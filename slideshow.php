<?php
/*
 * Template that displays a random picture from the media library, 
 * then automatically refreshes itself, creating a slideshow effect.
 * Please note that it is not possible to pause the slideshow or go back;
 * this template works best when you need to display pictures related to
 * your business/organization in the background at an event or in your office.
 *
 * Parameters are controlled via query string.
 *
 * `size` is the size of the image to load, either `thumbnail` (discouraged), `medium`, `large`, `full`, or `auto`, which uses medium or large depending on wp_is_mobile()
 * `year` is the 4-digit numeric year in which the images were published.
 * `month` is the numeric month in which the images were published (between 1 and 12).
 * `delay` is the length of time to display each image (it will be slightly longer in practice, while the next image is loaded).
 *
 * Using all custom options, for example:
 * http://example.com/slideshow?hidpi&year=2013&month=12&delay=1
 */

// Get options, via query string.

// Size of image to load.
$size = ( array_key_exists( 'size', $_GET ) ? $_GET['size'] : 'auto' );

// Year uploaded, in 4-digit numeric form.
$year = ( array_key_exists( 'year', $_GET ) ? absint( $_GET['year'] ) : false );

// Month uploaded, as an int between 1 and 12.
$month = ( array_key_exists( 'month', $_GET ) ? absint( $_GET['month'] ) : false );

// Delay (time each image is displayed).
$delay = ( array_key_exists( 'delay', $_GET ) ? absint( $_GET['delay'] ) : 3 );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php printf( __( 'Slideshow :: %s', 'content-slideshow' ), get_bloginfo( 'title' ) ); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<style type="text/css">
		* { box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; }
		img, figcaption { transition: .32s opacity ease-in-out; }
		html { background: #222; }
		body { margin: 0; padding: 0; overflow: hidden; color: #fff; font-family: sans-serif; }
		figure { width: 100%; height: 100%; margin: 0; padding: 0; text-align: center; vertical-align: middle; }
		img { width: auto; height: auto; margin: auto; opacity: .1; }
		img.portrait { height: 100%; }
		img.landscape { width: 100%; }
		figcaption { font-family: sans-serif; font-size: 28px; font-weight: normal; font-style: normal; position: absolute; bottom: 0; text-align: center; width: 100%; padding: 12px 15%; margin: 0; background: rgba(0,0,0,.5); color: #fff; text-shadow: 1px 1px 1px #000; }
		@-ms-viewport { width: device-width; }
		@viewport { width: device-width; }
		@media screen and (max-width: 1024px) { figcaption { font-size: 22px; } }
		@media screen and (max-width: 600px) { figcaption { font-size: 16px; } }
		@media screen and (max-width: 400px) { figcaption { font-size: 12px; } }
	</style>
	<meta http-equiv="refresh" content="<?php echo $delay; ?>">
<?php 
	/* 
	 * Action in the <head> of the Content Slideshow page template.
	 *
	 * wp_head() is NOT called on this page because it is independent of the rest of the site.
	 * However, this hook is provided so that custom styling or functionality can be applied.
	 */
	do_action( 'content_slideshow_head' ); 
?>
</head>
<body>
<figure>
<?php
	// get an image. searching only for image/jpeg: this should return pictures but not graphics, as long as files are uploaded in the appropriate format
	$query_image_args = array(
		'post_type' => 'attachment',
		'post_mime_type' =>'image/jpeg',
		'post_status' => 'inherit', // required for images, which are children of posts
		'posts_per_page' => 1,
		'max_num_pages' => 1,
		'orderby' => 'rand',
		// custom options
		'year' => $year,
		'monthnum' => $month,
	);

	$image = new WP_Query( $query_image_args );
	
	if ( ! $image->have_posts() ) {
		echo '<h1>' . __( 'Sorry, there are no images to display here.', 'content-slideshow' ) . '</h1></figure></body></html>';
		exit;
	}

	$id = $image->posts[0]->ID;

	// image
	$sizes = array( 'thumbnail', 'medium', 'large', 'full' );
	if( in_array( $size, $sizes ) ) {
		$img = wp_get_attachment_image_src( $id, $size );
	}
	// auto handling
	elseif( wp_is_mobile() ) {
		$img = wp_get_attachment_image_src( $id, 'medium' );
	}
	else {
		$img = wp_get_attachment_image_src( $id, 'large' );
	}

	$orientation = ( $img[1] > $img[2] ? 'landscape' : 'portrait' );

	echo '<a href="' . get_attachment_link($id) . '" target="_blank">';
	echo '<img src="' . $img[0] . '" class="' . $orientation . '" id="main" onload="load()">';
	echo '</a>';

	// caption
	if( $image->posts[0]->post_excerpt ) { // caption field
		echo '<figcaption>' . $image->posts[0]->post_excerpt . '</figcaption>';
	}
	elseif( $image->posts[0]->post_content ) { // description field
		echo '<figcaption>' . $image->posts[0]->post_content . '</figcaption>';
	}
	elseif($image->posts[0]->title) { // title field
		echo '<figcaption>' . $image->posts[0]->title . '</figcaption>';
	}
?>
</figure>
<script>
function load() {
	var img = document.getElementById('main');
	var width = window.innerWidth;
	var height = window.innerHeight;
	var ratio = img.naturalWidth / img.naturalHeight;
	if ( img.width > width ) {
		img.style.width = width + 'px';
		img.style.height = width / ratio + 'px';
	}
	else if( img.height > height ) {
		img.style.height = height + 'px';
		img.style.width = height * ratio + 'px';
	}
	img.style.opacity = '1';

/*	Would be cool to unfade the image before reloading,
	but currently better to leave image up during pageload.

	setTimeout( function() {
		img.style.opacity = '.01';
	}, 3200 );
*/
}
</script>
<?php 
	/* 
	 * Action just before </body> of the Content Slideshow page template.
	 *
	 * wp_footer() is NOT called on this page because it is independent of the rest of the site.
	 * However, this hook is provided so that custom markup or functionality can be applied.
	 */
	do_action( 'content_slideshow_footer' ); 
?>
</body>
</html>
=== Content Slideshow ===
Contributors: celloexpressions
Tags: Slideshow, Pictures, Media, Media Library, Automatic, Widget, Shortcode
Requires at least: 3.8
Tested up to: 3.8
Stable tag: 1.0
Description: Creates an automatic web-based slideshow that randomly cycles through all of your site's images. Includes a slideshow page, widget, and shortcode.
License: GPLv2

== Description ==
This plugin creates a fullscreen slideshow that displays randomly-selected pictures from your media library. Designed to display pictures related to your business/organization in the background at an event or in your office, there is no need to configure any settings or controls. Image captions/descriptions are automatically displayed as well.

Once activated, you can view the slideshow by visiting `http://yourdomain.com/slideshow`. All JPEG images will be displayed (since .jpg is best for pictures, while .png and .gif are typically used for graphics).

Please note that it is not possible to pause the slideshow or go back; the slideshow is not designed for personal viewing.

The slideshow can also be embedded into your site via a widget or a shortcode.

You can control some options by adjusting the url of the slideshow. Parameters are controlled via query string (and widget options and shortcode attributes).

* `size` is the size of the image to load, either `thumbnail` (discouraged), `medium`, `large`, `full`, or `auto`, which uses medium or large depending on `wp_is_mobile()`.
* `year` is the 4-digit numeric year in which the images were published.
* `month` is the numeric month in which the images were published (between 1 and 12), typically used in conjunction with `year`.
* `delay` is the length of time to display each image, in seconds (it will be slightly longer in practice, while the next image is loaded).

Using all options, for example:
http://example.com/slideshow?size=full&year=2014&month=1&delay=1

You can see it in action <a href="http://uscasce.com/slideshow">here</a>.

== Installation ==
1. Take the easy route and install through the WordPress plugin adder OR
1. Download the .zip file and upload the unzipped folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to `http://yourdomain.com/slideshow` to see the slideshow in action. Add a widget version from Appearance->Widgets or add the [content_slideshow] shortcode to a post or page.

== Frequently Asked Questions ==
= Where's the settings page? =
For simplicity's sake, no settings page is included. Settings for this plugin tend to depend on the exact situation in which you are using it, so rather than going to the setting page every time you want to use it, you can adjust the parameters via tweaks to the slideshow url (see details below).

= What happened to my page at /slideshow? =
This plugin overrides WordPress at the `slideshow/` url. If you have a post/page with that slug, it will no longer be accessible on the front-end. This may be desired; for example, you could create an empty slideshow page so that you have a record of the plugin's presence and can more easily add it to navigation menus. You don't have to have a page thee, though, and you can manually add the slideshow URL to you navigation menus.

= Loading higher quality images =
You can force the plugin to always show the highest resolution pictures available by using the `size` query argument (`http://example.com/slideshow?size=full`). Note that this could cause speed issues with loading the images if your internet connection or your web server is slow.

= Faster/slower slideshow =
You can adjust the speed of the slideshow with the `delay` query argument (`http://example.com/slideshow?delay=3`). The default is 3, which means that each image is shown for three seconds before the next one starts loading (expect at  lest 1 additional second for the next image to display, depending on the speed of your internet connection and your web server).

= Loading images from a specific time frame =
The plugin supports `year` and `month` parameters that can be used to only show images uploaded in a given time period (see the description for an example).

= Using the Shortcode =
The shortcode version supports all four parameters that the full URL version supports, as attributes:
`[content_slideshow size="medium" year="2014" month="1" delay="5"]`

== Screenshots ==
1. Full-screen mode.
2. Shortcode, in the Twenty Fourteen theme.
3. Widget, in the Twenty Fourteen theme.

== Changelog ==
= 1.0 =
* First publicly available version of the plugin.
* Tested with WordPress 3.8.

== Upgrade Notice ==
= 1.0 =
* Public release on WordPress.org.

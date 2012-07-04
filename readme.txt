=== Gallery Metabox ===
Contributors: billerickson
Tags: gallery, image, images, metabox
Requires at least: 3.0
Tested up to: 3.3
Stable tag: 1.3

Displays all the post's attached images on the Edit screen.

== Description ==

I use the WordPress Gallery a lot on websites I build. It's a wonderful tool, but it's hard to find. Instead of telling users "Click the first icon next to Upload/Insert, then click the gallery tab", I created this simple plugin to display all the attached images in a metabox. 

It's also customizable for developers (see other notes).

== Documentation ==

If you're a developer, there's a ton of filters in here to customize it specifically to your needs:

`be_gallery_metabox_post_types` 
An array of post types the metabox should be visible on. 
Default: array( 'post', 'page' )
Example: http://www.billerickson.net/code/gallery-metabox-custom-post-types/

`be_gallery_metabox_limit` 
Allows you to further refine your metabox by limiting it to specific pages or page templates
Default: true
Example: http://www.billerickson.net/code/limit-gallery-metabox-to-specific-page/

`be_gallery_metabox_context` 
Whether to display it in the main area or sidebar. 
Default: normal

`be_gallery_metabox_priority` 
Priority of metabox. 
Default: high

`be_gallery_metabox_args` 
Query args for image listing. Useful if you're [adding custom fields to media library](http://www.billerickson.net/wordpress-add-custom-fields-media-gallery/)
Example: http://www.billerickson.net/code/gallery-metabox-show-images-marked-include-in-rotator/

`be_gallery_metabox_intro` 
Text displayed above image listing. 
Default: Upload Image | Manage Gallery

`be_gallery_metabox_image_size` 
The image size displayed in the metabox. 
Default: thumbnail

`be_gallery_metabox_output`
The actual HTML to output for each image.

== Changelog ==

= 1.4 = 
* Fixed an issue of compatiblity with other plugins

= 1.3 =
* AJAX Refresh of metabox (thanks Zlatko Salbut)
* Add output filter
* Add image description as title

= 1.2 =
* Fix query reset issue (first fix didn't work)

= 1.1 = 
* Fix query reset issue 

= 1.0 =
* Release of plugin
* Added italian translation (thanks mad_max)


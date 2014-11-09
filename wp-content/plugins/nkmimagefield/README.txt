=== NKMImageField ===
Contributors: nmillman
Tags: images, meta
Requires at least: 2.7
Tested up to: 2.8.6
Stable tag: 0.6

NKMImageField provides an easy graphical interface for inserting image URLs from the Media gallery into custom fields.

**NOTE:** Version 0.4.1 fixes several bugs involving broken template tags and the (default) Flash uploader.

== Description == 

Have you ever needed to associate an image with each page or post?  Perhaps it's a headshot for a profile page, or a theme header image that changes on each page?  Well, you can add them with custom fields, but you have to copy and paste the image paths or URLs, which is clunky, and difficult for less-technical users.

NKMImageField provides an easy graphical interface for inserting image URLs from the Media gallery into custom fields.

NKMImageField does not currently interface with gallery or image management plugins such as NextGen-Gallery.

= Example uses: =
* Use a different header image in your theme for each page
* Assign a screenshot to each item ina graphic design portfolio
* Upload product views for each item in a store

== Installation ==

Unzip into plugins directory, and/or install via Wordpress admin interface.

== Instructions ==

The plugin installs a new administration screen under the Settings menu.  Use this screen to create, edit, and remove new fields.  There is no limit to the number of fields that may be created.

Please note that when a field is deleted, all values for that field for all posts are also deleted.

Data is not destroyed when the plugin is uninstalled.

Each field and its description are displayed under the content edit box on the Post and Page writing and editing screens.  To insert an image into a field, click the graphic beside the field, choose an image from the gallery (or upload a new one), and click the "insert into post" button.  The image's URL will appear in the text field.  Any changes will be saves when the page/post is saved.

== Upgrade Notice ==

= 0.4.1 =
This version fixes several bugs involving broken template tags and the (default) Flash uploader.

= 0.5 = 
This version adds the optional $post_id parameter to each template tag, to enable use outside the Loop.

= 0.6 =
Fixes issues with disappearing values related to autosave revisions and future-scheduled posts.

== Template Tags ==

Image URLs are stored in a separate table rather than alongside other post metadata (aka customfields).  The data can be retrieved in templates in one of three ways:

`get_nkm_imagefields([$post_id])` -- Returns an array containing all custom image field data for the current post.

`get_nkm_imagefield($fieldname [, $post_id])` -- Returns an array containing all data for the indicated field for the current post.

`get_nkm_imageurl($fieldname [, $post_id])` -- Returns a string containing the URL for the indicated field for the current post.

All three template tages also take an optional $post_id parameter indicating the post for which to retrieve the image field.  This parameter is optional within the Loop (where it will default to the current post) and mandatory outside the Loop.

== Compatibility ==

This plugin currently requires PHP 5 in order to run.  It will not install properly using PHP 4.

== Acknowledgements ==

Thank you to Hani AbuGhazaleh (http://www.mmbarn.com/) for his invaluable assistance in bug hunting and troubleshooting.
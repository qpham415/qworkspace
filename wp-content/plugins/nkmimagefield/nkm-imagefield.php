<?php

#
/*
Plugin Name: NKMImageField
Plugin URI: http://triopter.com/archive/announcing-nkmimagefield-a-custom-image-field-plugin-for-wordpress/
Version: 0.6
Author: Noemi Millman
Description: Enables the addition of custom fields that use the media gallery browser to insert image paths
*/

require_once (dirname (__FILE__).'/includes/NKMImageField.class.php');
require_once (dirname (__FILE__).'/includes/NKMImageFieldAdmin.class.php');

if(class_exists('NKMImageFieldAdmin')) {
	$nkm_controller = new NKMImageFieldAdmin;
}
else {
	die('not registered');
}
if(class_exists('NKMImageField')) {
	$nkm_field = new NKMImageField($nkm_controller);
}



if(isset($nkm_field)) {
	add_action('admin_menu', array(&$nkm_controller, 'add_admin_page'));
	add_action('submitpage_box', array(&$nkm_field, 'field_hook_page'));
	add_action('submitpost_box', array(&$nkm_field, 'field_hook_post'));
	add_action('media_upload_nkmimage', array(&$nkm_field, 'media_upload_nkmimage'));
	add_action('media_upload_nkmgallery', array(&$nkm_field, 'media_upload_nkmgallery'));
	add_action('media_upload_nkmlibrary', array(&$nkm_field, 'media_upload_nkmlibrary'));
	add_action('admin_head', array(&$nkm_field, 'nkm_field_js'));
	add_action('save_post', array(&$nkm_field, 'save_custom'));
	add_action('private_to_published', array(&$nkm_field, 'save_for_publication'));
}



?>
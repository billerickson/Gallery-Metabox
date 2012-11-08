<?php
/*
Plugin Name: Gallery Metabox
Plugin URI: http://wordpress.org/extend/plugins/gallery-metabox/
Description: Displays all the post's attached images on the Edit screen
Author: Bill Erickson
Version: 1.5
Author URI: http://www.billerickson.net
*/

if(is_admin())
	include "gallery-metabox-admin.php";

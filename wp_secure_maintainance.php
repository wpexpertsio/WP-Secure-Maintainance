<?php
/*
    Plugin Name: WP Secure Maintainance
	Plugin URI:	https://wpexperts.io/
    Description: Want to lock your site for Maintainance or Development? Then this is the right Plugin.
    Author: wpexpertsio
	Author URI: https://wpexperts.io/
    Version: 1.4
*/
  
/*if(!defined('Carbon_Fields\PLUGIN_FILE')){ // CHECK IF CARBON ALREADY EXIST OR NOT
	include 'inc/option_fields/carbon-fields-plugin.php';
}*/
if(!function_exists('carbon_fields_boot_plugin')){ // CHECK IF CARBON ALREADY EXIST OR NOT
    include 'inc/option_fields/carbon-fields-plugin.php';
}

require_once( 'inc/wpsp_options.php' );
 
require_once( 'inc/wpsp_functions.php' );
<?php 
/*
Plugin Name: Sample Library
Plugin URI: https://github.com/faham29/sample-library
Description: A plugin to add and view books
Version: 0.0.1
Author: Faham Shaikh
Author URI: https://www.luminate.ai/
Text Domain: samplib
Generated By: http://ensuredomains.com
*/

// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if

// Let's Initialize Everything
if ( file_exists( plugin_dir_path( __FILE__ ) . 'core-init.php' ) ) {
require_once( plugin_dir_path( __FILE__ ) . 'core-init.php' );
}
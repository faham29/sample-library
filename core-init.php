<?php 
/*
*
*	***** Sample Library *****
*
*	This file initializes all SAMPLIB Core components
*	
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if
// Define Our Constants
define('SAMPLIB_CORE_INC',dirname( __FILE__ ).'/assets/inc/');
define('SAMPLIB_CORE_IMG',plugins_url( 'assets/img/', __FILE__ ));
define('SAMPLIB_CORE_CSS',plugins_url( 'assets/css/', __FILE__ ));
define('SAMPLIB_CORE_JS',plugins_url( 'assets/js/', __FILE__ ));
/*
*
*  Register CSS
*
*/
function samplib_register_core_css(){
	wp_enqueue_style('samplib-jquery-ui', SAMPLIB_CORE_CSS . 'samplib-jquery-ui.css',null,time('s'),'all');
	wp_enqueue_style('samplib-core', SAMPLIB_CORE_CSS . 'samplib-core.css',null,time('s'),'all');
};
add_action( 'wp_enqueue_scripts', 'samplib_register_core_css' );
function samplib_register_core_admin_css(){
	wp_enqueue_style('samplib-core-admin', SAMPLIB_CORE_CSS . 'samplib-core-admin.css',null,time('s'),'all');
};
add_action( 'admin_enqueue_scripts', 'samplib_register_core_admin_css' );
/*
*
*  Register JS/Jquery Ready
*
*/
function samplib_register_core_js(){
	// Register Core Plugin JS	
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('samplib-core', SAMPLIB_CORE_JS . 'samplib-core.js',array('jquery', 'jquery-ui-slider'),time(),true);
};
add_action( 'wp_enqueue_scripts', 'samplib_register_core_js' );    
/*
*
*  Includes
*
*/ 
// Load the Functions
if ( file_exists( SAMPLIB_CORE_INC . 'samplib-core-functions.php' ) ) {
	require_once SAMPLIB_CORE_INC . 'samplib-core-functions.php';
}     
// Load the ajax Request
if ( file_exists( SAMPLIB_CORE_INC . 'samplib-ajax-request.php' ) ) {
	require_once SAMPLIB_CORE_INC . 'samplib-ajax-request.php';
} 
// Load the Shortcodes
if ( file_exists( SAMPLIB_CORE_INC . 'samplib-shortcodes.php' ) ) {
	require_once SAMPLIB_CORE_INC . 'samplib-shortcodes.php';
}
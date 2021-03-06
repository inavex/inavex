<?php

/**
 * Add theme features, define constants and load framework
 *
 * @package FrameShift
 * @version 1.0
 */

// frameshift_pre hook
do_action( 'frameshift_pre' );

/**
 * Define FrameShift theme constants
 *
 * @since 1.0
 */

add_action( 'frameshift_init', 'frameshift_constants' );
 
function frameshift_constants() {

	// General theme constants
	
	define( 'FRAMESHIFT_NAME', 'deCente' );
	define( 'FRAMESHIFT_DOMAIN', 'decente' );
	define( 'FRAMESHIFT_VERSION', '1.0.3' );
	define( 'FRAMESHIFT_DB', FRAMESHIFT_DOMAIN . '_1_0_3' );
	
	// Layout can be four or three columns

	define( 'FRAMESHIFT_LAYOUT', 'three' );
	
	// Location constants (paths)
	
	define( 'FRAMESHIFT_DIR', get_template_directory() );
	define( 'CHILD_DIR', get_stylesheet_directory() );
	
	define( 'FRAMESHIFT_LIB_DIR', FRAMESHIFT_DIR . '/lib' );
	define( 'FRAMESHIFT_ADMIN_DIR', FRAMESHIFT_LIB_DIR . '/admin' );
	define( 'FRAMESHIFT_FRAMEWORK_DIR', FRAMESHIFT_LIB_DIR . '/framework' );
	define( 'FRAMESHIFT_SHORTCODES_DIR', FRAMESHIFT_LIB_DIR . '/shortcodes' );
	define( 'FRAMESHIFT_CLASSES_DIR', FRAMESHIFT_LIB_DIR . '/classes' );
	define( 'FRAMESHIFT_FUNCTIONS_DIR', FRAMESHIFT_LIB_DIR . '/functions' );
	define( 'FRAMESHIFT_WIDGETS_DIR', FRAMESHIFT_LIB_DIR . '/widgets' );

	// Location constants (URLs)
	
	define( 'FRAMESHIFT_URL', get_template_directory_uri() );
	define( 'CHILD_URL', get_stylesheet_directory_uri() );
	
	define( 'FRAMESHIFT_LIB_URL', FRAMESHIFT_URL . '/lib' );
	define( 'FRAMESHIFT_ASSETS_URL', FRAMESHIFT_LIB_URL . '/assets' );
	define( 'FRAMESHIFT_ASSETS_IMG_URL', FRAMESHIFT_ASSETS_URL . '/img' );
	define( 'FRAMESHIFT_ASSETS_JS_URL', FRAMESHIFT_ASSETS_URL . '/js' );
	define( 'FRAMESHIFT_ASSETS_CSS_URL', FRAMESHIFT_ASSETS_URL . '/css' );
	define( 'FRAMESHIFT_JS_URL', FRAMESHIFT_LIB_URL . '/js' );
	define( 'FRAMESHIFT_ADMIN_URL', FRAMESHIFT_LIB_URL . '/admin' );
	define( 'FRAMESHIFT_ADMIN_IMAGES_URL', FRAMESHIFT_ADMIN_URL . '/img' );
	
	define( 'FRAMESHIFT_IMAGES', FRAMESHIFT_URL . '/images' );
	define( 'FRAMESHIFT_ICONS', FRAMESHIFT_IMAGES . '/icons' );

}

/**
 * Load all the framework files and features
 *
 * @since 1.0
 */
 
add_action( 'frameshift_init', 'frameshift_load_framework' );

function frameshift_load_framework() {

	// frameshift_pre_framework hook
	do_action( 'frameshift_pre_framework' );
	
	// Load theme and post options
	
	require_once( FRAMESHIFT_ADMIN_DIR . '/options-framework.php' );
	require_once( FRAMESHIFT_ADMIN_DIR . '/post-options.php' );
	
	// Load theme update class
	
	require_once( FRAMESHIFT_ADMIN_DIR . '/theme-updates.php' );
	
	// Load general functions
	
	require_once( FRAMESHIFT_FUNCTIONS_DIR . '/general.php' );
	require_once( FRAMESHIFT_FUNCTIONS_DIR . '/menus.php' );
	require_once( FRAMESHIFT_FUNCTIONS_DIR . '/helpers.php' );

	// Load framework
	
	require_once( FRAMESHIFT_FRAMEWORK_DIR . '/header.php' );
	require_once( FRAMESHIFT_FRAMEWORK_DIR . '/main.php' );
	require_once( FRAMESHIFT_FRAMEWORK_DIR . '/post.php' );
	require_once( FRAMESHIFT_FRAMEWORK_DIR . '/comments.php' );
	require_once( FRAMESHIFT_FRAMEWORK_DIR . '/footer.php' );
	
	// Load shortcodes

	require_once( FRAMESHIFT_SHORTCODES_DIR . '/general.php' );
	require_once( FRAMESHIFT_SHORTCODES_DIR . '/post.php' );
	require_once( FRAMESHIFT_SHORTCODES_DIR . '/footer.php' );
	
	// Load widgets
	
	require_once( FRAMESHIFT_WIDGETS_DIR . '/widgets.php' );
	
	// Load custom post type portfolio
	
/*	require_once( FRAMESHIFT_FUNCTIONS_DIR . '/portfolio.php' );
	require_once( FRAMESHIFT_FRAMEWORK_DIR . '/portfolio.php' );*/
	
}

// frameshift_init hook
do_action( 'frameshift_init' );

// frameshift_setup hook
do_action( 'frameshift_setup' );

/**
 * Set content width for embeds
 *
 * @since 1.0
 */

if ( ! isset( $content_width ) ) 
    $content_width = apply_filters( 'frameshift_content_width', 640 );

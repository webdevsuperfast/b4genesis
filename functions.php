<?php
/**
 * Functions
 *
 * @package      B4Genesis
 * @since        1.0
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

add_action( 'genesis_setup', 'b4g_childtheme_setup', 15 );

function b4g_childtheme_setup() {
	// Start the engine
	include_once( get_template_directory() . '/lib/init.php' );

	// Child theme (do not remove)
	define( 'B4G_THEME_NAME', 'B4Genesis' );
	define( 'B4G_THEME_URL', 'http://rotsenacob.com/' );
	define( 'B4G_THEME_LIB', CHILD_DIR . '/lib/' );
	define( 'B4G_THEME_LIB_URL', CHILD_URL . '/lib/' );
	define( 'B4G_THEME_IMAGES', CHILD_URL . '/images/' );
	define( 'B4G_THEME_JS', CHILD_URL . '/assets/js/' );
	define( 'B4G_THEME_CSS', CHILD_URL . '/assets/css/' );
	define( 'B4G_THEME_MODULES', CHILD_DIR . '/lib/modules/' );

	// Cleanup WP Head
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'start_post_rel_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );

	// Add HTML5 markup structure
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	//* Unregister secondary navigation menu
	add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

	// Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	// Add support for 3-column footer widgets
	add_theme_support( 'genesis-footer-widgets', 3 );

	// Structural Wraps
	add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'site-inner',
		'footer-widgets',
		'footer',
		'home-featured',
		'nav'
	) );

	// WooCommerce Support
	add_theme_support( 'genesis-connect-woocommerce' );

	// Remove unneeded widget areas
	unregister_sidebar( 'header-right' );

	// Move Sidebar Secondary After Content
	remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
	add_action( 'genesis_after_content', 'genesis_get_sidebar_alt' );

	// Remove Gallery CSS
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Add Shortcode Functionality to Text Widgets
	add_filter( 'widget_text', 'shortcode_unautop' );
	add_filter( 'widget_text', 'do_shortcode' );

	// Move Featured Image
	remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
	add_action( 'genesis_entry_header',  'genesis_do_post_image', 0 );

	// Custom Image Size
	add_image_size( 'b4genesis-featured', 750, 422, true );

	// Add Accessibility support
	add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

	// Include php files from lib folder
	// @link https://gist.github.com/theandystratton/5924570
	foreach ( glob( dirname( __FILE__ ) . '/lib/*.php' ) as $file ) {
		include $file;
	}
}

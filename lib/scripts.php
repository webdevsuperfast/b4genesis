<?php
/**
 * Scripts
 *
 * @package      B4Genesis
 * @since        0.0.1
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

add_action( 'wp_enqueue_scripts', 'b4g_enqueue_scripts' );
function b4g_enqueue_scripts() {
    $version = wp_get_theme()->Version;
	if ( !is_admin() ) {
		wp_enqueue_style( 'app-css', B4G_THEME_CSS . 'app.css' );

		// Disable the superfish script
		wp_deregister_script( 'superfish' );
		wp_deregister_script( 'superfish-args' );

		// Popper JS
		wp_register_script( 'app-popper-js', B4G_THEME_JS . 'popper.min.js', array( 'jquery' ), $version, true );
		wp_enqueue_script( 'app-popper-js' );

		// Bootstrap JS
		wp_register_script( 'app-bootstrap-js', B4G_THEME_JS . 'bootstrap.min.js', array( 'jquery' ), $version, true );
		wp_enqueue_script( 'app-bootstrap-js' );

		// Smart Menus
		wp_register_script( 'app-smartmenus-js', B4G_THEME_JS . 'jquery.smartmenus.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'app-smartmenus-bootstrap-js', B4G_THEME_JS . 'jquery.smartmenus.bootstrap-4.min.js', array( 'app-smartmenus-js' ), $version, true );

		wp_enqueue_script( 'app-smartmenus-js' );
		wp_enqueue_script( 'app-smartmenus-bootstrap-js' );

		// Theme JS
		wp_register_script( 'app-js', B4G_THEME_JS . 'app.min.js', array( 'jquery' ), $version, true );
		wp_enqueue_script( 'app-js' );
	}
}

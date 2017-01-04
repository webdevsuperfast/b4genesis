<?php
/**
 * Home Page
 *
 * @package 	B4Genesis
 * @since 		1.0
 * @author 		RecommendWP <http://www.recommendwp.com>
 * @copyright 	Copyright (c) 2017, RecommendWP
 * @license 	http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

add_action( 'get_header', 'b4g_homepage_settings' );
function b4g_homepage_settings() {
    if ( is_active_sidebar( 'home-featured' ) ) {
        add_action( 'genesis_after_header', 'b4g_do_home_featured' );
    }
}

function b4g_do_home_featured() {
	genesis_markup( array(
		'html5' => '<div %s>',
		'xhtml' => '<div class="home-featured">',
		'context' => 'home-featured'
	) );

	genesis_structural_wrap( 'home-featured' );

	genesis_widget_area( 'home-featured', array(
		'before' => '',
		'after' => ''
	) );

	genesis_structural_wrap( 'home-featured', 'close' );

	echo '</div>';
}

genesis();
<?php
/**
 * Navigation
 *
 * @package      B4Genesis
 * @since        0.0.1
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

//* Reposition navigation before site-container
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before', 'genesis_do_nav' );

add_filter( 'wp_nav_menu_args', 'b4g_menu_args_filter', 10, 2 );
function b4g_menu_args_filter( $args ) {
    require_once ( B4G_THEME_MODULES . 'class-wp-bootstrap-navwalker.php' );

    if ( 'primary' === $args['theme_location'] ) {
        $args['container'] = false;
        // $args['container_class'] = 'collapse navbar-collapse';
        $args['menu_class'] = 'navbar-nav mr-auto';
        $args['fallback_cb'] = 'WP_Bootstrap_Navwalker::fallback';
        // $args['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s</ul>';
        $args['depth'] = 2;
        $args['walker'] = new WP_Bootstrap_Navwalker();
    }

    return $args;
}

// add_filter( 'genesis_do_nav', 'override_do_nav', 10, 3 );
function override_do_nav($nav_output, $nav, $args) {
    require_once( B4G_THEME_MODULES . 'class-wp-bootstrap-navwalker.php' );

    $args['container'] = false;
    // $args['container_class'] = 'collapse navbar-collapse';
    $args['menu_class'] = 'navbar-nav mr-auto';
    $args['fallback_cb'] = 'WP_Bootstrap_Navwalker::fallback';
    // $args['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s</ul>';
    $args['depth'] = 2;
    $args['walker'] = new WP_Bootstrap_Navwalker();

    // check which function should be used to build the nav
    // rebuild the nav using the updated arguments
    if(array_key_exists('type', $args))
        $nav = wp_nav_menu( $args );
    else
        $nav = genesis_nav( $args );

    // return the modified result
    return sprintf( '%2$s%1$s%3$s', $nav, genesis_structural_wrap( 'nav', 'open', 0 ), genesis_structural_wrap( 'nav', 'close', 0 ) );

}

add_filter( 'wp_nav_menu', 'b4g_nav_markup_filter', 10, 2 );
function b4g_nav_markup_filter( $html, $args ) {
    if ( 'primary' !== $args->theme_location ) {
        return $html;
    }

    $data_target = 'nav' . sanitize_html_class( '-' . $args->theme_location );
    
    $output = '';

    if ( 'primary' === $args->theme_location ) {
        $output .= apply_filters( 'b4g_navbar_brand', b4g_navbar_brand_markup() );
    }

    $output .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#'.$data_target.'" aria-controls="'.$data_target.'" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
    $output .= '<div class="collapse navbar-collapse" id="'.$data_target.'">';
    $output .= $html;
    $output .= apply_filters( 'b4g_navbar_content', b4g_navbar_content_markup() );
    $output .= '</div>';

    return $output;
}

function b4g_navbar_brand_markup() {
    $output = '<a class="navbar-brand" title="'.esc_attr( get_bloginfo( 'description' ) ).'" href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo( 'name' ).'</a>';

    return $output;
}

function b4g_navbar_content_markup() {
    $url = get_home_url();

    $output = <<<EOT
        <form class="form-inline float-lg-right" method="get" action="#{$url}" role="search">
            <input class="form-control" type="text" placeholder="Search" name="s">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
EOT;
    return $output;
}

add_filter( 'nav_menu_link_attributes', function( $atts ) {
    $class = $atts['class'];
    $classes = array();
    $classes[] = $class;
    $classes[] = 'nav-link';

    $atts['class'] = esc_attr( implode( ' ', $classes ) );
    return $atts;
}, 10 );
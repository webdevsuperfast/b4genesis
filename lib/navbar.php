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
    require_once ( B4G_THEME_MODULES . 'navwalker.php' );

    if ( 'primary' === $args['theme_location'] ) {
        $args['container'] = false;
        $args['menu_class'] = 'nav navbar-nav';
        $args['fallback_cb'] = '__return_false';
        $args['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s</ul>';
        $args['depth'] = 2;
        $args['walker'] = new b4st_walker_nav_menu();
    }

    return $args;
}

add_filter( 'wp_nav_menu', 'b4g_nav_markup_filter', 10, 2 );
function b4g_nav_markup_filter( $html, $args ) {
    if ( 'primary' !== $args->theme_location ) {
        return $html;
    }

    $data_target = 'nav' . sanitize_html_class( '-' . $args->theme_location );

    $output = '<button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#'.$data_target.'" aria-controls="'.$data_target.'" aria-expanded="false" aria-label="Toggle navigation"></button>';
    $output .= '<div class="collapse navbar-toggleable-md" id="'.$data_target.'">';
    if ( 'primary' === $args->theme_location ) {
        $output .= apply_filters( 'b4g_navbar_brand', b4g_navbar_brand_markup() );
    }
    $output .= $html;
    $output .= apply_filters( 'b4g_navbar_content', b4g_navbar_content_markup() );
    $output .= '</div>';

    return $output;
}

function b4g_navbar_brand_markup() {
    $output = '<a class="navbar-brand hidden-lg-up" id="logo" title="'.esc_attr( get_bloginfo( 'description' ) ).'" href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo( 'name' ).'</a>';

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

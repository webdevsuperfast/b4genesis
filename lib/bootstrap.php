<?php
/**
 * Bootstrap
 *
 * @package      B4Genesis
 * @since        0.0.1
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

// Add row class after wrap
add_filter( 'genesis_structural_wrap-footer-widgets', 'b4g_filter_structural_wrap', 10, 2 );
function b4g_filter_structural_wrap( $output, $original_output ) {
    if( 'close' == $original_output ) {
        $output = '</div>' . $output;
    }

    if ( 'open' == $original_output )  {
    	$output = $output . '<div class="row">';
    }
    return $output;
}

// Adds Filters Automatically from Array Keys
// @link https://gist.github.com/bryanwillis/0f22c3ddb0d0b9453ad0
add_action( 'genesis_meta', 'b4g_add_array_filters_genesis_attr' );
function b4g_add_array_filters_genesis_attr() {
    $filters = b4g_merge_genesis_attr_classes();
    
    foreach( array_keys( $filters ) as $context ) {
        $context = "genesis_attr_$context";
        add_filter( $context, 'b4g_add_markup_sanitize_classes', 10, 2 );
    }
}

// Clean classes output
function b4g_add_markup_sanitize_classes( $attr, $context ) {
    $classes = array();
    
    if ( has_filter( 'b4g_clean_classes_output' ) ) {
        $classes = apply_filters( 'b4g_clean_classes_output', $classes, $context, $attr );
    }
    
    $value = isset( $classes[$context] ) ? $classes[$context] : array();
    
    if ( is_array( $value ) ) {
        $classes_array = $value;
    } else {
        $classes_array = explode( ' ', ( string )$value );
    }

    $classes_array = array_map( 'sanitize_html_class', $classes_array );
    $attr['class'].= ' ' . implode( ' ', $classes_array );
    return $attr;
}

// Default array of classes to add
function b4g_merge_genesis_attr_classes() {
    // $navclass = get_theme_mod( 'navtype', 'navbar-static-top' );
    $classes = array(
            'content-sidebar-wrap'      => 'row',
            'content'                   => 'col-sm-8',
            'sidebar-primary'           => 'col-sm-4',
            'sidebar-secondary'         => 'col-sm-2',
            // 'archive-pagination'        => ( 'numeric' == genesis_get_option( 'posts_nav' ) ) ? 'clearfix bfg-pagination-numeric' : 'clearfix bfg-pagination-prev-next',
            'entry-content'             => 'clearfix',
            'entry-pagination'          => 'clearfix bfg-pagination-numeric',
            'structural-wrap'           => 'container',
            'footer-widget-area'        => 'col-sm-6',
            'comment-list'              => 'list-unstyled',
            'ping-list'                 => 'list-unstyled',
            'home-featured'             => 'jumbotron',
            'nav-primary'               => 'navbar navbar-light bg-faded',
            'entry-image'               => 'img-fluid',
            'site-footer'               => 'bg-faded text-muted',
            'footer-widgets'            => 'bg-faded text-muted'
    );
    
    if ( has_filter( 'b4g_add_classes' ) ) {
        $classes = apply_filters( 'b4g_add_classes', $classes );
    }

    return $classes;
}

// Adds classes array to b4g_add_markup_class() for cleaning
add_filter( 'b4g_clean_classes_output', 'b4g_modify_classes_based_on_extras', 10, 3) ;
function b4g_modify_classes_based_on_extras( $classes, $context, $attr ) {
    $classes = b4g_merge_genesis_attr_classes( $classes );
    return $classes;
}

// Layout
// Modify bootstrap classes based on genesis_site_layout
add_filter('b4g_add_classes', 'b4g_modify_classes_based_on_template', 10, 3);

// Remove unused layouts
function b4g_layout_options_modify_classes_to_add( $classes_to_add ) {

    $layout = genesis_site_layout();
    
    if ( 'full-width-content' === $layout ) {
        $classes_to_add['content'] = 'col-sm-12';
    }

    // sidebar-content          // supported
    if ( 'sidebar-content' === $layout ) {
        $classes_to_add['content'] = 'col-sm-8 flex-sm-last';
        $classes_to_add['sidebar-primary'] = 'col-sm-4 flex-sm-first';
    }

    // content-sidebar-sidebar  // supported
    if ( 'content-sidebar-sidebar' === $layout ) {
        $classes_to_add['content'] = 'col-sm-6 flex-sm-first';
        $classes_to_add['sidebar-primary'] = 'col-sm-4';
        $classes_to_add['sidebar-secondary'] = 'col-sm-2 flex-sm-last';
    }


    // sidebar-sidebar-content  // supported
    if ( 'sidebar-sidebar-content' === $layout ) {
        $classes_to_add['content'] = 'col-sm-6 flex-sm-last';
        $classes_to_add['sidebar-primary'] = 'col-sm-4';
        $classes_to_add['sidebar-secondary'] = 'col-sm-2 flex-sm-first';
    }


    // sidebar-content-sidebar  // supported
    if ( 'sidebar-content-sidebar' === $layout ) {
        $classes_to_add['content'] = 'col-sm-6';
        $classes_to_add['sidebar-primary'] = 'col-sm-4 flex-sm-last';
        $classes_to_add['sidebar-secondary'] = 'col-sm-2 flex-sm-first';
    }

    return $classes_to_add;
};

function b4g_modify_classes_based_on_template( $classes_to_add ) {
    $classes_to_add = b4g_layout_options_modify_classes_to_add( $classes_to_add );

    return $classes_to_add;
}

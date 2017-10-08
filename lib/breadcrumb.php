<?php
/**
 * Breadcrumb
 *
 * @package      B4Genesis
 * @since        1.0
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

// Changing breadcrumbs to Bootstrap's format
// @link http://jhtechservices.com/2015/05/integrate-bootstraps-breadcrumbs-into-genesis-theme/
add_filter( 'genesis_breadcrumb_args', 'b4g_breadcrumb_args' );
function b4g_breadcrumb_args( $args ){
	$args['sep'] = '     ';
	$args['prefix'] = sprintf( '<ol %s>', genesis_attr( 'breadcrumb' ) );
    $args['suffix'] = '</ol>';
    $args['labels']['prefix'] = '';
	$args['labels']['author'] = '';
	$args['labels']['category'] = ''; // Genesis 1.6 and later
	$args['labels']['tag'] = '';
	$args['labels']['date'] = '';
	$args['labels']['search'] = '';
	$args['labels']['tax'] = '';
	$args['labels']['post_type'] = '';
	$args['labels']['404'] = ''; // Genesis 1.5 and later
	return $args;
}

add_filter( 'genesis_build_crumbs', 'b4g_build_crumbs', 10, 2 );
function b4g_build_crumbs( $crumbs ){

	foreach( $crumbs as &$crumb ){
		$crumb = str_replace( '     ','</li><li class="breadcrumb-item active">', $crumb );
		$class = strpos( $crumb, '</a>' ) ? 'class="breadcrumb-item"' : 'class="breadcrumb-item active"';
		$crumb = '<li ' . $class .'>' . $crumb . '</li>';
	}

	return $crumbs;
}

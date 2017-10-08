<?php
/**
 * Search Form
 *
 * @package      B4Genesis
 * @since        1.0
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

add_filter( 'get_search_form', 'b4g_search_form' );
function b4g_search_form( $form ) {
    $form = '<form class="form-inline" role="search" method="get" id="searchform" action="' . home_url('/') . '" >
	<input class="form-control" type="text" value="' . get_search_query() . '" placeholder="' . esc_attr__('Search', 'b4st') . '..." name="s" id="s" />
	<button type="submit" id="searchsubmit" value="'. esc_attr__('Search', 'b4genesis') .'" class="btn btn-primary"><i class="fa fa-search"></i></button>
    </form>';
    return $form;
}

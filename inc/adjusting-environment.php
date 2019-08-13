<?php
/**
 * Adjusting Environment
 */
// add_action( 'admin_footer', 'show_pagenow_label', 11 );
function show_pagenow_label() {
	global $pagenow;
	echo '<h4 style="text-align:center;">$pagenow = ' . $pagenow . '</h4>';
	// echo '<h4 style="text-align:center;">' . preg_replace( '/_+/', '-', __FUNCTION__ ) . '</h4>';
	// echo '<h3 style="text-align:center;color:salmon;">' . __FUNCTION__ . ' | ' . basename( __FILE__ ) . ' | ' . __LINE__ . '</h3>';
	$screen = get_current_screen();
	echo '<h3 style="margin:1rem 1rem 1rem 11rem;text-align:center;color:salmon;"><pre>' . print_r( $screen, true ) . '</pre></h3>';
}
/**
 * Displays the Post older then current date
 *
 * @uses posts_where filer for data range
 * @uses pre_get_posts hook
 */
function textdomain_older_posts( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		$query->set( 'order', 'ASC' );
		add_filter( 'posts_where', 'textdomain_date_range' );
	}
	return $query;
}
// add_action( 'pre_get_posts', 'textdomain_older_posts' );
// add_action( 'admin_menu', 'sandusky_change_reveal_slides_cat_label' );
add_action( 'init', 'change_reveal_slides_cat_label', 11 );
/**
 * Let's rename the native taxonomy Categories to Presentations.
 * This function takes care of the Taxonomy labels.
 *
 * [change_reveal_slides_cat_label]
 *
 * @return [type] [description]
 */
function change_reveal_slides_cat_label() {
	// ( ! ) Warning: in_array() expects parameter 2 to be array, null given in /app/public/wp-includes/taxonomy.php on line 619
	   global $wp_taxonomies;
	$section = $wp_taxonomies['reveal_slides_cat'];
	// $section->meta_box_cb = 'wp_dropdown_categories';
	$labels                     = &$wp_taxonomies['reveal_slides_cat']->labels;
	$labels->name               = 'Presentation';
	$labels->singular_name      = 'Presentation';
	$labels->add_new            = 'Add Presentation';
	$labels->add_new_item       = 'Add Presentation';
	$labels->edit_item          = 'Edit Presentation';
	$labels->parent_item        = 'Parent Presentation';
	$labels->parent_item_colon  = 'Parent Presentation:';
	$labels->new_item           = 'Presentation';
	$labels->view_item          = 'View Presentation';
	$labels->search_items       = 'Search Presentations';
	$labels->not_found          = 'No Presentations found';
	$labels->not_found_in_trash = 'No Presentations found in Trash';
	$labels->all_items          = 'All Presentations';
	$labels->menu_name          = 'Presentation';
	$labels->name_admin_bar     = 'Presentation';
}

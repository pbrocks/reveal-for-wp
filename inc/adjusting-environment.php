<?php
/**
 * Adjusting Environment
 */


// add_action( 'admin_menu', 'sandusky_change_category_label' );
add_action( 'init', 'sandusky_change_cat_object' );
/**
 * Let's rename the native taxonomy Categories to Presentations.
 * This function takes care of the Taxonomy labels.
 *
 * [sandusky_change_category_label]
 *
 * @return [type] [description]
 */
function sandusky_change_cat_object() {
	   global $wp_taxonomies;
	$section = $wp_taxonomies['category'];
	// $section->meta_box_cb = 'wp_dropdown_categories';
	$labels                     = &$wp_taxonomies['category']->labels;
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

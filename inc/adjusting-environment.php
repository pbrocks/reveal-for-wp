<?php

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

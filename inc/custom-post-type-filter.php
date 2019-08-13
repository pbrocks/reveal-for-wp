<?php

// add_action( 'pre_get_posts', 'search_filter' );
/**
 *  [search_filter description]
 */
function search_filter( $query ) {
	// if ( ! is_admin() && $query->is_main_query() ) {
	if ( $query->is_main_query() ) {
		if ( $query->is_search ) {
			$query->set( 'post_type', array( 'reveal_slides' ) );
		}
	}
}


/**
 * Display a custom taxonomy dropdown in admin
 *
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_action( 'restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy' );
function tsm_filter_post_type_by_taxonomy() {
	global $typenow;
	$post_type = 'reveal_slides'; // change to your post type
	$taxonomy  = 'reveal_slides_cat'; // change to your taxonomy
	if ( $typenow == $post_type ) {
		$selected      = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
		$info_taxonomy = get_taxonomy( $taxonomy );
		wp_dropdown_categories(
			array(
				'show_option_all' => sprintf( __( 'Show all %s', 'textdomain' ), $info_taxonomy->label ),
				'taxonomy'        => $taxonomy,
				'name'            => $taxonomy,
				'orderby'         => 'name',
				'selected'        => $selected,
				'show_count'      => true,
				'hide_empty'      => true,
			)
		);
	};
}
/**
 * Filter posts by taxonomy in admin
 *
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter( 'parse_query', 'tsm_convert_id_to_term_in_query' );
function tsm_convert_id_to_term_in_query( $query ) {
	global $pagenow;
	$post_type = 'reveal_slides'; // change to your post type
	$taxonomy  = 'reveal_slides_cat'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type && isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && $q_vars[ $taxonomy ] != 0 ) {
		$term = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
		$q_vars[ $taxonomy ] = $term->slug;
	}
}
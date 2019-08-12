<?php
/*
Plugin Name: Admin Filter BY Custom Fields
Plugin URI: http://en.bainternet.info
Description: answer to http://wordpress.stackexchange.com/q/45436/2487
Version: 1.0
Author: Bainternet
Author URI: http://en.bainternet.info
*/
function rrveal_slides__posts() {
	$args = array(
		'post_type' => 'reveal_slides',
		'nopaging'     => true,
		'order'        => 'ASC',
		'orderby'      => 'menu_order',
		'tax_query' => array(
			array(
				'taxonomy' => 'reveal_slides_cat',
				'field'    => 'term_id',
				'terms'    => array( 4 ),
				// 'operator' => 'AND',
			),
		),
	);

	$query = new WP_Query( $args );
	return $query;
}
// add_action( 'restrict_manage_posts', 'wpse45436_admin_posts_filter_restrict_manage_posts' );
/**
 * First create the dropdown
 * make sure to change POST_TYPE to the name of your custom post type
 *
 * @author Ohad Raz
 *
 * @return void
 */
function wpse45436_admin_posts_filter_restrict_manage_posts() {
	$type = 'post';
	if ( isset( $_GET['post_type'] ) ) {
		$type = $_GET['post_type'];
	}

	// only add filter to post type you want
	if ( 'reveal_slides' == $type ) {
		// change this to the list of values you want to show
		// in 'label' => 'value' format
		$values = array(
			'label' => 'value',
			'label1' => 'value1',
			'label2' => 'value2',
		);
		?>
		<select name="ADMIN_FILTER_FIELD_VALUE">
		<option value=""><?php _e( 'Filter By ', 'wose45436' ); ?></option>
		<?php
			$current_v = isset( $_GET['ADMIN_FILTER_FIELD_VALUE'] ) ? $_GET['ADMIN_FILTER_FIELD_VALUE'] : '';
		foreach ( $values as $label => $value ) {
			printf(
				'<option value="%s"%s>%s</option>',
				$value,
				$value == $current_v ? ' selected="selected"' : '',
				$label
			);
		}
		?>
		</select>
		<?php
	}
}


// add_filter( 'parse_query', 'wpse45436_posts_filter' );
/**
 * if submitted filter by post meta
 *
 * make sure to change META_KEY to the actual meta key
 * and POST_TYPE to the name of your custom post type
 *
 * @author Ohad Raz
 * @param  (wp_query object) $query
 *
 * @return Void
 */
function wpse45436_posts_filter( $query ) {
	global $pagenow;
	$type = 'post';
	if ( isset( $_GET['post_type'] ) ) {
		$type = $_GET['post_type'];
	}
	if ( 'reveal_slides' == $type && is_admin() && $pagenow == 'edit.php' && isset( $_GET['ADMIN_FILTER_FIELD_VALUE'] ) && $_GET['ADMIN_FILTER_FIELD_VALUE'] != '' ) {
		$query->query_vars['meta_key'] = 'META_KEY';
		$query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
	}
}

add_filter( 'manage_reveal_slides_posts_columns', 'reveal_slides_columns_head' );
add_action( 'manage_reveal_slides_posts_custom_column', 'reveal_slides_columns_content', 10, 2 );
add_filter( 'manage_edit-reveal_slides_sortable_columns', 'slug_title_not_sortable' );
// ADD TWO NEW COLUMNS
function reveal_slides_columns_head( $defaults ) {
	$defaults['first_column']  = 'First Column';
	$defaults['second_column'] = 'Second Column';
	return $defaults;
}
function reveal_slides_columns_content( $column_name, $post_ID ) {
	if ( $column_name == 'first_column' ) {
		// $post_featured_image = reveal_slides_get_featured_image( $post_ID );
		// if ( $post_featured_image ) {
			// HAS A FEATURED IMAGE
		// echo '<img src="' . $post_featured_image . '" />';
		// } else {
			// NO FEATURED IMAGE, SHOW THE DEFAULT ONE
			echo '<img src="https://picsum.photos/50?random=' . $post_ID . '" />';
		// }
	}
	if ( $column_name == 'second_column' ) {
		echo 'Second column';
	}
}

function slug_title_not_sortable( $cols ) {
	$cols['first_column']  = 'First Column';
	return $cols;
}

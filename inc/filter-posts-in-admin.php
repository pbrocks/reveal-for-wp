<?php

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

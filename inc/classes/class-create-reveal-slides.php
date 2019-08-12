<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class Create_Reveal_Slides {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'create_reveal_js_slide' ) );
		add_action( 'init', array( __CLASS__, 'register_slidecat_taxonomy' ) );
		add_action( 'manage_posts_extra_tablenav', array( __CLASS__, 'reveal_extra_tablenav' ) );
		add_filter( 'plugin_action_links_reveal-with-wordpress/reveal-with-wordpress.php', array( __CLASS__, 'plugin_action_links' ) );
		add_filter( 'query_vars', array( __CLASS__, 'custom_query_vars_filter' ) );
		// add_action( 'init', array( __CLASS__, 'add_slide_statuses' ), 0 );
		add_action( 'manage_reveal_slides_posts_custom_column', array( __CLASS__, 'custom_reveal_slides_column' ), 10, 2 );
		add_filter( 'manage_edit_reveal_slides_sortable_columns', array( __CLASS__, 'make_reveal_slides_sortable_column' ) );
		add_filter( 'manage_reveal_slides_posts_columns', array( __CLASS__, 'set_custom_edit_reveal_slides_columns' ) );
		add_action( 'admin_head', array( __CLASS__, 'add_admin_css' ) );
	}

	public static function make_reveal_slides_sortable_column( $columns ) {
		$columns['slide_order'] = 'slide_order';

		// To make a column 'un-sortable' remove it from the array
		unset( $columns['date'] );
		return $columns;
	}
	public static function reveal_extra_tablenav( $which ) {
		$screen = get_current_screen();
		$customize_link = admin_url( 'customize.php?url=' . get_permalink( get_option( 'reveal_on_page' ) ) );
		$present_link = get_permalink( get_option( 'reveal_on_page' ) );
		$edit_link = get_edit_post_link( get_option( 'reveal_on_page' ) );
		if ( 'reveal_slides' != $screen->post_type ) {
			return;
		}
		if ( $which == 'top' ) {
			echo '<a href="' . $edit_link . '"><input type="button" class="button button-primary" value="Edit Cover" /></a> ';
			echo '<a href="' . $customize_link . '"><input type="button" class="button button-primary" value="Customize Slides" /></a> ';
			echo ' <a href="' . $present_link . '"><input type="button" class="button button-primary" value="Present Slides" /></a>';
		}
		if ( $which == 'bottom' ) {
		}
	}

	public static function set_custom_edit_reveal_slides_columns( $columns ) {
		$columns['menu_order'] = __( 'SlideOrder', 'reveal-with-wp' );
		$columns['post_id'] = __( 'Slide ID', 'reveal-with-wp' );
		$columns['reorder'] = __( 'Reorder Slides', 'reveal-with-wp' );
		return $columns;
	}

	public static function custom_reveal_slides_column( $column, $post_id ) {
		switch ( $column ) {

			case 'menu_order':
				$post_object = get_post( $post_id );
				echo $post_object->menu_order;
				break;

			case 'post_id':
				echo $post_id;
				break;

			case 'reorder':
				echo '<span class="dashicons dashicons-move"></span>';
				break;
		}
	}

	public static function renaming_cpt_menu_function() {
		$renaming_menu = apply_filters( 'renaming_cpt_menu_filter', 'Reveal Slides' );
		return $renaming_menu;
	}

	public static function add_slide_statuses() {

		$args = array(
			'label'                     => _x( 'Presented', 'Status General Name', 'reveal-with-wp' ),
			'label_count'               => _n_noop( 'Presented (%s)', 'Presented (%s)', 'reveal-with-wp' ),
			'public'                    => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'exclude_from_search'       => true,
		);
		register_post_status( 'presented', $args );

	}


	public static function register_slidecat_taxonomy() {
		// $tax_labels = self::get_tax_label_defaults();
		$tax_labels['name']     = _x( 'SlideCats', 'Taxonomy General Name', 'reveal-with-wp' );
		$tax_labels['singular_name']         = _x( 'SlideCat', 'Taxonomy Singular Name', 'reveal-with-wp' );
		$tax_labels['menu_name']         = _x( 'SlideCat', 'Taxonomy Singular Name', 'reveal-with-wp' );

		// $tax_args = self::get_tax_args_defaults();
		$tax_args['label']  = __( 'SlideCat', 'reveal-with-wp' );
		$tax_args['labels'] = $tax_labels;
		$tax_args['hierarchical']         = __( true, 'reveal-with-wp' );

		register_taxonomy( 'reveal_slides_cat', array( 'reveal_slides' ), $tax_args );
	}
	public static function custom_query_vars_filter( $vars ) {
		$vars[] = 'reveal_order';
		return $vars;
	}
	public static function create_reveal_js_slide() {

		$labels = array(
			'name'                  => _x( 'Reveal Slides', 'Post Type General Name', 'reveal-with-wp' ),
			'singular_name'         => _x( 'Reveal Slide', 'Post Type Singular Name', 'reveal-with-wp' ),
			'menu_name'             => __( 'Reveal Slides', 'reveal-with-wp' ),
			'name_admin_bar'        => __( 'Reveal Slide', 'reveal-with-wp' ),
			'archives'              => __( 'Reveal Slide Archives', 'reveal-with-wp' ),
			'attributes'            => __( 'Reveal Slide Attributes', 'reveal-with-wp' ),
			'parent_item_colon'     => __( 'Parent Reveal Slide:', 'reveal-with-wp' ),
			'all_items'             => __( 'All Reveal Slides', 'reveal-with-wp' ),
			'add_new_item'          => __( 'Add New Slide', 'reveal-with-wp' ),
			'add_new'               => __( 'Add New Slide', 'reveal-with-wp' ),
			'new_item'              => __( 'New Reveal Slide', 'reveal-with-wp' ),
			'edit_item'             => __( 'Edit Reveal Slide', 'reveal-with-wp' ),
			'update_item'           => __( 'Update Reveal Slide', 'reveal-with-wp' ),
			'view_item'             => __( 'View Reveal Slide', 'reveal-with-wp' ),
			'view_items'            => __( 'View Reveal Slides', 'reveal-with-wp' ),
			'search_items'          => __( 'Search Reveal Slide', 'reveal-with-wp' ),
			'not_found'             => __( 'Reveal Slides Not found', 'reveal-with-wp' ),
			'not_found_in_trash'    => __( 'Reveal Slides Not found in Trash', 'reveal-with-wp' ),
			'featured_image'        => __( 'Reveal Slide Featured Image', 'reveal-with-wp' ),
			'set_featured_image'    => __( 'Set Reveal Slide featured image', 'reveal-with-wp' ),
			'remove_featured_image' => __( 'Remove Reveal Slide featured image', 'reveal-with-wp' ),
			'use_featured_image'    => __( 'Use as Reveal Slide featured image', 'reveal-with-wp' ),
			'insert_into_item'      => __( 'Insert into Reveal Slide', 'reveal-with-wp' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Reveal Slide', 'reveal-with-wp' ),
			'items_list'            => __( 'Reveal Slides list', 'reveal-with-wp' ),
			'items_list_navigation' => __( 'Reveal Slides list navigation', 'reveal-with-wp' ),
			'filter_items_list'     => __( 'Filter Reveal Slides list', 'reveal-with-wp' ),
		);
		$args = array(
			'label'                 => __( 'Reveal Slide', 'reveal-with-wp' ),
			'description'           => __( 'Reveal Slides Post Type Description', 'reveal-with-wp' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', 'excerpt' ),
			'taxonomies'            => array( 'reveal_slides_cat' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 21,
			'menu_icon'             => 'dashicons-move',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'rewrite'               => array(
				'with_front' => true,
				'slug' => 'presentation',
				'rest_base'           => __( 'reveal-with-wp', 'reveal-with-wp' ),
			),
		);

		register_post_type( 'reveal_slides', $args );
	}

	/**
	 * Plugin Action Links
	 *
	 * Adds settings link on the plugins page.
	 *
	 * @param   array $actions  Plugin action links array.
	 * @return  array            Plugin action links array.
	 */
	public static function plugin_action_links( $actions ) {

		$actions[] = sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php?post_type=reveal_slides&page=reveal-dashboard.php' ), __( 'Settings', 'reveal-with-wordpress' ) );
		return $actions;
	}
	/**
	 * Plugin CSS
	 *
	 * Adds settings link on the plugins page.
	 *
	 * @param   array $actions  Plugin action links array.
	 * @return  array            Plugin action links array.
	 */
	public static function add_admin_css() {
		?>
		<style type="text/css">
		#menu_order, #reorder,
		.menu_order.column-menu_order,
		.reorder.column-reorder {
			text-align: center;
			width: 15%;
		}
/*		.wp-list-table .title.column-title.has-row-actions.column-primary.page-title {
			width: 35%;
		}*/
		.manage-column.column-title.column-primary {
			width: 35%;
		}
		.wp-list-table .ui-sortable tr:hover {
			background: rgba(22,244,25,.2);
		}
		td.reorder.column-reorder > span {
			color: #bbb;
			transition: all .3s ease-in-out;
			padding: 1rem;
		}
		tr:hover td.reorder.column-reorder > span {
			color: green;
			transform: scale(1.5);
		}

		</style>
		<?php
	}

}

<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class Export_Reveal_Slides {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'export_dashboard' ) );
		add_action( 'wp_ajax_csv_pull', array( __CLASS__, 'perform_reveal_query' ) );
		add_action( 'add_to_export_dash', array( __CLASS__, 'adding_to_export_dashboard_page' ) );
	}

	/**
	 * Debug Information
	 *
	 * @since 1.0.0
	 *
	 * @param bool $html Optional. Return as HTML or not
	 *
	 * @return string
	 */
	public static function adding_to_export_dashboard_page() {
		global $wpdb;
		$table = 'posts';
		echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';
		$results = $wpdb->get_results(
			"
			SELECT * FROM $wpdb->prefix$table",
			ARRAY_A
		);

		$reveal_presentation_query = new WP_Query(
			array(
				'post_type'    => array( 'reveal_slides' ),
				'category__in' => array( 6 ),
				// 'meta_query' => array(
				// array(
				// 'key'   => 'teaser',
				// 'value' => 'on',
				// ),
			)
		);
		$index = 1;
		while ( $reveal_presentation_query->have_posts() ) :
			$reveal_presentation_query->the_post();
			// echo get_the_title() . '<br>';
			the_title( '<h4>Slide ' . $index . ' ', '</h4>' );
			echo '<div style="margin-left:1rem;">';
			the_content();
			echo '</div>';
			$index++;
		endwhile;
		echo '<h3>Add more info here</h3>';
	}


	public static function perform_reveal_query() {
		global $wpdb;

		$table   = 'ns_contact_form';// table name
		$file    = 'ns_contact_form_csv'; // csv file name
		$results = $wpdb->get_results( "SELECT * FROM $wpdb->prefix$table", ARRAY_A );

		if ( count( $results ) > 0 ) {
			foreach ( $results as $result ) {
				$result      = array_values( $result );
				$result      = implode( ', ', $result );
				$csv_output .= $result . "\n";
			}
		}

		$filename = $file . '_' . date( 'Y-m-d_H-i', time() );
		header( 'Content-type: application/vnd.ms-excel' );
		header( 'Content-disposition: csv' . date( 'Y-m-d' ) . '.csv' );
		header( 'Content-disposition: filename=' . $filename . '.csv' );
		print $csv_output;
		exit;

	}

	public static function export_dashboard() {
		$slug  = preg_replace( '/_+/', '-', __FUNCTION__ );
		$label = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
		add_dashboard_page( __( $label, 'export-dashboard-menu' ), __( $label, 'export-dashboard-menu' ), 'manage_options', $slug . '.php', array( __CLASS__, 'export_dashboard_page' ) );
	}


	/**
	 * Debug Information
	 *
	 * @since 1.0.0
	 *
	 * @param bool $html Optional. Return as HTML or not
	 *
	 * @return string
	 */
	public static function export_dashboard_page() {
		global $wpdb;
		echo '<div class="wrap">';
		echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';
		$screen         = get_current_screen();
		$site_theme     = wp_get_theme();
		$site_prefix    = $wpdb->prefix;
		$prefix_message = '$site_prefix = ' . $site_prefix;
		if ( is_multisite() ) {
			$network_prefix  = $wpdb->base_prefix;
			$prefix_message .= '<br>$network_prefix = ' . $network_prefix;
		}

		echo '<h4 style="color:rgba(250,128,114,.7);">Current Screen is <span style="color:rgba(250,128,114,1);">' . $screen->id . '</span></h4>';
		echo 'Your WordPress version is ' . get_bloginfo( 'version' );
		echo $site_prefix;

		echo '<div class="add-to-export-dash" style="background:aliceblue;padding:1rem 2rem;">';
		do_action( 'add_to_export_dash' );
		echo '</div>';

		$site_theme = wp_get_theme();
		echo '<h4>Theme is ' . sprintf(
			__( '%1$s and is version %2$s', 'text-domain' ),
			$site_theme->get( 'Name' ),
			$site_theme->get( 'Version' )
		) . '</h4>';
		echo '<h4>Templates found in ' . get_template_directory() . '</h4>';
		echo '<h4>Stylesheet found in ' . get_stylesheet_directory() . '</h4>';
		echo '</div>';
	}

}
Export_Reveal_Slides::init();

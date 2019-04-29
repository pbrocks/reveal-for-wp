<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class Print_Reveal_Slides {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'build_print_reveal_slides' ) );
		// add_action( 'wp_enqueue_scripts', array( __CLASS__, 'custom_css_enqueue' ) );
	}

	public static function build_print_reveal_slides() {
		$slug              = preg_replace( '/_+/', '-', __FUNCTION__ );
		$label             = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
		$print_reveal_page = add_submenu_page( 'edit.php?post_type=reveal_slides', __( $label, 'reveal-dashboard-menu' ), __( $label, 'reveal-dashboard-menu' ), 'manage_options', $slug . '-print.php', array( __CLASS__, 'reveal_print_html' ) );

		add_action( 'load-' . $print_reveal_page, array( __CLASS__, 'load_reveal_edit_screen' ) );
	}

	/**
	 * Add slide ordering help to the help tab
	 */
	public static function load_reveal_edit_screen() {
		$screen = get_current_screen();
		if ( $screen->id !== 'print-reveal_slides' ) {
			return;
		}
		$screen->add_help_tab(
			array(
				'id'      => 'print_reveal_slide_help_tab',
				'title'   => 'Reveal Slide ',
				'content' => '<p>' . __( ' T an item, simply drag and drop the row by "clicking and holding" it anywhere (outside of the links and form controls) and moving it to its new position.', 'reveal-slide-reordering' ) . '</p>',
			)
		);
	}


	public static function custom_css_enqueue() {
		?>
		<style type="text/css">
			#wpadminbar {
				/*display: none;*/
			}			
		</style>
		<?php
		wp_register_style( 'reveal-pbrocks', plugins_url( 'css/reveal-pbrocks.css', dirname( __FILE__ ) ) );
		// wp_enqueue_style( 'reveal-pbrocks' );
	}

	/**
	 * reveal_print_html
	 *
	 * @since 1.0.0
	 *
	 * @param bool $html Optional. Return as HTML or not
	 *
	 * @return string
	 */
	public static function reveal_print_html() {
		echo '<div class="wrap">';
		echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';
		// echo plugin_dir_path( dirname( __DIR__ ) ) . 'reveal-js/css/themes/<br>';
		$template_path = plugin_dir_path( __DIR__ ) . 'templates/reveal-page-pbrocks.php';
		echo $template_path;
		echo '<xmp>' . file_get_contents( $template_path ) . '</xmp>';

		// $portfolio = query_posts( 'post_type=reveal_slides' );
		$slides      = self::build_the_query();
		$slide_count = count( $slides->posts );

		echo '<hr><h3 style="color:tomato;">Slide presentation<h3>';
		echo '<p>Below you should see the order of slides in your presentation.</p>';
		$presentation = '';
		echo '<div style="padding:0 2rem;">';
		foreach ( $slides->posts as $key => $value ) {
			echo '<xmp>' . $value->post_title . '</xmp>';
			echo '<xmp>' . print_r( $value->post_content, true ) . '</xmp>';
		}

		echo '</div>';
	}

	/**
	 * build_the_query
	 *
	 * @since 1.0.0
	 *
	 * @param bool $html Optional. Return as HTML or not
	 *
	 * @return string
	 */
	public static function build_the_query() {
		$args = array(
			'post_type'    => array( 'reveal_slides' ),
			'post_status'  => array( 'publish' ),
			'category__in' => get_option( 'reveal_category' ),
			// 'category_name' => 'wclancpa19',
			'nopaging'     => true,
			'order'        => 'ASC',
			'orderby'      => 'menu_order',
		);

		$slides = new WP_Query( $args );

		return $slides;
	}
	/**
	 * count_the_query
	 *
	 * @since 1.0.0
	 *
	 * @param bool $html Optional. Return as HTML or not
	 *
	 * @return string
	 */
	public static function count_the_query() {
		$slides    = self::build_the_query();
		$count     = count( $slides->posts );
		$i         = 1;
		$step_menu = ' | ';
		while ( $i <= $count ) {
			$step_menu .= $i . ' | ';
			$i++;
		}
		return $count;
	}
}

Print_Reveal_Slides::init();

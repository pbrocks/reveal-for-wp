<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class Build_Reveal_Slides {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'reveal_html' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'custom_css_enqueue' ) );
		// add_filter( 'theme_page_templates', array( __CLASS__, 'add_page_template_to_dropdown' ) );
	}

	public static function reveal_html() {
		$slug  = preg_replace( '/_+/', '-', __FUNCTION__ );
		$label = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
		add_submenu_page( 'edit.php?post_type=reveal_slides', __( $label, 'reveal-dashboard-menu' ), __( $label, 'reveal-dashboard-menu' ), 'manage_options', $slug . '.php', array( __CLASS__, 'reveal_some_html' ) );
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
		wp_enqueue_style( 'reveal-pbrocks' );
	}


	/**
	 * reveal_some_html
	 *
	 * @since 1.0.0
	 *
	 * @param bool $html Optional. Return as HTML or not
	 *
	 * @return string
	 */
	public static function reveal_some_html() {
		echo '<div class="wrap">';
		echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';

		$response_tabs = new Reveal_Slides_Setup_Info();
		$hide_bouncing = get_user_meta( get_current_user_id(), 'hide_bouncing_arrow', true );
		if ( 'hide' !== $hide_bouncing ) {
			echo $hide_bouncing;
			$show_tabs = $response_tabs->reveal_slides_arrow();
		}

		echo plugin_dir_path( dirname( __DIR__ ) ) . 'reveal-js/css/themes/<br>';

		echo '<select>';
		foreach ( glob( plugin_dir_path( dirname( __DIR__ ) ) . 'reveal-js/css/theme/*.css' ) as $file ) {
			echo '<option>' . basename( $file ) . '</option>';
		}
		echo '</select>';
		echo '<h3>Presenting from reveal_slides_cat #' . get_option( 'reveal_category' ) . '</h3>';
		$check_this = rrveal_slides__posts();
		$check_this = self::build_the_query();
		self::list_slides_from_the_query();
		echo '<pre>';
		// print_r( $check_this );
		echo '</pre>';

		// $reveal_slides = new WP_Query( $args );
		$reveal_slides = $check_this;

		if ( $reveal_slides->have_posts() ) {
		?>
		  <ul>
			<?php
			while ( $reveal_slides->have_posts() ) {
				$reveal_slides->the_post();
				?>
				<li> ** <?php printf( '%1$s - %2$s', get_the_title(), get_the_content() ); ?></li>
				<?php
			}
			  wp_reset_postdata();
			?>
		  </ul>
		<?php
		} else {
			esc_html_e( 'No reveal_slides in the diving taxonomy!', 'text-domain' );
		}
		echo '<pre>';
		// print_r( $reveal_slides->posts );
		echo '</pre>';

		echo '</div>';
	}

	/**
	 * list_slides_from_the_query
	 *
	 * @since 1.0.0
	 *
	 * @param bool $html Optional. Return as HTML or not
	 *
	 * @return string
	 */
	public static function list_slides_from_the_query() {
		$slides = rrveal_slides__posts();
		echo '<hr><hr><h3 style="color:tomato;">Slide presentation<h3>';
		echo '<p>Below you should see the order of slides in your presentation.</p>';
		$presentation = '';
		echo '<div style="padding:0 2rem;">';
		foreach ( $slides->posts as $key => $value ) {
			echo '<h4><a href="' . admin_url() . '/post.php?post=' . $value->ID . '&action=edit" target="_blank"><span style="color:tomato;">Slide ' . ( intval( $key ) + 1 ) . '</span> ' . $value->post_title . '</a></h4>';
			// echo '<p style="color:blue">' . $value->post_content . '</p>';
		}
		echo '</div><hr><hr>';
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
			// 'category_name' => 'wclvpa19',
			'nopaging'     => true,
			'order'        => 'ASC',
			'orderby'      => 'menu_order',
		);
		$args = array(
			'post_type' => 'reveal_slides',
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'reveal_slides_cat',
					'terms'    => array( 'wclvpa19' ),
				),
			),
		);
		$args = array(
			'post_type' => 'reveal_slides',
			'nopaging'     => true,
			'order'        => 'ASC',
			'orderby'      => 'menu_order',
			'tax_query' => array(
				array(
					'taxonomy' => 'reveal_slides_cat',
					'field'    => 'term_id',
					'terms'    => array( get_option( 'reveal_category' ) ),
				),
			),
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

Build_Reveal_Slides::init();

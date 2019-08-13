<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class Reveal_Page_Template {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'reveal_dashboard' ) );
		// add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		// add_filter( 'theme_page_templates', array( __CLASS__, 'add_page_template_to_dropdown' ) );
		add_filter( 'template_include', array( __CLASS__, 'change_page_template' ) );
	}

	public static function reveal_dashboard() {
		$slug = preg_replace( '/_+/', '-', __FUNCTION__ );
		$label = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
		$settings_page = add_submenu_page( 'edit.php?post_type=reveal_slides', __( $label, 'reveal-dashboard-menu' ), __( $label, 'reveal-dashboard-menu' ), 'manage_options', $slug . '.php', array( __CLASS__, 'reveal_dashboard_menu_order' ) );
		add_action( "load-{$settings_page}", 'pbrx_load_settings_page' );
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
	public static function reveal_dashboard_menu_order() {
		echo '<div class="wrap">';
		echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';
		$response_tabs = new Reveal_Slides_Setup_Info();
		$hide_bouncing = get_user_meta( get_current_user_id(), 'hide_bouncing_arrow', true );
		if ( 'hide' !== $hide_bouncing ) {
			echo $hide_bouncing;
			$show_tabs = $response_tabs->reveal_slides_arrow();
		}
		$screen = get_current_screen();
		echo '<h4 style="color:rgba(250,128,114,.7);">Current Screen is <span style="color:rgba(250,128,114,1);">' . $screen->id . '</span></h4>';
		$my_theme = wp_get_theme();
		echo '<h4>Theme is ' . sprintf(
			__( '%1$s and is version %2$s', 'text-domain' ),
			$my_theme->get( 'Name' ),
			$my_theme->get( 'Version' )
		) . '</h4>';
		echo '<h4>Templates found in ' . get_template_directory() . '</h4>';
		echo '<h4>Stylesheet found in ' . get_stylesheet_directory() . '</h4>';
		echo '<xmp>// WP_Query arguments
$args = array(
	\'post_type\'  => array( \'reveal_slides\' ),
	\'order\'      => \'ASC\',
	\'orderby\'    => \'menu_order\',
);</xmp>';
		$path = plugin_dir_path( dirname( dirname( __FILE__ ) ) . '/templates/' );
		$path = plugin_dir_path( __DIR__ ) . 'templates/';
		$files = scandir( $path );

		$slides = Build_Reveal_Slides::build_the_query();
		echo '<hr><hr><pre>';
		print_r( $slides );
		echo '</pre>';
		// $presentation = '';
		// foreach ( $slides->posts as $key => $value ) {
		// $notes = '$post_id = ' . $value->ID . '<br>';
		// $presentation .= '<section><h3>Slide ' . ( intval( $key ) + 1 ) . ' ' . $value->post_title . '</h3>';
		// $presentation .= '<p style="color:blue">' . $value->post_content . '</p></section>';
		// }
		// echo esc_html__( $presentation );
		// echo '<hr><hr><pre>';
		// print_r( $slides->posts[0]->ID );
		// echo '</pre>';
		echo '<select>';
		foreach ( glob( plugin_dir_path( __DIR__ ) . 'templates/*.php' ) as $file ) {
			echo '<option>' . basename( $file ) . '</option>';
		}
		echo '</select>';

		echo '<pre>';
		// print_r( $files );
		echo '</pre>';
		$reveal_page_id = intval( get_option( 'reveal_on_page' ) );
		echo '<h4>final_reveal_template = ' . get_option( 'final_reveal_template' ) . '</h4>';
		echo '<h4>REVEAL_JS = ' . REVEAL_JS . '</h4>';
		echo '<h4>Reveal Templates = ' . $path . '</h4>';
		echo '<h4>reveal_on_page id# ' . $reveal_page_id . '</h4>';
		echo '<h4> ' . ( '1' === get_option( 'turn_off_admin_bar' ) && get_option( 'reveal_on_page' ) ? 'please' : 'nope' ) . '</h4>';
		echo '<pre>';
		print_r( get_post( $reveal_page_id ) );
		print_r( get_the_author_meta( $reveal_page_id ) );
		echo '</pre>';
		echo '</div>';
	}

	public static function enqueue_scripts() {
		wp_register_script( 'reveal-jbase', REVEAL_JS . 'js/reveal.js', array( 'jquery', 'reveal-min' ), time(), true );
		wp_register_script( 'reveal-min', REVEAL_JS . 'lib/js/head.min.js', array( 'jquery' ), time(), true );
		wp_register_style( 'reveal-base', REVEAL_JS . 'css/reveal.css' );
		wp_register_style( 'reveal-sky', REVEAL_JS . 'css/theme/sky.css' );
		wp_enqueue_script( 'reveal-jbase' );
		wp_enqueue_script( 'reveal-min' );
		wp_enqueue_style( 'reveal-base' );
		wp_enqueue_style( 'reveal-sky' );
	}

	/**
	 * Add page templates.
	 * plugin_dir_path( __DIR__ ) . 'templates/*.php'
	 *
	 * @param array $templates The list of page templates
	 *
	 * @return array  $templates  The modified list of page templates
	 */
	public static function add_page_template_to_dropdown( $templates ) {
		// $templates[ plugin_dir_path( dirname( __FILE__ ) ) . 'templates/reveal-page-template.php' ] = __( 'Reveal Template', 'reveal-with-wordpress' );
		$templates[ plugin_dir_path( dirname( __FILE__ ) ) . 'templates/' . get_option( 'final_reveal_template' ) ] = __( 'Reveal Template', 'reveal-with-wordpress' );
		return $templates;
	}

	/**
	 * Change the page template to the selected template on the dropdown
	 * Change the single template to the fixed template in the plugin
	 *
	 * @param $template
	 *
	 * @return mixed
	 */
	public static function change_page_template( $template ) {
		$page_id = get_option( 'reveal_on_page' );
		if ( is_page( $page_id ) ) {

			if ( is_single() || is_page() ) {
				// $file_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/reveal-page-template.php';
				$file_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/' . get_option( 'final_reveal_template' );
				if ( file_exists( $file_template ) ) {
					$template = $file_template;
				}
			}
		}
		return $template;
	}
}

Reveal_Page_Template::init();

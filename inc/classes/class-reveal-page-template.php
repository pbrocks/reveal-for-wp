<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class Reveal_Page_Template {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'reveal_dashboard' ) );
		// add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_filter( 'theme_page_templates', array( __CLASS__, 'add_page_template_to_dropdown' ) );
		add_filter( 'template_include', array( __CLASS__, 'change_page_template' ), 99 );
	}

	public static function reveal_dashboard() {
		$slug = preg_replace( '/_+/', '-', __FUNCTION__ );
		$label = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
		add_submenu_page( 'edit.php?post_type=reveal_slides', __( $label, 'reveal-dashboard-menu' ), __( $label, 'reveal-dashboard-menu' ), 'manage_options', $slug . '.php', array( __CLASS__, 'reveal_dashboard_menu_order' ) );
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
		echo '<h2>' . __FUNCTION__ . '</h2>';
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
	 *
	 * @param array $templates The list of page templates
	 *
	 * @return array  $templates  The modified list of page templates
	 */
	public static function add_page_template_to_dropdown( $templates ) {
		$templates[ plugin_dir_path( dirname( __FILE__ ) ) . 'templates/reveal-page-template.php' ] = __( 'Reveal Template', 'reveal-with-wordpress' );
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
		if ( is_page( 'wclvpa' ) ) {

			if ( is_single() || is_page() ) {
				// $file_template = plugin_dir_path( __FILE__ ) . 'templates/reveal-page-template.php';
				$file_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/reveal-page-template.php';
				if ( file_exists( $file_template ) ) {
					$template = $file_template;
				}
			}
		}
		return $template;
	}
}

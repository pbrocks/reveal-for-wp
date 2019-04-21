<?php
/**
 * Reveal Help Tabs
 */
defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class Reveal_Help_Tabs {
	public static function init() {
		// add_action( 'wp_enqueue_scripts', array( __CLASS__, 'customizer_enqueue' ) );
		// add_filter( 'wp_enqueue_scripts', array( __CLASS__, 'set_customizer_preview_url' ) );
		add_action( 'admin_menu', array( __CLASS__, 'reveal_admin_add_page' ) );
	}

	public static function reveal_admin_add_page() {
		global $reveal_help_page;
		$reveal_help_page = add_dashboard_page( __( 'Reveal Help Tabs', 'reveal-with-wp' ), __( 'Reveal help Tabs', 'reveal-with-wp' ), 'manage_options', 'options-test', array( __CLASS__, 'reveal_help_page' ) );

		add_action( "load-$reveal_help_page", array( __CLASS__, 'reveal_plugin_help_tabs' ) );

	}

	public static function reveal_plugin_help_tabs() {
		global $reveal_help_page;
		$screen = get_current_screen();
		if ( $screen->id != $reveal_help_page ) {
			return;
		}

		$screen->add_help_tab(
			array(
				'id'      => 'reveal-usage',
				'title'   => __( 'Using the Plugin', 'reveal-with-wp' ),
				'content' => self::reveal_help_tab_content( 'reveal-usage' ),
			)
		);
		$screen->add_help_tab(
			array(
				'id'      => 'reveal-set-up',
				'title'   => __( 'Reveal Setup', 'reveal-with-wp' ),
				'content' => self::reveal_help_tab_content( 'reveal-set-up' ),
			)
		);
		$screen->add_help_tab(
			array(
				'id'      => 'reveal-presenting',
				'title'   => __( 'Presenting', 'reveal-with-wp' ),
				'content' => self::reveal_help_tab_content( 'reveal-presenting' ),
			)
		);
	}

	public static function reveal_help_tab_content( $tab = 'reveal-usage' ) {
		if ( $tab == 'reveal-usage' ) {
			ob_start(); ?>
			<h3><?php _e( 'Using the plugin', 'reveal-with-wp' ); ?></h3>
			<p>In scelerisque, placerat nec urna in pulvinar rhoncus vut dolor tincidunt dapibus in ac massa sit tristique egestas? Non, integer dis massa egestas eros! Elementum vel rhoncus! Et lorem sed lundium nascetur amet! Et scelerisque sit. Egestas tincidunt, quis enim urna arcu mattis rhoncus nisi nec enim tincidunt! Augue magnis.</p>
			
			<p>In scelerisque, placerat nec urna in pulvinar rhoncus vut dolor tincidunt dapibus in ac massa sit tristique egestas? Non, integer dis massa egestas eros! Elementum vel rhoncus! Et lorem sed lundium nascetur amet! Et scelerisque sit. Egestas tincidunt, quis enim urna arcu mattis rhoncus nisi nec enim tincidunt! Augue magnis.</p>
			<?php
			return ob_get_clean();
		} elseif ( $tab == 'reveal-set-up' ) {
			ob_start();
			?>
			<h3><?php _e( 'Reveal Setup', 'reveal-with-wp' ); ?></h3>
			<p>In scelerisque, placerat nec urna in pulvinar rhoncus vut dolor tincidunt dapibus in ac massa sit tristique egestas? Non, integer dis massa egestas eros! Elementum vel rhoncus! Et lorem sed lundium nascetur amet! Et scelerisque sit. Egestas tincidunt, quis enim urna arcu mattis rhoncus nisi nec enim tincidunt! Augue magnis.</p>
			<?php
			return ob_get_clean();
		} elseif ( $tab == 'reveal-presenting' ) {
			ob_start();
			?>
			<h3><?php _e( 'Presenting with Reveal', 'reveal-with-wp' ); ?></h3>
			<p>In scelerisque, placerat nec urna in pulvinar rhoncus vut dolor tincidunt dapibus in ac massa sit tristique egestas? Non, integer dis massa egestas eros!</p>
			<p>Use s to present slides with Notes.</p>
			<ul>
				<li>List Item Reveal</li>
				<li>List Item Reveal</li>
				<li>List Item Reveal</li>
				<li>List Item Reveal</li>
			</ul>
			<?php
			return ob_get_clean();
		}
	}

	public static function reveal_help_page() {
		ob_start();
		?>
	<div class="wrap">
		<h2><?php _e( 'Reveal Help Tab', 'reveal-with-wp' ); ?></h2>
		<p>This is out set-up page content. Click the "Help" menu above to see the new help tabs.</p>
	</div>
		<?php
		echo ob_get_clean();
	}
}
Reveal_Help_Tabs::init();

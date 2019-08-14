<?php
/**
 * Plugin Name: Reveal for/with WordPress
 * Plugin URI: https://github.com/pbrocks/reveal-for-wp
 * Description: Build Reveal.js presentations in WordPress, select page to present on and category to present from in Customizer
 * Version: 0.9.6
 * Author: pbrocks
 * Author URI: https://github.com/pbrocks
 * Text-domain: reveal-with-wp
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

define( 'REVEAL_JS', plugins_url( 'reveal-js', __FILE__ ) );


register_activation_hook( __FILE__, 'reveal_slides_install' );
function reveal_slides_install() {
	set_transient( 'reveal_slides_activated', true, 30 );
}

if ( file_exists( __DIR__ . '/inc' ) && is_dir( __DIR__ . '/inc' ) ) {
	/**
	 * Include all php files in /inc directory.
	 */
	foreach ( glob( __DIR__ . '/inc/*.php' ) as $filename ) {
		require $filename;
	}
}
if ( file_exists( __DIR__ . '/inc/classes' ) && is_dir( __DIR__ . '/inc/classes' ) ) {
	/**
	 * Include all php files in /inc/classes directory.
	 */
	foreach ( glob( __DIR__ . '/inc/classes/*.php' ) as $filename ) {
		require $filename;
	}
}

/**
 * Setup WordPress localization support
 *
 * @since 4.0
 */
function reveal_slides_load_textdomain() {
	load_plugin_textdomain( 'reveal-with-wp', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'reveal_slides_load_textdomain' );

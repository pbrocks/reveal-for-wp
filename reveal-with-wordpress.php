<?php
/**
 * Plugin Name: Reveal for/with WordPress
 * Plugin URI: https://github.com/pbrocks/reveal-for-wp
 * Description: Build Reveal.js presentations in WordPress, select page to present on and category to present from in Customizer
 * Version: 0.9.5
 * Author: pbrocks
 * Author URI: https://github.com/pbrocks
 * Text-domain: reveal-with-wp
 */

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

define( 'REVEAL_JS', plugins_url( 'reveal-js', __FILE__ ) );

/**
 * Include all php files in /inc directory.
 */
foreach ( glob( __DIR__ . '/inc/*.php' ) as $filename ) {
	require $filename;
}

/**
 * Include all php files in /inc directory.
 */
foreach ( glob( __DIR__ . '/inc/classes/*.php' ) as $filename ) {
	require $filename;
}


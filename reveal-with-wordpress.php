<?php
/**
 * Plugin Name: Reveal for/with WordPress
 * Plugin URI: https://github.com/pbrocks/reveal-for-wp
 * Description: Build Reveal.js presentations in WordPress
 * Version: 0.9.1
 * Author: pbrocks
 * Author URI: https://github.com/pbrocks
 */

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

define( 'REVEAL_JS', plugins_url( 'reveal-js', __FILE__ ) );

include( 'inc/classes/class-add-reveal-customizer.php' );
include( 'inc/classes/class-build-reveal-slides.php' );
include( 'inc/classes/class-create-reveal-slides.php' );
include( 'inc/classes/class-reveal-page-template.php' );
include( 'inc/classes/class-reveal-slide-reordering.php' );
Build_Reveal_Slides::init();
Create_Reveal_Slides::init();
Reveal_Page_Template::init();
Add_Reveal_Customizer::init();

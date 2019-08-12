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
		echo plugin_dir_path( dirname( __DIR__ ) ) . 'reveal-js/css/themes/<br>';

		echo '<select>';
		foreach ( glob( plugin_dir_path( dirname( __DIR__ ) ) . 'reveal-js/css/theme/*.css' ) as $file ) {
			echo '<option>' . basename( $file ) . '</option>';
		}
		echo '</select>';

		$check_this = rrveal_slides__posts();

		echo '<pre>';
		print_r( $check_this );
		echo '</pre>';

		$args = array(
			'post_type'   => 'reveal_slides',
			'post_status' => 'publish',
			'tax_query'   => array(
				array(
					'taxonomy' => 'reveal_slides_cat',
					'field' => 'wclvpa19',
				),
			),
		);

		// $reveal_slides = new WP_Query( $args );
		$reveal_slides = $check_this;

		if ( $reveal_slides->have_posts() ) {
		?>
		  <ul>
			<?php
			while ( $reveal_slides->have_posts() ) {
				$reveal_slides->the_post();
				?>
				<li><?php printf( '%1$s - %2$s', get_the_title(), get_the_content() ); ?></li>
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
		echo '<pre>';
		// print_r( $slides->posts );
		echo '</pre>';
		/*
		echo '<xmp>
		<section class="page-zero">
		<section>
		<h2><?php echo $slides->posts[0]->post_title; ?></h2>

		<div class="slide-content">
			<?php echo $slides->posts[0]->post_content; ?>
		</div>
		<?php
		if ( $slides->max_num_pages > 1 ) {
			?>
			<div id="nav-below" class="navigation">
			<div class="nav-previous"><?php next_posts_link( __( \' <span class=\"meta-nav\">&larr;</span> Previous\', \'reveal-with-wordpress\' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( \'Next<span class=\"meta-nav\">&rarr;</span>\', \'reveal-with-wordpress\' ) ); ?></div>
		</div>
		<?php
		}
		?>
		<p><br><br></p>
		<aside class="notes">

		</aside>
		<p><small><?php echo $step_menu; ?></small></p>
		</section>
		</section>
		echo </xmp>';

		echo '<xmp>
		[1] => WP_Post Object SAMPLE
		(
			[ID] => 10463
			[post_author] => 1
			[post_date] => 2018-08-10 05:55:05
			[post_date_gmt] => 2018-08-09 19:55:05
			[post_content] => Slide 2 Content Slide 2 Content Slide 2 Content Slide 2 Content Slide 2 Content Slide 2 Content Slide 2 Content Slide 2 Content Slide 2 Content
			[post_title] => Slide 2 Title
			[post_excerpt] =>
			[post_status] => publish
			[comment_status] => closed
			[ping_status] => closed
			[post_password] =>
			[post_name] => slide-2-title
			[to_ping] =>
			[pinged] =>
			[post_modified] => 2018-08-11 13:44:18
			[post_modified_gmt] => 2018-08-11 03:44:18
			[post_content_filtered] =>
			[post_parent] => 0
			[guid] => https://wordcamp.local/?post_type=reveal_js_slide&p=10463
			[menu_order] => 2
			[post_type] => reveal_slides
			[post_mime_type] =>
			[comment_count] => 0
			[filter] => raw
		)
		</xmp>'; */
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
		$slides = get_posts( $args );

		// $slides = new WP_Query( $args );
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

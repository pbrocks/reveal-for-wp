<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class Build_Reveal_Slides {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'reveal_html' ) );
		// add_filter( 'theme_page_templates', array( __CLASS__, 'add_page_template_to_dropdown' ) );
	}

	public static function reveal_html() {
		$slug = preg_replace( '/_+/', '-', __FUNCTION__ );
		$label = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
		add_submenu_page( 'edit.php?post_type=reveal_slides', __( $label, 'reveal-dashboard-menu' ), __( $label, 'reveal-dashboard-menu' ), 'manage_options', $slug . '.php', array( __CLASS__, 'reveal_some_html' ) );
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
		$slides = self::build_the_query();
		foreach ( $slides->posts as $key => $value ) {
			// echo '<h4><span style="color:tomato;">Slide ' . ( intval( $key ) + 1 ) . '</span> ' . $value->ID . ' ' . $value->post_title . '</h4>';
		}
		echo '<hr><hr><h3 style="color:tomato;">Slide presentation<h3>';
		echo '<p>Below you should see the order of slides in your presentation.</p>';
		$presentation = '';
		foreach ( $slides->posts as $key => $value ) {
			echo '<div style="padding:0 2rem;"><h4><span style="color:tomato;">Slide ' . ( intval( $key ) + 1 ) . '</span> ' . $value->post_title . '</h4>';
			echo '<p style="color:blue">' . $value->post_content . '</p></div>';
		}
		echo '<hr><hr><pre>';
		// print_r( $slides->posts );
		echo '</pre>';

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
    [1] => WP_Post Object
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
            [guid] => https://elverson.local/?post_type=reveal_js_slide&p=10463
            [menu_order] => 2
            [post_type] => reveal_slides
            [post_mime_type] => 
            [comment_count] => 0
            [filter] => raw
        )
		</xmp>';
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
		$slides = new WP_Query(
			array(
				'post_type'  => array( 'reveal_slides' ),
				'order'      => 'ASC',
				'orderby'    => 'menu_order',
			)
		);
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
		$slides = self::build_the_query();
		$count = count( $slides->posts );
		$i = 1;
		$step_menu = ' | ';
		while ( $i <= $count ) {
			$step_menu .= $i . ' | ';
			$i++;
		}
		return $count;
	}
}
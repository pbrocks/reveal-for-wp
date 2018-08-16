<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

/**
 * Register a meta box using a class.
 */
class Reveal_Slide_MetaBoxes {

	/**
	 * Constructor.
	 */
	public static function init() {
		add_action( 'load-post.php', array( __CLASS__, 'init_metabox' ) );
		add_action( 'load-post-new.php', array( __CLASS__, 'init_metabox' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'save_post', array( __CLASS__, 'landing_page_on_save' ), 10, 3 );
	}

	/**
	 * Meta box initialization.
	 */
	public static function init_metabox() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_reveal_slides_metaboxes' ) );
		add_action( 'save_post', array( __CLASS__, 'save_reveal_slides_metaboxes' ), 10, 2 );
	}

	public static function enqueue_scripts() {
		wp_register_script( 'post-edit', plugins_url( 'js/post-edit.js', dirname( __FILE__ ) ), array( 'jquery' ) );
		wp_register_style( 'post-edit', plugins_url( 'css/post-edit.css', dirname( __FILE__ ) ) );
		wp_enqueue_script( 'post-edit' );
		wp_enqueue_style( 'post-edit' );
	}

	/**
	 * Add the metaboxes.
	 */
	public static function add_reveal_slides_metaboxes() {

		add_meta_box(
			'reveal_presentation_checkbox',
			__( 'Use with Reveal.js', 'reveal-with-wp' ),
			array( __CLASS__, 'is_this_for_reveal' ),
			array( 'page' ),
			'side',
			'high'
		);
		add_filter( 'postbox_classes_page_reveal_presentation_checkbox', array( __CLASS__, 'minify_this_metabox' ) );

		add_meta_box(
			'reveal_presentation_title',
			__( 'reveal_presentation_title', 'reveal-with-wp' ),
			array( __CLASS__, 'reveal_presentation_title' ),
			array( 'page' ),
			'normal',
			'high'
		);
		add_meta_box(
			'reveal_presenter_name',
			__( 'reveal_presenter_name', 'reveal-with-wp' ),
			array( __CLASS__, 'reveal_presenter_name' ),
			array( 'page' ),
			'normal',
			'high'
		);
		add_meta_box(
			'reveal_presenter_affiliation',
			__( 'reveal_presenter_affiliation', 'reveal-with-wp' ),
			array( __CLASS__, 'reveal_presenter_affiliation' ),
			array( 'page' ),
			'normal',
			'high'
		);
		add_meta_box(
			'reveal_slide_metabox_3',
			__( 'Customize your Message', 'reveal-with-wp' ),
			array( __CLASS__, 'display_metabox_3' ),
			array( 'reveal_slides' ),
			'normal',
			'high'
		);

		add_meta_box(
			'reveal_slide_metabox_5',
			__( 'Reveal Slide Notes', 'reveal-with-wp' ),
			array( __CLASS__, 'record_slide_notes' ),
			array( 'reveal_slides' ),
			'normal',
			'high'
		);

		add_meta_box(
			'reveal_slide_link',
			__( 'Reveal Slide Link', 'reveal-with-wp' ),
			array( __CLASS__, 'record_slide_link' ),
			array( 'reveal_slides' ),
			'normal',
			'high'
		);
	}



	/**
	 * [minify_this_metabox description]
	 *
	 * @param  array $classes [description]
	 * @return array          [description]
	 */
	public static function minify_this_metabox( $classes ) {
		// if ( isset( $_POST['my_condition'] ) && 'my_condition' == $_POST['my_condition'] ) {
		array_push( $classes, 'closed' );
		// }
		return $classes;
	}

	public static function reveal_presentation_title( $post ) {
		$reveal_meta = __FUNCTION__;
		$reveal_existing = get_post_meta( $post->ID, $reveal_meta, true );
		$label = ucwords( preg_replace( '/_+/', ' ', $reveal_meta ) );
		$selector = preg_replace( '/_+/', '-', $reveal_meta );
		echo '
		<label for="' . $selector . '">' . $label . '</label><br>
			<hr><input name="' . $selector . '" id="' . $selector . '" class="reveal_presentation_text_input" value="' . $reveal_existing . '" /><br>';
	}

	public static function reveal_presenter_name( $post ) {
		$reveal_meta = __FUNCTION__;
		$reveal_existing = get_post_meta( $post->ID, $reveal_meta, true );
		$label = ucwords( preg_replace( '/_+/', ' ', $reveal_meta ) );
		$selector = preg_replace( '/_+/', '-', $reveal_meta );
		echo '
		<label for="' . $selector . '">' . $label . '</label><br>
			<hr><input name="' . $selector . '" id="' . $selector . '" class="reveal_presentation_text_input" value="' . $reveal_existing . '" /><br>';
	}

	public static function reveal_presenter_affiliation( $post ) {
		$reveal_meta = __FUNCTION__;
		$reveal_existing = get_post_meta( $post->ID, $reveal_meta, true );
		$label = ucwords( preg_replace( '/_+/', ' ', $reveal_meta ) );
		$selector = preg_replace( '/_+/', '-', $reveal_meta );
		echo '
		<label for="' . $selector . '">' . $label . '</label><br>
			<hr><input name="' . $selector . '" id="' . $selector . '" class="reveal_presentation_text_input" value="' . $reveal_existing . '" /><br>';
	}

	public static function some_checkbox_metabox( $post ) {
		$selector = preg_replace( '/_+/', '-', __FUNCTION__ );
		$label = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
		wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		$init_checked = false;
		echo '<label for="' . esc_html__( $selector, 'reveal-with-wp' ) . '">' . esc_html__( $label, 'reveal-with-wp' ) . ':</label><br>
	<input name="' . esc_html__( $selector, 'reveal-with-wp' ) . '" id="' . esc_html__( $selector, 'reveal-with-wp' ) . '" type="checkbox" ' . ( $init_checked ? 'checked' : '' ) . ' /><div>
	' . home_url() . '/pbrocks-pmpro-rocks
	</div>';
	}

	public static function is_this_for_reveal( $post ) {
		$selector = preg_replace( '/_+/', '-', __FUNCTION__ );
		$label = ucfirst( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
		$reveal_page_id = intval( get_option( 'reveal_on_page' ) );
		$show_reveal = get_permalink( $reveal_page_id );
		$customize_reveal = admin_url( 'customize.php?url=' . get_permalink( $reveal_page_id ) );
		wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		$init_checked = false;

		echo '<p class="description">' . esc_html__( $label, 'reveal-with-wp' ) . '.js?<br>';
		echo '<div class="use-reveal"><br>';
		echo '<input name="' . esc_html__( $selector, 'reveal-with-wp' ) . '" id="' . esc_html__( $selector, 'reveal-with-wp' ) . '" type="checkbox" ' . ( $init_checked ? 'checked' : '' ) . ' />';
		echo '<label for="' . esc_html__( $selector, 'reveal-with-wp' ) . '"></label></div>';
		echo '<div id="show-reveal"><button class="button button-primary"><a href="' . $customize_reveal . '" target="_blank">Customize Presentation</a></button><br><br><button class="button button-primary"><a href="' . $show_reveal . '" target="_blank">Show Presentation</a></button><br></div>';
	}

	public static function display_metabox_3_heading() {
		$return = '<h3>' . __FUNCTION__ . '</h3>';
		return $return;
	}

	public static function display_metabox_3( $post ) {
		$label = self::display_metabox_3_heading();
		$label = ucwords( preg_replace( '/_+/', ' ', $label ) );
		$value = $label;
		$value .= apply_filters( 'sws_metabox_3_description', 'Use this filter: sws_metabox_3_description to provide some instructions about how to set up a Sitewide Sale.' );
		echo $value;
	}

	public static function record_slide_notes( $post ) {
		$reveal_notes = get_post_meta( $post->ID, 'reveal_notes', true );
		echo '
		<label for="record_slide_notes">Reveal Slide Notes</label><br>
			<hr><textarea name="record_slide_notes" id="record_slide_notes" rows="6" cols="80">' . $reveal_notes . '</textarea><br>';
	}

	public static function record_slide_link( $post ) {
		$reveal_link = get_post_meta( $post->ID, 'reveal_link', true );
		echo '
		<label for="record_slide_link">Reveal Slide Link</label><br>
			<hr><input name="record_slide_link" id="record_slide_link" width="80" value="' . $reveal_link . '" /><br>';
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 * @return null
	 */
	public static function save_reveal_slides_metaboxes( $post_id, $post ) {

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		if ( 'auto-draft' === $post->post_status || 'trash' === $post->post_status ) {
			return;
		}

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
		$nonce_action = 'custom_nonce_action';

		// Check if nonce is set.
		// if ( ! isset( $nonce_name ) ) {
		// return;
		// }
		// Check if nonce is valid.
		// if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
		// die( '<br/>Nonce failed' );
		// }
		global $wpdb;

		if ( isset( $_POST['record_slide_notes'] ) ) {
			update_post_meta( $post_id, 'reveal_notes', esc_html( $_POST['record_slide_notes'] ) );
		}

		if ( isset( $_POST['record_slide_link'] ) ) {
			update_post_meta( $post_id, 'reveal_link', esc_url( $_POST['record_slide_link'] ) );
		}

		if ( isset( $_POST['reveal-presentation-title'] ) ) {
			update_post_meta( $post_id, 'reveal_presentation_title', esc_html( $_POST['reveal-presentation-title'] ) );
		}

		if ( isset( $_POST['reveal-presenter-name'] ) ) {
			update_post_meta( $post_id, 'reveal_presenter_name', esc_html( $_POST['reveal-presenter-name'] ) );
		}

		if ( isset( $_POST['reveal-presenter-affiliation'] ) ) {
			update_post_meta( $post_id, 'reveal_presenter_affiliation', esc_html( $_POST['reveal-presenter-affiliation'] ) );
		}
	}

	/**
	 * Updates Sitewide Sale's landing page id on save
	 *
	 * @param int $saveid landing page being saved.
	 */
	public static function landing_page_on_save( $saveid ) {
		if ( isset( $_REQUEST['pmpro_sws_callback'] ) ) {
			update_post_meta( $_REQUEST['pmpro_sws_callback'], 'landing_page_post_id', $saveid );
		}
	}

	/**
	 * Redirects to Sitewide Sale after landing page is saved
	 *
	 * @param  string $location Previous redirect location.
	 * @param  int    $post_id  id of page that was edited.
	 * @return string           New redirect location
	 */
	public static function redirect_after_page_save( $location, $post_id ) {
		$post_type = get_post_type( $post_id );
		// Grab referrer url to see if it was sent there from editing a sitewide sale.
		$url = $_REQUEST['_wp_http_referer'];
		if ( 'page' === $post_type && ! empty( strpos( $url, 'pmpro_sws_callback=' ) ) ) {
			// Get id of sitewide sale to redirect to.
			$sitewide_sale_id = explode( 'pmpro_sws_callback=', $url )[1];
			$sitewide_sale_id = explode( '$', $sitewide_sale_id )[0];
			$location = esc_html( get_admin_url() ) . 'post.php?post=' . $sitewide_sale_id . '&action=edit';
		}
		return $location;
	}
}

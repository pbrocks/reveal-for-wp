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
		add_action( 'save_post', array( __CLASS__, 'landing_page_on_save' ), 10, 3 );
	}

	/**
	 * Meta box initialization.
	 */
	public static function init_metabox() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_sws_metaboxes' ) );
		add_action( 'save_post', array( __CLASS__, 'save_sws_metaboxes' ), 10, 2 );
	}

	/**
	 * Add the metaboxes.
	 */
	public static function add_sws_metaboxes() {

		add_meta_box(
			'reveal_slide_one',
			__( 'Sitewide Sale', 'pmpro_sitewide_sale' ),
			array( __CLASS__, 'some_checkbox_metabox' ),
			array( 'reveal_slides' ),
			'side',
			'high'
		);

		add_meta_box(
			'reveal_slide_step_3',
			__( 'Customize your Message', 'pmpro_sitewide_sale' ),
			array( __CLASS__, 'display_step_3' ),
			array( 'reveal_slides' ),
			'normal',
			'high'
		);

		add_meta_box(
			'reveal_slide_step_5',
			__( 'Reveal Slide Notes', 'pmpro_sitewide_sale' ),
			array( __CLASS__, 'record_slide_notes' ),
			array( 'reveal_slides' ),
			'normal',
			'high'
		);
	}

	public static function some_checkbox_metabox( $post ) {
		wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		$init_checked = false;

		echo '<table class="form-table"><tr>
	<th scope="row" valign="top"><label>' . esc_html__( 'Set as Current Sitewide Sale', 'pmpro-sitewide-sale' ) . ':</label></th>
	<td><input name="pmpro_sws_set_as_sitewide_sale" type="checkbox" ' . ( $init_checked ? 'checked' : '' ) . ' /></td>
	</tr>
	</table>';
	}

	public static function display_step_3_heading() {
		$return = '<h3>' . __FUNCTION__ . '</h3>';
		return $return;
	}

	public static function display_step_3( $post ) {
		$label = self::display_step_3_heading();
		$label = ucwords( preg_replace( '/_+/', ' ', $label ) );
		$value = $label;
		$value .= apply_filters( 'sws_step_3_description', 'Use this filter: sws_step_3_description to provide some instructions about how to set up a Sitewide Sale.' );
		echo $value;
	}

	public static function record_slide_notes( $post ) {
		$reveal_notes = get_post_meta( $post->ID, 'reveal_notes', true );
		if ( empty( $reveal_notes ) ) {
			$reveal_notes = false;
		}

		echo '
		<label for="record_slide_notes">Reveal Slide Notes</label><br>
			<hr><textarea rows="6" cols="80">
At w3schools.com you will learn how to make a website. We offer free tutorials in all web development technologies.
</textarea><br>';
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 * @return null
	 */
	public static function save_sws_metaboxes( $post_id, $post ) {
		if ( 'reveal_slides' !== $post->post_type ) {
			return;
		}

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
		if ( ! isset( $nonce_name ) ) {
			return;
		}

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			die( '<br/>Nonce failed' );
		}

		global $wpdb;

		if ( isset( $_POST['record_slide_notes'] ) ) {
			update_post_meta( $post_id, 'reveal_notes', true );
		} else {
			update_post_meta( $post_id, 'reveal_notes', false );
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

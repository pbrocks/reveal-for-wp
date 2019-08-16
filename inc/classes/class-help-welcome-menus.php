<?php
/**
 * text-domain:
 * register_activation_hook( __FILE__, 'reveal_slides_install' );
function reveal_slides_install() {
	set_transient( 'reveal_slides_activated', true, 30 );
}
 */

class Reveal_Help_Welcome_Menus {
	public function __construct() {
		add_action( 'admin_init', array( $this, 'reveal_slides_welcome' ), 11 );
		add_action( 'admin_menu', array( $this, 'a_reveal_slides_dashboard' ) );
		add_action( 'admin_head', array( $this, 'admin_add_help_tab' ) );
		// add_action( 'admin_enqueue_scripts', array( $this, 'initialize_reveal_slides_scripts' ) );
		// add_action( 'wp_enqueue_scripts', array( $this, 'initialize_reveal_slides_scripts' ) );
		add_action( 'wp_ajax_reveal_slides_request', array( $this, 'run_reveal_slides_function' ) );
		add_action( 'wp_ajax_nopriv_reveal_slides_request', array( $this, 'run_reveal_slides_function' ) );
		// add_filter( 'page_attributes_dropdown_pages_args', array( $this, 'dropdown_pages_args_callback' ), 10, 2 );
		// add_filter( 'wp_dropdown_pages', array( $this, 'dropdown_pages_callback' ) );
	}

	function dropdown_pages_args_callback( $dropdown_args, $post ) {
		$this->is_parent_select_dropdown = true;
		$dropdown_args['post_type']      = 'fake_post_type';
		return $dropdown_args;
	}

	function dropdown_pages_callback( $output ) {
		if ( $this->is_parent_select_dropdown ) {
			$output = $this->get_replacement_output();
		}
		$this->is_parent_select_dropdown = false;
		return $output;
	}
	public function get_replacement_output() {
		global $post;
		$parent            = isset( $post->post_parent ) ? $post->post_parent : '';
		$parent_page_title = $parent
			? get_the_title( $parent )
			: '';
		// Do search w/ Ajax and populate these fields dynamically when a person starts typing
		return '
		<input type="hidden" name="parent_id" id="js-page-search" value="' . $parent . '"/>
		<input type="text" name="parent_page_title" id="js-page-search" value="' . $parent_page_title . '"/>
		';
	}

	/**
	 * Add a page to the dashboard menu.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function a_reveal_slides_dashboard() {
		global $reveal_slides_help_page;
		$slug                  = preg_replace( '/_+/', '-', __FUNCTION__ );
		$label                 = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
		$reveal_slides_help_page = add_dashboard_page( __( $label, 'reveal-with-wp' ), __( $label, 'reveal-with-wp' ), 'manage_options', $slug . '.php', array( $this, 'a_reveal_slides_response' ) );

		add_action( 'load-' . $reveal_slides_help_page, array( $this, 'admin_add_help_tab' ) );
	}

	/**
	 * Display the plugin reveal_slides message
	 */
	public function a_reveal_slides_response() {
		global $reveal_slides_help_page;
		echo '<div class="wrap">';
		echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';
		$response_tabs = new Reveal_Slides_Setup_Info();
		$hide_bouncing = get_user_meta( get_current_user_id(), 'hide_bouncing_arrow', true );
		if ( 'hide' !== $hide_bouncing ) {
			echo $hide_bouncing;
			$show_tabs = $response_tabs->reveal_slides_arrow();
		}
		// $get_settings  = $response_tabs->a_settings_page();
		$this->add_to_reveal_slides_dashboard();
		// $this->a_reveal_slides_footer();
		echo '</div>';
	}

	/**
	 * [a_reveal_slides_footer]
	 *
	 * @return [type] [description]
	 */
	public function a_reveal_slides_footer() {
		echo '<div id="' . preg_replace( '/_+/', '-', __FUNCTION__ ) . '">';
		echo '<h2>$reveal_slides_help_page <span style="color:salmon;"> = ' . $reveal_slides_help_page . '</span></h2>';
		echo '<h3>' . __FILE__ . '</h3>';
		echo '</div>';
	}


	/**
	 * Add a page to the dashboard menu.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_to_reveal_slides_dashboard() {
		// echo '<h2>' . basename( __FILE__ ) . __LINE__ . '</h2>';
	}

	/**
	 * [initialize_reveal_slides_scripts]
	 *
	 * @return [type] [description]
	 */
	public function initialize_reveal_slides_scripts() {
		wp_register_script( 'reveal-with-wp', plugins_url( 'js/reveal-with-wp.js', __DIR__ ), array( 'jquery' ), time(), true );
		wp_localize_script(
			'reveal-with-wp',
			'reveal_slides_object',
			array(
				'code_ajaxurl'      => admin_url( 'admin-ajax.php' ),
				'random_number'     => time(),
				'reveal_slides_nonce' => wp_create_nonce( 'reveal-with-wp-nonce' ),
				'explanation_one'   => 'Set up anything from the PHP side here in this function (' . __FUNCTION__ . '). Add the variable to the JS file.',
			)
		);
		wp_enqueue_script( 'reveal-with-wp' );
	}

	public function run_reveal_slides_function() {
		$return_data                      = $_POST;
		$post_7                           = get_post( 7 );
		$title                            = $post_7->post_title;
		$return_data['explanation_three'] = 'You can also add data here in this function (' . __FUNCTION__ . ') if you need javascript to help you calculate first.';
		echo '<pre>$return_data ';
		print_r( $return_data );
		echo '</pre>';
		exit();
	}

	/**
	 * Check the plugin activated transient exists if does then redirect
	 */
	public function reveal_slides_welcome() {
		if ( ! get_transient( 'reveal_slides_activated' ) ) {
			return;
		}

		// Delete the plugin activated transient
		delete_transient( 'reveal_slides_activated' );

		wp_safe_redirect(
			add_query_arg(
				array(
					'page' => 'reveal-with-wp-dashboard.php',
				),
				admin_url( 'index.php' )
			)
		);
		exit;
	}

	public function admin_add_help_tab() {
		global $reveal_slides_help_page;
		$screen = get_current_screen();
		if ( $screen->post_type != 'reveal_slides' ) {
			return;
		}
		// Add my_help_tab if current screen is My Admin Page
		$screen->add_help_tab(
			array(
				'id'      => 'reveal_slides_help_tab_1',
				'title'   => __( 'BigTime Info', 'reveal-with-wp' ),
				'content' => '<h3>' . __( 'Reveal SlidesBigTime Info', 'reveal-with-wp' ) . '</h3>' .
				'<p>' . print_r( $screen, true ) . __( 'Use this field to describe to the user what text you want on the help tab.', 'reveal-with-wp' ) . '</p>',
			)
		);
		$screen->add_help_tab(
			array(
				'id'      => 'reveal_slides_help_tab_2',
				'title'   => __( 'Reveal Slides Help Tab Two', 'reveal-with-wp' ),
				'content' => '<h3>' . __( 'Reveal Slides Help Tab', 'reveal-with-wp' ) . '</h3>' .
				'<p>' . __( 'Use this field to describe to the user what text you want on the help tab.', 'reveal-with-wp' ) . '</p>',
			)
		);
		$screen->add_help_tab(
			array(
				'id'      => 'reveal_slides_help_tab_3',
				'title'   => __( 'Request One', 'reveal-with-wp' ),
				'content' => '<h3>' . __( 'Scenario 1', 'reveal-with-wp' ) . '</h3>' .
				'<p>' . __( 'Marketing team members are having a hard time figuring out what page templates are being used on what pages. Write a plugin that lets authors easily see which template a page is using and also see only pages using a particular template.', 'reveal-with-wp' ) . '</p>',
			)
		);
		$screen->add_help_tab(
			array(
				'id'      => 'reveal_slides_help_tab_4',
				'title'   => __( 'Request Two', 'reveal-with-wp' ),
				'content' => '<h3>' . __( 'Reveal Slides Help Tab', 'reveal-with-wp' ) . '</h3>' .
				'<p>' . __( 'The stakeholders want to be able to get featured posts out of many of our blogs and online magazines so they can put the posts into a widget on the wpengine.com blog. Write a plugin for those WordPress sites that gives the post author a way to mark a post as "Featured on WP Engine\'s blog" and a way to get the 5 most recent featured posts out of the REST API.', 'reveal-with-wp' ) . '</p>',
			)
		);
	}

		/**
		 * Add slide ordering help to the help tab
		 */
	public static function admin_head() {
		$screen = get_current_screen();
		if ( $screen->id != 'edit-reveal_slides' ) {
			return;
		}
		$screen->add_help_tab(
			array(
				'id'      => 'reveal_slide_reordering_help_tab',
				'title'   => 'Reveal Slide Reordering',
				'content' => '<p>' . __( ' To reposition an item, simply drag and drop the row by "clicking and holding" it anywhere (outside of the links and form controls) and moving it to its new position.', 'reveal-slide-reordering' ) . '</p>',
			)
		);
	}

}
new Reveal_Help_Welcome_Menus();

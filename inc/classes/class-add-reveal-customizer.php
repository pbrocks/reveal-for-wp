<?php
/**
 * References
 * https://themefoundation.com/wordpress-theme-customizer/
 * https://divpusher.com/blog/wordpress-customizer-sanitization-examples#ddpages
 */
defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class Add_Reveal_Customizer {
	public static function init() {
		add_action( 'customize_register', array( __CLASS__, 'engage_the_customizer' ) );
		// add_action( 'wp_enqueue_scripts', array( __CLASS__, 'customizer_enqueue' ) );
		// add_filter( 'wp_enqueue_scripts', array( __CLASS__, 'set_customizer_preview_url' ) );
		add_action( 'wp', array( __CLASS__, 'show_admin_bar' ) );
	}

		/**
		 * Customizer manager demo
		 *
		 * @param  WP_Customizer_Manager $reveal_wp
		 * @return void
		 */
	public static function engage_the_customizer( $reveal_wp ) {
		// self::reveal_panel( $reveal_wp );
		self::reveal_section( $reveal_wp );
	}

	public static function customizer_enqueue() {
		?>
		<style type="text/css">
			#wpadminbar {
				/*display: none;*/
			}			
		</style>
		<?php
		wp_enqueue_style( 'customizer-section', plugins_url( 'css/customizer-section.css', dirname( __FILE__ ) ) );
	}


	/**
	 * [engage_customizer description]
	 *
	 * @param [type] $reveal_wp [description]
	 * @return [type]             [description]
	 */
	private static function reveal_panel( $reveal_wp ) {
		$reveal_wp->add_panel(
			'reveal_wp_panel', array(
				'priority' => 10,
				'capability' => 'edit_theme_options',
				'description' => 'Wnat to switch pages via javascript',
				'title' => __( 'Reveal Admin Panel', 'reveal-customizer' ),
			)
		);
	}

	/**
	 * The reveal_section function adds a new section
	 * to the Customizer to display the settings and
	 * controls that we build.
	 *
	 * @param  [type] $reveal_wp [description]
	 * @return [type]             [description]
	 */
	private static function reveal_section( $reveal_wp ) {
		$reveal_wp->add_section(
			'reveal_section', array(
				'title'          => 'Reveal Controls',
				'priority'       => 9,
				// 'panel'          => 'reveal_wp_panel',
				'description' => 'This is a description of this text setting in the Reveal Customizer Controls section of the Reveal panel',
			)
		);

		$reveal_wp->add_setting(
			'turn_off_admin_bar', array(
				'default'   => false,
				'type'      => 'option',
				// 'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				'transport' => 'refresh',
			)
		);

		// $reveal_wp->add_control(
		// 'turn_off_admin_bar', array(
		// 'label'     => __( 'Turn off Admin Bar on Reveal Page', 'reveal-customizer' ),
		// 'section'   => 'reveal_section',
		// 'priority'  => 10,
		// 'settings'  => 'turn_off_admin_bar',
		// 'type'      => 'checkbox',
		// )
		// );
		$reveal_wp->add_setting(
			'reveal_on_page', array(
				'default'   => '',
				'type'      => 'option',
				'transport' => 'refresh',
				'sanitize_callback' => 'absint',
			)
		);

		$reveal_wp->add_control(
			'reveal_on_page', array(
				'type'        => 'dropdown-pages',
				'label'       => 'Show Presentation on',
				'settings'    => 'reveal_on_page',
				'section'     => 'reveal_section',
				'description' => 'Select the page you wish to show your presention on',
			)
		);

		$reveal_wp->add_setting(
			'reveal_category', array(
				'type'      => 'option',
				'transport' => 'refresh',
				'default'   => '',
			)
		);

		$reveal_wp->add_control(
			'reveal_category', array(
				// https://www.cssigniter.com/wordpress-customizer-custom-controls-categories-dropdown/
				// 'type'        => 'dropdown-category',
				'type'        => 'text',
				'label'       => 'Present from',
				'settings'    => 'reveal_category',
				'section'     => 'reveal_section',
				'description' => 'Select the page you wish to show your presention on',
			)
		);

		$reveal_wp->add_setting(
			'reveal_theme_css', array(
				'type'      => 'option',
				'transport' => 'refresh',
				'default'   => '',
			)
		);

		foreach ( glob( plugin_dir_path( dirname( __DIR__ ) ) . 'reveal-js/css/theme/*.css' ) as $css ) {
			$return_css[ basename( $css ) ] = basename( $css );
		}

		$reveal_wp->add_control(
			'reveal_theme_css', array(
				'section'     => 'reveal_section',
				'type'        => 'select',
				'settings'    => 'reveal_theme_css',
				'label'       => 'Reveal CSS',
				'description' => 'Select the css theme for displaying your presentation',
				'choices'     => $return_css,
				'priority'    => 14,
			)
		);

		$reveal_wp->add_setting(
			'final_reveal_template', array(
				'type'      => 'option',
				'transport' => 'refresh',
				'default'   => '',
			)
		);

		foreach ( glob( plugin_dir_path( __DIR__ ) . 'templates/*.php' ) as $file ) {
			// echo '<option>' . basename( $file ) . '</option>';
			$return[ basename( $file ) ] = basename( $file );
		}

		$reveal_wp->add_control(
			'final_reveal_template', array(
				'section'     => 'reveal_section',
				'type'        => 'select',
				'settings'    => 'final_reveal_template',
				'label'       => 'Final Reveal Template',
				'description' => 'Select the template displaying your presentation',
				'choices'     => $return,
				'priority'    => 11,
			)
		);

	}

	public static function show_admin_bar( $reveal_wp ) {
		global $post;

		if ( is_page( intval( get_option( 'reveal_on_page' ) ) ) ) {
			/* '1' === get_option( 'turn_off_admin_bar' ) && */

			// disable the admin bar
			add_filter( 'show_admin_bar', '__return_false' );
		}
	}

	public static function create_customizer_dev_page( $reveal_wp ) {

		$customizer_dev_page = 'Customizer Dev Page';
		$customizer_dev_page_content = self::return_something();
		$author_id = get_current_user();

		$check_page = get_page_by_title( $customizer_dev_page );
		if ( null == $check_page ) {
			$my_post = array(
				'post_title'    => wp_strip_all_tags( $customizer_dev_page ),
				// $slug = 'wordpress-post-created-with-code';
				'post_content'  => $customizer_dev_page_content,
				'post_status'   => 'publish',
				'post_type'     => 'page',
				'post_author'   => $author_id,
			// 'post_category' => array( 8,39 ),
			);

			wp_insert_post( $my_post );
		}
	}


	public static function set_customizer_preview_url() {
		global $wp_customize;
		$reveal_page_id = intval( get_option( 'reveal_on_page' ) );

		if ( ! isset( $_GET['url'] ) ) {
			$wp_customize->set_preview_url( get_permalink( $reveal_page_id ) );
		}
	}
	// checkbox sanitization function
	public static function sanitize_checkbox( $input ) {
		// returns true if checkbox is checked
		return ( isset( $input ) ? true : false );
	}

	/**
	 * A section to show how you use the default customizer controls in WordPress
	 *
	 * @param  Obj $reveal_wp - WP Manager
	 *
	 * @return Void
	 */
	private static function sanitize_select_slug( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

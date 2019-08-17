<?php

class Reveal_Slides_Setup_Info {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'initialize_template_request_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'initialize_template_request_scripts' ) );
		add_action( 'wp_ajax_page_template_request', array( $this, 'run_template_request_function' ) );
		add_action( 'wp_ajax_nopriv_hide_arrow_request', array( $this, 'run_template_request_function' ) );
		add_action( 'wp_ajax_hide_arrow_request', array( $this, 'run_hide_arrow_function' ) );
		add_action( 'wp_ajax_nopriv_page_hide_arrow', array( $this, 'run_hide_arrow_function' ) );
		add_action( 'init', array( $this, 'reveal_slides_admin_init' ) );
		// add_action( 'admin_menu', array( $this, 'reveal_slides_settings_page_init' ) );
	}
	/**
	 * [reveal_slides_footer]
	 *
	 * @return [type] [description]
	 */
	public function reveal_slides_footer() {
		echo '<div id="' . preg_replace( '/_+/', '-', __FUNCTION__ ) . '">';
		echo '<h3>' . __FILE__ . __LINE__ . '</h3>';
		echo '</div>';
	}
	public function delete_reveal_slides_tab_settings_page() {
		global $pagenow;
		$settings    = get_option( 'pbrx_tabbed_settings' );
		$plugin_data = $this->get_reveal_slides_setup_data();
		?>
	
	<div class="wrap">
		<h2><?php echo $plugin_data['Name']; ?> Settings</h2>
		<style type="text/css">
		h1, p {
			margin: 0 0 1em 0;
		}

		/* no grid support? */
		.sidebar {
			float: left;
			/*width: 19.1489%;*/
		}

		.content {
			float: right;
			/*width: 79.7872%;*/
		}

		/* make a grid */
		.grid-wrapper {
			/*max-width: 940px;*/
			margin: 0 auto;
			display: grid;
			grid-template-columns: 1fr 4fr;
			grid-gap: .5rem;
		}

		.grid-wrapper > * {
			background-color: mintcream;
			color: maroon;
			border-radius: .2rem;
			padding: 1rem;
			font-size: 150%;
			/* needed for the floated layout*/
			margin-bottom: .5rem;
		}

		.header, .footer {
			grid-column: 1 / -1;
			/* needed for the floated layout */
			clear: both;
		}


		/* We need to set the widths used on floated items back to auto, and remove the bottom margin as when we have grid we have gaps. */
		@supports (display: grid) {
			.grid-wrapper > * {
				width: auto;
				margin: 0;
			}
		}
	</style>
		<?php
		if ( 'true' == esc_attr( $_GET['updated'] ) ) {
			echo '<div class="updated" ><p> Settings updated.</p></div>';
		}

		if ( isset( $_GET['tab'] ) ) {
			pbrx_admin_tabs( $_GET['tab'] );
		} else {
			pbrx_admin_tabs( 'homepage' );
		}
		?>

	<div id="poststuff">
		<div class="grid-wrapper">
			<header class="header">My header</header>
			<form method="post" action="<?php admin_url( 'edit.php?post_type=reveal_slides&page=reveal-dashboard.php' ); ?>">
				<?php
				wp_nonce_field( 'pbrx-settings-page' );

				if ( $pagenow == 'edit.php' && $_GET['page'] == 'reveal-dashboard.php' ) {

					if ( isset( $_GET['tab'] ) ) {
						$tab = $_GET['tab'];
					} else {
						$tab = 'homepage';
					}

					echo '<table class="form-table">';
					switch ( $tab ) {
						case 'general':
							?>

						<aside class="sidebar">Sidebar<label for="pbrx_tag_class">Tags with CSS classes:</label></aside>						
						<article class="content">
							<h1>2 column, header and footer</h1>
							<p>
								<input id="pbrx_tag_class" name="pbrx_tag_class" type="checkbox" 
								<?php
								if ( $settings['pbrx_tag_class'] ) {
									echo 'checked="checked"';}
								?>
									value="true" /> 
									<span class="description">Output each post tag with a specific CSS class using its slug.</span>
								</p>
							</article>
							<?php
							break;
						case 'footer':
							?>
							<aside class="sidebar">Sidebar<label for="pbrx_ga">Insert tracking code:</label></aside>						
							<article class="content">
								<h1>2 column, header and footer</h1>
								<p>
									<textarea id="pbrx_ga" name="pbrx_ga" cols="60" rows="5"><?php echo esc_html( stripslashes( $settings['pbrx_ga'] ) ); ?></textarea><br/>
									<span class="description">Enter your Google Analytics tracking code:</span>
								</p>
							</article>
							<?php
							break;
						case 'homepage':
							?>
							<aside class="sidebar">Sidebar<label for="pbrx_intro">Introduction</label></aside>						
							<article class="content">
								<h1>2 column, header and footer</h1>
								<p>
									<textarea id="pbrx_intro" name="pbrx_intro" cols="60" rows="5" ><?php echo esc_html( stripslashes( $settings['pbrx_intro'] ) ); ?></textarea><br/>
									<span class="description">Enter the introductory text for the home page:</span>
								</p>
							</article>
							<?php
							break;
					}
						echo '</table>';
				}
				?>
					<footer class="footer">My footer
						<p class="submit" style="clear: both;">
							<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
							<input type="hidden" name="pbrx-settings-submit" value="Y" />
						</p>
					</footer>
				</form>
			</div>
		</div>
	</div>
		<?php
	}

	/**
	 * [initialize_template_request_scripts]
	 *
	 * @return [type] [description]
	 */
	public function initialize_template_request_scripts() {
		wp_register_script( 'page-template-request', plugins_url( 'js/page-template-request.js', __DIR__ ), array( 'jquery' ), time(), true );
		wp_localize_script(
			'page-template-request',
			'template_request_object',
			array(
				'template_request_ajaxurl' => admin_url( 'admin-ajax.php' ),
				'template_request_nonce'   => wp_create_nonce( 'page-template-request-nonce' ),
			)
		);
		wp_enqueue_script( 'page-template-request' );

		wp_register_script( 'hide-indexing-arrow', plugins_url( 'js/hide-indexing-arrow.js', __DIR__ ), array( 'jquery' ), time(), true );
		wp_localize_script(
			'hide-indexing-arrow',
			'hide_indexing_arrow',
			array(
				'hide_arrow_ajaxurl' => admin_url( 'admin-ajax.php' ),
				'hide_arrow_nonce'   => wp_create_nonce( 'hide-indexing-arrow-nonce' ),
			)
		);
		wp_enqueue_script( 'hide-indexing-arrow' );
		wp_register_style( 'wp-admin-grid', plugins_url( 'css/wp-admin-grid.css', __DIR__ ), time() );
		wp_enqueue_style( 'wp-admin-grid' );
	}

	public function run_template_request_function() {
		global $template;
		$return_data                  = $_POST;
		$return_data['page_template'] = ( get_post_meta( $_POST['returned_id'], '_wp_page_template', true ) ?: 'the default template' );
		// echo '<pre>$return_data ';
		// print_r( $return_data );
		echo json_encode( $return_data );
		// echo '</pre>';
		exit();
	}

	public function run_hide_arrow_function() {
		$return_data                = $_POST;
		$return_data['hide_arrow2'] = $_POST['hide_arrow'];
		update_user_meta( get_current_user_id(), 'hide_bouncing_arrow', $_POST['hide_arrow'] );
		echo '<pre>$return_data ';
		print_r( $return_data );
		echo '</pre>';
		exit();
	}

	public function reveal_slides_admin_init() {
		$settings = get_option( 'reveal_slides_tabbed_settings' );
		if ( empty( $settings ) ) {
			$settings = array(
				'reveal_slides_intro'     => 'Some intro text for the home page',
				'reveal_slides_tag_class' => false,
				'reveal_slides_ga'        => false,
			);
			add_option( 'reveal_slides_tabbed_settings', $settings, '', 'yes' );
		}
	}

	public function reveal_slides_settings_page_init() {
		$plugin_data   = $this->get_reveal_slides_setup_data();
		$settings_page = add_dashboard_page( $plugin_data['Name'] . ' Settings ' . __LINE__, $plugin_data['Name'] . ' Settings', 'manage_options', 'wp-admin-grid-dashboardd.php', [ $this, 'reveal_slides_settings_page' ] );
		$settings_page = 'a-reveal-slides-dashboard.php';
		add_action( "load-{$settings_page}", array( $this, 'reveal_slides_load_settings_page' ) );
	}

	public function reveal_slides_load_settings_page() {
		// $response_tabs = new Reveal_Slides_Setup_Info();
		$hide_bouncing = get_user_meta( get_current_user_id(), 'hide_bouncing_arrow', true );
		if ( 'hide' !== $hide_bouncing ) {
			echo $hide_bouncing;
			$show_arrow = $this->reveal_slides_arrow();
		}
		if ( $_POST['wpe-settings-submit'] == 'Y' ) {
			check_admin_referer( 'wpe-settings-page' );
			$this->reveal_slides_save_tabbed_settings();
			$url_parameters = isset( $_GET['tab'] ) ? 'updated=true&tab=' . $_GET['tab'] : 'updated=true';
			wp_redirect( admin_url( 'index.php?page=wp-admin-grid-dashboard.php&' . $url_parameters ) );
			exit;
		}
	}

	public function reveal_slides_save_tabbed_settings() {
		global $pagenow;
		$settings = get_option( 'reveal_slides_tabbed_settings' );

		if ( $pagenow == 'index.php' && $_GET['page'] == 'theme-settings' ) {
			if ( isset( $_GET['tab'] ) ) {
				$tab = $_GET['tab'];
			} else {
				$tab = 'overview';
			}

			switch ( $tab ) {
				case 'scenario1a':
					$settings['reveal_slides_tag_class'] = $_POST['reveal_slides_tag_class'];
					break;
				case 'scenario1b':
					$settings['reveal_slides_tag_class'] = $_POST['reveal_slides_tag_class'];
					break;
				case 'scenario2':
					$settings['reveal_slides_ga'] = $_POST['reveal_slides_ga'];
					break;
				case 'overview':
					$settings['reveal_slides_intro'] = $_POST['reveal_slides_intro'];
					break;
			}
		}
		if ( ! current_user_can( 'unfiltered_html' ) ) {
			if ( $settings['reveal_slides_ga'] ) {
				$settings['reveal_slides_ga'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['reveal_slides_ga'] ) ) );
			}
			if ( $settings['reveal_slides_intro'] ) {
				$settings['reveal_slides_intro'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['reveal_slides_intro'] ) ) );
			}
		}

		$updated = update_option( 'reveal_slides_tabbed_settings', $settings );
	}

	public function reveal_slides_admin_tabs( $current = 'overview' ) {
		$tabs  = array(
			'overview'   => 'Overview',
			'background' => 'Background',
			'scenario1a' => 'Scenario 1a',
			'scenario1b' => 'Scenario 1b',
			'scenario2'  => 'Scenario 2',
		);
		$links = array();
		echo '<div id="icon-themes" class="icon32"><br></div>';
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $tabs as $tab => $name ) {
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='?page=wp-admin-grid-dashboard.php&tab=$tab'>$name</a>";

		}
		echo '</h2>';
	}

	public function get_reveal_slides_setup_data() {
		$plugin_data['Name'] = 'Reveal Slides';
		return $plugin_data;
	}

	public function reveal_slides_settings_page() {
		global $pagenow, $template;
		$settings = get_option( 'reveal_slides_tabbed_settings' );
		?>
	
	<div class="tabs-wrap">	
		<?php
		if ( 'true' == esc_attr( $_GET['updated'] ) ) {
			echo '<div class="updated" ><p> Settings updated.</p></div>';
		}

		if ( isset( $_GET['tab'] ) ) {
			$this->reveal_slides_admin_tabs( $_GET['tab'] );
		} else {
			$this->reveal_slides_admin_tabs( 'overview' );
		}
		?>

	<div id="poststuff">
		<!-- <div class="grid-wrapper"> -->
			<!-- <header class="header">My header</header> -->
			<?php
			if ( $pagenow == 'index.php' && $_GET['page'] == 'wp-admin-grid-dashboard.php' ) {

				if ( isset( $_GET['tab'] ) ) {
					$tab = $_GET['tab'];
				} else {
					$tab = 'overview';
				}

				// echo '<table class="form-table">';
				switch ( $tab ) {
					case 'background':
						?>
							<grid-cell class="grid-head-label">
								<h2 class="description">WPE Code Challenge</h2>
							</grid-cell>						
							<grid-cell class="content">
								<p class="description">Thought process behind the code rendering these screens:</p>
								<p>Although there were two questions, the first has two parts itself, so I split them up. The following three (3) tabs will address each task individually.</p>
								<p>To begin, however, I want to mention that I built this plugin so that when it is activated, the user is taken to this welcome screen with five (5) tabs. Since the theme of this challenge is to assist authors, I also placed a bouncing arrow to indicate where the author could go to find more help on a topic. If a user closes the arrow by clicking on the X, the action is recorded in usermeta and won't show up again.</p>
							</grid-cell>
						<?php
						break;
					case 'scenario1a':
						?>
							<grid-cell class="grid-head-label">
								<h2 class="description">Scenario 1a</h2>
							</grid-cell>						
							<grid-cell class="content">
							<p class="description">Task 1a: 
								 <strong>Write a plugin that lets authors easily see which template a page is using</strong> and also see only pages using a particular template.
							</p>
							<p>For authors to quickly see what template a page is using, I added a node to the WP Admin Bar that shows the full path of the template. I did this in case a plugin is creating the page template. Note: some themes don't use page templates as extensively as before in WordPress. In fact, the default Twentynineteen theme doesn't have any page templates, but I added one called <em>Second</em> for demonstration purposes. This screencast shows the interface for authors on the frontend.</p>
							<div><img src="<?php echo plugins_url( 'images/page-templates.gif', dirname( __DIR__ ) ); ?>" />
							</div>
							<p>If this welcome screen were converted to a help area, we could have a dropdown selector to show the template used for each individual page, such as:</p>
							<p>
						<?php
						$args = array(
							'echo'             => 1,
							'name'             => 'page_id',
							'id'               => 'page_id',
							'show_option_none' => 'Select a Page',
						);
						?>
	<form id="get-template-form" method="post">
						<?php wp_dropdown_pages( $args ); ?>
	</form>
	<div id="return-page-template"></div>
								</p>
							<p>Again, this may not be very revealing if the current theme isn't using page templates.</p>
							</grid-cell>
							<?php
						break;
					case 'scenario1b':
						?>
							<grid-cell class="grid-head-label">
								<h2 class="description">Scenario 1b</h2>
							</grid-cell>						
							<grid-cell class="content">
								<p class="description">Task 1b: Write a plugin that lets authors easily see which template a page is using and also see <strong>only pages using a particular template</strong>.
								</p>
								<p>For this part of the task, I first checked the which pages were using a page template by checking for the meta key <em>_wp_page_template</em>, like this<xmp>
	$args  = array(
		'meta_key'    => '_wp_page_template',
		'meta_value'  => '',
		'post_type'   => 'page',
		'post_status' => 'publish',
	);
	$pages = get_pages( $args );
	</xmp>
	which gives me an array like this:
	<xmp>
	$page_templates used Array
	(
		[0] => fluid-width.php
		[1] => page-second.php
		[2] => page-second.php
		[3] => interstitial.php
		[4] => page-second.php
	)
	</xmp>
Your setup will render differently based on the values of your post meta. The following code will show what page template you have in your set up.</p>
							<?php
							$args  = array(
								'meta_key'    => '_wp_page_template',
								'meta_value'  => '',
								'post_type'   => 'page',
								'post_status' => 'publish',
							);
							$pages = get_pages( $args );
							foreach ( $pages as $key => $page_value ) {
								$page                                = get_post( $page_value );
								$iidd                                = $page->ID;
								$this_page[ $iidd ]['id']            = $page->ID;
								$this_page[ $iidd ]['page_template'] = $page->meta_value;
								$this_page[ $iidd ]['post_title']    = $page->post_title;
								$page_templates[]                    = basename( $page->meta_value );
							}
							echo '<pre>$page_templates used ';
							print_r( $page_templates );
							echo '</pre>';
							?>
							<p>Looking at all of the pages on your site, you will see the page id, page name, and the page template used. If the default is used, the following code will return <em>page.php</em></p>
							<?php
							$all_pages = get_pages();
							foreach ( $all_pages as $key => $page_value ) {
								$tmpl = basename( $this_page[ $page_value->ID ]['page_template'] ) ?: 'page.php';
								echo '<h4>' . $page_value->ID . ' | ' . $page_value->post_title . ' | ' . $tmpl . '</h4>';
							}
							?>
							</grid-cell>
								<?php
						break;
					case 'scenario2':
						?>
							<grid-cell class="grid-head-label">
								<h2 class="description">WPE Code Challenge</h2>
							</grid-cell>						
							<grid-cell class="content">
								<h3>Scenario two</h3>
								<p>Scenario two
								5 most recent featured posts out of the REST API.</p>
								<p>To display Featured Posts from other blogs, I used the REST API to get posts from the Torque Mag site. I checked for the category of <em>Featured</em> and only rendered from there. The result looks like this:</p>
							<div><img width="88%" src="<?php echo plugins_url( 'images/widget-frontend.png', dirname( __DIR__ ) ); ?>" />
							</div>
							<p>On the backend, you can select the number of posts to show, the default being 5, as well as choose to show the date and/or excerpt of the post.</p>
							<div><img width="88%" src="<?php echo plugins_url( 'images/widget-backend.png', dirname( __DIR__ ) ); ?>" />
							</grid-cell>
						<?php
						break;
					case 'overview':
						?>
							<grid-cell class="grid-head-label">
								<h2 class="description">WPE Code Challenge</h2>
							</grid-cell>					
							<grid-cell class="content">
								<p>
									We'd like you to come up with solutions to a couple of user stories that are similar to the work we do every day. Given each of the scenarios below, develop a solution that is simple, scalable, and easily maintainable. Leverage core WordPress features when appropriate. And pull in libraries if needed (and only if needed).</p>
								<ol>
									<li>Marketing team members are having a hard time figuring out what page templates are being used on what pages. Write a plugin that lets authors easily see which template a page is using and also see only pages using a particular template.</li>

									<li>The stakeholders want to be able to get featured posts out of many of our blogs and online magazines so they can put the posts into a widget on the wpengine.com blog. Write a plugin for those WordPress sites that gives the post author a way to mark a post as "Featured on WP Engine's blog" and a way to get the 5 most recent featured posts out of the REST API.</li>
								</ol>
							</grid-cell>
						<?php
						break;
				}
							// echo '</table>';
			}
			?>
		</div>
	</div>
		<?php
	}

	/**
	 * Display the plugin code_sample bouncing arrow
	 */
	public function reveal_slides_arrow() {
		global $code_sample_help_page;
		?>
	<div id="bouncing-arrow">
		<div id="close-arrow-x">x</div>
		<div class="arrow-container">
			<div class="arrow-footer">
				<svg class="arrow-circle-down bounce" viewbox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
				<path d="M1412 897q0-27-18-45l-91-91q-18-18-45-18t-45 18l-189 189v-502q0-26-19-45t-45-19h-128q-26 0-45 19t-19 45v502l-189-189q-19-19-45-19t-45 19l-91 91q-18 18-18 45t18 45l362 362 91 91q18 18 45 18t45-18l91-91 362-362q18-18 18-45zm252-1q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z" fill="#fff"></path></svg>
			</div>
		</div>
	</div>
		<?php
	}
}
new Reveal_Slides_Setup_Info();

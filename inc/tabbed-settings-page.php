<?php

/**
 * Tabbed Settings Page
 */

add_action( 'init', 'pbrx_admin_init' );
add_action( 'admin_menu', 'pbrx_settings_page_init' );
function pbrx_admin_init() {
	$settings = get_option( 'pbrx_tabbed_settings' );
	if ( empty( $settings ) ) {
		$settings = array(
			'pbrx_intro' => 'Some intro text for the home page',
			'pbrx_tag_class' => false,
			'pbrx_ga' => false,
		);
		add_option( 'pbrx_tabbed_settings', $settings, '', 'yes' );
	}
}

function pbrx_settings_page_init() {
	$plugin_data = get_pbrx_setup_data();
	$settings_page = add_dashboard_page( $plugin_data['Name'] . ' Settings', $plugin_data['Name'] . ' Settings', 'manage_options', 'pbrocks-settings', 'pbrx_settings_page' );
	$settings_page = 'reveal-dashboard.php';
	add_action( "load-{$settings_page}", 'pbrx_load_settings_page' );
}

function pbrx_load_settings_page() {
	if ( $_POST['pbrx-settings-submit'] == 'Y' ) {
		check_admin_referer( 'pbrx-settings-page' );
		pbrx_save_tabbed_settings();
		$url_parameters = isset( $_GET['tab'] ) ? 'updated=true&tab=' . $_GET['tab'] : 'updated=true';
		wp_redirect( admin_url( 'edit.php?post_type=reveal_slides?page=reveal-dashboard.php&' . $url_parameters ) );
		exit;
	}
}

function pbrx_save_tabbed_settings() {
	global $pagenow;
	$settings = get_option( 'pbrx_tabbed_settings' );

	if ( $pagenow == 'edit.php?post_type=reveal_slides' && $_GET['page'] == 'reveal-dashboard.php' ) {
		if ( isset( $_GET['tab'] ) ) {
			$tab = $_GET['tab'];
		} else {
			$tab = 'homepage';
		}

		switch ( $tab ) {
			case 'general':
				$settings['pbrx_tag_class']   = $_POST['pbrx_tag_class'];
				break;
			case 'footer':
				$settings['pbrx_ga']  = $_POST['pbrx_ga'];
				break;
			case 'homepage':
				$settings['pbrx_intro']   = $_POST['pbrx_intro'];
				break;
		}
	}
	if ( ! current_user_can( 'unfiltered_html' ) ) {
		if ( $settings['pbrx_ga'] ) {
			$settings['pbrx_ga'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['pbrx_ga'] ) ) );
		}
		if ( $settings['pbrx_intro'] ) {
			$settings['pbrx_intro'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['pbrx_intro'] ) ) );
		}
	}

	$updated = update_option( 'pbrx_tabbed_settings', $settings );
}

function pbrx_admin_tabs( $current = 'homepage' ) {
	$tabs = array(
		'homepage' => 'Home',
		'general' => 'General',
		'footer' => 'Footer',
	);
	$links = array();
	echo '<div id="icon-themes" class="icon32"><br></div>';
	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $tabs as $tab => $name ) {
		$class = ( $tab == $current ) ? ' nav-tab-active' : '';
		echo "<a class='nav-tab$class' href='?page=reveal-dashboard.php&tab=$tab'>$name</a>";

	}
	echo '</h2>';
}

function get_pbrx_setup_data() {
	$plugin_data['Name'] = 'PBRocks';
	return $plugin_data;
}
function pbrx_settings_page() {
	global $pagenow;
	$settings = get_option( 'pbrx_tabbed_settings' );
	$plugin_data = get_pbrx_setup_data();
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

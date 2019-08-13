<?php
/**
 * Reveal Page template
 */
// get_header();
wp_head();
	$slides = new WP_Query(
		array(
			'post_type'    => array( 'reveal_slides' ),
			'category__in' => get_option( 'reveal_category' ),
			'order'        => 'ASC',
			'orderby'      => 'menu_order',
		)
	);
	// $slides->posts[0]->post_title;
	$count     = count( $slides->posts );
	$i         = 1;
	$step_menu = ' | ';
	while ( $i <= $count ) {
		$step_menu .= $i . ' | ';
		$i++;
	}
	?>
<!doctype html>
<html lang="en">

  <head>
	<meta charset="utf-8">

	<title><?php echo get_the_title(); ?></title>

	<meta name="description" content="A framework for easily creating beautiful presentations using HTML">
	<meta name="author" content="Hakim El Hattab">

	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
	<?php $theme_css = get_option( 'reveal_theme_css' ); ?>
	<link rel="stylesheet" href="<?php echo REVEAL_JS; ?>/css/reveal.css">
	<link rel="stylesheet" href="<?php echo REVEAL_JS; ?>/css/theme/<?php echo ( $theme_css ? $theme_css : 'sky-too.css' ); ?>" id="theme">
	<link rel="stylesheet" href="<?php echo plugins_url( 'inc/css/reveal-pbrocks.css', dirname( __DIR__ ) ); ?>">

	<!-- Code syntax highlighting -->
	<link rel="stylesheet" href="<?php echo REVEAL_JS; ?>/lib/css/zenburn.css">
  </head>

  <body>
<?php
$posts_array                  = $slides->posts;
$reveal_page_id               = intval( get_option( 'reveal_on_page' ) );
$presenting_on                = get_post( $reveal_page_id );
$reveal_presentation_title    = get_post_meta( $reveal_page_id, 'reveal_presentation_title', true );
$reveal_presenter_name        = get_post_meta( $reveal_page_id, 'reveal_presenter_name', true );
$reveal_presenter_affiliation = get_post_meta( $reveal_page_id, 'reveal_presenter_affiliation', true );
$reveal_notes                 = get_post_meta( $reveal_page_id, 'reveal_notes', true );
?>
	<div class="reveal">
	  <div class="slides">
		<section class="title-slide">
			<h1 id="block-name"><?php echo $reveal_presentation_title; ?></h1>
			<?php /* echo plugins_url( 'inc/css/reveal-pbrocks.css', dirname( __DIR__ ) ); */ ?>
			<div class="slide-content">
				<h3><?php echo $reveal_presenter_name; ?></h3>
				<h3><?php echo $reveal_presenter_affiliation; ?></h3>
			</div>
			<p><br><br></p>
			<aside class="notes">
				<?php
				if ( ! empty( $reveal_notes ) ) {
					echo $reveal_notes;
				}
				?>
			</aside>
		</section>
		<?php
		$slides       = Build_Reveal_Slides::build_the_query();
		$presentation = '';
		foreach ( $slides->posts as $key => $value ) {
			$notes         = get_post_meta( $value->ID, 'reveal_notes', true );
			$presentation .= '<section><h2 id="block-name">' . $value->post_title . '</h2>';

			$presentation .= '<div id="block-content" class="slide-content">';
			if ( has_post_thumbnail( $value->ID ) ) {
				$presentation .= '<div id="slide-image" >' . get_the_post_thumbnail( $value->ID, 'full', array( 'class' => 'aligncenter' ) ) . '</div>';
			} else {
				$presentation .= $value->post_content;
			}
			$presentation .= '</div><aside class="notes">' . ( $notes ? esc_html( $notes ) : 'nada' ) . '</aside></section>';
		}
		echo $presentation;
		?>
		<section class="final-slide">
			<h1 id="presenter-name"><?php echo $reveal_presenter_name; ?></h1>

			<div class="slide-content">
				<h3><?php echo $reveal_presentation_title; ?></h3>
				<h3><?php echo $reveal_presenter_affiliation; ?></h3>
			</div>
			<p><br><br></p>
			<aside class="notes">
				<?php
				if ( ! empty( $reveal_notes ) ) {
					echo $reveal_notes;
				}
				?>
			</aside>
		</section>
		<?php wp_reset_postdata(); ?>
		</div>
	</div>

	<script src="<?php echo REVEAL_JS; ?>/lib/js/head.min.js"></script>
	<script src="<?php echo REVEAL_JS; ?>/js/reveal.js"></script>

	<script>
	Reveal.initialize({
		controls: true,
		progress: true,
		history: true,
		center: true,
		slideNumber: true,

		transition: 'slide', // none/fade/slide/convex/concave/zoom

				previewLinks: true,
		menu: { // Menu works best with font-awesome installed: sudo apt-get install fonts-font-awesome
			themes: true,
			themesPath: '<?php echo REVEAL_JS; ?>/lib/reveal.js/css/theme/',
			transitions: false,
			markers: true,
			hideMissingTitles: true,
			keyboard: true,
			custom: [
					{ title: 'Plugins', icon: '<i class="fa fa-external-link"></i>', src: 'toc.html' },
					{ title: 'About', icon: '<i class="fa fa-info"></i>', src: 'about.html' }
				]
		},


		// Optional reveal.js plugins
		dependencies: [
			{ src: '<?php echo REVEAL_JS; ?>/plugin/notes/notes.js', async: true },
			
		]
	  });

	</script>
<?php
	wp_footer();
?>
  </body>
</html>

<?php
/**
 * Reveal Page template
 */
// get_header();
wp_head();
	$slides = new WP_Query(
		array(
			'post_type'  => array( 'reveal_slides' ),
			'order'      => 'ASC',
			'orderby'    => 'menu_order',
		)
	);
	// $slides->posts[0]->post_title;
	$count = count( $slides->posts );
	$i = 1;
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

	<link rel="stylesheet" href="<?php echo REVEAL_JS; ?>/css/reveal.css">
	<link rel="stylesheet" href="<?php echo REVEAL_JS; ?>/css/theme/sky.css" id="theme">

	<!-- Code syntax highlighting -->
	<link rel="stylesheet" href="<?php echo REVEAL_JS; ?>/lib/css/zenburn.css">
  </head>

  <body>
<?php $posts_array = $slides->posts; ?>
	<div class="reveal">
	  <div class="slides">
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
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Previous', 'domain' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Next <span class="meta-nav">&rarr;</span>', 'domain' ) ); ?></div>
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
		<section>
			<section>
				<p>Reveal.js is great in showing slides in the same way on different screens with different sizes and aspect ratios.</p>
			</section>
			<section>
				<p>However, by default not all of the screen can be used for presentation.</p>
			</section>
			<section>
				<p>Sometimes you want to use all of the screen and this plugin allows you to.</p>
			</section>
			<section>
				<p>Just include the <code>data-fullscreen</code> attribute to the section tag and the slide will use the entire screen.</p>
			</section>
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
			themes: false,
			transitions: false,
			markers: true,
			hideMissingTitles: true,
			keyboard: true,
			custom: [
		            { title: 'Plugins', icon: '<i class="fa fa-external-link"></i>', src: 'toc.html' },
		            { title: 'About', icon: '<i class="fa fa-info"></i>', src: 'about.html' }
		        ]
		},
		// menu: {
		// 	numbers: true,
		// 	openSlideNumber: true,
		// 	themes: true,
		// 	themesPath: '<?php echo REVEAL_JS; ?>/lib/reveal.js/css/theme/',
		// 	transitions: true,
	 //        custom: [
	 //            { title: 'Custom', icon: '<i class="fa fa-bookmark">', src: 'links.html' },
	 //        ]
		// },

		// Optional reveal.js plugins
		dependencies: [
			{ src: '<?php echo REVEAL_JS; ?>/plugin/notes/notes.js', async: true },
			{ src: '<?php echo REVEAL_JS; ?>/plugin/menu/menu.js', async: true }
		]
	  });

	</script>
<?php
	wp_footer();
?>
  </body>
</html>

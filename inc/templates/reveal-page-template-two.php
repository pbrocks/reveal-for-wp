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
<!DOCTYPE html>
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
		<?php wp_reset_postdata(); ?>
		</div>
	</div>

	<script src="<?php echo REVEAL_JS; ?>/lib/js/head.min.js"></script>
	<script src="<?php echo REVEAL_JS; ?>/js/reveal.js"></script>

	<script>

	  // Full list of configuration options available at:
	  // https://github.com/hakimel/reveal.js#configuration
	  Reveal.initialize({
		controls: true,
		progress: true,
		history: true,
		center: true,

		transition: 'slide', // none/fade/slide/convex/concave/zoom

		// Optional reveal.js plugins
		dependencies: [
		  { src: '<?php echo REVEAL_JS; ?>/lib/js/classList.js', condition: function() { return !document.body.classList; } },
		  { src: '<?php echo REVEAL_JS; ?>/plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
		  { src: '<?php echo REVEAL_JS; ?>/plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
		  { src: '<?php echo REVEAL_JS; ?>/plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
		  { src: '<?php echo REVEAL_JS; ?>/plugin/zoom-js/zoom.js', async: true },
		  { src: '<?php echo REVEAL_JS; ?>/plugin/notes/notes.js', async: true }
		]
	  });

	</script>
<?php
	wp_footer();
?>
  </body>
</html>

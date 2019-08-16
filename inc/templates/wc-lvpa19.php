<?php
/**
 * Reveal Page template
 */
// get_header();
wp_head();
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
	<link rel="stylesheet" href="<?php echo plugins_url( 'inc/css/reveal-pbrocks.css', dirname( __DIR__ ) ); ?>">
  </head>
	<div class="reveal">
	  <div class="slides">
			<section>
				<h1>WordPress Plugin Architecture</h1>
				<h3>Paul Barthmaier</h3>
				<p>
					<small><i class="fa fa-twitter"></i> <a href="//twitter.com/_pbrocks">@_pbrocks</a></small>
				</p>
			</section>
			<!-- Example of nested vertical slides -->
			<section>
				<section id="vertical">
					<h2>Vertical Slides</h2>
					<h4>Top Level Slide</h4>
					<p><i class="fa fa-coffee"></i> Slides can be nested inside of each other.</p>
					<p><i class="fa fa-rocket fa-spin"></i> Use the <em>Space</em> key to navigate through all slides. </p>
					<br>
					<a href="#" class="navigate-down">
						<img width="178" height="238" data-src="https://s3.amazonaws.com/hakim-static/reveal-js/arrow.png" alt="Down arrow">
					</a>
				</section>
				<section id="vertical-1">
					<h2>Vertical Level -1</h2>
					<p>Nested slides are useful for adding additional detail underneath a high level horizontal slide.</p>
				</section>
				<section id="vertical-2">
					<h2>Vertical Level -2</h2>
					<p>That's it, time to go back up.</p>
					<br>
					<a href="#/2">
						<img width="178" height="238" data-src="https://s3.amazonaws.com/hakim-static/reveal-js/arrow.png" alt="Up arrow" style="transform: rotate(180deg); -webkit-transform: rotate(180deg);">
					</a>
				</section>
			</section>
			<section>
				<section id="button">
					<h2>Unsplash Button</h2>
					<p>
						<?php echo do_shortcode( '[unsplash-ajax]' ); ?>
					</p>
				</section>
			</section>
			<section>
				<section id="fragment">
					<h2>Fragments</h2>
					<p>There's different types of fragments, <span class="fragment fade-up">like:</span></p>
					<p class="fragment current-visible grow">grow</p>
					<p class="fragment current-visible shrink">shrink</p>
					<p class="fragment current-visible fade-out">fade-out</p>
					<p class="fragment current-visible fade-up">fade-up (also down, left and right!)</p>
					<p class="fragment current-visible">current-visible</p>
					<aside class="notes">
						This slide has fragments which are also stepped through in the notes window.
					</aside>
				</section>
				<section id="practical">
					<h2>Practical</h2>
					<p class="fragment">Highlight <span class="fragment highlight-red">red</span> <span class="fragment highlight-blue">blue</span> <span class="fragment highlight-green">green</span></p>
					<aside class="notes">
						This slide has fragments which are also stepped through in the notes window.
					</aside>
				</section>
			</section>
			<section>
				<h2>Paul Barthmaier</h2>
				<h3>WordPress Plugin Architecture</h3>
				<p>
					<small><i class="fa fa-twitter"></i> <a href="//twitter.com/_pbrocks">@_pbrocks</a></small>
				</p>
			</section>
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
		{ src: '<?php echo REVEAL_JS; ?>/plugin/menu/menu.js', async: true }
		]
	  });

	</script>
<?php
	wp_footer();
?>
  </body>
</html>

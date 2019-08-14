<?php
/**
 * Reveal Page template
 */
// get_header();
wp_head();
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
	<style type="text/css">
		body > div > div.slides > section.present.has-dark-background {
				background: radial-gradient(#fff, transparent);
				padding: 3em;
		}
	</style>
  </head>
	<div class="reveal">
	  <div class="slides">
			<section data-background="#00ffff">
				<h2>data-background: #00ffff</h2>
			</section>

			<section data-background="#bb00bb">
				<h2>data-background: #bb00bb</h2>
			</section>

			<section data-background-color="lightblue">
				<h2>data-background: lightblue</h2>
			</section>

			<section>
				<section data-background="#ff0000">
					<h2>data-background: #ff0000</h2>
				</section>
				<section data-background="rgba(0, 0, 0, 0.2)">
					<h2>data-background: rgba(0, 0, 0, 0.2)</h2>
				</section>
				<section data-background="salmon">
					<h2>data-background: salmon</h2>
				</section>
			</section>

			<section data-background="rgba(0, 100, 100, 0.2)">
				<section>
					<h2>Background applied to stack</h2>
				</section>
				<section>
					<h2>Background applied to stack</h2>
				</section>
				<section data-background="rgb(66, 66, 66)">
					<h2>Background applied to slide inside of stack</h2>
				</section>
			</section>

			<section data-background-transition="slide" data-background="<?php echo plugins_url( 'assets/image1.png', __DIR__ ); ?>">
				<h2>Background image</h2>
			</section>

			<section>
				<section data-background-transition="slide" data-background="<?php echo plugins_url( 'assets/image1.png', __DIR__ ); ?>">
					<h2>Background image</h2>
				</section>
				<section data-background-transition="slide" data-background="<?php echo plugins_url( 'assets/image1.png', __DIR__ ); ?>">
					<h2>Background image</h2>
				</section>
			</section>

			<section data-background="<?php echo plugins_url( 'assets/image2.png', __DIR__ ); ?>" data-background-size="100px" data-background-repeat="repeat" data-background-color="#111">
				<h2>Background image</h2>
				<pre>data-background-size="100px" data-background-repeat="repeat" data-background-color="#111"</pre>
			</section>

			<section data-background="#888888">
				<h2>Same background twice (1/2)</h2>
			</section>
			<section data-background="#888888">
				<h2>Same background twice (2/2)</h2>
			</section>

			<section data-background-video="https://s3.amazonaws.com/static.slid.es/site/homepage/v1/homepage-video-editor.mp4,https://s3.amazonaws.com/static.slid.es/site/homepage/v1/homepage-video-editor.webm">
				<h2>Video background</h2>
			</section>

			<section data-background-iframe="https://slides.com/news/make-better-presentations/embed?style=hidden&autoSlide=4000">
				<h2>Iframe background</h2>
			</section>

			<section>
				<section data-background="#417203">
					<h2>Same background twice vertical (1/2)</h2>
				</section>
				<section data-background="#417203">
					<h2>Same background twice vertical (2/2)</h2>
				</section>
			</section>

			<section data-background="#934f4d">
				<h2>Same background from horizontal to vertical (1/3)</h2>
			</section>
			<section>
				<section data-background="#934f4d">
					<h2>Same background from horizontal to vertical (2/3)</h2>
				</section>
				<section data-background="#934f4d">
					<h2>Same background from horizontal to vertical (3/3)</h2>
				</section>
			</section>

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
				width: 1200,
				height: 800,
				mouseWheel: true,
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
				theme: Reveal.getQueryHash().theme, // available themes are in /css/theme
				transition: Reveal.getQueryHash().transition || 'default', // none/fade/slide/convex/concave/zoom


		// Optional reveal.js plugins
		dependencies: [
			{ src: '<?php echo REVEAL_JS; ?>/lib/js/classList.js', condition: function() { return !document.body.classList; } },
			{ src: '<?php echo REVEAL_JS; ?>/plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
			{ src: '<?php echo REVEAL_JS; ?>/plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
			{ src: '<?php echo REVEAL_JS; ?>/plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
			{ src: '<?php echo REVEAL_JS; ?>/plugin/zoom-js/zoom.js', async: true },
			{ src: '<?php echo REVEAL_JS; ?>/plugin/notes/notes.js', async: true },
			{ src: '<?php echo REVEAL_JS; ?>/plugin/fullscreen/fullscreen.js' },
			{ src: '<?php echo REVEAL_JS; ?>/plugin/menu/menu.js' },
		]
	  });

	</script>
<?php
	wp_footer();
?>
  </body>
</html>

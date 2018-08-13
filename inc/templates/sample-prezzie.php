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
  </head>
	<div class="reveal">
	  <div class="slides">

	<div class="reveal">
		<!-- Any section element inside of this container is displayed as a slide -->
		<div class="slides" >
			<section>
				<h1>Fullscreen slides with Reveal.js</h1>
				<p>
					<small>Created by <a href="http://www.telematique.eu" >Asvin Goel</a></small>
				</p>
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
			<section>
				<section>
					<p>How about showing your next holiday location?</p>
				</section>
				<section data-fullscreen>
					<iframe class="stretch" data-src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d61206.89156051744!2d-151.77366863890407!3d-16.50433878928727!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sde!4v1467468929561"></iframe>
				</section>
			</section>
			<section>
				<section>
					<p>Or presenting some Google Spreadsheet?</p>
				</section>
				<section data-fullscreen>
					<iframe class="stretch" data-src="https://docs.google.com/spreadsheets/d/1HH4c7Wdcd6RBIbaw7WsTI4iYjgJAhCAul2td93I-coA/edit?usp=sharing"></iframe>
				</section>
			</section>
<!--
			<section>
				<section>
					<p>Or creating a BPMN model?</p>
				</section>
				<section data-fullscreen>
					<iframe class="stretch" data-src="http://demo.bpmn.io/s/start"></iframe>
				</section>
			</section>
-->
			<section>
				<section>
					<p>Note that the fullscreen slides may look different on different screens.</p>
				</section>
				<section>
					<p>It is advisable to only use the fullscreen mode for responsive content.</p>
				</section>
			</section>
			<section>
			<h2>The end</h2>

				<p>Check out other plugins by clicking on &nbsp;<a href="#" onclick="RevealMenu.toggle(); return false;"><i class="fa fa-bars"></i></a>&nbsp; and then on "Plugins <i class="fa fa-external-link"></i>".</p>
				<p>Have a look at the source code & documentation on <a href="https://github.com/rajgoel/reveal.js-plugins">Github</a>.</p>
					
			</section>
	<script src="<?php echo REVEAL_JS; ?>/lib/js/head.min.js"></script>
	<script src="<?php echo REVEAL_JS; ?>/js/reveal.js"></script>

	<script>
			Reveal.initialize({
				controls: false,
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

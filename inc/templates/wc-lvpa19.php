<?php
/**
 * Reveal Page template
 * body > div > div.slides > section.stack.present > section.has-dark-background.present {
 *
	background: radial-gradient(white, transparent);
 * }
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

	<?php $theme_css = get_option( 'reveal_theme_css' ); ?>
	<link rel="stylesheet" href="<?php echo REVEAL_JS; ?>/css/reveal.css">
	<link rel="stylesheet" href="<?php echo REVEAL_JS; ?>/css/theme/<?php echo ( $theme_css ? $theme_css : 'sky-too.css' ); ?>" id="theme">

	<!-- Code syntax highlighting -->
	<link rel="stylesheet" href="<?php echo REVEAL_JS; ?>/lib/css/zenburn.css">
	<link rel="stylesheet" href="<?php echo plugins_url( 'inc/css/reveal-pbrocks.css', dirname( __DIR__ ) ); ?>">
  </head>
	<div class="reveal">
	  <div class="slides">
			<section>
				<h1>WordPress Plugin Architecture</h1>
				<h3>Paul Barthmaier</h3>
				<h4>NE Tennesee Media Group</h4>
				<p>
					<small><a href="//twitter.com/_pbrocks">@_pbrocks</a></small>
				</p>
				<aside class="notes">
				</aside>
			</section>
			<section>
				<section id="what-isa-plugin">
					<h2>What is a Plugin?</h2>
					<div>
					</div>
					<aside class="notes">nada</aside>
				</section>
				<section>
					<h2>WordPress Plugin</h2>
					<h4>php file in the plugins folder/subfolder with a doc block header.</h4>
					<aside class="notes">nada</aside>
				</section>
				<section style="transform: translateY(-5rem);">
					<h2>WordPress Files</h2>
					<p>
					<img src="<?php echo plugins_url( 'inc/assets/wclvpa19/wordpress-files.png', dirname( __DIR__ ) ); ?>" width="100%"/>
					</p>
					<aside class="notes">
						This slide has fragments which are also stepped through in the notes window.
					</aside>
				</section>

				<section style="transform: translateY(-5rem);">
					<h2>Core Files</h2>
					<img src="<?php echo plugins_url( 'inc/assets/wclvpa19/wordpress-core-files.png', dirname( __DIR__ ) ); ?>" width="100%"/>
					<aside class="notes">
						This slide has fragments which are also stepped through in the notes window.
					</aside>
				</section>

				<section>
					<h1>wp-content</h1>
					<p>
					<img src="<?php echo plugins_url( 'inc/assets/wclvpa19/your-stuff.png', dirname( __DIR__ ) ); ?>" width="100%"/>
					</p>
					<aside class="notes">
						where your customizations go
					</aside>
				</section>
				<section>
					<h2 id="block-name">Plugin Header</h2>
					<div>
					</div>
					<aside class="notes">nada</aside>
				</section>
				<section>
					<h2 id="block-name">Image</h2>
					<div>
						<div id="slide-image" >
							<img width="1191" height="765" src="https://wordcamp.local/wp-content/uploads/2019/08/login-screen.png" class="aligncenter wp-post-image" alt="" srcset="https://wordcamp.local/wp-content/uploads/2019/08/login-screen.png 1191w, https://wordcamp.local/wp-content/uploads/2019/08/login-screen-300x193.png 300w, https://wordcamp.local/wp-content/uploads/2019/08/login-screen-768x493.png 768w, https://wordcamp.local/wp-content/uploads/2019/08/login-screen-1024x658.png 1024w" sizes="(max-width: 1191px) 100vw, 1191px" />
						</div>
					</div>
					<aside class="notes">bout how to set up a Sitewide Sale.
						Toggle panel: Reveal Slide Notes
					</aside>
				</section>
			</section>

			<section>
				<section>
					<h2>https://github.com/pbrocks/<br><br>wclvpa19-ajax-plugin</h2>
				</section>
				<section data-background="<?php echo plugins_url( 'assets/wclvpa19/github-login.png', __DIR__ ); ?>">
				</section>
				<section data-background="<?php echo plugins_url( 'assets/wclvpa19/enqueue-scripts-styles.png', __DIR__ ); ?>">
				</section>
				<section data-background="<?php echo plugins_url( 'assets/wclvpa19/login-style.png', __DIR__ ); ?>">
				</section>
				<section data-background-video="<?php echo plugins_url( 'assets/wclvpa19/login-scripts.mp4', __DIR__ ); ?>">
				</section>
			</section>
			<section id="mission">
				<section id="functions.php">
					<h2>Mission</h2>
					<div>Avoid the temptation of adding to functions.php</div>
					<aside class="notes">This is my Slide Notes</aside>
				</section>
				<section>
					<h2 id="block-name">Strategies I use when building plugins</h2>
					<div>
						<!-- wp:paragraph -->
						<p>-</p>
						<!-- /wp:paragraph -->
					</div>
					<aside class="notes">Reveal Slide Notes
						display Metabox 3 Heading
						Use this filter: sws_metabox_3_description to provide some instructions about how to set up a Sitewide Sale.
						Toggle panel: Reveal Slide Notes
					</aside>
				</section>
				<section>
					<h2 id="block-name">Stuff they don't teach you at the WordPress Seminary</h2>
					<div>
					</div>
					<aside class="notes">about how to set up a Sitewide Sale.
						Toggle panel: Reveal Slide Notes
					</aside>
				</section>
				<section id="pro-tip">
					<h2>pbrx Tip:</h2>
					<h1 class="fragment">Always Get Results</h1>
					<div>
					</div>
					<aside class="notes">Reveal Slide Notes
						
						Toggle panel: Reveal Slide Notes
					</aside>
				</section>
			</section>
			<section>
				<section>
				</section>
			</section>
			<section>
				<section>
					<h1>Why write a Plugin</h1>
					<p><i class="fa fa-coffee"></i> Slides can be nested inside of each other.</p>
					<p><i class="fa fa-rocket fa-spin"></i> Use the <em>Space</em> key to navigate through all slides. </p>
				</section>
				<section data-background="<?php echo plugins_url( 'assets/wclvpa19/ajax-color.png', __DIR__ ); ?>">
				</section>
				<section data-background-video="<?php echo plugins_url( 'assets/wclvpa19/unsplash.mp4', __DIR__ ); ?>">
				</section>
				<section data-background="<?php echo plugins_url( 'assets/wclvpa19/ajax-color.png', __DIR__ ); ?>">
				</section>
				<section data-background-video="<?php echo plugins_url( 'assets/wclvpa19/color-change.mp4', __DIR__ ); ?>">
				</section>
				<section data-background="<?php echo plugins_url( 'assets/wclvpa19/ajax-color.png', __DIR__ ); ?>">
				</section>
				<section data-background="<?php echo plugins_url( 'assets/wclvpa19/twentyten.png', __DIR__ ); ?>">
				</section>
				<section data-background-video="<?php echo plugins_url( 'assets/wclvpa19/three-areas.mp4', __DIR__ ); ?>">
				</section>
				<section data-background="<?php echo plugins_url( 'assets/wclvpa19/ajax-color.png', __DIR__ ); ?>">
				</section>
				<section data-background-video="<?php echo plugins_url( 'assets/wclvpa19/flashcards.mp4', __DIR__ ); ?>">
				</section>
			</section>
			<section>
			</section>
			<section>
				<h2>Paul Barthmaier</h2>
				<h3>WordPress Plugin Architecture</h3>
				<p>
					<small><a href="//twitter.com/_pbrocks">@_pbrocks</a></small>
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

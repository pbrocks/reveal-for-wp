<?php
define('REVEAL_JS_2', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] );
echo '<h2>' . REVEAL_JS_2 . '</h2>';
?>
<!doctype html>
<html lang="en">

	<head>
		<meta charset="utf-8">

		<title>reveal.js-menu</title>

		<meta name="description" content="A slideout menu for reveal.sj, a framework for easily creating beautiful presentations using HTML">
		<meta name="author" content="Greg Denehy">

		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">

		<link rel="stylesheet" href="<?php echo REVEAL_JS_2; ?>/../../../reveal-js/css/reveal.css">
		<link rel="stylesheet" href="<?php echo REVEAL_JS_2; ?>/../../../reveal-js/css/theme/black.css" id="theme">

		<!-- Code syntax highlighting -->
		<link rel="stylesheet" href="<?php echo REVEAL_JS_2; ?>/../../../reveal-js/lib/css/zenburn.css">

		<!-- Printing and PDF exports -->

		<!--[if lt IE 9]>
		<script src="/lib/reveal.js/lib/js/html5shiv.js"></script>
		<![endif]-->

		<style>
			.reveal .slide-number {
				font-size: 0.6em;
			}
		</style>
	</head>

	<body>

		<div class="reveal">

			<!-- Any section element inside of this container is displayed as a slide -->
			<div class="slides">
				<section id="home">
					<h1>Reveal.js-menu</h1>
					<h3>A slideout menu for navigating reveal.js presentations</h3>
					<p>
						<small>Created by <a href="https://github.com/denehyg">Greg Denehy</a> / <a href="http://twitter.com/gregdenehy">@gregdenehy</a></small>
					</p>
				</section>

				<section id="introduction">
					<h3>Hey There</h3>
					<p>Have you ever used <a href="https://github.com/hakimel/reveal.js">reveal.js</a> and wanted jump <br/>somewhere else in your presentation?</p>
					<p>The slide overview is great but perhaps you want to <br/>change slides without your audience seeing everything.</p>
					<p>Perhaps you need to quickly change the <br/>theme without editing the slide source.</p>
					<p>Give <a href="https://github.com/denehyg/reveal.js-menu">reveal.js-menu</a> a try</p>
				</section>

				<section data-menu-title="Opening the menu">
					<p>See the &nbsp;<a href="#" onclick="RevealMenu.toggle(); return false;"><i class="fa fa-bars"></i></a>&nbsp; in the corner?</p>
					<p>Click it and the menu will open from the side.</p>
					<p>
						Click anywhere on the slide to return to the presentation,<br>
						or use the close button in the menu.
					</p>
				</section>

				<section data-menu-title="Using the slide number">
					<p>If you don't like the menu button,<br/>you can use the slide number instead.</p>
					<p>Go on, give it a go.</p>
					<p>The menu button can be hidden using the options, <br/>but you need to enable the slide number link.</p>
				</section>

				<section id="keyboard" data-menu-title="Keyboard">
					<p>Or you can open the menu by pressing the <code>m</code> key.</p>
					<p>
						You can navigate the menu with the keyboard as well. <br/>Just use the arrow keys and <code>&lt;space&gt;</code> or <code>&lt;enter&gt;</code> to change slides.
					</p>
					<p>You can disable the keyboard for the <br/>menu in the options if you wish.</p>
				</section>

				<section>
					<h3>Left or Right</h3>
					<p>You can configure the menu to slide in from the left or right</p>
				</section>

				<section>
					<h3>Markers</h3>
					<p>The slide markers in the menu can be useful to show <br/>you the progress through the presentation.</p>
					<p>You can hide them if you want.</p>
					<p>You can also show/hide slide numbers.</p>
				</section>

				<section id="titles">
					<h3>Slide Titles</h3>
					<p>
						The menu uses the first heading to label each slide<br/>
						but you can specify another label if you want.
					</p>
					<p>
						Use a <code>data-menu-title</code> attribute in the section element to give the slide a custom label,
						or add a <code>menu-title</code> class to any element in the slide you wish.
					</p>
					<p>
						You can change the <code>titleSelector</code> option and use<br/>
						any elements you like as the default for labelling each slide.
					</p>
				</section>

				<section>
					<section>
						<h2>Vertical Slides</h2>
						<p>The menu indents your vertical slides so it's easy to see the structure of your presentation.</p>
						<br>
						<a href="#" class="navigate-down">
							<img width="178" height="238" data-src="https://s3.amazonaws.com/hakim-static/arrow.png" alt="Down arrow">
						</a>
					</section>
					<section>
						<h2>Next slide down</h2>
					</section>
					<section>
						<h2>At the bottom</h2>
						<br>
						<a href="#/2">
							<img width="178" height="238" data-src="https://s3.amazonaws.com/hakim-static/arrow.png" alt="Up arrow" style="transform: rotate(180deg); -webkit-transform: rotate(180deg);">
						</a>
					</section>
				</section>

				<section id="themes">
					<h3>Themes</h3>
					<p>The menu can also be used to change the <br/>theme of your presentation.</p>
					<p>Just click the Themes button at the top of the menu.</p>
					<p>The list of themes can be configured in the options.</p>
				</section>

				<section id="transitions">
					<h3>Transitions</h3>
					<p>You can also change the default <br/>transition style from the menu.</p>
				</section>

				<section id="custom">
					<h3>Custom Panels</h3>
					<p>
						Create your own custom menu panels where<br/>
						you can add your own html content.
					</p>
					<p>
						Custom panels support menu items so you<br/>
						can create your own menus that look and<br/>
						behaviour just like the other menus.
					</p>
				</section>

				<section>
					<h3>Speaker View</h3>
					<p>The menu works independently in the speaker view.</p>
					<p>You can changes slides without your audience <br/>seeing you doing any of it.</p>
				</section>

				<section style="text-align: left;">
					<h1>THE END</h1>
					<p><a href="https://github.com/denehyg/reveal.js-menu/archive/master.zip">Download reveal.js-menu</a> and add it to your plugin folder</p>
					<p>Have a look at the <a href="https://github.com/denehyg/reveal.js-menu">source code &amp; documentation</a></p>
					<p>And don't forget to check out <a href="https://github.com/hakimel/reveal.js">Reveal.js</a> if you haven't already</p>
				</section>

			</div>

		</div>

		<script src="<?php echo REVEAL_JS_2; ?>/../../../reveal-js/lib/js/head.min.js"></script>
		<script src="<?php echo REVEAL_JS_2; ?>/../../../reveal-js/js/reveal.js"></script>

		<script>

			// Full list of configuration options available at:
			// https://github.com/hakimel/reveal.js#configuration
			Reveal.initialize({
				controls: true,
				progress: true,
				history: true,
				center: true,
				slideNumber: true,

				transition: 'slide', // none/fade/slide/convex/concave/zoom

				menu: {
					numbers: true,
					openSlideNumber: true,
					themes: true,
					themesPath: '<?php echo REVEAL_JS_2; ?>/../../../reveal-js/css/theme/',
					transitions: true,
			        custom: [
			            { title: 'Custom', icon: '<i class="fa fa-bookmark">', src: 'links.html' },
			        ]
				},

				// Optional reveal.js plugins
				dependencies: [
					{ src: '<?php echo REVEAL_JS_2; ?>/../../../reveal-js/plugin/notes/notes.js', async: true },
					{ src: '<?php echo REVEAL_JS_2; ?>/../../../reveal-js/plugin/menu/menu.js', async: true }
				]
			});
		</script>

		<a class="fork-reveal" href="https://github.com/denehyg/reveal.js-menu"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/e7bbb0521b397edbd5fe43e7f760759336b5e05f/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f677265656e5f3030373230302e706e67" alt="Fork reveal.js-menu on GitHub"></a>

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-66860273-1', 'auto');
			ga('send', 'pageview');

			Reveal.addEventListener( 'slidechanged', function( event ) {
				var loc = (event.indexv > 0 ? event.indexh+'' : event.indexh+'.'+event.indexv);
				ga('send', 'event', 'slide', 'changed', loc);
			} );
		</script>

	</body>
</html>

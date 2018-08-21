<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <title>reveal-md</title>
        <link rel="stylesheet" href="./css/reveal.css">
        <link rel="stylesheet" href="css/theme/sky-three.css" id="theme">
        <link rel="stylesheet" href="./css/highlight/zenburn.css">
        <link rel="stylesheet" href="./css/print/paper.css" type="text/css" media="print">


    </head>
    <body>

        <div class="reveal">
            <div class="slides"><section  data-markdown><script type="text/template"># Redesigning plugin functionality using WP Blocks
<br>
## Paul Barthmaier
#### Paid Memberships Pro / Sidetrack Studio</script></section><section  data-markdown><script type="text/template">

## The Challenge

> The [new] editor will endeavour to create a new page and post building experience that makes writing rich posts effortless, and has “blocks” to make it easy what today might take shortcodes, custom HTML, or “mystery meat” embed discovery. <!-- .element: class="fragment" -->

<br>

#### https://wordpress.org/gutenberg/handbook/ <!-- .element: class="fragment" -->
<aside class="notes"><p>speaker notes FTW!</p>
</aside></script></section><section  data-markdown><script type="text/template">
# Did you catch that?

### Shortcodes <!-- .element: class="fragment" -->

## custom HTML <!-- .element: class="fragment" -->

# “mystery meat” embed <!-- .element: class="fragment" -->

<aside class="notes"><p>Lumping them together seems like they are all bad</p>
</aside></script></section><section  data-markdown><script type="text/template">
## Does that mission statement

## equate the three? <!-- .element: class="fragment" -->

### and worse <!-- .element: class="fragment" -->

## demonize them? <!-- .element: class="fragment" -->
</script></section><section  data-markdown><script type="text/template">
## So something like this:


`[pmpro_checkout_button class="pmpro_btn" level="1" text="Buy Now"]` <!-- .element: class="fragment" -->

# is bad? <!-- .element: class="fragment" -->
</script></section><section  data-markdown><script type="text/template">
## Remember the days of this:
</script></section><section  data-markdown><script type="text/template">
<!-- .slide: data-background="images/button-shortcode1.png" -->


<aside class="notes"><p>speaker notes FTW!</p>
</aside></script></section><section  data-markdown><script type="text/template">
<!-- .slide: data-background="images/button-shortcode2.png" -->


<aside class="notes"><p>speaker notes FTW!</p>
</aside></script></section><section  data-markdown><script type="text/template">
<!-- .slide: data-background="images/button-shortcode3.png" -->


<aside class="notes"><p>speaker notes FTW!</p>
</aside></script></section><section  data-markdown><script type="text/template">
<!-- .slide: data-background="images/button-shortcode4.png" -->


<aside class="notes"><p>speaker notes FTW!</p>
</aside></script></section><section  data-markdown><script type="text/template">
<!-- .slide: data-background="images/button-shortcode5.png" -->


<aside class="notes"><p>speaker notes FTW!</p>
</aside></script></section><section  data-markdown><script type="text/template">
<!-- .slide: data-background="images/button-shortcode6.png" -->


<aside class="notes"><p>speaker notes FTW!</p>
</aside></script></section><section  data-markdown><script type="text/template">
<!-- .slide: data-background="images/button-shortcode7.png" -->


<aside class="notes"><p>speaker notes FTW!</p>
</aside></script></section><section  data-markdown><script type="text/template">
<!-- .slide: data-background="images/button-shortcode8.png" -->


<aside class="notes"><p>speaker notes FTW!</p>
</aside></script></section><section  data-markdown><script type="text/template">
## to yield this:
</script></section><section  data-markdown><script type="text/template">
<!-- .slide: data-background="images/checkout-button-from-shortcode.png" -->
</script></section><section  data-markdown><script type="text/template">
## Not so Simple

</script></section><section  data-markdown><script type="text/template">## Javascript vs PHP

### PHP requires talking to a database <!-- .element: class="fragment" -->

#### usually over the internet <!-- .element: class="fragment" -->

### Javascript is a browser technology <!-- .element: class="fragment" -->

#### and thus operates on your computer <!-- .element: class="fragment" -->

#### ie not competing for bandwidth and processing speed of servers <!-- .element: class="fragment" -->
</script></section><section  data-markdown><script type="text/template">
## What is Javascript?

#### You've heard about <!-- .element: class="fragment" -->
##### Javascript <!-- .element: class="fragment" -->
##### jQuery <!-- .element: class="fragment" -->
##### Angular <!-- .element: class="fragment" -->
##### Vue <!-- .element: class="fragment" -->
##### Node <!-- .element: class="fragment" -->
##### JSX <!-- .element: class="fragment" -->
##### ES6 <!-- .element: class="fragment" -->
##### ESnext <!-- .element: class="fragment" -->
##### EcmaScript <!-- .element: class="fragment" -->
##### ES2015 <!-- .element: class="fragment" -->
##### ES2016 <!-- .element: class="fragment" -->

</script></section><section  data-markdown><script type="text/template">
## What is Javascript?

### Any file that uses a given set of structures and whose filename has a .js extention. <!-- .element: class="fragment" -->
<br>
<br>


#### TLDR: Netscape vs Microsoft <!-- .element: class="fragment" -->
</script></section><section  data-markdown><script type="text/template">
## Javascript vs ECMAscript

### Many different takes on the definitions <!-- .element: class="fragment" -->

<br>

### For the purposes of this talk <!-- .element: class="fragment" -->

### Javascript is the code used in .js files, regardless of its particular flavor <!-- .element: class="fragment" -->

### ECMAScript is code that adheres to standards put forth by the governing body <!-- .element: class="fragment" -->

</script></section><section  data-markdown><script type="text/template">
## Javascript vs ECMAscript

> When people call JavaScript a “dialect of the ECMAScript language,” they mean it in the same sense as when talking about English, French, or Chinese dialects. A dialect derives most of its lexicon and syntax from its parent language, but deviates enough to deserve distinction.

<br>
##### Source: https://medium.freecodecamp.org/whats-the-difference-between-javascript-and-ecmascript-cba48c73a2b5

<aside class="notes"><p>Here&#39;s a nice way to think of things, perhaps it&#39;s just me since it appeals to my linguistic instincts</p>
</aside></script></section><section  data-markdown><script type="text/template">

## Shift to Javascript

<br>

### Shift in the Marketplace <!-- .element: class="fragment" -->

### Shift in demands of users <!-- .element: class="fragment" -->

### Shift in what's possible <!-- .element: class="fragment" -->

## Shift towards SPEED <!-- .element: class="fragment" --></script></section><section  data-markdown><script type="text/template">
## Let's do this!
</script></section><section  data-markdown><script type="text/template">
## Building a Plugin 
</script></section><section  data-markdown><script type="text/template"><!-- .slide: data-background="images/plugin-overview-sublime.png" -->

</script></section><section  data-markdown><script type="text/template"><!-- .slide: data-background="images/folder-overview.png" -->

</script></section><section  data-markdown><script type="text/template"><!-- .slide: data-background="images/babel.png" -->

</script></section><section  data-markdown><script type="text/template"><!-- .slide: data-background="images/package_json.png" -->

</script></section><section  data-markdown><script type="text/template"><!-- .slide: data-background="images/package_json-focus.png" -->

</script></section><section  data-markdown><script type="text/template"><!-- .slide: data-background="images/package_json-babel.png" -->

</script></section><section  data-markdown><script type="text/template"><!-- .slide: data-background="images/package-lock_json.png" -->

</script></section><section  data-markdown><script type="text/template"><!-- .slide: data-background="images/wclvpa-blocks_php.png" -->

</script></section><section  data-markdown><script type="text/template"><!-- .slide: data-background="images/wclvpa-blocks_php-focus.png" -->

</script></section><section  data-markdown><script type="text/template"><!-- .slide: data-background="images/webpack_config_js.png" -->

</script></section><section  data-markdown><script type="text/template">
## Do I need to learn React?

> Best quote ever.

<aside class="notes"><p>speaker notes FTW!</p>
</aside></script></section><section  data-markdown><script type="text/template">

</script></section></div>
        </div>

        <script src="./lib/js/head.min.js"></script>
        <script src="./js/reveal.js"></script>

        <script>
            function extend() {
              var target = {};
              for (var i = 0; i < arguments.length; i++) {
                var source = arguments[i];
                for (var key in source) {
                  if (source.hasOwnProperty(key)) {
                    target[key] = source[key];
                  }
                }
              }
              return target;
            }

            // Optional libraries used to extend on reveal.js
            var deps = [
              { src: './lib/js/classList.js', condition: function() { return !document.body.classList; } },
              { src: './plugin/markdown/marked.js', condition: function() { return !!document.querySelector('[data-markdown]'); } },
              { src: './plugin/markdown/markdown.js', condition: function() { return !!document.querySelector('[data-markdown]'); } },
              { src: './plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
              { src: './plugin/zoom-js/zoom.js', async: true },
              { src: './plugin/notes/notes.js', async: true },
              { src: './plugin/math/math.js', async: true }
            ];

            // default options to init reveal.js
            var defaultOptions = {
              controls: true,
              progress: true,
              history: true,
              center: true,
              transition: 'default', // none/fade/slide/convex/concave/zoom
              dependencies: deps
            };

            // options from URL query string
            var queryOptions = Reveal.getQueryHash() || {};

            var options = {};
            options = extend(defaultOptions, options, queryOptions);
        </script>


        <script>
          Reveal.initialize(options);
        </script>
    </body>
</html>

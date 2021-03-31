=== Photographers galleries ===
Contributors: aurelienpierre
Donate link: https://www.paypal.me/aurelienpierre/
Tags: gallery, html5, carousel, pictures, responsive, jetpack, photo, taxonomy, exif
Requires at least: 3.6
Tested up to: 5.7
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Enhance your galleries with HTML5 responsive `figure` and present them with a  lightweight CSS3 carousel or exhibition mode that fills the gap between a digital presentation and a real-life exhibition.

[Demo](https://photo.aurelienpierre.com/photographers-galleries-demo/)

== Description ==

Most fancy gallery plugins will add their gallery manager on top of WordPress, which already has one… Then, they will crop images to fit within their fancy layout. Unfortunately, if you are an artist, the way you composed and framed your picture is no accident and should be honored by whatever display system you use. After all that, they will add an awful bloat of jQuery madness that will put a hole in your [Page Speed](https://developers.google.com/speed/pagespeed/insights/) score and kill your [loading time](https://tools.pingdom.com/). Finally, they will distract visitors from your content with all their fancy effects that make your CPU overheat for nothing. Picture-based websites were already heavy, these will make sure to give them the final blow...

We need better.

Photographers galleries extends native WordPress galleries with EXIF support and taxonomies, and make them query-able to display truly dynamic galleries. It uses 90% of built-in browser technologies (pure CSS and HTML), with only a bit of native Javascript to extend them (no jQuery or additional lib dependency). This ensures fast loading, fast execution, and will take advantage of hardware-accelerated animations. Overall, you get carousels and exhibitions with a small performance footprint, which is more energy-efficient but also snappier nd better looking than full-on Javascript animations.

For performance, it loads minified CSS and Javascript, only on the pages that actually make use of galleries (auto-detected). It's fast, minimalist, simple, robust, and good for your SEO (which is now a factor in [Google Page Rank](https://tools.pingdom.com/)).

The look is inspired by art books and museums exhibitions, meant to allow a flawless and non-intrusive full-screen experience, so you can design your website as a webapp.


= Quick features overview =

* Ready to use with caching, minification and lazy loading plugins : WP Super Cache, W3 Total Cache, WP Rocket, etc.,
* Compatible with Jetpack tiled galleries and every lightbox plugin, consistent with Jetpack tiled galleries styling,
* Fully responsive (width and height),
* The JS weighs only 4.7 kB, and the CSS 7 kB. JS is loaded in page footer and supports deferring.
* Theme-agnostic design, classy minimalist look.

= Attachements improvements =

**Photographers galleries** enhances the WordPress attachments from the media library by enabling regular posts properties on them :

* comments,
* author,
* custom fields,
* posts categories,
* posts tags.

It adds 3 custom taxonomies to the media attachments :

* galleries (which you can use as categories to describe **what** is on the picture),
* locations (**where** is the picture),
* models (**who** is on the picture).

These taxonomies are hierarchical, meaning that a "USA" parent location can have "Texas" and "Nevada" children locations which can have children themselves.

Taxonomies and tags make the attachments queryable in archives, just like posts categories, so they allow you to display dynamic galleries either through custom taxonomies template (to add to your theme) or on a page with a shortcode see [Installation](https://wordpress.org/plugins/photographers-galleries/installation/). Most gallery
plugins create galleries as custom posts and force you to add your new pictures to all the relevant galleries. PG's way allow you to add your pictures to multiple galleries in one step, during its upload in a post editor or in the media library.

To add taxonomies terms to your pictures during their upload in posts editor, use the plugin [Media Library Assistant](https://wordpress.org/plugins/media-library-assistant/). It will help you to bulk edit your media library too. See [Other notes](https://wordpress.org/plugins/photographers-galleries/other_notes/) to find how to set MLA.

= Galleries improvements =

**Photographers galleries** enable the WordPress built-in HTML5 support for pictures and galleries to produce `<figure>` and `<figcaption>` tags to increase the SEO and get rid of WordPress default gallery layout (which width is set by the global variable `$content_width`). They add a fully responsive stylesheet to fit the galleries along the borders of the container.

It also adds more thumbnails sizes for the responsive `srcset` HTML attribute of images, allowing browsers to load exactly the right image size for the current viewport size. These sizes go all the way from 240×360px to 4096×2160px, so don't be afraid to upload high-resolution images, your visitors will only see the image size relevant for their screen size and pixel density.

No particular operation is required, just use your regular WordPress gallery builder inside the post editor.

= Extra layouts & shortcodes wrappers for WordPress galleries =

**Photographers galleries** uses only regular WordPress galleries, called by the `[gallery]` shortcode, and does not rewrite them. This is intended to ensure maximum compatibility with other plugins (lightboxes, etc.) as well at with future WordPress versions. The extra gallery layouts are provided by extra shortcodes to wrap around the WordPress galleries.

**Note : this makes use of the classic editor gallery, not the Gutenberg block. For what Photographers galleries does, the Gutenberg gallery block adds no benefit over the classic gallery.**

Extra gallery layouts :

* no captions
* caption aligned

See [Installation](https://wordpress.org/plugins/photographers-galleries/installation/) tab for use instructions.

= Carousel =

**Photographers galleries** has a fixed-height carousel which takes by default 100 % of the container width and 92 % of the viewport height (99 % if captions are not displayed). It uses the native browser scrolling, supporting horizontal scrolling (touchpad and mouse wheel), swiping gestures (touch screens), click/tap on the next/previous buttons, as well as keyboard arrow keys (left and right).

The pictures are fitted to the same height so the layout is flawless and continuous, perfect to display a serie or a portfolio. Every carousel instance on a same page can have its own style. This carousel was inspired by [Format](https://format.com/themes#horizon).

See [Installation](https://wordpress.org/plugins/photographers-galleries/installation/) tab for use details.

= Exhibitions =

Exhibitions are a new mode of the 1.0 that enables a full-width and full-height experience with a framing look reproducing museum framings. They come in-place of usual lightboxes and gives your pictures maximal impact with minimal clutter, assuming you will use them in a full-width theme template. They support keyboard arrow keys interactions, as well as horizontal scrolling and click/tap on the buttons.

Exhibitions preload the next and previous images in row while looking at the current one, so the transition between images feels immediate and most lags are prevented.

= Media library improvements =

**Photographers galleries** adds EXIF metadata of your pictures in the WP library columns :

* time and date of the capture,
* camera,
* focal length,
* ISO,
* aperture,
* shutter speed,
* copyright terms,
* author credit.

== Caveats ==

Using native WordPress galleries, Photographers Galleries need to overwrite theme styling, which might still compete with it. Some CSS tuning might be necessary to fix corner-cases.

== Installation ==

Install and activate the plugin through the WordPress plugins screen directly. There is no configuration page.

Don't forget to visit the [Demo](https://photo.aurelienpierre.com/photographers-galleries-demo/), which presents examples and code to get them.


= Dynamic gallery =

This shortcode fetches all the pictures from a taxonomy (galleries, models, locations, tags) to build a dynamic gallery (which will be updated as soon as you add a picture to the corresponding taxonomy). All the display is processed by the regular WordPress shortcode, we just give it the pictures to show (meaning that your default styles, Jetpack, lightboxes etc. will work).

1. Create a regular WordPress gallery on the desired page with the desired settings and dumb content
1. Switch to the text editor in your post. You should see something like `[gallery size="full" link="file" type="rectangular" ids="4127,4126"]`
1. Strip the `ids` argument and rename the shortcode `dynamic_gallery` like `[dynamic_gallery size="full" link="file" type="rectangular"]`
1. Add the desired taxonomy as an argument, for example `gallery="portraits"`. You can add several conditions and use any of the galleries wrappers below.
1. Tweak it with more arguments.

**Example** : `[dynamic_gallery gallery='portraits' location='montreal' size="full" link="file" columns='4']`

**Arguments** :

* DISPLAY ARGUMENTS *optional*
	* Standard WordPress gallery arguments (See [the WP Codex](http://codex.wordpress.org/Gallery_Shortcode)):
		* `columns`
		* `size`
		* `link`
	* Jetpack argument (See [the Jetpack Support](https://en.support.wordpress.com/gallery/#adding-a-gallery-or-slideshow)) :
		* `type`
* CONTENT ARGUMENTS
	* Photographers galleries arguments : *they are all optional but you have to set at least one of them*
		* `gallery` : the term (slug) of the gallery whose pictures you want to show
		* `model` : idem for the models taxonomy
		* `location` : idem for the location taxonomy
		* `tag` : idem for tags
		* `author` : display only pictures from the selected author. Use the author's nicename (the one used to login)
		* `exif` : not yet implemented
	* Standard WordPress query arguments (See [the WP Codex](https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters)) :
		* `order` : *default : ASC*
		* `orderby` : *default : date*
		* For these two arguments, you can directly pass any of the allowed values described in the `WP_Query` documentation.

Note that if you give more than one condition, the conditions are added with `AND`. There is no way to exlude pictures for now.

= Galleries aligned by their caption =

By default, pictures of different heights are aligned along their top border. To align them along their bottom border (meaning to have all the captions on the same line), use the `[aligncaption]` shortcode like this : `[aligncaption][gallery ids=""][/aligncaption]`. Please be aware that other galleries types may be more suitable if you have different heights on the same gallery (e.g. tiled or masonry galleries), this is just a quick hook to improve captions readability.

= Galleries without caption =

**Photographers galleries** allows you to display galleries without image captions even if they have one stored in the database. The fact is if you delete or alter the caption of a picture in a WordPress gallery, the media will be altered too in the database and probably elsewhere if you used it on another page, which might be a problem. Here, we will just hide it.

Put your gallery shortcode in a `[nocaption]` shortcode like this : `[nocaption][gallery ids=""][/nocaption]`

= Carousel =

Just put your regular gallery shortcode in `[carousel]` shortcode like this : `[carousel][gallery ids="" size="full"][/carousel]`. Ensure your picture resolution is high enough to fit modern screens without stretching (2048 px on the large side is recommended). Since WordPress 4.4, the size you set does not matter since WP will load all available thumbnails in `srcset`. However, you need to set something, otherwise WP will default to square cropped thumbnails.

**Example of use** :
```
[carousel w="50%" h="66vh" align="left" caption="hide" title="Fancy"]
[gallery size="large" link="file" ids=""]
[/carousel]
```

**Arguments** :

* `w` = width of the carousel box with its unit – default : `100%`
	* px
	* percent of the container (`%`)
	* percent of the viewport width (`vw`)
* `h` = height of the pictures with its units – default : `calc(100vh - 0.9em - 2ex - 20px)`
    * px
    * percent of the container (`%`)
    * percent of the viewport height (`vh`)
    * a mix of different units with calc() CSS3 function : `calc(100vh – 40px – 2ex – 1.1em)`
* `title` = the title to display on the carousel – default : none
* `caption` = the caption style – default : `below`
    * `below`
    * `hide`
    * `hover`
* `align` = the desired alignement on the page – default : `none`
    * `none`
    * `left` (floating)
    * `right` (floating)
    * `center`
* `raw_css` = raw CSS code — default : `none`
	* provide an easy way to quickly add custom CSS to a container
	* if you want to style only one specific carousel, use the id `pg-carousel-X` where `X` is the order of your carousel on your page (from 1)

Please notice that the height argument sets the actual image height, not the whole carousel height, so don't forget to leave some room for the captions (0.9em + 2ex) and the scrolling bar (around 20px).

Each carousel on the page gets its own ID and settings, meaning that you can use several carousels on the same page with various settings.

= Exhibitions =

They work very similarly to carousels : `[exhibition][gallery ids="" size="full"][/exhibition]`.

**Arguments** :

All the same as carousels, plus a `look` argument to choose the styling :

* `modern` : similar to an alu-dibond mounting,
* `classic` : similar to a classical framing with a passe-partout,
* `box`, `box-dark`, `box-bright` : similar to a shadow box (called American box in Europe), in 3 shades,
* `plain` : no styling at all,
* `custom`, etc : you can create your own CSS looks by setting `look="your-name"` in the shortcode, and style the CSS selector `.pg-exhibition-wrapper .look-your-name`.

== Other notes ==

= Configuring Media Library Assistant for PG =

1. Go to "General tab"
1. Go to the "Taxonomy Support" option
1. For "Galleries", "Locations", "Models", check all the checkboxes of the line
1. Strings are ready to translate

== Screenshots ==

[Live Demo with real pictures](https://photo.aurelienpierre.com/photographers-galleries-demo/)


== Changelog ==

= 1.0.1 =

Fix a potential issue in PHP scripts including

= 1.0 =

* Fix Safari issues with picture height in carousels
* Add keyboard, touch swipe and horizontal scroll support in carousels
* Add exhibition mode
* Add thumbnail sizes for common screen resolutions, to fit in `scrset` of responsive images

= 0.4 =

* Add `raw_css` argument to `[carousel]` shortcode
* Add EXIF metadata column in media library
* Add the `[dynamic_gallery]` shortcode to retrieve pictures from taxonomies in a standard WordPress gallery
* Refactor `[carousel]` shortcode functions and don't add custom style on page if deafault settings are used
* Improve comments and docstrings

= 0.3.1 =
Minor default style tweaks

= 0.3 =
Add custom taxonomies, tags, comments and categories to attachments

= 0.2 =
Add some shortcodes

= 0.1 =
Initial version

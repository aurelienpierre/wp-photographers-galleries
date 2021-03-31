=== Photographers galleries ===
Contributors: aurelienpierre
Donate link: https://www.paypal.me/aurelienpierre/
Tags: gallery, html5, carousel, pictures, responsive, jetpack, photo, taxonomy, exif
Requires at least: 3.6
Tested up to: 5.7
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Enhance your galleries with HTML5 and add a lightweight CSS3 carousel to display a sequence of pictures without distractions.

== Description ==

**Photographers** usualy need to show their pictures without adding distracting effects such as transitions, frames, shadows, autoplay etc. They are cool though, but visitors may want to look at the pics, not at the fanciness of the latest top-notch trendy slider plugin which might, by the way, slow down their mobile device.

Native WordPress galleries are a bit too basic to achieve this but galleries plugins are often heavy, over-engineered and destroy your Page Speed performance, which now weighs in your SERP ranking.
Photo websites are heavy enough because of the pictures, it's a good idea to keep them as light as possible.

**Photographers galleries** helps photographers to organize their media library and to display dynamic galleries.

It shows nothing but the pictures, with a clean minimalist and responsive design that will fit flawless in most themes,
trying to reproduce the user experience you could get at a museum exhibition or in a fashion magazine.
To stay lightweight and compatible with every modern browser (mobile and desktop), it only takes advantage of native
Wordpress 3.6+, HTML5, CSS3 and native Javascript capabilities. No additional javascript is required. The styling is consistent with Jetpack galleries.

[Demo](https://photo.aurelienpierre.com/photographers-galleries-demo/)

= Quick features overview =

* Lightweight and robust : it uses browsers, CSS3, HTML5 and WordPress native features, enhanced with lightweight javascript,
* Ready to use with caching, minification and lazy loading plugins : WP Super Cache, W3 Total Cache, WP Rocket, etc.,
* Compatible with Jetpack tiled galleries and every lightbox plugin, consistent with Jetpack tiled galleries styling,
* Fully responsive (width and height),
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

Taxonomies and tags make the attachments queryable in archives, just like posts categories, so they allow you to display dynamic galleries either through custom
taxonomies template (to add to your theme) or on a page with a shortcode see [Installation](https://wordpress.org/plugins/photographers-galleries/installation/). Most gallery
plugins create galleries as custom posts and force you to add your new pictures to all the relevant galleries. PG's way allow you to add your pictures to
multiple galleries in one step, during its upload in a post editor or in the media library.

To add taxonomies terms to your pictures during their upload in posts editor, use the plugin [Media Library Assistant](https://wordpress.org/plugins/media-library-assistant/).
It will help you to bulk edit your media library too. See [Other notes](https://wordpress.org/plugins/photographers-galleries/other_notes/) to find how to set MLA.

= Galleries improvements =

**Photographers galleries** enable the WordPress built-in HTML5 support for pictures and galleries to produce `<figure>` and `<figcaption>` tags to increase
the SEO and get rid of WordPress default gallery layout (which width is set by the global variable `$content_width`) and adds a fully responsive
stylesheet to fit the galleries along the borders of the container.

It also adds more thumbnails sizes for the responsive `srcset` HTML attribute of images, allowing browsers to load exactly the right image size for the current viewport size.

No particular operation is required, just use your regular WordPress gallery builder inside the post editor.

= Extra layouts & shortcodes wrappers for WordPress galleries =

**Photographers galleries** uses only regular WordPress galleries, called by the `[gallery]` shortcode, and does not rewrite them.
This is intended to ensure maximum compatibility with other plugins (lightboxes, etc.) as well at with future WordPress versions. The extra gallery layouts are
provided by extra shortcodes to wrap around the WordPress galleries.

Extra gallery layouts :

* no captions
* caption aligned

See [Installation](https://wordpress.org/plugins/photographers-galleries/installation/) tab for use instructions.

= Carousel =

**Photographers galleries** has a fixed-height carousel which takes by default 100 % of the container width and 92 % of the viewport height
(99 % if captions are not displayed). It uses the native scollbars of the browser to ensure compatibility with every device, mobile or desktop.

The pictures are fitted to the same height so the layout is flawless and continuous, perfect to display a serie
or a portfolio. Every carousel instance on a same page can have its own style. This carousel was inspired by [Format](https://format.com/themes#horizon).

See [Installation](https://wordpress.org/plugins/photographers-galleries/installation/) tab for use details.

= Exhibitions =

Exhibitions are a new mode of the 1.0 that enables a full-width and full-height experience with a framing look reproducing museum framings.

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

= Upcoming features =

We are in dev phase so kep in touch. If you are a dev, you are welcome to contribute !

1. A theme template part for attachments taxonomies archives,
1. A bulk edit option to add multiple images in batch to attachments taxonomies (thus galleries),
1. A hook to add taxonomies directly in the post editor (while uploading them) without Media Library Assistant (overkill) plugin,
1. Workarounds with Exifography plugin to build dynamic galleries based on Exif metadata (shot date, ISO, aperture, camera, GPS, etc.).

= Coding philosophy =

**1. Never overwrite WordPress core functions** : that's nasty and garanteed to break other plugins now or in the future.
Moreover, as soon as these WP functions will be rewritten, our code would be obsolete. You would be suprised to know how many
plugins overwrite the native `[gallery]` shortcode, for example. That's bad.
All we do is building around WP core with wrappers, passing to them the right inputs and getting the right outputs.

**2. Separating the form and the content** : that means that you will always be able to use your own style over PG's one while
using it without nasty tricks (usefull for theme developpers). We will use filters as much as possible so themes developpers
could modify them on the fly.

**3. Never have a settings page*** : we will always add options on standard WP admin pages so you should never have to mess up
with complex settings. The paradigm choosen is very similar to the 500 px or Flickr one, keeping in mind the professional photographer needs.
So let's stuck to something you already know : WP default interface.

**4. Build on top of WordPress** : my secret wish is to get this functions natively into WordPress core so we will keep it
modular.

**5. Every part of the code is commented with docstrings** : because I code for others.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

The plugin has no configuration page.

= Dynamic gallery =

This shortcode fetches all the pictures from a taxonomy (galleries, models, locations, tags) to build a dynamic gallery
(which will be updated as soon as you add a picture to the corresponding taxonomy). All the display is processed by the regular
WordPress shortcode, we just give it the pictures to show (meaning that your default styles, Jetpack, lightboxes etc. will work).

1. Create a regular WordPress gallery on the desired page with the desired settings and dumb content
1. Switch to the text editor in your post. You should see something like `[gallery size="full" link="file" type="rectangular" ids="4127,4126"]`
1. Strip the `ids` argument and rename the shortcode `dynamic_gallery` like `[dynamic_gallery size="full" link="file" type="rectangular"]`
1. Add the desired taxonomy as an argument, for example `gallery="portraits"`. You can add several conditions and use any of the galleries wrappers below.
1. Tweak it with more arguments.

** Example ** : `[dynamic_gallery gallery='portraits' location='montreal' size="full" link="file" columns='4']`

**Arguments** :

* DISPLAY ARGUMENTS *optionnal*
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

By default, pictures of different heights are aligned along their top border. To align them along their bottom border
(meaning to have all the captions on the same line), use the `[aligncaption]` shortcode like this : `[aligncaption][gallery ids=""][/aligncaption]`.
Please be aware that other galleries types may be more suitable if you have different heights on the same gallery (e.g. tiled or masonry galleries),
this is just a quick hook to improve captions readability.

= Galleries without caption =

**Photographers galleries** allows you to display galleries without image captions even if they have one stored in the database. The fact is if you delete or alter the caption of a picture in a WordPress gallery, the media will be altered too in the database and probably elsewhere if you used it on another page, which might be a problem. Here, we will just hide it.

Put your gallery shortcode in a `[nocaption]` shortcode like this : `[nocaption][gallery ids=""][/nocaption]`

= Carousel =

Just put your regular gallery shortcode in `[carousel]` shortcode like this : `[carousel][gallery ids=""][/carousel]`

Ensure your picture resolution is high enough to fit modern screens without stretching (2048 px on the large side is recommended).

**Example of use** :
`
[carousel w="50%" h="66vh" align="left" caption="hide" title="Fancy"]
[gallery size="large" link="file" ids=""]
[/carousel]
`

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

== Other notes ==

= Configuring Media Library Assistant for PG =

1. Go to "General tab"
1. Go to the "Taxonomy Support" option
1. For "Galleries", "Locations", "Models", check all the checkboxes of the line
1. Strings are ready to translate

== Screenshots ==

[Live Demo with real pictures](https://photo.aurelienpierre.com/photographers-galleries-demo/)


== Changelog ==

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

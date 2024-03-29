<?php
/**
 * Photographers galleries
 *
 * Enhance your galleries with HTML5, metadata, dynamic galleries and add a lightweight carousel to display a sequence of pictures without distractions.
 *
 * @package   Photographers galleries
 * @author    Aurélien PIERRE <contact@aurelienpierre.com>
 * @license   GPL-2.0+
 * @link      https://wordpress.org/plugins/photographers-galleries/
 * @copyright 2016-2022 Aurélien Pierre
 *
 * @wordpress-plugin
 * Plugin Name: Photographers galleries
 * Plugin URI:  https://wordpress.org/plugins/photographers-galleries/
 * Description: Enhance your galleries with HTML5, metadata, dynamic galleries and add a lightweight carousel to display a sequence of pictures without distractions.
 * Version:     1.1.8
 * Author:      Aurélien PIERRE
 * Author URI:  https://photo.aurelienpierre.com
 * Text Domain: photographers-galleries
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register CSS
 *
 * The styles are loaded with a priority of 10 	:
 * 	* to override the gallery styles of your theme, ensure your theme loads its own stylesheet with a greater priority (> 20),
 * 	* to have these galleries styles overwritten by your custom stylesheet, either :
 * 		* deregister pg-css (but ensure you redefined all the styles) and register your own CSS sheet instead,
 *		* load your custom style with a larger priority (> 10).
*/


// scripts are enqueued from shortcodes, that run at priority 20, so they need to be declared before
add_action('wp_enqueue_scripts', 'register_pg_styles', 10 );

function register_pg_styles() {
  wp_register_style('pg-css', plugin_dir_url( __FILE__ ).'css/pg-style.min.css', array(), '1.1.8');
  wp_register_script('pg-js', plugin_dir_url( __FILE__ ).'js/pg-script.min.js', array(), '1.1.8', true);
}

// this parses the post content with a regex for clever on-demand loading, so it needs to come very late
add_filter('the_content', 'enqueue_photographers_galleries', 100);
function enqueue_photographers_galleries( $content )
{
  // Look for class="gallery" in post and load the CSS only if we have it
  if(preg_match('/<(div|section).*class=([\'\"]).*gallery.*\1.*>/s', $content))
  {
    wp_enqueue_style('pg-css');
  }
  return $content;
}

/*
 * Use HTML5 markup for galleries
*/

function pg_theme_setup() {
	add_theme_support( 'html5', array( 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'pg_theme_setup' );


/*
 * Class to track the number of carousels on a page
*/

class pg_Carousels {
    public static $counter = 0;

    function __construct() {
        self::$counter++;
    }
}

/*
 * Register shortcodes
*/
include_once('includes/shortcodes.php');

/*
 * Register taxonomies
 */
include_once('includes/taxonomies.php');


/*
* Add some other capabilities to attachments
*/

function pg_add_attachment_support() {
    $cap = array('title', 'author', 'custom-fields', 'comments' );
	add_post_type_support( 'attachment', $cap );
}
add_action( 'init', 'pg_add_attachment_support' );

/*
 * Improve media library admin page
 */
include_once('admin/media-admin.php');

/*
 * Add custom sizes for responsive images
 */
add_action( 'after_setup_theme', 'pg_custom_add_image_sizes' );
function pg_custom_add_image_sizes() {

  /*
  https://www.w3counter.com/globalstats.php
  repartition :
  1 	1366x768 	10.09%
  2 	640x360 	9.43%
  3 	1920x1080 	7.32%
  4 	667x375 	5.06%
  5 	896x414 	4.44%
  6 	1024x768 	4.00%
  7 	812x375 	3.54%
  8 	780x360 	3.26%
  9 	760x360 	2.93%
  10 	1440x900 	2.90%
  */

  add_image_size( 'portrait-7680', '7680', '0', false ); // 8K
  add_image_size( 'portrait-4096', '4096', '0', false ); // 4K cinema
  add_image_size( 'portrait-3840', '3840', '0', false ); // 4K
  add_image_size( 'portrait-2560', '2560', '0', false ); // QHD / WQHD
  add_image_size( 'portrait-2048', '2048', '0', false ); // 2K
  add_image_size( 'portrait-1920', '1920', '0', false ); // Full HD
  add_image_size( 'portrait-1680', '1680', '0', false ); // Desktop WSXGA+
  add_image_size( 'portrait-1440', '1440', '0', false ); // Desktop WXGA+
  add_image_size( 'portrait-1366', '1366', '0', false ); // HD-ish
  add_image_size( 'portrait-1280', '1280', '0', false ); // WXGA - HD
  add_image_size( 'portrait-1080', '1080', '0', false ); // Full HD height
  add_image_size( 'portrait-960', '960', '0', false );   // DVGA - iPhone 4
  add_image_size( 'portrait-800', '800', '0', false );   // WXGA - HD height
  add_image_size( 'portrait-640', '640', '0', false );   // VGA - Standard definition
  add_image_size( 'portrait-480', '480', '0', false );   // HVGA - Palm, iPhone 1
  add_image_size( 'portrait-360', '360', '0', false );   // Old stuff
  add_image_size( 'portrait-240', '240', '0', false );   // Very old stuff

  // panoramic images
  add_image_size( 'landscape-7680', '0', '7680', false ); // 8K
  add_image_size( 'landscape-4096', '0', '4096', false ); // 4K cinema
  add_image_size( 'landscape-3840', '0', '3840', false ); // 4K
  add_image_size( 'landscape-2560', '0', '2560', false ); // QHD / WQHD
  add_image_size( 'landscape-2048', '0', '2048', false ); // 2K
  add_image_size( 'landscape-1920', '0', '1920', false ); // Full HD
  add_image_size( 'landscape-1680', '0', '1680', false ); // Desktop WSXGA+
  add_image_size( 'landscape-1440', '0', '1440', false ); // Desktop WXGA+
  add_image_size( 'landscape-1366', '0', '1366', false ); // HD-ish
  add_image_size( 'landscape-1280', '0', '1280', false ); // WXGA - HD
  add_image_size( 'landscape-1080', '0', '1080', false ); // Full HD height
  add_image_size( 'landscape-960', '0', '960', false );   // DVGA - iPhone 4
  add_image_size( 'landscape-800', '0', '800', false );   // WXGA - HD height
  add_image_size( 'landscape-640', '0', '640', false );   // VGA - Standard definition
  add_image_size( 'landscape-480', '0', '480', false );   // HVGA - Palm, iPhone 1
  add_image_size( 'landscape-360', '0', '360', false );   // Old stuff
  add_image_size( 'landscape-240', '0', '240', false );   // Very old stuff

  // square images
  add_image_size( 'square-7680', '7680', '7680', true ); // 8K
  add_image_size( 'square-4096', '4096', '4096', true ); // 4K cinema
  add_image_size( 'square-3840', '3840', '3840', true ); // 4K
  add_image_size( 'square-2560', '2560', '2560', true ); // QHD / WQHD
  add_image_size( 'square-2048', '2048', '2048', true ); // 2K
  add_image_size( 'square-1920', '1920', '1920', true ); // Full HD
  add_image_size( 'square-1680', '1680', '1680', true ); // Desktop WSXGA+
  add_image_size( 'square-1440', '1440', '1440', true ); // Desktop WXGA+
  add_image_size( 'square-1366', '1366', '1366', true ); // HD-ish
  add_image_size( 'square-1280', '1280', '1280', true ); // WXGA - HD
  add_image_size( 'square-1080', '1080', '1080', true ); // Full HD height
  add_image_size( 'square-960', '960', '960', true );   // DVGA - iPhone 4
  add_image_size( 'square-800', '800', '800', true );   // WXGA - HD height
  add_image_size( 'square-640', '640', '640', true );   // VGA - Standard definition
  add_image_size( 'square-480', '480', '480', true );   // HVGA - Palm, iPhone 1
  add_image_size( 'square-360', '360', '360', true );   // Old stuff
  add_image_size( 'square-240', '240', '240', true );   // Very old stuff
}


// add some images sizes in GUI -> only the largest sizes, since real sizes are responsive
add_filter( 'image_size_names_choose', 'pg_custom_add_image_size_names' );

function pg_custom_add_image_size_names( $sizes ) {
  return array_merge( $sizes, array(
    'square-7680' => __( 'Responsive square' ),
  ) );
}

// Use a quality setting of 90 for WebP images.
// 75 is clearly not enough for photographs.
function filter_webp_quality( $quality, $mime_type ) {
  if ( 'image/webp' === $mime_type ) {
     return 90;
  }
  return $quality;
}
add_filter( 'wp_editor_set_quality', 'filter_webp_quality', 10, 2 );

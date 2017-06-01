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
 * @copyright 2016 Aurélien Pierre
 *
 * @wordpress-plugin
 * Plugin Name: Photographers galleries
 * Plugin URI:  https://wordpress.org/plugins/photographers-galleries/
 * Description: Enhance your galleries with HTML5, metadata, dynamic galleries and add a lightweight carousel to display a sequence of pictures without distractions.
 * Version:     0.4.2
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

$VERSION = '0.4.2';

/**
 * Register CSS
 * 
 * The styles are loaded with a priority of 20 	:
 * 	* to override the gallery styles of your theme, ensure your theme loads its own stylesheet with a greater priority (> 20),
 * 	* to have these galleries styles overwritten by your custom stylesheet, either :
 * 		* deregister pg-css (but ensure you redefined all the styles) and register your own CSS sheet instead,
 *		* load your custom style with a smaller priority (< 20).
*/

$PRIORITY = 20;

function register_pg_styles() {
        wp_register_style( 'pg-css', plugins_url( 'photographers-galleries/css/pg-style.css', $VERSION));
        wp_enqueue_style( 'pg-css' );
}
add_action( 'wp_enqueue_scripts', 'register_pg_styles', $PRIORITY );


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
include 'includes/shortcodes.php';

/*
 * Register taxonomies
 */
include 'includes/taxonomies.php';


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
include 'admin/media-admin.php';


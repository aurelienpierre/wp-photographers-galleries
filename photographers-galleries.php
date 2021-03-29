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
 * @copyright 2016-2021 Aurélien Pierre
 *
 * @wordpress-plugin
 * Plugin Name: Photographers galleries
 * Plugin URI:  https://wordpress.org/plugins/photographers-galleries/
 * Description: Enhance your galleries with HTML5, metadata, dynamic galleries and add a lightweight carousel to display a sequence of pictures without distractions.
 * Version:     0.5.15
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

$VERSION = '0.5.2';

/**
 * Register CSS
 *
 * The styles are loaded with a priority of 20 	:
 * 	* to override the gallery styles of your theme, ensure your theme loads its own stylesheet with a greater priority (> 20),
 * 	* to have these galleries styles overwritten by your custom stylesheet, either :
 * 		* deregister pg-css (but ensure you redefined all the styles) and register your own CSS sheet instead,
 *		* load your custom style with a smaller priority (< 20).
*/

add_action('wp_enqueue_scripts', 'register_pg_styles', 20 );
function register_pg_styles() {
  wp_register_style('pg-css', plugins_url('photographers-galleries/css/pg-style.min.css'), array(), '0.5.15');
  wp_register_script('pg-js', plugins_url('photographers-galleries/js/pg-script.min.js'), array(), '0.5.14', false);
}

add_filter('the_content', 'enqueue_photographers_galleries', 100);
function enqueue_photographers_galleries( $content )
{
  // Look for class="gallery" in post and load the CSS only if we have it
  if(preg_match('/<(div|section).*class=([\'\"]).*gallery.*\1.*>/s', $content))
  {
    wp_enqueue_style('pg-css');
    wp_enqueue_script('pg-js');
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


function remove_post_custom_fields() {
	remove_meta_box( 'attachment-compat' , 'attachment' , 'normal' );
}
add_action( 'admin_menu' , 'remove_post_custom_fields' );

function add_media_categories($fields, $post) {
    $categories = get_categories(array('taxonomy' => 'model', 'hide_empty' => 0));
    $post_categories = wp_get_object_terms($post->ID, 'model', array('fields' => 'ids'));
    $all_cats .= '<ul id="media-categories-list" style="width:500px;">';
    foreach ($categories as $category) {
        if (in_array($category->term_id, $post_categories)) {
            $checked = ' checked="checked"';
        } else {
            $checked = '';
        }
        $option = '<li style="width:240px;float:left;"><input type="checkbox" value="'.$category->category_nicename.'" id="'.$post->ID.'-'.$category->category_nicename.'" name="'.$post->ID.'-'.$category->category_nicename.'"'.$checked.'> ';
        $option .= '<label for="'.$post->ID.'-'.$category->category_nicename.'">'.$category->cat_name.'</label>';
        $option .= '</li>';
        $all_cats .= $option;
    }
    $all_cats .= '</ul>';

    $categories = array('all_categories' => array (
            'label' => __('Models'),
            'input' => 'html',
            'html' => $all_cats
    ));
    return array_merge($fields, $categories);
}
add_filter('attachment_fields_to_edit', 'add_media_categories', null, 2);

function add_image_attachment_fields_to_save($post, $attachment) {
    $categories = get_categories(array('taxonomy' => 'model', 'hide_empty' => 0));
    $terms = array();
    foreach($categories as $category) {
        if (isset($_POST[$post['ID'].'-'.$category->category_nicename])) {
            $terms[] = $_POST[$post['ID'].'-'.$category->category_nicename];
        }
    }
    wp_set_object_terms( $post['ID'], $terms, 'model' );
    return $post;
}
add_filter('attachment_fields_to_save', 'add_image_attachment_fields_to_save', null , 2);

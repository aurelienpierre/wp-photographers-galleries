<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*
 * Create a gallery taxonomy for attachements
 */

function pg_add_gallery_taxonomy() {
	$labels = array(
			'name'              => __('Galleries', 'photographers-galleries'),
			'singular_name'     => __('Gallery', 'photographers-galleries'),
			'search_items'      => __('Search Galleries', 'photographers-galleries'),
			'all_items'         => __('All Galleries'),
			'parent_item'       => __('Parent Galleries', 'photographers-galleries'),
			'parent_item_colon' => __('Parent Galleries:', 'photographers-galleries'),
			'edit_item'         => __('Edit Gallery', 'photographers-galleries'),
			'update_item'       => __('Update Gallery', 'photographers-galleries'),
			'add_new_item'      => __('Add New Gallery', 'photographers-galleries'),
			'new_item_name'     => __('New Gallery Name', 'photographers-galleries'),
			'menu_name'         => __('Galleries', 'photographers-galleries'),
	);

	$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'query_var' => true,
			'rewrite' => true,
			'show_ui' => true,
			'public' => true,
			'show_admin_column' => true,
	);

	register_taxonomy( 'gallery', 'attachment', $args );
}
add_action( 'init', 'pg_add_gallery_taxonomy' );


/*
 * Create a location taxonomy for attachements
 */

function pg_add_location_taxonomy() {
	$labels = array(
			'name'              => __('Locations', 'photographers-galleries'),
			'singular_name'     => __('Location', 'photographers-galleries'),
			'search_items'      => __('Search Locations', 'photographers-galleries'),
			'all_items'         => __('All Locations', 'photographers-galleries'),
			'parent_item'       => __('Parent Locations', 'photographers-galleries'),
			'parent_item_colon' => __('Parent Locations:', 'photographers-galleries'),
			'edit_item'         => __('Edit Location', 'photographers-galleries'),
			'update_item'       => __('Update Location', 'photographers-galleries'),
			'add_new_item'      => __('Add New Location', 'photographers-galleries'),
			'new_item_name'     => __('New Location Name', 'photographers-galleries'),
			'menu_name'         => __('Locations', 'photographers-galleries'),
	);

	$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'query_var' => true,
			'rewrite' => true,
			'show_ui' => true,
			'public' => true,
			'show_admin_column' => true,
	);

	register_taxonomy( 'location', 'attachment', $args );
}
add_action( 'init', 'pg_add_location_taxonomy' );


/*
 * Create a model taxonomy for attachements
 */

function pg_add_model_taxonomy() {
	$labels = array(
			'name'              => __('Models', 'photographers-galleries'),
			'singular_name'     => __('Model', 'photographers-galleries'),
			'search_items'      => __('Search Models', 'photographers-galleries'),
			'all_items'         => __('All Models', 'photographers-galleries'),
			'parent_item'       => __('Parent Models', 'photographers-galleries'),
			'parent_item_colon' => __('Parent Models:', 'photographers-galleries'),
			'edit_item'         => __('Edit Model', 'photographers-galleries'),
			'update_item'       => __('Update Model', 'photographers-galleries'),
			'add_new_item'      => __('Add New Model', 'photographers-galleries'),
			'new_item_name'     => __('New Model Name', 'photographers-galleries'),
			'menu_name'         => __('Models', 'photographers-galleries'),
	);

	$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'query_var' => true,
			'rewrite' => true,
			'show_ui' => true,
			'public' => true,
			'show_admin_column' => true,
	);

	register_taxonomy( 'model', 'attachment', $args );
}
add_action( 'init', 'pg_add_model_taxonomy' );


/*
 * Enable post categories and tags for attachements
 */

function pg_add_categories_to_attachments() {
	register_taxonomy_for_object_type( 'category', 'attachment' );
	register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'pg_add_categories_to_attachments' );

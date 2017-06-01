<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*
 * Carousel gallery
 */ 

function pg_carousel( $atts, $content ){
	/**
	 * This shortcode is just intended to add classes to the gallery wrapper div
	 * Optionnaly, it adds a custom height and width to the unique carousel
	 */

	// Set the container ID
	new pg_Carousels();
	$id = "pg-carousel-" . pg_Carousels::$counter;


	// Extract the shortcode attributes
	$a = shortcode_atts(
			array(
					'w' => '',
					'h' => '',
					'align' => 'none',
					'title' => '',
					'caption' => 'below',
					'raw_css' => '',
			),
			$atts );

	// Floating options
	$class = "align" . $a['align'];

	// Caption style
	if ( $a['caption'] == 'below' ) 	{ $class = $class . " pg-show_caption"; }
	if ( $a['caption'] == 'hide' ) 		{ $class = $class . " pg-no_caption"; }
	if ( $a['caption'] == 'hover' ) 	{ $class = $class . " pg-hover_caption"; }

	// Unique style if given : custom height and width, raw CSS code
	$style = '';
	
	if ( !empty( $a['h'] ) || !empty( $a['w'] ) || !empty( $a['raw_css'] ) ) { 
		$style = "<style> ";
			if ( !empty( $a['h'] ) ) { $style = $style . "#" . $id . " img { height: " . $a['h'] . ";} "; }
			if ( !empty( $a['w'] ) ) { $style = $style . "#" . $id . " { width: " . $a['w'] . ";} "; }
			$style = $style . $a['raw_css'];
		$style = $style . " </style>"; 
	}

	// Open markup
	$before = "<div class='pg-carousel-wrapper'><section class='pg-carousel " . $class . "' id='" . $id . "' >";

	// Optional title
	if ( !empty($a['title']) ) { $before = $before . "<header>" . $a['title'] . "</header>"; }

	// Content
	$inside = do_shortcode( strip_tags( $content ) );

	// Closing markup
	$after = "</section></div>";

	return $style . $before . $inside . $after;
}
add_shortcode( 'carousel', 'pg_carousel' );


/*
 * Gallery with no caption
 */ 

function pg_no_caption( $atts, $content ){
	$before = "<div class='pg-no_caption'>";
	$inside = do_shortcode( strip_tags( $content ) );
	$after = "</div>";
	return $before . $inside . $after;
}
add_shortcode( 'nocaption', 'pg_no_caption' );


/* 
 * Gallery where pictures are aligned along the bottom side
 */

function pg_align_caption( $atts, $content ){
	$before = "<div class='pg-align_caption'>";
	$inside = do_shortcode( strip_tags( $content ) );
	$after = "</div>";
	return $before . $inside . $after;
}
add_shortcode( 'aligncaption', 'pg_align_caption' );


/*
 * Dynamic gallery based on taxonomy
 */

function pg_dynamic_gallery( $atts ){
	
	// Extract the shortcode attributes
	$a = shortcode_atts(
			array(	// Plugin specific keys
					'gallery' => '',
					'model' => '',
					'location' => '',
					'exif' => '',
					'author' => '',
					'tag' => '',
					// Standard WP Query keys
					'orderby' => 'date',
					'order' => 'ASC',
					// Stardard WP gallery shortcode keys
					'columns' => '',
					'size' => '',
					'link' => '',
					'type' => '' // for compatibility with Jetpack tiled galleries
			),
			$atts );
	
	// Prepare the query
	$args = array(
			'post_type' => 'attachment',
			'post_parent' => 'null',
			'post_per_page' => -1,
			'author_name' => $a['author'],
			'tag' => $a['tag'],
			'orderby' => $a['orderby'],
			'order' => $a['order'],
			'perm'        => 'readable',
			'tax_query' => array('relation' => 'AND'),
			'post_mime_type'    => array( 
					'image/jpeg', 
					'image/jpg',
					'image/gif', 
					'image/png', 
					'image/bmp' 
			),
			'fields' => 'ids',
	);
	
	// Add the gallery
	if ( !empty( $a['gallery'] ) ) {
		$gal = array(
			'taxonomy' => 'gallery',
			'field'    => 'slug',
			'terms'    => $a['gallery']
		);
		array_push( $args['tax_query'] , $gal);
	}
	
	// Add the model
	if ( !empty( $a['model'] ) ) {
		$mod = array(
	 		'taxonomy' => 'model',
			'field'    => 'slug',
			'terms'    => $a['model']
		);
		array_push( $args['tax_query'] , $mod);
		
	}
	
	// Add the location
	if ( !empty( $a['location'] ) ) {
		$loc = array(
			'taxonomy' => 'location',
			'field'    => 'slug',
			'terms'    => $a['location']
		);
		array_push( $args['tax_query'] , $loc);
	}
	
	// The query
	$images = get_children( $args );

	if ( empty($images) ) {
		
		return __('No image found', 'photographers-galleries');
		
	} else {
		// Extract the relevant images IDS
		$ids = implode ( ',', array_values( $images ) );
		
		// Build the args array for WP gallery
		$args = array(
				'ids' => $ids,
				'size' => $a['size'],
				'columns' => $a['columns'],
				'link' => $a['link'],
				'type' => $a['type'] // for compatibility with Jetpack themes
		);
		
		// Print the standard WP gallery
		return gallery_shortcode( $args );
	}
	
	// Restore original Post Data
	wp_reset_postdata();
	
}
add_shortcode( 'dynamic_gallery', 'pg_dynamic_gallery' );

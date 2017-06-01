<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( is_admin() ):

/* 
 * Display exif tags in media library
 * Credit : Kevin Chard http://wpsnipp.com/index.php/functions-php/display-exif-metadata-in-media-library-admin-column/
 */

add_filter('manage_media_columns', 'posts_columns_attachment_exif', 1);
add_action('manage_media_custom_column', 'posts_custom_columns_attachment_exif', 1, 2);

function posts_columns_attachment_exif( $defaults ){
	$defaults['wps_post_attachments_exif'] = __( 'EXIF' );
	return $defaults;
}

function posts_custom_columns_attachment_exif( $column_name, $id ){
	if( $column_name === 'wps_post_attachments_exif' ) {
		
		$meta = wp_get_attachment_metadata( $id );
		$time_format = get_option( 'date_format' ) . " – H:i:s";
		
		if( !empty( $meta[image_meta][camera] ) ) {
			echo date_i18n( $time_format , $meta[image_meta][created_timestamp] ) ."<hr />";
			echo $meta[image_meta][camera] . " | ";
			echo $meta[image_meta][focal_length] . " mm<hr />";
			echo "F/" . $meta[image_meta][aperture]	. " – ";
			echo "ISO " . $meta[image_meta][iso] . " – ";
			echo "1/" . round(1 / floatval($meta[image_meta][shutter_speed])) .	"<hr />";
			echo $meta[image_meta][copyright]. " | ";
			echo $meta[image_meta][credit];
		}
	}
}

endif;
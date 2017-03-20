<?php
/*
Plugin Name: Сustom fields for categories
Plugin URI:
Description: Произвольные поля для таксономии категории
Version: 1.0
Author: Цимбал Олег
Author URI: https://github.com/geralt2008
License: GPL2
*/

define( 'CUSTOM_FIELDS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( CUSTOM_FIELDS__PLUGIN_DIR . 'CustomFields.php' );

$CustomFields = new CustomFields();
$CustomFields -> init();

function the_categories_description(  ) {
	if ( is_author() ) {
		$description = get_the_author_meta( 'description' );
	} else {
		$description = term_description();
	}
	if ( is_category() ) {
		// Get the current category ID, e.g. if we're on a category archive page
		$category = get_category( get_query_var( 'cat' ) );
		$cat_id   = $category->cat_ID;
		// Get the image ID for the category
		$image_id = get_term_meta( $cat_id, 'category-image-id', true );
		// Echo the image
		echo wp_get_attachment_image( $image_id, 'large' );
		echo wp_oembed_get( get_term_meta( $cat_id, 'category-video-link', true ), array('width' => 400) );
		echo $description;
	} else {
		echo $description;
	}
}
add_filter( 'get_the_archive_description', 'the_categories_description' );

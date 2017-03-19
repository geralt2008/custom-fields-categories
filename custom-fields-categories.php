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
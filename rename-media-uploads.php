<?php
/*
 * Plugin Name: Rename Media Uploads
 * Version: 1.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Hugh Lashbrooke
 * Author URI: http://www.hughlashbrooke.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: rename-media-uploads
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-rename-media-uploads.php' );
require_once( 'includes/class-rename-media-uploads-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-rename-media-uploads-admin-api.php' );
require_once( 'includes/lib/class-rename-media-uploads-post-type.php' );
require_once( 'includes/lib/class-rename-media-uploads-taxonomy.php' );

/**
 * Returns the main instance of Rename_Media_Uploads to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Rename_Media_Uploads
 */
function Rename_Media_Uploads () {
	$instance = Rename_Media_Uploads::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Rename_Media_Uploads_Settings::instance( $instance );
	}

	return $instance;
}

Rename_Media_Uploads();
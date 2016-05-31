<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { // If plugin is not being uninstalled, exit (do nothing)
	exit;
}

register_uninstall_hook(__FILE__, array( 'rename_media_uploads', 'uninstall' ) );

delete_site_option( 'rename_media_uploads' );
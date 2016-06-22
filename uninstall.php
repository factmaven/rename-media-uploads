<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { // If plugin is not being uninstalled, exit (do nothing)
	exit;
}

register_uninstall_hook(__FILE__, array( 'FCM_Rename_Media_Uploads', 'uninstall' ) );

delete_site_option( 'FCM_Rename_Media_Uploads' );
<?php
// If uninstall not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Clean up options added by plugin
delete_option( 'smmcare_api_key' );
delete_option( 'smmcare_company_name' );
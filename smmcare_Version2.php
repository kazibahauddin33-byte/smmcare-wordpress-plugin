<?php
/**
 * Plugin Name: SMMCARE
 * Plugin URI:  https://your-site.example.com/smmcare
 * Description: SMMCARE AI plugin — onboarding and integration utilities for SMMCARE SaaS.
 * Version:     0.1.0
 * Author:      Your Name
 * Author URI:  https://your-site.example.com
 * License:     GPLv2 or later
 * Text Domain: smmcare
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'SMMCARE_VERSION', '0.1.0' );
define( 'SMMCARE_PLUGIN_FILE', __FILE__ );
define( 'SMMCARE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SMMCARE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once SMMCARE_PLUGIN_DIR . 'includes/class-smmcare.php';

function smmcare_init_plugin() {
    $plugin = new SMMCARE\Plugin();
    $plugin->run();
}
add_action( 'plugins_loaded', 'smmcare_init_plugin' );
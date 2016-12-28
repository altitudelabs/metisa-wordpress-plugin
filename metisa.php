<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.askmetisa.com/
 * @since             1.0.0
 * @package           Metisa
 *
 * @wordpress-plugin
 * Plugin Name:       Metisa
 * Plugin URI:        http://example.com/metisa-uri/
 * Description:       Link your WP WooCommerce store data to Metisa for intelligent insights.
 * Version:           1.0.0
 * Author:            Altitude Labs
 * Author URI:        http://www.askmetisa.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       metisa
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-metisa-activator.php
 */
function activate_metisa() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-metisa-activator.php';
	Metisa_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-metisa-deactivator.php
 */
function deactivate_metisa() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-metisa-deactivator.php';
	Metisa_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_metisa' );
register_deactivation_hook( __FILE__, 'deactivate_metisa' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-metisa.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_metisa() {

	$plugin = new Metisa();
	$plugin->run();

}
run_metisa();

function log_me($message) {
	if (WP_DEBUG === true) {
		if (is_array($message) || is_object($message)) {
			error_log(print_r($message, true));
		} else {
			error_log($message);
		}
	}
}

function get_woocommerce_api_keys() {
	global $wpdb;

	// $offset = 0;
	// $per_page = apply_filters( 'woocommerce_api_keys_settings_items_per_page', 10 );
	$search = '';

	// Get the API keys
	$keys = $wpdb->get_results(
		"SELECT key_id, user_id, description, permissions, consumer_key, consumer_secret, last_access
		FROM {$wpdb->prefix}woocommerce_api_keys
		WHERE 1 = 1 {$search}",
		ARRAY_A
	);

	log_me('WOOCOMMERCE GET API KEYS DB RESULTS');
	log_me($keys);

	// foreach($keys as $key) {
	// 	foreach($key as $prop => $value) {
	// 		log_me($prop . ' ... : ' . $value);
	// 	}
	// }
}
// get_woocommerce_api_keys();

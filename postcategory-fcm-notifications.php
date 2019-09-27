<?php

/**
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.postcategory-fcm-notifications
 *
 * @link              https://github.com/EmilMfornyam/WordPress-Post-FCM-Plugin
 * @since             1.0.0
 * @package           WordPress-Post-FCM-Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Post Category FCM Notifications
 * Plugin URI:        https://github.com/EmilMfornyam/WordPress-Post-FCM-Plugin
 * Description:       Send FCM notifications from specific catergories.
 * Version:           1.0.0
 * Author:            Mfornyam Emil
 * License:           GNU v3.0
 * License URI:       https://github.com/EmilMfornyam/WordPress-Post-FCM-Plugin/blob/master/LICENSE
 * Text Domain:       postcategory-fcm-notifications
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define('PCFCM_VERSION', '1.0.0' );
	
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_PCFCM() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-postcategory-fcm-notifications-activator.php';
	PCFCM_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_PCFCM() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-postcategory-fcm-notifications-deactivator.php';
	PCFCM_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_PCFCM' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_PCFCM' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-postcategory-fcm-notifications.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_PCFCM() {

	$plugin = new Post_Category_FCM_Notifications();
	$plugin->run();

}
run_plugin_PCFCM();

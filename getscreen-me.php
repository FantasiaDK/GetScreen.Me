<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.qcompany.dk
 * @since             1.0.0
 * @package           GetScreenMe
 *
 * @wordpress-plugin
 * Plugin Name:       GetScreen.Me Customer initiation plugin
 * Plugin URI:        http://getscreen.me
 * Description:       This plugin lets you create a client facing invitation, so the customer can initiate a session.
 * Version:           1.0.0
 * Author:            QCompany / Michael Dyhr Iversen
 * Author URI:        http://qcompany.dk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       GetScreenMe
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GETSCREEN_ME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-getscreen-me-activator.php
 */
function activate_getscreen_me() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-getscreen-me-activator.php';
	GetScreen_Me_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-getscreen-me-deactivator.php
 */
function deactivate_getscreen_me() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-getscreen-me-deactivator.php';
	GetScreen_Me_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_getscreen_me' );
register_deactivation_hook( __FILE__, 'deactivate_getscreen_me' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-getscreen-me.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_getscreen_me() {

	$plugin = new GetScreen_Me();
	$plugin->run();

}
run_getscreen_me();

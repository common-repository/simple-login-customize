<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              apsaraaruna.com
 * @since             1.0.2
 * @package           Simple_Login_Customize
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Login Customize
 * Plugin URI:        https://wordpress.org/plugins/simple-login-customize
 * Description:       This is a created for easily customize your login page.
 * Version:           1.0.2
 * Author:            Apsara Aruna
 * Author URI:        apsaraaruna.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-login-customize
 * Domain Path:       /languages
 */

// if   this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SLC_WHITE_LABEL_VERSION', '1.0.2');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-login-customize-activator.php
 */
function activate_slc_white_label() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-simple-login-customize-activator.php';
	Simple_Login_Customize_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-login-customize-deactivator.php
 */
function deactivate_slc_white_label() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-simple-login-customize-deactivator.php';
	Simple_Login_Customize_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_slc_white_label');
register_deactivation_hook(__FILE__, 'deactivate_slc_white_label');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specif  ic hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-simple-login-customize.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page lif  e cycle.
 *
 * @since    1.0.0
 */
function run_slc_white_label() {

	$plugin = new Simple_Login_Customize();
	$plugin->run();
}
run_slc_white_label();

<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       apsaraaruna.com
 * @since      1.0.0
 *
 * @package    Simple_Login_Customize
 * @subpackage Simple_Login_Customize/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Simple_Login_Customize
 * @subpackage Simple_Login_Customize/includes
 * @author     Apsara Aruna <info@apsaraaruna.com>
 */
class Simple_Login_Customize_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'simple-login-customize',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

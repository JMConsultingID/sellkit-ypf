<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://yourpropfirm.com/
 * @since      1.0.0
 *
 * @package    Sellkit_Ypf
 * @subpackage Sellkit_Ypf/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sellkit_Ypf
 * @subpackage Sellkit_Ypf/includes
 * @author     Ardika JM Consulting <ardi@jm-consulting.id>
 */
class Sellkit_Ypf_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sellkit-ypf',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

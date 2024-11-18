<?php
/**
 * This file contains the Internalization class which is responsible for loading the plugin text domain for translation.
 *
 * @package Apollo
 * @subpackage Core
 * @since 1.0.0
 */

namespace Apollo\Core;

/**
 * Class Internalization
 *
 * This class is responsible for loading the plugin text domain for translation.
 *
 * @package Apollo
 * @subpackage Core
 * @since 1.0.0
 */
class Internalization {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * This method is used to load the plugin text domain for translation.
	 *
	 * @since 1.0.0
	 */
	public static function load() {
		\load_plugin_textdomain( 'apollo', false, APOLLO_FILE . '/languages/' );
	}
}

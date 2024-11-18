<?php
/**
 * Plugin Name:       Apollo
 * Plugin URI:        wparray.com
 * Description:       Apollo is a boilerplate template for creating modern WordPress plugins.
 * Version:           1.0.0
 * Author:            wparray
 * Author URI:        wparray.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       apollo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Include the Init class
// This class is responsible for initializing the plugin.
use Apollo\Core\Init;
use Apollo\Core\Activator;
use Apollo\Core\Deactivator;
use Apollo\Core\Internalization;

// Include the Composer autoload file.
// This file is responsible for loading all the classes and dependencies.
require __DIR__ . '/vendor/autoload.php';

/**
 * Global Definitions.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'APOLLO_NAME', 'apollo' );
define( 'APOLLO_VERSION', '1.0.0' );
define( 'APOLLO_FILE', __FILE__ );
define( 'APOLLO_PLUGIN_DIR', trailingslashit( dirname( APOLLO_FILE ) ) );
define( 'APOLLO_PLUGIN_URL', trailingslashit( plugin_dir_url( APOLLO_FILE ) ) );
define( 'APOLLO_PLUGIN_BASE', plugin_basename( APOLLO_FILE ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
register_activation_hook( __FILE__, function () {
	Activator::run();
} );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
register_deactivation_hook( __FILE__, function () {
	Deactivator::run();
} );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
add_action( 'plugins_loaded', function () {
	Internalization::load();
	Init::instance();
} );

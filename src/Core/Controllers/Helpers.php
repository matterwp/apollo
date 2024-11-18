<?php
/**
 * Helpers class
 *
 * This class is responsible for providing helper functions.
 *
 * @package Apollo
 * @subpackage Core
 * @since 1.0.0
 */
namespace Apollo\Core;

final class Helpers {
	/**
	 * Icon directory
	 * @var string
	 */
	private static $icon_dir = APOLLO_PLUGIN_URL . 'dist/icons/';

	/**
	 * Get template
	 *
	 * @param string $file The file name.
	 * @param string $type The type of template.
	 *
	 * @return string
	 */
	public static function get_template( $file, $type = 'admin' ) {
		$file = APOLLO_PLUGIN_DIR . 'templates/' . $type . '/' . $file . '.php';
		if ( file_exists( $file ) ) {
			include_once $file;
		}
		return '';
	}

	/**
	 * Get icon
	 *
	 * @param string $icon The icon name.
	 * @param string $type The type of icon.
	 *
	 * @return void
	 */
	public static function get_icon( $icon, $type = 'inline' ) {
		$icon_path = esc_attr( self::$icon_dir ) . esc_attr( $icon ) . '.svg';
		if ( $type === 'inline' ) {
			echo file_get_contents( $icon_path );
		} else {
			echo '<img src="' . $icon_path . '">';
		}
	}
}

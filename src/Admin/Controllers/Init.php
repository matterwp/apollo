<?php
/**
 *
 * Plugin Main Class
 *
 * This class is responsible for initializing the admin side of the plugin.
 *
 * @package Apollo
 * @subpackage Admin
 * @since 1.0.0
 */

namespace Apollo\Admin;

use Apollo\Core\Helpers;

class Init {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The Instance
	 *
	 * @since 1.0.0
	 * @access   protected
	 * @var boolean
	 */
	private static $_instance = null;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->initializePlugin();
		$this->setupAdminActions();
	}

	/**
	 * Instance of the class.
	 * @return void
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
	}

	/**
	 * Initialize the plugin.
	 * @return void
	 */
	private function initializePlugin() {
		$this->version     = defined( 'APOLLO_VERSION' ) ? APOLLO_VERSION : '1.0.0';
		$this->plugin_name = defined( 'APOLLO_NAME' ) ? APOLLO_NAME : 'apollo';
	}

	/**
	 * Setup the admin actions.
	 * @return void
	 */
	private function setupAdminActions() {
		add_action( 'admin_menu', [ $this, 'addPluginAdminMenu' ] );
		add_filter( 'plugin_action_links_' . APOLLO_PLUGIN_BASE, [ $this, 'addActionLinks' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueStyles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueScripts' ] );
	}

	/**
	 * Enqueue the admin styles.
	 * @return void
	 */
	public function enqueueStyles() {
		if ( ! $this->isPluginAdmin() ) {
			return;
		}
		wp_enqueue_style( $this->plugin_name, APOLLO_PLUGIN_URL . 'dist/css/admin.css', [], $this->version, 'all' );
	}

	/**
	 * Enqueue the admin scripts.
	 * @return void
	 */
	public function enqueueScripts() {
		if ( ! $this->isPluginAdmin() ) {
			return;
		}
		wp_enqueue_script( $this->plugin_name, APOLLO_PLUGIN_URL . 'dist/js/admin.js', [], $this->version, true );
	}

	/**
	 * Check if the current screen is the plugin admin.
	 * @return bool
	 */
	public function isPluginAdmin() {
		return str_contains( get_current_screen()->base, 'apollo' );
	}

	/**
	 * Add the plugin admin menu.
	 * @return void
	 */
	public function addPluginAdminMenu() {
		$this->addMenuPage( 'Apollo Welcome', 'apollo', 'displayPluginSetupPage' );
	}

	/**
	 * Add a menu page.
	 * @param string $title
	 * @param string $slug
	 * @param string $template
	 * @param string $type
	 * @param string $sub
	 * @param string $priority
	 * @return void
	 */
	public function addMenuPage( $title, $slug, $template, $type = 'page', $sub = 'apollo', $priority = '99' ) {
		$menuFunction = $this->getMenuFunction( $type );
		$menuFunction( $title, $title, 'manage_options', $slug, [ $this, $template ], $priority );
	}

	/**
	 * Get the menu function.
	 * @param string $type
	 * @return string
	 */
	private function getMenuFunction( $type ) {
		$menuFunctions = [ 
			'page' => 'add_options_page',
			'sub' => 'add_submenu_page',
			'menu' => 'add_menu_page'
		];
		return $menuFunctions[ $type ] ?? 'add_menu_page';
	}

	/**
	 * Add the plugin action links.
	 * @param array $links
	 * @return array
	 */
	public function addActionLinks( $links ) {
		$settingsLink = '<a href="' . esc_url( get_admin_url( null, 'options-general.php?page=apollo' ) ) . '"> ' . __( 'Settings', 'apollo' ) . '</a>';
		return array_merge( [ $settingsLink ], $links );
	}

	/**
	 * Display the plugin setup page.
	 * @return void
	 */
	public function displayPluginSetupPage() {
		Helpers::get_template( 'settings', 'admin' );
	}
}

<?php

namespace Apollo\Frontend;

class Init {
	/**
	 * The ID of this plugin.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $version;

	/**
	 * The Instance
	 *
	 * @since 1.0.0
	 * @var boolean
	 */
	private static $_instance = null;

	public function __construct() {
		$this->setPluginDetails();
		$this->loadStylesAndScripts();
	}

	/**
	 * Instance.
	 * @return void
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
	}

	/**
	 * Set plugin details.
	 * @return void
	 */
	private function setPluginDetails() {
		$this->version     = defined( 'APOLLO_VERSION' ) ? APOLLO_VERSION : '1.0.0';
		$this->plugin_name = defined( 'APOLLO_NAME' ) ? APOLLO_NAME : 'apollo';
	}

	/**
	 * Load styles and scripts.
	 * @return void
	 */
	private function loadStylesAndScripts() {
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * Load styles.
	 * @return void
	 */
	public function styles() {
		wp_enqueue_style( $this->plugin_name, APOLLO_PLUGIN_URL . 'dist/css/public.css', array(), $this->version, 'all' );
	}

	/**
	 * Load scripts.
	 * @return void
	 */
	public function scripts() {
		wp_enqueue_script( $this->plugin_name, APOLLO_PLUGIN_URL . 'dist/js/public.js', array(), $this->version, true );
	}
}
<?php
/**
 * This is the main plugin file, here we declare and call the important stuff
 *
 * @package     BlockStrap
 * @copyright   2022 AyeCode Ltd
 * @license     GPL-3.0+
 * @since       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: BlockStrap - Page Builder Blocks
 * Plugin URI: https://wpgeodirectory.com/
 * Description: BlockStrap - A FSE page builder for WordPress
 * Version: 0.0.1-dev
 * Author: AyeCode
 * Author URI: https://wpgeodirectory.com
 * Text Domain: blockstrap-blocks
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 6.1
 */


define( 'BLOCKSTRAP_BLOCKS_VERSION', '0.0.1-dev' );

/**
 * The BlockStrap Class
 */
final class BlockStrap {

	// The one true instance.
	private static $instance = null;

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof BlockStrap ) ) {
			self::$instance = new BlockStrap();
			self::$instance->setup_constants();

			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

			self::$instance->includes();
			self::$instance->init_hooks();

			do_action( 'blockstrap_loaded' );
		}

		return self::$instance;
	}

	private function init_hooks() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts'), 1000 );
	}

	public function enqueue_editor_scripts(){
		wp_enqueue_script(
			'blockstrap-blocks-filters',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/js/blockstrap-block-filters.js',
			array( 'wp-block-library', 'wp-element', 'wp-i18n' ), // required dependencies for blocks
			BLOCKSTRAP_BLOCKS_VERSION
		);

		wp_enqueue_style(
			'blockstrap-blocks-style',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/css/style.css',
			'',
			BLOCKSTRAP_BLOCKS_VERSION
		);

		wp_enqueue_style(
			'blockstrap-blocks-style-admin',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/css/block-editor.css',
			array( 'blockstrap-blocks-style' ),
			BLOCKSTRAP_BLOCKS_VERSION
		);
	}

	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since 2.0.0
	 * @return void
	 */
	public function load_textdomain() {

		$locale = get_user_locale();

		/**
		 * Filter the plugin locale.
		 *
		 * @since   1.4.2
		 * @package BlockStrap
		 */
		$locale = apply_filters( 'plugin_locale', $locale, 'blockstrap-blocks' );

		unload_textdomain( 'blockstrap-blocks' );
		load_textdomain( 'blockstrap-blocks', WP_LANG_DIR . '/' . 'geodirectory' . '/' . 'geodirectory' . '-' . $locale . '.mo' );
		load_plugin_textdomain( 'blockstrap-blocks', false, basename( dirname( BLOCKSTRAP_BLOCKS_PLUGIN_FILE ) ) . '/languages/' );
	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @return void
	 * @since 2.0.0
	 */
	private function setup_constants() {
		$this->define( 'BLOCKSTRAP_BLOCKS_PLUGIN_FILE', __FILE__ );
		$this->define( 'BLOCKSTRAP_BLOCKS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		$this->define( 'BLOCKSTRAP_BLOCKS_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string $name
	 * @param string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * File includes.
	 *
	 * @return void
	 */
	private function includes() {
		// composer autoloader
		require_once 'vendor/autoload.php';

		// Patterns
		require_once 'patterns/theme-defaults.php';
		require_once 'patterns/theme-parts-defaults.php';
		require_once 'patterns/header.php';

		// Blocks
		require_once 'blocks/class-blockstrap-widget-container.php';
		require_once 'blocks/class-blockstrap-widget-navbar.php';
		require_once 'blocks/class-blockstrap-widget-navbar-brand.php';
		require_once 'blocks/class-blockstrap-widget-nav.php';
		require_once 'blocks/class-blockstrap-widget-nav-item.php';
		require_once 'blocks/class-blockstrap-widget-nav-dropdown.php';
		require_once 'blocks/class-blockstrap-widget-shape-divider.php';
		require_once 'blocks/class-blockstrap-widget-button.php';
		require_once 'blocks/class-blockstrap-widget-heading.php';
		require_once 'blocks/class-blockstrap-widget-post-title.php';
		require_once 'blocks/class-blockstrap-widget-archive-title.php';
		require_once 'blocks/class-blockstrap-widget-image.php';
		require_once 'blocks/class-blockstrap-widget-map.php';
		require_once 'blocks/class-blockstrap-widget-counter.php';
		require_once 'blocks/class-blockstrap-widget-gallery.php';
		require_once 'blocks/class-blockstrap-widget-tabs.php';
		require_once 'blocks/class-blockstrap-widget-tab.php';
		require_once 'blocks/class-blockstrap-widget-icon-box.php';
		require_once 'blocks/class-blockstrap-widget-skip-links.php';
	}
}

//run
BlockStrap::instance();

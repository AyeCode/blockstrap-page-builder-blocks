<?php
/**
 * This is the main GeoDirectory plugin file, here we declare and call the important stuff
 *
 * @package     BlockStrap
 * @copyright   2022 AyeCode Ltd
 * @license     GPL-3.0+
 * @since       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: BlockStrap
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

final class BlockStrap {

	private static $instance = null;


	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof BlockStrap ) ) {
			self::$instance = new BlockStrap();
			self::$instance->setup_constants();

			//          add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

			self::$instance->includes();
			self::$instance->init_hooks();

			do_action( 'blockstrap_loaded' );
		}

		return self::$instance;
	}

	private function init_hooks() {

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


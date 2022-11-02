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
 * Plugin Name: BlockStrap Page Builder Blocks
 * Plugin URI: https://ayecode.io/
 * Description: BlockStrap - A FSE page builder for WordPress
 * Version: 0.0.1
 * Author: AyeCode
 * Author URI: https://ayecode.io
 * Text Domain: blockstrap-page-builder-blocks
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 6.1
 */


define( 'BLOCKSTRAP_BLOCKS_VERSION', '0.0.1' );

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

	/**
	 * Filters and actions.
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts' ), 1000 );
		add_filter( 'render_block', array( $this, 'force_render_blocks_on_templates' ), 10, 2 );
		add_filter( 'ayecode-ui-settings', array( $this, 'aui_settings_overwrite' ), 10, 3 );
		add_filter( 'ayecode-ui-default-settings', array( $this, 'aui_default_settings_overwrite' ), 10, 2 );
	}

	/**
	 * Overwrite AUI default settings to full mode.
	 *
	 * @param $settings
	 * @param $db_settings
	 * @param $defaults
	 *
	 * @return mixed
	 */
	public function aui_default_settings_overwrite( $settings, $db_settings ) {

		// set default value to full mode
		$settings['css']         = 'core';
		return $settings;
	}

	/**
	 * Overwrite AUI settings to force it to full mode if BlockStrap theme is being used.
	 *
	 * @param $settings
	 * @param $db_settings
	 * @param $defaults
	 *
	 * @return mixed
	 */
	public function aui_settings_overwrite( $settings, $db_settings, $defaults ) {

		// force full mode if theme is blockstrap
		if ( wp_get_theme()->get_stylesheet() === 'blockstrap' ) {
			$settings['css']         = 'core';
		}
		return $settings;
	}

	/**
	 * Force blocks to render shortcodes.
	 *
	 * There is a bug where shortcodes are not renders in template files.
	 *
	 * @todo remove this or make it more specific once this bug is resolved https://github.com/WordPress/gutenberg/issues/35258
	 *
	 * @param string $block_content The HTML content of the block.
	 * @param array  $block The full block, including name and attributes.
	 *
	 * @return mixed
	 */
	public function force_render_blocks_on_templates( $block_content, $block ) {
		return strip_shortcodes( do_shortcode( $block_content ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @return void
	 */
	public function enqueue_editor_scripts() {
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
		load_plugin_textdomain( 'blockstrap-page-builder-blocks', false, basename( dirname( BLOCKSTRAP_BLOCKS_PLUGIN_FILE ) ) . '/languages/' );
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

		// admin
		if ( is_admin() ) {
			require_once 'classes/class-blockstrap-blocks-admin.php';
		}

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

		// Frontend comments
		require_once 'classes/class-blockstrap-blocks-comments.php';

	}
}

//run
BlockStrap::instance();

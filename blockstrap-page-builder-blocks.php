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
 * Version: 0.1.11
 * Author: AyeCode
 * Author URI: https://ayecode.io
 * Text Domain: blockstrap-page-builder-blocks
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 6.5
 */


define( 'BLOCKSTRAP_BLOCKS_VERSION', '0.1.11' );

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
		add_filter( 'render_block', array( $this, 'force_render_blocks_on_templates' ), 100000, 2 );
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

		$block_content = strip_shortcodes( do_shortcode( $block_content ) );

		// @todo WP 6.2.1+ broke shortcodes, the order they added the code back broke other things, we need this till they revert it: https://core.trac.wordpress.org/ticket/58366#comment:37
		$block_content = str_replace('[/bs_','[bs_',$block_content );

		return strip_shortcodes( do_shortcode( $block_content ) );
	}


	/**
	 * Enqueue scripts
	 *
	 * @return void
	 */
	public function enqueue_editor_scripts() {
		global $wp_version;

		// WP 6.3 moved the loop column settings from query block to post-template block
		if( version_compare($wp_version,'6.3','<') ){
			$js_filters_filename = 'blockstrap-block-filters.js';
		}else{
			$js_filters_filename = 'blockstrap-block-filters-new.js';
		}

		wp_enqueue_script(
			'blockstrap-blocks-filters',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/js/' . $js_filters_filename,
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
		if (!defined( $name ) ) {
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

		require_once 'classes/class-blockstrap-blocks-templates.php';
		require_once 'classes/class-blockstrap-blocks-ajax.php';


		// Patterns
		require_once 'patterns/comments.php';
		require_once 'patterns/content.php';
		require_once 'patterns/footer.php';
		require_once 'patterns/header.php';
		require_once 'patterns/hero.php';
		require_once 'patterns/menu.php';

		// Blocks
		require_once 'blocks/class-blockstrap-widget-archive-actions.php';
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
		require_once 'blocks/class-blockstrap-widget-pagination.php';
		require_once 'blocks/class-blockstrap-widget-post-info.php';
		require_once 'blocks/class-blockstrap-widget-post-excerpt.php';
		require_once 'blocks/class-blockstrap-widget-breadcrumb.php';
		require_once 'blocks/class-blockstrap-widget-search.php';
		require_once 'blocks/class-blockstrap-widget-share.php';
		require_once 'blocks/class-blockstrap-widget-accordion.php';
		require_once 'blocks/class-blockstrap-widget-accordion-item.php';
		require_once 'blocks/class-blockstrap-widget-contact.php';
		require_once 'blocks/class-blockstrap-widget-rating.php';


//		require_once 'blocks/class-blockstrap-widget-popup-test.php'; //@todo remove before release

		// Frontend comments
		require_once 'classes/class-blockstrap-blocks-comments.php';

	}
}

//run
BlockStrap::instance();

//function eeeeeeeeeeee() {
//	echo strip_shortcodes( "testing [/bs_container]" );exit;
//
//}
//
//add_action('init','eeeeeeeeeeee');

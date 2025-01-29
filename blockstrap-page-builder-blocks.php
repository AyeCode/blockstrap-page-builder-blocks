<?php
/**
 * This is the main plugin file, here we declare and call the important stuff
 *
 * @package   BlockStrap
 * @copyright 2024 AyeCode Ltd
 * @license   GPL-3.0+
 * @since     1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: BlockStrap Page Builder Blocks
 * Plugin URI: https://ayecode.io/
 * Description: BlockStrap - A FSE page builder for WordPress
 * Version: 0.1.32
 * Author: AyeCode
 * Author URI: https://ayecode.io
 * Text Domain: blockstrap-page-builder-blocks
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 6.7
 */


define( 'BLOCKSTRAP_BLOCKS_VERSION', '0.1.32' );

/**
 * The BlockStrap Class
 */
final class BlockStrap {

	// The one true instance.
	private static $instance = null;

	/**
	 * Get the singleton instance of the BlockStrap class.
	 *
	 * If the instance does not yet exist, create a new instance and perform necessary setup actions.
	 *
	 * @return BlockStrap The singleton instance of the BlockStrap class.
	 */
	public static function instance() {
		if ( ! isset(self::$instance) && ! ( self::$instance instanceof BlockStrap )) {
			self::$instance = new BlockStrap();
			self::$instance->setup_constants();

			add_action('plugins_loaded', [ self::$instance, 'load_textdomain' ]);

			self::$instance->includes();
			self::$instance->init_hooks();

			do_action('blockstrap_loaded');
		}

		return self::$instance;
	}

	/**
	 * Filters and actions.
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action('enqueue_block_editor_assets', [ $this, 'enqueue_editor_scripts' ], 1000);
		add_filter('render_block', [ $this, 'force_render_blocks_on_templates' ], 100000, 2);
		add_filter('ayecode-ui-settings', [ $this, 'aui_settings_overwrite' ], 10, 3);
		add_filter('ayecode-ui-default-settings', [ $this, 'aui_default_settings_overwrite' ], 10, 2);
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
		$settings['css'] = 'core';
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
			$settings['css'] = 'core';
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
	 * @param array  $block         The full block, including name and attributes.
	 *
	 * @return mixed
	 */
	public function force_render_blocks_on_templates( $block_content, $block ) {
		$block_content = strip_shortcodes(do_shortcode($block_content));

		// @todo WP 6.2.1+ broke shortcodes, the order they added the code back broke other things, we need this till they revert it: https://core.trac.wordpress.org/ticket/58366#comment:37
		$block_content = str_replace('[/bs_', '[bs_', $block_content);

		return strip_shortcodes(do_shortcode($block_content));
	}

	/**
	 * Enqueue scripts
	 *
	 * @return void
	 */
	public function enqueue_editor_scripts() {
		global $wp_version;

		// WP 6.3 moved the loop column settings from query block to post-template block
		if (version_compare($wp_version, '6.3', '<')) {
			$js_filters_filename = 'blockstrap-block-filters.js';
		} else {
			$js_filters_filename = 'blockstrap-block-filters-new.js';
		}

		wp_enqueue_script(
			'blockstrap-blocks-filters',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL.'assets/js/'.$js_filters_filename,
			[
				'wp-block-library',
				'wp-element',
				'wp-i18n',
			],
			// required dependencies for blocks
			BLOCKSTRAP_BLOCKS_VERSION
		);

		wp_enqueue_style(
			'blockstrap-blocks-style',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL.'assets/css/style.css',
			'',
			BLOCKSTRAP_BLOCKS_VERSION
		);

		wp_enqueue_style(
			'blockstrap-blocks-style-admin',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL.'assets/css/block-editor.css',
			[ 'blockstrap-blocks-style' ],
			BLOCKSTRAP_BLOCKS_VERSION
		);
	}

	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since  2.0.0
	 * @return void
	 */
	public function load_textdomain() {
		// Determines the current locale.
		if ( function_exists( 'determine_locale' ) ) {
			$locale = determine_locale();
		} else if ( function_exists( 'get_user_locale' ) ) {
			$locale = get_user_locale();
		} else {
			$locale = get_locale();
		}

		$locale = apply_filters( 'plugin_locale', $locale, 'blockstrap-page-builder-blocks' );

		unload_textdomain( 'blockstrap-page-builder-blocks' );
		load_textdomain( 'blockstrap-page-builder-blocks', WP_LANG_DIR . '/blockstrap-page-builder-blocks/blockstrap-page-builder-blocks-' . $locale . '.mo' );
		load_plugin_textdomain( 'blockstrap-page-builder-blocks', false, basename( dirname( BLOCKSTRAP_BLOCKS_PLUGIN_FILE ) ) . '/languages/' );
	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @return void
	 * @since  2.0.0
	 */
	private function setup_constants() {
		$this->define( 'BLOCKSTRAP_BLOCKS_PLUGIN_FILE', __FILE__ );
		$this->define( 'BLOCKSTRAP_BLOCKS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		$this->define( 'BLOCKSTRAP_BLOCKS_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string         $name
	 * @param string|boolean $value
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
		include_once 'vendor/autoload.php';

		// admin
		if (is_admin()) {
			include_once 'classes/class-blockstrap-blocks-admin.php';
		}

		include_once 'classes/class-blockstrap-blocks-templates.php';
		include_once 'classes/class-blockstrap-blocks-ajax.php';

		// common functions
		include_once 'classes/functions.php';

		// Patterns
		include_once 'patterns/comments.php';
		include_once 'patterns/content.php';
		include_once 'patterns/footer.php';
		include_once 'patterns/header.php';
		include_once 'patterns/hero.php';
		include_once 'patterns/menu.php';

		// Blocks
		include_once 'blocks/class-blockstrap-widget-archive-actions.php';
		include_once 'blocks/class-blockstrap-widget-container.php';
		include_once 'blocks/class-blockstrap-widget-navbar.php';
		include_once 'blocks/class-blockstrap-widget-navbar-brand.php';
		include_once 'blocks/class-blockstrap-widget-nav.php';
		include_once 'blocks/class-blockstrap-widget-nav-item.php';
		include_once 'blocks/class-blockstrap-widget-nav-dropdown.php';
		include_once 'blocks/class-blockstrap-widget-shape-divider.php';
		include_once 'blocks/class-blockstrap-widget-button.php';
		include_once 'blocks/class-blockstrap-widget-heading.php';
		include_once 'blocks/class-blockstrap-widget-post-title.php';
		include_once 'blocks/class-blockstrap-widget-archive-title.php';
		include_once 'blocks/class-blockstrap-widget-image.php';
		include_once 'blocks/class-blockstrap-widget-map.php';
		include_once 'blocks/class-blockstrap-widget-counter.php';
		include_once 'blocks/class-blockstrap-widget-gallery.php';
		include_once 'blocks/class-blockstrap-widget-tabs.php';
		include_once 'blocks/class-blockstrap-widget-tab.php';
		include_once 'blocks/class-blockstrap-widget-icon-box.php';
		include_once 'blocks/class-blockstrap-widget-skip-links.php';
		include_once 'blocks/class-blockstrap-widget-pagination.php';
		include_once 'blocks/class-blockstrap-widget-post-info.php';
		include_once 'blocks/class-blockstrap-widget-post-excerpt.php';
		include_once 'blocks/class-blockstrap-widget-breadcrumb.php';
		include_once 'blocks/class-blockstrap-widget-search.php';
		include_once 'blocks/class-blockstrap-widget-share.php';
		include_once 'blocks/class-blockstrap-widget-accordion.php';
		include_once 'blocks/class-blockstrap-widget-accordion-item.php';
		include_once 'blocks/class-blockstrap-widget-contact.php';
		include_once 'blocks/class-blockstrap-widget-rating.php';
		include_once 'blocks/class-blockstrap-widget-scroll-top.php';
		include_once 'blocks/class-blockstrap-widget-modal.php';
		include_once 'blocks/class-blockstrap-widget-offcanvas.php';

		// Frontend comments
		include_once 'classes/class-blockstrap-blocks-comments.php';
	}
}

// run
BlockStrap::instance();

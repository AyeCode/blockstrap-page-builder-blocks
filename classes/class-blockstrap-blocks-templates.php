<?php
/**
 * Editor Templates functionality
 *
 * @package BlockStrap
 * @since 1.0.0
 */

/**
 * Add Editor Templates functionality.
 */
class BlockStrap_Blocks_Templates {

	/** Init the class.
	 *
	 * @return void
	 */
	public static function init() {

		// Set AUI to load on all post type edit screens
		//add_filter( 'wp_ajax_bpbb_get_templates', array( __CLASS__, 'get_templates' ) );

		add_filter( 'blockstrap_pattern_page_content_archive_default', array( __CLASS__, 'swap_pattern_theme_name' ), 15, 1 );

	}

	/**
	 * Swap the parent theme for the child theme in some patterns.
	 *
	 * This is stupid and WordPress should fix it.
	 *
	 * @param $content
	 *
	 * @return array|string|string[]
	 */
	public static function swap_pattern_theme_name( $content ) {
		$theme_slug = get_stylesheet();

//		print_r(wp_get_theme());
//		echo $theme_slug.'###'.get_stylesheet();exit;
		return str_replace( array( ',"theme":"blockstrap"', '' ), array( ',"theme":"' . $theme_slug .'"', '' ), $content );
	}

	public function get_templates(){

		check_admin_referer();
		echo '@@@';

		wp_die();
	}


}

BlockStrap_Blocks_Templates::init();

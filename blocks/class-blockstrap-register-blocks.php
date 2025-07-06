<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Widgets.
 *
 * @since 2.0.0
 */
class BlockStrap_Register_Blocks {

	public function __construct() {
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}

	/**
	 * Register Widgets.
	 *
	 * @since 2.0.0
	 * @since 2.1.1.0 Conditionally load widget code on the backend to reduce memory usage.
	 */
	public function register_widgets() {

		global $pagenow;

		$block_widget_init_screens = function_exists( 'sd_pagenow_exclude' ) ? sd_pagenow_exclude() : array();

		if ( is_admin() && $pagenow && in_array( $pagenow, $block_widget_init_screens ) ) {
			// don't initiate in these conditions.
		} else {

			$exclude = function_exists( 'sd_widget_exclude' ) ? sd_widget_exclude() : array();
			$widgets = $this->get_widgets();

			if ( ! empty( $widgets ) ) {
				foreach ( $widgets as $widget ) {
					if ( ! in_array( $widget, $exclude ) ) {

						// SD V1 used to extend the widget class. V2 does not, so we cannot call register widget on it.
						if ( is_subclass_of( $widget, 'WP_Widget' ) ) {
							register_widget( $widget );
						} else {
							new $widget();
						}

					}
				}
			}
		}
	}

	/**
	 * Get a list of available widgets.
	 *
	 * @return mixed|void
	 * @since 2.1.1.0
	 */
	public function get_widgets() {

		$widgets = array(
			'BlockStrap_Widget_Accordion',
			'BlockStrap_Widget_Accordion_Item',
			'BlockStrap_Widget_Alert',
			'BlockStrap_Widget_Archive_Actions',
			'BlockStrap_Widget_Archive_Title',
			'BlockStrap_Widget_Breadcrumb',
			'BlockStrap_Widget_Button',
			'BlockStrap_Widget_Contact',
			'BlockStrap_Widget_Container',
			'BlockStrap_Widget_Counter',
			'BlockStrap_Widget_Dark_Mode',
			'BlockStrap_Widget_Gallery',
			'BlockStrap_Widget_Heading',
			'BlockStrap_Widget_Headline',
			'BlockStrap_Widget_Icon_Box',
			'BlockStrap_Widget_Image',
			'BlockStrap_Widget_Map',
			'BlockStrap_Widget_Modal',
			'BlockStrap_Widget_Nav',
			'BlockStrap_Widget_Nav_Dropdown',
			'BlockStrap_Widget_Nav_Item',
			'BlockStrap_Widget_Navbar',
			'BlockStrap_Widget_Navbar_Brand',
			'BlockStrap_Widget_Offcanvas',
			'BlockStrap_Widget_Pagination',
			'BlockStrap_Widget_Post_Excerpt',
			'BlockStrap_Widget_Post_Info',
			'BlockStrap_Widget_Post_Title',
			'BlockStrap_Widget_Rating',
			'BlockStrap_Widget_Scroll_Top',
			'BlockStrap_Widget_Search',
			'BlockStrap_Widget_Shape_Divider',
			'BlockStrap_Widget_Share',
			'BlockStrap_Widget_Skip_Links',
			'BlockStrap_Widget_Tab',
			'BlockStrap_Widget_Tabs',
			'BlockStrap_Widget_Text',

		);


		return apply_filters( 'blockstrap_get_widgets', $widgets );
	}


}

new BlockStrap_Register_Blocks();

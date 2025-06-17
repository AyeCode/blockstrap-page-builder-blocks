<?php

class BlockStrap_Widget_Nav extends WP_Super_Duper {

	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		//global $bs_navbar_count;

		$bs_navbar_count = wp_unique_id();

		$options = array(
			'textdomain'       => 'blockstrap',
			'output_types'     => array( 'block', 'shortcode' ),
			'nested-block'     => true,
			'block-icon'       => 'fas fa-ellipsis-h',
			'block-category'   => 'layout',
			'block-keywords'   => "['menu','navigation','nav']",
			'block-supports'   => array(
				'customClassName' => false,
			),
// this might be too restrictive currently
//			'allowed-blocks'   => array(
//				'blockstrap/blockstrap-widget-nav-item',
//				'blockstrap/blockstrap-widget-nav-dropdown',
//				'blockstrap/blockstrap-widget-button',
//			),
			'block-output'     => array(
				array(
					'element'         => 'button',
					'className'       => 'navbar-toggler',
					'type'            => 'button',
					'"data-toggle"'   => 'collapse',
					'"data-target"'   => '#navbarNav_[%anchor%]',
					'element_require' => '[%inside_navbar%]=="1"',
					'"aria-label"'    => __('Open menu','blockstrap-page-builder-blocks'),
					array(
						'element' => 'span',
						'class'   => 'navbar-toggler-icon',
						'content' => '',
					),

				),
				array(
					'element'       => 'BlocksProps',
					'inner_element' => 'div',
					'if_className'  => '[%inside_navbar%]=="1" ? "blockstrap-nav collapse navbar-collapse" : "blockstrap-nav"',
					'style'         => '{[%WrapStyle%]}',
					'id'            => 'navbarNav_[%anchor%]',

					array(
						'element'          => 'innerBlocksProps',
						'inner_element'    => 'ul',
						'blockProps'       => array(
							'if_className' => '[%inside_navbar%]=="1" ? "navbar-nav [%WrapClass%]" : "nav [%WrapClass%]"',
						),
						'innerBlocksProps' => array(
							'orientation' => 'horizontal',
							'if_template' => "[
										[ 'blockstrap/blockstrap-widget-nav-item', { type:'home' } ],
										[ 'blockstrap/blockstrap-widget-nav-item', { type:'custom',text:'About' } ],
										[ 'blockstrap/blockstrap-widget-nav-item', { type:'custom',text:'Contact Us' } ],
										[ 'blockstrap/blockstrap-widget-nav-dropdown', { text:'Dropdown' },[
												[ 'blockstrap/blockstrap-widget-nav-item', { type:'custom',text:'Item 1' } ],
												[ 'blockstrap/blockstrap-widget-nav-item', { type:'custom',text:'Item 2' } ],
											]
										],
							]",
						),
					),
				),
//				array(
//					'element'         => 'script',
//					'content'         => 'jQuery("#navbarNav_[%anchor%]").on("show.bs.collapse", function () {jQuery("#navbarNav_[%anchor%]").closest(".bg-transparent-until-scroll,.bg-transparent").addClass("nav-menu-open"); jQuery(window).trigger("scroll");});jQuery("#navbarNav_[%anchor%]").on("hidden.bs.collapse", function () {jQuery("#navbarNav_[%anchor%]").closest(".bg-transparent-until-scroll,.bg-transparent").removeClass("nav-menu-open"); jQuery(window).trigger("scroll");});',
//					'element_require' => '[%inside_navbar%]=="1"',
//				),

			),
			'block-wrap'       => '',
			'class_name'       => __CLASS__,
			'base_id'          => 'bs_nav',
			'name'             => __( 'BS > Nav', 'blockstrap-page-builder-blocks' ),
			'widget_ops'       => array(
				'classname'   => 'bd-nav',
				'description' => esc_html__( 'Navigation items container.', 'blockstrap-page-builder-blocks' ),
			),
			'example'          => array(
				'attributes' => array(
					'inside_navbar' => '0',
				),
				'innerBlocks'   => array(
					array(
						'name'	=> 'blockstrap/blockstrap-widget-nav-item',
						'attributes'	=>	array(
							'type'	=> 'custom',
							'text'	=> esc_html__( 'Item 1', 'blockstrap-page-builder-blocks' ),
						)
					),
					array(
						'name'	=> 'blockstrap/blockstrap-widget-nav-item',
						'attributes'	=>	array(
							'type'	=> 'custom',
							'text'	=> esc_html__( 'Item 2', 'blockstrap-page-builder-blocks' ),
						)
					)
				),
				'viewportWidth' => 200
			),
			'no_wrap'          => true,
			'block_group_tabs' => array(
//				'content'  => array(
//					'groups' => array( __( 'Nav', 'blockstrap-page-builder-blocks' ) ),
//					'tab'    => array(
//						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
//						'key'       => 'bs_tab_content',
//						'tabs_open' => true,
//						'open'      => true,
//						'class'     => 'text-center flex-fill d-flex justify-content-center',
//					),
//				),
				'styles'   => array(
					'groups' => array( __( 'Nav Styles', 'blockstrap-page-builder-blocks' ), __( 'Typography', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Styles', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_styles',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'advanced' => array(
					'groups' => array(
						__( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ),
						__( 'Advanced', 'blockstrap-page-builder-blocks' ),
					),
					'tab'    => array(
						'title'     => __( 'Advanced', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_advanced',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
			),
		);

		parent::__construct( $options );
	}

	/**
	 * Set the arguments later.
	 *
	 * @return array
	 */
	public function set_arguments() {
		$arguments = array();

		$arguments['anchor'] = sd_get_anchor_input('anchor', array(
			'group'    => __( 'Nav Styles', 'blockstrap-page-builder-blocks' ),
		));

		$arguments['anchor_notice'] = array(
			'type'            => 'notice',
			'desc'            => __( 'A unique HTML anchor is required to prevent issues with multiple navs.', 'blockstrap-page-builder-blocks' ),
			'status'          => 'error', // 'warning' | 'success' | 'error' | 'info'
			'group'           => __( 'Nav Styles', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%anchor%]==""',
		);

		$arguments['inside_navbar'] = array(
			'type'     => 'select',
			'title'    => __( 'Usage', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'1' => __( 'Inside Navbar (collapse on mobile)', 'blockstrap-page-builder-blocks' ),
				'0' => __( 'Standalone (never collapse)', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '1',
			'desc_tip' => true,
			'group'    => __( 'Nav Styles', 'blockstrap-page-builder-blocks' ),
		);

		// container class
		$arguments['container'] = array(
			'type'     => 'select',
			'title'    => __( 'Color scheme', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''             => __( 'None', 'blockstrap-page-builder-blocks' ),
				'nav-dark'  => __( 'Dark', 'blockstrap-page-builder-blocks' ),
				'nav-light' => __( 'Light', 'blockstrap-page-builder-blocks' ),
				'nav-muted' => __( 'Muted', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Nav Styles', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%inside_navbar%]=="0"',
		);

		// flex direction
		$arguments['flex_direction'] = array(
			'type'     => 'select',
			'title'    => __( 'Horizontal / Vertical', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''            => __( 'Horizontal', 'blockstrap-page-builder-blocks' ),
				'flex-column' => __( 'Vertical', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Nav Styles', 'blockstrap-page-builder-blocks' ),
		);

		// Nav style
		$arguments['nav_style'] = array(
			'type'     => 'select',
			'title'    => __( 'Nav style', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''          => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'nav-tabs'  => __( 'Tabs', 'blockstrap-page-builder-blocks' ),
				'nav-pills' => __( 'Pills', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Nav Styles', 'blockstrap-page-builder-blocks' ),
		);

		$arguments = $arguments + sd_get_flex_justify_content_input_group( 'flex_justify_content', array('element_require' => '','group'    => __( 'Nav Styles', 'blockstrap-page-builder-blocks' ) ) );

		// fill / justify
		$arguments['nav_fill'] = array(
			'type'     => 'select',
			'title'    => __( 'Fill / Justify', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''              => __( 'No', 'blockstrap-page-builder-blocks' ),
				'nav-fill'      => __( 'Justify', 'blockstrap-page-builder-blocks' ),
				'nav-justified' => __( 'Justify equal width', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Nav Styles', 'blockstrap-page-builder-blocks' ),
		);

		// font size
		$arguments = $arguments + sd_get_font_size_input_group();

		// background
		$arguments['bg'] = sd_get_background_input( 'bg' );

		// margins mobile
		$arguments['mt'] = sd_get_margin_input( 'mt', array( 'device_type' => 'Mobile' ) );
		$arguments['mr'] = sd_get_margin_input(
			'mr',
			array(
				'device_type' => 'Mobile',
				'default'     => 'auto',
			)
		);
		$arguments['mb'] = sd_get_margin_input( 'mb', array( 'device_type' => 'Mobile' ) );
		$arguments['ml'] = sd_get_margin_input(
			'ml',
			array(
				'device_type' => 'Mobile',
				'default'     => 'auto',
			)
		);

		// margins tablet
		$arguments['mt_md'] = sd_get_margin_input( 'mt', array( 'device_type' => 'Tablet' ) );
		$arguments['mr_md'] = sd_get_margin_input( 'mr', array( 'device_type' => 'Tablet' ) );
		$arguments['mb_md'] = sd_get_margin_input( 'mb', array( 'device_type' => 'Tablet' ) );
		$arguments['ml_md'] = sd_get_margin_input( 'ml', array( 'device_type' => 'Tablet' ) );

		// margins desktop
		$arguments['mt_lg'] = sd_get_margin_input( 'mt', array( 'device_type' => 'Desktop' ) );
		$arguments['mr_lg'] = sd_get_margin_input(
			'mr',
			array(
				'device_type' => 'Desktop',
				'default'     => 0,
			)
		);
		$arguments['mb_lg'] = sd_get_margin_input( 'mb', array( 'device_type' => 'Desktop' ) );
		$arguments['ml_lg'] = sd_get_margin_input(
			'ml',
			array(
				'device_type' => 'Desktop',
				'default'     => 'auto',
			)
		);

		// padding
		$arguments['pt'] = sd_get_padding_input( 'pt', array( 'device_type' => 'Mobile' ) );
		$arguments['pr'] = sd_get_padding_input( 'pr', array( 'device_type' => 'Mobile' ) );
		$arguments['pb'] = sd_get_padding_input( 'pb', array( 'device_type' => 'Mobile' ) );
		$arguments['pl'] = sd_get_padding_input( 'pl', array( 'device_type' => 'Mobile' ) );

		// padding tablet
		$arguments['pt_md'] = sd_get_padding_input( 'pt', array( 'device_type' => 'Tablet' ) );
		$arguments['pr_md'] = sd_get_padding_input( 'pr', array( 'device_type' => 'Tablet' ) );
		$arguments['pb_md'] = sd_get_padding_input( 'pb', array( 'device_type' => 'Tablet' ) );
		$arguments['pl_md'] = sd_get_padding_input( 'pl', array( 'device_type' => 'Tablet' ) );

		// padding desktop
		$arguments['pt_lg'] = sd_get_padding_input( 'pt', array( 'device_type' => 'Desktop' ) );
		$arguments['pr_lg'] = sd_get_padding_input( 'pr', array( 'device_type' => 'Desktop' ) );
		$arguments['pb_lg'] = sd_get_padding_input( 'pb', array( 'device_type' => 'Desktop' ) );
		$arguments['pl_lg'] = sd_get_padding_input( 'pl', array( 'device_type' => 'Desktop' ) );

		// border
		$arguments['border']       = sd_get_border_input( 'border' );
		$arguments['rounded']      = sd_get_border_input( 'rounded' );
		$arguments['rounded_size'] = sd_get_border_input( 'rounded_size' );

		// shadow
		$arguments['shadow'] = sd_get_shadow_input( 'shadow' );

		$arguments['width'] = array(
			'type'     => 'select',
			'title'    => __( 'Width', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''       => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'w-auto' => __( 'Auto', 'blockstrap-page-builder-blocks' ),
				'w-25'   => '25%',
				'w-50'   => '50%',
				'w-75'   => '75%',
				'w-100'  => '100%',
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['css_class'] = sd_get_class_input();

		if ( function_exists( 'sd_get_custom_name_input' ) ) {
			$arguments['metadata_name'] = sd_get_custom_name_input();
		}

		return $arguments;
	}

	/**
	 * This is the output function for the widget, shortcode and block (front end).
	 *
	 * @param array $args The arguments values.
	 * @param array $widget_args The widget arguments when used.
	 * @param string $content The shortcode content argument
	 *
	 * @return string
	 */
	public function output( $args = array(), $widget_args = array(), $content = '' ) {
		if ( empty( $content ) ) {
			return '';
		} else {
			add_action( 'wp_enqueue_scripts',array( $this, 'enqueue_scripts' ) );
			return $content;
		}
	}

	/**
	 * Enqueues the necessary scripts for the widget, shortcode, and block (front end).
	 *
	 * @return void
	 * @global $blockstrap_nav_js
	 *
	 */
	public function enqueue_scripts() {
		global $blockstrap_nav_js;

		// Don't load JS again.
		if ( empty( $blockstrap_nav_js ) && class_exists( 'AyeCode_UI_Settings' ) ) {
			$script = 'jQuery(function($){$(".wp-block-blockstrap-blockstrap-widget-nav.navbar-collapse, .blockstrap-nav.navbar-collapse").on("show.bs.collapse",function(){$(this).closest(".bg-transparent-until-scroll,.bg-transparent").addClass("nav-menu-open");if(!$(this).hasClass("navbar-nav-scroll")&&($(this).closest(".navbar").hasClass("fixed-top")||$(this).closest(".navbar").hasClass("fixed-bottom"))){$(this).addClass("bs-class-added navbar-nav-scroll")}$(window).trigger("scroll")});$(".wp-block-blockstrap-blockstrap-widget-nav.navbar-collapse, .blockstrap-nav.navbar-collapse").on("hidden.bs.collapse",function(){$(this).closest(".bg-transparent-until-scroll,.bg-transparent").removeClass("nav-menu-open");if($(this).hasClass("bs-class-added")&&$(this).hasClass("navbar-nav-scroll")){$(this).removeClass("bs-class-added navbar-nav-scroll")}$(window).trigger("scroll")})});';
			$blockstrap_nav_js = wp_add_inline_script( 'bootstrap-js-bundle', $script );
		}
	}
}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Nav' );
	}
);

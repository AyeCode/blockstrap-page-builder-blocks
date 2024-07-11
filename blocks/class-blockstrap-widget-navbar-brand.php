<?php

class BlockStrap_Widget_Navbar_Brand extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'       => 'blockstrap',
			'output_types'     => array( 'block' ),
			'block-icon'       => 'fas fa-home',
			'block-category'   => 'layout',
			'block-keywords'   => "['brand','navbar','nav']",
			'block-supports'   => array(
				'customClassName' => false,
			),
			'block-output'     => array(
				array(
					'element'         => 'span',
					'className'       => 'navbar-brand d-flex align-items-center [%WrapClass%]',
					'style'           => '{[%WrapStyle%]}',
					'element_require' => '[%type%]=="none"',
					array(
						'element'         => 'img',
						'class'           => '',
						'alt'             => __( 'Site logo', 'blockstrap-page-builder-blocks' ),
						'element_require' => '[%icon_image%]!=""',
						'if_src'          => '[%icon_image%]==="Blockstrap-white.png" ? "' . BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/images/Blockstrap-white.png" : [%icon_image%]',
						'style'           => '{maxWidth:\'[%img_max_width%]px\'}',
						'width'           => '[%img_max_width%]',
						'height'          => '50',

					),
					array(
						'element'  => 'span',
						'if_class' => 'props.attributes.brand_font_italic ? "mb-0 [%brand_font_size%] [%brand_font_weight%] fst-italic" : "mb-0 [%brand_font_size%] [%brand_font_weight%] [%brand_font_italic%]"',
						'content'  => '[%text%]',
					),

				),
				array(
					'element'         => 'a',
					'className'       => 'navbar-brand d-flex align-items-center [%WrapClass%]',
					'style'           => '{[%WrapStyle%]}',
					'if_href'         => 'props.attributes.type == "home" ? "' . get_home_url() . '" : props.attributes.type == "custom" ? [%custom_url%] : "" ',
					'element_require' => '[%type%]!="none"',
					array(
						'element'         => 'img',
						'class'           => '',
						'alt'             => __( 'Site logo', 'blockstrap-page-builder-blocks' ),
						'element_require' => '[%icon_image%]!=""',
						'if_src'          => '[%icon_image%]==="Blockstrap-white.png" ? "' . BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/images/Blockstrap-white.png" : [%icon_image%]',
						'style'           => '{maxWidth:\'[%img_max_width%]px\'}',
						'width'           => '[%img_max_width%]',
						'height'          => '50',

					),
					array(
						'element'                    => 'span',
						'if_class'                   => 'props.attributes.brand_font_italic ? "mb-0 [%brand_font_size%] [%brand_font_weight%] fst-italic" : "mb-0 [%brand_font_size%] [%brand_font_weight%] [%brand_font_italic%]"',
						'if_dangerouslySetInnerHTML' => '{__html: props.attributes.text }',

				//                      'if_content' => 'dangerouslySetInnerHTML: {__html: props.attributes.text}',
					),

				),

			),
			'block-wrap'       => '',
			'class_name'       => __CLASS__,
			'base_id'          => 'bs_navbar_brand',
			'name'             => __( 'BS > Navbar Brand', 'blockstrap-page-builder-blocks' ),
			'widget_ops'       => array(
				'classname'   => 'bd-navbar-brand',
				'description' => esc_html__( 'Your navbar site name or logo.', 'blockstrap-page-builder-blocks' ),
			),
			'example'          => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'          => true,
			'block_group_tabs' => array(
				'content'  => array(
					'groups' => array(
						__( 'Text', 'blockstrap-page-builder-blocks' ),
						__( 'Icon', 'blockstrap-page-builder-blocks' ),
						__( 'Link', 'blockstrap-page-builder-blocks' ),
					),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array( __( 'Typography', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['text']       = array(
			'type'        => 'textarea',
			'title'       => __( 'Text', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Brand text', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'My Awesome Site!', 'blockstrap-page-builder-blocks' ),
			'default'     => get_bloginfo( 'name' ),
			'desc_tip'    => true,
			'group'       => __( 'Text', 'blockstrap-page-builder-blocks' ),
		);
		$arguments['icon_image'] = array(
			'type'        => 'image',
			'title'       => __( 'Image', 'blockstrap-page-builder-blocks' ),
			'placeholder' => '',
			'focalpoint'  => 0,
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Icon', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['img_max_width'] = array(
			'type'        => 'number',
			'title'       => __( 'Max width', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Set the image max width.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( '150', 'blockstrap-page-builder-blocks' ),
			'default'     => '150',
			'desc_tip'    => true,
			'group'       => __( 'Icon', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['type'] = array(
			'type'     => 'select',
			'title'    => __( 'Link Type', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'home'   => __( 'Home', 'blockstrap-page-builder-blocks' ),
				'custom' => __( 'Custom', 'blockstrap-page-builder-blocks' ),
				'none'   => __( 'None', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => 'home',
			'desc_tip' => true,
			'group'    => __( 'Link', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['custom_url'] = array(
			'type'            => 'text',
			'title'           => __( 'Custom URL', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Add custom link URL', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'https://example.com', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="custom"',
		);

		// text color
		$arguments['text_color'] = sd_get_text_color_input();

		// font size
		$arguments['brand_font_size'] = sd_get_font_size_input();

		// font size
		$arguments['brand_font_weight'] = sd_get_font_weight_input();

		$arguments['brand_font_italic'] = sd_get_font_italic_input();

		// Text justify
		$arguments['text_justify'] = sd_get_text_justify_input();

		// text align
		$arguments['text_align']    = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Mobile',
				'element_require' => '[%text_justify%]==""',
			)
		);
		$arguments['text_align_md'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Tablet',
				'element_require' => '[%text_justify%]==""',
			)
		);
		$arguments['text_align_lg'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Desktop',
				'element_require' => '[%text_justify%]==""',
			)
		);

		// background
		$arguments = $arguments + sd_get_background_inputs( 'bg', array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ), array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ), array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ), false );

		$arguments['bg_on_text'] = array(
			'type'            => 'checkbox',
			'title'           => __( 'Background on text', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'value'           => '1',
			'desc_tip'        => false,
			'desc'            => __( 'This will show the background on the text.', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%bg%]=="custom-gradient"',
		);

		// margins mobile
		$arguments['mt'] = sd_get_margin_input( 'mt', array( 'device_type' => 'Mobile' ) );
		$arguments['mr'] = sd_get_margin_input( 'mr', array( 'device_type' => 'Mobile' ) );
		$arguments['mb'] = sd_get_margin_input( 'mb', array( 'device_type' => 'Mobile' ) );
		$arguments['ml'] = sd_get_margin_input( 'ml', array( 'device_type' => 'Mobile' ) );

		// margins tablet
		$arguments['mt_md'] = sd_get_margin_input( 'mt', array( 'device_type' => 'Tablet' ) );
		$arguments['mr_md'] = sd_get_margin_input( 'mr', array( 'device_type' => 'Tablet' ) );
		$arguments['mb_md'] = sd_get_margin_input( 'mb', array( 'device_type' => 'Tablet' ) );
		$arguments['ml_md'] = sd_get_margin_input( 'ml', array( 'device_type' => 'Tablet' ) );

		// margins desktop
		$arguments['mt_lg'] = sd_get_margin_input( 'mt', array( 'device_type' => 'Desktop' ) );
		$arguments['mr_lg'] = sd_get_margin_input( 'mr', array( 'device_type' => 'Desktop' ) );
		$arguments['mb_lg'] = sd_get_margin_input(
			'mb',
			array(
				'device_type' => 'Desktop',
				'default'     => 3,
			)
		);
		$arguments['ml_lg'] = sd_get_margin_input( 'ml', array( 'device_type' => 'Desktop' ) );

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

		return $content;
	}
}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Navbar_Brand' );
	}
);

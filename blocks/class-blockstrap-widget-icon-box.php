<?php

class BlockStrap_Widget_Icon_Box extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block', 'shortcode' ),
			'block-icon'        => 'fas fa-star',
			'block-category'    => 'layout',
			'block-keywords'    => "['icon','iconbox','box']",
			'block-wrap'        => '',
			'block-supports'    => array(
				'customClassName' => false,
			),
			'block-edit-return' => "el('span', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									style: {'minHeight': '30px'},
									className: '',
								}))",
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_iconbox',
			'name'              => __( 'BS > Icon Box', 'blockstrap-page-builder-blocks' ),
			'widget_ops'        => array(
				'classname'   => 'bs-button',
				'description' => esc_html__( 'A bootstrap iconbox.', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => array(
				'attributes' => array(
					'icon_class' => 'fas fa-ship',
					'icon_type' => 'iconbox-translucent',
					'iconbox_size' => 'medium',
					'icon_color' => 'success',
				),
				'viewportWidth' => 300
			),
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array( __( 'Icon Box', 'blockstrap-page-builder-blocks' ), __( 'Link', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array( __( 'Icon Style', 'blockstrap-page-builder-blocks' ), __( 'Title Style', 'blockstrap-page-builder-blocks' ), __( 'Description Style', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Styles', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_styles',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'advanced' => array(
					'groups' => array( __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ), __( 'Advanced', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['img_src'] = array(
			'type'     => 'select',
			'title'    => __( 'Icon source', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''   => __( 'FontAwesome Class', 'blockstrap-page-builder-blocks' ),
				'upload'   => __( 'Upload', 'blockstrap-page-builder-blocks' ),
				'url'      => __( 'URL', 'blockstrap-page-builder-blocks' ),
				'svg'      => __( 'SVG code (not URL)', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
		);

		$type                          = 'img';
		$arguments[ $type . '_image' ] = array(
			'type'            => 'image',
			'title'           => __( 'Custom image', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => '',
			'default'         => '',
			'desc_tip'        => true,
			'focalpoint'      => false,
			'group'           => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_src%]=="upload"',
		);

		$arguments[ $type . '_image_id' ] = array(
			'type'        => 'hidden',
			'hidden_type' => 'number',
			'title'       => '',
			'placeholder' => '',
			'default'     => '',
			'group'       => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
		);

		$image_sizes = get_intermediate_image_sizes();

		$arguments['img_size'] = array(
			'type'            => 'select',
			'title'           => __( 'Image size', 'blockstrap-page-builder-blocks' ),
			'options'         => array( '' => 'Select image size' ) + array_combine( $image_sizes, $image_sizes ) + array( 'full' => 'full' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_src%]=="upload"',
		);

		$arguments['img_url'] = array(
			'type'            => 'text',
			'title'           => __( 'Image URL', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'https://example.com/uploads/my-iamge.jpg', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_src%]=="url"',
		);

		$arguments['svg_code'] = array(
			'type'            => 'textarea',
			'title'           => __( 'SVG Code', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( '<svg ...', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_src%]=="svg"',
		);

		// Max height
		$arguments['svg_max_height'] = sd_get_max_height_input( 'svg_max_height',
			array(
				'group'           => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%img_src%]!=""',
		) );

		##########

		$arguments['icon_class'] = array(
			'type'        => 'text',
			'title'       => __( 'Icon class', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'fas fa-ship', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_src%]==""',

		);

		$arguments['title'] = array(
			'type'        => 'text',
			'title'       => __( 'Title', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'fas fa-ship', 'blockstrap-page-builder-blocks' ),
			'default'     => __( 'Title of the iconbox', 'blockstrap-page-builder-blocks' ),
			'desc_tip'    => true,
			'group'       => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['title_tag'] = array(
			'type'     => 'select',
			'title'    => __( 'Title Tag', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h4'  => 'h3',
				'h5'  => 'h4',
				'h6'  => 'h5',
				'div' => 'div',
			),
			'default'  => 'h3',
			'desc_tip' => true,
			'group'    => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['description'] = array(
			'type'     => 'textarea',
			'title'    => __( 'Description', 'blockstrap-page-builder-blocks' ),
			//'default'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris risus magna, dignissim sit amet aliquam consequat, dignissim non ex.',
			'desc_tip' => true,
			'group'    => __( 'Icon Box', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['type'] = array(
			'type'     => 'select',
			'title'    => __( 'Link Type', 'blockstrap-page-builder-blocks' ),
			'options'  => $this->link_types(),
			'default'  => 'home',
			'desc_tip' => true,
			'group'    => __( 'Link', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['page_id'] = array(
			'type'            => 'select',
			'title'           => __( 'Page', 'blockstrap-page-builder-blocks' ),
			'options'         => blockstrap_pbb_page_options(false, false ),
			'placeholder'     => __( 'Select Page', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="page"',
		);

		$arguments['post_id'] = array(
			'type'            => 'number',
			'title'           => __( 'Post ID', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => 123,
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="post-id"',
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

		$arguments['icon_position'] = array(
			'type'     => 'select',
			'title'    => __( 'Icon position', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''                    => __( 'Top', 'blockstrap-page-builder-blocks' ),
				'left'             => __( 'Left', 'blockstrap-page-builder-blocks' ),
				'right'        => __( 'Right', 'blockstrap-page-builder-blocks' ),
				'bottom' => __( 'Bottom', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
		);

		// icon styles
		$arguments['icon_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Icon style', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''                    => __( 'Icon', 'blockstrap-page-builder-blocks' ),
				'iconbox'             => __( 'Iconbox bordered', 'blockstrap-page-builder-blocks' ),
				'iconbox-fill'        => __( 'Iconbox filled', 'blockstrap-page-builder-blocks' ),
				'iconbox-translucent' => __( 'Iconbox translucent', 'blockstrap-page-builder-blocks' ),
				'iconbox-invert'      => __( 'Iconbox hover invert', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['iconbox_size'] = array(
			'type'            => 'select',
			'title'           => __( 'Size', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				''            => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'extrasmall'  => __( 'Extra Small', 'blockstrap-page-builder-blocks' ),
				'small'       => __( 'Small', 'blockstrap-page-builder-blocks' ),
				'smallmedium' => __( 'Small-Medium', 'blockstrap-page-builder-blocks' ),
				'medium'      => __( 'Medium', 'blockstrap-page-builder-blocks' ),
				'large'       => __( 'Large', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%icon_type%]!=""',
		);

		$arguments = $arguments + sd_get_font_size_input_group(
			'icon_size',
			array(
				'group'           => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%icon_type%]==""',
				'default'         => 'h3',
			),
			array(
				'group' => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// text color
		$arguments = $arguments + sd_get_text_color_input_group(
			'icon_color',
			array(
				'group' => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			),
			array(
				'group' => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		$arguments['icon_bg'] = array(
			'title'           => __( 'Background Color', 'blockstrap-page-builder-blocks' ),
			'type'            => 'select',
			'options'         => array(
				'' => __( 'Default (primary)', 'blockstrap-page-builder-blocks' ),
			) + sd_aui_colors( true, true, true ),
			'default'         => 'primary',
			'desc_tip'        => true,
			'advanced'        => false,
			'group'           => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%icon_type%]=="iconbox-fill"',
		);

		// text align
		$arguments['icon_text_align']    = sd_get_text_align_input(
			'text_align',
			array(
				'device_type' => 'Mobile',
				'group'       => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['icon_text_align_md'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type' => 'Tablet',
				'group'       => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['icon_text_align_lg'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type' => 'Desktop',
				'default'     => 'text-lg-center',
				'group'       => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// icon padding bottom
		$arguments['icon_pb'] = sd_get_padding_input(
			'pb_custom',
			array(
				'title'    => __( 'Padding bottom', 'blockstrap-page-builder-blocks' ),
				'group' => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// Title
		$arguments = $arguments + sd_get_font_size_input_group(
			'title_size',
			array(
				'group'   => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
				'default' => 'h3',
			),
			array(
				'group' => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// line height
		$arguments['title_font_line_height'] = sd_get_font_line_height_input( 'font_line_height', array( 'group' => __( 'Title Style', 'blockstrap-page-builder-blocks' ) ) );

		// text color
		$arguments = $arguments + sd_get_text_color_input_group(
			'title_color',
			array(
				'group' => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
			),
			array(
				'group' => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// font weight.
		$arguments['title_font_weight'] = sd_get_font_weight_input(
			'title_font_weight',
			array(
				'group' => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// font case
		$arguments['title_font_case'] = sd_get_font_case_input(
			'title_font_case',
			array(
				'group' => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// Text justify
		$arguments['title_text_justify'] = sd_get_text_justify_input(
			'title_jext_justify',
			array(
				'group' => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// text align
		$arguments['title_text_align']    = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Mobile',
				'element_require' => '[%title_text_justify%]==""',
				'group'           => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['title_text_align_md'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Tablet',
				'element_require' => '[%title_text_justify%]==""',
				'group'           => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['title_text_align_lg'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Desktop',
				'element_require' => '[%title_text_justify%]==""',
				'default'         => 'text-lg-center',
				'group'           => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// icon padding bottom
		$arguments['title_pb'] = sd_get_padding_input(
			'pb_custom',
			array(
				'title'    => __( 'Padding bottom', 'blockstrap-page-builder-blocks' ),
				'group' => __( 'Title Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		//Description

		// Title
		$arguments = $arguments + sd_get_font_size_input_group(
			'desc_size',
			array(
				'group' => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			),
			array(
				'group' => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// line height
		$arguments['desc_font_line_height'] = sd_get_font_line_height_input( 'font_line_height', array( 'group' => __( 'Description Style', 'blockstrap-page-builder-blocks' ) ) );

		// text color
		$arguments = $arguments + sd_get_text_color_input_group(
			'desc_color',
			array(
				'group' => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			),
			array(
				'group' => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// font weight.
		$arguments['desc_font_weight'] = sd_get_font_weight_input(
			'desc_font_weight',
			array(
				'group' => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// font case
		$arguments['desc_font_case'] = sd_get_font_case_input(
			'desc_font_case',
			array(
				'group' => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// Text justify
		$arguments['desc_text_justify'] = sd_get_text_justify_input(
			'desc_jext_justify',
			array(
				'group' => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// text align
		$arguments['desc_text_align']    = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Mobile',
				'element_require' => '[%desc_text_justify%]==""',
				'group'           => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['desc_text_align_md'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Tablet',
				'element_require' => '[%desc_text_justify%]==""',
				'group'           => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['desc_text_align_lg'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Desktop',
				'element_require' => '[%desc_text_justify%]==""',
				'default'         => 'text-lg-center',
				'group'           => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// icon padding bottom
		$arguments['desc_pb'] = sd_get_padding_input(
			'pb_custom',
			array(
				'title'    => __( 'Padding bottom', 'blockstrap-page-builder-blocks' ),
				'group' => __( 'Description Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// background
		$arguments = $arguments + sd_get_background_inputs( 'bg', array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ), array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ), array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ), array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ) );

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
		$arguments['mb_lg'] = sd_get_margin_input( 'mb', array( 'device_type' => 'Desktop' ) );
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

		// Hover animations
		$arguments['hover_animations'] = sd_get_hover_animations_input( 'hover_animations' );

		// block visibility conditions
		$arguments['visibility_conditions'] = sd_get_visibility_conditions_input();

		$arguments['css_class'] = sd_get_class_input();

		if ( function_exists( 'sd_get_custom_name_input' ) ) {
			$arguments['metadata_name'] = sd_get_custom_name_input();
		}

		return $arguments;
	}

	public function link_types() {
		$links = array(
			'home'    => __( 'Home', 'blockstrap-page-builder-blocks' ),
			'none'    => __( 'None (non link)', 'blockstrap-page-builder-blocks' ),
			'page'    => __( 'Page', 'blockstrap-page-builder-blocks' ),
			'post-id' => __( 'Post ID', 'blockstrap-page-builder-blocks' ),
			'custom'  => __( 'Custom URL', 'blockstrap-page-builder-blocks' ),
		);

		if ( defined( 'GEODIRECTORY_VERSION' ) ) {
			$post_types           = function_exists( 'geodir_get_posttypes' ) ? geodir_get_posttypes( 'options-plural' ) : '';
			$links['gd_search']   = __( 'GD Search', 'blockstrap-page-builder-blocks' );
			$links['gd_location'] = __( 'GD Location', 'blockstrap-page-builder-blocks' );
			foreach ( $post_types as $cpt => $cpt_name ) {
				/* translators: Custom Post Type name. */
				$links[ $cpt ] = sprintf( __( '%s (archive)', 'blockstrap-page-builder-blocks' ), $cpt_name );
				/* translators: Custom Post Type name. */
				$links[ 'add_' . $cpt ] = sprintf( __( '%s (add listing)', 'blockstrap-page-builder-blocks' ), $cpt_name );
			}
		}

		return $links;
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

		$icon_html        = $this->build_icon( $args );
		$title_html       = $this->build_title( $args );
		$description_html = $this->build_description( $args );
		$tag              = 'div';
		$wrap_class       = sd_build_aui_class( $args );

		$styles = sd_build_aui_styles( $args );
		$style  = $styles ? ' style="' . $styles . '"' : '';

		$text_wrap_class = '';
		// icon position
		if ( ! empty( $args['icon_position'] ) ) {
			if ( 'left' === $args['icon_position'] ) {
				$wrap_class .= ' d-flex align-items-center';
			} elseif ( 'right' === $args['icon_position'] ) {
				$wrap_class .= ' d-flex align-items-center';
				$text_wrap_class .= ' order-0';
			} elseif ( 'bottom' === $args['icon_position'] ) {
				$wrap_class .= ' d-flex flex-column-reverse';
			}
		}

		return $icon_html || $title_html || $description_html ? sprintf(
			'<%1$s class="blockstrap-iconbox position-relative h-100 %2$s" %3$s >%4$s<div class="iconbox-text-wrap %5$s">%6$s%7$s</div></%1$s>',
			$tag,
			sd_sanitize_html_classes( $wrap_class ),
			$style,
			$icon_html,
			sd_sanitize_html_classes( $text_wrap_class ),
			$title_html,
			$description_html
		) : '';

	}


	public function build_icon( $args ) {

		// check we have an icon to use
		$has_icon = false;
		$img_src = !empty($args['img_src']) ? $args['img_src'] : '';
		if ('upload' === $img_src && !empty($args['img_image'])) {
			$has_icon = true;

//			print_r($args);exit;
		}elseif('url' === $img_src && !empty($args['img_url'])) {
			$has_icon = true;
		}elseif('svg' === $img_src && !empty($args['svg_code'])) {
			$has_icon = true;
		}elseif(!empty($args['icon_class'])) {
			$has_icon = true;
		}

//		print_r($args);//exit;
		$html = '';
		$wrap_class = '';
		if ( $has_icon ) {
			$tag        = 'div';
			$icon_class = '';
			if ( ! empty( $args['icon_type'] ) ) {
				if ( 'iconbox' === $args['icon_type'] ) {
					$icon_class .= ' iconbox rounded-circle';
				} elseif ( 'iconbox-fill' === $args['icon_type'] ) {
					$icon_class .= ' iconbox border-0 fill rounded-circle';

					if ( ! empty( $args['icon_bg'] ) ) {
						$icon_class .= ' ' . sd_build_aui_class(
								array(
									'bg' => $args['icon_bg'],
								)
							);
					}
				}  elseif ( 'iconbox-invert' === $args['icon_type'] ) {
					$icon_class .= ' iconbox border-0 fill rounded-circle icon-box-media transition-all';
					$wrap_class .= 'icon-box ';
					if ( ! empty( $args['icon_bg'] ) ) {
						$args['icon_bg'] = '';
					}

					if ( ! empty( $args['icon_color'] ) ) {
						$icon_class        .= ' text-' . esc_attr( $args['icon_color'] );
						$args['icon_color'] = '';
					}

				} elseif ( 'iconbox-translucent' === $args['icon_type'] ) {
					$icon_class .= ' iconbox border-0 fill rounded-circle transition-all';

					if ( ! empty( $args['icon_bg'] ) ) {
						$args['icon_bg'] = '';
					}

					if ( ! empty( $args['icon_color'] ) ) {
						$icon_class        .= ' btn-translucent-' . esc_attr( $args['icon_color'] );
						$args['icon_color'] = '';
					}
				}

				if ( empty( $args['iconbox_size'] ) || 'small' === $args['iconbox_size'] ) {
					$icon_class .= ' iconsmall';
				} elseif ( 'extrasmall' === $args['iconbox_size'] ) {
					$icon_class .= ' iconextrasmall';
				} elseif ( 'smallmedium' === $args['iconbox_size'] ) {
					$icon_class .= ' iconsmallmedium';
				} elseif ( 'medium' === $args['iconbox_size'] ) {
					$icon_class .= ' iconmedium';
				} elseif ( 'large' === $args['iconbox_size'] ) {
					$icon_class .= ' iconlarge';
				}
			}

			// margins left/right
			if ( 'right' === $args['icon_position'] ) {
				$wrap_class .= ' ms-3 ml-3 order-1 ';
			} elseif ( 'left' === $args['icon_position'] ) {
				$wrap_class .= ' me-3 mr-3 ';
			}


			// icon src
			$icon = '';
			$img_attr = array();

			// image alt
			$img_attr['alt'] = ! empty( $args['title'] ) ? esc_attr( $args['title'] ) : ( ! empty( $args['description'] ) ? esc_attr( strip_tags( $args['description'] ) ) : '');

			if ( empty( $args['img_src'] ) ) {
				$icon = '<i class="' . sd_sanitize_html_classes( $args['icon_class'] ) . ' ' . sd_sanitize_html_classes( $icon_class ) . '"></i>';
			} elseif ( 'svg' === $args['img_src'] ) {
				$allowed_svg_tags = [
					'svg'   => [
						'xmlns'         => true,
						'viewbox'       => true,
						'width'         => true,
						'height'        => true,
						'fill'          => true,
						'stroke'        => true,
						'stroke-width'  => true,
						'role'          => true,
						'aria-hidden'   => true,
						'class'         => true,
						'style'         => true,
					],
					'g'     => [
						'id'             => true,
						'fill'           => true,
						'stroke'         => true,
						'stroke-width'   => true,
						'stroke-linecap' => true,
						'stroke-linejoin'=> true,
						'fill-rule'      => true,
						'transform'      => true,
						'class'          => true,
						'style'          => true,
					],
					'path'  => [
						'd'              => true,
						'fill'           => true,
						'stroke'         => true,
						'stroke-width'   => true,
						'stroke-linecap' => true,
						'stroke-linejoin'=> true,
						'fill-rule'      => true,
						'class'          => true,
						'style'          => true,
					],
					'rect'  => [
						'x'              => true,
						'y'              => true,
						'width'          => true,
						'height'         => true,
						'fill'           => true,
						'stroke'         => true,
						'stroke-width'   => true,
						'class'          => true,
						'style'          => true,
					],
					'circle' => [
						'cx'             => true,
						'cy'             => true,
						'r'              => true,
						'fill'           => true,
						'stroke'         => true,
						'stroke-width'   => true,
						'class'          => true,
						'style'          => true,
					],
					'ellipse' => [
						'cx'             => true,
						'cy'             => true,
						'rx'             => true,
						'ry'             => true,
						'fill'           => true,
						'stroke'         => true,
						'stroke-width'   => true,
						'class'          => true,
						'style'          => true,
					],
					'line' => [
						'x1'             => true,
						'y1'             => true,
						'x2'             => true,
						'y2'             => true,
						'stroke'         => true,
						'stroke-width'   => true,
						'class'          => true,
						'style'          => true,
					],
					'polyline' => [
						'points'         => true,
						'fill'           => true,
						'stroke'         => true,
						'stroke-width'   => true,
						'class'          => true,
						'style'          => true,
					],
					'polygon' => [
						'points'         => true,
						'fill'           => true,
						'stroke'         => true,
						'stroke-width'   => true,
						'class'          => true,
						'style'          => true,
					],
					'defs'   => [],
					'title'  => [],
					'desc'   => [],
					'use'    => [
						'xlink:href'     => true,
						'href'           => true, // For newer browsers
						'class'          => true,
						'style'          => true,
					],
					'symbol' => [
						'id'             => true,
						'viewBox'        => true,
						'preserveAspectRatio' => true,
					],
				];




				$icon = $args['svg_code'] ? wp_kses( html_entity_decode( $args['svg_code'], ENT_QUOTES ), $allowed_svg_tags ) : '';


				// maybe add styles
				$img_attr['style'] = !empty($args['icon_color']) ? 'fill: currentColor;' . esc_attr( $args['icon_color_custom']).';' : '';
				$img_attr['style'] .= 'max-width:100%;';
				$img_attr['style'] .= 'width:1em;';
				$img_attr['style'] .= 'height:1em;';
				$img_attr['style'] .= !empty($args['svg_max_height']) ? 'max-height: ' . esc_attr( $args['svg_max_height']).';' : 'max-height: fit-content;';
				$custom_attr_string = implode(',', array_map(
					function($key, $value) {
						return esc_attr($key) . '|' . esc_attr($value);
					},
					array_keys($img_attr),
					$img_attr
				));
				$attributes_escaped = sd_build_attributes_string_escaped( array('custom'=> $custom_attr_string) );

				$icon = str_replace('<svg ', '<svg ' . $attributes_escaped , $icon);

			} elseif ( 'url' === $args['img_src'] ) {
				$image_src = $args['img_url'] ? esc_url_raw( $args['img_url'] ) : '';
				$img_attr['style'] = $args['icon_color'] === 'custom' && $args['icon_color_custom'] ? $this->hexToColorFilter($args['icon_color_custom']) : '';
				$img_attr['style'] .= 'max-width:100%;width:auto;';
				$img_attr['style'] .= !empty($args['svg_max_height']) ? 'max-height: ' . esc_attr( $args['svg_max_height']).';' : 'max-height: fit-content;';

				$custom_attr_string = implode(',', array_map(
					function($key, $value) {
						return esc_attr($key) . '|' . esc_attr($value);
					},
					array_keys($img_attr),
					$img_attr
				));
				$attributes_escaped = sd_build_attributes_string_escaped( array('custom'=> $custom_attr_string) );
				$icon = '<img src="' . esc_url_raw( $image_src ) . '" ' . $attributes_escaped . ' />';
			}  elseif ( ! empty( $args['img_image_id'] ) ) {
				$img_attr['style'] = $args['icon_color'] === 'custom' && $args['icon_color_custom'] ? $this->hexToColorFilter($args['icon_color_custom']) : '';
				$img_attr['style'] .= 'max-width:100%;width: auto;';
				$img_attr['style'] .= !empty($args['svg_max_height']) ? 'max-height: ' . esc_attr( $args['svg_max_height']).';' : 'max-height: fit-content;';
				$image_size     = ! empty( $args['img_size'] ) ? esc_attr( $args['img_size'] ) : 'full';
				$icon         = wp_get_attachment_image( absint( $args['img_image_id'] ), $image_size, true,$img_attr );

			}

//			$icon = '<i class="' . sd_sanitize_html_classes( $args['icon_class'] ) . ' ' . sd_sanitize_html_classes( $icon_class ) . '"></i>';
//			$icon = '<img src="http://localhost/wp-content/uploads/2025/02/pin.png" class=" ' . sd_sanitize_html_classes( $icon_class ) . '"></i>';

			$wrap_class .= sd_build_aui_class(
				array(
					'font_size'     => empty( $args['icon_type'] ) ? $args['icon_size'] : '',
					'text_color'    => $args['icon_color'],
					'pb'            => $args['icon_pb'],
					'text_align'    => $args['icon_text_align'],
					'text_align_md' => $args['icon_text_align_md'],
					'text_align_lg' => $args['icon_text_align_lg'],
				)
			);

			$styles = sd_build_aui_styles(
				array(
					'font_size_custom'  => 'custom' === $args['icon_size'] ? $args['icon_size_custom'] : '',
					'text_color_custom' => $args['icon_color_custom'],
				)
			);
			$style  = $styles ? ' style="' . $styles . '"' : '';

			$html = sprintf(
				'<%1$s class="blockstrap-iconbox-icon %2$s" %3$s >%4$s</%1$s>',
				$tag,
				sd_sanitize_html_classes( $wrap_class ),
				$style,
				$icon
			);

		}

		return $html;
	}

	public function hexToColorFilter($hex) {
		// Remove # if present
		$hex = ltrim($hex, '#');

		// Convert hex to RGB (0-255)
		$r = hexdec(substr($hex, 0, 2));
		$g = hexdec(substr($hex, 2, 2));
		$b = hexdec(substr($hex, 4, 2));

		// Normalize to 0-1
		$rNorm = $r / 255;
		$gNorm = $g / 255;
		$bNorm = $b / 255;

		// Convert to HSL for better filter mapping
		$max = max($rNorm, $gNorm, $bNorm);
		$min = min($rNorm, $gNorm, $bNorm);
		$delta = $max - $min;

		$l = ($max + $min) / 2; // Lightness
		$s = $delta === 0 ? 0 : $delta / (1 - abs(2 * $l - 1)); // Saturation
		$h = 0;
		if ($delta !== 0) {
			if ($max === $rNorm) {
				$h = (($gNorm - $bNorm) / $delta);
				// Handle negative values and wrap around 6 properly
				$h = fmod($h + 6, 6); // fmod works with floats, ensures 0-6 range
			} elseif ($max === $gNorm) {
				$h = ($bNorm - $rNorm) / $delta + 2;
			} else {
				$h = ($rNorm - $gNorm) / $delta + 4;
			}
			// Convert to degrees (0-360)
			$h = $h * 60;
			if ($h < 0) $h += 360; // Ensure positive hue
		}

		// Map to filter values
		$invert = round($l * 100); // 0-100%
		$saturate = round(100 + ($s * 2000)); // Boost saturation
		$hueRotate = round($h); // Degrees

		// Return filter string
		return "filter: invert({$invert}%) sepia(100%) saturate({$saturate}%) hue-rotate({$hueRotate}deg) brightness(100%) contrast(100%);";
	}



	/**
	 * Build the iconbox title.
	 *
	 * @param $args
	 *
	 * @return string
	 */
	public function build_title( $args ) {
		$html = '';

		if ( ! empty( $args['title'] ) ) {
			$tag          = ! empty( $args['title_tag'] ) ? esc_attr( $args['title_tag'] ) : 'h2';
			$allowed_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'div', 'p' );
			$tag          = in_array( $tag, $allowed_tags, true ) ? esc_attr( $tag ) : 'h2';

			$wrap_class = sd_build_aui_class(
				array(
					'font_size'     => $args['title_size'],
					'text_color'    => $args['title_color'],
					'pb'            => $args['title_pb'],
					'text_align'    => $args['title_text_align'],
					'text_align_md' => $args['title_text_align_md'],
					'text_align_lg' => $args['title_text_align_lg'],
					'font_weight'   => $args['title_font_weight'],
					'font_case'     => $args['title_font_case'],
					'text_justify'  => $args['title_text_justify'],
				)
			);

			$styles = sd_build_aui_styles(
				array(
					'font_size_custom'  => 'custom' === $args['title_size'] ? $args['title_size_custom'] : '',
					'text_color_custom' => $args['title_color_custom'],
					'font_line_height'  => $args['title_font_line_height'],
				)
			);
			$style  = $styles ? ' style="' . $styles . '"' : '';

			$html = sprintf(
				'<%1$s class="blockstrap-iconbox-title %2$s mb-0" %3$s >%4$s</%1$s>',
				$tag,
				sd_sanitize_html_classes( $wrap_class ),
				$style,
				esc_attr( $args['title'] )
			);

			$link = '';
			if ( 'home' === $args['type'] ) {
				$link = get_home_url();
			} elseif ( 'page' === $args['type'] || 'post-id' === $args['type'] ) {
				$page_id = ! empty( $args['page_id'] ) ? absint( $args['page_id'] ) : 0;
				$post_id = ! empty( $args['post_id'] ) ? absint( $args['post_id'] ) : 0;
				$id      = 'page' === $args['type'] ? $page_id : $post_id;
				if ( $id ) {
					$page = get_post( $id );
					if ( ! empty( $page->post_title ) ) {
						$link = get_permalink( $id );
					}
				}
			} elseif ( 'custom' === $args['type'] ) {
				$link = ! empty( $args['custom_url'] ) ? esc_url_raw( $args['custom_url'] ) : '#';
			} elseif ( 'gd_search' === $args['type'] ) {
				$link = function_exists( 'geodir_search_page_base_url' ) ? geodir_search_page_base_url() : '#';
			} elseif ( 'gd_location' === $args['type'] ) {
				$link = function_exists( 'geodir_location_page_id' ) ? get_permalink( geodir_location_page_id() ) : '#';
			} elseif ( substr( $args['type'], 0, 3 ) === 'gd_' ) {
				$post_types = function_exists( 'geodir_get_posttypes' ) ? geodir_get_posttypes( 'options-plural' ) : '';
				if ( ! empty( $post_types ) ) {
					foreach ( $post_types as $cpt => $cpt_name ) {
						if ( $cpt === $args['type'] ) {
							$link = get_post_type_archive_link( $cpt );
						}
					}
				}
			} elseif ( substr( $args['type'], 0, 7 ) === 'add_gd_' ) {
				$post_types = function_exists( 'geodir_get_posttypes' ) ? geodir_get_posttypes( 'options' ) : '';
				if ( ! empty( $post_types ) ) {
					foreach ( $post_types as $cpt => $cpt_name ) {
						if ( 'add_' . $cpt === $args['type'] ) {
							$link = function_exists( 'geodir_add_listing_page_url' ) ? geodir_add_listing_page_url( $cpt ) : '';
						}
					}
				}
			}

			if ( $link ) {
				$html = $this->is_preview() ? sprintf(
					'<a class="blockstrap-iconbox-title-link stretched-link" >%1$s</a>',
					$html
				) : sprintf(
					'<a href="%1$s" class="blockstrap-iconbox-title-link stretched-link" >%2$s</a>',
					esc_url_raw( $link ),
					$html
				);
			}
		}

		return $html;
	}

	public function build_description( $args ) {
		$html = '';

		if ( ! empty( $args['description'] ) ) {
			$html = '<div class="">' . wp_kses_post( $args['description'] ) . '</div>';

			$wrap_class = sd_build_aui_class(
				array(
					'font_size'     => $args['desc_size'],
					'text_color'    => $args['desc_color'],
					'pb'            => $args['desc_pb'],
					'text_align'    => $args['desc_text_align'],
					'text_align_md' => $args['desc_text_align_md'],
					'text_align_lg' => $args['desc_text_align_lg'],
					'font_weight'   => $args['desc_font_weight'],
					'font_case'     => $args['desc_font_case'],
					'text_justify'  => $args['desc_text_justify'],
				)
			);

			$styles = sd_build_aui_styles(
				array(
					'font_size_custom'  => 'custom' === $args['desc_size'] ? $args['desc_size_custom'] : '',
					'text_color_custom' => $args['desc_color_custom'],
					'font_line_height'  => $args['desc_font_line_height'],
				)
			);
			$style  = $styles ? ' style="' . $styles . '"' : '';

			$html = sprintf(
				'<div class="blockstrap-iconbox-desc %1$s" %2$s >%3$s</div>',
				sd_sanitize_html_classes( $wrap_class ),
				$style,
				wp_kses_post( $args['description'] )
			);
		}

		return $html;
	}


}


// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Icon_Box' );
	}
);


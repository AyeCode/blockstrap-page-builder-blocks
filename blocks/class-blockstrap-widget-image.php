<?php

class BlockStrap_Widget_Image extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block', 'shortcode' ),
			'block-icon'        => 'far fa-image',
			'block-category'    => 'layout',
			'block-keywords'    => "['image','images','photo']",
			'block-supports'    => array(
				'customClassName' => false,
			),
			'block-edit-return' => "el('span', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									style: {'minHeight': '30px'}
								}))",
			'block-wrap'        => '',
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_image',
			'name'              => __( 'BS > Image', 'blockstrap-page-builder-blocks' ),
			'widget_ops'        => array(
				'classname'   => 'bs-image',
				'description' => esc_html__( 'A image element', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array(
						__( 'Image', 'blockstrap-page-builder-blocks' ),
						__( 'Link', 'blockstrap-page-builder-blocks' ),
						__( 'Caption', 'blockstrap-page-builder-blocks' ),
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
					'groups' => array( __( 'Image Styles', 'blockstrap-page-builder-blocks' ), __( 'Typography', 'blockstrap-page-builder-blocks' ) ),
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
						__( 'Image Mask', 'blockstrap-page-builder-blocks' ),
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

		$arguments['img_src'] = array(
			'type'     => 'select',
			'title'    => __( 'Image source', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'upload'   => __( 'Upload', 'blockstrap-page-builder-blocks' ),
				'url'      => __( 'URL', 'blockstrap-page-builder-blocks' ),
				'featured' => __( 'Featured image', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => 'upload',
			'desc_tip' => true,
			'group'    => __( 'Image', 'blockstrap-page-builder-blocks' ),
		);

		$type                          = 'img';
		$arguments[ $type . '_image' ] = array(
			'type'            => 'image',
			'title'           => __( 'Custom image', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => '',
			'default'         => '',
			'desc_tip'        => true,
			'focalpoint'      => false,
			'group'           => __( 'Image', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_src%]=="upload"',
		);

		$arguments[ $type . '_image_id' ] = array(
			'type'        => 'hidden',
			'hidden_type' => 'number',
			'title'       => '',
			'placeholder' => '',
			'default'     => '',
			'group'       => __( 'Image', 'blockstrap-page-builder-blocks' ),
		);

		$image_sizes = get_intermediate_image_sizes();

		$arguments['img_size'] = array(
			'type'            => 'select',
			'title'           => __( 'Image size', 'blockstrap-page-builder-blocks' ),
			'options'         => array( '' => 'Select image size' ) + array_combine( $image_sizes, $image_sizes ) + array( 'full' => 'full' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Image', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_src%]!="url"',
		);

		$arguments['img_url'] = array(
			'type'            => 'text',
			'title'           => __( 'Image URL', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'https://example.com/uploads/my-iamge.jpg', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Image', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_src%]=="url"',
		);

		$arguments['fallback_img_src'] = array(
			'type'     => 'select',
			'title'    => __( 'Fallback image source', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''        => __( 'None', 'blockstrap-page-builder-blocks' ),
				'default' => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'upload'  => __( 'Upload', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Image', 'blockstrap-page-builder-blocks' ),
		);

		$type                          = 'fallback_img';
		$arguments[ $type . '_image' ] = array(
			'type'            => 'image',
			'title'           => __( 'Fallback image', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => '',
			'default'         => '',
			'desc_tip'        => true,
			'focalpoint'      => false,
			'group'           => __( 'Image', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_src%]=="featured" && [%fallback_img_src%]=="upload" ',
		);

		$arguments[ $type . '_image_id' ] = array(
			'type'        => 'hidden',
			'hidden_type' => 'number',
			'title'       => '',
			'placeholder' => '',
			'default'     => '',
			'group'       => __( 'Image', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['img_alt'] = array(
			'type'  => 'text',
			'title' => __( 'Alt text (alternative text)', 'blockstrap-page-builder-blocks' ),
			'desc'  => sprintf( __( '%1$sDescribe the purpose of the image%2$s Leave empty if the image is purely decorative.', 'blockstrap-page-builder-blocks' ), '<a class="components-external-link" href="https://www.w3.org/WAI/tutorials/images/decision-tree" target="_blank" rel="external noreferrer noopener">', '<i class="fas fa-external-link-alt"></i></a>' ),
			'group' => __( 'Image', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['img_lazyload'] = array(
			'type'     => 'select',
			'title'    => __( 'Lazyload', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''      => __( 'Off', 'blockstrap-page-builder-blocks' ),
				'lazy'  => __( 'On', 'blockstrap-page-builder-blocks' ),
				'eager' => __( 'Force off', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Image', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['img_lazyload_notice'] = array(
			'type'            => 'notice',
			'desc'            => __( 'Only lazyload images below the fold (off-screen).', 'blockstrap-page-builder-blocks' ),
			'status'          => 'info',
			'group'           => __( 'Image', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_lazyload%]=="lazy"',
		);

		$arguments['img_link_to'] = array(
			'type'     => 'select',
			'title'    => __( 'Link to', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''       => __( 'None', 'blockstrap-page-builder-blocks' ),
				'post'   => __( 'Post', 'blockstrap-page-builder-blocks' ),
				'media'  => __( 'Media', 'blockstrap-page-builder-blocks' ),
				'custom' => __( 'Custom', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Link', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['img_link'] = array(
			'type'            => 'text',
			'title'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'https://example.com', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_link_to%]=="custom"',
		);

		$arguments['img_link_lightbox'] = array(
			'type'            => 'select',
			'title'           => __( 'Lightbox', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				''  => __( 'No', 'blockstrap-page-builder-blocks' ),
				'1' => __( 'Yes', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_link_to%]=="media"',
		);

		$arguments['lightbox_size'] = array(
			'type'            => 'select',
			'title'           => __( 'Lightbox size', 'blockstrap-page-builder-blocks' ),
			'options'         => array( '' => 'No' ) + array_combine( $image_sizes, $image_sizes ) + array( 'full' => 'full' ),
			'default'         => 'full',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_link_to%]=="media" && [%img_link_lightbox%]!="" && [%img_src%]!="url"',
		);

		$arguments['img_link_hover_effect'] = array(
			'type'            => 'select',
			'title'           => __( 'Hover effect', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				''       => __( 'Darken + Icon', 'blockstrap-page-builder-blocks' ),
				'darken' => __( 'Darken', 'blockstrap-page-builder-blocks' ),
				'none'   => __( 'None', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_link_to%]!=""',
		);

		// caption
		$arguments['text'] = array(
			'type'        => 'textarea',
			'title'       => __( 'Caption', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Enter a caption!', 'blockstrap-page-builder-blocks' ),
			'desc_tip'    => true,
			'group'       => __( 'Caption', 'blockstrap-page-builder-blocks' ),
		);

		// columns
		$arguments['col']    = sd_get_col_input(
			'col',
			array(
				'device_type'     => 'Mobile',
				'group'           => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),
				'element_require' => '',
				'title'           => __( 'Responsive width', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['col_md'] = sd_get_col_input(
			'col',
			array(
				'device_type'     => 'Tablet',
				'group'           => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),
				'element_require' => '',
				'title'           => __( 'Responsive width', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['col_lg'] = sd_get_col_input(
			'col',
			array(
				'device_type'     => 'Desktop',
				'group'           => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),
				'element_require' => '',
				'title'           => __( 'Responsive width', 'blockstrap-page-builder-blocks' ),
			)
		);

		$arguments['img_aspect'] = array(
			'title'    => __( 'Aspect ratio', 'blockstrap-page-builder-blocks' ),
			'desc'     => __( 'For a more consistent image view you can set the aspect ratio of the image view port.', 'blockstrap-page-builder-blocks' ),
			'type'     => 'select',
			'options'  => array(
				'16by9' => __( 'Default (16by9)', 'blockstrap-page-builder-blocks' ),
				'21by9' => __( '21by9', 'blockstrap-page-builder-blocks' ),
				'4by3'  => __( '4by3', 'blockstrap-page-builder-blocks' ),
				'1by1'  => __( '1by1 (square)', 'blockstrap-page-builder-blocks' ),
				''      => __( 'No ratio (natural)', 'blockstrap-page-builder-blocks' ),
			),
			'desc_tip' => true,
			'value'    => '',
			'default'  => '',
			'group'    => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['img_cover'] = array(
			'title'    => __( 'Image cover type', 'blockstrap-page-builder-blocks' ),
			'desc'     => __( 'This is how the image should cover the image viewport.', 'blockstrap-page-builder-blocks' ),
			'type'     => 'select',
			'options'  => array(
				''  => __( 'Default (cover both)', 'blockstrap-page-builder-blocks' ),
				'x' => __( 'Width cover', 'blockstrap-page-builder-blocks' ),
				'y' => __( 'height cover', 'blockstrap-page-builder-blocks' ),
				'n' => __( 'No cover (contain)', 'blockstrap-page-builder-blocks' ),
			),
			'desc_tip' => true,
			'value'    => '',
			'default'  => '',
			'group'    => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),
		);

		// border
		$arguments['img_border']       = sd_get_border_input( 'border', array( 'group' => __( 'Image Styles', 'blockstrap-page-builder-blocks' ) ) );
		$arguments['img_border_width']     = sd_get_border_input( 'width' , array( 'group' => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),'element_require' => '', )); // BS5 only
		$arguments['img_border_opacity']   = sd_get_border_input( 'opacity' , array( 'group' => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),'element_require' => '', )); // BS5 only
		$arguments['img_rounded']      = sd_get_border_input(
			'rounded',
			array(
				'group'           => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),
				'element_require' => '',
			)
		);
		$arguments['img_rounded_size'] = sd_get_border_input(
			'rounded_size',
			array(
				'group'           => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),
				'element_require' => '',
			)
		);

//		// border
//		$arguments['border']         = sd_get_border_input( 'border' );
//		$arguments['border_type']    = sd_get_border_input( 'type' );
//		$arguments['border_width']   = sd_get_border_input( 'width' ); // BS5 only
//		$arguments['border_opacity'] = sd_get_border_input( 'opacity' ); // BS5 only
//		$arguments['rounded']        = sd_get_border_input( 'rounded' );
//		$arguments['rounded_size']   = sd_get_border_input( 'rounded_size' );

		// shadow
		$arguments['img_shadow'] = sd_get_shadow_input( 'shadow', array( 'group' => __( 'Image Styles', 'blockstrap-page-builder-blocks' ) ) );

		$arguments['img_overlay'] = array(
			'type'     => 'select',
			'title'    => __( 'Overlay', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''       => __( 'None', 'blockstrap-page-builder-blocks' ),
				'bottom' => __( 'Bottom', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),
		);

		// text color
		$arguments['text_color'] = sd_get_text_color_input();

		// font size
		$arguments = $arguments + sd_get_font_size_input_group();

		// font size
		$arguments['font_weight'] = sd_get_font_weight_input();

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
//		$arguments['border']       = sd_get_border_input( 'border' );
//		$arguments['rounded']      = sd_get_border_input( 'rounded' );
//		$arguments['rounded_size'] = sd_get_border_input( 'rounded_size' );

		// border
		$arguments['border']         = sd_get_border_input( 'border' );
		$arguments['border_type']    = sd_get_border_input( 'type' );
		$arguments['border_width']   = sd_get_border_input( 'width' ); // BS5 only
		$arguments['border_opacity'] = sd_get_border_input( 'opacity' ); // BS5 only
		$arguments['rounded']        = sd_get_border_input( 'rounded' );
		$arguments['rounded_size']   = sd_get_border_input( 'rounded_size' );

		// shadow
		$arguments['shadow'] = sd_get_shadow_input( 'shadow' );

		// position
		$arguments['position'] = sd_get_position_class_input( 'position' );

		$arguments['sticky_offset_top']    = sd_get_sticky_offset_input( 'top' );
		$arguments['sticky_offset_bottom'] = sd_get_sticky_offset_input( 'bottom' );

		$arguments['display']    = sd_get_display_input( 'd', array( 'device_type' => 'Mobile' ) );
		$arguments['display_md'] = sd_get_display_input( 'd', array( 'device_type' => 'Tablet' ) );
		$arguments['display_lg'] = sd_get_display_input( 'd', array( 'device_type' => 'Desktop' ) );

		// float
		$arguments = function_exists( 'sd_get_float_group' ) ? $arguments + sd_get_float_group() : $arguments;

		$arguments['img_mask'] = array(
			'type'     => 'select',
			'title'    => __( 'Mask', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''         => __( 'None', 'blockstrap-page-builder-blocks' ),
				'blob1'    => 'blob1',
				'blob2'    => 'blob2',
				'blob3'    => 'blob3',
				'circle'   => __( 'circle', 'blockstrap-page-builder-blocks' ),
				'diamond'  => __( 'Diamond', 'blockstrap-page-builder-blocks' ),
				'flower'   => __( 'Flower', 'blockstrap-page-builder-blocks' ),
				'hexagon'  => __( 'Hexagon', 'blockstrap-page-builder-blocks' ),
				'rounded'  => __( 'Rounded', 'blockstrap-page-builder-blocks' ),
				'sketch'   => __( 'sketch', 'blockstrap-page-builder-blocks' ),
				'triangle' => __( 'triangle', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Image Mask', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['img_mask_position'] = array(
			'type'            => 'select',
			'title'           => __( 'Position', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				'center center' => __( 'Center Center', 'blockstrap-page-builder-blocks' ),
				'center left'   => __( 'Center Left', 'blockstrap-page-builder-blocks' ),
				'center right'  => __( 'Center Right', 'blockstrap-page-builder-blocks' ),
				'top center'    => __( 'Top Center', 'blockstrap-page-builder-blocks' ),
				'top left'      => __( 'Top Left', 'blockstrap-page-builder-blocks' ),
				'top right'     => __( 'Top Right', 'blockstrap-page-builder-blocks' ),
				'bottom center' => __( 'Bottom Center', 'blockstrap-page-builder-blocks' ),
				'bottom left'   => __( 'bottom left', 'blockstrap-page-builder-blocks' ),
				'bottom right'  => __( 'bottom right', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => 'center center',
			'desc_tip'        => true,
			'group'           => __( 'Image Mask', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_mask%]!=""',
		);

		// block visibility conditions
		$arguments['visibility_conditions'] = sd_get_visibility_conditions_input();

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
		global $post, $aui_bs5;

		$link_to        = $args['img_link_to'] ? esc_attr( $args['img_link_to'] ) : '';
		$link_hover     = ! empty( $args['img_link_hover_effect'] ) ? esc_attr( $args['img_link_hover_effect'] ) : '';
		$link_image_src = '';
		$image_src      = '';
		$image_size     = ! empty( $args['img_size'] ) ? esc_attr( $args['img_size'] ) : 'full';
		$lightbox_size  = ! empty( $args['lightbox_size'] ) ? esc_attr( $args['lightbox_size'] ) : 'full';
		$image          = '';
		$image_class    = 'mw-100 w-100';
		$image_class   .= ! empty( $args['img_border'] ) ? ' border border-' . esc_attr( $args['img_border'] ) : '';
		$image_class   .= ! empty( $args['img_border_width'] ) ? ' ' . esc_attr( $args['img_border_width'] ) : '';
		$image_class   .= ! empty( $args['img_border_opacity'] ) ? ' ' . esc_attr( $args['img_border_opacity'] ) : '';
		$image_class   .= ! empty( $args['img_rounded'] ) ? ' ' . esc_attr( $args['img_rounded'] ) : '';
		$image_class   .= ! empty( $args['img_rounded_size'] ) ? ' rounded-' . esc_attr( $args['img_rounded_size'] ) : '';
		$image_class   .= ! empty( $args['img_shadow'] ) ? ' ' . esc_attr( $args['img_shadow'] ) : '';
		$image_class   .= ! empty( $args['img_aspect'] ) ? ' embed-responsive-item' : '';

		// image mask
		$image_styles  = ! empty( $args['img_mask'] ) ? '-webkit-mask-image: url("' . BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/masks/' . esc_attr( $args['img_mask'] ) . '.svg");' : '';
		$image_styles .= ! empty( $args['img_mask'] ) ? '-webkit-mask-size: contain;-webkit-mask-repeat: no-repeat;' : '';
		$image_styles .= ! empty( $args['img_mask'] ) && ! empty( $args['img_mask_position'] ) ? '-webkit-mask-position: ' . esc_attr( $args['img_mask_position'] ) . ';' : '';
		$image_style   = $image_styles ? "style='$image_styles'" : '';

		if ( ! empty( $args['img_cover'] ) ) {
			if ( 'x' === $args['img_cover'] ) {
				$image_class .= ' embed-item-cover-x ';
			} elseif ( 'y' === $args['img_cover'] ) {
				$image_class .= ' embed-item-cover-y ';
			} elseif ( 'n' === $args['img_cover'] ) {
				$image_class .= ' embed-item-contain ';
			}
		} else {
			$image_class .= ' embed-item-cover-xy ';
		}

		// image attributes
		$img_alt      = ! empty( $args['img_alt'] ) ? esc_attr( $args['img_alt'] ) : '';
		$img_alt_tag  = ! empty( $img_alt ) ? 'alt="' . $img_alt . '"' : '';
		$img_lazy     = ! empty( $args['img_lazyload'] ) ? esc_attr( $args['img_lazyload'] ) : '';
		$img_lazy_tag = ! empty( $img_alt ) ? 'loading="' . $img_lazy . '"' : '';
		$img_attr     = array(
			'alt'     => $img_alt,
			'loading' => $img_lazy,
			'class'   => $image_class,
		);

		// if eager
		if ('eager' === $img_lazy) {
			$img_attr['fetchpriority'] = 'high';
			$img_attr['decoding'] = 'async';
			$img_attr['importance'] = 'high';
		}

		if ( 'url' === $args['img_src'] ) {
			$image_src = $args['img_url'] ? esc_url_raw( $args['img_url'] ) : '';
		} elseif ( 'featured' === $args['img_src'] ) {
			$image          = get_the_post_thumbnail( $post, $image_size, $img_attr );
			$image_src      = get_the_post_thumbnail_url( $post, 'large' );
			$link_image_src = get_the_post_thumbnail_url( $post, $lightbox_size );
		} elseif ( ! empty( $args['img_image_id'] ) ) {
			$image         = wp_get_attachment_image( absint( $args['img_image_id'] ), $image_size, false, $img_attr );
			$image_src_arr = wp_get_attachment_image_src( absint( $args['img_image_id'] ), 'large' );
			$image_src     = ! empty( $image_src_arr[0] ) ? esc_url_raw( $image_src_arr[0] ) : '';

			$link_image_src_arr = wp_get_attachment_image_src( absint( $args['img_image_id'] ), $lightbox_size );
			$link_image_src     = ! empty( $link_image_src_arr[0] ) ? esc_url_raw( $link_image_src_arr[0] ) : '';
		}

		if ( ! $image_src && $this->is_block_content_call() ) {
			$image = '<img src="' . BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/images/block-image-placeholder.jpg" class="' . sd_sanitize_html_classes( $image_class ) . '" />';
		} elseif ( ! $image ) {
			if ( 'featured' === $args['img_src'] && 'upload' === $args['fallback_img_src'] && ! empty( $args['fallback_img_image_id'] ) ) {
				$image         = wp_get_attachment_image( absint( $args['fallback_img_image_id'] ), $image_size, false, $img_attr );
				$image_src_arr = wp_get_attachment_image_src( absint( $args['fallback_img_image_id'] ), 'large' );
				$image_src     = ! empty( $image_src_arr[0] ) ? esc_url_raw( $image_src_arr[0] ) : '';
			} elseif ( 'featured' === $args['img_src'] && 'default' === $args['fallback_img_src'] ) {
				$post_image = array();

				if ( ! empty( $post ) && ! empty( $post->post_type ) && function_exists( 'geodir_is_gd_post_type' ) && geodir_is_gd_post_type( $post->post_type ) ) {
					$post_images = geodir_get_images( (int) $post->ID, 1, true, 0, array( 'post_images' ) );

					if ( ! empty( $post_images ) ) {
						$post_image = $post_images[0];

						$image_src = geodir_get_image_src( $post_image, $image_size );
						$link_image_src = geodir_get_image_src( $post_image, $lightbox_size );
					}
				}

				if ( ! $image_src ) {
					$image_src = BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/images/block-image-placeholder.jpg';
				}

				if ( ! $img_alt ) {
					if ( ! empty( $post_image ) && ! empty( $post_image->title ) ) {
						$img_alt_tag = 'alt="' . esc_attr( wp_strip_all_tags( stripslashes_deep( $post_image->title ) ) ) . '"';
					} else {
						$img_alt_tag = 'alt="' . __( 'Placeholder image', 'blockstrap-page-builder-blocks' ) . '"';
					}
				}
				$image = '<img src="' . esc_url_raw( $image_src ) . '" class="' . sd_sanitize_html_classes( $image_class ) . '" ' . $img_alt_tag . ' ' . $img_lazy_tag . ' />';
			} else {
				$custom_attr_string = implode(',', array_map(
					function($key, $value) {
						return esc_attr($key) . '|' . esc_attr($value);
					},
					array_keys($img_attr),
					$img_attr
				));
				$attributes_escaped = sd_build_attributes_string_escaped( array('custom'=> $custom_attr_string) );
				$image = '<img src="' . esc_url_raw( $image_src ) . '" ' . $attributes_escaped . ' />';
			}
		}

		if ( ! $image_src && ! $this->is_preview() ) {
			return;
		}

		if ( empty( $link_image_src ) ) {
			$link_image_src = $image_src;
		}

		// maybe add image styles
		if ( $image_style && $image ) {
			$image = str_replace( ' src=', ' ' . $image_style . ' src=', $image );
		}

		// Image overlay
		if ( ! empty( $args['img_overlay'] ) && 'bottom' === $args['img_overlay'] ) {
			$image .= '<span class="img-gradient-overlay"></span>';
		}

		// class
		$wrap_class        = sd_build_aui_class( $args );
		$wrap_class        = $args['img_link_lightbox'] ? 'aui-gallery ' . $wrap_class : $wrap_class;
		$figure_attributes = $wrap_class ? 'class="overflow-hidden ' . sd_sanitize_html_classes( $wrap_class ) . '"' : '';

		// styles
		$wrap_styles        = sd_build_aui_styles( $args );
		$figure_attributes .= $wrap_class ? ' style="' . sd_sanitize_html_classes( $wrap_styles ) . '"' : '';

		$figcaption_class = $args['text_color'] ? 'text-' . sd_sanitize_html_classes( $args['text_color'] ) : '';
		$figcaption       = $args['text'] ? '<figcaption  class="figure-caption ' . $figcaption_class . '">' . wp_kses_post( $args['text'] ) . '</figcaption>' : '';

		// maybe link
		$ratio_cover_class = '';

		$ratio_prefix       = $aui_bs5 ? 'ratio ratio-' : 'embed-responsive embed-responsive-';
		$ratio_val          = $aui_bs5 ? str_replace( 'by', 'x', $args['img_aspect'] ) : $args['img_aspect'];
		$ratio_cover_class .= ! empty( $args['img_aspect'] ) ? ' ' . $ratio_prefix . esc_attr( $ratio_val ) . ' ' : '';

		// hover action
		$ratio_cover_class .= 'none' === $link_hover ? '' : ' embed-has-action ';

		if ( 'media' === $link_to ) {
			$icon  = '' === $link_hover ? '<i class="fas fa-search-plus w-auto h-auto"></i>' : '';
			$image = sprintf(
				'<a href="%1$s" class="%2$s aui-lightbox-image position-relative">%3$s%4$s</a>',
				$link_image_src,
				$ratio_cover_class,
				$image,
				$icon
			);
		} elseif ( 'custom' === $link_to ) {
			$image = sprintf(
				'<a href="%1$s" class="%2$s">%3$s</a>',
				$this->is_block_content_call() ? '#' : esc_url_raw( $args['img_link'] ),
				$ratio_cover_class,
				$image
			);
		} elseif ( 'post' === $link_to ) {
			$icon  = '' === $link_hover ? '<i class="fas fa-link w-auto h-auto"></i>' : '';
			$image = sprintf(
				'<a href="%1$s" class="%2$s position-relative" >%3$s%4$s</a>',
				$this->is_block_content_call() ? '#' : esc_url_raw( get_permalink() ),
				$ratio_cover_class,
				$image,
				$icon
			);
		} else {
			$figure_attributes = str_replace( 'class="', 'class=" ' . $ratio_cover_class, $figure_attributes );
		}

		$figure = sprintf(
			'<figure %1$s>%2$s%3$s</figure>',
			$figure_attributes,
			$image,
			$figcaption
		);

		return $image ? $figure : '';
	}
}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Image' );
	}
);

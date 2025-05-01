<?php

class BlockStrap_Widget_Gallery extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block' ),

			'block-icon'        => 'fas fa-th',
			'block-category'    => 'layout',
			'block-keywords'    => "['gallery','images','photo']",
			'block-supports'    => array(
				'customClassName' => false,
			),
			'block-edit-return' => "el('div', wp.blockEditor.useBlockProps({dangerouslySetInnerHTML: {__html: onChangeContent()}, style: {'minHeight': '30px'} }))",

			'block-wrap'        => '',
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_gallery',
			'name'              => __( 'BS > Gallery', 'blockstrap-page-builder-blocks' ),
			'widget_ops'        => array(
				'classname'   => 'bs-image',
				'description' => esc_html__( 'An image gallery.', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => false,
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array( __( 'Image', 'blockstrap-page-builder-blocks' ), __( 'Captions', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array(
						__( 'Gallery Styles', 'blockstrap-page-builder-blocks' ),
						__( 'Image Styles', 'blockstrap-page-builder-blocks' ),
						__( 'Typography', 'blockstrap-page-builder-blocks' ),
					),
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

		$arguments['img_source'] = array(
			'type'     => 'select',
			'title'    => __( 'Image source', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''               => __( 'Upload', 'blockstrap-page-builder-blocks' ),
				'gd_post_images' => __( 'GeoDirectory post images', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Image', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['images'] = array(
			'type'            => 'images',
			'title'           => __( 'Custom image', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => '',
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Image', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%img_source%]==""',
		);

		$image_sizes = get_intermediate_image_sizes();

		$arguments['img_size'] = array(
			'type'     => 'select',
			'title'    => __( 'Image size', 'blockstrap-page-builder-blocks' ),
			'options'  => array( '' => 'Select image size' ) + array_combine( $image_sizes, $image_sizes ) + array( 'full' => 'full' ),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Image', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['lightbox_size'] = array(
			'type'     => 'select',
			'title'    => __( 'Lightbox', 'blockstrap-page-builder-blocks' ),
			'options'  => array( '' => 'No' ) + array_combine( $image_sizes, $image_sizes ) + array( 'full' => 'full' ),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Image', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['caption_show'] = array(
			'type'     => 'select',
			'title'    => __( 'Caption', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''           => __( 'Hide', 'blockstrap-page-builder-blocks' ),
				'show'       => __( 'Show always', 'blockstrap-page-builder-blocks' ),
				'hover_show' => __( 'Show on hover', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Captions', 'blockstrap-page-builder-blocks' ),
		);

		//$arguments = $arguments + sd_get_background_inputs('bg');

		$arguments['gallery_style'] = array(
			'title'                 => __( 'Gallery style', 'blockstrap-page-builder-blocks' ),
			//          'desc' => __('For a more consistent image view you can set the aspect ratio of the image view port.', 'blockstrap-page-builder-blocks'),
							'type'  => 'select',
			'options'               => array(
				'grid'  => __( 'Grid (default)', 'blockstrap-page-builder-blocks' ),
				'1-2-5' => __( '1-2-5 Grid', 'blockstrap-page-builder-blocks' ),
				'1-2-2' => __( '1-2-2 Grid', 'blockstrap-page-builder-blocks' ),
			),
			'desc_tip'              => true,
			'value'                 => '',
			'default'               => 'grid',
			//          'advanced' => true,
							'group' => __( 'Gallery Styles', 'blockstrap-page-builder-blocks' ),
		);

		// row-cols
		$arguments['row_cols']    = sd_get_row_cols_input(
			'row_cols',
			array(
				'device_type'     => 'Mobile',
				'group'           => __( 'Gallery Styles', 'blockstrap-page-builder-blocks' ),
				'element_require' => '',
				'title'           => __( 'Images per row', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['row_cols_md'] = sd_get_row_cols_input(
			'row_cols',
			array(
				'device_type'     => 'Tablet',
				'group'           => __( 'Gallery Styles', 'blockstrap-page-builder-blocks' ),
				'element_require' => '',
				'title'           => __( 'Images per row', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['row_cols_lg'] = sd_get_row_cols_input(
			'row_cols',
			array(
				'device_type'     => 'Desktop',
				'group'           => __( 'Gallery Styles', 'blockstrap-page-builder-blocks' ),
				'element_require' => '',
				'title'           => __( 'Images per row', 'blockstrap-page-builder-blocks' ),
			)
		);

		$arguments['img_aspect'] = array(
			'title'                 => __( 'Aspect ratio', 'blockstrap-page-builder-blocks' ),
			'desc'                  => __( 'For a more consistent image view you can set the aspect ratio of the image view port.', 'blockstrap-page-builder-blocks' ),
			'type'                  => 'select',
			'options'               => array(
				'16by9' => __( 'Default (16by9)', 'blockstrap-page-builder-blocks' ),
				'21by9' => __( '21by9', 'blockstrap-page-builder-blocks' ),
				'4by3'  => __( '4by3', 'blockstrap-page-builder-blocks' ),
				'1by1'  => __( '1by1 (square)', 'blockstrap-page-builder-blocks' ),
				''      => __( 'No ratio (natural)', 'blockstrap-page-builder-blocks' ),
			),
			'desc_tip'              => true,
			'value'                 => '',
			'default'               => '16by9',
			//          'advanced' => true,
							'group' => __( 'Gallery Styles', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['img_cover'] = array(
			'title'                 => __( 'Image cover type', 'blockstrap-page-builder-blocks' ),
			'desc'                  => __( 'This is how the image should cover the image viewport.', 'blockstrap-page-builder-blocks' ),
			'type'                  => 'select',
			'options'               => array(
				''  => __( 'Default (cover both)', 'blockstrap-page-builder-blocks' ),
				'x' => __( 'Width cover', 'blockstrap-page-builder-blocks' ),
				'y' => __( 'height cover', 'blockstrap-page-builder-blocks' ),
				'n' => __( 'No cover (contain)', 'blockstrap-page-builder-blocks' ),
			),
			'desc_tip'              => true,
			'value'                 => '',
			'default'               => '',
			//          'advanced' => true,
							'group' => __( 'Gallery Styles', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['row_gap_x'] = array(
			'title'    => __( 'Row gap X', 'blockstrap-page-builder-blocks' ),
			'type'     => 'select',
			'options'  => array(
				''  => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			'desc_tip' => true,
			'value'    => '',
			'default'  => '',
			'group'    => __( 'Gallery Styles', 'blockstrap-page-builder-blocks' ),
		);
		$arguments['row_gap_y'] = array(
			'title'    => __( 'Row gap Y', 'blockstrap-page-builder-blocks' ),
			'type'     => 'select',
			'options'  => array(
				''  => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			'desc_tip' => true,
			'value'    => '',
			'default'  => '',
			'group'    => __( 'Gallery Styles', 'blockstrap-page-builder-blocks' ),
		);

		// border
		$arguments['img_border']       = sd_get_border_input( 'border', array( 'group' => __( 'Image Styles', 'blockstrap-page-builder-blocks' ) ) );
		$arguments['img_rounded']      = sd_get_border_input(
            'rounded',
            array(
				'group'           => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%img_border%]',
            )
        );
		$arguments['img_rounded_size'] = sd_get_border_input(
            'rounded_size',
            array(
				'group'           => __( 'Image Styles', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%img_border%]',
            )
        );

		// shadow
		$arguments['img_shadow'] = sd_get_shadow_input( 'shadow', array( 'group' => __( 'Image Styles', 'blockstrap-page-builder-blocks' ) ) );

		// Typography
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

		// margins
		$arguments['mt'] = sd_get_margin_input( 'mt' );
		$arguments['mr'] = sd_get_margin_input( 'mr' );
		$arguments['mb'] = sd_get_margin_input( 'mb', array( 'default' => 3 ) );
		$arguments['ml'] = sd_get_margin_input( 'ml' );

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

		// position
		$arguments['position'] = sd_get_position_class_input( 'position' );

		$arguments['sticky_offset_top']    = sd_get_sticky_offset_input( 'top' );
		$arguments['sticky_offset_bottom'] = sd_get_sticky_offset_input( 'bottom' );

		$arguments['display']    = sd_get_display_input( 'd', array( 'device_type' => 'Mobile' ) );
		$arguments['display_md'] = sd_get_display_input( 'd', array( 'device_type' => 'Tablet' ) );
		$arguments['display_lg'] = sd_get_display_input( 'd', array( 'device_type' => 'Desktop' ) );

		// block visibility conditions
		$arguments['visibility_conditions'] = sd_get_visibility_conditions_input();

		$arguments['css_class'] = sd_get_class_input();

		return $arguments;
	}

	/**
	 * Get dummy images for block demo content.
	 *
	 * @return array
	 */
	public function get_dummy_images() {
		$images = array();
		$dummy_image_url = 'https://ayecode.b-cdn.net/dummy/plugin/';
		$dummy_images = array(
			'happy-pasta.jpg',
			'burger.jpg',
			'food-salad.jpg',
			'las-vegas.jpg',
			'plate-restaurant.jpg',
			'san-francisco.jpg',
			'sea-scape.jpg',
			'happy-burger.jpg',
			'beach-trees.jpg',
			'air-baloons.jpg',
		);

		$count = 1;
		foreach ( $dummy_images as $dummy_image ) {
			// image
			$image = new stdClass();
			$image->ID = 0;
			$image->post_id = 0;
			$image->user_id = 0;
			$image->title = sprintf( __( 'Demo image title %d', 'geodirectory' ), $count );
			$image->caption = sprintf( __( 'Demo image caption %d', 'geodirectory' ), $count );
			$image->file = $dummy_image_url . $dummy_image;
			$image->mime_type = '';
			$image->menu_order = 0;
			$image->featured = 0;
			$image->is_approved = 1;
			$image->metadata = '';
			$image->type = '_dummy';
			$images[] = $image;
			++$count;
		}

		return $images;
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

		$output = '';

		$gd_images = false;
		if ( function_exists( 'geodir_get_images' ) && ! empty( $args['img_source'] ) && $args['img_source'] === 'gd_post_images' ) {
			$images = $this->is_block_content_call() ? $this->get_dummy_images() : geodir_get_images( $post->ID );
			$gd_images = true;
		} elseif ( $this->is_block_content_call() ) {
				$args['images'] = str_replace( '&quot;', '"', $args['images'] );
				$images         = json_decode( '[' . $args['images'] . ']', true );
			} else {
			$images = json_decode( '[' . $args['images'] . ']', true );
		}

		$lightbox_size = $args['lightbox_size'] ? esc_attr( $args['lightbox_size'] ) : '';
		$image_src     = '';
		$image_size    = ! empty( $args['img_size'] ) ? esc_attr( $args['img_size'] ) : 'full';
		$image         = '';
		$image_class   = 'mw-100 w-100 embed-responsive-item';
		$image_class  .= ! empty( $args['img_border'] ) ? ' border border-' . esc_attr( $args['img_border'] ) : '';
		$image_class  .= ! empty( $args['img_rounded'] ) ? ' ' . esc_attr( $args['img_rounded'] ) : '';
		$image_class  .= ! empty( $args['img_rounded_size'] ) ? ' rounded-' . esc_attr( $args['img_rounded_size'] ) : '';
		$image_class  .= ! empty( $args['img_shadow'] ) ? ' ' . esc_attr( $args['img_shadow'] ) : '';

		// img_cover.
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

		$fig_class    = 'figure p-0 m-0';
		$ratio_prefix = $aui_bs5 ? 'ratio ratio-' : 'embed-responsive embed-responsive-';
		$ratio_val    = $aui_bs5 ? str_replace( 'by', 'x', $args['img_aspect'] ) : $args['img_aspect'];
		$fig_class   .= ! empty( $args['img_aspect'] ) ? ' ' . $ratio_prefix . esc_attr( $ratio_val ) : '';

		$col_class  = '';
		$col_class .= ! empty( $args['row_gap_x'] ) ? ' px-' . absint( $args['row_gap_x'] ) : '';
		$col_class .= ! empty( $args['row_gap_y'] ) ? ' mb-' . absint( $args['row_gap_y'] ) : ' mb-4';

		$cols = array();
		if ( ! empty( $images ) ) {
			$i = 0;

			foreach ( $images as $image ) {

				if ( $gd_images ) {
					$img_src = geodir_get_image_src( $image, $image_size );
				} else {
					$img_src = ! empty( $image['sizes'][ $image_size ]['url'] ) ? esc_url_raw( $image['sizes'][ $image_size ]['url'] ) : ( ! empty( $image['url'] ) ? esc_url_raw( $image['url'] ) : '' );

					// Fallback to full size
					if ( ! $img_src && ! empty( $image['sizes']['full']['url'] ) ) {
						$img_src = esc_url_raw( $image['sizes']['full']['url'] );
					}
				}

				if ( $img_src ) {
					$caption = $gd_images ? esc_attr( $image->caption ) : esc_attr( $image['caption'] );

					if ( $gd_images ) {
						$img = geodir_get_image_tag( $image, $image_size, '', $image_class );
						$meta = isset( $image->metadata ) ? maybe_unserialize( $image->metadata ) : '';

						// only set different sizes if not thumbnail
						if ( $image_size != 'thumbnail' ) {
							$img = wp_image_add_srcset_and_sizes( $img, $meta, 0 );
						}
					} else {
						$image_alt = ! empty( $image['alt'] ) ? esc_attr( $image['alt'] ) : '';
						$img = sprintf(
							'<img src="%1$s" class="%2$s" alt="%3$s"/>',
							$img_src,
							$image_class,
							$image_alt
						);
					}

					$figcaption_class = 'figure-caption sr-only';

					$caption = ! empty( $caption ) ? sprintf(
						'<figcaption class="%1$s" style="position: initial;">%2$s</figcaption>',
						$figcaption_class,
						esc_attr( $caption )
					) : '';

					$fig = sprintf(
						'<figure class="%1$s d-block">%2$s%3$s</figure>',
						$fig_class,
						$img,
						$caption
					);

					if ( $lightbox_size ) {
						if ( $gd_images ) {
							$lightbox_src = geodir_get_image_src( $image, $lightbox_size );
						} else {
							$lightbox_src = ! empty( $image['sizes'][ $lightbox_size ]['url'] ) ? esc_url_raw( $image['sizes'][ $lightbox_size ]['url'] ) : ( ! empty( $image['url'] ) ? esc_url_raw( $image['url'] ) : '' );
							// fallback to full size
							if ( ! $lightbox_src && ! empty( $image['sizes']['full']['url'] ) ) {
								$lightbox_src = esc_url_raw( $image['sizes']['full']['url'] );
							}
						}

						$fig = sprintf(
							'<a href="%1$s" class="aui-lightbox-image embed-has-action">%2$s<i class="fas fa-search-plus w-auto h-auto"></i></a>',
							$lightbox_src,
							$fig
						);
					}

					$cols[] = sprintf(
						'<div class="col position-relative %1$s">%2$s</div>',
						$col_class,
						$fig
					);

				}
			}
		}

		// maybe wrap
		if ( ! empty( $cols ) && ! empty( $args['gallery_style'] ) && 'grid' !== $args['gallery_style'] ) {
			$i       = 0;
			$i_count = count( $cols );

			foreach ( $cols as $key => $col ) {
				++$i;

				if ( '1-2-2' === $args['gallery_style'] ) {

					// grid
					if ( 1 === $i ) {
						$col          = str_replace( '<figure ', '<figure style="height: 100.6%" ', $col );
						$cols[ $key ] = sprintf(
							'<div class="col-12 col-md-6 p-0 m-0"><div class="row row-cols-1 p-0 m-0">%1$s</div></div>',
							$col
						);
					} elseif ( 2 === $i ) {
						$cols[ $key ] = '<div class="col-12 col-md-6 p-0 m-0"><div class="row row-cols-2 p-0 m-0">' . $col;
					} elseif ( 5 === $i ) {
						$more = absint( $i_count - 5 );
						/* translators: number of photos */
						$more_text    = sprintf( _n( '+%s photo', '+%s photos', $more, 'blockstrap-page-builder-blocks' ), $more );
						$btn_color_class = $aui_bs5 ? 'text-bg-white' : 'btn-white';
						$col          = $more ? str_replace( '</a>', '<button class="btn btn-sm ' . $btn_color_class . ' position-absolute shadow border-dark" style="bottom: 15px; right: 20px;">' . esc_attr( $more_text ) . '</button></a>', $col ) . '</div></div>' : $col . '</div></div>';
						$cols[ $key ] = $col;
					} elseif ( $i >= 6 ) {
						$cols[ $key ] = str_replace( 'class="', 'class="d-none ', $col );
					}

					// maybe close
					if ( $i === $i_count && $i_count < 5 && $i_count >= 2 ) {

						$cols[ $key ] = $col . '</div></div>';
					}
				} elseif ( '1-2-5' === $args['gallery_style'] ) {

					// grid
					if ( 1 === $i ) {
						$col          = str_replace( '<figure ', '<figure style="height: 100.3%" ', $col );
						$cols[ $key ] = sprintf(
							'<div class="col-12 col-md-8 p-0 m-0"><div class="row row-cols-1 p-0 m-0">%1$s</div></div>',
							$col
						);
					} elseif ( 2 === $i ) {
						$cols[ $key ] = '<div class="col-12 col-md-4 p-0 m-0"><div class="row row-cols-1 p-0 m-0">' . $col;
					} elseif ( 3 === $i ) {
						$cols[ $key ] .= '</div></div>';
					} elseif ( 4 === $i ) {
						$cols[ $key ] = '<div class="col-12 p-0 m-0"><div class="row row-cols-5 p-0 m-0">' . $col;
					} elseif ( $i === $i_count && $i_count < 8 ) {
						$cols[ $key ] = $col . '</div></div>';
					} elseif ( 8 === $i ) {
						$more = absint( $i_count - 8 );
						/* translators: number of photos */
						$more_text    = sprintf( _n( '+%s photo', '+%s photos', $more, 'blockstrap-page-builder-blocks' ), $more );
						$btn_color_class = $aui_bs5 ? 'text-bg-white' : 'btn-white';
						$col          = $more ? str_replace( '</a>', '<button class="btn btn-sm ' . $btn_color_class . ' position-absolute shadow border-dark" style="bottom: 15px; right: 20px;">' . esc_attr( $more_text ) . '</button></a>', $col ) . '</div></div>' : $col . '</div></div>';
						$cols[ $key ] = $col;
					} elseif ( $i > 8 ) {
						$cols[ $key ] = str_replace( 'class="', 'class="d-none ', $col );
					}

					// maybe close
					if ( $i === $i_count && $i_count < 8 && $i_count >= 2 ) {

						$cols[ $key ] = $col . '</div></div>';
					}
				}
}
		}

		$cols = implode( '', $cols );

		// class
		$wrap_class        = sd_build_aui_class( $args );
		$wrap_class        = 'row aui-gallery ' . $wrap_class;
		$figure_attributes = $wrap_class ? 'class="overflow-hidden ' . sd_sanitize_html_classes( $wrap_class ) . '"' : '';

		// styles
		$wrap_styles = sd_build_aui_styles( $args );

		$output .= sprintf(
			'<div class="%1$s" %2$s>%3$s</div>',
			$wrap_class,
			$wrap_styles,
			$cols
		);

		return $output;
	}

	public function block_global_js() {
		$script = 'function bs_build_heading_html($args) { let $html = \'\'; $html += $args.text; return $html; }';

		return $script;
	}
}

// Register widget.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Gallery' );
	}
);

<?php

class BlockStrap_Widget_Pagination extends WP_Super_Duper {

	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block', 'shortcode' ),
			'block-icon'        => 'fas fa-angle-double-right',
			'block-category'    => 'layout',
			'block-keywords'    => "['loop','paging','pagination']",
			'block-wrap'        => '',
			'block-supports'    => array(
				'customClassName' => false,
			),
			'block-edit-return' => "el('span',wp.blockEditor.useBlockProps({dangerouslySetInnerHTML:{__html:onChangeContent()},style:{'minHeight': '30px'},className:''}))",
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_pagination',
			'name'              => __( 'BS > Pagination', 'blockstrap-page-builder-blocks' ),
			'widget_ops'        => array(
				'classname'   => 'bs-pagination',
				'description' => esc_html__( 'Displays a paginated navigation to next/previous set of posts, when applicable.', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array( __( 'Output', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array( __( 'Paging', 'blockstrap-page-builder-blocks' ), __( 'Advanced Paging', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['show_advanced'] = array(
			'type'     => 'select',
			'title'    => __( 'Show Advanced Pagination:', 'blockstrap-page-builder-blocks' ),
			'desc'     => __( 'This will add extra pagination info like `Showing posts x-y of z` before/after pagination.', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''              => __( 'Never', 'blockstrap-page-builder-blocks' ),
				'before'        => __( 'Before', 'blockstrap-page-builder-blocks' ),
				'after'         => __( 'After', 'blockstrap-page-builder-blocks' ),
				'inline_before' => __( 'Inline Before', 'blockstrap-page-builder-blocks' ),
				'inline_after'  => __( 'Inline After', 'blockstrap-page-builder-blocks' ),
				'only'          => __( 'Only (hide paging)', 'blockstrap-page-builder-blocks' ),
			),
			'desc_tip' => true,
			'group'    => __( 'Output', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['show_custom_next_prev'] = array(
			'type'     => 'checkbox',
			'title'    => __( 'Show custom next / previous links', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'value'    => '1',
			'desc_tip' => false,
			'group'    => __( 'Output', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['custom_next_text'] = array(
			'type'            => 'text',
			'title'           => __( 'Next page link text', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'The next page link text. Default: Next', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Next', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Output', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%show_custom_next_prev%]',
		);

		$arguments['custom_next_icon_class'] = array(
			'type'            => 'text',
			'title'           => __( 'Next page link icon class', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Enter a font awesome icon class. Default: fas fa-chevron-right', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'fas fa-chevron-right', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Output', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%show_custom_next_prev%]',
		);

		$arguments['custom_prev_text'] = array(
			'type'            => 'text',
			'title'           => __( 'Previous page link text', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'The previous page link text. Default: Previous', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Previous', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Output', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%show_custom_next_prev%]',
		);

		$arguments['custom_prev_icon_class'] = array(
			'type'            => 'text',
			'title'           => __( 'Previous page link icon class', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Enter a font awesome icon class. Default: fas fa-chevron-left', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'fas fa-chevron-left', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Output', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%show_custom_next_prev%]',
		);

		$arguments['mid_size'] = array(
			'type'     => 'select',
			'title'    => __( 'Middle Pages Numbers:', 'blockstrap-page-builder-blocks' ),
			'desc'     => __( 'How many numbers to either side of the current page. Default 2.', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''   => __( 'Default (2)', 'blockstrap-page-builder-blocks' ),
				'0'  => '0',
				'1'  => '1',
				'2'  => '2',
				'3'  => '3',
				'4'  => '4',
				'5'  => '5',
				'6'  => '6',
				'7'  => '7',
				'8'  => '8',
				'9'  => '9',
				'10' => '10',
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Paging', 'blockstrap-page-builder-blocks' ),
		);

		$arguments = $arguments + sd_get_flex_justify_content_input_group(
            'flex_justify_content',
            array(
				'group'           => __( 'Paging', 'blockstrap-page-builder-blocks' ),
				'element_require' => '![%show_custom_next_prev%]',
            )
        );

		$arguments['paging_style'] = array(
			'title'    => __( 'Style', 'blockstrap-page-builder-blocks' ),
			'type'     => 'select',
			'options'  => array(
				''             => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'rounded'      => __( 'Rounded', 'blockstrap-page-builder-blocks' ),
				'rounded-pill' => __( 'Rounded Pill', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'advanced' => false,
			'group'    => __( 'Paging', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['paging_rounded_size'] = sd_get_border_input(
            'rounded_size',
            array(
				'title'           => __( 'Page Link Border Radius Size', 'blockstrap-page-builder-blocks' ),
				'group'           => __( 'Paging', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%paging_style%]=="rounded"',
            )
        );

		//
		$arguments['size'] = array(
			'title'           => __( 'Size', 'blockstrap-page-builder-blocks' ),
			'type'            => 'select',
			'options'         => array(
				''       => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'small'  => __( 'Small', 'blockstrap-page-builder-blocks' ),
				'medium' => __( 'Medium', 'blockstrap-page-builder-blocks' ),
				'large'  => __( 'Large', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'advanced'        => false,
			'group'           => __( 'Paging', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%paging_style%]==""',
		);

		$arguments['ap_text_color'] = sd_get_text_color_input(
			'text_color',
			array(
				'group'           => __( 'Advanced Paging', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%show_advanced%]',
			)
		);

		$arguments['ap_font_size'] = sd_get_font_size_input(
			'font_size',
			array(
				'group'           => __( 'Advanced Paging', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%show_advanced%]',
			)
		);

		// padding
		$arguments['ap_pt'] = sd_get_padding_input(
            'pt',
            array(
				'group'           => __( 'Advanced Paging', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%show_advanced%]',
            )
        );
		$arguments['ap_pr'] = sd_get_padding_input(
            'pr',
            array(
				'group'           => __( 'Advanced Paging', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%show_advanced%]',
            )
        );
		$arguments['ap_pb'] = sd_get_padding_input(
            'pb',
            array(
				'group'           => __( 'Advanced Paging', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%show_advanced%]',
            )
        );
		$arguments['ap_pl'] = sd_get_padding_input(
            'pl',
            array(
				'group'           => __( 'Advanced Paging', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%show_advanced%]',
            )
        );

		// text align
		$arguments['ap_text_align']    = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Mobile',
				'element_require' => '[%show_advanced%]',
				'group'           => __( 'Advanced Paging', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['ap_text_align_md'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Tablet',
				'element_require' => '[%show_advanced%]',
				'group'           => __( 'Advanced Paging', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['ap_text_align_lg'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Desktop',
				'element_require' => '[%show_advanced%]',
				'group'           => __( 'Advanced Paging', 'blockstrap-page-builder-blocks' ),
			)
		);

		// background
		$arguments['bg'] = sd_get_background_input();

		// margins mobile
		$arguments['mt'] = sd_get_margin_input( 'mt', array( 'device_type' => 'Mobile' ) );
		$arguments['mr'] = sd_get_margin_input( 'mr', array( 'device_type' => 'Mobile' ) );
		$arguments['mb'] = sd_get_margin_input(
			'mb',
			array(
				'device_type' => 'Mobile',
				'default'     => 3,
			)
		);
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
		$arguments['border']         = sd_get_border_input( 'border' );
		$arguments['border_type']    = sd_get_border_input( 'type' );
		$arguments['border_width']   = sd_get_border_input( 'width' ); // BS5 only
		$arguments['border_opacity'] = sd_get_border_input( 'opacity' ); // BS5 only
		$arguments['rounded']        = sd_get_border_input( 'rounded' );
		$arguments['rounded_size']   = sd_get_border_input( 'rounded_size' );

		// shadow
		$arguments['shadow'] = sd_get_shadow_input( 'shadow' );

		$arguments['display']    = sd_get_display_input( 'd', array( 'device_type' => 'Mobile' ) );
		$arguments['display_md'] = sd_get_display_input( 'd', array( 'device_type' => 'Tablet' ) );
		$arguments['display_lg'] = sd_get_display_input( 'd', array( 'device_type' => 'Desktop' ) );

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
		global $wp_query;

		$defaults = array(
			'show_advanced'           => '',
			'bg'                      => '',
			'mt'                      => '',
			'mb'                      => '3',
			'mr'                      => '',
			'ml'                      => '',
			'pt'                      => '',
			'pb'                      => '',
			'pr'                      => '',
			'pl'                      => '',
			'border'                  => '',
			'rounded'                 => '',
			'rounded_size'            => '',
			'shadow'                  => '',
			'mid_size'                => '',

			'show_custom_next_prev'   => '',
			'custom_next_text'        => '',
			'custom_next_icon_class'  => '',
			'custom_prev_text'        => '',
			'custom_prev_icon_class'  => '',
			'paging_style'            => '',
			'paging_rounded_size'     => '',

			'size'                    => '',
			'flex_justify_content'    => '',
			'flex_justify_content_md' => '',
			'flex_justify_content_lg' => '',
		);

		$args = wp_parse_args( $args, $defaults );

		if ( $this->is_preview() ) {
			$args['preview'] = true;
			$args['total'] = 15;
			$args['current'] = 8;
		}

		if ( empty( $args['mid_size'] ) ) {
			$args['mid_size'] = 2;
		}

		/**
		 * Set global for the pagination.
		 *
		 * @since 1.0
		 *
		 * @param array  $args Widget args.
		 * @param object $this Widget object.
		 */
		do_action( 'blockstrap_blocks_pagination_set_global', $args, $this );

		// size
		if ( ! empty( $args['paging_style'] ) ) {
			$args['rounded_style'] = true;
		}

		if ( $args['size'] == 'lg' || $args['size'] == 'large' ) {
			$args['size'] = 'lg';
		} elseif ( $args['size'] == 'sm' || $args['size'] == 'small' ) {
			$args['size'] = 'sm';
		} else {
			$args['size'] = '';
		}

		// wrap class
		$wrap_class = sd_build_aui_class( $args );

		if ( ! empty( $args['show_custom_next_prev'] ) ) {
			$args['flex_justify_content'] = 'justify-content-center';
			$args['flex_justify_content_md'] = 'justify-content-center';
			$args['flex_justify_content_lg'] = 'justify-content-center';

			$custom_next_text = '';
			$custom_prev_text = '';

			if ( ! empty( $args['custom_next_text'] ) ) {
				$custom_next_text .= esc_attr( strip_tags( stripslashes( $args['custom_next_text'] ) ) );
			}

			if ( ! empty( $args['custom_next_icon_class'] ) ) {
				$custom_next_text .= '<i class="ms-2 ' . sd_sanitize_html_classes( $args['custom_next_icon_class'] ) . '" aria-hidden="true"></i>';
			}

			if ( empty( $custom_next_text ) ) {
				$custom_next_text = __( 'Next', 'blockstrap-page-builder-blocks' ) . '<i class="ms-2 fas fa-chevron-right" aria-hidden="true"></i>';
			}

			if ( ! empty( $args['custom_prev_icon_class'] ) ) {
				$custom_prev_text .= '<i class="ms-2 ' . sd_sanitize_html_classes( $args['custom_prev_icon_class'] ) . '" aria-hidden="true"></i>';
			}

			if ( ! empty( $args['custom_prev_text'] ) ) {
				$custom_prev_text .= esc_attr( strip_tags( stripslashes( $args['custom_prev_text'] ) ) );
			}

			if ( empty( $custom_prev_text ) ) {
				$custom_prev_text = '<i class="me-2 fas fa-chevron-left" aria-hidden="true"></i>' . __( 'Previous', 'blockstrap-page-builder-blocks' );
			}

			$args['custom_next_text'] = $custom_next_text;
			$args['custom_prev_text'] = $custom_prev_text;
		}

		$pagination_class = array();

		if ( ! empty( $args['size'] ) ) {
			$pagination_class[] = 'pagination-' . $args['size'];
		}

		$pagination_class[] = sd_build_aui_class(
			array(
				'flex_justify_content'    => $args['flex_justify_content'],
				'flex_justify_content_md' => $args['flex_justify_content_md'],
				'flex_justify_content_lg' => $args['flex_justify_content_lg'],
			)
		);
		$args['class'] = trim( implode( ' ', $pagination_class ) );
		$advanced_pagination_inline = false;

		if ( ! empty( $args['show_advanced'] ) ) {
			$show_advanced = $args['show_advanced'];

			$advance_pagination = $this->get_advanced_pagination( $args );

			if ( $advance_pagination ) {
				if ( $show_advanced == 'before' ) {
					$args['before_paging'] = $advance_pagination;
				} elseif ( $show_advanced == 'after' ) {
					$args['after_paging'] = $advance_pagination;
				} elseif ( $show_advanced == 'inline_before' ) {
					$args['before_paging'] = $advance_pagination;
					$wrap_class .= ' d-flex align-items-center justify-content-between';
					$advanced_pagination_inline = true;
				} elseif ( $show_advanced == 'inline_after' ) {
					$args['after_paging'] = $advance_pagination;
					$wrap_class .= ' d-flex align-items-center justify-content-between';
					$advanced_pagination_inline = true;
				} elseif ( $show_advanced == 'only' ) {
					$args['advanced_pagination_only'] = $advance_pagination;
				}
			} elseif ( $show_advanced == 'only' ) {
				return;
			}
		}

		ob_start();
		?>
		<div class="<?php echo esc_attr( $wrap_class ); ?>">
			<?php
			if ( ! empty( $args['advanced_pagination_only'] ) ) {
				echo wp_kses_post( $args['advanced_pagination_only'] );
			} else {
				echo wp_kses_post( aui()->pagination( $args ) );
			}
			?>
		</div>
		<?php
		$output = ob_get_clean();

		if ( ! empty( $args['paging_style'] ) && $args['paging_style'] == 'rounded' ) {
			$paging_rounded_size = $args['paging_rounded_size'] !== '' ? '-' . absint( $args['paging_rounded_size'] ) : '';
			$output = str_replace( 'rounded-pill', 'rounded' . $paging_rounded_size, $output );
		}

		if ( $advanced_pagination_inline ) {
			$output = str_replace( 'w-100', '', $output );
		}

		/**
		 * Pagination output.
		 *
		 * @since 1.0
		 *
		 * @param string $output Pagination content.
		 * @param array  $args Widget args.
		 * @param object $this Widget object.
		 */
		return apply_filters( 'blockstrap_blocks_pagination_output', $output, $args, $this );
	}

	public function get_advanced_pagination( $args = array() ) {
		global $wp_query, $posts_per_page, $paged;

		$advanced_pagination = '';

		if ( empty( $posts_per_page ) ) {
			$posts_per_page = (int) get_option( 'posts_per_page' );
		}

		if ( empty( $paged ) ) {
			$paged = 1;
		}

		$numposts = ! empty( $args['preview'] ) ? ( $args['total'] * $posts_per_page ) : (int) $wp_query->found_posts;
		$max_page = ceil( $numposts / $posts_per_page );
		$start_no = ( $paged - 1 ) * $posts_per_page + 1;
		$end_no   = min( $paged * $posts_per_page, $numposts );

		$pegination_text = wp_sprintf( __( 'Viewing %1$s posts %2$d - %3$d of %4$d', 'blockstrap-page-builder-blocks' ), $posts_per_page, $start_no, $end_no, $numposts );

		/**
		 * Adds an extra pagination text.
		 *
		 * @since 1.0
		 *
		 * @param string $pegination_text Extra pagination text.
		 * @param string $start_no First result number.
		 * @param string $end_no Last result number.
		 * @param string $numposts Total number of posts.
		 * @param array  $args Widget args.
		 * @param object $this Widget object.
		 */
		$pegination_text = apply_filters( 'blockstrap_blocks_advance_pagination', $pegination_text, $start_no, $end_no, $numposts, $args, $this );

		$class = sd_build_aui_class(
			array(
				'text_color' => $args['ap_text_color'] ? $args['ap_text_color'] : 'muted',
				'font_size'  => $args['ap_font_size'],
				'pt'         => $args['ap_pt'],
				'pr'         => $args['ap_pr'],
				'pb'         => $args['ap_pb'],
				'pl'         => $args['ap_pl'],
				'text_align' => $args['ap_text_align'] ? $args['ap_text_align'] : 'text-center',
				'text_align' => $args['ap_text_align_md'] ? $args['ap_text_align_md'] : 'text-center',
				'text_align' => $args['ap_text_align_lg'] ? $args['ap_text_align_lg'] : 'text-center',
			)
		);

		if ( empty( $class ) ) {
			$class = 'text-muted pb-2';
		}
		$advanced_pagination = '<div class="bs-pagination-advanced ' . sd_sanitize_html_classes( $class ) . '">' . $pegination_text . '</div>';

		/**
		 * Adds an extra pagination info above/under pagination.
		 *
		 * @since 1.0
		 *
		 * @param string $advanced_pagination Extra pagination info content.
		 * @param string $start_no First result number.
		 * @param string $end_no Last result number.
		 * @param string $numposts Total number of posts.
		 * @param array  $args Widget args.
		 * @param object $this Widget object.
		 */
		return apply_filters( 'blockstrap_blocks_advance_pagination', $advanced_pagination, $start_no, $end_no, $numposts, $args, $this );
	}
}

// Register block.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Pagination' );
	}
);

<?php

class BlockStrap_Widget_Search extends WP_Super_Duper {

	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block', 'shortcode' ),
			'block-icon'        => 'fas fa-search',
			'block-category'    => 'layout',
			'block-keywords'    => "['blog','search']",
			'block-wrap'        => '',
			'block-supports'    => array(
				'customClassName' => false,
			),
			'block-edit-return' => "el('span',wp.blockEditor.useBlockProps({dangerouslySetInnerHTML:{__html:onChangeContent()},style:{'minHeight': '30px'},className:''}))",
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_search',
			'name'              => __( 'BS > Search', 'blockstrap-page-builder-blocks' ),
			'widget_ops'        => array(
				'classname'   => 'bs-search',
				'description' => esc_html__( 'Displays the blog search bar.', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array( __( 'Search Input', 'blockstrap-page-builder-blocks' ), __( 'Search Button', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array( __( 'Button', 'blockstrap-page-builder-blocks' ), __( 'Typography', 'blockstrap-page-builder-blocks' ) ),
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

		// Search input
		$arguments['placeholder'] = array(
			'type'        => 'text',
			'title'       => __( 'Placeholder', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Search input placeholder text.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Search...', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Search Input', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['input_size'] = array(
			'type'     => 'select',
			'title'    => __( 'Size', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''       => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'small'  => __( 'Small', 'blockstrap-page-builder-blocks' ),
				'medium' => __( 'Medium', 'blockstrap-page-builder-blocks' ),
				'large'  => __( 'Large', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Search Input', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['button_hide'] = array(
			'type'     => 'checkbox',
			'title'    => __( 'Hide Search Button', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'value'    => '1',
			'desc_tip' => false,
			'group'    => __( 'Search Button', 'blockstrap-page-builder-blocks' ),
		);

		// Search button
		$arguments['button_title'] = array(
			'type'            => 'text',
			'title'           => __( 'Button Title', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Search button title. Leave blank to hide button.', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Search', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'element_require' => '![%button_hide%]',
			'group'           => __( 'Search Button', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['button_icon_class'] = array(
			'type'            => 'text',
			'title'           => __( 'Icon class', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'fas fa-search', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'element_require' => '![%button_hide%]',
			'group'           => __( 'Search Button', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['button_icon_position'] = array(
			'type'            => 'select',
			'title'           => __( 'Icon position', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				'left'  => __( 'Left', 'blockstrap-page-builder-blocks' ),
				'right' => __( 'right', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Search Button', 'blockstrap-page-builder-blocks' ),
			'element_require' => '([%button_icon_class%]!="" && ![%button_hide%])',
		);

		$arguments = $arguments + sd_get_background_inputs(
			'link_bg',
			array(
				'title'           => __( 'Color', 'blockstrap-page-builder-blocks' ),
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '![%button_hide%]',
				'default'         => 'primary',
				'tab'             => array(
					'title'     => __( 'Normal', 'blockstrap-page-builder-blocks' ),
					'key'       => 'button_normal',
					'tabs_open' => true,
					'open'      => true,
					'class'     => 'text-center w-50 d-flex justify-content-center',
				),
			),
			array(
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '(![%button_hide%] && [%link_bg%]=="custom-color")',
			),
			array(
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '(![%button_hide%] && [%link_bg%]=="custom-gradient")',
			),
			false,
			true
		);

		$arguments = $arguments + sd_get_text_color_input_group(
			'text_color',
			array(
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '![%button_hide%]',
			),
			array(
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '![%button_hide%]',
				'tab'             => array(
					'close' => true,
				),
			)
		);

		$arguments = $arguments + sd_get_background_inputs(
			'bg_hover',
			array(
				'title'           => __( 'Color', 'blockstrap-page-builder-blocks' ),
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '![%button_hide%]',
				'default'         => '',
				'tab'             => array(
					'title' => __( 'Hover', 'blockstrap-page-builder-blocks' ),
					'key'   => 'button_hover',
					'open'  => true,
					'class' => 'text-center w-50 d-flex justify-content-center',
				),
			),
			array(
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '(![%button_hide%] && [%bg_hover%]=="custom-color")',
			),
			array(
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '(![%button_hide%] && [%bg_hover%]=="custom-gradient")',
			),
			false,
			true
		);

		// text color
		$arguments = $arguments + sd_get_text_color_input_group(
			'text_color_hover',
			array(
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '![%button_hide%]',
			),
			array(
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '![%button_hide%]',
				'tab'             => array(
					'close'      => true,
					'tabs_close' => true,
				),
			)
		);

		// Typography
		// custom font size
		$arguments['font_size_custom'] = sd_get_font_custom_size_input( 'font_size_custom', array( 'element_require' => '![%button_hide%]' ) );

		// font weight.
		$arguments['font_weight'] = sd_get_font_weight_input( 'font_weight', array( 'element_require' => '![%button_hide%]' ) );

		// font case
		$arguments['font_case'] = sd_get_font_case_input( 'font_case', array( 'element_require' => '![%button_hide%]' ) );

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

		$arguments['css_class'] = sd_get_class_input();

		$arguments['styleid'] = array(
			'type'     => 'hidden',
			'title'    => __( 'Style ID', 'blockstrap-page-builder-blocks' ),
			'desc_tip' => true,
			'group'    => __( 'Advanced', 'blockstrap-page-builder-blocks' ),
		);

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
		global $aui_bs5;

		$args = wp_parse_args(
			$args,
			array(
				'placeholder'          => '',
				'input_size'           => '',
				'button_hide'          => '',
				'button_title'         => '',
				'button_icon_class'    => '',
				'button_icon_position' => '',
				'font_size'            => '',
			)
		);

		$wrap_class = sd_build_aui_class( $args );

		// Button
		if ( empty( $args['button_hide'] ) ) {
			$button_title = trim( esc_html( $args['button_title'] ) );
			$icon_left = '';
			$icon_right = '';

			if ( ! empty( $args['button_icon_class'] ) ) {
				if ( $args['button_icon_position'] == 'right' ) {
					$ml = $button_title ? ( $aui_bs5 ? ' ms-2' : ' ml-2' ) : '';
					$icon_right = '<i class="' . sd_sanitize_html_classes( $args['button_icon_class'] ) . $ml . '"></i>';
				} else {
					$mr = $button_title ? ( $aui_bs5 ? ' me-2' : ' mr-2' ) : '';
					$icon_left = '<i class="' . sd_sanitize_html_classes( $args['button_icon_class'] ) . $mr . '"></i>';
				}
			}

			$button_text = trim( $icon_left . $button_title . $icon_right );

			if ( empty( $button_text ) ) {
				$button_text = __( 'Search', 'blockstrap-page-builder-blocks' );
			}

			if ( 'custom-color' === $args['link_bg'] ) {
				$args['bg']       = $args['link_bg'];
				$args['bg_color'] = $args['link_bg_color'];
			} elseif ( 'custom-gradient' === $args['link_bg'] ) {
				$args['bg']          = $args['link_bg'];
				$args['bg_gradient'] = $args['link_bg_gradient'];
			}

			$button_class = 'btn ' . ( $aui_bs5 ? ' rounded-end' : ' rounded-right' );
			if ( ! empty( $args['link_bg'] ) ) {
				$button_class .= ' btn-' . sanitize_html_class( $args['link_bg'] );
			} else {
				$button_class .= ' btn-primary';
			}

			$button_class .= ' ' . sd_build_aui_class(
				array(
					'text_color'  => $args['text_color'],
					'font_size'   => $args['font_size'],
					'font_case'   => $args['font_case'],
					'font_weight' => $args['font_weight'],
				)
			);

			if ( function_exists( 'sd_build_hover_styles' ) ) {
				$button_style = sd_build_hover_styles( $args, $this->is_preview() );
			} else {
				$button_style = '';
			}

			$button_inline_style = sd_build_aui_styles( $args );
			$button_inline_style  = $button_inline_style ? ' style="' . $button_inline_style . '"' : '';

			$button = '<button class="' . $button_class . '" type="submit" id="bs-block-search-btn"' . $button_inline_style . '>' . $button_text . '</button>' . $button_style;
		} else {
			$button = '';
		}

		if ( $args['placeholder'] === '' ) {
			$args['placeholder'] = __( 'Search...', 'blockstrap-page-builder-blocks' );
		}

		// Size
		if ( $args['input_size'] == 'small' ) {
			$size = 'sm';
		} elseif ( $args['input_size'] == 'large' ) {
			$size = 'lg';
		} else {
			$size = '';
		}

		$input = aui()->input(
			array(
				'id'                => 'bs-block-search-s',
				'name'              => 's',
				'type'              => 'text',
				'placeholder'       => esc_html( $args['placeholder'] ),
				'value'             => get_search_query(),
				'size'              => $size,
				'input_group_right' => $button,
				'no_wrap'           => true,
			)
		);

		$output = sprintf( '<form role="search" method="get" action="%s" class="%s">%s</form>', esc_url( $this->is_preview() ? 'jsvascript:void(0)' : home_url( '/' ) ), esc_attr( $wrap_class ), $input );

		return $output;
	}
}

// Register block.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Search' );
	}
);

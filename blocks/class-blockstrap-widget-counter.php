<?php

class BlockStrap_Widget_Counter extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block', 'shortcode' ),
			'block-icon'        => 'fas fa-stopwatch-20',
			'block-category'    => 'layout',
			'block-keywords'    => "['counter','count','number']",
			'block-supports'    => array(
				'customClassName' => false,
			),
			'block-edit-return' => "el('span', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent() },
									style: sd_build_aui_styles(props.attributes),
									className: sd_build_aui_class(props.attributes),
								}),
//								el('span',{className:'aui-counter-number',
//								'data-auistart': props.attributes.num_start,
//								'data-auiend': props.attributes.num_end,
//								'data-auicounter': props.attributes.num_end,
//								},props.attributes.num_end)
								)",
			'block-wrap'        => '',
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_counter',
			'name'              => __( 'BS > Counter', 'blockstrap-page-builder-blocks' ),
			'widget_ops'        => array(
				'classname'   => 'bs-counter',
				'description' => esc_html__( 'Animate a number up/down.', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array( __( 'Text', 'blockstrap-page-builder-blocks' ) ),
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
						__( 'Number Typography', 'blockstrap-page-builder-blocks' ),
						__( 'Title Typography', 'blockstrap-page-builder-blocks' ),
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

		$arguments['num_start'] = array(
			'type'     => 'number',
			'title'    => __( 'Start number', 'blockstrap-page-builder-blocks' ),
			'default'  => '0',
			'desc_tip' => true,
			'group'    => __( 'Text', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['num_end'] = array(
			'type'     => 'number',
			'title'    => __( 'End number', 'blockstrap-page-builder-blocks' ),
			'default'  => '123',
			'desc_tip' => true,
			'group'    => __( 'Text', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['num_prefix'] = array(
			'type'     => 'text',
			'title'    => __( 'Prefix', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Text', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['num_suffix'] = array(
			'type'     => 'text',
			'title'    => __( 'Suffix', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Text', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['duration'] = array(
			'type'     => 'number',
			'title'    => __( 'Animation duration', 'blockstrap-page-builder-blocks' ),
			'default'  => '2000',
			'desc_tip' => true,
			'group'    => __( 'Text', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['num_sep'] = array(
			'type'     => 'checkbox',
			'title'    => __( 'Thousand Separator', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'value'    => '1',
			'desc_tip' => false,
			'group'    => __( 'Text', 'blockstrap-page-builder-blocks' ),
			//          'element_require' => '[%bg%]=="custom-gradient"',
		);

		$arguments['num_sep_type'] = array(
			'type'            => 'select',
			'title'           => __( 'Separator', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				',' => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'.' => __( 'Dot', 'blockstrap-page-builder-blocks' ),
				' ' => __( 'Space', 'blockstrap-page-builder-blocks' ),
				'_' => __( 'Underline', 'blockstrap-page-builder-blocks' ),
				"'" => __( 'Apostrophe', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => ',',
			'desc_tip'        => true,
			'group'           => __( 'Text', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%num_sep%]',
		);

		$arguments['text'] = array(
			'type'        => 'textarea',
			'title'       => __( 'Title', 'blockstrap-page-builder-blocks' ),
			//          'desc' => __('Brand text', 'blockstrap-page-builder-blocks'),
			'placeholder' => __( 'Enter you title!', 'blockstrap-page-builder-blocks' ),
			'desc_tip'    => true,
			'group'       => __( 'Text', 'blockstrap-page-builder-blocks' ),
		);

		// text color
		$arguments['num_text_color'] = sd_get_text_color_input(
			'',
			array(
				'group'   => __( 'Number Typography', 'blockstrap-page-builder-blocks' ),
				'default' => 'primary',
			)
		);

		// font size
		$arguments = $arguments + sd_get_font_size_input_group(
			'num_font_size',
			array(
				'group'   => __( 'Number Typography', 'blockstrap-page-builder-blocks' ),
				'default' => 'h2',
			),
			array( 'group' => __( 'Number Typography', 'blockstrap-page-builder-blocks' ) )
		);

		// font weight
		$arguments['num_font_weight'] = sd_get_font_weight_input( '', array( 'group' => __( 'Number Typography', 'blockstrap-page-builder-blocks' ) ) );

		// Text justify
		$arguments['num_text_justify'] = sd_get_text_justify_input( '', array( 'group' => __( 'Number Typography', 'blockstrap-page-builder-blocks' ) ) );

		// text align
		$arguments['num_text_align']    = sd_get_text_align_input(
			'text_align',
			array(
				'group'           => __( 'Number Typography', 'blockstrap-page-builder-blocks' ),
				'device_type'     => 'Mobile',
				'element_require' => '[%num_text_justify%]==""',
				'default'         => 'text-center',
			)
		);
		$arguments['num_text_align_md'] = sd_get_text_align_input(
			'text_align',
			array(
				'group'           => __( 'Number Typography', 'blockstrap-page-builder-blocks' ),
				'device_type'     => 'Tablet',
				'element_require' => '[%num_text_justify%]==""',
			)
		);
		$arguments['num_text_align_lg'] = sd_get_text_align_input(
			'text_align',
			array(
				'group'           => __( 'Number Typography', 'blockstrap-page-builder-blocks' ),
				'device_type'     => 'Desktop',
				'element_require' => '[%num_text_justify%]==""',
			)
		);

		// Title typography
		// text color
		$arguments['title_text_color'] = sd_get_text_color_input( '', array( 'group' => __( 'Title Typography', 'blockstrap-page-builder-blocks' ) ) );

		// font size
		$arguments = $arguments + sd_get_font_size_input_group( 'title_font_size', array( 'group' => __( 'Title Typography', 'blockstrap-page-builder-blocks' ) ), array( 'group' => __( 'Title Typography', 'blockstrap-page-builder-blocks' ) ) );

		// font weight
		$arguments['title_font_weight'] = sd_get_font_weight_input( '', array( 'group' => __( 'Title Typography', 'blockstrap-page-builder-blocks' ) ) );

		// Text justify
		$arguments['title_text_justify'] = sd_get_text_justify_input( '', array( 'group' => __( 'Title Typography', 'blockstrap-page-builder-blocks' ) ) );

		// text align
		$arguments['title_text_align']    = sd_get_text_align_input(
			'text_align',
			array(
				'group'           => __( 'Title Typography', 'blockstrap-page-builder-blocks' ),
				'device_type'     => 'Mobile',
				'element_require' => '[%title_text_justify%]==""',
				'default'         => 'text-center',
			)
		);
		$arguments['title_text_align_md'] = sd_get_text_align_input(
			'text_align',
			array(
				'group'           => __( 'Title Typography', 'blockstrap-page-builder-blocks' ),
				'device_type'     => 'Tablet',
				'element_require' => '[%title_text_justify%]==""',
			)
		);
		$arguments['title_text_align_lg'] = sd_get_text_align_input(
			'text_align',
			array(
				'group'           => __( 'Title Typography', 'blockstrap-page-builder-blocks' ),
				'device_type'     => 'Desktop',
				'element_require' => '[%title_text_justify%]==""',
			)
		);

		//      print_r($arguments);exit;

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

		$start      = isset( $args['num_start'] ) ? absint( $args['num_start'] ) : '';
		$end        = isset( $args['num_end'] ) ? absint( $args['num_end'] ) : '';
		$duration   = $args['duration'] ? absint( $args['duration'] ) : '2000';
		$num_prefix = $args['num_prefix'] ? esc_attr( $args['num_prefix'] ) : '';
		$num_sep    = $args['num_sep'] ? esc_attr( $args['num_sep_type'] ) : '';
		$num_suffix = $args['num_suffix'] ? esc_attr( $args['num_suffix'] ) : '';
		$text       = $args['text'] ? esc_attr( $args['text'] ) : '';

		// prefix.
		$prefix = $num_prefix ? sprintf(
			'<span class="bs-counter-prefix">%1$s</span>',
			$num_prefix
		) : '';

		// number.
		$number = '' !== $start ? sprintf(
			'<span class="bs-counter-number" data-auicounter data-auistart="%1$s" data-auiend="%2$s" data-auiduration="%3$s" data-auisep="%4$s">%5$s</span>',
			$start,
			$end,
			$duration,
			$num_sep,
			$end
		) : '';

		// suffix.
		$suffix = $num_suffix ? sprintf(
			'<span class="bs-counter-suffix">%1$s</span>',
			$num_suffix
		) : '';

		$title_class = sd_build_aui_class(
			array(
				'text_color'    => $args['title_text_color'],
				'font_size'     => $args['title_font_size'],
				'font_weight'   => $args['title_font_weight'],
				'text_justify'  => $args['title_text_justify'],
				'text_align'    => $args['title_text_align'],
				'text_align_md' => $args['title_text_align_md'],
				'text_align_lg' => $args['title_text_align_lg'],
			)
		);

		$title_styles = sd_build_aui_styles(
			array(
				'font_size_custom' => $args['title_font_size_custom'],
			)
		);
		$title_style  = $title_styles ? 'style="' . $title_styles . '"' : '';

		// title.
		$title = $text ? sprintf(
			'<div class="bs-counter-title %1$s" %2$s>%3$s</div>',
			$title_class,
			$title_style,
			$text
		) : '';

		$wrap_class  = 'bs-counter ';
		$wrap_class .= sd_build_aui_class( $args );

		$wrap_styles = sd_build_aui_styles( $args );
		$styles      = $wrap_styles ? 'style="' . $wrap_styles . '"' : '';

		$number_class = sd_build_aui_class(
			array(
				'text_color'    => $args['num_text_color'],
				'font_size'     => $args['num_font_size'],
				'font_weight'   => $args['num_font_weight'],
				'text_justify'  => $args['num_text_justify'],
				'text_align'    => $args['num_text_align'],
				'text_align_md' => $args['num_text_align_md'],
				'text_align_lg' => $args['num_text_align_lg'],
			)
		);

		$number_styles = sd_build_aui_styles(
			array(
				'font_size_custom' => $args['num_font_size_custom'],
			)
		);
		$number_style  = $number_styles ? 'style="' . $number_styles . '"' : '';

		$number_wrapper = '' !== $start ? sprintf(
			'<div class="bs-counter-number-wrapper %1$s" %2$s %3$s>%4$s%5$s%6$s</div>%7$s',
			$number_class,
			$styles,
			$number_style,
			$prefix,
			$number,
			$suffix,
			$title
		) : '';

		if ( $this->is_block_content_call() ) {
			return $number_wrapper;
		} else {
			return '' !== $start ? sprintf(
				'<span class="bs-counter-wrapper %1$s" %2$s>%3$s</span>',
				$wrap_class,
				$styles,
				$number_wrapper
			) : '';
		}

	}

}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Counter' );
	}
);


<?php

class BlockStrap_Widget_Headline extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'       => 'blockstrap',
			'output_types'     => array( 'block', 'shortcode' ),
			'block-icon'       => 'fas fa-heading',
			'block-category'   => 'layout',
			'block-keywords'   => "['heading','title','text','headline']",
			'block-supports'   => array(
				'customClassName' => false,
			),
			'block-wrap'       => '',
			'class_name'       => __CLASS__,
			'base_id'          => 'bs_headline',
			'name'             => __( 'BS > Headline', 'blockstrap-page-builder-blocks' ),
			'widget_ops'       => array(
				'classname'   => 'bs-heading',
				'description' => esc_html__( 'A animated headline element', 'blockstrap-page-builder-blocks' ),
			),
			'example'          => array(
				'attributes' => array(
					'text' => 'Earth',
				),
			),
			'no_wrap'          => true,
			'block_group_tabs' => array(
				'content'  => array(
					'groups' => array(
						__( 'Title', 'blockstrap-page-builder-blocks' ),
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
					'groups' => array(
						__( 'Typography', 'blockstrap-page-builder-blocks' ),
						__( 'Highlight Typography', 'blockstrap-page-builder-blocks' )
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
					'groups' => array(
						__( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ),
						__( 'Advanced', 'blockstrap-page-builder-blocks' )
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

	public function frontend_js() {

	}

	/**
	 * Set the arguments later.
	 *
	 * @return array
	 */
	public function set_arguments() {

		$arguments = array();

//		$arguments['animation_notice'] = [
//			'type'   => 'notice',
//			'desc'   => __( 'Currently animations are limited to the frontend only.', 'blockstrap-page-builder-blocks' ),
//			'status' => 'info',
//			'group'  => __( 'Title', 'blockstrap-page-builder-blocks' ),
//		];

		$arguments['style'] = array(
			'type'     => 'select',
			'title'    => __( 'Style', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'highlight' => __( 'Highlighted', 'blockstrap-page-builder-blocks' ),
				'rotate'    => __( 'Rotating', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => 'highlight',
			'desc_tip' => true,
			'group'    => __( 'Title', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['shape'] = array(
			'type'            => 'select',
			'title'           => __( 'Style', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				'circle'           => __( 'Circle', 'blockstrap-page-builder-blocks' ),
				'underline_zigzag' => __( 'Underline zigzag', 'blockstrap-page-builder-blocks' ),
				'x'                => __( 'X', 'blockstrap-page-builder-blocks' ),
				'strikethrough'    => __( 'Strikethrough', 'blockstrap-page-builder-blocks' ),
				'curly'            => __( 'Curly', 'blockstrap-page-builder-blocks' ),
				'diagonal'         => __( 'Diagonal', 'blockstrap-page-builder-blocks' ),
				'double'           => __( 'Double', 'blockstrap-page-builder-blocks' ),
				'double_underline' => __( 'Double Underline', 'blockstrap-page-builder-blocks' ),
				'underline'        => __( 'Underline', 'blockstrap-page-builder-blocks' ),

			),
			'default'         => 'highlight',
			'desc_tip'        => true,
			'group'           => __( 'Title', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%style%]=="highlight"',

		);

		$arguments['animation'] = array(
			'type'            => 'select',
			'title'           => __( 'Animation', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				'rotate-1'    => __( 'Rotate 1', 'blockstrap-page-builder-blocks' ),
				'rotate-2'    => __( 'Rotate 2', 'blockstrap-page-builder-blocks' ),
				'rotate-3'    => __( 'Rotate 3', 'blockstrap-page-builder-blocks' ),
				'type'        => __( 'Type', 'blockstrap-page-builder-blocks' ),
				'loading-bar' => __( 'Loading Bar', 'blockstrap-page-builder-blocks' ),
				'slide'       => __( 'Slide', 'blockstrap-page-builder-blocks' ),
				'clip'        => __( 'Clip', 'blockstrap-page-builder-blocks' ),
				'zoom'        => __( 'Zoom', 'blockstrap-page-builder-blocks' ),
				'scale'       => __( 'Scale', 'blockstrap-page-builder-blocks' ),
				'push'        => __( 'Push', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => 'slide',
			'desc_tip'        => true,
			'group'           => __( 'Title', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%style%]=="rotate"',
		);

		// Animations
		$arguments['loop'] = array(
			'type'            => 'checkbox',
			'title'           => __( 'Infinite Loop', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'value'           => '1',
			'desc_tip'        => false,
			'group'           => __( 'Title', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%style%]=="highlight"',
		);

		$arguments['highlight_duration'] = array(
			'type'            => 'number',
			'title'           => __( 'Duration (ms)', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( '1200', 'blockstrap-page-builder-blocks' ),
			'desc_tip'        => true,
			'group'           => __( 'Title', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%style%]=="highlight"',
		);

		$arguments['rotate_duration'] = array(
			'type'            => 'number',
			'title'           => __( 'Duration (ms)', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( '2500', 'blockstrap-page-builder-blocks' ),
			'desc_tip'        => true,
			'group'           => __( 'Title', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%style%]=="rotate"',
		);

		$arguments['delay'] = array(
			'type'            => 'number',
			'title'           => __( 'Delay (ms)', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( '8000', 'blockstrap-page-builder-blocks' ),
			'desc_tip'        => true,
			'group'           => __( 'Title', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%style%]=="highlight"',
		);

		if ( defined( 'GEODIRECTORY_VERSION' ) ) {
			$arguments['variables_notice'] = [
				'type'   => 'notice',
				'desc'   => __( 'GeoDirectory SEO variables can be used here. eg: %%in_location_single%%', 'blockstrap-page-builder-blocks' ),
				'status' => 'info',
				'group'  => __( 'Title', 'blockstrap-page-builder-blocks' ),
			];
		}

		$arguments['text'] = array(
			'type'        => 'text',
			'title'       => __( 'Before Text', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Enter your before text', 'blockstrap-page-builder-blocks' ),
			'default'     => __( 'Add Your ', 'blockstrap-page-builder-blocks' ),
			'desc_tip'    => true,
			'group'       => __( 'Title', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['text_highlight'] = array(
			'type'            => 'text',
			'title'           => __( 'Highlighted Text', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Enter you title!', 'blockstrap-page-builder-blocks' ),
			'default'         => 'Highlighted',
			'desc_tip'        => true,
			'group'           => __( 'Title', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%style%]=="highlight"',

		);

		$arguments['text_rotating'] = array(
			'type'            => 'textarea',
			'title'           => __( 'Rotating Text', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Enter you title!', 'blockstrap-page-builder-blocks' ),
			'default'         => 'Rotating\nChanging\nCycling',
			'desc_tip'        => true,
			'group'           => __( 'Title', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%style%]=="rotate"',

		);


		$arguments['text_after'] = array(
			'type'        => 'text',
			'title'       => __( 'After Text', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Enter after text', 'blockstrap-page-builder-blocks' ),
			'default'     => __( ' Text', 'blockstrap-page-builder-blocks' ),
			'desc_tip'    => true,
			'group'       => __( 'Title', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['html_tag'] = array(
			'type'     => 'select',
			'title'    => __( 'HTML tag', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'h1'   => 'h1',
				'h2'   => 'h2',
				'h3'   => 'h3',
				'h4'   => 'h4',
				'h5'   => 'h5',
				'h6'   => 'h6',
				'span' => 'span',
				'div'  => 'div',
				'p'    => 'p',
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Title', 'blockstrap-page-builder-blocks' ),
		);


		// text color
		$arguments = $arguments + sd_get_text_color_input_group();

		// font size
		$arguments = $arguments + sd_get_font_size_input_group();

		// line height
		$arguments['font_line_height'] = sd_get_font_line_height_input();

		// font size
		$arguments['font_weight'] = sd_get_font_weight_input();

		// font case
		$arguments['font_case'] = sd_get_font_case_input();

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


		// highlight typography
		// text color
		$arguments = $arguments + sd_get_text_color_input_group(
				'highlight_text_color',
				array( 'group' => __( 'Highlight Typography', 'blockstrap-page-builder-blocks' ) ),
				array( 'group' => __( 'Highlight Typography', 'blockstrap-page-builder-blocks' ) )
			);

		// font size
		$arguments['highlight_font_weight'] = sd_get_font_weight_input( 'highlight_font_weight', [ 'group' => __( 'Highlight Typography', 'blockstrap-page-builder-blocks' ) ] );

		// font case
		$arguments['highlight_font_case'] = sd_get_font_case_input( 'highlight_font_case', [ 'group' => __( 'Highlight Typography', 'blockstrap-page-builder-blocks' ) ] );

		$arguments['highlight_shape_color'] = sd_get_custom_color_input( 'color_custom', array(
			'title'           => __( 'Shape Color', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Highlight Typography', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%style%]=="highlight"',
		) );


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

		// block visibility conditions
		$arguments['visibility_conditions'] = sd_get_visibility_conditions_input();

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

		// content should always be empty here
		$title = '';

		if ( ! empty( $args['text'] ) || ! empty( $args['text_rotating'] ) || ! empty( $args['text_after'] ) ) {
			$attributes = array();
			if ( $args['style'] === 'rotate' ) {
				$attributes['data-animation-type']  = ! empty( $args['animation'] ) ? esc_attr( $args['animation'] ) : 'slide';
				$attributes['data-animation-delay'] = ! empty( $args['rotate_duration'] ) ? absint( $args['rotate_duration'] ) : '2500';
				$attributes['class']                = 'bs-headline-text-rotating bs-words-wrapper';
			} else {
				$attributes['class'] = 'highlight-headline bs-words-wrapper';

			}

			$attributes['id']    = ! empty( $args['styleid'] ) ? esc_attr( $args['styleid'] ) : 'bs-headline-text-rotating';
			$attributes['class'] .= ' ' . sd_build_aui_class( [
					'text_color'  => $args['highlight_text_color'],
					'font_case'   => $args['highlight_font_case'],
					'font_weight' => $args['highlight_font_weight'],
				] );
			$attributes['style'] = sd_build_aui_styles( [
				'text_color_custom' => $args['highlight_text_color_custom'],
			] );
			$custom_attr_string  = implode( ',', array_map(
				function ( $key, $value ) {
					return esc_attr( $key ) . '|' . esc_attr( $value );
				},
				array_keys( $attributes ),
				$attributes
			) );
			$attributes_escaped  = sd_build_attributes_string_escaped( array( 'custom' => $custom_attr_string ) );

			if ( $args['style'] === 'rotate' ) {
				$title = sprintf(
					'<span class="bs-headline-text-rotating-wrapper">%1$s %2$s %3$s</span>',
					$args['text'] ? '<span class="bs-headline-text-before">' . wp_kses_post( $args['text'] ) . '</span>' : '',
					$args['text_rotating'] ? sprintf(
						'<span %1$s>%2$s</span>',
						$attributes_escaped,
						$this->create_rotating_text_elements( $args['text_rotating'] )
					) : '',
					$args['text_after'] ? '<span class="bs-headline-text-after">' . wp_kses_post( $args['text_after'] ) . '</span>' : ''
				);
			} else {

				$shape       = ! empty( $args['shape'] ) ? esc_attr( $args['shape'] ) : 'curly';
				$shape_color = ! empty( $args['highlight_shape_color'] ) ? esc_attr( $args['highlight_shape_color'] ) : '#ff5733';
				$duration    = ! empty( $args['highlight_duration'] ) ? absint( $args['highlight_duration'] ) : '1200';
				$delay       = ! empty( $args['delay'] ) ? absint( $args['delay'] ) : '8000';
				$loop        = ! empty( $args['loop'] ) ? 'yes' : '';

				$title = sprintf(
					'<span class="bs-highlight-headline-widget" %1$s>%2$s %3$s %4$s</span>',
					'data-settings=\'{
				"marker": "' . esc_attr( $shape ) . '",
      "loop": "' . esc_attr( $loop ) . '",
      "highlight_animation_duration": ' . absint( $duration ) . ',
      "highlight_iteration_delay": ' . absint( $delay ) . ',
      "highlight_shape_color": "' . esc_attr( $shape_color ) . '"
    }\'',
					$args['text'] ? '<span class="bs-headline-text-before">' . wp_kses_post( $args['text'] ) . '</span>' : '',
					$args['text_highlight'] ? sprintf(
						'<span %1$s>%2$s</span>',
						$attributes_escaped,
						'<span class="highlight-headline-dynamic-wrapper">' . wp_kses_post( $args['text_highlight'] ) . '</span>'
					) : '',
					$args['text_after'] ? '<span class="bs-headline-text-after">' . wp_kses_post( $args['text_after'] ) . '</span>' : ''
				);
			}


			// maybe replace GD %%variables%%
			if ( defined( 'GEODIRECTORY_VERSION' ) ) {
				$title = GeoDir_SEO::replace_variables( $title );
			}

			$tag          = ! empty( $args['html_tag'] ) ? esc_attr( $args['html_tag'] ) : 'h1';
			$allowed_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'div', 'p' );
			$tag          = in_array( $tag, $allowed_tags, true ) ? esc_attr( $tag ) : 'h1';


			// Unset custom color when color class already set.
			if ( ! empty( $args['text_color'] ) && $args['text_color'] != 'custom' ) {
				$args['text_color_custom'] = '';
			}

			// Unset custom font size when color class already set.
			if ( ! empty( $args['font_size'] ) && $args['font_size'] != 'custom' ) {
				$args['font_size_custom'] = '';
			}


			$classes = sd_build_aui_class( $args );
			$class   = $classes ? 'class="' . $classes . '"' : '';
			$styles  = sd_build_aui_styles( $args );
			$style   = $styles ? ' style="' . $styles . '"' : '';

			$wrapper_attributes = $class . $style;

			// maybe enqueue scripts
			if ( $title ) {

				if ( $args['style'] === 'rotate' ) {
					add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
				} else {
					add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_highlight' ) );
				}

			}


			return $title ? sprintf(
				'<%1$s %2$s>%3$s</%1$s>',
				$tag,
				$wrapper_attributes,
				$title
			) : '';

		}

		return '';


	}

	public function enqueue_scripts_highlight() {
		wp_enqueue_script(
			'blockstrap-blocks-highlight-headline',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/js/highlight-headline.min.js',
			null,
			BLOCKSTRAP_BLOCKS_VERSION,
			[ 'in_footer' => true ]
		);

		wp_enqueue_style(
			'blockstrap-blocks-animated-headline',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/css/animated-headline.css',
			null,
			BLOCKSTRAP_BLOCKS_VERSION
		);
	}


	/**
	 * Enqueues the necessary scripts for the widget, shortcode, and block (front end).
	 *
	 * @return void
	 * @global $blockstrap_headline_js
	 *
	 */
	public function enqueue_scripts() {

		wp_enqueue_script(
			'blockstrap-blocks-animated-headline',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/js/animated-headline.min.js',
			null,
			BLOCKSTRAP_BLOCKS_VERSION,
			[ 'in_footer' => true ]
		);

		wp_enqueue_style(
			'blockstrap-blocks-animated-headline',
			BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/css/animated-headline.css',
			null,
			BLOCKSTRAP_BLOCKS_VERSION
		);

	}

	public function create_rotating_text_elements( $text ) {
		if ( empty( $text ) ) {
			return '';
		}

		$lines = array_filter( array_map( 'trim', explode( "\n", $text ) ) );

		if ( empty( $lines ) ) {
			return '';
		}

		$output = '';

		foreach ( $lines as $index => $line ) {
			$class = 'bs-headline-rotating-text';

			if ( $index === 0 ) {
				$class .= ' is-visible';
			} else {
				$class .= ' is-hidden';
				//$class .= $this->is_preview() ? ' d-none ' : '';
			}

			$output .= sprintf(
				'<b class="%s">%s</b>',
				esc_attr( $class ),
				esc_html( $line )
			);
		}

		return $output;
	}


	public function block_global_js() {


		ob_start();
	if ( false ) {
		?>
		<script>
			<?php
			}
			?>
			// init headlines inside site editor iframe
			function bs_fse_run_highlight_headline_from_iframe() {
				const iframeEl = document.querySelector(".edit-site-visual-editor__editor-canvas");
				if (!iframeEl?.contentWindow) return;

				const iframeDoc = iframeEl.contentWindow.document;
				const widgets = iframeDoc.querySelectorAll('.bs-highlight-headline-widget');

				// Just pass all widgets — let the main function handle .data() checking
				if (widgets.length) {
					window.bs_init_highlight_headline(Array.from(widgets));
				}
			}

			// init headlines inside site editor iframe
			function bs_fse_run_animated_headline_from_iframe() {
				const iframe = document.querySelector('.edit-site-visual-editor__editor-canvas');
				if (!iframe?.contentWindow || !iframe.contentWindow.document) return;

				const iframeDoc = iframe.contentWindow.document;

				const elements = Array.from(
					iframeDoc.querySelectorAll('.bs-headline-text-rotating.bs-words-wrapper')
				);

				if (elements.length && typeof window.bs_init_animated_headline === 'function') {
					window.bs_init_animated_headline(elements);
				}
			}

			let BSdebounceTimer;

			wp.data.subscribe(() => {
				// Clear the previous debounce timer.
				clearTimeout(BSdebounceTimer);

				// Set a new timer that will run after 800 ms of inactivity.
				BSdebounceTimer = setTimeout(() => {
					console.log('BS Headline animation initialized');

					// Site editor calls
					if (typeof bs_fse_run_highlight_headline_from_iframe === 'function') {
						bs_fse_run_highlight_headline_from_iframe();
						bs_fse_run_animated_headline_from_iframe();
					}

					// Page/post editor calls
					if (typeof bs_init_highlight_headline === 'function') {
						bs_init_highlight_headline();
					}
					if (typeof bs_init_animated_headline === 'function') {
						bs_init_animated_headline();
					}
				}, 800);
			});
			<?php
			if ( false ) {
			?>
		</script>
		<?php
	}


		return ob_get_clean();
	}


}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Headline' );
	}
);

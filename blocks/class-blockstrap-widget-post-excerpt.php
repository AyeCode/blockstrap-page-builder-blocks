<?php

class BlockStrap_Widget_Post_Excerpt extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'         => 'blockstrap',
			'output_types'       => array( 'block', 'shortcode' ),
			'block-icon'         => 'fas fa-heading',
			'block-category'     => 'layout',
			'block-keywords'     => "['content','excerpt','post']",
			'block-supports'     => array(
				'customClassName' => false,
			),
			'block-edit-returnx' => "!props.attributes.is_link ? el(props.attributes.html_tag ? props.attributes.html_tag : 'h1', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: 'Post Title' },
									style: sd_build_aui_styles(props.attributes),
									className: sd_build_aui_class(props.attributes),
								})) :
								el(props.attributes.html_tag ? props.attributes.html_tag : 'h1', wp.blockEditor.useBlockProps({
									//dangerouslySetInnerHTML: {__html: 'Post Title' },
									style: sd_build_aui_styles(props.attributes),
									className: sd_build_aui_class(props.attributes),
								}), el('a',{dangerouslySetInnerHTML: {__html: 'Post Title' },href: '#post-link', className: 'nav-link-' + props.attributes.text_color, style: sd_build_aui_styles(props.attributes)  }) )",
			'block-wrap'         => '',
			'class_name'         => __CLASS__,
			'base_id'            => 'bs_post_excerpt',
			'name'               => __( 'BS > Post Excerpt', 'blockstrap-page-builder-blocks' ),
			'widget_ops'         => array(
				'classname'   => 'bs-post-excerpt',
				'description' => esc_html__( 'Displays the post excerpt in a more customizable way that default.', 'blockstrap-page-builder-blocks' ),
			),
			'example'            => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'            => true,
			'block_group_tabs'   => array(
				'content'  => array(
					'groups' => array( __( 'Excerpt', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['html_tag'] = array(
			'type'     => 'select',
			'title'    => __( 'HTML tag', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'span' => 'span',
				'div'  => 'div',
				'p'    => 'p',
			),
			'default'  => 'div',
			'desc_tip' => true,
			'group'    => __( 'Excerpt', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['trim_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Trim type', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'words'      => 'words',
				'characters' => 'characters',
			),
			'default'  => 'words',
			'desc_tip' => true,
			'group'    => __( 'Excerpt', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['trim_count'] = array(
			'type'        => 'number',
			'title'       => __( 'Trim count', 'blockstrap-page-builder-blocks' ),
			'placeholder' => '55',
			'default'     => '',
			'desc_tip'    => false,
			'group'       => __( 'Excerpt', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['trim_append'] = array(
			'type'        => 'text',
			'title'       => __( 'Trim append', 'blockstrap-page-builder-blocks' ),
			'placeholder' => '…',
			'default'     => '',
			'desc_tip'    => false,
			'group'       => __( 'Excerpt', 'blockstrap-page-builder-blocks' ),
		);

		// text color
		$arguments = $arguments + sd_get_text_color_input_group();

		// font size
		$arguments = $arguments + sd_get_font_size_input_group();

		// line height
		$arguments['font_line_height'] = sd_get_font_line_height_input();

		// font weight
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

		$arguments['opacity'] = sd_get_opacity_input();

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
		global $post;

		$is_preview = $this->is_block_content_call();
		if ( $is_preview ) {
			$content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel felis ante. Aliquam suscipit eleifend leo, et pretium sapien finibus eu. Integer tellus mauris, aliquet nec eros vel, consequat accumsan metus. Sed hendrerit, sapien commodo efficitur semper, neque augue fringilla nisl, vitae mollis eros massa vel odio. Nulla finibus luctus bibendum. Maecenas est nulla, maximus ac purus id, maximus dictum leo. Ut eu lobortis felis, vulputate dapibus elit. Aenean consectetur feugiat placerat. Nulla consectetur nibh in sem aliquam commodo.

Nam malesuada metus lorem, nec lobortis sem suscipit quis. Curabitur fringilla nulla diam, in suscipit ante vestibulum id. Vestibulum orci ipsum, volutpat vitae aliquam eu, iaculis non diam. Nulla ac diam laoreet, pretium mi non, porttitor velit. Donec ornare, nibh vel aliquam suscipit, enim tellus laoreet erat, et fringilla nisl nibh id est. Mauris et augue pretium tortor molestie facilisis. Phasellus velit purus, gravida ut aliquet in, ultrices non urna. Praesent tincidunt risus vel eros laoreet laoreet. Donec porttitor sed nisl ac maximus. Mauris feugiat purus nec viverra suscipit.

Donec egestas urna vel lorem bibendum fringilla. Curabitur in dui augue. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aliquam et maximus mauris. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam volutpat viverra tortor sit amet volutpat. Donec nec scelerisque nunc. Donec lobortis tempor pharetra. Nulla a pharetra felis. Nunc placerat faucibus malesuada. Ut commodo lectus a sollicitudin tincidunt. Donec ac lectus eu enim efficitur elementum sed vitae mi. Nunc ac dui lacinia, egestas felis sed, gravida neque.';

		} else {
			$content = ! empty( $post->post_content ) ? wp_strip_all_tags( $post->post_content ) : '';
		}

		if ( $content ) {
			$tag          = ! empty( $args['html_tag'] ) ? esc_attr( $args['html_tag'] ) : 'div';
			$allowed_tags = array( 'span', 'div', 'p' );
			$tag          = in_array( $tag, $allowed_tags, true ) ? esc_attr( $tag ) : 'div';
			$classes      = sd_build_aui_class( $args );
			$class        = $classes ? 'class="' . $classes . '"' : '';
			$styles       = sd_build_aui_styles( $args );
			$style        = $styles ? ' style="' . $styles . '"' : '';

			$wrapper_attributes = $class . $style;

			$strip_count  = '' === $args['trim_count'] ? 55 : absint( $args['trim_count'] );
			$strip_append = '' === $args['trim_append'] ? '…' : esc_attr( $args['trim_append'] );
			if ( 'words' === $args['trim_type'] ) {
				$content = wp_trim_words( $content, $strip_count, $strip_append );
			} else {
				$content = substr( $content, 0, $strip_count ) . $strip_append;
			}
		}

		return $content ? sprintf(
			'<%1$s %2$s>%3$s</%1$s>',
			$tag,
			$wrapper_attributes,
			$content
		) : '';

	}

}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Post_Excerpt' );
	}
);


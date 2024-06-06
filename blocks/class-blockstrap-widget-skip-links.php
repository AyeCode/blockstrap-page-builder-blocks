<?php

class BlockStrap_Widget_Skip_Links extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block', 'shortcode' ),
			'block-icon'        => 'fab fa-accessible-icon',
			'block-category'    => 'layout',
			'block-keywords'    => "['skip','nav','accessibility']",
			'block-supports'    => array(
				'customClassName' => false,
			),
			'block-edit-return' => "el('div', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									className: 'bs-skip-links position-absolute shadow',
								}))",
			'block-wrap'        => '',
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_skip_links',
			'name'              => __( 'BS > Skip Links', 'blockstrap-page-builder-blocks' ),
			'widget_ops'        => array(
				'classname'   => 'bd-skip-links',
				'description' => esc_html__( 'Skip links for accessibility users. This should be the first thing in your header and link to places such as your main content.', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => false,
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array( __( 'Link One', 'blockstrap-page-builder-blocks' ), __( 'Link Two', 'blockstrap-page-builder-blocks' ), __( 'Link Three', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['text1'] = array(
			'type'        => 'text',
			'title'       => __( 'Text', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Skip to main content', 'blockstrap-page-builder-blocks' ),
			'default'     => __( 'Skip to main content', 'blockstrap-page-builder-blocks' ),
			'desc_tip'    => true,
			'group'       => __( 'Link One', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['hash1'] = array(
			'type'        => 'text',
			'title'       => __( 'Content ID', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Enter the ID of the content.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'main', 'blockstrap-page-builder-blocks' ),
			'default'     => __( 'main', 'blockstrap-page-builder-blocks' ),
			'desc_tip'    => true,
			'group'       => __( 'Link One', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['text2'] = array(
			'type'        => 'text',
			'title'       => __( 'Text', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Skip to footer', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Link Two', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['hash2'] = array(
			'type'        => 'text',
			'title'       => __( 'Content ID', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Enter the ID of the content.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'footer', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Link Two', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['text3'] = array(
			'type'        => 'text',
			'title'       => __( 'Text', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Skip to', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Link Three', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['hash3'] = array(
			'type'        => 'text',
			'title'       => __( 'Content ID', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Enter the ID of the content.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'footer', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Link Three', 'blockstrap-page-builder-blocks' ),
		);

		// text color
		$arguments['text_color'] = sd_get_text_color_input();

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

		// link one
		$link_one   = ! empty( $args['text1'] ) ? '<a href="#' . esc_attr( $args['hash1'] ) . '" class="btn btn-primary">' . esc_attr( $args['text1'] ) . '</a>' : '';
		$link_two   = ! empty( $args['text2'] ) ? ' <a href="#' . esc_attr( $args['hash2'] ) . '" class="btn btn-primary">' . esc_attr( $args['text2'] ) . '</a>' : '';
		$link_three = ! empty( $args['text3'] ) ? ' <a href="#' . esc_attr( $args['hash3'] ) . '" class="btn btn-primary">' . esc_attr( $args['text3'] ) . '</a>' : '';

		if ( $this->is_block_content_call() ) {
			return $link_one . $link_two . $link_three;
		}

		return $link_one || $link_two || $link_three ? sprintf(
			'<div class="bs-skip-links position-absolute shadow" style="z-index: 10000">%1$s%2$s%3$s</div>',
			$link_one,
			$link_two,
			$link_three
		) : '';
	}
}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Skip_Links' );
	}
);

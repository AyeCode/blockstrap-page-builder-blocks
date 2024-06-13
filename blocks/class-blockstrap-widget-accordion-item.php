<?php

class BlockStrap_Widget_Accordion_Item extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'       => 'blockstrap',
			'output_types'     => array( 'block', 'shortcode' ),
			'nested-block'     => true,
			'block-icon'       => 'fas fa-minus',
			'block-category'   => 'layout',
			'block-keywords'   => "['accordion','item','content']",
			'block-supports'   => array(
				'anchor'          => false,
				'customClassName' => false,
			),
			'parent'		   => array('blockstrap/blockstrap-widget-accordion'),
			'block-output'     => array(
				array(
					'element'   => 'div',
					'className' => 'accordion-item',
					'if_id'     => '"heading-"+props.attributes.anchor',
					array(
						'element'   => 'h2',
						'className' => 'accordion-header',
						array(
							'element'             => 'button',
							'if_className'        => 'props.attributes.state === "closed" ? "accordion-button collapsed" : "accordion-button"',
							'type'                => 'button',
							'"data-bs-toggle"'    => 'collapse',
							'if_"data-bs-target"' => '"#collapse-"+props.attributes.anchor',
							'if_"aria-expanded"'  => 'props.attributes.state === "closed" ? "false" : "true"',
							'if_"aria-controls"'  => '"collapse-"+props.attributes.anchor',
							'if_content'          => 'props.attributes.text',
						),
					),

					array(
						'element'              => 'div',
						'if_className'         => 'props.attributes.state === "closed" ? "accordion-collapse collapse" : "accordion-collapse collapse show"',
						'if_x'                 => '( typeof parentBlocks !== "undefined" && parentBlocks.length > 0 && parentBlocks[parentBlocks.length - 1].attributes.anchor ) ? props.setAttributes({parent_anchor: parentBlocks[parentBlocks.length - 1].attributes.anchor}) : ""', // required
						'if_id'                => '"collapse-"+props.attributes.anchor',
						'if_"aria-labelledby"' => '"heading-"+props.attributes.anchor',
						'if_"data-bs-parent"'  => 'props.attributes.parent_anchor ? "#"+props.attributes.parent_anchor : ""',
						array(
							'element'          => 'innerBlocksProps',
							'blockProps'       => array(
								'if_className' => '"accordion-body "  [%WrapClass%]',
								'style'        => '{[%WrapStyle%]}',
							),
							'innerBlocksProps' => array(
								'orientation' => 'vertical',
							),

						),
					),

				),
			),
			'block-wrap'       => '',
			'class_name'       => __CLASS__,
			'base_id'          => 'bs_accordion_item',
			'name'             => __( 'BS > Accordion Item', 'blockstrap-page-builder-blocks' ),
			'widget_ops'       => array(
				'classname'   => 'bs-accordion-item',
				'description' => esc_html__( 'A tab', 'blockstrap-page-builder-blocks' ),
			),
			'no_wrap'          => true,
			'block_group_tabs' => array(
				'content'  => array(
					'groups' => array( __( 'Item', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array( __( 'Background', 'blockstrap-page-builder-blocks' ), __( 'Typography', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['text'] = array(
			'type'        => 'text',
			'title'       => __( 'Name', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Item1', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Item', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['anchor']        = array(
			'type'    => 'text',
			'title'   => __( 'HTML anchor (required)', 'blockstrap-page-builder-blocks' ),
			'default' => '',
			'group'   => __( 'Item', 'blockstrap-page-builder-blocks' ),
		);
		$arguments['parent_anchor'] = array(
			'type'    => 'hidden',
			'default' => '',
			'group'   => __( 'Item', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['anchor_notice'] = array(
			'type'            => 'notice',
			'desc'            => __( 'A unique HTML anchor is required for each tab for tabs to function.', 'blockstrap-page-builder-blocks' ),
			'status'          => 'error', // 'warning' | 'success' | 'error' | 'info'
			'group'           => __( 'Item', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%anchor%]==""',
		);

		$arguments['state'] = array(
			'type'     => 'select',
			'title'    => __( 'Initial state', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''       => __( 'Open', 'blockstrap-page-builder-blocks' ),
				'closed' => __( 'Closed', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Item', 'blockstrap-page-builder-blocks' ),
		);

		$arguments = $arguments + sd_get_background_inputs( 'bg', array(), false, false, false );

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
		$arguments['mb_lg'] = sd_get_margin_input(
			'mb',
			array(
				'device_type' => 'Desktop',
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

		//      print_r( $args );

		//      if ( $content ) {
		//          $wrap_class = sd_build_aui_class( $args );
		//          $id         = ! empty( $args['anchor'] ) ? sanitize_html_class( $args['anchor'] ) : '';
		//          $content    = sprintf(
		//              '<div id="%1$s" class="tab-pane fade %2$s" role="tabpanel" aria-labelledby="%3$s-tab">%4$s</div>',
		//              $id,
		//              $wrap_class,
		//              $id,
		//              $content
		//          );
		//      }

		return $content;

	}


}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Accordion_Item' );
	}
);


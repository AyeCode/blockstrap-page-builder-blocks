<?php

class BlockStrap_Widget_Accordion extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$aui_settings = is_admin() ? get_option( 'ayecode-ui-settings' ) : array();
		$bs5          = ! empty( $aui_settings['bs_ver'] ) && '5' === $aui_settings['bs_ver'] ? 'bs-' : '';

		$options = array(
			'textdomain'       => 'blockstrap',
			'output_types'     => array( 'block', 'shortcode' ),
			'nested-block'     => true,
			'block-icon'       => 'fas fa-bars',
			'block-category'   => 'layout',
			'block-keywords'   => "['accordion','list','content']",
			'block-supports'   => array(
				'customClassName' => false,
			),
			'block-output'     => array(
				array(
					'element'          => 'innerBlocksProps',
					'blockProps'       => array(
						'if_className' => 'props.attributes.style == "flush" ? "accordion accordion-flush " [%WrapClass%] : "accordion " [%WrapClass%] ',
						'style'        => '{[%WrapStyle%]}',
						'if_id'        => 'props.attributes.anchor ? props.attributes.anchor : props.clientId',
					),
					'innerBlocksProps' => array(
						'orientation' => 'vertical',
					),

				),
			),
			'block-wrap'       => '',
			'class_name'       => __CLASS__,
			'base_id'          => 'bs_accordion',
			'name'             => __( 'BS > Accordion', 'blockstrap-page-builder-blocks' ),
			'widget_ops'       => array(
				'classname'   => 'bs-accordion',
				'description' => esc_html__( 'A container for an Accordion list', 'blockstrap-page-builder-blocks' ),
			),
			'no_wrap'          => true,
			'block_group_tabs' => array(
				'styles'   => array(
					'groups' => array( __( 'Accordion', 'blockstrap-page-builder-blocks' )),
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

		$arguments['style'] = array(
			'type'     => 'select',
			'title'    => __( 'Style', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''  => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'flush' => __( 'Flush', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Accordion', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['collapse'] = array(
			'type'     => 'select',
			'title'    => __( 'Tab click', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''  => __( 'Leave other items open', 'blockstrap-page-builder-blocks' ),
				'close' => __( 'Close all other items', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Accordion', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['anchor'] = array(
			'type'    => 'text',
			'title'   => __( 'HTML anchor', 'blockstrap-page-builder-blocks' ),
			'default' => '',
			'group'   => __( 'Accordion', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['anchor_notice'] = array(
			'type'            => 'notice',
			'desc'            => __( 'A unique HTML anchor is required for other items to close.', 'blockstrap-page-builder-blocks' ),
			'status'          => 'error', // 'warning' | 'success' | 'error' | 'info'
			'group'           => __( 'Accordion', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%anchor%]=="" && [%collapse%]=="close"',
		);



		// Text justify
		$arguments['text_justify'] = sd_get_text_justify_input( 'text_justify', array( 'group' => __( 'Accordion', 'blockstrap-page-builder-blocks' ) ) );

		// text align
		$arguments['text_align']    = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Mobile',
				'element_require' => '[%text_justify%]==""',
				'group'           => __( 'Accordion', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['text_align_md'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Tablet',
				'element_require' => '[%text_justify%]==""',
				'group'           => __( 'Accordion', 'blockstrap-page-builder-blocks' ),
			)
		);
		$arguments['text_align_lg'] = sd_get_text_align_input(
			'text_align',
			array(
				'device_type'     => 'Desktop',
				'element_require' => '[%text_justify%]==""',
				'group'           => __( 'Accordion', 'blockstrap-page-builder-blocks' ),
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


		$arguments['css_class'] = sd_get_class_input();

		return $arguments;
	}


	/**
	 * This is the output function for the widget, shortcode and block (front end).
	 *
	 * @param array $args The arguments values.
	 * @param array $widget_args The widget arguments when used.
	 * @param string $content The shortcode content argument.
	 *
	 * @return string
	 */
	public function output( $args = array(), $widget_args = array(), $content = '' ) {

		return $content;
		global $aui_bs5;
		if ( $content ) {
			$bs5          = $aui_bs5 ? 'bs-' : '';
			$wrap_class   = sd_build_aui_class( $args );
			$tabs_array   = $args['tabs_head_array'] ? json_decode( '[' . $args['tabs_head_array'] . ']', true ) : array();
			$tabs         = '';
			$first_tab_id = '';

			if ( ! empty( $tabs_array ) ) {
				foreach ( $tabs_array as $key => $tab ) {
					$active       = 0 === $key ? 'active' : '';
					$first_tab_id = $active ? esc_attr( $tab['id'] ) : $first_tab_id;
					$aria_active  = $active ? 'true' : 'false';
					$active      .= ' ' . sd_build_aui_class( array( 'rounded_size' => $args['tabs_rounded_size'] ) );
					$tabs        .= '<li class="nav-item"><button class="nav-link ' . $active . '" id="' . esc_attr( $tab['id'] ) . '-tab" data-' . $bs5 . 'toggle="tab" data-' . $bs5 . 'target="#' . esc_attr( $tab['id'] ) . '" type="button" role="tab" aria-controls="nav-home" aria-selected="' . $aria_active . '">' . esc_attr( $tab['name'] ) . '</button></li>';
				}
			}

			// set the first tab active.
			if ( $first_tab_id ) {
				$content = str_replace( 'id="' . $first_tab_id . '" class="tab-pane', 'id="' . $first_tab_id . '" class="active show tab-pane', $content );
			}

			$greedy      = ! empty( $args['tabs_greedy'] ) ? 'greedy' : '';
			$tabs_style  = ! empty( $args['tabs_style'] ) ? sanitize_html_class( $args['tabs_style'] ) : 'nav-tabs';
			$tabs_style .= ! empty( $args['tabs_style'] ) && 'nav-pills' === $args['tabs_style'] ? ' border-0' : '';
			$tabs_style .= ! empty( $args['tab_size'] ) ? ' ' . sanitize_html_class( $args['tab_size'] ) : '';
			$tabs_style .= ! empty( $args['tabs_head_mb'] ) ? ' mb-' . sanitize_html_class( $args['tabs_head_mb'] ) : '';
			$tabs_style .= ' ' . sd_build_aui_class(
				array(
					'flex_justify_content'    => $args['tabs_flex_justify_content'],
					'flex_justify_content_md' => $args['tabs_flex_justify_content_md'],
					'flex_justify_content_lg' => $args['tabs_flex_justify_content_lg'],
				)
			);


			return sprintf(
				'<div class="%1$s accordion">%2$s</div>',
				$wrap_class,
				$content
			);
		}

		return '';

	}
}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Accordion' );
	}
);


<?php

class BlockStrap_Widget_Alert extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block', 'shortcode' ),
			'block-icon'        => 'fas fa-exclamation-triangle',
			'block-category'    => 'layout',
			'block-keywords'    => "['alert','notice','message']",
			'block-supports'    => array(
				'customClassName' => false,
			),

			'block-edit-return' => "wp.element.createElement(
			    'div',
			    wp.blockEditor.useBlockProps({
			        className: 'd-flex align-items-center fade show alert alert-' + props.attributes.alert_type + ' ' + sd_build_aui_class(props.attributes),
			        style: sd_build_aui_styles(props.attributes),
			        role: 'alert'
			    }),
			    props.attributes.icon_position === 'start'
			        ? el('span', { className: bs_build_alert_icon_class(props.attributes)  })
			        : null,
			    el(wp.blockEditor.RichText, {
			        tagName: 'span',
			        value: props.attributes.text,
			        onChange: function (text) {
			            props.setAttributes({ text: text });
			        },
			        className: 'flex-grow-1',
			        placeholder: __('Heading...'),
			    }),
			    props.attributes.icon_position === 'end'
			        ? el('span', { className: bs_build_alert_icon_class(props.attributes) })
			        : null,
			    props.attributes.dismissible
			        ? el('button', {
						    type: 'button',
						    className: 'btn-close',
						    'aria-label': 'Close'
						})
			        : null
			)
			",
			'block-save-return' => "wp.element.createElement(
			    'div',
			    wp.blockEditor.useBlockProps.save({
			        className: 'd-flex align-items-center fade show alert alert-' + props.attributes.alert_type + ' ' + sd_build_aui_class(props.attributes),
			        style: sd_build_aui_styles(props.attributes),
			        role: 'alert'
			    }),
			    props.attributes.icon_position === 'start'
			        ? el('span', { className: bs_build_alert_icon_class(props.attributes) })
			        : null,
			    el(wp.blockEditor.RichText.Content, {
			        tagName: 'span',
			        value: props.attributes.text,
			        className: 'flex-grow-1',
			    }),
			    props.attributes.icon_position === 'end'
			        ? el('span', { className: bs_build_alert_icon_class(props.attributes) })
			        : null,
			    props.attributes.dismissible
			        ? el('button', {
						    type: 'button',
						    className: 'btn-close',
						    'data-bs-dismiss': 'alert',
						    'aria-label': 'Close'
						})
			        : null
			)
			",
			'block-wrap'        => '',
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_alert',
			'name'              => __( 'BS > Alert', 'blockstrap-page-builder-blocks' ),
			'widget_ops'        => array(
				'classname'   => 'bs-heading',
				'description' => esc_html__( 'An alert message box element', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array( __( 'Text', 'blockstrap-page-builder-blocks' ),__( 'Icon', 'blockstrap-page-builder-blocks' )  ),
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

		$arguments['text'] = array(
			'type'        => 'textarea',
			'title'       => __( 'Text', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Enter you text!', 'blockstrap-page-builder-blocks' ),
			'default'     => __( 'This is some information you should read', 'blockstrap-page-builder-blocks' ),
			'desc_tip'    => true,
			'desc'		=> __( 'Add class `alert-link` to links to make them stand out more', 'blockstrap-page-builder-blocks' ),
			'group'       => __( 'Text', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['alert_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Alert type', 'blockstrap-page-builder-blocks' ),
			'options'  => sd_aui_colors(),
			'default'  => 'info',
			'desc_tip' => true,
			'group'    => __( 'Text', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['dismissible'] = array(
			'type'     => 'checkbox',
			'title'    => __( 'Dismissible', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'value'    => '1',
			'desc_tip' => false,
			'desc'     => __( 'Hides the alert from the page until it’s refreshed (frontend only).', 'blockstrap-page-builder-blocks' ),
			'group'    => __( 'Text', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['icon_class'] = array(
			'type'        => 'text',
			'title'       => __( 'Icon class', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'fas fa-info-circle', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Icon', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['icon_position'] = array(
			'type'     => 'select',
			'title'    => __( 'Icon position', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'start' => __( 'Start', 'blockstrap-page-builder-blocks' ),
				'end' => __( 'End', 'blockstrap-page-builder-blocks' ),
				'none' => __( 'Remove', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => 'start',
			'desc_tip' => true,
			'group'    => __( 'Icon', 'blockstrap-page-builder-blocks' ),
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

		return $content;

	}

	public function block_global_js() {
		ob_start();
	if ( false ) {
		?>
		<script>
			<?php
			}
			?>

            function bs_build_alert_icon_class($args) {

                let $class = '';

	            if($args.icon_class){
                    $class +=  $args.icon_class;
	            }else if($args.alert_type === 'info'){
                    $class += 'fas fa-info-circle';
                }else if($args.alert_type === 'warning' || $args.alert_type === 'danger'){
                    $class += 'fas fa-exclamation-triangle';
                }else if($args.alert_type === 'success' ){
                    $class += 'fas fa-check-circle';
                }

                if ($class) {
                    $class += $args.icon_position === 'start' ? ' me-2' : ' ms-auto' ;

                }

                return $class;
            }
		<?php
		return ob_get_clean();
	}

}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Alert' );
	}
);


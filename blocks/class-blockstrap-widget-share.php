<?php

class BlockStrap_Widget_Share extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'       => 'blockstrap',
			'output_types'     => array( 'block', 'shortcode' ),
			'block-icon'       => 'fas fa-share-alt',
			'block-category'   => 'layout',
			'block-keywords'   => "['button','share','social']",
			'block-wrap'       => '',
			'block-supports'   => array(
				'customClassName' => false,
			),
			'class_name'       => __CLASS__,
			'base_id'          => 'bs_share',
			'name'             => __( 'BS > Share', 'blockstrap-page-builder-blocks' ),
			'widget_ops'       => array(
				'classname'   => 'bs-button',
				'description' => esc_html__( 'Add social share buttons or links.', 'blockstrap-page-builder-blocks' ),
			),
			'example'          => array(
				'attributes' => array(
					'output_type' => 'icons',
					'service_email' => 1,
					'service_link' => 1,
				),
				'viewportWidth' => 250
			),
			'no_wrap'          => true,
			'block_group_tabs' => array(
				'content'  => array(
					'groups' => array( __( 'Link', 'blockstrap-page-builder-blocks' ), __( 'Services', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['output_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Output Type', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''      => __( 'Dropdown', 'blockstrap-page-builder-blocks' ),
				'icons' => __( 'Icons', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Link', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['text'] = array(
			'type'            => 'text',
			'title'           => __( 'Link Text', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Add custom link text or leave blank for dynamic', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Home', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
//			'element_require' => '[%output_type%]==""',
		);

		$arguments['icon_class'] = array(
			'type'            => 'text',
			'title'           => __( 'Icon class', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'fas fa-ship', 'blockstrap-page-builder-blocks' ),
			'default'         => 'fas fa-share-alt',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
//			'element_require' => '[%output_type%]==""',
		);

		$arguments['icon_position'] = array(
			'type'            => 'select',
			'title'           => __( 'Icon position', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				'left'  => __( 'Left', 'blockstrap-page-builder-blocks' ),
				'right' => __( 'right', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
//			'element_require' => '[%icon_class%]!="" && [%output_type%]==""',
		);

		// Services
		$arguments['service_facebook'] = array(
			'type'     => 'select',
			'title'    => __( 'Facebook', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'0' => __( 'Disabled', 'blockstrap-page-builder-blocks' ),
				'1' => __( 'Enabled', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '1',
			'desc_tip' => true,
			'group'    => __( 'Services', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['service_twitter'] = array(
			'type'     => 'select',
			'title'    => __( 'Twitter', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'0' => __( 'Disabled', 'blockstrap-page-builder-blocks' ),
				'1' => __( 'Enabled', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '1',
			'desc_tip' => true,
			'group'    => __( 'Services', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['twitter_handel'] = array(
			'type'            => 'text',
			'title'           => __( 'Twitter handel', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Add your twitter handel to add `via @handel`', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'handel', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Services', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%service_twitter%]=="1"',
		);

		$arguments['share_text'] = array(
			'type'            => 'text',
			'title'           => __( 'Share Text', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'This will prefix the URL', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Check this out!', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Services', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%service_twitter%]=="1"',
		);

		$arguments['service_linkedin'] = array(
			'type'     => 'select',
			'title'    => __( 'Linkedin', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'0' => __( 'Disabled', 'blockstrap-page-builder-blocks' ),
				'1' => __( 'Enabled', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '1',
			'desc_tip' => true,
			'group'    => __( 'Services', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['service_email'] = array(
			'type'     => 'select',
			'title'    => __( 'Email', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'0' => __( 'Disabled', 'blockstrap-page-builder-blocks' ),
				'1' => __( 'Enabled', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Services', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['email_subject'] = array(
			'type'            => 'text',
			'title'           => __( 'Email Subject', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Check this out! - %%site_url%%', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Use %%page_url%% or %%site_url%% template replacements.', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Services', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%service_email%]=="1"',
		);

		$arguments['email_body'] = array(
			'type'            => 'textarea',
			'title'           => __( 'Email Body', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Check this out! %%page_url%%', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Use %%page_url%% or %%site_url%% template replacements.', 'blockstrap-page-builder-blocks' ),

			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Services', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%service_email%]=="1"',
		);

		$arguments['service_link'] = array(
			'type'     => 'select',
			'title'    => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'0' => __( 'Disabled', 'blockstrap-page-builder-blocks' ),
				'1' => __( 'Enabled', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Services', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['service_print'] = array(
			'type'     => 'select',
			'title'    => __( 'Print', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'0' => __( 'Disabled', 'blockstrap-page-builder-blocks' ),
				'1' => __( 'Enabled', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Services', 'blockstrap-page-builder-blocks' ),
		);

		// button styles
		$arguments['link_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Link style', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''             => __( 'None', 'blockstrap-page-builder-blocks' ),
				'btn'          => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'btn-round'    => __( 'Button rounded', 'blockstrap-page-builder-blocks' ),
				'iconbox'      => __( 'Iconbox bordered', 'blockstrap-page-builder-blocks' ),
				'iconbox-fill' => __( 'Iconbox filled', 'blockstrap-page-builder-blocks' ),
				'badge'        => __( 'Badge', 'blockstrap-page-builder-blocks' ),
				'badge-pill'   => __( 'Pill Badge', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Button', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['link_size'] = array(
			'type'            => 'select',
			'title'           => __( 'Size', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				''       => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'small'  => __( 'Small', 'blockstrap-page-builder-blocks' ),
				'medium' => __( 'Medium', 'blockstrap-page-builder-blocks' ),
				'large'  => __( 'Large', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%link_type%]!="badge" && [%link_type%]!="badge-pill" && [%link_type%]!=""',
		);

		$arguments['badge_size_notice'] = array(
			'type'            => 'notice',
			'desc'            => __( 'Badge size is inherited from the parent text size', 'blockstrap-page-builder-blocks' ),
			'status'          => 'info',
			'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
			'element_require' => '([%link_type%]=="badge" || [%link_type%]=="badge-pill")',
		);

		//      $arguments['link_bg'] = array(
		//          'title'           => __( 'Color', 'blockstrap-page-builder-blocks' ),
		//          'type'            => 'select',
		//          'options'         => array(
		//              '' => __( 'Default (primary)', 'blockstrap-page-builder-blocks' ),
		//          ) + sd_aui_colors( true, true, true ),
		//          'default'         => 'primary',
		//          'desc_tip'        => true,
		//          'advanced'        => false,
		//          'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
		//          'element_require' => '[%link_type%]!="iconbox"',
		//          'tab'             => array(
		//              'title'     => __( 'Normal', 'blockstrap-page-builder-blocks' ),
		//              'key'       => 'button_normal',
		//              'tabs_open' => true,
		//              'open'      => true,
		//              'class'     => 'text-center w-50 d-flex justify-content-center',
		//          ),
		//      );

		$arguments = $arguments + sd_get_background_inputs(
			'link_bg',
			array(
				'title'           => __( 'Color', 'blockstrap-page-builder-blocks' ),
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%link_type%]!="iconbox"',
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
				'element_require' => '[%link_type%]!="iconbox" && [%link_bg%]=="custom-color"',
			),
			array(
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%link_type%]!="iconbox" && [%link_bg%]=="custom-gradient"',
			),
			false
		);

		$arguments = $arguments + sd_get_text_color_input_group(
			'text_color',
			array(
				'group' => __( 'Button', 'blockstrap-page-builder-blocks' ),
			),
			array(
				'group' => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'tab'   => array(
					'close' => true,
				),
			)
		);

		//      $arguments['bg_hover'] = array(
		//          'title'           => __( 'Color', 'blockstrap-page-builder-blocks' ),
		//          'type'            => 'select',
		//          'options'         => array(
		//              '' => __( 'Default (primary)', 'blockstrap-page-builder-blocks' ),
		//          ) + sd_aui_colors( true, false, false ),
		//          'default'         => '',
		//          'desc_tip'        => true,
		//          'advanced'        => false,
		//          'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
		//          'element_require' => '[%link_type%]!="iconbox"',
		//          'tab'             => array(
		//              'title' => __( 'Hover', 'blockstrap-page-builder-blocks' ),
		//              'key'   => 'button_hover',
		//              'open'  => true,
		//              'class' => 'text-center w-50 d-flex justify-content-center',
		//          ),
		//      );

		$arguments = $arguments + sd_get_background_inputs(
			'bg_hover',
			array(
				'title'           => __( 'Color', 'blockstrap-page-builder-blocks' ),
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%link_type%]!="iconbox"',
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
				'element_require' => '[%link_type%]!="iconbox" && [%bg_hover%]=="custom-color"',
			),
			array(
				'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'element_require' => '[%link_type%]!="iconbox" && [%bg_hover%]=="custom-gradient"',
			),
			false
		);

		// text color
		$arguments = $arguments + sd_get_text_color_input_group(
			'text_color_hover',
			array(
				'group' => __( 'Button', 'blockstrap-page-builder-blocks' ),
			),
			array(
				'group' => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'tab'   => array(
					'close'      => true,
					'tabs_close' => true,
				),
			)
		);

		// Typography
		// font size
		$arguments = $arguments + sd_get_font_size_input_group();

		// font weight.
		$arguments['font_weight'] = sd_get_font_weight_input();

		// font case
		$arguments['font_case'] = sd_get_font_case_input();

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

		$tag         = 'a';
		$link        = '#';
		$link_text   = '';
		$output_type = esc_attr( $args['output_type'] );

		// maybe set custom link text
		$link_text = ! empty( $args['text'] ) ? esc_attr( $args['text'] ) : $link_text;

		// link type
		$link_class = 'nav-link';

		if ( ! empty( $args['link_type'] ) && ! $output_type ) {

			if ( 'btn' === $args['link_type'] ) {
				$link_class = 'btn';
			} elseif ( 'btn-round' === $args['link_type'] ) {
				$link_class = 'btn btn-round';
			} elseif ( 'iconbox' === $args['link_type'] ) {
				$link_class = 'iconbox rounded-circle';
			} elseif ( 'iconbox-fill' === $args['link_type'] ) {
				$link_class = 'iconbox fill rounded-circle btn p-0';
			} elseif ( 'badge' === $args['link_type'] ) {
				$link_class = 'badge';
			} elseif ( 'badge-pill' === $args['link_type'] ) {
				$link_class = $aui_bs5 ? 'badge rounded-pill' : 'badge badge-pill';
			}

			// colour prefix

			if ( 'custom-color' === $args['link_bg'] ) {
				$args['bg']       = $args['link_bg'];
				$args['bg_color'] = $args['link_bg_color'];
				//$args['link_bg']   = '';
			} elseif ( 'custom-gradient' === $args['link_bg'] ) {
				$args['bg']          = $args['link_bg'];
				$args['bg_gradient'] = $args['link_bg_gradient'];
				//$args['link_bg']     = '';
			}

			if ( 'btn' === $args['link_type'] || 'btn-round' === $args['link_type'] ) {
				$link_class .= $args['link_bg'] ? ' btn-' . sanitize_html_class( $args['link_bg'] ) : '';
				if ( 'small' === $args['link_size'] ) {
					$link_class .= ' btn-sm';
				} elseif ( 'large' === $args['link_size'] ) {
					$link_class .= ' btn-lg';
				}
			} elseif ( 'badge' === $args['link_type'] || 'badge-pill' === $args['link_type'] ) {
					$link_class .= $args['link_bg'] ? ' text-bg-' . sanitize_html_class( $args['link_bg'] ) : '';
			} else {
				$link_class .= 'iconbox-fill' === $args['link_type'] && $args['link_bg'] ? ' btn-' . sanitize_html_class( $args['link_bg'] ) : '';
				if ( empty( $args['link_size'] ) || 'small' === $args['link_size'] ) {
					$link_class .= ' iconsmall';
				} elseif ( 'medium' === $args['link_size'] ) {
					$link_class .= ' iconmedium';
				} elseif ( 'large' === $args['link_size'] ) {
					$link_class .= ' iconlarge';
				}
			}
		}

		$output = '';

		global $wp;
		$current_url = $this->get_current_page_url();

		if ( 'icons' === $output_type ) {
			$tag         = 'span';
			$output .= '<div class="d-flex">';
			if ( ! empty( $args['service_facebook'] ) ) {
				$link    = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode_deep( $current_url );
				$output .= '<a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm ms-2" href="' . esc_url( $link ) . '" data-bs-toggle="tooltip" title="' . esc_attr__( 'Share to Facebook', 'blockstrap-page-builder-blocks' ) . '" target="_blank" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"><i class="fab fa-facebook-f"></i></a>';
			}

			if ( ! empty( $args['service_twitter'] ) ) {
				// what icon shoudl we use
				$twitter_icon_class = 'fab fa-twitter';
				if(class_exists('WP_Font_Awesome_Settings')) {
					$FAS = WP_Font_Awesome_Settings::instance();
					$fas_settings = $FAS->get_settings();
					$version = $fas_settings['version'] ?? '';

					if( !$version || version_compare($version,'5.999','>')){
						$twitter_icon_class = 'fab fa-x-twitter';
					}
				}

				$handel     = ! empty( $args['twitter_handel'] ) ? '&via=' . esc_attr( $args['twitter_handel'] ) : '';
				$share_text = ! empty( $args['share_text'] ) ? '&text=' . esc_attr( $args['share_text'] ) : '';
				$link       = 'https://twitter.com/share?url=' . urlencode_deep( $current_url ) . $handel . $share_text;
				$output    .= '<a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm ms-2" href="' . esc_url( $link ) . '" data-bs-toggle="tooltip" title="' . esc_attr__( 'Share to Twitter', 'blockstrap-page-builder-blocks' ) . '" target="_blank" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=600\');return false;"><i class="' . esc_attr( $twitter_icon_class ) . '"></i></a>';
			}

			if ( ! empty( $args['service_linkedin'] ) ) {
				$link    = 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode_deep( $current_url );
				$output .= '<a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm ms-2" href="' . esc_url( $link ) . '" data-bs-toggle="tooltip" title="' . esc_attr__( 'Share to Linkedin', 'blockstrap-page-builder-blocks' ) . '" target="_blank" ><i class="fab fa-linkedin-in"></i></a>';
			}

			if ( ! empty( $args['service_email'] ) ) {
				$subject = ! empty( $args['email_subject'] ) ? esc_attr( $args['email_subject'] ) : esc_attr__( 'Check this out! - %%site_url%%', 'blockstrap-page-builder-blocks' );
				$subject = str_replace( array( '%%page_url%%', '%%site_url%%' ), array( $current_url, get_site_url() ), $subject );

				$body    = ! empty( $args['email_body'] ) ? esc_attr( $args['email_body'] ) : esc_attr__( 'I thought you might be interested in this: %%page_url%%', 'blockstrap-page-builder-blocks' );
				$body    = str_replace( array( '%%page_url%%', '%%site_url%%' ), array( $current_url, get_site_url() ), $body );
				$output .= '<a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm ms-2" href="mailto:?subject=' . urlencode_deep( $subject ) . '&body=' . urlencode_deep( $body ) . '" data-bs-toggle="tooltip" title="' . esc_attr__( 'Share via Email', 'blockstrap-page-builder-blocks' ) . '" target="_blank" ><i class="far fa-envelope"></i></a>';
			}

			if ( ! empty( $args['service_link'] ) ) {
				$output .= '<a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm ms-2" href="' . esc_url( $current_url ) . '" onclick="navigator.clipboard.writeText(\'' . esc_url( $current_url ) . '\');aui_toast(\'bs-blocks-copy-url\',\'success\',\'' . esc_attr__( 'URL Copied to Clipboard', 'blockstrap-page-builder-blocks' ) . '\');return false;" data-bs-toggle="tooltip" title="' . esc_attr__( 'Copy URL', 'blockstrap-page-builder-blocks' ) . '"><i class="fas fa-link"></i></a>';
			}

			if ( ! empty( $args['service_print'] ) ) {
				$output .= '<a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm ms-2" href="' . esc_url( $current_url ) . '" onclick="window.print();return false;" data-bs-toggle="tooltip" title="' . esc_attr__( 'Print page', 'blockstrap-page-builder-blocks' ) . '"><i class="fas fa-print"></i></a>';
			}

			$output .= '</div>';
		} else {

			$output .= '<div class="dropdown-menu dropdown-menu-end dropdown-caret-0 mt-2 text-muted ">';
			if ( ! empty( $args['service_facebook'] ) ) {
				$link    = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode_deep( $current_url );
				$output .= '<a href="' . esc_url( $link ) . '" class="dropdown-item" target="_blank" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"><i class="fab fa-facebook-f fa-fw opacity-75 fa-lg"></i> ' . __( 'Facebook', 'blockstrap-page-builder-blocks' ) . '</a>';
			}

			if ( ! empty( $args['service_twitter'] ) ) {
				$handel     = ! empty( $args['twitter_handel'] ) ? '&via=' . esc_attr( $args['twitter_handel'] ) : '';
				$share_text = ! empty( $args['share_text'] ) ? '&text=' . esc_attr( $args['share_text'] ) : '';
				$link       = 'https://twitter.com/share?url=' . urlencode_deep( $current_url ) . $handel . $share_text;
				$output    .= '<a href="' . esc_url( $link ) . '" class="dropdown-item"  target="_blank" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=600\');return false;"><i class="fab fa-twitter fa-fw opacity-75 fa-lg"></i> ' . __( 'Twitter', 'blockstrap-page-builder-blocks' ) . '</a>';
			}

			if ( ! empty( $args['service_linkedin'] ) ) {
				$link    = 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode_deep( $current_url );
				$output .= '<a href="' . esc_url( $link ) . '" class="dropdown-item"  target="_blank"><i class="fab fa-linkedin-in fa-fw opacity-75 fa-lg"></i> ' . __( 'Linkedin', 'blockstrap-page-builder-blocks' ) . '</a>';
			}

			if ( ! empty( $args['service_email'] ) ) {
				$subject = ! empty( $args['email_subject'] ) ? esc_attr( $args['email_subject'] ) : esc_attr__( 'Check this out! - %%site_url%%', 'blockstrap-page-builder-blocks' );
				$subject = str_replace( array( '%%page_url%%', '%%site_url%%' ), array( $current_url, get_site_url() ), $subject );

				$body    = ! empty( $args['email_body'] ) ? esc_attr( $args['email_body'] ) : esc_attr__( 'I thought you might be interested in this: %%page_url%%', 'blockstrap-page-builder-blocks' );
				$body    = str_replace( array( '%%page_url%%', '%%site_url%%' ), array( $current_url, get_site_url() ), $body );
				$output .= '<a href="mailto:?subject=' . urlencode_deep( $subject ) . '&body=' . urlencode_deep( $body ) . '" class="dropdown-item"><i class="far fa-envelope fa-fw opacity-75 fa-lg"></i> ' . __( 'Email', 'blockstrap-page-builder-blocks' ) . '</a>';
			}

			if ( ! empty( $args['service_link'] ) ) {
				$output .= '<a href="' . esc_url( $current_url ) . '" onclick="navigator.clipboard.writeText(\'' . esc_url( $current_url ) . '\');aui_toast(\'bs-blocks-copy-url\',\'success\',\'' . esc_attr__( 'URL Copied to Clipboard', 'blockstrap-page-builder-blocks' ) . '\');return false;" class="dropdown-item"><i class="fas fa-link fa-fw opacity-75 fa-lg"></i> ' . __( 'Copy Link', 'blockstrap-page-builder-blocks' ) . '</a>';
			}

			if ( ! empty( $args['service_print'] ) ) {
				$output .= '<a href="' . esc_url( $current_url ) . '" onclick="window.print();return false;" class="dropdown-item"><i class="fas fa-print fa-fw opacity-75 fa-lg"></i> ' . __( 'Print page', 'blockstrap-page-builder-blocks' ) . '</a>';
			}

			$output .= '</div>';
		}

		if ( ! empty( $args['text_color'] ) ) {
			$link_class .= ' text-' . esc_attr( $args['text_color'] );
		}

		if ( ! empty( $args['css_class'] ) ) {
			$link_class .= ' ' . sd_sanitize_html_classes( $args['css_class'] );
		}

		$icon_left  = '';
		$icon_right = '';
		if ( ! empty( $args['icon_class'] ) ) {
			// remove default text if icon exists.
			if ( empty( $args['text'] ) ) {
				$link_text = '';
			}

			if ( 'right' === $args['icon_position'] ) {
				$ml         = $aui_bs5 ? ' ms-2' : ' ml-2';
				$icon_right = ! empty( $link_text ) ? '<i class="' . esc_attr( $args['icon_class'] ) . $ml . '"></i>' : '<i class="' . esc_attr( $args['icon_class'] ) . '"></i>';
			} else {
				$mr        = $aui_bs5 ? ' me-2' : ' mr-2';
				$icon_left = ! empty( $link_text ) ? '<i class="' . esc_attr( $args['icon_class'] ) . $mr . '"></i>' : '<i class="' . esc_attr( $args['icon_class'] ) . '"></i>';
			}
		}

		$wrap_class = sd_build_aui_class( $args );

		// if a button add form-inline
		//      if ( ! empty( $args['link_type'] ) ) {
		//          $wrap_class .= ' form-inline';
		//      }

		$href = 'a' === $tag ? 'href="' . esc_url_raw( $link ) . '"' : '';

		if ( $this->is_preview() ) {
			$href = '';//'href="#"';
		}

		$styles = sd_build_aui_styles( $args );
		$style  = $styles ? 'style="' . $styles . '"' : '';

		$styles = function_exists( 'sd_build_hover_styles' ) ? sd_build_hover_styles( $args, $this->is_preview() ) : '';

		if ( 'icons' === $output_type ) {
			return $link_text || $icon_left || $icon_right ? '<div class="d-inline-flex  align-items-center"><' . esc_attr( $tag ) . ' ' . $style . ' ' . $href . ' class="' . esc_attr( $link_class ) . ' ' . esc_attr( $wrap_class ) . '" >' . $icon_left . esc_attr( $link_text ) . $icon_right . '</' . esc_attr( $tag ) . '> ' . $output . $styles . '</div>' : ''; // shortcode

		} else {
			return $link_text || $icon_left || $icon_right ? '<div class="dropdown"><' . esc_attr( $tag ) . ' ' . $style . ' ' . $href . ' class="dropdown-toggle dropdown-toggle-0 ' . esc_attr( $link_class ) . ' ' . esc_attr( $wrap_class ) . '"  data-bs-toggle="dropdown" aria-expanded="false">' . $icon_left . esc_attr( $link_text ) . $icon_right . '</' . esc_attr( $tag ) . '> ' . $output . $styles . '</div>' : ''; // shortcode

		}

	}

	public function get_current_page_url() {
		$pageURL = is_ssl() ? 'https://' : 'http://';

		// Host
		if ( isset( $_SERVER['HTTP_HOST'] ) ) {
			$host = wp_unslash( $_SERVER['HTTP_HOST'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		} else {
			$host = wp_parse_url( home_url(), PHP_URL_HOST );
		}

		/*
		 * Since we are assigning the URI from the server variables, we first need
		 * to determine if we are running on apache or IIS.  If PHP_SELF and REQUEST_URI
		 * are present, we will assume we are running on apache.
		 */
		if ( ! empty( $_SERVER['PHP_SELF'] ) && ! empty( $_SERVER['REQUEST_URI'] ) ) {
			// To build the entire URI we need to prepend the protocol, and the http host
			// to the URI string.
			$pageURL .= $host . $_SERVER['REQUEST_URI'];
		} else {
			/*
			 * Since we do not have REQUEST_URI to work with, we will assume we are
			 * running on IIS and will therefore need to work some magic with the SCRIPT_NAME and
			 * QUERY_STRING environment variables.
			 *
			 * IIS uses the SCRIPT_NAME variable instead of a REQUEST_URI variable... thanks, MS
			 */
			$pageURL .= $host . $_SERVER['SCRIPT_NAME'];

			// If the query string exists append it to the URI string
			if ( isset( $_SERVER['QUERY_STRING'] ) && ! empty( $_SERVER['QUERY_STRING'] ) ) {
				$pageURL .= '?' . $_SERVER['QUERY_STRING'];
			}
		}

		return $pageURL;
	}


}


// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Share' );
	}
);


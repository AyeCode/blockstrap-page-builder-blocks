<?php

class BlockStrap_Widget_Contact extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'         => 'blockstrap',
			'output_types'       => array( 'block', 'shortcode' ),
			'block-icon'         => 'fas fa-envelope',
			'block-category'     => 'layout',
			'block-keywords'     => "['contact','email','form']",
			'block-wrap'         => '',
			'block-supports'     => array(
				'customClassName' => false,
			),
			'block-edit-returnx' => "el('span', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									style: {'minHeight': '30px'},
									className: '',
								}))",
			'class_name'         => __CLASS__,
			'base_id'            => 'bs_contact',
			'name'               => __( 'BS > Contact Form', 'blockstrap-page-builder-blocks' ),
			'widget_ops'         => array(
				'classname'   => 'bs-contact',
				'description' => esc_html__( 'A simple contact form.', 'blockstrap-page-builder-blocks' ),
			),
			'example'            => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'            => true,
			'block_group_tabs'   => array(
				'content'  => array(
					'groups' => array( __( 'Display', 'blockstrap-page-builder-blocks' ), __( 'Fields', 'blockstrap-page-builder-blocks' ), __( 'Email', 'blockstrap-page-builder-blocks' ) ),
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
						__( 'Background', 'blockstrap-page-builder-blocks' ),
						__( 'Button', 'blockstrap-page-builder-blocks' ),
						__( 'Field Styles', 'blockstrap-page-builder-blocks' ),
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

		$arguments['display_labels'] = array(
			'type'     => 'select',
			'title'    => __( 'Field Labels', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''           => __( 'Hidden', 'blockstrap-page-builder-blocks' ),
				'top'        => __( 'Top', 'blockstrap-page-builder-blocks' ),
				'horizontal' => __( 'Inline', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Display', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['display'] = array(
			'type'     => 'select',
			'title'    => __( 'Display Type', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''              => __( 'Inline', 'blockstrap-page-builder-blocks' ),
				'lightbox'      => __( 'Lightbox (open with button)', 'blockstrap-page-builder-blocks' ),
				'lightbox-link' => __( 'Lightbox (open with another link)', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Display', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['lightbox_title'] = array(
			'type'            => 'text',
			'title'           => __( 'Lightbox title', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Contact form', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'group'           => __( 'Display', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%display%]!=""',
		);

		$arguments['lightbox_button_text'] = array(
			'type'            => 'text',
			'title'           => __( 'Button text', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Contact form', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'group'           => __( 'Display', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%display%]=="lightbox"',
		);

		$arguments['lightbox_id'] = array(
			'type'            => 'text',
			'title'           => __( 'Lightbox ID', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'contact-form', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc'            => __( 'Enter an ID with no spaces, only dashes allowed, eg: contact-form', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Display', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%display%]=="lightbox-link"',
		);

		$arguments['badge_size_notice'] = array(
			'type'            => 'notice',
			'desc'            => __( 'To open, use the BS > Button or BS > Nav item, with link type `Open Lightbox` and a URL of the Lightbox ID, prefixed with a #. eg: #contact-form (no spaces).', 'blockstrap-page-builder-blocks' ),
			'status'          => 'info',
			'group'           => __( 'Display', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%display%]=="lightbox-link"',
		);

			$arguments['field_name'] = array(
				'type'     => 'select',
				'title'    => __( 'Name', 'blockstrap-page-builder-blocks' ),
				'options'  => $this->get_field_options(),
				'default'  => 'require',
				'desc_tip' => true,
				'group'    => __( 'Fields', 'blockstrap-page-builder-blocks' ),
			);

			$arguments['field_email'] = array(
				'type'     => 'select',
				'title'    => __( 'Email', 'blockstrap-page-builder-blocks' ),
				'options'  => $this->get_field_options(),
				'default'  => 'require',
				'desc_tip' => true,
				'group'    => __( 'Fields', 'blockstrap-page-builder-blocks' ),
			);

			$arguments['field_phone'] = array(
				'type'     => 'select',
				'title'    => __( 'Phone', 'blockstrap-page-builder-blocks' ),
				'options'  => $this->get_field_options(),
				'default'  => '',
				'desc_tip' => true,
				'group'    => __( 'Fields', 'blockstrap-page-builder-blocks' ),
			);

			$arguments['field_subject'] = array(
				'type'     => 'select',
				'title'    => __( 'Subject', 'blockstrap-page-builder-blocks' ),
				'options'  => $this->get_field_options(),
				'default'  => '',
				'desc_tip' => true,
				'group'    => __( 'Fields', 'blockstrap-page-builder-blocks' ),
			);

			$arguments['field_message'] = array(
				'type'     => 'select',
				'title'    => __( 'Message', 'blockstrap-page-builder-blocks' ),
				'options'  => $this->get_field_options(),
				'default'  => '',
				'desc_tip' => true,
				'group'    => __( 'Fields', 'blockstrap-page-builder-blocks' ),
			);

			if ( defined( 'BLOCKSTRAP_VERSION' ) ) {
				$arguments['field_recaptcha'] = array(
					'type'     => 'select',
					'title'    => __( 'Recaptcha', 'blockstrap-page-builder-blocks' ),
					'options'  => array(
						''         => __( 'Enabled', 'blockstrap-page-builder-blocks' ),
						'disabled' => __( 'Disabled', 'blockstrap-page-builder-blocks' ),
					),
					'default'  => '',
					'desc_tip' => true,
					'group'    => __( 'Fields', 'blockstrap-page-builder-blocks' ),
				);

				//              $keys = get_option('blockstrap_recaptcha_keys');
				//              if()
				$arguments['recaptcha_notice'] = array(
					'type'            => 'notice',
					'desc'            => __( 'Set your keys under Appearances > Theme Setup > Recaptcha Keys', 'blockstrap-page-builder-blocks' ),
					'status'          => 'info',
					'group'           => __( 'Fields', 'blockstrap-page-builder-blocks' ),
					'element_require' => '[%field_recaptcha%]!="disabled"',
				);
			}

			$arguments['email_submit_text'] = array(
				'type'        => 'text',
				'title'       => __( 'Submit text', 'blockstrap-page-builder-blocks' ),
				'placeholder' => 'Send',
				'default'     => '',
				'desc'        => __( 'Leave this blank to be able to translate it.', 'blockstrap-page-builder-blocks' ),
				'group'       => __( 'Fields', 'blockstrap-page-builder-blocks' ),
			);

			$arguments['email_name'] = array(
				'type'        => 'text',
				'title'       => __( 'Email Name', 'blockstrap-page-builder-blocks' ),
				'placeholder' => 'BlockStrap Contact Form',
				'default'     => '',
				'desc'        => __( 'This helps identify the form emails', 'blockstrap-page-builder-blocks' ),
				'group'       => __( 'Email', 'blockstrap-page-builder-blocks' ),
			);

			$arguments['send_to'] = array(
				'type'     => 'select',
				'title'    => __( 'Send to', 'blockstrap-page-builder-blocks' ),
				'options'  => $this->get_recipient_options(),
				'default'  => '',
				'desc_tip' => true,
				'group'    => __( 'Email', 'blockstrap-page-builder-blocks' ),
			);

			$arguments['send_bcc'] = array(
				'type'     => 'select',
				'title'    => __( 'Send BCC', 'blockstrap-page-builder-blocks' ),
				'options'  => array( '0' => __( 'None', 'blockstrap-page-builder-blocks' ) ) + $this->get_recipient_options(),
				'default'  => '',
				'desc_tip' => true,
				'group'    => __( 'Email', 'blockstrap-page-builder-blocks' ),
			);

			$arguments['newsletter'] = array(
				'type'     => 'select',
				'title'    => __( 'Newsletter Subscribe', 'blockstrap-page-builder-blocks' ),
				'options'  => array(
					'0'      => __( 'No', 'blockstrap-page-builder-blocks' ),
					'noptin' => defined( 'NOPTIN_VERIFY_NONCE' ) ? __( 'Noptin', 'blockstrap-page-builder-blocks' ) : __( 'Noptin (plugin needs to be installed)', 'blockstrap-page-builder-blocks' ),
				),
				'default'  => '0',
				'desc_tip' => true,
				'group'    => __( 'Email', 'blockstrap-page-builder-blocks' ),
			);

			$arguments['sent_message'] = array(
				'type'                  => 'text',
				'title'                 => __( 'Sent message', 'blockstrap-page-builder-blocks' ),
				'placeholder'           => __( 'Thanks for your email, we will get back to you shortly!', 'blockstrap-page-builder-blocks' ),
				'default'               => '',
				//          'desc'        => __( 'This helps identify the form emails', 'blockstrap-page-builder-blocks' ),
								'group' => __( 'Email', 'blockstrap-page-builder-blocks' ),
			);

			//      $arguments['icon_class'] = array(
			//          'type'        => 'text',
			//          'title'       => __( 'Icon class', 'blockstrap-page-builder-blocks' ),
			//          'desc'        => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			//          'placeholder' => __( 'fas fa-ship', 'blockstrap-page-builder-blocks' ),
			//          'default'     => '',
			//          'desc_tip'    => true,
			//          'group'       => __( 'Link', 'blockstrap-page-builder-blocks' ),
			//      );
			//
			//      $arguments['icon_position'] = array(
			//          'type'            => 'select',
			//          'title'           => __( 'Icon position', 'blockstrap-page-builder-blocks' ),
			//          'options'         => array(
			//              'left'  => __( 'Left', 'blockstrap-page-builder-blocks' ),
			//              'right' => __( 'right', 'blockstrap-page-builder-blocks' ),
			//          ),
			//          'default'         => '',
			//          'desc_tip'        => true,
			//          'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			//          'element_require' => '[%icon_class%]!=""',
			//      );

			// background
			$arguments = $arguments + sd_get_background_inputs( 'bg' );

			// button styles
			$arguments['link_type'] = array(
				'type'     => 'select',
				'title'    => __( 'Link style', 'blockstrap-page-builder-blocks' ),
				'options'  => array(
					'btn'       => __( 'Button', 'blockstrap-page-builder-blocks' ),
					'btn-round' => __( 'Button rounded', 'blockstrap-page-builder-blocks' ),
				),
				'default'  => 'btn',
				'desc_tip' => true,
				'group'    => __( 'Button', 'blockstrap-page-builder-blocks' ),
			);

			$arguments['link_size'] = array(
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
				'group'    => __( 'Button', 'blockstrap-page-builder-blocks' ),
			//          'element_require' => '[%link_type%]!="badge" && [%link_type%]!="badge-pill"',
			);

			//      $arguments['badge_size_notice'] = array(
			//          'type'            => 'notice',
			//          'desc'            => __( 'Badge size is inherited from the parent text size', 'blockstrap-page-builder-blocks' ),
			//          'status'          => 'info',
			//          'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
			//          'element_require' => '([%link_type%]=="badge" || [%link_type%]=="badge-pill")',
			//      );

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
				//              'tab'             => array(
				//                  'title'     => __( 'Normal', 'blockstrap-page-builder-blocks' ),
				//                  'key'       => 'button_normal',
				//                  'tabs_open' => true,
				//                  'open'      => true,
				//                  'class'     => 'text-center w-50 d-flex justify-content-center',
				//              ),
				),
				array(
					'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
					'element_require' => '[%link_type%]!="iconbox" && [%link_bg%]=="custom-color"',
				),
				false,
				false,
				true
			);

		$arguments['button_position'] = array(
			'type'     => 'select',
			'title'    => __( 'Position', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''            => __( 'Left', 'blockstrap-page-builder-blocks' ),
				'text-right'  => __( 'Right', 'blockstrap-page-builder-blocks' ),
				'text-center' => __( 'Center', 'blockstrap-page-builder-blocks' ),
				'd-grid'      => __( 'Full width', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Button', 'blockstrap-page-builder-blocks' ),
		//          'element_require' => '[%link_type%]!="badge" && [%link_type%]!="badge-pill"',
		);

		//      $arguments = $arguments + sd_get_text_color_input_group(
		//          'text_color',
		//          array(
		//              'group' => __( 'Button', 'blockstrap-page-builder-blocks' ),
		//          ),
		//          array(
		//              'group' => __( 'Button', 'blockstrap-page-builder-blocks' ),
		//              'tab'   => array(
		//                  'close' => true,
		//              ),
		//          )
		//      );

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

		//      $arguments = $arguments + sd_get_background_inputs(
		//          'bg_hover',
		//          array(
		//              'title'           => __( 'Color', 'blockstrap-page-builder-blocks' ),
		//              'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
		//              'element_require' => '[%link_type%]!="iconbox"',
		//              'default'         => '',
		//              'tab'             => array(
		//                  'title' => __( 'Hover', 'blockstrap-page-builder-blocks' ),
		//                  'key'   => 'button_hover',
		//                  'open'  => true,
		//                  'class' => 'text-center w-50 d-flex justify-content-center',
		//              ),
		//          ),
		//          array(
		//              'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
		//              'element_require' => '[%link_type%]!="iconbox" && [%bg_hover%]=="custom-color"',
		//          ),
		//          array(
		//              'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
		//              'element_require' => '[%link_type%]!="iconbox" && [%bg_hover%]=="custom-gradient"',
		//          ),
		//          false,
		//          true
		//      );
		//
		//      // text color
		//      $arguments = $arguments + sd_get_text_color_input_group(
		//          'text_color_hover',
		//          array(
		//              'group' => __( 'Button', 'blockstrap-page-builder-blocks' ),
		//          ),
		//          array(
		//              'group' => __( 'Button', 'blockstrap-page-builder-blocks' ),
		//              'tab'   => array(
		//                  'close'      => true,
		//                  'tabs_close' => true,
		//              ),
		//          )
		//      );

		$arguments['field_size'] = array(
			'type'     => 'select',
			'title'    => __( 'Size', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''   => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'sm' => __( 'Small', 'blockstrap-page-builder-blocks' ),
				'lg' => __( 'Large', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Field Styles', 'blockstrap-page-builder-blocks' ),
		//          'element_require' => '[%link_type%]!="badge" && [%link_type%]!="badge-pill"',
		);

		$arguments['textarea_rows'] = array(
			'type'        => 'number',
			'title'       => __( 'Textarea rows', 'blockstrap-page-builder-blocks' ),
			'placeholder' => '4',
			'default'     => '',
			'group'       => __( 'Field Styles', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['field_layout'] = array(
			'type'            => 'select',
			'title'           => __( 'Layout', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				''           => __( 'Vertical', 'blockstrap-page-builder-blocks' ),
				'horizontal' => __( 'Horizontal (use with fewer fields)', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Field Styles', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%display%]==""',
		);

		// Typography
		//      // custom font size
		//      $arguments['font_size_custom'] = sd_get_font_custom_size_input();
		//
		//      // font weight.
		//      $arguments['font_weight'] = sd_get_font_weight_input();
		//
		//      // font case
		//      $arguments['font_case'] = sd_get_font_case_input();

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

	public function get_field_options() {
		$links = array(
			'show'    => __( 'Show', 'blockstrap-page-builder-blocks' ),
			'hide'    => __( 'Hide', 'blockstrap-page-builder-blocks' ),
			'require' => __( 'Require', 'blockstrap-page-builder-blocks' ),
		);

		return $links;
	}

	public function get_recipient_options() {
		$types = array(
			'site'        => __( 'Site Email', 'blockstrap-page-builder-blocks' ),
			'post_author' => __( 'Post Author', 'blockstrap-page-builder-blocks' ),
		);

		if ( defined( 'GEODIRECTORY_VERSION' ) ) {
			$types['gd_post_email'] = __( 'GD Listing Email', 'blockstrap-page-builder-blocks' );
		}

		$admins = get_users(
			array(
				'role__in' => array( 'administrator' ),
			)
		);

		if ( ! empty( $admins ) ) {
			foreach ( $admins as $admin ) {
				$types[ $admin->ID ] = 'Admin: ' . esc_attr( $admin->display_name );
			}
		}

		return $types;
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
		global $aui_bs5,$post;

		//      print_r( $args );
		//      $args['text'] = str_replace("&#039;","'",$args['text']);
		$tag       = 'a';
		$link      = '#';
		$link_text = __( 'Send', 'blockstrap-page-builder-blocks' );

		// maybe set custom link text
		$link_text     = ! empty( $args['email_submit_text'] ) ? esc_attr( $args['email_submit_text'] ) : $link_text;
		$is_lightbox   = ! empty( $args['display'] );
		$is_horizontal = ! empty( $args['field_layout'] ) && 'horizontal' === $args['field_layout'];

		//      echo '###'.$link_text;

		// link type
		$link_class = 'nav-link';

		if ( ! empty( $args['link_type'] ) ) {

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
			}
			//          elseif ( 'custom-gradient' === $args['link_bg'] ) {
			//              $args['bg']          = $args['link_bg'];
			//              $args['bg_gradient'] = $args['link_bg_gradient'];
			//              //$args['link_bg']     = '';
			//          }

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

		// Fields
		$field_content = '';
		$field_types   = array(
			'field_name'    => array(
				'type'  => 'text',
				'label' => __( 'Name', 'blockstrap-page-builder-blocks' ),
			),
			'field_email'   => array(
				'type'  => 'email',
				'label' => __( 'Email', 'blockstrap-page-builder-blocks' ),
			),
			'field_phone'   => array(
				'type'  => 'phone',
				'label' => __( 'Phone', 'blockstrap-page-builder-blocks' ),
			),
			'field_subject' => array(
				'type'  => 'text',
				'label' => __( 'Subject', 'blockstrap-page-builder-blocks' ),
			),
			'field_message' => array(
				'type'  => 'textarea',
				'label' => __( 'Message', 'blockstrap-page-builder-blocks' ),
			),
		);

		$field_types = apply_filters( 'blockstrap_blocks_contact_block_field_types', $field_types, $args, $this );

		$form_hz_col_class = ! $is_lightbox && $is_horizontal ? ' col' : '';

		foreach ( $field_types as $field_slug => $field ) {

			if ( 'hide' !== $args[ $field_slug ] ) {
				$required = 'require' === $args[ $field_slug ] ? ' <span class="text-danger">*</span>' : '';
				if ( $required && empty( $args['display_labels'] ) ) {
					$required = ' ' . __( '(required)', 'blockstrap-page-builder-blocks' );
				}
				$type           = 'textarea' === $field['type'] ? 'textarea' : 'input';

				$value          = '';
				// maybe set the name and email if the user is logged in
				$current_user = wp_get_current_user();
				if ( $current_user->exists() ) {
					if($field_slug === 'field_name' && !empty($current_user->display_name)) {
						$value = esc_attr( sanitize_text_field( $current_user->display_name ) );
					}elseif ($field_slug === 'field_email' && !empty($current_user->user_email)) {
						$value = esc_attr( sanitize_email( $current_user->user_email ) );
					}
				}

				$field_content .= aui()->{$type}(
					array(
						'type'        => $field['type'],
						//'id'          => $field_slug,
						'name'        => $field_slug,
						'value'       => $value,
						'required'    => 'require' === $args[ $field_slug ],
						'label_show'  => true,
						'label'       => $field['label'] . $required,
						'label_type'  => $args['display_labels'],
						'placeholder' => empty( $args['display_labels'] ) ? $field['label'] . $required : '',
						'size'        => ! empty( $args['field_size'] ) ? $args['field_size'] : '',
						'rows'        => ! empty( $args['textarea_rows'] ) ? $args['textarea_rows'] : '4',
						'wrap_class'  => $form_hz_col_class,
					)
				);
			}
		}


		// Captcha Input
		$captcha_input = apply_filters( 'blockstrap_blocks_contact_form_captcha_input', '', $args );

		// recaptcha
		$recaptcha_enabled = false;
		if ( !$captcha_input && defined( 'BLOCKSTRAP_VERSION' ) && empty( $args['field_recaptcha'] ) ) {
			$keys     = function_exists( 'blockstrap_get_option' ) ? blockstrap_get_option( 'blockstrap_recaptcha_keys' ) : get_option( 'blockstrap_recaptcha_keys' );
			if ( ! empty( $keys['site_key'] ) && ! empty( $keys['site_secret'] ) ) {
				$field_content    .= '<div class="g-recaptcha mb-3" data-sitekey="' . esc_attr( $keys['site_key'] ) . '"></div>';
				$recaptcha_enabled = 'g-recaptcha-response';
				//if(!$is_lightbox){
					add_action( 'wp_footer', array( $this, 'get_recaptcha_js' ) );
				//}
			}
		} elseif ( $captcha_input ) {
			$field_content .= $captcha_input;
			$recaptcha_enabled = 'cf-turnstile-response';
		}

		// add to footer
		add_action( 'wp_footer', array( $this, 'get_js' ) );

		$subject      = esc_attr( $args['email_name'] );
		$sent_message = ! empty( $args['sent_message'] ) ? esc_attr( $args['sent_message'] ) : __( 'Thanks for your email, we will get back to you shortly!', 'blockstrap-page-builder-blocks' );
		$send_to      = ! empty( $args['send_to'] ) ? esc_attr( $args['send_to'] ) : 'site';
		$newsletter   = ! empty( $args['newsletter'] ) ? esc_attr( $args['newsletter'] ) : '0';
		$send_bcc     = esc_attr( $args['send_bcc'] );
		$post_id      = ! empty( $post->ID ) ? absint( $post->ID ) : 0;

		// we force this to string as the post value will anyway and we need the hash to match
		$settings = array(
			(string) esc_attr( $send_to ),
			(string) esc_attr( $send_bcc ),
			(string) esc_attr( $subject ),
			(string) absint( $post_id ),
			(string) esc_attr( $recaptcha_enabled ),
			(string) esc_attr( $newsletter ),
		);

		$lightbox_id = ! empty( $args['lightbox_id'] ) ? esc_attr( sanitize_title_with_dashes( $args['lightbox_id'] ) ) : 'contact-form';

		$form_html     = '';
		$lightbox_html = '';
		$button_html   = '';
		$preview_click = $this->is_preview() ? ' onclick="alert(\'' . esc_attr__( 'This is a preview, please test on the frontend.', 'blockstrap-page-builder-blocks' ) . '\');return false;" ' : '';

		if ( $is_lightbox ) {
			$button_text  = ! empty( $args['lightbox_button_text'] ) ? esc_attr( $args['lightbox_button_text'] ) : __( 'Contact form', 'blockstrap-page-builder-blocks' );
			$modal_title  = ! empty( $args['lightbox_title'] ) ? esc_attr( $args['lightbox_title'] ) : __( 'Contact form', 'blockstrap-page-builder-blocks' );
			$button_html .= '<div class="' . esc_attr( $args['button_position'] ) . '">';
			if ( 'lightbox-link' === $args['display'] ) {
				$button_html .= $this->is_preview() ? aui()->alert(
					array(
						'type'    => 'info',
						'content' => sprintf( __( 'This is a placeholder for the lightbox for contact form: %s', 'blockstrap-page-builder-blocks' ), esc_attr( $args['lightbox_id'] ) ),
						'class'   => 'mb-0',
					)
				) : '';
			} else {

				$button_html .= $preview_click ? '<button type="button" class="' . esc_attr( $link_class ) . '" ' . $preview_click . '>' . esc_attr( $button_text ) . '</button>' : '<button type="button" class="' . esc_attr( $link_class ) . '" data-bs-toggle="modal" data-bs-target="#' . esc_attr( $lightbox_id ) . '">' . esc_attr( $button_text ) . '</button>';
			}
			$button_html    .= '</div>';
			$recaptcha_class = $recaptcha_enabled ? 'bspbb-contact-form-recaptcha-lightbox' : '';

			$lightbox_html .= '<div class="modal fade ' . esc_attr( $recaptcha_class ) . '" id="' . esc_attr( $lightbox_id ) . '" tabindex="-1" aria-labelledby="' . esc_attr( $lightbox_id ) . 'Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="' . esc_attr( $lightbox_id ) . 'Label">' . esc_attr( $modal_title ) . '</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">';
		}

		$recaptcha_class = ! $is_lightbox && $recaptcha_enabled ? ' bspbb-contact-form-recaptcha' : '';

		$form_hz_class     = ! $is_lightbox && $is_horizontal ? ' row' : '';
		$form_hz_btn_class = ! $is_lightbox && $is_horizontal ? ' col-auto' : '';

		$form_html .= '<form
		data-settings=\'' . wp_json_encode( $settings ) . '\'
		data-settings-nonce=\'' . wp_hash( wp_json_encode( $settings ) ) . '\'
		data-sent="' . esc_attr( $sent_message ) . '"
		class="' . esc_attr( $wrap_class ) . esc_attr( $recaptcha_class ) . esc_attr( $form_hz_class ) . '" ' . $style . '
		onsubmit="bpbb_send_contact_form(this);return false;">';

		$form_html .= $field_content;
		$form_html .= '<div class="' . esc_attr( $args['button_position'] ) . esc_attr( $form_hz_btn_class ) . '">';
		$form_html .= '<button type="submit" class="' . esc_attr( $link_class ) . '" ' . $preview_click . ' ><span class="spinner-border spinner-border-sm mt-n1 d-none" role="status" aria-hidden="true"></span> ' . $icon_left . esc_attr( $link_text ) . $icon_right . '</button>';
		$form_html .= '</div>';
		$form_html .= '</form>';

		if ( $is_lightbox ) {

			$lightbox_html .= $form_html;

			$lightbox_html .= '</div>

    </div>
  </div>
</div>';

			$html = $button_html;

			// Add the modal HTML to footer to prevent any z-index issues.
			add_action(
				'wp_footer',
				function() use ( $lightbox_html ) {
					echo $lightbox_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			);
		} else {
			$html = $button_html . $form_html . $lightbox_html;
		}


		// show notice that form will only show if GD email exists
		if ($send_to === 'gd_post_email') {
			global $gd_post;
			if ($this->is_preview()) {
				$html = aui()->alert( array(
					'type'    => 'info',
					'content' => __( 'GD contact form will only show if the listing has an email set.', 'blockstrap-page-builder-blocks' ),
					'class'   => 'mb-0',
				)) . $html ;
			}elseif(empty($gd_post->email)){
				// if the GD post has no email then don't show the form
				$html = '';
			}
		}

		return apply_filters( 'blockstrap_blocks_block_output_contact', $html, $args );

		//return $link_text || $icon_left || $icon_right ? '<' . esc_attr( $tag ) . ' ' . $style . ' ' . $href . ' class="' . esc_attr( $link_class ) . ' ' . esc_attr( $wrap_class ) . '">' . $icon_left . esc_attr( $link_text ) . $icon_right . '</' . esc_attr( $tag ) . '> ' . $styles : ''; // shortcode

	}

	public function get_modal_footer_html() {

	}

	public function get_recaptcha_js() {
		$keys     = function_exists( 'blockstrap_get_option' ) ? blockstrap_get_option( 'blockstrap_recaptcha_keys' ) : get_option( 'blockstrap_recaptcha_keys' );
		$site_key = ! empty( $keys['site_key'] ) ? esc_attr( $keys['site_key'] ) : '';
		ob_start();
		//bsppb-contact-form
		?>

		<script>
			let bspbb_is_recaptcha_loaded = false;
			/**
			 * Fire on jQuery load
			 */
			jQuery(document).ready(function(){
				// Check if recaptcha is already loaded
				var loaded = jQuery('script').filter(function () {
					let src = jQuery(this).attr('src') ? new URL(jQuery(this).attr('src')) :'';
					if(src ){
						let url = src.origin + src.pathname;
						if (url === 'https://www.google.com/recaptcha/api.js') {
							return true;
							bspbb_is_recaptcha_loaded = true;
						}
					}
				}).length;

				// If not loaded and there is a non lightbox form on the page, then load now.
				if(!loaded && jQuery('.bspbb-contact-form-recaptcha').length){
					bspbb_load_recaptcha_script();
				}else{
					//bspbbRecaptchaCallback(); // @todo maybe need a time delay here.
				}

				// If there is a lightbox form on the page, then make it fire on lightboox open.
				jQuery('.bspbb-contact-form-recaptcha-lightbox').each(function(i, obj) {
					const myModalEl = jQuery(this).get( 0 );
					myModalEl.addEventListener('shown.bs.modal', event => {
						bspbb_load_recaptcha_script();
					})
				});
			});

			/**
			 * The function to fire when recaptcha loaded
			 */
			function bspbbRecaptchaCallback(){
				 bspbb_init_form_recaptcha();
			}

			/**
			 * Load the recaptcha script.
			 */
			function bspbb_load_recaptcha_script(){
				if (!bspbb_is_recaptcha_loaded) {
					console.log('not loaded');
					jQuery.getScript("https://www.google.com/recaptcha/api.js?onload=bspbbRecaptchaCallback&render=explicit")
						.done(function() {
							bspbb_is_recaptcha_loaded = true;
						})
						.fail(function() {
						});
				}else{
					bspbbRecaptchaCallback();
				}

			}

			/**
			 * Initiate the recaptcha forms.
			 */
			function bspbb_init_form_recaptcha(){
				jQuery('.bspbb-contact-form-recaptcha,.bspbb-contact-form-recaptcha-lightbox').each(function(i, obj) {
					try{
						grecaptcha.render(jQuery(this).find('.g-recaptcha').get( 0 ),{'sitekey' : '<?php echo esc_attr( $site_key ); ?>' });
					}catch(error){/*possible duplicated instances*/}
				});
			}
		</script>
		<?php

		echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function get_js() {
		ob_start();
		?>
		<script>
			function bpbb_send_contact_form($form){
				var form_data = jQuery($form).serialize();
				let $message = jQuery($form).data('sent');
				console.log(form_data );

				var data = {
					action: 'blockstrap_pbb_contact',
					security: '<?php echo esc_attr( wp_hash( get_site_url() ) ); // a normal nonce could break for logged out users with certain caching. ?>',
					form_data: form_data,
					location: window.location.href,
					settings: jQuery($form).data('settings'),
					settingsNonce: jQuery($form).data('settings-nonce'),
				};

				jQuery.ajax({
					type: 'POST',
					url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
					data: data,
					// dataType: 'html'
					beforeSend: function() {
						jQuery($form).find('.btn-primary').prop('disabled', true).find('.spinner-border').removeClass('d-none');
					},
					success: function(data) {

						if (data.success) {
							jQuery($form).html( '<div class="alert alert-success" role="alert">'+$message+'</div>' );
							aui_toast('blockstrap_contact_form_success','success', $message );
						}else{
							var message = data.data ? data.data : '<?php esc_html_e( 'Something went wrong, please try again', 'blockstrap-page-builder-blocks' ); ?>';
							aui_toast('','error', message );
							jQuery($form).find('.btn-primary').prop('disabled', false).find('.spinner-border').addClass('d-none');
							document.dispatchEvent(new Event('ayecode_reset_captcha'));
						}

					},
					error: function(xhr) { // if error occured
						jQuery($form).find('.btn-primary').prop('disabled', false).find('.spinner-border').addClass('d-none');
						alert("Error occured.please try again");
						document.dispatchEvent(new Event('ayecode_reset_captcha'));
					},
					complete: function() {
						jQuery($form).find('.btn-primary').prop('disabled', false).find('.spinner-border').addClass('d-none');
					},
				});

			}
		</script>
		<?php

		echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}


}


// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Contact' );
	}
);


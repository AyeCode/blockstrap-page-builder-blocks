<?php

class BlockStrap_Widget_Offcanvas extends WP_Super_Duper
{

    public $arguments;


    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {

        $aui_settings = is_admin() ? get_option('ayecode-ui-settings') : [];

        $options = [
            'textdomain'       => 'blockstrap',
            'output_types'     => [
                'block',
                'shortcode',
            ],
            'nested-block'     => true,
            'block-icon'       => 'fas fa-square',
            'block-category'   => 'layout',
            'block-keywords'   => "['modal','popup','lightbox','offcanvas']",
            'block-supports'   => ['customClassName' => false],
            'block-output'     => [
				[
					'element'       => 'BlocksProps',
					'blockProps'       => array(
						'if_className'	=> 'bs_build_offcanvas_button_class(props.attributes)',
					),
					'inner_element' => 'button',
					'"data-bs-togglex"'	=> 'offcanvas',
					'if_"data-bs-target"'	=> 'props.attributes.anchor ? "#" + props.attributes.anchor : "#" + props.attributes.styleid',
					'if_content'	=> 'props.attributes.button_text',
					'element_require' => '[%open_with%]==""',
				],
				[
					'element'       => 'BlocksProps',
					'blockProps'       => array(
						'className'	=> 'alert alert-info',
					),
					'inner_element' => 'div',
					'if_content'	=> '"Offcanvas Placeholder for #" + bs_build_offcanvas_id(props.attributes)',
					'element_require' => '[%open_with%]=="external"',
				],
				array(
					'element'              => 'div',
					'if_id'	=> 'props.attributes.anchor ? props.attributes.anchor : props.attributes.styleid',
					'if_class' => '"offcanvas " + bs_build_offcanvas_class(props.attributes)',
					'style'        => '{zIndex:100000,[%WrapStyle%]}',
					'tabindex'	=> '-1',
					'if_"data-bs-backdrop"'	=> 'props.attributes.static_backdrop && props.attributes.static_backdrop == "yes" ? "static" : "true"',
					'if_"data-bs-keyboard"'	=> 'props.attributes.static_backdrop && props.attributes.static_backdrop == "yes" ? "false" : "true"',
//					array(
//						'element' => 'div',
//						'if_class' => '"modal-dialog " + bs_build_offcanvas_dialog_class(props.attributes)',
//						array(
//							'element' => 'div',
//							'if_class' => '"modal-content overflow-hidden " [%WrapClass%]',
//							'style'        => '{[%WrapStyle%]}',
							array(
								'element' => 'div',
								'if_class' => '"offcanvas-header " +  bs_build_offcanvas_header_class(props.attributes)',
								array(
									'element' => 'h1',
									'if_class' => '"offcanvas-title " +  bs_build_offcanvas_title_class(props.attributes)',
									'if_content' => 'props.attributes.header_title',
								),
								array(
									'element' => 'button',
									'if_class' => 'props.attributes.close_icon=="hide" ? "d-none" : "btn-close bg-white"',
									'"data-bs-dismiss"' => 'offcanvas',
									'"aria-label"' => 'Close',
								),

							),
							array(
								'element' => 'div',
								'if_class' => '"offcanvas-body " +  bs_build_offcanvas_body_class(props.attributes)',
								array(
									'element'          => 'innerBlocksProps',
									'blockProps'       => array(
									),
									'innerBlocksProps' => array(
										'orientation' => 'vertical',
									),

								),
							)

//						)
//					),

				),
            ],
			'example'           => array(
				'viewportWidth' => 200
			),
            'block-wrap'       => '',
			'block-api-version' => 3, // this is needed to make the block selectable in the editor if not using innerBlockProps https://wordpress.stackexchange.com/questions/384004/cant-select-my-block-by-clicking-on-it
			'class_name'       => __CLASS__,
            'base_id'          => 'bs_offcanvas',
            'name'             => __('BS > Offcanvas', 'blockstrap-page-builder-blocks'),
            'widget_ops'       => [
                'classname'   => 'bs-offcanvas',
                'description' => esc_html__('A Bootstrap Offcanvas builder for creating off page elements.', 'blockstrap-page-builder-blocks'),
            ],
            'no_wrap'          => true,
            'block_group_tabs' => [
				'content'  => array(
					'groups' => array(
						__( 'Offcanvas', 'blockstrap-page-builder-blocks' ),
						__( 'Header', 'blockstrap-page-builder-blocks' ),
						__( 'Body', 'blockstrap-page-builder-blocks' ),
						__( 'Footer', 'blockstrap-page-builder-blocks' ),
					),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
                'styles'   => [
                    'groups' => [
						__('Button', 'blockstrap-page-builder-blocks'),
						__('Offcanvas Header', 'blockstrap-page-builder-blocks'),
						__('Offcanvas Body', 'blockstrap-page-builder-blocks'),
					],
                    'tab'    => [
                        'title'     => __('Styles', 'blockstrap-page-builder-blocks'),
                        'key'       => 'bs_tab_styles',
                        'tabs_open' => true,
                        'open'      => true,
                        'class'     => 'text-center flex-fill d-flex justify-content-center',
                    ],
                ],
                'advanced' => [
                    'groups' => [
                        __('Wrapper Styles', 'blockstrap-page-builder-blocks'),
                        __('Advanced', 'blockstrap-page-builder-blocks'),
                    ],
                    'tab'    => [
                        'title'     => __('Advanced', 'blockstrap-page-builder-blocks'),
                        'key'       => 'bs_tab_advanced',
                        'tabs_open' => true,
                        'open'      => true,
                        'class'     => 'text-center flex-fill d-flex justify-content-center',
                    ],
                ],
            ],
        ];

        parent::__construct($options);

    }//end __construct()


    /**
     * Set the arguments later.
     *
     * @return array
     */
    public function set_arguments()
    {
        $arguments = [];

		$arguments['footer_notice'] = [
			'type'            => 'notice',
			'desc'            => __('Place in the theme footer to be able to open on any page.', 'blockstrap-page-builder-blocks'),
			'status'          => 'info',
			// 'warning' | 'success' | 'error' | 'info'
			'group'           => __('Offcanvas', 'blockstrap-page-builder-blocks'),
			'element_require' => '[%open_with%]=="external"',
		];

        $arguments['open_with'] = [
            'type'     => 'select',
            'title'    => __('Open with', 'blockstrap-page-builder-blocks'),
            'options'  => [
                ''      => __('Button', 'blockstrap-page-builder-blocks'),
                'external' => __('Another Element', 'blockstrap-page-builder-blocks'),
            ],
            'default'  => '',
            'desc_tip' => true,
            'group'    => __('Offcanvas', 'blockstrap-page-builder-blocks'),
        ];

		$arguments['anchor'] = [
			'type'    => 'text',
			'title'   => __('Offcanvas ID', 'blockstrap-page-builder-blocks'),
			'default' => '',
//			'custom_attributes' => array(
////				'pattern' => '[A-Za-z0-9_\-\.]+',
//					'onkeyup' => "alert(1)",
//			),
			'desc'	=> __('Enter an ID with no spaces, only dashes allowed, eg: contact-form', 'blockstrap-page-builder-blocks'),
			'group'   => __('Offcanvas', 'blockstrap-page-builder-blocks'),
			'element_require' => '[%open_with%]=="external"',
		];

		$arguments['anchor_notice'] = [
			'type'            => 'notice',
			'desc'            => __('The Offcanvas ID can be used by other blocks to open the Offcanvas, BS > Button or BS > Nav item', 'blockstrap-page-builder-blocks'),
			'status'          => 'error',
			// 'warning' | 'success' | 'error' | 'info'
			'group'           => __('Offcanvas', 'blockstrap-page-builder-blocks'),
			'element_require' => '[%open_with%]=="external"',
		];

		$arguments['button_text'] = [
			'type'    => 'text',
			'title'   => __('Button text', 'blockstrap-page-builder-blocks'),
			'placeholder'   => __('Open Popup', 'blockstrap-page-builder-blocks'),
			'default' => __('Open Offcanvas', 'blockstrap-page-builder-blocks'),
			'group'   => __('Offcanvas', 'blockstrap-page-builder-blocks'),
		];

//		$arguments['size_width'] = [
//			'type'     => 'select',
//			'title'    => __('Width Size', 'blockstrap-page-builder-blocks'),
//			'options'  => [
//				'sm'      => __('Small', 'blockstrap-page-builder-blocks'),
//				''      => __('Default', 'blockstrap-page-builder-blocks'),
//				'lg'      => __('Large', 'blockstrap-page-builder-blocks'),
//				'xl'      => __('Extra Large', 'blockstrap-page-builder-blocks'),
//				'100' => __('100% Width', 'blockstrap-page-builder-blocks'),
//				'fullscreen' => __('Full Screen', 'blockstrap-page-builder-blocks'),
//			],
//			'default'  => '',
//			'desc_tip' => true,
//			'group'    => __('Offcanvas', 'blockstrap-page-builder-blocks'),
//		];

		if (function_exists('sd_get_width_input')) {

			$arguments['width_height_notice'] = [
				'type'            => 'notice',
				'desc'            => __('If manually adjusting the height or width, be sure to adjust the responsive values also.', 'blockstrap-page-builder-blocks'),
				'status'          => 'info',
				// 'warning' | 'success' | 'error' | 'info'
				'group'           => __('Offcanvas', 'blockstrap-page-builder-blocks'),
				'element_require' => '[%with%]!="" ',
			];

			$arguments['width']    = sd_get_width_input( 'width', array( 'device_type' => 'Mobile', 'group' => __('Offcanvas', 'blockstrap-page-builder-blocks') ) );
			$arguments['width_md'] = sd_get_width_input( 'width', array( 'device_type' => 'Tablet', 'group' => __('Offcanvas', 'blockstrap-page-builder-blocks') ) );
			$arguments['width_lg'] = sd_get_width_input( 'width', array( 'device_type' => 'Desktop', 'group' => __('Offcanvas', 'blockstrap-page-builder-blocks') ) );

			$arguments['height']    = sd_get_height_input( 'height', array( 'device_type' => 'Mobile', 'group' => __('Offcanvas', 'blockstrap-page-builder-blocks') ) );
			$arguments['height_md'] = sd_get_height_input( 'height', array( 'device_type' => 'Tablet', 'group' => __('Offcanvas', 'blockstrap-page-builder-blocks') ) );
			$arguments['height_lg'] = sd_get_height_input( 'height', array( 'device_type' => 'Desktop', 'group' => __('Offcanvas', 'blockstrap-page-builder-blocks') ) );
		}


		$arguments['offcanvas_position'] = [
			'type'     => 'select',
			'title'    => __('Vertical Position', 'blockstrap-page-builder-blocks'),
			'options'  => [
				'start'      => __('Left', 'blockstrap-page-builder-blocks'),
				'end'      => __('Right', 'blockstrap-page-builder-blocks'),
				'top'      => __('Top', 'blockstrap-page-builder-blocks'),
				'bottom'      => __('Bottom', 'blockstrap-page-builder-blocks'),
			],
			'default'  => 'start',
			'desc_tip' => true,
			'group'    => __('Offcanvas', 'blockstrap-page-builder-blocks'),
		];

		$arguments['static_backdrop'] = [
			'type'     => 'select',
			'title'    => __('Static Backdrop', 'blockstrap-page-builder-blocks'),
			'options'  => [
				''      => __('No', 'blockstrap-page-builder-blocks'),
				'yes'      => __('Yes', 'blockstrap-page-builder-blocks'),
			],
			'default'  => '',
			'desc'    => __('Prevents modal close on clicks outside modal and on keyboard Esc', 'blockstrap-page-builder-blocks'),
			'desc_tip' => true,
			'group'    => __('Offcanvas', 'blockstrap-page-builder-blocks'),
		];




		// Header

		$arguments['header_hide'] = [
			'type'     => 'select',
			'title'    => __('Header', 'blockstrap-page-builder-blocks'),
			'options'  => [
				''      => __('Show', 'blockstrap-page-builder-blocks'),
				'hide' => __('Hide', 'blockstrap-page-builder-blocks'),
			],
			'default'  => '',
			'desc_tip' => true,
			'group'    => __('Header', 'blockstrap-page-builder-blocks'),
		];

		$arguments['header_title'] = [
			'type'    => 'text',
			'title'   => __('Header title', 'blockstrap-page-builder-blocks'),
			'placeholder'   => __('Popup title', 'blockstrap-page-builder-blocks'),
			'default' => __('Offcanvas title', 'blockstrap-page-builder-blocks'),
			'group'   => __('Header', 'blockstrap-page-builder-blocks'),
		];


        $arguments['close_icon'] = [
            'type'     => 'select',
            'title'    => __('Close Icon', 'blockstrap-page-builder-blocks'),
            'options'  => [
                ''      => __('Show', 'blockstrap-page-builder-blocks'),
                'hide' => __('Hide', 'blockstrap-page-builder-blocks'),
            ],
            'default'  => '',
            'desc_tip' => true,
            'group'    => __('Header', 'blockstrap-page-builder-blocks'),
        ];

		// STYLES

		// Button Styles
		// button styles
		$arguments['link_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Link style', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'btn'          => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'btn-round'    => __( 'Button rounded', 'blockstrap-page-builder-blocks' ),
				'iconbox-fill' => __( 'Iconbox filled', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => 'btn',
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
			'element_require' => '[%link_type%]!="badge" && [%link_type%]!="badge-pill"',
		);


		$arguments = $arguments + sd_get_background_inputs(
				'link_bg',
				array(
					'title'           => __( 'Color', 'blockstrap-page-builder-blocks' ),
					'group'           => __( 'Button', 'blockstrap-page-builder-blocks' ),
					'element_require' => '[%link_type%]!="iconbox"',
					'default'         => 'primary',
				),
				false,
				false,
				false,
				true
			);


		// Header



		$arguments['header_text_color'] = sd_get_text_color_input( 'text_color', array(
			'group' => __( 'Offcanvas Header', 'blockstrap-page-builder-blocks' ),
			false
		));

		// font size
		$arguments['header_font_size'] =  sd_get_font_size_input( 'font_size', array(
			'group' => __( 'Offcanvas Header', 'blockstrap-page-builder-blocks' ),
			'default'	=> 'fs-5',
		));

		// font size
		$arguments['header_font_weight'] = sd_get_font_weight_input('font_weight', array(
			'group' => __( 'Offcanvas Header', 'blockstrap-page-builder-blocks' ),
		));


		// background
		$arguments = $arguments + sd_get_background_inputs(
			'header_bg',
			array('group' => __('Offcanvas Header', 'blockstrap-page-builder-blocks')),
				false,
				false,
			false
			);


		// Offcanvas Content
		// background
		$arguments = $arguments + sd_get_background_inputs(
				'body_bg',
				array('group' => __('Offcanvas Body', 'blockstrap-page-builder-blocks')),
				false,
				false,
				false,
				false
			);


		// padding
		$arguments['body_pt'] = sd_get_padding_input('pt', array('group' => __('Offcanvas Body', 'blockstrap-page-builder-blocks') ) );
		$arguments['body_pr'] = sd_get_padding_input('pr', array('group' => __('Offcanvas Body', 'blockstrap-page-builder-blocks') ) );
		$arguments['body_pb'] = sd_get_padding_input('pb', array('group' => __('Offcanvas Body', 'blockstrap-page-builder-blocks') ));
		$arguments['body_pl'] = sd_get_padding_input('pl', array('group' => __('Offcanvas Body', 'blockstrap-page-builder-blocks') ) );


        // border
        $arguments['border']       = sd_get_border_input('border');
        $arguments['rounded']      = sd_get_border_input('rounded');
        $arguments['rounded_size'] = sd_get_border_input('rounded_size');

        // shadow
        $arguments['shadow'] = sd_get_shadow_input('shadow', array('default'=>'shadow'));

		// block visibility conditions
		$arguments['visibility_conditions'] = sd_get_visibility_conditions_input();

        $arguments['css_class'] = sd_get_class_input();

		// advanced
//		$arguments['anchor'] = sd_get_anchor_input();

		$arguments['styleid'] = array(
			'type'     => 'hidden',
			'title'    => __( 'Style ID', 'blockstrap-page-builder-blocks' ),
			'desc_tip' => true,
			'group'    => __( 'Advanced', 'blockstrap-page-builder-blocks' ),
		);

        if (function_exists('sd_get_custom_name_input')) {
            $arguments['metadata_name'] = sd_get_custom_name_input();
        }

        return $arguments;

    }//end set_arguments()


    /**
     * This is the output function for the widget, shortcode and block (front end).
     *
     * @param array  $args        The arguments values.
     * @param array  $widget_args The widget arguments when used.
     * @param string $content     The shortcode content argument.
     *
     * @return string
     */
    public function output($args=[], $widget_args=[], $content='')
    {
		global $bs_offcanvas_content,$bs_offcanvas_header_count;

		if (!$bs_offcanvas_header_count) {
			$bs_offcanvas_header_count = 0;
		}

		// we add the x so it will not open popup in editor, then we remove it here so on frontend it will
		$content = str_replace('data-bs-togglex', 'onclick="setTimeout(function() { window.dispatchEvent(new Event(\'resize\')); }, 200);" data-bs-toggle', $content);

		// Maybe remove the placeholder div
		if ($content) {
			// Define the pattern to match the first div with the specific classes
			$pattern = '/<div class="wp-block-blockstrap-blockstrap-widget-offcanvas alert alert-info">.*?<\/div>/s';

			// Replace the first occurrence of the pattern with an empty string
			$content = preg_replace($pattern, '', $content, 1);
		}


		//
		// Regex to match the first top-level button
		$buttonRegex = '/<button[^>]*\sdata-bs-target="[^"]*"[^>]*>(.*?)<\/button>/is';


		// Initialize variables
		$buttonHtml = '';
		$bs_offcanvas_content[$bs_offcanvas_header_count] = $content;

		// Find the first top-level button and separate it from the content
		if (preg_match($buttonRegex, $content, $matches)) {
			$buttonHtml = $matches[0];
			// Remove the button from the remaining content
			$bs_offcanvas_content[$bs_offcanvas_header_count] = preg_replace($buttonRegex, '', $content, 1);
		}

		// add the modal HTML to the footer, this needs to work for multiple instances
		add_action('wp_footer', function() {
			global $bs_offcanvas_content,$bs_offcanvas_header_count;
			if ($bs_offcanvas_header_count) {
				foreach ($bs_offcanvas_content as  $content) {
					$content = do_shortcode( $content );

					if (function_exists('do_blocks')) {
						$content = do_blocks( $content );
					}

					echo $content;
				}
				$bs_offcanvas_header_count = 0; // reset the
			}
		}, 1);

		$bs_offcanvas_header_count++;

		return $buttonHtml;

    }//end output()

	public function block_global_js() {
		ob_start();
	if ( false ) {
		?>
		<script>
			<?php
			}
			?>

			function bs_build_offcanvas_class($args) {
				let $class = ''

				// sizing
				// if ($args.size && $args.size == 100) {
				// 	$class += ' mw-100';
				// }else if($args.size && $args.size){
				// 	$class += ' modal-'+jQuery.escapeSelector($args.size);
				// }

				// position
				if ($args.offcanvas_position && $args.offcanvas_position) {
					$class += ' offcanvas-'+jQuery.escapeSelector($args.offcanvas_position);
				}

				$class += ' ' + sd_build_aui_class($args);

				return $class;
			}

			function bs_build_offcanvas_id($args) {
				let $id = ''

				// sizing
				if ($args.anchor) {
					$id =  jQuery.escapeSelector($args.anchor);
				}else if($args.styleid){
					$id =  jQuery.escapeSelector($args.styleid);
				}
				return $id;
			}


			function bs_build_offcanvas_header_class($args) {
				let $class = '';
				let $sd_args = [];

				$sd_args.bg = $args.header_bg;

				$class += ' ' + sd_build_aui_class($sd_args);

				if($args.header_hide==='hide'){
					$class += ' d-none';
				}

				return $class;
			}

			function bs_build_offcanvas_title_class($args) {
				let $class = '';
				let $sd_args = [];

				$sd_args.text_color = $args.header_text_color;
				$sd_args.font_size = $args.header_font_size;
				$sd_args.font_weight = $args.header_font_weight;

				$class += ' ' + sd_build_aui_class($sd_args);

				return $class;
			}

			function bs_build_offcanvas_body_class($args) {
				let $class = '';
				let $sd_args = [];

				$sd_args.pt = $args.body_pt;
				$sd_args.pr = $args.body_pr;
				$sd_args.pb = $args.body_pb;
				$sd_args.pl = $args.body_pl;
				$sd_args.bg = $args.body_bg;

				$class += ' ' + sd_build_aui_class($sd_args);

				return $class;
			}

			function bs_build_offcanvas_button_class($args) {
				let $class = '';
				let $sd_args = [];

				if ( $args.link_type ) {

					if ( 'btn' === $args.link_type ) {
						$class = 'btn';
					} else if ( 'btn-round' === $args.link_type ) {
						$class = 'btn btn-round';
					} else if ( 'iconbox-fill' === $args.link_type ) {
						$class = 'iconbox fill rounded-circle btn p-0';
					}

					if ( 'btn' === $args.link_type || 'btn-round' === $args.link_type ) {
						$class += $args.link_bg ? ' btn-' + jQuery.escapeSelector( $args.link_bg ) : '';
						if ( 'small' === $args.link_size ) {
							$class += ' btn-sm';
						} else if ( 'large' === $args.link_size ) {
							$class += ' btn-lg';
						}
					}else {
						$class += 'iconbox-fill' === $args.link_type && $args.link_bg ? ' btn-' + jQuery.escapeSelector( $args.link_bg ) : '';
						if ( !$args.link_size || 'small' === $args.link_size ) {
							$class += ' iconsmall';
						} else if ( 'medium' === $args.link_size ) {
							$class += ' iconmedium';
						} else if ( 'large' === $args.link_size ) {
							$class += ' iconlarge';
						}
					}
				}

				if($args.open_with==='external'){
					$class += ' d-none';
				}

				$class += ' ' + sd_build_aui_class($sd_args)



				return $class;
			}



		<?php
		//      return str_replace("\n"," ",ob_get_clean()) ;
		return ob_get_clean();
	}




}//end class

// register it.
add_action(
    'widgets_init',
    function () {
        register_widget('BlockStrap_Widget_Offcanvas');
    }
);

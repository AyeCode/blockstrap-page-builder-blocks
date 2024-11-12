<?php

class BlockStrap_Widget_Nav_Item extends WP_Super_Duper
{

    public $arguments;


    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        $options = [
            'textdomain'        => 'blockstrap',
            'output_types'      => [
                'block',
                'shortcode',
            ],
            'block-icon'        => 'fas fa-link',
            'block-category'    => 'layout',
            'block-keywords'    => "['menu','nav','item']",
            'block-label'       => "attributes.text ? '".__('BS > Nav', 'blockstrap-page-builder-blocks')." ('+ attributes.text+')' : ''",
            'block-supports'    => ['customClassName' => false],
            'block-edit-return' => "el('li', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									className: props.attributes.link_type ? 'nav-item form-inline align-self-center ' + sd_build_aui_class(props.attributes) : 'nav-item ' + sd_build_aui_class(props.attributes) ,
								}))",
            'block-wrap'        => '',
            'class_name'        => __CLASS__,
            'base_id'           => 'bs_nav_item',
            'name'              => __('BS > Nav Item', 'blockstrap-page-builder-blocks'),
            'widget_ops'        => [
                'classname'   => 'bd-nav-item',
                'description' => esc_html__('A navigation item for the navbar.', 'blockstrap-page-builder-blocks'),
            ],
			'parent'		   => array('blockstrap/blockstrap-widget-nav','blockstrap/blockstrap-widget-nav-dropdown'),
			'example'           => [
				'viewportWidth' => 80
			],
            'no_wrap'           => true,
            'block_group_tabs'  => [
                'content'  => [
                    'groups' => [ __('Link', 'blockstrap-page-builder-blocks') ],
                    'tab'    => [
                        'title'     => __('Content', 'blockstrap-page-builder-blocks'),
                        'key'       => 'bs_tab_content',
                        'tabs_open' => true,
                        'open'      => true,
                        'class'     => 'text-center flex-fill d-flex justify-content-center',
                    ],
                ],
                'styles'   => [
                    'groups' => [
                        __('Link styles', 'blockstrap-page-builder-blocks'),
                        __('Typography', 'blockstrap-page-builder-blocks'),
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

        $arguments['type'] = [
            'type'     => 'select',
            'title'    => __('Link Type', 'blockstrap-page-builder-blocks'),
            'options'  => blockstrap_pbb_get_block_link_types(),
            'default'  => 'home',
            'desc_tip' => true,
            'group'    => __('Link', 'blockstrap-page-builder-blocks'),
        ];

        $arguments['page_id'] = [
            'type'            => 'select',
            'title'           => __('Page', 'blockstrap-page-builder-blocks'),
            'options'         => blockstrap_pbb_page_options(false, false ),
            'placeholder'     => __('Select Page', 'blockstrap-page-builder-blocks'),
            'default'         => '',
            'desc_tip'        => true,
            'group'           => __('Link', 'blockstrap-page-builder-blocks'),
            'element_require' => '[%type%]=="page"',
        ];

        $arguments['post_id'] = [
            'type'            => 'number',
            'title'           => __('Post ID', 'blockstrap-page-builder-blocks'),
            'placeholder'     => 123,
            'default'         => '',
            'desc_tip'        => true,
            'group'           => __('Link', 'blockstrap-page-builder-blocks'),
            'element_require' => '[%type%]=="post-id"',
        ];

        $arguments['custom_url'] = [
            'type'            => 'text',
            'title'           => __('Custom URL', 'blockstrap-page-builder-blocks'),
            'desc'            => __('Add custom link URL', 'blockstrap-page-builder-blocks'),
            'placeholder'     => __('https://example.com', 'blockstrap-page-builder-blocks'),
            'default'         => '',
            'desc_tip'        => true,
            'group'           => __('Link', 'blockstrap-page-builder-blocks'),
            'element_require' => '( [%type%]=="custom" || [%type%]=="lightbox" || [%type%]=="offcanvas" )',
        ];

        $arguments['lightbox_notice'] = [
            'type'            => 'notice',
            'desc'            => __('Enter the BS > Contact form ID prefixed by a `#` eg: #contact-form', 'blockstrap-page-builder-blocks'),
            'status'          => 'info',
            'group'           => __('Link', 'blockstrap-page-builder-blocks'),
            'element_require' => '( [%type%]=="lightbox" || [%type%]=="offcanvas" )',
        ];

        $arguments['text'] = [
            'type'        => 'text',
            'title'       => __('Link Text', 'blockstrap-page-builder-blocks'),
            'desc'        => __('Add custom link text or leave blank for dynamic', 'blockstrap-page-builder-blocks'),
            'placeholder' => __('Home', 'blockstrap-page-builder-blocks'),
            'default'     => '',
            'desc_tip'    => true,
            'group'       => __('Link', 'blockstrap-page-builder-blocks'),
        ];

        $arguments['icon_class'] = [
            'type'        => 'text',
            'title'       => __('Icon class', 'blockstrap-page-builder-blocks'),
            'desc'        => __('Enter a font awesome icon class.', 'blockstrap-page-builder-blocks'),
            'placeholder' => __('fas fa-ship', 'blockstrap-page-builder-blocks'),
            'default'     => '',
            'desc_tip'    => true,
            'group'       => __('Link', 'blockstrap-page-builder-blocks'),
        ];

        $arguments['icon_aria_label'] = [
            'type'            => 'text',
            'title'           => __('Aria label', 'blockstrap-page-builder-blocks'),
            'desc'            => __('Describe the link for assistive technologies.', 'blockstrap-page-builder-blocks'),
            'placeholder'     => __('Visit our facebook page', 'blockstrap-page-builder-blocks'),
            'default'         => '',
            'desc_tip'        => true,
            'group'           => __('Link', 'blockstrap-page-builder-blocks'),
            'element_require' => '( [%icon_class%]!="" && [%text%]=="" )',
        ];

		if ( function_exists( 'sd_get_new_window_input' ) ) {
			$arguments['link_new_window'] = sd_get_new_window_input();
			$arguments['link_nofollow']   = sd_get_nofollow_input();
			$arguments['link_attributes'] = sd_get_attributes_input();
		}

        // Link styles.
        $arguments['link_type'] = [
            'type'     => 'select',
            'title'    => __('Link style', 'blockstrap-page-builder-blocks'),
            'options'  => [
                ''             => __('None', 'blockstrap-page-builder-blocks'),
                'btn'          => __('Button', 'blockstrap-page-builder-blocks'),
                'btn-round'    => __('Button rounded', 'blockstrap-page-builder-blocks'),
                'btn-icon'     => __('Button Icon Circle', 'blockstrap-page-builder-blocks'),
                'iconbox'      => __('Iconbox bordered', 'blockstrap-page-builder-blocks'),
                'iconbox-fill' => __('Iconbox filled', 'blockstrap-page-builder-blocks'),
            ],
            'default'  => '',
            'desc_tip' => true,
            'group'    => __('Link styles', 'blockstrap-page-builder-blocks'),
        ];

        $arguments['link_size'] = [
            'type'            => 'select',
            'title'           => __('Size', 'blockstrap-page-builder-blocks'),
            'options'         => [
                ''            => __('Default', 'blockstrap-page-builder-blocks'),
                'extra-small' => __('Extra Small (BS5)', 'blockstrap-page-builder-blocks'),
                'small'       => __('Small', 'blockstrap-page-builder-blocks'),
                'medium'      => __('Medium', 'blockstrap-page-builder-blocks'),
                'large'       => __('Large', 'blockstrap-page-builder-blocks'),
            ],
            'default'         => '',
            'desc_tip'        => true,
            'group'           => __('Link styles', 'blockstrap-page-builder-blocks'),
            'element_require' => '[%link_type%]!=""',
        ];

        $arguments['link_bg'] = [
            'title'           => __('Color', 'blockstrap-page-builder-blocks'),
            'desc'            => __('Select the color.', 'blockstrap-page-builder-blocks'),
            'type'            => 'select',
            'options'         => ([
                '' => __('Custom colors', 'blockstrap-page-builder-blocks'),
            ] + sd_aui_colors(true, true, true, true)),
            'default'         => '',
            'desc_tip'        => true,
            'advanced'        => false,
            'group'           => __('Link styles', 'blockstrap-page-builder-blocks'),
            'element_require' => '[%link_type%]!="iconbox" && [%link_type%]!=""',
        ];

        // padding
        $arguments['link_pt'] = sd_get_padding_input(
            'pt',
            [
                'device_type' => 'Mobile',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );
        $arguments['link_pr'] = sd_get_padding_input(
            'pr',
            [
                'device_type' => 'Mobile',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );
        $arguments['link_pb'] = sd_get_padding_input(
            'pb',
            [
                'device_type' => 'Mobile',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );
        $arguments['link_pl'] = sd_get_padding_input(
            'pl',
            [
                'device_type' => 'Mobile',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );

        // padding tablet
        $arguments['link_pt_md'] = sd_get_padding_input(
            'pt',
            [
                'device_type' => 'Tablet',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );
        $arguments['link_pr_md'] = sd_get_padding_input(
            'pr',
            [
                'device_type' => 'Tablet',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );
        $arguments['link_pb_md'] = sd_get_padding_input(
            'pb',
            [
                'device_type' => 'Tablet',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );
        $arguments['link_pl_md'] = sd_get_padding_input(
            'pl',
            [
                'device_type' => 'Tablet',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );

        // padding desktop
        $arguments['link_pt_lg'] = sd_get_padding_input(
            'pt',
            [
                'device_type' => 'Desktop',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );
        $arguments['link_pr_lg'] = sd_get_padding_input(
            'pr',
            [
                'device_type' => 'Desktop',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );
        $arguments['link_pb_lg'] = sd_get_padding_input(
            'pb',
            [
                'device_type' => 'Desktop',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );
        $arguments['link_pl_lg'] = sd_get_padding_input(
            'pl',
            [
                'device_type' => 'Desktop',
                'group'       => __(
                    'Link styles',
                    'blockstrap-page-builder-blocks'
                ),
            ]
        );

        $arguments['link_divider'] = [
            'type'     => 'select',
            'title'    => __('Link Divider', 'blockstrap-page-builder-blocks'),
            'options'  => [
                ''      => __('None', 'blockstrap-page-builder-blocks'),
                'left'  => __('Left', 'blockstrap-page-builder-blocks'),
                'right' => __('Right', 'blockstrap-page-builder-blocks'),
            ],
            'default'  => '',
            'desc_tip' => true,
            'group'    => __('Link styles', 'blockstrap-page-builder-blocks'),
        ];

        // text color
        $arguments['text_color'] = sd_get_text_color_input();

        // Text justify
        $arguments['text_justify'] = sd_get_text_justify_input();

        // text align
        $arguments['text_align']    = sd_get_text_align_input(
            'text_align',
            [
                'device_type'     => 'Mobile',
                'element_require' => '[%text_justify%]==""',
            ]
        );
        $arguments['text_align_md'] = sd_get_text_align_input(
            'text_align',
            [
                'device_type'     => 'Tablet',
                'element_require' => '[%text_justify%]==""',
            ]
        );
        $arguments['text_align_lg'] = sd_get_text_align_input(
            'text_align',
            [
                'device_type'     => 'Desktop',
                'element_require' => '[%text_justify%]==""',
            ]
        );

        // font weight
        $arguments['font_weight'] = sd_get_font_weight_input();

        // margins mobile
        $arguments['mt'] = sd_get_margin_input('mt', [ 'device_type' => 'Mobile' ]);
        $arguments['mr'] = sd_get_margin_input('mr', [ 'device_type' => 'Mobile' ]);
        $arguments['mb'] = sd_get_margin_input('mb', [ 'device_type' => 'Mobile' ]);
        $arguments['ml'] = sd_get_margin_input('ml', [ 'device_type' => 'Mobile' ]);

        // margins tablet
        $arguments['mt_md'] = sd_get_margin_input('mt', [ 'device_type' => 'Tablet' ]);
        $arguments['mr_md'] = sd_get_margin_input('mr', [ 'device_type' => 'Tablet' ]);
        $arguments['mb_md'] = sd_get_margin_input('mb', [ 'device_type' => 'Tablet' ]);
        $arguments['ml_md'] = sd_get_margin_input('ml', [ 'device_type' => 'Tablet' ]);

        // margins desktop
        $arguments['mt_lg'] = sd_get_margin_input('mt', [ 'device_type' => 'Desktop' ]);
        $arguments['mr_lg'] = sd_get_margin_input('mr', [ 'device_type' => 'Desktop' ]);
        $arguments['mb_lg'] = sd_get_margin_input('mb', [ 'device_type' => 'Desktop' ]);
        $arguments['ml_lg'] = sd_get_margin_input('ml', [ 'device_type' => 'Desktop' ]);

        // padding
        $arguments['pt'] = sd_get_padding_input('pt', [ 'device_type' => 'Mobile' ]);
        $arguments['pr'] = sd_get_padding_input('pr', [ 'device_type' => 'Mobile' ]);
        $arguments['pb'] = sd_get_padding_input('pb', [ 'device_type' => 'Mobile' ]);
        $arguments['pl'] = sd_get_padding_input('pl', [ 'device_type' => 'Mobile' ]);

        // padding tablet
        $arguments['pt_md'] = sd_get_padding_input('pt', [ 'device_type' => 'Tablet' ]);
        $arguments['pr_md'] = sd_get_padding_input('pr', [ 'device_type' => 'Tablet' ]);
        $arguments['pb_md'] = sd_get_padding_input('pb', [ 'device_type' => 'Tablet' ]);
        $arguments['pl_md'] = sd_get_padding_input('pl', [ 'device_type' => 'Tablet' ]);

        // padding desktop
        $arguments['pt_lg'] = sd_get_padding_input('pt', [ 'device_type' => 'Desktop' ]);
        $arguments['pr_lg'] = sd_get_padding_input('pr', [ 'device_type' => 'Desktop' ]);
        $arguments['pb_lg'] = sd_get_padding_input('pb', [ 'device_type' => 'Desktop' ]);
        $arguments['pl_lg'] = sd_get_padding_input('pl', [ 'device_type' => 'Desktop' ]);

        // border
        $arguments['border']       = sd_get_border_input('border');
        $arguments['rounded']      = sd_get_border_input('rounded');
        $arguments['rounded_size'] = sd_get_border_input('rounded_size');

        // shadow
        $arguments['shadow'] = sd_get_shadow_input('shadow');

        // block visibility conditions
        $arguments['visibility_conditions'] = sd_get_visibility_conditions_input();

        $arguments['css_class'] = sd_get_class_input();

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
     * @param string $content     The shortcode content argument
     *
     * @return string
     */
    public function output($args=[], $widget_args=[], $content='')
    {
        global $aui_bs5;

        $content = '';

        $link               = '#';
        $link_text          = '';
        $link_class         = 'nav-link';
        $link_attr          = '';
        $icon_aria_label    = ! empty($args['icon_aria_label']) ? 'aria-label="'.esc_attr($args['icon_aria_label']).'"' : '';
        $icon               = '';
        $link_divider_pos   = ! empty($args['link_divider']) ? esc_attr($args['link_divider']) : '';
        $link_divider_left  = 'left' === $link_divider_pos ? '<span class="navbar-divider d-none d-lg-block position-absolute top-50 start-0 translate-middle-y"></span>' : '';
        $link_divider_right = 'right' === $link_divider_pos ? '<span class="navbar-divider d-none d-lg-block position-absolute top-50 end-0 translate-middle-y"></span>' : '';

        $font_weight = ! empty($args['font_weight']) ? esc_attr($args['font_weight']) : '';
        unset($args['font_weight']);
        // we don't want it on the parent.
        $wrap_class = sd_build_aui_class($args);

		// set link parts
		$link_parts = blockstrap_pbb_get_link_parts( $args, $wrap_class );
//		print_r($link_parts);
		if(!empty($link_parts['link'])){$link = $link_parts['link'];}
		if(!empty($link_parts['text'])){$link_text = $link_parts['text'];}
		if(!empty($link_parts['icon'])){$icon = $link_parts['icon'];}
		if(!empty($link_parts['icon_class'])){$args['icon_class'] = $link_parts['icon_class'];}
		if(!empty($link_parts['link_attr'])){$link_attr = $link_parts['link_attr'];}
		if(!empty($link_parts['wrap_class'])){$wrap_class = $link_parts['wrap_class'];}

       //@todo, function call
        // UWP maybe bail if logged in.
        if (in_array($args['type'], [ 'wp-login', 'uwp_login', 'uwp_register', 'uwp_forgot' ], true)) {
            if (! $this->is_block_content_call() && get_current_user_id()) {
                return '';
            }
        } else if (in_array($args['type'], [ 'wp-logout', 'uwp_account', 'uwp_change_password', 'uwp_profile', 'uwp_logout' ], true)) {
            if (! $this->is_block_content_call() && ! get_current_user_id()) {
                return '';
            }
        }

        // maybe set custom link text if not set dynamically like for location switcher
		if ('gd_location_switcher' === $args['type'] && ( empty($args['text']) || $args['text'] !== $link_parts['text'])) {
			// don't set the text if its dynamic
		}else{
			$link_text = ! empty($args['text']) ? esc_attr($args['text']) : $link_text;
		}

        // link type
        if (! empty($args['link_type'])) {
            if ('btn' === $args['link_type']) {
                $link_class = 'btn';
            } else if ('btn-round' === $args['link_type']) {
                $link_class = 'btn btn-round';
            } else if ('btn-icon' === $args['link_type']) {
                $link_class = 'btn btn-icon rounded-circle';
            } else if ('iconbox' === $args['link_type']) {
                $link_class = 'iconbox rounded-circle';
            } else if ('iconbox-fill' === $args['link_type']) {
                $link_class = 'iconbox fill rounded-circle';
            }

            if ('btn' === $args['link_type'] || 'btn-round' === $args['link_type'] || 'btn-icon' === $args['link_type']) {
                $link_class .= ' btn-'.sanitize_html_class($args['link_bg']);
                if ('small' === $args['link_size']) {
                    $link_class .= ' btn-sm';
                } else if ('extra-small' === $args['link_size']) {
                    $link_class .= ' btn-xs';
                } else if ('large' === $args['link_size']) {
                    $link_class .= ' btn-lg';
                }
            } else {
                $link_class .= 'iconbox-fill' === $args['link_type'] ? ' bg-'.sanitize_html_class($args['link_bg']) : '';
                if (empty($args['link_size']) || 'small' === $args['link_size']) {
                    $link_class .= ' iconsmall';
                } else if ('medium' === $args['link_size']) {
                    $link_class .= ' iconmedium';
                } else if ('large' === $args['link_size']) {
                    $link_class .= ' iconlarge';
                }
            }
        }//end if

        if (! empty($args['text_color'])) {
            $link_class .= $aui_bs5 ? ' link-'.esc_attr($args['text_color']) : ' text-'.esc_attr($args['text_color']);
        }

        // link padding / font weight
        $link_class .= ' '.sd_build_aui_class(
            [
                'pt'          => $args['link_pt'],
                'pt_md'       => $args['link_pt_md'],
                'pt_lg'       => $args['link_pt_lg'],

                'pr'          => $args['link_pr'],
                'pr_md'       => $args['link_pr_md'],
                'pr_lg'       => $args['link_pr_lg'],

                'pb'          => $args['link_pb'],
                'pb_md'       => $args['link_pb_md'],
                'pb_lg'       => $args['link_pb_lg'],

                'pl'          => $args['link_pl'],
                'pl_md'       => $args['link_pl_md'],
                'pl_lg'       => $args['link_pl_lg'],

                'font_weight' => $font_weight,
            ]
        );

		if ('spacer' == $args['type'] && $link_text == '') {
			$link_text = ' '; // we need to trick it to show
		}

        if (! empty($args['icon_class']) && $args['icon_class'] !== ' ') {
            // remove default text if icon exists.
            if (empty($args['text'])) {
                $link_text = '';
            }

            $mr   = $aui_bs5 ? ' me-2' : ' mr-2';
			if(!$icon){
				$icon = ! empty($link_text) ? '<i class="'.esc_attr($args['icon_class']).$mr.'"></i>' : '<i class="'.esc_attr($args['icon_class']).'"></i>';
			}
        }

        // if a button add form-inline
        if (! empty($args['link_type'])) {
            $wrap_class .= $aui_bs5 ? ' align-self-center' : ' form-inline';
        }

		if (!$this->is_preview() && $link && function_exists( 'sd_build_attributes_string_escaped' ) ) {
			$attributes_escaped = sd_build_attributes_string_escaped(
				array(
					'new_window' => ! empty( $args['link_new_window'] ) ? 1 : '',
					'nofollow'   => ! empty( $args['link_nofollow'] ) ? 1 : '',
					'custom'     => ! empty( $args['link_attributes'] ) ? $args['link_attributes'] : array(),
				)
			);

			if ( $attributes_escaped ) {
				$link_attr .= ' ' . $attributes_escaped;
			}
		}

        if ($this->is_block_content_call()) {
            $is_sub = ! empty($_REQUEST['block_parent_name']) && 'blockstrap/blockstrap-widget-nav-dropdown' === $_REQUEST['block_parent_name']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            if ($is_sub) {
                $link_class = str_replace('nav-link', 'dropdown-item', $link_class);
            }

            return $link_text || $icon ? '<a href="#'.esc_url_raw($link).'" class="'.esc_attr($link_class).'" '.$icon_aria_label.$link_attr.'>'.$link_divider_left.$icon.esc_attr($link_text).$link_divider_right.'</a>' : '';
            // shortcode
        } else {

			if ('spacer' == $args['type']) {
				return $link_text || $icon ? '<li class="nav-item '.$wrap_class.'">'.$link_divider_left.$icon.esc_attr($link_text).$link_divider_right.'</li>' : '';

			}
            return $link_text || $icon ? '<li class="nav-item '.$wrap_class.'"><a href="'.esc_url_raw($link).'" class="'.esc_attr($link_class).'" '.$icon_aria_label.$link_attr.'>'.$link_divider_left.$icon.esc_attr($link_text).$link_divider_right.'</a></li>' : '';
            // shortcode
        }

    }//end output()


}//end class

// register it.
add_action(
    'widgets_init',
    function () {
        register_widget('BlockStrap_Widget_Nav_Item');
    }
);

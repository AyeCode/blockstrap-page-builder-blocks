<?php

class BlockStrap_Widget_Accordion extends WP_Super_Duper
{

    public $arguments;


    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
		$aui_settings = is_admin() ? get_option( 'ayecode-ui-settings', array()) : array();
		$aui_settings = apply_filters( 'ayecode-ui-settings', $aui_settings, array(), array() );
        $bs5          = ! empty($aui_settings['bs_ver']) && '5' === $aui_settings['bs_ver'] ? 'bs-' : '';

        $options = [
            'textdomain'       => 'blockstrap',
            'output_types'     => [
                'block',
                'shortcode',
            ],
            'nested-block'     => true,
            'block-icon'       => 'fas fa-bars',
            'block-category'   => 'layout',
            'block-keywords'   => "['accordion','list','content']",
            'block-supports'   => ['customClassName' => false],
			'allowed-blocks'   => array('blockstrap/blockstrap-widget-accordion-item'),
            'block-output'     => [
                [
                    'element'          => 'innerBlocksProps',
                    'blockProps'       => [
                        'if_className' => 'props.attributes.style == "flush" ? "accordion accordion-flush " [%WrapClass%] : "accordion " [%WrapClass%] ',
                        'style'        => '{[%WrapStyle%]}',
                        'if_id'        => 'props.attributes.anchor ? props.attributes.anchor : props.clientId',
                    ],
                    'innerBlocksProps' => [
                        'orientation' => 'vertical',
                        'if_template' => "[
														[ 'blockstrap/blockstrap-widget-accordion-item', {text:'Tab1',anchor:'tab-1'}, [[ 'core/paragraph', { placeholder: 'Add your blocks here' } ],] ],
														[ 'blockstrap/blockstrap-widget-accordion-item', {text:'Tab2',anchor:'tab-2'}, [[ 'core/paragraph', { placeholder: 'Add your blocks here' } ],] ],

													]",
                    ],

                ],
            ],
            'block-wrap'       => '',
            'class_name'       => __CLASS__,
            'base_id'          => 'bs_accordion',
            'name'             => __('BS > Accordion', 'blockstrap-page-builder-blocks'),
            'widget_ops'       => [
                'classname'   => 'bs-accordion',
                'description' => esc_html__('A container for an Accordion list', 'blockstrap-page-builder-blocks'),
            ],
            'no_wrap'          => true,
            'block_group_tabs' => [
                'styles'   => [
                    'groups' => [ __('Accordion', 'blockstrap-page-builder-blocks')],
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

        $arguments['style'] = [
            'type'     => 'select',
            'title'    => __('Style', 'blockstrap-page-builder-blocks'),
            'options'  => [
                ''      => __('Default', 'blockstrap-page-builder-blocks'),
                'flush' => __('Flush', 'blockstrap-page-builder-blocks'),
            ],
            'default'  => '',
            'desc_tip' => true,
            'group'    => __('Accordion', 'blockstrap-page-builder-blocks'),
        ];

        $arguments['collapse'] = [
            'type'     => 'select',
            'title'    => __('Tab click', 'blockstrap-page-builder-blocks'),
            'options'  => [
                ''      => __('Leave other items open', 'blockstrap-page-builder-blocks'),
                'close' => __('Close all other items', 'blockstrap-page-builder-blocks'),
            ],
            'default'  => '',
            'desc_tip' => true,
            'group'    => __('Accordion', 'blockstrap-page-builder-blocks'),
        ];

        $arguments['anchor'] = [
            'type'    => 'text',
            'title'   => __('HTML anchor', 'blockstrap-page-builder-blocks'),
            'default' => '',
            'group'   => __('Accordion', 'blockstrap-page-builder-blocks'),
        ];

        $arguments['anchor_notice'] = [
            'type'            => 'notice',
            'desc'            => __('A unique HTML anchor is required for other items to close.', 'blockstrap-page-builder-blocks'),
            'status'          => 'error',
        // 'warning' | 'success' | 'error' | 'info'
            'group'           => __('Accordion', 'blockstrap-page-builder-blocks'),
            'element_require' => '[%anchor%]=="" && [%collapse%]=="close"',
        ];

        // Text justify
        $arguments['text_justify'] = sd_get_text_justify_input('text_justify', [ 'group' => __('Accordion', 'blockstrap-page-builder-blocks') ]);

        // text align
        $arguments['text_align']    = sd_get_text_align_input(
            'text_align',
            [
                'device_type'     => 'Mobile',
                'element_require' => '[%text_justify%]==""',
                'group'           => __('Accordion', 'blockstrap-page-builder-blocks'),
            ]
        );
        $arguments['text_align_md'] = sd_get_text_align_input(
            'text_align',
            [
                'device_type'     => 'Tablet',
                'element_require' => '[%text_justify%]==""',
                'group'           => __('Accordion', 'blockstrap-page-builder-blocks'),
            ]
        );
        $arguments['text_align_lg'] = sd_get_text_align_input(
            'text_align',
            [
                'device_type'     => 'Desktop',
                'element_require' => '[%text_justify%]==""',
                'group'           => __('Accordion', 'blockstrap-page-builder-blocks'),
            ]
        );

        $arguments['faq_schema'] = [
            'title'    => __('SEO FAQ Schema', 'blockstrap-page-builder-blocks'),
            'desc'     => __('Enable a FAQ Schema for this block.', 'blockstrap-page-builder-blocks'),
            'type'     => 'checkbox',
            'desc_tip' => true,
            'value'    => '1',
            'default'  => 0,
            'advanced' => false,
            'group'    => __('Accordion', 'blockstrap-page-builder-blocks'),
        ];

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
        $arguments['mb_lg'] = sd_get_margin_input(
            'mb',
            [
                'device_type' => 'Desktop',
                'default'     => 3,
            ]
        );
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

        // position
        $arguments['position'] = sd_get_position_class_input('position');

        $arguments['sticky_offset_top']    = sd_get_sticky_offset_input('top');
        $arguments['sticky_offset_bottom'] = sd_get_sticky_offset_input('bottom');

        $arguments['display']    = sd_get_display_input('d', [ 'device_type' => 'Mobile' ]);
        $arguments['display_md'] = sd_get_display_input('d', [ 'device_type' => 'Tablet' ]);
        $arguments['display_lg'] = sd_get_display_input('d', [ 'device_type' => 'Desktop' ]);

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
     * @param string $content     The shortcode content argument.
     *
     * @return string
     */
    public function output($args=[], $widget_args=[], $content='')
    {
        $schema = '';
        if (!empty($args['faq_schema']) && $args['faq_schema'] && !empty($content)) {
            $schema_json = $this->generate_faq_schema($content);
            if ($schema_json) {
                $schema = '<script type="application/ld+json">'.$schema_json.'</script>';
            }
        }

        return $content.$schema;

    }//end output()


    public function generate_faq_schema($html)
    {
        // Create a new DOMDocument instance
        $dom = new DOMDocument();

        // Suppress warnings when loading potentially malformed HTML
        @$dom->loadHTML($html, (LIBXML_NOWARNING | LIBXML_NOERROR));

        // Use DOMXPath to navigate the DOM
        $xpath = new DOMXPath($dom);

        // Base FAQ schema setup
        $faqSchema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => [],
        ];

        // Perform an XPath query to find each accordion item
        $questionNodes = $xpath->query('//div[contains(@class, "accordion-item")]');

        // Ensure that nodes were found before attempting to loop through them
        if ($questionNodes->length > 0) {
            foreach ($questionNodes as $node) {
                // Safely retrieve each question and answer
                $questionNode = $xpath->query('.//button[contains(@class, "accordion-button")]', $node)->item(0);
                $answerNode   = $xpath->query('.//div[contains(@class, "accordion-body")]', $node)->item(0);

                if ($questionNode && $answerNode) {
                    $questionText = trim($questionNode->nodeValue);
                    $answerText   = trim($answerNode->nodeValue);

                    // Append valid questions and answers to the FAQ schema
                    $faqSchema['mainEntity'][] = [
                        '@type'          => 'Question',
                        'name'           => $questionText,
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => $answerText,
                        ],
                    ];
                }
            }
        }//end if

        // bail if nothing found
        if (empty($faqSchema['mainEntity'])) {
            return '';
        }

        // Convert the array to JSON with pretty printing
        return wp_json_encode($faqSchema, (JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    }//end generate_faq_schema()


}//end class

// register it.
add_action(
    'widgets_init',
    function () {
        register_widget('BlockStrap_Widget_Accordion');
    }
);

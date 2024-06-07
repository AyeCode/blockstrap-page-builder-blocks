<?php

class BlockStrap_Widget_Scroll_Top extends WP_Super_Duper
{

    public $arguments;


    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        $options = [
            'textdomain'         => 'blockstrap',
            'output_types'       => [
                'block',
                'shortcode',
            ],
            'block-icon'         => 'fas fa-arrow-up',
            'block-category'     => 'layout',
            'block-keywords'     => "['back','scroll','top']",
            'block-wrap'         => '',
            'block-supports'     => ['customClassName' => false],
            'block-edit-returnx' => "el('span', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									style: {'minHeight': '30px'},
									className: '',
								}))",
            'class_name'         => __CLASS__,
            'base_id'            => 'bs_scroll_top',
            'name'               => __('BS > Scroll Top', 'blockstrap-page-builder-blocks'),
            'widget_ops'         => [
                'classname'   => 'bs-scroll-top',
                'description' => esc_html__('A button for scrolling the website back tot he top of the page.', 'blockstrap-page-builder-blocks'),
            ],
            'example'            => false,
            'no_wrap'            => true,
            'block_group_tabs'   => [
//                'content'  => [
//                    'groups' => [ __('Home Link', 'blockstrap-page-builder-blocks') ],
//                    'tab'    => [
//                        'title'     => __('Content', 'blockstrap-page-builder-blocks'),
//                        'key'       => 'bs_tab_content',
//                        'tabs_open' => true,
//                        'open'      => true,
//                        'class'     => 'text-center flex-fill d-flex justify-content-center',
//                    ],
//                ],
                'styles'   => [
                    'groups' => [
                        __('Background', 'blockstrap-page-builder-blocks'),
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

        $arguments['source_auto_notice'] = [
            'type'   => 'notice',
            'desc'   => __('This should ideally be placed in the site footer so it works on all pages.', 'blockstrap-page-builder-blocks'),
            'status' => 'warning',
            'group'  => __('Typography', 'blockstrap-page-builder-blocks'),
        ];

        $arguments['icon_class'] = [
            'type'        => 'text',
            'title'       => __('Icon Class', 'blockstrap-page-builder-blocks'),
            'desc'        => __('Enter a font awesome icon class.', 'blockstrap-page-builder-blocks'),
            'placeholder' => __('fas fa-arrow-up', 'blockstrap-page-builder-blocks'),
            'default'     => '',
            'desc_tip'    => true,
            'group'       => __('Typography', 'blockstrap-page-builder-blocks'),
        ];

        // Typography
        // icon color
		$arguments['color_class'] = array(
			'type'     => 'select',
			'title'    => __( 'Color', 'blockstrap-page-builder-blocks' ),
			'options'  => sd_aui_colors( true , true, true, true ),
			'default'  => 'outline-primary',
			'desc_tip' => true,
			'group'    => __( 'Typography', 'blockstrap-page-builder-blocks' ),
		);


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

        // shadow
        $arguments['shadow'] = sd_get_shadow_input('shadow');

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
     * @param string $content     The shortcode content argument
     *
     * @return string
     */
    public function output($args=[], $widget_args=[], $content='')
    {
        global $aui_bs5;

        $output = '';

        ob_start();
		$style = $this->is_preview() ? '' : 'display: none !important;';
		$class_btt = $this->is_preview() ? ' d-flex' : ' fixed-bottom';
		$fa_icon = empty( $args['icon_class'] ) ? 'fas fa-arrow-up' : esc_attr( $args['icon_class'] );
		$color_class = empty( $args['color_class'] ) ? 'outline-primary' : esc_attr( $args['color_class'] );
		$wrap_class    = sd_build_aui_class( $args );
        ?>
        <div class="btn btn-<?php esc_attr_e( $color_class ); ?> bs-back-to-top p-0 m-0 rounded-circle c-pointer justify-content-center align-items-center <?php esc_attr_e( $class_btt );?> <?php esc_attr_e($wrap_class);?>" style="<?php esc_attr_e( $style ); ?>bottom: 20px;right: 20px;left: auto;width: 50px; height: 50px;z-index: 1000;">
            <svg class="bs-progress-ring position-absolute p-0 m-0" width="50" height="50" style="min-width: 50px;">
                <circle class="bs-progress-ring__circle" style=" transition: stroke-dasharray 0.3s ease-out, stroke-dashoffset 0.3s ease-out;transform: rotate(-90deg);transform-origin: 50% 50%;" stroke="#007bff" stroke-width="2" fill="transparent" r="23" cx="25" cy="25" />
            </svg>
            <i class="<?php esc_attr_e( $fa_icon );?>"></i>
        </div>
        <?php

		// Extra CSS for admin preview
		if ($this->is_preview()) {
			?>
			<style>
				/* hide the progress */
				.wp-block-blockstrap-blockstrap-widget-scroll-top .bs-progress-ring{
					display: none;
				}

				/* post/page editor */
				.editor-styles-wrapper .wp-block-blockstrap-blockstrap-widget-scroll-top{
					min-height: 0 !important;
					float: right;
					bottom: 20px;
					right: 20px;
				}

				/* editor */
				.block-editor-iframe__body .wp-block-blockstrap-blockstrap-widget-scroll-top{
					min-height: 0 !important;
					position: fixed !important;
					bottom: 20px;
					right: 20px;
				}
			</style>
			<?php
		}
        $output .= ob_get_clean();

		if ($output) {
			add_action( 'wp_footer', array( $this, 'add_js' ) );
		}

        return $output;

    }//end output()

	/**
	 * @return void
	 */
	public function add_js() {
		?>
		<script>
			jQuery(document).ready(function(){
				var backToTop = jQuery('.bs-back-to-top');
				var circle = jQuery('.bs-progress-ring__circle').get(0); // Get the native SVG circle element

				var radius = circle.r.baseVal.value;
				var circumference = radius * 2 * Math.PI;
				circle.style.strokeDasharray = `${circumference} ${circumference}`;
				circle.style.strokeDashoffset = `${circumference}`;

				// Function to update the stroke color based on the button's background color
				function updateStrokeColor() {
					var buttonColor = jQuery('.bs-back-to-top').css('color'); // Fetch the color of the button
					circle.style.stroke = buttonColor; // Set the stroke color of the circle
				}

				jQuery(window).scroll(function() {
					var scrollPercent = jQuery(window).scrollTop() / (jQuery(document).height() - jQuery(window).height());
					var offset = circumference - scrollPercent * circumference;

					circle.style.strokeDashoffset = offset;
					updateStrokeColor(); // Update the stroke color on scroll

					if (jQuery(this).scrollTop() > 50) {
						backToTop.fadeIn().css({"display": "flex"});
					} else {
						backToTop.fadeOut(400, function() {
							// backToTop.attr("style", "display: none !important");
							backToTop.css({"display": "none !important"});
						});
					}
				});

				backToTop.click(function(e) {
					e.preventDefault();
					jQuery('html, body').animate({scrollTop: 0}, 400);
				});

				updateStrokeColor(); // Initial color update when the page loads
			});
		</script>
		<?php
	}


}//end class

// register it.
add_action(
    'widgets_init',
    function () {
        register_widget('BlockStrap_Widget_Scroll_Top');
    }
);

<?php

class BlockStrap_Widget_Rating extends WP_Super_Duper {

	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'       => 'blockstrap',
			'output_types'     => array( 'block', 'shortcode' ),
			'block-icon'       => 'fas fa-star',
			'block-category'   => 'layout',
			'block-keywords'   => "['icon','rating','stars']",
			'block-wrap'       => '',
			'block-supports'   => array(
				'customClassName' => false,
			),
			//          'block-edit-return' => "el('span', wp.blockEditor.useBlockProps({
			//                                  dangerouslySetInnerHTML: {__html: onChangeContent()},
			//                                  style: {'minHeight': '30px'},
			//                                  className: '',
			//                              }))",
			'class_name'       => __CLASS__,
			'base_id'          => 'bs_rating',
			'name'             => __( 'BS > Rating', 'blockstrap-page-builder-blocks' ),
			'widget_ops'       => array(
				'classname'   => 'bs-rating',
				'description' => esc_html__( 'A bootstrap rating icons', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => array(
				'viewportWidth' => 200
			),
			'no_wrap'          => true,
			'block_group_tabs' => array(
				'content'  => array(
					'groups' => array(
						__( 'Rating', 'blockstrap-page-builder-blocks' ),
		//                      __( 'Link', 'blockstrap-page-builder-blocks' )
					),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array( __( 'Icon Style', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['type'] = array(
			'type'     => 'select',
			'title'    => __( 'Type', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''   => 'Custom Rating',
				'gd' => 'GeoDirectory Rating',
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Rating', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['icon_class'] = array(
			'type'        => 'text',
			'title'       => __( 'Icon class', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'fas fa-star', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Rating', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['rating_count'] = array(
			'type'     => 'select',
			'title'    => __( 'Rating Count', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				'1'  => '1',
				'2'  => '2',
				'3'  => '3',
				'4'  => '4',
				'5'  => '5',
				'6'  => '6',
				'7'  => '7',
				'8'  => '8',
				'9'  => '9',
				'10' => '10',
			),
			'default'  => '5',
			'desc_tip' => true,
			'group'    => __( 'Rating', 'blockstrap-page-builder-blocks' ),
		//          'element_require' => '[%type%]==""',
		);

		$arguments['rating_score'] = array(
			'type'            => 'number',
			'title'           => __( 'Rating Percent', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => 80,
			'default'         => 80,
			'desc_tip'        => true,
			'group'           => __( 'Rating', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]==""',
		);

		$arguments['hover_text'] = array(
			'type'        => 'text',
			'title'       => __( 'Hover Text', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'User rated 5/5', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Rating', 'blockstrap-page-builder-blocks' ),
		);

		//      $arguments['link_type'] = array(
		//          'type'     => 'select',
		//          'title'    => __( 'Link Type', 'blockstrap-page-builder-blocks' ),
		//          'options'  => $this->link_types(),
		//          'default'  => 'none',
		//          'desc_tip' => true,
		//          'group'    => __( 'Link', 'blockstrap-page-builder-blocks' ),
		//      );
		//
		//      $arguments['page_id'] = array(
		//          'type'            => 'select',
		//          'title'           => __( 'Page', 'blockstrap-page-builder-blocks' ),
		//          'options'         => blockstrap_pbb_page_options(),
		//          'placeholder'     => __( 'Select Page', 'blockstrap-page-builder-blocks' ),
		//          'default'         => '',
		//          'desc_tip'        => true,
		//          'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
		//          'element_require' => '[%type%]=="page"',
		//      );
		//
		//      $arguments['post_id'] = array(
		//          'type'            => 'number',
		//          'title'           => __( 'Post ID', 'blockstrap-page-builder-blocks' ),
		//          'placeholder'     => 123,
		//          'default'         => '',
		//          'desc_tip'        => true,
		//          'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
		//          'element_require' => '[%type%]=="post-id"',
		//      );
		//
		//      $arguments['custom_url'] = array(
		//          'type'            => 'text',
		//          'title'           => __( 'Custom URL', 'blockstrap-page-builder-blocks' ),
		//          'desc'            => __( 'Add custom link URL', 'blockstrap-page-builder-blocks' ),
		//          'placeholder'     => __( 'https://example.com', 'blockstrap-page-builder-blocks' ),
		//          'default'         => '',
		//          'desc_tip'        => true,
		//          'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
		//          'element_require' => '[%type%]=="custom"',
		//      );

		$arguments = $arguments + sd_get_font_size_input_group(
			'font_size',
			array(
				'group'   => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
				'default' => '',
			),
			array(
				'group' => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// text color
		$arguments = $arguments + sd_get_text_color_input_group(
			'rating_color',
			array(
				'group'   => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
				'title'   => __( 'Rating Color On', 'blockstrap-page-builder-blocks' ),
				'default' => 'orange',
			),
			array(
				'group' => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		$arguments = $arguments + sd_get_text_color_input_group(
			'rating_color_bg',
			array(
				'group'   => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
				'title'   => __( 'Rating Color Off', 'blockstrap-page-builder-blocks' ),
				'default' => 'gray',
			),
			array(
				'group' => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		// icon padding bottom
		$arguments['icon_padding'] = sd_get_padding_input(
			'pb_custom',
			array(
				'title' => __( 'Padding', 'blockstrap-page-builder-blocks' ),
				'group' => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
			)
		);

		$arguments['icon_fw'] = array(
			'type'     => 'checkbox',
			'title'    => __( 'Icon Fixed Width', 'blockstrap-page-builder-blocks' ),
			'default'  => '1',
			'value'    => '1',
			'desc_tip' => false,
			'desc'     => __( 'Some icons may require the fixed width setting.', 'blockstrap-page-builder-blocks' ),
			'group'    => __( 'Icon Style', 'blockstrap-page-builder-blocks' ),
		);

		// background
		$arguments = $arguments + sd_get_background_inputs( 'bg', array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ), array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ), array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ), array( 'group' => __( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ) ) );

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

		$arguments['display']    = sd_get_display_input( 'd', array( 'device_type' => 'Mobile' ) );
		$arguments['display_md'] = sd_get_display_input( 'd', array( 'device_type' => 'Tablet' ) );
		$arguments['display_lg'] = sd_get_display_input( 'd', array( 'device_type' => 'Desktop' ) );

		// Hover animations
		$arguments['hover_animations'] = sd_get_hover_animations_input( 'hover_animations' );

		// block visibility conditions
		$arguments['visibility_conditions'] = sd_get_visibility_conditions_input();

		$arguments['css_class'] = sd_get_class_input();

		if ( function_exists( 'sd_get_custom_name_input' ) ) {
			$arguments['metadata_name'] = sd_get_custom_name_input();
		}

		return $arguments;
	}

	public function link_types() {
		$links = array(
			'home'    => __( 'Home', 'blockstrap-page-builder-blocks' ),
			'none'    => __( 'None (non link)', 'blockstrap-page-builder-blocks' ),
			'page'    => __( 'Page', 'blockstrap-page-builder-blocks' ),
			'post-id' => __( 'Post ID', 'blockstrap-page-builder-blocks' ),
			'custom'  => __( 'Custom URL', 'blockstrap-page-builder-blocks' ),
		);

		if ( defined( 'GEODIRECTORY_VERSION' ) ) {
			$post_types           = function_exists( 'geodir_get_posttypes' ) ? geodir_get_posttypes( 'options-plural' ) : '';
			$links['gd_search']   = __( 'GD Search', 'blockstrap-page-builder-blocks' );
			$links['gd_location'] = __( 'GD Location', 'blockstrap-page-builder-blocks' );
			foreach ( $post_types as $cpt => $cpt_name ) {
				/* translators: Custom Post Type name. */
				$links[ $cpt ] = sprintf( __( '%s (archive)', 'blockstrap-page-builder-blocks' ), $cpt_name );
				/* translators: Custom Post Type name. */
				$links[ 'add_' . $cpt ] = sprintf( __( '%s (add listing)', 'blockstrap-page-builder-blocks' ), $cpt_name );
			}
		}

		return $links;
	}


	/**
	 * Returns the HTML output for a widget.
	 *
	 * @param array $args Optional. Array of arguments for building the widget output. Default empty array.
	 * @param array $widget_args Optional. Array of widget arguments. Default empty array.
	 * @param string $content Optional. Widget content. Default empty string.
	 *
	 * @return string The HTML output for the widget.
	 */
	public function output( $args = array(), $widget_args = array(), $content = '' ) {
		global $gd_post;

		$rating_count = isset( $args['rating_count'] ) ? absint( $args['rating_count'] ) : 5;
		$icon_class   = ! empty( $args['icon_class'] ) ? esc_attr( $args['icon_class'] ) : 'fas fa-star';
		$type         = isset( $args['type'] ) ? esc_attr( $args['type'] ) : '';
		$rating_score = isset( $args['rating_score'] ) ? absint( $args['rating_score'] ) : 80;
		$hover_text   = isset( $args['hover_text'] ) ? esc_attr( trim( $args['hover_text'] ) ) : '';
		$icon_padding = isset( $args['icon_padding'] ) ? absint( $args['icon_padding'] ) : '';
		$icon_fw      = ! empty( $args['icon_fw'] ) ? ' fa-fw' : '';

		$rating_on_class  = '';
		$rating_on_color  = '#ff9900';
		$rating_off_class = '';
		$rating_off_color = '#afafaf';

		// rating on
		if ( isset( $args['rating_color'] ) && 'custom' === $args['rating_color'] ) {
			if ( ! empty( $args['rating_color_custom'] ) ) {
				$rating_on_color = esc_attr( $args['rating_color_custom'] );
			}
		} else {
			$rating_on_class = sd_build_aui_class( array( 'text_color' => $args['rating_color'] ) );
			$rating_on_color = '';
		}

		// rating off
		if ( isset( $args['rating_color_bg'] ) && 'custom' === $args['rating_color_bg'] ) {
			if ( ! empty( $args['rating_color_bg_custom'] ) ) {
				$rating_off_color = esc_attr( $args['rating_color_bg_custom'] );
			}
		} else {
			$rating_off_class = sd_build_aui_class( array( 'text_color' => $args['rating_color_bg'] ) );
			$rating_off_color = '';
		}

		if ( 'gd' === $type && defined( 'GEODIRECTORY_VERSION' ) ) {
			$rating_score = round( ( $gd_post->overall_rating / 5 ) * 100, 3 );
		} else {
		}

		// rating color styles
		$rating_on_color  = $rating_on_color ? 'color:' . esc_attr( $rating_on_color ) . ';' : '';
		$rating_off_color = $rating_off_color ? 'color:' . esc_attr( $rating_off_color ) . ';' : '';

		$wrap_class = sd_build_aui_class( $args );

		$styles  = sd_build_aui_styles( $args );
		$styles .= ' text-wrap:nowrap';

		$icon_padding      = $icon_padding ? ' pe-' . $icon_padding : '';
		$icon_html         = '<i class="' . esc_attr( $icon_class ) . esc_attr( $icon_fw ) . esc_attr( $icon_padding ) . '" aria-hidden="true"></i>';
		$icon_html_escaped = str_repeat( $icon_html, $rating_count );

		ob_start();
		?>
		<span class="blockstrap-rating-wrap c-pointer justify-content-between flex-nowrap w-100 <?php echo esc_attr( $wrap_class ); ?>" style="<?php echo esc_attr( trim( $styles ) ); ?>">
			<span class="bs-rating-wrap d-inline-flex position-relative"<?php echo( $hover_text ? ' data-bs-toggle="tooltip" data-bs-title="' . esc_attr( $hover_text ) . '"' : '' ); ?>>
				<span class="bs-rating-foreground position-absolute text-nowrap overflow-hidden <?php echo esc_attr( $rating_on_class ); ?>" style="width:<?php echo absint( $rating_score ); ?>%;<?php echo esc_attr( $rating_on_color ); ?>">
					<?php echo $icon_html_escaped; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
				<span class="bs-rating-background <?php echo esc_attr( $rating_off_class ); ?>" style="<?php echo esc_attr( $rating_off_color ); ?>">
					<?php echo $icon_html_escaped; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
			</span>
		</span>
		<?php
		return ob_get_clean();
	}
}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Rating' );
	}
);

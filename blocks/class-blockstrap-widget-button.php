<?php

class BlockStrap_Widget_Button extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block', 'shortcode' ),
			'block-icon'        => 'fas fa-stop',
			'block-category'    => 'layout',
			'block-keywords'    => "['button','nav','icon']",
			'block-wrap'        => '',
			'block-supports'    => array(
				'customClassName' => false,
			),
			'block-edit-return' => "el('span', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									style: {'minHeight': '30px'},
									className: '',
								}))",
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_button',
			'name'              => __( 'BS > Button', 'blockstrap-page-builder-blocks' ),
			'widget_ops'        => array(
				'classname'   => 'bs-button',
				'description' => esc_html__( 'A bootstrap button, badge or iconbox.', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array( __( 'Link', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['type'] = array(
			'type'     => 'select',
			'title'    => __( 'Link Type', 'blockstrap-page-builder-blocks' ),
			'options'  => $this->link_types(),
			'default'  => 'home',
			'desc_tip' => true,
			'group'    => __( 'Link', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['page_id'] = array(
			'type'            => 'select',
			'title'           => __( 'Page', 'blockstrap-page-builder-blocks' ),
			'options'         => $this->get_pages_array(),
			'placeholder'     => __( 'Select Page', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="page"',
		);

		$arguments['meta_key'] = defined( 'GEODIRECTORY_VERSION' ) ? array(
			'type'            => 'select',
			'title'           => __( 'Meta Key', 'blockstrap-page-builder-blocks' ),
			'options'         => $this->get_custom_field_keys(),
			'placeholder'     => __( 'Select Key', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="gd_meta"',
		) : array(
			'type'  => 'hidden',
			'group' => __( 'Link', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['post_id'] = array(
			'type'            => 'number',
			'title'           => __( 'Post ID', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => 123,
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="post-id"',
		);

		$arguments['custom_url'] = array(
			'type'            => 'text',
			'title'           => __( 'Custom URL', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Add custom link URL', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'https://example.com', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '( [%type%]=="custom" || [%type%]=="lightbox" )',
		);

		$arguments['lightbox_notice'] = array(
			'type'            => 'notice',
			'desc'            => __( 'Enter the BS > Contact form ID prefixed by a `#` eg: #contact-form', 'blockstrap-page-builder-blocks' ),
			'status'          => 'info',
			'group'           => __( 'Link', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="lightbox"',
		);

		$arguments['text'] = array(
			'type'        => 'text',
			'title'       => __( 'Link Text', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Add custom link text or leave blank for dynamic', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Home', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Link', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['icon_class'] = array(
			'type'        => 'text',
			'title'       => __( 'Icon class', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'fas fa-ship', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Link', 'blockstrap-page-builder-blocks' ),
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
			'element_require' => '[%icon_class%]!=""',
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
			false,
			true
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
			false,
			true
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
		// custom font size
		$arguments['font_size_custom'] = sd_get_font_custom_size_input();

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

		$arguments['display']    = sd_get_display_input( 'd', array( 'device_type' => 'Mobile' ) );
		$arguments['display_md'] = sd_get_display_input( 'd', array( 'device_type' => 'Tablet' ) );
		$arguments['display_lg'] = sd_get_display_input( 'd', array( 'device_type' => 'Desktop' ) );

		// block visibility conditions
		$arguments['visibility_conditions'] = sd_get_visibility_conditions_input();

		$arguments['css_class'] = sd_get_class_input();

		$arguments['styleid'] = array(
			'type'     => 'hidden',
			'title'    => __( 'Style ID', 'blockstrap-page-builder-blocks' ),
			'desc_tip' => true,
			'group'    => __( 'Advanced', 'blockstrap-page-builder-blocks' ),
		);

		return $arguments;
	}

	public function link_types() {
		$links = array(
			'home'     => __( 'Home', 'blockstrap-page-builder-blocks' ),
			'none'     => __( 'None (non link)', 'blockstrap-page-builder-blocks' ),
			'page'     => __( 'Page', 'blockstrap-page-builder-blocks' ),
			'post-id'  => __( 'Post ID', 'blockstrap-page-builder-blocks' ),
			'custom'   => __( 'Custom URL', 'blockstrap-page-builder-blocks' ),
			'lightbox' => __( 'Open Lightbox', 'blockstrap-page-builder-blocks' ), // not implemented yet
		);

		if ( defined( 'GEODIRECTORY_VERSION' ) ) {

			$links['gd_meta']     = __( 'GD Post Meta', 'blockstrap-page-builder-blocks' );
			$post_types           = geodir_get_posttypes( 'options-plural' );
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

	public function get_pages_array() {
		$options = array( '' => __( 'Select Page', 'blockstrap-page-builder-blocks' ) );

		$pages = get_pages();

		if ( ! empty( $pages ) ) {
			foreach ( $pages as $page ) {
				if ( $page->post_title ) {
					$options[ $page->ID ] = esc_attr( $page->post_title );
				}
			}
		}

		return $options;
	}

	/**
	 * Gets an array of custom field keys.
	 *
	 * @return array
	 */
	public function get_custom_field_keys() {
		$fields = geodir_post_custom_fields( '', 'all', 'all', 'none' );
		$keys   = array();
		$keys[] = __( 'Select Key', 'geodirectory' );
		if ( ! empty( $fields ) ) {
			$address = array();
			foreach ( $fields as $field ) {
				$keys[ $field['htmlvar_name'] ] = $field['htmlvar_name'];
			}
		}

		// Advance fields
		$advance_fields = geodir_post_meta_advance_fields();
		if ( ! empty( $advance_fields ) ) {
			foreach ( $advance_fields as $field => $args ) {
				$keys[ $field ] = $field;
			}
		}

		return $keys;
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
		global $aui_bs5,$gd_post;

		//      print_r( $args );
		//      $args['text'] = str_replace("&#039;","'",$args['text']);
		$tag       = 'a';
		$link      = '#';
		$link_text = '';
		$link_attr = '';
		if ( 'none' === $args['type'] ) {
			$tag = 'span';

		} elseif ( 'home' === $args['type'] ) {
			$link      = get_home_url();
			$link_text = __( 'Home', 'blockstrap-page-builder-blocks' );
		} elseif ( 'page' === $args['type'] || 'post-id' === $args['type'] ) {
			$page_id = ! empty( $args['page_id'] ) ? absint( $args['page_id'] ) : 0;
			$post_id = ! empty( $args['post_id'] ) ? absint( $args['post_id'] ) : 0;
			$id      = 'page' === $args['type'] ? $page_id : $post_id;
			if ( $id ) {
				$page = get_post( $id );
				if ( ! empty( $page->post_title ) ) {
					$link      = get_permalink( $id );
					$link_text = esc_attr( $page->post_title );
				}
			}
		} elseif ( 'lightbox' === $args['type'] ) {
			$link      = ! empty( $args['custom_url'] ) ? esc_url_raw( $args['custom_url'] ) : '#';
			$link_text = __( 'Open Lightbox', 'blockstrap-page-builder-blocks' );
			$link_attr = ' data-bs-toggle="modal" ';
		} elseif ( 'custom' === $args['type'] ) {
			$link      = ! empty( $args['custom_url'] ) ? esc_url_raw( $args['custom_url'] ) : '#';
			$link_text = __( 'Custom', 'blockstrap-page-builder-blocks' );
		} elseif ( 'gd_search' === $args['type'] ) {
			$link      = function_exists( 'geodir_search_page_base_url' ) ? geodir_search_page_base_url() : '#';
			$link_text = __( 'Search', 'blockstrap-page-builder-blocks' );
		} elseif ( 'gd_location' === $args['type'] ) {
			$link      = function_exists( 'geodir_location_page_id' ) ? get_permalink( geodir_location_page_id() ) : '#';
			$link_text = __( 'Location', 'blockstrap-page-builder-blocks' );
		} elseif ( 'gd_meta' === $args['type'] ) {
			$meta_key = ! empty( $args['meta_key'] ) ? esc_attr( $args['meta_key'] ) : '';
			$link     = $meta_key && function_exists( 'geodir_location_page_id' ) && isset( $gd_post->ID ) ? geodir_get_post_meta( $gd_post->ID, $meta_key ) : '#';
			if ( empty( $link ) && ! $this->is_preview() ) {
				return '';
			}
			$link_text = __( 'Click here', 'blockstrap-page-builder-blocks' );
		} elseif ( substr( $args['type'], 0, 3 ) === 'gd_' ) {
			$post_types = function_exists( 'geodir_get_posttypes' ) ? geodir_get_posttypes( 'options-plural' ) : '';
			if ( ! empty( $post_types ) ) {
				foreach ( $post_types as $cpt => $cpt_name ) {
					if ( $cpt === $args['type'] ) {
						$link      = get_post_type_archive_link( $cpt );
						$link_text = $cpt_name;
					}
				}
			}
		} elseif ( substr( $args['type'], 0, 7 ) === 'add_gd_' ) {
			$post_types = function_exists( 'geodir_get_posttypes' ) ? geodir_get_posttypes( 'options' ) : '';
			if ( ! empty( $post_types ) ) {
				foreach ( $post_types as $cpt => $cpt_name ) {
					if ( 'add_' . $cpt === $args['type'] ) {
						$link = function_exists( 'geodir_add_listing_page_url' ) ? geodir_add_listing_page_url( $cpt ) : '';
						/* translators: Custom Post Type name. */
						$link_text = sprintf( __( 'Add %s', 'blockstrap-page-builder-blocks' ), $cpt_name );
					}
				}
			}
		}

		// maybe set custom link text
		$link_text = ! empty( $args['text'] ) ? esc_attr( $args['text'] ) : $link_text;

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

		// maybe prefix
		$link = $this->prefix_link( $link );

		$href = 'a' === $tag ? 'href="' . esc_url_raw( $link ) . '"' : '';

		if ( $this->is_preview() ) {
			$href = '';//'href="#"';
		}

		$styles = sd_build_aui_styles( $args );
		$style  = $styles ? 'style="' . $styles . '"' : '';

		$styles = function_exists( 'sd_build_hover_styles' ) ? sd_build_hover_styles( $args, $this->is_preview() ) : '';

		return $link_text || $icon_left || $icon_right ? '<' . esc_attr( $tag ) . ' ' . $style . ' ' . $href . ' class="' . esc_attr( $link_class ) . ' ' . esc_attr( $wrap_class ) . '"' . $link_attr . '>' . $icon_left . esc_attr( $link_text ) . $icon_right . '</' . esc_attr( $tag ) . '> ' . $styles : ''; // shortcode

	}

	/**
	 * Maybe prefix a link if it is a phone number of email.
	 *
	 * @param $link
	 *
	 * @return string
	 */
	public function prefix_link( $link ) {
		// Regular expression pattern for email
		$emailPattern = '/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';

		// Regular expression pattern for phone number (adjust as per your needs)
		// This pattern matches numbers like: (123) 456-7890 or 123-456-7890 or 1234567890 or +31636363634 etc.
		$phonePattern = '/^(\+?\d{1,4}[\s\-]?)?(\(?\d{1,4}\)?[\s\-]?)?[\d\s\-]{7,13}$/';

		if ( preg_match( $emailPattern, $link ) ) {
			return 'mailto:' . $link;
		} elseif ( preg_match( $phonePattern, $link ) ) {
			return 'tel:' . $link;
		} else {
			return $link; // return the original link if it's neither an email nor a phone number
		}
	}


}


// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Button' );
	}
);


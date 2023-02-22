<?php

class BlockStrap_Widget_Nav_Item extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block', 'shortcode' ),
			'block-icon'        => 'fas fa-link',
			'block-category'    => 'layout',
			'block-keywords'    => "['menu','nav','item']",
			'block-label'       => "attributes.text ? '" . __( 'BS > Nav', 'blockstrap' ) . " ('+ attributes.text+')' : ''",
			'block-supports'    => array(
				'customClassName' => false,
			),
			'block-edit-return' => "el('li', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									className: props.attributes.link_type ? 'nav-item form-inline align-self-center ' + sd_build_aui_class(props.attributes) : 'nav-item ' + sd_build_aui_class(props.attributes) ,
								}))",
			'block-wrap'        => '',
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_nav_item',
			'name'              => __( 'BS > Nav Item', 'blockstrap' ),
			'widget_ops'        => array(
				'classname'   => 'bd-nav-item',
				'description' => esc_html__( 'A navigation item for the navbar.', 'blockstrap' ),
			),
			'example'           => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array( __( 'Link', 'blockstrap' ) ),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array( __( 'Link styles', 'blockstrap' ), __( 'Typography', 'blockstrap' ) ),
					'tab'    => array(
						'title'     => __( 'Styles', 'blockstrap' ),
						'key'       => 'bs_tab_styles',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'advanced' => array(
					'groups' => array(
						__( 'Wrapper Styles', 'blockstrap' ),
						__( 'Advanced', 'blockstrap' ),
					),
					'tab'    => array(
						'title'     => __( 'Advanced', 'blockstrap' ),
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

	public function link_types() {
		$links = array(
			'home'    => __( 'Home', 'blockstrap' ),
			'page'    => __( 'Page', 'blockstrap' ),
			'post-id' => __( 'Post ID', 'blockstrap' ),
			'wp-login' => __( 'WP Login (logged out)', 'blockstrap' ),
			'wp-logout' => __( 'WP Logout (logged in)', 'blockstrap' ),
			'custom'  => __( 'Custom URL', 'blockstrap' ),
		);

		if ( defined( 'GEODIRECTORY_VERSION' ) ) {
			$post_types           = function_exists( 'geodir_get_posttypes' ) ? geodir_get_posttypes( 'options-plural' ) : array();
			$links['gd_search']   = __( 'GD Search', 'blockstrap' );
			$links['gd_location'] = __( 'GD Location', 'blockstrap' );
			foreach ( $post_types as $cpt => $cpt_name ) {
				/* translators: Custom Post Type name. */
				$links[ $cpt ] = sprintf( __( '%s (archive)', 'blockstrap' ), $cpt_name );
				/* translators: Custom Post Type name. */
				$links[ 'add_' . $cpt ] = sprintf( __( '%s (add listing)', 'blockstrap' ), $cpt_name );
			}
		}

		if ( defined( 'GEODIRLOCATION_VERSION' ) ) {
			$links['gd_location_switcher'] = __( 'GD Location Switcher', 'blockstrap' );
		}

		if ( defined( 'USERSWP_VERSION' ) ) {
			// logged out
			$links['uwp_login']    = __( 'UWP Login (logged out)', 'blockstrap' );
			$links['uwp_register'] = __( 'UWP Register (logged out)', 'blockstrap' );
			$links['uwp_forgot']   = __( 'UWP Forgot Password? (logged out)', 'blockstrap' );

			// logged in
			$links['uwp_account']         = __( 'Account (logged in)', 'blockstrap' );
			$links['uwp_change_password'] = __( 'Change Password (logged in)', 'blockstrap' );
			$links['uwp_profile']         = __( 'Profile (logged in)', 'blockstrap' );
			$links['uwp_logout']          = __( 'Log out (logged in)', 'blockstrap' );
		}

		$links['spacer'] = __( 'spacer (non link)', 'blockstrap' );

		return $links;
	}

	public function get_pages_array() {
		$options = array( '' => __( 'Select Page', 'blockstrap' ) );

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
	 * Set the arguments later.
	 *
	 * @return array
	 */
	public function set_arguments() {

		$arguments = array();

		$arguments['type'] = array(
			'type'     => 'select',
			'title'    => __( 'Link Type', 'blockstrap' ),
			'options'  => $this->link_types(),
			'default'  => 'home',
			'desc_tip' => true,
			'group'    => __( 'Link', 'blockstrap' ),
		);

		$arguments['page_id'] = array(
			'type'            => 'select',
			'title'           => __( 'Page', 'blockstrap' ),
			'options'         => $this->get_pages_array(),
			'placeholder'     => __( 'Select Page', 'blockstrap' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap' ),
			'element_require' => '[%type%]=="page"',
		);

		$arguments['post_id'] = array(
			'type'            => 'number',
			'title'           => __( 'Post ID', 'blockstrap' ),
			'placeholder'     => 123,
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap' ),
			'element_require' => '[%type%]=="post-id"',
		);

		$arguments['custom_url'] = array(
			'type'            => 'text',
			'title'           => __( 'Custom URL', 'blockstrap' ),
			'desc'            => __( 'Add custom link URL', 'blockstrap' ),
			'placeholder'     => __( 'https://example.com', 'blockstrap' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link', 'blockstrap' ),
			'element_require' => '[%type%]=="custom"',
		);

		$arguments['text'] = array(
			'type'        => 'text',
			'title'       => __( 'Link Text', 'blockstrap' ),
			'desc'        => __( 'Add custom link text or leave blank for dynamic', 'blockstrap' ),
			'placeholder' => __( 'Home', 'blockstrap' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Link', 'blockstrap' ),
		);

		$arguments['icon_class'] = array(
			'type'        => 'text',
			'title'       => __( 'Icon class', 'blockstrap' ),
			'desc'        => __( 'Enter a font awesome icon class.', 'blockstrap' ),
			'placeholder' => __( 'fas fa-ship', 'blockstrap' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Link', 'blockstrap' ),
		);

		// link styles
		$arguments['link_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Link style', 'blockstrap' ),
			'options'  => array(
				''             => __( 'None', 'blockstrap' ),
				'btn'          => __( 'Button', 'blockstrap' ),
				'btn-round'    => __( 'Button rounded', 'blockstrap' ),
				'btn-icon'     => __( 'Button Icon Circle', 'blockstrap' ),
				'iconbox'      => __( 'Iconbox bordered', 'blockstrap' ),
				'iconbox-fill' => __( 'Iconbox filled', 'blockstrap' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Link styles', 'blockstrap' ),
		);

		$arguments['link_size'] = array(
			'type'            => 'select',
			'title'           => __( 'Size', 'blockstrap' ),
			'options'         => array(
				''            => __( 'Default', 'blockstrap' ),
				'extra-small' => __( 'Extra Small (BS5)', 'blockstrap' ),
				'small'       => __( 'Small', 'blockstrap' ),
				'medium'      => __( 'Medium', 'blockstrap' ),
				'large'       => __( 'Large', 'blockstrap' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link styles', 'blockstrap' ),
			'element_require' => '[%link_type%]!=""',
		);

		$arguments['link_bg'] = array(
			'title'           => __( 'Color', 'blockstrap' ),
			'desc'            => __( 'Select the color.', 'blockstrap' ),
			'type'            => 'select',
			'options'         => array(
				'' => __( 'Custom colors', 'blockstrap' ),
			) + sd_aui_colors( true, true, true, true ),
			'default'         => '',
			'desc_tip'        => true,
			'advanced'        => false,
			'group'           => __( 'Link styles', 'blockstrap' ),
			'element_require' => '[%link_type%]!="iconbox" && [%link_type%]!=""',
		);

		// padding
		$arguments['link_pt'] = sd_get_padding_input(
			'pt',
			array(
				'device_type' => 'Mobile',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);
		$arguments['link_pr'] = sd_get_padding_input(
			'pr',
			array(
				'device_type' => 'Mobile',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);
		$arguments['link_pb'] = sd_get_padding_input(
			'pb',
			array(
				'device_type' => 'Mobile',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);
		$arguments['link_pl'] = sd_get_padding_input(
			'pl',
			array(
				'device_type' => 'Mobile',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);

		// padding tablet
		$arguments['link_pt_md'] = sd_get_padding_input(
			'pt',
			array(
				'device_type' => 'Tablet',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);
		$arguments['link_pr_md'] = sd_get_padding_input(
			'pr',
			array(
				'device_type' => 'Tablet',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);
		$arguments['link_pb_md'] = sd_get_padding_input(
			'pb',
			array(
				'device_type' => 'Tablet',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);
		$arguments['link_pl_md'] = sd_get_padding_input(
			'pl',
			array(
				'device_type' => 'Tablet',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);

		// padding desktop
		$arguments['link_pt_lg'] = sd_get_padding_input(
			'pt',
			array(
				'device_type' => 'Desktop',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);
		$arguments['link_pr_lg'] = sd_get_padding_input(
			'pr',
			array(
				'device_type' => 'Desktop',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);
		$arguments['link_pb_lg'] = sd_get_padding_input(
			'pb',
			array(
				'device_type' => 'Desktop',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);
		$arguments['link_pl_lg'] = sd_get_padding_input(
			'pl',
			array(
				'device_type' => 'Desktop',
				'group'       => __(
					'Link styles',
					'blockstrap'
				),
			)
		);

		$arguments['link_divider'] = array(
			'type'     => 'select',
			'title'    => __( 'Link Divider', 'blockstrap' ),
			'options'  => array(
				''      => __( 'None', 'blockstrap' ),
				'left'  => __( 'Left', 'blockstrap' ),
				'right' => __( 'Right', 'blockstrap' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Link styles', 'blockstrap' ),
		);

		// text color
		$arguments['text_color'] = sd_get_text_color_input();

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

		// font weight
		$arguments['font_weight'] = sd_get_font_weight_input();

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

		$content = '';

		$link               = '#';
		$link_text          = '';
		$link_class         = 'nav-link';
		$icon               = '';
		$link_divider_pos   = ! empty( $args['link_divider'] ) ? esc_attr( $args['link_divider'] ) : '';
		$link_divider_left  = 'left' === $link_divider_pos ? '<span class="navbar-divider d-none d-lg-block position-absolute top-50 start-0 translate-middle-y"></span>' : '';
		$link_divider_right = 'right' === $link_divider_pos ? '<span class="navbar-divider d-none d-lg-block position-absolute top-50 end-0 translate-middle-y"></span>' : '';

		$font_weight = ! empty( $args['font_weight'] ) ? esc_attr( $args['font_weight'] ) : '';
		unset( $args['font_weight'] ); // we don't want it on the parent.

		$wrap_class = sd_build_aui_class( $args );
		if ( 'spacer' === $args['type'] ) {
			return '<li class="nav-item ' . $wrap_class . '"></li>';
		} elseif ( 'home' === $args['type'] ) {
			$link      = get_home_url();
			$link_text = __( 'Home', 'blockstrap' );
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
		} elseif ( 'wp-login' === $args['type'] ) {
			$icon      = 'far fa-user';
			$link      = esc_url( wp_login_url( get_permalink() ) );
			$link_text = __( 'Sign in', 'blockstrap' );
		} elseif ( 'wp-logout' === $args['type'] ) {
			$icon      = 'fas fa-sign-out-alt';
			$link      = esc_url( wp_logout_url( get_permalink() ) );
			$link_text = __( 'Sign out', 'blockstrap' );
		} elseif ( 'custom' === $args['type'] ) {
			$link      = ! empty( $args['custom_url'] ) ? esc_url_raw( $args['custom_url'] ) : '#';
			$link_text = __( 'Custom', 'blockstrap' );
		} elseif ( 'gd_search' === $args['type'] ) {
			$link      = function_exists( 'geodir_search_page_base_url' ) ? geodir_search_page_base_url() : '';
			$link_text = __( 'Search', 'blockstrap' );
		} elseif ( 'gd_location' === $args['type'] ) {
			$link      = function_exists( 'geodir_location_page_id' ) ? get_permalink( geodir_location_page_id() ) : '';
			$link_text = __( 'Location', 'blockstrap' );
		} elseif ( 'gd_location_switcher' === $args['type'] ) {
			global $geodirectory;
			$location_name = __( 'Set Locationx', 'blockstrap' );
			$location_set  = true;

			//          print_r($geodirectory->location);
			if ( ! empty( $geodirectory->location->neighbourhood ) ) {
				$location_name = $geodirectory->location->neighbourhood;} elseif ( ! empty( $geodirectory->location->city ) ) {
				$location_name = $geodirectory->location->city;} elseif ( ! empty( $geodirectory->location->region ) ) {
					$location_name = $geodirectory->location->region;} elseif ( ! empty( $geodirectory->location->country ) ) {
					$location_name = __( $geodirectory->location->country, 'geodirectory' );} else {
							$location_set = false;
					}
					if ( $location_set ) {
						$icon_class         = ! empty( $args['icon_class'] ) ? esc_attr( $args['icon_class'] ) : 'fas fa-map-marker-alt fa-lg text-primary';
						$icon               = '<span class="hover-swap gdlmls-menu-icon"><i class="' . $icon_class . ' hover-content-original"></i><i class="fas fa-times hover-content c-pointer" title="' . __( 'Clear Location', 'geodirlocation' ) . '" data-toggle="tooltip"></i></span> ';
						$args['icon_class'] = '';
						$args['text']       = esc_attr( $location_name );
					}

					$link      = '#location-switcher';
					$link_text = esc_attr( $location_name );
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
						$link_text = sprintf( __( 'Add %s', 'blockstrap' ), $cpt_name );
					}
				}
			}
		} elseif ( 'uwp_login' === $args['type'] ) {
			$link        = function_exists( 'uwp_get_login_page_url' ) ? uwp_get_login_page_url() : '';
			$link_text   = __( 'Login', 'blockstrap' );
			$wrap_class .= ' uwp-login-link';
		} elseif ( 'uwp_register' === $args['type'] ) {
			$link        = function_exists( 'uwp_get_register_page_url' ) ? uwp_get_register_page_url() : '';
			$link_text   = __( 'Register', 'blockstrap' );
			$wrap_class .= ' uwp-register-link';
		} elseif ( 'uwp_forgot' === $args['type'] ) {
			$link        = function_exists( 'uwp_get_forgot_page_url' ) ? uwp_get_forgot_page_url() : '';
			$link_text   = __( 'Forgot Password', 'blockstrap' );
			$wrap_class .= ' uwp-forgot-password-link';
		} elseif ( 'uwp_account' === $args['type'] ) {
			$link      = function_exists( 'uwp_get_account_page_url' ) ? uwp_get_account_page_url() : '';
			$link_text = __( 'Account', 'blockstrap' );
		} elseif ( 'uwp_change_password' === $args['type'] ) {
			$link      = function_exists( 'uwp_get_change_page_url' ) ? uwp_get_change_page_url() : '';
			$link_text = __( 'Change password', 'blockstrap' );
		} elseif ( 'uwp_profile' === $args['type'] ) {
			$link      = function_exists( 'uwp_get_profile_page_url' ) ? uwp_get_profile_page_url() : '';
			$link_text = __( 'Profile', 'blockstrap' );
		} elseif ( 'uwp_logout' === $args['type'] ) {
			$link      = wp_logout_url( get_permalink() );
			$link_text = __( 'Log out', 'blockstrap' );
		}

		// UWP maybe bail if logged in.
		if ( in_array( $args['type'], array( 'wp-login', 'uwp_login', 'uwp_register', 'uwp_forgot' ), true ) ) {
			if ( ! $this->is_block_content_call() && get_current_user_id() ) {
				return '';
			}
		} elseif ( in_array( $args['type'], array( 'wp-logout', 'uwp_account', 'uwp_change_password', 'uwp_profile', 'uwp_logout' ), true ) ) {
			if ( ! $this->is_block_content_call() && ! get_current_user_id() ) {
				return '';
			}
		}

		// maybe set custom link text
		$link_text = ! empty( $args['text'] ) ? esc_attr( $args['text'] ) : $link_text;

		// link type
		if ( ! empty( $args['link_type'] ) ) {

			if ( 'btn' === $args['link_type'] ) {
				$link_class = 'btn';
			} elseif ( 'btn-round' === $args['link_type'] ) {
				$link_class = 'btn btn-round';
			} elseif ( 'btn-icon' === $args['link_type'] ) {
				$link_class = 'btn btn-icon rounded-circle';
			} elseif ( 'iconbox' === $args['link_type'] ) {
				$link_class = 'iconbox rounded-circle';
			} elseif ( 'iconbox-fill' === $args['link_type'] ) {
				$link_class = 'iconbox fill rounded-circle';
			}

			if ( 'btn' === $args['link_type'] || 'btn-round' === $args['link_type'] || 'btn-icon' === $args['link_type'] ) {
				$link_class .= ' btn-' . sanitize_html_class( $args['link_bg'] );
				if ( 'small' === $args['link_size'] ) {
					$link_class .= ' btn-sm';
				} elseif ( 'extra-small' === $args['link_size'] ) {
					$link_class .= ' btn-xs';
				} elseif ( 'large' === $args['link_size'] ) {
					$link_class .= ' btn-lg';
				}
			} else {
				$link_class .= 'iconbox-fill' === $args['link_type'] ? ' bg-' . sanitize_html_class( $args['link_bg'] ) : '';
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
			$link_class .= $aui_bs5 ? ' link-' . esc_attr( $args['text_color'] ) : ' text-' . esc_attr( $args['text_color'] );
		}

		// link padding / font weight
		$link_class .= ' ' . sd_build_aui_class(
			array(
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
			)
		);

		if ( ! empty( $args['icon_class'] ) ) {
			// remove default text if icon exists.
			if ( empty( $args['text'] ) ) {
				$link_text = '';
			}
			$mr   = $aui_bs5 ? ' me-2' : ' mr-2';
			$icon = ! empty( $link_text ) ? '<i class="' . esc_attr( $args['icon_class'] ) . $mr . '"></i>' : '<i class="' . esc_attr( $args['icon_class'] ) . '"></i>';

		}

		// if a button add form-inline
		if ( ! empty( $args['link_type'] ) ) {
			$wrap_class .= $aui_bs5 ? ' align-self-center' : ' form-inline';
		}

		if ( $this->is_block_content_call() ) {
			$is_sub = ! empty( $_REQUEST['block_parent_name'] ) && 'blockstrap/blockstrap-widget-nav-dropdown' === $_REQUEST['block_parent_name']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( $is_sub ) {
				$link_class = str_replace( 'nav-link', 'dropdown-item', $link_class );
			}
			return $link_text || $icon ? '<a href="#' . esc_url_raw( $link ) . '" class="' . esc_attr( $link_class ) . '">' . $link_divider_left . $icon . esc_attr( $link_text ) . $link_divider_right . '</a>' : ''; // shortcode

		} else {
			return $link_text || $icon ? '<li class="nav-item ' . $wrap_class . '"><a href="' . esc_url_raw( $link ) . '" class="' . esc_attr( $link_class ) . '">' . $link_divider_left . $icon . esc_attr( $link_text ) . $link_divider_right . '</a></li>' : ''; // shortcode

		}

	}

}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Nav_Item' );
	}
);


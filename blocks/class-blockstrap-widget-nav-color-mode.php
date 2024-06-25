<?php

class BlockStrap_Widget_Nav_Color_Mode extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'       => 'blockstrap',
			'output_types'     => array( 'block', 'shortcode' ),
			//'nested-block'     => true,
			'block-icon'       => 'fas fa-moon',
			'block-category'   => 'layout',
			'block-keywords'   => "['menu','nav','mode','color','colour']",
//			'block-label'      => "attributes.text ? '" . __( 'BS > Color Mode', 'blockstrap-page-builder-blocks' ) . " ('+ attributes.text+')' : ''",
			'block-supports'   => array(
				'customClassName' => false,
			),
			'parent'		   => array('blockstrap/blockstrap-widget-nav'),
			'block-outputx'     => array(
				array(
					'element'       => 'BlocksProps',
					'inner_element' => 'li',
					'if_className'  => 'props.attributes.link_type !== undefined ? "nav-item dropdown form-inline " [%WrapClass%] : "nav-item dropdown " [%WrapClass%]',
					'style'         => '{[%WrapStyle%]}',
					array(
						'element'                    => 'a',
						'if_className'               => '"dropdown-toggle nav-link " + bs_build_nav_dropdown_class(props.attributes)',
						'href'                       => '#',
						'if_dangerouslySetInnerHTML' => '{__html: bs_build_nav_dropdown_html(props.attributes)}',
						'roll'                       => 'button',
						'\'data-toggle\''            => 'dropdown',
						'\'aria-expanded\''          => 'false',
					),
					array(
						'element'          => 'innerBlocksProps',
						'inner_element'    => 'ul',
						'blockProps'       => array(
							'className' => 'dropdown-menu',
						),
						'innerBlocksProps' => array(
							'orientation' => 'horizontal',
						),
					),

				),
			),
			'block-wrap'       => '',
			'class_name'       => __CLASS__,
			'base_id'          => 'bs_nav_color_mode',
			'name'             => __( 'BS > Color Mode', 'blockstrap-page-builder-blocks' ),
			'widget_ops'       => array(
				'classname'   => 'bd-nav-color-mode',
				'description' => esc_html__( 'A color mode switcher.', 'blockstrap-page-builder-blocks' ),
			),
			'example'          => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'          => true,
			'block_group_tabs' => array(
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
					'groups' => array( __( 'Link styles', 'blockstrap-page-builder-blocks' ), __( 'Typography', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Styles', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_styles',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'advanced' => array(
					'groups' => array(
						__( 'Wrapper Styles', 'blockstrap-page-builder-blocks' ),
						__( 'Advanced', 'blockstrap-page-builder-blocks' ),
					),
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

		// link styles
		$arguments['link_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Link style', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''             => __( 'None', 'blockstrap-page-builder-blocks' ),
				'btn'          => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'btn-round'    => __( 'Button rounded', 'blockstrap-page-builder-blocks' ),
				'iconbox'      => __( 'Iconbox bordered', 'blockstrap-page-builder-blocks' ),
				'iconbox-fill' => __( 'Iconbox filled', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Link styles', 'blockstrap-page-builder-blocks' ),
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
			'group'    => __( 'Link styles', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%link_type%]!=""',
		);

		$arguments['link_bg'] = array(
			'title'           => __( 'Color', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Select the color.', 'blockstrap-page-builder-blocks' ),
			'type'            => 'select',
			'options'         => array(
				'' => __( 'Custom colors', 'blockstrap-page-builder-blocks' ),
			) + sd_aui_colors( true, true, true ),
			'default'         => '',
			'desc_tip'        => true,
			'advanced'        => false,
			'group'           => __( 'Link styles', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%link_type%]!="iconbox" && [%link_type%]!=""',
		);

		$arguments['link_divider'] = array(
			'type'     => 'select',
			'title'    => __( 'Link Divider', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''      => __( 'None', 'blockstrap-page-builder-blocks' ),
				'left'  => __( 'Left', 'blockstrap-page-builder-blocks' ),
				'right' => __( 'Right', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Link styles', 'blockstrap-page-builder-blocks' ),
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

		ob_start();
		?>
		<li class="nav-item dropdown">
			<a class="btnx btn-linkx nav-link py-2x px-0 px-lg-2x dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (light)">
				<i class="fas fa-sun theme-icon-active"></i>
				<span class="d-lg-none ms-2" id="bd-theme-text">Toggle theme</span>
			</a>
			<ul class="dropdown-menu dropdown-menu-end dropdown-caret-0 border-0" aria-labelledby="bd-theme-text">
				<li>
					<a href="#sun-fill" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light" aria-pressed="true">
						<i class="fas fa-sun me-2 opacity-50"></i>
						Light
						<i class="fas fa-check ms-auto d-none"></i>
					</a>
				</li>
				<li>
					<a href="#moon-stars-fill" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
						<i class="fas fa-moon me-2 opacity-50"></i>
						Dark
						<i class="fas fa-check ms-auto d-none"></i>
					</a>
				</li>
				<li>
					<a href="#circle-half" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="false">
						<i class="fas fa-adjust me-2 opacity-50"></i>
						Auto
						<i class="fas fa-check ms-auto d-none"></i>
					</a>
				</li>
			</ul>
		</li>




		<script>
			/*!
	 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
	 * Copyright 2011-2024 The Bootstrap Authors
	 * Licensed under the Creative Commons Attribution 3.0 Unported License.
	 */

			(() => {
				'use strict'

				const getStoredTheme = () => localStorage.getItem('theme')
				const setStoredTheme = theme => localStorage.setItem('theme', theme)

				const getPreferredTheme = () => {
					const storedTheme = getStoredTheme()
					if (storedTheme) {
						return storedTheme
					}

					return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
				}

				const setTheme = theme => {
					if (theme === 'auto') {
						document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'))
					} else {
						document.documentElement.setAttribute('data-bs-theme', theme)
					}
				}

				setTheme(getPreferredTheme())

				const showActiveTheme = (theme, focus = false) => {
					const themeSwitcher = document.querySelector('#bd-theme')

					if (!themeSwitcher) {
						return
					}

					const themeSwitcherText = document.querySelector('#bd-theme-text')
					const activeThemeIcon = document.querySelector('.theme-icon-active')
					const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
					const iconOfActiveBtnClass = btnToActive.querySelector('i').className

					document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
						element.classList.remove('active')
						element.setAttribute('aria-pressed', 'false')
					})

					btnToActive.classList.add('active')
					btnToActive.setAttribute('aria-pressed', 'true')
					activeThemeIcon.className = `fas ${iconOfActiveBtnClass.split(' ')[1]} my-1 theme-icon-active`
					const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`
					themeSwitcher.setAttribute('aria-label', themeSwitcherLabel)

					if (focus) {
						themeSwitcher.focus()
					}
				}

				window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
					const storedTheme = getStoredTheme()
					if (storedTheme !== 'light' && storedTheme !== 'dark') {
						setTheme(getPreferredTheme())
					}
				})

				window.addEventListener('DOMContentLoaded', () => {
					showActiveTheme(getPreferredTheme())

					document.querySelectorAll('[data-bs-theme-value]')
						.forEach(toggle => {
							toggle.addEventListener('click', () => {
								const theme = toggle.getAttribute('data-bs-theme-value')
								setStoredTheme(theme)
								setTheme(theme)
								showActiveTheme(theme, true)
							})
						})
				})
			})()

		</script>
		<?php

		return ob_get_clean();

		if ( ! empty( $content ) ) {
			$content = str_replace( '"nav-link', '"dropdown-item', $content );
		}
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

			function bs_build_nav_dropdown_html($args) {
				let $html = ''

				let $icon = '';
				if ( $args.icon_class !== undefined && $args.icon_class ) {
					$icon = $args['text'] !== undefined && $args['text'] ? '<i class="' + $args.icon_class + ' mr-2 me-2"></i>' : '<i class="' + $args.icon_class + '"></i>';
				}

				let $link_divider_pos   = $args.icon_class !== undefined && $args.icon_class ? $args.link_divider : '';
				let $link_divider_left  = 'left' === $link_divider_pos ? '<span class="navbar-divider d-none d-lg-block position-absolute top-50 start-0 translate-middle-y"></span>' : '';
				let $link_divider_right = 'right' === $link_divider_pos ? '<span class="navbar-divider d-none d-lg-block position-absolute top-50 end-0 translate-middle-y"></span>' : '';

				$html = $link_divider_left + $icon + $args['text'] + $link_divider_right ;

				return $html;
			}
			function bs_build_nav_dropdown_class($args) {

				let $link_class = '';

				$link_class = 'nav-link';

				if ( $args.link_type !== undefined ) {

					if ( 'btn' === $args.link_type ) {
						$link_class = 'btn';
					} else if ( 'btn-round' === $args.link_type ) {
						$link_class = 'btn btn-round';
					} else if ( 'iconbox' === $args.link_type ) {
						$link_class = 'iconbox rounded-circle';
					} else if ( 'iconbox-fill' === $args.link_type ) {
						$link_class = 'iconbox fill rounded-circle';
					}

					if ( 'btn' === $args.link_type || 'btn-round' === $args.link_type ) {
						$link_class += ' btn-' + $args.link_bg;
						if ( 'small' === $args.link_size ) {
							$link_class += ' btn-sm';
						} else if ( 'large' === $args.link_size ) {
							$link_class += ' btn-lg';
						}
					} else {
						$link_class += 'iconbox-fill' === $args.link_type ? ' bg-' + $args.link_bg : '';
						if ( $args.link_size === undefined || 'small' === $args.link_size ) {
							$link_class += ' iconsmall';
						} else if ( 'medium' === $args.link_size ) {
							$link_class += ' iconmedium';
						} else if ( 'large' === $args.link_size ) {
							$link_class += ' iconlarge';
						}
					}
				}

				if ( $args.text_color !== undefined ) {
					$link_class += ' text-' + $args.text_color ;
				}


				return $link_class;
			}


		<?php
		//      return str_replace("\n"," ",ob_get_clean()) ;
		return ob_get_clean();
	}

}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Nav_Color_Mode' );
	}
);


<?php

class BlockStrap_Widget_Dark_Mode extends WP_Super_Duper {


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
			'block-keywords'   => "['menu','nav','mode','color','colour','dark']",
//			'block-label'      => "attributes.text ? '" . __( 'BS > Color Mode', 'blockstrap-page-builder-blocks' ) . " ('+ attributes.text+')' : ''",
			'block-supports'   => array(
				'customClassName' => false,
			),
			'block-wrap'       => '',
			'class_name'       => __CLASS__,
			'base_id'          => 'bs_dark_mode',
			'name'             => __( 'BS > Dark Mode', 'blockstrap-page-builder-blocks' ),
			'widget_ops'       => array(
				'classname'   => 'bs-dark-mode',
				'description' => esc_html__( 'A dark/light mode switcher.', 'blockstrap-page-builder-blocks' ),
			),
			'example'          => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'          => true,
			'block_group_tabs' => array(
				'content'  => array(
					'groups' => array( __( 'Button', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array( __( 'Button styles', 'blockstrap-page-builder-blocks' ), __( 'Typography', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['type'] = array(
			'type'     => 'select',
			'title'    => __( 'Type', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''             => __( 'Button (stand alone)', 'blockstrap-page-builder-blocks' ),
				'nav-item'          => __( 'Nav item (for use in Nav Menu)', 'blockstrap-page-builder-blocks' ),
				'nav-dropdown'    => __( 'Nav Dropdown (for use in Nav Menu)', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Button', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['hover_text'] = array(
			'type'        => 'text',
			'title'       => __( 'Button Hover Text', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Add custom hover text', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Toggle dark mode', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Button', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['icon_light'] = array(
			'type'        => 'text',
			'title'       => __( 'Icon light class', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'fa-solid fa-sun', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Button', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['icon_dark'] = array(
			'type'        => 'text',
			'title'       => __( 'Icon dark class', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'fa-solid fa-moon', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Button', 'blockstrap-page-builder-blocks' ),
		);

		// Button styles
		$arguments['link_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Link style', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''             => __( 'None', 'blockstrap-page-builder-blocks' ),
				'btn'          => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'btn-icon'     => __('Button Icon Circle', 'blockstrap-page-builder-blocks'),
				'btn-round'    => __( 'Button rounded', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Button styles', 'blockstrap-page-builder-blocks' ),
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
			'group'    => __( 'Button styles', 'blockstrap-page-builder-blocks' ),
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
			'group'           => __( 'Button styles', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%link_type%]!="iconbox" && [%link_type%]!=""',
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

		// Hover animations
		//$arguments['hover_animations'] = sd_get_hover_animations_input();

		// Icon hover animations
		$arguments['hover_icon_animation'] = sd_get_hover_icon_animation_input();

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

		$type = ! empty($args['type']) ? esc_attr($args['type']) : 'button';
		$link               = '#';
		$link_text          = '';
		$link_class         = 'nav-link';
		$btn_color 			= '';
		$link_attr          = '';
		$icon_aria_label    = ! empty($args['icon_aria_label']) ? 'aria-label="'.esc_attr($args['icon_aria_label']).'"' : '';
		$icon               = '';

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



		// set text
		$link_text = ! empty($args['text']) ? esc_attr($args['text']) : $link_text;




		// link type
		if (! empty($args['link_type'])) {


			if ('btn' === $args['link_type']) {
				$link_class .= ' btn';
			} else if ('btn-round' === $args['link_type']) {
				$link_class .= ' btn btn-round';
			} else if ('btn-icon' === $args['link_type']) {
				$link_class .= ' btn btn-icon rounded-circle';
			} else if ('iconbox' === $args['link_type']) {
				$link_class .= ' iconbox rounded-circle';
			} else if ('iconbox-fill' === $args['link_type']) {
				$link_class .= ' iconbox fill rounded-circle';
			}

			if ('btn' === $args['link_type'] || 'btn-round' === $args['link_type'] || 'btn-icon' === $args['link_type']) {
				$btn_color = ! empty($args['link_bg']) ? ' btn-'.sanitize_html_class($args['link_bg']) : '';
				$link_class .= $btn_color;
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


		// if button color then we need to strip nav-link so it shows
		if ( $btn_color ) {
			$link_class = str_replace('nav-link', '', $link_class);
		}

		if ( 'button' !== $type ) {

			// link padding / font weight
			$link_class .= ' ' . sd_build_aui_class(
					[
						'pt'    => isset( $args['link_pt'] ) ? $args['link_pt'] : '',
						'pt_md' => isset( $args['link_pt_md'] ) ? $args['link_pt_md'] : '',
						'pt_lg' => isset( $args['link_pt_lg'] ) ? $args['link_pt_lg'] : '',

						'pr'    => isset( $args['link_pr'] ) ? $args['link_pr'] : '',
						'pr_md' => isset( $args['link_pr_md'] ) ? $args['link_pr_md'] : '',
						'pr_lg' => isset( $args['link_pr_lg'] ) ? $args['link_pr_lg'] : '',

						'pb'    => isset( $args['link_pb'] ) ? $args['link_pb'] : '',
						'pb_md' => isset( $args['link_pb_md'] ) ? $args['link_pb_md'] : '',
						'pb_lg' => isset( $args['link_pb_lg'] ) ? $args['link_pb_lg'] : '',

						'pl'    => isset( $args['link_pl'] ) ? $args['link_pl'] : '',
						'pl_md' => isset( $args['link_pl_md'] ) ? $args['link_pl_md'] : '',
						'pl_lg' => isset( $args['link_pl_lg'] ) ? $args['link_pl_lg'] : '',

						'font_weight' => $font_weight,
					]
				);
		}

		if ('spacer' == $args['type'] && $link_text == '') {
			$link_text = ' '; // we need to trick it to show
		}




		// if a button add form-inline
//		if (! empty($args['link_type'])) {
//			$wrap_class .= $aui_bs5 ? ' align-self-center' : ' form-inline';
//		}

		$icon_display = $this->is_preview() ? 'inline' : 'none';

		$icon_light_class = ! empty( $args['icon_light'] ) ? esc_attr( $args['icon_light'] ) : 'fa-solid fa-sun';
		$icon_dark_class  = ! empty( $args['icon_dark'] ) ? esc_attr( $args['icon_dark'] ) : 'fa-solid fa-moon';

		$hover_icon_animation = !empty($args['hover_icon_animation']) ? 'animate-target' : '';

		$icon_light = '<i class="' . esc_attr( $icon_light_class ) . ' bs-is-light-mode aui-dark-mode-hide '.esc_attr($hover_icon_animation).'" style="display: '.esc_attr($icon_display).';"></i>';
		$icon_dark  = '<i class="' . esc_attr( $icon_dark_class ) . ' bs-is-dark-mode aui-light-mode-hide '.esc_attr($hover_icon_animation).'" style="display: none;"></i>';

		$hover_text = ! empty( $args['hover_text'] ) ? esc_attr( $args['hover_text'] ) : __( 'Toggle dark mode', 'blockstrap' );
		$tooltip_data = $hover_text ? 'data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="'.esc_attr($hover_text).'" aria-label="'.esc_attr($hover_text).'"' : '';
		// enqueue script
		add_action( 'wp_footer',array( $this, 'enqueue_scripts' ) );

		if ( 'button' == $type ) {
			$wrap_class .= ' btn-icon '.$link_class;
			return sprintf(
				'<button class="bs-dark-mode-toggle btn %1$s" role="button" %2$s >
					  %3$s
					  %4$s
					</button>',
				$wrap_class,
				$tooltip_data,
				$icon_light,
				$icon_dark
			);
		}elseif( 'nav-item' == $type ){
			return sprintf(
				'<li class="nav-item %1$s"><button class="bs-dark-mode-toggle btn btn-icon %2$s" role="button" %3$s >
					  %4$s
					  %5$s
					</button></li>',
				$wrap_class,
				$link_class,
				$tooltip_data,
				$icon_light,
				$icon_dark
			);
		}elseif( 'nav-dropdown' == $type ){
			return sprintf(
				'<li class="nav-item dropdown %1$s"><button class="bs-dark-mode-toggle dropdown-togglex nav-link btn btn-icon %2$s" role="button" data-bs-toggle="dropdown" %3$s >
					  %4$s
					  %5$s
					</button>
					<ul class="dropdown-menu dropdown-menu-end">
                            <li>
                              <button type="button" class="bs-dark-mode-set dropdown-item">
                                  <i class="%6$s mr-2 fa-fw"></i>
                                <span class="theme-label">Light</span>
                              </button>
                            </li>
                            <li>
                              <button type="button" class="bs-light-mode-set dropdown-item">
                                  <i class="%7$s mr-2 fa-fw"></i>
                                <span class="theme-label">Dark</span>
                              </button>
                            </li>
                            <li>
                              <button type="button" class="bs-auto-mode-set dropdown-item">
                                  <i class="fa-solid fa-circle-half-stroke mr-2 fa-fw"></i>
                                <span class="theme-label">Auto</span>
                              </button>
                            </li>
                          </ul>
				</li>',
				$wrap_class,
				$link_class,
				$tooltip_data,
				$icon_light,
				$icon_dark,
				$icon_light_class,
				$icon_dark_class
			);
		}

		return '';

	}//end output()


	/**
	 * Enqueues the necessary scripts for the widget, shortcode, and block (front end).
	 *
	 * @return void
	 * @global $blockstrap_nav_js
	 *
	 */
	public function enqueue_scripts($return=false) {
		global $blockstrap_dark_mode_js;

		// Don't load JS again.
		if ( empty( $blockstrap_dark_mode_js ) && class_exists( 'AyeCode_UI_Settings' ) ) {
			ob_start();
			?>
			<script>
				(function () {
					const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

					function setMode(mode) {
						const resolved = mode === 'auto' ? (prefersDark ? 'dark' : 'light') : mode;
						document.documentElement.setAttribute('data-bs-theme', resolved);
						localStorage.setItem('bs-theme', mode);

						// Clear inline styles so CSS can take over
						document.querySelectorAll('.bs-is-light-mode, .bs-is-dark-mode').forEach(el => {
							el.style.display = '';
						});

						// Set active on dropdown buttons
						document.querySelectorAll('.bs-dark-mode-set, .bs-light-mode-set, .bs-auto-mode-set').forEach(btn => {
							btn.classList.remove('active');
						});
						const selector =
							mode === 'light'
								? '.bs-dark-mode-set'
								: mode === 'dark'
									? '.bs-light-mode-set'
									: '.bs-auto-mode-set';
						document.querySelectorAll(selector).forEach(btn => btn.classList.add('active'));
					}

					function initMode() {
						const saved = localStorage.getItem('bs-theme');
						if (saved) setMode(saved);
						else setMode(prefersDark ? 'dark' : 'light');
					}

					// All toggles
					document.querySelectorAll('.bs-dark-mode-toggle').forEach(toggle => {
						toggle.addEventListener('click', e => {
							// Don't toggle if the click is inside a dropdown menu
							if (e.target.closest('.dropdown-menu')) return;

							// Don't toggle if it's only opening a dropdown (based on aria-expanded attr)
							const dropdownParent = toggle.closest('.dropdown');
							if (dropdownParent) {
								const expanded = toggle.getAttribute('aria-expanded');
								if (expanded !== null && expanded !== 'false') return; // Let dropdown open
							}

							// Otherwise toggle
							const saved = localStorage.getItem('bs-theme');
							setMode(saved === 'dark' ? 'light' : 'dark');
						});
					});

					// Mode set buttons
					document.querySelectorAll('.bs-dark-mode-set').forEach(btn =>
						btn.addEventListener('click', () => setMode('light'))
					);
					document.querySelectorAll('.bs-light-mode-set').forEach(btn =>
						btn.addEventListener('click', () => setMode('dark'))
					);
					document.querySelectorAll('.bs-auto-mode-set').forEach(btn =>
						btn.addEventListener('click', () => setMode('auto'))
					);

					initMode();
				})();


			</script>
			<?php
			$script = ob_get_clean();

			if ( $return ) {
				return $script;
			}

			echo $script;
			//$blockstrap_dark_mode_js = wp_add_inline_script( 'bootstrap-js-bundle', $script );
		}
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
	public function outputx( $args = array(), $widget_args = array(), $content = '' ) {

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



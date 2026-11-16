<?php

class BlockStrap_Widget_Container extends WP_Super_Duper {

	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'       => 'blockstrap',
			'output_types'     => array( 'block', 'shortcode' ),
			'nested-block'     => true,
			'block-icon'       => 'far fa-square',
			'block-category'   => 'layout',
			'block-keywords'   => "['container','content','col','row']",
			'block-label'      => "attributes.container ? '" . __( 'BS > ', 'blockstrap-page-builder-blocks' ) . " ('+ attributes.container +')' : '" . __( 'BS > Container', 'blockstrap-page-builder-blocks' ) . "'",
			'block-supports'   => array(
				//'anchor' => 'true',
				'customClassName' => false,
				//'renaming' => false,
			),
			'block-output'     => array(
				array(
					'element'          => 'innerBlocksProps',
					'blockProps'       => array(
						//                      'if_className' => 'props.attributes.styleid + " " [%WrapClass%]',
						'if_className' => ' ( typeof  props.attributes.styleid !== "undefined" )  ?  props.attributes.styleid + " " [%WrapClass%] : ""  [%WrapClass%]',
						'style'        => '{[%WrapStyle%]}',
						'if_id'        => 'props.attributes.anchor ? props.attributes.anchor : props.clientId',
		//                      'if_id'        => 'props.attributes.anchor ? props.attributes.anchor : "bbb"',
						//                      '\'data-styleid\'' => "block-" . wp_rand(15),
						//                      'if_\'data-styleid\'' => 'props.attributes.anchor ? props.attributes.anchor : props.attributes.styleid',
						//                      'if_id'        => 'props.attributes.anchor ? props.attributes.anchor : "vvvv"',
						//                      'if_id'        => 'props.attributes.bg',
		//                                            'if_id'        => '"zzzzz"',
					),
					'innerBlocksProps' => array(
						'orientation' => 'vertical',
						//                      'template'    => "
						//                      [
						//                          [ 'blockstrap/blockstrap-widget-row', {}, [[ 'core/paragraph', { placeholder: 'Summaryx' } ],] ],
						//
						//                        ]
						//    "
					),

				),
				//              array(
				//                  'element'   => 'style',
				//                  //'className' => 'blockstrap-shape',
				//                  'if_content'   => "build_shape_divider_css( props.attributes )",
				//              )

			),
			'block-wrap'       => '',
			'class_name'       => __CLASS__,
			'base_id'          => 'bs_container',
			'name'             => __( 'BS > Container', 'blockstrap-page-builder-blocks' ),
			'widget_ops'       => array(
				'classname'   => 'bd-container',
				'description' => esc_html__( 'A container for content', 'blockstrap-page-builder-blocks' ),
			),
			'example'          => array(
				'viewportWidth' => 300,
				'innerBlocks'   => array(
					array(
						'name'	=> 'core/paragraph',
						'attributes'	=>	array(
							'content'	=> esc_html__( 'A container for content', 'blockstrap-page-builder-blocks' ),
						)
					)
				)
			),
			'no_wrap'          => true,
			'block_group_tabs' => array(
				'content'  => array(
					'groups' => array( __( 'Container', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array( __( 'Background', 'blockstrap-page-builder-blocks' ), __( 'Typography', 'blockstrap-page-builder-blocks' ) ),
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
						__( 'Hover Animations', 'blockstrap-page-builder-blocks' ),
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

		$arguments = array();

		// container class
		$arguments['container'] = sd_get_container_class_input( 'container', array( 'default' => 'container' ) );

		$arguments['h100'] = array(
			'type'            => 'select',
			'title'           => __( 'Card equal heights', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'options'         => array(
				''      => __( 'No', 'blockstrap-page-builder-blocks' ),
				'h-100' => __( 'Yes', 'blockstrap-page-builder-blocks' ),
			),
			'desc_tip'        => false,
			'group'           => __( 'Container', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%container%]=="card"',
		);

		// row-cols
		$arguments['row_cols']    = sd_get_row_cols_input( 'row_cols', array( 'device_type' => 'Mobile' ) );
		$arguments['row_cols_md'] = sd_get_row_cols_input( 'row_cols', array( 'device_type' => 'Tablet' ) );
		$arguments['row_cols_lg'] = sd_get_row_cols_input( 'row_cols', array( 'device_type' => 'Desktop' ) );

		// columns
		$arguments['col']    = sd_get_col_input( 'col', array( 'device_type' => 'Mobile' ) );
		$arguments['col_md'] = sd_get_col_input( 'col', array( 'device_type' => 'Tablet' ) );
		$arguments['col_lg'] = sd_get_col_input( 'col', array( 'device_type' => 'Desktop' ) );

		$arguments = $arguments + sd_get_background_inputs( 'bg' );

		$arguments['bg_on_text'] = array(
			'type'            => 'checkbox',
			'title'           => __( 'Background on text', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'value'           => '1',
			'desc_tip'        => false,
			'desc'            => __( 'This will show the background on the text.', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Background', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%bg%]=="custom-gradient"',
		);

		$arguments['bg_image_random'] = array(
			'type'            => 'checkbox',
			'title'           => __( 'Random image on each load', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'value'           => '1',
			'desc_tip'        => false,
			'desc'            => __( 'Show one of the images below at random each time the page loads. The custom image above is used in the editor and as a fallback.', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Background', 'blockstrap-page-builder-blocks' ),
			'element_require' => '![%bg_image_use_featured%]',
		);

		$arguments['bg_images'] = array(
			'type'            => 'images',
			'title'           => __( 'Random images', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Background', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%bg_image_random%] && ![%bg_image_use_featured%]',
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
		$arguments['mb'] = sd_get_margin_input(
			'mb',
			array(
				'device_type' => 'Mobile',
			//              'default'     => 3,
			)
		);
		$arguments['ml'] = sd_get_margin_input( 'ml', array( 'device_type' => 'Mobile' ) );

		// margins tablet
		$arguments['mt_md'] = sd_get_margin_input( 'mt', array( 'device_type' => 'Tablet' ) );
		$arguments['mr_md'] = sd_get_margin_input( 'mr', array( 'device_type' => 'Tablet' ) );
		$arguments['mb_md'] = sd_get_margin_input( 'mb', array( 'device_type' => 'Tablet' ) );
		$arguments['ml_md'] = sd_get_margin_input( 'ml', array( 'device_type' => 'Tablet' ) );

		// margins desktop
		$arguments['mt_lg'] = sd_get_margin_input( 'mt', array( 'device_type' => 'Desktop' ) );
		$arguments['mr_lg'] = sd_get_margin_input( 'mr', array( 'device_type' => 'Desktop' ) );
		$arguments['mb_lg'] = sd_get_margin_input(
			'mb',
			array(
				'device_type' => 'Desktop',
				'default'     => 3,
			)
		);
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
		$arguments['border']         = sd_get_border_input( 'border' );
		$arguments['border_type']    = sd_get_border_input( 'type' );
		$arguments['border_width']   = sd_get_border_input( 'width' ); // BS5 only
		$arguments['border_opacity'] = sd_get_border_input( 'opacity' ); // BS5 only
		$arguments['rounded']        = sd_get_border_input( 'rounded' );
		$arguments['rounded_size']   = sd_get_border_input( 'rounded_size' );

		// shadow
		$arguments['shadow'] = sd_get_shadow_input( 'shadow' );

		// position
		$arguments['position'] = sd_get_position_class_input( 'position' );

		$arguments['sticky_offset_top']    = sd_get_sticky_offset_input( 'top' );
		$arguments['sticky_offset_bottom'] = sd_get_sticky_offset_input( 'bottom' );

		$arguments['display']    = sd_get_display_input( 'd', array( 'device_type' => 'Mobile' ) );
		$arguments['display_md'] = sd_get_display_input( 'd', array( 'device_type' => 'Tablet' ) );
		$arguments['display_lg'] = sd_get_display_input( 'd', array( 'device_type' => 'Desktop' ) );

		// flex align items
		$arguments = $arguments + sd_get_flex_align_items_input_group( 'flex_align_items' );
		$arguments = $arguments + sd_get_flex_justify_content_input_group( 'flex_justify_content' );
		$arguments = $arguments + sd_get_flex_align_self_input_group( 'flex_align_self' );
		$arguments = $arguments + sd_get_flex_order_input_group( 'flex_order' );

		// overflow
		$arguments['overflow'] = sd_get_overflow_input();

		// Max height
		$arguments['max_height'] = sd_get_max_height_input();

		// scrollbars
		$arguments['scrollbars'] = sd_get_scrollbars_input();

		// Hover animations
		$arguments['hover_animations'] = sd_get_hover_animations_input();

		// block visibility conditions
		$arguments['visibility_conditions'] = sd_get_visibility_conditions_input();

		// advanced
		$arguments['anchor'] = sd_get_anchor_input();

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
		if ( ! empty( $args['bg_image_use_featured'] ) ) {
			global $post;
			$featured_image = get_the_post_thumbnail_url( $post, 'full' );
			if ( ! $featured_image && ! empty( $args['bg_image'] ) ) {
				$featured_image = esc_url( $args['bg_image'] );
			} elseif ( ! $featured_image ) {
				$featured_image = '';
			}

			// check if we are on a GD location page
			$gd_location_img = $this->maybe_get_gd_location_image();
			if ($gd_location_img) {
				$featured_image = $gd_location_img;
			}

			// GD archive page images
			$gd_archive_img = $this->maybe_get_gd_archive_image();
			if ($gd_archive_img) {
				$featured_image = $gd_archive_img;
			}

			/**
			 * Filter the image URL used by the container's "Use featured image" option.
			 *
			 * @since 0.1.65
			 *
			 * @param string                        $featured_image The image URL. Can be empty.
			 * @param array                         $args           The block arguments.
			 * @param WP_Post|null                  $post           The current post.
			 * @param BlockStrap_Widget_Container   $widget         The container block instance.
			 */
			$featured_image = apply_filters( 'blockstrap_blocks_container_featured_bg_image', $featured_image, $args, $post, $this );
			$featured_image = is_string( $featured_image ) && $featured_image ? esc_url( $featured_image ) : '';

			// replace the old URL based placeholder image @todo remove once all products have latest SD in their release.
			$content = preg_replace( '/:url\(\w+:\/\/\S*\/icons\/placeholder.png/', ':url(' . $featured_image, $content );

			// replace the new inline placeholder image
			$content = preg_replace(
				'/:url\(data:image\/svg\+xml;base64,PD94bW[\w+\/=]*\)/',
				':url(' . $featured_image . ')',
				$content
			);
		}

		//$content = str_replace( '&lt;', '<', $content ); // this could cause XSS in search

		if ( empty( $content ) ) {
			return '';
		} elseif ( strpos( $content, 'class="wp-block-' ) !== false ) {//block
			$html = $content;
		} else {
			$wrap_class = sd_build_aui_class( $args );

			$styles = sd_build_aui_styles( $args );
			$style  = $styles ? ' style="' . $styles . '"' : '';

			$html = '<section class="' . $wrap_class . '"' . $style . '>' . $content . '</section>'; // shortcode
		}

		// Random background image (the featured image option takes priority).
		if ( empty( $args['bg_image_use_featured'] ) ) {
			$random_images = $this->get_random_bg_images( $args );

			if ( ! empty( $random_images ) ) {
				$html = $this->apply_random_bg_image( $html, $random_images );
			}
		}

		return $html;
	}

	/**
	 * Get the list of image URLs for the random background option.
	 *
	 * @param array $args The block arguments.
	 *
	 * @return array
	 */
	public function get_random_bg_images( $args ) {
		$urls = array();

		if ( ! empty( $args['bg_image_random'] ) && ! empty( $args['bg_images'] ) && is_string( $args['bg_images'] ) ) {
			// The images input stores a list of JSON objects without the surrounding brackets.
			$raw    = str_replace( array( '&quot;', '&#39;' ), array( '"', "'" ), $args['bg_images'] );
			$images = json_decode( '[' . $raw . ']', true );

			if ( is_array( $images ) ) {
				foreach ( $images as $image ) {
					$url = '';

					// Prefer the current full size URL from the media library.
					if ( ! empty( $image['id'] ) ) {
						$url = wp_get_attachment_image_url( absint( $image['id'] ), 'full' );
					}

					if ( ! $url && ! empty( $image['url'] ) ) {
						$url = $image['url'];
					}

					if ( $url ) {
						$urls[] = $url;
					}
				}
			}
		}

		/**
		 * Filter the image URLs the container picks a random background from.
		 *
		 * @since 0.1.65
		 *
		 * @param string[]                      $urls   The image URLs chosen in the block settings.
		 * @param array                         $args   The block arguments.
		 * @param BlockStrap_Widget_Container   $widget The container block instance.
		 */
		$urls = apply_filters( 'blockstrap_blocks_container_random_bg_images', $urls, $args, $this );

		if ( ! is_array( $urls ) ) {
			return array();
		}

		$clean = array();
		foreach ( $urls as $url ) {
			$url = is_string( $url ) ? esc_url_raw( $url ) : '';

			if ( $url ) {
				$clean[] = $url;
			}
		}

		return array_values( array_unique( $clean ) );
	}

	/**
	 * Add a random background image to the container's wrapper element.
	 *
	 * PHP picks one image so the page works without JavaScript, then a small script
	 * (loaded once per page) picks again in the browser so the image still changes
	 * on cached pages.
	 *
	 * @param string $html   The container HTML.
	 * @param array  $images The image URLs to pick from.
	 *
	 * @return string
	 */
	public function apply_random_bg_image( $html, $images ) {
		// The first opening tag is the container wrapper; inner blocks come after it.
		if ( ! preg_match( '/^\s*<([a-z][a-z0-9-]*)\b[^>]*>/i', $html, $tag_match ) ) {
			return $html;
		}

		$tag     = $tag_match[0];
		$new_tag = $tag;
		$pick    = esc_url( $images[ array_rand( $images ) ] );
		$css_url = 'url(&quot;' . $pick . '&quot;)';

		if ( preg_match( '/\sstyle="([^"]*)"/i', $tag, $style_match ) ) {
			if ( strpos( $style_match[1], 'url(' ) !== false ) {
				// Swap the existing image, keeping any gradient or colour overlay.
				$new_style = preg_replace_callback(
					'/url\([^)]*\)/',
					function () use ( $css_url ) {
						return $css_url;
					},
					$style_match[1],
					1
				);
			} else {
				$new_style = 'background-image:' . $css_url . ';background-size:cover;' . $style_match[1];
			}

			$new_tag = str_replace( $style_match[0], ' style="' . $new_style . '"', $tag );
			$extra   = '';
		} else {
			$extra = ' style="background-image:' . $css_url . ';background-size:cover;"';
		}

		$extra .= ' data-bs-random-bg="' . esc_attr( wp_json_encode( $images ) ) . '"';

		// Insert the extra attributes straight after the tag name.
		$name_end = strpos( $new_tag, $tag_match[1] ) + strlen( $tag_match[1] );
		$new_tag  = substr_replace( $new_tag, $extra, $name_end, 0 );

		$html = substr_replace( $html, $new_tag, 0, strlen( $tag ) );

		return $this->enqueue_random_bg_script( $html );
	}

	/**
	 * Load the random background script once per page, in the footer.
	 *
	 * @param string $html The container HTML.
	 *
	 * @return string
	 */
	public function enqueue_random_bg_script( $html ) {
		static $done = false;

		if ( $done ) {
			return $html;
		}
		$done = true;

		$script = <<<'JS'
(function(){function r(){document.querySelectorAll('[data-bs-random-bg]').forEach(function(e){try{var l=JSON.parse(e.getAttribute('data-bs-random-bg'));e.removeAttribute('data-bs-random-bg');if(l.length){var u=String(l[Math.floor(Math.random()*l.length)]).replace(/"/g,'%22');e.style.backgroundImage=e.style.backgroundImage.replace(/url\([^)]*\)/,'url("'+u+'")');}}catch(x){}});}if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',r);}else{r();}})();
JS;

		if ( did_action( 'wp_print_footer_scripts' ) ) {
			return $html . '<script>' . $script . '</script>';
		}

		wp_register_script( 'bs-random-bg', false, array(), BLOCKSTRAP_BLOCKS_VERSION, true );
		wp_add_inline_script( 'bs-random-bg', $script );
		wp_enqueue_script( 'bs-random-bg' );

		return $html;
	}

	/**
	 * Get the GeoDirectory archive page image if available.
	 *
	 * @return string
	 */
	public function maybe_get_gd_archive_image() {
		global $post;

		$url = '';

		if ( defined( 'GEODIRECTORY_VERSION' ) ) {
			if ( geodir_is_page( 'single' ) && ! empty( $post->ID ) ) {
				$images = geodir_get_images( (int) $post->ID, 1, true, 0, array( 'post_images' ) );

				if ( ! empty( $images ) ) {
					$url = geodir_get_image_src( $images[0], 'full' );
				}
			} else if ( geodir_is_page( 'archive' ) ) {

				$images = geodir_get_images( 0, 1, false, '', array(), array( 'cat_default' ) );

				if ( ! empty( $images ) ) {
					$url = geodir_get_image_src( $images[0], 'full' );
				}
				// CPT default image: the 'cpt_default' fallback in geodir_get_images() needs a post, so it never resolves on archives.
				if ( ! $url ) {
					$post_type = geodir_get_current_posttype();
					$post_types = geodir_get_posttypes( 'array' );

					if ( $post_type && ! empty( $post_types[ $post_type ]['default_image'] ) ) {
						$url = wp_get_attachment_image_url( absint( $post_types[ $post_type ]['default_image'] ), 'full' );
					}
				}

				if ( ! $url ) {
					$images = geodir_get_images( 0, 1, false, '', array(), array( 'listing_default' ) );

					if ( ! empty( $images ) ) {
						$url = geodir_get_image_src( $images[0], 'full' );
					}
				}
			}
		}

		return $url;
	}

	/**
	 * Get the GeoDirectory location page image if available.
	 *
	 * @return string
	 */
	public function maybe_get_gd_location_image() {
		global $geodirectory;

		$url = '';

		if ( defined( 'GEODIRLOCATION_VERSION' ) && geodir_is_page( 'location' ) ) {
			$img = do_shortcode( '[gd_location_meta key="location_image" image_size="full" no_wrap="1"]' );//exit;

			if( ! empty( $img ) ) {
				if (preg_match('/<img[^>]+src="([^"]+)"/i', $img, $matches)) {
					$url = esc_url( $matches[1] );
				}
			}
		}

		return $url;
	}
}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Container' );
	}
);

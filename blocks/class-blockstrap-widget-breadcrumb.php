<?php

class BlockStrap_Widget_Breadcrumb extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'         => 'blockstrap',
			'output_types'       => array( 'block', 'shortcode' ),
			'block-icon'         => 'fas fa-chevron-right',
			'block-category'     => 'layout',
			'block-keywords'     => "['breadcrumbs','trail','links']",
			'block-wrap'         => '',
			'block-supports'     => array(
				'customClassName' => false,
			),
			'block-edit-returnx' => "el('span', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									style: {'minHeight': '30px'},
									className: '',
								}))",
			'class_name'         => __CLASS__,
			'base_id'            => 'bs_breadcrumb',
			'name'               => __( 'BS > Breadcrumb', 'blockstrap-page-builder-blocks' ),
			'widget_ops'         => array(
				'classname'   => 'bs-breadcrumb',
				'description' => esc_html__( 'A bootstrap breadcrumb output.', 'blockstrap-page-builder-blocks' ),
			),
			'example'            => array(
				'viewportWidth' => 300
			),
			'no_wrap'            => true,
			'block_group_tabs'   => array(
				'content'  => array(
					'groups' => array( __( 'Home Link', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['hide_home'] = array(
			'type'     => 'checkbox',
			'title'    => __( 'Hide the home link', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'value'    => '1',
			'desc_tip' => false,
			'desc'     => __( 'This will hide the home link.', 'blockstrap-page-builder-blocks' ),
			'group'    => __( 'Home Link', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['home_text'] = array(
			'type'        => 'text',
			'title'       => __( 'Home Text', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'Home', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Home Link', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['icon_class'] = array(
			'type'        => 'text',
			'title'       => __( 'Home icon class', 'blockstrap-page-builder-blocks' ),
			'desc'        => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			'placeholder' => __( 'fas fa-home', 'blockstrap-page-builder-blocks' ),
			'default'     => '',
			'desc_tip'    => true,
			'group'       => __( 'Home Link', 'blockstrap-page-builder-blocks' ),
		);

		$arguments = $arguments + sd_get_background_inputs( 'bg' );

		// Typography
		// text color
		$arguments = $arguments + sd_get_text_color_input_group();

		// font size
		$arguments = $arguments + sd_get_font_size_input_group();

		// line height
		$arguments['font_line_height'] = sd_get_font_line_height_input();

		// font size
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
		$arguments['border']         = sd_get_border_input( 'border' );
		$arguments['border_type']    = sd_get_border_input( 'type' );
		$arguments['border_width']   = sd_get_border_input( 'width' ); // BS5 only
		$arguments['border_opacity'] = sd_get_border_input( 'opacity' ); // BS5 only
		$arguments['rounded']        = sd_get_border_input( 'rounded' );
		$arguments['rounded_size']   = sd_get_border_input( 'rounded_size' );

		// shadow
		$arguments['shadow'] = sd_get_shadow_input( 'shadow' );

		$arguments['display']    = sd_get_display_input( 'd', array( 'device_type' => 'Mobile' ) );
		$arguments['display_md'] = sd_get_display_input( 'd', array( 'device_type' => 'Tablet' ) );
		$arguments['display_lg'] = sd_get_display_input( 'd', array( 'device_type' => 'Desktop' ) );

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
		global $aui_bs5;

		$output = '';
		$crumbs = $this->get_breadcrumbs();

//      /print_r($crumbs);exit();

		// maybe remove home link
		if ( ! empty( $crumbs ) && ! empty( $args['hide_home'] ) ) {
			array_shift( $crumbs );
		}

		if ( ! empty( $crumbs ) ) {

			//          print_r( $args );
			$item_class = sd_build_aui_class(
				array(
					'text_color'        => $args['text_color'],
					'text_color_custom' => $args['text_color_custom'],
					'font_size'         => $args['font_size'],
					'font_size_custom'  => $args['font_size_custom'],
				)
			);

			$item_class .= ' mb-0';

			unset( $args['text_color'] );
			unset( $args['text_color_custom'] );
			unset( $args['font_size'] );
			unset( $args['font_size_custom'] );

			$wrap_class    = sd_build_aui_class( $args );
			$class_output  = $wrap_class ? ' class=" ' . $wrap_class . '"' : '';
			$wrap_styles   = sd_build_aui_styles( $args );
			$styles_output = $wrap_class ? ' style="' . $wrap_styles . '"' : '';

			$output .= '<nav aria-label="breadcrumb" ' . $class_output . $styles_output . '><ol class="breadcrumb  m-0 p-0 pt-1">';

			$i     = 0;
			$total = count( $crumbs );
			foreach ( $crumbs as $crumb ) {
				$icon = '';
				if ( ! $i && empty( $args['hide_home'] ) ) {
					if ( ! empty( $args['home_text'] ) && ' ' !== $args['home_text'] ) {
						$crumb['name'] = esc_attr( $args['home_text'] );
					}

					if ( ! empty( $args['icon_class'] ) ) {
						$icon = '<i class="' . sd_sanitize_html_classes( $args['icon_class'] ) . '"></i> ';
					}
				}
				++$i;

				$link    = $i < $total && $crumb['link'] ? esc_url_raw( $crumb['link'] ) : '';
				$name    = $crumb['name'] ? esc_attr( $crumb['name'] ) : '';
				$output .= ! $link ? '<li class="breadcrumb-item active ' . $item_class . '" aria-current="page">' : '<li class="breadcrumb-item ' . $item_class . '">';
				$output .= $link ? '<a href="' . esc_url_raw( $link ) . '">' : '';
				$output .= $icon . esc_attr( $name );
				$output .= $link ? '</a>' : '';
				$output .= '</li>';

			}
			$output .= '</ol></nav>';

		}

		return $output;
	}

	/**
	 * Build the breadcrumb array.
	 *
	 * @return array
	 */
	public function get_breadcrumbs() {
		global $post;

		// Set up variables
		$breadcrumbs        = array();
		$current_page_title = get_the_title();

		// Home page
		$breadcrumbs[] = array(
			'name' => 'Home',
			'link' => home_url(),
		);

		if ( is_archive() && ! is_tax() && ! is_category() && ! is_tag() ) {

			// Custom post type archive
			$post_type        = get_post_type();
			$post_type_object = get_post_type_object( $post_type );
			if ( isset( $post_type_object->label ) ) {
				$breadcrumbs[] = array(
					'name' => $post_type_object->label,
					'link' => get_post_type_archive_link( $post_type ),
				);
			}
		} elseif ( is_archive() && is_tax() && ! is_category() && ! is_tag() ) {

			// check if we can get the CTP link first
			$post_type        = get_post_type();
			$post_type_object = get_post_type_object( $post_type );
			if ( isset( $post_type_object->label ) ) {
				$breadcrumbs[] = array(
					'name' => $post_type_object->label,
					'link' => get_post_type_archive_link( $post_type ),
				);
			}

			// Custom taxonomy archive
			$custom_tax_name = get_queried_object()->name;
			$breadcrumbs[]   = array(
				'name' => $custom_tax_name,
				'link' => '',
			);

		} elseif ( is_home() ) {

			$breadcrumbs[] = array(
				'name' => 'Blog',
				'link' => '#',
			);
		} elseif ( is_single() ) {

			// Single post
			$post_type = get_post_type();

			if ( $post_type != 'post' ) {

				// Custom post type single
				$post_type_object = get_post_type_object( $post_type );
				$breadcrumbs[]    = array(
					'name' => esc_attr( $post_type_object->label ),
					'link' => get_post_type_archive_link( $post_type ),
				);

			} else {

				// Blog post
				$breadcrumbs[] = array(
					'name' => 'Blog',
					'link' => get_permalink( get_option( 'page_for_posts' ) ),
				);

			}

			// Get post category info
			$category = get_the_category();

			if ( ! empty( $category ) ) {

				// Get last category post is in
				$last_category = reset( $category );

				if ( ! empty( $last_category ) ) {
					//                  print_r( $last_category );
					$breadcrumbs[] = array(
						'name' => $last_category->name,
						'link' => get_term_link( $last_category->term_id ),
					);
				}

			}else{
				global $wp_query;

				// check for custom categories
				$post_type = get_post_type();
				if ( $post_type && ( ! empty( $wp_query->query_vars[ $post_type . 'category' ] ) || ! empty( $wp_query->query_vars[ $post_type . '_category' ] ) ) ) {
					$taxonomy      = ! empty( $wp_query->query_vars[ $post_type . 'category' ] ) ? esc_attr( $post_type . 'category' ) : esc_attr( $post_type . '_category' );
					$taxonomy_slug = ! empty( $wp_query->query_vars[ $post_type . 'category' ] ) ? esc_attr( $wp_query->query_vars[ $post_type . 'category' ] ) : esc_attr( $wp_query->query_vars[ $post_type . '_category' ] );
					$term          = get_term_by( 'slug', $taxonomy_slug, $taxonomy );


					if ( isset( $term->name ) ) {
						$breadcrumbs[] = array(
							'name' => esc_attr( $term->name ),
							'link' => get_term_link( $term ),
						);
					}
				}
			}



			// Add current page to breadcrumbs
			$breadcrumbs[] = array(
				'name' => $current_page_title,
				'link' => '',
			);

		} elseif ( is_category() ) {

			// Category page
			$breadcrumbs[] = array(
				'name' => single_cat_title( '', false ),
				'link' => '',
			);



		} elseif ( is_page() ) {

			// Standard page
			if ( $post->post_parent ) {

				// If child page, get parents
				$anc = get_post_ancestors( $post->ID );

				// Reverse the order so it's oldest to newest
				$anc = array_reverse( $anc );

				// Add parents to breadcrumbs
				foreach ( $anc as $ancestor ) {
					$breadcrumbs[] = array(
						'name' => get_the_title( $ancestor ),
						'link' => get_permalink( $ancestor ),
					);
				}

				// Add current page to breadcrumbs
				$breadcrumbs[] = array(
					'name' => $current_page_title,
					'link' => '',
				);

			} else {

				// Just add current page to breadcrumbs
				$breadcrumbs[] = array(
					'name' => $current_page_title,
					'link' => '',
				);

			}
		} elseif ( is_tag() ) {

			// Tag page

			// Get tag information
			$term_id       = get_query_var( 'tag_id' );
			$taxonomy      = 'post_tag';
			$args          = 'include=' . $term_id;
			$terms         = get_terms( $taxonomy, $args );
			$get_term_id   = $terms[0]->term_id;
			$get_term_slug = $terms[0]->slug;
			$get_term_name = $terms[0]->name;

			// Add current tag to breadcrumbs
			$breadcrumbs[] = array(
				'name' => $get_term_name,
				'link' => '',
			);

		} elseif ( is_day() ) {

			// Day archive

			// Year link
			$breadcrumbs[] = array(
				'name' => get_the_time( 'Y' ),
				'link' => get_year_link( get_the_time( 'Y' ) ),
			);

			// Month link
			$breadcrumbs[] = array(
				'name' => get_the_time( 'M' ),
				'link' => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
			);

			// Day display
			$breadcrumbs[] = array(
				'name' => get_the_time( 'jS' ),
				'link' => '',
			);

		} elseif ( is_month() ) {

			// Month Archive

			// Year link
			$breadcrumbs[] = array(
				'name' => get_the_time( 'Y' ),
				'link' => get_year_link( get_the_time( 'Y' ) ),
			);
			// Month display
			$breadcrumbs[] = array(
				'name' => get_the_time( 'M' ),
				'link' => '',
			);

		} elseif ( is_year() ) {

			// Display year archive
			$breadcrumbs[] = array(
				'name' => get_the_time( 'Y' ),
				'link' => '',
			);

		} elseif ( is_author() ) {

			// Auhor archive

			// Get the author information
			global $author;
			$userdata = get_userdata( $author );

			// Display author name
			$breadcrumbs[] = array(
				'name' => 'Author: ' . $userdata->display_name,
				'link' => '',
			);

		} elseif ( get_query_var( 'paged' ) ) {

			// Paginated archives
			$breadcrumbs[] = array(
				'name' => 'Page ' . get_query_var( 'paged' ),
				'link' => '',
			);

		} elseif ( is_search() ) {

			// Search results page
			$breadcrumbs[] = array(
				'name' => 'Search results for: ' . esc_attr( get_search_query() ),
				'link' => '',
			);

		} elseif ( is_404() ) {

			// 404 page
			$breadcrumbs[] = array(
				'name' => 'Error 404',
				'link' => '',
			);
		} elseif ( $this->is_preview() ) {
			$breadcrumbs[] = array(
				'name' => 'Backend',
				'link' => '#',
			);
			$breadcrumbs[] = array(
				'name' => 'Block Editor',
				'link' => '',
			);
		}

		/**
		 * Filters the breadcrumbs array for the breadcrumb block.
		 *
		 * This filter allows modifying the breadcrumbs before they are displayed.
		 *
		 * @since 0.1.32
		 *
		 * @param array $breadcrumbs The array of breadcrumbs.
		 */
		return apply_filters( 'blockstrap_blocks_breadcrumb_block_breadcrumbs', $breadcrumbs );

	}
}


// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Breadcrumb' );
	}
);

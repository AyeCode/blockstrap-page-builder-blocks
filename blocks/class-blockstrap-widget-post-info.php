<?php

class BlockStrap_Widget_Post_Info extends WP_Super_Duper {


	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'          => 'blockstrap',
			'output_types'        => array( 'block', 'shortcode' ),
			'block-icon'          => 'fas fa-info-circle',
			'block-category'      => 'layout',
			'block-keywords'      => "['post','meta','info']",
			'block-label'         => "attributes.text ? '" . __( 'BS > Post info', 'blockstrap-page-builder-blocks' ) . " ('+ attributes.text+')' : ''",
			'block-supports'      => array(
				'customClassName' => false,
			),
			'block-edit-returnx'  => "el('li', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									className: props.attributes.link_type ? 'nav-item form-inline align-self-center ' + sd_build_aui_class(props.attributes) : 'nav-item ' + sd_build_aui_class(props.attributes) ,
								}))",
			'block-wrap'          => '',
			'class_name'          => __CLASS__,
			'base_id'             => 'bs_post_info',
			'name'                => __( 'BS > Post info', 'blockstrap-page-builder-blocks' ),
			'widget_ops'          => array(
				'classname'   => 'bs-post-info',
				'description' => esc_html__( 'Show basic post information.', 'blockstrap-page-builder-blocks' ),
			),
			'example'             => array(
				'attributes' => array(
					'type' => 'comments',
				),
				'viewportWidth' => 200
			),
			'no_wrap'             => true,
			'block_edit_wrap_tag' => 'span',
			'block_group_tabs'    => array(
				'content'  => array(
					'groups' => array( __( 'Meta', 'blockstrap-page-builder-blocks' ) ),
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

	public function meta_types() {
		$types = array(
			'author'         => __( 'Author', 'blockstrap-page-builder-blocks' ),
			'date_published' => __( 'Date Published', 'blockstrap-page-builder-blocks' ),
			'date_updated'   => __( 'Date Updated', 'blockstrap-page-builder-blocks' ),
			'comments'       => __( 'Comments', 'blockstrap-page-builder-blocks' ),
			'taxonomy'       => __( 'Taxonomy', 'blockstrap-page-builder-blocks' ),
			'read_time'      => __( 'Read Time', 'blockstrap-page-builder-blocks' ),
			'custom'         => __( 'Custom Meta', 'blockstrap-page-builder-blocks' ),
		);

		return $types;
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
			'options'  => $this->meta_types(),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Meta', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['custom_meta'] = array(
			'type'            => 'text',
			'title'           => __( 'Meta Key', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Enter a meta key', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'my_custom_meta_key', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Meta', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="custom"',
		);

		$arguments['taxonomy'] = array(
			'type'            => 'select',
			'title'           => __( 'Taxonomy', 'blockstrap-page-builder-blocks' ),
			'options'         => get_taxonomies(
				array(
					'show_ui' => 1,
					'public'  => 1,
				)
			),
			'default'         => 'category',
			'desc_tip'        => true,
			'group'           => __( 'Meta', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="taxonomy"',
		);

		$arguments['taxonomy_limit'] = array(
			'type'            => 'number',
			'title'           => __( 'Taxonomy limit', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'placeholder'     => __( '0', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Meta', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="taxonomy"',
		);

		$arguments['date_format'] = array(
			'type'            => 'select',
			'title'           => __( 'Date format', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				''         => __( 'Default (WordPress)', 'blockstrap-page-builder-blocks' ),
				'time-ago' => __( 'Time ago (4mins ago)', 'blockstrap-page-builder-blocks' ),
				'F j, Y'   => gmdate( 'F j, Y' ) . ' (F j, Y)',
				'Y-m-d'    => gmdate( 'Y-m-d' ) . ' (Y-m-d)',
				'm/d/Y'    => gmdate( 'm/d/Y' ) . ' (m/d/Y)',
				'd/m/Y'    => gmdate( 'd/m/Y' ) . ' (d/m/Y)',
				'custom'   => __( 'Custom', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Meta', 'blockstrap-page-builder-blocks' ),
			'element_require' => '( [%type%]=="date_published" || [%type%]=="date_updated" )',
		);

		$arguments['date_custom'] = array(
			'type'            => 'text',
			'title'           => __( 'Date custom', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'placeholder'     => __( 'F j, Y', 'blockstrap-page-builder-blocks' ),
			'group'           => __( 'Meta', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%date_format%]=="custom"',
		);

		$arguments['is_link'] = array(
			'type'     => 'checkbox',
			'title'    => __( 'Is link', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'value'    => '1',
			'desc_tip' => false,
			'group'    => __( 'Meta', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['custom_url'] = array(
			'type'            => 'text',
			'title'           => __( 'Custom URL', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Add custom link URL', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'https://example.com', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Meta', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%type%]=="custom"',
		);

		$arguments['icon_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Icon', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''       => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'custom' => __( 'Custom', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Meta', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['icon_class'] = array(
			'type'            => 'text',
			'title'           => __( 'Icon class', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Enter a font awesome icon class.', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'fas fa-ship', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Meta', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%icon_type%]=="custom"',
		);

		$arguments['before'] = array(
			'type'     => 'text',
			'title'    => __( 'Before', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Meta', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['after'] = array(
			'type'     => 'text',
			'title'    => __( 'After', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Meta', 'blockstrap-page-builder-blocks' ),
		);

		// link styles
		$arguments['link_type'] = array(
			'type'     => 'select',
			'title'    => __( 'Link style', 'blockstrap-page-builder-blocks' ),
			'options'  => array(
				''             => __( 'None', 'blockstrap-page-builder-blocks' ),
				'btn'          => __( 'Button', 'blockstrap-page-builder-blocks' ),
				'btn-round'    => __( 'Button rounded', 'blockstrap-page-builder-blocks' ),
				'btn-icon'     => __( 'Button Icon Circle', 'blockstrap-page-builder-blocks' ),
				'iconbox'      => __( 'Iconbox bordered', 'blockstrap-page-builder-blocks' ),
				'iconbox-fill' => __( 'Iconbox filled', 'blockstrap-page-builder-blocks' ),
				'badge'        => __( 'Badge', 'blockstrap-page-builder-blocks' ),
				'badge-round'  => __( 'Badge rounded', 'blockstrap-page-builder-blocks' ),
			),
			'default'  => '',
			'desc_tip' => true,
			'group'    => __( 'Link styles', 'blockstrap-page-builder-blocks' ),
		);

		$arguments['link_size'] = array(
			'type'            => 'select',
			'title'           => __( 'Size', 'blockstrap-page-builder-blocks' ),
			'options'         => array(
				''            => __( 'Default', 'blockstrap-page-builder-blocks' ),
				'extra-small' => __( 'Extra Small (BS5)', 'blockstrap-page-builder-blocks' ),
				'small'       => __( 'Small', 'blockstrap-page-builder-blocks' ),
				'medium'      => __( 'Medium', 'blockstrap-page-builder-blocks' ),
				'large'       => __( 'Large', 'blockstrap-page-builder-blocks' ),
			),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Link styles', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%link_type%]!=""',
		);

		$arguments['link_bg'] = array(
			'title'           => __( 'Color', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Select the color.', 'blockstrap-page-builder-blocks' ),
			'type'            => 'select',
			'options'         => array(
				''         => __( 'Custom colors', 'blockstrap-page-builder-blocks' ),
				'category' => __( 'Category Color (taxonomy only)', 'blockstrap-page-builder-blocks' ),
			) + sd_aui_colors( true, true, true, true ),
			'default'         => '',
			'desc_tip'        => true,
			'advanced'        => false,
			'group'           => __( 'Link styles', 'blockstrap-page-builder-blocks' ),
			'element_require' => '[%link_type%]!="iconbox" && [%link_type%]!=""',
		);

		// padding
		$arguments['link_pt'] = sd_get_padding_input(
			'pt',
			array(
				'device_type' => 'Mobile',
				'group'       => __(
					'Link styles',
					'blockstrap-page-builder-blocks'
				),
			)
		);
		$arguments['link_pr'] = sd_get_padding_input(
			'pr',
			array(
				'device_type' => 'Mobile',
				'group'       => __(
					'Link styles',
					'blockstrap-page-builder-blocks'
				),
			)
		);
		$arguments['link_pb'] = sd_get_padding_input(
			'pb',
			array(
				'device_type' => 'Mobile',
				'group'       => __(
					'Link styles',
					'blockstrap-page-builder-blocks'
				),
			)
		);
		$arguments['link_pl'] = sd_get_padding_input(
			'pl',
			array(
				'device_type' => 'Mobile',
				'group'       => __(
					'Link styles',
					'blockstrap-page-builder-blocks'
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
					'blockstrap-page-builder-blocks'
				),
			)
		);
		$arguments['link_pr_md'] = sd_get_padding_input(
			'pr',
			array(
				'device_type' => 'Tablet',
				'group'       => __(
					'Link styles',
					'blockstrap-page-builder-blocks'
				),
			)
		);
		$arguments['link_pb_md'] = sd_get_padding_input(
			'pb',
			array(
				'device_type' => 'Tablet',
				'group'       => __(
					'Link styles',
					'blockstrap-page-builder-blocks'
				),
			)
		);
		$arguments['link_pl_md'] = sd_get_padding_input(
			'pl',
			array(
				'device_type' => 'Tablet',
				'group'       => __(
					'Link styles',
					'blockstrap-page-builder-blocks'
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
					'blockstrap-page-builder-blocks'
				),
			)
		);
		$arguments['link_pr_lg'] = sd_get_padding_input(
			'pr',
			array(
				'device_type' => 'Desktop',
				'group'       => __(
					'Link styles',
					'blockstrap-page-builder-blocks'
				),
			)
		);
		$arguments['link_pb_lg'] = sd_get_padding_input(
			'pb',
			array(
				'device_type' => 'Desktop',
				'group'       => __(
					'Link styles',
					'blockstrap-page-builder-blocks'
				),
			)
		);
		$arguments['link_pl_lg'] = sd_get_padding_input(
			'pl',
			array(
				'device_type' => 'Desktop',
				'group'       => __(
					'Link styles',
					'blockstrap-page-builder-blocks'
				),
			)
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

		// font size
		$arguments = $arguments + sd_get_font_size_input_group();

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

		// position
		$arguments['position'] = sd_get_position_class_input( 'position' );

		// absolute_position
		$arguments['absolute_position'] = sd_get_absolute_position_input();

		$arguments['sticky_offset_top']    = sd_get_sticky_offset_input( 'top' );
		$arguments['sticky_offset_bottom'] = sd_get_sticky_offset_input( 'bottom' );

		$arguments['display']    = sd_get_display_input( 'd', array( 'device_type' => 'Mobile' ) );
		$arguments['display_md'] = sd_get_display_input( 'd', array( 'device_type' => 'Tablet' ) );
		$arguments['display_lg'] = sd_get_display_input( 'd', array( 'device_type' => 'Desktop' ) );

		// zindex
		$arguments['zindex'] = sd_get_zindex_input();

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
		global $aui_bs5, $post;

		$content = '';

		$text        = '';
		$icon        = '';
		$link        = '#';
		$link_text   = '';
		$link_class  = '';
		$is_preview  = $this->is_block_content_call();
		$post_author = ! empty( $post->post_author ) ? absint( $post->post_author ) : 0;

		$link_divider_pos   = ! empty( $args['link_divider'] ) ? esc_attr( $args['link_divider'] ) : '';
		$link_divider_left  = 'left' === $link_divider_pos ? '<span class="navbar-divider d-none d-lg-block position-absolute top-50 start-0 translate-middle-y"></span>' : '';
		$link_divider_right = 'right' === $link_divider_pos ? '<span class="navbar-divider d-none d-lg-block position-absolute top-50 end-0 translate-middle-y"></span>' : '';

		$font_weight = ! empty( $args['font_weight'] ) ? esc_attr( $args['font_weight'] ) : '';
		//unset( $args['font_weight'] ); // we don't want it on the parent.

		//      print_r( $args );
		$wrap_class = sd_build_aui_class( $args );

		//      echo '###'.$wrap_class .'###';
		if ( 'author' === $args['type'] ) {
			$link = $is_preview ? '#author' : get_author_posts_url( $post_author );
			$text = $is_preview ? 'John Doe' : get_the_author_meta( 'display_name' );
			$icon = 'fas fa-user-circle';
		} elseif ( 'custom' === $args['type'] && !empty( $args['custom_meta'] ) ) {
			$meta_key = sanitize_key( $args['custom_meta'] );
			$link = $is_preview ? '#custom_meta' : get_author_posts_url( $post_author );
			$text =  esc_html( get_post_meta( $post->ID, $meta_key, true ) );
			$text =  $is_preview && !$text ? 'Custom Meta' : $text;
			$icon = 'fas fa-info-circle';
		} elseif ( 'date_published' === $args['type'] || 'date_updated' === $args['type'] ) {
			$link     = $is_preview ? '#post-link' : get_the_permalink();
			$time_ago = 'time-ago' === $args['date_format'];
			if ( empty( $args['date_format'] ) || $time_ago ) {
				$date_format = get_option( 'date_format' );
			} else {
				$date_format = 'custom' === $args['date_format'] ? $args['date_custom'] : $args['date_format'];
			}

			if ( isset( $post->post_date ) ) {
				$date = 'date_published' === $args['type'] ? $post->post_date : $post->post_modified;
			}else{
				$date = '';
			}
			$text = $is_preview ? gmdate( $date_format, strtotime( '-2 hours' ) ) : gmdate( $date_format, strtotime( $date ) );
			$icon = 'far fa-calendar';

			if ( $time_ago ) {
				$icon     = $is_preview ? 'far fa-clock' : '';
				$date_raw = $is_preview ? strtotime( '-2 hours' ) : $date;
				$text     = $is_preview ? '2 days ago' : sprintf(
					'<span class="timeago" datetime="%1$s" >%2$s</span>',
					$date_raw,
					$text
				);
			}
		} elseif ( 'comments' === $args['type'] ) {
			$comments = $is_preview ? 3 : absint( $post->comment_count );
			$link     = $is_preview ? '#post-comments' : get_comments_link();
			$text     = $comments ?
				/* translators: the number of comments */
				sprintf( _n( '%s comment', '%s comments', $comments, 'blockstrap-page-builder-blocks' ), number_format_i18n( $comments ) )
				: __( 'No comments', 'blockstrap-page-builder-blocks' );
			$icon = 'far fa-comment';
		} elseif ( 'read_time' === $args['type'] ) {
			$words = $is_preview ? 1000 : str_word_count( wp_strip_all_tags( $post->post_content ) );
			$m     = floor( $words / 200 );
			$m  = $m == 0 ? 1 : $m; // if very short just default to 1 min
			$link  = '';
			/* translators: the number of minutes to read */
			$text = sprintf( __( '%d min read', 'blockstrap-page-builder-blocks' ), absint( $m ) );
			$icon = 'far fa-clock';
		} elseif ( 'taxonomy' === $args['type'] ) {
			$taxonomy = esc_attr( $args['taxonomy'] );
			$terms    = get_the_terms( $post, $taxonomy );
			$term     = '';
			$limit    = absint( $args['taxonomy_limit'] );
			$icon     = 'far fa-folder-open';
			$text     = $is_preview ? 'Taxonomy' : '';

			if ( ! empty( $terms ) ) {

				if ( $limit && count( $terms ) > $limit ) {
					$terms = array_slice( $terms, 0, $limit );
				}

				if ( 1 === count( $terms ) ) {
					$term = end( $terms );
					$text = esc_attr( $term->name );
					$link = $is_preview ? '#post-tax' : get_term_link( $term );
				} else {

					$text = array();
					foreach ( $terms as $term ) {
						$text[] = array(
							'text' => esc_attr( $term->name ),
							'link' => $is_preview ? '#post-tax' : get_term_link( $term ),
						);
					}
				}
			}

			if ( $is_preview && empty( $text ) ) {
				$text = 'Taxonomy';
				$link = '#';
			}

			//          print_r( $term );
			//          echo '###' . $taxonomy;//exit;
			//          $link = $is_preview ? '#post-tax' : get_term_link( $term );

		}

		// maybe set custom link text
		$text = ! empty( $args['text'] ) ? esc_attr( $args['text'] ) : $text;


		// maybe add before and after text
		if (!empty($args['before'])) {
			$text = esc_attr( $args['before'] ) . $text;
		}
		if (!empty($args['after'])) {
			$text .= esc_attr( $args['after'] );
		}

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
			} elseif ( 'badge' === $args['link_type'] ) {
				$link_class = 'badge';
			} elseif ( 'badge-round' === $args['link_type'] ) {
				$link_class = 'badge rounded-pill';
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
			} elseif ( 'badge' === $args['link_type'] || 'badge-round' === $args['link_type'] ) {
				$link_class .= ' text-bg-' . sanitize_html_class( $args['link_bg'] );
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
		//      $link_class .= ' ' . sd_build_aui_class(
		//          array(
		//              'pt'          => $args['link_pt'],
		//              'pt_md'       => $args['link_pt_md'],
		//              'pt_lg'       => $args['link_pt_lg'],
		//
		//              'pr'          => $args['link_pr'],
		//              'pr_md'       => $args['link_pr_md'],
		//              'pr_lg'       => $args['link_pr_lg'],
		//
		//              'pb'          => $args['link_pb'],
		//              'pb_md'       => $args['link_pb_md'],
		//              'pb_lg'       => $args['link_pb_lg'],
		//
		//              'pl'          => $args['link_pl'],
		//              'pl_md'       => $args['link_pl_md'],
		//              'pl_lg'       => $args['link_pl_lg'],
		//
		//              'font_weight' => $font_weight,
		//          )
		//      );

		//      echo '####'.$link_class.'###';

		$wrap_class .= ' ' . $link_class;

		if ( 'custom' !== $args['icon_type'] ) {
			$args['icon_class'] = $icon;
		}

		$icon = '';
		if ( ! empty( $args['icon_class'] ) ) {
			// remove default text if icon exists.
			if ( empty( $args['text'] ) ) {
				$link_text = '';
			}
			$mr   = $aui_bs5 ? ' me-2' : ' mr-2';
			$icon = '<i class="' . esc_attr( $args['icon_class'] ) . $mr . '"></i>';

		}

		// if a button add form-inline
		if ( ! empty( $args['link_type'] ) ) {
			$wrap_class .= $aui_bs5 ? ' align-self-center' : ' form-inline';
		}

		$wrapper_attributes = '';

		$output = '';

		if ( is_array( $text ) ) {
			foreach ( $text as $t ) {
				$text    = ! empty( $t['text'] ) ? $t['text'] : $text;
				$link    = ! empty( $t['link'] ) ? $t['link'] : $link;
				$output .= $this->output_html( $text, $link, $wrap_class, $wrapper_attributes, $icon, $args['is_link'] );
			}
		} else {
			$output .= $this->output_html( $text, $link, $wrap_class, $wrapper_attributes, $icon, $args['is_link'] );
		}

		return $output;

	}

	public function output_html( $text, $link, $wrap_class, $wrapper_attributes, $icon, $is_link ) {

		if ( $is_link ) {
			return $text ? sprintf(
				'<a href="%1$s" class="%2$s" %3$s>%4$s%5$s</a>',
				$link,
				$wrap_class,
				$wrapper_attributes,
				$icon,
				$text
			) : '';
		} else {
			return $text ? sprintf(
				'<span class="%1$s" %2$s>%3$s%4$s</span>',
				$wrap_class,
				$wrapper_attributes,
				$icon,
				$text
			) : '';
		}
	}

}

// register it.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Post_Info' );
	}
);


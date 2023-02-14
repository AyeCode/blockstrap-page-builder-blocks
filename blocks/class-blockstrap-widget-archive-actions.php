<?php

class BlockStrap_Widget_Archive_Actions extends WP_Super_Duper {

	public $arguments;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$options = array(
			'textdomain'        => 'blockstrap',
			'output_types'      => array( 'block', 'shortcode' ),
			'block-icon'        => 'fas fa-filter',
			'block-category'    => 'layout',
			'block-keywords'    => "['archive','category','sorting','actions']",
			'block-wrap'        => '',
			'block-supports'    => array(
				'customClassName' => false,
			),
			'block-edit-return' => "el('span',wp.blockEditor.useBlockProps({dangerouslySetInnerHTML:{__html:onChangeContent()},style:{'minHeight': '30px'},className:''}))",
			'class_name'        => __CLASS__,
			'base_id'           => 'bs_archive_actions',
			'name'              => __( 'BS > Archive Actions', 'blockstrap-page-builder-blocks' ),
			'widget_ops'        => array(
				'classname'   => 'bs-archive-actions',
				'description' => esc_html__( 'Displays the actions like category & sorting on blog archive page.', 'blockstrap-page-builder-blocks' ),
			),
			'example'           => array(
				'attributes' => array(
					'after_text' => 'Earth',
				),
			),
			'no_wrap'           => true,
			'block_group_tabs'  => array(
				'content'  => array(
					'groups' => array( __( 'Actions', 'blockstrap-page-builder-blocks' ) ),
					'tab'    => array(
						'title'     => __( 'Content', 'blockstrap-page-builder-blocks' ),
						'key'       => 'bs_tab_content',
						'tabs_open' => true,
						'open'      => true,
						'class'     => 'text-center flex-fill d-flex justify-content-center',
					),
				),
				'styles'   => array(
					'groups' => array( __( 'Dropdown', 'blockstrap-page-builder-blocks' ), __( 'Typography', 'blockstrap-page-builder-blocks' ) ),
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

		$arguments['hide_category_filter'] = array(
			'type'     => 'checkbox',
			'title'    => __( 'Hide Category Filter', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'value'    => '1',
			'desc_tip' => false,
			'group'    => __( 'Actions', 'blockstrap-page-builder-blocks' )
		);

		$arguments['category_placeholder'] = array(
			'type'            => 'text',
			'title'           => __( 'Category Placeholder', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Placeholder text for the category filter.', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Category', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Actions', 'blockstrap-page-builder-blocks' ),
			'element_require' => '![%hide_category_filter%]',
		);

		$arguments['hide_sortby_filter'] = array(
			'type'     => 'checkbox',
			'title'    => __( 'Hide Sort By Filter', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'value'    => '1',
			'desc_tip' => false,
			'group'    => __( 'Actions', 'blockstrap-page-builder-blocks' )
		);

		$arguments['sortby_placeholder'] = array(
			'type'            => 'text',
			'title'           => __( 'Sort By Placeholder', 'blockstrap-page-builder-blocks' ),
			'desc'            => __( 'Placeholder text for the sort by filter.', 'blockstrap-page-builder-blocks' ),
			'placeholder'     => __( 'Sort By', 'blockstrap-page-builder-blocks' ),
			'default'         => '',
			'desc_tip'        => true,
			'group'           => __( 'Actions', 'blockstrap-page-builder-blocks' ),
			'element_require' => '![%hide_sortby_filter%]',
		);

		$arguments['hide_icon'] = array(
			'type'     => 'checkbox',
			'title'    => __( 'Hide Icon', 'blockstrap-page-builder-blocks' ),
			'default'  => '',
			'value'    => '1',
			'desc_tip' => false,
			'group'    => __( 'Dropdown', 'blockstrap-page-builder-blocks' )
		);

		$arguments['input_size'] = array(
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
			'group'           => __( 'Dropdown', 'blockstrap-page-builder-blocks' )
		);

		$arguments = $arguments + sd_get_flex_justify_content_input_group( 'flex_justify_content', array( 'group' => __( 'Dropdown', 'blockstrap-page-builder-blocks' ), 'element_require' => '' ) );

		// Typography
		// custom font size
		$arguments = $arguments + sd_get_font_size_input_group( 'font_size', array(), false );

		// font weight.
		$arguments['font_weight'] = sd_get_font_weight_input( 'font_weight', array( 'element_require' => '![%button_hide%]' ) );

		// font case
		$arguments['font_case'] = sd_get_font_case_input( 'font_case', array( 'element_require' => '![%button_hide%]' ) );

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

		$arguments['styleid'] = array(
			'type'     => 'hidden',
			'title'    => __( 'Style ID', 'blockstrap-page-builder-blocks' ),
			'desc_tip' => true,
			'group'    => __( 'Advanced', 'blockstrap-page-builder-blocks' ),
		);

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
		global $wp, $aui_bs5;

		$args = wp_parse_args(
			$args,
			array(
				'hide_category_filter' => '',
				'category_placeholder' => '',
				'hide_sortby_filter' => '',
				'sortby_placeholder' => '',
				'input_size' => '',
				'hide_icon' => '',
				'text_color' => '',
				'font_size' => '',
				'font_case' => '',
				'font_weight' => ''
			)
		);

		// Blog posts page.
		if ( ! ( ! is_front_page() && is_home() && ! $this->is_preview() ) ) {
			return;
		}

		$category_filter = empty( $args['hide_category_filter'] ) ? true : false;
		$sortby_filter = empty( $args['hide_sortby_filter'] ) ? true : false;

		if ( ! $category_filter && ! $sortby_filter ) {
			return;
		}

		$wrap_class = sd_build_aui_class( $args );

		// Size
		if ( $args['input_size'] == 'small' ) {
			$size = 'sm';
		} else if ( $args['input_size'] == 'large' ) {
			$size = 'lg';
		} else {
			$size = '';
		}

		$select_class = '';
		if ( empty( $args['hide_icon'] ) ) {
			$select_class .= 'ps-5';
		}

		if ( $size ) {
			$select_class .= ( $aui_bs5 ? ' form-select-' : ' custom-select-' ) . $size;
		}

		$select_class .= ' ' . sd_build_aui_class(
			array(
				'text_color' => $args['text_color'],
				'font_size' => $args['font_size'],
				'font_case' => $args['font_case'],
				'font_weight' => $args['font_weight'],
			)
		);

		if ( empty( $args['flex_justify_content'] ) ) {
			$args['flex_justify_content'] = 'justify-content-end';
		}
		if ( empty( $args['flex_justify_content_md'] ) ) {
			$args['flex_justify_content_md'] = 'justify-content-end';
		}
		if ( empty( $args['flex_justify_content_lg'] ) ) {
			$args['flex_justify_content_lg'] = 'justify-content-end';
		}

		$justify_class = sd_build_aui_class(
			array(
				'flex_justify_content'    => $args['flex_justify_content'],
				'flex_justify_content_md' => $args['flex_justify_content_md'],
				'flex_justify_content_lg' => $args['flex_justify_content_lg'],
			)
		);

		$parse_url = parse_url( home_url() );
		$current_url = set_url_scheme( 'http://' . $parse_url['host'] . wp_unslash( $_SERVER['REQUEST_URI'] ) );
		$current_url = remove_query_arg( array( '_bs_category', '_bs_sortby' ), $current_url );
		$content .= '<div class="row g-3 ' . $justify_class . '">';
		if ( $category_filter && ( $category_options = self::get_category_options() ) ) {
			$category_placeholder = trim( stripslashes( esc_html( $args['category_placeholder'] ) ) );
			if ( ! $category_placeholder ) {
				$category_placeholder = __( 'Category', 'blockstrap-page-builder-blocks' );
			}

			$category_options = array( '' => $category_placeholder ) + $category_options;

			$content .= '<div class="col-6 col-sm-3 d-flex flex-sm-row flex-column align-items-sm-center"><div class="position-relative w-100">';
			if ( empty( $args['hide_icon'] ) ) {
				$content .= '<i class="fas fa-filter position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>';
			}
			$content .= aui()->select( 
				array(
					'name'             => '_bs_category',
					'class'            => $select_class,
					'value'            => ( ! empty( $_REQUEST['_bs_category'] ) ? sanitize_text_field( $_REQUEST['_bs_category'] ) : '' ),
					'options'          => $category_options,
					'no_wrap'          => true,
					'extra_attributes' => array(
						'aria-label' => $category_placeholder,
						'data-current-url' => esc_url( $current_url ),
					)
				)
			);
			$content .= '</div></div>';
		}

		if ( $sortby_filter && ( $sortby_options = self::get_sortby_options() ) ) {
			$sortby_placeholder = trim( stripslashes( esc_html( $args['sortby_placeholder'] ) ) );
			if ( ! $sortby_placeholder ) {
				$sortby_placeholder = __( 'Sort By', 'blockstrap-page-builder-blocks' );
			}

			$sortby_options = array( '' => $sortby_placeholder ) + $sortby_options;

			$content .= '<div class="col-6 col-sm-3 d-flex flex-sm-row flex-column align-items-sm-center"><div class="position-relative w-100">';
			if ( empty( $args['hide_icon'] ) ) {
				$content .= '<i class="fas fa-arrow-up-a-z position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>';
			}
			$content .= aui()->select( 
				array(
					'name'             => '_bs_sortby',
					'class'            => $select_class,
					'value'            => ( ! empty( $_REQUEST['_bs_sortby'] ) && isset( $sortby_options[ $_REQUEST['_bs_sortby'] ] ) ? sanitize_key( $_REQUEST['_bs_sortby'] ) : '' ),
					'options'          => $sortby_options,
					'no_wrap'          => true,
					'extra_attributes' => array(
						'aria-label' => $category_placeholder,
						'data-current-url' => esc_url( $current_url ),
					)
				)
			);
			$content .= '</div></div>';
		}
		$content .= '</div>';

		$output = sprintf( '<div class="%s">%s</div>', esc_attr( $wrap_class ), $content );

		if ( ! $this->is_preview() ) {
			add_action( 'wp_footer', array( __CLASS__, 'add_script' ), 99 );
		}

		return $output;
	}

	public static function get_category_options() {
		$categories = get_categories();
		$options = array();

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $k => $category ) {
				$options[ $category->slug ] = $category->name;
			}
		}

		/**
		 * Filters the category options for archive actions.
		 *
		 * @since 1.0
		 *
		 * @param array  $options Post category options.
		 * @param object $categories Categories object.
		 */
		return apply_filters( 'blockstrap_blocks_archive_actions_category_opitons', $options, $categories );
	}

	public static function get_sortby_options() {
		$options = array(
			'title' => __( 'Title', 'blockstrap-page-builder-blocks' ),
			'newest' => __( 'Newest', 'blockstrap-page-builder-blocks' ),
			'oldest' => __( 'Oldest', 'blockstrap-page-builder-blocks' ),
			//'popular' => __( 'Popular', 'blockstrap-page-builder-blocks' ),
			//'sponsored' => __( 'Sponsored', 'blockstrap-page-builder-blocks' ),
		);

		/**
		 * Filters the sort by options for archive actions.
		 *
		 * @since 1.0
		 *
		 * @param array $options Sort by options.
		 */
		return apply_filters( 'blockstrap_blocks_archive_actions_sortby_opitons', $options );
	}

	public static function add_script() {
		remove_action( 'wp_footer', array( __CLASS__, 'add_script' ), 99 );
?>
<script type="text/javascript">
jQuery(function($) {
	$('[name="_bs_category"], [name="_bs_sortby"]').on('change', function(e){
		blockstrap_archive_action(this);
	});

	function blockstrap_archive_action(el) {
		var $row = $(el).closest('.row'), bsUrl = $(el).data('current-url') ? $(el).data('current-url') : window.location;
		if ($('[name="_bs_category"]', $row).length && $('[name="_bs_category"]', $row).val()) {
			bsUrl = bsUrl + (bsUrl.indexOf('?') === -1 ? '?' : '&') + '_bs_category=' + $('[name="_bs_category"]', $row).val();
		}
		if ($('[name="_bs_sortby"]', $row).length && $('[name="_bs_sortby"]', $row).val()) {
			bsUrl = bsUrl + (bsUrl.indexOf('?') === -1 ? '?' : '&') + '_bs_sortby=' + $('[name="_bs_sortby"]', $row).val();
		}
		window.location = bsUrl;
	}
});
</script>
<?php
	}

}

// Register block.
add_action(
	'widgets_init',
	function () {
		register_widget( 'BlockStrap_Widget_Archive_Actions' );
	}
);

/**
 * Apply blog archive actions filters.
 *
 * @since 1.0
 */
function blockstrap_archive_actions_filter( $query ) {
	if ( ( isset( $_REQUEST['_bs_category'] ) || isset( $_REQUEST['_bs_sortby'] ) ) && $query->is_main_query() && ! is_admin() && $query->is_home() ) {
		// Category
		if ( ! empty( $_REQUEST['_bs_category'] ) && ( $term = get_term_by( 'slug', sanitize_text_field( $_REQUEST['_bs_category'] ), 'category' ) ) ) {
			$term = get_term_by( 'slug', sanitize_text_field( $_REQUEST['_bs_category'] ), 'category' );

			if ( ! empty( $term->term_id ) ) {
				$query->set( 'category_name', sanitize_text_field( $_REQUEST['_bs_category'] ) );
			}
		}

		// Sort by
		if ( ! empty( $_REQUEST['_bs_sortby'] ) ) {
			switch ( $_REQUEST['_bs_sortby'] ) {
				case 'title':
					$query->set( 'orderby', 'title' );
					$query->set( 'order', 'ASC' );
					break;
				case 'newest':
					$query->set( 'orderby', 'date' );
					$query->set( 'order', 'DESC' );
					break;
				case 'oldest':
					$query->set( 'orderby', 'date' );
					$query->set( 'order', 'ASC' );
					break;
			}
		}
	}
}
add_action( 'pre_get_posts', 'blockstrap_archive_actions_filter', 10, 1 );
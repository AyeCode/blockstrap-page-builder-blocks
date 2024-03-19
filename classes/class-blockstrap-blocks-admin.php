<?php
/**
 * Admin functionality
 *
 * @package BlockStrap
 * @since 1.0.0
 */

/**
 * Add admin required functionality.
 */
class BlockStrap_Blocks_Admin {

	/** Init the class.
	 *
	 * @return void
	 */
	public static function init() {

		// load only if theme is not blockstrap
		if ( 'blockstrap' !== wp_get_theme()->get_stylesheet() && 'blockstrap' !== get_template() ) {
			add_action( 'admin_notices', array( __CLASS__, 'theme_notice' ) );
		}

		add_action( 'switch_theme', array( __CLASS__, 'theme_switch_actions' ) );

		// Add term fields.
		$taxonomies = array( 'category' );

		foreach ( $taxonomies as $taxonomy ) {
			add_action( $taxonomy . '_add_form_fields', array( __CLASS__, 'add_term_fields' ), 10, 1 );
			add_action( $taxonomy . '_edit_form_fields', array( __CLASS__, 'edit_term_fields' ), 10, 2 );
		}

		// Save term fields.
		add_action( 'create_term', array( __CLASS__, 'save_term_fields' ), 10, 3 );
		add_action( 'edit_term', array( __CLASS__, 'save_term_fields' ), 10, 3 );

		// Set AUI to load on all post type edit screens
		add_filter( 'aui_screen_ids', array( __CLASS__, 'maybe_load_aui' ) );

	}

	/**
	 * Load AUI on all post edit screens so our blocks render.
	 *
	 * @param $aui_screens
	 *
	 * @return mixed
	 */
	public static function maybe_load_aui( $aui_screens ) {

		$screen = get_current_screen();

		if ( ! empty( $screen->id ) && ! empty( $screen->base ) && 'post' === $screen->base ) {
			$aui_screens[] = esc_attr( $screen->id );
		}

		return $aui_screens;
	}

	/**
	 * Actions to perform after a theme switch
	 *
	 * @return void
	 */
	public static function theme_switch_actions() {
		delete_option( 'blockstrap_blocks_compatibility_notice' );
	}

	/**
	 * Show a notice if theme is not BlockStrap with further instructions.
	 *
	 * @return void
	 */
	public static function theme_notice() {

		// maybe clear notice
		if ( isset( $_REQUEST['blockstrap-blocks-clear-compatibility-notice'] ) && wp_verify_nonce( $_REQUEST['blockstrap-blocks-clear-compatibility-notice'], 'blockstrap-blocks-dismiss-nonce' ) ) {
			update_option( 'blockstrap_blocks_compatibility_notice', 1 );
		}

		$show = ! get_option( 'blockstrap_blocks_compatibility_notice' );

		if ( $show ) {
			$install_url     = wp_nonce_url(
				add_query_arg(
					array(
						'action' => 'install-theme',
						'theme'  => 'blockstrap',
					),
					admin_url( 'update.php' )
				),
				'install-theme_blockstrap'
			);
			$settings_url    = admin_url( '/options-general.php?page=ayecode-ui-settings' );
			$class           = 'notice notice-warning is-dismissible';
			$name            = __( 'Thanks for installing BlockStrap Blocks', 'blockstrap-page-builder-blocks' );
			$install_message = __( 'BlockStrap Blocks work best with the BlockStrap theme, why not give it a try?', 'blockstrap-page-builder-blocks' );

			$message = sprintf(
				// translators: The settings open and the settings link close.
				__( 'If you notice undesirable style changes to your current theme, please try to run in %1$scompatibility mode%2$s and wrap any blocks in a container with the class `bsui`', 'blockstrap-page-builder-blocks' ),
				'<a href="' . esc_url_raw( $settings_url ) . '">',
				'</a>'
			);
			printf(
				'<div class="%1$s"><h3>%2$s</h3><p>%3$s</p><small>%4$s</small><p><a href="%5$s" class="button button-primary">%6$s</a> <a href="%7$s" class="button button-secondary">%8$s</a></p></div>',
				esc_attr( $class ),
				esc_html( $name ),
				esc_html( $install_message ),
				wp_kses_post( $message ),
				esc_url_raw( $install_url ),
				esc_html__( 'Install BlockStrap Theme', 'blockstrap-page-builder-blocks' ),
				esc_url_raw(
					add_query_arg(
						array(
							'blockstrap-blocks-clear-compatibility-notice' => wp_create_nonce( 'blockstrap-blocks-dismiss-nonce' ),
						)
					)
				),
				esc_html__( 'Dismiss', 'blockstrap-page-builder-blocks' )
			);
		}

	}

	/**
	 * Show fields in new term form.
	 *
	 * @since 1.0
	 *
	 * @param string $taxonomy Current taxonomy slug.
	 */
	public static function add_term_fields( $taxonomy ) {
		?>
		<div class="form-field term-_bs_term_bg_color-wrap bs-term-form-field">
			<label for="_bs_term_bg_color"><?php esc_html_e( 'Background Color', 'blockstrap-page-builder-blocks' ); ?></label>
			<?php echo self::render_term_color( '', '_bs_term_bg_color' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fully escaped in wrapper function ?>
			<p class="description"><?php esc_html_e( 'Background color to use for this item for frontend.', 'blockstrap-page-builder-blocks' ); ?></p>
		</div>

		<div class="form-field term-_bs_term_text_color-wrap bs-term-form-field">
			<label for="_bs_term_text_color"><?php esc_html_e( 'Text Color', 'blockstrap-page-builder-blocks' ); ?></label>
			<?php echo self::render_term_color( '', '_bs_term_text_color' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fully escaped in wrapper function ?>
			<p class="description"><?php esc_html_e( 'Text color to use for this item for frontend.', 'blockstrap-page-builder-blocks' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Show fields in edit term form.
	 *
	 * @since 1.0
	 *
	 * @param object $term     Current taxonomy term object.
	 * @param string $taxonomy Current taxonomy slug.
	 */
	public static function edit_term_fields( $term, $taxonomy ) {
		$bg_color   = get_term_meta( $term->term_id, '_bs_term_bg_color', true );
		$text_color = get_term_meta( $term->term_id, '_bs_term_text_color', true );

		?>
		<tr class="form-field term-_bs_term_bg_color-wrap bs-term-form-field">
			<th scope="row"><label for="_bs_term_bg_color"><?php esc_html_e( 'Background Color', 'blockstrap-page-builder-blocks' ); ?></label></th>
			<td><?php echo self::render_term_color( $bg_color, '_bs_term_bg_color' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fully escaped in wrapper function ?><p class="description"><?php esc_html_e( 'Background color to use for this item for frontend.', 'blockstrap-page-builder-blocks' ); ?></p></td>
		</tr>

		<tr class="form-field term-_bs_term_text_color-wrap bs-term-form-field">
			<th scope="row"><label for="_bs_term_text_color"><?php esc_html_e( 'Text Color', 'blockstrap-page-builder-blocks' ); ?></label></th>
			<td><?php echo self::render_term_color( $text_color, '_bs_term_text_color' );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fully escaped in wrapper function ?><p class="description"><?php esc_html_e( 'Text color to use for this item for frontend.', 'blockstrap-page-builder-blocks' ); ?></p></td>
		</tr>
		<?php
	}

	/**
	 * Get the term color selection html.
	 *
	 * @since 1.0
	 *
	 * @param string $value Optional. Color value. Default null.
	 * @param string $id Optional. Term id. Default ct_cat_color.
	 * @param string $name Optional. Input name. Default null.
	 * @return string Color selection html.
	 */
	public static function render_term_color( $value = '', $id = '_bs_term_color', $name = '' ) {
		if ( empty( $name ) ) {
			$name = $id;
		}

		$color_options = sd_aui_colors();

		$content = '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '"><option value="">' . __( 'None', 'blockstrap-page-builder-blocks' ) . '</option>';

		foreach ( $color_options as $name => $label ) {
			$content .= '<option value="' . esc_attr( $name ) . '" ' . selected( $value, $name, false ) . '>' . esc_html( $label ) . '</option>';
		}

		$content .= '</select>';

		return $content;
	}

	/**
	 * Save term fields.
	 *
	 * @since 1.0
	 *
	 * @param int    $term_id  Term ID.
	 * @param int    $tt_id    Term taxonomy ID.
	 * @param string $taxonomy Taxonomy slug.
	 */
	public static function save_term_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
		$taxonomies = array( 'category' );

		// Save term colors.
		if ( in_array( $taxonomy, $taxonomies ) ) {
			if ( isset( $_POST['_bs_term_bg_color'] ) ) {
				update_term_meta( $term_id, '_bs_term_bg_color', sanitize_text_field( $_POST['_bs_term_bg_color'] ) );
			}

			if ( isset( $_POST['_bs_term_text_color'] ) ) {
				update_term_meta( $term_id, '_bs_term_text_color', sanitize_text_field( $_POST['_bs_term_text_color'] ) );
			}
		}
	}
}

BlockStrap_Blocks_Admin::init();

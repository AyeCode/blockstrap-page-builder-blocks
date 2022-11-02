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
		if ( 'blockstrap' !== wp_get_theme()->get_stylesheet() ) {
			add_action( 'admin_notices', array( __CLASS__, 'theme_notice' ) );
		}

		add_action( 'switch_theme', array( __CLASS__, 'theme_switch_actions' ) );

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

		$show     = ! get_option( 'blockstrap_blocks_compatibility_notice' );
		$aui      = AyeCode_UI_Settings::instance();
		$settings = $aui->get_settings();

		if ( $show && 'core' === $settings['css'] ) {
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


}

BlockStrap_Blocks_Admin::init();

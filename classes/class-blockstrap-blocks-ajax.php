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
class BlockStrap_Blocks_AJAX {

	/** Init the class.
	 *
	 * @return void
	 */
	public static function init() {

		// ajax for contact form block
		add_action( 'wp_ajax_blockstrap_pbb_contact', array( __CLASS__, 'contact_form_block_send' ) );
		add_action( 'wp_ajax_nopriv_blockstrap_pbb_contact', array( __CLASS__, 'contact_form_block_send' ) );

	}

	public static function contact_form_block_send() {

		if ( ! isset( $_POST['security'] ) || wp_hash( get_site_url() ) !== $_POST['security'] ) {
			wp_send_json_error( 'Invalid nonce' );
			wp_die();
		}

		//      print_r( $_POST );
		//      exit;

		$email_template = nl2br(
			apply_filters(
				'blockstrap_blocks_contact_email_template',
				'Contact form received

Submitted from: %%submitted_from_url%%

%%form_data%%

%%blockstrap_contact_footer%%',
				$_POST
			)
		);

		$content = '';
		parse_str( $_POST['form_data'], $data );

		if ( ! empty( $data ) ) {
			foreach ( $data as $key => $val ) {
				$content .= ucfirst( esc_attr( str_replace( 'field_', '', $key ) ) ) . ': ' . nl2br( stripslashes_deep( esc_attr( $val ) ) ) . '<br/>';

			}
		}

		$subject = 'BlockStrap Contact Form';

		$email_template = str_replace(
			array(
				'%%submitted_from_url%%',
				'%%form_data%%',
				'%%blockstrap_contact_footer%%',
			),
			array(
				! empty( $_POST['location'] ) ? esc_url( $_POST['location'] ) : '',
				$content,
				__( 'Contact form by BlockStrap' ),
			),
			$email_template
		);

		$email     = '';
		$bcc_email = '';
		if ( ! empty( $_POST['settings'] ) && ! empty( $_POST['settingsNonce'] ) && wp_hash( wp_json_encode( $_POST['settings'] ) ) === $_POST['settingsNonce'] ) {
			//          print_r($settings); exit;
			$to                = isset( $_POST['settings'][0] ) ? esc_attr( $_POST['settings'][0] ) : '';
			$bcc               = isset( $_POST['settings'][1] ) ? esc_attr( $_POST['settings'][1] ) : '';
			$subject           = ! empty( $_POST['settings'][2] ) ? esc_attr( $_POST['settings'][2] ) : $subject;
			$post_id           = absint( $_POST['settings'][3] );
			$recaptcha_enabled = absint( $_POST['settings'][4] );

			if ( $recaptcha_enabled && empty( $data['g-recaptcha-response'] ) ) {
				wp_send_json_error( __( 'Please complete the recaptcha', 'blockstrap-page-builder-blocks' ) );
				wp_die();
			} elseif ( $recaptcha_enabled && ! empty( $data['g-recaptcha-response'] ) ) {
				$keys     = get_option( 'blockstrap_recaptcha_keys' );
				$response = wp_remote_post(
					'https://www.google.com/recaptcha/api/siteverify',
					array(
						'method'      => 'POST',
						'timeout'     => 45,
						'redirection' => 5,
						'httpversion' => '1.0',
						'blocking'    => true,
						'headers'     => array(),
						'body'        => array(
							'secret'   => $keys['site_secret'],
							'response' => $data['g-recaptcha-response'],
						),
						'cookies'     => array(),
					)
				);

				// unset the captcha so it's not sent in the email
				unset( $data['g-recaptcha-response'] );

				if ( is_wp_error( $response ) ) {
					wp_send_json_error( __( 'Recaptcha error, please refresh and try again', 'blockstrap-page-builder-blocks' ) );
					wp_die();
				} else {
					$recaptcha_response = json_decode( wp_remote_retrieve_body( $response ), true );

					if ( empty( $recaptcha_response['success'] ) ) {
						wp_send_json_error(__( 'Recaptcha error, please refresh and try again', 'blockstrap-page-builder-blocks' ) );
						wp_die();
					}
				}

				//              print_r($recaptcha_response);
				//              wp_die();
			}

			$email     = self::get_email( $to, $post_id );
			$bcc_email = self::get_email( $bcc, $post_id );
		} else {
			wp_send_json_error();
			wp_die();
		}

		$subject = apply_filters( 'blockstrap_blocks_contact_email_subject', 'CF: ' . $subject, $_POST );

		$sent = false;
		if ( $email ) {
			$sent = wp_mail( $email, $subject, $email_template );

			if ( $bcc_email ) {
				wp_mail( $bcc_email, $subject . ' - BCC ', $email_template );
			}
		}
		wp_send_json_success();
		if ( $sent ) {
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}

		wp_die();
	}

	public static function get_email( $to, $post_id = 0 ) {
		$email = '';
		if ( is_numeric( $to ) ) {
			$user_info = get_userdata( $to );
			$email     = sanitize_email( $user_info->user_email );
		} elseif ( 'site' === $to ) {
			$email = get_bloginfo( 'admin_email' );
		} elseif ( 'post_author' === $to ) {
			$author_id = get_post_field( 'post_author', $post_id );
			if ( $author_id ) {
				$user_info = get_userdata( $author_id );
				$email     = sanitize_email( $user_info->user_email );
			}
		} elseif ( defined( 'GEODIRECTORY_VERSION' ) && 'gd_post_email' === $to ) {
			$email = geodir_get_post_meta( $post_id, 'email', true );
		}

		return sanitize_email( $email );
	}



}

BlockStrap_Blocks_AJAX::init();

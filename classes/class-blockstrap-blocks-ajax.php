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

	/**
	 *
	 */
	public static function contact_form_block_send() {
		if ( ! isset( $_POST['security'] ) || wp_hash( get_site_url() ) !== $_POST['security'] ) {
			wp_send_json_error( 'Invalid nonce' );
			wp_die();
		}

		parse_str( $_POST['form_data'], $data );

		// Default fields
		$field_types = array(
			'field_name'    => array(
				'type'  => 'text',
				'label' => __( 'Name', 'blockstrap-page-builder-blocks' ),
			),
			'field_email'   => array(
				'type'  => 'email',
				'label' => __( 'Email', 'blockstrap-page-builder-blocks' ),
			),
			'field_phone'   => array(
				'type'  => 'phone',
				'label' => __( 'Phone', 'blockstrap-page-builder-blocks' ),
			),
			'field_subject' => array(
				'type'  => 'text',
				'label' => __( 'Subject', 'blockstrap-page-builder-blocks' ),
			),
			'field_message' => array(
				'type'  => 'textarea',
				'label' => __( 'Message', 'blockstrap-page-builder-blocks' ),
			),
		);

		$field_types = apply_filters( 'blockstrap_blocks_contact_block_field_types', $field_types, array(), array() );

		$fields = array();

		foreach ( $field_types as $key => $field ) {
			if ( isset( $data[ $key ] ) ) {
				if ( $field['type'] == 'textarea' ) {
					$field['value'] = nl2br( sanitize_textarea_field( wp_unslash( $data[ $key ] ) ) );
				} else {
					$field['value'] = sanitize_text_field( wp_unslash( $data[ $key ] ) );
				}

				$fields[ $key ] = $field;
			}
		}

		$email_template = nl2br(
			apply_filters(
				'blockstrap_blocks_contact_email_template',
				'Contact form received

Submitted from: %%submitted_from_url%%

%%form_data%%

%%blockstrap_contact_footer%%',
				$_POST,
				$data,
				$fields
			)
		);

		$content = '';

		if ( ! empty( $fields ) ) {
			foreach ( $fields as $key => $field ) {
				$content .= '<b>' . $field['label'] . ':</b> ' . $field['value'] . '<br/>';
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
			$to                = isset( $_POST['settings'][0] ) ? esc_attr( $_POST['settings'][0] ) : '';
			$bcc               = isset( $_POST['settings'][1] ) ? esc_attr( $_POST['settings'][1] ) : '';
			$subject           = ! empty( $_POST['settings'][2] ) ? esc_attr( $_POST['settings'][2] ) : $subject;
			$post_id           = absint( $_POST['settings'][3] );
			$recaptcha_enabled = esc_attr( $_POST['settings'][4] );
			$newsletter        = isset( $_POST['settings'][5] ) ? esc_attr( $_POST['settings'][5] ) : '';


			if ( $recaptcha_enabled && empty( $data[$recaptcha_enabled] ) ) {
				wp_send_json_error( __( 'Please complete the recaptcha', 'blockstrap-page-builder-blocks' ) );
				wp_die();
			} elseif ( $recaptcha_enabled && ! empty( $data['g-recaptcha-response'] ) ) {
				$keys     = function_exists( 'blockstrap_get_option' ) ? blockstrap_get_option( 'blockstrap_recaptcha_keys' ) : get_option( 'blockstrap_recaptcha_keys' );
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
						wp_send_json_error( __( 'Recaptcha error, please refresh and try again', 'blockstrap-page-builder-blocks' ) );
						wp_die();
					}
				}
			} elseif ( $recaptcha_enabled && ! empty( $data[$recaptcha_enabled] ) ) {
				$valid = apply_filters( 'blockstrap_blocks_contact_form_captcha_valid', false, $data );

				if( is_wp_error( $valid ) ){
					wp_send_json_error( $valid->get_error_message() );
					wp_die();
				} elseif ( ! $valid ) {
					wp_send_json_error( __( 'Captcha error, please refresh and try again', 'blockstrap-page-builder-blocks' ) );
					wp_die();
				}

				// unset the captcha so it's not sent in the email
				unset( $data[$recaptcha_enabled] );
			}

			$email     = self::get_email( $to, $post_id );
			$bcc_email = self::get_email( $bcc, $post_id );
		} else {
			wp_send_json_error(__( 'There is a settings error with this contact form', 'blockstrap-page-builder-blocks' ));
			wp_die();
		}

		$subject = apply_filters( 'blockstrap_blocks_contact_email_subject', 'CF: ' . $subject, $_POST, $data, $fields );

		$sent = false;
		if ( $email ) {

			$headers = '';

			// from
			$from_email = sanitize_email( get_bloginfo('admin_email') );
			$headers = "From: " . stripslashes_deep( html_entity_decode( get_bloginfo('name'), ENT_COMPAT, 'UTF-8' ) ) . " <$from_email>\r\n";


			// If a GeoDirectory Contact form then set the reply to address to the submitter
			if ( 'gd_post_email' === $to && !empty($fields['field_email']['value'])) {
				$reply_to = sanitize_email( $fields['field_email']['value'] );
				$headers .= "Reply-To: " . $reply_to . "\r\n";
			}

			// Set content as HTML
			$headers .= "Content-Type: text/html; charset=\"" . get_option( 'blog_charset' ) . "\"\r\n";


			$sent = wp_mail( $email, $subject, $email_template, $headers );

			if ( $bcc_email ) {
				wp_mail( $bcc_email, $subject . ' - BCC ', $email_template, $headers );
			}
		}

		// maybe subscribe to newsletter
		if ( ! empty( $newsletter ) && 'noptin' === $newsletter && function_exists( 'add_noptin_subscriber' ) ) {
			$filtered          = array();
			$filtered['name']  = ! empty( $data['field_name'] ) ? esc_attr( $data['field_name'] ) : '';
			$filtered['email'] = ! empty( $data['field_email'] ) ? sanitize_email( $data['field_email'] ) : '';

			if ( ! empty( $filtered['email'] ) ) {
				// Add the subscriber's IP address.
				$address = noptin_get_user_ip();

				if ( ! empty( $address ) && '::1' !== $address ) {
					$filtered['ip_address'] = $address;
				}

				$filtered['tags']            = array();
				$filtered['_subscriber_via'] = 'BlockStrap Blocks';

				/**
				 * Filters subscriber details when adding a new subscriber via ajax.
				 *
				 * @since 1.2.4
				 */
				$filtered = apply_filters( 'noptin_add_ajax_subscriber_filter_details', wp_unslash( $filtered ), 0 );

				$inserted = add_noptin_subscriber( $filtered );

				do_action( 'noptin_add_ajax_subscriber', $inserted, 0 );
			}
		}

		do_action( 'blockstrap_blocks_after_contact_sent', $sent, $data, $fields );

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

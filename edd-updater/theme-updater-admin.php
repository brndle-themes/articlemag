<?php

/**
 * Theme updater admin page and functions.
 *
 * @package EDD Sample Theme
 */
class EDD_Articlemag_Theme_Updater_Admin {

	/**
	 * Variables required for the theme updater
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $remote_api_url	 = null;
	protected $theme_slug		 = null;
	protected $version			 = null;
	protected $author			 = null;
	protected $download_id		 = null;
	protected $renew_url		 = null;
	protected $strings			 = null;

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	function __construct( $config = array(), $strings = array() ) {
		$config = wp_parse_args( $config, array(
			'remote_api_url' => 'http://easydigitaldownloads.com',
			'theme_slug'	 => get_template(),
			'item_name'		 => '',
			'license'		 => '',
			'version'		 => '',
			'author'		 => '',
			'download_id'	 => '',
			'renew_url'		 => '',
			'beta'			 => false,
		) );

		// Set config arguments
		$this->remote_api_url	 = $config[ 'remote_api_url' ];
		$this->item_name		 = $config[ 'item_name' ];
		$this->theme_slug		 = sanitize_key( $config[ 'theme_slug' ] );
		$this->version			 = $config[ 'version' ];
		$this->author			 = $config[ 'author' ];
		$this->download_id		 = $config[ 'download_id' ];
		$this->renew_url		 = $config[ 'renew_url' ];
		$this->beta				 = $config[ 'beta' ];

		// Populate version fallback
		if ( '' == $config[ 'version' ] ) {
			$theme			 = wp_get_theme( $this->theme_slug );
			$this->version	 = $theme->get( 'Version' );
		}

		// Strings passed in from the updater config
		$this->strings = $strings;

		add_action( 'init', array( $this, 'updater' ) );
		//add_action( 'wp_ajax_articlemag_license_action', array( $this, 'articlemag_license_action_ajax' ) );
		//add_action( 'admin_init', array( $this, 'register_option' ) );
		//add_action( 'admin_init', array( $this, 'license_action' ) );
		//add_action( 'admin_menu', array( $this, 'license_menu' ) );
		add_action( 'update_option_' . FRAMEWORK_OPTION_NAME, array( $this, 'articlemag_license_action' ), 10 );
		add_filter( 'http_request_args', array( $this, 'disable_wporg_request' ), 5, 2 );
	}

	function articlemag_license_action( $old_value ) {

		$license		 = trim( cs_get_option( 'articlemag_license', '' ) );
		$license_action	 = cs_get_option( 'license_action', '' );

		if ( $license_action ) {
			if ( $license != $old_value[ 'articlemag_license' ] || $old_value[ 'license_action' ] == '' ) {
				$this->activate_license( $license );
			}
		} else {
			if ( $old_value[ 'license_action' ] == 1 ) {
				$this->deactivate_license( $license );
			}
		}
	}

	/**
	 * Function added to get license page url.
	 *
	 * since 2.0.1
	 */
	function get_license_page_url() {
		return admin_url( 'admin.php?page=articlemag' );
	}

	/**
	 * Creates the updater class.
	 *
	 * since 1.0.0
	 */
	function updater() {

		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}

		/* If there is no valid license key status, don't allow updates. */
		if ( get_option( $this->theme_slug . '_license_key_status', false ) != 'valid' ) {
			return;
		}

		if ( !class_exists( 'EDD_Theme_Updater' ) ) {
			// Load our custom theme updater
			include( dirname( __FILE__ ) . '/theme-updater-class.php' );
		}

		new EDD_Theme_Updater(
		array(
			'remote_api_url' => $this->remote_api_url,
			'version'		 => $this->version,
			'license'		 => trim( get_option( $this->theme_slug . '_license_key' ) ),
			'item_name'		 => $this->item_name,
			'author'		 => $this->author,
			'beta'			 => $this->beta
		), $this->strings
		);
	}

	/**
	 * Adds a menu item for the theme license under the appearance menu.
	 *
	 * since 1.0.0
	 */
	function license_menu() {

		$strings = $this->strings;

		// add_theme_page(
		// 	$strings['theme-license'],
		// 	$strings['theme-license'],
		// 	'manage_options',
		// 	$this->theme_slug . '-license',
		// 	array( $this, 'license_page' )
		// );
		// add_submenu_page(
		// 	'varuna-settings',
		// 	$strings['theme-license'],
		// 	$strings['theme-license'],
		// 	'manage_options',
		// 	$this->theme_slug . '-license',
		// 	array( $this, 'license_page' )
		// );
	}

	/**
	 * Outputs the markup used on the theme license page.
	 *
	 * since 1.0.0
	 */
	function license_page() {

		$strings	 = $this->strings;
		$license_key = trim( cs_get_option( 'articlemag_license', '' ) );

		$license = $license_key;
		$status	 = get_option( $this->theme_slug . '_license_key_status', false );

		// Checks license status to display under license key
		if ( !$license ) {
			$message = $strings[ 'enter-key' ];
		} else {
			set_transient( $this->theme_slug . '_license_message', $this->check_license(), ( 60 * 60 * 24 ) );
			$message = get_transient( $this->theme_slug . '_license_message' );
		}

		return $message;
	}

	/**
	 * Registers the option used to store the license key in the options table.
	 *
	 * since 1.0.0
	 */
	function register_option() {
		register_setting(
		$this->theme_slug . '-license', $this->theme_slug . '_license_key', array( $this, 'sanitize_license' )
		);
	}

	/**
	 * Sanitizes the license key.
	 *
	 * since 1.0.0
	 *
	 * @param string $new License key that was submitted.
	 * @return string $new Sanitized license key.
	 */
	function sanitize_license( $new ) {

		$old = cs_get_option( 'articlemag_license', '' );

		if ( $old && $old != $new ) {
			// New license has been entered, so must reactivate
			delete_option( $this->theme_slug . '_license_key_status' );
			delete_transient( $this->theme_slug . '_license_message' );
		}

		return $new;
	}

	/**
	 * Makes a call to the API.
	 *
	 * @since 1.0.0
	 *
	 * @param array $api_params to be used for wp_remote_get.
	 * @return array $response decoded JSON response.
	 */
	function get_api_response( $api_params ) {

		// Call the custom API.
		$verify_ssl	 = (bool) apply_filters( 'edd_sl_api_request_verify_ssl', true );
		$response	 = wp_remote_post( $this->remote_api_url, array( 'timeout' => 15, 'sslverify' => $verify_ssl, 'body' => $api_params ) );

		// Make sure the response came back okay.
		if ( is_wp_error( $response ) ) {
			wp_die( $response->get_error_message(), __( 'Error', 'articlemag' ) . $response->get_error_code() );
		}

		return $response;
	}

	/**
	 * Activates the license key.
	 *
	 * @since 1.0.0
	 */
	function activate_license( $license ) {
		//$license = trim( cs_get_option( 'articlemag_license', '' ) );
		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'	 => $license,
			'item_name'	 => urlencode( $this->item_name ),
			'url'		 => home_url()
		);

		$response = $this->get_api_response( $api_params );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.', 'articlemag' );
			}
		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( false === $license_data->success ) {

				switch ( $license_data->error ) {

					case 'expired' :

						$message = sprintf(
						__( 'Your license key expired on %s.', 'articlemag' ), date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;

					case 'revoked' :

						$message = __( 'Your license key has been disabled.', 'articlemag' );
						break;

					case 'missing' :

						$message = __( 'Invalid license.', 'articlemag' );
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message = __( 'Your license is not active for this URL.', 'articlemag' );
						break;

					case 'item_name_mismatch' :

						$message = sprintf( __( 'This appears to be an invalid license key for %s.', 'articlemag' ), 'Articlemag' );
						break;

					case 'no_activations_left':

						$message = __( 'Your license key has reached its activation limit.', 'articlemag' );
						break;

					default :

						$message = __( 'An error occurred, please try again.', 'articlemag' );
						break;
				}

				if ( !empty( $message ) ) {
					$base_url	 = $this->get_license_page_url();
					$redirect	 = add_query_arg( array( 'sl_theme_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

					wp_redirect( $redirect );
					exit();
				}
			}
		}

		// $response->license will be either "active" or "inactive".
		if ( $license_data && isset( $license_data->license ) ) {
			update_option( $this->theme_slug . '_license_key_status', $license_data->license );
			delete_transient( $this->theme_slug . '_license_message' );
		}

		wp_redirect( $this->get_license_page_url() );
		exit();
	}

	/**
	 * Deactivates the license key.
	 *
	 * @since 1.0.0
	 */
	function deactivate_license( $license ) {
		//$license = trim( cs_get_option( 'articlemag_license', '' ) );
		// Retrieve the license from the database.
		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'	 => $license,
			'item_name'	 => urlencode( $this->item_name ),
			'url'		 => home_url()
		);

		$response = $this->get_api_response( $api_params );
		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.', 'articlemag' );
			}
		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed"
			if ( $license_data && ( $license_data->license == 'deactivated' ) ) {
				delete_option( $this->theme_slug . '_license_key_status' );
				delete_transient( $this->theme_slug . '_license_message' );
			}
		}

		if ( !empty( $message ) ) {
			$base_url	 = $this->get_license_page_url();
			$redirect	 = add_query_arg( array( 'sl_theme_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}

		wp_redirect( $this->get_license_page_url() );
		exit();
	}

	/**
	 * Constructs a renewal link
	 *
	 * @since 1.0.0
	 */
	function get_renewal_link() {

		// If a renewal link was passed in the config, use that
		if ( '' != $this->renew_url ) {
			return $this->renew_url;
		}

		// If download_id was passed in the config, a renewal link can be constructed
		$license_key = trim( cs_get_option( 'articlemag_license', '' ) );
		if ( '' != $this->download_id && $license_key ) {
			$url = esc_url( $this->remote_api_url );
			$url .= '/checkout/?edd_license_key=' . $license_key . '&download_id=' . $this->download_id;
			return $url;
		}

		// Otherwise return the remote_api_url
		return $this->remote_api_url;
	}

	/**
	 * Checks if a license action was submitted.
	 *
	 * @since 1.0.0
	 */
	function license_action() {

		if ( isset( $_POST[ $this->theme_slug . '_license_activate' ] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->activate_license();
			}
		}

		if ( isset( $_POST[ $this->theme_slug . '_license_deactivate' ] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->deactivate_license();
			}
		}
	}

	/**
	 * Checks if license is valid and gets expire date.
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	function check_license() {

		$license = trim( cs_get_option( 'articlemag_license', '' ) );
		$strings = $this->strings;

		$api_params = array(
			'edd_action' => 'check_license',
			'license'	 => $license,
			'item_name'	 => urlencode( $this->item_name ),
			'url'		 => home_url()
		);

		$response = $this->get_api_response( $api_params );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = $strings[ 'license-status-unknown' ];
			}
		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			// If response doesn't include license data, return
			if ( !isset( $license_data->license ) ) {
				$message = $strings[ 'license-status-unknown' ];
				return $message;
			}

			// We need to update the license status at the same time the message is updated
			if ( $license_data && isset( $license_data->license ) ) {
				update_option( $this->theme_slug . '_license_key_status', $license_data->license );
			}

			// Get expire date
			$expires = false;
			if ( isset( $license_data->expires ) && 'lifetime' != $license_data->expires ) {
				$expires	 = date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) );
				$renew_link	 = '<a href="' . esc_url( $this->get_renewal_link() ) . '" target="_blank">' . $strings[ 'renew' ] . '</a>';
			} elseif ( isset( $license_data->expires ) && 'lifetime' == $license_data->expires ) {
				$expires = 'lifetime';
			}

			// Get site counts
			$site_count		 = $license_data->site_count;
			$license_limit	 = $license_data->license_limit;

			// If unlimited
			if ( 0 == $license_limit ) {
				$license_limit = $strings[ 'unlimited' ];
			}

			if ( $license_data->license == 'valid' ) {
				$message = $strings[ 'license-key-is-active' ] . ' ';
				if ( isset( $expires ) && 'lifetime' != $expires ) {
					$message .= sprintf( $strings[ 'expires%s' ], $expires ) . ' ';
				}
				if ( isset( $expires ) && 'lifetime' == $expires ) {
					$message .= $strings[ 'expires-never' ];
				}
				if ( $site_count && $license_limit ) {
					$message .= sprintf( $strings[ '%1$s/%2$-sites' ], $site_count, $license_limit );
				}
			} else if ( $license_data->license == 'expired' ) {
				if ( $expires ) {
					$message = sprintf( $strings[ 'license-key-expired-%s' ], $expires );
				} else {
					$message = $strings[ 'license-key-expired' ];
				}
				if ( $renew_link ) {
					$message .= ' ' . $renew_link;
				}
			} else if ( $license_data->license == 'invalid' ) {
				$message = $strings[ 'license-keys-do-not-match' ];
			} else if ( $license_data->license == 'inactive' ) {
				$message = $strings[ 'license-is-inactive' ];
			} else if ( $license_data->license == 'disabled' ) {
				$message = $strings[ 'license-key-is-disabled' ];
			} else if ( $license_data->license == 'site_inactive' ) {
				// Site is inactive
				$message = $strings[ 'site-is-inactive' ];
			} else {
				$message = $strings[ 'license-status-unknown' ];
			}
		}

		return $message;
	}

	/**
	 * Disable requests to wp.org repository for this theme.
	 *
	 * @since 1.0.0
	 */
	function disable_wporg_request( $r, $url ) {

		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
			return $r;
		}

		// Decode the JSON response
		$themes = json_decode( $r[ 'body' ][ 'themes' ] );

		// Remove the active parent and child themes from the check
		$parent	 = get_option( 'template' );
		$child	 = get_option( 'stylesheet' );
		unset( $themes->themes->$parent );
		unset( $themes->themes->$child );

		// Encode the updated JSON response
		$r[ 'body' ][ 'themes' ] = json_encode( $themes );

		return $r;
	}

}

/**
 * This is a means of catching errors from the activation method above and displyaing it to the customer
 */
function edd_sample_theme_admin_notices() {
	if ( isset( $_GET[ 'sl_theme_activation' ] ) && !empty( $_GET[ 'message' ] ) ) {

		switch ( $_GET[ 'sl_theme_activation' ] ) {

			case 'false':
				$message = urldecode( $_GET[ 'message' ] );
				?>
				<div class="error">
					<p><?php echo $message; ?></p>
				</div>
				<?php
				break;

			case 'true':
			default:

				break;
		}
	}
}

add_action( 'admin_notices', 'edd_sample_theme_admin_notices' );

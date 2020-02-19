<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * New Articlemag Theme Updater
 *
 * @since 6.2.0
 * @version 1.1.0
 *
 */
if ( ! function_exists( 'cs_pre_set_site_transient_update_themes' ) ) {
  function cs_pre_set_site_transient_update_themes( $updates ) {

    if ( ! empty( $updates->checked ) ) {

      $purchase_code = cs_get_option( 'purchase_code' );

      //
      // Check for purchase code
      if( preg_match( '/^(\w{8})-((\w{4})-){3}(\w{12})$/', $purchase_code ) ) {

        $item_id       = '8815770';
        $api_url       = 'http://codestarthemes.com/themes/articlemagwp/updates/verify.php';
        $data          = get_transient( 'cs_get_theme_update' );
        $wp_get_theme  = wp_get_theme();
        $current_theme = ( $wp_get_theme->parent() ) ? $wp_get_theme->parent() : $wp_get_theme;

        if( empty( $data ) ) {

          $response   = wp_remote_post( $api_url, array(
            'method'  => 'POST',
            'timeout' => 30,
            'body'    => array(
              'item_id'       => $item_id,
              'item_version'  => $current_theme->Version,
              'purchase_code' => $purchase_code,
            )
          ) );

          if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) == 200 ) {

            $data = json_decode( wp_remote_retrieve_body( $response ), true );

            if( empty( $data['error'] ) ) {
              set_transient( 'cs_get_theme_update', $data, 24 * HOUR_IN_SECONDS );
            }

          }

        }

        if( ! empty( $data['new_version'] ) && ! empty( $data['package'] ) && version_compare( $current_theme->Version, $data['new_version'], '<' ) ) {

          $updates->response[$current_theme->Stylesheet] = array(
            'url'         => 'http://themeforest.net/item/theme/'. $item_id,
            'package'     => $data['package'],
            'new_version' => $data['new_version'],
          );

        }

      }

    }

    return $updates;

  }
  add_filter( 'pre_set_site_transient_update_themes', 'cs_pre_set_site_transient_update_themes' );
}

/**
 *
 * Force check update theme
 *
 * @since 6.3.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_force_check_update_theme' ) ) {
  function cs_force_check_update_theme() {
    if( ! empty( $_GET['force-check'] ) ) {
      delete_transient( 'cs_get_theme_update' );
    }
  }
  add_action( 'init', 'cs_force_check_update_theme' );
}

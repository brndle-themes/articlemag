<?php
/**
 *
 * Current Year Shortcode
 * @since 1.0.0
 * @version 1.1.0
 *
 */
if( ! function_exists( 'cs_current_year' ) ) {
  function cs_current_year() {
    return date('Y');
  }
  add_shortcode( 'cs_current_year', 'cs_current_year' );
}

/**
 *
 * Home URL Shortcode
 * @version 1.0.0
 * @since 1.1.0
 *
 */
if( ! function_exists( 'cs_home_url' ) ) {
  function cs_home_url() {
    return esc_url( home_url( '/' ) );
  }
  add_shortcode( 'cs_home_url', 'cs_home_url' );
}
<?php
/**
 *
 * Clear Shortcode
 * @since 1.0.0
 * @version 1.1.0
 *
 */
if( ! function_exists( 'cs_clear' ) ) {
  function cs_clear( $atts, $content = '', $key = '' ) {
    return '<hr class="cs-clear">';
  }
  add_shortcode( 'cs_clear', 'cs_clear' );
}
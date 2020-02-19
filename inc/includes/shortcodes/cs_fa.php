<?php
/**
 *
 * Font Awesome Shortcode
 * @since 1.0.0
 * @version 1.1.0
 *
 */
if( ! function_exists( 'cs_fa' ) ) {
  function cs_fa( $atts, $content = '', $key = '' ) {
    extract( shortcode_atts( array(
      'icon'  => '',
      'class' => '',
      'style' => '',
    ), $atts ) );

    $style = ( $style ) ? ' style="'. $style .'"' : '';
    $class = ( $class ) ? ' '. $class : '';

    return '<i class="fa fa-'. $icon . $class .'"'. $style .'></i>';
  }
  add_shortcode( 'cs_fa', 'cs_fa' );
}
<?php
/**
 *
 * The Template for displaying all pages/posts header.
 * @since 1.0.0
 * @version 1.3.0
 *
 */

global $post;

// set post meta
$cs_post_id         = ( isset( $post ) ) ? $post->ID : 0;
$cs_post_id         = ( is_home() ) ? get_option( 'page_for_posts' ) : $cs_post_id;
$cs_post_id         = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $cs_post_id;
$cs_post_meta       = get_post_meta( $cs_post_id, '_custom_page_options', true );

// do not show header in front page
if( is_front_page() && ! is_woocommerce_shop() && empty( $cs_post_meta['header_transparent'] ) && empty( $cs_post_meta['force_show_header'] ) ) { return; }

// check page header-active
if( ! empty( $cs_post_meta['disable_header'] ) && empty( $cs_post_meta['force_show_header'] ) ) { return; }

// header classes
$cs_classes         = ( ! empty( $cs_post_meta['background'] ) || ! empty( $cs_post_meta['video'] ) ) ? 'cs-section cs-parallax' : '';
$cs_classes        .= ( ! empty( $cs_post_meta['cover'] ) ) ? ' cs-section-cover-bg' : '';
$cs_classes        .= ( ! empty( $cs_post_meta['parallax'] ) ) ? ' parallax' : '';
$cs_classes        .= ( ! empty( $cs_post_meta['position'] ) && $cs_post_meta['position'] == 'all' ) ? ' text-center' : '';
$cs_classes         = ( $cs_classes ) ? ' class="' . $cs_classes . '"' : '';

// background and parallax speed
$cs_background      = ( ! empty( $cs_post_meta['background'] ) ) ? cs_option2background( $cs_post_meta ) : '';
$cs_parallax_speed  = ( ! empty( $cs_post_meta['parallax'] ) && ! empty( $cs_post_meta['speed'] ) ) ? ' data-parallax-speed="'. $cs_post_meta['speed'] .'"' : '';

// fluid header
$cs_is_fluid        = ( ! empty( $cs_post_meta['fluid'] ) ) ? '-fluid' : '';
$cs_is_fluid_col    = ( ! empty( $cs_post_meta['fluid'] ) ) ? '-fluid ' : '-12 ';
$cs_padding         = ( ! empty( $cs_post_meta['padding'] ) ) ? $cs_post_meta['padding'] : 'md-padding';
$cs_padding_top     = ( ! empty( $cs_post_meta['top'] ) ) ? 'padding-top:'. cs_validpx( $cs_post_meta['top'] ) .';' : '';
$cs_padding_bottom  = ( ! empty( $cs_post_meta['bottom'] ) ) ? 'padding-bottom:'. cs_validpx( $cs_post_meta['bottom'] ) .';' : '';
$cs_padding_style   = ( $cs_padding == 'custom-padding' && ( $cs_padding_top || $cs_padding_bottom ) ) ? ' style="'. $cs_padding_top . $cs_padding_bottom .'"' : '';

// element positions
$cs_center_title    = ( ! empty( $cs_post_meta['position'] ) && $cs_post_meta['position'] == 'title' ) ? ' text-center' : '';

// page title
$cs_title           = ( ! empty( $cs_post_meta['page_title'] ) ) ? cs_multilang_value( $cs_post_meta['page_title'] ) : get_the_title( $cs_post_id );
$cs_title           = ( is_tax() ) ? single_cat_title( '', false ) : $cs_title;
$cs_title_slogan    = ( ! empty( $cs_post_meta['page_title_slogan'] ) ) ? ' <small>'. cs_multilang_value( $cs_post_meta['page_title_slogan'] ) . '</small>' : '';

// header output
echo '<section id="page-header"'. $cs_classes . $cs_parallax_speed . $cs_background .'>';

  // container
  echo '<div class="container'. $cs_is_fluid .'">';
  echo '<div class="row">';
  echo '<div class="col-md'. $cs_is_fluid_col . $cs_padding .'"'. $cs_padding_style .'>';

  // page title
  if ( empty( $cs_post_meta['disable_title'] ) ) {
    echo '<h1 class="page-title'. $cs_center_title .'">'. $cs_title . $cs_title_slogan .'</h1>';
  }

  // custom content
  if ( ! empty( $cs_post_meta['custom_content'] ) ) {
    echo '<div class="header-content">';
    echo do_shortcode( cs_multilang_value( $cs_post_meta['custom_content'] ) );
    echo '</div>';
  }

  echo '</div>';

  // breadcrumb
  if ( empty( $cs_post_meta['breadcrumb'] ) ) {
    echo cs_breadcrumb();
  }

  echo '</div>';
  echo '</div>';

  // section overlay
  if ( ! empty( $cs_post_meta['overlay'] ) ) {
    $overlay_color    = ( ! empty( $cs_post_meta['overlay_color'] ) ) ? $cs_post_meta['overlay_color'] : '#000000';
    $overlay_opacity  = ( ! empty( $cs_post_meta['overlay_opacity'] ) ) ? $cs_post_meta['overlay_opacity'] : 0.5;
    echo '<span class="section-overlay" style="background-color: '. cs_hex2rgba( $overlay_color, $overlay_opacity ) .';"></span>';
  }

  // video section controlller
  if( ! empty( $cs_post_meta['video'] ) ) {

    $cs_mp4    = ( ! empty( $cs_post_meta['mp4'] ) ) ? $cs_post_meta['mp4'] : '';
    $cs_ogv    = ( ! empty( $cs_post_meta['ogv'] ) ) ? $cs_post_meta['ogv'] : '';
    $cs_webm   = ( ! empty( $cs_post_meta['webm'] ) ) ? $cs_post_meta['webm'] : '';
    $cs_loop   = ( ! empty( $cs_post_meta['loop'] ) ) ? $cs_post_meta['loop'] : '';
    $cs_muted  = ( ! empty( $cs_post_meta['muted'] ) ) ? $cs_post_meta['muted'] : '';

    if( $cs_mp4 || $cs_ogv || $cs_webm ) {

      // include mediaelement library
      wp_enqueue_style( 'mediaelement' );
      wp_enqueue_script( 'mediaelement' );

      $cs_poster = ( $cs_background ) ? ' poster="'. cs_blank_png() .'"' : '';
      $cs_muted  = ( $cs_muted ) ? ' muted' : '';
      $cs_loop   = ( $cs_loop ) ? ' loop' : '';

      echo '<div class="video-section-wrap">';
      echo '<div class="video-wrap">';
      echo '<video width="1920" height="1080" autoplay'. $cs_loop . $cs_muted . $cs_poster .'>';
      echo ( $cs_mp4 ) ? '<source type="video/mp4" src="'. $cs_mp4 .'"></source>'   : '';
      echo ( $cs_ogv ) ? '<source type="video/ogv" src="'. $cs_ogv .'"></source>'   : '';
      echo ( $cs_webm ) ? '<source type="video/webm" src="'. $cs_webm .'"></source>' : '';
      echo '</video>';
      echo '</div>';
      echo '</div>';

    }

  }


echo '</section><!-- /page-header -->';
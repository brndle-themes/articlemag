<?php
/**
 *
 * Framework Get Option
 * @since 1.0.0
 * @version 1.0.1
 *
 */
if ( ! function_exists( 'cs_get_option' ) ) {
  function cs_get_option( $option_name = '', $default = '' ) {

    $options      = get_option( FRAMEWORK_OPTION_NAME );
    $customizes   = get_option( CUSTOMIZE_OPTION_NAME );
    $options      = wp_parse_args( $customizes, $options );
    $options      = apply_filters( 'cs_get_option', $options ); // Preview Helper!

    if( isset( $options[$option_name] ) && isset( $option_name ) ) {

      return $options[$option_name];

    } else {

      if( isset( $options['skin'] ) && ( $options['skin'] === 'accent' || $options['skin'] === 'custom' ) ) {

        $get_predefined_colors = get_predefined_colors( $options['skin'] );

        if( array_key_exists( $option_name, $get_predefined_colors) ) {

          return $get_predefined_colors[$option_name];

        }

      }

      return ( ! empty( $default ) ) ? $default : null;

    }

  }
}

/**
 *
 * Framework Set Option
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_set_option' ) ) {
  function cs_set_option( $option_name = '', $new_value = '' ) {

    $options    = get_option( FRAMEWORK_OPTION_NAME );
    $customizes = get_option( CUSTOMIZE_OPTION_NAME );

    if( isset( $options[$option_name] ) ) {

      $options[$option_name] = $new_value;
      update_option( FRAMEWORK_OPTION_NAME, $options );

    } else if( isset( $customizes[$option_name] ) ) {

      $customizes[$option_name] = $new_value;
      update_option( CUSTOMIZE_OPTION_NAME, $customizes );

    } else {

      return;

    }

  }
}

/**
 *
 * Framework Get All Option
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_get_all_option' ) ) {
  function cs_get_all_option() {

    $options    = get_option( FRAMEWORK_OPTION_NAME );
    $customizes = get_option( CUSTOMIZE_OPTION_NAME );
    $options    = wp_parse_args( $customizes, $options );

    return $options;

  }
}

/**
 *
 * Framework Fields
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'cs_get_field' ) ) {
  function cs_get_field( $field = array(), $value = '', $unique = '' ) {

    $unique = ( isset( $unique ) ) ? $unique : '';

    // check for field type
    if ( isset( $field['type'] ) ) {

      // set class name
      $class = 'CSFramework_Option_' . $field['type'];

      // check class
      if( class_exists( $class ) ) {

        $el_wrap_id     = ( isset( $field['id'] ) ) ? ' id="element-'. $field['id'] .'"' : '';
        $el_class       = ( isset( $field['el_class'] ) ) ? ' class_' . $field['el_class'] : '';
        $el_wrap_class  = ( !isset( $field['pseudo'] ) )  ? 'cs-element-wrap' : 'pseudo-field';

        // add dependencies attributes
        $depend = '';
        $hidden = '';
        $sub    = ( isset( $field['sub'] ) ) ? 'sub-': '';

        if ( isset( $field['dependency'] ) ) {
          $hidden  = ' hidden';
          $depend .= ' data-'. $sub .'controller="'. $field['dependency'][0] .'"';
          $depend .= ' data-'. $sub .'condition="'. $field['dependency'][1] .'"';
          $depend .= " data-". $sub ."value='". htmlspecialchars( $field['dependency'][2] ) ."'";
        }

        $fieldset_class = ( isset( $field['title'] ) )    ? 'cs-element-fieldset ' : '';

        echo '<div'. $el_wrap_id .' class="'. $el_wrap_class . $el_class . $hidden .'"' . $depend.'>';

        if( isset( $field['title'] ) ) {
          $field_desc = ( isset( $field['desc'] ) ) ? '<p class="cs-text-desc">'. $field['desc'] .'</p>' : '';
          echo '<div class="cs-element-title"><h4>' . $field['title'] . '</h4>'. $field_desc .'</div>';
        }

        echo '<div class="'. $fieldset_class .'cs_field cs_field_'. $field['type'] .'">';


        $value   = ( !isset( $value ) && isset( $field['default'] ) ) ? $field['default'] : $value;
        $value   = ( isset( $field['value'] ) ) ? $field['value'] : $value;
        $element = new $class( $field, $value, $unique );
        $element->output();

        echo '</div>';

        echo '<div class="clear"></div>';

        echo '</div>';

      } else {
        echo '<p><span class="label label-danger">Field class is not available.</span></p>';
      }

    } else {
      echo '<p><span class="label label-danger">Field type is not available.</span></p>';
    }

  }
}

/**
 *
 * Set predefined colors for reset!
 * @since 1.0.0
 *
 */
function get_predefined_colors( $skin = '' ) {

  $skin   = ( !empty( $skin ) ) ? $skin : cs_get_option( 'skin' );
  $accent = '#293951';

  if ( $skin == 'accent' ) {

    $predefined_colors    = array( 'accent_color' => $accent );

  } else if( $skin == 'custom' ) {

    $predefined_colors             = array(
      // accent color
      'accent_color'               => $accent,

      // top bar
      'top_bar_bg'                 => '#f1f1f1',
      'top_bar_border'             => '#e8e8e8',
      'top_bar_text'               => '#555555',
      'top_bar_link'               => '#555555',
      'top_bar_link_hover'         => $accent,
      'top_bar_icon_color'         => '#555555',
      'top_bar_social_color'       => '#555555',
      'top_bar_social_hover'       => $accent,

      //header
      'header_bg'                  => '#ffffff',
      'header_border'              => 'rgba(255, 255, 255, 0.1)',
      'header_link'                => '#555555',
      'header_link_hover'          => $accent,

      // submenu
      'submenu_bg'                 => '#ffffff',
      'submenu_bg_hover'           => '#f8f8f8',
      'submenu_border'             => '#eeeeee',
      'submenu_link'               => '#555555',
      'submenu_link_hover'         => $accent,

      // mega-menu
      'submenu_mega_title_color'   => '#555555',
      'submenu_mega_title_bgcolor' => '#f5f5f5',
      'submenu_mega_title_border'  => '#eeeeee',

      // page-header
      'page_header_bg'             => $accent,
      'page_header_color'          => '#ffffff',
      'breadcrumb_bgcolor'         => 'rgba(0,0,0,0.5)',
      'breadcrumb_color'           => '#ffffff',
      'breadcrumb_link_color'      => '#ffffff',

      // footer
      'footer_bg'                  => '#222222',
      'footer_color'               => '#999999',
      'footer_link_color'          => '#cccccc',
      'footer_link_hover'          => '#ffffff',
      'footer_title_color'         => '#ffffff',
      'footer_border_color'        => '#444444',

      // footer before and after
      'footer_ba_bg'               => $accent,
      'footer_ba_color'            => '#ffffff',
      'footer_ba_link_color'       => '#ffffff',
      'footer_ba_link_hover'       => '#ffffff',
      'footer_ba_title_color'      => '#ffffff',
      'footer_ba_border_color'     => '#ffffff',

      // copyright
      'copyright_bg'               => '#111111',
      'copyright_color'            => '#555555',
      'copyright_link_color'       => '#555555',
      'copyright_link_hover'       => '#ffffff',

      // logo bar
      'logo_bar_bg'                => '#ffffff',
      'logo_bar_color'             => '#555555',
    );

  }

  $predefined_colors = apply_filters( 'cs_predefined_colors', $predefined_colors );

  return $predefined_colors;
}
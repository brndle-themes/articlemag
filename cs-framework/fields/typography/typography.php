<?php
/**
 *
 * Field: Typography
 *
 * @package CSFramework_Options_API
 * @version 1.0.0
 * @since 1.0.0
 *
 */
class CSFramework_Option_typography extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    // set defaults
    $defaults         = array(
      'family'        => 'Arial, Helvetica, sans-serif',
      'variant'       => 400,
      'fontsize'      => '13px',
      'lineheight'    => '1.65em',
      'letterspacing' => 0,
    );

    $defaults     = wp_parse_args( $this->field['default'], $defaults );
    $this->value  = wp_parse_args( $this->value, $defaults );


    echo $this->element_before();

    $websafe_fonts = cs_get_websafe_fonts();

    // default variants
    $default_variants = array(
      '400'           => 'regular',
      '400italic'     => 'italic',
      '700'           => '700',
      '700italic'     => '700italic',
      'inherit'       => 'inherit',
    );

    // custom variants
    $custom_variants  = array( '400' => 'regular' );

    // get google fonts from fonts.json
    $webfonts = array();
    $fonts    = json_decode( file_get_contents( FRAMEWORK_DIR.'/fields/typography/fonts.json' ) );
    foreach ( $fonts->items as $key => $font ) {
      $webfonts[$font->family] = $font->variants;
    }

    $chosen_rtl = is_rtl() ? ' chosen-rtl' : '';

    // begin typography
    echo '<div class="cs-typography">';
    echo '<ul>';

    // begin font family selector
    echo '<li class="cs-family">';
    echo '<select name="'. $this->element_name('[family]') .'" class="chosen typography-select'. $chosen_rtl .'" data-atts="family">';

      do_action( 'cs_font_family', $this->value['family'] );

      echo '<optgroup label="Web Safe Fonts">';
        foreach ($websafe_fonts as $key => $value) {
          echo '<option value="'. $value .'" data-type="safefonts"'. selected($value, $this->value['family'], true ) .'>'. $value .'</option>';
        }
      echo '</optgroup>';
      echo '<optgroup label="Google Fonts">';
        foreach ($webfonts as $key => $value) {
          echo '<option value="'. $key .'" data-type="googlefonts"'. selected($key, $this->value['family'], true ) .'>'. $key .'</option>';
        }
      echo '</optgroup>';

    echo '</select>';
    echo '</li>';
    // end font family selector

    $variants = ( cs_is_googe_font( $this->value['family'] ) && isset( $webfonts[$this->value['family']] ) ) ? $webfonts[$this->value['family']] : $default_variants;
    $variants = ( cs_is_custom_font( $this->value['family'] ) ) ? $custom_variants : $variants;

    echo '<li class="cs-variant">';
    echo '<select name="'. $this->element_name('[variant]') .'" class="chosen typography-variant-select'. $chosen_rtl .'" data-atts="variant">';
    foreach ($variants as $key => $value) {
      echo '<option value="'. $value .'"'. $this->checked( $this->value['variant'], $value, 'selected' ) .'>'. $value .'</option>';
    }
    echo '</select>';
    echo '</li>';


    if( $defaults['fontsize'] !== false ){
      echo '<li class="cs-size">';
      echo '<span class="cs-typography-title">font-size</span> <input type="text" name="'. $this->element_name('[fontsize]') .'" value="'. $this->value['fontsize'] .'" size="3" class="typography-fontsize" data-min="1" data-max="100" data-step="1" data-atts="size">';
      echo '</li>';
    }


    if( $this->field['default']['lineheight'] !== false ){
      echo '<li class="cs-line-height">';
      echo '<span class="cs-typography-title">line-height</span><input type="text" name="'. $this->element_name('[lineheight]') .'" value="'. $this->value['lineheight'] .'"size="3" class="typography-line-height" data-min="1" data-max="100" data-step="1" data-atts="lineheight">';
      echo '</li>';
    }


    if( $this->field['default']['letterspacing'] !== false ){
      echo '<li class="cs-letter-spacing">';
      echo '<span class="cs-typography-title">letter-spacing</span><input type="text" name="'. $this->element_name('[letterspacing]') .'" value="'. $this->value['letterspacing'] .'"size="3" class="typography-letter-spacing" data-min="-10" data-max="10" data-step="0.1" data-atts="letterspacing">';
      echo '</li>';
    }

    echo '</ul>';
    echo '</div>';

    echo $this->element_after();

  }

}
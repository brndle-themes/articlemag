<?php
/**
 *
 * Field: Input Checkbox
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_color_picker extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();

    $extra_name     = ( isset( $this->field['transparency'] ) ) ? '[color]' : '' ;
    $color_value    = ( isset( $this->field['transparency'] ) ) ? $this->value['color'] : $this->value ;
    $opacity_value  = ( isset( $this->field['transparency'] ) && !empty( $this->value['opacity'] )) ? $this->value['opacity'] : 0.7;
    $transparency   = ( isset( $this->value['transparency'] ) ) ? $this->value['transparency'] : '' ;

    echo '<ul'. $this->element_class('cs-color-wrap') .'>';

    if( isset( $this->field['options'] ) ){

      foreach ( $this->field['options'] as $key => $value ) {
        echo '<li><span class="color-label">'. $value .'</span><input type="text" name="'. $this->element_name('['.$key.']') .'" value="'. $this->value[$key] .'" class="cs-color-picker" data-atts="'. $key .'"/></li>';
      }

    } else {

      echo '<li><input type="text" name="'. $this->element_name( $extra_name ) .'" value="'. $color_value .'" class="cs-color-picker"'. $this->element_attributes() .'/></li>';

      if( isset( $this->field['transparency'] ) ) {
        echo '<li><label><input type="checkbox" name="'. $this->element_name('[transparency]') .'" value="1" data-depend-id="'. $this->field['id'] .'_transparency" data-atts="transparency"'. checked( $transparency, 1, false ) .'/> Color Opacity</label></li>';
        echo '<li>';
        echo '<div class="pseudo-field" data-depends-on="'. $this->field['id'] .'_transparency">';
        echo '<input type="text" name="'. $this->element_name('[opacity]') .'" size="3" class="cs-ui-spinner" data-min="0" data-max="1" data-step="0.1" data-atts="opacity" value="'. $opacity_value .'" />';
        echo '</div>';
        echo '</li>';
      }

    }
    echo '</ul>';

    echo $this->element_after();

  }

}
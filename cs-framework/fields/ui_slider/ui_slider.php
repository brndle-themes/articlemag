<?php
/**
 *
 * Field: UI Slider
 * @version 1.0.0
 * @since 1.0.0
 *
 */
class CSFramework_Option_ui_slider extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique     = $unique;
  }

  public function output() {

    extract( $this->field['settings'] );

    echo $this->element_before();
    
    $unit = ( isset( $this->field['unit'] ) ) ? ' <small>'. $this->field['unit'] .'</small>' : '';

    echo '<div'. $this->element_class('cs-ui-slider') .'>';
    echo '<div class="ui-slider-block" data-min="'. $min .'" data-max="'. $max .'" data-step="'. $step .'"></div>';
    echo '<div class="cs-ui-input"><input type="text" name="'. $this->element_name() .'" value="'. $this->value .'" size="3"'. $this->element_attributes() .'/>'. $unit .'</div>';
    echo '<div class="clear"></div>';
    echo '</div>';

    echo $this->element_after();

  }

}
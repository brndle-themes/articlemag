<?php
/**
 *
 * Field: UI Spinner
 * @version 1.0.0
 * @since 1.0.0
 *
 */
class CSFramework_Option_ui_spinner extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    extract( $this->field['settings'] );

    echo $this->element_before();
    $unit = ( isset( $this->field['unit'] ) ) ? ' <small>'. $this->field['unit'] .'</small>' : '';
    echo '<div class="cs-spinner-wrap">';
    echo '<input type="text" name="'. $this->element_name() .'" value="'. $this->value .'" size="5" data-min="'. $min .'" data-max="'. $max .'" data-step="'. $step .'"'. $this->element_class('cs-ui-spinner') . $this->element_attributes() .'/>'. $unit;
    echo '</div>';
    echo $this->element_after();

  }

}
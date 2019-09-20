<?php
/**
 *
 * Field: Input Number
 * @version 1.0.0
 * @since 1.0.0
 *
 */
class CSFramework_Option_number extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();
    $unit = ( isset( $this->field['unit'] ) ) ? '<i>'. $this->field['unit'] .'</i>' : '';
    echo '<input type="number" name="'. $this->element_name() .'" value="'. $this->value .'"'. $this->element_class() . $this->element_attributes() .'/>'. $unit;
    echo $this->element_after();

  }

}
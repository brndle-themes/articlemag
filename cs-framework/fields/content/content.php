<?php
/**
 *
 * Field: Input Checkbox
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_content extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();
    echo $this->field['content'];
    echo $this->element_after();

  }

}
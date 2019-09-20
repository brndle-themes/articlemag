<?php
/**
 *
 * Field: Heading
 * @since 1.4.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_heading extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();
    echo '<h3>'. $this->field['content'] .'</h3>';
    echo $this->element_after();

  }

}
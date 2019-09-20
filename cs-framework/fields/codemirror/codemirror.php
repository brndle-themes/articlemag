<?php
/**
 *
 * Field: CodeMirror
 *
 * @package CSFramework_Options_API
 * @version 1.0.0
 * @since 1.1.0
 *
 */
class CSFramework_Option_codemirror extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();

    echo '<textarea name="'. $this->element_name() .'"'. $this->element_class() . $this->element_attributes() .'>'. $this->value .'</textarea>';

    echo $this->element_after();

  }

}
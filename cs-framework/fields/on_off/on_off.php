<?php
/**
 *
 * Field: ON-OFF
 * @version 1.0.0
 * @since 1.0.0
 *
 */
class CSFramework_Option_on_off extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();
    $label = ( isset( $this->field['label'] ) ) ? '<span class="cs-text-desc">'. $this->field['label'] . '</span>' : '';
    echo '<label class="switch switch-green"><input type="checkbox" name="'. $this->element_name() .'" value="1"'. $this->element_class('switch-input') . $this->element_attributes() . checked( $this->value, 1, false ) .'/><span class="switch-label" data-on="On" data-off="Off"></span><span class="switch-handle"></span></label>' . $label;
    echo $this->element_after();

  }

}
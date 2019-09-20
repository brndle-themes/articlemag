<?php
/**
 *
 * Field: Icon
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_icon extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();

    $hidden = ( empty( $this->value ) ) ? ' hidden' : '';
    $icon = ( !empty( $this->value ) ) ? ' class="'. cs_icon_class( $this->value ) . '"' : '';

    echo '<div class="cs-icon-select">';
    echo '<span class="icon-preview'. $hidden .'"><span'. $icon .'></span></span>';
    echo '<button class="button button-primary icon-add">Add Icon</button>';
    echo '<button class="button cs-button-remove icon-remove'. $hidden .'">Remove Icon</button>';
    echo '<input type="hidden" name="'. $this->element_name() .'" value="'. $this->value .'"'. $this->element_class('icon-value') . $this->element_attributes() .'/>';
    echo '</div>';

    echo $this->element_after();

  }

}
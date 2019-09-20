<?php
/**
 *
 * Field: Input Radio
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_radio extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output(){

    echo $this->element_before();

    if( isset( $this->field['options'] ) ) {

      $options  = $this->field['options'];
      $options  = ( is_array( $options ) ) ? $options : $this->element_data( $options );
      
      if( ! empty( $options ) ) {

        echo '<ul'. $this->element_class() .'>';
        foreach ( $options as $key => $value ) {
          echo '<li><label><input type="radio" name="'. $this->element_name('[]') .'" value="'.$key.'"'. $this->element_class() . $this->element_attributes( $key ) . $this->checked( $this->value, $key ) .'/> '.$value.'</label></li>';
        }
        echo '</ul>';
      }
    
    } else {
      $label = ( isset( $this->field['label'] ) ) ? $this->field['label'] : '';
      echo '<label><input type="radio" name="'. $this->element_name() .'" value="1"'. $this->element_class() . $this->element_attributes() . checked( $this->value, 1, false ) .'/> '. $label .'</label>';
    }

    echo $this->element_after();

  }

}
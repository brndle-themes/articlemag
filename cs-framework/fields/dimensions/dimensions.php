<?php
/**
 *
 * Field: Dimensions
 * @version 1.0.0
 * @since 1.0.0
 *
 */
class CSFramework_Option_dimensions extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    extract( $this->field['settings'] );

    echo $this->element_before();

    echo '<div class="field_ui_spinner">';
    echo '<ul class="cs-dimensions">';
    $n = 0;
    foreach ( $this->field['options'] as $key => $value ) {
      $n++;
      $current_value = ( ! empty( $this->value[$key] ) ) ? $this->value[$key] : '';
      if( isset( $ui ) ) {
        echo '<li><div class="cs-dimensions-title">'. $value . '</div><input type="text" name="'. $this->element_name('['. $key .']') .'" size="5" value="'. $current_value .'"'. $this->element_class('cs-ui-spinner') .' data-depend-id="'. $this->field['id'] .'_'. $key .'"  data-min="'. $min .'" data-max="'. $max .'" data-step="'. $step .'" data-atts="'. $key .'"/></li>';
      } else {
        echo '<li><div class="cs-dimensions-title">'. $value . '</div><input type="number" name="'. $this->element_name('['. $key .']') .'" size="5" value="'. $current_value .'"'. $this->element_class('cs-size-75') .' data-depend-id="'. $this->field['id'] .'_'. $key .'"  min="'. $min .'" max="'. $max .'" step="'. $step .'" data-atts="'. $key .'"/></li>';
      }
      echo ( count( $this->field['options'] ) != $n && isset( $seperator ) ) ? '<li>'. $seperator .'</li>' : '';
    }

    if( isset( $this->field['default']['unit'] ) ) {
      echo '<li>';
        $this->addElement(
          array(
            'pseudo'      => true,
            'id'          => 'unit',
            'type'        => 'select',
            'name'        => $this->element_name( '[unit]' ),
            'options'     => array(
              'px'        => 'px',
              '%'         => '%',
              'em'        => 'em',
              'rem'       => 'rem',
            ),
            'attributes'  => array(
              'data-atts' => 'unit',
            ),
            'value'       => ( !empty( $this->value['unit'] ) ) ? $this->value['unit'] : array('px'),
          )
        );
      echo '</li>';
    }

    echo '</ul>';
    echo '</div>';

    echo $this->element_after();

  }

}
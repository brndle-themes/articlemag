<?php
/**
 *
 * Field: Group
 * @version 1.0.0
 * @since 1.0.0
 *
 */
class CSFramework_Option_group extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();

    $last_array_id    = ( !empty( $this->value ) ) ? count( $this->value ) : 0;
    $accordion        = ( isset( $this->field['accordion'] ) ) ? ' cs-accordion' : '';
    $button_title     = ( isset( $this->field['button_title'] ) ) ? $this->field['button_title'] : 'Add New Group';
    $accordion_title  = ( isset( $this->field['accordion_title'] ) ) ? $this->field['accordion_title'] : 'New Group';

    echo '<div class="cs-field-container">';

      //
      // Dump group field
      // --------------------------------------------------------------------------------------------------------------
      echo '<div class="cs-field-group hidden">';
        echo '<h3>'. $accordion_title .'</h3>';
        echo '<div class="cs-field-content">';

          foreach ( $this->field['fields'] as $field_key => $field ) {
            $field['sub']   = true;
            $unique         = $this->unique . '[_nonce][' . $this->field['id'] . ']['.$last_array_id.']';
            $field_default  = ( isset( $field['default'] ) ) ? $field['default'] : '';
            $this->addElement( $field, $field_default, $unique );
          }

          echo '<div class="cs-remove-group"><a href="#" class="button remove-cs-field">Remove</a></div>';
        echo '</div>';
      echo '</div>';

      echo '<div class="cs-field-groups'. $accordion .'">';
       
      if( isset( $this->value ) && ! empty( $this->value ) ) {

        $i = 0;
        foreach ( $this->value as $key => $value ) {


          echo '<div id="'. sanitize_title( $this->value[$key][$this->field['fields'][0]['id']] ) .'" class="cs-field-group">';

            echo '<h3><span class="cs-title">'. $this->field['fields'][0]['title'] .': </span>'. $this->value[$key][$this->field['fields'][0]['id']] .'</h3>';
            echo '<div class="cs-field-content">';

              foreach ( $this->field['fields'] as $field_key => $field ) {
                $field['sub'] = true;
                $unique = $this->unique . '[' . $this->field['id'] . ']['.$i.']';
                $value  = isset($this->value[$key][$field['id']]) ? $this->value[$key][$field['id']]:'';
                $this->addElement( $field, $value, $unique ); // add element
              }

            echo '<div class="cs-remove-group"><a href="#" class="button remove-cs-field">Remove</a></div>';
            echo '</div>';

          echo '</div>';

          $i++;
        }

      }

      echo '</div>';

      echo '<p><a href="#" class="button button-primary cs-add-field">'. $button_title .'</a></p>';

    echo '</div>';
    echo $this->element_after();

  }

}
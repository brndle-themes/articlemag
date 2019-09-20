<?php
/**
 *
 * Field: Select
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_select extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();

    if( isset( $this->field['options'] ) ) {

      if( isset( $this->field['multilang'] ) && ( is_wpml_activated() || is_qtranslate_activated() || is_polylang_activated() ) ) {

        if( is_wpml_activated() ) {

          $languages = icl_get_languages();
          $current   = ICL_LANGUAGE_CODE;

        } else if( is_qtranslate_activated() ) {

          global $q_config;
          $q_current = $q_config['language'];
          $languages = qtrans_getSortedLanguages();
          $languages = array_flip( $languages );
          $current   = $q_current;

        } else if( is_polylang_activated() ) {

          global $polylang;
          $current    = pll_current_language();
          $current    = ( empty( $current ) ) ? pll_default_language() : $current;
          $poly_langs = $polylang->model->get_languages_list();
          $languages  = array();

          foreach ( $poly_langs as $p_lang ) {
            $languages[$p_lang->slug] = $p_lang->slug;
          }

        }

        foreach( $languages as $kk => $vv ) {

          $hidden       = ( $kk === $current ) ? '' : 'hidden';
          $options      = $this->field['options'];
          $options      = ( is_array( $options ) ) ? $options : $this->element_data( $options );
          $extra_name   = ( isset( $this->field['attributes']['multiple'] ) ) ? '[]' : '' ;
          $el_value_key = ( ! empty( $this->value[$kk] ) ) ? $this->value[$kk] : '';
          $el_value     = ( is_array( $this->value ) ) ? $el_value_key : $this->value;

          echo '<div class="'. $hidden .'">';
          echo '<select name="'. $this->element_name( '['. $kk .']'. $extra_name ) .'"'. $this->element_class() . $this->element_attributes() .'>';
          echo ( isset( $this->field['default_option'] ) ) ? '<option value="">'.$this->field['default_option'].'</option>' : '';
          if( !empty( $options ) ){
            foreach ( $options as $k => $v ) {
              echo '<option value="'. $k .'" '. $this->checked( $el_value, $k, 'selected' ).'>'. $v .'</option>';
            }
          }
          echo '</select>';
          echo '<div class="cs-text-desc '. $hidden .'">You are editing language: ( <strong>'. $kk .'</strong> )</div>';
          echo '</div>';

        }

      } else {

        $options    = $this->field['options'];
        $options    = ( is_array( $options ) ) ? $options : $this->element_data( $options );
        $extra_name = ( isset( $this->field['attributes']['multiple'] ) ) ? '[]' : '' ;

        echo '<select name="'. $this->element_name( $extra_name ) .'"'. $this->element_class() . $this->element_attributes() .'>';

        echo ( isset( $this->field['default_option'] ) ) ? '<option value="">'.$this->field['default_option'].'</option>' : '';

        if( !empty( $options ) ){
          foreach ( $options as $key => $value ) {
            echo '<option value="'. $key .'" '. $this->checked( $this->value, $key, 'selected' ).'>'. $value .'</option>';
          }
        }

        echo '</select>';

      }

    }

    echo $this->element_after();

  }

}
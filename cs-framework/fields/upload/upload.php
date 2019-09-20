<?php
/**
 *
 * Field: Upload
 * @version 1.0.0
 * @since 1.0.0
 *
 */
class CSFramework_Option_upload extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();
    $return_as = ( isset( $this->field['return_id'] ) ) ? 'id' : 'url';

    if( isset( $this->field['settings'] ) ) {
      extract( $this->field['settings'] );
    }

    $upload_type        = ( isset( $upload_type  ) ) ? $upload_type  : 'image';
    $button_title       = ( isset( $button_title ) ) ? $button_title : 'Upload';
    $frame_title        = ( isset( $frame_title  ) ) ? $frame_title  : 'Upload';
    $insert_title       = ( isset( $insert_title ) ) ? $insert_title : 'Use Image';
    $input_as           = ( isset( $this->field['preview'] ) ) ? 'hidden' : 'text';
    $media_detailed     = ( isset( $this->field['detailed'] ) ) ? '[attachment]' : '';
    $element_value      = ( isset( $this->field['detailed'] ) ) ? $this->value['attachment'] : $this->value;

    $remove_media_class = ( empty( $element_value ) ) ? ' hidden' : '';

    if( isset( $this->field['multilang'] ) && ( is_wpml_activated() || is_qtranslate_activated() || is_polylang_activated() ) ) {
      if( is_wpml_activated() ) {

        $languages  = icl_get_languages();
        $current    = ICL_LANGUAGE_CODE;

      } else if( is_qtranslate_activated() ) {

        global $q_config;
        $q_current  = $q_config['language'];
        $languages  = qtrans_getSortedLanguages();
        $languages  = array_flip( $languages );
        $current    = $q_current;

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

      foreach ( $languages as $key => $value ) {
        $type       = ( $key == $current ) ? $input_as : 'hidden';
        $display    = ( $key == $current ) ? '' : 'hidden';
        $value_key  = ( ! empty( $this->value[$key] ) ) ? $this->value[$key] : '';
        $value      = ( is_array( $this->value ) ) ? $value_key : $this->value;
        $hide_preview = '';

          echo '<div class="cs-uploader">';

          echo '<input type="'. $type .'" name="'. $this->element_name( '['. $key .']' ) .'" value="'. $value .'"'. $this->element_class('media-attachment') . $this->element_attributes() .'/>';

          if( isset( $this->field['detailed'] ) ) {
            echo '<input type="hidden" name="'. $this->element_name( '[details]' ) .'" value="'. $this->value['details'] .'" class="media-details"/>';
          }
          if ( 'hidden' == $input_as && $key == $current ) {
            $hide_preview = ' ';
          } else {
            $hide_preview = 'hidden';
          }
          if( isset( $this->field['preview'] ) ) {

            echo '<div class="cs-upload-preview '. $hide_preview .'">';

            if( ! empty( $value ) ) {

              if( is_numeric( $value ) ) {
                echo '<a href="'. wp_get_attachment_url( $value ) .'" target="_blank">'. wp_get_attachment_image( $value, 'thumbnail' ) .'</a>';
              } else {
                echo '<a href="'. $value .'" target="_blank"><img src="'. $value .'" alt="'. $this->field['id'] .'" /></a>';
              }

            }

            echo '</div>';

          }
            echo '<a href="#" class="button cs-add-media ' . $display . '" data-frame-title="'. $frame_title .'" data-upload-type="'. $upload_type .'" data-return="'. $return_as .'" data-insert-title="'. $insert_title .'">'. $button_title .'</a>';
            echo '&nbsp;';
            if( isset( $this->field['preview'] ) ){
              echo '<a href="#" class="button cs-button-remove '. $remove_media_class . ' ' . $hide_preview .' "> Remove </a>';
            }
            echo '<div class="cs-text-desc '. $display .'">You are editing language: ( <strong>'. $current .'</strong> )</div>';
          echo '</div>';
      }

    } else {
      echo '<div class="cs-uploader">';

      echo '<input type="'. $input_as .'" name="'. $this->element_name( $media_detailed ) .'" value="'. $element_value .'"'. $this->element_class('media-attachment') . $this->element_attributes() .'/>';

      if( isset( $this->field['detailed'] ) ) {
        echo '<input type="hidden" name="'. $this->element_name( '[details]' ) .'" value="'. $this->value['details'] .'" class="media-details"/>';
      }

      if( isset( $this->field['preview'] ) ) {

        echo '<div class="cs-upload-preview">';

        if( ! empty( $element_value ) ) {

          if( is_numeric( $element_value ) ) {
            echo '<a href="'. wp_get_attachment_url( $element_value ) .'" target="_blank">'. wp_get_attachment_image( $element_value, 'thumbnail' ) .'</a>';
          } else {
            echo '<a href="'. $element_value .'" target="_blank"><img src="'. $element_value .'" alt="'. $this->field['id'] .'" /></a>';
          }

        }

        echo '</div>';

      }

      echo '<a href="#" class="button cs-add-media" data-frame-title="'. $frame_title .'" data-upload-type="'. $upload_type .'" data-return="'. $return_as .'" data-insert-title="'. $insert_title .'">'. $button_title .'</a>';
      echo '&nbsp;';

      if( isset( $this->field['preview'] ) ){
        echo '<a href="#" class="button cs-button-remove'. $remove_media_class .'"> Remove </a>';
      }
      
      echo '</div>';
     }

    echo $this->element_after();

  }
}
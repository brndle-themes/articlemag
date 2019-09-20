<?php

/**
 *
 * Field: Textarea
 *
 * @package CSFramework_Options_API
 * @version 1.0.0
 * @since 1.1.0
 *
 */
class CSFramework_Option_textarea extends CSFramework_Options_API {

	public function __construct( $field = array(), $value = '', $unique = '' ) {
		$this->field	 = $field;
		$this->value	 = $value;
		$this->unique	 = $unique;
	}

	public function output() {


		$elem_id		 = '';
		$is_shortcode	 = ( isset( $this->field[ 'shortcode' ] ) ) ? true : false;

		echo $this->element_before();

		if ( isset( $this->field[ 'multilang' ] ) && ( is_wpml_activated() || is_qtranslate_activated() || is_polylang_activated() ) ) {

			if ( is_wpml_activated() ) {

				$languages	 = icl_get_languages();
				$current	 = ICL_LANGUAGE_CODE;
			} else if ( is_qtranslate_activated() ) {

				global $q_config;
				$q_current	 = $q_config[ 'language' ];
				$languages	 = qtrans_getSortedLanguages();
				$languages	 = array_flip( $languages );
				$current	 = $q_current;
			} else if ( is_polylang_activated() ) {

				global $polylang;
				$current	 = pll_current_language();
				$current	 = ( empty( $current ) ) ? pll_default_language() : $current;
				$poly_langs	 = $polylang->model->get_languages_list();
				$languages	 = array();

				foreach ( $poly_langs as $p_lang ) {
					$languages[ $p_lang->slug ] = $p_lang->slug;
				}
			}

			foreach ( $languages as $key => $value ) {

				$class		 = ( $key == $current ) ? '' : 'hidden';
				$value_key	 = (!empty( $this->value[ $key ] ) ) ? $this->value[ $key ] : '';
				$value		 = ( is_array( $this->value ) ) ? $value_key : $this->value;

//        if( $is_shortcode ){
//          $uniqid  = uniqid();
//          $elem_id = ' id="'. $this->field['id'] . '-'. $uniqid .'"';
//          echo '<p class="'. $class .'"><a href="#" onmousedown="return false;" class="button button-primary shortcode-button" data-target="'. $this->field['id'] .'-'. $uniqid .'"><span class="dashicons dashicons-menu"></span> Quick Shortcode</a></p>';
//        }

				echo '<textarea name="' . $this->element_name( '[' . $key . ']' ) . '"' . $this->element_class( $class ) . $this->element_attributes() . $elem_id . '>' . $value . '</textarea>';
				echo '<div class="cs-text-desc ' . $class . '">You are editing language: ( <strong>' . $current . '</strong> )</div>';
			}
		} else {

//			if ( $is_shortcode ) {
//				$uniqid	 = uniqid();
//				$elem_id = ' id="' . $this->field[ 'id' ] . '-' . $uniqid . '"';
//				echo '<p><a href="#" onmousedown="return false;" class="button button-primary shortcode-button" data-target="' . $this->field[ 'id' ] . '-' . $uniqid . '"><span class="dashicons dashicons-menu"></span> Quick Shortcode</a></p>';
//			}

			echo '<textarea name="' . $this->element_name() . '"' . $this->element_class() . $this->element_attributes() . $elem_id . '>' . $this->value . '</textarea>';
		}

		echo $this->element_after();
	}

}

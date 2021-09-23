<?php
/**
 *
 * Field: Reset
 *
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! class_exists( 'CSF_Field_reset' ) ) {
	class CSF_Field_reset extends CSF_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {

			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			echo $this->field_before();
			echo '<div id="cs-reset-customize">';
			echo '<p class="cs-text-center cs-text-note"><strong>[DANGER]</strong> You are reseting color settings!</p>';
			echo '<p class="cs-text-center"><span class="spinner-scheme hidden"><span class="cs-spinner"></span></span><a href="#" class="button button-primary cs-reset-color">Yes Please, Reset Colors</a></p>';
			echo '</div>';
			echo $this->field_after();

		}

	}
}

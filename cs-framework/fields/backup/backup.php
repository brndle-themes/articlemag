<?php
/**
 *
 * Field: Backup
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_backup extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    // get options
    $options = array();
    $options['framework_options'] = get_option( $this->unique );
    $options['customize_options'] = get_option( CUSTOMIZE_OPTION_NAME );

    echo $this->element_before();

    echo '<textarea name="'. $this->unique .'[import]"'. $this->element_class() . $this->element_attributes() .'></textarea>';
    submit_button( 'Import', 'primary cs-import-backup', 'backup', false );

    echo '<hr>';
    
    echo '<textarea name="_nonce"'. $this->element_class() . $this->element_attributes() .' disabled="disabled">'. cs_encode_string( $options ) .'</textarea>';
    echo '<a href="'. admin_url( 'admin-ajax.php?action=cs-export-options' ) .'" class="button button-primary" target="_blank">Download Backup</a>';

    echo '<hr>';

    submit_button( 'Reset All Options', 'cs-reset-all', $this->unique . '[resetall]', false );
    echo '<p class="cs-text-danger"><small>Please be sure for reset all options.</small></p>';

    echo $this->element_after();

  }

}
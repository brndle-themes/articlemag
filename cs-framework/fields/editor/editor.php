<?php
/**
 *
 * Field: WP Editor
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_editor extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    $settings = array(
      'textarea_name' => $this->element_name(),
      'textarea_rows' => 5,
    );

    $editor_settings = wp_parse_args( $this->field['settings'], $settings );

    echo $this->element_before();
    wp_editor( $this->value, $this->field['id'], $editor_settings );
    echo '<div class="clear"></div>';
    echo $this->element_after();

  }
}
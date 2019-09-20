<?php
/**
 *
 * Field: Background
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_background extends CSFramework_Options_API {

  public function __construct( $field = array(), $value = '', $unique = '' ) {
    $this->field    = $field;
    $this->value    = $value;
    $this->unique   = $unique;
  }

  public function output() {

    echo $this->element_before();

    $return_as = 'url';

    if( isset( $this->field['settings'] ) ){
      extract( $this->field['settings'] );
    }

    $value_defaults = array(
      'image'       => '',
      'repeat'      => '',
      'position'    => '',
      'attachment'  => '',
      'color'       => '',
    );

    $this->value    = wp_parse_args( $this->value, $value_defaults );

    $button_title   = ( isset( $button_title ) ) ? $button_title : 'Upload';
    $frame_title    = ( isset( $frame_title  ) ) ? $frame_title  : 'Upload';
    $upload_type    = ( isset( $upload_type  ) ) ? $upload_type  : 'image';
    $insert_title   = ( isset( $insert_title ) ) ? $insert_title : 'Use Image';
    $defaults       = ( isset( $this->field['defaults'] ) ) ? $this->field['defaults'] : array();

    echo '<div class="cs-uploader">';
    echo '<input type="text" name="'. $this->element_name( '[image]' ) .'" value="'. $this->value['image'] .'"'. $this->element_class('media-attachment') . $this->element_attributes() .'/>';
    echo '<a href="#" class="button cs-add-media" data-frame-title="'. $frame_title .'" data-upload-type="'. $upload_type .'" data-return="'. $return_as .'" data-insert-title="'. $insert_title .'">'. $button_title .'</a>';
    echo '</div>';

    echo '<ul class="field-background">';

    echo '<li>';
    $this->addElement( array(
        'pseudo'      => true,
        'id'          => 'repeat',
        'type'        => 'select',
        'name'        => $this->element_name('[repeat]'),
        'options'     => array(
          ''          => 'Repeat',
          'repeat-x'  => 'Repeat Horizontally',
          'repeat-y'  => 'Repeat Vertically',
          'no-repeat' => 'No Repeat',
        ),
        'attributes'  => array(
          'data-atts' => 'repeat',
        ),
        'value'       => $this->value['repeat']
    ) );
    echo '</li>';

    echo '<li>';
    $this->addElement( array(
        'pseudo'      => true,
        'id'          => 'position',
        'type'        => 'select',
        'name'        => $this->element_name('[position]'),
        'options'     => array(
          ''          => 'left top',
          '0% 50%'    => 'left center',
          '0% 100%'   => 'left bottom',
          '100% 0%'   => 'right top',
          '100% 50%'  => 'right center',
          '100% 100%' => 'right bottom',
          '50% 0%'    => 'center top',
          '50% 50%'   => 'center center',
          '50% 100%'  => 'center bottom'
        ),
        'attributes'  => array(
          'data-atts' => 'position',
        ),
        'value'       => $this->value['position']
    ) );
    echo '</li>';

    echo '<li>';
    $this->addElement( array(
        'pseudo'      => true,
        'id'          => $this->field['id'].'_attachment',
        'type'        => 'select',
        'name'        => $this->element_name('[attachment]'),
        'options'     => array(
          ''          => 'scroll',
          'fixed'     => 'fixed',
        ),
        'attributes'  => array(
          'data-atts' => 'attachment',
        ),
        'value'       => $this->value['attachment']
    ) );
    echo '</li>';

    echo '<li class   ="bg-color-picker">';
    $this->addElement( array(
        'pseudo'      => true,
        'id'          => $this->field['id'].'_color',
        'type'        => 'color_picker',
        'name'        => $this->element_name('[color]'),
        'attributes'  => array(
          'data-atts' => 'bgcolor',
        ),
        'value'       => ( !empty( $this->value['color'] ) ) ? $this->value['color'] : '',
    ) );
    echo '</li>';
  
    echo '</ul>';

    echo $this->element_after();

  }
}
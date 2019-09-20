<?php
/**
 *
 * CSFramework Metabox API
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Metabox_API extends CSFramework_Abstract{

  public $args = array();
  public $metakey = '_custom_page_options';

  public function __construct( $args = array() ){
    $this->args = apply_filters( 'csframework_metaboxes', $args );
    $this->addAction( 'add_meta_boxes', 'add_meta_box' );
    $this->addAction( 'save_post', 'save_post', 10, 2 );
  }

  /**
   *
   * Add Metabox
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function add_meta_box( $post_type ) {
    foreach ( $this->args as $key => $value ) {
      add_meta_box( $value['id'], $value['title'], array( &$this, 'render_meta_box_content' ), $value['post_type'], $value['context'], $value['priority'], $value );
    }
  }

  /**
   *
   * Metabox Render.
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function render_meta_box_content( $post, $callback ) {

    wp_nonce_field( 'csframework_metabox', 'csframework_metabox_nonce' );

    $unique = $callback['args']['id'];
    $sections = $callback['args']['sections'];
    $nav = ( count($sections) >= 2 ) ? ' cs-framework-nav' : '';

    echo '<div class="cs-framework cs-metabox-framework '. $nav .'" data-cookie="'. $unique .'">';

      echo '<div class="cs-body">';

        if( count( $sections ) >= 2 ) {

          echo '<div class="cs-nav-background"></div>';
          echo '<div class="cs-nav-wrap">';

            echo '<ul class="cs-sections">';
            foreach( $sections as $section_key => $section_value ) {
              echo '<li>';
              echo '<a href="#" data-section="'. $section_key .'" data-target="cs-tab-'. sanitize_title( $section_value['title'] ) .'">'. $section_value['title'] .'</a>';
              echo '</li>';
            }
            echo '</ul>';

          echo '</div>';

        }

        echo '<div class="cs-content-wrap">';

          echo '<div class="cs-content">';

            echo '<ul>';
            foreach( $sections as $section_k => $section_v ) {
              echo '<li id="cs-tab-'.sanitize_title( $section_v['title']  ).'" class="cs-content-body">';

              $value = get_post_meta( $post->ID, $this->metakey, true );

              foreach ( $section_v['fields'] as $field_key => $field ) {

                $default = ( isset( $field['default'] ) ) ? $field['default'] : '';
                $elem_value = ( !empty( $value ) && isset( $value[$field['id']] ) ) ? $value[$field['id']] : $default;

                $this->addElement( $field, $elem_value, $unique );

              }

              echo '</li>';
            }
            echo '</ul>';

          echo '</div>';

        echo '</div>';

      echo '</div>';

    echo '<div class="clear"></div>';
    echo '</div>';
  }

  /**
   *
   * Save Metabox Options
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function save_post( $post_id, $post ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }

    $nonce = ( isset( $_POST['csframework_metabox_nonce'] ) ) ? $_POST['csframework_metabox_nonce'] : '';

    if ( ! isset( $nonce ) ) { return $post_id; }

    if ( ! wp_verify_nonce( $nonce, 'csframework_metabox' ) ) { return $post_id; }

    if ( 'page' == $_POST['post_type'] ) {

      if ( ! current_user_can( 'edit_page', $post_id ) ) { return $post_id; }

    } else {

      if ( ! current_user_can( 'edit_post', $post_id ) ) { return $post_id; }

    }

    $ignore_meta  = array();
    $meta_value   = array();
    $post         = get_post( $post_id );
    $metakey      = $this->metakey;

    foreach ( $this->args as $request_key => $request_value ) {

      foreach( $request_value['sections'] as $key => $section ) {
        if( isset( $section['fields'] ) ) {
          foreach( $section['fields'] as $field ) {
            if( isset( $field['type'] ) && isset( $_POST[$request_value['id']] ) && ( $field['type'] == 'checkbox' || $field['type'] == 'image_select' || $field['type'] == 'on_off' ) ) {

              $field_id = @$_POST[$request_value['id']][$field['id']];

              if( ! isset( $field_id ) ) {
                $field_id = false;
              }

              if( $field['type'] == 'checkbox' || $field['type'] == 'on_off' ) {
                if( isset( $field_id ) && $field_id == 1 ) {
                  $field_id = true;
                }
              }

              if( $field['type'] == 'image_select' ) {
                if( isset( $field_id ) && is_array( $field_id ) ) {
                  $field_id = $field_id[0];
                }
              }

              @$_POST[$request_value['id']][$field['id']] = $field_id;
            }
          }
        }
      }

      $metavalue  = isset( $_POST[$request_value['id']] ) ? $_POST[$request_value['id']] : '';
      $meta_value = wp_parse_args( $meta_value, $metavalue );
      $meta_value = cs_array_filter( $meta_value );

    }

    // checking for section
    if( has_shortcode( $post->post_content, 'vc_row' ) && in_array( $meta_value['sidebar'], array( 'full', 'fluid' ) ) ) {
      $meta_value['section'] = true;
    }

    if( empty( $meta_value ) ) {

      delete_post_meta( $post_id, $metakey );

    } else {

      if( get_post_meta( $post_id, $metakey ) ) {

        update_post_meta( $post_id, $metakey, $meta_value );

      } else {

        add_post_meta( $post_id, $metakey, $meta_value );

      }

    }

  }

}
<?php
/**
 *
 * CSFramework Options API
 * @since 1.0.0
 * @version 1.0.0
 *
 */
abstract class CSFramework_Options_API extends CSFramework_Abstract {

  public function __construct( $field, $unique ) {
    $this->field  = $field;
    $this->unique = $unique;
  }

  /**
   *
   * Options fields elements attr
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function element_name( $extra_name = '' ) {
    return ( isset( $this->field['name'] ) ) ? $this->field['name'] : $this->unique .'[' . $this->field['id'] . ']'.$extra_name;
  }

  /**
   *
   * Options fields elements class
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function element_class( $el_class = '' ) {
    $field_class = ( isset( $this->field['class'] ) ) ? ' ' . $this->field['class'] : '';
    return ' class="'. $el_class . $field_class .'"';
  }

  /**
   *
   * Options fields elements attributes
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function element_attributes( $el_attributes = array() ) {

    $attributes = ( isset( $this->field['attributes'] ) ) ? $this->field['attributes'] : array();
    
    if( $el_attributes !== false ) {
      $el_attributes  = ( is_string( $el_attributes ) || is_numeric( $el_attributes ) ) ? array('data-depend-id' => $this->field['id'] . '_' . $el_attributes ) : $el_attributes;
      $el_attributes  = ( empty( $el_attributes ) && isset( $this->field['id']  ) ) ? array('data-depend-id' => $this->field['id'] ) : $el_attributes;
    }

    $attributes = wp_parse_args( $attributes, $el_attributes );

    $atts = '';

    if( ! empty( $attributes ) ) {
      foreach ($attributes as $key => $value) {
        $atts .= ' '. $key . '="'. $value .'"';
      }
    }

    return $atts;

  }

  /**
   *
   * Options fields elements before
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function element_before() {
    return ( isset( $this->field['before'] ) ) ? $this->field['before'] : '';
  }

  /**
   *
   * Options fields elements after
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function element_after() {

    $output  = '';
    $output .= ( isset( $this->field['info'] ) ) ? '<p class="cs-text-desc">'. $this->field['info'] .'</p>' : '';
    $output .= ( isset( $this->field['after'] ) ) ? $this->field['after'] : '';
    return $output;

  }
  
  /**
   *
   * Options fields elements data
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function element_data( $type = '' ) {

    $options = array();
    $query_args = ( isset( $this->field['query_args'] ) ) ? $this->field['query_args'] : array();

    switch( $type ) {

      case 'pages':
      case 'page':

        $pages = get_pages( $query_args );
        if ( ! empty( $pages ) ) {
          foreach ( $pages as $page ) {
            $options[$page->ID] = $page->post_title;
          }
        }

      break;

      case 'posts':
      case 'post':

        $posts = get_posts( $query_args );
        if ( ! empty( $posts ) ) {
          foreach ( $posts as $post ) {
            $options[$post->ID] = $post->post_title;
          }
        }

      break;

      case 'tags':
      case 'tag':

        $tags = get_terms( $query_args['taxonomies'], $query_args['args'] );
        if ( ! empty( $tags ) ) {
          foreach ( $tags as $tag ) {
            $options[$tag->term_id] = $tag->name;
          }
        }

      break;

      case 'categories':
      case 'category':

        $categories = get_categories( $query_args );
        if ( ! empty( $categories ) ) {
          foreach ( $categories as $category ) {
            $options[$category->term_id] = $category->name;
          }
        }

      break;

      case 'custom':
      case 'callback':

        if( is_callable( $query_args['function'] ) ) {
          $options = call_user_func( $query_args['function'], $query_args['args'] );
        }

      break;

    }

    return $options;
  }

  /**
   *
   * Private helper function for checked, selected, and disabled.
   * @since 1.0.0
   * @version 1.1.0
   *
   */
  public function checked( $helper = '', $current = '', $type = 'checked', $echo = false ) {


    if ( is_array( $helper ) && in_array( $current, $helper ) ) {
      $result = ' '. $type .'="'. $type .'"';
    } else if ( $helper == $current ) {
      $result = ' '. $type .'="'. $type .'"';
    } else {
      $result = '';
    }

    if ( $echo ) {
      echo $result;
    }

    return $result;

  }

}

foreach ( glob( FRAMEWORK_DIR . '/fields/*/*.php' ) as $field_key => $field_class ) {
  $cs_field_basename = basename( $field_class, '.php' );
  locate_template( 'cs-framework/fields/'. $cs_field_basename . '/' . $cs_field_basename . '.php', true );
}
<?php
/**
 *
 * Blog Shortcode
 * @since 1.0.0
 * @version 1.2.0
 *
 */
if( ! function_exists( 'cs_blog' ) ) {
  function cs_blog( $atts, $content = '', $key = '' ) {

    global $wp_query, $paged, $post, $cs_blog_column, $cs_blog_image_size;

    extract( shortcode_atts( array(
      'id'      => '',
      'class'   => '',
      'cats'    => 0,
      'limit'   => '',
      'type'    => 'default',
      'nav'     => 'paging',
      'columns' => 3,
      'size'    => 'blog-large-image',
    ), $atts ) );

    $id                 = ( $id ) ? ' id="'. $id .'"' : '';
    $class              = ( $class ) ? ' '. $class : '';
    $blog_layout        = ( $type == 'grid' || $type == 'masonry' ) ? 'masonry' : 'default blog-layout-'. $type;
    $data_layout        = ( $type == 'grid' ) ? 'fitRows' : 'masonry';
    $cs_blog_column     = $columns;
    $cs_blog_image_size = $size;

    if( is_front_page() || is_home() ){
      $paged = ( get_query_var('paged') ) ? intval( get_query_var('paged') ) : intval( get_query_var('page') );
    } else {
      $paged = intval( get_query_var('paged') );
    }

    // Query args
    $args = array(
      'posts_per_page'  => $limit,
      'paged'           => $paged,
      'cat'             => $cats,
      'post_status'     => 'publish',
    );

    // Nav args
    $nav_args = array(
      'size'            => $size,
      'columns'         => $columns,
      'nav'             => $nav,
      'template'        => $type,
      'posts_per_page'  => $limit,
      'isotope'         => ( $type == 'default' || $type == 'medium' || $type == 'small' ) ? '0' : '1',
      'cats'            => $cats,
    );

    $tmp_query  = $wp_query;
    $wp_query   = new WP_Query( $args );

    ob_start();

    if( have_posts() ) :

      echo '<div'. $id .' class="blog-'. $blog_layout . $class .'">';

        if( $type == 'masonry' || $type == 'grid' ) {

          echo '<div class="isotope-container">';
            echo '<div class="isotope-loading cs-loader"></div>';
            echo '<div class="isotope-wrapper">';
            echo '<div class="row isotope-blog isotope-loop" data-layout="'. $data_layout .'">';
              while ( have_posts() ) : the_post();
                get_template_part( 'templates/page-blog', 'masonry' );
              endwhile;
            echo '</div><!-- isotope-blog -->';
              cs_paging_nav( $nav_args );
            echo '</div><!-- isotope-wrapper -->';
          echo '</div><!-- isotope-container -->';

        } else {

          // loop posts
          while( have_posts() ) : the_post();

            global $more;
            $more = 0;

            if ( $type == 'default' ) {
              get_template_part( 'post-formats/content', get_post_format() );
            } else {
              get_template_part( 'templates/page-blog', $type );
            }

          endwhile;

          // loop nav
          cs_paging_nav( $nav_args );
        }

      echo '</div>';

    else:
      echo '<span class="fa fa-warning-sign"></span> please check settings.';
    endif;

    wp_reset_query();
    wp_reset_postdata();
    $wp_query = $tmp_query;

    $output = ob_get_clean();
    return $output;
  }
  add_shortcode( 'cs_blog', 'cs_blog' );
}
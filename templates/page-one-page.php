<?php
/**
 *
 * Template Name: One-Page Template
 * @since 1.0.0
 * @version 1.0.0
 *
 */
get_header();

// Start the Loop.
while ( have_posts() ) : the_post();
  the_content();
endwhile;

echo '</div><!-- /content -->';
echo '</div><!-- /main -->';

//
// Fixed Navigation
// -------------------------------------------------------------------------------------------
$cs_location = apply_filters( 'cs_one_page_location', 'primary' );
if ( ( $cs_locations = get_nav_menu_locations() ) && isset( $cs_locations[$cs_location] ) ) {

  $cs_menu_object  = wp_get_nav_menu_object( $cs_locations[$cs_location] );

  if ( is_object( $cs_menu_object ) ) {

    $cs_menu_items   = wp_get_nav_menu_items( $cs_menu_object->term_id );
    $cs_nav_list     = '<nav id="cs-fixed-nav">';
    $cs_nav_list    .= '<ul>';

    if( ! empty( $cs_menu_items ) ) {
      foreach ( $cs_menu_items as $cs_menu_item ) {
        $cs_nav_list  .= '<li class="'. join( ' ', $cs_menu_item->classes ) .'"><a href="' . $cs_menu_item->url . '" data-toggle="tooltip" data-original-title="'. $cs_menu_item->title .'" data-placement="left"></a></li>';
      }
    }

    $cs_nav_list    .= '</ul>';
    $cs_nav_list    .= '</nav><!-- /cs-fixed-nav -->';

    echo $cs_nav_list;

  }

}

$cs_post_meta = get_post_meta( get_the_ID(), '_custom_page_options', true );

if( ! empty( $cs_post_meta['one_page_footer'] ) ) {
  echo cs_footer_area();
}

echo '</div><!-- /page -->';

echo cs_custom_js();

wp_footer();

echo '</body>';
echo '</html>';
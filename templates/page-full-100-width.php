<?php
/**
 *
 * Template Name: Full 100% width, without container
 * @since 1.7.0
 * @version 1.0.0
 *
 */
get_header();
get_template_part( 'templates/page-header' );

while ( have_posts() ) : the_post();
  cs_page_featured_image();
  the_content();
  cs_link_pages();
  do_action( 'cs_page_end' );
endwhile;

get_footer();
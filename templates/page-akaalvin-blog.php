<?php
/**
 *
 * Template Name: Full-width, no sidebar
 * @since 1.0.0
 * @version 1.0.1
 *
 */
get_header();
get_template_part( 'templates/page-header' );
?>
<section class="main-content md-padding">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="page-content">
          <?php
            // Start the Loop.
            while ( have_posts() ) : the_post();

              cs_page_featured_image();
              the_content();
              cs_link_pages();
              do_action( 'cs_page_end' );

            endwhile;
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php get_footer();
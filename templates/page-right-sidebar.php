<?php
/**
 *
 * Template Name: Page Right Sidebar
 * @since 1.0.0
 * @version 1.0.1
 *
 */
get_header();
get_template_part( 'templates/page-header' );
?>
<section class="main-content md-padding right-layout">
  <div class="container">
    <div class="row">

      <div class="page-content col-md-9">
        <?php
          while ( have_posts() ) : the_post();

            cs_page_featured_image();
            the_content();
            cs_link_pages();
            do_action( 'cs_page_end' );

          endwhile;
        ?>
      </div>

      <div class="page-sidebar col-md-3">
        <?php get_sidebar(); ?>
      </div>

    </div>
  </div>
</section>
<?php get_footer();
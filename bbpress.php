<?php
/**
 *
 * The template for displaying bbpress forum.
 * @since 1.4.0
 * @version 1.0.0
 *
 */
get_header();
get_template_part( 'templates/page-header' );

$cs_bbpress_layout  = cs_get_option( 'bbpress_sidebar', 'full' );
$cs_page_column  = ( $cs_bbpress_layout == 'full' ) ? '12' : '9';

?>
<section class="main-content md-padding page-layout-<?php echo $cs_bbpress_layout; ?>">
  <div class="container">
    <div class="row">

      <?php cs_page_sidebar( 'left', $cs_bbpress_layout ); ?>

      <div class="col-md-<?php echo $cs_page_column; ?>">
        <div class="page-content">
          <?php
            while ( have_posts() ) : the_post();
              the_content();
            endwhile;
          ?>
        </div>
      </div>

      <?php cs_page_sidebar( 'right', $cs_bbpress_layout ); ?>

    </div>
  </div>
</section>
<?php get_footer();
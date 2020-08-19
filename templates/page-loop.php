<?php
/**
 *
 * Page Loop
 * @since 1.0.0
 * @version 1.5.0
 *
 */

$cs_blog_layout    = cs_get_option( 'blog_layout' );
$cs_page_layout    = cs_get_option( 'blog_sidebar' );
$cs_page_container = ( $cs_page_layout == 'fluid' ) ? '-fluid' : '';
$cs_page_column  = ( $cs_page_layout == 'full' || $cs_page_layout == 'fluid' ) ? '12' : ( ( $cs_page_layout == 'both' ) ? '6' : '9' );
$cs_blog_class     = ( $cs_blog_layout == 'grid' || $cs_blog_layout == 'masonry' ) ? 'masonry' : 'default blog-layout-'. $cs_blog_layout;
?>
<section class="main-content md-padding page-layout-<?php echo esc_attr($cs_page_layout); ?> blog-<?php echo esc_attr($cs_blog_class); ?>">
  <div class="container<?php echo esc_attr($cs_page_container); ?>">
    <div class="row">

      <?php cs_page_sidebar( 'left', $cs_page_layout ); ?>

      <div class="col-md-<?php echo esc_attr($cs_page_column); ?>">
        <div class="page-content">
          <div class="article-post-gird">

          <?php
            if (is_home() ) {
              echo display_articlemag_featured_posts();
            }
          ?>
          <?php if( $cs_blog_layout == 'masonry' || $cs_blog_layout == 'grid' ) { ?>
            <div class="isotope-container">
              <div class="isotope-loading cs-loader"></div>
              <div class="isotope-wrapper">
                <div class="row isotope-blog isotope-loop" data-layout="<?php echo ( $cs_blog_layout == 'grid' ) ? 'fitRows' : 'masonry'; ?>">
                  <?php
                    while ( have_posts() ) : the_post();
                      get_template_part( 'templates/page-blog', 'masonry' );
                    endwhile;
                  ?>
                </div><!-- isotope-blog -->
                <?php cs_paging_nav(); ?>
              </div><!-- isotope-wrapper -->
            </div><!-- isotope-container -->
          <?php
            } else {

              // default posts loop
              while ( have_posts() ) : the_post();
                // check blog type
                if ( $cs_blog_layout == 'default' ) {
                  get_template_part( 'post-formats/content', get_post_format() );
                } else {
                  get_template_part( 'templates/page-blog', $cs_blog_layout );
                }
              endwhile;

              // pagination
              cs_paging_nav();

            }
          ?>
        </div>
        </div><!-- page-content -->
      </div>

      <?php cs_page_sidebar( 'right', $cs_page_layout ); ?>

    </div>
  </div>
</section><!-- /main-content -->
<?php
/**
 *
 * The template for displaying category archives.
 * @since 1.0.0
 * @version 1.0.0
 *
 */
get_header(); ?>
<?php
  $category        = get_queried_object();  
  $get_term_meta   = get_term_meta( $category->term_id, 'category_thumbnail_id' );
  $cat_thumb_url   = wp_get_attachment_image_src( $get_term_meta[ 0 ], 'large' );
  $cat_img_url     = $cat_thumb_url[ 0 ];    
?>
<section id="page-header">
  <div class="category-hero" style="background-image: url('<?php echo $cat_img_url; ?>');"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-12 md-padding">

       <div class="category-content">
            <div class="category-content-inner">
                <h1 class="page-title"><?php printf( __( '%s', 'articlemag' ), single_cat_title( '', false ) ); ?></h1>
                  <?php
                    $cs_term_description = term_description();
                    if ( ! empty( $cs_term_description ) ) { printf( '<div class="header-content">%s</div>', $cs_term_description ); }
                  ?>
                <?php echo cs_breadcrumb(); ?>  
            </div>  
        </div>       
        
      </div>
    </div>
  </div>
</section><!-- /page-header -->

<?php get_template_part( 'templates/page', 'loop' ); ?>
<?php get_footer();
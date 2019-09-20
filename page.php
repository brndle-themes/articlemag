<?php
/**
 *
 * The template for displaying all pages.
 * @since 1.0.0
 * @version 1.4.0
 *
 */
get_header();
get_template_part( 'templates/page-header' );

global $cs_has_section, $post;

$cs_post_meta    = get_post_meta( $post->ID, '_custom_page_options', true );
$cs_page_layout  = ( isset ( $cs_post_meta['sidebar'] ) ) ? $cs_post_meta['sidebar'] : 'full';
$cs_page_column  = ( $cs_page_layout == 'full' ) ? '12' : '9';
$vc_exclude      = cs_get_option( 'vc_exclude_shortcodes' );
$vc_exclude      = ( is_array( $vc_exclude ) ) ? $vc_exclude : array();
$cs_page_padding = ( ! in_array( 'vc_row', $vc_exclude ) ) ? 'md-padding ' : '';
$cs_has_section  = isset( $cs_post_meta['section'] ) ? true : false;

if( ( $cs_page_layout == 'fluid' || isset( $cs_post_meta['section'] ) ) && ! in_array( 'vc_row', $vc_exclude ) ) {

  get_template_part('templates/page', 'section');
  do_action( 'cs_page_end', true );

} else {
?>
<section class="main-content <?php echo $cs_page_padding; ?>page-layout-<?php echo $cs_page_layout; ?>">
  <div class="container">
    <div class="row">

      <?php cs_page_sidebar( 'left', $cs_page_layout ); ?>

      <div class="col-md-<?php echo $cs_page_column; ?>">
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

      <?php cs_page_sidebar( 'right', $cs_page_layout ); ?>

    </div>
  </div>
</section>
<?php
}
get_footer();
<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @author WooThemes
 * @package WooCommerce/Templates
 * @version 10.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

get_header( 'shop' );

get_template_part( 'templates/page-header' );

$cs_page_layout     = 'full';
$cs_page_column     = '12';

if ( cs_get_option( 'woo_product_sidebar') ) {
  $shop_id          = apply_filters( 'cs_woo_product_sidebar', wc_get_page_id( 'shop' ) );
  $cs_post_meta     = get_post_meta( $shop_id, '_custom_page_options', true );
  $cs_page_layout   = ( isset ( $cs_post_meta['sidebar'] ) ) ? $cs_post_meta['sidebar'] : 'full';
  $cs_page_column   = ( $cs_page_layout == 'full' ) ? '12' : '9';
}
?>

<section class="main-content md-padding page-layout-<?php echo $cs_page_layout; ?>">
  <div class="container">
    <div class="row">

      <?php cs_page_sidebar( 'left', $cs_page_layout ); ?>

      <div class="col-md-<?php echo $cs_page_column; ?>">
        <div class="page-content">
          <?php
            /**
             * woocommerce_before_main_content hook
             *
             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
             * @hooked woocommerce_breadcrumb - 20
             */
            do_action( 'woocommerce_before_main_content' );
          ?>

            <?php while ( have_posts() ) : the_post(); ?>

              <?php wc_get_template_part( 'content', 'single-product' ); ?>

            <?php endwhile; // end of the loop. ?>

          <?php
            /**
             * woocommerce_after_main_content hook
             *
             * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
             */
            do_action( 'woocommerce_after_main_content' );
          ?>

        </div><!-- /page-content -->
      </div><!-- /colmd -->

      <?php cs_page_sidebar( 'right', $cs_page_layout ); ?>

    </div>
  </div>
</section>
<?php get_footer( 'shop' ); ?>
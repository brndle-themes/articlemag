<?php
/**
 *
 * The template for displaying author archive pages.
 * @since 1.0.0
 * @version 1.1.0
 *
 */
get_header();
$background_image = cs_multilang_value( cs_get_option( 'default_profile_cover' ) );
?>
<section id="page-header">
	<div class="auhtor-cover" style="background-image: url(<?php echo $background_image; ?>);"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-12 lg-padding">

      		<?php
			$author = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
			?>
			<?php cs_post_author_box( $author->ID ); ?>

      </div>
    </div>
  </div>
</section><!-- /page-header -->
<?php get_template_part( 'templates/page', 'loop' ); ?>
<?php get_footer();
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
      <div class="col-md-12">

      		<div class="author-content">
      			<div class="author-content-inner">
		      		<div class="author_hero"><?php echo get_avatar( get_the_author_meta( 'ID' )); ?> </div>
		      		<h1 class="author-title"><?php the_author(); ?></h1>
		      		<p class="author-description"><?php the_author_meta('user_description'); ?></p>
		      		<div class="author-meta">
		      			<ul class="author-social">
		      				<li><a href="<?php the_author_meta('url'); ?>"><i class="fa fa-globe"></i></a></li>
		      				<li><a href="<?php the_author_meta('facebook'); ?>"><i class="fa fa-facebook-official"></i></a></li>
		      				<li><a href="<?php the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i></a></li>
		      			</ul>
		      			<span class="post-count"><?php echo ''. count_user_posts( get_the_author_meta('ID') ). ' Post' ; ?></span>
		      		</div>
	      		</div>
      		</div>
      		
      </div>
    </div>
  </div>
</section><!-- /page-header -->
<?php get_template_part( 'templates/page', 'loop' ); ?>
<?php get_footer();
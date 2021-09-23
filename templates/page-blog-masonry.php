<?php
/**
 *
 * Blog Layout "Masonry"
 *
 * @since 1.0.0
 * @version 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'isotope-item ' . cs_get_bootstrap( cs_get_option( 'blog_column' ) ) ); ?>>
  <div class="blog-masonry-border">

	<?php
	  $post_format = get_post_format();
	switch ( $post_format ) {
		case 'audio':
			cs_post_thumbnail();
			echo cs_post_media( get_the_content() );
			break;

		case 'video':
			echo cs_post_media( get_the_content() );
			break;

		case 'link':
			$cs_format = post_format_link_helper( get_the_content(), get_the_title() );
			$cs_title  = $cs_format['title'];

			// if has post thumbnail, add link for thumbnail.
			if ( has_post_thumbnail() ) {
				$cs_link = cs_get_link_attributes( $cs_title );
				cs_post_thumbnail( $cs_link );
			}
			echo $cs_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output

			break;

		case 'gallery':
			echo cs_post_gallery( get_the_content() );
			break;

		default:
			cs_post_thumbnail();
			break;
	}

	  global $more;
	  $more = 0;
	?>

	<header class="entry-header">

	  <?php
		if ( ! is_single() && $post_format != 'link' ) {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); }
		?>

	  <div class="entry-meta">
		<?php cs_posted_on(); ?>
	  </div>

	</header><!-- /entry-header -->

	<?php if ( has_excerpt() ) : ?>
	<div class="entry-summary"><?php the_excerpt(); ?></div><!-- /entry-summary -->
	<?php else : ?>
	<div class="entry-content"><?php the_content( __( 'Read More', 'articlemag' ) ); ?></div><!-- /entry-content -->
	<?php endif; ?>

  </div>
</article><!-- /post-standard -->

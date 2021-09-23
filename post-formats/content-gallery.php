<?php
/**
 *
 * The template for displaying posts in the Gallery post format
 *
 * @since 1.0
 * @version 1.2.0
 */
?>

<?php
if ( is_single() && 'post' == get_post_type() ) :
	?>
  <article id="post-<?php the_ID(); ?>" <?php post_class( '' ); ?>>
	<header class="entry-header">
	  <h1 class="entry-title"><?php the_title(); ?></h1>
	  <div class="post-meta">
		<span><?php the_category( ' ' ); ?></span>
		<span><?php the_modified_date(); ?></span>
	  </div>
	</header>

	<div class="post-content">
	  <?php echo cs_post_gallery( get_the_content() ); ?>
	  <?php the_content(); ?>
	</div>
  </article>
<?php else : ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class( 'article-post' ); ?>>

	<div class="article-card-img" style="background: url(<?php echo get_the_post_thumbnail_url( $post_id, 'large' ); ?>);">
	  <a href="<?php the_permalink(); ?>" class="article-card-link"></a>
	  <div class="article-avatar">
		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" class="tippy-js" data-tippy-content="<?php echo esc_html( 'Posted by', 'articlemag' ) . ' ' . get_the_author(); ?>">
		  <?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
		</a>
	  </div>
	  <?php
		$featured_post = get_post_meta( get_the_ID(), 'meta-checkbox', true );
		if ( $featured_post == 1 ) {
			?>
		<a href="<?php the_permalink(); ?>" class="article-card-featured tippy-js" data-tippy-content="Featured"><i class="fas fa-star"></i></a>
	   <?php } ?> 
	</div>

	<div class="article-card-info">

	  <div class="article-cat"><?php the_category( ' ' ); ?></div>
	  <a href="<?php the_permalink(); ?>">
		<header class="entry-header">
		  <h2 class="entry-title"><?php the_title(); ?></h2>
		  <div class="entry-meta">
			<?php the_modified_date(); ?>
		  </div>
		</header><!-- /entry-header -->
	  </a>
	</div>

  </article><!-- /post-standard -->

<?php endif; ?>


<?php do_action( 'cs_post_format_content_after', $post ); ?>

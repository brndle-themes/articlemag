<?php
/**
 *
 * The default template for displaying content
 * @since 1.0
 * @version 1.2.0
 *
 */
?>


<?php if ( is_single() && 'post' == get_post_type() ) :
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( '' ); ?>>
		<div class="single-post-image">
			<div class="post-image" style="background: url('<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>')"></div>
		</div>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="post-meta">
				<span><?php the_category( ' ' ); ?></span>
				<span><?php the_modified_date(); ?></span>
			</div>
		</header>

		<div class="post-content">
			<div class="article-share">
				<div class="share-content sticky">
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank" class="sticky-icons"><i class="fa fa-facebook"></i></a>
					<a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank" class="sticky-icons"><i class="fa fa-twitter"></i></a>
				</div>
			</div>
			<?php the_content(); ?>
		</div>
	</article>
<?php else: ?>

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
			if ( $featured_post == 'yes' ) {
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
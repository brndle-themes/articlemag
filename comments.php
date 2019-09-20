<?php
/**
 *
 * The template for displaying Comments
 * The area of the page that contains comments and the comment form.
 * @since 1.0.0
 * @version 1.0.0
 *
 */

/*
 * If the current post is protected by a password and the visitor has not yet entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) { return; }
?>
<div id="comments" class="comments-area">

  <?php if ( have_comments() ) : ?>

  <h2 class="comments-title"><?php printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'articlemag' ), number_format_i18n( get_comments_number() ), get_the_title() ); ?></h2>

  <ol class="comment-list">
    <?php
      wp_list_comments( array(
        'style'      => 'ol',
        'short_ping' => true,
        'avatar_size'=> 50,
      ) );
    ?>
  </ol><!-- .comment-list -->

  <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
  <nav class="comment-navigation" role="navigation">
    <div class="nav-previous"><?php previous_comments_link( '<i class="fa fa-angle-left"></i> '. __( 'Older Comments', 'articlemag' ) ); ?></div>
    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'articlemag' ) . ' <i class="fa fa-angle-right"></i>' ); ?></div>
    <div class="clear"></div>
  </nav><!-- #comment-nav-below -->
  <?php endif; // Check for comment navigation. ?>

  <?php if ( ! comments_open() ) : ?>
  <p class="no-comments"><?php _e( 'Comments are closed.', 'articlemag' ); ?></p>
  <?php endif; ?>

  <?php endif; // have_comments() ?>

  <?php echo cs_comment_form(); ?>

</div><!-- #comments -->
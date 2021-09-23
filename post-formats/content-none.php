<?php
/**
 *
 * If no content, include the "No posts found" template.
 *
 * @since 1.0
 * @version 1.0.0
 */

?>
<article id="post-0" class="post no-results not-found">
  <div class="entry-content e-entry-content">
	<p><?php esc_html_e( 'It seems we can not find what you are looking for. Perhaps searching can help.', 'articlemag' ); ?></p>
	<?php get_search_form(); ?>
  </div><!-- entry-content -->
</article><!-- /article -->

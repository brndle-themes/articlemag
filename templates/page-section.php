<?php
/**
 *
 * Full 100% width, without anything
 * @since 1.0.0
 * @version 1.0.1
 *
 */
while ( have_posts() ) : the_post();
  the_content();
endwhile;
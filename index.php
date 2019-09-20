<?php
/**
 *
 * The main template file
 * @since 1.7.0
 * @version 1.0.0
 *
 */

get_header();
get_template_part( 'templates/page-header' );
get_template_part( 'templates/page', 'loop' );
get_footer();
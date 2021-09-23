<?php
/**
 *
 * The home template file
 *
 * @since 1.0.0
 * @version 1.0.0
 */

get_header();
get_template_part( 'templates/page-header' );
get_template_part( 'templates/page-home-header' );
get_template_part( 'templates/page', 'loop' );
get_footer();

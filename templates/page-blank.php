<?php
/**
 *
 * Template Name: Blank - No Header, No Footer
 *
 * @since 1.0.0
 * @version 1.0.0
 */

?><!DOCTYPE html>
<!--[if IE 6]><html class="ie ie6 no-js" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="ie ie7 no-js" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8 no-js" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
  <head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title>
	<?php
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	?>
	</title>
	<?php if ( ! cs_get_option( 'non_responsive' ) ) { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php } else { ?>
	<meta name="viewport" content="width=1200">
	<?php } ?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php
	if ( is_search() || is_404() ) {
		echo '<meta name="robots" content="noindex, nofollow" />'; }
	?>
	<?php
	if ( cs_multilang_value( cs_get_option( 'favicon' ) ) ) {
		echo '<link rel="shortcut icon" href="' . cs_multilang_value( cs_get_option( 'favicon' ) ) . '" />'; }
	?>
	<?php wp_head(); ?>
  </head>
  <body <?php body_class( 'cs-blank' ); ?>>
	<div class="cs-blank-wrap">
	  <?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
	<?php wp_footer(); ?>
  </body>
</html>

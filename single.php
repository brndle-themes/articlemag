<?php
/**
 *
 * The Template for displaying all single posts.
 *
 * @since 1.0.0
 * @version 1.3.0
 * @package single
 */

get_header();

global $cs_has_section, $post;

$cs_post_meta    = get_post_meta( $post->ID, '_side_custom_page_options', true );
$cs_page_layout  = ( isset( $cs_post_meta['sidebar'] ) ) ? $cs_post_meta['sidebar'] : 'right';
$cs_page_column  = ( $cs_page_layout == 'full' ) ? '12' : ( ( $cs_page_layout == 'both' ) ? '6' : '9' );
$vc_exclude      = cs_get_option( 'vc_exclude_shortcodes' );
$vc_exclude      = ( is_array( $vc_exclude ) ) ? $vc_exclude : array();
$cs_page_padding = ( ! in_array( 'vc_row', $vc_exclude ) ) ? 'md-padding ' : '';
$cs_has_section  = isset( $cs_post_meta['section'] ) ? true : false;

if ( ( $cs_page_layout == 'fluid' || isset( $cs_post_meta['section'] ) ) && ! in_array( 'vc_row', $vc_exclude ) ) {

	get_template_part( 'templates/page', 'section' );

} else {
	?>
<section class="main-content blog-default single-post">

	<?php get_template_part( 'templates/page-header' ); ?>
	<?php cs_post_thumbnail(); ?>
<div class="container">
<div class="row signle-post-content cs-row-wrap">

	<?php cs_page_sidebar( 'left', $cs_page_layout ); ?>

	<div class="cs-content-wrapper col-md-<?php echo esc_attr( $cs_page_column ); ?>">
		<div class="page-content">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'post-formats/content', get_post_format() );

			cs_post_nav();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || '0' != get_comments_number() ) {
				comments_template( '', true );
			}

			endwhile;
		?>
		</div>
	</div>

	<?php cs_page_sidebar( 'right', $cs_page_layout ); ?>

	</div>
</div>
</section>
	<?php
}
get_footer();

<?php
/**
 *
 * The template for displaying bbpress forum.
 *
 * @since 1.4.0
 * @version 1.0.0
 * @package bbpress
 */

get_header();
get_template_part( 'templates/page-header' );

$cs_bbpress_layout = cs_get_option( 'bbpress_sidebar', 'full' );
$cs_page_column    = ( $cs_page_layout == 'full' ) ? '12' : ( ( $cs_page_layout == 'both' ) ? '6' : '9' );

?>
<section class="main-content md-padding page-layout-<?php echo esc_attr( $cs_bbpress_layout ); ?>">
<div class="container">
	<div class="row cs-row-wrap">

	<?php cs_page_sidebar( 'left', $cs_bbpress_layout ); ?>

	<div class="cs-content-wrapper col-md-<?php echo esc_attr( $cs_page_column ); ?>">
		<div class="page-content">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
			endwhile;
		?>
		</div>
	</div>

	<?php cs_page_sidebar( 'right', $cs_bbpress_layout ); ?>

	</div>
</div>
</section>
<?php
get_footer();

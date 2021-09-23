<?php
/**
 *
 * The template for displaying archive pages.
 *
 * @since 1.0.0
 * @version 1.1.0
 * @package archieve
 */

get_header(); ?>

<section id="page-header">
<div class="category-hero" ></div>
<div class="container">
	<div class="row">
	<div class="col-md-12 md-padding">

		<div class="category-content">
			<div class="category-content-inner">
				<h1 class="page-title">
				<?php
				if ( is_day() ) {
					printf( __( 'Daily Archives: %s', 'articlemag' ), get_the_date() );
				} elseif ( is_month() ) {
					printf( __( 'Monthly Archives: %s', 'articlemag' ), get_the_date( 'F Y' ) );
				} elseif ( is_year() ) {
					printf( __( 'Yearly Archives: %s', 'articlemag' ), get_the_date( 'Y' ) );
				} else {
					_e( 'Archives', 'articlemag' );
				}
				?>
				</h1>
				<?php echo cs_breadcrumb(); ?>
			</div>
			</div>    
	</div>
	</div>
</div>
</section><!-- /page-header -->
<?php get_template_part( 'templates/page', 'loop' ); ?>
<?php
get_footer();

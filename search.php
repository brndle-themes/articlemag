<?php
/**
 *
 * The template for displaying search posts.
 *
 * @since 1.0.0
 * @version 1.1.0
 */

get_header(); ?>

<section id="page-header">
<div class="category-hero"></div>
<div class="container">
	<div class="row">
	<div class="col-md-12 md-padding">

	<div class="category-content">
			<div class="category-content-inner">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'articlemag' ), get_search_query() ); ?></h1>
				<?php echo cs_breadcrumb(); ?>  
			</div>  
		</div>       
		</div>
	</div>
</div>
</section><!-- /page-header -->

<section class="main-content md-padding blog-default blog-search">
<div class="container">
	<div class="row">

	<div class="col-md-9">
		<?php
		if ( have_posts() ) :

			// loop posts.
			while ( have_posts() ) :
				the_post();
				?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="entry-header">

				<h2 class="entry-title"><a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<div class="entry-meta">
				<?php cs_posted_on(); ?>
				</div>

			</header><!-- /entry-header -->

			<div class="entry-summary"><?php the_excerpt(); ?></div><!-- /entry-summary -->

			</article><!-- /post-standard -->
				<?php
			endwhile;

			// pagination.
			cs_paging_nav( array( 'nav' => 'archive' ) );

		else :

			// If no content, include the "No posts found" template.
			get_template_part( 'post-formats/content', 'none' );

		endif;
		?>
	</div>

	<?php cs_page_sidebar(); ?>

	</div>
</div>
</section><!-- /section -->
<?php
get_footer();

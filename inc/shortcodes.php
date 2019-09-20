<?php
add_shortcode( 'articlemag-featured-posts', 'display_articlemag_featured_posts' );

function display_articlemag_featured_posts( $atts = array() ) {
	global $wp_query, $paged, $post;
	$atts  = shortcode_atts(
		array(
			'limit' => 5,
		),
		$atts
	);

	echo '<div class="featured_blog_posts_widget article-featured-slider">';
	$tmp_query	 = $wp_query;
	ob_start();
	?>
	<div class="article-slider">
            
      <?php
      	$is_featured_exists = false;
        $args = array(
			'posts_per_page' => $atts['limit'],
			'post_type'		 => 'post',
			'meta_key'       => 'meta-checkbox',
            'meta_value'     => 'yes'
		);
        $all_posts =  new WP_Query( $args );
        if ( ! $all_posts->have_posts() ) {
        	$args = array(
				'posts_per_page' => $atts['limit'],
				'post_type'		 => 'post',
			);
            $all_posts =  new WP_Query( $args );
            $is_featured_exists = false;
        } else {
        	$is_featured_exists = true;
        }

        if ( $all_posts->have_posts() ): while( $all_posts->have_posts() ): $all_posts->the_post(); ?>
        <div> 
          <article class="article-featured-slider-sec">
            <div class="article-featured-img">
              <div class="featured-article" style="background: url('<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>')"></div>
            </div> 
            <div class="article-featured-info">
				<div class="article-avatar"> 
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" class="tippy-js" data-tippy-content="<?php echo esc_html( 'Posted by', 'articlemag' ) . ' ' . get_the_author(); ?>">
					    <?php echo get_avatar( get_the_author_meta( 'ID' )); ?>  
					</a>
				</div>
				<div class="article-cat"><?php the_category( ' ' ); ?></div>
					<a href="<?php the_permalink(); ?>" class="article-card-featured">
					<span><i class="fa fa-star"></i></span>
					<span>
					<?php if ( $is_featured_exists ) { ?>
						<?php esc_html_e( 'Featured', 'articlemag' ); ?>
					<?php } else { ?>
						<?php esc_html_e( 'Recent', 'articlemag' ); ?>
					<?php } ?>
					</span>
				</a>
            </div>
            <a href="<?php echo get_the_permalink(); ?>" class="article-featured-content">
                <h2><?php the_title(); ?></h2>
                <div class="entry-meta">
                    <?php the_modified_date(); ?>
                </div>
            </a>
          </article> 
        </div>
      <?php 
        endwhile; else:

        endif;
      ?>
       
    </div>
    <?php
	wp_reset_query();
	wp_reset_postdata();
	$wp_query = $tmp_query;
	echo '</div><div class="clear"></div>';
	return ob_get_clean();
}
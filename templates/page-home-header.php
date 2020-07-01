<?php
$homepage_image       = cs_multilang_value( cs_get_option( 'homepage_cover' ) );
$homepage_title       = cs_multilang_value( cs_get_option( 'homepage_title' ) );
$homepage_subtitle    = cs_multilang_value( cs_get_option( 'homepage_default_subtitle' ) );
$homepage_action      = cs_multilang_value( cs_get_option( 'homepage_action_button' ) );
$homepage_action_link = cs_get_option( 'homepage_action_button_link' );
$is_dynamic_cover     = cs_get_option( 'set_homepage_cover' );
$post_count           = ! empty( cs_get_option( 'post_count' ) ) ? cs_get_option( 'post_count' ) : 5;
$post_category        = cs_get_option( 'set_post_categories' );
$post_category    	  = ! empty( $post_category ) ? $post_category : array();

$post_category_list = implode( ', ', $post_category );

if ( is_home() ) {
	$slider_posts = get_posts(
		array(
			'post_type'   => 'post',
			'numberposts' => $post_count,
			'orderby'     => 'date',
			'order'       => 'DESC',
			'category'    => $post_category_list,

		)
	);
	?>
	<?php if ( $is_dynamic_cover ) : ?>
	<section class="header-hero-slider">	
		<div class="hero-post-slider">  
			<?php foreach ( $slider_posts as $slider_post ) : ?>
				<?php $slider_image = wp_get_attachment_image_src( get_post_thumbnail_id( $slider_post->ID ), 'articlemag-featured-large' ); ?>			
				<div class="header-hero-post">
					<div class="header-post-img">
						<img src="<?php echo esc_url( $slider_image[0] ); ?>" alt="<?php echo esc_attr( $slider_post->post_title ); ?>" />
					</div>
					<div class="header-post-title">
						<a href="<?php echo esc_url( get_permalink( $slider_post->ID ) ); ?>" target="blank"><?php echo esc_html( $slider_post->post_title ); ?></a>
					</div>				
				</div>
			<?php endforeach; ?>  
		</div>  	
	</section>
	<?php else : ?>
	<section class="header-hero">
		<div class="header-hero-img" style="background:url( '<?php echo $homepage_image; ?>' );"></div>
		<div class="header-hero-content">
			<h1 class="hero-title"><?php echo esc_html( $homepage_title ); ?></h1>
			<p class="hero-description"><?php echo esc_html( $homepage_subtitle ); ?></p>
			<a href="<?php echo esc_url( $homepage_action_link ); ?>" class="hero-button"><?php echo esc_html( $homepage_action ); ?></a>
		</div>
	</section>
		<?php
	endif;

}

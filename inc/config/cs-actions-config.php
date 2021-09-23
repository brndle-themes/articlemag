<?php
/**
 *
 * After Theme Supports
 *
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! function_exists( 'cs_after_setup_theme' ) ) {

	/**
	 * Cs_after_setup_theme
	 */
	function cs_after_setup_theme() {

		global $content_width;

		if ( ! isset( $content_width ) ) {
			$content_width = 1260;
		}

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'video', 'audio', 'link', 'quote', 'status', 'chat' ) );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'custom-background' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'bbpress' );
		add_theme_support( 'title-tag' );

		remove_theme_support( 'custom-header' );

		$custom_image_sizes = cs_get_option( 'custom_image_sizes' );
		if ( ! empty( $custom_image_sizes ) ) {
			foreach ( $custom_image_sizes as $size ) {
				$crop = ( $size['crop'] === true ) ? true : false;
				add_image_size( sanitize_title( $size['name'] ), $size['size']['width'], $size['size']['height'], $crop );
			}
		}

		register_nav_menus(
			array(
				'primary' => 'Main menu',
				'mobile'  => 'Mobile menu (optional)',
				'right'   => 'Right menu (for center logo)',
			)
		);

		register_nav_menus(
			array(
				'bp-userbar' => 'User Menu',
			)
		);

		load_theme_textdomain( 'articlemag', THEME_DIR . '/languages' );

		/**
		 *
		 * Gutenberg Optimized
		 */
		// Add support for Block Styles.
		// add_theme_support( 'wp-block-styles' );
		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );
		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'articlemag-featured-large', 1920, 600 );
			add_image_size( 'articlemag-thumb', 600, 300 );
		}
	}

	add_action( 'after_setup_theme', 'cs_after_setup_theme' );
}


/**
 *
 * Articlemag Shortcode Block for Gutenberg
 *
 * @since 6.4.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_articlemag_shortcode_block' ) && function_exists( 'register_block_type' ) ) {

	/**
	 * Cs articlemag shortcode block
	 *
	 * @return void
	 */
	function cs_articlemag_shortcode_block() {

		wp_register_script(
			'articlemag-shortcode-block',
			FRAMEWORK_ASSETS . '/js/cs-gutenberg-block.js',
			array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-components' )
		);

		register_block_type(
			'articlemag/shortcode-block',
			array(
				'editor_script' => 'articlemag-shortcode-block',
			)
		);
	}

	add_action( 'init', 'cs_articlemag_shortcode_block' );
}

/**
 *
 * Post Love Ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_post_love' ) ) {

	/**
	 * Cs post love
	 */
	function cs_post_love() {

		if ( isset( $_POST['id'] ) && wp_verify_nonce( $_POST['love_it_nonce'], 'love-it-nonce' ) ) {
			$post_id    = $_POST['id'];
			$love_count = get_post_meta( $post_id, '_love_count', true );
			$love_count = ( ! empty( $love_count ) ) ? ++$love_count : 1;
			update_post_meta( $post_id, '_love_count', $love_count );
			setcookie( 'articlemag_love_' . $post_id, $post_id, time() + ( 86400 * 7 ), '/' );
			echo 'loved';
		} else {
			echo 'error';
		}

		die();
	}

	add_action( 'wp_ajax_nopriv_post-love', 'cs_post_love' );
	add_action( 'wp_ajax_post-love', 'cs_post_love' );
}

/**
 *
 * Import Dump XML
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_import_dump' ) ) {

	/**
	 * Cs import dump
	 */
	function cs_import_dump() {

		echo '<div id="cs-install-result">';

		// importing xml.
		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		if ( ! class_exists( 'WP_Import' ) ) {
			require_once FRAMEWORK_PLUGIN_DIR . '/wordpress-importer/wordpress-importer.php';
		}

		$attachment = ( ! empty( $_POST['attachment'] ) ) ? true : false;

		ob_start();
		$wp_import                    = new WP_Import();
		$wp_import->fetch_attachments = $attachment;
		$wp_import->import( FRAMEWORK_DIR . '/config/dump/dump.xml' );
		$wp_import_result = ob_get_clean();

		// setting menu.
		$locations = get_theme_mod( 'nav_menu_locations' );
		$menus     = wp_get_nav_menus();

		if ( ! empty( $menus ) ) {
			foreach ( $menus as $menu ) {
				if ( is_object( $menu ) && $menu->slug == 'main' ) {
					$locations['primary'] = $menu->term_id;
				}
			}
			set_theme_mod( 'nav_menu_locations', $locations );
		}

		// setting custom menu fields.
		$menu_items = wp_get_nav_menu_items( 'main' );

		if ( ! empty( $menu_items ) ) {

			$menu_fields = array(
				// HOME.
				'Home Version 3'      => array(
					'highlight'      => 'one page',
					'highlight_type' => 'danger',
				),
				'Home Version 5'      => array( 'highlight' => 'blog' ),
				// HEADERS.
				'Header Version 1'    => array( 'content' => 'Left Logo - Right Menu Default' ),
				'Header Version 2'    => array( 'content' => 'Left Logo - Logo Below Menu' ),
				'Header Version 3'    => array( 'content' => 'Center Logo - Center Menu' ),
				'Header Version 4'    => array( 'content' => 'Transparency Header' ),
				'Header Version 5'    => array( 'content' => 'Fullscreen Slider - Below Header' ),
				'Header Version 6'    => array( 'content' => 'Fancy Header' ),
				'Header Version 7'    => array( 'content' => 'Video Header' ),
				// SHORTCODES.
				'Shortcodes'          => array(
					'mega' => 1,
					'',
				),
				'Grid with Load More' => array(
					'highlight'      => 'hot',
					'highlight_type' => 'danger',
				),
				'Icon Box'            => array(
					'highlight'      => 'useful',
					'highlight_type' => 'success',
				),
				'Icon Fancybox'       => array(
					'highlight'      => 'useful',
					'highlight_type' => 'info',
				),
			);

			if ( ! empty( $menu_fields ) ) {
				foreach ( $menu_items as $menu_key => $menu_item ) {
					foreach ( $menu_fields as $field_key => $field_data ) {
						if ( $field_key == $menu_item->title ) {
							foreach ( $field_data as $key => $value ) {
								update_post_meta( $menu_item->ID, '_menu_item_' . $key, $value );
							}
						}
					}
				}
			}
		}

		// setting home-page.
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', cs_get_id_by_slug( 'home' ) );

		echo '</div>';

		update_option( 'cs-installed', true );

		die();
	}

	add_action( 'wp_ajax_cs-import-dump', 'cs_import_dump' );
}

/**
 *
 * Ajax Pagination
 *
 * @since 1.0.0
 * @version 1.2.0
 */
if ( ! function_exists( 'cs_ajax_pagination' ) ) {

	/**
	 * Cs ajax pagination
	 */
	function cs_ajax_pagination() {

		$type       = ( ! empty( $_POST['post_type'] ) ) ? $_POST['post_type'] : 'post';
		$template   = ( ! empty( $_POST['template'] ) ) ? $_POST['template'] : 'default';
		$categories = ( ! empty( $_POST['cats'] ) ) ? $_POST['cats'] : '';
		$query_args = array(
			'paged'          => $_POST['paged'],
			'posts_per_page' => $_POST['posts_per_page'],
			'post_type'      => $type,
			'post_status'    => 'publish',
		);

		if ( $type == 'portfolio' && ! empty( $categories ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio-category',
					'field'    => 'id',
					'terms'    => explode( ',', $categories ),
				),
			);
		}

		if ( $type == 'post' && ! empty( $categories ) ) {
			$query_args['cat'] = $categories;
		}

		query_posts( $query_args );

		while ( have_posts() ) :
			the_post();

			if ( $type == 'post' ) {

				global $cs_blog_image_size, $cs_blog_column;

				$cs_blog_image_size = $_POST['size'];
				$cs_blog_column     = $_POST['columns'];

				if ( $template != 'default' ) {

					$template = ( $template == 'grid' ) ? 'masonry' : $template;
					get_template_part( 'templates/page-blog', $template );
				} else {

					get_template_part( 'post-formats/content', get_post_format() );
				}
			} elseif ( $type == 'portfolio' ) {

				$item_args = array(
					'columns' => $_POST['columns'],
					'model'   => $_POST['model'],
					'love'    => $_POST['love'],
					'size'    => $_POST['size'],
				);
				cs_portfolio_item( $item_args );
			}

		endwhile;
		wp_reset_query();

		die();
	}

	add_action( 'wp_ajax_ajax-pagination', 'cs_ajax_pagination' );
	add_action( 'wp_ajax_nopriv_ajax-pagination', 'cs_ajax_pagination' );
}




/**
 * Add fields to user profile screen, add new user screen
 */
if ( ! function_exists( 'brndle_profile_fields' ) ) {

	// This action for 'Add New User' screen.
	add_action( 'user_new_form', 'brndle_profile_fields' );

	// This actions for 'User Profile' screen.
	add_action( 'show_user_profile', 'brndle_profile_fields' );
	add_action( 'edit_user_profile', 'brndle_profile_fields' );

	function brndle_profile_fields( $user ) {

		if ( ! current_user_can( 'administrator', $user->ID ) ) {
			return false;
		}

		$social_url = get_user_meta( $user->ID, 'social_url', true );
		?>

		<h3>Social Media</h3>
		<table class="form-table">
			<tr>
				<th><label for="dropdown">Facebook</label></th>
				<td>
					<input type="text" class="regular-text" name="facebook" value="<?php echo ! empty( $social_url['facebook'] ) ? esc_attr( $social_url['facebook'] ) : ''; ?>" id="facebook" />
				</td>
			</tr>
			<tr>
				<th><label for="dropdown">Twitter</label></th>
				<td>
					<input type="text" class="regular-text" name="twitter" value="<?php echo ! empty( $social_url['twitter'] ) ? esc_attr( $social_url['twitter'] ) : ''; ?>" id="twitter" />
				</td>
			</tr>
			<tr>
				<th><label for="dropdown">Linkedin</label></th>
				<td>
					<input type="text" class="regular-text" name="linkedin" value="<?php echo ! empty( $social_url['linkedin'] ) ? esc_attr( $social_url['linkedin'] ) : ''; ?>" id="linkedin" />
				</td>
			</tr>
			<tr>
				<th><label for="dropdown">Instagram</label></th>
				<td>
					<input type="text" class="regular-text" name="instagram" value="<?php echo ! empty( $social_url['instagram'] ) ? esc_attr( $social_url['instagram'] ) : ''; ?>" id="instagram" />
				</td>
			</tr>
			<tr>
				<th><label for="dropdown">Youtube</label></th>
				<td>
					<input type="text" class="regular-text" name="youtube" value="<?php echo ! empty( $social_url['youtube'] ) ? esc_attr( $social_url['youtube'] ) : ''; ?>" id="youtube" />
				</td>
			</tr>
		</table>
		<?php
	}
}


/**
 *  Save portal category field to user profile page, add new profile page etc
 */
if ( ! function_exists( 'brndle_save_profile_fields' ) ) {

	// This action for 'Add New User' screen.
	add_action( 'user_register', 'brndle_save_profile_fields' );

	// This actions for 'User Profile' screen.
	add_action( 'personal_options_update', 'brndle_save_profile_fields' );
	add_action( 'edit_user_profile_update', 'brndle_save_profile_fields' );

	function brndle_save_profile_fields( $user_id ) {

		if ( ! current_user_can( 'administrator', $user_id ) ) {
			return false;
		}
		$user_meta = array(
			'facebook'  => $_POST['facebook'],
			'twitter'   => $_POST['twitter'],
			'linkedin'  => $_POST['linkedin'],
			'instagram' => $_POST['instagram'],
			'youtube'   => $_POST['youtube'],
		);

		update_usermeta( $user_id, 'social_url', $user_meta );
	}
}


/**
 *
 * Post Format Content After
 *
 * @since 1.0.0
 * @version 1.2.0
 */
if ( ! function_exists( 'cs_post_format_content_after' ) ) {

	function cs_post_format_content_after( $post = null ) {

		cs_link_pages();

		if ( is_single() ) {
			$user_id     = $post->post_author;
			$social_urls = get_user_meta( $user_id, 'social_url', true );
			?>
			<footer class="entry-footer">

				<?php the_tags( '<div class="entry-tags"><span class="tag-links">', ', ', '</span></div>' ); ?>

				<?php do_action( 'cs_single_content_after', $post ); ?>

				<?php if ( cs_get_option( 'blog_single_author' ) != false ) : ?>
					<div class="entry-author" itemprop="author" itemscope itemtype="http://schema.org/Person">
						<div class="author-avatar" itemprop="image">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), 70, '', esc_html( get_the_author_meta( 'display_name' ) ) ); ?>
						</div>
						<div class="author-info">
							<h2 class="author-title"><span class="author-name" itemprop="name"><?php the_author(); ?></span></h2>
							<div class="author-description" itemprop="description"><?php the_author_meta( 'description' ); ?></div>
							<div class="author-meta">
								<ul class="author-social">
									<?php if ( is_array( $social_urls ) && ! empty( $social_urls ) ) : ?>
										<?php if ( ! empty( $social_urls['facebook'] ) ) : ?>
											<li><a href="<?php echo $social_urls['facebook']; ?>" class="bs-facebook"><i class="fa fa-facebook"></i></a></li>
										<?php endif; ?>
										<?php if ( ! empty( $social_urls['twitter'] ) ) : ?>
											<li><a href="<?php echo $social_urls['twitter']; ?>" class="bs-twitter"><i class="fa fa-twitter"></i></a></li>
										<?php endif; ?>
										<?php if ( ! empty( $social_urls['linkedin'] ) ) : ?>
											<li><a href="<?php echo $social_urls['linkedin']; ?>" class="bs-linkedin"><i class="fa fa-linkedin"></i></a></li>
										<?php endif; ?>
										<?php if ( ! empty( $social_urls['instagram'] ) ) : ?>
											<li><a href="<?php echo $social_urls['instagram']; ?>" class="bs-instagram"><i class="fa fa-instagram"></i></a></li>
										<?php endif; ?>
										<?php if ( ! empty( $social_urls['youtube'] ) ) : ?>
											<li><a href="<?php echo $social_urls['youtube']; ?>" class="bs-youtube"><i class="fa fa-youtube-play"></i></a></li>
										<?php endif; ?>
									<?php endif; ?>
								</ul>
							</div>
						</div>
						<div class="clear"></div>
					</div><!-- /entry-author -->
				<?php endif; ?>

				<?php
				if ( cs_get_option( 'blog_single_recents' ) != false ) :

					$single_recents    = cs_get_option( 'single_recents' );
					$single_title      = cs_get_option( 'single_recents_title' );
					$single_thumb      = cs_get_option( 'single_recents_thumbnail' );
					$single_thumb_size = cs_get_option( 'single_recents_thumbnail_size', 'thumbnail' );
					$type              = ( ! empty( $single_recents ) ) ? $single_recents : 'random';
					$title             = ( ! empty( $single_title ) ) ? $single_title : ucfirst( $type ) . ' Posts';
					$operation         = true;

					$args = array(
						'post_type'           => 'post',
						'ignore_sticky_posts' => 1,
						'posts_per_page'      => 2,
					);

					switch ( $type ) {

						case 'commented':
							$args['orderby'] = 'comment_count';
							break;

						case 'random':
							$args['orderby'] = 'rand';
							break;

						case 'related':
							$tags = wp_get_post_tags( $post->ID );
							$ids  = array();

							if ( ! empty( $tags ) ) {
								foreach ( $tags as $term ) {
									$ids[] = $term->term_id;
								}
							} else {
								$operation = false;
							}

							$args['tag__in'] = $ids;
							$args['orderby'] = 'rand';

							break;

						case 'loved':
							$args['meta_key'] = '_love_count';
							$args['orderby']  = 'meta_value_num';
							$args['order']    = 'DESC';

							break;

						default:
							$args['orderby'] = 'date';
							break;
					}

					$args['post__not_in'] = array( $post->ID );

					$q = new WP_Query( $args );

					if ( $q->have_posts() && $operation === true ) {

						$related_class = ( ! empty( $single_thumb ) ) ? ' related-posts-thumbnail' : '';

						echo '<div class="related-posts' . $related_class . '"><h2 class="related-title">' . cs_multilang_value( $title ) . '</h2><div class="article-post-gird ">';

						while ( $q->have_posts() ) :
							$q->the_post();
							setup_postdata( $post );

							$cs_featured   = '';
							$featured_post = get_post_meta( get_the_ID(), 'meta-checkbox', true );
							if ( $featured_post == 'yes' ) {
								$cs_featured = ' cs-featured';
							}

							if ( ! empty( $single_thumb ) ) {

								$image = wp_get_attachment_image_src( get_post_thumbnail_id(), $single_thumb_size );
								$image = ( ! empty( $image ) ) ? '<img src="' . $image[0] . '" alt="' . get_the_title() . '" />' : '<img src="' . THEME_URI . '/images/no-pictures/no-standard-picture.png" alt="No Picture" />';

								echo '<article class="article-post' . $cs_featured . '">
										<div class="article-card-img">
											<a href="' . esc_url( get_permalink() ) . '">' . $image . '</a>
											<a href="' . esc_url( get_permalink() ) . '" class="article-card-link"></a>
										</div>
										<div class="article-avatar"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ) . '" class="tippy-js" data-tippy-content="
											' . esc_html( 'Posted by', 'articlemag' ) . ' ' . get_the_author() . '">' . get_avatar( get_the_author_meta( 'ID' ) ) . '</a></div>
										<a href="' . esc_url( get_permalink() ) . '" class="article-card-featured tippy-js" data-tippy-content="Featured"><i class="fas fa-star"></i></a><div class="article-card-info">';
								echo '<div class="article-cat">' . the_category( ' ' ) . '</div>';
								echo '<a href="' . esc_url( get_permalink() ) . '">' . '<header class="entry-header"><h2 class="entry-title">' . get_the_title() . '</h2><div class="entry-meta">' . esc_html( get_the_date() ) . '</div></header></a>
									</article>';
							} else {
								echo '<article class="article-post article-post-not-img">';
								echo '<div class="article-card-info">';
								echo '<div class="article-cat">' . the_category( ' ' ) . '</div>';
								echo '<a href="' . esc_url( get_permalink() ) . '">' . '<header class="entry-header"><h2 class="entry-title">' . get_the_title() . '</h2><div class="entry-meta">' . esc_html( get_the_date() ) . '</div></header></a>';
								echo '</div>';
								echo '</article>';
							}

						endwhile;

						echo '</div></div>';
					}

					wp_reset_postdata();
					wp_reset_query();

				endif;
				?>
				<!-- entry-recents -->

			</footer><!-- /entry-footer -->
			<?php
		}
	}

	add_action( 'cs_post_format_content_after', 'cs_post_format_content_after' );
}



/**
 *
 * Post Author Box
 *
 * @since 1.0.0
 * @version 1.2.0
 */
if ( ! function_exists( 'cs_post_author_box' ) ) {

	function cs_post_author_box( $author_id ) {
		if ( is_author() ) {
			$social_urls = get_user_meta( $author_id, 'social_url', true );
			?>



			<div class="author-content">
				<div class="author-content-inner">
					<div class="author_hero"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 100, '', esc_html( get_the_author_meta( 'display_name' ) ) ); ?></div>
					<h1 class="author-title" itemprop="name"><?php the_author(); ?></h1>
					<p class="author-description" itemprop="description"><?php the_author_meta( 'description' ); ?></p>
					<div class="author-meta">
						<ul class="author-social">
							<?php if ( is_array( $social_urls ) && ! empty( $social_urls ) ) : ?>
								<?php if ( ! empty( $social_urls['facebook'] ) ) : ?>
									<li><a href="<?php echo $social_urls['facebook']; ?>" class="bs-facebook"><i class="fa fa-facebook"></i></a></li>
								<?php endif; ?>
								<?php if ( ! empty( $social_urls['twitter'] ) ) : ?>
									<li><a href="<?php echo $social_urls['twitter']; ?>" class="bs-twitter"><i class="fa fa-twitter"></i></a></li>
								<?php endif; ?>
								<?php if ( ! empty( $social_urls['linkedin'] ) ) : ?>
									<li><a href="<?php echo $social_urls['linkedin']; ?>" class="bs-linkedin"><i class="fa fa-linkedin"></i></a></li>
								<?php endif; ?>
								<?php if ( ! empty( $social_urls['instagram'] ) ) : ?>
									<li><a href="<?php echo $social_urls['instagram']; ?>" class="bs-instagram"><i class="fa fa-instagram"></i></a></li>
								<?php endif; ?>
								<?php if ( ! empty( $social_urls['youtube'] ) ) : ?>
									<li><a href="<?php echo $social_urls['youtube']; ?>" class="bs-youtube"><i class="fa fa-youtube-play"></i></a></li>
								<?php endif; ?>
							<?php endif; ?>
						</ul>
						<span class="post-count"><?php echo '' . count_user_posts( get_the_author_meta( 'ID' ) ) . ' Post'; ?></span>
					</div>

				</div>
			</div>

			<?php
		}
	}
}



/**
 *
 * Contact Form7 Submit
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( function_exists( 'wpcf7_add_form_tag' ) && ! function_exists( 'wpcf7_submit_customize' ) ) {

	function wpcf7_submit_customize( $tag ) {

		$tag   = new WPCF7_FormTag( $tag );
		$class = wpcf7_form_controls_class( $tag->type );
		$class = ( empty( $tag_class ) ) ? cs_get_button_class( array( 'size' => 'sm' ) ) . ' ' . $class : $class;
		$atts  = array();

		$atts['class']    = $tag->get_class_option( $class );
		$atts['id']       = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

		$value = isset( $tag->values[0] ) ? $tag->values[0] : '';

		if ( empty( $value ) ) {
			$value = __( 'Send', 'articlemag' );
		}

		$atts['type']  = 'submit';
		$atts['value'] = $value;

		$atts = wpcf7_format_atts( $atts );

		$html = sprintf( '<input %1$s />', $atts );

		return $html;
	}

	wpcf7_add_form_tag( 'submit', 'wpcf7_submit_customize' );
} else {

	function wpcf7_submit_customize( $tag ) {

		$tag       = new WPCF7_Shortcode( $tag );
		$class     = wpcf7_form_controls_class( $tag->type );
		$atts      = array();
		$value     = isset( $tag->values[0] ) ? $tag->values[0] : '';
		$tag_class = $tag->get_class_option();
		$class     = ( empty( $tag_class ) ) ? cs_get_button_class( array( 'size' => 'sm' ) ) . ' ' . $class : $class;

		$atts['type']     = 'submit';
		$atts['value']    = ( empty( $value ) ) ? __( 'Send', 'articlemag' ) : $value;
		$atts['class']    = $tag->get_class_option( $class );
		$atts['id']       = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

		$atts = wpcf7_format_atts( $atts );
		$html = sprintf( '<input %1$s />', $atts );

		return $html;
	}

	if ( ! function_exists( 'wpcf7_init_customize' ) ) {

		/**
		 * Wpcf7 init customize
		 */
		function wpcf7_init_customize() {
			wpcf7_add_shortcode( 'submit', 'wpcf7_submit_customize' );
		}

		add_action( 'wpcf7_init', 'wpcf7_init_customize' );
	}
}

/**
 *
 * Google Analytics by Tracking Code
 *
 * @since 1.8.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_wp_head' ) ) {

	/**
	 * Cs wp head
	 */
	function cs_wp_head() {

		// if theme do not support title-tag, using old method.
		if ( ! function_exists( '_wp_render_title_tag' ) ) {

			echo '<title>';

			if ( defined( 'WPSEO_VERSION' ) || defined( 'AIOSEOP_VERSION' ) ) {
				wp_title();
			} else {
				wp_title( '|', true, 'right' );
				bloginfo( 'name' );
			}

			echo '</title>';
		}

		$typekit_id = cs_get_option( 'typekit_id' );

		if ( ! empty( $typekit_id ) ) {
			echo '<script src="https://use.typekit.net/' . $typekit_id . '.js"></script>';
			echo '<script>try{Typekit.load({ async: true });}catch(e){}</script>';
		}

		cs_google_analytics();

		echo cs_get_option( 'ga_script' );
	}

	add_action( 'wp_head', 'cs_wp_head' );
}

/**
 *
 * Comments for Pages
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_page_comment_form' ) ) {

	function cs_page_comment_form( $section ) {

		if ( cs_get_option( 'page_comment' ) && ( comments_open() || '0' != get_comments_number() ) ) {

			if ( $section ) {
				echo '<div id="cs-page-comments">';
				echo '<div class="container"><div class="row"><div class="col-md-12">';
			}

			comments_template( '', true );

			if ( $section ) {
				echo '</div></div></div>';
				echo '</div>';
			}
		}
	}

	add_action( 'cs_page_end', 'cs_page_comment_form' );
}

/**
 *
 * Flush Rewrites for Custom Post Types
 *
 * @since 1.6.0
 * @version 1.0.0
 */
if ( ! function_exists( 'articlemag_flush_rewrites' ) ) {

	/**
	 * Articlemag flush rewrites
	 */
	function articlemag_flush_rewrites() {

		if ( get_option( 'articlemag_rewrite_flush' ) === false ) {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
			update_option( 'articlemag_rewrite_flush', true );
		}
	}

	add_action( 'wp_loaded', 'articlemag_flush_rewrites' );
}

/**
 * OnePage site Link Attribute
 *
 * @since   1.9.3
 * @version 1.0.0
 */
if ( ! function_exists( 'articlemag_nav_menu_link_attributes' ) ) {

	function articlemag_nav_menu_link_attributes( $atts ) {
		global $post;
		$one_page_template = false;
		if ( $post ) {
			$template = get_post_meta( $post->ID, '_wp_page_template', true );
			if ( false !== $template && strpos( $template, 'page-one-page.php' ) !== false ) {
				$one_page_template = true;
			}
		}

		if ( false === $one_page_template && ! is_front_page() && substr( $atts['href'], 0, 1 ) == '#' && strlen( $atts['href'] ) > 1 ) {
			$atts['href'] = home_url( '/' ) . $atts['href'];
		}

		return $atts;
	}


	add_filter( 'nav_menu_link_attributes', 'articlemag_nav_menu_link_attributes' );

}

/**
 *
 * Flush Rewrites for Portfolio Slug
 *
 * @since 2.1.0
 * @version 1.0.0
 */
if ( ! function_exists( 'articlemag_flush_cs_framework_save' ) ) {

	function articlemag_flush_cs_framework_save( $request ) {
		delete_option( 'articlemag_rewrite_flush' );
		return $request;
	}

	add_action( 'cs_framework_save', 'articlemag_flush_cs_framework_save' );
}

/**
 *
 * Switch Theme Flush Rewrite
 *
 * @since 2.1.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_switch_theme' ) ) {

	/**
	 * Cs switch theme
	 */
	function cs_switch_theme() {
		delete_option( 'articlemag_rewrite_flush' );
	}

	add_action( 'switch_theme', 'cs_switch_theme', 10, 2 );
}

/**
 *
 * Maintenance Mode
 *
 * @since 2.3.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_maintenance_mode' ) ) {

	function cs_maintenance_mode() {

		$maintenance = cs_get_option( 'maintenance' );

		if ( ! empty( $maintenance ) && ! is_user_logged_in() ) {
			get_template_part( 'templates/page', 'maintenance' );
			exit;
		}
	}

	add_action( 'wp', 'cs_maintenance_mode', 1 );
}


/**
 *
 * Custom New Font Family
 *
 * @since 2.3.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_new_font_family' ) ) {

	function cs_new_font_family( $db_value ) {

		$fonts = cs_get_option( 'font_family' );

		if ( ! empty( $fonts ) ) {

			echo '<optgroup label="Your Custom Fonts">';
			foreach ( $fonts as $key => $value ) {
				echo '<option value="' . $value['name'] . '" data-type="customfonts"' . selected( $value['name'], $db_value, true ) . '>' . $value['name'] . '</option>';
			}
			echo '</optgroup>';
		}
	}

	add_action( 'cs_font_family', 'cs_new_font_family' );
}


/**
 *
 * Disable Revolution Slider Updates
 *
 * @since 3.4.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_set_revslider_as_theme' ) && function_exists( 'set_revslider_as_theme' ) ) {

	/**
	 * Cs set revslider as theme
	 */
	function cs_set_revslider_as_theme() {

		set_revslider_as_theme();
	}

	add_action( 'init', 'cs_set_revslider_as_theme' );
}

/**
 *
 * WooCommerce Cart Side Widget
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_cart_widget_side' ) ) {

	/**
	 * Cs cart widget side
	 */
	function cs_cart_widget_side() {
		?>
		<div class="cs-cart-widget-side">
			<div class="widget-heading">
				<h3 class="widget-title">Shopping cart</h3>
				<a href="#" class="widget-close">close</a>
			</div>
			<div class="cs-module-woominicart">
				<div class="woocommerce">
					<div class="cs-mini-cart">
						<?php woocommerce_mini_cart(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

// add_shortcode( 'articlemag-featured-posts', 'display_articlemag_featured_posts' );

/**
 * Display articlemag featured posts
 */
function display_articlemag_featured_posts() {
	global $wp_query, $paged, $post;

	echo '<div class="featured_blog_posts_widget article-featured-slider">';
	$tmp_query = $wp_query;
	ob_start();
	?>
	<div class="article-slider">
		<?php
		$atts               = null;
		$is_featured_exists = false;
		$args               = array(
			'posts_per_page' => -1,
			'post_type'      => 'post',
			'meta_key'       => 'meta-checkbox',
			'meta_value'     => 1,
		);
		$all_posts          = new WP_Query( $args );

		if ( ! $all_posts->have_posts() ) {
			$args               = array(
				'posts_per_page' => -1,
				'post_type'      => 'post',
			);
			$all_posts          = new WP_Query( $args );
			$is_featured_exists = false;
		} else {
			$is_featured_exists = true;
		}

		if ( $all_posts->have_posts() ) :
			while ( $all_posts->have_posts() ) :
				$all_posts->the_post();
				?>
				<div> 
					<article class="article-featured-slider-sec">
						<?php
						if ( has_post_thumbnail() ) {
							?>
							<div class="article-featured-img">
								<div class="featured-article" style="background: url('<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>')"></div>
							</div> 
							<?php
						} else {
							?>
							<div class="article-featured-img">
								<div class="featured-article" style="background: url('<?php echo THEME_URI . '/images/no-pictures/no-standard-picture.png'; ?>)"></div>
							</div> 
						<?php } ?>

						<div class="article-featured-info">
							<div class="article-avatar"> 
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" class="tippy-js" data-tippy-content="<?php echo esc_html( 'Posted by', 'articlemag' ) . ' ' . get_the_author(); ?>">
									<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>  
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
			endwhile;
		else :
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

/**
 * Category thumbnail fields.
 */
function add_category_thumbnail_field() {
	?>
	<div class="form-field term-thumbnail-wrap">
		<label><?php esc_html_e( 'Thumbnail', 'articlemag' ); ?></label>
		<div id="category_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/no-pictures/no-image-picture.png' ); ?>" width="60px" height="60px" /></div>
		<div style="line-height: 60px;">
			<input type="hidden" id="category_thumbnail_id" name="category_thumbnail_id" />
			<button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'articlemag' ); ?></button>
			<button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'articlemag' ); ?></button>
		</div>
		<script type="text/javascript">

			// Only show the "remove image" button when needed
			if (!jQuery('#category_thumbnail_id').val()) {
				jQuery('.remove_image_button').hide();
			}

			// Uploading files
			var file_frame;

			jQuery(document).on('click', '.upload_image_button', function (event) {

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if (file_frame) {
					file_frame.open();
					return;
				}

				// Create the media frame.
				file_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php esc_html_e( 'Choose an image', 'articlemag' ); ?>',
					button: {
						text: '<?php esc_html_e( 'Use image', 'articlemag' ); ?>'
					},
					multiple: false
				});

				// When an image is selected, run a callback.
				file_frame.on('select', function () {
					var attachment = file_frame.state().get('selection').first().toJSON();
					var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

					jQuery('#category_thumbnail_id').val(attachment.id);
					jQuery('#category_thumbnail').find('img').attr('src', attachment_thumbnail.url);
					jQuery('.remove_image_button').show();
				});

				// Finally, open the modal.
				file_frame.open();
			});

			jQuery(document).on('click', '.remove_image_button', function () {
				jQuery('#category_thumbnail').find('img').attr('src', '<?php echo esc_js( get_template_directory_uri() . '/images/no-pictures/no-image-picture.png' ); ?>');
				jQuery('#category_thumbnail_id').val('');
				jQuery('.remove_image_button').hide();
				return false;
			});

			jQuery(document).ajaxComplete(function (event, request, options) {
				if (request && 4 === request.readyState && 200 === request.status
						&& options.data && 0 <= options.data.indexOf('action=add-tag')) {

					var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
					if (!res || res.errors) {
						return;
					}
					// Clear Thumbnail fields on submit
					jQuery('#category_thumbnail').find('img').attr('src', '<?php echo esc_js( get_template_directory_uri() . '/images/no-pictures/no-image-picture.png' ); ?>');
					jQuery('#category_thumbnail_id').val('');
					jQuery('.remove_image_button').hide();
					// Clear Display type field on submit
					jQuery('#display_type').val('');
					return;
				}
			});

		</script>
		<div class="clear"></div>
	</div>
	<?php
}

// Category Image Field.
add_action( 'category_add_form_fields', 'add_category_thumbnail_field' );

/**
 * Edit category thumbnail field.
 *
 * @param mixed $term Term (category) being edited.
 */
function edit_category_thumbnail_fields( $term ) {
	$thumbnail_id = absint( get_term_meta( $term->term_id, 'category_thumbnail_id', true ) );

	if ( $thumbnail_id ) {
		$image = wp_get_attachment_thumb_url( $thumbnail_id );
	} else {
		$image = get_template_directory_uri() . '/images/no-pictures/no-image-picture.png';
	}
	?>
	<tr class="form-field term-thumbnail-wrap">
		<th scope="row" valign="top"><label><?php esc_html_e( 'Thumbnail', 'articlemag' ); ?></label></th>
		<td>
			<div id="category_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="category_thumbnail_id" name="category_thumbnail_id" value="<?php echo esc_attr( $thumbnail_id ); ?>" />
				<button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'articlemag' ); ?></button>
				<button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'articlemag' ); ?></button>
			</div>
			<p class="description">Upload Image Min. Size 1280X600</p>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ('0' === jQuery('#category_thumbnail_id').val()) {
					jQuery('.remove_image_button').hide();
				}

				// Uploading files
				var file_frame;

				jQuery(document).on('click', '.upload_image_button', function (event) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if (file_frame) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php esc_html_e( 'Choose an image', 'articlemag' ); ?>',
						button: {
							text: '<?php esc_html_e( 'Use image', 'articlemag' ); ?>'
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on('select', function () {
						var attachment = file_frame.state().get('selection').first().toJSON();
						var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

						jQuery('#category_thumbnail_id').val(attachment.id);
						jQuery('#category_thumbnail').find('img').attr('src', attachment_thumbnail.url);
						jQuery('.remove_image_button').show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery(document).on('click', '.remove_image_button', function () {
					jQuery('#category_thumbnail').find('img').attr('src', '<?php echo esc_js( get_template_directory_uri() . '/images/no-pictures/no-image-picture.png' ); ?>');
					jQuery('#category_thumbnail_id').val('');
					jQuery('.remove_image_button').hide();
					return false;
				});

			</script>
			<div class="clear"></div>
		</td>
	</tr>
	<?php
}

add_action( 'category_edit_form_fields', 'edit_category_thumbnail_fields', 10 );

/**
 * Save category fields
 *
 * @param mixed  $term_id Term ID being saved.
 * @param mixed  $tt_id Term taxonomy ID.
 * @param string $taxonomy Taxonomy slug.
 */
function save_category_thumbnail_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
	if ( isset( $_POST['category_thumbnail_id'] ) && 'category' === $taxonomy ) {
		update_term_meta( $term_id, 'category_thumbnail_id', absint( $_POST['category_thumbnail_id'] ) );
	}
}

add_action( 'edit_term', 'save_category_thumbnail_fields', 10, 3 );
add_action( 'created_term', 'save_category_thumbnail_fields', 10, 3 );

/**
 * Thumbnail column added to category admin.
 *
 * @param mixed $columns Columns array.
 * @return array
 */
function category_thumbnail_columns( $columns ) {
	$new_columns = array();

	if ( isset( $columns['cb'] ) ) {
		$new_columns['cb'] = $columns['cb'];
		unset( $columns['cb'] );
	}

	$new_columns['thumb'] = __( 'Image', 'articlemag' );

	$columns           = array_merge( $new_columns, $columns );
	$columns['handle'] = '';

	return $columns;
}

add_filter( 'manage_edit-category_columns', 'category_thumbnail_columns' );

/**
 * Thumbnail column value added to category admin.
 *
 * @param string $columns Column HTML output.
 * @param string $column Column name.
 * @param int    $id Product ID.
 *
 * @return string
 */
function category_thumbnail_column( $columns, $column, $id ) {
	if ( 'thumb' === $column ) {

		$thumbnail_id = get_term_meta( $id, 'category_thumbnail_id', true );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = get_template_directory_uri() . '/images/no-pictures/no-image-picture.png';
		}

		// Prevent esc_url from breaking spaces in urls for image embeds. Ref: https://core.trac.wordpress.org/ticket/23605 .
		$image    = str_replace( ' ', '%20', $image );
		$columns .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Thumbnail', 'articlemag' ) . '" class="wp-post-image" height="48" width="48" />';
	}
	if ( 'handle' === $column ) {
		$columns .= '<input type="hidden" name="term_id" value="' . esc_attr( $id ) . '" />';
	}
	return $columns;
}

add_filter( 'manage_category_custom_column', 'category_thumbnail_column', 10, 3 );

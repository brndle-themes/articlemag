<?php
/**
 *
 * Top Bar
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_top_bar' ) ) {

	function cs_top_bar() {

		$options = cs_get_post_meta( '_custom_page_options' );

		$out = '';

		if ( ( cs_get_option( 'top_bar' ) && empty( $options['disable_top_bar'] ) && ( cs_get_option( 'top_left' ) || cs_get_option( 'top_right' ) ) && empty( $options['header_transparent'] ) ) || ( ! empty( $options['header_transparent'] ) && ! empty( $options['top_bar_transparent'] ) ) ) {
			$out .= '<div id="top-bar">';
			$out .= '<div class="container">';
			$out .= cs_top_bar_modules( 'left' );
			$out .= cs_top_bar_modules( 'right' );
			$out .= '</div>';
			$out .= '</div><!-- /top-bar -->';
		}

		return $out;
	}
}

/**
 *
 * Top Bar Modules
 *
 * @since 1.0.0
 * @version 1.6.0
 */
if ( ! function_exists( 'cs_top_bar_modules' ) ) {

	function cs_top_bar_modules( $area ) {

		$output    = '';
		$top_left  = cs_get_option( 'top_left' );
		$top_right = cs_get_option( 'top_right' );
		$modules   = ( $area == 'right' ) ? $top_right : $top_left;
		$column    = ( empty( $top_left ) || empty( $top_right ) ) ? 12 : 6;

		if ( ! empty( $modules ) ) {

			$output .= '<div class="cs-top-' . $area . '">';

			foreach ( $modules as $key => $module ) {

				$class = ( ! empty( $module['class'] ) ) ? ' ' . $module['class'] : '';

				$out  = '';
				$out .= '<div class="cs-top-module cs-module-' . $module['module'] . $class . '">';

				switch ( $module['module'] ) {

					// module text
					// ----------------------------------------------
					case 'text':
						$out .= ( ! empty( $module['icon'] ) ) ? '<i class="' . cs_icon_class( $module['icon'] ) . '"></i>' : '';
						$out .= cs_multilang_value( $module['text'] );
						break;

					// module text
					// ----------------------------------------------
					case 'textarea':
						$out .= ( ! empty( $module['icon'] ) ) ? '<i class="' . cs_icon_class( $module['icon'] ) . '"></i>' : '';
						$out .= do_shortcode( cs_multilang_value( $module['content'] ) );
						break;

					// module link
					// ----------------------------------------------
					case 'link':
						$target = ( ! empty( $module['target'] ) ) ? ' target="' . $module['target'] . '"' : '';
						$out   .= '<a href="' . cs_multilang_value( $module['link'] ) . '"' . $target . '>';
						$out   .= ( ! empty( $module['icon'] ) ) ? '<i class="' . cs_icon_class( $module['icon'] ) . '"></i>' : '';
						$out   .= cs_multilang_value( $module['text'] );
						$out   .= '</a>';
						break;

					// module menu
					// ----------------------------------------------
					case 'menu':
						$out .= '<div class="cs-top-modal-hover cs-lang-top-modal">';

						$out .= '<div class="cs-open-modal-pointer">';
						$out .= ( ! empty( $module['icon'] ) ) ? '<i class="' . cs_icon_class( $module['icon'] ) . '"></i>' : '';
						$out .= cs_multilang_value( $module['text'] );
						$out .= '<i class="cs-down fa fa-angle-down"></i>';
						$out .= '</div>';

						if ( ! empty( $module['menu_term_id'] ) ) {

							$items = cs_get_nav_menu_array( cs_multilang_value( $module['menu_term_id'] ) );

							$out .= '<div class="cs-modal-content-hover">';
							$out .= '<ul>';

							foreach ( $items as $item ) {

								$target = ( ! empty( $item->target ) ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
								$icon   = ( ! empty( $item->icon ) ) ? '<i class="' . cs_icon_class( $item->icon ) . '"></i>' : '';

								$out .= '<li>';
								$out .= sprintf( '<a href="%s"%s>%s%s</a>', esc_url( $item->url ), $target, $icon, $item->title );
								$out .= '</li>';
							}

							$out .= '</ul>';
							$out .= '</div>';
						}

						$out .= '</div>';

						break;

					// module social
					// ----------------------------------------------
					case 'social':
						$target = ( ! empty( $module['target'] ) ) ? ' target="' . $module['target'] . '"' : '';
						$out   .= '<a href="' . cs_multilang_value( $module['link'] ) . '"' . $target . ' class="' . cs_icon_class( $module['icon'] ) . '"></a>';
						break;

					// module modal
					// ----------------------------------------------
					case 'modal':
						$out .= '<div class="cs-top-modal">';
						$out .= '<a href="#" class="cs-open-modal">';
						$out .= ( ! empty( $module['icon'] ) ) ? '<i class="' . cs_icon_class( $module['icon'] ) . '"></i>' : '';
						$out .= cs_multilang_value( $module['text'] );
						$out .= '<i class="cs-down fa fa-angle-down"></i></a>';
						$out .= '<div class="cs-modal-content">' . do_shortcode( cs_multilang_value( $module['content'] ) ) . '</div>';
						$out .= '</div>';
						break;

					// module search
					// ----------------------------------------------
					case 'search':
						$out .= '<div class="cs-top-modal">';
						$out .= '<a href="#" class="cs-open-modal"><i class="cs-in fa fa-search"></i>' . __( 'Search', 'articlemag' ) . '</a>';
						$out .= '<div class="cs-modal-content">' . get_search_form( false ) . '</div>';
						$out .= '</div>';
						break;

					// module wp login
					// ----------------------------------------------
					case 'wplogin':
						if ( is_user_logged_in() ) {
							$out .= '<a href="' . wp_logout_url() . '"><i class="cs-in fa fa-power-off"></i>' . __( 'Log Out', 'articlemag' ) . '</a>';
						} else {
							$login_form = wp_login_form(
								array(
									'echo'     => false,
									'redirect' => admin_url(),
								)
							);
							$login_form = str_replace( 'button-primary', cs_get_button_class( array( 'size' => 'xxs' ) ), $login_form );
							$out       .= '<div class="cs-top-modal">';
							$out       .= '<a href="#" class="cs-open-modal"><i class="cs-in fa fa-user"></i>' . __( 'Log In', 'articlemag' ) . '</a>';
							$out       .= '<div class="cs-modal-content cs-login-form">';
							$out       .= $login_form;
							$out       .= '</div>';
							$out       .= '</div>';
						}

						break;

					// module woocommerce login
					// ----------------------------------------------
					case 'woologin':
						if ( is_woocommerce_activated() ) {

							if ( is_user_logged_in() ) {
								$out .= '<a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '"><i class="cs-in fa fa-user"></i>' . __( 'My Account Page', 'articlemag' ) . '</a>';
								$out .= ' / ';
								$out .= '<a href="' . wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '"><i class="cs-in fa fa-power-off"></i>' . __( 'Logout', 'articlemag' ) . '</a>';
							} else {
								$login_form = wp_login_form( array( 'echo' => false ) );
								$login_form = str_replace( 'button-primary', cs_get_button_class( array( 'size' => 'xxs' ) ), $login_form );
								$out       .= '<div class="cs-top-modal">';
								$out       .= '<a href="#" class="cs-open-modal"><i class="cs-in fa fa-user"></i>' . __( 'Login', 'articlemag' ) . '</a>';
								$out       .= '<div class="cs-modal-content">';
								$out       .= $login_form;
								$out       .= '<p class="cs-modal-lost-password">';
								$out       .= ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) ? '<a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '">' . __( 'Register', 'articlemag' ) . '</a> - ' : '';
								$out       .= '<a href="' . wc_lostpassword_url() . '">' . __( 'Lost your password?', 'articlemag' ) . '</a>';
								$out       .= '</p>';
								$out       .= '</div>';
								$out       .= '</div>';
							}
						}

						break;

					// module woocommerce cart count
					// ----------------------------------------------
					case 'woocount':
						if ( is_woocommerce_activated() ) {
							$out .= '<a href="' . wc_get_cart_url() . '"><i class="fa fa-shopping-cart"></i><span class="cs-cart-count">' . WC()->cart->cart_contents_count . '</span></a>';
						}

						break;

					// module woocommerce cart price
					// ----------------------------------------------
					case 'wooprice':
						if ( is_woocommerce_activated() ) {
							$out .= '<a href="' . wc_get_cart_url() . '"><i class="cs-in fa fa-shopping-cart"></i><span class="cs-cart-contents">' . sprintf( _n( '%d item', '%d items', WC()->cart->cart_contents_count, 'articlemag' ), WC()->cart->cart_contents_count ) . WC()->cart->get_cart_total() . '</span></a>';
						}

						break;

					// module woocommerce mini cart
					// ----------------------------------------------
					case 'woominicart':
						if ( is_woocommerce_activated() ) {

							// Get mini cart
							ob_start();
							woocommerce_mini_cart();
							$mini_cart = ob_get_clean();

							$out .= '<div class="cs-top-modal">';
							$out .= '<a href="#" class="cs-open-modal"><i class="cs-in fa fa-shopping-cart"></i>' . __( 'Cart', 'articlemag' ) . '<span class="cs-cart-count">' . WC()->cart->cart_contents_count . '</span></a>';
							$out .= '<div class="cs-modal-content woocommerce"><div class="cs-mini-cart">' . $mini_cart . '</div></div>';
							$out .= '</div>';
						}

						break;

					// module module wpml
					// ----------------------------------------------
					case 'wpml':
						if ( is_wpml_activated() ) {

							global $sitepress;

							$sitepress_settings = $sitepress->get_settings();
							$icl_get_languages  = icl_get_languages();

							if ( ! empty( $icl_get_languages ) ) {

								$out .= '<div class="cs-top-modal cs-lang-top-modal">';

								// current language
								$out .= '<a href="#" class="cs-open-modal">';
								foreach ( $icl_get_languages as $id => $current_lang ) {
									if ( $current_lang['active'] ) {
										$out .= ( empty( $module['wpml_flags'] ) ) ? '<img src="' . $current_lang['country_flag_url'] . '" alt="' . $current_lang['language_code'] . '" />' : '<i class="cs-in fa fa-globe"></i>';
										$out .= $current_lang['native_name'];
										$out .= ( ! empty( $module['wpml_current_name'] ) ) ? ' (' . $current_lang['translated_name'] . ')' : '';
										$out .= '<i class="cs-down fa fa-angle-down"></i>';
										break;
									}
								}
								$out .= '</a>';

								// list languages
								$out .= '<div class="cs-modal-content">';
								$out .= '<ul>';
								foreach ( $icl_get_languages as $id => $language ) {
									if ( empty( $language['active'] ) ) {
										$out .= '<li>';
										$out .= '<a href="' . $language['url'] . '">';
										$out .= ( empty( $module['wpml_flags'] ) ) ? '<img src="' . $language['country_flag_url'] . '" alt="' . $language['language_code'] . '" />' : '';
										$out .= $language['native_name'];
										$out .= ( ! empty( $module['wpml_current_name'] ) ) ? ' (' . $language['translated_name'] . ')' : '';
										$out .= '</a>';
										$out .= '</li>';
									}
								}
								$out .= '</ul>';
								$out .= '</div>';
								$out .= '</div>';
							}
						} else {
							$out .= 'WPML is not activated';
						}

						break;

					// module module qtranslate
					// ----------------------------------------------
					case 'qtranslate':
						if ( is_qtranslate_activated() ) {

							global $q_config;
							$q_languages = qtrans_getSortedLanguages();

							if ( ! empty( $q_languages ) ) {

								$q_current = $q_config['language'];
								$q_image   = trailingslashit( WP_CONTENT_URL ) . $q_config['flag_location'];
								$url       = ( is_404() ) ? home_url( '/' ) : '';

								$out .= '<div class="cs-top-modal cs-lang-top-modal">';

								// current language
								$out .= '<a href="#" class="cs-open-modal">';
								$out .= '<img src="' . $q_image . $q_config['flag'][ $q_current ] . '" alt="' . $q_config['language_name'][ $q_current ] . '" />';
								$out .= $q_config['language_name'][ $q_current ];
								$out .= '<i class="cs-down fa fa-angle-down"></i>';
								$out .= '</a>';

								// list languages
								$out .= '<div class="cs-modal-content">';
								$out .= '<ul>';
								foreach ( $q_languages as $id => $language ) {
									if ( $language != $q_current ) {
										$out .= '<li>';
										$out .= '<a href="' . qtrans_convertURL( $url, $language ) . '">';
										$out .= '<img src="' . $q_image . $q_config['flag'][ $language ] . '" alt="' . $q_config['language_name'][ $language ] . '" />';
										$out .= $q_config['language_name'][ $language ];
										$out .= '</a>';
										$out .= '</li>';
									}
								}
								$out .= '</ul>';
								$out .= '</div>';
								$out .= '</div>';
							} else {
								$out .= 'qTranslate is not activated';
							}
						}

						break;

					// module module polylang
					// ----------------------------------------------
					case 'polylang':
						if ( is_polylang_activated() ) {

							global $polylang;

							$languages = $polylang->model->get_languages_list();
							$curlang   = $polylang->curlang;

							if ( ! empty( $languages ) ) {

								$out .= '<div class="cs-top-modal cs-lang-top-modal">';

								// current language
								$out .= '<a href="#" class="cs-open-modal">';
								$out .= $curlang->flag . $curlang->name;
								$out .= '<i class="cs-down fa fa-angle-down"></i>';
								$out .= '</a>';

								// list languages
								$out .= '<div class="cs-modal-content">';
								$out .= '<ul>';

								foreach ( $languages as $language ) {

									$url = $polylang->links->get_translation_url( $language );
									$url = ( empty( $url ) ) ? $polylang->links->get_home_url( $language ) : $url;

									if ( $language->slug !== $curlang->slug ) {
										$out .= '<li>';
										$out .= '<a href="' . $url . '">';
										$out .= $language->flag;
										$out .= $language->name;
										$out .= '</a>';
										$out .= '</li>';
									}
								}

								$out .= '</ul>';
								$out .= '</div>';
								$out .= '</div>';
							} else {
								$out .= 'Polylang is not activated';
							}
						}

						break;

					default:
						ob_start();
						do_action( 'cs_top_bar_module', $module['module'] );
						$out .= ob_get_clean();

						break;
				}

				$out .= '</div>';

				$output .= ( ! empty( $module['check'] ) && is_user_logged_in() ) ? '' : $out;
			}

			$output .= '</div>';
		}

		return $output;
	}
}

/**
 *
 * Breadcrumb
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_breadcrumb' ) ) {

	function cs_breadcrumb() {

		$out = '';
		if ( function_exists( 'bcn_display' ) ) {
			$out .= '<div class="cs-breadcrumb">';
			$out .= '<div class="cs-inner">';
			$out .= bcn_display( true );
			$out .= '</div>';
			$out .= '</div>';
		}

		return $out;
	}
}

/**
 *
 * Blog Post Meta
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_posted_on' ) ) {

	function cs_posted_on() {

		global $post;

		if ( is_sticky() && is_home() && ! is_paged() ) {
			echo '<span class="entry-featured">' . __( 'Sticky', 'articlemag' ) . '</span>';
		}

		$post_format = get_post_format();
		if ( $post_format ) {
			echo '<span class="entry-format-' . $post_format . '">';
			echo '<a href="' . esc_url( get_post_format_link( $post_format ) ) . '">' . get_post_format_string( $post_format ) . '</a>';
			echo '</span>';
		}

		printf(
			'<span class="entry-date"><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="entry-author-link"><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
			esc_url( get_permalink() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);

		if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && articlemag_categorized_blog() ) {
			echo '<span class="entry-cat-links">' . get_the_category_list( ', ' ) . '</span>';
		}

		if ( ! is_search() ) {

			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="entry-comments-link">';
				comments_popup_link( __( 'Leave a comment', 'articlemag' ), __( '1 Comment', 'articlemag' ), __( '% Comments', 'articlemag' ) );
				echo '</span>';
			}

			$live_id    = get_the_ID();
			$love_count = get_post_meta( $live_id, '_love_count', true );
			$love_count = ( ! empty( $love_count ) ) ? $love_count : 0;
			$is_loved   = ( isset( $_COOKIE[ 'articlemag_love_' . $live_id ] ) ) ? ' entry-loved' : '';

			echo '<span class="entry-love">';
			echo '<a href="#" class="entry-love-it' . $is_loved . '" data-post-id="' . $live_id . '"><span class="love-count">' . $love_count . '</span></a>';
			echo '</span>';
		}

		edit_post_link( __( 'Edit', 'articlemag' ), '<span class="entry-edit-link">', '</span>' );
	}
}

/**
 *
 * Post Navigation
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_post_nav' ) ) {

	function cs_post_nav() {

		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ( empty( $next ) && empty( $previous ) ) || cs_get_option( 'blog_single_navigation' ) == false ) {
			return;
		}
		?>
		<nav class="post-navigation" role="navigation">
			<div class="nav-previous"><?php previous_post_link( '%link', '<i class="fa fa-angle-left"></i> ' . __( 'Previous Post', 'articlemag' ) . '<br /><strong>%title</strong>' ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', __( 'Next Post', 'articlemag' ) . ' <i class="fa fa-angle-right"></i><br /><strong>%title</strong>' ); ?></div>
			<div class="clear"></div>
		</nav>
		<?php
	}
}

/**
 *
 * Post Thumbnail
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_post_thumbnail' ) ) {

	function cs_post_thumbnail( $link = '' ) {

		if ( post_password_required() ) {
			return;
		}

		global $cs_blog_image_size;

		$size = ( empty( $cs_blog_image_size ) ) ? cs_get_option( 'blog_single_image_size' ) : $cs_blog_image_size;
		$link = ( empty( $link ) ) ? get_permalink() : $link;

		if ( is_singular() ) {
			if ( cs_get_option( 'blog_single_image_show' ) ) {
				$post_meta = get_post_meta( get_the_ID(), '_custom_page_options', true );
				if ( has_post_thumbnail() ) {
					if ( empty( $post_meta['hide_featured_image'] ) ) {
						echo '<div class="entry-image">';
						the_post_thumbnail( $size );
						echo '</div><!-- entry-image -->';
					}
				}
			}
		} else {
			$img_src = get_template_directory_uri() . '/images/no-pictures/no-image-picture.png';
			echo '<div class="entry-image">';
			echo '<a href="' . $link . '" class="post-thumbnail">';
			if ( has_post_thumbnail() ) {
					the_post_thumbnail( $size );
			} else {
				echo '<img src="' . $img_src . '" id="contextual" class="contextual"  alt="' . esc_html__( 'No Image', 'articlemag') . '" />';
			}
			echo '<span class="entry-image-overlay"></span>';
			echo '</a>';
			echo '</div><!-- entry-image -->';
		}
	}
}

/**
 *
 * Page Featured Image
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_page_featured_image' ) ) {

	function cs_page_featured_image() {

		if ( post_password_required() || ! has_post_thumbnail() ) {
			return;
		}

		$post_meta = get_post_meta( get_the_ID(), '_custom_page_options', true );

		if ( ! empty( $post_meta['hide_featured_image'] ) ) {
			return;
		}

		$size = apply_filters( 'cs_page_featured_image_size', 'full' );

		echo '<div class="entry-image">';
		the_post_thumbnail( $size );
		echo '</div><!-- entry-image -->';
	}
}

/**
 *
 * Pagination
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_paging_nav' ) ) {

	function cs_paging_nav( $args = array() ) {

		if ( ! empty( $args['wp_query'] ) ) {
			$wp_query      = $args['wp_query'];
			$max_num_pages = $wp_query->max_num_pages;
		} elseif ( ! empty( $args['query'] ) ) {
			$max_num_query = new WP_Query( $args['query'] );
			$max_num_pages = $max_num_query->max_num_pages;
			wp_reset_query();
		} else {
			$max_num_pages = $GLOBALS['wp_query']->max_num_pages;
		}

		$template = cs_get_option( 'blog_layout' );
		$defaults = array(
			'nav'            => cs_get_option( 'blog_pagination' ),
			'template'       => cs_get_option( 'blog_layout' ),
			'posts_per_page' => get_option( 'posts_per_page' ),
			'size'           => cs_get_option( 'blog_image_size' ),
			'columns'        => cs_get_option( 'blog_column' ),
			'max_pages'      => $max_num_pages,
			'post_type'      => 'post',
			'isotope'        => ( $template == 'default' || $template == 'medium' || $template == 'small' ) ? '0' : '1',
		);

		$args = wp_parse_args( $args, $defaults );

		if ( $max_num_pages < 2 || $args['nav'] == 'hide' ) {
			return;
		}

		if ( $args['nav'] == 'load' ) {

			wp_enqueue_style( 'cs-royalslider' );
			wp_enqueue_script( 'cs-royalslider' );

			$uniqid  = uniqid();
			$output  = '<div class="ajax-pagination">';
			$output .= '<a href="#" class="ajax-load-more ' . cs_get_button_class( array( 'size' => 'xxs' ) ) . '" data-token="' . $uniqid . '">';
			$output .= __( 'Load More', 'articlemag' );
			$output .= '<span class="cs-loader"></span>';
			$output .= '</a>';
			$output .= '</div>';

			unset( $args['query'] );
			wp_localize_script( 'cs-jquery-register', 'cs_load_more_' . $uniqid, $args );

			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
		} else {

			if ( is_front_page() || is_home() ) {
				$paged = ( get_query_var( 'paged' ) ) ? intval( get_query_var( 'paged' ) ) : intval( get_query_var( 'page' ) );
			} else {
				$paged = intval( get_query_var( 'paged' ) );
			}

			$paged        = $paged ? $paged : 1;
			$pagenum_link = html_entity_decode( get_pagenum_link() );
			$query_args   = array();
			$url_parts    = explode( '?', $pagenum_link );

			if ( isset( $url_parts[1] ) ) {
				wp_parse_str( $url_parts[1], $query_args );
			}

			$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
			$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

			$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
			$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

			$links = paginate_links(
				array(
					'base'      => $pagenum_link,
					'format'    => $format,
					'total'     => $max_num_pages,
					'current'   => $paged,
					'mid_size'  => 1,
					'type'      => 'array',
					'add_args'  => array_map( 'urlencode', $query_args ),
					'prev_text' => __( 'Previous', 'articlemag' ),
					'next_text' => __( 'Next', 'articlemag' ),
				)
			);

			if ( $links ) {
				?>
				<div class="clear"></div>
				<nav class="pagination page-pagination">
					<div class="pagination-shadow">
						<?php
						foreach ( $links as $link ) {
							echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
						}
						?>
					</div>
				</nav>
				<?php
			}
		}
	}
}

/**
 *
 * Link Pages
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_link_pages' ) ) {

	function cs_link_pages( $args = '' ) {

		$defaults = array(
			'title'            => '<span class="pagination-title">' . __( 'Pages', 'articlemag' ) . '</span>',
			'before'           => '<div class="page-pagination">',
			'after'            => '</div>',
			'link_before'      => '',
			'link_after'       => '',
			'next_or_number'   => 'number',
			'separator'        => '',
			'nextpagelink'     => __( 'Next', 'articlemag' ),
			'previouspagelink' => __( 'Previous', 'articlemag' ),
			'pagelink'         => '%',
			'echo'             => 1,
		);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );

		ob_start();
		wp_link_pages();
		$pages = ob_get_clean();

		extract( $r, EXTR_SKIP );

		global $page, $numpages, $multipage, $more;

		$output = '';

		if ( $multipage ) {

			if ( 'number' == $next_or_number ) {
				$output .= $before;
				$output .= $title;
				for ( $i = 1; $i <= $numpages; $i++ ) {
					$link = $link_before . str_replace( '%', $i, $pagelink ) . $link_after;

					$output .= ( $i == $page ) ? '<span class="current">' : '</span>';

					if ( $i != $page ) {
						$link = _wp_link_page( $i ) . $link . '</a>';
					}

					$link    = apply_filters( 'wp_link_pages_link', $link, $i );
					$output .= $separator . $link;
				}
				$output .= $after;
			} elseif ( $more ) {
				$output .= $before;
				$i       = $page - 1;
				if ( $i ) {
					$link    = _wp_link_page( $i ) . $link_before . $previouspagelink . $link_after . '</a>';
					$link    = apply_filters( 'wp_link_pages_link', $link, $i );
					$output .= $separator . $link;
				}
				$i = $page + 1;
				if ( $i <= $numpages ) {
					$link    = _wp_link_page( $i ) . $link_before . $nextpagelink . $link_after . '</a>';
					$link    = apply_filters( 'wp_link_pages_link', $link, $i );
					$output .= $separator . $link;
				}
				$output .= $after;
			}
		}

		$output = apply_filters( 'wp_link_pages', $output, $args );

		if ( $echo ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
		}

		return $output;
	}
}

/**
 *
 * Page Sidebar
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_page_sidebar' ) ) {

	function cs_page_sidebar( $base = 'right', $layout = 'right' ) {
		if ( $base == $layout || $layout == 'both' ) {
			echo '<div class="col-md-3 cs-sidebar-clear">';
			echo '<div class="page-sidebar sidebar-' . $base . '">';
			get_sidebar( $base );
			echo '</div>';
			echo '</div>';
		}
	}
}

/**
 *
 * Site Logo
 *
 * @since 1.0.0
 * @version 1.5.0
 */
if ( ! function_exists( 'cs_site_logo' ) ) {

	function cs_site_logo( $class = '' ) {

		$home_url     = home_url( '/' );
		$home_url     = ( is_qtranslate_activated() ) ? qtrans_convertURL( $home_url ) : $home_url;
		$header_style = cs_get_option( 'header_style' );
		$logo         = cs_multilang_value( cs_get_option( 'logo' ) );
		$logo2x       = cs_multilang_value( cs_get_option( 'logo2x' ) );
		$logo_class   = ( empty( $logo2x ) ) ? ' cs-logo1x' : '';
		$has_logo     = ( $logo || $logo2x ) ? true : false;
		$is_sticky    = ( $header_style == 'default' || $header_style == 'fancy' ) ? 'cs-sticky-item' : '';
		$class        = ( $class ) ? ' class="' . $class . '"' : '';

		$post_meta   = cs_get_post_meta();
		$logo1x_data = '';
		$logo2x_data = '';
		$link_size   = '';

		if ( ( $header_style == 'default' || $header_style == 'fancy' ) && ! empty( $post_meta['header_transparent'] ) ) {

			$logo1x_alt = cs_multilang_value( cs_get_option( 'logo_alt' ) );
			$logo2x_alt = cs_multilang_value( cs_get_option( 'logo2x_alt' ) );

			if ( $logo1x_alt ) {
				$logo1x_data = ' data-alternative="' . $logo . '"';
				$logo        = $logo1x_alt;
			}

			if ( $logo2x_alt ) {
				$logo2x_data = ' data-alternative="' . $logo2x . '"';
				$logo2x      = $logo2x_alt;
			}
		}

		if ( $logo2x ) {
			$logo_url  = str_replace( 'https://', 'http://', $logo );
			$logo_size = @getimagesize( $logo_url );
			$link_size = ( ! empty( $logo_size ) ) ? ' style="max-width:' . $logo_size[0] . 'px;"' : '';
		}

		$output  = '<div id="site-logo"' . $class . '>';
		$output .= ( ! $has_logo ) ? '<h1 class="site-name ' . $is_sticky . '">' : '';
		$output .= '<a href="' . $home_url . '" class="' . $is_sticky . '"' . $link_size . '>';
		$output .= ( $logo ) ? '<img class="cs-logo' . $logo_class . '" src="' . $logo . '" alt="' . get_bloginfo( 'name' ) . '"' . $logo1x_data . '/>' : '';
		$output .= ( $logo2x ) ? '<img class="cs-logo2x" src="' . $logo2x . '" alt="' . get_bloginfo( 'name' ) . '"' . $logo2x_data . '/>' : '';

		$output .= ( ! $has_logo ) ? cs_multilang_value( cs_get_option( 'logo_text' ) ) : '';
		$output .= '</a>';
		$output .= ( ! $has_logo ) ? '</h1>' : '';
		$output .= '</div>';

		return $output;
	}
}


/**
 *
 * Site Menu
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_site_menu' ) ) {

	function cs_site_menu() {

		$output = '<nav id="site-nav" role="navigation">';
		ob_start();
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array( 'theme_location' => 'primary' ) );
		} else {
			echo '<a href="' . admin_url( 'nav-menus.php' ) . '" class="cs-sticky-item">' . __( 'You can edit your menu content on the Menus screen in the Appearance section.', 'articlemag' ) . '</a>';
		}
		$output .= ob_get_clean();
		$output .= '</nav>';

		return $output;
	}
}

/**
 *
 * Site Mobile Menu
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_site_mobile_menu' ) ) {

	function cs_site_mobile_menu() {

		ob_start();
		if ( has_nav_menu( 'mobile' ) ) {
			wp_nav_menu( array( 'theme_location' => 'mobile' ) );
		} else {

			$header_style = cs_get_option( 'header_style' );

			if ( $header_style == 'fancy' ) {
				echo '<div class="cs-fancy-mobile-menu">';
			}

			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'mobile'         => true,
				)
			);

			if ( $header_style == 'fancy' ) {
				wp_nav_menu(
					array(
						'theme_location' => 'right',
						'mobile'         => true,
					)
				);
				echo '</div>';
			}
		}
		$output = ob_get_clean();

		return $output;
	}
}

/**
 *
 * Mobile Icon
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_mobile_icon' ) ) {

	function cs_mobile_icon() {

		$output  = '<div id="cs-mobile-icon">';
		$output .= ( is_front_page() || is_page() || is_single() ) ? '<strong class="hidden-xs hidden-sm">' . get_the_title() . '</strong>' : '';
		$output .= '<span><i class="cs-one"></i><i class="cs-two"></i><i class="cs-three"></i></span>';
		$output .= '</div>';

		if ( cs_get_option( 'dark_mode' ) ) {
			$output .= '<div class="cs-toggle-track cs-mobile-toggle-track">';
			$output .= '<div class="cs-link cs-sticky-item"><i class="fa fa-moon-o" aria-hidden="true"></i><i class="fa fa-sun-o" aria-hidden="true"></i></div>';
			$output .= '</div>';
		}

		return $output;
	}
}

/**
 *
 * Site Mobile Multilanguage
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_site_mobile_languages' ) ) {

	function cs_site_mobile_languages() {

		$output = '';

		if ( is_wpml_activated() ) {

			global $sitepress;
			$sitepress_settings = $sitepress->get_settings();
			$icl_get_languages  = icl_get_languages();

			if ( ! empty( $icl_get_languages ) ) {
				$output .= '<div id="mobile-languages">';

				foreach ( $icl_get_languages as $id => $language ) {

					$current = ( $language['active'] ) ? ' class="cs-current"' : '';
					$output .= '<a href="' . $language['url'] . '"' . $current . '>';
					$output .= '<img src="' . $language['country_flag_url'] . '" alt="' . $language['language_code'] . '" />';
					$output .= $language['native_name'];
					$output .= '</a>';
				}

				$output .= '</div>';
				return $output;
			}
		} elseif ( is_polylang_activated() ) {

			global $polylang;

			$languages = $polylang->model->get_languages_list();
			$curlang   = $polylang->curlang;

			if ( ! empty( $languages ) ) {

				$output .= '<div id="mobile-languages">';

				foreach ( $languages as $language ) {

					$url = $polylang->links->get_translation_url( $language );
					$url = ( empty( $url ) ) ? $polylang->links->get_home_url( $language ) : $url;

					$current = ( $language->slug === $curlang->slug ) ? ' class="cs-current"' : '';

					$output .= '<a href="' . $url . '"' . $current . '>';
					$output .= $language->flag;
					$output .= $language->name;
					$output .= '</a>';
				}

				$output .= '</div>';
				return $output;
			}
		} elseif ( is_qtranslate_activated() ) {

			global $q_config;
			$q_languages = qtrans_getSortedLanguages();
			$q_current   = $q_config['language'];
			$q_image     = trailingslashit( WP_CONTENT_URL ) . $q_config['flag_location'];
			$url         = ( is_404() ) ? home_url( '/' ) : '';

			if ( ! empty( $q_languages ) ) {

				$output .= '<div id="mobile-languages">';

				foreach ( $q_languages as $id => $language ) {

					$current = ( $language == $q_current ) ? ' class="cs-current"' : '';
					$output .= '<a href="' . qtrans_convertURL( $url, $language ) . '"' . $current . '>';
					$output .= '<img src="' . $q_image . $q_config['flag'][ $language ] . '" alt="' . $q_config['language_name'][ $language ] . '" />';
					$output .= $q_config['language_name'][ $language ];
					$output .= '</a>';
				}

				$output .= '</div>';
				return $output;
			}
		}

		do_action( 'cs_site_languages' );

		return null;
	}
}

/**
 *
 * Global Button Class
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_button_class' ) ) {

	function cs_get_button_class( $args = array() ) {

		$defaults = array(
			'type'  => 'flat',
			'shape' => 'rounded',
			'size'  => 'xs',
			'color' => 'flat-accent',
		);

		$classes = array();
		$args    = wp_parse_args( $args, $defaults );

		foreach ( $args as $key => $value ) {
			$classes[] = 'cs-btn-' . $value;
		}

		return 'cs-btn ' . join( ' ', $classes );
	}
}

/**
 *
 * Comment Form
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_comment_form' ) ) {

	function cs_comment_form() {
		ob_start();
		comment_form();
		$comment_form = ob_get_clean();
		$comment_form = str_replace( array( 'id="submit"', 'class="comment-form"' ), array( 'id="submit" class="' . cs_get_button_class() . '"', 'class="comment-form cs-comment-form"' ), $comment_form );
		return $comment_form;
	}
}

/**
 *
 * Footer Area
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_footer_area' ) ) {

	function cs_footer_area() {

		$output         = '';
		$post_options   = cs_get_post_meta();
		$disable_footer = cs_get_option( 'disable_footer' );

		if ( ! empty( $post_options['disable_footer'] ) ) {
			return;
		}

		if ( empty( $disable_footer ) ) {

			$widgets = cs_get_option( 'footer_widgets' );
			$before  = cs_get_option( 'footer_before' );
			$after   = cs_get_option( 'footer_after' );

			ob_start();
			dynamic_sidebar( 'footer-block-before' );
			$footer_block_before = ob_get_clean();

			if ( ! empty( $footer_block_before ) ) {
				$output .= '<div id="cs-footer-block-before">';
				$output .= '<div class="container">';
				$output .= '<div class="row">';
				$output .= '<div class="col-md-12">';
				$output .= $footer_block_before;
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
			}

			if ( $widgets || $before || $after ) {

				$output .= '<footer id="colophon" class="site-footer" role="contentinfo">';
				$output .= '<div class="container">';
				$output .= '<div class="row">';

				if ( $before ) {
					ob_start();
					dynamic_sidebar( 'footer-before' );
					$before  = ob_get_clean();
					$output .= '<div class="col-md-12">' . $before . '</div>';
				}

				if ( $widgets ) {

					switch ( $widgets ) {
						case 1:
							$widget = array(
								'piece' => 1,
								'class' => 'col-md-12',
							);
							break;
						case 2:
							$widget = array(
								'piece' => 2,
								'class' => 'col-md-6',
							);
							break;
						case 3:
							$widget = array(
								'piece' => 3,
								'class' => 'col-md-4',
							);
							break;
						case 4:
							$widget = array(
								'piece' => 4,
								'class' => 'col-md-3',
							);
							break;
						case 5:
							$widget = array(
								'piece' => 6,
								'class' => 'col-md-2',
							);
							break;
						case 6:
							$widget = array(
								'piece'  => 3,
								'class'  => 'col-md-3',
								'layout' => 'col-md-6',
								'queue'  => 1,
							);
							break;
						case 7:
							$widget = array(
								'piece'  => 3,
								'class'  => 'col-md-3',
								'layout' => 'col-md-6',
								'queue'  => 2,
							);
							break;
						case 8:
							$widget = array(
								'piece'  => 3,
								'class'  => 'col-md-3',
								'layout' => 'col-md-6',
								'queue'  => 3,
							);
							break;
						case 9:
							$widget = array(
								'piece'  => 4,
								'class'  => 'col-md-2',
								'layout' => 'col-md-6',
								'queue'  => 1,
							);
							break;
						case 10:
							$widget = array(
								'piece'  => 4,
								'class'  => 'col-md-2',
								'layout' => 'col-md-6',
								'queue'  => 4,
							);
							break;
					}

					for ( $i = 1; $i < $widget['piece'] + 1; $i++ ) {

						$widget_class = ( isset( $widget['queue'] ) && $widget['queue'] == $i ) ? $widget['layout'] : $widget['class'];

						$output .= '<div class="' . $widget_class . '">';
						ob_start();
						dynamic_sidebar( 'footer-' . $i );
						$output .= ob_get_clean();
						$output .= '</div>';
					}
				}

				if ( $after ) {
					ob_start();
					dynamic_sidebar( 'footer-after' );
					$after   = ob_get_clean();
					$output .= '<div class="col-md-12">' . $after . '</div>';
				}

				$output .= '</div>';
				$output .= '</div>';
				$output .= '</footer>';
			}

			ob_start();
			dynamic_sidebar( 'footer-block-after' );
			$footer_block_after = ob_get_clean();

			if ( ! empty( $footer_block_after ) ) {
				$output .= '<div id="cs-footer-block-after">';
				$output .= '<div class="container">';
				$output .= '<div class="row">';
				$output .= '<div class="col-md-12">';
				$output .= $footer_block_after;
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
			}
		}

		$copyright         = cs_get_option( 'copyright_text' );
		$disable_copyright = cs_get_option( 'disable_copyright' );

		if ( $copyright && empty( $disable_copyright ) ) {

			$output .= '<div id="copyright">';
			$output .= '<div class="container">';
			$output .= '<div class="row">';
			$output .= '<div class="col-md-12">';
			$output .= do_shortcode( cs_multilang_value( $copyright ) );
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
		}

		return $output;
	}
}

/**
 *
 * Footer Social Modules
 *
 * @since 1.0.0
 * @version 1.6.0
 */
if ( ! function_exists( 'cs_footer_bar_modules' ) ) {

	function cs_footer_bar_modules( $area ) {
		$output    = '';
		$top_right = cs_get_option( 'footer_social' );
		$modules   = ( $area == 'right' ) ? $top_right : $top_left;
		$column    = ( empty( $top_left ) || empty( $top_right ) ) ? 12 : 6;
		if ( ! empty( $modules ) ) {
			$output .= '<div class="cs-bottom-' . $area . '">';
			foreach ( $modules as $key => $module ) {
				$class   = ( ! empty( $module['class'] ) ) ? ' ' . $module['class'] : '';
				$out     = '';
				$out    .= '<div class="cs-module-' . $module['module'] . $class . '">';
				$target  = ( ! empty( $module['target'] ) ) ? ' target="' . $module['target'] . '"' : '';
				$out    .= '<a href="' . cs_multilang_value( $module['link'] ) . '"' . $target . ' class="' . cs_icon_class( $module['icon'] ) . '"></a>';
				$out    .= '</div>';
				$output .= ( ! empty( $module['check'] ) && is_user_logged_in() ) ? '' : $out;
			}
			$output .= '</div>';
		}
		return $output;
	}
}


/**
 *
 * Custom Javascript
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_custom_js' ) ) {

	function cs_custom_js() {
		$custom_js = cs_get_option( 'custom_js' );
		if ( $custom_js ) {
			return '<script type="text/javascript">' . $custom_js . '</script>';
		}
	}
}

/**
 *
 * Header Before
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_header_before' ) ) {

	function cs_header_before() {

		global $post;

		$post_id = ( isset( $post ) ) ? $post->ID : false;
		$post_id = ( is_front_page() ) ? get_option( 'page_on_front' ) : $post_id;

		if ( ! $post_id ) {
			return;
		}

		$post_meta = get_post_meta( $post_id, '_custom_page_options', true );
		return ( ! empty( $post_meta['header_before'] ) ) ? '<div id="header-before">' . do_shortcode( cs_multilang_value( $post_meta['header_before'] ) ) . '</div>' : '';
	}
}


/**
 *
 * Google Analytics by Tracking Code
 *
 * @since 1.8.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_google_analytics' ) ) {

	function cs_google_analytics( $head = '' ) {

		$ga = cs_get_option( 'ga' );

		if ( $ga ) {

			ob_start();
			?>
			<!-- Google Analytics -->
			<script type="text/javascript">
				var _gaq = _gaq || [ ];
				_gaq.push( [ '_setAccount', '<?php echo esc_attr($ga); ?>' ] );
				_gaq.push( [ '_trackPageview' ] );

				( function () {
					var ga = document.createElement( 'script' );
					ga.type = 'text/javascript';
					ga.async = true;
					ga.src = ( 'https:' == document.location.protocol ? 'https://ssl' : 'http://www' ) + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName( 'script' )[0];
					s.parentNode.insertBefore( ga, s );
				} )();
			</script>
			<!-- End Google Analytics -->
			<?php
			echo ob_get_clean();
		}
	}
}

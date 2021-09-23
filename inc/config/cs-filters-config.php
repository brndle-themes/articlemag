<?php
/**
 *
 * Post formats filters in the_content
 *
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! function_exists( 'cs_content_filter' ) ) {
	function cs_content_filter( $content ) {
		$post_format = get_post_format();
		if ( $post_format ) {
			$content = apply_filters( 'cs-post-format-' . $post_format, $content );
		}
		return $content;
	}
	add_filter( 'the_content', 'cs_content_filter', 2 );
}

/**
 *
 * Post format "Link"
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_post_format_link' ) ) {
	function cs_post_format_link( $content ) {
		$parse_content = post_format_link_helper( $content );
		return $parse_content['content'];
	}
	add_filter( 'cs-post-format-link', 'cs_post_format_link' );
}


/**
 *
 * Post format "Video and Audio"
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_post_format_media' ) ) {
	function cs_post_format_media( $content ) {

		$media = get_first_url_from_string( $content );

		if ( ! empty( $media ) ) {

			$content = str_replace( $media, '', $content );

		} else {

			$pattern = cs_get_shortcode_regex( cs_tagregexp() );
			preg_match( '/' . $pattern . '/s', $content, $media );
			if ( ! empty( $media[2] ) ) {
				$content = str_replace( $media[0], '', $content );
			}
		}

		return $content;
	}
	add_filter( 'cs-post-format-video', 'cs_post_format_media' );
	add_filter( 'cs-post-format-audio', 'cs_post_format_media' );
}


/**
 *
 * Post format "Gallery"
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_post_format_gallery' ) ) {
	function cs_post_format_gallery( $content ) {

		$pattern = cs_get_shortcode_regex( 'gallery' );
		preg_match( '/' . $pattern . '/s', $content, $media );

		if ( ! empty( $media[2] ) ) {
			$content = str_replace( $media[0], '', $content );
		}

		return $content;
	}
	add_filter( 'cs-post-format-gallery', 'cs_post_format_gallery' );
}


/**
 *
 * Post format "Chat"
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_post_format_chat' ) ) {
	function cs_post_format_chat( $content ) {

		$output = '<ul class="cs-chat">';
		$rows   = preg_split( "/(\r?\n)+|(<br\s*\/?>\s*)+/", $content );
		$i      = 0;

		foreach ( $rows as $row ) {

			if ( strpos( $row, ':' ) ) {

				$row_split = explode( ':', trim( $row ), 2 );
				$author    = strip_tags( trim( $row_split[0] ) );
				$text      = trim( $row_split[1] );

				$output .= '<li class="cs-chat-row cs-chat-row-' . ( $i % 2 ? 'odd' : 'even' ) . '">';
				$output .= '<div class="cs-chat-author ' . sanitize_html_class( strtolower( "chat-author-{$author}" ) ) . ' vcard"><span class="fa fa-comment"></span> <cite class="fn">' . $author . '</cite>' . ':' . '</div>';
				$output .= '<div class="cs-chat-text">' . $text . '</div>';
				$output .= '</li>';

				$i++;
			} else {
				$output .= $row;
			}
		}

		$output .= '</ul>';
		return $output;

	}
	add_filter( 'cs-post-format-chat', 'cs_post_format_chat' );
}


/**
 *
 * The content more link modification
 *
 * @since 1.0.0
 * @version 1.2.0
 */
if ( ! function_exists( 'cs_content_more_link' ) ) {
	function cs_content_more_link( $link ) {

		$offset = strpos( $link, '#more-' );

		if ( $offset ) {
			$end = strpos( $link, '"', $offset );
		}

		if ( $end ) {
			$link = substr_replace( $link, '', $offset, ( $end - $offset ) );
		}

		$link = '<span class="entry-read-more">' . str_replace( 'more-link', 'entry-more ' . cs_get_button_class( array( 'size' => 'xxs' ) ), $link ) . '</span>';

		return $link;
	}
	add_filter( 'the_content_more_link', 'cs_content_more_link' );
}


/**
 *
 * Blog Excerpt Read More
 *
 * @since 1.4.0
 * @version 1.2.0
 */
if ( ! function_exists( 'cs_excerpt_read_more_link' ) ) {
	function cs_excerpt_read_more_link( $text ) {
		return ( is_search() ) ? $text : $text . '<span class="entry-read-more"><a href="' . get_permalink( get_the_ID() ) . '" class="' . cs_get_button_class( array( 'size' => 'xxs' ) ) . '">' . __( 'Read More', 'articlemag' ) . '</a></span>';
	}
	add_filter( 'the_excerpt', 'cs_excerpt_read_more_link', 7 );
}


/**
 *
 * Blog Auto Excerpt Read More
 *
 * @since 1.7.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_auto_excerpt_read_more_link' ) ) {
	function cs_auto_excerpt_read_more_link( $content ) {

		if ( cs_get_option( 'blog_auto_excerpt' ) == 1 && get_post_type() == 'post' && ! is_feed() && ! is_single() && ! is_search() && ! strpos( $content, 'cs-btn' ) ) {

			$content = cs_auto_post_excerpt( $content, 10 );
		}
		return $content;

	}
	add_filter( 'the_content', 'cs_auto_excerpt_read_more_link', 7 );
}


/**
 *
 * Disable default WordPress gallery styles
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( '_use_default_gallery_style' ) ) {
	function _use_default_gallery_style() {
		return false;
	}
	add_filter( 'use_default_gallery_style', '_use_default_gallery_style' );
}

/**
 *
 * Custom Image Sizes
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_image_size_names_choose' ) ) {
	function cs_image_size_names_choose( $image_sizes ) {

		$custom_image_sizes = cs_get_option( 'custom_image_sizes' );

		if ( ! empty( $custom_image_sizes ) ) {
			$custom_sizes = array();
			foreach ( $custom_image_sizes as $image_size ) {
				$name                  = sanitize_title( $image_size['name'] );
				$custom_sizes[ $name ] = $image_size['name'];
			}

			return array_merge( $image_sizes, $custom_sizes );
		}

		return $image_sizes;

	}
	add_filter( 'image_size_names_choose', 'cs_image_size_names_choose' );
}


/**
 *
 * Retrieve protected post password form content.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_the_password_form' ) ) {
	function cs_the_password_form( $output ) {
		$output = str_replace( 'type="submit"', 'type="submit" class="cs-password-btn ' . cs_get_button_class( array( 'size' => 'sm' ) ) . '"', $output );
		return $output;
	}
	add_filter( 'the_password_form', 'cs_the_password_form' );
}


/**
 *
 * Ninja Forms add submit class
 *
 * @since 1.3.0
 * @version 1.0.0
 */
if ( is_ninjaforms_activated() && ! function_exists( 'cs_ninja_forms_display_field_class' ) ) {
	function cs_ninja_forms_display_field_class( $field_class, $field_id, $field_row ) {
		return ( $field_row['type'] == '_submit' ) ? $field_class . ' ' . cs_get_button_class() : $field_class;
	}
	add_filter( 'ninja_forms_display_field_class', 'cs_ninja_forms_display_field_class', 1, 3 );
}

/**
 *
 * Gravity Forms add submit class
 *
 * @since 1.3.0
 * @version 1.2.0
 */
if ( is_gravityforms_activated() && ! function_exists( 'cs_gform_submit_class' ) ) {
	function cs_gform_submit_class( $button ) {
		$button = str_replace( 'gform_next_button button', 'gform_next_button button ' . cs_get_button_class(), $button );
		$button = str_replace( 'gform_previous_button button', 'gform_previous_button button ' . cs_get_button_class(), $button );
		$button = str_replace( 'gform_button button', 'gform_button button ' . cs_get_button_class(), $button );
		return $button;
	}
	add_filter( 'gform_next_button', 'cs_gform_submit_class', 10 );
	add_filter( 'gform_previous_button', 'cs_gform_submit_class', 10 );
	add_filter( 'gform_submit_button', 'cs_gform_submit_class', 10 );
}

/**
 *
 * Set body class for header options
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_body_class_names' ) ) {
	function cs_body_class_names( $classes ) {

		$post_meta         = cs_get_post_meta();
		$mobile_animations = cs_get_option( 'mobile_animations' );
		$boxed_layout      = cs_get_option( 'boxed_layout' );
		$header_style      = cs_get_option( 'header_style' );
		$menu_down_icon    = cs_get_option( 'menu_down_icon' );
		$menu_effect       = cs_get_option( 'menu_effect' );
		$menu_effect       = ( $menu_effect != 'none' ) ? 'cs-menu-effect cs-menu-effect-' . $menu_effect : '';
		$menu_down_icon    = ( $menu_down_icon ) ? 'cs-down-icon' : '';
		$boxed_layout      = ( $boxed_layout ) ? 'cs-boxed-layout' : '';
		$is_sticky         = ( cs_get_option( 'header_sticky' ) ) ? 'cs-header-sticky' : '';
		$is_transparent    = ( ( $header_style == 'default' || $header_style == 'fancy' ) && ! empty( $post_meta['header_transparent'] ) ) ? 'cs-header-transparent is-transparent' : '';
		$is_transparent    = ( $header_style == 'center' && ! empty( $post_meta['header_transparent'] ) ) ? 'is-transparent-center' : $is_transparent;
		$is_top_bar        = ( ! empty( $post_meta['header_transparent'] ) && ! empty( $post_meta['top_bar_transparent'] ) ) ? 'is-transparent-top-bar' : '';
		$mobile_animations = ( $mobile_animations ) ? 'cs-no-mobile-animations' : '';

		$classes[] = "$is_sticky cs-header-$header_style $menu_effect $menu_down_icon $boxed_layout $is_transparent $is_top_bar $mobile_animations";

		return $classes;
	}
	add_filter( 'body_class', 'cs_body_class_names' );
}

/**
 *
 * Add new upload mimes for font uploader
 *
 * @since 2.3.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_upload_mimes' ) ) {
	function cs_upload_mimes( $mimes ) {

		$mimes['ttf']  = 'font/ttf';
		$mimes['eot']  = 'font/eot';
		$mimes['svg']  = 'font/svg';
		$mimes['woff'] = 'font/woff';
		$mimes['otf']  = 'font/otf';

		return $mimes;

	}
	add_filter( 'upload_mimes', 'cs_upload_mimes' );
}

/**
 *
 * Adding new custom fonts for exclude google fonts
 *
 * @since 2.3.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_is_googe_font_custom' ) ) {
	function cs_is_googe_font_custom( $fonts ) {

		$custom = cs_get_option( 'font_family' );

		if ( ! empty( $custom ) ) {
			foreach ( $custom as $family ) {
				$fonts[] = $family['name'];
			}
		}

		return $fonts;

	}
	add_filter( 'cs_is_googe_font', 'cs_is_googe_font_custom' );
}

/**
 *
 * Disabling contact form 7 css
 *
 * @since 2.6.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_wpcf7_load_css' ) ) {
	/**
	 * Cs wpcf7 load css
	 */
	function cs_wpcf7_load_css() {
		return false;
	}
	add_filter( 'wpcf7_load_css', 'cs_wpcf7_load_css' );
}

/**
 *
 * Yoast Seo Plugin Metabox Low
 *
 * @since 2.7.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_wpseo_metabox_prio' ) ) {
	/**
	 * Cs wpseo metabox prio
	 */
	function cs_wpseo_metabox_prio() {
		return 'low';
	}
	add_filter( 'wpseo_metabox_prio', 'cs_wpseo_metabox_prio' );
}

/**
 *
 * Admin Post Thumbnail HTML
 *
 * @since 3.6.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_admin_post_thumbnail_html' ) ) {
	function cs_admin_post_thumbnail_html( $content, $post_id ) {

		$value = get_post_meta( get_the_ID(), '_custom_page_options', true );
		$value = ( ! empty( $value['hide_featured_image'] ) ) ? 1 : 0;

		$content .= '<label>';
		$content .= '<input type="checkbox" name="_page_custom_box[hide_featured_image]" value="1" ' . checked( $value, 1, false ) . '>';
		$content .= 'Do not show this on single page';
		$content .= '</label>';

		return $content;

	}
}

<?php
/**
 *
 * Hex to Rgba
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_hex2rgba' ) ) {
	function cs_hex2rgba( $hexcolor, $opacity = 1 ) {

		if ( preg_match( '/^#[a-fA-F0-9]{6}|#[a-fA-F0-9]{3}$/i', $hexcolor ) ) {

			$hex = str_replace( '#', '', $hexcolor );

			if ( strlen( $hex ) == 3 ) {
				$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
				$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
				$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
			} else {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );
			}

			return ( isset( $opacity ) && $opacity != 1 ) ? 'rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $opacity . ')' : ' ' . $hexcolor;

		} else {

			return $hexcolor;

		}

	}
}

/**
 *
 * Set WPAUTOP for shortcode output
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_set_wpautop' ) ) {
	function cs_set_wpautop( $content, $force = true ) {
		if ( $force ) {
			$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
		}
		return do_shortcode( shortcode_unautop( $content ) );
	}
}

/**
 *
 * Shortcode Attributes to HTML
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_atts2html' ) ) {
	function cs_atts2html( $atts ) {

		$attributes = array();
		if ( is_array( $atts ) ) {
			foreach ( $atts as $key => $value ) {
				$attributes[] = ( is_numeric( $key ) ) ? $value : $key . '="' . $value . '"';
			}
		}

		return ( ! empty( $attributes ) ) ? ' ' . join( ' ', $attributes ) : '';
	}
}

/**
 *
 * HTML Entities for Escape Shortcode Characters "[" and "]"
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_htmlentities' ) ) {
	function cs_htmlentities( $text ) {
		return str_replace( array( '[', ']' ), array( '&#091;', '&#093;' ), htmlentities( $text ) );
	}
}

/**
 *
 * Inline Style Store
 *
 * @since 1.0.0
 * @version 1.0.0
 */
global $cs_inline_styles;
$cs_inline_styles = array();
if ( ! function_exists( 'cs_add_inline_style' ) ) {
	function cs_add_inline_style( $style ) {
		global $cs_inline_styles;
		array_push( $cs_inline_styles, $style );
	}
}

/**
 *
 * Valid PX
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_validpx' ) ) {
	function cs_validpx( $num ) {
		return ( is_numeric( $num ) ) ? $num . 'px' : $num;
	}
}

/**
 *
 * ESC String
 *
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! function_exists( 'cs_esc_string' ) ) {
	function cs_esc_string( $num ) {
		return preg_replace( '/\D/', '', $num );
	}
}

/**
 *
 * ESC Number
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_esc_number' ) ) {
	function cs_esc_number( $num ) {
		return preg_replace( '/[^a-zA-Z]/', '', $num );
	}
}

/**
 *
 * Option to Background
 *
 * @since 1.0.0
 * @version 1.0.0
 */
 /**
  *
  * Option to Background
  *
  * @since 1.0.0
  * @version 1.0.0
  */
if ( ! function_exists( 'cs_option2background' ) ) {
	function cs_option2background( $post_meta = array() ) {

		$out = '';

		if ( isset( $post_meta['background'] ) ) {

			extract( $post_meta['background'] );

			$image          = $post_meta['background']['background-image']['url'];
			$repeat         = $post_meta['background']['background-repeat'];
			$attachment     = $post_meta['background']['background-attachment'];
			$color          = $post_meta['background']['background-color'];
			$bg_size        = $post_meta['background']['background-size'];
			$position       = $post_meta['background']['background-position'];
                        $default_image  = get_template_directory_uri() . '/images/default-image.jpg';
                                
			$background_image      = ( ! empty( $image ) ) ? 'background-image: url(' . $image . ');' : $default_image;
			$background_repeat     = ( ! empty( $image ) && ! empty( $repeat ) ) ? ' background-repeat: ' . $repeat . ';' : '';
			$background_size       = ( ! empty( $image ) ) ? ' background-size: ' . $bg_size . ';' : '';
			$background_position   = ( ! empty( $image ) && ! empty( $position ) ) ? ' background-position: ' . $position . ';' : '';
			$background_attachment = ( ! empty( $attachment ) ) ? $attachment : '';
			$background_attachment = ( ! empty( $post_meta['parallax'] ) ) ? 'fixed' : $background_attachment;
			$background_attachment = ( ! empty( $image ) && $background_attachment ) ? ' background-attachment: ' . $background_attachment . ';' : '';
			$background_color      = ( ! empty( $color ) ) ? ' background-color: ' . $color . ';' : '';
			$background_style      = ( ! empty( $image ) ) ? $background_image . $background_repeat . $background_position . $background_attachment . $background_size : '';

			$out .= ( ! empty( $background_style ) || ! empty( $background_color ) ) ? ' style="' . $background_style . $background_color . '"' : '';

		}
		return $out;
	}
}

/**
 *
 * Darken or Lighten Colours
 * Source : http://lab.clearpixel.com.au/2008/06/darken-or-lighten-colours-dynamically-using-php/
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_brightness' ) ) {
	function cs_brightness( $hex, $percent ) {

		$hash = '';
		if ( stristr( $hex, '#' ) ) {
			$hex  = str_replace( '#', '', $hex );
			$hash = '#';
		}

		$rgb = array( hexdec( substr( $hex, 0, 2 ) ), hexdec( substr( $hex, 2, 2 ) ), hexdec( substr( $hex, 4, 2 ) ) );

		for ( $i = 0; $i < 3; $i++ ) {

			if ( $percent > 0 ) {
				$rgb[ $i ] = round( $rgb[ $i ] * $percent ) + round( 255 * ( 1 - $percent ) );
			} else {
				$positivePercent = $percent - ( $percent * 2 );
				$rgb[ $i ]       = round( $rgb[ $i ] * $positivePercent ) + round( 0 * ( 1 - $positivePercent ) );
			}

			if ( $rgb[ $i ] > 255 ) {
				$rgb[ $i ] = 255;
			}
		}

		$hex = '';
		for ( $i = 0; $i < 3; $i++ ) {
			$hexDigit = dechex( $rgb[ $i ] );
			if ( strlen( $hexDigit ) == 1 ) {
				$hexDigit = '0' . $hexDigit;
			}
			$hex .= $hexDigit;
		}
		return $hash . $hex;
	}
}

/**
 *
 * Categorized Blog
 * Find out if blog has more than one category.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'articlemag_categorized_blog' ) ) {
	function articlemag_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'articlemag_category_count' ) ) ) {

			$all_the_cool_cats = get_categories( array( 'hide_empty' => 1 ) );
			$all_the_cool_cats = count( $all_the_cool_cats );
			set_transient( 'articlemag_category_count', $all_the_cool_cats );

		}

		if ( 1 !== (int) $all_the_cool_cats ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 *
 * Flush Categorized Blog
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'articlemag_category_transient_flusher' ) ) {
	function articlemag_category_transient_flusher() {
		delete_transient( 'articlemag_category_count' );
	}
}
add_action( 'edit_category', 'articlemag_category_transient_flusher' );
add_action( 'save_post', 'articlemag_category_transient_flusher' );

/**
 *
 * Get Bootstrap Column
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_bootstrap' ) ) {
	function cs_get_bootstrap( $columns = 1, $device = 'md', $force = false ) {

		global $cs_blog_column;

		$columns = ( ! empty( $cs_blog_column ) && ! $force ) ? $cs_blog_column : $columns;
		$device  = ( cs_get_option( 'non_responsive' ) ) ? 'md' : $device;

		$bootstrap_columns = array(
			1  => 'col-' . $device . '-12',
			2  => 'col-' . $device . '-6',
			3  => 'col-' . $device . '-4',
			4  => 'col-' . $device . '-3',
			5  => 'col-' . $device . '-five',
			6  => 'col-' . $device . '-2',
			7  => 'col-' . $device . '-seven',
			8  => 'col-' . $device . '-eight',
			9  => 'col-' . $device . '-nine',
			10 => 'col-' . $device . '-ten',
			11 => 'col-' . $device . '-eleven',
			12 => 'col-' . $device . '-1',
		);

		$bootstrap_columns = apply_filters( 'cs_get_bootstrap_columns', $bootstrap_columns );

		return $bootstrap_columns[ $columns ];

	}
}

/**
 *
 * Get Bootstrap Col
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_bootstrap_col' ) ) {
	function cs_get_bootstrap_col( $width = '' ) {
		$width = explode( '/', $width );
		$width = ( $width[0] != '1' ) ? $width[0] * floor( 12 / $width[1] ) : floor( 12 / $width[1] );
		return $width;
	}
}

/**
 *
 * Walker Category
 *
 * @since 1.0.0
 * @version 1.1.0
 */
class Walker_Portfolio_List_Categories extends Walker_Category {

	function start_el( &$output, $category, $depth = 0, $args = array(), $current_object_id = 0 ) {

		$has_children = get_term_children( $category->term_id, 'portfolio-category' );

		if ( empty( $has_children ) ) {
			$cat_name = esc_attr( $category->name );
			$cat_name = apply_filters( 'list_cats', $cat_name, $category );
			$link     = '<a href="#" data-filter=".' . strtolower( $category->slug ) . '">';
			$link    .= $cat_name;
			$link    .= '</a>';
			$output  .= $link;
		}

	}

	function end_el( &$output, $page, $depth = 0, $args = array() ) {}

}

/**
 *
 * Get Image Sizes
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_image_sizes' ) ) {
	function cs_get_image_sizes( $force = false, $flip = true ) {
		$current_image_sizes = get_intermediate_image_sizes();
		
		foreach ( $current_image_sizes as $image_size ) {
			$dimenssion                 = ( in_array( $image_size, array( 'thumbnail', 'medium', 'large' ) ) ) ? ' - (' . get_option( $image_size . '_size_w' ) . 'x' . get_option( $image_size . '_size_h' ) . ')' : '';
			$image_sizes[ $image_size ] = $image_size . $dimenssion;
		}

		if ( $force ) {
			$get_custom_image_sizes = cs_get_option( 'custom_image_sizes' );
			if ( ! empty( $get_custom_image_sizes ) ) {
				foreach ( $get_custom_image_sizes as $custom_size ) {
					$name                        = sanitize_title( $custom_size['name'] );
					$custom_image_sizes[ $name ] = $name . ' - (' . $custom_size['size']['width'] . 'x' . $custom_size['size']['height'] . ')';
				}
				$image_sizes = array_filter( array_merge( $image_sizes, $custom_image_sizes ) );
			}
		}

		$image_sizes['full'] = 'full (orginal size)';

		$image_sizes['articlemag-featured-large'] = 'articlemag-featured-large (1920 x 600)';
		$image_sizes['articlemag-thumb']          = 'articlemag-thumb (600 x 300)';

		$image_sizes = ( $flip ) ? array_flip( $image_sizes ) : $image_sizes;

		return apply_filters( 'cs_custom_image_sizes', $image_sizes );
	}
}

/**
 *
 * Aspect Radio
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_aspect_radio' ) ) {
	function cs_aspect_radio( $radio = '' ) {
		$radio = explode( ':', $radio );
		$radio = intVal( $radio[1] / $radio[0] * 100 );
		return $radio;
	}
}

/**
 *
 * Get Icon
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_icon_class' ) ) {
	function cs_icon_class( $icon, $before = false ) {
		if ( empty( $icon ) ) {
			return null; }
		$icon = 'cs-in ' . substr( $icon, 0, 2 ) . ' ' . $icon;
		return $icon;
	}
}

/**
 *
 * Create Blank Png
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_blank_png' ) ) {
	function cs_blank_png() {
		return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=';
	}
}

/**
 *
 * Multi Language Value
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_multilang_value' ) ) {
	function cs_multilang_value( $value ) {

		if ( is_array( $value ) && is_wpml_activated() ) {

			$current = ICL_LANGUAGE_CODE;
			return $value[ $current ];

		} elseif ( is_qtranslate_activated() ) {

			global $q_config;
			$current = $q_config['language'];
			return ( is_array( $value ) ) ? $value[ $current ] : qtrans_use( $current, $value );

		} elseif ( is_array( $value ) && is_polylang_activated() ) {

			$current = pll_current_language();
			return $value[ $current ];

		} elseif ( is_array( $value ) ) {
			$value = array_values( $value );
			return $value[0];
		}

		return $value;

	}
}


/**
 *
 * is go_pricing activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'is_go_pricing_activated' ) ) {
	function is_go_pricing_activated() {
		if ( class_exists( 'GW_GoPricing' ) ) {
			return true;
		} else {
			return false; }
	}
}

/**
 *
 * is woocommerce activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) {
			return true;
		} else {
			return false; }
	}
}

/**
 *
 * is woocommerce shop
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'is_woocommerce_shop' ) ) {
	function is_woocommerce_shop() {
		if ( is_woocommerce_activated() && is_shop() ) {
			return true;
		} else {
			return false; }
	}
}

/**
 *
 * is wpml activated
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'is_wpml_activated' ) ) {
	function is_wpml_activated() {
		if ( class_exists( 'SitePress' ) ) {
			return true;
		} else {
			return false; }
	}
}

/**
 *
 * qTranslate-x compatibility
 *
 * @since 3.3.0
 * @version 1.0.0
 */
if ( function_exists( 'qtranxf_init' ) && ! function_exists( 'qtranslate_compatibility_enable' ) ) {
	function qtranslate_compatibility_enable() {
		return true;
	}
	add_filter( 'qtranslate_compatibility', 'qtranslate_compatibility_enable' );
}

/**
 *
 * is qtranslate activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'is_qtranslate_activated' ) ) {
	function is_qtranslate_activated() {
		if ( function_exists( 'qtrans_getSortedLanguages' ) ) {
			return true;
		} else {
			return false; }
	}
}

/**
 *
 * is polylang activated
 *
 * @since 1.3.0
 * @version 1.0.0
 */
if ( ! function_exists( 'is_polylang_activated' ) ) {
	function is_polylang_activated() {
		if ( class_exists( 'Polylang' ) ) {
			return true;
		} else {
			return false; }
	}
}

/**
 *
 * is gravityforms activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'is_gravityforms_activated' ) ) {
	function is_gravityforms_activated() {
		if ( class_exists( 'RGForms' ) ) {
			return true;
		} else {
			return false; }
	}
}

/**
 *
 * is ninjaforms activated
 *
 * @since 1.3.0
 * @version 1.0.0
 */
if ( ! function_exists( 'is_ninjaforms_activated' ) ) {
	function is_ninjaforms_activated() {
		if ( class_exists( 'Ninja_Forms' ) ) {
			return true;
		} else {
			return false; }
	}
}

/**
 *
 * is bbpress activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'is_bbpress_activated' ) ) {
	function is_bbpress_activated() {
		if ( class_exists( 'bbPress' ) ) {
			return true;
		} else {
			return false; }
	}
}

/**
 *
 * is js_composer activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'is_vc_activated' ) ) {
	function is_vc_activated() {
		if ( class_exists( 'Vc_Manager' ) && defined( 'WPB_VC_VERSION' ) && version_compare( WPB_VC_VERSION, '4.2.3', '>=' ) ) {
			return true;
		} else {
			return false; }
	}
}

/**
 *
 * cs is activated
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_is_activated' ) ) {
	function cs_is_activated( $element ) {
		do_action( 'cs_is_activated', $element );
		return true;
	}
}

/**
 *
 * WebSafe Fonts
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_websafe_fonts' ) ) {
	function cs_get_websafe_fonts() {

		$fonts = array(
			'Arial, Helvetica, sans-serif',
			"'Arial Black', Gadget, sans-serif",
			"'Comic Sans MS', cursive, sans-serif",
			'Impact, Charcoal, sans-serif',
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			'Tahoma, Geneva, sans-serif',
			"'Trebuchet MS', Helvetica, sans-serif",
			'Verdana, Geneva, sans-serif',
			"'Courier New', Courier, monospace",
			"'Lucida Console', Monaco, monospace",
			'Georgia, serif',
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"'Times New Roman', Times, serif",
		);

		$fonts = apply_filters( 'cs_websafe_fonts', $fonts );

		return $fonts;
	}
}

/**
 *
 * Check for Google Font
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_is_googe_font' ) ) {
	function cs_is_googe_font( $font ) {
		$fonts = apply_filters( 'cs_is_googe_font', cs_get_websafe_fonts() );
		return ( ! empty( $font ) && ! in_array( $font, $fonts ) ) ? true : false;
	}
}

/**
 *
 * Enqueue Google Fonts
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_enqueue_google_fonts' ) ) {
	function cs_enqueue_google_fonts() {

		$embed_fonts = array();
		$query_args  = array();
		$typography  = cs_get_option( 'typography' );
		if ( empty( $typography ) ) {
			return; }
		foreach ( $typography as $font ) {
			$subsets = ( isset( $font['font']['subset'] ) ) ? $font['font']['subset'] : '';
			$subsets = ( ! empty( $subsets ) ) ? '&subset=' . $subsets : '';
			if ( ! empty( $font['selector'] ) ) {
				$family = ( isset( $font['font']['font-family'] ) ) ? $font['font']['font-family'] : '';
				if ( cs_is_googe_font( $family ) ) {
					$variant = ( $font['font']['font-weight'] != 'regular' ) ? $font['font']['font-weight'] : 400;
					$embed_fonts[ $family ]['font-weight'][ $variant ] = $variant;
				}
			}
		}

		if ( ! empty( $embed_fonts ) ) {
			foreach ( $embed_fonts as $name => $font ) {
				$variants       = ( $font['font-weight'] );
				$embed_variants = ( ! empty( $font['font-weight'] ) ) ? ':' . implode( ',', $font['font-weight'] ) : '';
				$query_args[]   = $name . $embed_variants;
			}
			wp_enqueue_style( 'cs-google-fonts', esc_url( add_query_arg( 'family', urlencode( implode( '|', $query_args ) ) . $subsets, '//fonts.googleapis.com/css' ) ), array(), null );
		}

	}
}


/**
 *
 * Typography
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_typography' ) ) {
	function cs_get_typography() {
		$typography = cs_get_option( 'typography' );
		$output     = '';
		if ( ! empty( $typography ) ) {
			foreach ( $typography as $font ) {
				if ( ! empty( $font['selector'] ) ) {
					$weight    = ( $font['font']['font-weight'] != 'regular' ) ? esc_attr( $font['font']['font-weight'] ) : 400;
					$style     = cs_esc_number( $font['font']['font-weight'] );
					$style     = ( $style && $style != 'regular' ) ? $style : 'normal';
					$transform = ( $font['font']['text-transform'] != 'none' ) ? esc_attr( $font['font']['text-transform'] ) : '';
					$letter    = ( $font['font']['letter-spacing'] != '0.5' ) ? esc_attr( $font['font']['letter-spacing'] ) : '';
					$aligment  = ( $font['font']['text-align'] != 'left' ) ? esc_attr( $font['font']['text-align'] ) : '';
					$color     = ( $font['font']['color'] != 'none' ) ? esc_attr( $font['font']['color'] ) : '';
					$family    = ( cs_is_googe_font( $font['font']['font-family'] ) ) ? '"' . $font['font']['font-family'] . '", Arial, sans-serif' : $font['font']['font-family'];

					$output .= $font['selector'] . '{';
					$output .= ( ! empty( $family ) ) ? 'font-family: ' . $family . ';' : '';
					$output .= ( ! empty( $font['font']['line-height'] ) ) ? 'line-height: ' . $font['font']['line-height'] . 'px;' : '';
					$output .= ( ! empty( $font['font']['font-size'] ) ) ? 'font-size: ' . $font['font']['font-size'] . 'px;' : '';
					$output .= 'font-style: ' . $style . ';';
					$output .= ( ! empty( $weight ) ) ? 'font-weight: ' . $weight . ';' : '';
					$output .= ( ! empty( $transform ) ) ? 'text-transform: ' . $transform . ';' : '';
					$output .= ( ! empty( $letter ) ) ? 'letter-spacing: ' . $letter . 'px;' : '';
					$output .= ( ! empty( $aligment ) ) ? 'text-align: ' . $aligment . ';' : '';
					$output .= ( ! empty( $color ) ) ? 'color: ' . $color . ';' : '';
					$output .= ( ! empty( $font['css'] ) ) ? $font['css'] : '';
					$output .= '}';
				}
			}
		}
		return $output;
	}
}



/**
 *
 * Font CSS
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_animations' ) ) {
	function cs_get_animations() {

		$animations = array(
			'',
			// fading_entrances
			'fadeIn',
			'fadeInLeft',
			'fadeInRight',
			'fadeInUp',
			'fadeInDown',
			// attention_seekers
			'bounce',
			'flash',
			'pulse',
			'shake',
			'swing',
			'tada',
			'wobble',
			// bouncing_entrances
			'bounceIn',
			'bounceInLeft',
			'bounceInRight',
			'bounceInUp',
			'bounceInDown',
		);

		$animations = apply_filters( 'cs_animations', $animations );
		return $animations;

	}
}

/**
 *
 * Get Post Meta
 *
 * @since 1.0.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_get_post_meta' ) ) {
	function cs_get_post_meta() {
		global $post;
		$post_id = ( isset( $post ) ) ? $post->ID : false;
		$post_id = ( is_front_page() ) ? get_option( 'page_on_front' ) : $post_id;
		$post_id = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $post_id;
		$post_id = ( ! is_tag() && ! is_archive() && ! is_search() && ! is_404() ) ? $post_id : false;
		return ( ! empty( $post_id ) ) ? get_post_meta( $post_id, '_custom_page_options', true ) : null;
	}
}


/**
 *
 * CSS Compress
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_css_compress' ) ) {
	function cs_css_compress( $css ) {
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		$css = str_replace( ': ', ':', $css );
		$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );
		return $css;
	}
}


/**
 *
 * Array Filter
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_array_filter' ) ) {
	function cs_array_filter( $input, $callback = null ) {

		foreach ( $input as $key => &$value ) {
			if ( is_array( $value ) ) {
				$value = cs_array_filter( $value, $callback );
				if ( is_array( $value ) ) {
					if ( (bool) $value === false ) {
						unset( $input[ $key ] ); }
				} else {
					if ( (bool) ( $callback ? $callback( $value ) : $value ) === false ) {
						unset( $input[ $key ] ); }
				}
			} else {
				if ( (bool) ( $callback ? $callback( $value ) : $value ) === false ) {
					unset( $input[ $key ] ); }
			}
		}

		return $input;
	}
}

/**
 *
 * IF Not Empty
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_not_empty' ) ) {
	function cs_not_empty( $var ) {
		return ( $var === '0' || $var );
	}
}

/**
 *
 * Encode String
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_encode_string' ) ) {
	function cs_encode_string( $string ) {
		return rtrim( strtr( base64_encode( addslashes( gzcompress( serialize( $string ), 9 ) ) ), '+/', '-_' ), '=' );
	}
}


/**
 *
 * Get Registered Sidebars
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_wp_registered_sidebars' ) ) {
	function cs_wp_registered_sidebars() {

		global $wp_registered_sidebars;
		$widgets = array();

		if ( ! empty( $wp_registered_sidebars ) ) {
			foreach ( $wp_registered_sidebars as $key => $value ) {
				$widgets[ $key ] = $value['name'];
			}
		}

		return array_reverse( $widgets );

	}
}

/**
 *
 * Array Insert
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_array_insert' ) ) {
	function cs_array_insert( $array = array(), $values = array(), $target = 'after', $position = false ) {

		// enforce existing position
		if ( $position !== false && ! isset( $array[ $position ] ) ) {
			return $array;
		}

		$offset = ( $target == 'after' ) ? 0 : -1;

		foreach ( $array as $key => $value ) {
			++$offset;
			if ( $key == $position ) {
				break;
			}
		}

		$array = array_slice( $array, 0, $offset, true ) + $values + array_slice( $array, $offset, null, true );

		return $array;

	}
}

/**
 *
 * Get Page ID from Slug Insert
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_id_by_slug' ) ) {
	function cs_get_id_by_slug( $slug ) {
		$page = get_page_by_path( $slug );
		return ( isset( $page ) ) ? $page->ID : null;
	}
}

/**
 *
 * Blog Excerpt Read More
 *
 * @since 1.7.0
 * @version 1.1.0
 */
if ( ! function_exists( 'cs_auto_post_excerpt' ) ) {
	function cs_auto_post_excerpt( $content = '' ) {

		global $shortcode_tags;

		$exclude = array(
			'rev_slider'    => true,
			'rev_slider_vc' => true,
		);

		$temporary      = $shortcode_tags;
		$shortcode_tags = $exclude;
		$content        = strip_shortcodes( $content );
		$shortcode_tags = $temporary;
		$content        = do_shortcode( $content );

		$limit = cs_get_option( 'blog_excerpt_world_limit', 40 );

		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = strip_tags( $content );
		$words   = explode( ' ', $content, $limit + 1 );

		if ( count( $words ) > $limit ) {

			array_pop( $words );
			$content  = implode( ' ', $words );
			$content .= ' &hellip;';
			$content .= '<span class="entry-read-more"><a href="' . get_permalink( get_the_ID() ) . '" class="' . cs_get_button_class( array( 'size' => 'xxs' ) ) . '">' . __( 'Read More', 'articlemag' ) . '</a></span>';

		}

		return $content;

	}
}

/**
 *
 * Check for Custom Font
 *
 * @since 2.3.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_is_custom_font' ) ) {
	function cs_is_custom_font( $font ) {

		$fonts  = cs_get_option( 'font_family' );
		$custom = array();

		if ( ! empty( $fonts ) ) {
			foreach ( $fonts as $custom_font ) {
				$custom[] = $custom_font['name'];
			}
		}

		return ( ! empty( $font ) && ! empty( $custom ) && in_array( $font, $custom ) ) ? true : false;

	}
}

/**
 *
 * Get Nav Menus
 *
 * @since 4.2.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_nav_menus' ) ) {
	function cs_get_nav_menus() {

		$menus = array();
		$items = wp_get_nav_menus();

		if ( ! empty( $items ) ) {
			foreach ( $items as $value ) {
				$menus[ $value->term_id ] = $value->name;
			}
		}

		return $menus;

	}
}

/**
 *
 * Get Nav Menu Array ( two level )
 *
 * @since 4.2.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_nav_menu_array' ) ) {
	function cs_get_nav_menu_array( $term_id ) {

		$nav    = array();
		$child  = array();
		$items  = wp_get_nav_menu_items( $term_id );
		$parent = 0;

		if ( ! empty( $items ) ) {

			foreach ( $items as $item ) {

				if ( $item->menu_item_parent == 0 ) {

					$nav[ $item->ID ] = $item;
					$parent           = $item->ID;

				} else {

					$child[]                  = $item;
					$nav[ $parent ]->children = $child;

				}
			}
		}

		return $nav;

	}
}

/**
 *
 * Framework Get Option
 *
 * @since 1.0.0
 * @version 1.0.1
 */
if ( ! function_exists( 'cs_get_option' ) ) {
	function cs_get_option( $option_name = '', $default = '' ) {

		$options    = get_option( FRAMEWORK_OPTION_NAME );
		$customizes = get_option( CUSTOMIZE_OPTION_NAME );
		$options    = wp_parse_args( $customizes, $options );
		$options    = apply_filters( 'cs_get_option', $options ); // Preview Helper!

		if ( isset( $options[ $option_name ] ) && isset( $option_name ) ) {

			return $options[ $option_name ];

		} else {

			if ( isset( $options['skin'] ) && ( $options['skin'] === 'accent' || $options['skin'] === 'custom' ) ) {

				$get_predefined_colors = get_predefined_colors( $options['skin'] );

				if ( array_key_exists( $option_name, $get_predefined_colors ) ) {

					return $get_predefined_colors[ $option_name ];

				}
			}

			return ( ! empty( $default ) ) ? $default : null;

		}

	}
}

/**
 *
 * Framework Set Option
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_set_option' ) ) {
	function cs_set_option( $option_name = '', $new_value = '' ) {

		$options    = get_option( FRAMEWORK_OPTION_NAME );
		$customizes = get_option( CUSTOMIZE_OPTION_NAME );

		if ( isset( $options[ $option_name ] ) ) {

			$options[ $option_name ] = $new_value;
			update_option( FRAMEWORK_OPTION_NAME, $options );

		} elseif ( isset( $customizes[ $option_name ] ) ) {

			$customizes[ $option_name ] = $new_value;
			update_option( CUSTOMIZE_OPTION_NAME, $customizes );

		} else {

			return;

		}

	}
}

/**
 *
 * Framework Get All Option
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_all_option' ) ) {
	function cs_get_all_option() {

		$options    = get_option( FRAMEWORK_OPTION_NAME );
		$customizes = get_option( CUSTOMIZE_OPTION_NAME );
		$options    = wp_parse_args( $customizes, $options );

		return $options;

	}
}

/**
 *
 * Framework Fields
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'cs_get_field' ) ) {
	function cs_get_field( $field = array(), $value = '', $unique = '' ) {

		$unique = ( isset( $unique ) ) ? $unique : '';

		// check for field type
		if ( isset( $field['type'] ) ) {

			// set class name
			$class = 'CSF_Field_' . $field['type'];
			// check class
			if ( class_exists( $class ) ) {

				$el_wrap_id    = ( isset( $field['id'] ) ) ? ' id="element-' . $field['id'] . '"' : '';
				$el_class      = ( isset( $field['el_class'] ) ) ? ' class_' . $field['el_class'] : '';
				$el_wrap_class = ( ! isset( $field['pseudo'] ) ) ? 'cs-element-wrap' : 'pseudo-field';

				// add dependencies attributes
				$depend = '';
				$hidden = '';
				$sub    = ( isset( $field['sub'] ) ) ? 'sub-' : '';

				if ( isset( $field['dependency'] ) ) {
					$hidden  = ' hidden';
					$depend .= ' data-' . $sub . 'controller="' . $field['dependency'][0] . '"';
					$depend .= ' data-' . $sub . 'condition="' . $field['dependency'][1] . '"';
					$depend .= ' data-' . $sub . "value='" . htmlspecialchars( $field['dependency'][2] ) . "'";
				}

				$fieldset_class = ( isset( $field['title'] ) ) ? 'cs-element-fieldset ' : '';

				echo '<div' . $el_wrap_id . ' class="' . $el_wrap_class . $el_class . $hidden . '"' . $depend . '>';

				if ( isset( $field['title'] ) ) {
					$field_desc = ( isset( $field['desc'] ) ) ? '<p class="cs-text-desc">' . $field['desc'] . '</p>' : '';
					echo '<div class="cs-element-title"><h4>' . $field['title'] . '</h4>' . $field_desc . '</div>';
				}

				echo '<div class="' . $fieldset_class . 'cs_field cs_field_' . $field['type'] . '">';

				$value   = ( ! isset( $value ) && isset( $field['default'] ) ) ? $field['default'] : $value;
				$value   = ( isset( $field['value'] ) ) ? $field['value'] : $value;
				$element = new $class( $field, $value, $unique );

				$element->render();

				echo '</div>';

				echo '<div class="clear"></div>';

				echo '</div>';

			} else {
				echo '<p><span class="label label-danger">Field class is not available.</span></p>';
			}
		} else {
				echo '<p><span class="label label-danger">Field type is not available.</span></p>';
		}

	}
}

/**
 *
 * Set predefined colors for reset!
 *
 * @since 1.0.0
 */
function get_predefined_colors( $skin = '' ) {

	$skin   = ( ! empty( $skin ) ) ? $skin : cs_get_option( 'skin' );
	$accent = '#e9425d';

	if ( $skin == 'accent' ) {

		$predefined_colors = array( 'accent_color' => $accent );

	} elseif ( $skin == 'custom' ) {

		$predefined_colors = array(
			// accent color
			'accent_color'               => $accent,

			// top bar
			'top_bar_bg'                 => '#f1f1f1',
			'top_bar_border'             => '#e8e8e8',
			'top_bar_text'               => '#555555',
			'top_bar_link'               => '#555555',
			'top_bar_link_hover'         => $accent,
			'top_bar_icon_color'         => '#555555',
			'top_bar_social_color'       => '#555555',
			'top_bar_social_hover'       => $accent,

			// header
			'header_bg'                  => '#ffffff',
			'header_border'              => 'rgba(255, 255, 255, 0.1)',
			'header_link'                => '#555555',
			'header_link_hover'          => $accent,

			// submenu
			'submenu_bg'                 => '#ffffff',
			'submenu_bg_hover'           => '#f8f8f8',
			'submenu_border'             => '#eeeeee',
			'submenu_link'               => '#555555',
			'submenu_link_hover'         => $accent,

			// mega-menu
			'submenu_mega_title_color'   => '#555555',
			'submenu_mega_title_bgcolor' => '#f5f5f5',
			'submenu_mega_title_border'  => '#eeeeee',

			// page-header
			'page_header_bg'             => $accent,
			'page_header_color'          => '#ffffff',
			'breadcrumb_bgcolor'         => 'rgba(0,0,0,0.5)',
			'breadcrumb_color'           => '#ffffff',
			'breadcrumb_link_color'      => '#ffffff',

			// footer
			'footer_bg'                  => '#222222',
			'footer_color'               => '#999999',
			'footer_link_color'          => '#cccccc',
			'footer_link_hover'          => '#ffffff',
			'footer_title_color'         => '#ffffff',
			'footer_border_color'        => '#444444',

			// footer before and after
			'footer_ba_bg'               => $accent,
			'footer_ba_color'            => '#ffffff',
			'footer_ba_link_color'       => '#ffffff',
			'footer_ba_link_hover'       => '#ffffff',
			'footer_ba_title_color'      => '#ffffff',
			'footer_ba_border_color'     => '#ffffff',

			// copyright
			'copyright_bg'               => '#111111',
			'copyright_color'            => '#555555',
			'copyright_link_color'       => '#555555',
			'copyright_link_hover'       => '#ffffff',

			// logo bar
			'logo_bar_bg'                => '#ffffff',
			'logo_bar_color'             => '#555555',
		);

	}

	$predefined_colors = apply_filters( 'cs_predefined_colors', $predefined_colors );

	return $predefined_colors;
}

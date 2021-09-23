<?php
/**
 *
 * Footer Social
 *
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! function_exists( 'cs_social' ) ) {

	/**
	 * Cs social
	 */
	function cs_social() {

		$options = cs_get_post_meta();

		$out = '';

		if ( ( cs_get_option( 'footer_social' ) ) ) {

			$out .= cs_footer_bar_modules( 'right' );
		}

		return $out;
	}

	add_shortcode( 'cs_social', 'cs_social' );
}

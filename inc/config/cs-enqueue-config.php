<?php

/**
 *
 * Theme Enqueue Scripts
 * @since 1.0.0
 * @version 1.1.0
 *
 */
function cs_wp_enqueue_scripts() {

	if ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) && ( false !== strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'MSIE' ) ) && ( false === strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'MSIE 9' ) ) ) {
		wp_enqueue_script( 'html5shiv', THEME_URI . '/js/iefix/html5shiv.min.js', array(), null, false );
		wp_enqueue_script( 'selectivizr', THEME_URI . '/js/iefix/selectivizr.js', array(), null, false );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


	wp_register_script( 'cs-royalslider', THEME_URI . '/js/vendor/jquery.royalslider.min.js', array( 'jquery' ), '9.5.1', true );
	wp_register_script( 'cs-caroufredsel', THEME_URI . '/js/vendor/jquery.caroufredsel.min.js', array( 'jquery' ), '6.2.1', true );
	wp_register_script( 'cs-countdown', THEME_URI . '/js/vendor/jquery.countdown.min.js', array( 'jquery' ), '2.0.0', true );

	wp_enqueue_script( 'slick', THEME_URI . '/js/slick.min.js', array( 'jquery' ), null, false );
	wp_enqueue_script( 'index-all', THEME_URI . '/js/index.all.min.js', array( 'jquery' ), null, false );
	wp_enqueue_script( 'popper', THEME_URI . '/js/popper.min.js', array( 'jquery' ), null, false );
	wp_enqueue_script( 'modernizr', THEME_URI . '/js/modernizr.min.js', array(), null, false );
        wp_enqueue_script( 'cs-fitvids', THEME_URI . '/js/vendor/jquery-fitvids.js', array( 'jquery' ), '2.0.0', true );
	wp_enqueue_script( 'cs-jquery-plugins', THEME_URI . '/js/jquery.plugins.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'cs-jquery-register', THEME_URI . '/js/jquery.register.js', array( 'jquery' ), time(), true );

	wp_localize_script( 'cs-jquery-register', 'cs_ajax', array(
		'ajaxurl'			 => admin_url( 'admin-ajax.php' ),
		'siteurl'			 => THEME_URI,
		'loved'				 => __( 'Already loved!', 'articlemag' ),
		'error'				 => __( 'Error!', 'articlemag' ),
		'nonce'				 => wp_create_nonce( 'love-it-nonce' ),
		'viewport'			 => cs_get_option( 'menu_max_width' ),
		'sticky'			 => cs_get_option( 'header_sticky' ),
		'header'			 => cs_get_option( 'header_height_sticky' ),
		'accent'			 => ( cs_get_option( 'skin' ) != 'default' ) ? cs_get_option( 'accent_color' ) : '#293951',
		'non_responsive'	 => cs_get_option( 'non_responsive' ),
		'no_smoothscroll'	 => ( cs_get_option( 'smoothscroll' ) ) ? '1' : '0',
	) );
}

add_action( 'wp_enqueue_scripts', 'cs_wp_enqueue_scripts' );

/**
 *
 * Theme Enqueue Styles
 * @since 1.0.0
 * @version 1.2.0
 *
 */
function cs_wp_enqueue_styles() {

	cs_enqueue_google_fonts();

	if ( cs_get_option( 'icomoon' ) ) {
		wp_enqueue_style( 'cs-icomoon', THEME_URI . '/css/vendor/icomoon.css', array(), null );
	}

	$cs_grid = ( cs_get_option( 'non_responsive' ) ) ? 'non-responsive' : 'grid';

	wp_register_style( 'cs-royalslider', THEME_URI . '/css/vendor/royalslider.css' );
	wp_enqueue_style( 'cs-royalslider' );

	wp_enqueue_style( 'cs-font-awesome', THEME_URI . '/css/vendor/font-awesome.css', array(), null );
	
	wp_enqueue_style( 'cs-slick', THEME_URI . '/css/vendor/slick.css', array(), null );
	
        // Theme CSS
	wp_enqueue_style( 'cs-theme', THEME_URI . '/css/theme.min.css', array(), time() );

	// BuddySress
	if ( class_exists( 'buddypress' ) && (!articlemag_is_active_plugin( 'youzer/youzer.php' )) ) {
		wp_enqueue_style( 'cs-buddypress', THEME_URI . '/css/cs-buddypress.min.css', array(), time() );
	}
        
        // youzer
        if( articlemag_is_active_plugin( 'youzer/youzer.php' ) ) {
            wp_enqueue_style( 'cs-youzer', THEME_URI . '/css/cs-youzer.min.css', array(), time() );
        }
        
        // BB Platform
	if ( articlemag_is_active_plugin( 'buddyboss-platform/bp-loader.php' ) ) {
		wp_enqueue_style( 'cs-bb-platform', THEME_URI . '/css/bb-platform.min.css', array(), time() );
	}
        
        // Forums
	if ( class_exists( 'bbPress' ) ) {
		wp_enqueue_style( 'cs-bbpress', THEME_URI . '/css/bbpress.min.css', array(), null );
	}

	// Dark Mode
	if ( cs_get_option( 'dark_mode' ) ) {
		wp_enqueue_style( 'cs-dark-mode', THEME_URI . '/css/vendor/dark-mode.css' );
	}

	if ( is_rtl() ) {
		wp_enqueue_style( 'cs-rtl', THEME_URI . '/css/vendor/rtl.css', array(), null );
	}

	if ( cs_get_option( 'cache_css' ) && is_writable( THEME_CACHE_DIR ) && empty( $_POST[ 'wp_customize' ] ) ) {

		$already_cached = get_option( CACHED_OPTION_NAME );
		if ( !$already_cached ) {
			cs_cache_css_file();
		}

		global $blog_id;
		$is_multisite_active = ( is_multisite() ) ? '-' . $blog_id : '';
		wp_enqueue_style( 'cs-custom', THEME_URI . '/cache/custom-style' . $is_multisite_active . '.css', array(), null );
	} else {
		add_action( 'wp_head', 'cs_custom_css', 99 );
	}

	if ( is_child_theme() ) {
		wp_enqueue_style( 'articlemag', get_stylesheet_uri() );
	}
}

add_action( 'wp_enqueue_scripts', 'cs_wp_enqueue_styles' );


/**
 *
 * Enqueue Inline Styles
 * @since 1.0.0
 * @version 1.0.1
 *
 */
if ( !function_exists( 'cs_enqueue_inline_styles' ) ) {

	function cs_enqueue_inline_styles() {

		global $cs_inline_styles;

		if ( !empty( $cs_inline_styles ) ) {
			echo '<style type="text/css">' . cs_css_compress( join( '', $cs_inline_styles ) ) . '</style>';
			$cs_inline_styles = array();
		}
	}

	add_action( 'wp_footer', 'cs_enqueue_inline_styles' );
}


/**
 *
 * If cache folder is not writable
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( !function_exists( 'cs_custom_css' ) ) {

	function cs_custom_css() {

		echo '<style type="text/css">';
		$output	 = cs_get_custom_style();
		$output	 .= cs_get_custom_skin();
		$output	 .= cs_get_woocoomerce_style();
		$output	 .= cs_get_option( 'custom_css' );
		echo cs_css_compress( $output );
		do_action( 'cs_add_custom_css' );
		echo '</style>' . "\n";
	}

}

/**
 *
 * If cache folder is writable create skin.css
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( !function_exists( 'cs_cache_css_file' ) ) {

	function cs_cache_css_file() {

		if ( is_multisite() ) {
			global $blog_id;
			$output_file = THEME_CACHE_DIR . '/custom-style-' . $blog_id . '.css';
		} else {
			$output_file = THEME_CACHE_DIR . '/custom-style.css';
		}

		$banner	 = "/**\n";
		$banner	 .= " * Do not touch this file! This file created by PHP\n";
		$banner	 .= " * Last modifiyed time: " . date( 'M d Y, h:s:i' ) . "\n";
		$banner	 .= " */\n";

		$output	 = cs_get_custom_style();
		$output	 .= "\n\n";
		$output	 .= cs_get_custom_skin();
		$output	 .= cs_get_woocoomerce_style();
		$output	 .= cs_get_option( 'custom_css' );
		$output	 = $banner . cs_css_compress( $output );

		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		WP_Filesystem();
		global $wp_filesystem;

		if ( !$wp_filesystem->put_contents( $output_file, $output, FS_CHMOD_FILE ) ) {
			update_option( CACHED_OPTION_NAME, false );
		} else {
			update_option( CACHED_OPTION_NAME, true );
		}
	}

}
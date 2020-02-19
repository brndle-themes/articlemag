<?php

//
// Add LearnDash Support
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_learndash_support' ) ) {

	function cs_learndash_support() {
		add_theme_support( 'sfwd-lms' );
	}

	add_action( 'after_setup_theme', 'cs_learndash_support' );
}

//
// Add Articlemag LearnDash Main Style
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_learndash_style' ) ) {

	function cs_learndash_style() {
		if ( !is_plugin_active( 'design-upgrade-pro-learndash/design-upgrade-pro-learndash.php' ) ) {
			wp_enqueue_style( 'cs-learndash', THEME_URI . '/css/vendor/learndash.css', array(), time() );
		}

		wp_enqueue_style( 'cs-base-learndash', THEME_URI . '/css/vendor/base-learndash.css', array(), time() );
	}

	add_action( 'wp_enqueue_scripts', 'cs_learndash_style' );
}
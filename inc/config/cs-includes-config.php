<?php

/**
 *
 * Load all of shortcode from folder
 * @since 1.0.0
 * @version 1.1.0
 *
 */
//
// Require plugin.php to use is_plugin_active() below
// ----------------------------------------------------------------------------------------------------
if ( !function_exists( 'is_plugin_active' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

//
// Load Shortcodes
// ----------------------------------------------------------------------------------------------------
foreach ( glob( FRAMEWORK_INCLUDE_DIR . '/shortcodes/cs_*.php' ) as $shortcode ) {
	locate_template( 'inc/includes/shortcodes/' . basename( $shortcode ), true );
}

//
// Custom Style Adapted
// ----------------------------------------------------------------------------------------------------
locate_template( 'inc/includes/custom-style.php', true );

//
// woocommerce integration
// ----------------------------------------------------------------------------------------------------
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	locate_template( 'inc/plugins/woocommerce/woocommerce-config.php', true );
}


//
// TGM integration
// ----------------------------------------------------------------------------------------------------
locate_template( 'inc/plugins/tgm-plugin-activation/tgm-articlemag-plugins.php', true );

//
// BuddyPress Integration
// ----------------------------------------------------------------------------------------------------
if ( class_exists( 'BuddyPress' ) ) {
	locate_template( 'inc/plugins/buddypress/buddypress-config.php', true );
}

//
// Articlemag Theme Check
// ----------------------------------------------------------------------------------------------------
//$purchase_code = cs_get_option( 'purchase_code' );
//if ( !empty( $purchase_code ) ) {
//	locate_template( 'inc/plugins/articlemag-theme-updater/articlemag-theme-updater.php', true );
//}

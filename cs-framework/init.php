<?php

/**
 *
 * Codestar Framework
 *
 * @author Codestar
 * @license Commercial License
 * @link http://codestar.me
 * @copyright 2014 Codestar Themes
 * @since 1.0.0
 * @version 1.7.0
 *
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

defined( 'THEME_DIR' ) or define( 'THEME_DIR', get_template_directory() );
defined( 'THEME_URI' ) or define( 'THEME_URI', get_template_directory_uri() );
defined( 'THEME_VERSION' ) or define( 'THEME_VERSION', '1.0.0' );
defined( 'THEME_CACHE_DIR' ) or define( 'THEME_CACHE_DIR', THEME_DIR . '/cache' );
defined( 'THEME_CACHE_URI' ) or define( 'THEME_CACHE_URI', THEME_URI . '/cache' );
defined( 'FRAMEWORK_DIR' ) or define( 'FRAMEWORK_DIR', THEME_DIR . '/cs-framework' );
defined( 'FRAMEWORK_URI' ) or define( 'FRAMEWORK_URI', THEME_URI . '/cs-framework' );
defined( 'FRAMEWORK_ASSETS' ) or define( 'FRAMEWORK_ASSETS', THEME_URI . '/cs-framework/assets' );
defined( 'FRAMEWORK_INCLUDE_DIR' ) or define( 'FRAMEWORK_INCLUDE_DIR', THEME_DIR . '/cs-framework/includes' );
defined( 'FRAMEWORK_INCLUDE_URI' ) or define( 'FRAMEWORK_INCLUDE_URI', THEME_URI . '/cs-framework/includes' );
defined( 'FRAMEWORK_PLUGIN_DIR' ) or define( 'FRAMEWORK_PLUGIN_DIR', THEME_DIR . '/cs-framework/plugins' );
defined( 'FRAMEWORK_PLUGIN_URI' ) or define( 'FRAMEWORK_PLUGIN_URI', THEME_URI . '/cs-framework/plugins' );
defined( 'FRAMEWORK_OPTION_NAME' ) or define( 'FRAMEWORK_OPTION_NAME', 'framework_option' );
defined( 'CUSTOMIZE_OPTION_NAME' ) or define( 'CUSTOMIZE_OPTION_NAME', 'customize_option' );
defined( 'CACHED_OPTION_NAME' ) or define( 'CACHED_OPTION_NAME', 'cs_skin_cached' );

// base classes
locate_template( 'cs-framework/classes/cs-framework-helpers-api.php', true );
locate_template( 'cs-framework/classes/cs-framework-abstract.class.php', true );
locate_template( 'cs-framework/classes/cs-framework-mega-menu-api.php', true );
locate_template( 'cs-framework/classes/cs-framework-sidebars-api.php', true );
locate_template( 'cs-framework/classes/cs-framework-customize-api.php', true );
locate_template( 'cs-framework/classes/cs-framework.class.php', true );

// is admin init
function is_admin_init() {

	// admin class
	locate_template( 'cs-framework/classes/cs-framework-actions-api.php', true );
	locate_template( 'cs-framework/classes/cs-framework-enqueue-api.php', true );
	locate_template( 'cs-framework/classes/cs-framework-options-api.php', true );
	locate_template( 'cs-framework/classes/cs-framework-metabox-api.php', true );

	// admin config
	locate_template( 'cs-framework/config/cs-metabox-config.php', true );
}

add_action( 'admin_init', 'is_admin_init' );

// theme config
locate_template( 'cs-framework/config/cs-helper-functions.php', true );
locate_template( 'cs-framework/config/cs-actions-config.php', true );
locate_template( 'cs-framework/config/cs-filters-config.php', true );
locate_template( 'cs-framework/config/cs-framework-config.php', true );
locate_template( 'cs-framework/config/cs-enqueue-config.php', true );
locate_template( 'cs-framework/config/cs-customize-config.php', true );
locate_template( 'cs-framework/config/cs-includes-config.php', true );
locate_template( 'cs-framework/config/cs-post-formats-helper.php', true );
locate_template( 'cs-framework/config/cs-front-end-functions.php', true );
locate_template( 'cs-framework/config/cs-widgets-config.php', true );

require_once get_parent_theme_file_path( '/cs-framework/merlin/vendor/autoload.php' );
require_once get_parent_theme_file_path( '/cs-framework/merlin/class-merlin.php' );
require_once get_parent_theme_file_path( '/cs-framework/config/merlin-config.php' );



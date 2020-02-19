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
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'THEME_DIR' ) or define( 'THEME_DIR', get_template_directory() );
defined( 'THEME_URI' ) or define( 'THEME_URI', get_template_directory_uri() );
defined( 'THEME_VERSION' ) or define( 'THEME_VERSION', '1.0.0' );
defined( 'THEME_CACHE_DIR' ) or define( 'THEME_CACHE_DIR', THEME_DIR . '/cache' );
defined( 'THEME_CACHE_URI' ) or define( 'THEME_CACHE_URI', THEME_URI . '/cache' );
defined( 'FRAMEWORK_DIR' ) or define( 'FRAMEWORK_DIR', THEME_DIR . '/inc' );
defined( 'FRAMEWORK_URI' ) or define( 'FRAMEWORK_URI', THEME_URI . '/inc' );
defined( 'FRAMEWORK_ASSETS' ) or define( 'FRAMEWORK_ASSETS', THEME_URI . '/inc/assets' );
defined( 'FRAMEWORK_INCLUDE_DIR' ) or define( 'FRAMEWORK_INCLUDE_DIR', THEME_DIR . '/inc/includes' );
defined( 'FRAMEWORK_INCLUDE_URI' ) or define( 'FRAMEWORK_INCLUDE_URI', THEME_URI . '/inc/includes' );
defined( 'FRAMEWORK_PLUGIN_DIR' ) or define( 'FRAMEWORK_PLUGIN_DIR', THEME_DIR . '/inc/plugins' );
defined( 'FRAMEWORK_PLUGIN_URI' ) or define( 'FRAMEWORK_PLUGIN_URI', THEME_URI . '/inc/plugins' );
defined( 'FRAMEWORK_OPTION_NAME' ) or define( 'FRAMEWORK_OPTION_NAME', 'articlemag_theme_options' );
defined( 'CUSTOMIZE_OPTION_NAME' ) or define( 'CUSTOMIZE_OPTION_NAME', 'customize_option' );
defined( 'CACHED_OPTION_NAME' ) or define( 'CACHED_OPTION_NAME', 'cs_skin_cached' );



// Codestar Framework.
require_once THEME_DIR . '/inc/cs-framework/codestar-framework.php';

// theme config
locate_template( 'inc/config/cs-helper-functions.php', true );
locate_template( 'inc/config/cs-actions-config.php', true );
locate_template( 'inc/config/cs-filters-config.php', true );
locate_template( 'inc/config/cs-enqueue-config.php', true );
locate_template( 'inc/config/cs-customize-config.php', true );
locate_template( 'inc/config/cs-includes-config.php', true );
locate_template( 'inc/config/cs-post-formats-helper.php', true );
locate_template( 'inc/config/cs-front-end-functions.php', true );
// locate_template( 'inc/config/cs-widgets-config.php', true );


// base classes
// locate_template( 'inc/classes/cs-framework-abstract.class.php', true );
locate_template( 'inc/classes/class-cs-mega-menu-api.php', true );
locate_template( 'inc/classes/class-cs-customizer-helper.php', true );
locate_template( 'inc/classes/classs-cs-enequeue-api.php', true );
locate_template( 'inc/classes/class-cs-sidebar-api.php', true );


require_once get_parent_theme_file_path( '/inc/options/class-cs-theme-options.php' );
require_once get_parent_theme_file_path( '/inc/options/class-cs-customizer-options.php' );
require_once get_parent_theme_file_path( '/inc/options/class-cs-metabox-options.php' );
require_once get_parent_theme_file_path( '/inc/options/class-cs-widget-options.php' );
require_once get_parent_theme_file_path( '/inc/merlin/vendor/autoload.php' );
require_once get_parent_theme_file_path( '/inc/merlin/class-merlin.php' );
require_once get_parent_theme_file_path( '/inc/config/merlin-config.php' );

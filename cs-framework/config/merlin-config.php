<?php

/**
 * Merlin WP configuration file.
 *
 * @package   Merlin WP
 * @version   @@pkg.version
 * @link      https://merlinwp.com/
 * @author    Rich Tabor, from ThemeBeans.com & the team at ProteusThemes.com
 * @copyright Copyright (c) 2018, Merlin WP of Inventionn LLC
 * @license   Licensed GPLv3 for Open Source Use
 */
if ( !class_exists( 'Merlin' ) ) {
	return;
}

/**
 * Set directory locations, text strings, and settings.
 */
$wizard	 = new Merlin(
 $config	 = array(
	'directory'				 => 'cs-framework/merlin', // Location / directory where Merlin WP is placed in your theme.
	'merlin_url'			 => 'articlemag-sample-demo-import', // The wp-admin page slug where Merlin WP loads.
	'parent_slug'			 => 'themes.php', // The wp-admin parent page slug for the admin menu item.
	'capability'			 => 'manage_options', // The capability required for this menu to be displayed to the user.
	'child_action_btn_url'	 => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
	'dev_mode'				 => true, // Enable development mode for testing.
	'license_step'			 => false, // EDD license activation step.
	'license_required'		 => false, // Require the license activation step.
	'license_help_url'		 => '', // URL for the 'license-tooltip'.
	'edd_remote_api_url'	 => '', // EDD_Theme_Updater_Admin remote_api_url.
	'edd_item_name'			 => '', // EDD_Theme_Updater_Admin item_name.
	'edd_theme_slug'		 => '', // EDD_Theme_Updater_Admin item_slug.
	'ready_big_button_url'	 => site_url( '' ), // Link for the big button on the ready step.
), $strings = array(
	'admin-menu'				 => esc_html__( 'Theme Setup', 'articlemag' ),
	/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
	'title%s%s%s%s'				 => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'articlemag' ),
	'return-to-dashboard'		 => esc_html__( 'Return to the dashboard', 'articlemag' ),
	'ignore'					 => esc_html__( 'Disable this wizard', 'articlemag' ),
	'btn-skip'					 => esc_html__( 'Skip', 'articlemag' ),
	'btn-next'					 => esc_html__( 'Next', 'articlemag' ),
	'btn-start'					 => esc_html__( 'Start', 'articlemag' ),
	'btn-no'					 => esc_html__( 'Cancel', 'articlemag' ),
	'btn-plugins-install'		 => esc_html__( 'Install', 'articlemag' ),
	'btn-child-install'			 => esc_html__( 'Install', 'articlemag' ),
	'btn-content-install'		 => esc_html__( 'Install', 'articlemag' ),
	'btn-import'				 => esc_html__( 'Import', 'articlemag' ),
	'btn-license-activate'		 => esc_html__( 'Activate', 'articlemag' ),
	'btn-license-skip'			 => esc_html__( 'Later', 'articlemag' ),
	/* translators: Theme Name */
	'license-header%s'			 => esc_html__( 'Activate %s', 'articlemag' ),
	/* translators: Theme Name */
	'license-header-success%s'	 => esc_html__( '%s is Activated', 'articlemag' ),
	/* translators: Theme Name */
	'license%s'					 => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'articlemag' ),
	'license-label'				 => esc_html__( 'License key', 'articlemag' ),
	'license-success%s'			 => esc_html__( 'The theme is already registered, so you can go to the next step!', 'articlemag' ),
	'license-json-success%s'	 => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'articlemag' ),
	'license-tooltip'			 => esc_html__( 'Need help?', 'articlemag' ),
	/* translators: Theme Name */
	'welcome-header%s'			 => esc_html__( 'Welcome to %s', 'articlemag' ),
	'welcome-header-success%s'	 => esc_html__( 'Hi. Welcome back', 'articlemag' ),
	'welcome%s'					 => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'articlemag' ),
	'welcome-success%s'			 => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'articlemag' ),
	'child-header'				 => esc_html__( 'Install Child Theme', 'articlemag' ),
	'child-header-success'		 => esc_html__( 'You\'re good to go!', 'articlemag' ),
	'child'						 => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'articlemag' ),
	'child-success%s'			 => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'articlemag' ),
	'child-action-link'			 => esc_html__( 'Learn about child themes', 'articlemag' ),
	'child-json-success%s'		 => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'articlemag' ),
	'child-json-already%s'		 => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'articlemag' ),
	'plugins-header'			 => esc_html__( 'Install Plugins', 'articlemag' ),
	'plugins-header-success'	 => esc_html__( 'You\'re up to speed!', 'articlemag' ),
	'plugins'					 => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'articlemag' ),
	'plugins-success%s'			 => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'articlemag' ),
	'plugins-action-link'		 => esc_html__( 'Advanced', 'articlemag' ),
	'import-header'				 => esc_html__( 'Import Content', 'articlemag' ),
	'import'					 => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'articlemag' ),
	'import-action-link'		 => esc_html__( 'Advanced', 'articlemag' ),
	'ready-header'				 => esc_html__( 'All done. Have fun!', 'articlemag' ),
	/* translators: Theme Author */
	'ready%s'					 => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'articlemag' ),
	'ready-action-link'			 => esc_html__( 'Extras', 'articlemag' ),
	'ready-big-button'			 => esc_html__( 'View your website', 'articlemag' ),
	'ready-link-1'				 => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__( 'Explore WordPress', 'articlemag' ) ),
	'ready-link-2'				 => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://themebeans.com/contact/', esc_html__( 'Get Theme Support', 'articlemag' ) ),
	'ready-link-3'				 => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'articlemag' ) ),
)
);

function articlemag_import_files() {
	return array(
		array(
			'import_file_name'				 => 'Articlemag',
			'import_file_url'				 => get_template_directory_uri() . '/cs-framework/merlin/demos/articlemag/demo-content.xml',
			'import_widget_file_url'		 => get_template_directory_uri() . '/cs-framework/merlin/demos/articlemag/widgets.json',
			'import_customizer_file_url'	 => get_template_directory_uri() . '/cs-framework/merlin/demos/articlemag/customizer.dat',
			'import_cs_framework_file_url'	 => get_template_directory_uri() . '/cs-framework/merlin/demos/articlemag/theme-option.txt',
			'import_redux'					 => array(),
			'import_preview_image_url'		 => 'https://www.example.com/merlin/preview_import_image1.jpg',
			'import_notice'					 => __( 'A special note for this import.', 'articlemag' ),
			'preview_url'					 => 'https://www.example.com/my-demo-1',
		),
	);
}

add_filter( 'merlin_import_files', 'articlemag_import_files' );

/* remove Admin init function on Theme Setup wizard start */
add_action( 'admin_init', 'articlemag_remove_admin_init', 0 );

function articlemag_remove_admin_init() {
	if ( isset( $_GET[ 'page' ] ) && ( $_GET[ 'page' ] == 'articlemag-sample-demo-import' || $_GET[ 'page' ] == 'tgmpa-install-plugins' ) ) {
		remove_action( 'admin_init', 'is_admin_init' );
		add_filter( 'woocommerce_enable_setup_wizard', function() {
			return false;
		} );
		update_option( 'wpforms_activation_redirect', true );
		if ( did_action( 'elementor/loaded' ) ) {
			remove_action( 'admin_init', [ \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ] );
		}
	}
}

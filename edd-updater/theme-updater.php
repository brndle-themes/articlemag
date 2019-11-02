<?php

/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */
// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Articlemag_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}
// Loads the updater classes
$updater = new EDD_Articlemag_Theme_Updater_Admin(
 // Config settings
$config	 = array(
	'remote_api_url' => 'https://brndle.com/', // Site where EDD is hosted
	'item_name'		 => 'ArticleMag', // Name of theme
	'theme_slug'	 => 'articlemag', // Theme slug
	'version'		 => THEME_VERSION, // The current version of this theme
	'author'		 => 'brndleteam', // The author of this theme
	'download_id'	 => '', // Optional, used for generating a license renewal link
	'renew_url'		 => '', // Optional, allows for a custom license renewal link
	'beta'			 => false, // Optional, set to true to opt into beta versions
),
 // Strings
$strings = array(
	'theme-license'				 => __( 'Theme License', 'articlemag' ),
	'enter-key'					 => __( 'Enter your theme license key.', 'articlemag' ),
	'license-key'				 => __( 'License Key', 'articlemag' ),
	'license-action'			 => __( 'License Action', 'articlemag' ),
	'deactivate-license'		 => __( 'Deactivate License', 'articlemag' ),
	'activate-license'			 => __( 'Activate License', 'articlemag' ),
	'status-unknown'			 => __( 'License status is unknown.', 'articlemag' ),
	'renew'						 => __( 'Renew?', 'articlemag' ),
	'unlimited'					 => __( 'unlimited', 'articlemag' ),
	'license-key-is-active'		 => __( 'License key is active.', 'articlemag' ),
	'expires%s'					 => __( 'Expires %s.', 'articlemag' ),
	'expires-never'				 => __( 'Lifetime License.', 'articlemag' ),
	'%1$s/%2$-sites'			 => __( 'You have %1$s / %2$s sites activated.', 'articlemag' ),
	'license-key-expired-%s'	 => __( 'License key expired %s.', 'articlemag' ),
	'license-key-expired'		 => __( 'License key has expired.', 'articlemag' ),
	'license-keys-do-not-match'	 => __( 'License keys do not match.', 'articlemag' ),
	'license-is-inactive'		 => __( 'License is inactive.', 'articlemag' ),
	'license-key-is-disabled'	 => __( 'License key is disabled.', 'articlemag' ),
	'site-is-inactive'			 => __( 'Site is inactive.', 'articlemag' ),
	'license-status-unknown'	 => __( 'License status is unknown.', 'articlemag' ),
	'update-notice'				 => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'articlemag' ),
	'update-available'			 => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'articlemag' ),
)
);

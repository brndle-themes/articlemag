<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Articlemag_Customizer_Options
 * Cretae theme customizer options.
 *
 * @var [type]
 */

if ( ! class_exists( 'Articlemag_Customizer_Options' ) ) {

	class Articlemag_Customizer_Options {

		// Hold the class instance.
		private static $instance = null;

		/**
		 * Set a unique slug-like ID
		 */
		public $prefix = CUSTOMIZE_OPTION_NAME;

		/**
		 * Articlemag_Customizer_Options constructor.
		 */
		private function __construct() {
				$this->includes();
				$this->configure_configuration_option();
				$this->configuration_option_sections();
				add_action( 'wp_ajax_cs-reset-customize', array( $this, 'reset' ), 99 );
		}

		/**
		 * @return Articlemag_Customizer_Options
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}


		public function includes() {
			require_once get_parent_theme_file_path( 'inc/config/cs-customize-config.php' );
		}

		public function configure_configuration_option() {
			// Control core classes for avoid errors.
			if ( class_exists( 'CSF' ) ) {
				CSF::createCustomizeOptions(
					$this->prefix,
					array(
						'database'        => 'option',
						'transport'       => 'refresh',
						'capability'      => 'manage_options',
						'save_defaults'   => true,
						'enqueue_webfont' => true,
						'async_webfont'   => false,
						'output_css'      => true,
					)
				);

			}
		}

		public function configuration_option_sections() {
			if ( class_exists( 'CSF' ) ) {
				$skin = cs_get_option( 'skin' );
				if ( ! empty( $skin ) && $skin == 'accent' ) {
					$tabs = articlemag_customizer_sections();
					foreach ( $tabs as $key => $tab ) {
						CSF::createSection(
							$this->prefix,
							$tab
						);
					}
				} elseif ( ! empty( $skin ) && $skin == 'custom' ) {
					$tabs = articlemag_customizer_sections();
					foreach ( $tabs as $key => $tab ) {
						CSF::createSection(
							$this->prefix,
							$tab
						);
					}
				}
			}
		}
/**
 *
 * Reset Customize Settings
 *
 * @since 1.0.0
 * @version 1.0.0
 */
public function reset() {
	delete_option( CUSTOMIZE_OPTION_NAME );
	update_option( CACHED_OPTION_NAME, false );
	die();
		}
	}
}

/**
 * Main instance of Articlemag_Customizer_Options.
 *
 * @return Articlemag_Customizer_Options
 */
Articlemag_Customizer_Options::instance();

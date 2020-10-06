<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Articlemag_Theme_Options' ) ) {

	class Articlemag_Theme_Options {

		/**
		 * @var null
		 */
		private static $instance = null;

		public $prefix = FRAMEWORK_OPTION_NAME;

		/**
		 * Articlemag_Theme_Options constructor.
		 */
		private function __construct() {
				$this->includes();
				$this->configure_theme_option();
				$this->option_sections();
		}

		/**
		 * @return Articlemag_Theme_Options|null
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}


		public function includes() {
			require_once get_parent_theme_file_path( '/inc/config/cs-framework-option-section.php' );
		}

		public function configure_theme_option() {
			// Control core classes for avoid errors.
			if ( class_exists( 'CSF' ) ) {

				// Create options.
				CSF::createOptions(
					$this->prefix,
					array(
						// framework title.
						'framework_title'         => 'ArticleMag Option <small>by BRNDLE</small>',
						'framework_class'         => '',

						// menu settings.
						'menu_title'              => 'ArticleMag',
						'menu_slug'               => $this->prefix,
						'menu_type'               => 'menu',
						'menu_capability'         => 'manage_options',
						'menu_icon'               => 'dashicons-admin-customizer',
						'menu_position'           => null,
						'menu_hidden'             => false,

						// menu extras.
						'show_bar_menu'           => true,
						'show_sub_menu'           => true,
						'show_network_menu'       => true,
						'show_in_customizer'      => false,

						'show_search'             => false,
						'show_reset_all'          => true,
						'show_reset_section'      => true,
						'show_footer'             => true,
						'show_all_options'        => true,
						'show_form_warning'       => true,
						'sticky_header'           => true,
						'save_defaults'           => true,
						'ajax_save'               => true,

						// admin bar menu settings.
						'admin_bar_menu_icon'     => 'dashicons-admin-customizer',
						'admin_bar_menu_priority' => 80,

						// footer.
						'footer_text'             => 'The Theme Options is created by BRNDLE',
						'footer_after'            => '',
						'footer_credit'           => 'Design and Developed by <a href="https://brndle.com/" target="_blank">BRNDLE</a>',
						// database model.
						'database'                => 'options',
						// typography options.
						'enqueue_webfont'         => true,
						'async_webfont'           => false,

						// others.
						'output_css'              => true,

						// theme and wrapper classname.
						'theme'                   => 'dark',
						'class'                   => '',
					)
				);
			}
		}

		public function option_sections() {
			if ( class_exists( 'CSF' ) ) {
				$tabs = articlemag_option_sections();
				foreach ( $tabs as $key => $tab ) {
					CSF::createSection(
						$this->prefix,
						$tab
					);
				}
			}
		}
	}
}

/**
 * Main instance of Articlemag_Theme_Options.
 *
 * @return Articlemag_Theme_Options
 */
Articlemag_Theme_Options::instance();

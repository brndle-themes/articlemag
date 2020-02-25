<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Articlemag_MetaBox_Options
 * Cretae theme customizer options.
 *
 * @var [type]
 */

if ( ! class_exists( 'Articlemag_MetaBox_Options' ) ) {

	class Articlemag_MetaBox_Options {

		// Hold the class instance.
		private static $instance = null;

		/**
		 * Set a unique slug-like ID
		 */
		public $prefix = '_custom_page_options';

		public $side_prefix = '_side_custom_page_options';

		public $side_featured_prefix = 'meta-checkbox';

		/**
		 * Articlemag_MetaBox_Options constructor.
		 */
		private function __construct() {
				$this->includes();
				$this->configure_metabox_option();
				$this->metabox_option_sections();
				$this->side_metabox_option_sections();
		}

		/**
		 * @return Articlemag_MetaBox_Options
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * [Include Option fields]
		 */
		public function includes() {
			require_once get_parent_theme_file_path( '/inc/config/cs-metabox-config.php' );
		}

		/**
		 * [configure_metabox_option description] Create meta Boxes.
		 */
		public function configure_metabox_option() {
					// Control core classes for avoid errors.
			if ( class_exists( 'CSF' ) ) {
				CSF::createMetabox(
					$this->prefix,
					array(
						'title'              => 'Custom Options',
						'post_type'          => array( 'post', 'page', 'product', 'sfwd-courses', 'sfwd-lessons', 'sfwd-topic', 'sfwd-quiz', 'sfwd-certificates', 'sfwd-assignment', 'sfwd-groups' ),
						'data_type'          => 'serialize',
						'context'            => 'advanced',
						'priority'           => 'default',
						'exclude_post_types' => array(),
						'page_templates'     => '',
						'post_formats'       => '',
						'show_restore'       => true,
						'enqueue_webfont'    => true,
						'async_webfont'      => false,
						'output_css'         => true,
						'theme'              => 'dark',
						'class'              => '',
					)
				);

				CSF::createMetabox(
					$this->side_prefix,
					array(
						'title'              => 'Side Bar Model',
						'post_type'          => array( 'post', 'page', 'product', 'sfwd-courses', 'sfwd-lessons', 'sfwd-topic', 'sfwd-quiz', 'sfwd-certificates', 'sfwd-assignment', 'sfwd-groups' ),
						'data_type'          => 'serialize',
						'context'            => 'side',
						'priority'           => 'default',
						'exclude_post_types' => array(),
						'page_templates'     => '',
						'post_formats'       => '',
					)
				);

				CSF::createMetabox(
					$this->side_featured_prefix,
					array(
						'title'              => 'Featured Post',
						'post_type'          => 'post',
						'data_type'          => 'unserialize',
						'context'            => 'side',
						'priority'           => 'default',
						'exclude_post_types' => array(),
						'page_templates'     => '',
						'post_formats'       => '',
					)
				);
			}
		}

		/**
		 * [metabox_option_sections description] Advance Page MetaBox
		 */
		public function metabox_option_sections() {
			if ( class_exists( 'CSF' ) ) {
				$tabs = articlemag_metabox_sections();
				foreach ( $tabs as $key => $tab ) {
					CSF::createSection(
						$this->prefix,
						$tab
					);
				}
			}
		}

		/**
		 * [side_metabox_option_sections description] Side page meta box
		 */
		public function side_metabox_option_sections() {

					$sidebars = array(
						'left'  => FRAMEWORK_URI . '/config/sidebars/sidebar_left.png',
						'right' => FRAMEWORK_URI . '/config/sidebars/sidebar_right.png',
						'full'  => FRAMEWORK_URI . '/config/sidebars/sidebar_full.png',
						'fluid' => FRAMEWORK_URI . '/config/sidebars/sidebar_fluid.png',
					);

					global $wp_registered_sidebars;
					$sidebar_widgets = array();

					if ( ! empty( $wp_registered_sidebars ) ) {
						foreach ( $wp_registered_sidebars as $key => $value ) {
							$sidebar_widgets[ $key ] = $value['name'];
						}
					}
					if ( class_exists( 'CSF' ) ) {
						CSF::createSection(
							$this->side_prefix,
							array(
								'title'  => 'Sidebar',
								'fields' => array(
									array(
										'id'         => 'sidebar',
										'type'       => 'image_select',
										'options'    => $sidebars,
										'default'    => array( 'right' ),
										'attributes' => array(
											'data-depend-id' => 'page_sidebars',
										),
									),
									array(
										'id'          => 'sidebar_widget',
										'type'        => 'select',
										'options'     => array_reverse( $sidebar_widgets ),
										'default'     => 'sidebar-1',
										'placeholder' => 'Choose a custom sidebar',
										'dependency'  => array( 'page_sidebars', 'any', 'right,left' ),
									),
								),

							)
						);

						CSF::createSection(
							$this->side_featured_prefix,
							array(								
								'fields' => array(
									array(
										'id'         => $this->side_featured_prefix,
										'type'       => 'checkbox',
										'label'   => 'Featured this post ',
										'default' => false,
									),
								),

							)
						);
					}

		}
	}
}

/**
 * Main instance of Articlemag_MetaBox_Options.
 *
 * @return Articlemag_MetaBox_Options
 */
Articlemag_MetaBox_Options::instance();

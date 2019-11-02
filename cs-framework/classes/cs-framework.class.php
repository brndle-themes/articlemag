<?php

/**
 *
 * CSFramework Main Class
 * @since 1.0.0
 * @version 1.1.0
 *
 */
class CSFramework extends CSFramework_Abstract {

	var $unique		 = FRAMEWORK_OPTION_NAME;
	var $tabs		 = array();
	var $sections	 = array();
	var $options		 = array();
	var $menu_type	 = 'add_menu_page';
	var $menu_title	 = 'ArticleMag';
	var $menu_slug	 = 'articlemag';
	var $ajax		 = false;
	var $sticky		 = false;

	public function __construct( $sections = array(), $tabs = array() ) {

		$this->tabs		 = $tabs;
		$this->tabs		 = apply_filters( 'csframework_tabs', $tabs );
		$this->sections	 = apply_filters( 'csframework_sections', $sections );
		$this->options	 = cs_get_all_option();

		$this->addAction( 'admin_init', 'init' );
		$this->addAction( 'admin_menu', 'menu' );
		$this->addAction( 'wp_ajax_cs-export-options', 'export', 99 );
	}

	/**
	 *
	 * Init Defaults and Register Settings
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 */
	public function init() {

		$defaults = array();

		foreach ( $this->sections as $section_key => $section ) {

			register_setting( $this->unique . '_group', $this->unique, array( &$this, 'validate_save' ) );

			if ( isset( $section[ 'fields' ] ) ) {

				add_settings_section( $section_key . '_section', $section[ 'title' ], '', $section_key . '_section_group' );

				foreach ( $section[ 'fields' ] as $field_key => $field ) {

					add_settings_field( $field_key . '_field', '', array( &$this, 'field_callback' ), $section_key . '_section_group', $section_key . '_section', $field );

					//
					// Set Default
					// ---------------------------------
					if ( isset( $field[ 'default' ] ) ) {
						$defaults[ $field[ 'id' ] ] = $field[ 'default' ];
						if ( !empty( $this->options ) && !isset( $this->options[ $field[ 'id' ] ] ) ) {
							$this->options[ $field[ 'id' ] ] = $field[ 'default' ];
						}
					}
				}
			}
		}

		//
		// set defaults if empty options and not empty defaults
		// ---------------------------------------------------------------------------------------------
		if ( empty( $this->options ) && !empty( $defaults ) ) {
			update_option( $this->unique, $defaults );
			$this->options = $defaults;
		}
	}

	/**
	 *
	 * Section fields validate in save
	 * @since 1.0.0
	 * @version 1.1.0
	 *
	 */
	public function validate_save( $request ) {

		update_option( CACHED_OPTION_NAME, false );

		$request = apply_filters( 'cs_framework_save', $request, $this->options );

		if ( isset( $request[ '_nonce' ] ) ) {
			unset( $request[ '_nonce' ] );
		}

		if ( isset( $request[ 'import' ] ) && !empty( $request[ 'import' ] ) ) {
			$decode_string = cs_decode_string( $request[ 'import' ] );
			if ( is_array( $decode_string ) ) {
				return $decode_string[ 'framework_options' ];
			}
		}

		if ( isset( $request[ 'resetall' ] ) ) {
			return;
		}

		if ( isset( $request[ 'reset' ] ) ) {

			foreach ( $this->sections[ $request[ 'reset-section' ] ][ 'fields' ] as $field ) {

				if ( isset( $field[ 'default' ] ) ) {
					$request[ $field[ 'id' ] ] = $field[ 'default' ];
				} else {
					unset( $request[ $field[ 'id' ] ] );
				}
			}
		}

		foreach ( $this->sections as $k => $section ) {
			if ( isset( $section[ 'fields' ] ) ) {
				foreach ( $section[ 'fields' ] as $field ) {
					if ( isset( $field[ 'type' ] ) && ( $field[ 'type' ] == 'checkbox' || $field[ 'type' ] == 'image_select' || $field[ 'type' ] == 'on_off' || $field[ 'type' ] == 'group' ) ) {

						if ( !isset( $request[ $field[ 'id' ] ] ) ) {
							$request[ $field[ 'id' ] ] = false;
						}

						if ( $field[ 'type' ] == 'checkbox' || $field[ 'type' ] == 'on_off' ) {
							if ( isset( $request[ $field[ 'id' ] ] ) && $request[ $field[ 'id' ] ] == 1 ) {
								$request[ $field[ 'id' ] ] = true;
							}
						}

						if ( $field[ 'type' ] == 'image_select' ) {
							if ( isset( $request[ $field[ 'id' ] ] ) && is_array( $request[ $field[ 'id' ] ] ) ) {
								$request[ $field[ 'id' ] ] = $request[ $field[ 'id' ] ][ 0 ];
							}
						}
					}

					if ( !isset( $field[ 'id' ] ) || empty( $request[ $field[ 'id' ] ] ) ) {
						continue;
					}
				}
			}
		}

		return $request;
	}

	/**
	 *
	 * Field Callback Classes
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 */
	public function field_callback( $field ) {
		$value = ( isset( $field[ 'id' ] ) && isset( $this->options[ $field[ 'id' ] ] ) ) ? $this->options[ $field[ 'id' ] ] : '';
		$this->addElement( $field, $value, $this->unique );
	}

	/**
	 *
	 * Settings Sections
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 */
	public function do_settings_sections( $page ) {

		global $wp_settings_sections, $wp_settings_fields;

		if ( !isset( $wp_settings_sections[ $page ] ) ) {
			return;
		}

		foreach ( $wp_settings_sections[ $page ] as $section ) {

			if ( $section[ 'callback' ] ) {
				call_user_func( $section[ 'callback' ], $section );
			}

			if ( !isset( $wp_settings_fields ) || !isset( $wp_settings_fields[ $page ] ) || !isset( $wp_settings_fields[ $page ][ $section[ 'id' ] ] ) ) {
				continue;
			}

			$this->do_settings_fields( $page, $section[ 'id' ] );
		}
	}

	/**
	 *
	 * Settings Fields
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 */
	public function do_settings_fields( $page, $section ) {

		global $wp_settings_fields;

		if ( !isset( $wp_settings_fields[ $page ][ $section ] ) ) {
			return;
		}

		foreach ( $wp_settings_fields[ $page ][ $section ] as $field ) {
			call_user_func( $field[ 'callback' ], $field[ 'args' ] );
		}
	}

	/**
	 *
	 * Adding Option Page
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 */
	public function menu() {
		call_user_func( $this->menu_type, $this->menu_title, $this->menu_title, 'manage_options', $this->menu_slug, array( &$this, 'page' ) );
	}

	/**
	 *
	 * Option page html output
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 */
	public function page() {

		echo '<div class="cs-framework cs-option-framework cs-framework-nav" data-cookie="base">';

		echo '<form method="post" action="./options.php" enctype="multipart/form-data" id="csframework_form">';
		echo '<input type="hidden" id="cs-reset-section" name="' . $this->unique . '[reset-section]" value="" />';

		settings_fields( $this->unique . '_group' );

		$ajax_atts	 = ( $this->ajax === true ) ? ' cs-ajax' : '';
		$sticky_atts = ( $this->sticky === true ) ? ' cs-sticky' : '';

		//
		// Header
		// ------------------------------------------------------------------------------------
		echo '<div class="cs-header' . $sticky_atts . '">';
		echo '<h1>ArticleMag <small>- Theme Options</small></h1>';
		echo '<div class="cs-save">';
		submit_button( 'Save', 'primary' . $ajax_atts, 'save', false );
		echo '&nbsp;';
		submit_button( 'Reset', 'secondary cs-reset', $this->unique . '[reset]', false );
		echo '</div>';
		echo '<div class="clear"></div>';
		echo '</div>';

		//
		// Body
		// ------------------------------------------------------------------------------------
		echo '<div class="cs-body">';

		echo '<div class="cs-nav-wrap">';

		if ( !empty( $this->tabs ) ) {

			echo '<ul class="cs-accordion-nav">';
			foreach ( $this->tabs as $tab_key => $tab ) {

				echo '<li>';
				echo '<a href="#" class="cs-nav-tab">' . $tab[ 'title' ] . '</a>';
				echo '<ul class="cs-sections">';
				foreach ( $tab[ 'sections' ] as $tab_section ) {
					echo '<li>';
					echo '<a href="#" data-section="' . $tab_section . '" data-target="cs-tab-' . sanitize_title( $this->sections[ $tab_section ][ 'title' ] ) . '">' . $this->sections[ $tab_section ][ 'title' ] . '</a>';
					echo '</li>';
				}
				echo '</ul>';
				echo '</li>';
			}
			echo '</ul>';
		} else {

			echo '<ul class="cs-sections">';
			foreach ( $this->sections as $k => $section ) {
				echo '<li>';
				echo '<a href="#" data-section="' . $k . '" data-target="cs-tab-' . sanitize_title( $section[ 'title' ] ) . '">' . $section[ 'title' ] . '</a>';
				echo '</li>';
			}
			echo '</ul>';
		}

		echo '</div>';

		//
		// Content
		// ------------------------------------------------------------------------------------
		echo '<div class="cs-content-wrap">';

		echo '<div class="cs-content">';

		echo '<ul>';
		foreach ( $this->sections as $key => $section ) {
			echo '<li id="cs-tab-' . sanitize_title( $section[ 'title' ] ) . '" class="cs-content-body">';
			$this->do_settings_sections( $key . '_section_group' );
			echo '</li>';
		}
		echo '</ul>';


		echo '<div class="clear"></div>';
		echo '</div>';

		echo '<div class="clear"></div>';
		echo '</div>';

		echo '<div class="cs-nav-background"></div>';
		echo '<div class="clear"></div>';

		echo '</div>';
		echo '<div class="clear"></div>';

		//
		// Footer
		// ------------------------------------------------------------------------------------
		echo '<div class="cs-footer">';
		//echo 'CSFramework v1.0.0 Powered by Codestar';
		echo '</div>';

		echo '</form>';

		echo '<div class="clear"></div>';
		echo '</div>';

		echo ( $this->ajax === true ) ? '<div id="save-ajax"></div>' : '';
	}

	/**
	 *
	 * Export Options
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 */
	public function export() {

		$options						 = array();
		$options[ 'framework_options' ]	 = get_option( FRAMEWORK_OPTION_NAME );
		$options[ 'customize_options' ]	 = get_option( CUSTOMIZE_OPTION_NAME );

		header( 'Content-Type: plain/text' );
		header( 'Content-disposition: attachment; filename=backup-options-' . gmdate( 'd-m-Y' ) . '.txt' );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		echo cs_encode_string( $options );

		die();
	}

}

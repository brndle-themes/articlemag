<?php

/**
 *
 * CSFramework Metabox Config
 *
 * @since 1.0.0
 * @version 1.2.0
 */

if ( ! function_exists( 'articlemag_metabox_sections' ) ) {
	/**
	 * [articlemag_metabox_sections description] Meta Box Fields
	 *
	 * @return [array] [fields]
	 */
	function articlemag_metabox_sections() {
		$header_options = array(
			'header-options' => array(
				'title'  => 'Header Options',
				'fields' => array(
					array(
						'id'    => 'fluid',
						'type'  => 'switcher',
						'title' => 'Fluid Header',
						'label' => '100% width, without container',
					),
					array(
						'id'    => 'page_title',
						'type'  => 'textarea',
						'title' => 'Custom Title',
						'class' => 'cs-textarea-mini',
					),
					array(
						'id'    => 'page_title_slogan',
						'type'  => 'textarea',
						'title' => 'Custom Title Slogan',
						'class' => 'cs-textarea-mini',
					),
					array(
						'id'        => 'custom_content',
						'type'      => 'textarea',
						'title'     => 'Custom Content',
						'desc'      => 'Showing below title',
						'shortcode' => true,
					),
					array(
						'id'      => 'padding',
						'type'    => 'select',
						'title'   => 'Padding',
						'options' => array(
							''               => 'Medium Padding',
							'xs-padding'     => 'Extra Small Padding',
							'sm-padding'     => 'Small Padding',
							'lg-padding'     => 'Large Padding',
							'xl-padding'     => 'Extra Large Padding',
							'no-padding'     => 'No Padding',
							'custom-padding' => 'Custom Padding',
						),
						'default' => array(
						    'custom-padding'  => 'lg-padding',
						 ),
					),
					array(
						'id'         => 'top',
						'type'       => 'text',
						'title'      => 'Padding Top',
						'attributes' => array( 'placeholder' => '100px' ),
						'dependency' => array( 'padding', '==', 'custom-padding' ),
					),
					array(
						'id'         => 'bottom',
						'type'       => 'text',
						'title'      => 'Padding Bottom',
						'attributes' => array( 'placeholder' => '100px' ),
						'dependency' => array( 'padding', '==', 'custom-padding' ),
					),
					array(
						'id'             => 'position',
						'type'           => 'select',
						'title'          => 'Center Title',
						'options'        => array(
							'default' => 'Choose a position',
							'title' => 'Center Title',
							'all'   => 'Center All',
						),
						'default' => 'default',
					),
				),
			),
			'header-styling' => array(
				'title'  => 'Header Styling',
				'fields' => array(
					array(
						'id'    => 'header_transparent',
						'type'  => 'switcher',
						'title' => 'Transparency Header',
						'label' => 'Use Transparent Method',
					),
					array(
						'id'         => 'top_bar_transparent',
						'type'       => 'switcher',
						'title'      => 'Transparency Top Bar',
						'label'      => 'Use Transparent Top Bar',
						'dependency' => array( 'header_transparent', '==', 'true' ),
					),
					array(
						'id'    => 'background',
						'type'  => 'background',
						'title' => 'Custom Header',
					),
					array(
						'id'    => 'cover',
						'type'  => 'switcher',
						'title' => 'Background Stretch',
						'label' => 'Settings with ON option will stretch the background image full as with container',
					),
					array(
						'id'    => 'parallax',
						'type'  => 'switcher',
						'title' => 'Parallax',
					),
					array(
						'id'         => 'speed',
						'type'       => 'text',
						'title'      => 'Parallax SpeedFactor',
						'attributes' => array(
							'placeholder' => 0.4,
						),
						'dependency' => array( 'parallax', '==', 'true' ),
					),
					array(
						'id'    => 'overlay',
						'type'  => 'switcher',
						'title' => 'Overlay',
					),
					array(
						'id'         => 'overlay_color',
						'type'       => 'color',
						'title'      => 'Overlay Color',
						'dependency' => array( 'overlay', '==', 'true' ),
					),
					array(
						'id'         => 'overlay_opacity',
						'type'       => 'text',
						'title'      => 'Overlay Opacity',
						'attributes' => array(
							'placeholder' => 0.5,
						),
						'dependency' => array( 'overlay', '==', 'true' ),
					),
					array(
						'id'    => 'video',
						'type'  => 'switcher',
						'title' => 'Video Header',
					),
					array(
						'id'         => 'mp4',
						'type'       => 'upload',
						'title'      => 'video/mp4',
						'settings'   => array(
							'upload_type'  => 'video',
							'insert_title' => 'Use This Video',
							'button_title' => 'Upload / MP4',
						),
						'dependency' => array( 'video', '==', 'true' ),
					),
					array(
						'id'         => 'ogv',
						'type'       => 'upload',
						'title'      => 'video/ogv',
						'settings'   => array(
							'upload_type'  => 'video',
							'insert_title' => 'Use This Video',
							'button_title' => 'Upload / OGV',
						),
						'dependency' => array( 'video', '==', 'true' ),
					),
					array(
						'id'         => 'webm',
						'type'       => 'upload',
						'title'      => 'video/webm',
						'settings'   => array(
							'upload_type'  => 'video',
							'insert_title' => 'Use This Video',
							'button_title' => 'Upload / WEBM',
						),
						'dependency' => array( 'video', '==', 'true' ),
					),
					array(
						'id'         => 'muted',
						'type'       => 'switcher',
						'title'      => 'Muted',
						'dependency' => array( 'video', '==', 'true' ),
					),
					array(
						'id'         => 'loop',
						'type'       => 'switcher',
						'title'      => 'Loop',
						'dependency' => array( 'video', '==', 'true' ),
					),
				),
			),
			'extras'         => array(
				'title'  => 'Extras',
				'fields' => array(
					array(
						'id'    => 'disable_header',
						'type'  => 'switcher',
						'title' => 'Disable Page Header',
					),
					// array(
					// 'id'        => 'breadcrumb',
					// 'type'      => 'switcher',
					// 'title'     => 'Disable Breadcrumb',
					// ),
						array(
							'id'    => 'disable_title',
							'type'  => 'switcher',
							'title' => 'Disable Title',
						),
					array(
						'id'    => 'disable_top_bar',
						'type'  => 'switcher',
						'title' => 'Disable Site Top-Bar',
					),
					array(
						'id'    => 'disable_footer',
						'type'  => 'switcher',
						'title' => 'Disable Site Footer',
					),
					array(
						'id'    => 'one_page_footer',
						'type'  => 'switcher',
						'title' => 'Show Footer in One-Page Template',
					),
					array(
						'id'    => 'force_show_header',
						'type'  => 'switcher',
						'title' => 'Force Show Header in Front page display',
					),
					array(
						'id'    => 'hide_featured_image',
						'type'  => 'switcher',
						'title' => 'Hide Featured Image',
					),
					array(
						'id'        => 'header_before',
						'type'      => 'textarea',
						'shortcode' => true,
						'title'     => 'Site Header Before Content',
						'info'      => 'eg. you can add a revolution slider for start page',
					),
				),
			),
		);

		return $header_options;
	}
}



// new CSFramework_Metabox_API( $metaboxes );

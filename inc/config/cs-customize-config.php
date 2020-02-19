<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * CSFramework Customize Config
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'articlemag_customizer_sections' ) ) {
	function articlemag_customizer_sections() {
		$wp_customize_colors = array();

		$wp_customize_colors['accent'] = array(
			array(
				'title'       => 'Accent Color',
				'priority'    => 1,
				'description' => 'All Elements Color, Just one click!',
				'fields'      => array(
					array(
						'id'      => 'accent_color',
						'type'    => 'color',
						'dafault' => '#e9425d',
					),
				),
			),
			array(
				'title'    => 'Reset',
				'priority' => 2,
				'fields'   => array(
					array(
						'id'   => 'reset',
						'type' => 'reset',
					),
				),
			),

		);

		$wp_customize_colors['custom']  = array(
			'title'       => 'Elements Colors',
			'priority'    => 1,
			'description' => 'This is for your all shortcode elements and etc colors of contents.',
			'fields'      => array(
				array(
					'id'      => 'accent_color',
					'type'    => 'color',
					'default' => '#e9425d',
				),
			),
		);
		$wp_customize_colors['top_bar'] = array(
			'title'    => '01. Top Bar Colors',
			'priority' => 2,
			'fields'   => array(
				array(
					'id'                         => 'top_bar_image',
					'title'                      => 'Background Image',
					'type'                       => 'background',
					'background_color'           => false,
					'background_position'        => false,
					'background_repeat'          => false,
					'background_size'            => false,
					'background_origin'          => false,
					'background_clip'            => false,
					'background_blend_mode'      => false,
					'background_gradient'        => false,
					'background_auto_attributes' => false,
					'background_attachment'      => false,
					'background_image_preview'   => false,
				),
				array(
					'id'      => 'top_bar_repeat',
					'type'    => 'select',
					'title'   => 'Background Repeat',
					'options' => array(
						''          => 'repeat',
						'repeat-x'  => 'repeat-x',
						'repeat-y'  => 'repeat-y',
						'no-repeat' => 'no-repeat',
					),
				),
				array(
					'id'      => 'top_bar_position',
					'title'   => 'Background Position',
					'type'    => 'select',
					'options' => array(
						''          => 'Left Top',
						'0% 50%'    => 'Left Center',
						'0% 100%'   => 'Left Bottom',
						'100% 0%'   => 'Right Top',
						'100% 50%'  => 'Right Center',
						'100% 100%' => 'Right Bottom',
						'50% 0%'    => 'Center Top',
						'50% 50%'   => 'Center Center',
						'50% 100%'  => 'Center Bottom',
					),
				),
				array(
					'id'      => 'top_bar_attachment',
					'title'   => 'Background Attachment',
					'type'    => 'select',
					'options' => array(
						''      => 'scroll',
						'fixed' => 'fixed',
					),

				),
				array(
					'id'      => 'top_bar_size',
					'title'   => 'Background Size',
					'type'    => 'select',
					'options' => array(
						''        => 'inherit',
						'cover'   => 'cover',
						'contain' => 'contain',
					),

				),
				array(
					'id'      => 'top_bar_bg',
					'title'   => 'Background Color',
					'type'    => 'color',
					'default' => '#f1f1f1',
				),
				array(
					'id'      => 'top_bar_border',
					'title'   => 'Border Color',
					'type'    => 'color',
					'default' => '#e8e8e8',

				),
				array(
					'id'      => 'top_bar_text',
					'title'   => 'Text Color',
					'type'    => 'color',
					'default' => '#555555',

				),
				array(
					'id'      => 'top_bar_link',
					'title'   => 'Link Color',
					'type'    => 'color',
					'default' => '#555555',

				),
				'top_bar_link_hover' => array(
					'title'   => 'Link Hover Color',
					'type'    => 'color',
					'default' => '#e9425d',
				),
				array(
					'id'      => 'top_bar_icon_color',
					'title'   => 'Icon Color',
					'type'    => 'color',
					'default' => '#e9425d',
				),
				array(
					'id'      => 'top_bar_social_color',
					'title'   => 'Social Icons Color',
					'type'    => 'color',
					'deafult' => '#555555',
				),
				array(
					'id'      => 'top_bar_social_hover',
					'title'   => 'Social Icons Hover Color',
					'type'    => 'color',
					'default' => '#e9425d',

				),
			),
		);

		$wp_customize_colors['header'] = array(
			'title'    => '02. Header Colors',
			'priority' => 3,
			'fields'   => array(
				array(
					'id'                         => 'header_image',
					'transport'                  => 'postMessage',
					'title'                      => 'Background Image',
					'type'                       => 'background',
					'background_color'           => false,
					'background_position'        => false,
					'background_repeat'          => false,
					'background_size'            => false,
					'background_origin'          => false,
					'background_clip'            => false,
					'background_blend_mode'      => false,
					'background_gradient'        => false,
					'background_auto_attributes' => false,
					'background_attachment'      => false,
					'background_image_preview'   => false,

				),
				array(
					'id'        => 'header_repeat',
					'title'     => 'Background Repeat',
					'transport' => 'postMessage',
					'type'      => 'select',
					'options'   => array(
						''          => 'repeat',
						'repeat-x'  => 'repeat-x',
						'repeat-y'  => 'repeat-y',
						'no-repeat' => 'no-repeat',
					),

				),
				array(
					'id'        => 'header_position',
					'title'     => 'Background Position',
					'transport' => 'postMessage',
					'type'      => 'select',
					'options'   => array(
						''          => 'Left Top',
						'0% 50%'    => 'Left Center',
						'0% 100%'   => 'Left Bottom',
						'100% 0%'   => 'Right Top',
						'100% 50%'  => 'Right Center',
						'100% 100%' => 'Right Bottom',
						'50% 0%'    => 'Center Top',
						'50% 50%'   => 'Center Center',
						'50% 100%'  => 'Center Bottom',
					),
				),
				array(
					'id'        => 'header_attachment',
					'title'     => 'Background Attachment',
					'transport' => 'postMessage',
					'type'      => 'select',
					'options'   => array(
						''      => 'scroll',
						'fixed' => 'fixed',
					),
				),
				array(
					'id'      => 'header_size',

					'title'   => 'Background Size',
					'type'    => 'select',
					'options' => array(
						''        => 'inherit',
						'cover'   => 'cover',
						'contain' => 'contain',
					),
				),
				array(
					'id'        => 'header_bg',
					'title'     => 'Background Color',
					'transport' => 'postMessage',
					'type'      => 'color',
					'default'   => '#ffffff',

				),
				array(
					'id'        => 'header_border',
					'title'     => 'Border Color',
					'transport' => 'postMessage',
					'type'      => 'color',
					'default'   => 'rgba(255, 255, 255, 0.1)',
				),
				array(
					'id'        => 'header_link',
					'title'     => 'Link Color',
					'transport' => 'postMessage',
					'type'      => 'color',
					'default'   => '#555555',
				),

				array(
					'id'      => 'header_link_hover',
					'title'   => 'Link Hover Color',
					'type'    => 'color',
					'default' => '#e9425d',
				),
				array(
					'id'      => 'header_link_hover_bg',
					'title'   => 'Link Hover Background Color',
					'type'    => 'color',
					'default' => '',
				),

				array(
					'id'      => 'submenu_colors',
					'type'    => 'heading',
					'content' => 'Submenu Colors',
				),
				array(
					'id'      => 'submenu_bg',
					'type'    => 'color',
					'title'   => 'Background Color',
					'dafault' => '#ffffff',
				),
				array(
					'id'      => 'submenu_bg_hover',
					'title'   => 'Background Hover Color',
					'type'    => 'color',
					'dafault' => '#f8f8f8',
				),
				array(
					'id'      => 'submenu_border',
					'title'   => 'Border Color',
					'type'    => 'color',
					'dafault' => '#eeeeee',
				),
				array(
					'id'      => 'submenu_link',
					'title'   => 'Link Color',
					'type'    => 'color',
					'dafault' => '#555555',
				),
				array(
					'id'      => 'submenu_link_hover',
					'type'    => 'color',
					'title'   => 'Link Hover Color',
					'dafault' => '#e9425d',
				),
				array(
					'id'      => 'megamenu_colors',
					'type'    => 'heading',
					'content' => 'Mega-Menu Colors',
				),
				array(
					'id'      => 'submenu_mega_title_color',
					'title'   => 'Title Color',
					'type'    => 'color',
					'default' => '#555555',
				),
				array(
					'id'      => 'submenu_mega_title_bgcolor',
					'title'   => 'Title Background Color',
					'type'    => 'color',
					'default' => '#f5f5f5',
				),
				array(
					'id'      => 'submenu_mega_title_border',
					'title'   => 'Title Border Color',
					'type'    => 'color',
					'default' => '#eeeeee',
				),
			),
		);

			$wp_customize_colors['page_header'] = array(
				'title'    => '03. Page Header Colors',
				'priority' => 4,
				'fields'   => array(
					array(
						'id'                         => 'page_header_image',
						'title'                      => 'Background Image',
						'type'                       => 'background',
						'background_color'           => false,
						'background_position'        => false,
						'background_repeat'          => false,
						'background_size'            => false,
						'background_origin'          => false,
						'background_clip'            => false,
						'background_blend_mode'      => false,
						'background_gradient'        => false,
						'background_auto_attributes' => false,
						'background_attachment'      => false,
						'background_image_preview'   => false,
					),
					array(
						'id'      => 'page_header_repeat',
						'title'   => 'Background Repeat',
						'type'    => 'select',
						'options' => array(
							''          => 'repeat',
							'repeat-x'  => 'repeat-x',
							'repeat-y'  => 'repeat-y',
							'no-repeat' => 'no-repeat',
						),
					),
					array(
						'id'      => 'page_header_position',
						'title'   => 'Background Position',
						'type'    => 'select',
						'options' => array(
							''          => 'Left Top',
							'0% 50%'    => 'Left Center',
							'0% 100%'   => 'Left Bottom',
							'100% 0%'   => 'Right Top',
							'100% 50%'  => 'Right Center',
							'100% 100%' => 'Right Bottom',
							'50% 0%'    => 'Center Top',
							'50% 50%'   => 'Center Center',
							'50% 100%'  => 'Center Bottom',
						),
					),
					array(
						'id'      => 'page_header_attachment',
						'title'   => 'Background Attachment',
						'type'    => 'select',
						'options' => array(
							''      => 'scroll',
							'fixed' => 'fixed',
						),
					),
					array(
						'id'      => 'page_header_size',
						'title'   => 'Background Size',
						'type'    => 'select',
						'options' => array(
							''        => 'inherit',
							'cover'   => 'cover',
							'contain' => 'contain',
						),
					),
					array(
						'id'     => 'page_header_bg',
						'title'  => 'Background Color',
						'type'   => 'color',
						'dafult' => '#e9425d',
					),
					array(
						'id'     => 'page_header_color',
						'title'  => 'Text Color',
						'type'   => 'color',
						'dafult' => '#ffffff',
					),
				// breadcrumb
				// 'breadcrumb_colors' => array(
				// 'control' => array(
				// 'type'   => 'heading',
				// 'content'  => 'Breadcrumb Colors',
				// ),
				// ),
				// 'breadcrumb_bgcolor' => array(
				// 'transport'  => 'postMessage',
				// 'control'    => array(
				// 'title'  => 'Breadcrumb Background Color',
				// 'type'   => 'color',
				// ),
				// ),
				// 'breadcrumb_color' => array(
				// 'transport'  => 'postMessage',
				// 'control'    => array(
				// 'title'  => 'Breadcrumb Text Color',
				// 'type'   => 'color',
				// ),
				// ),
				// 'breadcrumb_link_color' => array(
				// 'control' => array(
				// 'title'  => 'Breadcrumb Link Color',
				// 'type'   => 'color',
				// ),
				// ),
				),
			);
			// section
			$wp_customize_colors['footer'] = array(
				'title'    => '04. Footer Colors',
				'priority' => 5,
				// fields
				'fields'   => array(
					array(
						'id'                         => 'footer_image',
						'title'                      => 'Background Image',
						'type'                       => 'background',
						'background_color'           => false,
						'background_position'        => false,
						'background_repeat'          => false,
						'background_size'            => false,
						'background_origin'          => false,
						'background_clip'            => false,
						'background_blend_mode'      => false,
						'background_gradient'        => false,
						'background_auto_attributes' => false,
						'background_attachment'      => false,
						'background_image_preview'   => false,
					),
					array(
						'id'      => 'footer_repeat',
						'title'   => 'Background Repeat',
						'type'    => 'select',
						'options' => array(
							''          => 'repeat',
							'repeat-x'  => 'repeat-x',
							'repeat-y'  => 'repeat-y',
							'no-repeat' => 'no-repeat',
						),
					),
					array(
						'id'      => 'footer_position',
						'title'   => 'Background Position',
						'type'    => 'select',
						'options' => array(
							''          => 'Left Top',
							'0% 50%'    => 'Left Center',
							'0% 100%'   => 'Left Bottom',
							'100% 0%'   => 'Right Top',
							'100% 50%'  => 'Right Center',
							'100% 100%' => 'Right Bottom',
							'50% 0%'    => 'Center Top',
							'50% 50%'   => 'Center Center',
							'50% 100%'  => 'Center Bottom',
						),
					),
					array(
						'id'      => 'footer_attachment',
						'title'   => 'Background Attachment',
						'type'    => 'select',
						'options' => array(
							''      => 'scroll',
							'fixed' => 'fixed',
						),
					),
					array(
						'id'      => 'footer_size',
						'title'   => 'Background Size',
						'type'    => 'select',
						'options' => array(
							''        => 'inherit',
							'cover'   => 'cover',
							'contain' => 'contain',
						),
					),
					array(
						'id'      => 'footer_bg',
						'title'   => 'Background Color',
						'type'    => 'color',
						'default' => '#222222',
					),
					array(
						'id'      => 'footer_color',
						'title'   => 'Text Color',
						'type'    => 'color',
						'default' => '#999999',
					),
					array(
						'id'      => 'footer_link_color',
						'title'   => 'Link Color',
						'type'    => 'color',
						'default' => '#cccccc',
					),
					array(
						'id'      => 'footer_link_hover',
						'title'   => 'Link Hover Color',
						'type'    => 'color',
						'default' => '#ffffff',
					),
					array(
						'id'      => 'footer_title_color',
						'title'   => 'Title Color',
						'type'    => 'color',
						'default' => '#ffffff',
					),
					array(
						'id'      => 'footer_border_color',
						'title'   => 'Border Color',
						'type'    => 'color',
						'default' => '#444444',
					),
				),
			);

			$wp_customize_colors['footer_ba'] = array(
				'title'    => '05. Footer Block Before &amp; After',
				'priority' => 6,
				'fields'   => array(
					array(
						'id'                         => 'footer_ba_image',
						'title'                      => 'Background Image',
						'type'                       => 'background',
						'background_color'           => false,
						'background_position'        => false,
						'background_repeat'          => false,
						'background_size'            => false,
						'background_origin'          => false,
						'background_clip'            => false,
						'background_blend_mode'      => false,
						'background_gradient'        => false,
						'background_auto_attributes' => false,
						'background_attachment'      => false,
						'background_image_preview'   => false,
					),
					array(
						'id'      => 'footer_ba_repeat',
						'title'   => 'Background Repeat',
						'type'    => 'select',
						'options' => array(
							''          => 'repeat',
							'repeat-x'  => 'repeat-x',
							'repeat-y'  => 'repeat-y',
							'no-repeat' => 'no-repeat',
						),
					),
					array(
						'id'      => 'footer_ba_position',
						'title'   => 'Background Position',
						'type'    => 'select',
						'options' => array(
							''          => 'Left Top',
							'0% 50%'    => 'Left Center',
							'0% 100%'   => 'Left Bottom',
							'100% 0%'   => 'Right Top',
							'100% 50%'  => 'Right Center',
							'100% 100%' => 'Right Bottom',
							'50% 0%'    => 'Center Top',
							'50% 50%'   => 'Center Center',
							'50% 100%'  => 'Center Bottom',
						),
					),
					array(
						'id'      => 'footer_ba_attachment',
						'title'   => 'Background Attachment',
						'type'    => 'select',
						'options' => array(
							''      => 'scroll',
							'fixed' => 'fixed',
						),
					),
					array(
						'id'      => 'footer_ba_size',
						'title'   => 'Background Size',
						'type'    => 'select',
						'options' => array(
							''        => 'inherit',
							'cover'   => 'cover',
							'contain' => 'contain',
						),
					),
					array(
						'id'      => 'footer_ba_bg',
						'title'   => 'Background Color',
						'type'    => 'color',
						'dafault' => '#e9425d',
					),
					array(
						'id'      => 'footer_ba_color',
						'title'   => 'Text Color',
						'type'    => 'color',
						'dafault' => '#ffffff',
					),
					array(
						'id'      => 'footer_ba_link_color',
						'title'   => 'Link Color',
						'type'    => 'color',
						'dafault' => '#ffffff',
					),
					array(
						'id'      => 'footer_ba_link_hover',
						'title'   => 'Link Hover Color',
						'type'    => 'color',
						'dafault' => '#ffffff',
					),
					array(
						'id'      => 'footer_ba_title_color',
						'title'   => 'Title Color',
						'type'    => 'color',
						'dafault' => '#ffffff',
					),
					array(
						'id'      => 'footer_ba_border_color',
						'title'   => 'Border Color',
						'type'    => 'color',
						'dafault' => '#ffffff',
					),
				),
			);

			$wp_customize_colors['copyright']              = array(
				'title'    => '06. Copyright Colors',
				'priority' => 7,

				'fields'   => array(
					array(
						'id'                         => 'copyright_image',
						'title'                      => 'Background Image',
						'type'                       => 'background',
						'background_color'           => false,
						'background_position'        => false,
						'background_repeat'          => false,
						'background_size'            => false,
						'background_origin'          => false,
						'background_clip'            => false,
						'background_blend_mode'      => false,
						'background_gradient'        => false,
						'background_auto_attributes' => false,
						'background_attachment'      => false,
						'background_image_preview'   => false,
					),
					array(
						'id'      => 'copyright_repeat',
						'title'   => 'Background Repeat',
						'type'    => 'select',
						'options' => array(
							''          => 'repeat',
							'repeat-x'  => 'repeat-x',
							'repeat-y'  => 'repeat-y',
							'no-repeat' => 'no-repeat',
						),
					),
					array(
						'id'      => 'copyright_position',
						'title'   => 'Background Position',
						'type'    => 'select',
						'options' => array(
							''          => 'Left Top',
							'0% 50%'    => 'Left Center',
							'0% 100%'   => 'Left Bottom',
							'100% 0%'   => 'Right Top',
							'100% 50%'  => 'Right Center',
							'100% 100%' => 'Right Bottom',
							'50% 0%'    => 'Center Top',
							'50% 50%'   => 'Center Center',
							'50% 100%'  => 'Center Bottom',
						),
					),
					array(
						'id'      => 'copyright_attachment',
						'title'   => 'Background Attachment',
						'type'    => 'select',
						'options' => array(
							''      => 'scroll',
							'fixed' => 'fixed',
						),
					),
					array(
						'id'      => 'copyright_size',
						'title'   => 'Background Size',
						'type'    => 'select',
						'options' => array(
							''        => 'inherit',
							'cover'   => 'cover',
							'contain' => 'contain',
						),
					),
					array(
						'id'     => 'copyright_bg',
						'title'  => 'Background Color',
						'type'   => 'color',
						'dafult' => '#111111',
					),
					array(
						'id'     => 'copyright_color',
						'title'  => 'Text Color',
						'type'   => 'color',
						'dafult' => '#555555',
					),
					array(
						'id'     => 'copyright_link_color',
						'title'  => 'Link Color',
						'type'   => 'color',
						'dafult' => '#555555',
					),
					array(
						'id'     => 'copyright_link_hover',
						'title'  => 'Link Hover Color',
						'type'   => 'color',
						'dafult' => '#ffffff',
					),
				),
			);
				$wp_customize_colors['cs_reset_customize'] = array(
					'title'    => 'Reset',
					'priority' => 8,
					'fields'   => array(
						array(
							'type' => 'reset',
						),
					),
				);

				// // logo background for header-left and header-center
				// $has_logo_bar = cs_get_option( 'header_style' );
				//
				// if ( $has_logo_bar !== 'default' ) {
				//
				// $logo_bar = array(
				// 'logo_bar' => array(
				// 'title'  => '06. Logo Background Colors',
				// 'fields' => array(
				// 'logo_bar_image'      => array(
				// 'transport' => 'postMessage',
				// 'control'   => array(
				// 'title' => 'Background Image',
				// 'type'  => 'image',
				// ),
				// ),
				// 'logo_bar_repeat'     => array(
				// 'transport' => 'postMessage',
				// 'control'   => array(
				// 'title'   => 'Background Repeat',
				// 'type'    => 'select',
				// 'options' => array(
				// ''          => 'repeat',
				// 'repeat-x'  => 'repeat-x',
				// 'repeat-y'  => 'repeat-y',
				// 'no-repeat' => 'no-repeat',
				// ),
				// ),
				// ),
				// 'logo_bar_position'   => array(
				// 'transport' => 'postMessage',
				// 'control'   => array(
				// 'title'   => 'Background Position',
				// 'type'    => 'select',
				// 'options' => array(
				// ''          => 'Left Top',
				// '0% 50%'    => 'Left Center',
				// '0% 100%'   => 'Left Bottom',
				// '100% 0%'   => 'Right Top',
				// '100% 50%'  => 'Right Center',
				// '100% 100%' => 'Right Bottom',
				// '50% 0%'    => 'Center Top',
				// '50% 50%'   => 'Center Center',
				// '50% 100%'  => 'Center Bottom',
				// ),
				// ),
				// ),
				// 'logo_bar_attachment' => array(
				// 'transport' => 'postMessage',
				// 'control'   => array(
				// 'title'   => 'Background Attachment',
				// 'type'    => 'select',
				// 'options' => array(
				// ''      => 'scroll',
				// 'fixed' => 'fixed',
				// ),
				// ),
				// ),
				// 'logo_bar_size'       => array(
				// 'transport' => 'postMessage',
				// 'control'   => array(
				// 'title'   => 'Background Size',
				// 'type'    => 'select',
				// 'options' => array(
				// ''        => 'inherit',
				// 'cover'   => 'cover',
				// 'contain' => 'contain',
				// ),
				// ),
				// ),
				// 'logo_bar_bg'         => array(
				// 'transport' => 'postMessage',
				// 'control'   => array(
				// 'title' => 'Background Color',
				// 'type'  => 'color',
				// ),
				// ),
				// 'logo_bar_color'      => array(
				// 'transport' => 'postMessage',
				// 'control'   => array(
				// 'title' => 'Text Color',
				// 'type'  => 'color',
				// ),
				// ),
				// ),
				// ),
				// );
				//
				//
				// $wp_customize_colors['custom'] = cs_array_insert( $wp_customize_colors['custom'], $logo_bar, 'before', '' );
				// }

				/**
				 *
				 * CSFramework_Customize_API init
				 *
				 * @since 1.0.0
				 * @version 1.0.0
				 */
				$skin = cs_get_option( 'skin' );
				if ( ! empty( $skin ) && $skin == 'accent' ) {
					return $wp_customize_colors[ $skin ];
				} elseif ( ! empty( $skin ) && $skin == 'custom' ) {
					return $wp_customize_colors;
				}

	}
}

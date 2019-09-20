<?php

/**
 *
 * CSFramework Customize Config
 * @since 1.0.0
 * @version 1.0.0
 *
 */
$wp_customize_colors[ 'accent' ] = array(
	// accent colors
	'accent'			 => array(
		'title'			 => 'Accent Color',
		'priority'		 => 1,
		'description'	 => 'All Elements Color, Just one click!',
		'settings'		 => array(
			'accent_color' => array(
				'transport'	 => 'refresh',
				'control'	 => array(
					'type' => 'cs_color',
				),
			),
		)
	),
	// reset colors
	'cs_reset_customize' => array(
		'title'		 => 'Reset',
		'priority'	 => 2,
		'settings'	 => array(
			'reset' => array(
				'control' => array(
					'type' => 'cs_reset',
				)
			)
		)
	),
);

$wp_customize_colors[ 'custom' ] = array(
	'accent'			 => array(
		'title'		 => 'Elements Colors',
		'settings'	 => array(
			'accent_desc'	 => array(
				'control' => array(
					'label'	 => 'This is for your all shortcode elements and etc colors of contents.',
					'type'	 => 'cs_description',
				),
			),
			'accent_color'	 => array(
				'control' => array(
					'type' => 'cs_color',
				),
			),
		)
	),
	// Top Bar Section
	'top_bar'			 => array(
		'title'		 => '01. Top Bar Colors',
		'settings'	 => array(
			'top_bar_image'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Image',
					'type'	 => 'image',
				),
			),
			'top_bar_repeat'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Repeat',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'repeat',
						'repeat-x'	 => 'repeat-x',
						'repeat-y'	 => 'repeat-y',
						'no-repeat'	 => 'no-repeat',
					)
				),
			),
			'top_bar_position'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Position',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'Left Top',
						'0% 50%'	 => 'Left Center',
						'0% 100%'	 => 'Left Bottom',
						'100% 0%'	 => 'Right Top',
						'100% 50%'	 => 'Right Center',
						'100% 100%'	 => 'Right Bottom',
						'50% 0%'	 => 'Center Top',
						'50% 50%'	 => 'Center Center',
						'50% 100%'	 => 'Center Bottom'
					)
				),
			),
			'top_bar_attachment'	 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Attachment',
					'type'		 => 'select',
					'choices'	 => array(
						''		 => 'scroll',
						'fixed'	 => 'fixed',
					)
				),
			),
			'top_bar_size'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Size',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'inherit',
						'cover'		 => 'cover',
						'contain'	 => 'contain',
					)
				),
			),
			'top_bar_bg'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Color',
					'type'	 => 'cs_color',
				),
			),
			'top_bar_border'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Border Color',
					'type'	 => 'cs_color',
				),
			),
			'top_bar_text'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Text Color',
					'type'	 => 'cs_color',
				),
			),
			'top_bar_link'			 => array(
				'control' => array(
					'label'	 => 'Link Color',
					'type'	 => 'cs_color',
				),
			),
			'top_bar_link_hover'	 => array(
				'control' => array(
					'label'	 => 'Link Hover Color',
					'type'	 => 'cs_color',
				),
			),
			'top_bar_icon_color'	 => array(
				'control' => array(
					'label'	 => 'Icon Color',
					'type'	 => 'cs_color',
				),
			),
			'top_bar_social_color'	 => array(
				'control' => array(
					'label'	 => 'Social Icons Color',
					'type'	 => 'cs_color',
				),
			),
			'top_bar_social_hover'	 => array(
				'control' => array(
					'label'	 => 'Social Icons Hover Color',
					'type'	 => 'cs_color',
				),
			),
		)
	),
	# section
	'header'			 => array(
		'title'		 => '02. Header Colors',
		# settings
		'settings'	 => array(
			'header_image'				 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Image',
					'type'	 => 'image',
				),
			),
			'header_repeat'				 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Repeat',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'repeat',
						'repeat-x'	 => 'repeat-x',
						'repeat-y'	 => 'repeat-y',
						'no-repeat'	 => 'no-repeat',
					)
				),
			),
			'header_position'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Position',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'Left Top',
						'0% 50%'	 => 'Left Center',
						'0% 100%'	 => 'Left Bottom',
						'100% 0%'	 => 'Right Top',
						'100% 50%'	 => 'Right Center',
						'100% 100%'	 => 'Right Bottom',
						'50% 0%'	 => 'Center Top',
						'50% 50%'	 => 'Center Center',
						'50% 100%'	 => 'Center Bottom'
					)
				),
			),
			'header_attachment'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Attachment',
					'type'		 => 'select',
					'choices'	 => array(
						''		 => 'scroll',
						'fixed'	 => 'fixed',
					)
				),
			),
			'header_size'				 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Size',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'inherit',
						'cover'		 => 'cover',
						'contain'	 => 'contain',
					)
				),
			),
			'header_bg'					 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Color',
					'type'	 => 'cs_color',
				),
			),
			'header_border'				 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Border Color',
					'type'	 => 'cs_color',
				),
			),
			'header_link'				 => array(
				'control' => array(
					'label'	 => 'Link Color',
					'type'	 => 'cs_color',
				),
			),
			'header_link_hover'			 => array(
				'control' => array(
					'label'	 => 'Link Hover Color',
					'type'	 => 'cs_color',
				),
			),
			'header_link_hover_bg'		 => array(
				'control' => array(
					'label'	 => 'Link Hover Background Color',
					'type'	 => 'cs_color',
				),
			),
			//
			// submenu
			// -------------------------------------------------------
			'submenu_colors'			 => array(
				'control' => array(
					'label'	 => 'Submenu Colors',
					'type'	 => 'cs_subtitle',
				),
			),
			'submenu_bg'				 => array(
				'control' => array(
					'label'	 => 'Background Color',
					'type'	 => 'cs_color',
				),
			),
			'submenu_bg_hover'			 => array(
				'control' => array(
					'label'	 => 'Background Hover Color',
					'type'	 => 'cs_color',
				),
			),
			'submenu_border'			 => array(
				'control' => array(
					'label'	 => 'Border Color',
					'type'	 => 'cs_color',
				),
			),
			'submenu_link'				 => array(
				'control' => array(
					'label'	 => 'Link Color',
					'type'	 => 'cs_color',
				),
			),
			'submenu_link_hover'		 => array(
				'control' => array(
					'label'	 => 'Link Hover Color',
					'type'	 => 'cs_color',
				),
			),
			// mega-menu
			'megamenu_colors'			 => array(
				'control' => array(
					'label'	 => 'Mega-Menu Colors',
					'type'	 => 'cs_subtitle',
				),
			),
			'submenu_mega_title_color'	 => array(
				'control' => array(
					'label'	 => 'Title Color',
					'type'	 => 'cs_color',
				),
			),
			'submenu_mega_title_bgcolor' => array(
				'control' => array(
					'label'	 => 'Title Background Color',
					'type'	 => 'cs_color',
				),
			),
			'submenu_mega_title_border'	 => array(
				'control' => array(
					'label'	 => 'Title Border Color',
					'type'	 => 'cs_color',
				),
			),
		)
	),
	# section
	'page_header'		 => array(
		'title'		 => '03. Page Header Colors',
		# settings
		'settings'	 => array(
			'page_header_image'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Image',
					'type'	 => 'image',
				),
			),
			'page_header_repeat'	 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Repeat',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'repeat',
						'repeat-x'	 => 'repeat-x',
						'repeat-y'	 => 'repeat-y',
						'no-repeat'	 => 'no-repeat',
					)
				),
			),
			'page_header_position'	 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Position',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'Left Top',
						'0% 50%'	 => 'Left Center',
						'0% 100%'	 => 'Left Bottom',
						'100% 0%'	 => 'Right Top',
						'100% 50%'	 => 'Right Center',
						'100% 100%'	 => 'Right Bottom',
						'50% 0%'	 => 'Center Top',
						'50% 50%'	 => 'Center Center',
						'50% 100%'	 => 'Center Bottom'
					)
				),
			),
			'page_header_attachment' => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Attachment',
					'type'		 => 'select',
					'choices'	 => array(
						''		 => 'scroll',
						'fixed'	 => 'fixed',
					)
				),
			),
			'page_header_size'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Size',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'inherit',
						'cover'		 => 'cover',
						'contain'	 => 'contain',
					)
				),
			),
			'page_header_bg'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Color',
					'type'	 => 'cs_color',
				),
			),
			'page_header_color'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Text Color',
					'type'	 => 'cs_color',
				),
			),
		// breadcrumb
//			'breadcrumb_colors' => array(
//				'control' => array(
//					'label'	 => 'Breadcrumb Colors',
//					'type'	 => 'cs_subtitle',
//				),
//			),
//			'breadcrumb_bgcolor' => array(
//				'transport'	 => 'postMessage',
//				'control'	 => array(
//					'label'	 => 'Breadcrumb Background Color',
//					'type'	 => 'cs_color',
//				),
//			),
//			'breadcrumb_color' => array(
//				'transport'	 => 'postMessage',
//				'control'	 => array(
//					'label'	 => 'Breadcrumb Text Color',
//					'type'	 => 'cs_color',
//				),
//			),
//			'breadcrumb_link_color' => array(
//				'control' => array(
//					'label'	 => 'Breadcrumb Link Color',
//					'type'	 => 'cs_color',
//				),
//			),
		)
	),
	# section
	'footer'			 => array(
		'title'		 => '04. Footer Colors',
		# settings
		'settings'	 => array(
			'footer_image'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Image',
					'type'	 => 'image',
				),
			),
			'footer_repeat'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Repeat',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'repeat',
						'repeat-x'	 => 'repeat-x',
						'repeat-y'	 => 'repeat-y',
						'no-repeat'	 => 'no-repeat',
					)
				),
			),
			'footer_position'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Position',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'Left Top',
						'0% 50%'	 => 'Left Center',
						'0% 100%'	 => 'Left Bottom',
						'100% 0%'	 => 'Right Top',
						'100% 50%'	 => 'Right Center',
						'100% 100%'	 => 'Right Bottom',
						'50% 0%'	 => 'Center Top',
						'50% 50%'	 => 'Center Center',
						'50% 100%'	 => 'Center Bottom'
					)
				),
			),
			'footer_attachment'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Attachment',
					'type'		 => 'select',
					'choices'	 => array(
						''		 => 'scroll',
						'fixed'	 => 'fixed',
					)
				),
			),
			'footer_size'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Size',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'inherit',
						'cover'		 => 'cover',
						'contain'	 => 'contain',
					)
				),
			),
			'footer_bg'				 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Color',
					'type'	 => 'cs_color',
				),
			),
			'footer_color'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Text Color',
					'type'	 => 'cs_color',
				),
			),
			'footer_link_color'		 => array(
				'control' => array(
					'label'	 => 'Link Color',
					'type'	 => 'cs_color',
				),
			),
			'footer_link_hover'		 => array(
				'control' => array(
					'label'	 => 'Link Hover Color',
					'type'	 => 'cs_color',
				),
			),
			'footer_title_color'	 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Title Color',
					'type'	 => 'cs_color',
				),
			),
			'footer_border_color'	 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Border Color',
					'type'	 => 'cs_color',
				),
			),
		)
	),
	# section
	'footer_ba'			 => array(
		'title'		 => '05. Footer Block Before &amp; After',
		# settings
		'settings'	 => array(
			'footer_ba_image'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Image',
					'type'	 => 'image',
				),
			),
			'footer_ba_repeat'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Repeat',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'repeat',
						'repeat-x'	 => 'repeat-x',
						'repeat-y'	 => 'repeat-y',
						'no-repeat'	 => 'no-repeat',
					)
				),
			),
			'footer_ba_position'	 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Position',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'Left Top',
						'0% 50%'	 => 'Left Center',
						'0% 100%'	 => 'Left Bottom',
						'100% 0%'	 => 'Right Top',
						'100% 50%'	 => 'Right Center',
						'100% 100%'	 => 'Right Bottom',
						'50% 0%'	 => 'Center Top',
						'50% 50%'	 => 'Center Center',
						'50% 100%'	 => 'Center Bottom'
					)
				),
			),
			'footer_ba_attachment'	 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Attachment',
					'type'		 => 'select',
					'choices'	 => array(
						''		 => 'scroll',
						'fixed'	 => 'fixed',
					)
				),
			),
			'footer_ba_size'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Size',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'inherit',
						'cover'		 => 'cover',
						'contain'	 => 'contain',
					)
				),
			),
			'footer_ba_bg'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Color',
					'type'	 => 'cs_color',
				),
			),
			'footer_ba_color'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Text Color',
					'type'	 => 'cs_color',
				),
			),
			'footer_ba_link_color'	 => array(
				'control' => array(
					'label'	 => 'Link Color',
					'type'	 => 'cs_color',
				),
			),
			'footer_ba_link_hover'	 => array(
				'control' => array(
					'label'	 => 'Link Hover Color',
					'type'	 => 'cs_color',
				),
			),
			'footer_ba_title_color'	 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Title Color',
					'type'	 => 'cs_color',
				),
			),
			'footer_ba_border_color' => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Border Color',
					'type'	 => 'cs_color',
				),
			),
		)
	),
	# section
	'copyright'			 => array(
		'title'		 => '06. Copyright Colors',
		# settings
		'settings'	 => array(
			'copyright_image'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Image',
					'type'	 => 'image',
				),
			),
			'copyright_repeat'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Repeat',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'repeat',
						'repeat-x'	 => 'repeat-x',
						'repeat-y'	 => 'repeat-y',
						'no-repeat'	 => 'no-repeat',
					)
				),
			),
			'copyright_position'	 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Position',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'Left Top',
						'0% 50%'	 => 'Left Center',
						'0% 100%'	 => 'Left Bottom',
						'100% 0%'	 => 'Right Top',
						'100% 50%'	 => 'Right Center',
						'100% 100%'	 => 'Right Bottom',
						'50% 0%'	 => 'Center Top',
						'50% 50%'	 => 'Center Center',
						'50% 100%'	 => 'Center Bottom'
					)
				),
			),
			'copyright_attachment'	 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Attachment',
					'type'		 => 'select',
					'choices'	 => array(
						''		 => 'scroll',
						'fixed'	 => 'fixed',
					)
				),
			),
			'copyright_size'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'		 => 'Background Size',
					'type'		 => 'select',
					'choices'	 => array(
						''			 => 'inherit',
						'cover'		 => 'cover',
						'contain'	 => 'contain',
					)
				),
			),
			'copyright_bg'			 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Background Color',
					'type'	 => 'cs_color',
				),
			),
			'copyright_color'		 => array(
				'transport'	 => 'postMessage',
				'control'	 => array(
					'label'	 => 'Text Color',
					'type'	 => 'cs_color',
				),
			),
			'copyright_link_color'	 => array(
				'control' => array(
					'label'	 => 'Link Color',
					'type'	 => 'cs_color',
				),
			),
			'copyright_link_hover'	 => array(
				'control' => array(
					'label'	 => 'Link Hover Color',
					'type'	 => 'cs_color',
				),
			),
		)
	),
	// reset colors
	'cs_reset_customize' => array(
		'title'		 => 'Reset',
		//'priority'       => 99,
		'settings'	 => array(
			'reset' => array(
				'control' => array(
					'type' => 'cs_reset',
				)
			)
		)
	),
);

// logo background for header-left and header-center
$has_logo_bar = cs_get_option( 'header_style' );

if ( $has_logo_bar !== 'default' ) {

	$logo_bar = array(
		'logo_bar' => array(
			'title'		 => '06. Logo Background Colors',
			'settings'	 => array(
				'logo_bar_image'		 => array(
					'transport'	 => 'postMessage',
					'control'	 => array(
						'label'	 => 'Background Image',
						'type'	 => 'image',
					),
				),
				'logo_bar_repeat'		 => array(
					'transport'	 => 'postMessage',
					'control'	 => array(
						'label'		 => 'Background Repeat',
						'type'		 => 'select',
						'choices'	 => array(
							''			 => 'repeat',
							'repeat-x'	 => 'repeat-x',
							'repeat-y'	 => 'repeat-y',
							'no-repeat'	 => 'no-repeat',
						)
					),
				),
				'logo_bar_position'		 => array(
					'transport'	 => 'postMessage',
					'control'	 => array(
						'label'		 => 'Background Position',
						'type'		 => 'select',
						'choices'	 => array(
							''			 => 'Left Top',
							'0% 50%'	 => 'Left Center',
							'0% 100%'	 => 'Left Bottom',
							'100% 0%'	 => 'Right Top',
							'100% 50%'	 => 'Right Center',
							'100% 100%'	 => 'Right Bottom',
							'50% 0%'	 => 'Center Top',
							'50% 50%'	 => 'Center Center',
							'50% 100%'	 => 'Center Bottom'
						)
					),
				),
				'logo_bar_attachment'	 => array(
					'transport'	 => 'postMessage',
					'control'	 => array(
						'label'		 => 'Background Attachment',
						'type'		 => 'select',
						'choices'	 => array(
							''		 => 'scroll',
							'fixed'	 => 'fixed',
						)
					),
				),
				'logo_bar_size'			 => array(
					'transport'	 => 'postMessage',
					'control'	 => array(
						'label'		 => 'Background Size',
						'type'		 => 'select',
						'choices'	 => array(
							''			 => 'inherit',
							'cover'		 => 'cover',
							'contain'	 => 'contain',
						)
					),
				),
				'logo_bar_bg'			 => array(
					'transport'	 => 'postMessage',
					'control'	 => array(
						'label'	 => 'Background Color',
						'type'	 => 'color',
					),
				),
				'logo_bar_color'		 => array(
					'transport'	 => 'postMessage',
					'control'	 => array(
						'label'	 => 'Text Color',
						'type'	 => 'cs_color',
					),
				),
			)
		)
	);

	$wp_customize_colors[ 'custom' ] = cs_array_insert( $wp_customize_colors[ 'custom' ], $logo_bar, 'before', 'cs_reset_customize' );
}

/**
 *
 * CSFramework_Customize_API init
 * @since 1.0.0
 * @version 1.0.0
 *
 */
$skin = cs_get_option( 'skin' );
if ( !empty( $skin ) && $skin != 'default' ) {
	new CSFramework_Customize_API( $wp_customize_colors[ $skin ] );
}
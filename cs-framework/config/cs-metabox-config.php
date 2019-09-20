<?php

/**
 *
 * CSFramework Metabox Config
 * @since 1.0.0
 * @version 1.2.0
 *
 */
$sidebars = array(
	'left'	 => FRAMEWORK_URI . '/config/sidebars/sidebar_left.png',
	'right'	 => FRAMEWORK_URI . '/config/sidebars/sidebar_right.png',
	'full'	 => FRAMEWORK_URI . '/config/sidebars/sidebar_full.png',
	'fluid'	 => FRAMEWORK_URI . '/config/sidebars/sidebar_fluid.png',
);

$header_sliders	 = array();
$header_options	 = array(
	'header-options' => array(
		'title'	 => "Header Options",
		'fields' => array(
			array(
				'id'	 => 'fluid',
				'type'	 => 'on_off',
				'title'	 => 'Fluid Header',
				'label'	 => '100% width, without container'
			),
			array(
				'id'	 => 'page_title',
				'type'	 => 'textarea',
				'title'	 => 'Custom Title',
				'class'	 => 'cs-textarea-mini',
			),
			array(
				'id'	 => 'page_title_slogan',
				'type'	 => 'textarea',
				'title'	 => 'Custom Title Slogan',
				'class'	 => 'cs-textarea-mini',
			),
			array(
				'id'		 => 'custom_content',
				'type'		 => 'textarea',
				'title'		 => 'Custom Content',
				'desc'		 => 'Showing below title',
				'shortcode'	 => true
			),
			array(
				'id'		 => 'padding',
				'type'		 => 'select',
				'title'		 => 'Padding',
				'options'	 => array(
					''				 => 'Medium Padding',
					'xs-padding'	 => 'Extra Small Padding',
					'sm-padding'	 => 'Small Padding',
					'lg-padding'	 => 'Large Padding',
					'xl-padding'	 => 'Extra Large Padding',
					'no-padding'	 => 'No Padding',
					'custom-padding' => 'Custom Padding',
				),
			),
			array(
				'id'		 => 'top',
				'type'		 => 'text',
				'title'		 => 'Padding Top',
				'attributes' => array( 'placeholder' => '100px' ),
				'dependency' => array( 'padding', '==', 'custom-padding' ),
			),
			array(
				'id'		 => 'bottom',
				'type'		 => 'text',
				'title'		 => 'Padding Bottom',
				'attributes' => array( 'placeholder' => '100px' ),
				'dependency' => array( 'padding', '==', 'custom-padding' ),
			),
			array(
				'id'			 => 'position',
				'type'			 => 'select',
				'title'			 => 'Center Title',
				'options'		 => array(
					'title'	 => 'Center Title',
					'all'	 => 'Center All',
				),
				'default_option' => 'Choose a position',
			),
		)
	),
	'header-styling' => array(
		'title'	 => "Header Styling",
		'fields' => array(
			array(
				'id'	 => 'header_transparent',
				'type'	 => 'on_off',
				'title'	 => 'Transparency Header',
				'label'	 => 'Use Transparent Method',
			),
			array(
				'id'		 => 'top_bar_transparent',
				'type'		 => 'on_off',
				'title'		 => 'Transparency Top Bar',
				'label'		 => 'Use Transparent Top Bar',
				'dependency' => array( 'header_transparent', '==', 'true' ),
			),
			array(
				'id'	 => 'background',
				'type'	 => 'background',
				'title'	 => 'Custom Header',
			),
			array(
				'id'	 => 'cover',
				'type'	 => 'on_off',
				'title'	 => 'Background Stretch',
				'label'	 => 'Settings with ON option will stretch the background image full as with container',
			),
			array(
				'id'	 => 'parallax',
				'type'	 => 'on_off',
				'title'	 => 'Parallax',
			),
			array(
				'id'		 => 'speed',
				'type'		 => 'text',
				'title'		 => 'Parallax SpeedFactor',
				'attributes' => array(
					'placeholder' => 0.4,
				),
				'dependency' => array( 'parallax', '==', 'true' ),
			),
			array(
				'id'	 => 'overlay',
				'type'	 => 'on_off',
				'title'	 => 'Overlay',
			),
			array(
				'id'		 => 'overlay_color',
				'type'		 => 'color_picker',
				'title'		 => 'Overlay Color',
				'dependency' => array( 'overlay', '==', 'true' ),
			),
			array(
				'id'		 => 'overlay_opacity',
				'type'		 => 'text',
				'title'		 => 'Overlay Opacity',
				'attributes' => array(
					'placeholder' => 0.5,
				),
				'dependency' => array( 'overlay', '==', 'true' ),
			),
			array(
				'id'	 => 'video',
				'type'	 => 'on_off',
				'title'	 => 'Video Header',
			),
			array(
				'id'		 => 'mp4',
				'type'		 => 'upload',
				'title'		 => 'video/mp4',
				'settings'	 => array(
					'upload_type'	 => 'video',
					'insert_title'	 => 'Use This Video',
					'button_title'	 => 'Upload / MP4',
				),
				'dependency' => array( 'video', '==', 'true' ),
			),
			array(
				'id'		 => 'ogv',
				'type'		 => 'upload',
				'title'		 => 'video/ogv',
				'settings'	 => array(
					'upload_type'	 => 'video',
					'insert_title'	 => 'Use This Video',
					'button_title'	 => 'Upload / OGV',
				),
				'dependency' => array( 'video', '==', 'true' ),
			),
			array(
				'id'		 => 'webm',
				'type'		 => 'upload',
				'title'		 => 'video/webm',
				'settings'	 => array(
					'upload_type'	 => 'video',
					'insert_title'	 => 'Use This Video',
					'button_title'	 => 'Upload / WEBM',
				),
				'dependency' => array( 'video', '==', 'true' ),
			),
			array(
				'id'		 => 'muted',
				'type'		 => 'on_off',
				'title'		 => 'Muted',
				'dependency' => array( 'video', '==', 'true' ),
			),
			array(
				'id'		 => 'loop',
				'type'		 => 'on_off',
				'title'		 => 'Loop',
				'dependency' => array( 'video', '==', 'true' ),
			),
		)
	),
	'extras'		 => array(
		'title'	 => "Extras",
		'fields' => array(
			array(
				'id'	 => 'disable_header',
				'type'	 => 'on_off',
				'title'	 => 'Disable Page Header',
			),
//      array(
//        'id'        => 'breadcrumb',
//        'type'      => 'on_off',
//        'title'     => 'Disable Breadcrumb',
//      ),
			array(
				'id'	 => 'disable_title',
				'type'	 => 'on_off',
				'title'	 => 'Disable Title',
			),
			array(
				'id'	 => 'disable_top_bar',
				'type'	 => 'on_off',
				'title'	 => 'Disable Site Top-Bar',
			),
			array(
				'id'	 => 'disable_footer',
				'type'	 => 'on_off',
				'title'	 => 'Disable Site Footer',
			),
			array(
				'id'	 => 'one_page_footer',
				'type'	 => 'on_off',
				'title'	 => 'Show Footer in One-Page Template',
			),
			array(
				'id'	 => 'force_show_header',
				'type'	 => 'on_off',
				'title'	 => 'Force Show Header in Front page display',
			),
			array(
				'id'	 => 'hide_featured_image',
				'type'	 => 'on_off',
				'title'	 => 'Hide Featured Image',
			),
			array(
				'id'		 => 'header_before',
				'type'		 => 'textarea',
				'shortcode'	 => true,
				'title'		 => 'Site Header Before Content',
				'info'		 => 'eg. you can add a revolution slider for start page'
			),
		)
	)
);

// pages custom metabox
$metaboxes[ 'page' ] = array(
	'id'		 => '_page_custom_box',
	'title'		 => "Page Custom Options",
	'post_type'	 => 'page',
	'context'	 => 'normal',
	'priority'	 => 'high',
	'sections'	 => $header_options
);


// posts custom metabox
$metaboxes[ 'post' ] = array(
	'id'		 => '_page_custom_box',
	'title'		 => "Page Custom Options",
	'post_type'	 => 'post',
	'context'	 => 'normal',
	'priority'	 => 'high',
	'sections'	 => $header_options
);

// posts custom metabox
$metaboxes[ 'product' ] = array(
	'id'		 => '_page_custom_box',
	'title'		 => "Page Custom Options",
	'post_type'	 => 'product',
	'context'	 => 'normal',
	'priority'	 => 'high',
	'sections'	 => $header_options
);

global $wp_registered_sidebars;
$sidebar_widgets = array();

if ( !empty( $wp_registered_sidebars ) ) {
	foreach ( $wp_registered_sidebars as $key => $value ) {
		$sidebar_widgets[ $key ] = $value[ 'name' ];
	}
}

$metaboxes[ 'post_sidebar' ] = array(
	'id'		 => '_sidebar',
	'title'		 => "Post Sidebar Model",
	'post_type'	 => 'post',
	'context'	 => 'side',
	'priority'	 => 'low',
	'sections'	 => array(
		'post-sidebar' => array(
			'title'	 => "Post Sidebar",
			'fields' => array(
				array(
					'id'		 => 'sidebar',
					'type'		 => 'image_select',
					'radio'		 => true,
					'options'	 => $sidebars,
					'default'	 => array( 'full' ),
					'attributes' => array(
						'data-depend-id' => 'page_sidebars'
					)
				),
				array(
					'id'			 => 'sidebar_widget',
					'type'			 => 'select',
					'options'		 => array_reverse( $sidebar_widgets ),
					'default_option' => 'Choose a custom sidebar',
					'dependency'	 => array( 'page_sidebars', 'any', '["right", "left"]' ),
				)
			)
		),
	),
);


$metaboxes[ 'page_sidebar' ] = array(
	'id'		 => '_sidebar',
	'title'		 => "Page Sidebar Model",
	'post_type'	 => 'page',
	'context'	 => 'side',
	'priority'	 => 'low',
	'sections'	 => array(
		'page-sidebar' => array(
			'title'	 => "Page Sidebar",
			'fields' => array(
				array(
					'id'		 => 'sidebar',
					'type'		 => 'image_select',
					'radio'		 => true,
					'options'	 => $sidebars,
					'default'	 => array( 'full' ),
					'attributes' => array(
						'data-depend-id' => 'page_sidebars'
					)
				),
				array(
					'id'			 => 'sidebar_widget',
					'type'			 => 'select',
					'options'		 => array_reverse( $sidebar_widgets ),
					'default_option' => 'Choose a custom sidebar',
					'dependency'	 => array( 'page_sidebars', 'any', '["right", "left"]' ),
				)
			)
		),
	),
);

//
// Add Metaboxes for LearnDash
//
if ( defined( 'LEARNDASH_VERSION' ) ) {

	$leardash_post_types = array(
		'sfwd-courses',
		'sfwd-lessons',
		'sfwd-topic',
		'sfwd-quiz',
		'sfwd-certificates',
		'sfwd-assignment',
		'sfwd-groups'
	);

	foreach ( $leardash_post_types as $ld_type ) {

		$metaboxes[ $ld_type ] = array(
			'id'		 => '_page_custom_box',
			'title'		 => "Page Custom Options",
			'post_type'	 => $ld_type,
			'context'	 => 'normal',
			'priority'	 => 'high',
			'sections'	 => $header_options
		);

		$metaboxes[ $ld_type . '_sidebar' ] = array(
			'id'		 => '_sidebar',
			'title'		 => "Sidebar",
			'post_type'	 => $ld_type,
			'context'	 => 'side',
			'priority'	 => 'low',
			'sections'	 => array(
				'sidebar' => array(
					'title'	 => "Sidebar",
					'fields' => array(
						array(
							'id'		 => 'sidebar',
							'type'		 => 'image_select',
							'radio'		 => true,
							'options'	 => $sidebars,
							'default'	 => array( 'right' ),
							'attributes' => array(
								'data-depend-id' => 'page_sidebars'
							)
						),
						array(
							'id'			 => 'sidebar_widget',
							'type'			 => 'select',
							'options'		 => array_reverse( $sidebar_widgets ),
							'default_option' => 'Choose a custom sidebar',
							'dependency'	 => array( 'page_sidebars', 'any', '["right", "left"]' ),
						)
					)
				),
			),
		);
	}
}

new CSFramework_Metabox_API( $metaboxes );

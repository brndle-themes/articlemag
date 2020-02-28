<?php
// Cannot access directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 *
 * About Widget
 *
 * @since 1.0.0
 * @version 1.0.0
 */
CSF::createWidget(
	'about_cs_widget',
	array(
		'title'       => '- About us',
		'classname'   => 'cs_widget_about',
		'description' => 'About us Widget.',
		'fields'      => array(
			array(
				'id'    => 'title',
				'type'  => 'text',
				'title' => 'Widget Title',
			),
			array(
				'id'    => 'img',
				'type'  => 'upload',
				'title' => 'About us - Logo',
			),
			array(
				'id'      => 'logo_text',
				'type'    => 'textarea',
				'title'   => 'Logo Text',
				'default' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
			),
			array(
				'id'      => 'address',
				'type'    => 'text',
				'title'   => 'Address',
				'default' => 'Address:',
			),
			array(
				'id'      => 'address_text',
				'type'    => 'textarea',
				'title'   => 'Address Text',
				'default' => '3060 Duncan Avenue<br />Garden City, NY 11530',
			),
			array(
				'id'      => 'phone',
				'type'    => 'text',
				'title'   => 'Phone',
				'default' => 'Phone:',
			),
			array(
				'id'      => 'phone_text',
				'type'    => 'text',
				'title'   => 'Phone Text',
				'default' => '0800 555 5555',
			),
			array(
				'id'      => 'empty',
				'type'    => 'text',
				'title'   => 'Empty',
				'default' => ' ',
			),
			array(
				'id'      => 'empty_text',
				'type'    => 'text',
				'title'   => 'Empty Text',
				'default' => ' ',
			),
			array(
				'id'      => 'mail',
				'type'    => 'text',
				'title'   => 'E-Mail',
				'default' => 'E-Mail:',
			),
			array(
				'id'      => 'mail_text',
				'type'    => 'text',
				'title'   => 'E-Mail Text',
				'default' => 'info@domain.com',
			),
			array(
				'id'      => 'web',
				'type'    => 'text',
				'title'   => 'Web',
				'default' => 'Web',
			),
			array(
				'id'      => 'web_text',
				'type'    => 'text',
				'title'   => 'Web Text',
				'default' => 'domain.com',
			),
			array(
				'id'      => 'web_url',
				'type'    => 'text',
				'title'   => 'Web URL',
				'default' => 'http://domain.com',
			),
		),
	)
);


if ( ! function_exists( 'about_cs_widget' ) ) {
	/**
	 * [about_cs_widget Front-end display of about us widget]
	 *
	 * @param  [type] $args     [description]
	 * @param  [type] $instance [description]
	 * @return [type]           [description]
	 */
	function about_cs_widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance );
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}
		echo '<div class="textwidget">';
		echo '<p>';
		echo ( ! empty( $instance['img'] ) ) ? '<img src="' . $instance['img'] . '" class="footer-logo-left" alt="" />' : '';
		echo $instance['logo_text'];
		echo '</p>';
		echo '<p>';
		echo ( ! empty( $instance['address'] ) ) ? '<strong class="about-strong">' . $instance['address'] . '</strong> ' : '';
		echo ( ! empty( $instance['address_text'] ) ) ? $instance['address_text'] . '<br />' : '';
		echo ( ! empty( $instance['phone'] ) ) ? '<strong class="about-strong">' . $instance['phone'] . '</strong> ' : '';
		echo ( ! empty( $instance['phone_text'] ) ) ? $instance['phone_text'] . '<br />' : '';
		echo ( ! empty( $instance['empty'] ) ) ? '<strong class="about-strong">' . $instance['empty'] . '</strong> ' : '';
		echo ( ! empty( $instance['empty_text'] ) ) ? $instance['empty_text'] . '<br />' : '';
		echo ( ! empty( $instance['mail'] ) ) ? '<strong class="about-strong">' . $instance['mail'] . '</strong> ' : '';
		echo ( ! empty( $instance['mail_text'] ) ) ? '<a href="mailto:' . $instance['mail_text'] . '">' . $instance['mail_text'] . '</a><br />' : '';
		echo ( ! empty( $instance['web'] ) ) ? '<strong class="about-strong">' . $instance['web'] . '</strong> ' : '';
		echo ( ! empty( $instance['web_text'] ) ) ? '<a href="' . esc_url( $instance['web_url'] ) . '">' . $instance['web_text'] . '</a>' : '';
		echo '</p>';
		echo '</div><div class="clear"></div>';
		echo $args['after_widget'];
	}
}

/**
 *
 * Flickr Widget
 *
 * @since 1.0.0
 * @version 1.0.0
 */
CSF::createWidget(
	'flickr_cs_widget',
	array(
		'title'       => '- Flickr Photo Stream',
		'classname'   => 'cs_widget_flickr',
		'description' => 'Flickr Photo Stream Widget',
		'fields'      => array(
			array(
				'id'    => 'title',
				'type'  => 'text',
				'title' => 'Widget Title',
			),
			array(
				'id'      => 'type',
				'type'    => 'select',
				'title'   => 'Type',
				'options' => array(
					'user' => 'user',
					'set'  => 'set',
				),
				'default' => 'user',
			),
			array(
				'id'      => 'flickr_id',
				'type'    => 'text',
				'title'   => 'Flickr User ID',
				'default' => '17423713@N03',
				'desc'    => 'Find your Flickr ID <a href="http://idgettr.com/" target="_blank">idGettr</a>',
			),
			array(
				'id'      => 'count',
				'type'    => 'text',
				'title'   => 'Count',
				'default' => '9',
			),
			array(
				'id'      => 'ordering',
				'type'    => 'select',
				'title'   => 'Ordering your images',
				'options' => array(
					'latest' => 'Latest',
					'random' => 'Random',
				),
				'default' => 'random',
			),
			array(
				'id'      => 'size',
				'type'    => 'select',
				'title'   => 'Size of your images',
				'options' => array(
					's' => 'Small square box',
					't' => 'Thumbnail size',
					'm' => 'Medium size',
				),
				'default' => 's',
			),
		),
	)
);


if ( ! function_exists( 'flickr_cs_widget' ) ) {
	/**
	 * [flickr_cs_widget Front-end display of flicker widget]
	 *
	 * @param  [type] $args
	 * @param  [type] $instance
	 */
	function flickr_cs_widget( $args, $instance ) {
				extract( $args );
				$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance );
				echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}
				echo '<div class="cs_flickr_widget">';
				$source = ( $instance['type'] == 'set' ) ? 'source=user_set&set=' : 'source=user&user=';
				echo '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne? count=' . $instance['count'] . '&display=' . $instance['ordering'] . '&size=' . $instance['size'] . '&' . $source . $instance['flickr_id'] . '"></script>';
				echo '</div><div class="clear"></div>';
		echo $args['after_widget'];
	}
}

/**
 *
 * Blog Posts
 *
 * @since 1.0.0
 * @version 1.0.0
 */
CSF::createWidget(
	'blog_posts_cs_widget',
	array(
		'title'       => '- Blog Posts',
		'classname'   => 'cs_widget_custom_posts',
		'description' => 'Recent, Popular, Related Blog Posts.',
		'fields'      => array(
			array(
				'id'    => 'title',
				'type'  => 'text',
				'title' => 'Widget Title',
			),
			array(
				'id'      => 'type',
				'type'    => 'select',
				'title'   => 'Type',
				'options' => array(
					'recent'    => 'Recent Posts',
					'related'   => 'Related Posts',
					'random'    => 'Random Posts',
					'commented' => 'Most Commented Posts',
					'loved'     => 'Most Loved Posts',
				),
				'default' => 'random',
			),
			array(
				'id'         => 'cats',
				'type'       => 'checkbox',
				'title'      => 'Categories (optional)',
				'options'    => 'categories',
				'query_args' => array(
					'order'    => 'ASC',
					'taxonomy' => 'category',
				),
				'desc'       => 'Default: All categories selected.',
			),
			array(
				'id'      => 'limit',
				'type'    => 'text',
				'title'   => 'Number of posts to show',
				'default' => 5,
			),
			array(
				'id'      => 'image_size',
				'type'    => 'select',
				'title'   => 'Image Size',
				'options' => cs_get_image_sizes( true, false ),
				'default' => 'thumbnail',
			),
			array(
				'id'      => 'display_image',
				'type'    => 'switcher',
				'label'   => 'Display post image ?',
				'default' => true,
			),
			array(
				'id'      => 'full_width_image',
				'type'    => 'switcher',
				'label'   => 'Use 100% width image',
				'default' => false,
			),
			array(
				'id'      => 'display_date',
				'type'    => 'switcher',
				'label'   => 'Display post date ?',
				'default' => true,
			),
			array(
				'id'      => 'display_category',
				'type'    => 'switcher',
				'label'   => 'Display post category ?',
				'default' => false,
			),
		),
	)
);

if ( ! function_exists( 'blog_posts_cs_widget' ) ) {
	/**
	 * [blog_posts_cs_widget Front-end display of blog-post widget]
	 *
	 * @param  [type] $args     [description]
	 * @param  [type] $instance [description]
	 * @return [type]           [description]
	 */
	function blog_posts_cs_widget( $args, $instance ) {
		global $wp_query, $paged, $post;

		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance );

		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		echo '<div class="cs_blog_posts_widget">';

		// Query
		$args = array(
			'posts_per_page' => $instance['limit'],
			'post_type'      => 'post',
		);

		if ( isset( $instance['cats'] ) ) {
			$cats_exp    = ( is_array( $instance['cats'] ) ) ? implode( ',', $instance['cats'] ) : $instance['cats'];
			$args['cat'] = $cats_exp;
		}

		switch ( $instance['type'] ) {

			case 'commented':
				$args['orderby'] = 'comment_count';
				break;

			case 'random':
				$args['orderby'] = 'rand';
				break;

			case 'related':
				$tags = wp_get_post_tags( $post->ID );
				$ids  = array();

				if ( ! empty( $tags ) ) {
					foreach ( $tags as $term ) {
						$ids[] = $term->term_id;
					}
				} else {
					$operation = false;
				}

				$args['tag__in']      = $ids;
				$args['post__not_in'] = array( $post->ID );
				$args['orderby']      = 'rand';

				break;

			case 'loved':
				$args['meta_key'] = '_love_count';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';

				break;

			default:
				$args['orderby'] = 'date';
				break;
		}

		$tmp_query = $wp_query;
		$wp_query  = new WP_Query( $args );

		if ( have_posts() ) :

			$is_full    = ( ! empty( $instance['full_width_image'] ) ) ? true : false;
			$with_image = ( ! empty( $instance['display_image'] ) && ! $is_full ) ? 'cs-with-image' : '';
			$full_image = ( $is_full ) ? ' cs-full-with-image' : '';
			$image_size = ( ! empty( $instance['image_size'] ) ) ? $instance['image_size'] : 'thumbnail';

			echo '<ul class="' . $with_image . $full_image . '">';
			while ( have_posts() ) :
				the_post();

				$format = ( get_post_format() ) ? get_post_format() : 'standard';
				$image  = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size );
				$image  = ( ! empty( $image ) ) ? '<img src="' . $image[0] . '" alt="' . get_the_title() . '" />' : '<img src="' . THEME_URI . '/images/no-pictures/no-' . $format . '-picture.png" alt="No Video Picture" />';
				$image  = ( $instance['display_image'] ) ? $image : '';

				$categories = get_the_category();
				$post_cats  = array();

				if ( ! empty( $categories ) ) {
					foreach ( $categories as $category ) {
						$post_cats[] = $category->name;
					}
				}

				$post_cats = implode( ' &bull; ', $post_cats );

				echo '<li>';
				echo '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . $image . get_the_title() . '</a>';
				echo ( $instance['display_date'] ) ? '<span class="post-date"><i class="fa fa-clock-o"></i> ' . get_the_date() . '</span>' : '';
				echo ( $instance['display_category'] ) ? '<span class="post-category"><i class="fa fa-folder-o"></i> ' . $post_cats . '</span>' : '';
				echo '</li>';

			endwhile;
			echo '</ul>';

		endif;

		wp_reset_query();
		wp_reset_postdata();
		$wp_query = $tmp_query;

		echo '</div><div class="clear"></div>';

		echo $after_widget;
	}
}


/**
 *
 * Side Menu Widget
 *
 * @since 1.0.0
 * @version 4.3.0
 */
CSF::createWidget(
	'side_menu_cs_widget',
	array(
		'title'       => '- Side Menu',
		'classname'   => 'widget_nav_menu',
		'description' => 'Side menu instead of top menus.',
		'fields'      => array(
			array(
				'id'    => 'title',
				'type'  => 'text',
				'title' => 'Title',
			),
		),
	)
);

if ( ! function_exists( 'side_menu_cs_widget' ) ) {
	/**
	 * [side_menu_cs_widget description]
	 *
	 * @param  [type] $args     [description]
	 * @param  [type] $instance [description]
	 */
	function side_menu_cs_widget( $args, $instance ) {
		if ( is_page() ) {

			extract( $args );

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance );

			global $post;

			$children = get_pages( array( 'child_of' => $post->ID ) );

			if ( ! empty( $children ) ) {
				$post_id = $post->ID;
			} else {
				$post_id = $post->post_parent;
			}

			$list_pages = wp_list_pages(
				array(
					'sort_column' => 'menu_order',
					'title_li'    => '',
					'echo'        => 0,
					'depth'       => 1,
					'child_of'    => $post_id,
				)
			);

			// widget content
			if ( ! empty( $list_pages ) ) {

				echo $before_widget;

				if ( ! empty( $title ) ) {
					echo $before_title . $title . $after_title;
				}

				echo '<ul>';
				echo str_replace( 'current_page_item', 'current_page_item current-menu-item', $list_pages );
				echo '</ul>';
			}

			echo $after_widget;
		}
	}
}

<?php

/**
 *
 * About Widget
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class CS_About_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'cs_widget_about',
			'description' => 'About us Widget.',
		);
		parent::__construct( 'about_cs_widget', '- About us', $widget_ops );
	}

	function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
		}

		echo '<div class="textwidget">';

		echo '<p>';
		echo ( ! empty( $instance['img'] ) ) ? '<img src="' . $instance['img'] . '" class="footer-logo-left" alt="' .esc_html__('Footer Logo', 'articlemag').'" />' : '';
		echo $instance['logo_text']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
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

		echo $after_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
	}

	function update( $new_instance, $old_instance ) {

		$instance                 = $old_instance;
		$instance['title']        = $new_instance['title'];
		$instance['img']          = $new_instance['img'];
		$instance['logo_text']    = $new_instance['logo_text'];
		$instance['address']      = $new_instance['address'];
		$instance['address_text'] = $new_instance['address_text'];
		$instance['phone']        = $new_instance['phone'];
		$instance['phone_text']   = $new_instance['phone_text'];
		$instance['empty']        = $new_instance['empty'];
		$instance['empty_text']   = $new_instance['empty_text'];
		$instance['mail']         = $new_instance['mail'];
		$instance['mail_text']    = $new_instance['mail_text'];
		$instance['web']          = $new_instance['web'];
		$instance['web_text']     = $new_instance['web_text'];
		$instance['web_url']      = $new_instance['web_url'];

		return $instance;
	}

	function form( $instance ) {
		//
		// $instance = wp_parse_args(
		// (array) $instance,
		// array(
		// 'title'        => '',
		// 'img'          => '',
		// 'logo_text'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
		// 'address'      => 'Address:',
		// 'address_text' => '3060 Duncan Avenue<br />Garden City, NY 11530',
		// 'phone'        => 'Phone:',
		// 'phone_text'   => '0800 555 5555',
		// 'empty'        => '',
		// 'empty_text'   => '',
		// 'mail'         => 'mail',
		// 'mail_text'    => 'info@domain.com',
		// 'web'          => 'Web',
		// 'web_text'     => 'domain.com',
		// 'web_url'      => 'http://domain.com',
		// )
		// );

		$title        = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$img          = ! empty( $instance['img'] ) ? $instance['img'] : '';
		$logo_text    = ! empty( $instance['logo_text'] ) ? $instance['logo_text'] : 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
		$address      = ! empty( $instance['address'] ) ? $instance['address'] : 'Address:';
		$address_text = ! empty( $instance['address_text'] ) ? $instance['address_text'] : '3060 Duncan Avenue, Garden City, NY 11530';
		$phone        = ! empty( $instance['phone'] ) ? $instance['phone'] : 'Phone:';
		$phone_text   = ! empty( $instance['phone_text'] ) ? $instance['phone_text'] : '0800 555 5555';
		$empty        = ! empty( $instance['empty'] ) ? $instance['empty'] : '';
		$empty_text   = ! empty( $instance['empty_text'] ) ? $instance['empty_text'] : '';
		$mail         = ! empty( $instance['mail'] ) ? $instance['mail'] : 'E-mail';
		$mail_text    = ! empty( $instance['mail_text'] ) ? $instance['mail_text'] : 'info@domain.com';
		$web          = ! empty( $instance['web'] ) ? $instance['web'] : 'Web';
		$web_text     = ! empty( $instance['web_text'] ) ? $instance['web_text'] : 'domain.com';
		$web_url      = ! empty( $instance['web_url'] ) ? $instance['web_url'] : 'http://domain.com';

		// WIDGET TITLE
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'title' ),
				'name'  => $this->get_field_name( 'title' ),
				'type'  => 'text',
				'title' => 'Widget Title',
			),
			$title
		);

		// IMAGE - TEXT
		cs_get_field(
			array(
				'id'           => $this->get_field_name( 'img' ),
				'name'         => $this->get_field_name( 'img' ),
				'type'         => 'upload',
				'title'        => 'About us - Logo',
				'library'      => 'image',
				'button_title' => 'Upload',
			),
			$img
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'logo_text' ),
				'name'  => $this->get_field_name( 'logo_text' ),
				'type'  => 'textarea',
				'title' => 'Logo Text',
			),
			$logo_text
		);

		// ADDRESS
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'address' ),
				'name'  => $this->get_field_name( 'address' ),
				'type'  => 'text',
				'title' => 'Address',
			),
			$address
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'address_text' ),
				'name'  => $this->get_field_name( 'address_text' ),
				'type'  => 'textarea',
				'title' => 'Address Text',
			),
			$address_text
		);

		// PHONE
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'phone' ),
				'name'  => $this->get_field_name( 'phone' ),
				'type'  => 'text',
				'title' => 'Phone',
			),
			$phone
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'phone_text' ),
				'name'  => $this->get_field_name( 'phone_text' ),
				'type'  => 'text',
				'title' => 'Phone Text',
			),
			$phone_text
		);

		// EMPTY
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'empty' ),
				'name'  => $this->get_field_name( 'empty' ),
				'type'  => 'text',
				'title' => 'Empty',
			),
			$empty
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'empty_text' ),
				'name'  => $this->get_field_name( 'empty_text' ),
				'type'  => 'text',
				'title' => 'Empty Text',
			),
			$empty_text
		);

		// MAIL
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'mail' ),
				'name'  => $this->get_field_name( 'mail' ),
				'type'  => 'text',
				'title' => 'E-Mail',
			),
			$mail
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'mail_text' ),
				'name'  => $this->get_field_name( 'mail_text' ),
				'type'  => 'text',
				'title' => 'E-Mail Text',
			),
			$mail_text
		);

		// WEB
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'web' ),
				'name'  => $this->get_field_name( 'web' ),
				'type'  => 'text',
				'title' => 'Web',
			),
			$web
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'web_text' ),
				'name'  => $this->get_field_name( 'web_text' ),
				'type'  => 'text',
				'title' => 'Web Text',
			),
			$web_text
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'web_url' ),
				'name'  => $this->get_field_name( 'web_url' ),
				'type'  => 'text',
				'title' => 'Web URL',
			),
			$web_url
		);
	}

}

/**
 *
 * Blog Posts
 *
 * @since 1.0.0
 * @version 1.0.0
 */
class CS_Blog_Posts_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'cs_widget_custom_posts',
			'description' => 'Recent, Popular, Related Blog Posts',
		);
		parent::__construct( 'blog_posts_cs_widget', '- Blog Posts', $widget_ops );
	}

	function widget( $args, $instance ) {

		global $wp_query, $paged, $post;

		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
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

		echo $after_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
	}

	function update( $new_instance, $old_instance ) {

		$instance                     = $old_instance;
		$instance['title']            = $new_instance['title'];
		$instance['type']             = $new_instance['type'];
		$instance['cats']             = $new_instance['cats'];
		$instance['limit']            = $new_instance['limit'];
		$instance['display_image']    = $new_instance['display_image'];
		$instance['display_date']     = $new_instance['display_date'];
		$instance['display_category'] = $new_instance['display_category'];
		$instance['full_width_image'] = $new_instance['full_width_image'];
		$instance['image_size']       = $new_instance['image_size'];

		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'            => '',
				'type'             => 'random',
				'cats'             => 0,
				'limit'            => 5,
				'display_image'    => 1,
				'display_date'     => 1,
				'display_category' => 0,
				'full_width_image' => false,
				'image_size'       => 'thumbnail',
			)
		);

		$title            = $instance['title'];
		$type             = $instance['type'];
		$cats             = $instance['cats'];
		$limit            = $instance['limit'];
		$display_image    = $instance['display_image'];
		$display_date     = $instance['display_date'];
		$display_category = $instance['display_category'];
		$full_width_image = $instance['full_width_image'];
		$image_size       = $instance['image_size'];

		// WIDGET TITLE
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'title' ),
				'name'  => $this->get_field_name( 'title' ),
				'type'  => 'text',
				'title' => 'Widget Title',
			),
			$title
		);
		cs_get_field(
			array(
				'id'      => $this->get_field_name( 'type' ),
				'name'    => $this->get_field_name( 'type' ),
				'type'    => 'select',
				'title'   => 'Type',
				'options' => array(
					'recent'    => 'Recent Posts',
					'related'   => 'Related Posts',
					'random'    => 'Random Posts',
					'commented' => 'Most Commented Posts',
					'loved'     => 'Most Loved Posts',
				),
			),
			$type
		);

		// FIELDS
		cs_get_field(
			array(
				'id'         => $this->get_field_name( 'cats' ),
				'name'       => $this->get_field_name( 'cats' ) . '[]',
				'type'       => 'checkbox',
				'title'      => 'Categories (optional)',
				'options'    => 'categories',
				'query_args' => array(
					'order'    => 'ASC',
					'taxonomy' => 'category',
				),
				'desc'       => 'Default: All categories selected.',
			),
			$cats
		);

		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'limit' ),
				'name'  => $this->get_field_name( 'limit' ),
				'type'  => 'text',
				'title' => 'Number of posts to show',
			),
			$limit
		);
		cs_get_field(
			array(
				'id'      => $this->get_field_name( 'image_size' ),
				'name'    => $this->get_field_name( 'image_size' ),
				'type'    => 'select',
				'title'   => 'Image Size',
				'options' => cs_get_image_sizes( true, false ),
				'default' => 'thumbnail',
			),
			$image_size
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'display_image' ),
				'name'  => $this->get_field_name( 'display_image' ),
				'type'  => 'switcher',
				'label' => 'Display post image ?',
			),
			$display_image
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'full_width_image' ),
				'name'  => $this->get_field_name( 'full_width_image' ),
				'type'  => 'switcher',
				'label' => 'Use 100% width image',
			),
			$full_width_image
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'display_date' ),
				'name'  => $this->get_field_name( 'display_date' ),
				'type'  => 'switcher',
				'label' => 'Display post date ?',
			),
			$display_date
		);
		cs_get_field(
			array(
				'id'    => $this->get_field_name( 'display_category' ),
				'name'  => $this->get_field_name( 'display_category' ),
				'type'  => 'switcher',
				'label' => 'Display post category ?',
			),
			$display_category
		);
	}

}

/**
 *
 * Side Menu Widget
 *
 * @since 1.0.0
 * @version 4.3.0
 */
class CS_Side_Menu_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_nav_menu',
			'description' => 'Side menu instead of top menus.',
		);
		parent::__construct( 'side_menu_cs_widget', '- Side Menu', $widget_ops );
	}

	function widget( $args, $instance ) {

		if ( is_page() ) {

			extract( $args );

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

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

				echo $before_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output

				if ( ! empty( $title ) ) {
					echo $before_title . $title . $after_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
				}

				echo '<ul>';
				echo str_replace( 'current_page_item', 'current_page_item current-menu-item', $list_pages );
				echo '</ul>';
			}

			echo $after_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output
		}
	}

	function update( $new_instance, $old_instance ) {

		$instance          = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title    = strip_tags( $instance['title'] );
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">Title</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		<?php
	}

}

/**
 *
 * CSFramework Widgets Config
 *
 * @since 1.0.0
 * @version 1.1.0
 */
function custom_widgets_init() {
	register_widget( 'CS_About_Widget' );
	register_widget( 'CS_Blog_Posts_Widget' );
	register_widget( 'CS_Side_Menu_Widget' );
}

add_action( 'widgets_init', 'custom_widgets_init', 2 );

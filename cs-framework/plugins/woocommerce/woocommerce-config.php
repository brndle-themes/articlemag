<?php
//
// Ajax WooCommerce - Add Card - Add Contents
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_top_bar_ajax' ) ) {

	function cs_woocommerce_top_bar_ajax( $fragments ) {
		global $woocommerce;

		ob_start();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();

		$fragments[ '.cs-mini-cart' ]		 = '<div class="cs-mini-cart">' . $mini_cart . '</div>';
		$fragments[ '.cs-cart-count' ]	 = '<span class="cs-cart-count">' . $woocommerce->cart->cart_contents_count . '</span>';
		$fragments[ '.cs-cart-contents' ]	 = '<span class="cs-cart-contents">' . sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes' ), $woocommerce->cart->cart_contents_count ) . ' - ' . $woocommerce->cart->get_cart_total() . '</span>';

		return $fragments;
	}

	add_filter( 'woocommerce_add_to_cart_fragments', 'cs_woocommerce_top_bar_ajax' );
}

//
// Add WooCommerce Support
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_support' ) ) {

	function cs_woocommerce_support() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	add_action( 'after_setup_theme', 'cs_woocommerce_support' );
}

//
// Remove WooCommerce Main Style
// ------------------------------------------------------------------------------
if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
	define( 'WOOCOMMERCE_USE_CSS', false );
}

//
// Add Articlemag WooCommerce Main Style
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_style' ) ) {

	function cs_woocommerce_style() {
		wp_enqueue_style( 'cs-woocommerce', THEME_URI . '/css/vendor/woocommerce.css', array(), time() );
	}

	add_action( 'wp_enqueue_scripts', 'cs_woocommerce_style' );
}

//
// Remove WooCommerce BreadCrumbs
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_remove_wc_breadcrumbs' ) ) {

	function cs_remove_wc_breadcrumbs() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}

	add_action( 'init', 'cs_remove_wc_breadcrumbs' );
}

//
// Remove Shop Sidebar
// ------------------------------------------------------------------------------
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

//
// Register Shop Sidebar
// ------------------------------------------------------------------------------
register_sidebar( array(
	'name'			 => 'Shop Sidebar',
	'id'			 => 'shop-sidebar',
	'description'	 => 'Drag widgets for all of shop sidebar',
	'before_widget'	 => '<section class="articlemag_widget %2$s">',
	'after_widget'	 => '</section>',
	'before_title'	 => '<div class="widget-title"><h4>',
	'after_title'	 => '</h4></div>'
) );

//
// Remove Lightbox Styles and Scripts
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_remove_scripts' ) ) {

	function cs_woocommerce_remove_scripts() {
		wp_dequeue_script( 'prettyPhoto' );
		wp_dequeue_script( 'prettyPhoto-init' );
	}

	add_action( 'wp_print_scripts', 'cs_woocommerce_remove_scripts' );
}

if ( !function_exists( 'cs_woocommerce_remove_styles' ) ) {

	function cs_woocommerce_remove_styles() {
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
	}

	add_action( 'wp_print_styles', 'cs_woocommerce_remove_styles', 99 );
}

//
// Loop Columns
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_loop_shop_columns' ) ) {

	function cs_loop_shop_columns() {
		$columns = cs_get_option( 'woo_loop_columns', 4 );
		return $columns;
	}

	add_filter( 'loop_shop_columns', 'cs_loop_shop_columns', 99 );
}

//
// Related Columns
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_output_related_products_args' ) ) {

	function cs_woocommerce_output_related_products_args( $args ) {

		$columns = cs_get_option( 'woo_related_columns', 4 );
		$args	 = array(
			'posts_per_page' => $columns,
			'columns'		 => $columns,
			'orderby'		 => 'rand'
		);

		return $args;
	}

	add_filter( 'woocommerce_output_related_products_args', 'cs_woocommerce_output_related_products_args', 99 );
}

//
// Up-Sells ( You may also like ) Columns
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_after_single_product_summary' ) ) {
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

	function cs_woocommerce_after_single_product_summary() {
		$columns = cs_get_option( 'woo_upsells_columns', 4 );
		woocommerce_upsell_display( $columns, $columns );
	}

	add_action( 'woocommerce_after_single_product_summary', 'cs_woocommerce_after_single_product_summary', 15 );
}

//
// Cross-Sells ( You may also like ) Columns : Cart Page
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_cross_sells_columns' ) ) {

	function cs_woocommerce_cross_sells_columns() {
		$columns = cs_get_option( 'woo_upsells_columns', 4 );
		return $columns;
	}

	add_filter( 'woocommerce_cross_sells_total', 'cs_woocommerce_cross_sells_columns' );
	add_filter( 'woocommerce_cross_sells_columns', 'cs_woocommerce_cross_sells_columns' );
}

//
// Product Thumbnail Hover Effect
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_before_shop_loop_item_title' ) ) {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

	function cs_woocommerce_before_shop_loop_item_title() {
		echo cs_woocommerce_get_product_thumbnail();
	}

	add_action( 'woocommerce_before_shop_loop_item_title', 'cs_woocommerce_before_shop_loop_item_title', 10 );
}

if ( !function_exists( 'cs_woocommerce_get_product_thumbnail' ) ) {

	function cs_woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0 ) {

		global $post, $product, $woocommerce;
		$image_ids = $product->get_gallery_image_ids();

		$output = '';

		if ( has_post_thumbnail() ) {

			$output	 .= '<div class="cs-product-images">';
			$output	 .= '<div class="primary-img">' . get_the_post_thumbnail( $post->ID, $size ) . '</div>';

			if ( !empty( $image_ids ) ) {
				$secondary_image_id	 = $image_ids[ '0' ];
				$output				 .= '<div class="secondary-img">' . wp_get_attachment_image( $secondary_image_id, $size ) . '</div>';
			}

			$output .= (!$product->is_in_stock() ) ? '<span class="out-of-stock">' . __( 'Out of stock', 'woocommerce' ) . '</span>' : '';

			$output .= '</div>';
		} elseif ( wc_placeholder_img_src() ) {

			$output	 .= '<div class="cs-product-images">';
			$output	 .= wc_placeholder_img( $size );
			$output	 .= '</div>';
		}


		return $output;
	}

}


//
// Order Again
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_order_again_button' ) ) {
	remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );

	function cs_woocommerce_order_again_button( $order ) {
		if ( !$order || $order->status != 'completed' )
			return;
		?>
		<p class="order-again">
			<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'order_again', $order->id ), 'woocommerce-order_again' ) ); ?>" class="button <?php echo cs_get_button_class(); ?>"><i class="fa fa-refresh"></i> <?php _e( 'Order Again', 'woocommerce' ); ?></a>
		</p>
		<?php
	}

	add_action( 'woocommerce_order_details_after_order_table', 'cs_woocommerce_order_again_button' );
}


//
// Search Form
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_get_product_search_form' ) ) {

	function cs_get_product_search_form() {

		$form = '<div class="cs-search-form">
      <form action="' . esc_url( home_url( '/' ) ) . '" method="get">
        <input type="text" value="' . get_search_query() . '" name="s" class="cs-search" placeholder="' . esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ) . '" />
        <button type="submit" class="fa fa-search"></button>
        <input type="hidden" name="post_type" value="product" />
      </form>
    </div>';

		return $form;
	}

	add_filter( 'get_product_search_form', 'cs_get_product_search_form' );
}


//
// Search Converter
// ------------------------------------------------------------------------------
if ( !function_exists( 'custom_cs_search_hidden_fields' ) ) {

	function custom_cs_search_hidden_fields() {
		if ( cs_get_option( 'woo_convert_search' ) ) {
			echo '<input type="hidden" name="post_type" value="product" />';
		}
	}

	add_action( 'cs_search_hidden_fields', 'custom_cs_search_hidden_fields' );
}


//
// Add Cart Button Style
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_loop_add_to_cart_link' ) ) {

	function cs_woocommerce_loop_add_to_cart_link( $link, $product ) {

		$link	 = preg_replace( '/class="(.*?)"/', 'class="cs-btn cs-btn-outlined cs-btn-rounded cs-btn-xxs cs-btn-outlined-accent $1"', $link );
		$link	 = preg_replace( '/>(.*?)<\/a>/', '><i class="fa fa-refresh fa-spin"></i><i class="fa fa-check"></i>$1</a>', $link );
		$link	 = str_replace( '<a', '<div class="clear"></div><a', $link );

		return $link;
	}

	add_filter( 'woocommerce_loop_add_to_cart_link', 'cs_woocommerce_loop_add_to_cart_link', 10, 2 );
}

//
// Add Product Thumbnails Columns
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_woocommerce_product_thumbnails_columns' ) ) {

	function cs_woocommerce_product_thumbnails_columns( $columns ) {
		return 4;
	}

	add_filter( 'woocommerce_product_thumbnails_columns', 'cs_woocommerce_product_thumbnails_columns' );
}

//
// Review Comment Form Modifications
// ------------------------------------------------------------------------------
if ( !function_exists( 'cs_wc_tab_comments_template' ) ) {

	function cs_wc_tab_comments_template( $content ) {

		$replaces = array(
			'id="submit"'	 => 'id="submit" class="' . cs_get_button_class() . '"',
			'commentlist'	 => 'comment-list',
		);

		foreach ( $replaces as $from => $to ) {
			$content = str_replace( $from, $to, $content );
		}

		return $content;
	}

	add_filter( 'wc_tab_comments_template', 'cs_wc_tab_comments_template' );
}
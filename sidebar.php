<?php
/**
 *
 * The Sidebar containing the main widget areas.
 *
 * @since 1.0.0
 * @version 1.3.0
 * @package Sidebar
 */

?>
<aside id="sidebar">
	<?php
	global $post;

	if ( is_woocommerce_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_singular( 'product' ) ) {

		$cs_post_id = wc_get_page_id( 'shop' );
		$cs_meta    = get_post_meta( $cs_post_id, '_side_custom_page_options', true );
		$cs_widget  = ( ! empty( $cs_meta['sidebar_widget'] ) ) ? $cs_meta['sidebar_widget'] : '';
	} elseif ( ( is_single() || is_page() ) && ! empty( $post ) ) {

		$cs_post_id = $post->ID;
		$cs_meta    = get_post_meta( $cs_post_id, '_side_custom_page_options', true );
		$cs_widget  = ( ! empty( $cs_meta['sidebar_widget'] ) ) ? $cs_meta['sidebar_widget'] : '';
	} elseif ( is_tax( 'portfolio-category' ) || is_archive( 'portfolio' ) ) {

		$cs_post_id = cs_get_option( 'portfolio_archives_layout' );
		$cs_meta    = get_post_meta( $cs_post_id, '_side_custom_page_options', true );
		$cs_widget  = ( ! empty( $cs_meta['sidebar_widget'] ) ) ? $cs_meta['sidebar_widget'] : '';
	} else {

		$cs_widget = cs_get_option( 'blog_widget' );
	}

	if ( class_exists( 'BuddyPress' ) && is_buddypress() ) {

		$bp_pages = get_option( 'bp-pages' );
		if ( bp_is_current_component( 'groups' ) && ( ! bp_is_group_single() && ! bp_is_group_create() ) ) {
			$post = get_post( $bp_pages['groups'] );
		} elseif ( bp_is_current_component( 'members' ) ) {
			$post = get_post( $bp_pages['members'] );
		} elseif ( bp_is_current_component( 'activity' ) && ! bp_current_action( 'activity' ) ) {
			$post = get_post( $bp_pages['activity'] );
		}

		$cs_meta   = get_post_meta( $post->ID, '_side_custom_page_options', true );
		$cs_widget = ( ! empty( $cs_meta['sidebar_widget'] ) ) ? $cs_meta['sidebar_widget'] : '';
	}

	if ( is_bbpress_activated() && is_bbpress() ) {
		$cs_widget = cs_get_option( 'bbpress_widget' );
	}

	$cs_widget = ( ! empty( $cs_widget ) ) ? $cs_widget : 'sidebar-1';

	dynamic_sidebar( $cs_widget );
	?>
</aside><!-- /aside -->

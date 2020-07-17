<?php
/**
 * BuddyPress - Members Home
 *
 * @since   1.0.0
 * @version 3.0.0
 */
?>

<?php bp_nouveau_member_hook( 'before', 'home_content' ); ?>

<?php
global $cs_has_section, $post;

$bp_pages = get_option( 'bp-pages' );
if ( bp_is_user() ) {
	$post = get_post( $bp_pages[ 'members' ] );
}

$cs_post_meta	 = get_post_meta( $post->ID, '_side_custom_page_options', true );
$cs_page_layout	 = ( isset( $cs_post_meta[ 'sidebar' ] ) ) ? $cs_post_meta[ 'sidebar' ] : 'full';
$cs_page_column  = ( $cs_page_layout == 'full' ) ? '12' : ( ( $cs_page_layout == 'both' ) ? '6' : '9' );
$vc_exclude		 = cs_get_option( 'vc_exclude_shortcodes' );
$vc_exclude		 = ( is_array( $vc_exclude ) ) ? $vc_exclude : array();
$cs_page_padding = (!in_array( 'vc_row', $vc_exclude ) ) ? 'md-padding ' : '';
$cs_has_section	 = isset( $cs_post_meta[ 'section' ] ) ? true : false;
?>

<div id="item-header" role="complementary" data-bp-item-id="<?php echo esc_attr( bp_displayed_user_id() ); ?>" data-bp-item-component="members" class="users-header single-headers">

	<?php bp_nouveau_member_header_template_part(); ?>

</div><!-- #item-header -->

<div class="cs-member-home">
	<div class="container">
		<div class="row">
			<?php cs_page_sidebar( 'left', $cs_page_layout ); ?>
			<div class="col-md-<?php echo $cs_page_column; ?>">
				<div class="bp-wrap">
					<?php if ( !bp_nouveau_is_object_nav_in_sidebar() ) : ?>

						<?php bp_get_template_part( 'members/single/parts/item-nav' ); ?>

					<?php endif; ?>

					<div id="item-body" class="item-body">

						<?php bp_nouveau_member_template_part(); ?>

					</div><!-- #item-body -->
				</div><!-- // .bp-wrap -->
			</div><!-- .col -->
			<?php cs_page_sidebar( 'right', $cs_page_layout ); ?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .member-home -->

<?php bp_nouveau_member_hook( 'after', 'home_content' ); ?>

<?php
/**
 * BuddyPress - Members Home
 *
 * @since   1.0.0
 * @version 3.0.0
 * @package BuddyPress
 */

 ?>

<?php bp_nouveau_member_hook( 'before', 'home_content' ); ?>

<?php
global $cs_has_section, $post;

$cs_buddypress_layout = cs_get_option( 'buddypress_single_member_sidebar', 'full' );
$cs_page_column       = ( $cs_buddypress_layout == 'full' ) ? '12' : ( ( $cs_buddypress_layout == 'both' ) ? '6' : '9' );
?>

<div id="item-header" role="complementary" data-bp-item-id="<?php echo esc_attr( bp_displayed_user_id() ); ?>" data-bp-item-component="members" class="users-header single-headers">

	<?php bp_nouveau_member_header_template_part(); ?>

</div><!-- #item-header -->

<div class="cs-member-home">
	<div class="container">
		<div class="row cs-row-wrap">
			<?php cs_page_sidebar( 'left', $cs_buddypress_layout ); ?>
			<div class="cs-content-wrapper col-md-<?php echo esc_attr( $cs_page_column ); ?>">
				<div class="bp-wrap">
					<?php if ( ! bp_nouveau_is_object_nav_in_sidebar() ) : ?>

						<?php bp_get_template_part( 'members/single/parts/item-nav' ); ?>

					<?php endif; ?>

					<div id="item-body" class="item-body">

						<?php bp_nouveau_member_template_part(); ?>

					</div><!-- #item-body -->
				</div><!-- .bp-wrap -->
			</div><!-- .col -->
			<?php cs_page_sidebar( 'right', $cs_buddypress_layout ); ?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .member-home -->

<?php bp_nouveau_member_hook( 'after', 'home_content' ); ?>

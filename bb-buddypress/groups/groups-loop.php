<?php
/**
 * BuddyBoss - Groups Loop
 *
 * This template can be overridden by copying it to yourtheme/bb-buddypress/groups/groups-loop.php.
 *
 * @since   BuddyPress 3.0.0
 * @version 1.0.0
 *
 * @package BuddyBoss\Core
 */

add_filter( 'bp_get_group_description_excerpt', 'bb_get_group_description_excerpt_view_more', 99, 2 );

bp_nouveau_before_loop(); ?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
	<div class="bp-feedback info">
		<span class="bp-icon" aria-hidden="true"></span>
		<p class="current-group-type"><?php bp_current_group_directory_type_message(); ?></p>
	</div>
<?php endif; ?>

<?php

$cover_class        = ! bb_platform_group_element_enable( 'cover-images' ) ? 'bb-cover-disabled' : 'bb-cover-enabled';
$meta_privacy       = ! bb_platform_group_element_enable( 'group-privacy' ) ? 'meta-privacy-hidden' : '';
$meta_group_type    = ! bb_platform_group_element_enable( 'group-type' ) ? 'meta-group-type-hidden' : '';
$group_members      = ! bb_platform_group_element_enable( 'members' ) ? 'group-members-hidden' : '';
$join_button        = ! bb_platform_group_element_enable( 'join-buttons' ) ? 'group-join-button-hidden' : '';
$group_alignment    = bb_platform_group_grid_style( 'left' );
$group_cover_height = function_exists( 'bb_get_group_cover_image_height' ) ? bb_get_group_cover_image_height() : 'small';

?>


<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<?php bp_nouveau_pagination( 'top' ); ?>

	<ul id="groups-list" class="
	<?php
	bp_nouveau_loop_classes();
	echo esc_attr( ' ' . $cover_class . ' ' . $group_alignment );
	?>
	groups-dir-list">

		<?php
		while ( bp_groups() ) :
			bp_the_group();
			?>

			<li <?php bp_group_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups">
				<div class="list-wrap">

					<?php do_action( 'articlemag_before_group_avatar_group_directory' ); ?>

					<?php
					if ( ! bp_disable_group_avatar_uploads() && bb_platform_group_element_enable( 'avatars' ) ) :
						?>
						<div class="item-avatar"><a href="<?php bp_group_permalink(); ?>" class="group-avatar-wrap"><?php bp_group_avatar( bp_nouveau_avatar_args() ); ?></a></div>
					<?php endif; ?>

					<div class="item <?php echo esc_attr( $group_members . ' ' . $join_button ); ?>">

						<div class="item-block">

							<h2 class="list-title groups-title"><?php bp_group_link(); ?></h2>

							<?php if ( bp_nouveau_group_has_meta() ) : ?>

								<p class="item-meta group-details <?php echo esc_attr( $meta_privacy . ' ' . $meta_group_type ); ?>">
									<?php
									$meta = bp_nouveau_get_group_meta();
									echo wp_kses_post( $meta['status'] );
									?>
								</p>

							<?php endif; ?>

							<?php
							if ( bb_platform_group_element_enable( 'last-activity' ) ) {
								echo '<p class="last-activity item-meta">' .
								sprintf(
										/* translators: %s = last activity timestamp (e.g. "active 1 hour ago") */
									esc_attr__( 'Active %s', 'articlemag' ),
									wp_kses_post( bp_get_group_last_active() )
								) .
								'</p>';
							}
							?>

						</div>

						<?php bp_nouveau_groups_loop_item(); ?>

						<div class="group-footer-wrap <?php echo esc_attr( $group_members . ' ' . $join_button ); ?>">
							<div class="group-members-wrap">
								<?php bb_groups_loop_members(); ?>
							</div>
							<?php if ( bb_platform_group_element_enable( 'join-buttons' ) ) { ?>
								<div class="groups-loop-buttons footer-button-wrap"><?php bp_nouveau_groups_loop_buttons(); ?></div>
							<?php } ?>
						</div>

					</div>


				</div>
			</li>

	<?php endwhile; ?>

	</ul>

	<!-- Leave Group confirmation popup -->
	<div class="bb-leave-group-popup bb-action-popup" style="display: none">
		<transition name="modal">
			<div class="modal-mask bb-white bbm-model-wrap">
				<div class="modal-wrapper">
					<div class="modal-container">
						<header class="bb-model-header">
							<h4><span class="target_name"><?php esc_html_e( 'Leave Group', 'articlemag' ); ?></span></h4>
							<a class="bb-close-leave-group bb-model-close-button" href="#">
								<span class="bb-icon-l bb-icon-times"></span>
							</a>
						</header>
						<div class="bb-leave-group-content bb-action-popup-content">
							<p><?php esc_html_e( 'Are you sure you want to leave ', 'articlemag' ); ?><span class="bb-group-name"></span>?</p>
						</div>
						<footer class="bb-model-footer flex align-items-center">
							<a class="bb-close-leave-group bb-close-action-popup" href="#"><?php esc_html_e( 'Cancel', 'articlemag' ); ?></a>
							<a class="button push-right bb-confirm-leave-group" href="#"><?php esc_html_e( 'Confirm', 'articlemag' ); ?></a>
						</footer>

					</div>
				</div>
			</div>
		</transition>
	</div> <!-- .bb-leave-group-popup -->

	<?php bp_nouveau_pagination( 'bottom' ); ?>

<?php else : ?>

	<?php bp_nouveau_user_feedback( 'groups-loop-none' ); ?>

<?php endif; ?>

<?php
bp_nouveau_after_loop();

remove_filter( 'bp_get_group_description_excerpt', 'bb_get_group_description_excerpt_view_more', 99, 2 );

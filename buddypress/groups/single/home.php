<?php
/**
 * BuddyPress - Groups Home
 *
 * @since 3.0.0
 * @version 3.0.0
 * @package BuddyPress
 */

global $cs_has_section, $post;

$cs_buddypresss_layout = cs_get_option( 'buddypress_single_group_sidebar', 'full' );
$cs_page_column        = ( $cs_buddypresss_layout == 'full' ) ? '12' : ( ( $cs_buddypresss_layout == 'both' ) ? '6' : '9' );

if ( bp_has_groups() ) :
	while ( bp_groups() ) :
		bp_the_group();
		?>

		<?php bp_nouveau_group_hook( 'before', 'home_content' ); ?>

		<div id="item-header" role="complementary" data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups" class="groups-header single-headers">

			<?php bp_nouveau_group_header_template_part(); ?>

		</div><!-- #item-header -->

		<div class="cs-group-home">
			<div class="container">
				<div class="row cs-row-wrap">
					<?php cs_page_sidebar( 'left', $cs_buddypresss_layout ); ?>
					<div class="cs-content-wrapper col-md-<?php echo esc_attr( $cs_page_column ); ?>">

						<div class="bp-wrap">

							<?php if ( ! bp_nouveau_is_object_nav_in_sidebar() ) : ?>

								<?php bp_get_template_part( 'groups/single/parts/item-nav' ); ?>

							<?php endif; ?>

							<div id="item-body" class="item-body">

								<?php bp_nouveau_group_template_part(); ?>

							</div><!-- #item-body -->

						</div><!-- // .bp-wrap -->
					</div><!-- .col -->
					<?php cs_page_sidebar( 'right', $cs_buddypresss_layout ); ?>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .cs-group-home -->

		<?php bp_nouveau_group_hook( 'after', 'home_content' ); ?>

	<?php endwhile; ?>

	<?php


endif;

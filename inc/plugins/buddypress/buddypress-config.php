<?php
/**
 * Bp get activity css first class
 */
function bp_get_activity_css_first_class() {
	global $activities_template;
	/**
	 * Filters the available mini activity actions available as CSS classes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $value Array of classes used to determine classes applied to HTML element.
	 */
	$mini_activity_actions = apply_filters(
		'bp_activity_mini_activity_types',
		array(
			'friendship_accepted',
			'friendship_created',
			'new_blog',
			'joined_group',
			'created_group',
			'new_member',
		)
	);
	return apply_filters( 'bp_get_activity_css_first_class', $activities_template->activity->component );
}


if ( ! function_exists( 'articlemag_is_user_online' ) ) {
	/**
	 * Is the current user online
	 *
	 * @param int $user_id define user_id.
	 */
	function articlemag_is_user_online( $user_id ) {

		if ( ! function_exists( 'bp_get_user_last_activity' ) ) {
			return;
		}

		$last_activity = strtotime( bp_get_user_last_activity( $user_id ) );

		if ( empty( $last_activity ) ) {
			return false;
		}

		// the activity timeframe is 5 minutes.
		$activity_timeframe = 5 * MINUTE_IN_SECONDS;
		return ( time() - $last_activity <= $activity_timeframe );
	}
}


if ( ! function_exists( 'articlemag_user_status' ) ) {
	/**
	 * BuddyPress user status
	 *
	 * @param int $user_id define user_id.
	 */
	function articlemag_user_status( $user_id ) {
		if ( articlemag_is_user_online( $user_id ) ) {
			echo '<span class="member-status online"></span>';
		}
	}
}


if ( ! function_exists( 'is_buddypress_activated' ) ) {
	/**
	 *
	 * Is buddypress activated
	 *
	 * @since 1.5.0
	 * @version 1.5.0
	 */
	function is_buddypress_activated() {
		if ( class_exists( 'BuddyPress' ) ) {
			return true;
		} else {
			return false;
		}
	}
}



if ( ! function_exists( 'articlemag_render_member_cover_image' ) ) {
		add_action( 'articlemag_before_member_avatar_member_directory', 'articlemag_render_member_cover_image', 10 );
	/**
	 * Showing member cover image on member directory page
	 */
	function articlemag_render_member_cover_image() {
			$cover_img_url = bp_attachments_get_attachment(
				'url',
				$args      = array(
					'object_dir' => 'members',
					'item_id'    => $user_id = bp_get_member_user_id(),
					'type'       => 'cover-image',
				)
			);
			$default_members_cover = cs_get_option( 'bp_custom_members_cover' );
		/* @var $cover_img_url type */
		$cover_img_url = $cover_img_url ?: $default_members_cover;
			echo '<div class="articlemag-mem-cover-wrapper"><div class="articlemag-mem-cover-img"><img src="' . $cover_img_url . '" /></div></div>';
	}
}


if ( ! function_exists( 'articlemag_render_group_cover_image' ) ) {
	add_action( 'articlemag_before_group_avatar_group_directory', 'articlemag_render_group_cover_image', 10 );
	/**
	 * Showing group cover image on groups directory page
	 */
	function articlemag_render_group_cover_image() {
		$cover_img_url = bp_attachments_get_attachment(
			'url',
			$args      = array(
				'object_dir' => 'groups',
				'item_id'    => $group_id = bp_get_group_id(),
				'type'       => 'cover-image',
			)
		);
		$default_groups_cover = cs_get_option( 'bp_custom_groups_cover' );
		/* @var $cover_img_url type */
		$cover_img_url = $cover_img_url ?: $default_groups_cover;
			echo '<div class="articlemag-grp-cover-wrapper"><div class="articlemag-grp-cover-img"><img src="' . $cover_img_url . '" /></div></div>';
	}
}

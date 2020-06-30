<?php

// bp_get_activity_css_first_class
function bp_get_activity_css_first_class() {
	global $activities_template;
	/**
	 * Filters the available mini activity actions available as CSS classes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $value Array of classes used to determine classes applied to HTML element.
	 */
	$mini_activity_actions = apply_filters( 'bp_activity_mini_activity_types', array(
		'friendship_accepted',
		'friendship_created',
		'new_blog',
		'joined_group',
		'created_group',
		'new_member'
	) );
	return apply_filters( 'bp_get_activity_css_first_class', $activities_template->activity->component );
}

/**
 * Is the current user online
 *
 * @param $user_id
 *
 * @return bool
 */
if ( !function_exists( 'articlemag_is_user_online' ) ) {

	function articlemag_is_user_online( $user_id ) {

		if ( !function_exists( 'bp_get_user_last_activity' ) ) {
			return;
		}

		$last_activity = strtotime( bp_get_user_last_activity( $user_id ) );

		if ( empty( $last_activity ) ) {
			return false;
		}

		// the activity timeframe is 5 minutes
		$activity_timeframe = 5 * MINUTE_IN_SECONDS;
		return ( time() - $last_activity <= $activity_timeframe );
	}

}

/**
 * BuddyPress user status
 *
 * @param $user_id
 *
 */
if ( !function_exists( 'articlemag_user_status' ) ) {

	function articlemag_user_status( $user_id ) {
		if ( articlemag_is_user_online( $user_id ) ) {
			echo '<span class="member-status online"></span>';
		}
	}

}

/**
 *
 * is buddypress activated
 *
 * @since 1.5.0
 * @version 1.5.0
 */
if ( !function_exists( 'is_buddypress_activated' ) ) {

	function is_buddypress_activated() {
		if ( class_exists( 'BuddyPress' ) ) {
			return true;
		} else {
			return false;
		}
	}

}
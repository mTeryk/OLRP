<?php
	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}


	$object_id                  = $item->object_id;
	$object_type                = $item->object_type;

	$enable_buddypress_bookmark = intval( $setting->get_option( 'enable_buddypress_bookmark', 'cbxwpbookmark_buddypress', 0 ) );
	if ( $enable_buddypress_bookmark && $object_type == 'buddypress_activity' && function_exists( 'bp_activity_get' ) ) {

		//$activity_get = bp_activity_get_specific( array( 'activity_ids' => array($object_id) ) );
		$args = array(
			//'ids' => $object_id,
			'in'       => $object_id,
			'per_page' => 1
		);

		$activity_get = bp_activity_get( $args );
		if ( isset( $activity_get['activities'][0] ) ) {
			$activity = $activity_get['activities'][0];
			echo '<li class="cbxwpbookmark-mylist-item cbxwpbookmark-mylist-item-othertype '.$sub_item_class.'">';
			do_action( 'cbxwpbookmark_bookmarkpost_othertype_item_start', $object_id, $item );
			echo '<a href="' . bp_activity_get_permalink( $object_id ) . '">' . wp_strip_all_tags( $activity->content ) . '</a>' . $action_html;
			do_action( 'cbxwpbookmark_bookmarkpost_othertype_item_end', $object_id, $item );
			echo '</li>';
		}

	}//if bp and $enable_buddypress_bookmark
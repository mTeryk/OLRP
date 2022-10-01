<?php
	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	$object_id                  = $item->object_id;
	$object_type                = $item->object_type;


	$thumb_size = 'thumbnail';
	$thumb_attr = array();

	$enable_buddypress_bookmark = intval( $setting->get_option( 'enable_buddypress_bookmark', 'cbxwpbookmark_buddypress', 0 ) );

	if ( $enable_buddypress_bookmark && $object_type == 'buddypress_activity' && function_exists( 'bp_activity_get' ) ) {
		$ul_class = isset( $instance['ul_class'] ) ? $instance['ul_class'] : '';
		$li_class = isset( $instance['li_class'] ) ? $instance['li_class'] : '';

		$show_thumb = isset( $instance['show_thumb'] ) ? intval( $instance['show_thumb'] ) : 1;

		//$activity_get = bp_activity_get_specific( array( 'activity_ids' => array($object_id) ) );
		$args = array(
			//'ids' => $object_id,
			'in'       => $object_id,
			'per_page' => 1
		);

		$activity_get = bp_activity_get( $args );
		if ( isset( $activity_get['activities'][0] ) ) {
			$activity = $activity_get['activities'][0];

			echo '<li class="cbxwpbookmark-mostlist-item cbxwpbookmark-mostlist-item-othertype ' . $li_class . '" >';

			do_action( 'cbxwpbookmark_bookmarkmost_othertype_item_start', $object_id, $item );

			echo '<a href="' . bp_activity_get_permalink( $object_id ) . '">';
			$thumb_html = '';

			/*if ( $show_thumb ) {
				if ( has_post_thumbnail( $object_id ) ) {
					$thumb_html = get_the_post_thumbnail( $object_id, $thumb_size, $thumb_attr );
				} elseif ( ( $parent_id = wp_get_post_parent_id( $object_id ) ) && has_post_thumbnail( $parent_id ) ) {
					$thumb_html = get_the_post_thumbnail( $parent_id, $thumb_size, $thumb_attr );
				}
	
				echo $thumb_html;
			}*/

			echo wp_strip_all_tags( $activity->content ) . $show_count_html;
			echo '</a>';

			do_action( 'cbxwpbookmark_bookmarkmost_othertype_item_end', $object_id, $item );
			echo '</li>';
		}
	}//if bp and $enable_buddypress_bookmark
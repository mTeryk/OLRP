<?php
	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	$show_thumb  = isset( $instance['show_thumb'] ) ? intval( $instance['show_thumb'] ) : 1; //show thumbnail
	$object_id                  = $item->object_id;
	$object_type                = $item->object_type;

	$pro_grid_thumb_size = $setting->get_option( 'pro_grid_thumb_size', 'cbxwpbookmark_proaddon', 'medium' );
	if ( $pro_grid_thumb_size == '' ) {
		$pro_grid_thumb_size = 'medium';
	}

	$enable_buddypress_bookmark = intval( $setting->get_option( 'enable_buddypress_bookmark', 'cbxwpbookmark_buddypress', 0 ) );

	$pro_grid_thumb_size = $setting->get_option( 'pro_grid_thumb_size', 'cbxwpbookmark_proaddon', 'medium' );
	if ( $pro_grid_thumb_size == '' ) {
		$pro_grid_thumb_size = 'medium';
	}



	if ( $enable_buddypress_bookmark && $object_type == 'buddypress_activity' && function_exists( 'bp_activity_get' ) ) {

		$show_thumb  = isset( $instance['show_thumb'] ) ? intval( $instance['show_thumb'] ) : 1;
		$allowdelete = isset( $instance['allowdelete'] ) ? intval( $instance['allowdelete'] ) : 0;

		//$activity_get = bp_activity_get_specific( array( 'activity_ids' => array($object_id) ) );
		$args = array(
			//'ids' => $object_id,
			'in'       => $object_id,
			'per_page' => 1
		);

		$activity_get = bp_activity_get( $args );


		if ( isset( $activity_get['activities'][0] ) ) {
			$activity = $activity_get['activities'][0];

			$thumb_html = '';

			if ( $show_thumb ) {
				$img_url = '';

				if ( has_post_thumbnail( $object_id ) ) {
					$img_url = get_the_post_thumbnail_url( $object_id, $pro_grid_thumb_size );


				}
				else if(class_exists('BB_Platform_Pro')){
				    $media_ids  = bp_activity_get_meta( $object_id, 'bp_media_ids', true );
				    if($media_ids != ''){
                        $media_ids = explode(',', $media_ids);
                        //$img_url = CBXWPBookmarkproHelper::buddyPressFeaturedImage($media_ids, $pro_grid_thumb_size);
                        $img_url = CBXWPBookmarkproHelper::buddyPressFeaturedImage($media_ids, 'bp-media-thumbnail');
				    }
                }

				if ( $img_url == '' || $img_url === false ) {

					$img_url = apply_filters( 'cbxwpbookmarkaddon_defaultgridimage', plugins_url( 'cbxwpbookmarkaddon/assets/img/bookmark-placeholder-250x150.png' ) );
				}

				$thumb_html .= '<a class="cbxbookmark_card_teaser" href="' . bp_activity_get_permalink( $object_id ) . '"><img src="' . apply_filters('cbxwpbookmark_bookmarkgrid_othertype_thumb_url', $img_url, $object_id, $object_type) . '" alt="bookmarkimage"  /></a>';
			}

			$card_cols_class = apply_filters( 'cbxwpbookmark_bookmarkgrid_cols_class', 'col-12 col-xs-12 col-sm-6 col-md-4', 'othertype' );

			echo '<div class="' . esc_attr( $card_cols_class ) . ' cbxbookmark_card_col"><div class="cbxbookmark_card cbxbookmark_card_othertype">';

			do_action( 'cbxwpbookmark_bookmarkgrid_othertype_item_start', $object_id, $item );

			echo $thumb_html;
			echo '<div class="cbxbookmark_card_clear"></div>
								<div class="cbxbookmark_card_container">
									<p class="cbxbookmark_card_title"><a href="' . bp_activity_get_permalink( $object_id ) . '">' . apply_filters('cbxwpbookmark_bookmarkgrid_othertype_title', wp_strip_all_tags( $activity->content ), $object_id, $object_type) . '</a></p>
									<div class="cbxbookmark_card_clear"></div>' .

			     ( ( $cat_title != '' || $delete_html != '' ) ? '<p class="cbxbookmark_card_cat_delete">' . wp_unslash( $cat_title ) . $delete_html . '</p>' : '' ) . '
								</div>';

			do_action( 'cbxwpbookmark_bookmarkgrid_othertype_item_end', $object_id, $item );

			echo '</div></div>';

		}
	}
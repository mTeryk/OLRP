<?php
	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	$show_thumb  = isset( $instance['show_thumb'] ) ? intval( $instance['show_thumb'] ) : 1; //show thumbnail
	$object_id   = $item->object_id;
	$object_type = $item->object_type;

	$pro_grid_thumb_size = $setting->get_option( 'pro_grid_thumb_size', 'cbxwpbookmark_proaddon', 'medium' );
	if ( $pro_grid_thumb_size == '' ) {
		$pro_grid_thumb_size = 'medium';
	}

	$thumb_html = '';
	if ( $show_thumb ) {
		$img_url = '';
		if ( function_exists( 'fifu_main_image_url' ) && $pro_grid_thumb_size == 'fifu' ) {
			//$img_url = get_post_meta($item->object_id, 'fifu_image_url_' . $att_id, true);
			$img_url = fifu_main_image_url( $object_id );
		} else if ( has_post_thumbnail( $object_id ) ) {
			$img_url = get_the_post_thumbnail_url( $object_id, $pro_grid_thumb_size );

		}

		if ( $img_url == '' || $img_url === false ) {

			$img_url = apply_filters( 'cbxwpbookmarkaddon_defaultgridimage', plugins_url( 'cbxwpbookmarkaddon/assets/img/bookmark-placeholder-250x150.png' ) );
		}

		$thumb_html .= '<a class="cbxbookmark_card_teaser" href="' . get_permalink( $object_id ) . '"><img src="' . $img_url . '" alt="bookmarkimage"  /></a>';
	}

	$track_input        = get_post_meta( $object_id, 'track_input', true );
	$track_input_output = '';
	if ( $track_input != '' ) {
		/*if(has_shortcode($track_input, 'fwdmsp')){
			$track_input_output .= do_shortcode($track_input);
		}
		else{
			$track_input_output = $track_input;
		}*/

		$track_input_output .= do_shortcode( $track_input );
	}

	if ( $track_input_output != '' ) {
		$track_input_output = '<div class="cbxbookmark_card_track_input">' . $track_input_output . '</div>';
	}


	$card_cols_class =  apply_filters('cbxwpbookmark_bookmarkgridmost_cols_class', 'col-xs-12 col-sm-6 col-md-4', 'single');

	echo '<div class="'.esc_attr($card_cols_class).' cbxbookmark_card_col"><div class="cbxbookmark_card">';

	do_action( 'cbxwpbookmark_bookmarkgridmost_single_item_start', $object_id, $item );

	echo $thumb_html;
	echo '<div class="cbxbookmark_card_clear"></div>
								<div class="cbxbookmark_card_container">
									<p class="cbxbookmark_card_title"><a href="' . get_permalink( $object_id ) . '">' . wp_strip_all_tags( get_the_title( $object_id ) ). $show_count_html . '</a></p>
									<div class="cbxbookmark_card_clear"></div></div>';

	do_action( 'cbxwpbookmark_bookmarkgridmost_single_item_end', $object_id, $item );

	echo '</div></div>';
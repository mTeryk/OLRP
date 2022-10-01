<?php

/**
 * Provide a public area view for the plugin
 *
 * This file is used to markup the public-facing most bookmarked downloads(EDD) of the widget.
 *
 * @link       codeboxr.com
 * @since      1.0.0
 *
 * @package    cbxwpbookmarkaddon
 * @subpackage cbxwpbookmarkaddon/templates
 */
?>
<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$limit        = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 10;
$daytime      = isset( $instance['daytime'] ) ? absint( $instance['daytime'] ) : 0;
$order        = isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 'DESC';
$orderby      = isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : 'object_count';
$show_count   = isset( $instance['show_count'] ) ? absint( $instance['show_count'] ) : 1;
$show_thumb   = isset( $instance['show_thumb'] ) ? absint( $instance['show_thumb'] ) : 1;
$show_price   = isset( $instance['show_price'] ) ? absint( $instance['show_price'] ) : 1;
$show_addcart = isset( $instance['show_addcart'] ) ? absint( $instance['show_addcart'] ) : 1;


$daytime = (int) $daytime;
ob_start();
?>

    <ul class="cbxwpbookmark-list-generic cbxwpbookmark-mostlist product_list_widget">
		<?php

		global $wpdb;

		$cbxwpbookmrak_table = $wpdb->prefix . 'cbxwpbookmark';


		$sql = $where_sql = '';

		$datetime_sql = "";
		if ( $daytime != '0' || ! empty( $daytime ) ) {
			$time         = date( 'Y-m-d H:i:s', strtotime( '-' . $daytime . ' day' ) );
			$datetime_sql = " created_date > '$time' ";

			$where_sql .= ( ( $where_sql != '' ) ? ' AND ' : '' ) . $datetime_sql;
		}

		$object_typ_sql = ' object_type = "download" ';
		$where_sql      .= ( ( $where_sql != '' ) ? ' AND ' : '' ) . $object_typ_sql;

		if ( $where_sql == '' ) {
			$where_sql = '1';
		}

		$param = array( $limit );

		if ( $orderby == 'object_count' ) {
			$sql = "SELECT count(object_id) as totalobject, object_id, object_type FROM  $cbxwpbookmrak_table WHERE $where_sql group by object_id order by totalobject $order LIMIT %d";
		} else {
			$join = '';

			if ( $orderby == 'title' ) {

				$posts_table = $wpdb->prefix . 'posts'; //core posts table
				$join        .= " LEFT JOIN $posts_table posts ON posts.ID = bookmarks.object_id ";

				$orderby = 'posts.post_title';
			}

			$sql = "SELECT count(object_id) as totalobject, object_id, object_type FROM  $cbxwpbookmrak_table AS bookmarks $join WHERE $where_sql group by object_id order by $orderby $order, totalobject $order LIMIT %d";
		}


		$items = $wpdb->get_results(
			$wpdb->prepare( $sql, $param )
		);


		// Checking for available results
		if ( $items != null || sizeof( $items ) > 0 ) {

			// Return post ids as array
			foreach ( $items as $item ) {
				$show_count_html = ( $show_count == 1 ) ? '<i>(' . $item->totalobject . ')</i>' : "";

				echo '<li class="cbxwpbookmark-mostlist-item cbxwpbookmark-mostlist-item-products">';
				echo '<p class="cbxwpbookmark-mostlist-product-title"><a href="' . get_permalink( $item->object_id ) . '">';
				echo '<span class="cbxwpbookmark-mostlist-product-name">'.wp_strip_all_tags( get_the_title( $item->object_id ) ) . $show_count_html.'</span>';
				echo ( $show_thumb ) ? CBXWPBookmarkproHelper::getThumb( $item->object_id ) : '';
				echo '</a></p>';

				echo ( $show_price ) ? edd_price( $item->object_id ) : '';
				if ( $show_addcart ) {
					echo do_shortcode( '[purchase_link id="' . $item->object_id . '"]' );
				}
				echo '</li>';
			}
		} else {
			echo '<li class="cbxwpbookmark-mostlist-item">' . esc_html__( 'No bookmarked downloads found', 'cbxwpbookmarkaddon' ) . '</li>';
		}
		?>
    </ul>
<?php

$output = ob_get_clean();

echo $output;
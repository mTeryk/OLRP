<?php

	/**
	 * The file that defines the core plugin class
	 *
	 * A class definition that includes attributes and functions used across both the
	 * public-facing side of the site and the admin area.
	 *
	 * @link       codeboxr.com
	 * @since      1.0.0
	 *
	 * @package    cbxwpbookmarkaddon
	 * @subpackage cbxwpbookmarkaddon/includes
	 */

	/**
	 * The pro addon plugin helper class.
	 *
	 * This is used to define static methods
	 *
	 * Also maintains the unique identifier of this plugin as well as the current
	 * version of the plugin.
	 *
	 * @since      1.0.0
	 * @package    cbxwpbookmarkaddon
	 * @subpackage cbxwpbookmarkaddon/includes
	 * @author     CBX Team  <info@codeboxr.com>
	 */
	class CBXWPBookmarkproHelper {
		/**
		 * Get thumbnail by post id and thumb size
		 *
		 * @param        $id
		 * @param string $size
		 * @param array  $attr
		 *
		 * @return string
		 */
		public static function getThumb( $id, $size = 'thumbnail', $attr = array() ) {
			$image = '';
			if ( has_post_thumbnail( $id ) ) {
				$image = get_the_post_thumbnail( $id, $size, $attr );
			} elseif ( ( $parent_id = wp_get_post_parent_id( $id ) ) && has_post_thumbnail( $parent_id ) ) {
				$image = get_the_post_thumbnail( $parent_id, $size, $attr );
			}

			return $image;
		}//end getThumb

        public static function buddyPressFeaturedImage($media_ids = array(), $thumb_size = 'bp-media-thumbnail'){
            // Bail if no media ID's passed.
            if ( empty( $media_ids ) ) {
                return '';
            }

            // Get BuddyPress.
            $bp = buddypress();
            global  $wpdb;

            $medias       = array();
            $uncached_ids = bp_get_non_cached_ids( $media_ids, 'bp_media' );

            // Prime caches as necessary.
            if ( ! empty( $uncached_ids ) ) {
                // Format the media ID's for use in the query below.
                $uncached_ids_sql = implode( ',', wp_parse_id_list( $uncached_ids ) );

                // Fetch data from media table, preserving order.
                $queried_adata = $wpdb->get_results( "SELECT * FROM {$bp->media->table_name} WHERE id IN ({$uncached_ids_sql})" );

                // Put that data into the placeholders created earlier,
                // and add it to the cache.
                foreach ( (array) $queried_adata as $adata ) {
                    wp_cache_set( $adata->id, $adata, 'bp_media' );
                }
            }

            $attachment_id = 0;
            // Now fetch data from the cache.
            foreach ( $media_ids as $media_id ) {
                // Integer casting.
                $media = wp_cache_get( $media_id, 'bp_media' );
                if ( ! empty( $media ) ) {
                    /*$media->id            = (int) $media->id;
                    $media->blog_id       = (int) $media->blog_id;
                    $media->user_id       = (int) $media->user_id;*/
                    $media->attachment_id = $attachment_id = (int) $media->attachment_id;
                    /*$media->album_id      = (int) $media->album_id;
                    $media->activity_id   = (int) $media->activity_id;
                    $media->group_id      = (int) $media->group_id;
                    $media->menu_order    = (int) $media->menu_order;*/
                }

                break;
            }

            if($attachment_id != 0){
                return wp_get_attachment_image_url($attachment_id, $thumb_size);
            }

            return '';
        }//end buddyPressFeaturedImage

		/**
		 * Get bookmarked buddypress activity id(s) by any user id
		 *
		 * @param int $user_id
		 */
		public static function get_buddypress_activity_by_user($user_id = 0){
			$ids = array();

			$user_id = intval($user_id);
			if($user_id == 0) return $ids;


			global  $wpdb;
			$cbxwpbookmrak_table         = $wpdb->prefix . 'cbxwpbookmark';

			$rows = $wpdb->get_results( $wpdb->prepare( "SELECT object_id FROM  $cbxwpbookmrak_table WHERE object_type = %s AND user_id = %d", 'buddypress_activity', $user_id ), ARRAY_A );
			if($rows !== null){
				foreach ($rows as $row){
					$ids[] = intval($row['object_id']);
				}

				$ids= array_unique($ids);
			}

			return $ids;
		}
	}//end CBXWPBookmarkproHelper
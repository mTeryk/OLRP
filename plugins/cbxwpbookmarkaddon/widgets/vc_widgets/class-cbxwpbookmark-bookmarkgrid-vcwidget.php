<?php
	// Prevent direct file access
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * My Bookmarked post grid widget for vc
	 *
	 * Class CBXWPBookmarks_VCWidget
	 */
	class CBXWPBookmarkgrid_VCWidget extends WPBakeryShortCode {
		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'bakery_shortcode_mapping' ), 12 );
		}// /end of constructor


		/**
		 * Element Mapping
		 */
		public function bakery_shortcode_mapping() {

			// Map the block with vc_map()
			vc_map( array(
				"name"        => esc_html__( "CBX My Bookmarked Posts Grid", 'cbxwpbookmarkaddon' ),
				"description" => esc_html__( "This widget shows bookmarked posts from a user as grid", 'cbxwpbookmarkaddon' ),
				"base"        => "cbxwpbookmarkgrid",
				"icon"        => CBXWPBOOKMARKADDON_ROOT_URL . 'assets/img/widget_icons/icon_post_grid.png',
				"category"    => esc_html__( 'CBX Bookmark Widgets', 'cbxwpbookmarkaddon' ),
				"params"      => array(
					array(
						"type"        => "textfield",
						"holder"      => "div",
						"class"       => "",
						'admin_label' => false,
						"heading"     => esc_html__( "Title", 'cbxwpbookmarkaddon' ),
						'description'   => esc_html__( 'Leave empty to ignore', 'cbxwpbookmarkaddon' ),
						"param_name"  => "title",
						"std"         => esc_html__('All Bookmarks', 'cbxwpbookmarkaddon'),
					),
					array(
						"type"        => "dropdown",
						'admin_label' => true,
						"heading"     => esc_html__( "Display order", 'cbxwpbookmarkaddon' ),
						"param_name"  => "order",
						'value'       => array(
							esc_html__( 'Ascending', 'cbxwpbookmarkaddon' ) => 'ASC',
							esc_html__( 'Descending', 'cbxwpbookmarkaddon' ) => 'DESC',
						),
						'std'         => 'DESC',
					),
					array(
						"type"        => "dropdown",
						'admin_label' => true,
						"heading"     => esc_html__( "Display order by", 'cbxwpbookmarkaddon' ),
						"param_name"  => "orderby",
						'value'       => array(
							esc_html__( 'Bookmark id', 'cbxwpbookmarkaddon' ) => 'id',
							esc_html__( 'Post ID', 'cbxwpbookmarkaddon' ) => 'object_id',
							esc_html__( 'Post Type', 'cbxwpbookmarkaddon' ) => 'object_type',
							esc_html__( 'Post Title', 'cbxwpbookmarkaddon' ) => 'title',
						),
						'std'         => 'id',
					),
					array(
						"type"        => "textfield",
						"holder"      => "div",
						"class"       => "",
						'admin_label' => true,
						"heading"     => esc_html__( "Limit", 'cbxwpbookmarkaddon' ),
						'description'   => esc_html__( 'Need numeric value.', 'cbxwpbookmarkaddon' ),
						"param_name"  => "limit",
						"std"         => 10
					),
					array(
						'type'        => 'cbxwpbookmarkdownmulti',
						"class"       => "",
						'admin_label' => false, //it must be false
						'heading'     => esc_html__( 'Post type(s)', 'cbxwpbookmarkaddon' ),
						'param_name'  => 'type',
						'value'       => CBXWPBookmarkHelper::post_types_plain_r(),
						'std'         => array(),
					),
					array(
						"type"        => "dropdown",
						'admin_label' => true,
						"heading"     => esc_html__( "Show load more", 'cbxwpbookmarkaddon' ),
						"param_name"  => "loadmore",
						'value'       => array(
							esc_html__( 'Yes', 'cbxwpbookmarkaddon' ) => 1,
							esc_html__( 'No', 'cbxwpbookmarkaddon' ) => 0,
						),
						'std'         => 1,
					),
					array(
						"type"        => "textfield",
						"holder"      => "div",
						"class"       => "",
						'admin_label' => false,
						"heading"     => esc_html__( "Category ID", 'cbxwpbookmarkaddon' ),
						"param_name"  => "catid",
						"std"         => '',
					),
					array(
						"type"        => "dropdown",
						'admin_label' => false,
						"heading"     => esc_html__( "Show category title", 'cbxwpbookmarkaddon' ),
						"param_name"  => "cattitle",
						'value'       => array(
							esc_html__( 'Yes', 'cbxwpbookmarkaddon' ) => 1,
							esc_html__( 'No', 'cbxwpbookmarkaddon' ) => 0
						),
						'std'         => 1,
					),
					array(
						"type"        => "dropdown",
						'admin_label' => false,
						"heading"     => esc_html__( "Show category count", 'cbxwpbookmarkaddon' ),
						"param_name"  => "catcount",
						'value'       => array(
							esc_html__( 'Yes', 'cbxwpbookmarkaddon' ) => 1,
							esc_html__( 'No', 'cbxwpbookmarkaddon' ) => 0
						),
						'std'         => 1,
					),
					array(
						"type"        => "dropdown",
						'admin_label' => true,
						"heading"     => esc_html__( "Allow Delete", 'cbxwpbookmarkaddon' ),
						"param_name"  => "allowdelete",
						'value'       => array(
							esc_html__( 'Yes', 'cbxwpbookmarkaddon' ) => 1,
							esc_html__( 'No', 'cbxwpbookmarkaddon' ) => 0,
						),
						'std'         => 0,
					),
					array(
						"type"        => "dropdown",
						'admin_label' => true,
						"heading"     => esc_html__( "Allow Delete All", 'cbxwpbookmarkaddon' ),
						"param_name"  => "allowdeleteall",
						'value'       => array(
							esc_html__( 'Yes', 'cbxwpbookmarkaddon' ) => 1,
							esc_html__( 'No', 'cbxwpbookmarkaddon' ) => 0,
						),
						'std'         => 0,
					)
				)
			) );
		}//end bakery_shortcode_mapping
	}// end class CBXWPBookmarkgrid_VCWidget
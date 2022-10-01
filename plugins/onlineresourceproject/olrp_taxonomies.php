<?php

add_action( 'init', 'olrp_resource_register_taxonomies' );

function olrp_resource_register_taxonomies() {

	register_taxonomy( 'creator', 'olrp_resource', [

		// Taxonomy arguments.
		'public'            => true,
		'show_in_rest'      => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => false,
		'query_var'         => 'creator',

		// The rewrite handles the URL structure.
		'rewrite' => [
			'slug'         => 'creator',
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		],

		// Text labels.
		'labels'            => [
			'name'                       => 'Creators',
			'singular_name'              => 'Creator',
			'menu_name'                  => 'Creators',
			'name_admin_bar'             => 'Creator',
			'search_items'               => 'Search Creators',
			'popular_items'              => 'Popular Creators',
			'all_items'                  => 'All Creators',
			'edit_item'                  => 'Edit Creator',
			'view_item'                  => 'View Creator',
			'update_item'                => 'Update Creator',
			'add_new_item'               => 'Add New Creator',
			'new_item_name'              => 'New Creator Name',
			'not_found'                  => 'No creators found.',
			'no_terms'                   => 'No creators',
			'items_list_navigation'      => 'Creators list navigation',
			'items_list'                 => 'Creators list'
		]
	] );

	register_taxonomy( 'collection', 'olrp_resource', [

		// Taxonomy arguments.
		'public'            => true,
		'show_in_rest'      => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'query_var'         => 'collection',

		// The rewrite handles the URL structure.
		'rewrite'           => [
			'slug'         => 'collection',
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		],

		// Text labels.
		'labels'            => [
			'name'                  => 'Collections',
			'singular_name'         => 'Collection',
			'menu_name'             => 'Collections',
			'name_admin_bar'        => 'Collection',
			'search_items'          => 'Search Collections',
			'popular_items'         => 'Popular Collections',
			'all_items'             => 'All Collections',
			'edit_item'             => 'Edit Collection',
			'view_item'             => 'View Collection',
			'update_item'           => 'Update Collection',
			'add_new_item'          => 'Add New Collection',
			'new_item_name'         => 'New Collection Name',
			'not_found'             => 'No collections found.',
			'no_terms'              => 'No collections',
			'items_list_navigation' => 'Collections list navigation',
			'items_list'            => 'Collections list'
		]
	] );






	register_taxonomy( 'licensing', 'olrp_resource', [

		// Taxonomy arguments.
		'public'            => true,
		'show_in_rest'      => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'query_var'         => 'licensing',

		// The rewrite handles the URL structure.
		'rewrite'           => [
			'slug'         => 'licensing',
			'with_front'   => false,
			'hierarchical' => true,
			'ep_mask'      => EP_NONE
		],

		// Text labels.
		'labels'            => [
			'name'                  => 'Licensing',
			'singular_name'         => 'License',
			'menu_name'             => 'Licenses',
			'name_admin_bar'        => 'Licenses',
			'search_items'          => 'Search Licenses',
			'popular_items'         => 'Popular Licenses',
			'all_items'             => 'All Licenses',
			'edit_item'             => 'Edit License',
			'view_item'             => 'View License',
			'update_item'           => 'Update License',
			'add_new_item'          => 'Add New License',
			'new_item_name'         => 'New License Name',
			'not_found'             => 'No licensess found.',
			'no_terms'              => 'No licenses',
			'items_list_navigation' => 'Licenses list navigation',
			'items_list'            => 'Licenses list'
		]
	] );

	register_taxonomy( 'department', 'olrp_resource', [

		// Taxonomy arguments.
		'public'            => true,
		'show_in_rest'      => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'query_var'         => 'department',

		// The rewrite handles the URL structure.
		'rewrite'           => [
			'slug'         => 'department',
			'with_front'   => false,
			'hierarchical' => true,
			'ep_mask'      => EP_NONE
		],

		// Text labels.
		'labels'            => [
			'name'                  => 'Departments',
			'singular_name'         => 'Department',
			'menu_name'             => 'Departments',
			'name_admin_bar'        => 'Department',
			'search_items'          => 'Search Departments',
			'popular_items'         => 'Popular Departments',
			'all_items'             => 'All Departments',
			'edit_item'             => 'Edit Departments',
			'view_item'             => 'View Department',
			'update_item'           => 'Update Department',
			'add_new_item'          => 'Add New Department',
			'new_item_name'         => 'New Department Name',
			'not_found'             => 'No departments found.',
			'no_terms'              => 'No departments',
			'items_list_navigation' => 'department list navigation',
			'items_list'            => 'departments list'
		]
	] );

}
/**
 * Display a custom taxonomy dropdown in admin
 * @author  Mike Hemberger - Modified to support multiple taxonomies by Teryk Morris
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_action('restrict_manage_posts', 'olrp_filter_post_type_by_taxonomy');
function olrp_filter_post_type_by_taxonomy() {

	global $typenow;
	$post_type = 'olrp_resource'; // change to your post type
	olrp_display_dropdown($typenow, $post_type, 'creator');
	olrp_display_dropdown($typenow, $post_type, 'collection');
//	olrp_display_dropdown($typenow, $post_type, 'resource_list');
	olrp_display_dropdown($typenow, $post_type, 'licensing');
	olrp_display_dropdown($typenow, $post_type, 'department');
}
/**
 * Display a custom taxonomy dropdown in admin
 * @author  Mike Hemberger - Modified to support multiple taxonomies by Teryk Morris
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
function olrp_display_dropdown($typenow, $post_type, $taxonomy)
{
	if ($typenow == $post_type) {

		$selected      = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
		$info_taxonomy = get_taxonomy( $taxonomy );
		wp_dropdown_categories( array(
			'show_option_all' => sprintf( __( 'Show all %s', 'teryk' ), $info_taxonomy->label ),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => false,
		) );
	}
}

/**
 * Filter posts by taxonomy in admin
 * @author Mike Hemberger - Modified to support multiple taxonomies by Teryk Morris
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter('parse_query', 'olrp_convert_id_to_term_in_query');
function olrp_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type  = 'olrp_resource'; // change to your post type
	$taxonomies = [ 'creator', 'collection', 'resource_list','licensing' ]; // change to your taxonomy
	$q_vars     = &$query->query_vars;

		if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type ) {

			foreach ($taxonomies as $taxonomy){
			if ( isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && $q_vars[ $taxonomy ] != 0 ) {
				$term                = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
				$q_vars[ $taxonomy ] = $term->slug;
			}
		}
	}
}

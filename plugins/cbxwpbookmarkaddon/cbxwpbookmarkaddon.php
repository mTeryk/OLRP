<?php
/**
 * @link              http://codeboxr.com
 * @since             1.0.0
 * @package           Cbxwpbookmarkaddon
 *
 * @wordpress-plugin
 * Plugin Name:       CBX Bookmark & Favorite Pro Addon
 * Plugin URI:        https://codeboxr.com/product/cbx-wordpress-bookmark/
 * Description:       Pro add On for CBX Bookmark plugin
 * Version:           1.3.3
 * Author:            Codeboxr
 * Author URI:        https://codeboxr.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cbxwpbookmarkaddon
 * Domain Path:       /languages
 */


// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


defined( 'CBXWPBOOKMARKADDON_PLUGIN_NAME' ) or define( 'CBXWPBOOKMARKADDON_PLUGIN_NAME', 'cbxwpbookmarkaddon' );
defined( 'CBXWPBOOKMARKADDON_PLUGIN_VERSION' ) or define( 'CBXWPBOOKMARKADDON_PLUGIN_VERSION', '1.3.3' );
defined( 'CBXWPBOOKMARKADDON_BASE_NAME' ) or define( 'CBXWPBOOKMARKADDON_BASE_NAME', plugin_basename( __FILE__ ) );
defined( 'CBXWPBOOKMARKADDON_ROOT_PATH' ) or define( 'CBXWPBOOKMARKADDON_ROOT_PATH', plugin_dir_path( __FILE__ ) );
defined( 'CBXWPBOOKMARKADDON_ROOT_URL' ) or define( 'CBXWPBOOKMARKADDON_ROOT_URL', plugin_dir_url( __FILE__ ) );

register_activation_hook( __FILE__, array( 'CBXWpbookmarkaddon', 'activation' ) );


/**
 * CBX Bookmark Addon.
 *
 * Defines the Functionality of Cbxwpbookmarkaddon
 *
 * @package    Cbxwpbookmarkaddon
 * @subpackage Cbxwpbookmarkaddon/admin
 * @author     Codeboxr <info@codeboxr.com>
 */
class CBXWpbookmarkaddon {

	private $version;
	private $settings_api;

	/**
	 * Initialize the class and set its properties.
	 *
	 */
	public function __construct() {
		$this->version = CBXWPBOOKMARKADDON_PLUGIN_VERSION;
		//load text domain
		load_plugin_textdomain( 'cbxwpbookmarkaddon', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		$this->settings_api = new CBXWPBookmark_Settings_API();

		require_once plugin_dir_path( __FILE__ ) . 'includes/cbxwpbookmarkpro-tpl-loader.php';

		//if need to load any other things

		require_once plugin_dir_path( __FILE__ ) . 'includes/class-cbxwpbookmarkpro-helper.php'; //helper class with static methods
		$this->init();

		require_once plugin_dir_path( __FILE__ ) . 'includes/cbxwpbookmarkpro-functions.php'; //functions
	}//end

	/**
	 * Load the plugin on `init` hook
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'init', array( $this, 'init_pro_shortcodes' ) );
		add_action( 'widgets_init', array( $this, 'init_pro_widgets' ) );

		add_filter( 'cbxwpbookmark_post_types', array( $this, 'cbxwpbookmarkaddon_post_types' ) );

		add_filter( 'cbxwpbookmark_setting_sections', array( $this, 'proaddon_sections' ) );
		add_filter( 'cbxwpbookmark_global_cbxwpbookmark_proaddon_fields', array( $this, 'proaddon_fields' ) );
		add_filter( 'cbxwpbookmark_global_cbxwpbookmark_woocommerce_fields', array( $this, 'woocommerce_fields' ) );
		add_filter( 'cbxwpbookmark_global_cbxwpbookmark_buddypress_fields', array( $this, 'buddypress_fields' ) );
		add_filter( 'cbxwpbookmark_global_cbxwpbookmark_bbpress_fields', array( $this, 'bbpress_fields' ) );
		//add_filter( 'cbxwpbookmark_global_cbxwpbookmark_gridplugins_fields', array( $this, 'gridplugins_fields' ) );


		//buddypress integration
		add_action( 'bp_setup_nav', array( $this, 'add_cbxwpbookmark_buddypress_tabs' ), 100 );
		add_filter( 'bp_activity_entry_meta', array(
			$this,
			'bp_activity_entry_meta_bookmark_btn'
		) ); //bookmark button for buddypress stream

		//as there are major changes in core, these two actions are not in use any more.
		//add_action( 'cbxwpbookmark_othertype_item', array( $this, 'cbxwpbookmark_othertype_item' ), 10, 4 ); //my bookmmark widget or shortcode
		//add_action( 'cbxwpbookmark_othertype_mostitem', array( $this, 'cbxwpbookmark_othertype_mostitem' ), 10, 4 ); //most bookmark widget or shortcode

		add_action( 'cbxwpbookmark_item_othertype', array(
			$this,
			'cbxwpbookmark_item_othertype'
		), 10, 5 ); //my bookmmark widget or shortcode
		add_action( 'cbxwpbookmark_mostitem_othertype', array(
			$this,
			'cbxwpbookmark_mostitem_othertype'
		), 10, 5 ); //most bookmark widget or shortcode

		//end buddypress integration

		//add extra js and css
		add_action( 'cbxwpbookmark_css_end', array( $this, 'add_cbxwpbookmark_css' ) );
		add_action( 'cbxwpbookmark_js_end', array( $this, 'add_cbxwpbookmark_js' ) );
		//add_action( 'cbxwpbookmark_js_before_cbxwpbookmarkpublicjs', array( $this, 'cbxwpbookmark_js_before_cbxwpbookmarkpublicjs' ) );
		add_action( 'wp_head', array( $this, 'wp_head_custom_css' ) );

		//bookmarkgrid ajax
		add_action( 'wp_ajax_cbx_bookmark_postgrid_loadmore', array( $this, 'bookmark_postgrid_loadmore' ) );
		add_action( 'wp_ajax_nopriv_cbx_bookmark_postgrid_loadmore', array( $this, 'bookmark_postgrid_loadmore' ) );

		//bookmarkmostgrid ajax
		add_action( 'wp_ajax_cbx_bookmark_mostgrid_loadmore', array( $this, 'bookmark_mostgrid_loadmore' ) );
		add_action( 'wp_ajax_nopriv_cbx_bookmark_mostgrid_loadmore', array( $this, 'bookmark_mostgrid_loadmore' ) );

		add_filter( "plugin_action_links_" . plugin_basename( __FILE__ ), array( $this, 'admin_settings_link' ) );
		add_filter( "plugin_row_meta", array( $this, 'plugin_row_meta' ), 10, 4 );

		//create default category if user doesn't have any category
		add_filter( 'cbxwpbookmark_user_cats_found', array( $this, 'create_default_category' ), 10, 4 );
		add_filter( 'cbxwpbookmark_public_jsvar', array( $this, 'cbxwpbookmark_public_jsvar_extra' ), 10, 1 );

		//add fifu plugin support
		add_filter( 'cbxwpbookmark_all_thumbnail_sizes_formatted', array(
			$this,
			'cbxwpbookmark_all_thumbnail_sizes_formatted_fifu'
		) );

		//woocommerce support
		//add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'bookmark_after_addtocart_button' ) );
		add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'bookmark_after_add_to_cart_form' ) );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'bookmark_after_shop_loop_item' ), 11 );
		add_action( 'cbxwpbookmark_auto_integration', array(
			$this,
			'disable_for_woo_if_shownearcart'
		), 10, 6 ); //for archive mode

		add_action( 'init', array( $this, 'add_endpoint_woo_my_bookmarked' ) );
		add_filter( 'query_vars', array( $this, 'add_query_vars_woo_my_bookmarked' ), 0 );
		//add_filter( 'the_title', array( $this, 'endpoint_title_woo_my_bookmarked' ) );
		//add_filter( 'woocommerce_account_menu_items', array( $this, 'woo_my_bookmarked_tab' ), 10, 2 );
		add_filter( 'woocommerce_account_menu_items', array( $this, 'woo_my_bookmarked_tab' ), 10 );
		add_action( 'woocommerce_account_mybookmarkedproducts_endpoint', array(
			$this,
			'mybookmarkedproducts_endpoint_content'
		) );
		add_filter( 'woocommerce_short_description', array( $this, 'woo_shortcode_description_auto_integration' ) );


		//gutenberg
		add_action( 'init', array( $this, 'gutenberg_blocks' ) );
		add_action( 'enqueue_block_editor_assets', array(
			$this,
			'enqueue_block_editor_assets'
		) );//Hook: Editor assets.

		//not implemented yet
		//$this->loader->add_action( 'enqueue_block_assets', $plugin_admin, 'block_assets' );// Hook: Frontend assets.

		//customizer
		add_filter( 'cbxwpbookmark_customizer_strip_shortcodes', array(
			$this,
			'cbxwpbookmark_customizer_strip_shortcodes'
		) );
		add_filter( 'cbxwpbookmark_customizer_default_values', array(
			$this,
			'cbxwpbookmark_customizer_default_values'
		) );
		add_filter( 'cbxwpbookmark_customizer_shortcodes_choices', array(
			$this,
			'cbxwpbookmark_customizer_shortcodes_choices'
		) );
		add_action( 'cbxwpbookmark_customizer_shortcode_controls', array(
			$this,
			'cbxwpbookmark_customizer_shortcode_controls'
		), 10, 2 );

		//envira images
		//add_filter('envira_gallery_output_after_link', array($this, 'envira_gallery_output_after_item_btn'), 10, 5);

		//elementor Widget
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_elementor_widgets' ) );
		//add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'elementor_icon_loader' ), 99999 );

		//visual composer widget
		//add_action( 'vc_before_init', array($this, 'vc_before_init_actions'), 12 );//priority 12 works for both old and new version of vc
		add_action( 'vc_before_init', array(
			$this,
			'vc_before_init_actions'
		) );//priority 12 works for both old and new version of vc

		//add_filter('cbxwpbookmark_login_html', array($this, 'cbxwpbookmark_login_html_woo'), 10, 2);


		add_filter( 'cbxwpbookmark_guest_login_forms', array( $this, 'cbxwpbookmark_guest_login_forms_others' ) );
		add_filter( 'cbxwpbookmark_login_html', array( $this, 'cbxwpbookmark_login_html_others' ), 10, 3 );
		add_filter( 'cbxwpbookmark_register_html', array( $this, 'cbxwpbookmark_register_html_others' ), 10, 2 );

		add_filter( 'cbxwpbookmark_can_user_create_own_category', array(
			$this,
			'can_user_create_own_category'
		), 10, 2 );

		//on delete buddypress activity, delete bookmarks
		add_action( 'bp_activity_action_delete_activity', array( $this, 'delete_bookmark_buddypress' ), 10, 2 );

		//on bookmark post in buddypress
		add_action( 'bp_activity_register_activity_actions', array( $this, 'register_buddypress_activity' ) );
		add_action( 'cbxbookmark_bookmark_added', array( $this, 'buddypress_posting_on_bookmark' ), 10, 5 );
		//buddypress setting for bookmark
		add_action( 'bp_settings_setup_nav', array( $this, 'setup_settings_nav_user_setting' ) );
		add_filter( 'bp_notifications_get_registered_components', array(
			$this,
			'bd_add_custom_notification_component'
		) );
		add_filter( 'bp_notifications_get_notifications_for_user', array(
			$this,
			'custom_format_buddypress_notifications'
		), 10, 5 );
		add_filter( 'bp_nouveau_notifications_init_filters', array( $this, 'bp_nouveau_notifications_init_filters' ) );


		//$bd_ids = CBXWPBookmarkproHelper::get_buddypress_activity_by_user(1);


		//remove_filter( 'bp_activity_set_favorites_scope_args', 'bp_activity_filter_favorites_scope', 10 );
		add_filter( 'bp_activity_set_bookmarkedactivity_scope_args', array(
			$this,
			'bp_activity_filter_bookmarkedactivity_scope'
		), 10, 2 );
		add_action( 'bp_actions', array( $this, 'bp_remove_sub_tabs' ) );
		add_filter( 'bp_get_total_favorite_count_for_user', array(
			$this,
			'bp_get_total_favorite_count_for_user'
		), 10, 2 );

		//grid plugins integration
		//add_action('post_grid_loop', array($this, 'post_grid_loop_integration'));
		//add_action('post_grid_item_top', array($this, 'post_grid_loop_integration'));
		//add_action('post_grid_item_layout', array($this, 'post_grid_loop_integration'), 99999);

        //bbpress
		add_action('bbp_get_topic_favorite_link', array($this, 'bbp_get_topic_favorite_link_disable'), 10, 3 );
	}//end init

	/**
	 * Strip pro shortcodes
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public function cbxwpbookmark_customizer_strip_shortcodes( $content ) {
		$content = CBXWPBookmarkHelper::strip_shortcode( 'cbxwpbookmarkgrid', $content );

		//$content = CBXWPBookmarkHelper::strip_shortcode( 'cbxwpbookmark-mostgrid', $content );

		return $content;
	}//end cbxwpbookmark_customizer_strip_shortcodes

	/**
	 * Add pro shortcodes to customizer default
	 *
	 * @param array $customizer_default
	 *
	 * @return array
	 */
	public function cbxwpbookmark_customizer_default_values( $customizer_default = array() ) {
		$customizer_default['cbxwpbookmarkgrid'] = array(
			'title'       => esc_html__( 'All Bookmarks', 'cbxwpbookmarkaddon' ),//leave empty to ignore
			'order'       => 'DESC',
			'orderby'     => 'id', //id, object_id, object_type
			'limit'       => 6,
			'type'        => '', //post type, multiple post type in comma
			'loadmore'    => 1,  //this is shortcode only params
			'catid'       => '', //category id
			'cattitle'    => 1,  //show category title,
			'catcount'    => 1,  //show item count per category
			'allowdelete' => 0,
			'show_thumb'  => 1, //show thumbnail
		);

		/*$customizer_default['cbxwpbookmark-mostgrid'] = array(
				'title'      => esc_html__('Most Bookmarked Posts', 'cbxwpbookmarkaddon'), //if empty title will not be shown
				'order'      => 'DESC',
				'orderby'    => 'object_count', //id, object_id, object_type, object_count
				'limit'      => 10,
				'type'       => '', //db col name object_type,  post types eg, post, page, any custom post type, for multiple comma separated
				'daytime'    => 0, // 0 means all time,  any numeric values as days
				'show_count' => 1,
				'show_thumb' => 1,
				'load_more'   => 0,
			);*/

		return $customizer_default;
	}//end cbxwpbookmark_customizer_default_values

	/**
	 * Add pro shortcode to choices
	 *
	 * @param array $choices
	 *
	 * @return array
	 */
	public function cbxwpbookmark_customizer_shortcodes_choices( $choices = array() ) {
		$choices['cbxwpbookmarkgrid'] = esc_html__( 'Bookmark Grid', 'cbxwpbookmarkaddon' );

		return $choices;
	}//end cbxwpbookmark_customizer_shortcodes_choices

	/**
	 * Add pro addon controls to customizer
	 *
	 * @param object $wp_customize
	 * @param object $ref
	 */
	public function cbxwpbookmark_customizer_shortcode_controls( $wp_customize, $ref ) {
		//cbxwpbookmarkgrid shortcode
		$wp_customize->add_section(
			'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
			array(
				'title'    => esc_html__( 'Shortcode Params: Bookmark Grid', 'cbxwpbookmarkaddon' ),
				'priority' => 10,
				'panel'    => 'cbxwpbookmark',
			)
		);

		//title
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][title]',
			array(
				'default'           => esc_html__( 'All Bookmarks', 'cbxwpbookmarkaddon' ),
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			'cbxwpbookmark_customizer_shortcode_bookmarkgrid_title',
			array(
				'label'    => esc_html__( 'Title', 'cbxwpbookmarkaddon' ),
				'section'  => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
				'settings' => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][title]',
				'type'     => 'text',
				'default'  => esc_html__( 'All Bookmarks', 'cbxwpbookmarkaddon' ),
			)
		);

		//order
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][order]',
			array(
				'default'    => 'DESC',
				'type'       => 'option',
				'capability' => 'manage_options',

			)
		);

		$wp_customize->add_control(
			'cbxwpbookmark_customizer_shortcode_bookmarkgrid_order',
			array(
				'label'    => esc_html__( 'Order', 'cbxwpbookmarkaddon' ),
				'section'  => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
				'settings' => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][order]',
				'type'     => 'select',
				'default'  => 'DESC',
				'choices'  => array(
					'DESC' => esc_html__( 'Descending', 'cbxwpbookmarkaddon' ),
					'ASC'  => esc_html__( 'Ascending', 'cbxwpbookmarkaddon' )
				),
			)
		);

		//orderby
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][orderby]',
			array(
				'default'    => 'id',
				'type'       => 'option',
				'capability' => 'manage_options',

			)
		);

		$wp_customize->add_control(
			'cbxwpbookmark_customizer_shortcode_bookmarkgrid_orderby',
			array(
				'label'    => esc_html__( 'Order By', 'cbxwpbookmarkaddon' ),
				'section'  => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
				'settings' => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][orderby]',
				'type'     => 'select',
				'default'  => 'id',
				'choices'  => array(
					'id'          => esc_html__( 'ID', 'cbxwpbookmarkaddon' ),
					'object_id'   => esc_html__( 'Post ID', 'cbxwpbookmarkaddon' ),
					'object_type' => esc_html__( 'Post Type', 'cbxwpbookmarkaddon' ),
					'title'       => esc_html__( 'Post Title', 'cbxwpbookmarkaddon' ),
				),
			)
		);

		//limit
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][limit]',
			array(
				'default'           => '10',
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => array( $this, 'sanitize_number_field' ),
			)
		);

		$wp_customize->add_control(
			'cbxwpbookmark_customizer_shortcode_bookmarkgrid_limit',
			array(
				'label'       => esc_html__( 'Limit', 'cbxwpbookmarkaddon' ),
				'section'     => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
				'settings'    => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][limit]',
				'type'        => 'number',
				'default'     => '10',
				'input_attrs' => array(
					'min'  => 1,
					'max'  => 100,
					'step' => 1,
				),
			)
		);

		//type
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][type]',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'manage_options',
				'sanitize_callback' => array( $this, 'text_sanitization' ),
			)
		);


		$object_types = CBXWPBookmarkHelper::object_types_customizer_format();


		$wp_customize->add_control(
			new CBXWPBookmark_Customizer_Control_Select2(
				$wp_customize,
				'cbxwpbookmark_customizer_shortcode_bookmarkgrid_type',
				array(
					'label'       => esc_html__( 'Post Type(s)', 'cbxwpbookmarkaddon' ),
					'section'     => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
					'settings'    => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][type]',
					'type'        => 'cbxwpbookmark_select2',
					'default'     => '',
					'choices'     => $object_types,
					'input_attrs' => array(
						'placeholder' => esc_html__( 'Please select post type(s)', 'cbxwpbookmarkaddon' ),
						'multiselect' => true,
					),
				)
			)
		);

		//loadmore
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][loadmore]',
			array(
				'default'    => '1',
				'type'       => 'option',
				'capability' => 'manage_options'
			)
		);

		$wp_customize->add_control(
			new CBXWPBookmark_Customizer_Control_Switch(
				$wp_customize,
				'cbxwpbookmark_customizer_shortcode_bookmarkgrid_loadmore',
				array(
					'label'             => esc_html__( 'Show Load More', 'cbxwpbookmarkaddon' ),
					'section'           => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
					'settings'          => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][loadmore]',
					'type'              => 'cbxwpbookmark_switch',
					'default'           => '1',
					'sanitize_callback' => array( $this, 'absint' )
					/*'choices'  => array(
							'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
							'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
						),*/
				)
			)
		);

		//catid
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][catid]',
			array(
				'default'    => '',
				'type'       => 'option',
				'capability' => 'manage_options'
			)
		);

		$wp_customize->add_control(
			'cbxwpbookmark_customizer_shortcode_bookmarkgrid_catid',
			array(
				'label'    => esc_html__( 'Category ID', 'cbxwpbookmarkaddon' ),
				'section'  => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
				'settings' => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][catid]',
				'type'     => 'text',
				'default'  => ''
			)
		);

		//cattitle
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][cattitle]',
			array(
				'default'    => '1',
				'type'       => 'option',
				'capability' => 'manage_options'
			)
		);

		$wp_customize->add_control(
			new CBXWPBookmark_Customizer_Control_Switch(
				$wp_customize,
				'cbxwpbookmark_customizer_shortcode_bookmarkgrid_cattitle',
				array(
					'label'             => esc_html__( 'Show category title', 'cbxwpbookmarkaddon' ),
					'section'           => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
					'settings'          => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][cattitle]',
					'type'              => 'cbxwpbookmark_switch',
					'default'           => '1',
					'sanitize_callback' => array( $this, 'absint' )
					/*'choices'  => array(
							'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
							'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
						),*/
				)
			)
		);

		//catcount
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][catcount]',
			array(
				'default'    => '1',
				'type'       => 'option',
				'capability' => 'manage_options'
			)
		);

		$wp_customize->add_control(
			new CBXWPBookmark_Customizer_Control_Switch(
				$wp_customize,
				'cbxwpbookmark_customizer_shortcode_bookmarkgrid_catcount',
				array(
					'label'             => esc_html__( 'Show item count per category', 'cbxwpbookmarkaddon' ),
					'section'           => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
					'settings'          => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][catcount]',
					'type'              => 'cbxwpbookmark_switch',
					'default'           => '1',
					'sanitize_callback' => array( $this, 'absint' )
					/*'choices'  => array(
							'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
							'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
						),*/
				)
			)
		);

		//allowdelete
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][allowdelete]',
			array(
				'default'    => '0',
				'type'       => 'option',
				'capability' => 'manage_options'
			)
		);


		$wp_customize->add_control(
			new CBXWPBookmark_Customizer_Control_Switch(
				$wp_customize,
				'cbxwpbookmark_customizer_shortcode_bookmarkgrid_allowdelete',
				array(
					'label'             => esc_html__( 'Allow Delete', 'cbxwpbookmarkaddon' ),
					'section'           => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
					'settings'          => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][allowdelete]',
					'type'              => 'cbxwpbookmark_switch',
					'default'           => '0',
					'sanitize_callback' => array( $this, 'absint' )
					/*'choices'  => array(
							'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
							'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
						),*/
				)
			)
		);

		//allowdeleteall
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][allowdeleteall]',
			array(
				'default'    => '0',
				'type'       => 'option',
				'capability' => 'manage_options'
			)
		);


		$wp_customize->add_control(
			new CBXWPBookmark_Customizer_Control_Switch(
				$wp_customize,
				'cbxwpbookmark_customizer_shortcode_bookmarkgrid_allowdeleteall',
				array(
					'label'             => esc_html__( 'Allow Delete All', 'cbxwpbookmarkaddon' ),
					'section'           => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
					'settings'          => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][allowdeleteall]',
					'type'              => 'cbxwpbookmark_switch',
					'default'           => '0',
					'sanitize_callback' => array( $this, 'absint' )
					/*'choices'  => array(
							'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
							'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
						),*/
				)
			)
		);

		//show_thumb
		$wp_customize->add_setting(
			'cbxwpbookmark_customizer[cbxwpbookmarkgrid][show_thumb]',
			array(
				'default'    => '1',
				'type'       => 'option',
				'capability' => 'manage_options'
			)
		);


		$wp_customize->add_control(
			new CBXWPBookmark_Customizer_Control_Switch(
				$wp_customize,
				'cbxwpbookmark_customizer_shortcode_bookmarkgrid_show_thumb',
				array(
					'label'             => esc_html__( 'Show Thumbnail', 'cbxwpbookmarkaddon' ),
					'section'           => 'cbxwpbookmark_customizer_shortcode_bookmarkgrid',
					'settings'          => 'cbxwpbookmark_customizer[cbxwpbookmarkgrid][show_thumb]',
					'type'              => 'cbxwpbookmark_switch',
					'default'           => '1',
					'sanitize_callback' => array( $this, 'absint' )
					/*'choices'  => array(
							'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
							'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
						),*/
				)
			)
		);
	}//end cbxwpbookmark_customizer_shortcode_controls

	/**
	 * Number field sanitization
	 *
	 * @param $number
	 * @param $setting
	 *
	 * @return int
	 */
	public function sanitize_number_field( $number, $setting ) {
		// Ensure $number is an absolute integer (whole number, zero or greater).
		$number = absint( $number );

		// If the input is an absolute integer, return it; otherwise, return the default
		return ( $number ? $number : $setting->default );
	}//end sanitize_number_field

	/**
	 * Text field sanitizer
	 *
	 * @param string $input
	 *
	 * @return string
	 */
	public function text_sanitization( $input ) {
		if ( strpos( $input, ',' ) !== false ) {
			$input = explode( ',', $input );
		}

		if ( is_array( $input ) ) {
			foreach ( $input as $key => $value ) {
				$input[ $key ] = sanitize_text_field( $value );
			}
			$input = implode( ',', $input );
		} else {
			$input = sanitize_text_field( $input );
		}

		return $input;
	}//end text_sanitization

	/**
	 * @param $auto_integration_ok
	 * @param $post_id
	 * @param $post_type
	 * @param $showcount
	 * @param $skip_ids
	 * @param $skip_roles
	 *
	 * @return bool
	 */
	public function disable_for_woo_if_shownearcart( $auto_integration_ok, $post_id, $post_type, $showcount, $skip_ids, $skip_roles ) {
		$setting = $this->settings_api;

		//$user_id = get_current_user_id();
		global $post;

		$post_type = $post->post_type;

		//$show_woobtn_nearcart = $setting->get_option( 'show_woobtn_nearcart', 'cbxwpbookmark_proaddon', 1 );
		$disable_woo_auto = $setting->get_option( 'disable_woo_auto', 'cbxwpbookmark_woocommerce', 0 );

		if ( $post_type == 'product' && $disable_woo_auto == 1 ) {
			return false;
		}


		$enable_woo_shortdescription = $setting->get_option( 'enable_woo_shortdescription', 'cbxwpbookmark_woocommerce', 0 );
		if ( ! in_array( 'woocommerce_short_description', $GLOBALS['wp_current_filter'] ) && $post_type == 'product' && $enable_woo_shortdescription == 1 ) {
			return false;
		}

		return $auto_integration_ok;
	}//end class disable_for_woo_if_shownearcart

	/**
	 * Register new endpoint to use inside My Account page.
	 *
	 * @since 2.1.4
	 * @see   https://developer.wordpress.org/reference/functions/add_rewrite_endpoint/
	 */
	public function add_endpoint_woo_my_bookmarked() {
		$setting              = $this->settings_api;
		$woo_mybookmarked_tab = intval( $setting->get_option( 'woo_mybookmarked_tab', 'cbxwpbookmark_woocommerce', 1 ) );

		if ( $woo_mybookmarked_tab ) {
			add_rewrite_endpoint( $this->get_endpoint_woo_my_bookmarked(), EP_PAGES );
		}
	}

	/**
	 * Return the my-account page endpoint.
	 *
	 * @return string
	 * @since 2.1.4
	 */
	public function get_endpoint_woo_my_bookmarked() {
		$setting              = $this->settings_api;
		$woo_mybookmarked_tab = intval( $setting->get_option( 'woo_mybookmarked_tab', 'cbxwpbookmark_woocommerce', 1 ) );

		if ( $woo_mybookmarked_tab ) {
			return apply_filters( 'woocommerce_cbxwpbookmark_account_endpoint', 'mybookmarkedproducts' );
		}
	}

	/**
	 * Add new query var.
	 *
	 * @param array $vars
	 *
	 * @return array
	 * @since 2.1.4
	 *
	 */
	public function add_query_vars_woo_my_bookmarked( $vars ) {
		$setting              = $this->settings_api;
		$woo_mybookmarked_tab = intval( $setting->get_option( 'woo_mybookmarked_tab', 'cbxwpbookmark_woocommerce', 1 ) );

		if ( $woo_mybookmarked_tab ) {
			$vars[] = $this->get_endpoint_woo_my_bookmarked();
		}

		return $vars;
	}

	/**
	 * Change endpoint title.
	 *
	 * @param string $title
	 *
	 * @return string
	 * @since 2.1.4
	 *
	 */
	public function endpoint_title_woo_my_bookmarked( $title ) {
		$setting              = $this->settings_api;
		$woo_mybookmarked_tab = intval( $setting->get_option( 'woo_mybookmarked_tab', 'cbxwpbookmark_woocommerce', 1 ) );

		if ( $woo_mybookmarked_tab ) {
			global $wp_query;

			$is_endpoint = isset( $wp_query->query_vars[ $this->get_endpoint_woo_my_bookmarked() ] );

			if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
				$title = esc_html__( 'Bookmarked Products', 'cbxwpbookmarkaddon' );
				remove_filter( 'the_title', array( $this, 'endpoint_title' ) );
			}
		}

		return $title;
	}

	/**
	 * Add new tab to woocommerce my account
	 *
	 * Add my bookmarked tab in my account sections
	 *
	 * @param $items
	 *
	 * @return mixed
	 */
	public function woo_my_bookmarked_tab( $items ) {
		$setting              = $this->settings_api;
		$woo_mybookmarked_tab = intval( $setting->get_option( 'woo_mybookmarked_tab', 'cbxwpbookmark_woocommerce', 1 ) );

		if ( $woo_mybookmarked_tab ) {

			// Remove logout menu item.
			if ( array_key_exists( 'customer-logout', $items ) ) {
				$logout = $items['customer-logout'];
				unset( $items['customer-logout'] );
			}

			// Add appointments menu item.
			$items[ $this->get_endpoint_woo_my_bookmarked() ] = esc_html__( 'Bookmarked Products', 'cbxwpbookmarkaddon' );

			// Add back the logout item.
			if ( isset( $logout ) ) {
				$items['customer-logout'] = $logout;
			}
		}

		return $items;
	}//end woo_my_bookmarked_tab

	/**
	 * Show content for my bookmarked products
	 */
	public function mybookmarkedproducts_endpoint_content( $current_page ) {
		//$current_page         = empty( $current_page ) ? 1 : absint( $current_page );
		$setting              = $this->settings_api;
		$woo_mybookmarked_tab = intval( $setting->get_option( 'woo_mybookmarked_tab', 'cbxwpbookmark_woocommerce', 1 ) );

		if ( $woo_mybookmarked_tab ) {

			$limit = intval( $setting->get_option( 'woo_mybookmarked_limit', 'cbxwpbookmark_woocommerce', 12 ) );

			$current_user_id = get_current_user_id();
			echo '<h2>' . esc_html__( 'My Bookmarked Products', '' ) . '</h2>';

			echo do_shortcode( '[cbxwpbookmarkgrid hide_title="1" limit="' . $limit . '" userid="' . intval( $current_user_id ) . '" type="product" loadmore="1" allowdelete="1"]' );
			//echo do_shortcode('[cbxwpbookmarkgrid userid="'.intval($current_user_id).'"  loadmore="1" allowdelete="1"]');
		}
	}//end mybookmarkedproducts_endpoint_content

	public function woo_shortcode_description_auto_integration( $content ) {
		$setting                     = $this->settings_api;
		$enable_woo_shortdescription = $setting->get_option( 'enable_woo_shortdescription', 'cbxwpbookmark_woocommerce', 0 );

		if ( $enable_woo_shortdescription == 1 ) {
			$plugin_public = new CBXWPbookmark_Public( CBXWPBOOKMARK_PLUGIN_NAME, CBXWPBOOKMARK_PLUGIN_VERSION );

			return $plugin_public->bookmark_auto_integration( $content );
		}

		return $content;

	}


	/**
	 * Bookmark button after add to cart in details product page
	 */
	public function bookmark_after_add_to_cart_form() {
		$setting = $this->settings_api;

		$woobtn_aftercart = intval( $setting->get_option( 'show_woobtn_aftercart', 'cbxwpbookmark_woocommerce', 1 ) );
		if ( $woobtn_aftercart == 0 ) {
			return '';
		}

		$this->bookmark_button_woo();
	}//end bookmark_after_add_to_cart_form

	/**
	 * Bookmark button in product archive/loop pages
	 */
	public function bookmark_after_shop_loop_item() {
		$setting = $this->settings_api;

		$woobtn_inloop = intval( $setting->get_option( 'show_woobtn_archive', 'cbxwpbookmark_woocommerce', 0 ) );
		if ( $woobtn_inloop == 0 ) {
			return '';
		}

		$this->bookmark_button_woo();
	}//end bookmark_after_shop_loop_item


	/**
	 * Add bookmark button after
	 *
	 * @return string
	 */
	public function bookmark_button_woo() {
		$setting = $this->settings_api;

		//$user_id = get_current_user_id();
		global $post;
		$post_id   = $post->ID;
		$post_type = $post->post_type;

		/*$position = $this->settings_api->get_option( 'cbxbookmarkpostion', 'cbxwpbookmark_basics', 'after_content' );
			if ( $position == 'disable' ) {
				return '';
			}*/

		/*$show_woobtn_archive = intval( $setting->get_option( 'show_woobtn_archive', 'cbxwpbookmark_proaddon', 1 ) );
			if ( $show_woobtn_archive == 0 ) {
				return '';
			}*/


		$post_types_to_show_bookmark = $setting->get_option( 'cbxbookmarkposttypes', 'cbxwpbookmark_basics', array(
			'post',
			'page'
		) );

		$skip_ids   = $setting->get_option( 'skip_ids', 'cbxwpbookmark_basics', '' );
		$skip_roles = $setting->get_option( 'skip_roles', 'cbxwpbookmark_basics', '' );
		$showcount  = intval( $setting->get_option( 'showcount', 'cbxwpbookmark_basics', 0 ) );

		//$show_in_archive = intval( $setting->get_option( 'showinarchive', 'cbxwpbookmark_basics', 0 ) );
		//$show_in_home    = intval( $setting->get_option( 'showinhome', 'cbxwpbookmark_basics', 0 ) );

		//if archive and show archive false then return content
		/*if ( ! $show_in_archive && is_archive() ) {
				return '';
			}*/


		//if home and show in home false then return content
		/*if ( ! $show_in_home && ( is_home() && is_front_page() ) ) {
				return '';
			}*/

		//check if the bookmark button is allowed
		if ( ! in_array( $post->post_type, $post_types_to_show_bookmark ) ) {
			return '';
		}


		//grab bookmark button html
		if ( is_array( $skip_roles ) ) {
			$skip_roles = implode( ',', $skip_roles );
		}

		$bookmark_html = show_cbxbookmark_btn( $post_id, $post_type, $showcount, '', $skip_ids, $skip_roles );

		echo $bookmark_html;
	}//end bookmark_button_woo

	/**
	 * Init shortcodes
	 */
	public function init_pro_shortcodes() {
		//shortcode to display bookmakred posts as grid
		add_shortcode( 'cbxwpbookmarkgrid', array( $this, 'cbxbookmark_postgrid' ) );      //my bookmark post grid

		//shortcode to display most bookmarked post as grid
		add_shortcode( 'cbxwpbookmark-mostgrid', array( $this, 'cbxbookmark_mostgrid' ) ); //most bookmark post grid

		add_shortcode( 'cbxwpbookmark-mostproducts', array(
			$this,
			'cbxbookmark_mostproducts'
		) ); //most bookmarked products(wocommerce)
		add_shortcode( 'cbxwpbookmark-mostdownloads', array(
			$this,
			'cbxbookmark_mostdownlaods'
		) ); //most bookmarked downloads(easy digital downloads)
	}//end init_pro_shortcodes


	/**
	 * Add extra public js variable or override them
	 *
	 * @param $cbxwpbookmark_translation
	 *
	 * @return mixed
	 */
	function cbxwpbookmark_public_jsvar_extra( $cbxwpbookmark_translation ) {
		$setting = $this->settings_api;


		$current_user_id = intval( get_current_user_id() );

		//max cat limit override
		$max_cat_limit = $setting->get_option( 'max_cat_limit', 'cbxwpbookmark_proaddon', '10' );
		$max_cat_limit = apply_filters( 'cbxwpbookmark_max_cat_limit', $max_cat_limit, $current_user_id );

		$cbxwpbookmark_translation['max_cat_limit'] = intval( $max_cat_limit ); //0 means unlimited

		//who can create category override
		$default_roles = array( 'administrator', 'editor', 'author', 'contributor', 'subscriber' );
		$current_user  = wp_get_current_user();
		if ( is_user_logged_in() ) {
			$this_user_role = $current_user->roles;
		} else {
			$this_user_role = array( 'guest' );
		}

		$cat_create_role    = $setting->get_option( 'cat_create_role', 'cbxwpbookmark_proaddon', $default_roles );
		$allowed_user_group = array_intersect( $cat_create_role, $this_user_role );
		if ( ( sizeof( $allowed_user_group ) ) < 1 ) {
			//current user is not allowed
			$cbxwpbookmark_translation['user_can_create_cat'] = 0;
		} else {
			$cbxwpbookmark_translation['user_can_create_cat'] = 1;
		}


		return $cbxwpbookmark_translation;
	}//end cbxwpbookmark_public_jsvar_extra

	/**
	 * Create default category for user if none exists
	 *
	 * @param $cats_by_user
	 * @param $user_id
	 * @param $object_id
	 * @param $object_type
	 *
	 * @return array
	 */
	public function create_default_category( $cats_by_user, $user_id, $object_id, $object_type ) {
		global $wpdb;

		$setting = $this->settings_api;

		$enable_default_cat = $setting->get_option( 'enable_default_cat', 'cbxwpbookmark_proaddon', 'yes' );
		$default_cat_namet  = $setting->get_option( 'default_cat_name', 'cbxwpbookmark_proaddon', esc_html__( 'My Favorites', 'cbxwpbookmarkaddon' ) );


		if ( $default_cat_namet == '' ) {
			$default_cat_namet = esc_html__( 'My Favorites', 'cbxwpbookmarkaddon' );
		}


		if ( ( $cats_by_user == null ) && ( $enable_default_cat == 'yes' ) ) {

			$category_table = $wpdb->prefix . 'cbxwpbookmarkcat';


			$cat_name    = $default_cat_namet;
			$cat_privacy = 0; //private


			$return = $wpdb->query( $wpdb->prepare( "INSERT INTO $category_table ( cat_name, user_id, privacy ) VALUES ( %s, %d, %d )", array(
				$cat_name,
				$user_id,
				$cat_privacy
			) ) );

			if ( $return !== false ) {
				$cat_id         = $wpdb->insert_id;
				$cats_by_user   = array();
				$cats_by_user[] = array(
					'id'       => $cat_id,
					'cat_name' => $cat_name,
					'user_id'  => $user_id,
					'privacy'  => $cat_privacy
				);

			}

		}

		return $cats_by_user;
	}//end create_default_category

	/**
	 * Add new section for pro addon support
	 *
	 * @param $sections
	 *
	 * @return array
	 */
	public function proaddon_sections( $sections ) {
		$pro_sections = array(
			array(
				'id'    => 'cbxwpbookmark_proaddon',
				'title' => esc_html__( 'Pro Setting', 'cbxwpbookmarkaddon' )
			),
			array(
				'id'    => 'cbxwpbookmark_buddypress',
				'title' => esc_html__( 'BuddyPress Integration', 'cbxwpbookmarkaddon' )
			),
			array(
				'id'    => 'cbxwpbookmark_bbpress',
				'title' => esc_html__( 'BBPress Integration', 'cbxwpbookmarkaddon' )
			),
			array(
				'id'    => 'cbxwpbookmark_woocommerce',
				'title' => esc_html__( 'WooCommerce Integration', 'cbxwpbookmarkaddon' )
			)
			/*array(
					'id'    => 'cbxwpbookmark_gridplugins',
					'title' => esc_html__( 'Grid Plugins Integration', 'cbxwpbookmarkaddon' )
				)*/
		);

		return array_merge( $sections, $pro_sections );
	}//end proaddon_sections

	/**
	 * Woocommerce fields
	 *
	 * @param $fields
	 *
	 * @return array[]
	 */
	public function woocommerce_fields( $fields ) {
		$fields = array(
			'woo_heading'            => array(
				'name'    => 'woo_heading',
				'label'   => esc_html__( 'WooCommerce Integration Settings', 'cbxwpbookmarkaddon' ),
				'type'    => 'heading',
				'default' => '',
			),
			'woo_mybookmarked_tab'   => array(
				'name'    => 'woo_mybookmarked_tab',
				'label'   => esc_html__( 'Enable Bookmark Tab', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Add tab to woocommerce my account sections to show user\'s bookmarked products, Woocommerce product post type need to be selected from General Settings. If this tab doesn\'t show please save permalink once from site setting.', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					1 => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					0 => esc_html__( 'No', 'cbxwpbookmarkaddon' )
				),
				'default' => 1
			),
			'woo_mybookmarked_limit' => array(
				'name'              => 'woo_mybookmarked_limit',
				'label'             => esc_html__( 'Bookmark Tab Bookmarks Limits', 'cbxwpbookmarkaddon' ),
				'desc'              => esc_html__( 'Number of products to display as bookmark in my bookmarked products tab', 'cbxwpbookmarkaddon' ),
				'type'              => 'text',
				'default'           => 12,
				'sanitize_callback' => 'absint'
			),
			'woo_login'              => array(
				'name'    => 'woo_login',
				'label'   => esc_html__( 'Integration with Woocommerce Login', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Display woocommerce\'s login form for guest user as replacement of wordpress regular login form.', 'cbxwpbookmarkaddon' ),
				'type'    => 'select',
				'options' => array(
					1 => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					0 => esc_html__( 'No', 'cbxwpbookmarkaddon' )
				),
				'default' => 0
			),

			'show_woobtn_archive'         => array(
				'name'    => 'show_woobtn_archive',
				'label'   => esc_html__( 'Bookmark in WooCommerce Product Archive', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Show bookmark button in woocommerce product archive near add to cart button. Default auto integration doesn\'t work for for woocommerce archive page.', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Enable', 'cbxwpbookmarkaddon' ),
					'0' => esc_html__( 'Disable', 'cbxwpbookmarkaddon' )
				),
				'default' => 0,
				//'desc_tip' => true,
			),
			'disable_woo_auto'            => array(
				'name'    => 'disable_woo_auto',
				'label'   => esc_html__( 'Disable Auto Intergation for Woocommerce', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Woocommerce may need special integration so auto integration for woocommerce details page, can be disabled from here', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
				),
				'default' => 0,
			),
			'show_woobtn_aftercart'       => array(
				'name'    => 'show_woobtn_aftercart',
				'label'   => esc_html__( 'Bookmark in WooCommerce Product Details(After Cart)', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Show bookmark button in woocommerce product details after add to cart button. To skip repeat bookmark button in product details page use this feature.', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Enable', 'cbxwpbookmarkaddon' ),
					'0' => esc_html__( 'Disable', 'cbxwpbookmarkaddon' )
				),
				'default' => 0,
			),
			'enable_woo_shortdescription' => array(
				'name'    => 'enable_woo_shortdescription',
				'label'   => esc_html__( 'Enable Auto for Product Shortcode Description', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Enable auto integration for product short description. If this is enabled then auto integration will be disabled for long description.', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
				),
				'default' => 0,
			),

		);

		return $fields;
	}//end woocommerce_fields

	/**
	 * Fields for grid plugin integration
	 */
	public function gridplugins_fields() {
		$fields = array(
			'gridplugins_heading_thepostgrid' => array(
				'name'    => 'gridplugins_heading_thepostgrid',
				'label'   => esc_html__( 'The Post Grid - By RadiusTheme - Settings', 'cbxwpbookmarkaddon' ),
				'type'    => 'heading',
				'default' => '',
			),
			'thepostgrid_enable'              => array(
				'name'    => 'thepostgrid_enable',
				'label'   => esc_html__( 'Enable for The Post Grid', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
				),
				'default' => 0,
			),
		);

		return $fields;
	}//end gridplugins_fields

	/**
	 * BuddyPress fields (section id 'cbxwpbookmark_buddypress')
	 *
	 * @return array[]
	 */
	public function buddypress_fields() {
		$posts_definition = CBXWPBookmarkHelper::post_types_multiselect( CBXWPBookmarkHelper::post_types() );

		$fields = array(
			'buddypress_heading'          => array(
				'name'    => 'buddypress_heading',
				'label'   => esc_html__( 'BuddyPress Integration Settings', 'cbxwpbookmarkaddon' ),
				'type'    => 'heading',
				'default' => '',
			),
			'buddy_bookmark_profile_tab'  => array(
				'name'    => 'buddy_bookmark_profile_tab',
				'label'   => esc_html__( 'Show Bookmark in Buddypress Profile tab', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Show tab in buddypress user profile for bookmarks', 'cbxwpbookmarkaddon' ),
				'type'    => 'checkbox',
				'default' => 'on',
			),
			'buddy_bookmark_slug'         => array(
				'name'    => 'buddy_bookmark_slug',
				'label'   => esc_html__( 'BuddyPress My Bookmark Slug', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Slug used for buddypress my bookmark page. Use all lowercase without any space', 'cbxwpbookmarkaddon' ),
				'type'    => 'text',
				'default' => 'bookmarks',
			),
			'enable_buddypress_bookmark'  => array(
				'name'    => 'enable_buddypress_bookmark',
				'label'   => esc_html__( 'BuddyPress Activity Bookmark', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'This will enable bookmark feature for BuddyPress activity stream', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Enable', 'cbxwpbookmarkaddon' ),
					'0' => esc_html__( 'Disable', 'cbxwpbookmarkaddon' )
				),
				'default' => 1,
			),
			'enable_buddypress_posting'   => array(
				'name'    => 'enable_buddypress_posting',
				'label'   => esc_html__( 'BuddyPress Activity Post', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'On bookmark -> post activity into buddypress stream/user timeline. User can disable from buddypress setting. If user bookmarks in any private category then it will be ignored.', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Enable', 'cbxwpbookmarkaddon' ),
					'0' => esc_html__( 'Disable', 'cbxwpbookmarkaddon' )
				),
				'default' => 0,
			),
			'buddypress_posting_types'    => array(
				'name'     => 'buddypress_posting_types',
				'label'    => esc_html__( 'BuddyPress Activity Post Types', 'cbxwpbookmarkaddon' ),
				'desc'     => esc_html__( 'On which post type(s) bookmark there will be buddypress posting', 'cbxwpbookmarkaddon' ),
				'type'     => 'multiselect',
				'optgroup' => 1,
				'default'  => array( 'post', 'page' ),
				'options'  => $posts_definition,
			),
			'enable_buddypress_notify'    => array(
				'name'    => 'enable_buddypress_notify',
				'label'   => esc_html__( 'BuddyPress Notification', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'If user A bookmarks user B\'s article. User B will get notification. User B can disable from buddypress setting. If user A bookmarks in any private category then it will be ignored. This will only work for wordpress compatible post types(core or custom).', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Enable', 'cbxwpbookmarkaddon' ),
					'0' => esc_html__( 'Disable', 'cbxwpbookmarkaddon' )
				),
				'default' => 0,
			),
			'disable_buddypress_fav'      => array(
				'name'    => 'disable_buddypress_fav',
				'label'   => esc_html__( 'Disable Buddypress Favorite', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Disable buddypress\'s native favorite feature, so that cbx bookmark\'s bookmark feature can be used as only favorite/bookmark feature', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
				),
				'default' => 0,
			),
			'display_bookmarked_activity' => array(
				'name'    => 'display_bookmarked_activity',
				'label'   => esc_html__( 'Display Bookmarked Activity', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Display bookmarked activity sub menu under activity menu', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
				),
				'default' => 1,
			),
		);

		return $fields;
	}//end buddypress_fields

    public function bbpress_fields(){
	    $fields = array(
		    'bbpress_heading'          => array(
			    'name'    => 'bbpress_heading',
			    'label'   => esc_html__( 'BBPress Integration Settings', 'cbxwpbookmarkaddon' ),
			    'type'    => 'heading',
			    'default' => '',
		    ),

		    'disable_bbpress_fav'      => array(
			    'name'    => 'disable_bbpress_fav',
			    'label'   => esc_html__( 'Disable BBPress Favorite', 'cbxwpbookmarkaddon' ),
			    'desc'    => esc_html__( 'Disable bbpress\'s native favorite feature, so that cbx bookmark\'s bookmark feature can be used as only favorite/bookmark feature', 'cbxwpbookmarkaddon' ),
			    'type'    => 'radio',
			    'options' => array(
				    '1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
				    '0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
			    ),
			    'default' => 0,
		    ),
	    );

	    return $fields;
    }//end bbpress_fields

	/**
	 * Fields for proaddon setting section
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	public function proaddon_fields( $fields ) {

		global $wp_roles;

		// now this is for meta box

		$roles = CBXWPBookmarkHelper::user_roles( true, false );

		$default_roles    = array( 'administrator', 'editor', 'author', 'contributor', 'subscriber' );
		$posts_definition = CBXWPBookmarkHelper::post_types_multiselect( CBXWPBookmarkHelper::post_types() );

		$setting = $this->settings_api;

		$cat_create_role = $setting->get_option( 'cat_create_role', 'cbxwpbookmark_proaddon', $default_roles );

		$available_thumbnail_sizes = CBXWPBookmarkHelper::get_all_image_sizes_formatted();

		$fields = array(
			'pro_heading'         => array(
				'name'    => 'pro_heading',
				'label'   => esc_html__( 'Pro Features Settings', 'cbxwpbookmarkaddon' ),
				'type'    => 'heading',
				'default' => '',
			),
			'enable_default_cat'  => array(
				'name'    => 'enable_default_cat',
				'label'   => esc_html__( 'Enable Default Category', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'If enabled, plugin will create default category for any user while any user will try to bookmark, in case there is no category created by that user before.', 'cbxwpbookmarkaddon' ),
				'type'    => 'radio',
				'options' => array(
					'yes' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					'no'  => esc_html__( 'No', 'cbxwpbookmarkaddon' )
				),
				'default' => 'yes',
				//'desc_tip' => true,
			),
			'default_cat_name'    => array(
				'name'    => 'default_cat_name',
				'label'   => esc_html__( 'Default Category Name', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'If empty default category name will be used "My Favorites"', 'cbxwpbookmarkaddon' ),
				'type'    => 'text',
				'default' => esc_html__( 'My Favorites', 'cbxwpbookmarkaddon' ),
				//'desc_tip' => true,
			),
			'max_cat_limit'       => array(
				'name'    => 'max_cat_limit',
				'label'   => esc_html__( 'Maximum Category Per User', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Maximum number of categories user can create, if set 0 then unlimited', 'cbxwpbookmarkaddon' ),
				'type'    => 'number',
				'default' => '10',
				//'desc_tip' => true,
			),
			'cat_create_role'     => array(
				'name'     => 'cat_create_role',
				'label'    => esc_html__( 'Who can create Catagory', 'cbxwpbookmarkaddon' ),
				'desc'     => esc_html__( 'Choose user roles who can create', 'cbxwpbookmarkaddon' ),
				'type'     => 'multiselect',
				'optgroup' => 0,
				'options'  => $roles,
				'default'  => $cat_create_role,
				//'desc_tip' => true,
			),
			/*'buddy_bookmark_profile_tab' => array(
					'name'     => 'buddy_bookmark_profile_tab',
					'label'    => esc_html__( 'Show Bookmark in Buddypress Profile tab', 'cbxwpbookmarkaddon' ),
					'desc'     => esc_html__( 'Show tab in buddypress user profile for bookmarks', 'cbxwpbookmarkaddon' ),
					'type'     => 'checkbox',
					'default'  => 'on',
					//'desc_tip' => true,
				),
				'buddy_bookmark_slug'        => array(
					'name'     => 'buddy_bookmark_slug',
					'label'    => esc_html__( 'BuddyPress My Bookmark Slug', 'cbxwpbookmarkaddon' ),
					'desc'     => esc_html__( 'Slug used for buddypress my bookmark page. Use all lowercase without any space', 'cbxwpbookmarkaddon' ),
					'type'     => 'text',
					'default'  => 'bookmarks',
				),
                'enable_buddypress_bookmark' => array(
                    'name'     => 'enable_buddypress_bookmark',
                    'label'    => esc_html__( 'BuddyPress Activity Bookmark', 'cbxwpbookmarkaddon' ),
                    'desc'     => esc_html__( 'This will enable bookmark feature for BuddyPress activity stream', 'cbxwpbookmarkaddon' ),
                    'type'     => 'radio',
                    'options'  => array(
                        '1' => esc_html__( 'Enable', 'cbxwpbookmarkaddon' ),
                        '0' => esc_html__( 'Disable', 'cbxwpbookmarkaddon' )
                    ),
                    'default'  => 1,
                ),
                'enable_buddypress_posting' => array(
                    'name'     => 'enable_buddypress_posting',
                    'label'    => esc_html__( 'BuddyPress Activity Post', 'cbxwpbookmarkaddon' ),
                    'desc'     => esc_html__( 'On bookmark -> post activity into buddypress stream/user timeline. User can disable from buddypress setting. If user bookmarks in any private category then it will be ignored.', 'cbxwpbookmarkaddon' ),
                    'type'     => 'radio',
                    'options'  => array(
                        '1' => esc_html__( 'Enable', 'cbxwpbookmarkaddon' ),
                        '0' => esc_html__( 'Disable', 'cbxwpbookmarkaddon' )
                    ),
                    'default'  => 0,
                ),
                'buddypress_posting_types' => array(
                    'name'     => 'buddypress_posting_types',
                    'label'    => esc_html__( 'BuddyPress Activity Post Types', 'cbxwpbookmarkaddon' ),
                    'desc'     => esc_html__( 'On which post type(s) bookmark there will be buddypress posting', 'cbxwpbookmarkaddon' ),
                    'type'     => 'multiselect',
                    'optgroup' => 1,
                    'default'  => array( 'post', 'page' ),
                    'options'  => $posts_definition,
                ),
				'enable_buddypress_notify' => array(
					'name'     => 'enable_buddypress_notify',
					'label'    => esc_html__( 'BuddyPress Notification', 'cbxwpbookmarkaddon' ),
					'desc'     => esc_html__( 'If user A bookmarks user B\'s article. User B will get notification. User B can disable from buddypress setting. If user A bookmarks in any private category then it will be ignored. This will only work for wordpress compatible post types(core or custom).', 'cbxwpbookmarkaddon' ),
					'type'     => 'radio',
					'options'  => array(
						'1' => esc_html__( 'Enable', 'cbxwpbookmarkaddon' ),
						'0' => esc_html__( 'Disable', 'cbxwpbookmarkaddon' )
					),
					'default'  => 0,
				),*/
			'pro_grid_thumb_size' => array(
				'name'     => 'pro_grid_thumb_size',
				'label'    => esc_html__( 'Grid display thumb sizes', 'cbxwpbookmarkaddon' ),
				'desc'     => esc_html__( 'Grid display thumb sizes', 'cbxwpbookmarkaddon' ),
				'type'     => 'select',
				'optgroup' => 0,
				'options'  => $available_thumbnail_sizes,
				'default'  => 'medium'
			),

			/*'disable_woo_auto'       => array(
					'name'     => 'disable_woo_auto',
					'label'    => esc_html__( 'Disable Auto Intergation for Woocommerce', 'cbxwpbookmarkaddon' ),
					'desc'     => esc_html__( 'Woocommerce may need special integration so auto integration for woocommerce can be disabled from here', 'cbxwpbookmarkaddon' ),
					'type'     => 'radio',
					'options'  => array(
						'1' => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
						'0' => esc_html__( 'No', 'cbxwpbookmarkaddon' )
					),
					'default'  => 0,
					//'desc_tip' => true,
				),
				'show_woobtn_archive'       => array(
					'name'     => 'show_woobtn_archive',
					'label'    => esc_html__( 'Bookmark in WooCommerce Product Archive', 'cbxwpbookmarkaddon' ),
					'desc'     => esc_html__( 'Show bookmark button in woocommerce product archive near add to cart button. This will override regular bookmark button presentation as auto integration. Auto integration must be enabled to make feature work.', 'cbxwpbookmarkaddon' ),
					'type'     => 'radio',
					'options'  => array(
						'1' => esc_html__( 'Enable', 'cbxwpbookmarkaddon' ),
						'0' => esc_html__( 'Disable', 'cbxwpbookmarkaddon' )
					),
					'default'  => 0,
					//'desc_tip' => true,
				),
				'show_woobtn_aftercart'       => array(
					'name'     => 'show_woobtn_aftercart',
					'label'    => esc_html__( 'Bookmark in WooCommerce Product Details(After Cart)', 'cbxwpbookmarkaddon' ),
					'desc'     => esc_html__( 'Show bookmark button in woocommerce product details after add to cart button. This will override regular bookmark button presentation as auto integration. Auto integration must be enabled to make feature work.', 'cbxwpbookmarkaddon' ),
					'type'     => 'radio',
					'options'  => array(
						'1' => esc_html__( 'Enable', 'cbxwpbookmarkaddon' ),
						'0' => esc_html__( 'Disable', 'cbxwpbookmarkaddon' )
					),
					'default'  => 1,
					//'desc_tip' => true,
				),*/
			'bookmark_icon'       => array(
				'name'    => 'bookmark_icon',
				'label'   => esc_html__( 'Bookmark Icon', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Choose ready made custom bookmark icon. If bookmark icon type is selected from theme then it will try to load from theme root/cbxwpbookmark/bookmarkicons, child theme location will get high priority. Custom bookmark icon needs to have images named bookmark_before_2x.png, bookmark_after_2x.png . If custom icon then add via the below two fields.', 'cbxwpbookmarkaddon' ),
				'type'    => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'cbxwpbookmarkaddon' ),
					'heart'   => esc_html__( 'Heart', 'cbxwpbookmarkaddon' ),
					'star'    => esc_html__( 'Star', 'cbxwpbookmarkaddon' ),
					'theme'   => esc_html__( 'From Theme', 'cbxwpbookmarkaddon' ),
					'custom'  => esc_html__( 'Custom Icon', 'cbxwpbookmarkaddon' )
				),
				'default' => 'default'
			),

			'bookmark_icon_custom_before' => array(
				'name'    => 'bookmark_icon_custom_before',
				'label'   => esc_html__( 'Custom Icon(Before Bookmark)', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Icon size 42*42 in px suits best.', 'cbxwpbookmarkaddon' ),
				'type'    => 'file',
				'default' => ''
			),
			'bookmark_icon_custom_after'  => array(
				'name'    => 'bookmark_icon_custom_after',
				'label'   => esc_html__( 'Custom Icon(After Bookmark)', 'cbxwpbookmarkaddon' ),
				'desc'    => esc_html__( 'Icon size 42*42 in px suits best.', 'cbxwpbookmarkaddon' ),
				'type'    => 'file',
				'default' => ''
			),
			/*'woo_mybookmarked_tab'         => array(
					'name'     => 'woo_mybookmarked_tab',
					'label'    => esc_html__( 'Enable WooCommerce Tab', 'cbxwpbookmarkaddon' ),
					'desc'     => esc_html__( 'Add tab to woocommerce my account sections to show user\'s bookmarked products, Woocommerce product post type need to be selected from General Settings.', 'cbxwpbookmarkaddon' ),
					'type'     => 'radio',
					'options'  => array(
						1 => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
						0  => esc_html__( 'No', 'cbxwpbookmarkaddon' )
					),
					'default'  => 1
				),*/
		);

		return $fields;
	}//end proaddon_fields

	/**
	 * Add pro css
	 */
	public function add_cbxwpbookmark_css() {
		//load extra css
		wp_register_style( 'bootstrap-grid', plugin_dir_url( __FILE__ ) . 'assets/css/bootstrap-grid/bootstrap-grid.min.css', array(), $this->version, 'all' );
		wp_register_style( 'cbxwpbookmarkaddon', plugin_dir_url( __FILE__ ) . 'assets/css/cbxwpbookmarkaddon.css', array(
			'bootstrap-grid',
			'cbxwpbookmarkpublic-css'
		), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap-grid' );
		wp_enqueue_style( 'cbxwpbookmarkaddon' );
	}//end add_cbxwpbookmark_css

	/**
	 * Add pro cjs
	 */
	public function add_cbxwpbookmark_js() {
		//load extra js
		wp_register_script( 'cbxwpbookmarkaddon', plugin_dir_url( __FILE__ ) . 'assets/js/cbxwpbookmarkaddon.js', array(
			'jquery',
			'cbxwpbookmarkpublicjs'
		), $this->version, true );
		wp_enqueue_script( 'cbxwpbookmarkaddon' );
	}//end add_cbxwpbookmark_js

	public function cbxwpbookmark_js_before_cbxwpbookmarkpublicjs() {
		wp_register_script( 'cbxwpbookmark-events-test', plugin_dir_url( __FILE__ ) . 'assets/js/cbxwpbookmark-events-test.js', array( 'cbxwpbookmark-events' ), $this->version, true );
		wp_enqueue_script( 'cbxwpbookmark-events-test' );
	}

	/**
	 * Custom css to style custom bookmark icons
	 */
	public function wp_head_custom_css() {
		$setting = $this->settings_api;

		$bookmark_icon = $setting->get_option( 'bookmark_icon', 'cbxwpbookmark_proaddon', 'default' );

		$custom_css               = '';
		$img_path_bookmark_before = '';
		$img_path_bookmark_after  = '';

		if ( $bookmark_icon != 'default' ) {
			if ( $bookmark_icon == 'theme' ) {
				$located = '';

				if ( file_exists( get_stylesheet_directory() . '/cbxwpbookmark/bookmarkicons' ) ) {
					//if in child theme
					$located = get_stylesheet_directory_uri() . '/cbxwpbookmark/bookmarkicons/';
				} elseif ( file_exists( get_template_directory() . '/cbxwpbookmark/bookmarkicons' ) ) {
					//if in theme
					$located = get_template_directory_uri() . '/cbxwpbookmark/bookmarkicons/';
				} elseif ( file_exists( ABSPATH . WPINC . '/theme-compat/cbxwpbookmark/bookmarkicons' ) ) {
					$located = includes_url() . '/theme-compat/cbxwpbookmark/bookmarkicons/';
				}

				if ( $located != '' ) {
					$img_path_bookmark_before = $located . 'bookmark_before_2x.png';
					$img_path_bookmark_after  = $located . 'bookmark_after_2x.png';

				}

			}//end if from theme
			else if ( $bookmark_icon == 'custom' ) {
				$icon_custom_before = $setting->get_option( 'bookmark_icon_custom_before', 'cbxwpbookmark_proaddon', '' );
				$icon_custom_after  = $setting->get_option( 'bookmark_icon_custom_after', 'cbxwpbookmark_proaddon', '' );

				if ( $icon_custom_before != '' ) {
					$img_path_bookmark_before = $icon_custom_before;
				}

				if ( $icon_custom_after != '' ) {
					$img_path_bookmark_after = $icon_custom_after;
				}
			} else if ( file_exists( CBXWPBOOKMARKADDON_ROOT_PATH . 'assets/img/bookmarkicons/' . $bookmark_icon . '/' ) ) {
				$img_path = CBXWPBOOKMARKADDON_ROOT_URL . 'assets/img/bookmarkicons/' . $bookmark_icon . '/';

				$img_path_bookmark_before = $img_path . 'bookmark_before_2x.png';
				$img_path_bookmark_after  = $img_path . 'bookmark_after_2x.png';
			}

		}

		if ( $img_path_bookmark_before != '' && $img_path_bookmark_after != '' ) {
			$custom_css .= '.cbxwpbkmarktrig:before {    
									background: no-repeat url(\'' . $img_path_bookmark_before . '\') 0 0;
									background-size: cover;								
								}
								
								.cbxwpbkmarktrig-marked:before {
									background: no-repeat url(\'' . $img_path_bookmark_after . '\') 0 0;   
									background-size: cover;
								}
								';
		}

		if ( $custom_css != '' ) {
			?>
            <style type="text/css" id="cbxwpbookmarkaddon-custom-css">
                <?php echo wp_strip_all_tags( $custom_css ); // Note that esc_html() cannot be used because `div &gt; span` is not interpreted properly. ?>
            </style>
			<?php
		}

		//disable buddypress fav button
		if ( function_exists( 'bp_is_active' ) ) {

			$disable_buddypress_fav = intval( $setting->get_option( 'disable_buddypress_fav', 'cbxwpbookmark_buddypress', 0 ) );

			if ( $disable_buddypress_fav ) {
				?>
                <style type="text/css" id="cbxwpbookmarkaddon-buddypress-css">
                    .bp-secondary-action.unfav, .bp-secondary-action.fav {
                        display: none !important;
                    }
                </style>
				<?php
			}
		}


	}//end wp_head_custom_css


	/**
	 * Add Tabs to Buddypress User profile
	 */
	public function add_cbxwpbookmark_buddypress_tabs() {
		global $bp;

		$setting       = $this->settings_api;
		$bookmark_mode = $setting->get_option( 'bookmark_mode', 'cbxwpbookmark_basics', 'user_cat' );
		//$show_bookmark_tab   = $setting->get_option( 'buddy_bookmark_profile_tab', 'cbxwpbookmark_proaddon', 'on' );
		$show_bookmark_tab = $setting->get_option( 'buddy_bookmark_profile_tab', 'cbxwpbookmark_buddypress', 'on' );
		//$buddy_bookmark_slug = $setting->get_option( 'buddy_bookmark_slug', 'cbxwpbookmark_proaddon', 'bookmarks' );
		$buddy_bookmark_slug = $setting->get_option( 'buddy_bookmark_slug', 'cbxwpbookmark_buddypress', 'bookmarks' );
		if ( $buddy_bookmark_slug == '' ) {
			$buddy_bookmark_slug = 'bookmarks';
		}


		$current_profile_id = intval( bp_displayed_user_id() );
		$logged_user_id     = intval( get_current_user_id() );

		//$title = esc_html__( 'My Bookmarks', 'cbxwpbookmarkaddon' );
		if ( is_user_logged_in() && $logged_user_id == $current_profile_id ) {
			$title = esc_html__( 'My Bookmarks', 'cbxwpbookmarkaddon' );
		} else {
			$title = sprintf( esc_html__( '%s\'s Bookmarks', 'cbxwpbookmarkaddon' ), bp_core_get_user_displayname( $current_profile_id ) );
		}

		if ( $show_bookmark_tab == 'on' ) {
			//parent left tab or main tab
			bp_core_new_nav_item(
				array(
					//'name'                => esc_html__( 'Bookmarks', 'cbxwpbookmarkaddon' ),
					'name'                => $title,
					'slug'                => $buddy_bookmark_slug,
					'parent_url'          => $bp->displayed_user->domain,
					'parent_slug'         => $bp->profile->slug,
					'screen_function'     => array( $this, 'cbxwpbookmark_buddypress_screen' ),
					'position'            => 200,
					'default_subnav_slug' => $buddy_bookmark_slug
				)
			);

			if ( $bookmark_mode == 'user_cat' ) {
				//submenu for buddypress bookmark for category
				bp_core_new_subnav_item(
					array(
						'name'            => esc_html__( 'Manage Bookmark Category', 'cbxwpbookmarkaddon' ),
						'slug'            => 'category',
						'parent_url'      => trailingslashit( bp_displayed_user_domain() . $buddy_bookmark_slug ),
						'parent_slug'     => $buddy_bookmark_slug,
						'screen_function' => array( $this, 'cbxwpbookmark_category_buddypress_screen' ),
						'position'        => 150,
						'user_has_access' => bp_is_my_profile()
					)
				);
			}
		}

		$display_bookmarked_activity = intval( $setting->get_option( 'display_bookmarked_activity', 'cbxwpbookmark_buddypress', 1 ) );

		if ( bp_is_active( 'activity' ) && $display_bookmarked_activity ) {
			//trying custom bookmarked stream
			// Determine user to use.
			if ( bp_displayed_user_domain() ) {
				$user_domain = bp_displayed_user_domain();
			} elseif ( bp_loggedin_user_domain() ) {
				$user_domain = bp_loggedin_user_domain();
			} else {
				return;
			}


			$slug          = bp_get_activity_slug();
			$activity_link = trailingslashit( $user_domain . $slug );

			bp_core_new_subnav_item(
				array(
					'name'            => _x( 'Bookmarked Activities', 'Profile activity screen sub nav', 'cbxwpbookmarkaddon' ),
					'slug'            => 'bookmarkedactivity',
					'parent_url'      => $activity_link,
					'parent_slug'     => $slug,
					'screen_function' => array( $this, 'bp_activity_screen_bookmarked' ),
					'item_css_id'     => 'activity-bookmarked'
				)
			);
		}

	}//end add_cbxwpbookmark_buddypress_tabs


	public function bp_before_member_body() {
		/*if(bp_is_user_activity()){
			    bp_get_template_part( 'members/single/activity' );
		    }*/
	}


	/**
	 * Add Buddypress bookmark screen function
	 */
	public function cbxwpbookmark_buddypress_screen() {
		add_action( 'bp_template_title', array( $this, 'cbxwpbookmark_buddypress_screen_title' ) );
		add_action( 'bp_template_content', array( $this, 'cbxwpbookmark_buddypress_screen_content' ) );

		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}//end cbxwpbookmark_buddypress_screen

	/**
	 * Display title for my bookmarks page
	 */
	public function cbxwpbookmark_buddypress_screen_title() {
		$current_profile_id = intval( bp_displayed_user_id() );
		$logged_user_id     = intval( get_current_user_id() );

		$title = '';
		if ( is_user_logged_in() && $logged_user_id == $current_profile_id ) {
			$title = esc_html__( 'My Bookmarks', 'cbxwpbookmarkaddon' );
		} else {
			$title = sprintf( esc_html__( '%s\'s Bookmarks', 'cbxwpbookmarkaddon' ), bp_core_get_user_displayname( $current_profile_id ) );
		}

		echo esc_html( $title );
	}//end cbxwpbookmark_buddypress_screen_title

	/**
	 * Display contents for my bookmarks page
	 */
	function cbxwpbookmark_buddypress_screen_content() {

		$setting       = $this->settings_api;
		$bookmark_mode = $setting->get_option( 'bookmark_mode', 'cbxwpbookmark_basics', 'user_cat' );
		//$buddy_bookmark_slug = $setting->get_option( 'buddy_bookmark_slug', 'cbxwpbookmark_proaddon', 'bookmarks' );
		$buddy_bookmark_slug = $setting->get_option( 'buddy_bookmark_slug', 'cbxwpbookmark_buddypress', 'bookmarks' );
		if ( $buddy_bookmark_slug == '' ) {
			$buddy_bookmark_slug = 'bookmarks';
		}

		echo '<div class="cbxwpbookmark_buddypress_wrapper">';


		$current_profile_id = intval( bp_displayed_user_id() );
		$logged_user_id     = intval( get_current_user_id() );

		$allow_delete = 0; //we will allow to delete only for the owner of the bookmark
		if ( is_user_logged_in() && $logged_user_id == $current_profile_id ) {
			$allow_delete = 1;
		}

		$base_url = trailingslashit( bp_displayed_user_domain() . $buddy_bookmark_slug );

		$current_profile_id = intval( bp_displayed_user_id() );
		$logged_user_id     = intval( get_current_user_id() );



		$cat_widget_title = esc_html__( 'Bookmark Categories', 'cbxwpbookmarkaddon' );

		/*if ( is_user_logged_in() && $logged_user_id == $current_profile_id ) {
				$cat_widget_title = esc_html__( 'My Bookmark Categories', 'cbxwpbookmark' );
			} else {
				$cat_widget_title = sprintf( esc_html__( '%s\'s Bookmark Categories', 'cbxwpbookmarkaddon' ), bp_core_get_user_displayname( $current_profile_id ) );
			}*/

		if ( $bookmark_mode != 'no_cat' ) {
			echo do_shortcode( '[cbxwpbookmark-mycat title="' . $cat_widget_title . '" display="1" userid="' . $current_profile_id . '" allowedit="1"  base_url="' . $base_url . '"]' );
		}

		echo do_shortcode( '[cbxwpbookmarkgrid userid="' . $current_profile_id . '" allowdelete="' . $allow_delete . '"]' );
		echo '</div>';
	}//end cbxwpbookmark_buddypress_screen_content

	/**
	 * Load the 'bookmarked' activity page.
	 *
	 * @since 1.2.0
	 */
	public function bp_activity_screen_bookmarked() {
		bp_update_is_item_admin( bp_current_user_can( 'bp_moderate' ), 'activity' );

		/**
		 * Fires right before the loading of the "Favorites" screen template file.
		 *
		 * @since 1.2.0
		 */
		//do_action( 'bp_activity_screen_bookmarked' );

		//add_action( 'bp_template_title', array( $this, 'cbxwpbookmark_buddypress_screen_title_fav' ) );
		//add_action( 'bp_template_content', array( $this, 'cbxwpbookmark_buddypress_screen_content_fav' ) );

		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	/**
	 * Display title for my bookmarks page
	 */
	public function cbxwpbookmark_buddypress_screen_title_fav() {
		$current_profile_id = intval( bp_displayed_user_id() );
		$logged_user_id     = intval( get_current_user_id() );

		//$title = '';
		if ( is_user_logged_in() && $logged_user_id == $current_profile_id ) {
			$title = esc_html__( 'My Favorite Activities', 'cbxwpbookmarkaddon' );
		} else {
			$title = sprintf( esc_html__( '%s\'s Favorite Activities', 'cbxwpbookmarkaddon' ), bp_core_get_user_displayname( $current_profile_id ) );
		}

		echo esc_html( $title );
	}//end cbxwpbookmark_buddypress_screen_title_fav

	/**
	 * Display contents for my bookmarks page
	 */
	function cbxwpbookmark_buddypress_screen_content_fav() {
		//echo 'miao here';

	}//end cbxwpbookmark_buddypress_screen_content_fav

	/**
	 * Set up activity arguments for use with the 'bookmarkedactivity' scope.
	 *
	 * @param array $retval Empty array by default.
	 * @param array $filter Current activity arguments.
	 *
	 * @return array $retval
	 * @since 2.2.0
	 *
	 */
	public function bp_activity_filter_bookmarkedactivity_scope( $retval = array(), $filter = array() ) {

		// Determine the user_id.
		if ( ! empty( $filter['user_id'] ) ) {
			$user_id = $filter['user_id'];
		} else {
			$user_id = bp_displayed_user_id()
				? bp_displayed_user_id()
				: bp_loggedin_user_id();
		}

		// Determine the favorites.
		//$favs = bp_activity_get_user_favorites( $user_id );
		$favs = CBXWPBookmarkproHelper::get_buddypress_activity_by_user( $user_id );

		if ( empty( $favs ) ) {
			$favs = array( 0 );
		}

		// Should we show all items regardless of sitewide visibility?
		$show_hidden = array();
		if ( ! empty( $user_id ) && ( $user_id !== bp_loggedin_user_id() ) ) {
			$show_hidden = array(
				'column' => 'hide_sitewide',
				'value'  => 0
			);
		}

		$retval = array(
			'relation' => 'AND',
			array(
				'column'  => 'id',
				'compare' => 'IN',
				'value'   => (array) $favs
			),
			$show_hidden,

			// Overrides.
			'override' => array(
				'display_comments' => true,
				'filter'           => array( 'user_id' => 0 ),
				'show_hidden'      => true
			),
		);


		return $retval;
	}//end bp_activity_filter_bookmarkedactivity_scope

	/**
	 * Remove fav tab from activity sub nav
	 */
	public function bp_remove_sub_tabs() {
		if ( ! bp_is_user() ) {
			return;
		}

		$setting                = $this->settings_api;
		$disable_buddypress_fav = intval( $setting->get_option( 'disable_buddypress_fav', 'cbxwpbookmark_buddypress', 0 ) );

		if ( $disable_buddypress_fav ) {
			bp_core_remove_subnav_item( 'activity', 'favorites' );
		}

	}//end bp_remove_sub_tabs

	/**
	 * Disable fav tab from global activity nav
	 *
	 * @param $retval
	 * @param $user_id
	 *
	 * @return int|mixed
	 */
	public function bp_get_total_favorite_count_for_user( $retval, $user_id ) {
		$setting                = $this->settings_api;
		$disable_buddypress_fav = intval( $setting->get_option( 'disable_buddypress_fav', 'cbxwpbookmark_buddypress', 0 ) );

		if ( $disable_buddypress_fav ) {
			return 0;
		}

		return $retval;
	}//end bp_get_total_favorite_count_for_user


	public function cbxwpbookmark_category_buddypress_screen() {
		add_action( 'bp_template_content', array( $this, 'cbxwpbookmark_buddypress_category_screen_content' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}//end cbxwpbookmark_category_buddypress_screen


	/**
	 * Display categories for only the logged in users
	 */
	public function cbxwpbookmark_buddypress_category_screen_content() {
		//$current_profile_id = intval( bp_displayed_user_id() );
		//$logged_user_id     = intval( get_current_user_id() );

		//$userid = ($current_profile_id != $logged_user_id)? $current_profile_id : $logged_user_id;

		$base_url = trailingslashit( bp_displayed_user_domain() . 'bookmarks' );

		echo '<div class="cbxwpbookmark_buddypress_category_wrapper">';
		//echo do_shortcode( '[cbxwpbookmark-mycat allowedit="1" userid="'.$userid.'"]' );
		echo do_shortcode( '[cbxwpbookmark-mycat privacy="2" allowedit="1" base_url="' . $base_url . '"]' );
		echo '</div>';
	}//end cbxwpbookmark_buddypress_category_screen_content

	/**
	 * Registers all widgets of plugins
	 */
	public function init_pro_widgets() {
		//bookmark grid widget
		if ( ! class_exists( 'CBXWPBookmarkgrid_Widget' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'widgets/classic_widgets/cbxwpbookmarkgrid-widget/cbxwpbookmarkgrid-widget.php';
		}

		register_widget( 'CBXWPBookmarkgrid_Widget' );

		//most bookmark grid widget
		if ( ! class_exists( 'CBXWPBookmarkedMostGrid_Widget' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'widgets/classic_widgets/cbxwpbookmarkmostgrid-widget/cbxwpbookmarkmostgrid-widget.php';
		}

		register_widget( 'CBXWPBookmarkedMostGrid_Widget' );


		//check if woocommerce active and installed before register widget
		if ( class_exists( 'Woocommerce' ) ) {
			if ( ! class_exists( 'WPBM_Products' ) ) {
				require_once plugin_dir_path( __FILE__ ) . 'widgets/classic_widgets/wpbmproducts-widget/class-wpbm-wooproducts.php';
			}
			register_widget( 'WPBM_Products' );
		}


		//check if easy digital download installed and active before register
		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			if ( ! class_exists( 'WPBM_Downloads' ) ) {
				require_once plugin_dir_path( __FILE__ ) . 'widgets/classic_widgets/wpbmdownloads-widget/class-wpbm-edddownloads.php';
			}

			register_widget( 'WPBM_Downloads' );
		}
	}//end init_pro_widgets


	/**
	 * Plugin activation check
	 */
	public static function activation() {
		//need to check if any specific plugin is activate to make the plugin compatible for it.
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if ( in_array( 'cbxwpbookmark/cbxwpbookmark.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || defined( 'CBXWPBOOKMARK_PLUGIN_NAME' ) ) {
			//
		} else {

			// Deactivate the plugin
			deactivate_plugins( __FILE__ );

			// Throw an error in the wordpress admin console
			$error_message = __( 'This plugin requires <a target="_blank" href="http://wordpress.org/extend/plugins/cbxwpbookmark/">CBX Bookmark & Favorite</a>  to be installed and active to function.', 'cbxwpbookmarkaddon' );
			die( $error_message );
		}
	}//end activation

	/**
	 * Add custom
	 *
	 * @param $args
	 *
	 * @return array
	 */
	public function cbxwpbookmarkaddon_post_types( $args ) {
		$custom_args = array(
			'custom' => array(
				'options' => array(
					'public'   => true,
					'_builtin' => false,
				),
				'label'   => esc_html__( 'Custom post types', 'cbxwpbookmarkaddon' ),
			)
		);

		$args = array_merge( $args, $custom_args );

		return $args;
	}//end cbxwpbookmarkaddon_post_types

	/**
	 * My Bookmark post grid(deprecated)
	 *
	 * @param $attr
	 *
	 * @return false|string
	 */
	public function cbxbookmarkmypost_grid( $attr ) {
		$this->cbxbookmark_postgrid( $attr );
	}

	/**
	 * My Bookmark post grid
	 *
	 * @param $attr
	 *
	 * @return false|string
	 */
	public function cbxbookmark_postgrid( $attr ) {
		global $wpdb;

		$cbxwpbookmrak_table         = $wpdb->prefix . 'cbxwpbookmark';
		$cbxwpbookmak_category_table = $wpdb->prefix . 'cbxwpbookmarkcat';


		$settings_api  = $this->settings_api;
		$bookmark_mode = $settings_api->get_option( 'bookmark_mode', 'cbxwpbookmark_basics', 'user_cat' );

		$object_types = CBXWPBookmarkHelper::object_types( true ); //get plain post type as array

		$current_user_id = get_current_user_id();

		$attr = shortcode_atts(
			array(
				'title'          => esc_html__( 'All Bookmarks', 'cbxwpbookmarkaddon' ),
				'order'          => 'DESC',
				'orderby'        => 'id',//id, object_id, object_type, title , if you use title it will be resource intensive
				'limit'          => 6,
				'type'           => '',//post type, multiple post type in comma
				'loadmore'       => 1, //this is shortcode only params
				'catid'          => '',//category id
				'cattitle'       => 1, //show category title,
				'catcount'       => 1, //show item count per category
				'show_thumb'     => 1, //show thumbnail
				'userid'         => $current_user_id,
				'allowdelete'    => 0,
				'allowdeleteall' => 0,
				'offset'         => 0,
			), $attr, 'cbxwpbookmarkgrid'
		);

		$attr['title'] = $title = sanitize_text_field( $attr['title'] );

		//if the url has cat id (cbxbmcatid get param) thenm use it or try it from shortcode
		$attr['catid'] = ( isset( $_GET['cbxbmcatid'] ) && $_GET['cbxbmcatid'] != null ) ? sanitize_text_field( $_GET['cbxbmcatid'] ) : $attr['catid'];
		if ( $attr['catid'] == 0 ) {
			$attr['catid'] = '';
		}//compatibility with previous shortcode default values
		$attr['catid'] = array_filter( explode( ',', $attr['catid'] ) );


		$userid_temp = $attr['userid'];

		//let's find out if the userid is email or username
		if ( is_email( $userid_temp ) ) {
			//possible email
			$user_temp = get_user_by( 'email', $userid_temp );

			if ( $user_temp !== false ) {
				$userid_temp = absint( $user_temp->ID );

				if ( $userid_temp > 0 ) {
					$attr['userid'] = $userid_temp;
				}
			} else {
				//email but user not found so reset it to guest
				$attr['userid'] = 0;
			}

		} else if ( ! is_numeric( $userid_temp ) ) {
			if ( ( $user_temp = get_user_by( 'login', $userid_temp ) ) !== false ) {
				//user_login
				$userid_temp = absint( $user_temp->ID );
				if ( $userid_temp > 0 ) {
					$attr['userid'] = absint( $userid_temp );
				}
			} else if ( ( $user_temp = get_user_by( 'slug', $userid_temp ) ) !== false ) {
				//user_login
				$userid_temp = absint( $user_temp->ID );
				if ( $userid_temp > 0 ) {
					$attr['userid'] = absint( $userid_temp );
				}
			} else {
				$attr['userid'] = 0;
			}
		}


		//get userid from url linked from other page
		//if ( isset( $_GET['userid'] ) && absint( $_GET['userid'] ) > 0 ) {

		if ( isset( $_GET['userid'] ) ) {
			$userid_temp = $_GET['userid'];

			if ( is_numeric( $userid_temp ) ) {
				//if user id is used
				$attr['userid'] = absint( $userid_temp );
			} else if ( ( $user_temp = get_user_by( 'login', $userid_temp ) ) !== false ) {
				//user_login
				$userid_temp = absint( $user_temp->ID );
				if ( $userid_temp > 0 ) {
					$attr['userid'] = absint( $userid_temp );
				}
			} else if ( ( $user_temp = get_user_by( 'slug', $userid_temp ) ) !== false ) {
				//user_login
				$userid_temp = absint( $user_temp->ID );
				if ( $userid_temp > 0 ) {
					$attr['userid'] = absint( $userid_temp );
				}
			} else {
				$attr['userid'] = 0;
			}


		}

		$attr['userid'] = absint( $attr['userid'] );


		//determine if we allow user to delete
		$allow_delete_all_html  = '';
		$attr['allowdeleteall'] = $allow_delete_all = absint( $attr['allowdeleteall'] );
		if ( $allow_delete_all && is_user_logged_in() && $attr['userid'] == $current_user_id ) {
			$allow_delete_all      = 1;
			$allow_delete_all_html = '<a data-busy="0" class="cbxwpbookmark_deleteall" href="#" class="">' . esc_html__( 'Delete All', 'cbxwpbookmark' ) . '</a>';
		}

		$attr['type'] = array_filter( explode( ',', $attr['type'] ) );

		extract( $attr );

		$show_loadmore_html = '';


		$privacy = 2; //all
		if ( $userid == 0 || ( $userid != get_current_user_id() ) ) {
			$privacy     = 1;
			$allowdelete = 0;
		};


		$cat_sql              = '';
		$total_sql            = '';
		$category_privacy_sql = '';
		$type_sql             = '';

		//if ( $catid != 0 && $bookmark_mode != 'no_cat' ) {
		if ( is_array( $catid ) && sizeof( $catid ) > 0 && ( $bookmark_mode != 'no_cat' ) ) {
			$cats_ids_str = implode( ', ', $catid );
			$cat_sql      .= " AND cat_id IN ($cats_ids_str) ";
		}

		//get cats
		if ( $bookmark_mode == 'user_cat' ) {
			//same user seeing
			if ( $privacy != 2 ) {
				$cats = $wpdb->get_results( $wpdb->prepare( "SELECT *  FROM  $cbxwpbookmak_category_table WHERE privacy = %d", intval( $privacy ) ), ARRAY_A );

			} else {
				$cats = $wpdb->get_results( "SELECT *  FROM  $cbxwpbookmak_category_table WHERE 1", ARRAY_A );
			}


			$cats_ids     = array();
			$cats_ids_str = '';
			if ( is_array( $cats ) && sizeof( $cats ) > 0 ) {
				foreach ( $cats as $cat ) {
					$cats_ids[] = intval( $cat['id'] );
				}
				$cats_ids_str .= implode( ', ', $cats_ids );

				$category_privacy_sql .= " AND cat_id IN ($cats_ids_str) ";
			}
		}//end user_cat mode

		/*if($orderby == 'title'){
                $orderby = 'id'; //for count calculation order by anything will give same output
            }*/

		if ( sizeof( $type ) == 0 ) {
			$param = array( $userid );
			//$total_sql .= "SELECT COUNT(*) FROM (select count(*) as totalobject FROM $cbxwpbookmrak_table  WHERE user_id = %d $cat_sql $category_privacy_sql group by object_id  ORDER BY $orderby $order) AS TotalData";
			$total_sql .= "SELECT COUNT(*) FROM (select count(*) as totalobject FROM $cbxwpbookmrak_table  WHERE user_id = %d $cat_sql $category_privacy_sql group by object_id) AS TotalData";
		} else {


			$type_sql .= " AND object_type IN ('" . implode( "','", $type ) . "') ";

			//$param     = array( $userid, $type );
			$param = array( $userid );
			//$total_sql .= "SELECT COUNT(*) FROM (select count(*) as totalobject FROM $cbxwpbookmrak_table  WHERE user_id = %d $type_sql $cat_sql  $category_privacy_sql group by object_id   ORDER BY $orderby $order) AS TotalData";
			$total_sql .= "SELECT COUNT(*) FROM (select count(*) as totalobject FROM $cbxwpbookmrak_table  WHERE user_id = %d $type_sql $cat_sql  $category_privacy_sql group by object_id) AS TotalData";
		}

		$total_count = intval( $wpdb->get_var( $wpdb->prepare( $total_sql, $param ) ) );


		$total_page = ( $total_count > 0 ) ? ceil( $total_count / $limit ) : 0;


		if ( intval( $cattitle ) && $bookmark_mode != 'no_cat' ) {
			if ( sizeof( $catid ) == 0 ) {

			} else {
				if ( sizeof( $catid ) == 1 ) {
					$cat_info      = CBXWPBookmarkHelper::getBookmarkCategoryById( reset( $catid ) );
					$catcount_html = '';
					if ( $catcount ) {
						$cat_bookmark_count = CBXWPBookmarkHelper::getTotalBookmarkByCategory( reset( $catid ) );
						$catcount_html      = '<i>(' . number_format_i18n( $cat_bookmark_count ) . ')</i>';
					}

					if ( is_array( $cat_info ) && sizeof( $cat_info ) > 0 ) {
						$title = $cat_info['cat_name'] . $catcount_html;
					}
				}

			}
		}


		if ( $attr['loadmore'] == 1 && $total_page > 1 ) {
			$ajax_icon = CBXWPBOOKMARK_ROOT_URL . 'assets/img/busy.gif';

			$offset             += $limit;
			$loadmore_busy_icon = '<span data-busy="0" class="cbxwpbm_ajax_icon">' . esc_html__( 'Loading ...', 'cbxwpbookmarkaddon' ) . '<img src = "' . $ajax_icon . '"/></span>';

			$show_loadmore_html = '<p class="cbxbookmark-more-wrap"><a href="#" class="cbxbookmark-more" data-cattitle="' . $cattitle . '" data-order="' . $order . '" data-orderby="' . $orderby . '" data-show_thumb="' . intval( $show_thumb ) . '" data-userid="' . $userid . '" data-limit="' . $limit . '" data-offset="' . $offset . '" data-catid="' . implode( ',', $catid ) . '" data-type="' . implode( ',', $type ) . '" data-totalpage="' . $total_page . '" data-currpage="1" data-allowdelete="' . intval( $allowdelete ) . '">' . esc_html__( 'Load More', 'cbxwpbookmarkaddon' ) . '</a>' . $loadmore_busy_icon . '</p>';
		}


		ob_start();


		echo '<div class="cbxbookmark_cards_wrapper_postgrid-wrap">';
		if ( $title != '' ) {
			echo '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-postgrid">' . $title . $allow_delete_all_html . '</h3>';
		} else {
			echo '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-postgrid">' . $allow_delete_all_html . '</h3>';
		}

		echo '<div class="bootstrap-wrapper cbxbookmark_cards_wrapper cbxbookmark_cards_wrapper_postgrid ">';
		echo '<div class="cbxbookmark_card_wrap row">';
		echo cbxbookmark_postgrid_html( $attr );
		echo '</div>'; //end cbxbookmark_card_wrap
		echo $show_loadmore_html;
		echo '<div class="cbxbookmark_card_clear"></div>';
		echo '</div>';
		echo '</div>';

		$output = ob_get_clean();

		return $output;
	}//end cbxbookmark_postgrid

	/**
	 * Most bookmarked products(woocommerce) shortcode
	 *
	 * @param $attr
	 *
	 * @return string
	 */
	public function cbxbookmark_mostproducts( $attr ) {
		if ( ! class_exists( 'Woocommerce' ) ) {
			return '';
		}
		// normalize attribute keys, lowercase
		$attr = array_change_key_case( (array) $attr, CASE_LOWER );

		$attr = shortcode_atts(
			array(
				'title'        => esc_html__( 'Most Bookmarked Products', 'cbxwpbookmarkaddon' ),
				//if empty title will not be shown
				'order'        => 'DESC',
				'orderby'      => 'object_count', //id, object_id, object_type, object_count, title
				'limit'        => 10,
				'daytime'      => 0,// 0 means all time,  any numeric values as days
				'show_count'   => 1,
				'show_thumb'   => 1,
				'show_price'   => 1,
				'show_addcart' => 1
			), $attr, 'cbxwpbookmark-mostproducts' );

		wp_enqueue_style( 'cbxwpbookmarkpublic-css' );

		$output = '';
		$output .= '<div class="cbxwpbookmark-mostlist-wrap cbxwpbookmark-mostlist-wrap-products">';
		if ( $attr['title'] != '' ) {
			$output        .= '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-most cbxwpbookmark-title-most-products">' . $attr['title'] . '</h3>';
			$attr['title'] = '';
		}
		$output .= cbxwpbookmarkpro_get_template_html( 'widgets/wpbmproducts-widget.php', array(
			'instance' => $attr,
			'ref'      => $this
		) );
		$output .= '</div>';

		return $output;


	}//end cbxbookmark_mostproducts

	/**
	 * Most bookmarked downloads(easy digital downloads) shortcode
	 *
	 * @param $attr
	 *
	 * @return string
	 */
	public function cbxbookmark_mostdownlaods( $attr ) {
		if ( ! class_exists( 'Easy_Digital_Downloads' ) ) {
			return '';
		}
		// normalize attribute keys, lowercase
		$attr = array_change_key_case( (array) $attr, CASE_LOWER );

		$attr = shortcode_atts(
			array(
				'title'        => esc_html__( 'Most Bookmarked Downloads', 'cbxwpbookmarkaddon' ),
				//if empty title will not be shown
				'order'        => 'DESC',
				'orderby'      => 'object_count',
				//id, object_id, object_type, object_count
				'limit'        => 10,
				'daytime'      => 0,
				// 0 means all time,  any numeric values as days
				'show_count'   => 1,
				'show_thumb'   => 1,
				'show_price'   => 1,
				'show_addcart' => 1
			), $attr, 'cbxwpbookmark-mostdownloads' );

		wp_enqueue_style( 'cbxwpbookmarkpublic-css' );

		$output = '<div class="cbxwpbookmark-mostlist-wrap cbxwpbookmark-mostlist-wrap-downloads">';

		if ( $attr['title'] != '' ) {
			$output        .= '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-most cbxwpbookmark-title-most-downloads ">' . $attr['title'] . '</h3>';
			$attr['title'] = '';
		}

		$output .= cbxwpbookmarkpro_get_template_html( 'widgets/wpbmdownloads-widget.php', array(
			'instance' => $attr,
			'ref'      => $this
		) );
		$output .= '</div>';

		return $output;

	}//end cbxbookmark_mostdownlaods

	/**
	 * Most bookmarked post grid shortcode
	 *
	 * @param $attr
	 *
	 * @return string
	 */
	public function cbxbookmark_mostgrid( $attr ) {
		global $wpdb;

		$cbxwpbookmrak_table = $wpdb->prefix . 'cbxwpbookmark';

		//$settings_api  = $this->settings_api;

		// normalize attribute keys, lowercase
		$attr = array_change_key_case( (array) $attr, CASE_LOWER );

		$attr = shortcode_atts(
			array(
				'title'      => esc_html__( 'Most Bookmarked Posts', 'cbxwpbookmarkaddon' ),//if empty title will not be shown
				'order'      => 'DESC',
				'orderby'    => 'object_count',//id, object_id, object_type, object_count, title
				'limit'      => 10,
				'type'       => '',    //db col name object_type,  post types eg, post, page, any custom post type, for multiple comma separated
				'daytime'    => 0,     // 0 means all time,  any numeric values as days
				'show_count' => 1,
				'show_thumb' => 1,
				'offset'     => 0,
				'load_more'  => 0,
			), $attr, 'cbxwpbookmark-mostgrid' );


		$attr['type'] = array_filter( explode( ',', wp_unslash($attr['type']) ) );

		extract( $attr );


		$where_sql = $sql = $type_sql = '';
		$daytime   = (int) $daytime;

		$datetime_sql = "";
		if ( $daytime != '0' || ! empty( $daytime ) ) {
			$time         = date( 'Y-m-d H:i:s', strtotime( '-' . $daytime . ' day' ) );
			$datetime_sql .= " created_date > '$time' ";

			$where_sql .= ( ( $where_sql != '' ) ? ' AND ' : '' ) . $datetime_sql;
		}

		if ( sizeof( $type ) > 0 ) {
			$type_sql  .= " object_type IN ('" . implode( "','", $type ) . "') ";
			$where_sql .= ( ( $where_sql != '' ) ? ' AND ' : '' ) . $type_sql;
		}

		if ( $where_sql == '' ) {
			$where_sql = '1';
		}

		if ( $orderby == 'object_count' ) {
			//$sql .= "SELECT COUNT(*) FROM (select count(*) as totalobject FROM $cbxwpbookmrak_table  WHERE $where_sql group by object_id   ORDER BY totalobject $order) AS TotalData";
			$sql .= "SELECT COUNT(*) FROM (select count(*) as totalobject FROM $cbxwpbookmrak_table  WHERE $where_sql group by object_id) AS TotalData";
		} else {

			//$sql .= "SELECT COUNT(*) FROM (select count(*) as totalobject FROM $cbxwpbookmrak_table  WHERE $where_sql group by object_id   ORDER BY $orderby $order) AS TotalData";
			$sql .= "SELECT COUNT(*) FROM (select count(*) as totalobject FROM $cbxwpbookmrak_table  WHERE $where_sql group by object_id) AS TotalData";
		}

		$total_count = intval( $wpdb->get_var( $sql ) );


		$total_page = ( $total_count > 0 ) ? ceil( $total_count / $limit ) : 0;

		$show_loadmore_html = '';
		if ( $load_more == 1 && $total_page > 1 ) {
			$ajax_icon = CBXWPBOOKMARK_ROOT_URL . 'assets/img/busy.gif';

			$offset             += $limit;
			$loadmore_busy_icon = '<span data-busy="0" class="cbxwpbm_ajax_icon">' . esc_html__( 'Loading ...', 'cbxwpbookmarkaddon' ) . '<img src = "' . $ajax_icon . '"/></span>';

			$show_loadmore_html .= '<p class="cbxbookmark-more-wrap"><a href="#" class="cbxbookmark-more" data-order="' . $order . '" data-orderby="' . $orderby . '" data-show_thumb="' . intval( $show_thumb ) . '"  data-limit="' . $limit . '" data-offset="' . $offset . '"  data-type="' . implode( ',', $type ) . '" data-totalpage="' . $total_page . '" data-currpage="1">' . esc_html__( 'Load More', 'cbxwpbookmarkaddon' ) . '</a>' . $loadmore_busy_icon . '</p>';
		}

		ob_start();

		echo '<div class="cbxbookmark_cards_wrapper_mostgrid-wrap ">';
		if ( $title != '' ) {
			echo '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-mostgrid">' . $title . '</h3>';
		}
		echo '<div class="bootstrap-wrapper cbxbookmark_cards_wrapper cbxbookmark_cards_wrapper_mostgrid ">';
		echo '<div class="cbxbookmark_card_wrap row">';
		echo cbxbookmark_mostgrid_html( $attr );
		echo '</div>'; //end cbxbookmark_card_wrap
		echo $show_loadmore_html;
		echo '<div class="cbxbookmark_card_clear"></div>';
		echo '</div>';
		echo '</div>';

		$output = ob_get_clean();

		return $output;
	}//end cbxbookmark_mostgrid


	/**
	 * Bookmarkgrid Load more ajax hook
	 */
	public function bookmark_postgrid_loadmore() {
		//security check
		check_ajax_referer( 'cbxbookmarknonce', 'security' );

		$instance = array();
		$message  = array();

		if ( isset( $_POST['limit'] ) && $_POST['limit'] != null ) {
			$instance['limit'] = intval( $_POST['limit'] );
		}

		if ( isset( $_POST['offset'] ) && $_POST['offset'] != null ) {
			$instance['offset'] = intval( $_POST['offset'] );
		}

		/*if ( isset( $_POST['catid'] ) && $_POST['catid'] != 0 ) {
				$instance['catid'] = intval( $_POST['catid'] );
			}*/

		if ( isset( $_POST['catid'] ) ) {
			$catid             = sanitize_text_field( $_POST['catid'] );
			$instance['catid'] = array_filter( explode( ',', $catid ) );
		}

		if ( isset( $_POST['type'] ) ) {
			$type             = sanitize_text_field( $_POST['type'] );
			$instance['type'] = array_filter( explode( ',', $type ) );
		}

		if ( isset( $_POST['userid'] ) && $_POST['userid'] != 0 ) {
			$instance['userid'] = intval( $_POST['userid'] );
		}

		if ( isset( $_POST['order'] ) && $_POST['order'] != null ) {
			$instance['order'] = esc_attr( $_POST['order'] );
		}

		if ( isset( $_POST['orderby'] ) && $_POST['orderby'] != null ) {
			$instance['orderby'] = esc_attr( $_POST['orderby'] );
		}

		$instance['allowdelete'] = intval( $_POST['allowdelete'] );
		$instance['show_thumb']  = intval( $_POST['show_thumb'] ); //arr

		if ( function_exists( 'cbxbookmark_postgrid_html' ) && cbxbookmark_postgrid_html( $instance, false ) ) {
			$message['code'] = 1;
			$message['data'] = cbxbookmark_postgrid_html( $instance, false );

		} else {
			$message['code'] = 0;
		}

		echo json_encode( $message );
		wp_die();
	}//end bookmark_postgrid_loadmore

	/**
	 * Bookmarkgrid Load more ajax hook
	 */
	public function bookmark_mostgrid_loadmore() {
		//security check
		check_ajax_referer( 'cbxbookmarknonce', 'security' );

		$instance = array();
		$message  = array();

		if ( isset( $_POST['limit'] ) && $_POST['limit'] != null ) {
			$instance['limit'] = intval( $_POST['limit'] );
		}

		if ( isset( $_POST['offset'] ) && $_POST['offset'] != null ) {
			$instance['offset'] = intval( $_POST['offset'] );
		}

		if ( isset( $_POST['type'] ) ) {
			$type             = sanitize_text_field( $_POST['type'] );
			$instance['type'] = array_filter( explode( ',', $type ) );
		}


		if ( isset( $_POST['order'] ) && $_POST['order'] != null ) {
			$instance['order'] = esc_attr( $_POST['order'] );
		}

		if ( isset( $_POST['orderby'] ) && $_POST['orderby'] != null ) {
			$instance['orderby'] = esc_attr( $_POST['orderby'] );
		}

		$instance['show_thumb'] = intval( $_POST['show_thumb'] ); //arr

		if ( function_exists( 'cbxbookmark_mostgrid_html' ) && cbxbookmark_mostgrid_html( $instance, false ) ) {
			$message['code'] = 1;
			$message['data'] = cbxbookmark_mostgrid_html( $instance, false );

		} else {
			$message['code'] = 0;
		}

		echo json_encode( $message );
		wp_die();
	}//end bookmark_mostgrid_loadmore

	/**
	 * Admin setting link
	 *
	 * @param $links
	 *
	 * @return mixed
	 * return rating setting link in backed dashboard
	 */
	public function admin_settings_link( $links ) {
		$settings_link = '<a target="_blank" style="color:#005ae0 !important; font-weight: bold;" href="' . admin_url( 'admin.php?page=cbxwpbookmark_settings#cbxwpbookmark_proaddon' ) . '" title="' . esc_attr( 'Settings', 'cbxwpbookmarkaddon' ) . '">' . esc_html__( 'Settings', 'cbxwpbookmarkaddon' ) . '</a>';


		array_unshift( $links, $settings_link );

		return $links;

	}//end admin_settings_link

	/**
	 * Filters the array of row meta for each/specific plugin in the Plugins list table.
	 * Appends additional links below each/specific plugin on the plugins page.
	 *
	 * @access  public
	 *
	 * @param array $links_array An array of the plugin's metadata
	 * @param string $plugin_file_name Path to the plugin file
	 * @param array $plugin_data An array of plugin data
	 * @param string $status Status of the plugin
	 *
	 * @return  array       $links_array
	 */
	public function plugin_row_meta( $links_array, $plugin_file_name, $plugin_data, $status ) {
		if ( strpos( $plugin_file_name, CBXWPBOOKMARKADDON_BASE_NAME ) !== false ) {
			/*if ( ! function_exists( 'is_plugin_active' ) ) {
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}*/

			$links_array[] = '<a target="_blank" style="color:#005ae0 !important; font-weight: bold;" href="https://codeboxr.com/product/cbx-wordpress-bookmark/" aria-label="' . esc_attr__( 'Learn More', 'cbxwpbookmarkaddon' ) . '">' . esc_html__( 'Learn More', 'cbxwpbookmarkaddon' ) . '</a>';

			$links_array[] = '<a target="_blank" style="color:#005ae0 !important; font-weight: bold;" href="https://codeboxr.com/contact-us/" aria-label="' . esc_attr__( 'Pro Support', 'cbxwpbookmarkaddon' ) . '">' . esc_html__( 'Pro Support', 'cbxwpbookmarkaddon' ) . '</a>';
		}

		return $links_array;
	}//end plugin_row_meta

	/**
	 * Display bookmark button for buddypress activity
	 */
	public function bp_activity_entry_meta_bookmark_btn() {
		$setting = $this->settings_api;

		$bookmark_mode = $setting->get_option( 'bookmark_mode', 'cbxwpbookmark_basics', 'user_cat' );
		//$enable_buddypress_bookmark = intval( $setting->get_option( 'enable_buddypress_bookmark', 'cbxwpbookmark_proaddon', 0 ) );
		$enable_buddypress_bookmark = intval( $setting->get_option( 'enable_buddypress_bookmark', 'cbxwpbookmark_buddypress', 0 ) );

		//if ( function_exists( 'show_cbxbookmark_btn' ) && $bookmark_mode == 'no_cat'  && $enable_buddypress_bookmark) {
		if ( function_exists( 'show_cbxbookmark_btn' ) && $enable_buddypress_bookmark ) {
			$showcount   = intval( $setting->get_option( 'showcount', 'cbxwpbookmark_basics', 0 ) );
			$activity_id = intval( bp_get_activity_id() );
			echo show_cbxbookmark_btn( $activity_id, 'buddypress_activity', $showcount );
		}
	}//end bp_activity_entry_meta_bookmark_btn

	/**
	 * Let's show buddypress type post title and information
	 *
	 * @param $item
	 * @param $instance
	 * @param $setting
	 * @param $action_html
	 * @param $sub_item_class
	 */
	public function cbxwpbookmark_item_othertype( $item, $instance, $setting, $action_html = '', $sub_item_class = '' ) {
		echo cbxwpbookmarkpro_get_template_html( 'bookmarkpost/single-othertype.php', array(
			'item'           => $item,
			'instance'       => $instance,
			'setting'        => $setting,
			'action_html'    => $action_html,
			'sub_item_class' => $sub_item_class
		) );
	}//end cbxwpbookmark_item_othertype

	/**
	 * Let's show buddypress type post title and information
	 *
	 * @param $item
	 * @param $instance
	 * @param $setting
	 * @param $li_class
	 * @param $show_count_html
	 */
	public function cbxwpbookmark_mostitem_othertype( $item, $instance, $setting, $li_class = '', $show_count_html = '' ) {
		echo cbxwpbookmarkpro_get_template_html( 'bookmarkmost/single-othertype.php', array(
			'item'            => $item,
			'instance'        => $instance,
			'setting'         => $setting,
			'li_class'        => $li_class,
			'show_count_html' => $show_count_html
		) );
	}//end cbxwpbookmark_mostitem_othertype

	/**
	 *
	 *
	 * @param $image_sizes_arr
	 *
	 * @return mixed
	 */
	public function cbxwpbookmark_all_thumbnail_sizes_formatted_fifu( $image_sizes_arr ) {
		$image_sizes_arr['fifu'] = esc_html__( 'Fifu Integration', 'cbxwpbookmarkaddon' );

		return $image_sizes_arr;
	}//end cbxwpbookmark_all_thumbnail_sizes_formatted_fifu

	/**
	 * Init all gutenberg pro blocks
	 */
	public function gutenberg_blocks() {

		if ( ! function_exists( 'register_block_type' ) ) {
			// Gutenberg is not active.
			return;
		}

		$this->init_cbxwpbookmark_postgrid_block();
		$this->init_cbxwpbookmark_mostgrid_block();

		if ( class_exists( 'Woocommerce' ) ) {
			$this->init_cbxwpbookmark_mostproducts_block(); //woo
		}

		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			$this->init_cbxwpbookmark_mostdownloads_block(); //edd
		}
	}//end gutenberg_blocks

	/**
	 * Register bookmark post grid block
	 */
	public function init_cbxwpbookmark_postgrid_block() {
		$order_options = array();

		$order_options[] = array(
			'label' => esc_html__( 'Descending Order', 'cbxwpbookmarkaddon' ),
			'value' => 'DESC',
		);

		$order_options[] = array(
			'label' => esc_html__( 'Ascending Order', 'cbxwpbookmarkaddon' ),
			'value' => 'ASC',
		);

		$orderby_options   = array();
		$orderby_options[] = array(
			'label' => esc_html__( 'Post Type', 'cbxwpbookmarkaddon' ),
			'value' => 'object_type',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post ID', 'cbxwpbookmarkaddon' ),
			'value' => 'object_id',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Bookmark ID', 'cbxwpbookmarkaddon' ),
			'value' => 'id',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post Title', 'cbxwpbookmarkaddon' ),
			'value' => 'title',
		);

		$type_options   = array();
		$post_types     = CBXWPBookmarkHelper::post_types_plain();
		$type_options[] = array(
			'label' => esc_html__( 'Select Post Type', 'cbxwpbookmarkaddon' ),
			'value' => '',
		);

		foreach ( $post_types as $type_slug => $type_name ) {
			$type_options[] = array(
				'label' => $type_name,
				'value' => $type_slug,
			);
		}


		//css file is common for all blocks
		wp_register_style( 'cbxwpbookmarkaddon-block', plugin_dir_url( __FILE__ ) . 'assets/css/cbxwpbookmarkaddon-block.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/cbxwpbookmarkaddon-block.css' ) );


		wp_register_script( 'cbxwpbookmark-postgrid-block',
			plugin_dir_url( __FILE__ ) . 'assets/js/cbxwpbookmark-postgrid-block.js',
			array(
				'wp-blocks',
				'wp-element',
				'wp-components',
				'wp-editor',
				//'jquery',
				//'codeboxrflexiblecountdown-public'
			),
			filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/cbxwpbookmark-postgrid-block.js' ) );

		$js_vars = apply_filters( 'cbxwpbookmark_postgrid_block_js_vars',
			array(
				'block_title'      => esc_html__( 'CBX My Bookmarked Post Grid', 'cbxwpbookmarkaddon' ),
				'block_category'   => 'cbxwpbookmark',
				'block_icon'       => 'universal-access-alt',
				'general_settings' => array(
					'heading'         => esc_html__( 'Block Settings', 'cbxwpbookmarkaddon' ),
					'title'           => esc_html__( 'Title', 'cbxwpbookmarkaddon' ),
					'title_desc'      => esc_html__( 'Leave empty to hide', 'cbxwpbookmarkaddon' ),
					'order'           => esc_html__( 'Order', 'cbxwpbookmarkaddon' ),
					'order_options'   => $order_options,
					'orderby'         => esc_html__( 'Order By', 'cbxwpbookmarkaddon' ),
					'orderby_options' => $orderby_options,
					'type'            => esc_html__( 'Post Type(s)', 'cbxwpbookmarkaddon' ),
					'type_options'    => $type_options,
					'limit'           => esc_html__( 'Number of Posts', 'cbxwpbookmarkaddon' ),
					'loadmore'        => esc_html__( 'Show Load More', 'cbxwpbookmarkaddon' ),
					'catid'           => esc_html__( 'Categories(Comma Separated)', 'cbxwpbookmarkaddon' ),
					'catid_note'      => esc_html__( 'This is practically useful if category mode = global category', 'cbxwpbookmarkaddon' ),
					'cattitle'        => esc_html__( 'Show Category Title', 'cbxwpbookmarkaddon' ),
					'catcount'        => esc_html__( 'Show Category Count', 'cbxwpbookmarkaddon' ),
					'allowdelete'     => esc_html__( 'Allow Delete', 'cbxwpbookmarkaddon' ),
					'allowdeleteall'  => esc_html__( 'Allow Delete All', 'cbxwpbookmarkaddon' ),
					'show_thumb'      => esc_html__( 'Show Thumbnail', 'cbxwpbookmarkaddon' ),
				),
			) );

		wp_localize_script( 'cbxwpbookmark-postgrid-block', 'cbxwpbookmark_postgrid_block', $js_vars );

		register_block_type( 'codeboxr/cbxwpbookmark-postgrid-block',
			array(
				'editor_script'   => 'cbxwpbookmark-postgrid-block',
				'editor_style'    => 'cbxwpbookmarkaddon-block',
				'attributes'      => apply_filters( 'cbxwpbookmark_postgrid_block_attributes',
					array(
						'title'          => array(
							'type'    => 'string',
							'default' => esc_html__( 'All Bookmarks', 'cbxwpbookmarkaddon' ),
						),
						'order'          => array(
							'type'    => 'string',
							'default' => 'DESC',
						),
						'orderby'        => array(
							'type'    => 'string',
							'default' => 'id',
						),
						'type'           => array(
							'type'    => 'array',
							'default' => array(),
							'items'   => array(
								'type' => 'string',
							),
						),
						'catid'          => array(
							'type'    => 'string',
							'default' => '',
						),
						'limit'          => array(
							'type'    => 'integer',
							'default' => 10,
						),
						'loadmore'       => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'cattitle'       => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'catcount'       => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'allowdelete'    => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'allowdeleteall' => array(
							'type'    => 'boolean',
							'default' => false,
						),
						'show_thumb'     => array(
							'type'    => 'boolean',
							'default' => true,
						),

					) ),
				'render_callback' => array( $this, 'cbxwpbookmark_postgrid_block_render' ),
			) );
	}//end init_cbxwpbookmark_postgrid_block

	/**
	 * Getenberg server side render for my bookmark post grid block
	 *
	 * @param $attr
	 *
	 * @return string
	 */
	public function cbxwpbookmark_postgrid_block_render( $attr ) {
		$arr = array();

		$arr['title']   = isset( $attr['title'] ) ? sanitize_text_field( $attr['title'] ) : '';
		$arr['order']   = isset( $attr['order'] ) ? sanitize_text_field( $attr['order'] ) : 'DESC';
		$arr['orderby'] = isset( $attr['orderby'] ) ? sanitize_text_field( $attr['orderby'] ) : 'id';
		$arr['limit']   = isset( $attr['limit'] ) ? intval( $attr['limit'] ) : 10;


		$type        = isset( $attr['type'] ) ? wp_unslash( $attr['type'] ) : array();
		$type        = array_filter( $type );
		$arr['type'] = implode( ',', $type );

		$attr['catid'] = isset( $attr['catid'] ) ? wp_unslash( $attr['catid'] ) : '';


		$arr['loadmore'] = isset( $attr['loadmore'] ) ? $attr['loadmore'] : 'true';
		$arr['loadmore'] = ( $arr['loadmore'] == 'true' ) ? 1 : 0;


		$arr['cattitle'] = isset( $attr['cattitle'] ) ? $attr['cattitle'] : 'true';
		$arr['cattitle'] = ( $arr['cattitle'] == 'true' ) ? 1 : 0;

		$arr['catcount'] = isset( $attr['catcount'] ) ? $attr['catcount'] : 'true';
		$arr['catcount'] = ( $arr['catcount'] == 'true' ) ? 1 : 0;

		$arr['allowdelete'] = isset( $attr['allowdelete'] ) ? $attr['allowdelete'] : 'false';
		$arr['allowdelete'] = ( $arr['allowdelete'] == 'true' ) ? 1 : 0;

		$arr['allowdeleteall'] = isset( $attr['allowdeleteall'] ) ? $attr['allowdeleteall'] : 'false';
		$arr['allowdeleteall'] = ( $arr['allowdeleteall'] == 'true' ) ? 1 : 0;

		$arr['show_thumb'] = isset( $attr['show_thumb'] ) ? $attr['show_thumb'] : 'true';
		$arr['show_thumb'] = ( $arr['show_thumb'] == 'true' ) ? 1 : 0;

		$attr_html = '';
		foreach ( $arr as $key => $value ) {
			$attr_html .= ' ' . $key . '="' . $value . '" ';
		}

		return do_shortcode( '[cbxwpbookmarkgrid ' . $attr_html . ']' );
		//return '[cbxwpbookmarkgrid '.$attr_html.']';


	}//end cbxwpbookmark_postgrid_block_render

	/**
	 * Register most bookmarked post grid block
	 */
	public function init_cbxwpbookmark_mostgrid_block() {
		$order_options = array();

		$order_options[] = array(
			'label' => esc_html__( 'Descending Order', 'cbxwpbookmarkaddon' ),
			'value' => 'DESC',
		);

		$order_options[] = array(
			'label' => esc_html__( 'Ascending Order', 'cbxwpbookmarkaddon' ),
			'value' => 'ASC',
		);

		$orderby_options   = array();
		$orderby_options[] = array(
			'label' => esc_html__( 'Bookmark Count', 'cbxwpbookmarkaddon' ),
			'value' => 'object_count',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post Type', 'cbxwpbookmarkaddon' ),
			'value' => 'object_type',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post ID', 'cbxwpbookmarkaddon' ),
			'value' => 'object_id',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Bookmark ID', 'cbxwpbookmarkaddon' ),
			'value' => 'id',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post Title', 'cbxwpbookmarkaddon' ),
			'value' => 'title',
		);

		$type_options   = array();
		$post_types     = CBXWPBookmarkHelper::post_types_plain();
		$type_options[] = array(
			'label' => esc_html__( 'Select Post Type', 'cbxwpbookmarkaddon' ),
			'value' => '',
		);

		foreach ( $post_types as $type_slug => $type_name ) {
			$type_options[] = array(
				'label' => $type_name,
				'value' => $type_slug,
			);
		}

		$daytime_options   = array();
		$daytime_options[] = array(
			'label' => esc_html__( '-- All Time --', 'cbxwpbookmarkaddon' ),
			'value' => 0
		);

		$daytime_options[] = array(
			'label' => esc_html__( '1 Day', 'cbxwpbookmarkaddon' ),
			'value' => 1
		);

		$daytime_options[] = array(
			'label' => esc_html__( '7 Days', 'cbxwpbookmarkaddon' ),
			'value' => 7
		);

		$daytime_options[] = array(
			'label' => esc_html__( '30 Days', 'cbxwpbookmarkaddon' ),
			'value' => 30
		);

		$daytime_options[] = array(
			'label' => esc_html__( '6 Months', 'cbxwpbookmarkaddon' ),
			'value' => 180
		);

		$daytime_options[] = array(
			'label' => esc_html__( '1 Year', 'cbxwpbookmarkaddon' ),
			'value' => 365
		);


		//css file is common for all blocks
		wp_register_style( 'cbxwpbookmarkaddon-block', plugin_dir_url( __FILE__ ) . 'assets/css/cbxwpbookmarkaddon-block.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/cbxwpbookmarkaddon-block.css' ) );

		wp_register_script( 'cbxwpbookmark-mostgrid-block',
			plugin_dir_url( __FILE__ ) . 'assets/js/cbxwpbookmark-mostgrid-block.js',
			array(
				'wp-blocks',
				'wp-element',
				'wp-components',
				'wp-editor',
				//'jquery',
				//'codeboxrflexiblecountdown-public'
			),
			filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/cbxwpbookmark-mostgrid-block.js' ) );

		$js_vars = apply_filters( 'cbxwpbookmark_mostgrid_block_js_vars',
			array(
				'block_title'      => esc_html__( 'CBX Most Bookmarked Posts Grid', 'cbxwpbookmarkaddon' ),
				'block_category'   => 'cbxwpbookmark',
				'block_icon'       => 'universal-access-alt',
				'general_settings' => array(
					'heading'         => esc_html__( 'Block Settings', 'cbxwpbookmarkaddon' ),
					'title'           => esc_html__( 'Title', 'cbxwpbookmarkaddon' ),
					'title_desc'      => esc_html__( 'Leave empty to hide', 'cbxwpbookmarkaddon' ),
					'order'           => esc_html__( 'Order', 'cbxwpbookmarkaddon' ),
					'order_options'   => $order_options,
					'orderby'         => esc_html__( 'Order By', 'cbxwpbookmarkaddon' ),
					'orderby_options' => $orderby_options,
					'type'            => esc_html__( 'Post Type(s)', 'cbxwpbookmarkaddon' ),
					'type_options'    => $type_options,
					'limit'           => esc_html__( 'Number of Posts', 'cbxwpbookmarkaddon' ),
					'daytime'         => esc_html__( 'Duration', 'cbxwpbookmarkaddon' ),
					'daytime_options' => $daytime_options,
					'show_count'      => esc_html__( 'Show Count', 'cbxwpbookmarkaddon' ),
					'show_thumb'      => esc_html__( 'Show Thumbnail', 'cbxwpbookmarkaddon' ),
					'load_more'       => esc_html__( 'Show Load More', 'cbxwpbookmarkaddon' ),
				),
			) );

		wp_localize_script( 'cbxwpbookmark-mostgrid-block', 'cbxwpbookmark_mostgrid_block', $js_vars );

		register_block_type( 'codeboxr/cbxwpbookmark-mostgrid-block',
			array(
				'editor_script'   => 'cbxwpbookmark-mostgrid-block',
				'editor_style'    => 'cbxwpbookmarkaddon-block',
				'attributes'      => apply_filters( 'cbxwpbookmark_mostgrid_block_attributes',
					array(
						'title'      => array(
							'type'    => 'string',
							'default' => esc_html__( 'Most Bookmarked Posts', 'cbxwpbookmarkaddon' ),
						),
						'order'      => array(
							'type'    => 'string',
							'default' => 'DESC',
						),
						'orderby'    => array(
							'type'    => 'string',
							'default' => 'object_count',
						),
						'type'       => array(
							'type'    => 'array',
							'default' => array(),
							'items'   => array(
								'type' => 'string',
							),
						),
						'limit'      => array(
							'type'    => 'integer',
							'default' => 10,
						),
						'daytime'    => array(
							'type'    => 'integer',
							'default' => 0,
						),
						'show_count' => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'show_thumb' => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'load_more'  => array(
							'type'    => 'boolean',
							'default' => false,
						),

					) ),
				'render_callback' => array( $this, 'cbxwpbookmark_mostgrid_block_render' ),
			) );
	}//end init_cbxwpbookmark_mostgrid_block

	/**
	 * Getenberg server side render for most bookmark post grid block
	 *
	 * @param $attr
	 *
	 * @return string
	 */
	public function cbxwpbookmark_mostgrid_block_render( $attr ) {
		$arr = array();

		$arr['title']   = isset( $attr['title'] ) ? sanitize_text_field( $attr['title'] ) : '';
		$arr['order']   = isset( $attr['order'] ) ? sanitize_text_field( $attr['order'] ) : 'DESC';
		$arr['orderby'] = isset( $attr['orderby'] ) ? sanitize_text_field( $attr['orderby'] ) : 'object_count';
		$arr['limit']   = isset( $attr['limit'] ) ? intval( $attr['limit'] ) : 10;


		$type        = isset( $attr['type'] ) ? wp_unslash( $attr['type'] ) : array();
		$type        = array_filter( $type );
		$arr['type'] = implode( ',', $type );

		$attr['daytime'] = isset( $attr['daytime'] ) ? intval( $attr['daytime'] ) : 0;


		$arr['show_count'] = isset( $attr['show_count'] ) ? $attr['show_count'] : 'true';
		$arr['show_count'] = ( $arr['show_count'] == 'true' ) ? 1 : 0;

		$arr['show_thumb'] = isset( $attr['show_thumb'] ) ? $attr['show_thumb'] : 'false';
		$arr['show_thumb'] = ( $arr['show_thumb'] == 'true' ) ? 1 : 0;

		$arr['load_more'] = isset( $attr['load_more'] ) ? $attr['load_more'] : 'false';
		$arr['load_more'] = ( $arr['load_more'] == 'true' ) ? 1 : 0;

		$attr_html = '';
		foreach ( $arr as $key => $value ) {
			$attr_html .= ' ' . $key . '="' . $value . '" ';
		}

		return do_shortcode( '[cbxwpbookmark-mostgrid ' . $attr_html . ']' );
		//return '[cbxwpbookmark-mostgrid '.$attr_html.']';
	}//end cbxwpbookmark_mostgrid_block_render

	/**
	 * Register most bookmark products(woo) grid block
	 */
	public function init_cbxwpbookmark_mostproducts_block() {
		$order_options = array();

		$order_options[] = array(
			'label' => esc_html__( 'Descending Order', 'cbxwpbookmarkaddon' ),
			'value' => 'DESC',
		);

		$order_options[] = array(
			'label' => esc_html__( 'Ascending Order', 'cbxwpbookmarkaddon' ),
			'value' => 'ASC',
		);

		$orderby_options   = array();
		$orderby_options[] = array(
			'label' => esc_html__( 'Bookmark Count', 'cbxwpbookmarkaddon' ),
			'value' => 'object_count',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post Type', 'cbxwpbookmarkaddon' ),
			'value' => 'object_type',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post ID', 'cbxwpbookmarkaddon' ),
			'value' => 'object_id',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Bookmark ID', 'cbxwpbookmarkaddon' ),
			'value' => 'id',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post Title', 'cbxwpbookmarkaddon' ),
			'value' => 'title',
		);

		$type_options   = array();
		$post_types     = CBXWPBookmarkHelper::post_types_plain();
		$type_options[] = array(
			'label' => esc_html__( 'Select Post Type', 'cbxwpbookmarkaddon' ),
			'value' => '',
		);

		foreach ( $post_types as $type_slug => $type_name ) {
			$type_options[] = array(
				'label' => $type_name,
				'value' => $type_slug,
			);
		}

		$daytime_options   = array();
		$daytime_options[] = array(
			'label' => esc_html__( '-- All Time --', 'cbxwpbookmarkaddon' ),
			'value' => 0
		);

		$daytime_options[] = array(
			'label' => esc_html__( '1 Day', 'cbxwpbookmarkaddon' ),
			'value' => 1
		);

		$daytime_options[] = array(
			'label' => esc_html__( '7 Days', 'cbxwpbookmarkaddon' ),
			'value' => 7
		);

		$daytime_options[] = array(
			'label' => esc_html__( '30 Days', 'cbxwpbookmarkaddon' ),
			'value' => 30
		);

		$daytime_options[] = array(
			'label' => esc_html__( '6 Months', 'cbxwpbookmarkaddon' ),
			'value' => 180
		);

		$daytime_options[] = array(
			'label' => esc_html__( '1 Year', 'cbxwpbookmarkaddon' ),
			'value' => 365
		);


		//css file is common for all blocks
		wp_register_style( 'cbxwpbookmarkaddon-block', plugin_dir_url( __FILE__ ) . 'assets/css/cbxwpbookmarkaddon-block.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/cbxwpbookmarkaddon-block.css' ) );

		wp_register_script( 'cbxwpbookmark-mostproducts-block',
			plugin_dir_url( __FILE__ ) . 'assets/js/cbxwpbookmark-mostproducts-block.js',
			array(
				'wp-blocks',
				'wp-element',
				'wp-components',
				'wp-editor',
				//'jquery',
				//'codeboxrflexiblecountdown-public'
			),
			filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/cbxwpbookmark-mostproducts-block.js' ) );

		$js_vars = apply_filters( 'cbxwpbookmark_mostproducts_block_js_vars',
			array(
				'block_title'      => esc_html__( 'CBX Most Bookmarked Products Grid', 'cbxwpbookmarkaddon' ),
				'block_category'   => 'cbxwpbookmark',
				'block_icon'       => 'universal-access-alt',
				'general_settings' => array(
					'heading'         => esc_html__( 'Block Settings', 'cbxwpbookmarkaddon' ),
					'title'           => esc_html__( 'Title', 'cbxwpbookmarkaddon' ),
					'title_desc'      => esc_html__( 'Leave empty to hide', 'cbxwpbookmarkaddon' ),
					'order'           => esc_html__( 'Order', 'cbxwpbookmarkaddon' ),
					'order_options'   => $order_options,
					'orderby'         => esc_html__( 'Order By', 'cbxwpbookmarkaddon' ),
					'orderby_options' => $orderby_options,
					'type'            => esc_html__( 'Post Type(s)', 'cbxwpbookmarkaddon' ),
					'type_options'    => $type_options,
					'limit'           => esc_html__( 'Number of Posts', 'cbxwpbookmarkaddon' ),
					'daytime'         => esc_html__( 'Duration', 'cbxwpbookmarkaddon' ),
					'daytime_options' => $daytime_options,
					'show_count'      => esc_html__( 'Show Count', 'cbxwpbookmarkaddon' ),
					'show_thumb'      => esc_html__( 'Show Thumbnail', 'cbxwpbookmarkaddon' ),
					'show_price'      => esc_html__( 'Show Price', 'cbxwpbookmarkaddon' ),
					'show_addcart'    => esc_html__( 'Show Add to Cart', 'cbxwpbookmarkaddon' ),
				),
			) );

		wp_localize_script( 'cbxwpbookmark-mostproducts-block', 'cbxwpbookmark_mostproducts_block', $js_vars );

		register_block_type( 'codeboxr/cbxwpbookmark-mostproducts-block',
			array(
				'editor_script'   => 'cbxwpbookmark-mostproducts-block',
				'editor_style'    => 'cbxwpbookmarkaddon-block',
				'attributes'      => apply_filters( 'cbxwpbookmark_mostproducts_block_attributes',
					array(
						'title'        => array(
							'type'    => 'string',
							'default' => esc_html__( 'Most Bookmarked Products', 'cbxwpbookmarkaddon' ),
						),
						'order'        => array(
							'type'    => 'string',
							'default' => 'DESC',
						),
						'orderby'      => array(
							'type'    => 'string',
							'default' => 'object_count',
						),
						'type'         => array(
							'type'    => 'array',
							'default' => array(),
							'items'   => array(
								'type' => 'string',
							),
						),
						'limit'        => array(
							'type'    => 'integer',
							'default' => 10,
						),
						'daytime'      => array(
							'type'    => 'integer',
							'default' => 0,
						),
						'show_count'   => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'show_thumb'   => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'show_price'   => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'show_addcart' => array(
							'type'    => 'boolean',
							'default' => true,
						),

					) ),
				'render_callback' => array( $this, 'cbxwpbookmark_mostproducts_block_render' ),
			) );
	}//end init_cbxwpbookmark_mostproducts_block

	/**
	 * Getenberg server side render for most bookmark products(woo) grid block
	 *
	 * @param $attr
	 *
	 * @return string
	 */
	public function cbxwpbookmark_mostproducts_block_render( $attr ) {
		$arr = array();

		$arr['title']   = isset( $attr['title'] ) ? sanitize_text_field( $attr['title'] ) : '';
		$arr['order']   = isset( $attr['order'] ) ? sanitize_text_field( $attr['order'] ) : 'DESC';
		$arr['orderby'] = isset( $attr['orderby'] ) ? sanitize_text_field( $attr['orderby'] ) : 'object_count';
		$arr['limit']   = isset( $attr['limit'] ) ? intval( $attr['limit'] ) : 10;


		$type        = isset( $attr['type'] ) ? wp_unslash( $attr['type'] ) : array();
		$type        = array_filter( $type );
		$arr['type'] = implode( ',', $type );

		$attr['daytime'] = isset( $attr['daytime'] ) ? intval( $attr['daytime'] ) : 0;


		$arr['show_count'] = isset( $attr['show_count'] ) ? $attr['show_count'] : 'true';
		$arr['show_count'] = ( $arr['show_count'] == 'true' ) ? 1 : 0;

		$arr['show_thumb'] = isset( $attr['show_thumb'] ) ? $attr['show_thumb'] : 'false';
		$arr['show_thumb'] = ( $arr['show_thumb'] == 'true' ) ? 1 : 0;

		$arr['show_price'] = isset( $attr['show_price'] ) ? $attr['show_price'] : 'true';
		$arr['show_price'] = ( $arr['show_price'] == 'true' ) ? 1 : 0;

		$arr['show_addcart'] = isset( $attr['show_addcart'] ) ? $attr['show_addcart'] : 'true';
		$arr['show_addcart'] = ( $arr['show_addcart'] == 'true' ) ? 1 : 0;

		$attr_html = '';
		foreach ( $arr as $key => $value ) {
			$attr_html .= ' ' . $key . '="' . $value . '" ';
		}

		return do_shortcode( '[cbxwpbookmark-mostproducts ' . $attr_html . ']' );
		//return '[cbxwpbookmark-mostproducts '.$attr_html.']';
	}//end cbxwpbookmark_mostproducts_block_render

	/**
	 * Register most bookmark downlods(edd) grid block
	 */
	public function init_cbxwpbookmark_mostdownloads_block() {
		$order_options = array();

		$order_options[] = array(
			'label' => esc_html__( 'Descending Order', 'cbxwpbookmarkaddon' ),
			'value' => 'DESC',
		);

		$order_options[] = array(
			'label' => esc_html__( 'Ascending Order', 'cbxwpbookmarkaddon' ),
			'value' => 'ASC',
		);

		$orderby_options   = array();
		$orderby_options[] = array(
			'label' => esc_html__( 'Bookmark Count', 'cbxwpbookmarkaddon' ),
			'value' => 'object_count',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post Type', 'cbxwpbookmarkaddon' ),
			'value' => 'object_type',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post ID', 'cbxwpbookmarkaddon' ),
			'value' => 'object_id',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Bookmark ID', 'cbxwpbookmarkaddon' ),
			'value' => 'id',
		);
		$orderby_options[] = array(
			'label' => esc_html__( 'Post Title', 'cbxwpbookmarkaddon' ),
			'value' => 'title',
		);

		$type_options   = array();
		$post_types     = CBXWPBookmarkHelper::post_types_plain();
		$type_options[] = array(
			'label' => esc_html__( 'Select Post Type', 'cbxwpbookmarkaddon' ),
			'value' => '',
		);

		foreach ( $post_types as $type_slug => $type_name ) {
			$type_options[] = array(
				'label' => $type_name,
				'value' => $type_slug,
			);
		}

		$daytime_options   = array();
		$daytime_options[] = array(
			'label' => esc_html__( '-- All Time --', 'cbxwpbookmarkaddon' ),
			'value' => 0
		);

		$daytime_options[] = array(
			'label' => esc_html__( '1 Day', 'cbxwpbookmarkaddon' ),
			'value' => 1
		);

		$daytime_options[] = array(
			'label' => esc_html__( '7 Days', 'cbxwpbookmarkaddon' ),
			'value' => 7
		);

		$daytime_options[] = array(
			'label' => esc_html__( '30 Days', 'cbxwpbookmarkaddon' ),
			'value' => 30
		);

		$daytime_options[] = array(
			'label' => esc_html__( '6 Months', 'cbxwpbookmarkaddon' ),
			'value' => 180
		);

		$daytime_options[] = array(
			'label' => esc_html__( '1 Year', 'cbxwpbookmarkaddon' ),
			'value' => 365
		);


		//css file is common for all blocks
		wp_register_style( 'cbxwpbookmarkaddon-block', plugin_dir_url( __FILE__ ) . 'assets/css/cbxwpbookmarkaddon-block.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/cbxwpbookmarkaddon-block.css' ) );

		wp_register_script( 'cbxwpbookmark-mostdownloads-block',
			plugin_dir_url( __FILE__ ) . 'assets/js/cbxwpbookmark-mostdownloads-block.js',
			array(
				'wp-blocks',
				'wp-element',
				'wp-components',
				'wp-editor',
				//'jquery',
				//'codeboxrflexiblecountdown-public'
			),
			filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/cbxwpbookmark-mostdownloads-block.js' ) );

		$js_vars = apply_filters( 'cbxwpbookmark_mostdownloads_block_js_vars',
			array(
				'block_title'      => esc_html__( 'CBX Most Bookmarked downloads Grid', 'cbxwpbookmarkaddon' ),
				'block_category'   => 'cbxwpbookmark',
				'block_icon'       => 'universal-access-alt',
				'general_settings' => array(
					'heading'         => esc_html__( 'Block Settings', 'cbxwpbookmarkaddon' ),
					'title'           => esc_html__( 'Title', 'cbxwpbookmarkaddon' ),
					'title_desc'      => esc_html__( 'Leave empty to hide', 'cbxwpbookmarkaddon' ),
					'order'           => esc_html__( 'Order', 'cbxwpbookmarkaddon' ),
					'order_options'   => $order_options,
					'orderby'         => esc_html__( 'Order By', 'cbxwpbookmarkaddon' ),
					'orderby_options' => $orderby_options,
					'type'            => esc_html__( 'Post Type(s)', 'cbxwpbookmarkaddon' ),
					'type_options'    => $type_options,
					'limit'           => esc_html__( 'Number of Posts', 'cbxwpbookmarkaddon' ),
					'daytime'         => esc_html__( 'Duration', 'cbxwpbookmarkaddon' ),
					'daytime_options' => $daytime_options,
					'show_count'      => esc_html__( 'Show Count', 'cbxwpbookmarkaddon' ),
					'show_thumb'      => esc_html__( 'Show Thumbnail', 'cbxwpbookmarkaddon' ),
					'show_price'      => esc_html__( 'Show Price', 'cbxwpbookmarkaddon' ),
					'show_addcart'    => esc_html__( 'Show Add to Cart', 'cbxwpbookmarkaddon' ),
				),
			) );

		wp_localize_script( 'cbxwpbookmark-mostdownloads-block', 'cbxwpbookmark_mostdownloads_block', $js_vars );

		register_block_type( 'codeboxr/cbxwpbookmark-mostdownloads-block',
			array(
				'editor_script'   => 'cbxwpbookmark-mostdownloads-block',
				'editor_style'    => 'cbxwpbookmarkaddon-block',
				'attributes'      => apply_filters( 'cbxwpbookmark_mostdownloads_block_attributes',
					array(
						'title'        => array(
							'type'    => 'string',
							'default' => esc_html__( 'Most Bookmarked Downloads', 'cbxwpbookmarkaddon' ),
						),
						'order'        => array(
							'type'    => 'string',
							'default' => 'DESC',
						),
						'orderby'      => array(
							'type'    => 'string',
							'default' => 'object_count',
						),
						'type'         => array(
							'type'    => 'array',
							'default' => array(),
							'items'   => array(
								'type' => 'string',
							),
						),
						'limit'        => array(
							'type'    => 'integer',
							'default' => 10,
						),
						'daytime'      => array(
							'type'    => 'integer',
							'default' => 0,
						),
						'show_count'   => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'show_thumb'   => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'show_price'   => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'show_addcart' => array(
							'type'    => 'boolean',
							'default' => true,
						),

					) ),
				'render_callback' => array( $this, 'cbxwpbookmark_mostdownloads_block_render' ),
			) );
	}//end init_cbxwpbookmark_mostdownloads_block

	/**
	 * Getenberg server side render for most bookmark downloads(edd) grid block
	 *
	 * @param $attr
	 *
	 * @return string
	 */
	public function cbxwpbookmark_mostdownloads_block_render( $attr ) {
		$arr = array();

		$arr['title']   = isset( $attr['title'] ) ? sanitize_text_field( $attr['title'] ) : '';
		$arr['order']   = isset( $attr['order'] ) ? sanitize_text_field( $attr['order'] ) : 'DESC';
		$arr['orderby'] = isset( $attr['orderby'] ) ? sanitize_text_field( $attr['orderby'] ) : 'object_count';
		$arr['limit']   = isset( $attr['limit'] ) ? intval( $attr['limit'] ) : 10;


		$type        = isset( $attr['type'] ) ? wp_unslash( $attr['type'] ) : array();
		$type        = array_filter( $type );
		$arr['type'] = implode( ',', $type );

		$attr['daytime'] = isset( $attr['daytime'] ) ? intval( $attr['daytime'] ) : 0;


		$arr['show_count'] = isset( $attr['show_count'] ) ? $attr['show_count'] : 'true';
		$arr['show_count'] = ( $arr['show_count'] == 'true' ) ? 1 : 0;

		$arr['show_thumb'] = isset( $attr['show_thumb'] ) ? $attr['show_thumb'] : 'false';
		$arr['show_thumb'] = ( $arr['show_thumb'] == 'true' ) ? 1 : 0;

		$arr['show_price'] = isset( $attr['show_price'] ) ? $attr['show_price'] : 'true';
		$arr['show_price'] = ( $arr['show_price'] == 'true' ) ? 1 : 0;

		$arr['show_addcart'] = isset( $attr['show_addcart'] ) ? $attr['show_addcart'] : 'true';
		$arr['show_addcart'] = ( $arr['show_addcart'] == 'true' ) ? 1 : 0;

		$attr_html = '';
		foreach ( $arr as $key => $value ) {
			$attr_html .= ' ' . $key . '="' . $value . '" ';
		}

		return do_shortcode( '[cbxwpbookmark-mostdownloads ' . $attr_html . ']' );
		//return '[cbxwpbookmark-mostdownloads '.$attr_html.']';
	}//end cbxwpbookmark_mostdownloads_block_render


	/**
	 * Enqueue style for block editor
	 */
	public function enqueue_block_editor_assets() {

	}//end enqueue_block_editor_assets

	public function envira_gallery_output_after_item_btn( $gallery, $id, $item, $data, $i ) {
		$gallery .= do_shortcode( '[cbxwpbookmarkbtn object_id="' . $id . '" object_type="attachment"]' );

		return $gallery;
	}//end envira_gallery_output_after_item_btn

	/**
	 * Init elementor widget
	 *
	 * @throws Exception
	 */
	public function init_elementor_widgets() {
		//register the bookmark post grid widget
		if ( ! class_exists( 'CBXWPBookmarkgrid_ElemWidget' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'widgets/elementor_widgets/class-cbxwpbookmark-bookmarkgrid-elemwidget.php';
		}

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CBXWPBookmark_ElemWidget\Widgets\CBXWPBookmarkgrid_ElemWidget() );

		//register the  most bookmark post grid widget
		if ( ! class_exists( 'CBXWPBookmarkmostgrid_ElemWidget' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'widgets/elementor_widgets/class-cbxwpbookmark-bookmarkmostgrid-elemwidget.php';
		}

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CBXWPBookmark_ElemWidget\Widgets\CBXWPBookmarkmostgrid_ElemWidget() );

		if ( class_exists( 'Woocommerce' ) ) {
			//register the  most bookmarked products widget
			if ( ! class_exists( 'CBXWPBookmarkProducts_ElemWidget' ) ) {
				require_once plugin_dir_path( __FILE__ ) . 'widgets/elementor_widgets/class-cbxwpbookmark-products-elemwidget.php';
			}

			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CBXWPBookmark_ElemWidget\Widgets\CBXWPBookmarkProducts_ElemWidget() );
		}


		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			//register the  most bookmarked downloads widget
			if ( ! class_exists( 'CBXWPBookmarkDownloads_ElemWidget' ) ) {
				require_once plugin_dir_path( __FILE__ ) . 'widgets/elementor_widgets/class-cbxwpbookmark-downloads-elemwidget.php';
			}

			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CBXWPBookmark_ElemWidget\Widgets\CBXWPBookmarkDownloads_ElemWidget() );
		}

	}//end widgets_registered

	/**
	 * Add new category to elementor
	 *
	 * @param $elements_manager
	 */
	public function add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'cbxwpbookmark',
			array(
				'title' => esc_html__( 'CBX Bookmark Widgets', 'cbxwpbookmarkaddon' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}//end add_elementor_widget_categories

	/**
	 * Load Elementor Custom Icon
	 */
	public function elementor_icon_loader() {
		wp_register_style( 'cbxwpbookmarkaddon_elementor_icon',
			CBXWPBOOKMARKADDON_ROOT_URL . 'assets/css/cbxwpbookmarkaddon-elementor.css', false, $this->version );
		wp_enqueue_style( 'cbxwpbookmarkaddon_elementor_icon' );
	}//end elementor_icon_loader

	/**
	 * WPBakery Widgets registers
	 *
	 * Before WPBakery inits includes the new widgets
	 */
	public function vc_before_init_actions() {
		//include vc params
		if ( ! class_exists( 'CBXWPBookmark_VCParam_DropDownMulti' ) ) {
			require_once CBXWPBOOKMARK_ROOT_PATH . 'widgets/vc_widgets/params/class-cbxwpbookmark-vc-param-dropdown-multi.php';
		}

		//includes the vc widgets


		//bookmark post grid
		if ( ! class_exists( 'CBXWPBookmarkgrid_VCWidget' ) ) {
			require_once CBXWPBOOKMARKADDON_ROOT_PATH . 'widgets/vc_widgets/class-cbxwpbookmark-bookmarkgrid-vcwidget.php';
		}
		new CBXWPBookmarkgrid_VCWidget();

		//most bookmarked post grid widget
		if ( ! class_exists( 'CBXWPBookmarkmostgrid_VCWidget' ) ) {
			require_once CBXWPBOOKMARKADDON_ROOT_PATH . 'widgets/vc_widgets/class-cbxwpbookmark-bookmarkmostgrid-vcwidget.php';
		}
		new CBXWPBookmarkmostgrid_VCWidget();

		if ( class_exists( 'Woocommerce' ) ) {
			//most bookmarked products(woo) widget
			if ( ! class_exists( 'CBXWPBookmarkProducts_VCWidget' ) ) {
				require_once CBXWPBOOKMARKADDON_ROOT_PATH . 'widgets/vc_widgets/class-cbxwpbookmark-products-vcwidget.php';
			}
			new CBXWPBookmarkProducts_VCWidget();
		}


		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			//most bookmarked downloads(EDD) widget
			if ( ! class_exists( 'CBXWPBookmarkDownlods_VCWidget' ) ) {
				require_once CBXWPBOOKMARKADDON_ROOT_PATH . 'widgets/vc_widgets/class-cbxwpbookmark-downloads-vcwidget.php';
			}
			new CBXWPBookmarkDownlods_VCWidget();
		}

	}//end vc_before_init_actions

	/**
	 * Override the login html with woocommerce's login form
	 *
	 * @param string $login_html
	 * @param string $login_url
	 *
	 * @return string
	 */
	public function cbxwpbookmark_login_html_woo( $login_html = '', $login_url = '' ) {
		$settings_api = $this->settings_api;

		$woo_login = intval( $settings_api->get_option( 'woo_login', 'cbxwpbookmark_woocommerce', 0 ) );

		if ( $woo_login && class_exists( 'woocommerce' ) ) {
			$login_url_parsed = parse_url( $login_url );
			parse_str( $login_url_parsed['query'], $login_url_params );

			if ( isset( $login_url_params['redirect_to'] ) ) {
				$redirect_to = $login_url_params['redirect_to'];

				$args = array(
					'message'  => '',
					'redirect' => $redirect_to,
					'hidden'   => false,
				);


				$login_html = '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-login cbxwpbookmark-title-woocommerce">' . esc_html__( 'Please login to bookmark', 'cbxwpbookmarkaddon' ) . '</h3>';
				$login_html .= wc_get_template_html( 'global/form-login.php', $args );
			}

		}

		return $login_html;
	}//end cbxwpbookmark_login_html_woo

	/**
	 * Add other 3rd party plugin's login form as option
	 *
	 * @param array $forms
	 *
	 * @return array
	 */
	public function cbxwpbookmark_guest_login_forms_others( $forms = array() ) {
		if ( class_exists( 'woocommerce' ) ) {
			$forms['woocommerce'] = esc_html__( 'WooCommerce Login Form', 'cbxwpbookmarkaddon' );
		}

		if ( class_exists( 'RCP_Requirements_Check' ) ) {
			$forms['restrict-content-pro'] = esc_html__( 'Restrict Content Pro Login Form', 'cbxwpbookmarkaddon' );
		}


		if ( class_exists( 'bbPress' ) ) {
			$forms['bbpress'] = esc_html__( 'bbPress Login Form', 'cbxwpbookmarkaddon' );
		}

		if ( class_exists( 'BuddyPress' ) ) {
			$forms['buddypress'] = esc_html__( 'BuddyPress Login Form', 'cbxwpbookmarkaddon' );
		}

		if ( defined('ultimatemember_plugin_name') ) {
			$forms['ultimate-member'] = esc_html__( 'Ultimate Member', 'cbxwpbookmarkaddon' );
		}

		if ( defined('PMPRO_VERSION') ) {
			$forms['paid-memberships-pro'] = esc_html__( 'Paid Memberships Pro', 'cbxwpbookmarkaddon' );
		}

		if ( defined('WP_EMEMBER_VERSION') ) {
			$forms['wp-emember'] = esc_html__( ' WP eMember', 'cbxwpbookmarkaddon' );
		}

		return $forms;
	}//end cbxwpbookmark_guest_login_forms_others

	/**
	 * Override the login html with 3rd party's login form
	 *
	 * @param string $login_html
	 * @param string $login_url
	 *
	 * @return string
	 */
	public function cbxwpbookmark_login_html_others( $login_html = '', $login_url = '', $redirect_url = '' ) {
	    global $wpdb;
		$settings_api = $this->settings_api;

		//$woo_login = intval($settings_api->get_option('woo_login', 'cbxwpbookmark_woocommerce', 0));
		$guest_login_form = esc_attr( $settings_api->get_option( 'guest_login_form', 'cbxwpbookmark_basics', 'wordpress' ) );


		//compatibility
		$woo_login = intval( $settings_api->get_option( 'woo_login', 'cbxwpbookmark_woocommerce', 0 ) );

		if ( class_exists( 'woocommerce' ) && ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) || 'yes' === get_option( 'woocommerce_enable_signup_and_login_from_checkout' ) ) && ( $guest_login_form == 'woocommerce') ) {



			//$login_url_parsed = parse_url($login_url);
			//parse_str($login_url_parsed['query'], $login_url_params);

			//if(isset($login_url_params['redirect_to'])){
			//	$redirect_to = $login_url_params['redirect_to'];

			$args = array(
				'message'  => '',
				'redirect' => $redirect_url,
				'hidden'   => false,
			);

			$login_html = '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-login cbxwpbookmark-title-woocommerce">' . esc_html__( 'Please login to bookmark', 'cbxwpbookmarkaddon' ) . '</h3>';
			$login_html .= wc_get_template_html( 'global/form-login.php', $args );
			//}

		}

		if ( function_exists( 'rcp_login_form' ) && ( $guest_login_form == 'restrict-content-pro' ) ) {
			$args = array(
				'redirect' => $redirect_url
			);

			$login_html = '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-login cbxwpbookmark-title-rpc">' . esc_html__( 'Please login to bookmark', 'cbxwpbookmarkaddon' ) . '</h3>';
			$login_html .= rcp_login_form( $args );
		}

		if ( class_exists( 'bbPress' ) && ( $guest_login_form == 'bbpress' ) ) {
			$login_html = '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-login cbxwpbookmark-title-bbpress">' . esc_html__( 'Please login to bookmark', 'cbxwpbookmarkaddon' ) . '</h3>';
			$login_html .= do_shortcode( '[bbp-login]' );
		}

		if ( class_exists( 'BuddyPress' ) && ( $guest_login_form == 'buddypress' ) ) {
			$login_html = '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-login cbxwpbookmark-title-buddypress">' . esc_html__( 'Please login to bookmark', 'cbxwpbookmarkaddon' ) . '</h3>';


			$login_html .= '<form name="login-form" id="sidebar-login-form" class="standard-form standard-form-buddypress" action="' . site_url( 'wp-login.php', 'login_post' ) . '" method="post">
                                    <label>' . __( 'Username', 'cbxwpbookmarkaddon' ) . '<br />
                                    <input type="text" name="log" id="sidebar-user-login" class="input" value="" tabindex="97" /></label>
                                    <label>' . __( 'Password', 'cbxwpbookmarkaddon' ) . '<br />
                                    <input type="password" name="pwd" id="sidebar-user-pass" class="input" value="" tabindex="98" /></label>
                                    <p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="sidebar-rememberme" value="forever" tabindex="99" /> ' . __( 'Remember Me', 'cbxwpbookmarkaddon' ) . '</label></p>
                                    <input type="submit" name="wp-submit" id="sidebar-wp-submit" value="' . esc_attr__( 'Log In', 'cbxwpbookmarkaddon' ) . '" tabindex="100" />		
                                    <input type="hidden" name="redirect_to" value="' . $redirect_url . '" />
                                </form>';

		}

		if ( defined('ultimatemember_plugin_name') && ( $guest_login_form == 'ultimate-member' )) {
			$args = array();
			$default_login = $wpdb->get_var(
				"SELECT pm.post_id 
				FROM {$wpdb->postmeta} pm 
				LEFT JOIN {$wpdb->postmeta} pm2 ON( pm.post_id = pm2.post_id AND pm2.meta_key = '_um_core' )
				WHERE pm.meta_key = '_um_mode' AND 
					  pm.meta_value = 'login' AND 
					  pm2.meta_value = 'login' "
			);

			$args['form_id'] = $default_login;
			$shortcode_attrs = '';
			foreach ( $args as $key => $value ) {
				$shortcode_attrs .= " {$key}=\"{$value}\"";
			}

			$login_html = '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-login cbxwpbookmark-title-ultimate-member">' . esc_html__( 'Please login to bookmark', 'cbxwpbookmarkaddon' ) . '</h3>';
			$login_html .= do_shortcode( "[ultimatemember {$shortcode_attrs} /]");
        }

		if ( defined('PMPRO_VERSION') && ( $guest_login_form == 'paid-memberships-pro' ) ) {
			$login_html = '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-login cbxwpbookmark-title-pmpro">' . esc_html__( 'Please login to bookmark', 'cbxwpbookmarkaddon' ) . '</h3>';
			$login_html .= do_shortcode( '[pmpro_login]' );
		}

		if ( defined('WP_EMEMBER_VERSION') && ( $guest_login_form == 'wp-emember' ) ) {
			$login_html = '<h3 class="cbxwpbookmark-title cbxwpbookmark-title-login cbxwpbookmark-title-wp-emember">' . esc_html__( 'Please login to bookmark', 'cbxwpbookmarkaddon' ) . '</h3>';
			$login_html .= do_shortcode( '[wp_eMember_login]' );
		}

		return $login_html;
	}//end cbxwpbookmark_login_html_others


	/**
	 * Override the register html with 3rd party's register form
	 *
	 * @param string $guest_register_html
	 * @param string $redirect_url
	 *
	 * @return string
	 */
	public function cbxwpbookmark_register_html_others( $guest_register_html = '', $redirect_url = '' ) {

		$settings_api = $this->settings_api;

		//$woo_login = intval($settings_api->get_option('woo_login', 'cbxwpbookmark_woocommerce', 0));
		$guest_login_form = esc_attr( $settings_api->get_option( 'guest_login_form', 'cbxwpbookmark_basics', 'wordpress' ) );


		//compatibility
		$woo_login = intval( $settings_api->get_option( 'woo_login', 'cbxwpbookmark_woocommerce', 0 ) );

		if ( class_exists( 'woocommerce' ) && ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) || 'yes' === get_option( 'woocommerce_enable_signup_and_login_from_checkout' ) ) && ( $guest_login_form == 'woocommerce' || $woo_login ) ) {

			$registration_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			if ( $redirect_url != '' ) {
				$registration_url = add_query_arg( 'redirect', urlencode( $redirect_url ), $registration_url );
			}

			$guest_register_html = '<p class="cbxwpbookmark-guest-register">' . sprintf( __( 'No account yet? <a href="%s">Register</a>', 'cbxwpbookmarkaddon' ), $registration_url ) . '</p>';
		}

		//restrict content pro
		if ( function_exists( 'rcp_login_form' ) && ( $guest_login_form == 'restrict-content-pro' ) ) {
			$rcp_options      = get_option( 'rcp_settings' );
			$registration_url = get_permalink( $rcp_options['registration_page'] );
			/*if($redirect_url != ''){
			        $registration_url = add_query_arg( 'redirect_to', urlencode( $redirect_url ), $registration_url);
		        }*/


			$guest_register_html = '<p class="cbxwpbookmark-guest-register">' . sprintf( __( 'No account yet? <a href="%s">Register</a>', 'cbxwpbookmarkaddon' ), $registration_url ) . '</p>';
		}


		//bbpress integration
		if ( class_exists( 'bbPress' ) && ( $guest_login_form == 'bbpress' ) ) {
			if ( get_option( 'users_can_register' ) ) {
				$register_url        = add_query_arg( 'redirect_to', urlencode( $redirect_url ), wp_registration_url() );
				$guest_register_html = '<p class="cbxwpbookmark-guest-register">' . sprintf( __( 'No account yet? <a href="%s">Register</a>', 'cbxwpbookmarkaddon' ), $register_url ) . '</p>';
			}
		}

		//buddypress integration
		if ( class_exists( 'BuddyPress' ) && ( $guest_login_form == 'buddypress' ) ) {
			if ( bp_get_signup_allowed() ) {
				//$register_url        = add_query_arg( 'redirect_to', urlencode( $redirect_url ), wp_registration_url() );
				$register_url        = bp_get_signup_page();
				$guest_register_html = '<p class="cbxwpbookmark-guest-register">' . sprintf( __( 'No account yet? <a href="%s">Register</a>', 'cbxwpbookmarkaddon' ), $register_url ) . '</p>';
			}
		}

		if ( defined('ultimatemember_plugin_name') && ( $guest_login_form == 'ultimate-member' )) {
			$register_url = um_get_core_page( 'register' );
			$guest_register_html = '<p class="cbxwpbookmark-guest-register">' . sprintf( __( 'No account yet? <a href="%s">Register</a>', 'cbxwpbookmarkaddon' ), $register_url ) . '</p>';
        }

		if ( defined('PMPRO_VERSION') && ( $guest_login_form == 'paid-memberships-pro' )) {
			$guest_register_html = '';
		}

		if ( defined('WP_EMEMBER_VERSION') && ( $guest_login_form == 'wp-emember' )) {
			$guest_register_html = '';
		}


		return $guest_register_html;
	}//end cbxwpbookmark_register_html_others


	public function can_user_create_own_category( $allow_create = true, $user_id = 0 ) {
		$user_id = intval( $user_id );
		$user_id = ( $user_id == 0 ) ? intval( get_current_user_id() ) : $user_id;

		if ( $user_id == 0 ) {
			return false;
		}

		$setting = $this->settings_api;

		//$allow_create = true

		//max cat limit override

		//$cbxwpbookmark_translation['max_cat_limit'] = intval( $max_cat_limit ); //0 means unlimited


		//who can create category override
		$default_roles = array( 'administrator', 'editor', 'author', 'contributor', 'subscriber' );
		$current_user  = wp_get_current_user();
		if ( is_user_logged_in() ) {
			$this_user_role = $current_user->roles;
		} else {
			$this_user_role = array( 'guest' );
		}

		$user_role_allowed = true;

		$cat_create_role    = $setting->get_option( 'cat_create_role', 'cbxwpbookmark_proaddon', $default_roles );
		$allowed_user_group = array_intersect( $cat_create_role, $this_user_role );
		if ( ( sizeof( $allowed_user_group ) ) < 1 ) {
			//current user is not allowed
			//$cbxwpbookmark_translation['user_can_create_cat'] = 0;
			$user_role_allowed = false;
		} else {
			//$cbxwpbookmark_translation['user_can_create_cat'] = 1;
			$user_role_allowed = true;
		}

		if ( $user_role_allowed ) {
			$max_cat_limit = intval( $setting->get_option( 'max_cat_limit', 'cbxwpbookmark_proaddon', '10' ) );
			$max_cat_limit = apply_filters( 'cbxwpbookmark_max_cat_limit', $max_cat_limit, $user_id );

			if ( $max_cat_limit != 0 ) {
				global $wpdb;
				$category_table = $wpdb->prefix . 'cbxwpbookmarkcat';
				$user_cat_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $category_table WHERE user_id = %d", array( $user_id ) ) );
				if ( $user_cat_count >= $max_cat_limit ) {
					$allow_create = false;
				}
			}

		} else {
			$allow_create = false;
		}


		return $allow_create;

	}//end can_user_create_own_category

	/**
	 * Delete bookmarks on buddypress activity delete
	 *
	 * @param int $object_id
	 * @param int $user_id
	 */
	public function delete_bookmark_buddypress( $object_id = 0, $user_id = 0 ) {
		global $wpdb;

		$bookmark_table = $wpdb->prefix . 'cbxwpbookmark';

		$object_id = intval( $object_id );

		//$object_types                = CBXWPBookmarkHelper::object_types( true ); //get plain post type as array

		$bookmarks = CBXWPBookmarkHelper::getBookmarksByObject( $object_id );

		if ( is_array( $bookmarks ) && sizeof( $bookmarks ) > 0 ) {
			foreach ( $bookmarks as $bookmark ) {
				$bookmark_id = intval( $bookmark['id'] );
				$user_id     = intval( $bookmark['user_id'] );
				$object_type = esc_attr( $bookmark['object_type'] );

				if ( $object_type != 'buddypress_activity' ) {
					return;
				}

				do_action( 'cbxbookmark_bookmark_removed_before', $bookmark_id, $user_id, $object_id, $object_type );

				$delete_bookmark = $wpdb->delete( $bookmark_table,
					array(
						'object_id' => $object_id,
						'user_id'   => $user_id,
					),
					array( '%d', '%d' ) );

				if ( $delete_bookmark !== false ) {
					do_action( 'cbxbookmark_bookmark_removed', $bookmark_id, $user_id, $object_id, $object_type );
				}
			}
		}

	}//end delete_bookmark_buddypress

	/**
	 * On bookmark on any post, post in buddypress activity
	 */
	public function register_buddypress_activity() {
		global $bp;

		$settings_api = $this->settings_api;

		//$woo_login = intval($settings_api->get_option('woo_login', 'cbxwpbookmark_woocommerce', 0));
		//$enable_buddypress_posting = intval($settings_api->get_option('enable_buddypress_posting', 'cbxwpbookmark_proaddon', 0));
		$enable_buddypress_posting = intval( $settings_api->get_option( 'enable_buddypress_posting', 'cbxwpbookmark_buddypress', 0 ) );

		if ( $enable_buddypress_posting && function_exists( 'bp_is_active' ) && bp_is_active( 'activity' ) ) {
			bp_activity_set_action(
				$bp->activity->id,
				'cbxwpbookmark_bookmark_added',
				esc_html__( 'Bookmarked Something', 'cbxwpbookmarkaddon' ),
				array( $this, 'register_buddypress_activity_bookmark' )
			);
		}

	}//end register_buddypress_activity

	/**
	 * Format 'cbxpoll_vote' activity actions.
	 *
	 * @param string $action Static activity action.
	 * @param object $activity Activity data object.
	 *
	 * @return string
	 * @since BuddyPress (2.0.0)
	 *
	 */
	public function register_buddypress_activity_bookmark( $action, $activity ) {
		$action = sprintf( __( '%s bookmarked an article', 'cbxwpbookmarkaddon' ), bp_core_get_userlink( $activity->user_id ) );

		return apply_filters( 'buddypress_activity_bookmark_added', $action, $activity );
	}//end register_buddypress_activity_bookmark

	/**
	 * On bookmark add post to buddypress
	 *
	 * @param $bookmark_id
	 * @param $user_id
	 * @param $object_id
	 * @param $object_type
	 * @param $category_privacy
	 */
	public function buddypress_posting_on_bookmark( $bookmark_id, $user_id, $object_id, $object_type, $category_privacy = 1 ) {
		$settings_api = $this->settings_api;

		//$enable_buddypress_posting = intval($settings_api->get_option('enable_buddypress_posting', 'cbxwpbookmark_proaddon', 0));
		$enable_buddypress_posting = intval( $settings_api->get_option( 'enable_buddypress_posting', 'cbxwpbookmark_buddypress', 0 ) );

		//$buddypress_posting_types = $settings_api->get_option('buddypress_posting_types', 'cbxwpbookmark_proaddon', array( 'post', 'page' ));
		$buddypress_posting_types = $settings_api->get_option( 'buddypress_posting_types', 'cbxwpbookmark_buddypress', array(
			'post',
			'page'
		) );
		$buddyalert_bookmark      = intval( get_user_meta( $user_id, '_cbxwpbookmark_buddyalert_bookmark', true ) );

		//$enable_buddypress_notify = intval($settings_api->get_option('enable_buddypress_notify', 'cbxwpbookmark_proaddon', 0));
		$enable_buddypress_notify = intval( $settings_api->get_option( 'enable_buddypress_notify', 'cbxwpbookmark_buddypress', 0 ) );


		$post_type_allow = in_array( $object_type, $buddypress_posting_types );

		//buddypress user timeline posting
		if ( $post_type_allow && $category_privacy && $enable_buddypress_posting && function_exists( 'bp_is_active' ) && bp_is_active( 'activity' ) && $buddyalert_bookmark == 0 ) {
			$buddy_post = array(
				'id'                => false,
				// Pass an existing activity ID to update an existing entry.
				'action'            => sprintf( __( '%s has bookmarked <a target="_blank" href = "%s">%s</a>',
					'cbxwpbookmarkaddon' ), bp_core_get_userlink( bp_loggedin_user_id() ), esc_url( get_permalink( $object_id ) ),
					esc_attr( get_the_title( $object_id ) ) ),
				// The activity action - e.g. "Jon Doe posted an update"
				'content'           => apply_filters( 'cbxwpbookmark_bookmark_added_bp_content', __( '<blockquote>I found this content interesting and bookmarked</blockquote>', 'cbxwpbookmarkaddon' ) ),
				//'content'           =>  '',
				'component'         => 'cbxwpbookmark',
				// The name/ID of the component e.g. groups, profile, mycomponent
				'type'              => 'cbxwpbookmark_bookmark_added',
				// The activity type e.g. activity_update, profile_updated
				'primary_link'      => '',
				// Optional: The primary URL for this item in RSS feeds (defaults to activity permalink)
				'user_id'           => $user_id,
				// Optional: The user to record the activity for, can be false if this activity is not for a user.
				'item_id'           => $object_id,
				'secondary_item_id' => $bookmark_id,
				'recorded_time'     => bp_core_current_time(),
				// The GMT time that this activity was recorded
				'hide_sitewide'     => false,
				// Should this be hidden on the sitewide activity stream?
				'is_spam'           => false,
				// Is this activity item to be marked as spam?
			);

			bp_activity_add( $buddy_post );
		}


		//buddypress notification
		if ( $enable_buddypress_notify && $category_privacy && ( get_post_type( $bookmark_id ) !== false ) && function_exists( 'bp_is_active' ) && bp_is_active( 'notifications' ) ) {

			$content        = get_post( $object_id );
			$content_author = intval( $content->post_author );

			if ( $content_author != $user_id ) {
				bp_notifications_add_notification( array(
					'user_id'           => $content_author,
					'item_id'           => $object_id,
					'secondary_item_id' => $bookmark_id,
					'component_name'    => 'cbxwpbookmark',
					'component_action'  => 'cbxwpbookmark_bookmark_added',
					'date_notified'     => bp_core_current_time(),
					'is_new'            => 1,
				) );
			}

		}
	}//end buddypress_posting_on_bookmark

	/**
	 * Register new component for bp for bookmark notification
	 *
	 * @param array $component_names
	 *
	 * @return array
	 * Add a custom component for notification.
	 *
	 */
	public function bd_add_custom_notification_component( $component_names = array() ) {
		// Force $component_names to be an array.
		if ( ! is_array( $component_names ) ) {
			$component_names = array();
		}

		// Add 'cbxwpbookmark_bookmark_added' component to registered components array.
		array_push( $component_names, 'cbxwpbookmark' );

		// Return component's with 'cbxwpbookmark_bookmark_added' appended.
		return $component_names;
	}//end bd_add_custom_notification_component

	/**
	 * Custom format for BP notification for bookmark added
	 *
	 * @param $action
	 * @param $item_id
	 * @param $total_items
	 * @param string $format
	 *
	 * @return mixed
	 *
	 * Display notification on member notifications list and admin bar.
	 */
	function custom_format_buddypress_notifications( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {
		// New custom notifications.
		if ( 'cbxwpbookmark_bookmark_added' === $action ) {
			//$comment = get_post( $item_id );
			$single_bookmark     = CBXWPBookmarkHelper::singleBookmark( $secondary_item_id );
			$who_bookmarked_id   = intval( $single_bookmark['user_id'] );
			$who_bookmarked_name = CBXWPBookmarkHelper::userDisplayName( $who_bookmarked_id );
            $article_title = get_the_title( $item_id );

			//$custom_title = $who_bookmarked_name . ' bookmarked your article -' . get_the_title( $item_id );
			$custom_title = sprintf(_x('%s bookmarked your article - %s', 'buddypress notification title', 'cbxwpbookmarkaddon'), $who_bookmarked_name, $article_title);
			$custom_link  = get_the_permalink( $item_id );
			//$custom_text  = $who_bookmarked_name . ' bookmarked your article -' . get_the_title( $item_id );
			$custom_text  = sprintf(_x('%s bookmarked your article - %s', 'buddypress notification text', 'cbxwpbookmarkaddon'), $who_bookmarked_name, $article_title);

			// WordPress Toolbar
			if ( 'string' === $format ) {
				$return = apply_filters( 'cbxwpbookmark_bookmark_added_notification', '<a href="' . esc_url( $custom_link ) . '" title="' . esc_attr( $custom_title ) . '">' . esc_html( $custom_text ) . '</a>', $custom_text, $custom_link );

				// Deprecated BuddyBar
			} else {
				$return = apply_filters( 'cbxwpbookmark_bookmark_added_notification', array(
					'text' => $custom_text,
					'link' => $custom_link
				), $custom_link, (int) $total_items, $custom_text, $custom_title );
			}

			return $return;
		}
	}

	/**
	 * Add custom notification filter for bookmark
	 */
	public function bp_nouveau_notifications_init_filters() {
		bp_nouveau_notifications_register_filter(
			array(
				'id'       => 'cbxwpbookmark_bookmark_added',
				'label'    => esc_attr__( 'New Bookmark added', 'cbxwpbookmarkaddon' ),
				'position' => 115,
			)
		);
	}//end bp_nouveau_notifications_init_filters

	/**
	 * Set up the Settings > Profile nav item.
	 *
	 * Loaded in a separate method because the Settings component may not
	 * be loaded in time for BP_XProfile_Component::setup_nav().
	 *
	 * @since 2.1.0
	 */
	public function setup_settings_nav_user_setting() {
		$settings_api = $this->settings_api;
		//$enable_buddypress_posting  = intval($settings_api->get_option('enable_buddypress_posting', 'cbxwpbookmark_proaddon', 0));
		//$enable_buddypress_notify   = intval($settings_api->get_option('enable_buddypress_notify', 'cbxwpbookmark_proaddon', 0));

		$enable_buddypress_posting = intval( $settings_api->get_option( 'enable_buddypress_posting', 'cbxwpbookmark_buddypress', 0 ) );
		$enable_buddypress_notify  = intval( $settings_api->get_option( 'enable_buddypress_notify', 'cbxwpbookmark_buddypress', 0 ) );


		//if buddypress positing or notification is on then enable the bookmark setting
		if ( $enable_buddypress_posting || $enable_buddypress_notify ) {
			global $bp;

			bp_core_new_subnav_item( array(
				'name'                    => esc_html__( 'Bookmark Setting', 'cbxwpbookmarkaddon' ),
				'slug'                    => 'bookmarksetting',
				'position'                => 30,
				'screen_function'         => array( &$this, 'cbxwpbookmark_bp_user_screen_settings' ),
				'show_for_displayed_user' => true,
				'parent_url'              => trailingslashit( $bp->loggedin_user->domain . $bp->slug . "settings" ),
				'parent_slug'             => 'settings',
			) );
		}
	}//end function setup_settings_nav_user_setting

	/**
	 * Load template content
	 */
	public function cbxwpbookmark_bp_user_screen_settings() {
		add_action( 'bp_template_title', array( &$this, 'cbxwpbookmark_bp_user_screen_title' ) );
		add_action( 'bp_template_content', array( &$this, 'cbxwpbookmark_bp_user_screen_content' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );

	}//end function  cbxwpbookmark_bp_user_screen_settings

	/**
	 * BP CBX Poll user setting page title
	 *
	 */
	public function cbxwpbookmark_bp_user_screen_title() {
		echo '<h2 class="screen-heading cbxwpbookmark-settings-screen">' . esc_html__( 'Bookmark Activity Control',
				'cbxwpbookmarkaddon' ) . '</h2>';
		//echo '<p class="bp-help-text cbxwpbookmark-notifications-info">'.esc_html__('On different bookmark activity automatic ','cbxwpbookmarkaddon').'</p>';
	}//end function cbxwpbookmark_bp_user_screen_title

	/**
	 * BP CBX Poll user setting page content
	 */
	public function cbxwpbookmark_bp_user_screen_content() {
		$settings_api = $this->settings_api;
		//$enable_buddypress_posting = intval($settings_api->get_option('enable_buddypress_posting', 'cbxwpbookmark_proaddon', 0));
		//$enable_buddypress_notify = intval($settings_api->get_option('enable_buddypress_notify', 'cbxwpbookmark_proaddon', 0));

		$enable_buddypress_posting = intval( $settings_api->get_option( 'enable_buddypress_posting', 'cbxwpbookmark_buddypress', 0 ) );
		$enable_buddypress_notify  = intval( $settings_api->get_option( 'enable_buddypress_notify', 'cbxwpbookmark_buddypress', 0 ) );


		$user_id              = get_current_user_id();
		$buddyalert_bookmark  = intval( get_user_meta( $user_id, '_cbxwpbookmark_buddyalert_bookmark', true ) );
		$buddynotify_bookmark = intval( get_user_meta( $user_id, '_cbxwpbookmark_buddynotify_bookmark', true ) );


		if ( $enable_buddypress_posting && isset( $_POST['cbxwpbookmark_buddyalert_bookmark'] ) ) {
			check_admin_referer( 'cbxwpbookmark_buddyalert_save_settings', 'cbxwpbookmark_buddyalert_nonce' );
			$buddyalert_bookmark = intval( $_POST['cbxwpbookmark_buddyalert_bookmark'] );
			update_user_meta( $user_id, '_cbxwpbookmark_buddyalert_bookmark', $buddyalert_bookmark );
		}


		if ( $enable_buddypress_notify && isset( $_POST['cbxwpbookmark_buddynotify_bookmark'] ) ) {
			check_admin_referer( 'cbxwpbookmark_buddyalert_save_settings', 'cbxwpbookmark_buddyalert_nonce' );
			$buddynotify_bookmark = intval( $_POST['cbxwpbookmark_buddynotify_bookmark'] );
			update_user_meta( $user_id, '_cbxwpbookmark_buddynotify_bookmark', $buddynotify_bookmark );
		}

		?>
        <form class="standard-form" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
            <table class="notification-settings" id="cbxpoll-notification-settings">
                <thead>
                <tr>
                    <th class="icon">&nbsp;</th>
                    <th class="title"><?php esc_html_e( 'Automatic Activity', 'cbxwpbookmarkaddon' ) ?></th>
                    <th class="yes"><?php esc_html_e( 'Yes', 'cbxwpbookmarkaddon' ) ?></th>
                    <th class="no"><?php esc_html_e( 'No', 'cbxwpbookmarkaddon' ) ?></th>
                </tr>
                </thead>

                <tbody>
				<?php if ( $enable_buddypress_posting ) : ?>
                    <tr id="activity-cbxwpbookmark-settings-activity">
                        <td>&nbsp;</td>
                        <td><?php esc_html_e( 'Enable automatic post on timeline when you bookmark any content', 'cbxwpbookmarkaddon' ); ?></td>
                        <td class="yes">
                            <input type="radio" name="cbxwpbookmark_buddyalert_bookmark"
                                   id="cbxwpbookmark_buddyalert_bookmark_yes"
                                   value="0" <?php checked( $buddyalert_bookmark, 0, true ) ?>/><label
                                    for="cbxwpbookmark_buddyalert_bookmark_yes" class="bp-screen-reader-text"><?php
								/* translators: accessibility text */
								esc_html_e( 'Yes', 'cbxwpbookmarkaddon' );
								?></label></td>
                        <td class="no">
                            <input type="radio" name="cbxwpbookmark_buddyalert_bookmark"
                                   id="cbxwpbookmark_buddyalert_bookmark_no"
                                   value="1" <?php checked( $buddyalert_bookmark, 1, true ) ?>/><label
                                    for="cbxwpbookmark_buddyalert_bookmark_no" class="bp-screen-reader-text"><?php
								/* translators: accessibility text */
								esc_html_e( 'No', 'cbxwpbookmarkaddon' );
								?></label></td>
                    </tr>
				<?php endif; ?>
				<?php if ( $enable_buddypress_posting ) : ?>
                    <tr id="activity-cbxwpbookmark-settings-notify">
                        <td>&nbsp;</td>
                        <td><?php esc_html_e( 'Enable automatic notification when someone bookmarks your content', 'cbxwpbookmarkaddon' ); ?></td>
                        <td class="yes">
                            <input type="radio" name="cbxwpbookmark_buddynotify_bookmark"
                                   id="cbxwpbookmark_buddynotify_bookmark_yes"
                                   value="0" <?php checked( $buddynotify_bookmark, 0, true ) ?>/><label
                                    for="cbxwpbookmark_buddynotify_bookmark_yes"
                                    class="bp-screen-reader-text"><?php esc_html_e( 'Yes', 'cbxwpbookmarkaddon' );
								?></label></td>
                        <td class="no">
                            <input type="radio" name="cbxwpbookmark_buddynotify_bookmark"
                                   id="cbxwpbookmark_buddynotify_bookmark_no"
                                   value="1" <?php checked( $buddynotify_bookmark, 1, true ) ?>/><label
                                    for="cbxwpbookmark_buddynotify_bookmark_no"
                                    class="bp-screen-reader-text"><?php esc_html_e( 'No', 'cbxwpbookmarkaddon' );
								?></label></td>
                    </tr>
				<?php endif; ?>
                </tbody>
            </table>


            <input type="submit" value="<?php esc_html_e( 'Save Changes', 'cbxwpbookmarkaddon' ); ?>"/>
			<?php wp_nonce_field( 'cbxwpbookmark_buddyalert_save_settings', 'cbxwpbookmark_buddyalert_nonce' ); ?>
        </form>
		<?php
	}//end function cbxwpbookmark_bp_user_screen_content

	/**
	 * Integration with post grid plugin https://wordpress.org/plugins/the-post-grid/
	 */
	public function post_grid_loop_integration( $args ) {
		$post_id            = intval( $args['post_id'] );
		$setting            = $this->settings_api;
		$thepostgrid_enable = intval( $setting->get_option( 'thepostgrid_enable', 'cbxwpbookmark_gridplugins', 0 ) );
		if ( $thepostgrid_enable ) {
			echo do_shortcode( '[cbxwpbookmarkbtn object_id="' . $post_id . '"]' );
		}
	}//end post_grid_loop_integration

	//$cat_create_role = $setting->get_option( 'cat_create_role', 'cbxwpbookmark_proaddon', $default_roles );

	/**
     * Disable bbpress bookmark to show cbx bookmarks only
     *
	 * @param $retval
	 * @param $r
	 * @param $args
	 *
	 * @return mixed
	 */
	public function bbp_get_topic_favorite_link_disable($retval, $r, $args){
		$setting            = $this->settings_api;

		$disable_bbpress_fav = intval( $setting->get_option( 'disable_bbpress_fav', 'cbxwpbookmark_bbpress', 0 ) );

		if ( $disable_bbpress_fav ) {
		    return '';
		}
        return $retval;
	}//end bbp_get_topic_favorite_link_disable

}//end class CBXWpbookmarkaddon

if ( ! function_exists( 'cbxbookmark_postgrid_html' ) ) {
	function cbxbookmark_postgrid_html( $instance, $echo = false ) {

		global $wpdb;
		$object_types                = CBXWPBookmarkHelper::object_types( true ); //get plain post type as array
		$cbxwpbookmrak_table         = $wpdb->prefix . 'cbxwpbookmark';
		$cbxwpbookmak_category_table = $wpdb->prefix . 'cbxwpbookmarkcat';

		$setting       = new CBXWPBookmark_Settings_API();
		$bookmark_mode = $setting->get_option( 'bookmark_mode', 'cbxwpbookmark_basics', 'user_cat' );


		//max cat limit override
		/*$pro_grid_thumb_size = $setting->get_option( 'pro_grid_thumb_size', 'cbxwpbookmark_proaddon', 'medium' );
			if ( $pro_grid_thumb_size == '' ) {
				$pro_grid_thumb_size = 'medium';
			}*/


		$limit   = isset( $instance['limit'] ) ? intval( $instance['limit'] ) : 10;
		$orderby = isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : 'id';
		$order   = isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 'desc';
		$type    = isset( $instance['type'] ) ? wp_unslash( $instance['type'] ) : array(); //object type(post types), multiple as array

		//old format compatibility
		if ( is_string( $type ) ) {
			$type = explode( ',', $type );
		}

		$type = array_filter( $type );


		$offset = isset( $instance['offset'] ) ? intval( $instance['offset'] ) : 0;

		//$catid       = isset( $instance['catid'] ) ? intval( $instance['catid'] ) : 0;
		$catid = isset( $instance['catid'] ) ? wp_unslash( $instance['catid'] ) : array();
		if ( $catid == 0 ) {
			$catid = '';
		}//compatibility with previous shortcode default values
		if ( is_string( $catid ) ) {
			$catid = explode( ',', $catid );
		}
		$catid = array_filter( $catid );


		$allowdelete = isset( $instance['allowdelete'] ) ? intval( $instance['allowdelete'] ) : 0;
		$show_thumb  = isset( $instance['show_thumb'] ) ? intval( $instance['show_thumb'] ) : 1; //show thumbnail


		$userid_attr = isset( $instance['userid'] ) ? intval( $instance['userid'] ) : 0;

		//$userid = 0;

		//if ( $userid_attr == 0 ) {
		//	$userid = get_current_user_id(); //get current logged in user id
		//} else {
		$userid = absint( $userid_attr );
		//}

		$privacy = 2; //all

		if ( $userid == 0 || ( $userid != get_current_user_id() ) ) {
			$allowdelete = 0;
			$privacy     = 1;

			$instance['allowdelete'] = $allowdelete;
			$instance['privacy']     = $privacy;
			$instance['userid']      = $userid;
		}

		ob_start();

		$main_sql             = '';
		$cat_sql              = '';
		$category_privacy_sql = '';
		$type_sql             = '';

		if ( is_array( $catid ) && sizeof( $catid ) > 0 && ( $bookmark_mode != 'no_cat' ) ) {
			//$cat_sql .= $wpdb->prepare( ' AND cat_id = %d ', $catid );
			$cats_ids_str = implode( ', ', $catid );
			$cat_sql      .= " AND cat_id IN ($cats_ids_str) ";
		}

		//get cats
		$cats = array();
		if ( $bookmark_mode == 'user_cat' ) {
			// Executing Query
			if ( $privacy != 2 ) {
				$cats = $wpdb->get_results( $wpdb->prepare( "SELECT *  FROM  $cbxwpbookmak_category_table WHERE privacy = %d", $privacy ), ARRAY_A );

			} else {
				$cats = $wpdb->get_results( "SELECT *  FROM  $cbxwpbookmak_category_table WHERE 1", ARRAY_A );
			}

			//category privacy sql only needed for user_cat mode
			$cats_ids = array();
			if ( is_array( $cats ) && sizeof( $cats ) > 0 ) {
				foreach ( $cats as $cat ) {
					$cats_ids[] = intval( $cat['id'] );
				}
				$cats_ids_str         = implode( ', ', $cats_ids );
				$category_privacy_sql .= " AND cat_id IN ($cats_ids_str) ";
			}
		} else if ( $bookmark_mode == 'global_cat' ) {
			// Executing Query
			$cats = $wpdb->get_results( "SELECT *  FROM  $cbxwpbookmak_category_table WHERE 1", ARRAY_A );
		}


		//used for category title
		$cats_arr = array();
		if ( is_array( $cats ) && sizeof( $cats ) > 0 ) {
			foreach ( $cats as $cat ) {
				$cats_arr[ intval( $cat['id'] ) ] = $cat;
			}
		}

		$join = '';

		if ( $orderby == 'title' ) {

			$posts_table = $wpdb->prefix . 'posts'; //core posts table
			$join        .= " LEFT JOIN $posts_table posts ON posts.ID = bookmarks.object_id ";

			$orderby = 'posts.post_title';
		}

		if ( sizeof( $type ) == 0 ) {
			$param    = array( $userid, $offset, $limit );
			$main_sql .= "SELECT *  FROM $cbxwpbookmrak_table AS bookmarks $join WHERE user_id = %d $cat_sql $category_privacy_sql group by object_id  ORDER BY $orderby $order LIMIT %d, %d";
		} else {
			$type_sql .= " AND object_type IN ('" . implode( "','", $type ) . "') ";

			$param    = array( $userid, $offset, $limit );
			$main_sql .= "SELECT *  FROM $cbxwpbookmrak_table AS bookmarks $join WHERE user_id = %d $type_sql $cat_sql $category_privacy_sql group by object_id   ORDER BY $orderby $order LIMIT %d, %d";
		}


		$items = $wpdb->get_results( $wpdb->prepare( $main_sql, $param ) );

		if ( $items === null || sizeof( $items ) > 0 ) {

			foreach ( $items as $item ) {
				$delete_html = ( $allowdelete ) ? '<span data-busy="0" target="_blank" class="cbxbookmark-delete-btn cbxbookmark-post-delete" data-bookmark_id="' . $item->id . '" data-object_id="' . $item->object_id . '" data-object_type="' . $item->object_type . '"></span></a>' : '';
				$cat_title   = isset( $cats_arr[ $item->cat_id ] ) ? '<span class="cbxbookmark_card_cat">#' . esc_attr( $cats_arr[ $item->cat_id ]['cat_name'] ) . '</span>' : '';

				if ( in_array( $item->object_type, $object_types ) ) {
					echo cbxwpbookmarkpro_get_template_html( 'bookmarkgrid/single.php', array(
						'setting'     => $setting,
						'item'        => $item,
						'instance'    => $instance,
						'cat_title'   => $cat_title,
						'delete_html' => $delete_html,
					) );

				} else {
					echo cbxwpbookmarkpro_get_template_html( 'bookmarkgrid/single-othertype.php', array(
						'setting'     => $setting,
						'item'        => $item,
						'instance'    => $instance,
						'cat_title'   => $cat_title,
						'delete_html' => $delete_html
					) );
				}
			}
		} else {
			echo cbxwpbookmarkpro_get_template_html( 'bookmarkgrid/single-notfound.php', array() );
		}


		?>
		<?php

		$output = ob_get_clean();


		if ( $echo ) {
			echo '<div class="bootstrap-wrapper cbxbookmark_cards_wrapper cbxbookmark_cards_wrapper_postgrid"><div class="row cbxbookmark_card_wrap">' . $output . '<div class="cbxbookmark_card_clear"></div></div></div>';
		} else {
			return $output;
		}
	}//end cbxbookmark_postgrid_html
}

if ( ! function_exists( 'cbxbookmark_mostgrid_html' ) ) {
	/**
	 * bookmark post most grid
	 *
	 * @param      $instance
	 * @param bool $echo
	 *
	 * @return false|string
	 */
	function cbxbookmark_mostgrid_html( $instance, $echo = false ) {

		global $wpdb;
		$object_types        = CBXWPBookmarkHelper::object_types( true ); //get plain post type as array
		$cbxwpbookmrak_table = $wpdb->prefix . 'cbxwpbookmark';
		//$cbxwpbookmak_category_table = $wpdb->prefix . 'cbxwpbookmarkcat';

		$setting = new CBXWPBookmark_Settings_API();


		//max cat limit override
		$pro_grid_thumb_size = $setting->get_option( 'pro_grid_thumb_size', 'cbxwpbookmark_proaddon', 'medium' );
		if ( $pro_grid_thumb_size == '' ) {
			$pro_grid_thumb_size = 'medium';
		}

		$limit   = isset( $instance['limit'] ) ? intval( $instance['limit'] ) : 10;
		$orderby = isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : 'id';
		$order   = isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 'DESC';
		$type    = isset( $instance['type'] ) ? wp_unslash( $instance['type'] ) : array(); //object type(post types), multiple as array

		//old format compatibility
		if ( is_string( $type ) ) {
			$type = explode( ',', $type );
		}

		$type = array_filter( $type );


		$offset     = isset( $instance['offset'] ) ? intval( $instance['offset'] ) : 0;
		$daytime    = isset( $instance['daytime'] ) ? intval( $instance['daytime'] ) : 0;
		$show_count = isset( $instance['show_count'] ) ? intval( $instance['show_count'] ) : 1;
		$show_thumb = isset( $instance['show_thumb'] ) ? intval( $instance['show_thumb'] ) : 1; //show thumbnail

		ob_start();

		$where_sql = '';
		$daytime   = (int) $daytime;

		$datetime_sql = "";
		if ( $daytime != '0' || ! empty( $daytime ) ) {
			$time         = date( 'Y-m-d H:i:s', strtotime( '-' . $daytime . ' day' ) );
			$datetime_sql = " created_date > '$time' ";

			$where_sql .= ( ( $where_sql != '' ) ? ' AND ' : '' ) . $datetime_sql;
		}

		if ( sizeof( $type ) > 0 ) {
			$type_sql  = " object_type IN ('" . implode( "','", $type ) . "') ";
			$where_sql .= ( ( $where_sql != '' ) ? ' AND ' : '' ) . $type_sql;
		}

		if ( $where_sql == '' ) {
			$where_sql = '1';
		}

		$param = array( $offset, $limit );

		if ( $orderby == 'object_count' ) {
			$sql = "SELECT count(object_id) as totalobject, object_id, object_type FROM  $cbxwpbookmrak_table WHERE $where_sql group by object_id order by totalobject $order LIMIT  %d, %d";
		} else {

			$join = '';

			if ( $orderby == 'title' ) {

				$posts_table = $wpdb->prefix . 'posts'; //core posts table
				$join        .= " LEFT JOIN $posts_table posts ON posts.ID = bookmarks.object_id ";

				$orderby = 'posts.post_title';
			}

			$sql = "SELECT count(object_id) as totalobject, object_id, object_type FROM  $cbxwpbookmrak_table AS bookmarks $join  WHERE $where_sql group by object_id order by $orderby $order, totalobject $order LIMIT  %d, %d";
		}


		$items = $wpdb->get_results(
			$wpdb->prepare( $sql, $param )
		);


		if ( $items === null || sizeof( $items ) > 0 ) {

			foreach ( $items as $item ) {
				$show_count_html = ( $show_count == 1 ) ? '<i>(' . intval( $item->totalobject ) . ')</i>' : "";

				if ( in_array( $item->object_type, $object_types ) ) {
					echo cbxwpbookmarkpro_get_template_html( 'bookmarkgridmost/single.php', array(
						'setting'         => $setting,
						'item'            => $item,
						'instance'        => $instance,
						'show_count_html' => $show_count_html
					) );

				} else {

					echo cbxwpbookmarkpro_get_template_html( 'bookmarkgridmost/single-othertype.php', array(
						'setting'         => $setting,
						'item'            => $item,
						'instance'        => $instance,
						'show_count_html' => $show_count_html,
					) );
				}
			}
		} else {
			echo cbxwpbookmarkpro_get_template_html( 'bookmarkgridmost/single-notfound.php', array() );
		}

		$output = ob_get_clean();

		if ( $echo ) {
			echo '<div class="bootstrap-wrapper cbxbookmark_cards_wrapper cbxbookmark_cards_wrapper_mostgrid"><div class="row cbxbookmark_card_wrap">' . $output . '<div class="cbxbookmark_card_clear"></div></div></div>';
		} else {
			return $output;
		}
	}//end cbxbookmark_postgrid_html
}


add_action( 'plugins_loaded', 'cbxwpbookmarkaddon_init' );

/**
 * Init cbxbookmark proadon depending on it's parent plugin
 */
function cbxwpbookmarkaddon_init() {
	if ( defined( 'CBXWPBOOKMARK_PLUGIN_NAME' ) ) {
		new CBXWpbookmarkaddon();
	}
}//end function cbxwpbookmarkaddon_init
<?php
/*

Plugin Name: onlineresourceproject

Plugin URI: https://teryk.com/olrp/

Description: Plugin to create custom resource type in wordpress for online resource database, registers a post type.

Version: 1.5

Author: Teryk Morris

Author URI: https://teryk.com

License: GPLv2 or later

Text Domain: teryk
*/

define('__ROOT__', dirname(__FILE__));

require_once(__ROOT__ . '/olrp-import-utils.php');
require_once(__ROOT__ . '/olrp-display-table.php');
require_once(__ROOT__ . '/olrp_taxonomies.php');
require_once(__ROOT__ . '/../cbxwpbookmark/includes/cbxwpbookmark-functions.php');

/* Create our OLRP Manager, constructor registers for init which instatiates the the plugin*/
new olrp_manager();


/* This class does the majority of the work for the plugin, registers callbacks, adds menu items etc. */
class olrp_manager
{
	public $custom_meta; //array for holding meta_data keys
	public $styles; // Array of CSS scripts
	public $scripts; // Array of JS scripts
	public olrp_display $olrp_disp;
	public olrp_data $olrp_data;

	function __construct()
	{
		add_action( 'init', [$this, 'init']);
	}

	/**
	 * Init method for the plugin. Does all the work to register callbacks, add scripts to the header, add menu items etc.
	 */
	public function init()
	{
		$this->olrp_disp = new olrp_display($this);
		$this->olrp_data = new olrp_data($this);

		/* register our taxonomies */
		olrp_resource_register_taxonomies();

		/* Add items to the admin page and toolbar*/
		add_action( 'admin_menu', array($this->olrp_data,'olrp_create_menu_page'));
		add_action('admin_bar_menu', array($this,'add_toolbar_items'), 100);

		/* Add our scripts and data to the html header*/
		add_action( 'wp_enqueue_scripts', array($this,"enqueue_scripts"));
		add_action('wp_head', array($this,"head_output"));

		/* Adds dropdowns to filter posts by taxonomy in admin bulk edit page - from olrp_taxonomies.php*/
		add_action('restrict_manage_posts', 'olrp_filter_post_type_by_taxonomy');
		add_filter('parse_query', 'olrp_convert_id_to_term_in_query');

		/* Modify the title in the blog header but not in the footer */
		add_filter('the_title',[$this->olrp_disp,'olrp_modify_title']);
		add_action('get_footer',[$this,'olrp_unhook_title']);

		/* Save our metadata when the post is saved*/
		add_action( 'save_post_olrp_resource', array($this,"save_events_meta"),1,2);

		//add_filter('bloginfo', array($olrp_m,"bloginfo_styling"),10,2);

		/*Shortcodes to display the index table and the individual resources */
		add_shortcode('olrp_display_table',array($this->olrp_disp,'olrp_display_table'));
		add_shortcode('olrp_display_resource',array($this->olrp_disp,'olrp_display_resource'));

		/* Hacks */
		/* Fix search so our custom post type shows up in the main search */
		add_filter( 'pre_get_posts', [$this,'fix_search'] );

		/* Insert olrp_display_resource shortcode into all posts, should really do this in save_post but
		then I would have to go and save all the already created posts*/
		add_filter('the_content',[$this->olrp_disp,'olrp_insert_content']);


		/** Custom Metadata Types
		 * uses an ordered array to control the order that forms are
		 * created in edit/create dialog
		 * */
		$this->custom_meta = array(
			array('URL' => 'olrp-resource-url'),
			array('Summary' => 'olrp-resource-summary'),
			array('Comments' => 'olrp-resource-comments'),
		/* Not added as metadata, just here for header error checking */
			array('Title' => Null), //built in property
			array('Tags' => Null),  //built in property
			array('Creator' => Null), //custom taxonomy
			array('Collection',Null), //custom taxonomy
		//	array('Resource_List', Null),			//custom taxonomy
			array('Licensing', Null)			//custom taxonomy
	);


		/* Arguments and $labels for register_post_type */
		$labels = array(
			'name'                  => _x( 'OLRP Resources', 'Post type general name', 'olrp_resource' ),
			'singular_name'         => _x( 'OLRP Resource', 'Post type singular name', 'olrp_resource' ),
			'menu_name'             => _x( 'OLRP Resources', 'Admin Menu text', 'olrp_resource' ),
			'name_admin_bar'        => _x( 'OLRP Resource', 'Add New on Toolbar', 'olrp_resource' ),
			'add_new'               => __( 'Add New', 'olrp_resource' ),
			'add_new_item'          => __( 'Add New resource', 'olrp_resource' ),
			'new_item'              => __( 'New resource', 'olrp_resource' ),
			'edit_item'             => __( 'Edit resource', 'olrp_resource' ),
			'view_item'             => __( 'View resource', 'olrp_resource' ),
			'all_items'             => __( 'All resources', 'olrp_resource' ),
			'search_items'          => __( 'Search resources', 'olrp_resource' ),
			'parent_item_colon'     => __( 'Parent resources:', 'olrp_resource' ),
			'not_found'             => __( 'No resources found.', 'olrp_resource' ),
			'not_found_in_trash'    => __( 'No resources found in Trash.', 'olrp_resource' ),
			'featured_image'        => _x( 'Resource Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'olrp_resource' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'olrp_resource' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'olrp_resource' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'olrp_resource' ),
			'archives'              => _x( 'Resource archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'olrp_resource' ),
			'insert_into_item'      => _x( 'Insert into resource', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'olrp_resource' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this resource', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'olrp_resource' ),
			'filter_items_list'     => _x( 'Filter resources list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'olrp_resource' ),
			'items_list_navigation' => _x( 'Resources list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'olrp_resource' ),
			'items_list'            => _x( 'Resources list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'olrp_resource' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => 'OLRP Resource custom post type.',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'olrp' ),
			'capability_type'    => 'post',
			'map_meta_cap'		 => true,
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail','custom-fields','comments','revisions' ),
			'taxonomies'         => array( 'post_tag' ),
			'show_in_rest'       => true,
			'register_meta_box_cb'  => array($this,'add_post_meta_boxes')
		);
		register_post_type( 'olrp_resource', $args );

		$this->add_frontend_scripts();
		$this->register_scripts();

	}

	/**
	 * Splits up the blog info (CTE - Online Learning Resource Project) so that each word can be styled individually
	 * @param $text
	 * @param $show
	 *
	 *
	 *
	 * @return string
	 */
	public function bloginfo_styling($text,$show)
	{
		if ($show == 'description')
		{
			$words = explode(' ',$text);
			$text = "";
			$n = 0;
			foreach ($words as $word){
				$text .= "<span id=\"header_word_$n\"> $word </span>";
				$n++;
			}
		}
		return $text;
	}

	/**
	 * Outputs the Google Font links into the header so we can use fancy fonts
	 */
	public function head_output()
	{
		?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<?php
	}

	/**
	 * Removes the Title Hook so that we don't turnit into a url in the footer
	 */
	public function olrp_unhook_title()
	{
		remove_filter('the_title',[$this->olrp_disp,'olrp_modify_title']);
	}

	/**
	 * Fixes the main search so that our custom posts are returned
	 */
	public function fix_search($query)
	{
		if ( $query->is_main_query() && ! is_admin() ) {
			if(! isset($query->query_vars['page_id']) || $query->query_vars['page_id'] == '' || $query->query_vars['page_id'] == 0) {
				$query->set( 'post_type', array( 'olrp_resource', 'post' ) );
			}
		}

		return $query;
	}

	/**
	 * Add the My Resource List Menu Item to the Admin header
	 */
	function add_toolbar_items($admin_bar) {

		$url = cbxwpbookmarks_mybookmark_page_url();
		$admin_bar->add_menu( array(
			'id'    => 'my-resource-lists',
			'title' => 'My Resource Lists',
			'href'  => $url,
			'meta'  => array(
				'title' => __( 'My Resource Lists' ),
			),
		) );
	}
	/**
	 * Turns the ordered custom_meta array into an associative array
	 */
	public function get_meta($flipped = false)
	{
		$meta =array();
		foreach($this->custom_meta as $index => $keyVal){
			if($flipped ){
				if(current($keyVal)){
					$meta[current($keyVal)] = key($keyVal);
				}
			}else {
				$meta[key($keyVal)] = current($keyVal);
			}
		}
		return $meta;
	}

	/**
	 * Loads the header scripts
	 */
	public function add_frontend_scripts () {
		$this->styles = array(
			'jquery-datatables'       => array(
				'src' => 'https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css'
			),
			'datatables-buttons'      => array(
				'src' => 'https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css'
			),
			'datatables-select'       => array(
				'src' => 'https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css'
			),
			'datatables-fixedheader'  => array(
				'src' => 'https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css'
			),
			'datatables-fixedcolumns' => array(
				'src' => 'https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css'
			),
			'datatables-responsive'   => array(
				'src' => 'https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css'
			),
			'google_font_noto'   => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Noto+Sans+Mono:wght@400;500&display=swap'
			)
		);

		$this->scripts = array(
			'jquery-datatables'         => array(
				'src'  => 'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js',
				'deps' => array( 'jquery' )
			),
			'datatables-buttons'        => array(
				'src'  => 'https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js',
				'deps' => array( 'jquery-datatables' )
			),
			'datatables-buttons-colvis' => array(
				'src'  => '//cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js',
				'deps' => array( 'datatables-buttons' )
			),
			'datatables-buttons-print'  => array(
				'src'  => '//cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js',
				'deps' => array( 'datatables-buttons' )
			),
			// PDFMake (required for DataTables' PDF buttons)
			'pdfmake'                   => array(
				'src'  => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js',
				'deps' => array( 'datatables-buttons' )
			),
			'pdfmake-fonts'             => array(
				'src'  => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js',
				'deps' => array( 'pdfmake' )
			),
			// JSZip (required for DataTables' Excel button)
			'jszip'                     => array(
				'src'  => '//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
				'deps' => array( 'datatables-buttons' )
			),
			'datatables-buttons-html5'  => array(
				'src'  => '//cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js',
				'deps' => array( 'datatables-buttons' )
			),
			'datatables-select'         => array(
				'src'  => 'https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js',
				'deps' => array( 'jquery-datatables' )
			),
			'datatables-fixedheader'    => array(
				'src'  => 'https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js',
				'deps' => array( 'jquery-datatables' )
			),
			'datatables-fixedcolumns'   => array(
				'src'  => 'https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js',
				'deps' => array( 'jquery-datatables' )
			),
			'datatables-responsive'     => array(
				'src'  => 'https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js',
				'deps' => array( 'jquery-datatables' )
			),
			'olrp-js' => array(
				'src' => plugins_url( 'olrp_datatable.js', __FILE__ ),
				'deps' => array( 'jquery-datatables' )
		)

		);
	}

	/**
	 * Registers the header scripts with Wordpress
	 */
	public function register_scripts()
	{
		foreach ( $this->scripts as $handle => $script ) {
		wp_register_script(
			$handle,
			$script['src'],
			( isset( $script['deps'] ) ) ? $script['deps'] : array(),
			null,
			false);
		}

		foreach ( $this->styles as $handle => $style ) {
		wp_register_style(
			$handle,
			$style['src']);
		}
	}

	/**
	 * Tells Wordpress about our header scripts. Allows it to do some checks for duplicates.
	 */
	public function enqueue_scripts()
	{
		foreach ( $this->scripts as $handle => $script ) {
		wp_enqueue_script($handle);
		}

		foreach ( $this->styles as $handle => $style ) {
		wp_enqueue_style($handle);
		}

	}


	/**
	 * Callback to add the metaboxes, registered in init with register_post_type()
	 */
	public function add_post_meta_boxes($post) {

		foreach ($this->custom_meta as $index => $keyval) {
			$key   = key( $keyval );
			$value = current( $keyval );

			/*error_log("add_metabox -- " . $key . "," . $value);
			flush();
			*/
			if ( $value != null ) {
				add_meta_box(
					$value,      // Unique ID
					esc_html__( $key, 'teryk' ),    // Title
					array($this,'resource_meta_callback'),   // Callback function
					'olrp_resource',         // Admin page (or post type)
					'normal',         // Context
					'default',         // Priority
					$value,
				);
			}

		}
	}


	/**
	 * Callback to add the metaboxes, registered in init with register_post_type()
	 * @param $post
	 * @param $args
	 */
	public function resource_meta_callback( $post,$args )
	{
		/* TERYK TODO: Figure out nonce security */
		//wp_nonce_field( basename( __FILE__ ), 'olrp_resource_title_meta_box' );

		$val = $args['args'];
		?>
		<p>
			<?php /*<label for="olrp-resource-title"><?php _e( "Give this resource a title", 'teryk' ); ?></label>
		<br />
	*/?>
			<input class="widefat" type="text" name="<?php echo($val)?>" id="<?php echo($val)?>" value="<?php echo esc_attr( get_post_meta( $post->ID, $val, true ) ); ?>" size="30" />
		</p>

		<?php
	}

	/* Event kicked off when saving a post, updates metadata */

	/**
	 * Save Metadata on Post Save
	 *
	 *  Saves the metadata associated with the post on save. We have to use the $_POST global because the
	 *  metadata is not stored in the WP_Post object.
	 *
	 * 	 @param int Post ID
	 *   $@param WP_Post Post being saved
	 *
	 * @return int Post ID
	 **/
	public function save_events_meta( $post_id, $post ):int
	{
		// Return if the user doesn't have edit permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if (count($_POST))/*skip empty posts*/ {
			// Don't store custom data twice
			if ('revision' === $post->post_type) {
				return $post_id;
			}
			/*Look through the $_POST for our metakeys and save */
			foreach ($this->get_meta(false) as $key)
			{
				if (key_exists($key, $_POST)) {
					$value   = $_POST[ $key ];
					$post_id = $this->add_update_delete_post_meta( $post_id, $key, $value );

				}
			}
		}
		return $post_id;
	}

	/**
	 * Creates, updates or deletes metadata for a post
	 * @param $post_id
	 * @param $key
	 * @param $value
	 *
	 * @return mixed
	 */
	public function add_update_delete_post_meta($post_id, $key, $value)
	{
		if ( get_post_meta( $post_id, $key, false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, $key, $value );
		} else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, $key, $value);
		}
		if ( ! $value ) {
			// Delete the meta key if there's no value
			delete_post_meta( $post_id, $key );
		}
		return $post_id;
	}
}//olrp_manager



?>

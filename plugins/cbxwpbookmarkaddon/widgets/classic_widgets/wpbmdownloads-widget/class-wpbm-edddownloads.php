<?php

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Most Bookmarked downloads (Easy digital downloads)
 *
 * Class WPBM_Downloads
 */
class WPBM_Downloads extends WP_Widget {

	/**
	 *
	 * Unique identifier for your widget.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * widget file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $widget_slug = 'cbxwpbmmostdownload-widget';


	/**
	 * Constructor
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {
		parent::__construct(
			$this->get_widget_slug(), esc_html__( 'CBX Most Bookmarked Downloads List', "cbxwpbookmarkaddon" ), array(
				'classname'   => 'cbxwpbookmark-mostlist-wrap cbxwpbookmark-mostlist-wrap-downloads cbxwpbookmark-mostlist-wrap-widget ' . $this->get_widget_slug() . '-class',
				'description' => esc_html__( 'This widget shows most bookmarked downloads within specific time limit.', "cbxwpbookmarkaddon" )
			)
		);

		//Refreshing the widget's cached output with each new post
		//add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'save_post_download', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		//add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}// end constructor

	/**
	 * Return the widget slug.
	 *
	 * @return    Plugin slug variable.
	 * @since    1.0.0
	 *
	 */
	public function get_widget_slug() {
		return $this->widget_slug;
	}


	/**
	 * Outputs the content of the widget.
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @return int|void
	 */
	public function widget( $args, $instance ) {


		// Check if there is a cached output
		$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			return print $cache[ $args['widget_id'] ];
		}

		// go on with your widget logic, put everything into a string and …

		extract( $args, EXTR_SKIP );

		$widget_string = $before_widget;

		// Title
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? esc_html__( 'Most Bookmarked Downloads', 'cbxwpbookmarkaddon' ) : $instance['title'], $instance, $this->id_base );


		// Defining Title of Widget
		if ( $title ) {
			$widget_string .= $args['before_title'] . $title . $args['after_title'];
		} else {
			$widget_string .= $args['before_title'] . $args['after_title'];
		}


		wp_enqueue_style( 'cbxwpbookmarkpublic-css' );

		$instance['title'] = '';
		$widget_string     .= cbxwpbookmarkpro_get_template_html( 'widgets/wpbmdownloads-widget.php', array( 'instance' => $instance, 'ref' => $this ) );

		$widget_string .= $after_widget;

		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

		print $widget_string;
	}//end widget

	public function flush_widget_cache() {
		wp_cache_delete( $this->get_widget_slug(), 'widget' );
	}//end flush_widget_cache

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array|mixed
	 */
	public function update( $new_instance, $old_instance ) {
		$instance['title']   = isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['daytime'] = isset( $new_instance['daytime'] ) ? absint( $new_instance['daytime'] ) : 0;
		$instance['order']   = isset( $new_instance['order'] ) ? sanitize_text_field( $new_instance['order'] ) : 'DESC';
		$instance['orderby'] = isset( $new_instance['orderby'] ) ? sanitize_text_field( $new_instance['orderby'] ) : 'object_count'; //id, object_id, object_type

		$type = isset( $new_instance['type'] ) ? wp_unslash( $new_instance['type'] ) : array();  //object type: post, page, custom any post type or custom object type  ->  can be introduced in future
		if ( is_string( $type ) ) {
			$type = explode( ',', $type );
		}

		$type             = array_filter( $type );
		$instance['type'] = $type;

		$instance['limit']        = isset( $new_instance['limit'] ) ? absint( $new_instance['limit'] ) : 10;
		$instance['show_count']   = isset( $new_instance['show_count'] ) ? absint( $new_instance['show_count'] ) : 1;
		$instance['show_thumb']   = isset( $new_instance['show_thumb'] ) ? absint( $new_instance['show_thumb'] ) : 1;
		$instance['show_price']   = isset( $new_instance['show_price'] ) ? absint( $new_instance['show_price'] ) : 1;
		$instance['show_addcart'] = isset( $new_instance['show_addcart'] ) ? absint( $new_instance['show_addcart'] ) : 1;

		return $instance;
	}//end update

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'        => esc_html__( 'Most Bookmarked Downloads', 'cbxwpbookmarkaddon' ),
				'limit'        => 10,
				'daytime'      => '0',
				'order'        => 'DESC',
				'orderby'      => 'object_count', //id, object_id, object_count
				'show_count'   => 1,
				'show_thumb'   => 1,
				'show_price'   => 1,
				'show_addcart' => 1
			)
		);


		$title        = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$limit        = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 10;
		$daytime      = isset( $instance['daytime'] ) ? absint( $instance['daytime'] ) : 0;
		$order        = isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 'DESC';             //desc, asc
		$orderby      = isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : 'object_count'; //id, object_id, object_type, object_count
		$show_count   = isset( $instance['show_count'] ) ? absint( $instance['show_count'] ) : 1;
		$show_thumb   = isset( $instance['show_thumb'] ) ? absint( $instance['show_thumb'] ) : 1;
		$show_price   = isset( $instance['show_price'] ) ? absint( $instance['show_price'] ) : 1;
		$show_addcart = isset( $instance['show_addcart'] ) ? absint( $instance['show_addcart'] ) : 1;


		// Display the admin form
		include( plugin_dir_path( __FILE__ ) . 'views/admin.php' );
	}//end form
}//end class WPBM_Downloads
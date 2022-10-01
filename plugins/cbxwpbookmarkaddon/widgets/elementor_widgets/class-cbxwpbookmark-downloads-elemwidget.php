<?php

	namespace CBXWPBookmark_ElemWidget\Widgets;

	use Elementor\Widget_Base;
	use Elementor\Controls_Manager;

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}

	/**
	 * Most bookmarked downloads(Easy Digital Downloads) Elementor Widget
	 */
	class CBXWPBookmarkDownloads_ElemWidget extends \Elementor\Widget_Base {

		/**
		 * Widget name.
		 *
		 * @return string Widget name.
		 * @since  1.0.0
		 * @access public
		 *
		 */
		public function get_name() {
			return 'cbxwpbookmarkdownloads';
		}

		/**
		 * Widget title.
		 *
		 * @return string Widget title.
		 * @since  1.0.0
		 * @access public
		 *
		 */
		public function get_title() {
			return esc_html__( 'CBX Most Bookmarked Downloads List', 'cbxwpbookmarkaddon' );
		}

		/**
		 * Get widget categories.
		 *
		 * Retrieve the widget categories.
		 *
		 * @return array Widget categories.
		 * @since  1.0.10
		 * @access public
		 *
		 */
		public function get_categories() {
			return array( 'cbxwpbookmark' );
		}

		/**
		 * Widget icon.
		 *
		 * @return string Widget icon.
		 * @since  1.0.0
		 * @access public
		 *
		 */
		public function get_icon() {
			return 'cbxwpbookmars-most-downloads-icon';
		}

		/**
		 * Register My Bookmark Grid widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		protected function _register_controls() {

			$this->start_controls_section(
				'section_cbxwpbookmarkdownloads',
				array(
					'label' => esc_html__( 'Most Bookmarked Downloads Setting', 'cbxwpbookmarkaddon' ),
				)
			);

			$this->add_control(
				'title',
				array(
					'label'       => esc_html__( 'Title', 'cbxwpbookmarkaddon' ),
					'description' => esc_html__( 'Keep empty to hide', 'cbxwpbookmarkaddon' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'default'     => esc_html__( 'Most Bookmarked Downloads', 'cbxwpbookmarkaddon' ),
				)
			);



			$this->add_control(
				'order',
				array(
					'label'       => esc_html__( 'Display order', 'cbxwpbookmarkaddon' ),
					'type'        => \Elementor\Controls_Manager::SELECT,
					'default'     => 'DESC',
					'placeholder' => esc_html__( 'Select order', 'cbxwpbookmarkaddon' ),
					'options'     => array(
						'ASC'  => esc_html__( 'Ascending', 'cbxwpbookmarkaddon' ),
						'DESC' => esc_html__( 'Descending', 'cbxwpbookmarkaddon' ),
					)
				)
			);

			$this->add_control(
				'orderby',
				array(
					'label'       => esc_html__( 'Display order by', 'cbxwpbookmarkaddon' ),
					'type'        => \Elementor\Controls_Manager::SELECT,
					'default'     => 'object_count',
					'placeholder' => esc_html__( 'Select order by', 'cbxwpbookmarkaddon' ),
					'options' => array(
						'object_count' => esc_html__( 'Bookmark Count', 'cbxwpbookmarkaddon' ),
						'id'           => esc_html__( 'Bookmark id', 'cbxwpbookmarkaddon' ),
						'object_id'    => esc_html__( 'Post ID', 'cbxwpbookmarkaddon' ),
						'object_type'  => esc_html__( 'Post Type', 'cbxwpbookmarkaddon' ),
						'title'        => esc_html__( 'Post Title', 'cbxwpbookmarkaddon' ),
					)
				)
			);

			$this->add_control(
				'limit',
				array(
					'label'   => esc_html__( 'Limit', 'cbxwpbookmarkaddon' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 10,
					'min'     => 1,
					'step'    => 1
				)
			);

			$this->add_control(
				'daytime',
				array(
					'label'         => esc_html__( 'Day(s)', 'cbxwpbookmarkaddon' ),
					'description'   => esc_html__( '0 means all time', 'cbxwpbookmarkaddon' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 0,
					'min'     => 0,
					'step'    => 1
				)
			);

			$this->add_control(
				'show_count',
				array(
					'label'        => esc_html__( 'Show count', 'cbxwpbookmarkaddon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					'label_off'    => esc_html__( 'No', 'cbxwpbookmarkaddon' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);

			$this->add_control(
				'show_thumb',
				array(
					'label'        => esc_html__( 'Show thumbnail', 'cbxwpbookmarkaddon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					'label_off'    => esc_html__( 'No', 'cbxwpbookmarkaddon' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);

			$this->add_control(
				'show_price',
				array(
					'label'        => esc_html__( 'Show price', 'cbxwpbookmarkaddon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					'label_off'    => esc_html__( 'No', 'cbxwpbookmarkaddon' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);

			$this->add_control(
				'show_addcart',
				array(
					'label'        => esc_html__( 'Show cart', 'cbxwpbookmarkaddon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'cbxwpbookmarkaddon' ),
					'label_off'    => esc_html__( 'No', 'cbxwpbookmarkaddon' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);

			$this->end_controls_section();
		}//end method _register_controls


		/**
		 * Convert yes/no to boolean on/off
		 *
		 * @param string $value
		 *
		 * @return string
		 */
		public static function yes_no_to_on_off( $value = '' ) {
			if ( $value === 'yes' ) {
				return 'on';
			}

			return 'off';
		}//end yes_no_to_on_off

		/**
		 * Convert yes/no switch to boolean 1/0
		 *
		 * @param string $value
		 *
		 * @return int
		 */
		public static function yes_no_to_1_0( $value = '' ) {
			if ( $value === 'yes' ) {
				return 1;
			}

			return 0;
		}//end yes_no_to_1_0

		/**
		 * Render My Bookmark Grid widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		protected function render() {
			/*if ( ! class_exists( 'CBXWPBookmark_Settings_API' ) ) {
				require_once plugin_dir_path( dirname(dirname( __FILE__ ) )) . 'includes/class-cbxwpbookmark-setting.php';
			}

			$settings_api = new \CBXWPBookmark_Settings_API();*/

			$settings = $this->get_settings();

			$attr = array();


			$attr['title']        = sanitize_text_field( $settings['title'] );
			$attr['order']        = sanitize_text_field( $settings['order'] );
			$attr['orderby']      = sanitize_text_field( $settings['orderby'] );
			$attr['limit']        = intval( $settings['limit'] );
			$attr['daytime']      = intval( $settings['daytime'] );
			$attr['show_count']   = $this->yes_no_to_1_0( $settings['show_count'] );
			$attr['show_thumb']   = $this->yes_no_to_1_0( $settings['show_thumb'] );
			$attr['show_price']   = $this->yes_no_to_1_0( $settings['show_price'] );
			$attr['show_addcart'] = $this->yes_no_to_1_0( $settings['show_addcart'] );

			$attr = apply_filters( 'cbxwpbookmark_elementor_shortcode_builder_attr', $attr, $settings, 'cbxwpbookmark-mostdownloads' );

			$attr_html = '';

			foreach ( $attr as $key => $value ) {
				$attr_html .= ' ' . $key . '="' . $value . '" ';
			}

			echo do_shortcode( '[cbxwpbookmark-mostdownloads ' . $attr_html . ']' );

		}//end method render

		/**
		 * Render My Bookmark Grid widget output in the editor.
		 *
		 * Written as a Backbone JavaScript template and used to generate the live preview.
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		protected function _content_template() {
		}//end method _content_template
	}//end method CBXWPBookmarkDownloads_ElemWidget

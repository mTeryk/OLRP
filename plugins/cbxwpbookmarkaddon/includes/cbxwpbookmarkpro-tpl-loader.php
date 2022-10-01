<?php
	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	/**
	 * Locate comment template using the core cbxwpbookmark_locate_template     *
	 *
	 * @return string
	 */
	function cbxwpbookmarkpro_locate_template( $template_name ) {
		$default_path = CBXWPBOOKMARKADDON_ROOT_PATH . 'templates/';

		// Return what we found.
		return cbxwpbookmark_locate_template( $template_name, '', $default_path );
	}//end function cbxwpbookmarkpro_locate_template

	/**
	 * Get other templates (e.g. product attributes) passing attributes and including the file.
	 *
	 * @param string $template_name Template name.
	 * @param array  $args          Arguments. (default: array).
	 * @param string $template_path Template path. (default: '').
	 * @param string $default_path  Default path. (default: '').
	 */
	function cbxwpbookmarkpro_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args ); // @codingStandardsIgnoreLine
		}

		$located = cbxwpbookmarkpro_locate_template( $template_name, $template_path, $default_path );

		if ( ! file_exists( $located ) ) {
			/* translators: %s template */
			_doing_it_wrong( __FUNCTION__, sprintf( __( '%s does not exist.', 'cbxwpbookmarkaddon' ), '<code>' . $located . '</code>' ), '1.0.0' );

			return;
		}

		// Allow 3rd party plugin filter template file from their plugin.
		$located = apply_filters( 'cbxwpbookmark_get_template', $located, $template_name, $args, $template_path, $default_path );

		do_action( 'cbxwpbookmark_before_template_part', $template_name, $template_path, $located, $args );

		include $located;

		do_action( 'cbxwpbookmark_after_template_part', $template_name, $template_path, $located, $args );
	}//end cbxwpbookmarkpro_get_template

	/**
	 * Like wc_get_template, but returns the HTML instead of outputting.
	 *
	 * @param string $template_name Template name.
	 * @param array  $args          Arguments. (default: array).
	 * @param string $template_path Template path. (default: '').
	 * @param string $default_path  Default path. (default: '').
	 *
	 * @return string
	 * @since 2.5.0
	 *
	 * @see   wc_get_template
	 */
	function cbxwpbookmarkpro_get_template_html( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		ob_start();
		cbxwpbookmarkpro_get_template( $template_name, $args, $template_path, $default_path );

		return ob_get_clean();
	}//end cbxwpbookmarkpro_get_template_html
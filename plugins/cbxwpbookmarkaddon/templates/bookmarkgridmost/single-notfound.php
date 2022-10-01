<?php
	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	echo '<div class="cbxbookmark-alert cbxbookmark-alert-warning">';
	do_action( 'cbxwpbookmark_bookmarkgridmost_not_found_start' );
	echo esc_html__( 'No bookmark found', 'cbxwpbookmarkaddon' );
	do_action( 'cbxwpbookmark_bookmarkgridmost_not_found_end' );
	echo '</div>';
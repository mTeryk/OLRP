<!-- This file is used to markup the administration form of the widget. -->

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
		<?php esc_html_e( 'Title', "cbxwpbookmarkaddon" ); ?>
	</label>

	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'limit' ); ?>">
		<?php esc_html_e( 'Display Limit:', "cbxwpbookmarkaddon" ); ?>
	</label>

	<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo intval( $limit ); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'daytime' ); ?>"> <?php esc_html_e( 'Select Time Duration', "cbxwpbookmarkaddon" ); ?>
		<select class="widefat" id="<?php echo $this->get_field_id( 'daytime' ); ?>" name="<?php echo $this->get_field_name( 'daytime' ); ?>">
			<option value="0"><?php esc_html_e( '-- All Time --', "cbxwpbookmarkaddon" ); ?></option>
			<option value="1" <?php echo ( $daytime == '1' ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "1 Day", 'cbxwpbookmarkaddon' ); ?>
			</option>
			<option value="7" <?php echo ( $daytime == "7" ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "7 Days", 'cbxwpbookmarkaddon' ); ?>
			</option>
			<option value="30" <?php echo ( $daytime == "30" ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "30 Days", 'cbxwpbookmarkaddon' ); ?>
			</option>
			<option value="180" <?php echo ( $daytime == "180" ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "6 Months", 'cbxwpbookmarkaddon' ); ?>
			</option>
			<option value="365" <?php echo ( $daytime == "365" ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "1 Year", 'cbxwpbookmarkaddon' ); ?>
			</option>
		</select> </label>

</p>
<p>
	<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php esc_html_e( "Order By", "cbxwpbookmarkaddon" ) ?>

		<select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
			<option value="object_count" <?php echo ( $orderby == "object_count" ) ? 'selected="selected"' : ''; ?>> <?php esc_html_e( "Bookmark Count", "cbxwpbookmarkaddon" ) ?> </option>
			<option value="object_id" <?php echo ( $orderby == "object_id" ) ? 'selected="selected"' : ''; ?>> <?php esc_html_e( "Post ID", "cbxwpbookmarkaddon" ) ?>     </option>
			<option value="id" <?php echo ( $orderby == "id" ) ? 'selected="selected"' : ''; ?>> <?php esc_html_e( "Bookmark ID", "cbxwpbookmarkaddon" ) ?>     </option>
			<option value="title" <?php echo ( $orderby == "title" ) ? 'selected="selected"' : ''; ?>> <?php esc_html_e( "Post Title", "cbxwpbookmarkaddon" ) ?>     </option>
		</select> </label>
</p>
<?php
	$order = strtoupper( $order );
?>
<p>
	<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php esc_html_e( "Order", "cbxwpbookmarkaddon" ) ?>

		<select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
			<option value="ASC" <?php echo ( $order == "ASC" ) ? 'selected="selected"' : ''; ?>> <?php esc_html_e( "Asending", "cbxwpbookmarkaddon" ) ?> </option>
			<option value="DESC" <?php echo ( $order == "DESC" ) ? 'selected="selected"' : ''; ?>> <?php esc_html_e( "Desending", "cbxwpbookmarkaddon" ) ?> </option>
		</select> </label>

</p>
<p>
	<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php esc_html_e( "Show Count", "cbxwpbookmarkaddon" ) ?>

		<select class="widefat" id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>">

			<option value="1" <?php echo ( $show_count == "1" ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "Yes", "cbxwpbookmarkaddon" ) ?>
			</option>

			<option value="0" <?php echo ( $show_count == "0" ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "No", "cbxwpbookmarkaddon" ) ?>
			</option>

		</select>

	</label>

</p>
<!-- show thumb -->
<p>
	<label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php esc_html_e( "Show Thumb", "cbxwpbookmarkaddon" ) ?>

		<select class="widefat" id="<?php echo $this->get_field_id( 'show_thumb' ); ?>" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>">

			<option value="1" <?php echo ( $show_thumb == 1 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "Yes", "cbxwpbookmarkaddon" ) ?>
			</option>

			<option value="0" <?php echo ( $show_thumb == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "No", "cbxwpbookmarkaddon" ) ?>
			</option>

		</select>

	</label>

</p>
<!-- show price -->
<p>
	<label for="<?php echo $this->get_field_id( 'show_price' ); ?>"><?php esc_html_e( "Show Price", "cbxwpbookmarkaddon" ) ?>

		<select class="widefat" id="<?php echo $this->get_field_id( 'show_price' ); ?>" name="<?php echo $this->get_field_name( 'show_price' ); ?>">

			<option value="1" <?php echo ( $show_price == 1 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "Yes", "cbxwpbookmarkaddon" ) ?>
			</option>

			<option value="0" <?php echo ( $show_price == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "No", "cbxwpbookmarkaddon" ) ?>
			</option>

		</select>

	</label>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'show_addcart' ); ?>"><?php esc_html_e( "Show Add to Cart", "cbxwpbookmarkaddon" ) ?>

		<select class="widefat" id="<?php echo $this->get_field_id( 'show_addcart' ); ?>" name="<?php echo $this->get_field_name( 'show_addcart' ); ?>">

			<option value="1" <?php echo ( $show_addcart == 1 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "Yes", "cbxwpbookmarkaddon" ) ?>
			</option>

			<option value="0" <?php echo ( $show_addcart == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "No", "cbxwpbookmarkaddon" ) ?>
			</option>

		</select>

	</label>
</p>
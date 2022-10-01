<!-- This file is used to markup the administration form of the widget. -->

<!-- Custom  Title Field -->
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
		<?php esc_html_e( 'Title', 'cbxwpbookmarkaddon' ); ?>
	</label>

	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
		   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'limit' ); ?>">
		<?php esc_html_e( 'Display Limit', 'cbxwpbookmarkaddon' ); ?>
    </label> <input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo absint($limit); ?>" />
</p>
<?php
$order = strtoupper( $order );
?>
<p>
    <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php esc_html_e( 'Order', 'cbxwpbookmarkaddon' ); ?>
        <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
            <option value="ASC" <?php echo ( $order == 'ASC' ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Ascending', 'cbxwpbookmarkaddon' ) ?></option>
            <option value="DESC" <?php echo ( $order == 'DESC' ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Descending', 'cbxwpbookmarkaddon' ) ?></option>
        </select>
    </label>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php esc_html_e( 'Order By', 'cbxwpbookmarkaddon' ); ?>
        <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
            <option value="object_type" <?php echo ( $orderby == 'object_type' ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Post Type', 'cbxwpbookmarkaddon' ) ?></option>
            <option value="object_id" <?php echo ( $orderby == 'object_id' ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Post ID', 'cbxwpbookmarkaddon' ) ?></option>
            <option value="id" <?php echo ( $orderby == 'id' ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Bookmark ID', 'cbxwpbookmarkaddon' ) ?></option>
            <option value="title" <?php echo ( $orderby == 'title' ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Post Title', 'cbxwpbookmarkaddon' ) ?></option>
        </select>
    </label>
</p>
<?php
	$object_types = CBXWPBookmarkHelper::object_types();
?>

<p>
	<label for="<?php echo $this->get_field_id( 'type' ); ?>"> <?php esc_html_e( 'Post Type(s)', 'cbxwpbookmarkaddon' ); ?>

		<select multiple="true" class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>"
				name="<?php echo $this->get_field_name( 'type' ); ?>[]">

			<option value="" <?php echo ( sizeof( $type ) == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( "Select Post Type(s)", 'cbxwpbookmarkaddon' ) ?>
			</option>
			<?php
				if ( isset( $object_types['builtin']['types'] ) ) {
					echo '<optgroup label="' . esc_html__( 'Built-in Post Types', 'cbxwpbookmarkaddon' ) . '">';
					foreach ( $object_types['builtin']['types'] as $key => $name ) {
						$selected = ( $key == $type ) ? ' selected="selected" ' : '';
						echo '<option value="' . $key . '" ' . $selected . ' >' . $name . '</option>';
					}
					echo '</optgroup>';
				}

				if ( isset( $object_types['custom']['types'] ) ) {
					echo '<optgroup label="' . esc_html__( 'Built-in Post Types', 'cbxwpbookmarkaddon' ) . '">';
					foreach ( $object_types['custom']['types'] as $key => $name ) {
						$selected = ( $key == $type ) ? ' selected="selected" ' : '';
						echo '<option value="' . $key . '" ' . $selected . ' >' . $name . '</option>';
					}
					echo '</optgroup>';
				}
			?>
		</select> </label>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'loadmore' ); ?>"><?php esc_html_e( 'Read More', 'cbxwpbookmarkaddon' ); ?>
		<select class="widefat" id="<?php echo $this->get_field_id( 'loadmore' ); ?>"
				name="<?php echo $this->get_field_name( 'loadmore' ); ?>">

			<option value="1" <?php echo ( $loadmore == 1 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'Yes', 'cbxwpbookmarkaddon' ) ?>
			</option>
			<option value="0" <?php echo ( $loadmore == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'No', 'cbxwpbookmarkaddon' ) ?>
			</option>
		</select> </label>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'catid' ); ?>">
		<?php esc_html_e( 'Category Id', 'cbxwpbookmarkaddon' ); ?>
    </label> <input class="widefat" id="<?php echo $this->get_field_id( 'catid' ); ?>" name="<?php echo $this->get_field_name( 'catid' ); ?>" type="text" value="<?php echo esc_attr($catid); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'cattitle' ); ?>"><?php esc_html_e( 'Category Title', 'cbxwpbookmarkaddon' ); ?>
        <select class="widefat" id="<?php echo $this->get_field_id( 'cattitle' ); ?>"
                name="<?php echo $this->get_field_name( 'cattitle' ); ?>">

            <option value="1" <?php echo ( $cattitle == 1 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'Yes', 'cbxwpbookmarkaddon' ) ?>
            </option>
            <option value="0" <?php echo ( $cattitle == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'No', 'cbxwpbookmarkaddon' ) ?>
            </option>
        </select> </label>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'catcount' ); ?>"><?php esc_html_e( 'Category Count', 'cbxwpbookmarkaddon' ); ?>
        <select class="widefat" id="<?php echo $this->get_field_id( 'catcount' ); ?>"
                name="<?php echo $this->get_field_name( 'catcount' ); ?>">

            <option value="1" <?php echo ( $catcount == 1 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'Yes', 'cbxwpbookmarkaddon' ) ?>
            </option>
            <option value="0" <?php echo ( $catcount == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'No', 'cbxwpbookmarkaddon' ) ?>
            </option>
        </select> </label>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php esc_html_e( "Show Thumbnail", 'cbxwpbookmarkaddon' ); ?>
		<select class="widefat" id="<?php echo $this->get_field_id( 'show_thumb' ); ?>"
				name="<?php echo $this->get_field_name( 'show_thumb' ); ?>">

			<option value="1" <?php echo ( $show_thumb == 1 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'Yes', 'cbxwpbookmarkaddon' ) ?>
			</option>
			<option value="0" <?php echo ( $show_thumb == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'No', 'cbxwpbookmarkaddon' ) ?>
			</option>
		</select> </label>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'allowdelete' ); ?>"><?php esc_html_e( 'Allow Delete', 'cbxwpbookmarkaddon' ); ?>
        <select class="widefat" id="<?php echo $this->get_field_id( 'allowdelete' ); ?>"
                name="<?php echo $this->get_field_name( 'allowdelete' ); ?>">

            <option value="1" <?php echo ( $allowdelete == 1 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'Yes', 'cbxwpbookmarkaddon' ) ?>
            </option>
            <option value="0" <?php echo ( $allowdelete == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'No', 'cbxwpbookmarkaddon' ) ?>
            </option>
        </select> </label>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'allowdeleteall' ); ?>"><?php esc_html_e( 'Allow Delete All', 'cbxwpbookmarkaddon' ); ?>
        <select class="widefat" id="<?php echo $this->get_field_id( 'allowdeleteall' ); ?>"
                name="<?php echo $this->get_field_name( 'allowdeleteall' ); ?>">

            <option value="1" <?php echo ( $allowdeleteall == 1 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'Yes', 'cbxwpbookmarkaddon' ) ?>
            </option>
            <option value="0" <?php echo ( $allowdeleteall == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'No', 'cbxwpbookmarkaddon' ) ?>
            </option>
        </select> </label>
</p>
<p>
	<label
		for="<?php echo $this->get_field_id( 'honorauthor' ); ?>"><?php esc_html_e( 'In Author Archive Show for Author', 'cbxwpbookmarkaddon' ); ?>
		<select class="widefat" id="<?php echo $this->get_field_id( 'honorauthor' ); ?>"
				name="<?php echo $this->get_field_name( 'honorauthor' ); ?>">

			<option value="1" <?php echo ( $honorauthor == 1 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'Yes', 'cbxwpbookmarkaddon' ) ?>
			</option>

			<option value="0" <?php echo ( $honorauthor == 0 ) ? 'selected="selected"' : ''; ?>>
				<?php esc_html_e( 'No', 'cbxwpbookmarkaddon' ) ?>
			</option>
		</select> </label>
</p>
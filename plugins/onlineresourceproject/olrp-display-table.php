<?php

/* This class contains methods for outputting the table and individual resources to HTML.*/
class olrp_display {
	public olrp_manager $olrp_m;

	function __construct( olrp_manager $olrp_m ) {
		$this->olrp_m = $olrp_m;
	}

	/**
	 * Shortcode to display a table of resources
	 *
	 * Displays all the resources in an html table. Later extend to filter the resources by category etc.
	 *
	 * @param array $options specify which metadata to display **UNUSED**
	 */
	 function olrp_display_table(): string {
		$output                = '<table class="olrp_display_table display compact" style="width:100%"><thead><th>Title</th><th>URL</th><th>Creator</th><th>Summary</th><th>Tags</th></thead>';
		$args                  = array();
		$args['post_type']     = 'olrp_resource';
		$args['nopaging']      = true;
		$args['post_per_page'] = - 1;
		$posts                 = get_posts( $args );

		foreach ( $posts as $post ) {
			$meta     = get_post_meta( $post->ID );
			$creators = get_the_term_list( $post->ID, 'creator' );

			$discussion = get_permalink( $post );
			$url        = $meta['olrp-resource-url'][0];
			$summary    = $meta['olrp-resource-summary'][0];
			$title      = get_the_title( $post );
			$tags_obj   = get_the_tags( $post );
			$tags_str   = get_the_tag_list( '', ',', '', get_post()->ID );
			if ( $tags_obj ) {
				foreach ( $tags_obj as $tag ) {
					$name     = $tag->name;
					$tags_str .= "<a href=\"?tag=$name\"> $name </a> , "; /*FIXME: likely bug here, need to html_encode to manage spaces*/
				}
			}


			$output .= "<tr>";
			$output .= "<td><a href=\" $discussion \"> $title </a></td>";
			$output .= "<td>$url</td>";
			$output .= "<td> $creators </td>";
			$output .= "<td> $summary </td>";
			$output .= "<td> $tags_str </td>";
			//$output .= "<td><a href=\" $discussion \"> More Info</a></td>";
			$output .= "</tr>";


		}

		$output .= '</table>';

		return $output;
	}

	/**
	 * Get Post Metadata
	 *
	 *  Returns the desired metadata or "" if not found
	 *
	 * @param int Post ID
	 * @param string Metadata key
	 *
	 * @return string metadata value
	 **/
	function olrp_get_post_meta( $post_id, $meta_key ): string {
		$post_meta = get_post_meta( $post_id ); //metadata for this post

		return isset( $post_meta[ $meta_key ] ) ? current( $post_meta[ $meta_key ] ) : "";

	}

	/**
	 * Shortcode to display a resource
	 *
	 * Displays the Title, Tags and any metdata for the resource, later extend to specify specific metadata values and
	 * how to display it.
	 *
	 * @param array $options specify which metadata to display
	 */
	function olrp_display_resource(): string {
		$tags           = get_the_tag_list( '', ',', '', get_post()->ID );
		$creators       = get_the_term_list( get_post()->ID, 'creator' );
		$collections    = get_the_term_list( get_post()->ID, 'collection' );
		$resource_lists = get_the_term_list( get_post()->ID, 'resource_list' );

		$summary = $this->olrp_get_post_meta( get_post()->ID, "olrp-resource-summary" );

		$output = "";
		$output .= "<h3> Summary => $summary </h3>";
		$output .= "<h3> Creator => $creators </h3>";
		$output .= "<h3> Tags => $tags  </h3>";
		if ( $collections ) {
			$output .= "<h3> Collections => $collections  </h3>";
		}
		if ( 0 /*$resource_lists*/ ) {
			$output .= "<h3> Resource Lists => $resource_lists  </h3>";
		}
		$output .= do_shortcode( '[cbxwpbookmarkbtn object_id="' . get_post()->ID . '" object_type="' . get_post()->post_type . '"]' );

		return $output;
	}

	/**
	 * Kind of a hack. This is a callback to automatically display resource data for single olrp_resources. This should eventually be replaced with a default template that uses a shortcode or
	 * more advanced guttenberg stuff.
	 * @param $content
	 *
	 * @return mixed|string
	 */
	function olrp_insert_content( $content ) {

		if ( 'olrp_resource' == get_post_type( get_post()->ID ) ) {
			$modified_content = $this->olrp_display_resource();
			$modified_content .= $content;

			return $modified_content;
		} else {
			return $content;
		}

	}

	/**
	 *  Callback to modify the title of an olrp_resource by making it a link using it's url.
	 * @param $title

	 * @return mixed|string
	 */
	function olrp_modify_title( $title ) {

		//FIXME - Don't add URL to post titles in navigation (Previous / Next Post
		if ( is_single() && 'olrp_resource' == get_post_type() ) {
			$url = $this->olrp_get_post_meta( get_post()->ID, "olrp-resource-url" );

			$modified_title = "<a target=\"_blank\" href=\" $url \" > $title </a> ";

			return $modified_title;
		} else {
			return $title;
		}

	}


}
?>

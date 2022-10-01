<?php
/* These are the functions for importing resources from a CSV file
*/


/** Add the OLRP Tools Menu and Page
 *
 */
class olrp_data
{
	public olrp_manager $olrp_m;

	function __construct(olrp_manager $olrp_m)
	{
		$this->olrp_m = $olrp_m;
	}

	function olrp_create_menu_page() {

		//create custom top-level menu
		add_menu_page( 'OLRP Tools Page', 'OLRP Tools',
			'manage_options', 'olrp-tools', array($this,'olrp_tools_page'),
			'dashicons-smiley', 99 );

		}


/** Draw the OLRP Tools Page
 *
 */
	function olrp_tools_page()
	{
		?>
		<div class="wrap">
			<h2>OLRP Tools</h2>
			<form action="" method="post" enctype="multipart/form-data">
				<input  name="olrp_resource_csv_file" type="file">
				<select name="category-dropdown">
					<option value=""><?php echo esc_attr_e( 'Select Category', 'teryk' ); ?></option>
					<?php
					$categories = get_categories( array( 'hide_empty' => false, 'type' => 'olrp_resource') );
					foreach ( $categories as $category ) {
						printf( '<option value="%1$s">%2$s</option>',
							esc_attr( $category->cat_ID ),
							esc_html( $category->cat_name )
						);
					}
					?>
				</select>
				<input type="submit" name="submit">
			</form>
		</div>
		<?php


		if (isset($_POST['submit']) && !empty($_FILES["olrp_resource_csv_file"]) ) {
			$rtn = "";
			$options = array();
			$options['csv_file'] = $_FILES['olrp_resource_csv_file'];
			if(isset($_POST['category-dropdown']) && $_POST['category-dropdown'] != "") {
				$options['category'] = array($_POST['category-dropdown']);
			}

			$rtn = $this->handle_csv_upload($options);
			if($rtn){
				echo ($rtn);
			}
		}

	}

/** Handles CSV Upload
 *
 *Has wordpress copy the passed in temp file to the uploads directory, Checks the headers of the
 *uploaded CSV and imports it if no errors.
 *
 *@param array $options Array containing file to import and other
 *@return string error
 */
	function handle_csv_upload($options): string
	{
		$rtn = "";

		$filepath = $options['csv_file']['tmp_name'];
		$fileSize = filesize($filepath);
		$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
		$filetype = finfo_file($fileinfo, $filepath);

		if ($fileSize > 3145728) { // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
			$rtn = "<h3>The file is too large</h3>";
		}
		if($filetype != 'text/plain' || ! stristr($options['csv_file']['name'],".csv")){
			$rtn .= "<h3>Wrong File Type, must be .csv</h3>";
		}

		if (strlen($rtn)){
			return $rtn;
		}

		if(!function_exists('wp_handle_upload'))
		{
			require_once(ABSPATH .'wp-admin/includes/file.php');
		}

		$move_csv = wp_handle_upload( $options['csv_file'], array('test_form' => false) );
		if ( $move_csv && !isset($move_csv['error']) ) {
			$rtn = $this->importCSV($move_csv['file'],$options);
		}
		else
		{
			return $move_csv['error'];
		}
		return $rtn;
	}

/** Imports a CSV file local to the server
 *
 *Imports the local CSV file and creates custom posts with metadata
 *
 *@param string $file_path Path the the uploaded file
 *@param array $options Array containing file to import and other
 *@return string error
 */
	/* Process a .csv file, create resources and assign metadata */
	Function importCSV(string $file_path, array $options): string
	{
		$err = "";
		$rescount = 0;

		$err = $this->csv_to_array($resources, $file_path);
		if(! $resources) {
			return $err;
		}

		$metakeys = $this->get_metakeys();

		foreach($resources as $res)
		{
			/*Create an array of just the values from the csv file matching the meta keys*/
			$metavalues = array_intersect_key($res,$metakeys);

			$creator = $metavalues['Creator'];
			unset($metavalues['Creator']);

			/* swap the human readable keys out for the db key*/
			foreach ($metakeys as $key => $value)
			{
				if(array_key_exists( $key, $metavalues )){
					$metavalues[$value] = $metavalues[$key];
					unset ($metavalues[$key]);
				}
			}

			$postarr = array(
				'ID' => 0,
				'post_content' => "",
				'post_title' => $res['Title'],
				'post_excerpt' => $res['Summary'],
				'post_type' => 'olrp_resource',
				'tags_input' => explode(",",$res['Tags']),
				'meta_input' => $metavalues,
				//'tax_input' => $creator
			);
			if (isset($options['category'])){
				$postarr['post_category'] = $options['category'];
			}

			$id = wp_insert_post($postarr);
			if(isset ($id) && $id !== 0 ) {
				wp_set_object_terms( $id, $creator, 'creator' );
			}
			$rescount += 1;
		}
		return "Created " . $rescount . " New Resources.";
	}
/** Get the Metadata key array
 *
 * Get an array of our custom meta keys
 * Creator => olrp-resource-creator, URL => olrp-resource-url ....
 *
 * @return array of metakeys
 */
	function get_metakeys()
	{
		$arrlength = count($this->olrp_m->custom_meta);
		$metakeys = array();

		for ($n = 0; $n < $arrlength; $n++){
			$metakeys[key($this->olrp_m->custom_meta[$n])] =  $this->olrp_m->custom_meta[$n][key($this->olrp_m->custom_meta[$n])];
		}
		return $metakeys;

	}
/* creates a two dimensional array with each row containing an array of
key/value pairs. The keys are taken from the header of the .csv file
*/
/** Converts a csv into a php array
 *
 * Creates a two dimensional array with each row containing an array of
 * key/value pairs. The keys are taken from the header of the .csv file
 *
 * @param string $filename
 * @param string $delimiter
 * @return string error
 */
	function csv_to_array(&$resources,$filename='', $delimiter=',')
	{
		if(!file_exists($filename) || !is_readable($filename))
			return "<h3> Cannot Open File on Server</h3>";

		$header = NULL;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== FALSE)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
				if(!$header) {
					$header = $row;
					if(! $this->check_headers($header)){
						return "<h3>Header Mismatch in CSV File</h3>";
					}
				}
				else
					$resources[] = array_combine($header, $row);
			}
			fclose($handle);
		}
		return "";
	}

/** Checks CSV Headers
 *
 * Tests to see if the CSV has the values we want
 *
 * @param array $headers
 * @return bool error
 */
	function check_headers( array $headers ): bool {

		$key_array = $this->get_metakeys();

		foreach($key_array as $key=> $value )
		{
			if(false === array_search($key,$headers)){
				return false;
			}
		}
		Return true;
	}
}
?>

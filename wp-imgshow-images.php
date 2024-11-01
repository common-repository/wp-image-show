<?php
function wpshow_addimages()
{
	global $wpdb;	
	$query = "SELECT guid,post_title,id " . 
	     	  " FROM $wpdb->posts " . 
	     	 " WHERE post_mime_type like '%image%' ORDER BY post_date DESC";

	$result = $wpdb->get_results( $query );
	
	$images = "";
	$i = 0;
	foreach ($result as $row) 
	{	
		if ($_POST["wpshow_image" . $row->id])
		{
			$images .= "(" . $row->id ."),";
			$i++;
		}
	}
	
	global $wpimageshow_table_name;
	
	
	if ($i > 0)
	{	
		$images = substr($images,0,strlen($images)-1);
		
		$wpdb->query("DELETE FROM " . $wpdb->prefix . $wpimageshow_table_name );
		
		$query = "INSERT INTO " . $wpdb->prefix . $wpimageshow_table_name 
					. " ( id_image  )" .
						"VALUES " . $images;
		
						
		$wpdb->query($query);
	}
			
	
}
?>
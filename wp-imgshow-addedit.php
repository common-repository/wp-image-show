<?php
include_once("wp-imgshow-images.php");
 
function wpimageshow_addedit_page() {
	global $wpdb;
	global $wpimageshow_table_name;
    
	// *** Post-It Info
	$id_galery     = $_REQUEST["wpimageshow_id_galery"];
	
	// *******  SAVE POST-IT ********
	if ( ($_POST["wpimgshow_submit"] == "ok") )
	{	 	
		   wpshow_addimages  ();  	
			    
	}
	 

?>
<div class="wrap">

<form name="wpimgshow_form" method="post" onsubmit="return validateInfo(this);" 
	  action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	  

<?php
    // Now display the options editing screen

    // header
	echo "<h2>" . __( 'Create Image List', 'mt_trans_domain' ) . "</h2>";

    // options form
    
 ?>
    <?php if ( $_POST["wpimgshow_submit"] == "ok" ) { ?>
    <div class="updated"><p><strong><?php _e('Gallery information saved.', 'mt_trans_domain' ); ?></strong></p></div><br>	
    <? }; ?>

 	
 	
 		
		 
	     <b>Select the images that you want to include in your image show widget</b>
	     <table cellspacing="10">
	     <tr>
	     <?php
	     	$img_count = 0;
	     	$img_per_row = 10;
	     	$query = "SELECT guid,post_title,id " . 
	     	              " FROM $wpdb->posts " . 
	     	             " WHERE post_mime_type like '%image%' ORDER BY post_title";

			$result = $wpdb->get_results( $query );
			
			foreach ($result as $row) 
			{	
				if ($img_count == $img_per_row )
				{
					echo "</tr><tr>";	
					$img_count = 0;
				}
				$cheked = "";
				
				if ($wpdb->get_var("SELECT COUNT(*) " . 
										" FROM " . $wpdb->prefix . $wpimageshow_table_name .
										" WHERE  id_image  = " . $row->id ))
				{
						 $cheked = "checked";
				}
				
				
				echo '<td><img src="' . $row->guid . '" width="50" height="50"><br>' .
					 '<p style="font-size:10px; text-align:center">' .
					 '<input type="checkbox" name="wpshow_image' . $row->id . '" value="' . $row->id .'" ' . $cheked .'>' .
				    $row->post_title .'</p></td>';
				    
				$img_count++;
			}
		?>
		</tr>
		</table>
 	
 

<p class="submit">
	<input type="hidden" name="wpimgshow_submit" value="ok">
	<input type="submit" name="Submit" value="<?php _e('Save Gallery Information', 'mt_trans_domain' ) ?>" />&nbsp;
	
</p>

</form>

</div> <!-- **** DIV WRAPPER *** -->

<?php } ?>
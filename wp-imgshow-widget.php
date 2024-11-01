<?php

function wpimageshow_widget_control()
{
  
  $optTimeInterval = get_option("wpimageshow_timeinterval");
  if (!$optTimeInterval)
		$optTimeInterval = "5";

  $optHeight = get_option("wpimageshow_height");
  if (!$optHeight)
		$optHeight = "150";

  $optWidth = get_option("wpimageshow_width");
  if (!$optWidth)
		$optWidth = "150";
 		
  if ($_POST['wpimageshow-Submit'])
  {
	    update_option("wpimageshow_timeinterval", $_POST['wpimageshow_timeinterval']);
	    update_option("wpimageshow_height",       $_POST['wpimageshow_height']);
	    update_option("wpimageshow_width",        $_POST['wpimageshow_width']);
  }
  
  ?>
   <p>
    <label for="wpimageshow_timeinterval">Time interval between images: </label>
    <input type="text" id="wpimageshow_timeinterval" name="wpimageshow_timeinterval" size="3" maxlength="3" 
    	   value="<?php echo $optTimeInterval;?>" /> seconds.<br><br>
    
    Widget Height
    <input type="text" id="wpimageshow_height" name="wpimageshow_height" size="5" maxlength="4" 
    	   value="<?php echo $optHeight;?>" />px<br>
    <br><br>
    Widget Width
    <input type="text" id="wpimageshow_width" name="wpimageshow_width" size="5" maxlength="4" 
    	   value="<?php echo $optWidth;?>" />px<br>
    	   	   
    <input type="hidden" id="wpimageshow-Submit" name="wpimageshow-Submit" value="1" />
  </p>
  <?php
};


function wpimageshow_getwidget()
{	
  $optHeight = get_option("wpimageshow_height");
  if (!$optHeight)
		$optHeight = "150";

  $optWidth = get_option("wpimageshow_width");
  if (!$optWidth)
		$optWidth = "150";

	
	
	global $wpdb;
	global $wpimageshow_table_name;
    $table = $wpdb->prefix . $wpimageshow_table_name;
    
	$result = $wpdb->get_results( "SELECT guid " . 
	     	  					  " FROM $wpdb->posts " . 
			  						  " INNER JOIN " . $table . " ON id = id_image" .
	     	 					  " ORDER BY post_title desc limit 0,1");

	$i = 0;
	
	$img = "";
	if ($result) 
	  $img = $result[0]->guid; 
?>
<div>
   <table border="0" cellpadding="0" style="border: 2px solid darkblue; " cellspacing="0">
   <tr>
    <td width="<?php echo $optWidth ?>" height="<?php echo $optHeight ?>">
	    <img src="<?php echo $img ?>" id="PictureBox" name="PictureBox" width="<?php echo $optWidth ?>" 
	    	 height="<?php echo $optHeight ?>">
    </td>
  </tr>
  <tr>
     <td id="CaptionBox" class="Caption" align="center" bgcolor="cornflowerblue">
 	   &nbsp;
     </td>
  </tr>
  </table>
  <font style="font-size:6px;">Created by  
	<a href="http://www.grupomayanvacations.com" target="_TOP" title="grupo mayan">grupo mayan</a>
  </font>
</div>
<?php		   
}

function wpimageshow_widget($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?><?php echo $after_title;
  echo wpimageshow_getwidget();
  echo $after_widget;
}
?>
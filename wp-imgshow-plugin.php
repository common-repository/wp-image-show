<?php
/*
Plugin Name: WP Image Show
Plugin URI:  http://www.grupomayanvacations.com/wp-image-show/
Description: Let you create an image slide show for your wordpress blog
Author: Demain Rice
Version: 1.0
Author URI: http://www.grupomayanvacations.com/
*/


// *********** PARSER *********** //

register_activation_hook(__FILE__,'wpimageshow_install');

$wpimageshow_table_name   = "imgshow_images";


function wpimageshow_install () {
   global $wpdb;
   
   $wpimageshow_table_name   = "imgshow_images";
    
	// **** IMAGE'S TABLE *****   
   $table_name = $wpdb->prefix . $wpimageshow_table_name;
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      $sql = "CREATE TABLE " . $table_name . " (
	  id_imggal mediumint(9) NOT NULL AUTO_INCREMENT,
      id_image  mediumint(9) NOT NULL,
	  UNIQUE KEY id_imggal (id_imggal)
	);";

      
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
	$wpdb->query($query);
	
	 // update_option("wpimageshow_timeinterval", "3");
	 // update_option("wpimageshow_dateformat",   "m/d/Y");
	 // update_option("wpimageshow_linktext", "read more");
			   		 
   }
}


$wpimageshow_plugin_dir = get_option("siteurl") . '/wp-content/plugins/' . basename(dirname(__FILE__)); 
function wpimageshow_setfiles()
{	
	global $wpimageshow_plugin_dir;

	 echo '<script type="text/javascript" src="' .  $wpimageshow_plugin_dir . '/wp-imgshow.js">' .
		 '</script>' ."\n";
}

include ("wp-imgshow-widget.php");
function wpimageshow_init()
{
  register_sidebar_widget(__('WordPress Image Show'), 'wpimageshow_widget');
  register_widget_control('WordPress Image Show', 'wpimageshow_widget_control', 300, 200 );
}

include ("wp-imgshow-addedit.php");
function wpimageshow_add_pages() {
    
	// Add a new submenu under Options:
   	add_options_page('WP Image Show', 'WP Image Show', 8, 'wpimageshow', 'wpimageshow_addedit_page');
}


function wpimageshow_loadimages()
{	
	global $wpdb;
    global $wpimageshow_table_name;
    $table = $wpdb->prefix . $wpimageshow_table_name;
    
   $optTimeInterval = get_option("wpimageshow_timeinterval");
   if (!$optTimeInterval)
		$optTimeInterval = "3";
		
	?>
	<script type="text/javascript">
	var SlideShowSpeed = <?php echo $optTimeInterval * 1000 ?>;
	var Picture = new Array(); 
	var Caption = new Array(); 
	
	<?php
	$query = "SELECT guid,post_title,id " . 
	     	  " FROM $wpdb->posts " . 
			  " INNER JOIN " . $table . " ON id = id_image" .
	     	 " ORDER BY post_title";

	$result = $wpdb->get_results( $query );

	$i = 0;
	foreach ($result as $row) 
	{
		$i++;	
		
?>

			Picture[<?php echo $i ?>]  = "<?php echo $row->guid ?>";
			Caption[<?php echo $i ?>]  = "<?php echo $row->post_title ?>";
	
<?php
		
	}
?>
</script> 
<?php
}

function wpimageshow_start()
{
  ?>
  <script type="text/javascript">
  	runSlideShow();
  </script>
  <?php
}
add_action('admin_menu',     "wpimageshow_add_pages");
add_action("wp_footer",        "wpimageshow_setfiles");
add_action("wp_head",        "wpimageshow_loadimages");
add_action("wp_footer",      "wpimageshow_start");
add_action("plugins_loaded", "wpimageshow_init");
?>
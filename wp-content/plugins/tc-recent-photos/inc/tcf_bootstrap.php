<?PHP

/*-----------------------------------------------------------------------------------*/
/*	Bootstrapn' Time!
/*-----------------------------------------------------------------------------------*/

function tcrinsta_init(){
	
	// Load Lang
	load_plugin_textdomain( 'tcrinsta', false, TCRINSTA_RELPATH.'/languages/' );
	
	// Make sure we are not in the admin section
	if (!is_admin()){
		
		// Load ThickBox For Gallery
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox', NULL,  array('jquery'));
		wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', NULL, '1.0');	
		
		// Flush, register, enque  CSS
		wp_deregister_style('tcrinsta-css');
		wp_register_style('tcrinsta-css', TCRINSTA_LOCATION.'/css/insta-widget.css');
		wp_enqueue_style('tcrinsta-css');
			
	} // End if admin
	
	// Strap MCE
	tcrinsta_mce();
				
} // End jsloader function

/*-----------------------------------------------------------------------------------*/
/*	Add tinyMCE Button
/*-----------------------------------------------------------------------------------*/

function tcrinsta_mce(){
	
	// Don't bother doing this stuff if the current user lacks permissions
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
	return;
	
	// Add only in Rich Editor mode
	if( get_user_option('rich_editing') == 'true'){
		
		// Add cutom button to TinyMCE
		add_filter('mce_external_plugins', "tcrinsta_mce_register");
		add_filter('mce_buttons', 'tcrinsta_add_button', 0);
		
	}
	
}

function tcrinsta_add_button($buttons) {
   array_push($buttons, "separator", "tcrinstaplugin");
   return $buttons;
}

function tcrinsta_mce_register($plugin_array) {
   $plugin_array['tcrinstaplugin'] = TCRINSTA_LOCATION."/inc/mce/mce.js";
   return $plugin_array;
} // end tinyMCE

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Handle
/*-----------------------------------------------------------------------------------*/

function tcrinsta_sc_handle($atts, $content) {
	
	// Extract variables from shortcode tag, set defaults
	extract(shortcode_atts(array(
		"title"		=> '',
		"type"		=> 'user',
		"tag"		=> '',
		"username"	=> 'mistercapo',
		"count"		=> '6',
		"size"		=> '70',
		"columns"	=> '3',
		"lightbox"	=> 'true',
		"follow"	=> 'false'
	), $atts));
	
	$thisContent = '';
	
	// Display A Title If Set
	if( $title != '' ){
		$thisContent.= '<h3 class="tcr-insta-heading">'.$title.'</h3>';
	}
	
	// Setup List
	if( $type == 'user' ){
		$thisContent.= tcrinsta_getFeed($username, $count, $size, $columns, $lightbox, $follow);
	} else if( $type == 'tag' ){
		$thisContent.= tcrinsta_getTagMedia($tag, $username, $count, $size, $columns, $lightbox, $follow);
	} else {
		$thisContent.= 'No valid widget type is set.';
	}
	
	// Return Output
	return $thisContent;
	
}// End shortcode handler

/*-----------------------------------------------------------------------------------*/
/*	Start Running Hooks
/*-----------------------------------------------------------------------------------*/

// Start the plugin
add_action('init', 'tcrinsta_init');

// Add hook to include settings CSS
add_action( 'admin_init', 'tcrinsta_settings_admin_css' );
// create custom plugin settings menu
add_action( 'admin_menu', 'tcrinsta_create_menu' );

// Add Shortcode
add_shortcode('tcr-instagram', 'tcrinsta_sc_handle');

?>
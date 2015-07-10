<?PHP

/*-----------------------------------------------------------------------------------*/
/*	Menu Creation
/*-----------------------------------------------------------------------------------*/

function tcrinsta_create_menu() {
	
	// Adds the tab into the options panel in WordPress Admin area
	$page = add_options_page( __("Instagram Widget Pro Settings", "tcrinsta"), __("Instagram Widget Pro", "tcrinsta"), 'administrator', __FILE__, 'tcrinsta_settings_page');

	// call register settings function
	add_action( 'admin_init', 'tcrinsta_register_settings' );
	
	// Hook style sheet loading
	add_action( 'admin_print_styles-' . $page, 'tcrinsta_admin_cssloader' );

}
		
/*-----------------------------------------------------------------------------------*/
/*	Add Admin CSS
/*-----------------------------------------------------------------------------------*/

// Add style sheet for plugin settings
function tcrinsta_settings_admin_css(){
				
	/* Register our stylesheet. */
	wp_register_style( 'tcrinstaSettings', TCRINSTA_LOCATION.'/css/tc_framework.css' );
							
} function tcrinsta_admin_cssloader(){
	
	// It will be called only on your plugin admin page, enqueue our stylesheet here
	wp_enqueue_style( 'tcrinstaSettings' );
	   
} // End admin style CSS

/*-----------------------------------------------------------------------------------*/
/*	Define Settings
/*-----------------------------------------------------------------------------------*/

global $tcrinsta_settings;

$tcrinsta_settings = array(
	// Instagram Settings
	'insta-client-id'		=> '',
	'insta-access-token'	=> '',
	'insta-follow-name'		=> 'mistercapo'
);

/*-----------------------------------------------------------------------------------*/
/*	Register Settings
/*-----------------------------------------------------------------------------------*/

function tcrinsta_register_settings(){
	global $tcrinsta_settings;
	$prefix = 'tcrinsta';
	foreach($tcrinsta_settings as $setting => $value){
		// Define
		$thisSetting = $prefix.'-'.$setting;
		// Register setting
		register_setting( $prefix.'-settings-group', $thisSetting );
		// Apply default
		add_option( $thisSetting, $value );
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Get Settings
/*-----------------------------------------------------------------------------------*/

function tcrinsta_get_settings(){
	// Get Settings	
	global $tcrinsta_settings;
	$prefix = 'tcrinsta';
	$new_settings = array();
	foreach($tcrinsta_settings as $setting => $default){
		// Define
		$thisSetting = $prefix.'-'.$setting;
		$value = get_option( $thisSetting );
		if( !isset($value) ) : $value = ''; endif;
		$new_settings[$setting] = $value;
	}
	return $new_settings;
}

global $tcrinsta_options;
$tcrinsta_options = tcrinsta_get_settings();

/*-----------------------------------------------------------------------------------*/
/*	Ajax save callback
/*-----------------------------------------------------------------------------------*/

add_action('wp_ajax_tcrinsta_tc_settings_save', 'tcrinsta_tc_settings_save');

function tcrinsta_tc_settings_save(){

	check_ajax_referer('tcrinsta_settings_secure', 'security');
	
	// Setup
	global $tcrinsta_settings;
	$prefix = 'tcrinsta';

	// Loop through settings
	foreach($tcrinsta_settings as $setting => $value){
		
		// Define
		$thisSetting = $prefix.'-'.$setting;
					
		// Register setting
		if( isset( $_POST[$thisSetting] ) ){
			update_option( $thisSetting, $_POST[$thisSetting] );
		}
		
	} // end for each
		
}

/*-----------------------------------------------------------------------------------*/
/*	New framework settings page
/*-----------------------------------------------------------------------------------*/

function tcrinsta_settings_page() {
	
?>

<script>
	
jQuery(document).ready(function(){

/*-----------------------------------------------------------------------------------*/
/*	Options Pages and Tabs
/*-----------------------------------------------------------------------------------*/
	  
	jQuery('.options_pages li').click(function(){
		
		var tab_page = 'div#' + jQuery(this).attr('id');
		var old_page = 'div#' + jQuery('.options_pages li.active').attr('id');
		
		// Change button class
		jQuery('.options_pages li.active').removeClass('active');
		jQuery(this).addClass('active');
				
		// Set active tab page
		jQuery(old_page).fadeOut('slow', function(){
			
			jQuery(tab_page).fadeIn('slow');
			
		});
		
	});
	
/*-----------------------------------------------------------------------------------*/
/*	Form Submit
/*-----------------------------------------------------------------------------------*/
	
	jQuery('form#plugin-options').submit(function(){
			
		var data = jQuery(this).serialize();
		
		jQuery.post(ajaxurl, data, function(response){
			
			if(response == 0){
				
				// Flash success message and shadow
				var success = jQuery('#success-save');
				var bg = jQuery("#message-bg");
				success.css("position","absolute");
				bg.css({"height": jQuery(window).height()});
				bg.css({"opacity": .45});
				bg.fadeIn('slow');
				success.fadeIn('slow');
				window.setTimeout(function(){success.fadeOut(); bg.fadeOut();}, 2000);
								
			} else {
				
				//error out
				
			}
		
		});
				  
		return false;
	
	});
	
/*-----------------------------------------------------------------------------------*/
/*	Popup Center Handles
/*-----------------------------------------------------------------------------------*/
	
	// Center Function
	jQuery.fn.center = function(parent){
		this.animate({"top":( jQuery(window).height() - this.height() - 65 ) / 2+jQuery(window).scrollTop() + "px"},100);
		//this.css({"left": (((jQuery(this).parent().width() - this.outerWidth()) / 2) + jQuery(this).parent().scrollLeft() + "px")});
		this.css({"left":"250px"});
		return this;
	}
	
	// Center onLoad and Scroll
	jQuery('#success-save').center();
	jQuery(window).scroll(function(){ 
		jQuery('#success-save').center();
	});
	
/*-----------------------------------------------------------------------------------*/
/*	Open Instagram Window
/*-----------------------------------------------------------------------------------*/

	jQuery('#tc-insta-generate').on('click', function(e){
		window.open ("https://instagram.com/oauth/authorize/?client_id=<?PHP echo get_option('tcrinsta-insta-client-id'); ?>&redirect_uri=<?PHP echo TCRINSTA_INSTAGRAM_URI; ?>&response_type=token&scope=relationships","mywindow","menubar=1,resizable=1,width=500,height=400");
	});
	
/*-----------------------------------------------------------------------------------*/
/*	Finished
/*-----------------------------------------------------------------------------------*/
	
});

</script>

<div class="wrap">

    <div id="icon-options-general" class="icon32"><br/></div>
    <h2 class="tc-heading"><?PHP _e('Instagram Widget Pro for WordPress', 'tcrinsta') ?> <span id="version">V<?PHP echo TCRINSTA_VERSION; ?></span> <a href="<?PHP echo TCRINSTA_LOCATION; ?>/documentation" target="_blank">&raquo; <?PHP _e('View Plugin Documentation', 'tcrinsta') ?></a></h2>

</div>

<div id="message-bg"></div>
<div id="success-save"></div>

<div id="tc_framework_wrap">

    <div id="content_wrap">
    
    	<form id="plugin-options" name="plugin-options" action="/">
        <?php settings_fields( 'edd-tcmd-settings-group' ); ?>
        <input type="hidden" name="action" value="tcrinsta_tc_settings_save" />
        <input type="hidden" name="security" value="<?php echo wp_create_nonce('tcrinsta_settings_secure'); ?>" />
        <!-- Checkbox Fall Backs -->
        <input type="hidden" name="edd-tcmd-jquery-enabled" id="edd-tcmd-jquery-enabled" value="false" />
        <input type="hidden" name="edd-tcmd-double-optin" id="edd-tcmd-double-optin" value="false" />
        <input type="hidden" name="edd-tcmd-first-name" id="edd-tcmd-first-name" value="false" />
        <input type="hidden" name="edd-tcmd-last-name" id="edd-tcmd-last-name" value="false" />
        <input type="hidden" name="edd-tcmd-discount-string" id="edd-tcmd-discount-string" value="<?PHP echo get_option('edd-tcmd-discount-string'); ?>" />
        
        	<div id="sub_header" class="info">
            
                <input type="submit" name="settingsBtn" id="settingsBtn" class="button-framework save-options" value="<?php _e('Save All Changes', 'tcrinsta') ?>" />
                <span><?PHP _e('Options Page', 'tcrinsta') ?></span>
                
            </div>
            
            <div id="content">
            
            	<div id="options_content">
                
                	<ul class="options_pages">
                    	<li id="general_options" class="active"><a href="#"><?php _e('General Settings', 'tcrinsta') ?></a><span></span></li>
                    </ul>
                    
                    <div id="general_options" class="options_page"> 
                    

                    	<div class="option">
                        	<h3><?PHP _e('Instagram Setup', 'tcrinsta') ?></h3>
                            <div class="section">
                            	<div class="element">
                                    <p><?PHP _e('Instagram Client ID', 'tcrinsta') ?></p>
                                    <input class="textfield" name="tcrinsta-insta-client-id" type="text" id="tcrinsta-insta-client-id" value="<?PHP echo get_option('tcrinsta-insta-client-id'); ?>" />
                                    <p><?PHP _e('Instagram Redirect URI:', 'tcrinsta') ?></p>
									<p style="font-family:'Courier New', Courier, monospace;"><?PHP echo TCRINSTA_INSTAGRAM_URI; ?></p>
                                </div>
                                <div class="description"><?PHP _e('Here you need to enter your Instagram "Client ID". This change has been made to make image fetching more stable, and allows support for hashtags and more.', 'tcrinsta') ?></div>
                            </div>
                        </div>


                    	<div class="option">
                        	<?PHP
							$currentToken = get_option('tcrinsta-insta-access-token'); 
							if( $currentToken == '' ){
								$currentToken = __('NO TOKEN SET!', 'tcrinsta');
							}
							?>
                        	<h3><?PHP _e('Instagram Access Token', 'tcrinsta') ?> - <a id="tc-insta-generate" href="#"><?PHP _e('Generate Token'); ?></a></h3>
                            <div class="section">
                            	<div class="element">
                                    <p><?PHP _e('Current Token:', 'tcrinsta') ?></p>
									<p style="font-family:'Courier New', Courier, monospace;"><?PHP echo $currentToken; ?></p>
                                </div>
                                <div class="description"><?PHP _e('Here you need to enter your Instagram "Client ID". This change has been made to make image fetching more stable, and allows support for hashtags and more.', 'tcrinsta') ?></div>
                            </div>
                        </div>


                    	<div class="option">
                        	<h3><?PHP _e('Follow Button Setup', 'tcrinsta') ?></h3>
                            <div class="section">
                            	<div class="element">
                                    <p><?PHP _e('Instagram Username', 'tcrinsta') ?></p>
                                    <input class="textfield" name="tcrinsta-insta-follow-name" type="text" id="tcrinsta-insta-follow-name" value="<?PHP echo get_option('tcrinsta-insta-follow-name'); ?>" />
                                </div>
                                <div class="description"><?PHP _e('Here you can enter the Instagram Username you want to use with the Follow Button if enabled.', 'tcrinsta') ?></div>
                            </div>
                        </div>

                                                                                                                        
                    </div>   
                                        
            		<br class="clear" />
                    
            </div>
            
            <div class="info bottom">
            
                <input type="submit" name="settingsBtn" id="settingsBtn" class="button-framework save-options" value="<?php _e('Save All Changes', 'tcrinsta') ?>" />
            
            </div>
            
        </form>
        
    </div>

</div>

<?php } ?>
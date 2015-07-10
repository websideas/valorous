<?PHP

// Boostrap WP
$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
  $wp_include = "../$wp_include";
}

// let's load WordPress
require($wp_include);

// Get Options from DB
//$tc = get_option('');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Recent Instagram Photos</title>
<style>

body{
	margin:0px !important;
	padding:0px !important;
	border:0px !important;
	font-family:Arial, Helvetica, sans-serif !important;
	font-size:12px;
}

.tc-mce-clear{
	clear:both;
	height:0px;
}

.tc-mce-popup{
	margin:20px 0 0 0;;
}

.tc-mce-buttons{
	text-align:center;
}

.tc-mce-popup .option{
	padding: 0 0 8px 0;
	border-bottom:1px solid #ededed;
	margin-bottom:10px;
}

.tc-mce-popup .option .mce-option-title{
    clear: both;
    margin:0px;
    padding:7px 0 0 10px;
	float:left;
	width:175px;
	font-weight:bold;
}

.tc-mce-popup .option .section{
    font-size: 11px;
    overflow: hidden;
	float:left;
	width:325px;
}

.tc-mce-popup .option .section .element{
    float: left;
    margin:0px;
    width: 325px;
}

.tc-mce-popup .option .section .description{
    color: #555555;
    font-size: 11px;
    width: auto;
}

.tc-mce-popup #content select{
    cursor: pointer;
	height:2.5em !important;
}

.tc-mce-popup .option .section .element .textfield{
    background: none repeat scroll 0 0 #FAFAFA;
    border-color: #CCCCCC #EEEEEE #EEEEEE #CCCCCC;
    border-style: solid;
    border-width: 1px;
    color: #888888;
    display: block;
    font-family: "Lucida Grande","Lucida Sans Unicode",Arial,Verdana,sans-serif;
    font-size: 12px;
    margin-bottom: 6px !important;
    padding: 5px;
    resize: none;
    width: 310px;
}

.tc-mce-popup .tc-checkbox-wrap{
	width:95px;
	float:left;
}

.tc-mce-popup .tc-checkbox-wrap{
	width:110px;
	float:left;
}

.tc-mce-popup .tc-checkbox{
	margin:0 7px 4px 0;
}

.tc-mce-popup .tc-radio-group{
	padding:3px;
}

.tc-mce-popup .tc-radio-group input{
	margin-top:0px !important;
	vertical-align:baseline !important;
	margin-right:5px;
}

</style>
<script language="javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/jquery/jquery.js"></script>
<script language="javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script language="javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
<script language="javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
<script language="javascript" type="text/javascript">

	// Start TinyMCE
	function init() {
		tinyMCEPopup.resizeToInnerSize();
	}	
	
	// Function to add the like locker shortcode to the editor
	function addShortcode(){
		
		// Cache our form vars
		var insta_title = document.getElementById('tcr-insta-title').value;
		var insta_type = document.getElementById('tcr-insta-type').value;
		var insta_tag = document.getElementById('tcr-insta-tag').value;
		var insta_user = document.getElementById('tcr-insta-user').value;
		var insta_count = document.getElementById('tcr-insta-count').value;
		var insta_size = document.getElementById('tcr-insta-size').value;
		var insta_cols = document.getElementById('tcr-insta-cols').value;
		
		// Checkboxes
		var insta_lightbox = false;
		var insta_follow = false;
		if( jQuery('#tcr-insta-lightbox').prop('checked') == true ){insta_lightbox = 'true';}
		if( jQuery('#tcr-insta-follow').prop('checked') == true ){insta_follow = 'true';}
					
		// If TinyMCE runable
		if(window.tinyMCE) {
			
			// Get the selected text in the editor
			selected = tinyMCE.activeEditor.selection.getContent();
			
			// Send our modified shortcode to the editor with selected content				
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, '[tcr-instagram title="'+insta_title+'" type="'+insta_type+'" username="'+insta_user+'" tag="'+insta_tag+'" size="'+insta_size+'" columns="'+insta_cols+'" count="'+insta_count+'" lightbox="'+insta_lightbox+'" follow="'+insta_follow+'"]');

			// Repaints the editor
			tinyMCEPopup.editor.execCommand('mceRepaint');
			
			// Close the TinyMCE popup
			tinyMCEPopup.close();
			
		} // end if
		
		return; // always R E T U R N

	} // end add like locker function
	
</script>
</head>
<body>


<div class="tc-mce-popup">
    
    <div class="tc-mce-form-wrap">
    
    	<form action="" id="tc-mce-form">
        
            <div class="option">
                <div class="mce-option-title"><?php _e('Widget Title', 'tcrinsta') ?></div>
                <div class="section">
                    <div class="element"><input class="textfield" name="tcr-insta-title" type="text" id="tcr-insta-title" value="Recent Photos" /></div>
                </div>
                <br class="tc-mce-clear" />
            </div>  
            
            <div class="option">
                <div class="mce-option-title"><?php _e('Show Images From', 'tcrinsta') ?></div>
                <div class="section">
                    <div class="element">
                        <select class="textfield" name="tcr-insta-type" id="tcr-insta-type">
                            <option value="user" selected="selected"><?PHP _e('User ID', 'tcrinsta'); ?></option>
                            <option value="tag"><?PHP _e('Tag', 'tcrinsta'); ?></option>
                        </select>
                    </div>
                </div>
                <br class="tc-mce-clear" />
            </div>  

            <div class="option">
                <div class="mce-option-title"><?php _e('Instagram User ID', 'tcrinsta') ?></div>
                <div class="section">
                    <div class="element"><input class="textfield" name="tcr-insta-user" type="text" id="tcr-insta-user" value="25148318" /></div>
                </div>
                <br class="tc-mce-clear" />
            </div>  

            <div class="option">
                <div class="mce-option-title"><?php _e('Instagram Tag / Hashtag', 'tcrinsta') ?></div>
                <div class="section">
                    <div class="element"><input class="textfield" name="tcr-insta-tag" type="text" id="tcr-insta-tag" value="" /></div>
                </div>
                <br class="tc-mce-clear" />
            </div>  

            <div class="option">
                <div class="mce-option-title"><?php _e('Image Count', 'tcrinsta') ?></div>
                <div class="section">
                    <div class="element"><input class="textfield" name="tcr-insta-count" type="text" id="tcr-insta-count" value="6" /></div>
                </div>
                <br class="tc-mce-clear" />
            </div>  

            <div class="option">
                <div class="mce-option-title"><?php _e('Image Size', 'tcrinsta') ?></div>
                <div class="section">
                    <div class="element"><input class="textfield" name="tcr-insta-size" type="text" id="tcr-insta-size" value="70" /></div>
                </div>
                <br class="tc-mce-clear" />
            </div>  

            <div class="option">
                <div class="mce-option-title"><?php _e('Columns', 'tcrinsta') ?></div>
                <div class="section">
                    <div class="element"><input class="textfield" name="tcr-insta-cols" type="text" id="tcr-insta-cols" value="3" /></div>
                </div>
                <br class="tc-mce-clear" />
            </div>              

            <div class="option">
                <div class="mce-option-title"><?php _e('Enable Lightbox', 'tcrinsta') ?></div>
                <div class="section">
                    <div class="element">
                        <div class="tc-checkbox-wrap-wide">
                            <label><input name="tcr-insta-lightbox" type="checkbox" class="tc-checkbox" id="tcr-insta-lightbox" value="true" checked="checked" /><?PHP _e('Enable Lightbox', 'tcrinsta'); ?></label><br />
                        </div>
                    </div>
                </div>
                <br class="tc-mce-clear" />
            </div>

            <div class="option">
                <div class="mce-option-title"><?php _e('Follow Button', 'tcrinsta') ?></div>
                <div class="section">
                    <div class="element">
                        <div class="tc-checkbox-wrap-wide">
                            <label><input name="tcr-insta-follow" type="checkbox" class="tc-checkbox" id="tcr-insta-follow" value="true" /><?PHP _e('Show Follow Button', 'tcrinsta'); ?></label><br />
                        </div>
                    </div>
                </div>
                <br class="tc-mce-clear" />
            </div>
           
            <div class="tc-mce-buttons">
            	<input type="button" class="button-primary" value="<?PHP _e('Insert Shortcode', 'tcrinsta'); ?>" onclick="addShortcode();" />
            </div>  
        
        </form>
    
    </div>

</div>

</body>
</html>
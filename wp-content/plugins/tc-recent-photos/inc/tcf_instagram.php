<?PHP

// Boostrap WP
$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
  $wp_include = "../$wp_include";
}

// let's load WordPress
require($wp_include);

// Get options
global $tcrinsta_options;

// Set Token if Able
$close = 'false';
if( current_user_can( 'manage_options' ) ){
	
	if( isset( $_GET['newToken'] ) ){
		
		$token = $_GET['newToken'];
		
		update_option('tcrinsta-insta-access-token', $token);
		
		_e('Access Token has been saved! You can now close this window and refresh your settings to confirm your access token.', 'tcrinsta');
		
		$close = 'true';
		
	}
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Instagram Recent Photos</title>
<script language="javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/jquery/jquery.js"></script>

<script language="javascript" type="text/javascript">

	var thisClose = '<?PHP echo $close; ?>';
	if( thisClose == 'true' ){
		//window.close();
	}

	if(window.location.hash) {
		var hash = window.location.hash.substring(1);
		var regexp = /=(.*)/g;
		var token = regexp.exec(hash);
		if( token == '' ){
			console.log('Error, Instagram Returned No Token:');
			console.log(hash);
		} else {
			window.location = "<?PHP echo TCRINSTA_INSTAGRAM_URI; ?>?newToken="+token[1];
		}
	}
	
</script>
</head>

<body>


</body>
</html>
<?PHP
	
/*-----------------------------------------------------------------------------------*/
/*	Fetch Pins
/*-----------------------------------------------------------------------------------*/

function tcrinsta_getFeed($username, $count, $size, $cloumns, $lightbox, $follow){
	
	// Start Output
	$output = '';

	// Configure image size
	$retina = ( $size * 2 );
	
	// get the cached data
	$user_data = get_transient('tcrinsta-photos-'.$username);
	$access_token = get_option('tcrinsta-insta-access-token');
	
	// check to see if data was successfully retrieved from the cache
	if( false === $user_data ){		
		// Get Latest Images
		$profilePage = tcrinsta_api('https://api.instagram.com/v1/users/'.$username.'/media/recent/?access_token='.$access_token);		
		// store the data and set it to expire in 3 hours
		set_transient( 'tcrinsta-photos-'.$username, $profilePage, 60*60*3 );
		// return data
		$image_data = json_decode($profilePage);
	} else {
		$image_data = json_decode($user_data);
	}
		
	// Count Setup (12 Max)
	if( $count > 12 ){
		$count = 12;
	} else if( $count <= 0 ){
		$count = 1;
	}
			
	// Meta Check
	$metaCode = $image_data->meta->code;
	if( $metaCode == '200' ){
		
		// For Each Image
		if( count($image_data->data) > 0 ){
					
			$output.= '<ul class="tcr-insta-list">';
			
			$x = 1;
			
			// for each
			foreach($image_data->data as $baseImage){
							
				// check image limit
				if($x <= $count){
			
					// Construct Image
					$imageurl = $baseImage->images->standard_resolution->url;					
					if($x % $cloumns == 0){
						$class = 'last';
					} else {
						$class = '';
					}
					
					// Creaate Image Tag
					$thisImage = '<img src="'.TCRINSTA_LOCATION.'/inc/timthumb.php?src='.$imageurl.'&zc=1&q=90&h='.$retina.'&w='.$retina.'" alt="Instagram Photo" height="'.$size.'" width="'.$size.'" />';
					
					// Configure href
					if($lightbox == 'true'){
						$link = '<a class="thickbox" rel="tcrinsta-'.str_replace(' ', '-', $tag).'" href="'.$imageurl.'">'.$thisImage.'</a>';
					} else {
						$link = '<a href="'.$baseImage->link.'" target="_blank">'.$thisImage.'</a>';
					}
			
					// Output Image
					$output.= '<li class="photo '.$class.'">'.$link.'</li>';
					if( $class == 'last' ){
						$output.= '<br class="tcrinsta-row" />';
					}
					$x++;
					
				} // end count check
							
			} // end for each
		
			$output.= '</ul>';
			
			// Show Follow Button?
			if( $follow == 'true' ){
				$output.= '<p><a href="http://instagram.com/'.get_option('tcrinsta-insta-follow-name').'" target="_blank">'.__('Follow Me', 'tcrinsta').'</a> '.__('on Instagram', 'tcrinsta').'</p>';
			}
			
		} else {
			
			$output.= '<p class="tcrinsta-noimages">'.__('No images could be found on Instagram!', 'tcrinsta').'</p>';
			
		} // end if images found
	
	} else { // else error code
	
		$output.= 'Instagram Error '.$image_data->meta->code.': '.$image_data->meta->error_message;	
		
	}
	
	// Return Output
	return $output;

}

/*-----------------------------------------------------------------------------------*/
/*	Fetch Images From Tags
/*-----------------------------------------------------------------------------------*/

function tcrinsta_getTagMedia($tag, $username, $count, $size, $cloumns, $lightbox, $follow){
	
	// Setup Vars
	$output = '';
	$retina = ( $size * 2 );
	$tag = trim( $tag );
	$client_id = get_option('tcrinsta-insta-client-id');	

	// get the cached data
	$media_data = get_transient('tcrinsta-photos-'.$tag);
	
	// check to see if data was successfully retrieved from the cache
	if( false === $media_data ){
		// Get Latest Images from Tag
		$tag_data = tcrinsta_api('https://api.instagram.com/v1/tags/'.urlencode( str_replace(' ', '', $tag) ).'/media/recent?client_id='.$client_id);
		// store the data and set it to expire in 3 hours
		set_transient( 'tcrinsta-photos-'.$tag, $tag_data, 60*60*3 );
		// return data
		$image_data = json_decode($tag_data);
	} else {
		$image_data = json_decode($media_data);
	}
	
	// Count Setup (12 Max)
	if( $count > 12 ){
		$count = 12;
	} else if( $count <= 0 ){
		$count = 1;
	}
	
	// Meta Check
	$metaCode = $image_data->meta->code;
	if( $metaCode == '200' ){
		
		// For Each Image
		if( count($image_data->data) > 0 ){
					
			$output.= '<ul class="tcr-insta-list">';
			
			$x = 1;
			
			// for each
			foreach($image_data->data as $baseImage){
							
				// check image limit
				if($x <= $count){
			
					// Construct Image
					$imageurl = $baseImage->images->standard_resolution->url;					
					if($x % $cloumns == 0){
						$class = 'last';
					} else {
						$class = '';
					}
					
					// Creaate Image Tag
					$thisImage = '<img src="'.TCRINSTA_LOCATION.'/inc/timthumb.php?src='.$imageurl.'&zc=1&q=90&h='.$retina.'&w='.$retina.'" alt="Instagram Photo" height="'.$size.'" width="'.$size.'" />';
					
					// Configure href
					if($lightbox == 'true'){
						$link = '<a class="thickbox" rel="tcrinsta-'.str_replace(' ', '-', $tag).'" href="'.$imageurl.'">'.$thisImage.'</a>';
					} else {
						$link = '<a href="'.$baseImage->link.'" target="_blank">'.$thisImage.'</a>';
					}
			
					// Output Image
					$output.= '<li class="photo '.$class.'">'.$link.'</li>';
					if( $class == 'last' ){
						$output.= '<br class="tcrinsta-row" />';
					}
					$x++;
					
				} // end count check
							
			} // end for each
			
			$output.= '</ul>';
			
			// Show Follow Button?
			if( $follow == 'true' ){
				$output.= '<p><a href="http://instagram.com/'.get_option('tcrinsta-insta-follow-name').'" target="_blank">'.__('Follow Me', 'tcrinsta').'</a> '.__('on Instagram', 'tcrinsta').'</p>';
			}
			
		} else {
			
			$output.= '<p class="tcrinsta-noimages">'.__('No images could be found on Instagram!', 'tcrinsta').'</p>';
			
		} // end if images found
	
	} else { // else error code
	
		$output.= 'Instagram Error '.$image_data->meta->code.': '.$image_data->meta->error_message;	
		
	}
	
	// Return Output
	return $output;

}

/*-----------------------------------------------------------------------------------*/
/*	cURL Wrappers
/*-----------------------------------------------------------------------------------*/

function tcrinsta_curl($url){
	$ch = curl_init ($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$userAgent = 'Mozilla/5.0 (Linux; Android 4.1.1; Nexus 7 Build/JRO03D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Safari/535.19';
	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	$rawdata = curl_exec($ch);
	curl_close ($ch);
	return $rawdata;
}

function tcrinsta_api($url){
	$ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$rawdata = curl_exec($ch);
	curl_close ($ch);
	return $rawdata;
}

?>
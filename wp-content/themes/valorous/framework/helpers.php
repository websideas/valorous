<?php

/**
 * All helpers for theme
 *
 */

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Add search to header
 * 
 * 
 */
function kt_search_form(){
    if(kt_is_wc()){
        get_product_search_form();
    }else{
        get_search_form();
    }
}
/**
 * Function check if WC Plugin installed
 */
function kt_is_wc(){
    return function_exists('is_woocommerce');
}

/**
 *  @true  if WPML installed.
 */
function  kt_is_wpml(){
    return function_exists('icl_get_languages');
}

/**
 * Get Page id - Supported WPML Plguin
 * @return page id
 */
function kt_get_page_id(  $ID , $post_type= 'page'){
    if(kt_is_wpml()){
        $ID =   icl_object_id($ID, $post_type , true) ;
    }
    return $ID;
}

/**
 *
 * Detect plugin.
 *
 * @param $plugin example: 'plugin-directory/plugin-file.php'
 */

function kt_is_active_plugin(   $plugin ){
    if(  !function_exists( 'is_plugin_active' ) ){
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    // check for plugin using plugin name
    return is_plugin_active( $plugin ) ;
}

/**
 * Flag boolean.
 * 
 * @param $input string
 * @return boolean
 */
function kt_sanitize_boolean( $input = '' ) {
	return in_array($input, array('1', 'true', 'y', 'on'));
}
add_filter( 'sanitize_boolean', 'kt_sanitize_boolean', 15 );

/**
 * Convert hexdec color string to rgb(a) string
 *
 * @param $color string
 * @param $opacity boolean
 * @return void
 */

function kt_hex2rgba($color, $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
          return $default;

	//Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}

/**
 * Convert hexdec color string to darken or lighten
 *
 * http://lab.clearpixel.com.au/2008/06/darken-or-lighten-colours-dynamically-using-php/
 *
 * $brightness = 0.5; // 50% brighter
 * $brightness = -0.5; // 50% darker
 *
 */

function kt_colour_brightness($hex, $percent) {
	// Work out if hash given
	$hash = '';
	if (stristr($hex,'#')) {
		$hex = str_replace('#','',$hex);
		$hash = '#';
	}
	/// HEX TO RGB
	$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
	//// CALCULATE
	for ($i=0; $i<3; $i++) {
		// See if brighter or darker
		if ($percent > 0) {
			// Lighter
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
		} else {
			// Darker
			$positivePercent = $percent - ($percent*2);
			$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
		}
		// In case rounding up causes us to go to 256
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	//// RBG to Hex
	$hex = '';
	for($i=0; $i < 3; $i++) {
		// Convert the decimal digit to hex
		$hexDigit = dechex($rgb[$i]);
		// Add a leading zero if necessary
		if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}
	return $hash.$hex;
}

/**
* Function to get sidebars
* 
* @return array
*/

if (!function_exists('kt_sidebars')){
    function kt_sidebars( ){
        $sidebars = array();
        foreach ( $GLOBALS['wp_registered_sidebars'] as $item ) {
            $sidebars[$item['id']] = $item['name'];
        }
        return $sidebars;
    }
}

/**
* Function to get image sizes
* 
* @return array
*/

if (!function_exists('kt_get_image_sizes')){
    function kt_get_image_sizes( $size = '' ) {

            global $_wp_additional_image_sizes;
    
            $sizes = array();
            $get_intermediate_image_sizes = get_intermediate_image_sizes();
    
            // Create the full array with sizes and crop info
            foreach( $get_intermediate_image_sizes as $_size ) {
    
                    if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
    
                            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
                            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
                            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
    
                    } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
    
                            $sizes[ $_size ] = array( 
                                    'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                                    'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                                    'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
                            );
    
                    }
    
            }
    
            // Get only 1 size if found
            if ( $size ) {
    
                    if( isset( $sizes[ $size ] ) ) {
                            return $sizes[ $size ];
                    } else {
                            return false;
                    }
    
            }
    
            return $sizes;
    }
}


/**
* Function to get options in front-end
* @param int $option The option we need from the DB
* @param string $default If $option doesn't exist in DB return $default value
* @return string
*/

if (!function_exists('kt_option')){
    function kt_option( $option=false, $default=false ){
        if($option === FALSE){
            return FALSE;
        }
        $kt_options = wp_cache_get( THEME_OPTIONS );
        if(  !$kt_options ){
            $kt_options = get_option( THEME_OPTIONS );
            wp_cache_delete( THEME_OPTIONS );
            wp_cache_add( THEME_OPTIONS, $kt_options );
        }

        if(isset($kt_options[$option]) && $kt_options[$option] !== ''){
            return $kt_options[$option];
        }else{
            return $default;
        }
    }
}

/**
 * Get logo of current page
 * 
 * @return string
 * 
 */
function kt_get_logo(){
    $logo = array('default' => '', 'retina' => '','sticky' => '', 'sticky_retina' => '');
    
    $logo_default = kt_option( 'logo' );
    $logo_retina = kt_option( 'logo_retina' );
    $logo_sticky = kt_option( 'logo_sticky' );
    $logo_retina_sticky = kt_option( 'logo_retina_sticky' );
    
    
    if(is_array($logo_default) && $logo_default['url'] != '' ){
        $logo['default'] = $logo_default['url'];
    }
    
    if(is_array($logo_retina ) && $logo_retina['url'] != '' ){
        $logo['retina'] = $logo_retina['url'];
    }
    
    if(is_array($logo_sticky ) && $logo_sticky['url'] != '' ){
        $logo['sticky'] = $logo_sticky['url'];
    }else{
        $logo['sticky'] = $logo['default'];
    }
    
    if(is_array($logo_retina_sticky ) && $logo_retina_sticky['url'] != '' ){
        $logo['sticky_retina'] = $logo_retina_sticky['url'];
    }
    
    $layout = kt_option('header', 'layout1');
    
    if($layout == 'layout1'){
        if(!$logo['retina'] && !$logo['default']){
            $logo['retina'] = THEME_IMG.'logo-retina.png';
        }
        if(!$logo['default']){
            $logo['default'] = THEME_IMG.'logo.png';
        }
        if(!$logo['sticky_retina'] && !$logo['sticky']){
            $logo['sticky_retina'] = THEME_IMG.'logo-retina.png';
        }
        if(!$logo['sticky']){
            $logo['sticky'] = THEME_IMG.'logo.png';
        }
    }elseif($layout == 'layout2' || $layout == 'layout3'){
        if(!$logo['retina'] && !$logo['default']){
            $logo['retina'] = THEME_IMG.'logo-black-retina.png';
        }
        if(!$logo['default']){
            $logo['default'] = THEME_IMG.'logo-black.png';
        }
        if(!$logo['sticky_retina'] && !$logo['sticky']){
            $logo['sticky_retina'] = THEME_IMG.'logo-retina.png';
        }
        if(!$logo['sticky']){
            $logo['sticky'] = THEME_IMG.'logo.png';
        }
    }
    
    
    
    
    return $logo;
}

/**
 * Get Layout of post
 * 
 * @param number $post_id Optional. ID of article or page.
 * @return string
 * 
 */
function kt_getlayout($post_id = null){
    global $post;
	if(!$post_id) $post_id = $post->ID;

    $layout = rwmb_meta('_kt_layout');
    
    if($layout == 'default' || !$layout){
        $layout = kt_option('layout', 'full');
    }
    
    return $layout;
}

/**
 * Get Header
 * 
 * @return string
 * 
 */

function kt_get_header(){
    $header = 'default';
    if(is_page() || is_singular('post')){
        $header_position = rwmb_meta('_kt_header_position');
        if($header_position){
            $header = $header_position;
        }
    }
    return $header;
}

/**
 * Get Header Layout
 * 
 * @return string
 * 
 */
function kt_get_header_layout(){
    $layout = kt_option('header', 'layout1');
    return $layout;
}

/**
 * Get Layout sidebar of post
 * 
 * @return array
 * 
 */
function kt_sidebar(){
    global $post;
    
    $sidebar = kt_option('sidebar', 'full');
    $sidebar_left = kt_option('sidebar_left', 'primary-widget-area');
    $sidebar_right = kt_option('sidebar_right', 'primary-widget-area');

    if( kt_is_wc() ){
        if( is_shop() || is_product_category() || is_product_tag() ){
            $sidebar = kt_option('shop_sidebar', 'full');
            $sidebar_left = kt_option('shop_sidebar_left', 'shop-widget-area');
            $sidebar_right = kt_option('shop_sidebar_right', 'shop-widget-area');
        }elseif( is_product() ){
            $sidebar = kt_option('product_sidebar', 'full');
            $sidebar_left = kt_option('product_sidebar_left', 'shop-widget-area');
            $sidebar_right = kt_option('product_sidebar_right', 'shop-widget-area');
        }elseif(is_cart()){
            return array('sidebar' => 'full', 'sidebar_area' => null);
        }
    }
    
    if($sidebar == 'left'){
        $sidebar_area = $sidebar_left;
    }elseif($sidebar == 'right'){
        $sidebar_area = $sidebar_right;
    }else{
        $sidebar_area = null;
    }
    
    $layout_sidebar = array(
        'sidebar' => $sidebar,
        'sidebar_area' => $sidebar_area        
    );
    
    if(is_page() || is_singular('post') || is_home()){
        $page_id = get_the_ID();
        if(is_home()){
            $page_id = get_option( 'page_for_posts' );
        }

        $sidebar_post = rwmb_meta('_kt_sidebar', array(), $page_id);

        if($sidebar_post != 'default' && $sidebar_post){
            $layout_sidebar['sidebar'] = $sidebar_post;
            if($sidebar_post == 'left'){
                $sidebar_left_post = rwmb_meta('_kt_left_sidebar', array(), $page_id);
                if($sidebar_left_post  == 'default'){
                    $sidebar_left_post = $sidebar_left;
                }
                $layout_sidebar['sidebar_area'] = $sidebar_left_post;
            }elseif($sidebar_post == 'right'){
                $sidebar_right_post = rwmb_meta('_kt_right_sidebar', array(), $page_id);
                if($sidebar_right_post  == 'default'){
                    $sidebar_right_post = $sidebar_right;
                }
                $layout_sidebar['sidebar_area'] = $sidebar_right_post;
            }
        }
        
    }



    return $layout_sidebar;
}

/**
 * Get link attach from thumbnail_id.
 *
 * @param number $thumbnail_id ID of thumbnail.
 * @param string|array $size Optional. Image size. Defaults to 'post-thumbnail'
 * @return array
 */
if (!function_exists('get_thumbnail_attachment')){
    function get_thumbnail_attachment($thumbnail_id ,$size = 'post-thumbnail'){
        if(!$thumbnail_id) return ;
        
        $attachment = get_post( $thumbnail_id );
        if(!$attachment) return;
        
        $image = wp_get_attachment_image_src($thumbnail_id, $size);
    	return array(
    		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
    		'caption' => $attachment->post_excerpt,
    		'description' => $attachment->post_content,
            'src' => $attachment->guid,
    		'url' => $image[0],
    		'title' => $attachment->post_title
    	);
    }
}

/**
 * Get image form meta.
 * 
 * @param string $meta. meta id of article.
 * @param string|array $size Optional. Image size. Defaults to 'screen'.
 * @param number $post_id Optional. ID of article.
 * @return array
 */

function get_link_image_post($meta, $post_id = null, $size = 'screen') {
	global $post;
	if(!$post_id) $post_id = $post->ID;
    
	$media_image = rwmb_meta($meta, 'type=image&size='.$size, $post_id);
    
	if(!$media_image) return;
    
	foreach ($media_image as $item) {
		return $item;
		break;
	}
}

/**
 * Get all image form meta box.
 *
 * @param string $meta. meta id of article.
 * @param string|array $size Optional. Image size. Defaults to 'screen'.
 * @param array $post_id Optional. ID of article.
 * @return array
 */
function get_galleries_post($meta, $size = 'screen', $post_id = null) {
	global $post;
	if(!$post_id) $post_id = $post->ID;
	
	$media_image = rwmb_meta($meta, 'type=image&size='.$size, $post_id);
	return (count($media_image)) ? $media_image : false;
}


/**
 * Function to show youtube
 *
 * @return array
 */
function kt_video_youtube($video_id, $width = 640, $height = 480, $iframe = 1){
    if($iframe){
        return '<iframe itemprop="video" src="//www.youtube.com/embed/'. $video_id .'?wmode=transparent" width="'. $width .'" height="'. $height .'" ></iframe>';
    }else{
        return '//www.youtube.com/embed/'. $video_id;
    }
}
/**
 * Function to show vimeo
 *
 * @return array
 */
function kt_video_vimeo($video_id, $width = 640, $height = 480, $iframe = 1){
    if($iframe){
        return '<iframe itemprop="video" src="//player.vimeo.com/video/'. $video_id .'?title=0&amp;byline=0&amp;portrait=0?wmode=transparent" width="'. $width .'" height="'. $height .'"></iframe>';
    }else{
        return '//player.vimeo.com/video/'. $video_id;
    }

}
/**
 * Function to show youtube
 *
 * @return array
 */
function kt_video_dailymotion($video_id, $width = 640, $height = 480, $iframe = 1){
    if($iframe){
        return '<iframe itemprop="video" src="//www.dailymotion.com/embed/video/'.$video_id.'" width="'. $width .'" height="'. $height .'" ></iframe>';
    }else{
        return '//www.dailymotion.com/embed/video/'. $video_id;
    }
}

/**
 * Render Carousel
 *
 * @param $data array, All option for carousel
 * @param $class string, Default class for carousel
 *
 * @return void
 */

function kt_render_carousel($data, $class = ''){
    $data = shortcode_atts( array(
        'margin' => 10,
        'loop' => 'false',
        'autoheight' => 'true',
        'autoplay' => 'false',
        'mousedrag' => 'true',
        'autoplayspeed' => 5000,
        'slidespeed' => 200,
        'desktop' => 4,
        'tablet' => 2,
        'mobile' => 1,

        'navigation' => 'true',
        'navigation_always_on' => 'false',
        'navigation_position' => 'center_outside',
        'navigation_style' => '',
        'navigation_border_width' => '1',
        'navigation_border_color' => '',
        'navigation_background' => '',
        'navigation_color' => '',
        'navigation_icon' => 'fa fa-angle-left|fa fa-angle-right',

        'pagination' => 'true',
        'pagination_color' => '',
        'pagination_icon' => 'circle-o',
    ), $data );


    extract( $data );

    $output = $custom_css = '';
    $uniqid = 'owl-carousel-'.uniqid();

    $owl_carousel_class = array('owl-carousel-wrapper', 'carousel-navigation-'.$navigation_position, 'carousel-pagination-'.$pagination_icon, $class);
    if($navigation_always_on == 'false' && $navigation_position != 'bottom'){
        $owl_carousel_class[] = 'visiable-navigation';
    }
    if($navigation_style){
        $owl_carousel_class[] = 'carousel-navigation-'.$navigation_style;
    }
    if($pagination == 'true'){
        $owl_carousel_class[] = 'carousel-pagination-dots';
    }

    if($pagination == "true" && $pagination_color){
        $custom_css .= '#'.$uniqid.'.kt-owl-carousel .owl-dots .owl-dot span{color:'.$pagination_color.';}';
    }
    if($navigation == "true"){
        if($navigation_color){
            $custom_css .= '#'.$uniqid.'.kt-owl-carousel .owl-nav div{color:'.$navigation_color.';}';
        }
        if(($navigation_style == 'circle' || $navigation_style == 'square' || $navigation_style == 'round') && $navigation_background){
            $custom_css .= '#'.$uniqid.'.kt-owl-carousel .owl-nav div{background:'.$navigation_background.';}';
        }elseif(($navigation_style == 'circle_border' || $navigation_style == 'square_border' || $navigation_style == 'round_border') && $navigation_border_width){
            $custom_css .= '#'.$uniqid.'.kt-owl-carousel .owl-nav div{border:'.$navigation_border_width.'px solid;}';
            if($navigation_border_color){
                $custom_css .= '#'.$uniqid.'.kt-owl-carousel .owl-nav div{border-color:'.$navigation_border_color.';}';
            }
        }
    }

    $autoplay = ($autoplay == 'true') ? $autoplayspeed : $autoplay;

    $data_carousel = array(
        'mousedrag' => $mousedrag,
        "autoheight" => $autoheight,
        "autoplay" => $autoplay,
        'navigation_icon' => $navigation_icon,
        "margin" => $margin,
        "nav" => $navigation,
        "slidespeed" => $slidespeed,
        'desktop' => $desktop,
        'tablet' => $tablet,
        'mobile' => $mobile,
        "dots" => $pagination,
        "loop" => $loop,
    );
    $output .= '<div class="'.esc_attr(implode(' ', $owl_carousel_class)).'">';
    $output .= '<div id="'.esc_attr($uniqid).'" class="owl-carousel kt-owl-carousel" '.render_data_carousel($data_carousel).'>%carousel_html%</div>';
    $output .= '</div>';

    if($custom_css){
        $custom_css = '<div class="kt_custom_css">'.$custom_css.'</div>';
    }

    return $output.$custom_css;
}



/**
 * Render data option for carousel
 * 
 * @param $data array. All data for carousel
 * 
 */
function render_data_carousel($data){
    $output = "";
    foreach($data as $key => $val){
        if($val != ''){
            $output .= ' data-'.$key.'="'.esc_attr($val).'"';
        }
    }
    return $output;
}
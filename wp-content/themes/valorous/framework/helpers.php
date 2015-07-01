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

if (!function_exists('kt_sidebars')){
    /**
     * Get sidebars
     *
     * @return array
     */

    function kt_sidebars( ){
        $sidebars = array();
        foreach ( $GLOBALS['wp_registered_sidebars'] as $item ) {
            $sidebars[$item['id']] = $item['name'];
        }
        return $sidebars;
    }
}



if (!function_exists('kt_get_image_sizes')){
    /**
     * Get image sizes
     *
     * @return array
     */
    function kt_get_image_sizes( $full = true, $custom = false ) {

        global $_wp_additional_image_sizes;
        $get_intermediate_image_sizes = get_intermediate_image_sizes();
        $sizes = array();
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

            $option_text = array();
            $option_text[] = ucfirst(str_replace('_', ' ', $_size));
            $option_text[] = '('.$sizes[ $_size ]['width'].' x '.$sizes[ $_size ]['height'].')';
            if($sizes[ $_size ]['crop']){
                $option_text[] = __('Crop', THEME_LANG);
            }
            $sizes[ $_size ] = implode(' - ', $option_text);
        }

        if($full){
            $sizes[ 'full' ] = __('Full', THEME_LANG);
        }
        if($custom){
            $sizes[ 'custom' ] = __('Custom size', THEME_LANG);
        }


        return $sizes;
    }
}


if (!function_exists('kt_get_woo_sidebar')) {
    /**
     * Get woo sidebar
     *
     * @param null $post_id
     * @return array
     */
    function kt_get_woo_sidebar( $post_id = null )
    {
        if(is_product() || $post_id){
            global $post;
            if(!$post_id) $post_id = $post->ID;

            $sidebar = array(
                'sidebar' => rwmb_meta('_kt_sidebar', array(), $post_id),
                'sidebar_area' => '',
            );

            if($sidebar['sidebar'] == '' || $sidebar['sidebar'] == 'default' ){
                $sidebar['sidebar'] = kt_option('product_sidebar', 'full');
                if($sidebar['sidebar'] == 'left' ){
                    $sidebar['sidebar_area'] = kt_option('product_sidebar_left', 'shop-widget-area');
                }elseif($sidebar['sidebar'] == 'right'){
                    $sidebar['sidebar_area'] = kt_option('product_sidebar_right', 'shop-widget-area');
                }
            }elseif($sidebar['sidebar'] == 'left'){
                $sidebar['sidebar_area'] = rwmb_meta('_kt_left_sidebar', array(), $post_id);
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = rwmb_meta('_kt_right_sidebar', array(), $post_id);
            }

        }elseif(is_shop() || is_product_taxonomy()){
            $sidebar = array(
                'sidebar' => kt_option('shop_sidebar', 'full'),
                'sidebar_area' => '',
            );
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('shop_sidebar_left', 'shop-widget-area');
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('shop_sidebar_right', 'shop-widget-area');
            }
        }
        return apply_filters('woo_sidebar', $sidebar);

    }
}



if (!function_exists('kt_get_page_sidebar')) {
    /**
     * Get page sidebar
     *
     * @param null $post_id
     * @return mixed|void
     */
    function kt_get_page_sidebar( $post_id = null )
    {
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $sidebar = array(
            'sidebar' => rwmb_meta('_kt_sidebar', array(), $post_id),
            'sidebar_area' => '',
        );
        if($sidebar['sidebar'] == '' || $sidebar['sidebar'] == 'default' ){
            $sidebar['sidebar'] = kt_option('sidebar', 'full');
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('sidebar_left', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('sidebar_right', 'primary-widget-area');
            }
        }elseif($sidebar['sidebar'] == 'left'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_left_sidebar', array(), $post_id);
        }elseif($sidebar['sidebar'] == 'right'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_right_sidebar', array(), $post_id);
        }

        return apply_filters('page_sidebar', $sidebar);

    }
}

if (!function_exists('kt_get_single_sidebar')) {
    /**
     * Get Single post sidebar
     *
     * @param null $post_id
     * @return array
     */
    function kt_get_single_sidebar( $post_id = null )
    {
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $sidebar = array(
            'sidebar' => rwmb_meta('_kt_sidebar', array(), $post_id),
            'sidebar_area' => '',
        );
        if($sidebar['sidebar'] == '' || $sidebar['sidebar'] == 'default' ){
            $sidebar['sidebar'] = kt_option('blog_sidebar', 'full');
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('blog_sidebar_left', 'blog-widget-area');
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('blog_sidebar_right', 'blog-widget-area');
            }
        }elseif($sidebar['sidebar'] == 'left'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_left_sidebar', array(), $post_id);
        }elseif($sidebar['sidebar'] == 'right'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_right_sidebar', array(), $post_id);
        }

        return apply_filters('single_sidebar', $sidebar);
    }

}
if (!function_exists('kt_get_archive_sidebar')) {
    /**
     * Get Archive sidebar
     *
     * @return array
     */
    function kt_get_archive_sidebar()
    {
        $sidebar = array(
            'sidebar' => kt_option('archive_sidebar', 'full'),
            'sidebar_area' => '',
        );
        if($sidebar['sidebar'] == 'left' ){
            $sidebar['sidebar_area'] = kt_option('archive_sidebar_left', 'blog-widget-area');
        }elseif($sidebar['sidebar'] == 'right'){
            $sidebar['sidebar_area'] = kt_option('archive_sidebar_right', 'blog-widget-area');
        }
        return apply_filters('archive_sidebar', $sidebar);
    }

}



if (!function_exists('kt_option')){
    /**
     * Function to get options in front-end
     * @param int $option The option we need from the DB
     * @param string $default If $option doesn't exist in DB return $default value
     * @return string
     */

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
    $logo = array('default' => '', 'logo_dark' => '');
    
    $logo_default = kt_option( 'logo' );
    $logo_dark = kt_option( 'logo_dark' );

    if(is_array($logo_default) && $logo_default['url'] != '' ){
        $logo['default'] = $logo_default['url'];
    }

    if(is_array($logo_dark ) && $logo_dark['url'] != '' ){
        $logo['logo_dark'] = $logo_dark['url'];
    }

    if($logo['default'] && !$logo['logo_dark']){
        $logo['logo_dark'] = $logo['default'];
    }elseif(!$logo['default'] && $logo['logo_dark']){
        $logo['default'] = $logo['logo_dark'];
    }

    if(!$logo['default'] && !$logo['logo_dark']){
        $logo['default'] = THEME_IMG.'logo-light.png';
        $logo['logo_dark'] = THEME_IMG.'logo-dark.png';
    }

    return $logo;
}
/**
 * Get header scheme
 *
 * @param number $post_id Optional. ID of article or page.
 * @return string
 *
 */
function kt_get_header_scheme(){
    $scheme = array(
        'scheme' => rwmb_meta('_kt_header_scheme'),
        'sticky' => rwmb_meta('_kt_header_scheme_fixed')
    );
    if(!$scheme['scheme']){
        $scheme['scheme'] = kt_option('header_scheme', 'dark');
    }
    if(!$scheme['sticky']){
        $scheme['sticky'] = kt_option('header_scheme_fixed', 'dark');
    }
    return $scheme;
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

    $layout = rwmb_meta('_kt_layout', array(),  $post_id);
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
    $header_position = rwmb_meta('_kt_header_position');
    if($header_position){
        $header = $header_position;
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
 * Get Single file form meta box.
 *
 * @param string $meta. meta id of article.
 * @param string|array $size Optional. Image size. Defaults to 'screen'.
 * @param array $post_id Optional. ID of article.
 * @return array
 */
function kt_get_single_file($meta, $post_id = null) {
    global $post;
    if(!$post_id) $post_id = $post->ID;
    $medias = rwmb_meta($meta, 'type=file', $post_id);
    if (count($medias)){
        foreach($medias as $media){
            return $media['url'];
        }
    }
    return false;
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
        $custom_css .= '#'.$uniqid.' .kt-owl-carousel .owl-pagination .owl-page span{color:'.$pagination_color.';}';
    }
    if($navigation == "true"){
        if($navigation_color){
            $custom_css .= '#'.$uniqid.' .kt-owl-carousel .owl-buttons div{color:'.$navigation_color.';}';
        }
        if(($navigation_style == 'circle' || $navigation_style == 'square' || $navigation_style == 'round') && $navigation_background){
            $custom_css .= '#'.$uniqid.' .kt-owl-carousel .owl-buttons div{background:'.$navigation_background.';}';
        }elseif(($navigation_style == 'circle_border' || $navigation_style == 'square_border' || $navigation_style == 'round_border') && $navigation_border_width){
            $custom_css .= '#'.$uniqid.' .kt-owl-carousel .owl-buttons div{border:'.$navigation_border_width.'px solid;}';
            if($navigation_border_color){
                $custom_css .= '#'.$uniqid.'.kt-owl-carousel .owl-buttons div{border-color:'.$navigation_border_color.';}';
            }
        }
    }
    if(intval($margin)){
        $custom_css .= '#'.$uniqid.' .kt-owl-carousel .owl-item{padding-left: '.$margin.'px;padding-right: '.$margin.'px;}';
        $custom_css .= '#'.$uniqid.'{margin-left: -'.$margin.'px;margin-right: -'.$margin.'px;}';
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
    $output .= '<div id="'.esc_attr($uniqid).'" class="owl-carousel-kt"><div class="owl-carousel owl-kttheme kt-owl-carousel" '.render_data_carousel($data_carousel).'>%carousel_html%</div></div>';
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





/**
 * Check option for in article
 *
 * @param number $post_id Optional. ID of article.
 * @param string $meta Optional. meta oftion in article
 * @param string $option Optional. if meta is Global, Check option in theme option.
 * @param string $default Optional. Default vaule if theme option don't have data
 * @return boolean
 */
function kt_post_option($post_id = null, $meta = '', $option = '', $default = null){
    global $post;
    if(!$post_id) $post_id = $post->ID;

    $meta_v = get_post_meta($post_id, $meta, true);

    if($meta_v == -1 || $meta_v == '' ){
        $meta_v = kt_option($option, $default);
    }
    return $meta_v;
}
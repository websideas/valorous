<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

//  0 - unsorted and appended to bottom Default  
//  1 - Appended to top)

vc_add_param( 'vc_single_image', array(    
    'type' => 'dropdown',    
    'heading' => __("Image effect", THEME_LANG),    
    'param_name' => 'effect',
    'value' => array( 
        __("None", THEME_LANG) => "",
        __("Creative", THEME_LANG) => "creative",
        __("Simple Fade", THEME_LANG) => "simple",
        __("Zoom in", THEME_LANG) => "zoomin", 
        __('Zoom out', THEME_LANG) => "zoomout",
        __('Mask Side to center', THEME_LANG) => "sidetocenter",
        
    ),
    'description' => __( "Image effect when hover", THEME_LANG),
    'dependency' => array(
		'element' => 'style',
		'is_empty' => true
	) 
));


vc_add_param("vc_row", array(
	'type' => 'dropdown',
	'heading' => __( 'Equal height', THEME_LANG ),
	'param_name' => 'equal_height',
	'description' => __( 'Check here if you want column equal height.', THEME_LANG ),
	'value' => array( 
        __("None", THEME_LANG) => "",
        __("Column", THEME_LANG) => "column",
        __("Content item", THEME_LANG) => "content"
    ),
));


vc_add_param("vc_row_inner", array(
	'type' => 'dropdown',
	'heading' => __( 'Equal height', THEME_LANG ),
	'param_name' => 'equal_height',
	'description' => __( 'Check here if you want column equal height.', THEME_LANG ),
	'value' => array( 
        __("None", THEME_LANG) => "",
        __("Column", THEME_LANG) => "column",
        __("Content item", THEME_LANG) => "content"
    ),
));



$composer_addons = array(
    'categories_products.php',
    'contact_info.php',
    'clients_carousel.php',
    'blog_posts_carousel.php',
    'sales_countdown.php',
    'designer_collection_carousel.php',
    'category_products_tab.php',
    'categories_top_sellers.php',
    'blog_posts.php',
    'button.php',
    'widget_products_carousel.php',
    'widget_testimonials.php',
    'vc_gitem_post_metadata.php',
    'designer_products.php'
);

foreach ( $composer_addons as $addon ) {
	require_once( FW_DIR . 'js_composer/vc_addons/' . $addon );
}
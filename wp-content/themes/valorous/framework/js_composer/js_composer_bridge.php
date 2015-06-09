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
        'element' => 'parallax',
        'value' => array( 'content-moving', 'content-moving-fade' ),
    ),
));

vc_add_params("vc_row", array(
    array(
        'type' => 'dropdown',
        'heading' => __( 'Equal height', THEME_LANG ),
        'param_name' => 'equal_height',
        'description' => __( 'Check here if you want column equal height.', THEME_LANG ),
        'value' => array(
            __("None", THEME_LANG) => "",
            __("Column", THEME_LANG) => "column",
            __("Content item", THEME_LANG) => "content"
        )
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Color Overlay', 'js_composer' ),
        'param_name' => 'color_overlay',
        'description' => __( 'Select your color overlay for image and video ( rgba ).', 'js_composer' ),
    ),
));

vc_add_params("vc_row_inner", array(
    array(
        'type' => 'dropdown',
        'heading' => __( 'Equal height', THEME_LANG ),
        'param_name' => 'equal_height',
        'description' => __( 'Check here if you want column equal height.', THEME_LANG ),
        'value' => array(
            __("None", THEME_LANG) => "",
            __("Column", THEME_LANG) => "column",
            __("Content item", THEME_LANG) => "content"
        ),
    ),
));

vc_add_params("vc_icon", array(
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Custom Icon Background', 'js_composer' ),
        'param_name' => 'custom_background',
        'description' => __( 'Select Background icon color.', 'js_composer' ),
        'dependency' => array(
            'element' => 'background_color',
            'value' => 'custom',
        ),
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Icon color on Hover', 'js_composer' ),
        'param_name' => 'color_hover',
        'description' => __( 'Select icon color on hover.', 'js_composer' ),
        'group' => __( 'Hover', 'js_composer' ),
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Background on Hover', 'js_composer' ),
        'param_name' => 'background_color_hover',
        'description' => __( 'Select Background icon color on hover.', 'js_composer' ),
        'group' => __( 'Hover', 'js_composer' ),
        'dependency' => array(
            'element' => 'background_style',
            'not_empty' => true,
        ),
    ),

));

$composer_addons = array(
    'alert.php',
    'list.php',
    'icon_box.php',
    'counter.php',
    'heading.php',
    'callout.php',
    'divider.php',
    //'categories_products.php',
    'contact_info.php',
    'clients_carousel.php',
    'blog_posts_carousel.php',
    'recentpost.php',
    'testimonial_carousel.php',
    //'sales_countdown.php',
    //'designer_collection_carousel.php',
    //'category_products_tab.php',
    //'categories_top_sellers.php',
    'blog_posts.php',
    'button.php',
    //'widget_products_carousel.php',
    //'widget_testimonials.php',
    'vc_gitem_post_metadata.php',
    'skill.php',
    'socials.php',
    //'designer_products.php',
    'team.php',
    'timeline.php',
    'dropcap.php',
    'lightbox.php'
);

foreach ( $composer_addons as $addon ) {
	require_once( FW_DIR . 'js_composer/vc_addons/' . $addon );
}
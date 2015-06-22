<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

//  0 - unsorted and appended to bottom Default  
//  1 - Appended to top)

vc_remove_param( "vc_row", "parallax" );
vc_remove_param( "vc_row", "parallax_image" );



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
        'heading' => __( 'Background', 'js_composer' ),
        'param_name' => 'background_type',
        'value' => array(
            __( 'None', 'js_composer' ) => '',
            __( 'Parallax Simple', THEME_LANG ) => 'content-moving',
            __( 'Parallax With fade', THEME_LANG ) => 'content-moving-fade',
            //__( 'Youtube - Vimeo URL', THEME_LANG) => 'external',
            //__( 'Video upload', THEME_LANG) => 'upload'
        ),
        'group' => __( 'Background', 'js_composer' ),
        'description' => __( 'Select type of background.', THEME_LANG ),
    ),
    array(
        'type' => 'attach_image',
        'heading' => __( 'Image', 'js_composer' ),
        'param_name' => 'parallax_image',
        'value' => '',
        'description' => __( 'Add parallax type background for row (Note: If no image is specified, parallax will use background image from Design Options).', 'js_composer' ),
        'dependency' => array(
            'element' => 'background_type',
            'value' => array('content-moving', 'content-moving-fade'),
        ),
        'group' => __( 'Background', 'js_composer' ),
    ),
    /*
     array(
        'type' => 'textfield',
        'heading' => __( 'Youtube - Vimeo URL', 'js_composer' ),
        'param_name' => 'external_link',
        'description' => __( 'Put link Youtube or Vimeo', THEME_LANG ),
        'group' => __( 'Background', 'js_composer' ),
        'dependency' => array(
            'element' => 'background_type',
            'value' => array('external'),
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __( 'Video WebM Upload', 'js_composer' ),
        'param_name' => 'video_webm',
        'description' => __( 'Add your WebM video file. WebM and MP4 format must be included to render your video with cross browser compatibility.', THEME_LANG ),
        'group' => __( 'Background', 'js_composer' ),
        'dependency' => array(
            'element' => 'background_type',
            'value' => array('upload'),
        ),
    ),
    array(
        'type' => 'textfield',
        'heading' => __( 'Video MP4 Upload', 'js_composer' ),
        'param_name' => 'video_mp4',
        'description' => __( 'Add your WebM video file. WebM and MP4 format must be included to render your video with cross browser compatibility.', THEME_LANG ),
        'group' => __( 'Background', 'js_composer' ),
        'dependency' => array(
            'element' => 'background_type',
            'value' => array('upload'),
        ),
    ),
    array(
        'type' => 'attach_image',
        'heading' => __( 'Video Preview Image', 'js_composer' ),
        'param_name' => 'video_image',
        'value' => '',
        'description' => __( 'This field must be used for self hosted videos. Self hosted videos do not work correctly on mobile devices.', THEME_LANG ),
        'dependency' => array(
            'element' => 'background_type',
            'value' => array('upload'),
        ),
        'group' => __( 'Background', 'js_composer' ),
    ),
    */


    array(
        'group' => __( 'Background', 'js_composer' ),
        'type' => 'colorpicker',
        'heading' => __( 'Color Overlay', 'js_composer' ),
        'param_name' => 'color_overlay',
        'description' => __( 'Select your color overlay for image and video ( rgba ).', THEME_LANG ),
        'dependency' => array(
            'element' => 'background_type',
            'not_empty' => true,
        ),
    ),
    array(
        'type' => 'dropdown',
        'heading' => __( 'Set Columns to Equal Height', THEME_LANG ),
        'param_name' => 'equal_height',
        'description' => __( 'Check here if you want column equal height.', THEME_LANG ),
        'value' => array(
            __("None", THEME_LANG) => "",
            __("Column", THEME_LANG) => "column",
        ),
        'group' => __( 'Extra', 'js_composer' ),
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Font Color', THEME_LANG ),
        'param_name' => 'font_color',
        'description' => __( 'Select Font Color', THEME_LANG ),
        'group' => __( 'Extra', 'js_composer' ),
    ),
    array(
        'type' => 'dropdown',
        'heading' => __( 'Top of the section', 'js_composer' ),
        'param_name' => 'top_section',
        'value' => array(
            __( 'None', 'js_composer' ) => '',
            __( 'Divider', THEME_LANG ) => 'divider',
        ),
        'group' => __( 'Extra', 'js_composer' ),
        'description' => __( 'Select top of the section.', THEME_LANG ),
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Divider Color', THEME_LANG ),
        'param_name' => 'top_divider_color',
        'description' => __( 'Select divider Color', THEME_LANG ),
        'group' => __( 'Extra', 'js_composer' ),
        'dependency' => array(
            'element' => 'top_section',
            'value' => array('divider'),
        ),
    ),
    array(
        'type' => 'dropdown',
        'heading' => __( 'Top of the section', 'js_composer' ),
        'param_name' => 'bottom_section',
        'value' => array(
            __( 'None', 'js_composer' ) => '',
            __( 'Divider', THEME_LANG ) => 'divider',
        ),
        'group' => __( 'Extra', 'js_composer' ),
        'description' => __( 'Select top of the section.', THEME_LANG ),
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Divider Color', THEME_LANG ),
        'param_name' => 'bottom_divider_color',
        'description' => __( 'Select divider Color', THEME_LANG ),
        'group' => __( 'Extra', 'js_composer' ),
        'dependency' => array(
            'element' => 'bottom_section',
            'value' => array('divider'),
        ),
    ),




));

vc_add_params("vc_row_inner", array(
    array(
        'type' => 'dropdown',
        'heading' => __( 'Set Columns to Equal Height', THEME_LANG ),
        'param_name' => 'equal_height',
        'description' => __( 'Check here if you want column equal height.', THEME_LANG ),
        'value' => array(
            __("None", THEME_LANG) => "",
            __("Column", THEME_LANG) => "column",
        ),
        'group' => __( 'Extra', 'js_composer' ),
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Font Color', THEME_LANG ),
        'param_name' => 'font_color',
        'description' => __( 'Select Font Color', THEME_LANG ),
        'group' => __( 'Extra', 'js_composer' ),
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
    'lightbox.php',
    'piechart.php'
);

foreach ( $composer_addons as $addon ) {
	require_once( FW_DIR . 'js_composer/vc_addons/' . $addon );
}
<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

//  0 - unsorted and appended to bottom Default  
//  1 - Appended to top)

vc_add_params("vc_row", array(
    array(
        'group' => __( 'Extra', 'js_composer' ),
        'type' => 'colorpicker',
        'heading' => __( 'Color Overlay', 'js_composer' ),
        'param_name' => 'color_overlay',
        'description' => __( 'Select your color overlay for image and video ( rgba ).', THEME_LANG ),
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
        'description' => __( 'Only working with background color and not paralax.', THEME_LANG ),
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
        'heading' => __( 'Bottom of the section', 'js_composer' ),
        'param_name' => 'bottom_section',
        'value' => array(
            __( 'None', 'js_composer' ) => '',
            __( 'Divider', THEME_LANG ) => 'divider',
        ),
        'group' => __( 'Extra', 'js_composer' ),
        'description' => __( 'Only working with background color and not paralax.', THEME_LANG ),
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


vc_add_params( 'vc_single_image', array(
    array(
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
    ),
    array(
        'type' => 'dropdown',    
        'heading' => __("Show Social", THEME_LANG),    
        'param_name' => 'show_social',
        'value' => array( 
            __("None", THEME_LANG) => "",
            __("Yes", THEME_LANG) => "yes",
        ),
        'description' => __( "Image social shar", THEME_LANG),
    )
));

vc_add_params("vc_icon", array(
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
    array(
        'type' => 'hidden',
        'heading' => '',
        'param_name' => 'hover_div',
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
    'contact_info.php',
    'clients_carousel.php',
    'testimonial_carousel.php',
    'blog_posts.php',
    'blog_posts_carousel.php',
    'button.php',
    'skill.php',
    'socials.php',
    'team.php',
    'timeline.php',
    'dropcap.php',
    'lightbox.php',
    'piechart.php',
    'coming_soon.php',
    'googlemap.php',
    'client_gird.php',
    'gallery-justified.php',
    'image_banner.php',
    'blockquote.php',
    'kt_image_gallery.php',
);

foreach ( $composer_addons as $addon ) {
	require_once( FW_DIR . 'js_composer/vc_addons/' . $addon );
}

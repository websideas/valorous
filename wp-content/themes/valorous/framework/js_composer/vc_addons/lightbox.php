<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Lightbox extends WPBakeryShortCode {
    var $excerpt_length;
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'kt_type' => '',
            'font_type' => 'fontawesome',
            'icon_fontawesome' => '',
            'icon_openiconic' => '',
            'icon_typicons' => '',
            'icon_entypoicons' => '',
            'icon_linecons' => '',
            'icon_entypo' => '',
            'color' => '',
            'color_hover' => '',
            'custom_color' => '',
            'background_style' => '',
            'background_color' => '',
            'custom_background' => '',
            'background_color_hover' => '',
            'size' => 'md',
            
            'image_thumbnail' => '',
            'type_lightbox' => '',
            'image_lightbox' => '',
            'video_link' => '',
            'content_width' => '',

            'css' => '',
            'css_animation' => '',
            'el_class' => '',
        ), $atts );
        extract($atts);
        
        $uniqid = 'kt-icon-lightbox-'.uniqid();
        $rand = rand();
        
        if( $type_lightbox == 'lightbox-image' ){
            $type_lightbox = 'image';
            
            $img_lightbox_id = preg_replace( '/[^\d]/', '', $image_lightbox );
            $img_lightbox = wp_get_attachment_image_src( $img_lightbox_id, 'full' );
            if( $kt_type == 'icon' ){
                $link = urlencode($img_lightbox['0']);
            }elseif( $kt_type == 'image' ){
                $link = $img_lightbox['0'];
            }
        }elseif( $type_lightbox == 'lightbox-video' ){
            $type_lightbox = 'iframe';
            $link = $video_link;
        }else{
            $type_lightbox = 'inline';
            $link = '#lightbox'.$rand;
        }
        
        $img_id = preg_replace( '/[^\d]/', '', $image_thumbnail );
        $img = wpb_getImageBySize( array(
        	'attach_id' => $img_id,
        	'thumb_size' => 'full',
        	'class' => 'vc_single_image-img img-responsive'
        ) );
        if ( $img == null ) {
        	$img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
        }
        
        $lightbox = '';
        
        $icon_lightbox = do_shortcode('[vc_icon el_class="kt_lightbox_item" link="url:'.$link.'" hover_div="'.$uniqid.'" addon="1" uniqid="'.$uniqid.'" color_hover="'.$color_hover.'" background_color_hover="'.$background_color_hover.'" type="'.$font_type.'" icon_fontawesome="'.$icon_fontawesome.'" icon_openiconic="'.$icon_openiconic.'" icon_typicons="'.$icon_typicons.'" icon_entypo="'.$icon_entypo.'" icon_linecons="'.$icon_linecons.'" color="'.$color.'" custom_color="'.$custom_color.'" background_style="'.$background_style.'" background_color="'.$background_color.'" custom_background="'.$custom_background.'" size="'.$size.'" align="center"]');
        
        if( $kt_type == 'icon' ){
            $lightbox = $icon_lightbox;
        }elseif( $kt_type == 'image' ){
            $lightbox = '<a class="vc_icon_element-link" href="'.$link.'">'.$img['thumbnail'].'</a>';
        }
        
        $elementClass = array(
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $output = '<div class="kt_lightbox '.esc_attr( $elementClass ).'" data-effect="mfp-newspaper" data-type="'.$type_lightbox.'">'.$lightbox.'</div>';
        
        $style_content = '';
        if( $content_width != '' ){
            $style_content = 'style="max-width:'.$content_width.'px"';
        }
        
        if( $content != '' && $type_lightbox == 'inline' ){
            $output .= '<div id="lightbox'.$rand.'" class="mfp-hide mfp-with-anim kt-content-lightbox" '.$style_content.'>'.do_shortcode($content).'</div>';
        }

    	return $output;
    }
}

vc_map( array(
    "name" => __( "Lightbox", THEME_LANG),
    "base" => "lightbox",
    "category" => __('by Theme', THEME_LANG ),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
    		'type' => 'dropdown',
    		'heading' => __( 'Type', 'js_composer' ),
    		'param_name' => 'kt_type',
    		'value' => array(
                __( 'Icon', 'js_composer' ) => 'icon',
                __( 'Image', 'js_composer' ) => 'image',
    		),
    		'description' => __( 'Select type.', 'js_composer' ),
            "admin_label" => true,
    	),
        
        //Icon settings
        array(
            'type' => 'dropdown',
            'heading' => __( 'Icon library', 'js_composer' ),
            'value' => array(
                __( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                __( 'Open Iconic', 'js_composer' ) => 'openiconic',
                __( 'Typicons', 'js_composer' ) => 'typicons',
                __( 'Entypo', 'js_composer' ) => 'entypo',
                __( 'Linecons', 'js_composer' ) => 'linecons',
            ),
            'dependency' => array(
                'element' => 'kt_type',
                'value' => 'icon',
            ),
            'param_name' => 'font_type',
            'description' => __( 'Select icon library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_fontawesome',
            'value' => '',
            'settings' => array(
                'emptyIcon' => true,
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'font_type',
                'value' => 'fontawesome',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_openiconic',
            'value' => '',
            'settings' => array(
                'emptyIcon' => true,
                'type' => 'openiconic',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'font_type',
                'value' => 'openiconic',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_typicons',
            'value' => '', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'typicons',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'font_type',
                'value' => 'typicons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_entypo',
            'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'entypo',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'font_type',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_linecons',
            'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'linecons',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'font_type',
                'value' => 'linecons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Icon color', 'js_composer' ),
            'param_name' => 'color',
            'value' => array_merge( getVcShared( 'colors' ), array( __( 'Custom color', 'js_composer' ) => 'custom' ) ),
            'description' => __( 'Select icon color.', 'js_composer' ),
            'param_holder_class' => 'vc_colored-dropdown',
            'dependency' => array(
                'element' => 'kt_type',
                'value' => 'icon',
            ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Icon color on Hover', 'js_composer' ),
            'param_name' => 'color_hover',
            'description' => __( 'Select icon color on hover.', 'js_composer' ),
            'dependency' => array(
                'element' => 'kt_type',
                'value' => 'icon',
            ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Custom Icon Color', 'js_composer' ),
            'param_name' => 'custom_color',
            'description' => __( 'Select custom icon color.', 'js_composer' ),
            'dependency' => array(
                'element' => 'color',
                'value' => 'custom',
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Background shape', 'js_composer' ),
            'param_name' => 'background_style',
            'value' => array(
                __( 'None', 'js_composer' ) => '',
                __( 'Circle', 'js_composer' ) => 'rounded',
                __( 'Square', 'js_composer' ) => 'boxed',
                __( 'Rounded', 'js_composer' ) => 'rounded-less',
                __( 'Outline Circle', 'js_composer' ) => 'rounded-outline',
                __( 'Outline Square', 'js_composer' ) => 'boxed-outline',
                __( 'Outline Rounded', 'js_composer' ) => 'rounded-less-outline',
                __( 'Hexagonal', 'js_composer' ) => 'hexagonal',
                __( 'Diamond Square', 'js_composer' ) => 'diamond_square',

            ),
            'description' => __( 'Select background shape and style for icon.', 'js_composer' ),
            'dependency' => array(
                'element' => 'kt_type',
                'value' => 'icon',
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Background Color', 'js_composer' ),
            'param_name' => 'background_color',
            'value' => array_merge( getVcShared( 'colors' ), array( __( 'Custom color', 'js_composer' ) => 'custom' ) ),
            'std' => 'grey',
            'description' => __( 'Background Color.', 'js_composer' ),
            'param_holder_class' => 'vc_colored-dropdown',
            'dependency' => array(
                'element' => 'background_style',
                'not_empty' => true,
            ),
        ),
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
            'heading' => __( 'Background on Hover', 'js_composer' ),
            'param_name' => 'background_color_hover',
            'description' => __( 'Select Background icon color on hover.', 'js_composer' ),
            'dependency' => array(
                'element' => 'background_style',
                'not_empty' => true,
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Size', 'js_composer' ),
            'param_name' => 'size',
            'value' => array_merge( getVcShared( 'sizes' ), array( 'Extra Large' => 'xl' ) ),
            'std' => 'md',
            'description' => __( 'Icon size.', 'js_composer' ),
            'dependency' => array(
                'element' => 'kt_type',
                'value' => 'icon',
            ),
        ),
        //Image
        array(
			'type' => 'attach_image',
			'heading' => __( 'Image Thumbnail', 'js_composer' ),
			'param_name' => 'image_thumbnail',
			'dependency' => array(
    			'element' => 'kt_type',
    			'value' => array( 'image' ),
    		),
			'description' => __( 'Select image from media library.', 'js_composer' ),
		),
        array(
    		'type' => 'dropdown',
    		'heading' => __( 'Type Lightbox', 'js_composer' ),
    		'param_name' => 'type_lightbox',
    		'value' => array(
                __( 'Single Image Lightbox', 'js_composer' ) => 'lightbox-image',
    			__( 'Video Lightbox', 'js_composer' ) => 'lightbox-video',
    			__( 'Content Lightbox', 'js_composer' ) => 'lightbox-content'
    		),
    		'description' => __( 'Select type lightbox.', 'js_composer' ),
            'group' => __( 'Lightbox', THEME_LANG )
    	),
        array(
    		'type' => 'attach_image',
    		'heading' => __( 'Image Lightbox', 'js_composer' ),
    		'param_name' => 'image_lightbox',
    		'description' => __( 'Select image from media library.', 'js_composer' ),
    		'dependency' => array(
    			'element' => 'type_lightbox',
    			'value' => array( 'lightbox-image' ),
    		),
            'group' => __( 'Lightbox', THEME_LANG )
    	),
        array(
    		'type' => 'textfield',
    		'heading' => __( 'Video Link', 'js_composer' ),
    		'param_name' => 'video_link',
    		'description' => __( 'Enter your link video.', 'js_composer' ),
    		'dependency' => array(
    			'element' => 'type_lightbox',
    			'value' => array( 'lightbox-video' ),
    		),
            'group' => __( 'Lightbox', THEME_LANG )
    	),
        array(
            "type" => "textarea_html",
            "heading" => __("Content Lightbox", THEME_LANG),
            "param_name" => "content",
            'dependency' => array(
    			'element' => 'type_lightbox',
    			'value' => array( 'lightbox-content' ),
    		),
            "value" => __("", THEME_LANG),
            "description" => __("", THEME_LANG),
            'group' => __( 'Lightbox', THEME_LANG )
        ),
        array(
    		'type' => 'textfield',
    		'heading' => __( 'Content width', 'js_composer' ),
    		'param_name' => 'content_width',
    		'description' => __( 'Enter your max width of content lightbox.(px)', 'js_composer' ),
    		'dependency' => array(
    			'element' => 'type_lightbox',
    			'value' => array( 'lightbox-content' ),
    		),
            'group' => __( 'Lightbox', THEME_LANG )
    	),
        array(
        	'type' => 'dropdown',
        	'heading' => __( 'CSS Animation', 'js_composer' ),
        	'param_name' => 'css_animation',
        	'admin_label' => true,
        	'value' => array(
        		__( 'No', 'js_composer' ) => '',
        		__( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
        		__( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
        		__( 'Left to right', 'js_composer' ) => 'left-to-right',
        		__( 'Right to left', 'js_composer' ) => 'right-to-left',
        		__( 'Appear from center', 'js_composer' ) => "appear"
        	),
        	'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),

        array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		),
    ),
));

<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Image_Banner extends WPBakeryShortCode {
    var $excerpt_length;
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'image' => '',
            'image_size' => 'full',
            'position' => 'position-center',
            'align' => 'align-center',

            'css' => '',
            'css_animation' => '',
            'el_class' => '',
        ), $atts );

        extract($atts);
        $output = '';
        
        $img_id = preg_replace( '/[^\d]/', '', $image );
        $img = wpb_getImageBySize( array(
            'attach_id' => $img_id,
            'thumb_size' => $image_size,
            'class' => 'vc_single_image-img img-responsive'
        ) );
        if ( $img == null ) {
            $img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
        }
        
        $elementClass = array(
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $output .= '<div class="kt_image_banner '.$position.' '.$align.'">'.$img['thumbnail'];
            if($content){
                $output .= '<div class="content_banner_wrapper"><div class="content_banner '.esc_attr( $elementClass ).'">'.do_shortcode($content).'</div></div>';
            }
        $output .= '</div>';
        
    	return $output;
    }
}

vc_map( array(
    "name" => __( "Image Banner", THEME_LANG),
    "base" => "image_banner",
    "category" => __('by Theme', THEME_LANG ),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
			'type' => 'attach_image',
			'heading' => __( 'Image Banner', THEME_LANG ),
			'param_name' => 'image',
			'description' => __( 'Select image from media library.', 'js_composer' ),
		),
        array(
            "type" => "kt_image_sizes",
            "heading" => __( "Select image sizes", THEME_LANG ),
            "param_name" => "image_size",
            "std" => 'full'
        ),
        array(
            "type" => "textarea_html",
            "heading" => __("Content", THEME_LANG),
            "param_name" => "content",
            "value" => __("", THEME_LANG),
            "description" => __("", THEME_LANG),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Content Position', THEME_LANG ),
            'param_name' => 'position',
            'value' => array(
                __( 'Top', THEME_LANG ) => 'position-top',
                __( 'Center', THEME_LANG ) => 'position-center',
                __( 'Bottom', THEME_LANG ) => 'position-bottom',
            ),
            'std' => 'position-center',
            'description' => __( 'Position of content.', THEME_LANG ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Text Align', THEME_LANG ),
            'param_name' => 'align',
            'value' => array(
                __( 'Left', THEME_LANG ) => 'align-left',
                __( 'Center', THEME_LANG ) => 'align-center',
                __( 'Right', THEME_LANG ) => 'align-right',
            ),
            'std' => 'align-center',
            'description' => __( 'Align of text.', THEME_LANG ),
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
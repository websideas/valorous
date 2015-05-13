<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Clients_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'images' => '',
            'img_size' => 'thumbnail',
            'desktop' => 6,
            'tablet' => 3,
            'mobile' => 2,
            
            'autoplay' => '', 
            'always_show_nav' => '',
            'navigation' => '',
            'slidespeed' => 200,
            'theme' => 'style-navigation-center',
            
            'css_animation' => '',
            'el_class' => '',
            'border_heading' => '',
            'css' => '',
            
        ), $atts ) );
        
        if ( $images == '' ) return;
        $images = explode( ',', $images );
        
        
        $carousel = '';
        foreach ( $images as $attach_id ) {
            if ( $attach_id > 0 ) {
        		$post_thumbnail = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ) );
        	} else {
        		$post_thumbnail = array();
        		$post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
        		
        	}
            $carousel .= sprintf(
                            '<div class="%s">%s</div>',
                            'clients-carousel-item',
                            $post_thumbnail['thumbnail']
                        );
        }
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'clients-carousel-wrapper ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        if($theme == 'style-navigation-top'){
            $elementClass['carousel'] = 'carousel-wrapper-top';
            $title = ($title) ? $title : "&nbsp;";
        }
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $output = '';
        $output .= '<div class="'.esc_attr( $elementClass ).'">';
            if($title){
                $heading_class = "block-heading";
                if($border_heading){
                    $heading_class .= " block-heading-underline";
                }
                $output .= '<div class="'.esc_attr($heading_class).'">';
                    $output .= '<h3>'.$title.'</h3>';
                $output .= '</div>';
            }
            
            $data_carousel = array(
                "autoheight" => "false",
                "autoplay" => $autoplay,
                "navigation" => $navigation,
                "slidespeed" => $slidespeed,
                "pagination" => "false",
                "theme" => $theme,
                "itemscustom" => '[[992,'.$desktop.'], [768, '.$tablet.'], [480, '.$mobile.']]'
            );
            if( $always_show_nav == true ) { $class_show_nav = ''; }else{ $class_show_nav = 'visiable-navigation'; }
            
            $output .= '<div class="owl-carousel-wrapper">';
            $output .= '<div class="owl-carousel kt-owl-carousel '.$class_show_nav.$always_show_nav.'" '.render_data_carousel($data_carousel).'>';
                $output .= $carousel;
            $output .= '</div>';
            $output .= '</div>';
                
                
        $output .= '</div>';
        
    	return $output;
    }
}

vc_map( array(
    "name" => __( "Clients Carousel", THEME_LANG),
    "base" => "clients_carousel",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Recent Posts Carousel", THEME_LANG),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "description" => __( "title", THEME_LANG ),
            "admin_label" => true,
        ),
        array(
			'type' => 'checkbox',
			'heading' => __( 'Border in heading', THEME_LANG ),
			'param_name' => 'border_heading',
			'value' => array( __( 'Yes, please', 'js_composer' ) => 'true' ),
		),
        array(
			'type' => 'attach_images',
			'heading' => __( 'Images', 'js_composer' ),
			'param_name' => 'images',
			'value' => '',
			'description' => __( 'Select images from media library.', 'js_composer' )
		),
        array(
			'type' => 'textfield',
			'heading' => __( 'Image size', 'js_composer' ),
			'param_name' => 'img_size',
			'description' => __( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'js_composer' )
		),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        
        // Carousel
        array(
			'type' => 'checkbox',
			'heading' => __( 'AutoPlay', THEME_LANG ),
			'param_name' => 'autoplay',
			'value' => array( __( 'Yes, please', 'js_composer' ) => 'true' ),
            'group' => __( 'Carousel settings', THEME_LANG )
		),
        array(
			'type' => 'checkbox',
			'heading' => __( 'Always Show Navigation', THEME_LANG ),
			'param_name' => 'always_show_nav',
			'value' => array( __( 'Yes, please', 'js_composer' ) => 'true' ),
            'group' => __( 'Carousel settings', THEME_LANG )
		),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Navigation', THEME_LANG ),
			'param_name' => 'navigation',
			'value' => array( __( "Don't use Navigation", 'js_composer' ) => 'false' ),
            'description' => __( "Don't display 'next' and 'prev' buttons.", THEME_LANG ),
            'group' => __( 'Carousel settings', THEME_LANG )
		),
        array(
    		'type' => 'dropdown',
    		'heading' => __( 'Theme',THEME_LANG ),
    		'param_name' => 'theme',
    		'value' => array(
    			__( 'Navigation Top', THEME_LANG ) => 'style-navigation-top',
    			__( 'Navigation Center', THEME_LANG ) => 'style-navigation-center',
                __( 'Navigation Bottom', THEME_LANG ) => 'style-navigation-bottom',
    		),
            'std' => 'style-navigation-center',
            'description' => __( 'Please your theme for carousel', THEME_LANG ),
            'group' => __( 'Carousel settings', THEME_LANG )
    	),
        array(
			"type" => "kt_number",
			"heading" => __("Slide Speed", THEME_LANG),
			"param_name" => "slidespeed",
			"value" => "200",
            "suffix" => __("milliseconds", THEME_LANG),
			"description" => __('Slide speed in milliseconds', THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
	  	),
        array(
          "type" => "kt_heading",
          "heading" => __("Items to Show?", THEME_LANG),
          "param_name" => "items_show",
          'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Desktop", THEME_LANG),
			"param_name" => "desktop",
			"value" => "6",
			"min" => "1",
			"max" => "25",
			"step" => "1",
            'group' => __( 'Carousel settings', THEME_LANG )
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Tablet", THEME_LANG),
			"param_name" => "tablet",
			"value" => "3",
			"min" => "1",
			"max" => "25",
			"step" => "1",
            'group' => __( 'Carousel settings', THEME_LANG )
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Mobile", THEME_LANG),
			"param_name" => "mobile",
			"value" => "2",
			"min" => "1",
			"max" => "25",
			"step" => "1",
            'group' => __( 'Carousel settings', THEME_LANG )
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
<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Product_Category_Banner extends WPBakeryShortCode {
    
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'product_category' => '',
            'image_size' => 'full',
            'position' => 'position-center',
            'hover_effect' => '',

            'css' => '',
            'css_animation' => '',
            'el_class' => '',
        ), $atts );

        extract($atts);
        $output = '';
        
        $elementClass = array(
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'position' => $position,
        );
        if($hover_effect){
            $elementClass['hover'] = 'hover-effect-'.$hover_effect;
        }

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        if( $product_category && function_exists( 'get_woocommerce_term_meta' )){
            $term = get_term( $product_category, 'product_cat' );
            $link = get_term_link( $term->slug, 'product_cat' );
            
            $thumbnail_id = get_woocommerce_term_meta( $product_category, 'thumbnail_id', true );
            $image = wp_get_attachment_image( $thumbnail_id, $image_size, false, array( 'class' => 'vc_single_image-img img-responsive attachment-'.$image_size, 'alt' => $term->name ) );
            
            if( !$image ){ $image = '<img class="vc_img-placeholder vc_single_image-img img-responsive" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />'; }
            
            $output .= '<div class="kt_image_banner '.esc_attr( $elementClass ).'">'.$image;
                $output .= '<div class="content_banner_wrapper"><div class="content_banner"><span class="btn btn-light btn-block">'.$term->name.'</span></div></div>';             
                $output .= '<a class="banner-link" href="'.esc_attr( $link ).'" title="'.esc_attr( $term->name ).'" alt="'.esc_attr( $term->name ).'"></a>';
            $output .= '</div>';
        }else{
            $output .= '<p>'.__( 'No product category',THEME_LANG ).'</p>';
        }
    	return $output;
    }

}

vc_map( array(
    "name" => __( "Product Category Banner", THEME_LANG),
    "base" => "product_category_banner",
    "category" => __('by Theme', THEME_LANG ),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "kt_taxonomy",
            'taxonomy' => 'product_cat',
            'heading' => __( 'Product Category', THEME_LANG ),
            'param_name' => 'product_category',
            'placeholder' => __( 'Select your Product Category', THEME_LANG ),
            'multiple' => false,
            "admin_label" => true,
        ),
        array(
            "type" => "kt_image_sizes",
            "heading" => __( "Select image sizes", THEME_LANG ),
            "param_name" => "image_size",
            "std" => 'full',
            "admin_label" => true,
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
            "admin_label" => true,
        ),

        array(
            'type' => 'dropdown',
            'heading' => __( 'Hover Effect', THEME_LANG ),
            'param_name' => 'hover_effect',
            'value' => array(
                __( 'No', 'js_composer' ) => '',
                __( 'Dark Overlay', THEME_LANG ) => 'dark',
                __( 'Light Overlay', THEME_LANG ) => 'light'
            ),
            "admin_label" => true,
        ),
        
        array(
        	'type' => 'dropdown',
        	'heading' => __( 'CSS Animation', 'js_composer' ),
        	'param_name' => 'css_animation',
        	'value' => array(
        		__( 'No', 'js_composer' ) => '',
        		__( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
        		__( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
        		__( 'Left to right', 'js_composer' ) => 'left-to-right',
        		__( 'Right to left', 'js_composer' ) => 'right-to-left',
        		__( 'Appear from center', 'js_composer' ) => "appear"
        	),
            "admin_label" => true,
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
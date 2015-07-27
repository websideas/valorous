<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );

class WPBakeryShortCode_KT_Gallery extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'image_gallery' => '',
            'image_size' => 'full',
            'row_height' => 400,
            'margin_image' => 10,
            'gallery_popup' => 'yes',
            
            'el_class' => '',
            'css' => '',
        ), $atts );
        extract($atts);
        
        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wrapper-gallery ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        if( $image_gallery ){ $image_gallery = explode( ',', $image_gallery ); }else{ $image_gallery = array(); }
        if( $gallery_popup == 'yes' ){ $popup = ' popup-gallery'; }else{ $popup = ''; }
        $output = '';
        if( count($image_gallery) > 0 ){
            $output .= '<div class="'.esc_attr( $elementClass ).'" style="margin-left:-'.$margin_image.'px;margin-right:-'.$margin_image.'px;">';
                $output .= '<div class="justified-gallery'.$popup.'" data-height="'.esc_attr($row_height).'" data-margin="'.esc_attr($margin_image).'">';
                    foreach ( $image_gallery as $attach_id ) {
                    	if ( $attach_id > 0 ) {
                    		$image = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $image_size ) );
                    	}
                        $output .= '<div class="gallery-item">';
                            if( $gallery_popup == 'yes' ){ $output .= '<a href="'.$image['p_img_large'][0].'">'; }
                                $output .= $image['thumbnail'];
                            if( $gallery_popup == 'yes' ){ $output .= "</a>"; }
                        $output .= '</div>';
                    }
                $output .= '</div>';
            $output .= '</div>';
        }
        
        return $output;
    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "KT Gallery", THEME_LANG),
    "base" => "kt_gallery",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Gallery", THEME_LANG),
    "params" => array(
        //Image
        array(
			'type' => 'attach_images',
			'heading' => __( 'Image Gallery', THEME_LANG ),
			'param_name' => 'image_gallery',
			'description' => __( 'Select image from media library.', 'js_composer' ),
		),
        array(
            "type" => "kt_image_sizes",
            "heading" => __( "Select image sizes", THEME_LANG ),
            "param_name" => "image_size",
            "std" => "full"
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Row Height", THEME_LANG ),
            "param_name" => "row_height",
            "description" => __( "The preferred height of rows in pixel.", THEME_LANG ),
            "std" => 400
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Margin", THEME_LANG ),
            "param_name" => "margin_image",
            "description" => __( "Decide the margins between the images.", THEME_LANG ),
            "std" => 10
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Gallery Popup', THEME_LANG ),
            'param_name' => 'gallery_popup',
            'value' => array(
                __( 'Yes', THEME_LANG ) => 'yes',
                __( 'No', THEME_LANG ) => 'no',
            ),
            'std' => 'yes',
        ),
        
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        //Design options
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => __( 'Design options', 'js_composer' )
        ),

    ),
));
<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );

class WPBakeryShortCode_Dropcap extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => '',
            'size' => '',
            'font_container' => '',
            'border_radius' => '',
            'custom_background' => '',
            'font_type_title' => '',
            'google_fonts' => '',

            'el_class' => '',
            'css' => '',
        ), $atts );
        extract($atts);
        
        $style_title = '';

        extract( $this->getAttributes( $atts ) );
        unset($font_container_data['values']['text_align']);

        $styles = array();
        if($font_type_title != 'google'){
            $google_fonts_data = array();
        }
        extract( $this->getStyles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) );

        $settings = get_option( 'wpb_js_google_fonts_subsets' );
        $subsets = '';
        if ( is_array( $settings ) && ! empty( $settings ) ) {
            $subsets = '&subset=' . implode( ',', $settings );
        }
        if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data['values']['font_family'] ) ) {
            wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
        }
        if($border_radius){
            $styles[] = 'border-radius: '.$border_radius.'px;';
        }
        if($custom_background){
            $styles[] = 'background: '.$custom_background;
        }
        if ( ! empty( $styles ) ) {
            $style_title .= 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
        }
        
        $elementClass = array(
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'size' => 'dropcap-'.$size,
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        return '<span class="kt_dropcap '.$elementClass.'" '.$style_title.'>'.$title.'</span>';
    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Dropcap", THEME_LANG),
    "base" => "dropcap",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Dropcap", THEME_LANG),
    "params" => array(
        array(
            "type" => "textfield",
            'heading' => __( 'First Letter', 'js_composer' ),
            'param_name' => 'title',
            'value' => __( 'P', 'js_composer' ),
            "admin_label" => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Size', 'js_composer' ),
            'param_name' => 'size',
            'value' => getVcShared( 'sizes' ),
            'std' => 'md',
            'description' => __( 'Dropcap size.', 'js_composer' )
        ),
        
        //Typography settings
        array(
            'type' => 'font_container',
            'param_name' => 'font_container',
            'value' => '',
            'settings' => array(
                'fields' => array(
                    //'tag' => 'h2', // default value h2
                    'font_size',
                    //'line_height',
                    'color',
                    'tag_description' => __( 'Select element tag.', 'js_composer' ),
                    'text_align_description' => __( 'Select text alignment.', 'js_composer' ),
                    'font_size_description' => __( 'Enter font size.', 'js_composer' ),
                    'line_height_description' => __( 'Enter line height.', 'js_composer' ),
                    'color_description' => __( 'Select heading color.', 'js_composer' ),
                ),
            ),
            'group' => __( 'Typography', THEME_LANG )
        ),
        array(
            "type" => "kt_number",
            "heading" => __("Border Radius", THEME_LANG),
            "param_name" => "border_radius",
            "value" => 0,
            "min" => 0,
            "max" => 10,
            "suffix" => "px",
            "description" => "",
            'group' => __( 'Typography', THEME_LANG ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Custom Background', 'js_composer' ),
            'param_name' => 'custom_background',
            'description' => __( 'Select Background color.', 'js_composer' ),
            'group' => __( 'Typography', THEME_LANG )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Font type', 'js_composer' ),
            'param_name' => 'font_type_title',
            'value' => array(
                __( 'Normal', 'js_composer' ) => '',
                __( 'Google font', 'js_composer' ) => 'google',
            ),
            'group' => __( 'Typography', 'js_composer' ),
            'description' => __( '', 'js_composer' ),
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'google_fonts_title',
            'value' => 'font_family:Abril%20Fatface%3A400|font_style:400%20regular%3A400%3Anormal',
            'settings' => array(
                'fields' => array(
                    'font_family_description' => __( 'Select font family.', 'js_composer' ),
                    'font_style_description' => __( 'Select font styling.', 'js_composer' )
                )
            ),
            'group' => __( 'Typography', THEME_LANG ),
            'dependency' => array( 'element' => 'font_type_title', 'value' => array( 'google' ) ),
            'description' => __( '', 'js_composer' ),
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
<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );

class WPBakeryShortCode_Comingsoon extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => '',
            
            'day' => 19,
            'month' => 5,
            'year' => 2016,
            
            'font_type_title' => '',
            'font_container_title' => '',
            'google_fonts_title' => '',
            'font_type_value' => '',
            'font_container_value' => '',
            'google_fonts_value' => '',

            'el_class' => '',
            'css' => '',
        ), $atts );
        extract($atts);
        
        $rand = rand(); 
        $custom_css = '';
        
        $style_title = '';
        $atts['font_container'] = $font_container_title;
        $atts['google_fonts'] = $google_fonts_title;
        extract( $this->getAttributes( $atts ) );
        unset($font_container_data['values']['text_align']);
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


        if ( ! empty( $styles ) ) {
            $style_title .= esc_attr( implode( ';', $styles ) );
        }

        $style_value = '';
        $atts['font_container'] = $font_container_value;
        $atts['google_fonts'] = $google_fonts_value;
        extract($this->getAttributes($atts));
        unset($font_container_data['values']['text_align']);

        if($font_type_value != 'google'){
            $google_fonts_data = array();
        }

        extract($this->getStyles($el_class, $css, $google_fonts_data, $font_container_data, $atts));

        $settings = get_option('wpb_js_google_fonts_subsets');
        $subsets = '';
        if (is_array($settings) && !empty($settings)) {
            $subsets = '&subset=' . implode(',', $settings);
        }
        if (!empty($google_fonts_data) && isset($google_fonts_data['values']['font_family'])) {
            wp_enqueue_style('vc_google_fonts_' . vc_build_safe_css_class($google_fonts_data['values']['font_family']), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets);
        }

        if (!empty($styles)) {
            $style_value .= esc_attr(implode(';', $styles));
        }
        
        $custom_css .= '#kt_comming_'.$rand.' .title{ '.$style_title.' }';
        $custom_css .= '#kt_comming_'.$rand.' .value-time{ '.$style_value.' }';
        
        if($custom_css){
            $custom_css = '<div class="kt_custom_css">'.$custom_css.'</div>';
        }

        $output = '<div class="wrapper-comingsoon"><div id="kt_comming_'.$rand.'" class="coming-soon" data-date="'.$day.'" data-month="'.$month.'" data-year="'.$year.'"></div>'.$custom_css.'</div>';
        
        return $output;
    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Coming soon", THEME_LANG),
    "base" => "comingsoon",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Coming soon", THEME_LANG),
    "params" => array(
        array(
            "type" => "textfield",
            'heading' => __( 'Title', 'js_composer' ),
            'param_name' => 'title',
            'value' => '',
            "admin_label" => true,
        ),
        
        //Typography settings
        array(
            "type" => "kt_heading",
            "heading" => __("Title typography", THEME_LANG),
            "param_name" => "title_typography",
            'group' => __( 'Typography', THEME_LANG )
        ),
        array(
            'type' => 'font_container',
            'param_name' => 'font_container_title',
            'value' => '',
            'settings' => array(
                'fields' => array(
                    //'tag' => 'h2', // default value h2
                    'font_size',
                    'line_height',
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
            "type" => "kt_heading",
            "heading" => __('Value Typography', THEME_LANG),
            "param_name" => "value_typography",
            'group' => __( 'Typography', THEME_LANG )
        ),
        array(
            'type' => 'font_container',
            'param_name' => 'font_container_value',
            'value' => '',
            'settings' => array(
                'fields' => array(
                    'font_size',
                    'line_height',
                    'color',

                    'tag_description' => __( 'Select element tag.', 'js_composer' ),
                    'text_align_description' => __( 'Select text alignment.', 'js_composer' ),
                    'font_size_description' => __( 'Enter font size.', 'js_composer' ),
                    'line_height_description' => __( 'Enter line height.', 'js_composer' ),
                    'color_description' => __( 'Select heading color.', 'js_composer' ),
                ),
            ),
            'description' => __( '', 'js_composer' ),
            'group' => __( 'Typography', THEME_LANG )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Font type', 'js_composer' ),
            'param_name' => 'font_type_value',
            'value' => array(
                __( 'Normal', 'js_composer' ) => '',
                __( 'Google font', 'js_composer' ) => 'google',
            ),
            'group' => __( 'Typography', 'js_composer' ),
            'description' => __( '', 'js_composer' ),
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'google_fonts_value',
            'value' => 'font_family:Abril%20Fatface%3A400|font_style:400%20regular%3A400%3Anormal',
            'settings' => array(
                'fields' => array(
                    'font_family_description' => __( 'Select font family.', 'js_composer' ),
                    'font_style_description' => __( 'Select font styling.', 'js_composer' )
                )
            ),
            'group' => __( 'Typography', THEME_LANG ),
            'dependency' => array( 'element' => 'font_type_value', 'value' => array( 'google' ) ),
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
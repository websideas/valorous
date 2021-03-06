<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );

class WPBakeryShortCode_Comingsoon extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'date_coming' => '2016/5/19',
            
            'use_theme_fonts' => '',
            'font_container' => '',
            'google_fonts' => '',

            'use_theme_fonts_value' => '',
            'font_container_value' => '',
            'google_fonts_value' => '',

            'css_animation' => '',
            'el_class' => '',
            'css' => '',
        ), $atts );
        extract($atts);
        
        $rand = rand(); 
        $custom_css = $data_animate = $cl_animate = $animate_item = '';
        
        $style_title = '';
        extract( $this->getAttributes( $atts ) );
        unset($font_container_data['values']['text_align']);
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
            $custom_css .= '#kt_comming_'.$rand.' .title{ '.$style_title.' }';
        }

        $style_value = '';
        $atts['font_container'] = $font_container_value;
        $atts['google_fonts'] = $google_fonts_value;
        $atts['use_theme_fonts'] = $use_theme_fonts_value;

        extract($this->getAttributes($atts));
        unset($font_container_data['values']['text_align']);

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
            $custom_css .= '#kt_comming_'.$rand.' .value-time{ '.$style_value.' }';
        }

        
        if($custom_css){
            $custom_css = '<div class="kt_custom_css" data-css="'.esc_attr($custom_css).'"></div>';
        }
        
        if($css_animation !=''){
            $data_animate = 'data-timeeffect="200" data-animation="'.$css_animation.'"';
            $cl_animate = 'animation-effect';
            $animate_item = 'animation-effect-item';
        }
        
        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wrapper-comingsoon ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'animate' => $cl_animate,
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        $html = '<div class="wrap"><div class="value-time">266</div><div class="title">Days</div></div>
                 <div class="wrap wrap-divider"><div class="value-time">:</div><div class="title">&nbsp;</div></div>
                 <div class="wrap"><div class="value-time">09</div><div class="title">Hours</div></div>
                 <div class="wrap wrap-divider"><div class="value-time">:</div><div class="title">&nbsp;</div></div>
                 <div class="wrap"><div class="value-time">53</div><div class="title">Minutes</div></div>
                 <div class="wrap wrap-divider"><div class="value-time">:</div><div class="title">&nbsp;</div></div>
                 <div class="wrap"><div class="value-time">59</div><div class="title">Seconds</div></div>';
        
        $output = '<div class="'.esc_attr( $elementClass ).'" '.$data_animate.'><div id="kt_comming_'.$rand.'" class="coming-soon '.$animate_item.'" data-date="'.$date_coming.'">'.$html.'<div class="clearfix"></div></div>'.$custom_css.'</div>';
        
        return $output;
    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Coming soon", THEME_LANG),
    "base" => "comingsoon",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "", THEME_LANG),
    "params" => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Date coming', 'js_composer' ),
            'param_name' => 'date_coming',
            'value' => '2016/5/19',
            'admin_label' => true,
            'description' => __( 'Example: 2016/5/19', 'js_composer' ),
        ),
        array(
            'type' => 'hidden',
            'heading' => __( 'URL (Link)', 'js_composer' ),
            'param_name' => 'link',
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
            'param_name' => 'font_container',
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
            'type' => 'checkbox',
            'heading' => __( 'Use theme default font family?', 'js_composer' ),
            'param_name' => 'use_theme_fonts',
            'value' => array( __( 'Yes', 'js_composer' ) => 'yes' ),
            'description' => __( 'Use font family from the theme.', 'js_composer' ),
            'group' => __( 'Typography', THEME_LANG ),
            'std' => 'yes'
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'google_fonts',
            'settings' => array(
                'fields' => array(
                    'font_family_description' => __( 'Select font family.', 'js_composer' ),
                    'font_style_description' => __( 'Select font styling.', 'js_composer' )
                )
            ),
            'group' => __( 'Typography', THEME_LANG ),
            'dependency' => array(
                'element' => 'use_theme_fonts',
                'value_not_equal_to' => 'yes',
            ),
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
            'type' => 'checkbox',
            'heading' => __( 'Use theme default font family?', 'js_composer' ),
            'param_name' => 'use_theme_fonts_value',
            'value' => array( __( 'Yes', 'js_composer' ) => 'yes' ),
            'description' => __( 'Use font family from the theme.', 'js_composer' ),
            'group' => __( 'Typography', THEME_LANG ),
            'std' => 'yes'
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'google_fonts_value',
            'settings' => array(
                'fields' => array(
                    'font_family_description' => __( 'Select font family.', 'js_composer' ),
                    'font_style_description' => __( 'Select font styling.', 'js_composer' )
                )
            ),
            'group' => __( 'Typography', THEME_LANG ),
            'dependency' => array(
                'element' => 'use_theme_fonts_value',
                'value_not_equal_to' => 'yes',
            ),
            'description' => __( '', 'js_composer' ),
        ),

        array(
            'type' => 'kt_animate',
            'heading' => __( 'CSS Animation', 'js_composer' ),
            'param_name' => 'css_animation',
            'value' => '',
            'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
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
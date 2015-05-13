<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



class WPBakeryShortCode_KT_Button extends WPBakeryShortCode {
    protected function content($atts, $content = null) {

            $wrapper_start = $wrapper_end = '';
            extract( shortcode_atts( array(
                'href' => '',
                'target' => '',
                'title' => __( 'Text on the button', "js_composer" ),
                'sub_title' => __( 'Sub title on button', "js_composer" ),
                'color' => '',
                'icon' => '',
                'size' => '',
                'style' => '',
                'el_class' => '',
                'css' => '',
            ), $atts ) );



            $class = 'kt-button btn';

            $a_href = $href;
            $a_target = ($target) ? ' target="'.esc_attr($target).'" ' : '';

            $el_class = $this->getExtraClass( $el_class );
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . $class . $el_class, $this->settings['base'], $atts );
            $wrapper_css_class = 'kt-button-wrapper '.vc_shortcode_custom_css_class(  $css );


            return '
            <div class="'.esc_attr($wrapper_css_class).'">
                <a class="'.esc_attr( trim( $css_class ) ).'" href="'.esc_attr( $a_href ).'" title="'.esc_attr( $title ).'" '.$a_target.'>
                    <span class="btn-sub-title">'.$sub_title.'</span>
                    <span class="btn-title">'.$title.'</span>
                </a>
            </div>';


    }
}

vc_map( array(
    "name" => __( "KT Button", THEME_LANG),
    "base" => "kt_button",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Custom button", THEME_LANG),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            'type' => 'href',
            'heading' => __( 'URL (Link)', 'js_composer' ),
            'param_name' => 'href',
            'description' => __( 'Enter button link.', 'js_composer' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Target', 'js_composer' ),
            'param_name' => 'target',
            'value' =>  array(
                    __( 'Same window', 'js_composer' ) => '_self',
                    __( 'New window', 'js_composer' ) => "_blank"
                ),
            'dependency' => array(
                'element' => 'href',
                'not_empty' => true,
                'callback' => 'vc_button_param_target_callback'
            )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Text on the button', 'js_composer' ),
            'holder' => 'button',
            'class' => 'vc_btn',
            'param_name' => 'title',
            'value' => __( 'Text on the button', 'js_composer' ),
            'description' => __( 'Text on the button.', 'js_composer' )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Text on the button', 'js_composer' ),
            'class' => 'vc_btn',
            'param_name' => 'sub_title',
            'value' => __( 'Sub title on the button', 'js_composer' ),
            'description' => __( 'Sub  title on the button.', 'js_composer' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Button alignment', 'js_composer' ),
            'param_name' => 'align',
            'value' => array(
                __( 'Center', 'js_composer' ) => 'center',
                __( 'Inline', 'js_composer' ) => "inline",
                __( 'Left', 'js_composer' ) => 'left',
                __( 'Right', 'js_composer' ) => "right"
            ),
            'description' => __( 'Select button alignment.', 'js_composer' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Target', 'js_composer' ),
            'param_name' => 'target',
            'value' => array(
                __( 'Stay in Window', THEME_LANG ) => '_self',
                __( 'Open New Window', THEME_LANG ) => "_blank"
            ),
            'description' => ""
        ),


        array(
            'type' => 'textfield',
            'heading' => __( 'Extra class name', 'js_composer' ),
            'param_name' => 'el_class',
            'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
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


<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );

class WPBakeryShortCode_KT_Callout extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {


        $atts = shortcode_atts( array(
            'title' => __( 'Call to Action', THEME_LANG ),
            'layout' => 1,
            'font_type' => '',
            'font_container' => '',
            'google_fonts' => '',
            'letter_spacing' => '0',


            'bt_title' => '',
            'link' => '',
            'bt_title_color' => '',
            'bt_bg_color' => '',
            'bt_title_color_hover' => '',
            'bt_bg_color_hover' => '',

            'type' => 'fontawesome',
            'icon_fontawesome' => '',
            'icon_openiconic' => '',
            'icon_typicons' => '',
            'icon_entypoicons' => '',
            'icon_linecons' => '',
            'icon_entypo' => '',
            'color' => '',
            'custom_color' => '',
            'icon_position' => '',

            'bt_font_type' => '',
            'bt_font_container' => '',
            'bt_google_fonts' => '',
            'bt_letter_spacing' => '0',

            'bt_border_style' => '',
            'bt_color_border' => '',
            'bt_color_border_hover' => '',
            'bt_border_size' => 1,
            'bt_radius' => 3,

            'css_animation' => '',
            'el_class' => '',
            'css' => '',
        ), $atts );
        extract($atts);

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'kt-callout-wrapper ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'layout' => 'kt-callout-layout-'.$layout
        );
        $output = $style_title = '' ;

        $styles = array();
        extract( $this->getAttributes( $atts ) );
        unset($font_container_data['values']['text_align']);

        if($font_type != 'google'){
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
        $styles[] = 'letter-spacing:'.$letter_spacing.'px';
        if ( ! empty( $styles ) ) {
            $style_title .= 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
        }






        $callout_content = '<h3 class="kt-callout-title" '.$style_title.'>'.$title.'</h3>';
        if($content){
            $callout_content .= '<div class="kt-callout-content">'.$content.'</div>';
        }

        $callout_button = do_shortcode('[kt_button title="'.$bt_title.'" link="'.$link.'"  bt_title_color="'.$bt_title_color.'" bt_title_color_hover="'.$bt_title_color_hover.'" bt_bg_color="'.$bt_bg_color.'" bt_bg_color_hover="'.$bt_bg_color_hover.'" bt_align="inline" bt_border_style="'.$bt_border_style.'" bt_color_border="'.$bt_color_border.'" bt_color_border_hover="'.$bt_color_border_hover.'" bt_border_size="'.$bt_border_size.'" bt_radius="'.$bt_radius.'" font_container="'.$bt_font_container.'" letter_spacing="'.$bt_letter_spacing.'" font_type="'.$bt_font_type.'" google_fonts="'.$bt_google_fonts.'"]');

        if($layout == 2){
            $output .= sprintf(
                '<div class="callout-content display-table">
                    <div class="callout-action display-cell">%s</div>
                    <div class="callout-text display-cell">%s</div>
                </div>',
                $callout_button,
                $callout_content
            );
        }elseif($layout == 3){
            $output .= sprintf(
                '<div class="kt-callout-inner">%s</div>%s',
                $callout_content,
                $callout_button
            );
        }else{
            $output .= sprintf(
                '<div class="callout-content display-table">
                    <div class="callout-text display-cell">%s</div>
                    <div class="callout-action display-cell">%s</div>
                </div>',
                $callout_content,
                $callout_button
            );
        }


        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        return '<div class="'.esc_attr( $elementClass ).'">'.$output.'</div>';

    }
}

vc_map( array(
    "name" => __( " Call to Action", THEME_LANG),
    "base" => "kt_callout",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Catch visitors attention with CTA block", THEME_LANG),
    "wrapper_class" => "clearfix",
    "params" => array(

        array(
            'type' => 'textfield',
            'heading' => __( 'Text', 'js_composer' ),
            'param_name' => 'title',
            'admin_label' => true,
            'value' => __( 'Call to Action', THEME_LANG ),
            'description' => __( 'Note: If you are using non-latin characters be sure to activate them under Settings/Visual Composer/General Settings.', 'js_composer' ),
        ),
        array(
            "type" => "textarea_html",
            "heading" => __("Content", THEME_LANG),
            "param_name" => "content",
            "value" => '',
            "description" => __("", THEME_LANG),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout', 'js_composer' ),
            'param_name' => 'layout',
            'value' => array(
                __( 'Side - Text + Button', 'js_composer' ) => '1',
                __( 'Side - Button + Text', 'js_composer' ) => '2',
                __( 'Center - Text + Button', 'js_composer' ) => '3',
            ),
            'admin_label' => true,
            'description' => '',
        ),
        //Typography settings
        array(
            "type" => "kt_heading",
            "heading" => __("Typography setting", THEME_LANG),
            "param_name" => "callout_typography_setting",
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
        ),
        array(
            "type" => "kt_number",
            "heading" => __("Letter spacing", THEME_LANG),
            "param_name" => "letter_spacing",
            "value" => 0,
            "min" => 0,
            "max" => 10,
            "suffix" => "px",
            "description" => "",
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Font type', 'js_composer' ),
            'param_name' => 'font_type',
            'value' => array(
                __( 'Normal', 'js_composer' ) => '',
                __( 'Google font', 'js_composer' ) => 'google',
            ),
            'description' => '',
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'google_fonts',
            'value' => 'font_family:Abril%20Fatface%3A400|font_style:400%20regular%3A400%3Anormal',
            'settings' => array(
                'fields' => array(
                    'font_family_description' => __( 'Select font family.', 'js_composer' ),
                    'font_style_description' => __( 'Select font styling.', 'js_composer' )
                )
            ),
            'dependency' => array( 'element' => 'font_type', 'value' => array( 'google' ) ),
            'description' => __( '', 'js_composer' ),
        ),
        array(
            "type" => "kt_heading",
            "heading" => __("Other setting", THEME_LANG),
            "param_name" => "callout_other_setting",
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
            'type' => 'textfield',
            'heading' => __( 'Extra class name', 'js_composer' ),
            'param_name' => 'el_class',
            'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
        ),

        array(
            'type' => 'vc_link',
            'heading' => __( 'URL (Link)', 'js_composer' ),
            'param_name' => 'link',
            'description' => __( 'Enter button link.', 'js_composer' ),
            'group' => __( 'Button', THEME_LANG ),
        ),
        array(
            "type" => "textfield",
            'heading' => __( 'Button Title', 'js_composer' ),
            'param_name' => 'bt_title',
            'value' => '',
            'group' => __( 'Button', THEME_LANG )
        ),

        array(
            "type" => "colorpicker",
            "heading" => __("Button Title Color", THEME_LANG),
            "param_name" => "bt_title_color",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            "value" => "",
            "description" => "",
            'group' => __( 'Button', THEME_LANG ),
        ),
        array(
            "type" => "colorpicker",
            "heading" => __("Button Title Color on Hover", THEME_LANG),
            "param_name" => "bt_title_color_hover",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            "value" => "",
            "description" => "",
            'group' => __( 'Button', THEME_LANG ),
        ),


        array(
            "type" => "colorpicker",
            "heading" => __("Background Color", THEME_LANG),
            "param_name" => "bt_bg_color",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            "value" => "",
            'group' => __( 'Button', THEME_LANG ),
        ),
        array(
            "type" => "colorpicker",
            "heading" => __("Background Color on Hover", THEME_LANG),
            "param_name" => "bt_bg_color_hover",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            "value" => "",
            'group' => __( 'Button', THEME_LANG ),
        ),




        // Border setting
        array(
            "type" => "kt_heading",
            "heading" => __("Border setting", THEME_LANG),
            "param_name" => "bt_border_setting",
            'group' => __( 'Button', THEME_LANG )
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Button Border Style", THEME_LANG),
            "param_name" => "bt_border_style",
            "value" => array(
                __("None", THEME_LANG)=> "",
                __("Solid", THEME_LANG)=> "solid",
                __("Dashed", THEME_LANG) => "dashed",
                __("Dotted", THEME_LANG) => "dotted",
                __("Double", THEME_LANG) => "double",
            ),
            "description" => "",
            'group' => __( 'Button', THEME_LANG ),
        ),
        array(
            "type" => "colorpicker",
            "heading" => __("Border Color", THEME_LANG),
            "param_name" => "bt_color_border",
            "value" => "",
            "description" => "",
            "dependency" => array("element" => "bt_border_style", "not_empty" => true),
            'group' => __( 'Button', THEME_LANG ),
        ),
        array(
            "type" => "colorpicker",
            "heading" => __("Border Color on Hover", THEME_LANG),
            "param_name" => "bt_color_border_hover",
            "value" => "",
            "description" => "",
            "dependency" => array("element" => "bt_border_style", "not_empty" => true),
            'group' => __( 'Button', THEME_LANG ),
        ),
        array(
            "type" => "kt_number",
            "heading" => __("Border Width", THEME_LANG),
            "param_name" => "bt_border_size",
            "value" => 1,
            "min" => 1,
            "max" => 10,
            "suffix" => "px",
            "description" => "",
            "dependency" => array("element" => "bt_border_style", "not_empty" => true),
            'group' => __( 'Button', THEME_LANG ),
        ),
        array(
            "type" => "kt_number",
            "heading" => __("Border Radius", THEME_LANG),
            "param_name" => "bt_radius",
            "value" => 3,
            "min" => 0,
            "max" => 500,
            "suffix" => "px",
            "description" => "",
            'group' => __( 'Button', THEME_LANG ),
        ),



        //Typography settings
        array(
            "type" => "kt_heading",
            "heading" => __("Typography setting", THEME_LANG),
            "param_name" => "bt_typography_setting",
            'group' => __( 'Button', THEME_LANG )
        ),
        array(
            'type' => 'font_container',
            'param_name' => 'bt_font_container',
            'value' => '',
            'settings' => array(
                'fields' => array(
                    //'tag' => 'h2', // default value h2
                    'font_size',
                    'line_height',
                    'tag_description' => __( 'Select element tag.', 'js_composer' ),
                    'text_align_description' => __( 'Select text alignment.', 'js_composer' ),
                    'font_size_description' => __( 'Enter font size.', 'js_composer' ),
                    'line_height_description' => __( 'Enter line height.', 'js_composer' ),
                    'color_description' => __( 'Select heading color.', 'js_composer' ),
                ),
            ),
            'group' => __( 'Button', THEME_LANG ),
        ),
        array(
            "type" => "kt_number",
            "heading" => __("Letter spacing", THEME_LANG),
            "param_name" => "bt_letter_spacing",
            "value" => 0,
            "min" => 0,
            "max" => 10,
            "suffix" => "px",
            "description" => "",
            'group' => __( 'Button', THEME_LANG ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Font type', 'js_composer' ),
            'param_name' => 'bt_font_type',
            'value' => array(
                __( 'Normal', 'js_composer' ) => '',
                __( 'Google font', 'js_composer' ) => 'google',
            ),
            'group' => __( 'Button', THEME_LANG ),
            'description' => __( '&nbsp;', 'js_composer' ),
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'bt_google_fonts',
            'value' => 'font_family:Abril%20Fatface%3A400|font_style:400%20regular%3A400%3Anormal',
            'settings' => array(
                'fields' => array(
                    'font_family_description' => __( 'Select font family.', 'js_composer' ),
                    'font_style_description' => __( 'Select font styling.', 'js_composer' )
                )
            ),
            'group' => __( 'Button', THEME_LANG ),
            'dependency' => array( 'element' => 'bt_font_type', 'value' => array( 'google' ) ),
            'description' => __( '', 'js_composer' ),
        ),

        array(
            'type' => 'css_editor',
            'heading' => __( 'CSS box', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
            'group' => __( 'Design Options', 'js_composer' )
        )

    ),
));


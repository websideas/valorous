<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );

class WPBakeryShortCode_Counter extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => '',
            'from' => '0',
            'to' => '100',
            'speed' => '5000',
            'prefix' => '',
            'suffix' => '',

            'font_type_title' => '',
            'font_container_title' => '',
            'google_fonts_title' => '',
            'font_type_value' => '',
            'font_container_value' => '',
            'google_fonts_value' => '',




            'type' => 'fontawesome',
            'icon_fontawesome' => '',
            'icon_openiconic' => '',
            'icon_typicons' => '',
            'icon_entypoicons' => '',
            'icon_linecons' => '',
            'icon_entypo' => '',
            'color' => '',
            'custom_color' => '',
            'background_style' => '',
            'background_color' => '',
            'size' => 'md',
            'align' => 'center',
            'link' => '',

            'el_class' => '',
            'css' => '',
        ), $atts );
        extract($atts);

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
            $style_title .= 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
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
            $style_value .= 'style="' . esc_attr(implode(';', $styles)) . '"';
        }


        $to = floatval($to);
        $decimals = explode('.', $to);
        $decimals_html = '';
        if(count($decimals) > 1){
            $decimals_html = 'data-decimals="'.esc_attr(strlen($decimals[1])).'"';
        }
        $from = ($from) ? 'data-from="'.$from.'"' : '';


        $counter_content = '<div class="counter-content" '.$style_title.'>'.$suffix.'<span class="couter" '.$from.' data-speed="'.intval($speed).'"  '.$decimals_html.' data-to="'.esc_attr($to).'">'.$to.'</span>'.$prefix.'</div>';
        $counter_text = '<div class="counter-text" '.$style_value.'>'.$title.'</div>';

        $output = '';

        $output .= do_shortcode('[vc_icon addon="1" type="'.$type.'" icon_fontawesome="'.$icon_fontawesome.'" icon_openiconic="'.$icon_openiconic.'" icon_typicons="'.$icon_typicons.'" icon_entypo="'.$icon_entypo.'" icon_linecons="'.$icon_linecons.'" color="'.$type.'" background_style="'.$background_style.'" background_color="'.$background_color.'" size="'.$size.'" align="center"]');
        $output .= $counter_content;
        $output .= $counter_text;







        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'kt-counter-wrapper ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
        );

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        return '<div class="'.esc_attr( $elementClass ).'">'.$output.'</div>';

    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Counter", THEME_LANG),
    "base" => "counter",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Counter", THEME_LANG),
    "params" => array(
        array(
            "type" => "textfield",
            'heading' => __( 'Title', 'js_composer' ),
            'param_name' => 'title',
            'value' => __( 'Title', 'js_composer' ),
            "admin_label" => true,
        ),
        array(
            "type" => "kt_number",
            "heading" => __("Counter from", "js_composer"),
            "param_name" => "from",
            "value" => 0,
            "min" => 1,
            "description" => __( "The number to start counting from. <br/>Enter number for counter without any special character. You may enter a decimal number. Eg 10.17", THEME_LANG ),
        ),

        array(
            "type" => "kt_number",
            "heading" => __("Counter to", "js_composer"),
            "param_name" => "to",
            "admin_label" => true,
            "value" => 100,
            "min" => 1,
            "description" => __( "The number to stop counting at. <br/>Enter number for counter without any special character. You may enter a decimal number. Eg 10.17", THEME_LANG ),
        ),
        array(
            "type" => "textfield",
            'heading' => __( 'Counter Value suffix', THEME_LANG ),
            'param_name' => 'suffix',
            "description" => __( "Enter suffix for counter value" , THEME_LANG),
        ),
        array(
            "type" => "textfield",
            'heading' => __( 'Counter Value prefix', THEME_LANG ),
            'param_name' => 'prefix',
            "description" => __( "Enter prefix for counter value" , THEME_LANG),
        ),
        array(
            "type" => "kt_number",
            "heading" => __("Speed", THEME_LANG),
            "param_name" => "speed",
            "value" => "5000",
            "suffix" => __("milliseconds", THEME_LANG),
            "description" => __( "The number of milliseconds it should take to finish counting", THEME_LANG ),
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
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
            'admin_label' => true,
            'param_name' => 'type',
            'description' => __( 'Select icon library.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_fontawesome',
            'value' => '', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => true,
                // default true, display an "EMPTY" icon?
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'fontawesome',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_openiconic',
            'value' => '', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'openiconic',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'openiconic',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG )
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
                'element' => 'type',
                'value' => 'typicons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_entypo',
            'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'type' => 'entypo',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'entypo',
            ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_linecons',
            'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'type' => 'linecons',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'linecons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Icon color', 'js_composer' ),
            'param_name' => 'color',
            'value' => array_merge( getVcShared( 'colors' ), array( __( 'Custom color', 'js_composer' ) => 'custom' ) ),
            'description' => __( 'Select icon color.', 'js_composer' ),
            'param_holder_class' => 'vc_colored-dropdown',
            'group' => __( 'Icon', THEME_LANG )
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
            'group' => __( 'Icon', THEME_LANG )
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
            ),
            'description' => __( 'Select background shape and style for icon.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Background Color', 'js_composer' ),
            'param_name' => 'background_color',
            'value' => getVcShared( 'colors' ),
            'std' => 'grey',
            'description' => __( 'Background Color.', 'js_composer' ),
            'param_holder_class' => 'vc_colored-dropdown',
            'dependency' => array(
                'element' => 'background_style',
                'not_empty' => true,
            ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Size', 'js_composer' ),
            'param_name' => 'size',
            'value' => array_merge( getVcShared( 'sizes' ), array( 'Extra Large' => 'xl' ) ),
            'std' => 'md',
            'description' => __( 'Icon size.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Icon alignment', 'js_composer' ),
            'param_name' => 'align',
            'value' => array(
                __( 'Left', 'js_composer' ) => 'left',
                __( 'Right', 'js_composer' ) => 'right',
                __( 'Center', 'js_composer' ) => 'center',
            ),
            'description' => __( 'Select icon alignment.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG )
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
                    //'font_style_description' => __('Put your description here','js_composer'),
                    //'font_family_description' => __('Put your description here','js_composer'),
                ),
            ),
            // 'description' => __( '', 'js_composer' ),
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
            // default
            //'font_family:'.rawurlencode('Abril Fatface:400').'|font_style:'.rawurlencode('400 regular:400:normal')
            // this will override 'settings'. 'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900 bold italic:900:italic'),
            'settings' => array(
                //'no_font_style' // Method 1: To disable font style
                //'no_font_style'=>true // Method 2: To disable font style
                'fields' => array(
                    //'font_family' => 'Abril Fatface:regular',
                    //'Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic',// Default font family and all available styles to fetch
                    //'font_style' => '400 regular:400:normal',
                    // Default font style. Name:weight:style, example: "800 bold regular:800:normal"
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
                    //'tag' => 'h2', // default value h2
                    'font_size',
                    'line_height',
                    'color',
                    //'font_style_italic'
                    //'font_style_bold'
                    //'font_family'

                    'tag_description' => __( 'Select element tag.', 'js_composer' ),
                    'text_align_description' => __( 'Select text alignment.', 'js_composer' ),
                    'font_size_description' => __( 'Enter font size.', 'js_composer' ),
                    'line_height_description' => __( 'Enter line height.', 'js_composer' ),
                    'color_description' => __( 'Select heading color.', 'js_composer' ),
                    //'font_style_description' => __('Put your description here','js_composer'),
                    //'font_family_description' => __('Put your description here','js_composer'),
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
            // default
            //'font_family:'.rawurlencode('Abril Fatface:400').'|font_style:'.rawurlencode('400 regular:400:normal')
            // this will override 'settings'. 'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900 bold italic:900:italic'),
            'settings' => array(
                //'no_font_style' // Method 1: To disable font style
                //'no_font_style'=>true // Method 2: To disable font style
                'fields' => array(
                    //'font_family' => 'Abril Fatface:regular',
                    //'Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic',// Default font family and all available styles to fetch
                    //'font_style' => '400 regular:400:normal',
                    // Default font style. Name:weight:style, example: "800 bold regular:800:normal"
                    'font_family_description' => __( 'Select font family.', 'js_composer' ),
                    'font_style_description' => __( 'Select font styling.', 'js_composer' )
                )
            ),
            'group' => __( 'Typography', THEME_LANG ),
            'dependency' => array( 'element' => 'font_type_value', 'value' => array( 'google' ) ),
            'description' => __( '', 'js_composer' ),
        ),

        /** ----------- Design options ------------------- */
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => __( 'Design options', 'js_composer' )
        ),




    ),
));
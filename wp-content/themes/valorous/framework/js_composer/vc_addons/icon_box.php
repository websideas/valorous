<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );

class WPBakeryShortCode_Icon_Box extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => '',
            'icon_box_layout' => '1',
            'icon_box_bg' => '#f7f7f7',
            'link_text' => '',
            'link' => '',

            'font_type' => '',
            'font_container' => '',
            'google_fonts' => '',
            'letter_spacing' => '0',


            'type' => 'fontawesome',
            'icon_fontawesome' => '',
            'icon_openiconic' => '',
            'icon_typicons' => '',
            'icon_entypoicons' => '',
            'icon_linecons' => '',
            'icon_entypo' => '',
            'color' => '',
            'color_hover' => '',
            'custom_color' => '',
            'background_style' => '',
            'background_color' => '',
            'custom_background' => '',
            'background_color_hover' => '',
            'size' => 'md',
            'align' => 'center',
            'link' => '',

            'el_class' => '',
            'css_animation' => '',
            'css' => '',
        ), $atts );
        extract($atts);

        $uniqid = 'kt-icon-box-'.uniqid();

        $style_title = '';

        extract( $this->getAttributes( $atts ) );
        unset($font_container_data['values']['text_align']);

        $styles = array();
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
        if($letter_spacing){
            $styles[] = 'letter-spacing: '.$letter_spacing.'px;';
        }
        if ( ! empty( $styles ) ) {
            $style_title .= 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
        }

        $icon_box_linkmore = $icon_box_link = '';
        if($link){
            $link = ( $link == '||' ) ? '' : $link;
            $link = vc_build_link( $link );
            $a_href = $link['url'];
            $a_title = $link['title'];
            $a_target = $link['target'];
            $icon_box_link = array('href="'.esc_attr( $a_href ).'"', 'title="'.esc_attr( $a_title ).'"', 'target="'.esc_attr( $a_target ).'"' );

            if($link_text){
                $icon_box_linkmore = '<a '.implode(' ', $icon_box_link).' class="icon-box-linkmore">'.__('Learn More', THEME_LANG).'</a>';
            }
            if($title){
                $style_link = '';
                if(isset($font_container_data['values']['color'])){
                    $style_link .= ' style="color: '.$font_container_data['values']['color'].'"';
                }
                $title = '<a '.implode(' ', $icon_box_link).$style_link.'>'.$title.'</a>';
            }

        }

        $icon_box_title = ($title) ? '<div class="icon-box-title" '.$style_title.'>'.$title.'</div>' : '';

        $icon_box_content = '<div class="icon-box-content">'.$content.'</div>';

        $icon_box_icon= do_shortcode('[vc_icon el_class="icon-box-icon" hover_div="'.$uniqid.'" addon="1" uniqid="'.$uniqid.'" color_hover="'.$color_hover.'" background_color_hover="'.$background_color_hover.'" type="'.$type.'" icon_fontawesome="'.$icon_fontawesome.'" icon_openiconic="'.$icon_openiconic.'" icon_typicons="'.$icon_typicons.'" icon_entypo="'.$icon_entypo.'" icon_linecons="'.$icon_linecons.'" color="'.$color.'" custom_color="'.$custom_color.'" background_style="'.$background_style.'" background_color="'.$background_color.'" custom_background="'.$custom_background.'" size="'.$size.'" align="center"]');

        $output = '';
        if($icon_box_layout == 2 || $icon_box_layout == 6){
            $output .= sprintf(
                '<div class="icon-box-left clearfix">%s %s</div>%s %s',
                $icon_box_icon,
                $icon_box_title,
                $icon_box_content,
                $icon_box_linkmore
            );
        }elseif($icon_box_layout == 7 || $icon_box_layout == 9){
            $output .= sprintf(
                '<div class="icon-box-left clearfix">%s %s</div>%s %s',
                $icon_box_title,
                $icon_box_icon,
                $icon_box_content,
                $icon_box_linkmore
            );
        }elseif($icon_box_layout == 3){
            $output .= sprintf(
                '%s<div class="icon-box-right">%s %s %s</div>',
                $icon_box_icon,
                $icon_box_title,
                $icon_box_content,
                $icon_box_linkmore
            );
        }elseif($icon_box_layout == 8){
            $output .= sprintf(
                '<div class="icon-box-right">%s %s %s</div>%s',
                $icon_box_title,
                $icon_box_content,
                $icon_box_linkmore,
                $icon_box_icon
            );
        }else{
            $output .= $icon_box_icon;
            $output .= $icon_box_title;
            $output .= $icon_box_content;
            $output .= $icon_box_linkmore;
        }

        if($icon_box_layout == '4' || $icon_box_layout == '5' || $icon_box_layout == '6' || $icon_box_layout == '9'){
            $output = '<div class="icon-box-inner" style="background:'.$icon_box_bg.';">'.$output.'</div>';
        }



        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'kt-icon-box-wrapper ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'layout' => 'icon-box-layout-'.$icon_box_layout
        );
        if( $icon_box_layout == 2 || $icon_box_layout == 3 || $icon_box_layout == 6 ){
            $elementClass[] = 'kt-icon-box-table';
        }elseif( $icon_box_layout == 7 || $icon_box_layout == 8 || $icon_box_layout == 9 ){
            $elementClass[] = 'kt-icon-box-table-right';
        }
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        return '<div id="'.$uniqid.'" class="'.esc_attr( $elementClass ).'">'.$output.'</div>';

    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Icon box", THEME_LANG),
    "base" => "icon_box",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Icon box description", THEME_LANG),
    "params" => array(
        array(
            "type" => "textfield",
            'heading' => __( 'Title', 'js_composer' ),
            'param_name' => 'title',
            'value' => __( 'Title', 'js_composer' ),
            "admin_label" => true,
        ),
        array(
            'type' => 'vc_link',
            'heading' => __( 'Read More Link Url', 'js_composer' ),
            'param_name' => 'link',
        ),
        array(
            "type" => "textfield",
            'heading' => __( 'Read More Link Text', 'js_composer' ),
            'param_name' => 'link_text',
            'value' => __( 'Learn More', THEME_LANG ),
            'desc' => __('Insert the text to display as the link', THEME_LANG)
        ),
        array(
            "type" => "textarea_html",
            "heading" => __("Content", THEME_LANG),
            "param_name" => "content",
            "value" => __("Put your content here", THEME_LANG),
            "description" => __("", THEME_LANG),
            "holder" => "div",
        ),
        //Layout settings
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout icon box', THEME_LANG ),
            'param_name' => 'icon_box_layout',
            'value' => array(
                __( 'Icon on Top of Title', THEME_LANG ) => '1',
                __( 'Icon beside Title', THEME_LANG ) => '2',
                __( 'Icon beside Title - Icon Right', THEME_LANG ) => '7',
                __( 'Icon beside Title and Content aligned with Title', THEME_LANG ) => '3',
                __( 'Icon beside Title and Content aligned with Title - Icon Right', THEME_LANG ) => '8',
                __( 'Icon Boxed - Icon on Top of Boxed', THEME_LANG ) => '4',
                __( 'Icon Boxed - Icon on Top of Title', THEME_LANG ) => '5',
                __( 'Icon Boxed - Icon beside Title and Content aligned with Title', THEME_LANG ) => '6',
                __( 'Icon Boxed - Icon beside Title and Content aligned with Title - Icon Right', THEME_LANG ) => '9'
            ),
            'description' => __( 'Select your layout.', THEME_LANG ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Background', THEME_LANG ),
            'param_name' => 'icon_box_bg',
            'description' => __( 'Select background for icon box.', THEME_LANG ),
            'dependency' => array("element" => "icon_box_layout","value" => array('4', '5', '6')),
            'value' => '#f7f7f7',
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
            'param_name' => 'type',
            'description' => __( 'Select icon library.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_fontawesome',
            'value' => '',
            'settings' => array(
                'emptyIcon' => true,
                'iconsPerPage' => 4000,
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
            'value' => '',
            'settings' => array(
                'emptyIcon' => true,
                'type' => 'openiconic',
                'iconsPerPage' => 4000,
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
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
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
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
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
            'heading' => __( 'Icon color on Hover', 'js_composer' ),
            'param_name' => 'color_hover',
            'description' => __( 'Select icon color on hover.', 'js_composer' ),
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
                __( 'Hexagonal', 'js_composer' ) => 'hexagonal',
                __( 'Diamond Square', 'js_composer' ) => 'diamond_square',

            ),
            'description' => __( 'Select background shape and style for icon.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Background Color', 'js_composer' ),
            'param_name' => 'background_color',
            'value' => array_merge( getVcShared( 'colors' ), array( __( 'Custom color', 'js_composer' ) => 'custom' ) ),
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
            'type' => 'colorpicker',
            'heading' => __( 'Custom Icon Background', 'js_composer' ),
            'param_name' => 'custom_background',
            'description' => __( 'Select Background icon color.', 'js_composer' ),
            'dependency' => array(
                'element' => 'background_color',
                'value' => 'custom',
            ),
            'group' => __( 'Icon', THEME_LANG )
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Background on Hover', 'js_composer' ),
            'param_name' => 'background_color_hover',
            'description' => __( 'Select Background icon color on hover.', 'js_composer' ),
            'group' => __( 'Icon', THEME_LANG ),
            'dependency' => array(
                'element' => 'background_style',
                'not_empty' => true,
            ),
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





        //Typography settings
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
            "type" => "kt_number",
            "heading" => __("Letter spacing", THEME_LANG),
            "param_name" => "letter_spacing",
            "value" => 0,
            "min" => 0,
            "max" => 10,
            "suffix" => "px",
            "description" => "",
            'group' => __( 'Typography', THEME_LANG ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Font type', 'js_composer' ),
            'param_name' => 'font_type',
            'value' => array(
                __( 'Normal', 'js_composer' ) => '',
                __( 'Google font', 'js_composer' ) => 'google',
            ),
            'group' => __( 'Typography', 'js_composer' ),
            'description' => __( '', 'js_composer' ),
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
            'group' => __( 'Typography', THEME_LANG ),
            'dependency' => array( 'element' => 'font_type', 'value' => array( 'google' ) ),
            'description' => __( '', 'js_composer' ),
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
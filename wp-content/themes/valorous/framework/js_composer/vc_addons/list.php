<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

//Register "container" content element. It will hold all your inner (child) content elements
vc_map( array(
    "name" => __("List", THEME_LANG),
    "base" => "list",
    "category" => __('by Theme', THEME_LANG ),
    "as_parent" => array('only' => 'list_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => true,
    "params" => array(
        
        array(
            'type' => 'kt_animate',
            'heading' => __( 'Animation', 'js_composer' ),
            'param_name' => 'kt_animation',
            'value' => '',
            'description' => __( 'Animation.', 'js_composer' ),
        ),
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
        	'param_name' => 'icon_type',
        	'description' => __( 'Select icon library.', 'js_composer' ),
        ),
        array(
    		'type' => 'iconpicker',
    		'heading' => __( 'Icon', 'js_composer' ),
    		'param_name' => 'icon_fontawesome',
            'value' => 'fa fa-minus',
    		'settings' => array(
    			'emptyIcon' => true, // default true, display an "EMPTY" icon?
    			'iconsPerPage' => 200, // default 100, how many icons per/page to display
    		),
    		'dependency' => array(
    			'element' => 'icon_type',
    			'value' => 'fontawesome',
    		),
    		'description' => __( 'Select icon from library.', 'js_composer' ),
    	),
    	array(
    		'type' => 'iconpicker',
    		'heading' => __( 'Icon', 'js_composer' ),
    		'param_name' => 'icon_openiconic',
    		'settings' => array(
    			'emptyIcon' => true, // default true, display an "EMPTY" icon?
    			'type' => 'openiconic',
    			'iconsPerPage' => 200, // default 100, how many icons per/page to display
    		),
    		'dependency' => array(
    			'element' => 'icon_type',
    			'value' => 'openiconic',
    		),
    		'description' => __( 'Select icon from library.', 'js_composer' ),
    	),
    	array(
    		'type' => 'iconpicker',
    		'heading' => __( 'Icon', 'js_composer' ),
    		'param_name' => 'icon_typicons',
    		'settings' => array(
    			'emptyIcon' => true, // default true, display an "EMPTY" icon?
    			'type' => 'typicons',
    			'iconsPerPage' => 200, // default 100, how many icons per/page to display
    		),
    		'dependency' => array(
        		'element' => 'icon_type',
        		'value' => 'typicons',
        	),
    		'description' => __( 'Select icon from library.', 'js_composer' ),
    	),
    	array(
    		'type' => 'iconpicker',
    		'heading' => __( 'Icon', 'js_composer' ),
    		'param_name' => 'icon_entypo',
    		'settings' => array(
    			'emptyIcon' => true, // default true, display an "EMPTY" icon?
    			'type' => 'entypo',
    			'iconsPerPage' => 300, // default 100, how many icons per/page to display
    		),
    		'dependency' => array(
    			'element' => 'icon_type',
    			'value' => 'entypo',
    		),
    	),
    	array(
    		'type' => 'iconpicker',
    		'heading' => __( 'Icon', 'js_composer' ),
    		'param_name' => 'icon_linecons',
    		'settings' => array(
    			'emptyIcon' => true, // default true, display an "EMPTY" icon?
    			'type' => 'linecons',
    			'iconsPerPage' => 200, // default 100, how many icons per/page to display
    		),
    		'dependency' => array(
    			'element' => 'icon_type',
    			'value' => 'linecons',
    		),
    		'description' => __( 'Select icon from library.', 'js_composer' ),
    	),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Icon color', 'js_composer' ),
            'param_name' => 'icon_color',
            'value' => '',
            'description' => __( 'Select backgound color for your testimonial', 'js_composer' ),
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => __( 'Design options', 'js_composer' )
        ),
    ),
    "js_view" => 'VcColumnView'
) );



vc_map( array(
    "name" => __("List item", "js_composer"),
    "base" => "list_item",
    "content_element" => true,
    "as_child" => array('only' => 'list'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        array(
          "type" => "textarea_html",
          "heading" => __("Content", THEME_LANG),
          "param_name" => "content",
          "value" => __("Put your content here", THEME_LANG),
          "description" => __("", THEME_LANG),
          "holder" => "div",
        ),

        array(
            'type' => 'kt_switch',
            'heading' => __( 'Custom icon', THEME_LANG ),
            'param_name' => 'custom_icon',
            'value' => 'false',
            "description" => __("Close button in alert", THEME_LANG),
        ),

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
        	'param_name' => 'icon_type',
        	'description' => __( 'Select icon library.', 'js_composer' ),
            "dependency" => array("element" => "custom_icon","value" => array('true')),
        ),
        array(
    		'type' => 'iconpicker',
    		'heading' => __( 'Icon', 'js_composer' ),
    		'param_name' => 'icon_fontawesome',
            'value' => '',
    		'settings' => array(
    			'emptyIcon' => true, // default true, display an "EMPTY" icon?
    			'iconsPerPage' => 200, // default 100, how many icons per/page to display
    		),
    		'dependency' => array(
    			'element' => 'icon_type',
    			'value' => 'fontawesome',
    		),
    		'description' => __( 'Select icon from library.', 'js_composer' ),
    	),
    	array(
    		'type' => 'iconpicker',
    		'heading' => __( 'Icon', 'js_composer' ),
    		'param_name' => 'icon_openiconic',
    		'settings' => array(
    			'emptyIcon' => true, // default true, display an "EMPTY" icon?
    			'type' => 'openiconic',
    			'iconsPerPage' => 200, // default 100, how many icons per/page to display
    		),
    		'dependency' => array(
    			'element' => 'icon_type',
    			'value' => 'openiconic',
    		),
    		'description' => __( 'Select icon from library.', 'js_composer' ),
    	),
    	array(
    		'type' => 'iconpicker',
    		'heading' => __( 'Icon', 'js_composer' ),
    		'param_name' => 'icon_typicons',
    		'settings' => array(
    			'emptyIcon' => true, // default true, display an "EMPTY" icon?
    			'type' => 'typicons',
    			'iconsPerPage' => 200, // default 100, how many icons per/page to display
    		),
    		'dependency' => array(
        		'element' => 'icon_type',
        		'value' => 'typicons',
        	),
    		'description' => __( 'Select icon from library.', 'js_composer' ),
    	),
    	array(
    		'type' => 'iconpicker',
    		'heading' => __( 'Icon', 'js_composer' ),
    		'param_name' => 'icon_entypo',
    		'settings' => array(
    			'emptyIcon' => true, // default true, display an "EMPTY" icon?
    			'type' => 'entypo',
    			'iconsPerPage' => 300, // default 100, how many icons per/page to display
    		),
    		'dependency' => array(
    			'element' => 'icon_type',
    			'value' => 'entypo',
    		),
    	),
    	array(
    		'type' => 'iconpicker',
    		'heading' => __( 'Icon', 'js_composer' ),
    		'param_name' => 'icon_linecons',
    		'settings' => array(
    			'emptyIcon' => true, // default true, display an "EMPTY" icon?
    			'type' => 'linecons',
    			'iconsPerPage' => 200, // default 100, how many icons per/page to display
    		),
    		'dependency' => array(
    			'element' => 'icon_type',
    			'value' => 'linecons',
    		),
    		'description' => __( 'Select icon from library.', 'js_composer' ),
    	),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Icon color', 'js_composer' ),
            'param_name' => 'icon_color',
            'value' => '',
            'description' => __( 'Select backgound color for your testimonial', 'js_composer' ),
            "dependency" => array("element" => "custom_icon","value" => array('true')),
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
    )
) );

class WPBakeryShortCode_List extends WPBakeryShortCodesContainer {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'kt_animation' => '',
            'icon_type' => 'fontawesome',
            'icon_fontawesome' => '',
        	'icon_openiconic' => '',
        	'icon_typicons' => '',
        	'icon_entypo' => '',
        	'icon_linecons' => '',
            'icon_color' => '',
            'el_class' => '',
            'css' => ''
        ), $atts ) );
        
        global $icon_show, $icon_color_show;
        
        $icon_color_show = '';

        if($icon_type){
            $icon = 'icon_'.$icon_type;
            $icon_value = $$icon;
            if($icon_value){
                vc_icon_element_fonts_enqueue( $icon_type );
                $icon_color_show = ($icon_color) ? ' style="color: '.esc_attr($icon_color).';"' : '';
                $icon_show = '<span class="vc_icon_element-icon '.esc_attr($icon_value).'" '.$icon_color_show.'></span> ';
            }
        }


        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'kt-list-wrapper ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        return '<div class="'.esc_attr( $elementClass ).'"><ul data-timeeffect="10" class="kt-list-fancy animation-effect">' . do_shortcode($content) . '</ul></div>';

    }
}

class WPBakeryShortCode_List_Item extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'custom_icon' => 'false',
            'icon_type' => 'fontawesome',
            'icon_fontawesome' => '',
        	'icon_openiconic' => '',
        	'icon_typicons' => '',
        	'icon_entypo' => '',
        	'icon_linecons' => '',
            'icon_color' => '',
            'el_class' => '',
        ), $atts ) );
        $icon_li = '';
        
        global $icon_show, $icon_color_show;
        
        if($icon_type && $custom_icon == 'true'){
            $icon = 'icon_'.$icon_type;
            $icon_value = $$icon;
            if($icon_value){
                vc_icon_element_fonts_enqueue( $icon_type );
                $icon_color = $icon_color ? ' style="color: '.esc_attr($icon_color).';"' : $icon_color_show;
                $icon_li = '<span class="vc_icon_element-icon '.esc_attr($icon_value).'" '.$icon_color.'></span> ';
            }
        }
        
        if(!$icon_li) $icon_li = $icon_show;
        
        return '<li class="kt-list-item animation-effect-item '.$el_class.'">' . $icon_li . do_shortcode($content) . '</li>';
        
    }
}

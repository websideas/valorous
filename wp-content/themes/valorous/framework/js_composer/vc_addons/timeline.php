<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

//Register "container" content element. It will hold all your inner (child) content elements
vc_map( array(
    "name" => __("Timeline", THEME_LANG),
    "base" => "timeline",
    "category" => __('by Theme', THEME_LANG ),
    "as_parent" => array('only' => 'timeline_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => true,
    "params" => array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Timeline Type', 'js_composer' ),
            'param_name' => 'timeline_tyle',
            'value' => array(
                __( 'Vertical', 'js_composer' ) => 'vertical',
                __( 'Horizontal', 'js_composer' ) => 'horizontal',

            ),
            'description' => __( 'Select Timeline Type.', 'js_composer' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Timeline Column', 'js_composer' ),
            'param_name' => 'timeline_column',
            'value' => array(
                __( '4 Column', 'js_composer' ) => '4',
                __( '3 Column', 'js_composer' ) => '3',
                __( '2 Column', 'js_composer' ) => '2',

            ),
            'description' => __( 'Timeline Column.', 'js_composer' ),
            'dependency' => array(
                'element' => 'timeline_tyle',
                'value' => 'horizontal',
            ),
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
    "name" => __("Timeline item", "js_composer"),
    "base" => "timeline_item",
    "content_element" => true,
    "as_child" => array('only' => 'timeline'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
    
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "admin_label" => true,
            "value" => 'Title'
        ),
        
        array(
          "type" => "textarea_html",
          "heading" => __("Content", THEME_LANG),
          "param_name" => "content",
          "value" => __("Put your content here", THEME_LANG),
          "description" => __("", THEME_LANG),
          "holder" => "div",
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
            "type" => "textfield",
            "heading" => __("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
    )
) );

class WPBakeryShortCode_Timeline extends WPBakeryShortCodesContainer {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'timeline_tyle' => '',
            'timeline_column' => '',
            'color' => '',
            'color_hover' => '',
            'custom_color' => '',
            'background_style' => '',
            'background_color' => '',
            'background_color_hover' => '',
            'size' => 'xl',
            'el_class' => '',
            'css' => ''
        ), $atts ) );
        global $data_icon, $data_type;
        
        $data_type = $timeline_tyle;
        $data_icon = 'color_hover="'.$color_hover.'" background_color_hover="'.$background_color_hover.'" color="'.$color.'" custom_color="'.$custom_color.'" background_style="'.$background_style.'" background_color="'.$background_color.'" size="'.$size.'"';
        
        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'kt-timeline-wrapper ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        if(isset( $timeline_column ) || $timeline_column != ''){
            $column = 'column-'.$timeline_column;
        }

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        return '<div class="'.esc_attr( $elementClass ).'"><ul class="kt-timeline-'.$timeline_tyle.' '.$column.'">' . do_shortcode($content) . '</ul></div>';

    }
}

class WPBakeryShortCode_Timeline_Item extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'icon_type' => 'fontawesome',
            'icon_fontawesome' => 'fa fa-heart',
        	'icon_openiconic' => '',
        	'icon_typicons' => '',
        	'icon_entypo' => '',
        	'icon_linecons' => '',
            'el_class' => '',
        ), $atts ) );
        
        global $data_icon, $data_type;
        
        $uniqid = 'kt-timeline-item-'.uniqid();
        
        $icon_box_icon = do_shortcode('[vc_icon el_class="icon-timeline" hover_div="'.$uniqid.'" addon="1" uniqid="'.$uniqid.'" type="'.$icon_type.'" icon_fontawesome="'.$icon_fontawesome.'" icon_openiconic="'.$icon_openiconic.'" icon_typicons="'.$icon_typicons.'" icon_entypo="'.$icon_entypo.'" icon_linecons="'.$icon_linecons.'" '.$data_icon.']');
        
        $output = '<li id="'.$uniqid.'" class="kt-timeline-item item-'.$data_type.' '.$el_class.'">';
            $output .= $icon_box_icon;
            if( $data_type == 'horizontal' ) $output .= '<div class="divider-icon"></div>';
            $output .= '<div class="timeline-info">';
                if( $title ) $output .= '<h4 class="timeline-title">'.$title.'</h4>';
                if( $content ) $output .= do_shortcode($content);
            $output .= '</div>';
        $output .= '</li>';
        return $output;
    }
}
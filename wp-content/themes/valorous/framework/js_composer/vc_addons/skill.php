<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );

class WPBakeryShortCode_Skill extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => __( 'Title', 'js_composer' ),
            'percent' => 88,

            'options' => '',
            'boxbgcolor' => '',
            'bgcolor' => 'accent',
            'height' => 10,
            'style' => 'before',
            'custombgcolor' => '',
            'gradient_start' => '',
            'gradient_end' => '',
            'border_style' => '',
            'border_color' => '',
            'border_size' => '',
            'border_radius' => '',

            'use_theme_fonts' => '',
            'font_container' => '',
            'google_fonts' => '',

            'padding_box' => '',
            'padding_left' => '',
            'padding_right' => '',
            'el_class' => '',

            'css' => '',
        ), $atts );

        extract( $atts );
        //if(!$title || $percent) return;
        
        $output = '';
        $style_skill_arr = $style_bar_arr = $style_text_arr = array();

        $bar_options = '';
        $options = explode( ",", $options );
        if ( in_array( "animated", $options ) ) {
            $bar_options .= " animated";
        }
        if ( in_array( "striped", $options ) ) {
            $bar_options .= " striped";
        }
        
        if($border_style){
            $style_skill_arr[] = "border: ".$border_size.'px '.$border_style.' '.$border_color;
        }
        if($border_radius && $border_style){
            $style_skill_arr[] = $style_bar_arr[] = 'border-radius: '.$border_radius.'px';
            $style_skill_arr[] = $style_bar_arr[] = '-webkit-border-radius: '.$border_radius.'px';
            $style_skill_arr[] = $style_bar_arr[] = '-moz-border-radius: '.$border_radius.'px';
        }
        if($padding_box && $border_style){
            $style_skill_arr[] = 'padding: '.$padding_box.'px';
        }
        if($boxbgcolor){
            $style_skill_arr[] = 'background-color: '.$boxbgcolor;  
        }
        
        $style_skill = '';
        if ( ! empty( $style_skill_arr ) ) {
        	$style_skill = 'style="' . esc_attr( implode( ';', $style_skill_arr ) ) . '"';
        }
        
        if($bgcolor == 'custom'){
            $style_bar_arr[] = 'background-color: '.$custombgcolor;
        }elseif($bgcolor == 'gradient'){
            $style_bar_arr[] = "background: {$gradient_start}";
            $style_bar_arr[] = "background: -moz-linear-gradient(left,  {$gradient_start} 0%, {$gradient_end} 100%)";
            $style_bar_arr[] = "background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,{$gradient_start}), color-stop(100%,{$gradient_end}))";
            $style_bar_arr[] = "background: -webkit-linear-gradient(left,  {$gradient_start} 0%,{$gradient_end} 100%)";
            $style_bar_arr[] = "background: -o-linear-gradient(left,  {$gradient_start} 0%,{$gradient_end} 100%)";
            $style_bar_arr[] = "background: -ms-linear-gradient(left,  {$gradient_start} 0%,{$gradient_end} 100%)";
            $style_bar_arr[] = "background: linear-gradient(to right,  {$gradient_start} 0%,{$gradient_end} 100%)";
            $style_bar_arr[] = "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$gradient_start}', endColorstr='{$gradient_end}',GradientType=1 )";
        }
        //$style_bar_arr[] = 'width: '.$percent.'%';
        if($style =='before' || $style =='after'){
            $style_bar_arr[] = 'height: '.$height.'px';
        }
        
        $style_bar = '';
        if ( ! empty( $style_bar_arr ) ) {
        	$style_bar = 'style="' . esc_attr( implode( ';', $style_bar_arr ) ) . '"';
        }



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
            $style_text_arr = array_merge($style_text_arr, $styles);
        }


        if($style =='inner'){
            $style_text_arr[] = 'line-height: '.$height.'px';
        }
        if($padding_left){
            $style_text_arr[] = 'padding-left: '.$padding_left.'px';
        }
        if($padding_right){
            $style_text_arr[] = 'padding-right: '.$padding_right.'px';
        } 
        
        $style_text = '';
        if ( ! empty( $style_text_arr ) ) {
        	$style_text = 'style="' . esc_attr( implode( ';', $style_text_arr ) ) . '"';
        }
        
        $text = "<div class='kt-skill-text' {$style_text}>{$title} <span>$percent%</span></div>";
        $bar = "<div class='kt-skill-bar ".esc_attr($bar_options)."' {$style_bar} data-percent='{$percent}'><span></span></div>";
        //$bar .= "<div class='kt-skill-bar-stripe' data-percent='{$percent}'></div>";

        if($style == 'inner'){
            $output .= "<div class='kt-skill-bg kt-skill-bg-".$bgcolor."' ".$style_skill."><div class='kt-skill-content'>".$text.$bar."</div></div>";
        }elseif($style == 'before'){
            $output .= "$text<div class='kt-skill-bg kt-skill-bg-{$bgcolor}' {$style_skill}>$bar</div>";
        }else{
            $output .= "<div class='kt-skill-bg kt-skill-bg-{$bgcolor}' {$style_skill}>$bar</div>$text";
        }

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'kt-skill-wrapper ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'style' => 'kt-style-'.$style,
            'bgcolor' => 'kt-bgcolor-'.$bgcolor
        );

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

    	return '<div class="'.esc_attr( $elementClass ).'"><div class="kt-skill-content">'.$output.'</div></div>';
    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Skill", THEME_LANG),
    "base" => "skill",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Skill", THEME_LANG),
    "params" => array(
        array(
			"type" => "textfield",
			'heading' => __( 'Title', 'js_composer' ),
			'param_name' => 'title',
            'value' => __( 'Title', 'js_composer' ),
			"admin_label" => true,
		),
        array(
            'type' => 'hidden',
            'heading' => __( 'URL (Link)', 'js_composer' ),
            'param_name' => 'link',
        ),
        array(
			"type" => "kt_number",
			"heading" => __("Percent", "js_composer"),
			"param_name" => "percent",
            "admin_label" => true,
            "value" => 88,
			"min" => 1,
			"max" => 100,
            "suffix" => "%",
		),
        array(
			'type' => 'checkbox',
			'heading' => __( 'Options', 'js_composer' ),
			'param_name' => 'options',
			'value' => array(
				__( 'Add Stripes?', 'js_composer' ) => 'striped',
				__( 'Add animation? Will be visible with striped bars.', 'js_composer' ) => 'animated'
			),
		),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Style', 'js_composer' ),
            'param_name' => 'style',
            'value' => array(
                __( 'Title before skill', 'js_composer' ) => 'before',
                __( 'Title after skill', 'js_composer' ) => 'after',
                __( 'Title inner skill', 'js_composer' ) => 'inner',
            ),
            'description' => __( 'Select skill background color.', 'js_composer' ),
            'admin_label' => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        /** ----------- Design options ------------------- */
        array(
            "type" => "kt_heading",
            "heading" => __("Box style", "js_composer"),
            "param_name" => "box_style",
            'group' => __( 'Layout options', 'js_composer' )
        ),
        array(
			'type' => 'colorpicker',
			'heading' => __( 'Background color', 'js_composer' ),
			'param_name' => 'boxbgcolor',
			'description' => __( 'Select background color for box.', 'js_composer' ),
            "value" => '#F8F8F8',
            'group' => __( 'Layout options', 'js_composer' )
		),
        array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Border Style", 'js_composer'),
			"param_name" => "border_style",
			"value" => array(
				"None"=> "",
				"Solid"=> "solid",
				"Dashed" => "dashed",
				"Dotted" => "dotted",
				"Double" => "double",
				"Inset" => "inset",
				"Outset" => "outset",
			),
			"description" => "",
			'group' => __( 'Layout options', 'js_composer' )
		),
        array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Border Color", 'js_composer'),
			"param_name" => "border_color",
			"value" => "",
			"description" => "",
			"dependency" => array("element" => "border_style", "not_empty" => true),
			'group' => __( 'Layout options', 'js_composer' )
		),

		array(
			"type" => "kt_number",
			"class" => "",
			"heading" => __("Border Width", 'js_composer'),
			"param_name" => "border_size",
			"value" => 1,
			"min" => 1,
			"max" => 10,
			"suffix" => "px",
			"description" => "",
			"dependency" => array("element" => "border_style", "not_empty" => true),
			'group' => __( 'Layout options', 'js_composer' )
		),
		array(
			"type" => "kt_number",
			"class" => "",
			"heading" => __("Border Radius",'js_composer'),
			"param_name" => "border_radius",
			"value" => 3,
			"min" => 0,
			"max" => 500,
			"suffix" => "px",
			"description" => "",
			"dependency" => array("element" => "border_style", "not_empty" => true),
			'group' => __( 'Layout options', 'js_composer' )
	  	),
        array(
			"type" => "kt_number",
			"class" => "",
			"heading" => __("Padding", 'js_composer'),
			"param_name" => "padding_box",
			"value" => 2,
			"min" => 0,
			"max" => 10,
			"suffix" => "px",
			"description" => "Don't use for Title inner box",
			"dependency" => array("element" => "border_style", "not_empty" => true),
			'group' => __( 'Layout options', 'js_composer' )
		),



        array(
            "type" => "kt_heading",
            "heading" => __("Skill style", "js_composer"),
            "param_name" => "skill_style",
            'group' => __( 'Layout options', 'js_composer' )
        ),
        array(
			"type" => "kt_number",
			"class" => "",
			"heading" => __("Bar Height", 'js_composer'),
			"param_name" => "height",
			"value" => 10,
			"suffix" => "px",
			'group' => __( 'Layout options', 'js_composer' )
		),
        array(
            "type" => "kt_number",
            "heading" => __("Padding left",'js_composer'),
            "param_name" => "padding_left",
            "suffix" => "px",
            'value' => 0,
            'group' => __( 'Layout options', 'js_composer' ),
            'edit_field_class' => 'vc_col-sm-4 vc_column',
            'description' => '&nbsp;',
        ),

        array(
            "type" => "kt_number",
            "heading" => __("Padding right",'js_composer'),
            "param_name" => "padding_right",
            "suffix" => "px",
            'value' => 0,
            'group' => __( 'Layout options', 'js_composer' ),
            'edit_field_class' => 'vc_col-sm-4 vc_column',
            'description' => '&nbsp;',
        ),
        array(
			'type' => 'dropdown',
			'heading' => __( 'Background', 'js_composer' ),
			'param_name' => 'bgcolor',
			'value' => array(
				__( 'Accent', 'js_composer' ) => 'accent',
				__( 'Custom Color', 'js_composer' ) => 'custom',
                __( 'Custom Gradient', 'js_composer' ) => 'gradient',
			),
			'description' => __( 'Select skill background color.', 'js_composer' ),
			'admin_label' => true,
            'group' => __( 'Layout options', 'js_composer' )
		),
        array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom background color', 'js_composer' ),
			'param_name' => 'custombgcolor',
			'description' => __( 'Select custom background color for skill.', 'js_composer' ),
			'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) ),
            'group' => __( 'Layout options', 'js_composer' )
		),
        array(
			'type' => 'colorpicker',
			'heading' => __( 'Background color start', 'js_composer' ),
			'param_name' => 'gradient_start',
            'class' => 'gradient_start',
            'description' => __( 'Select custom background color for skill.', 'js_composer' ),
            'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'gradient' ) ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => __( 'Layout options', 'js_composer' )
		),
        array(
			'type' => 'colorpicker',
			'heading' => __( 'Background color end', 'js_composer' ),
			'param_name' => 'gradient_end',
            'class' => 'gradient_end',
            'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'gradient' ) ),
            'description' => __( 'Select custom background color for skill.', 'js_composer' ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => __( 'Layout options', 'js_composer' )
		),
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
            // 'description' => __( '', 'js_composer' ),
            'group' => __( 'Layout options', 'js_composer' )
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Use theme default font family?', 'js_composer' ),
            'param_name' => 'use_theme_fonts',
            'value' => array( __( 'Yes', 'js_composer' ) => 'yes' ),
            'description' => __( 'Use font family from the theme.', 'js_composer' ),
            'group' => __( 'Layout options', 'js_composer' )
        ),
        array(
			'type' => 'google_fonts',
			'param_name' => 'google_fonts',
			'value' => '', // default
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
            'dependency' => array(
                'element' => 'use_theme_fonts',
                'value_not_equal_to' => 'yes',
            ),
            'group' => __( 'Layout options', 'js_composer' )
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
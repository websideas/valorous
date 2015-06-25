<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class WPBakeryShortCode_Socials extends WPBakeryShortCode {
    protected function content($atts, $content = null) {

        extract(shortcode_atts(array(
    	   "social" => '',
    	   "size" => 'standard',
    	   "style" => 'icon',
           'align' => '',
           'tooltip' =>'top',
           'el_class' => '',

            'css' => '',
    	), $atts));

        $output = $social_icons = '';

        $socials_arr = array(
            'facebook' => array('title' => __('Facebook', THEME_LANG), 'icon' => 'fa fa-facebook', 'link' => '%s'),
            'twitter' => array('title' => __('Twitter', THEME_LANG), 'icon' => 'fa fa-twitter', 'link' => 'http://www.twitter.com/%s'),
            'dribbble' => array('title' => __('Dribbble', THEME_LANG), 'icon' => 'fa fa-dribbble', 'link' => 'http://www.dribbble.com/%s'),
            'vimeo' => array('title' => __('Vimeo', THEME_LANG), 'icon' => 'fa fa-vimeo-square', 'link' => 'http://www.vimeo.com/%s'),
            'tumblr' => array('title' => __('Tumblr', THEME_LANG), 'icon' => 'fa fa-tumblr', 'link' => 'http://%s.tumblr.com/'),
            'skype' => array('title' => __('Skype', THEME_LANG), 'icon' => 'fa fa-skype', 'link' => 'skype:%s'),
            'linkedin' => array('title' => __('LinkedIn', THEME_LANG), 'icon' => 'fa fa-linkedin', 'link' => '%s'),
            'googleplus' => array('title' => __('Google Plus', THEME_LANG), 'icon' => 'fa fa-google-plus', 'link' => '%s'),
            'youtube' => array('title' => __('Youtube', THEME_LANG), 'icon' => 'fa fa-youtube', 'link' => 'http://www.youtube.com/user/%s'),
            'pinterest' => array('title' => __('Pinterest', THEME_LANG), 'icon' => 'fa fa-pinterest', 'link' => 'http://www.pinterest.com/%s'),
            'instagram' => array('title' => __('Instagram', THEME_LANG), 'icon' => 'fa fa-instagram', 'link' => 'http://instagram.com/%s'),
        );

        foreach($socials_arr as $k => &$v){
            $val = kt_option($k);
            $v['val'] = ($val) ? $val : '';
        }

        $tooltiphtml = '';

        if($tooltip) {
            $tooltiphtml .= ' data-toggle="tooltip" data-placement="'.esc_attr($tooltip).'" ';
        }

        if($social){
            $social_type = explode(',', $social);
            foreach ($social_type as $id) {
                $val = $socials_arr[$id];
                $social_text = '<i class="'.esc_attr($val['icon']).'"></i>';
                if($style == '3d'){
                    $social_text = '<span class="front"><i class="'.esc_attr($val['icon']).'"></i></span><span class="back"><i class="'.esc_attr($val['icon']).'"></i></span>';
                }
                $social_icons .= '<li><a class="'.esc_attr($id).'" title="'.esc_attr($val['title']).'" '.$tooltiphtml.' href="'.esc_url(str_replace('%s', $val['val'], $val['link'])).'" target="_blank">'.$social_text.'</a></li>'."\n";
            }
        }else{
            foreach($socials_arr as $key => $val){
                $social_text = '<i class="'.esc_attr($val['icon']).'"></i>';
                if($style == '3d'){
                    $social_text = '<span class="front"><i class="'.esc_attr($val['icon']).'"></i></span><span class="back"><i class="'.esc_attr($val['icon']).'"></i></span>';
                }
                $social_icons .= '<li><a class="'.esc_attr($key).'"  '.$tooltiphtml.' title="'.esc_attr($val['title']).'" href="'.esc_url(str_replace('%s', $val['val'], $val['link'])).'" target="_blank">'.$social_text.'</a></li>'."\n";
            }
        }

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'socials-icon-wrapper', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'style' => 'model-'.$style,
            'size' => 'social-icons-'.$size,
            'clearfix' => 'clearfix'
        );

        if($align){
            $elementClass['align'] = 'social-icons-'.$align;
        }

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

    	$output .= '<div class="'.esc_attr( $elementClass ).'"><ul class="social-nav clearfix">';
    	$output .= $social_icons;
    	$output .= '</ul></div>';
     
    	return $output;
    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Social", THEME_LANG),
    "base" => "socials",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Social", THEME_LANG),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "kt_socials",
            "class" => "",
            "heading" => __("Choose social", THEME_LANG),
            "param_name" => "social",
            "value" => '',
            "description" => __("Empty for select all, Drop and sortable social", THEME_LANG),
            "admin_label" => true,
        ),
        array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Style",THEME_LANG),
			"param_name" => "style",
			"value" => array(
                __('Style 1', THEME_LANG) => '1',
                __('Style 2', THEME_LANG) => '2',
                __('Style 3', THEME_LANG) => '3',
                __('Style 4', THEME_LANG) => '4',
                __('Style 5', THEME_LANG) => '5',
                __('Style 6', THEME_LANG) => '6',
                __('Style 7', THEME_LANG) => '7',
                __('Style 3d', THEME_LANG) => '3d'

			),
			"description" => __("",THEME_LANG),
            "admin_label" => true,
		),
        array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Size",THEME_LANG),
			"param_name" => "size",
			"value" => array(
                __('Standard', THEME_LANG) => 'standard',
                __('Small', THEME_LANG) => 'small',
			),
			"description" => __("",THEME_LANG),
            "admin_label" => true,
		),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __("Tooltip",THEME_LANG),
            "param_name" => "tooltip",
            "value" => array(
                __('None', THEME_LANG) => '',
                __('Top', THEME_LANG) => 'top',
                __('Right', THEME_LANG) => 'right',
                __('Bottom', THEME_LANG) => 'bottom',
                __('Left', THEME_LANG) => 'left',
            ),
            'std' => 'top',
            "description" => __("Select the tooltip position",THEME_LANG),
            "admin_label" => true,
        ),

        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __("Align",THEME_LANG),
            "param_name" => "align",
            "value" => array(
                __('None', THEME_LANG) => '',
                __('Center', THEME_LANG) => 'center',
                __('Left', THEME_LANG) => 'left',
                __('Right', THEME_LANG) => 'right'
            ),
            "description" => __("",THEME_LANG)
        ),

        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
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
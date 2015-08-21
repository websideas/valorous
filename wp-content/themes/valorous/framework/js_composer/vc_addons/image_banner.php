<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Image_Banner extends WPBakeryShortCode {
    
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'image' => '',
            'image_size' => 'full',
            'position' => 'position-center',
            'align' => 'align-center',
            'link' => '',

            'css' => '',
            'css_animation' => '',
            'el_class' => '',
        ), $atts );

        extract($atts);
        $output = '';
        
        $img_id = preg_replace( '/[^\d]/', '', $image );
        $img = wpb_getImageBySize( array(
            'attach_id' => $img_id,
            'thumb_size' => $image_size,
            'class' => 'vc_single_image-img img-responsive'
        ) );
        if ( $img == null ) {
            $img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
        }
        
        $elementClass = array(
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $output .= '<div class="kt_image_banner '.$position.' '.$align.'">'.$img['thumbnail'];
            if($content){
                $output .= '<div class="content_banner_wrapper"><div class="content_banner '.esc_attr( $elementClass ).'">'.do_shortcode($content).'</div></div>';
            }
            if( $link ){
                $link = ( $link == '||' ) ? '' : $link;
                $link = vc_build_link( $link );
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = $link['target'];
                $button_link = array('href="'.esc_attr( $a_href ).'"', 'title="'.esc_attr( $a_title ).'"', 'target="'.esc_attr( $a_target ).'"' );
                
                $output .= '<a class="banner-link" '.implode(' ', $button_link).'></a>';
            }
        $output .= '</div>';
        
    	return $output;
    }
    
    public function singleParamHtmlHolder( $param, $value ) {
		$output = '';
		// Compatibility fixes
		$old_names = array( 'yellow_message', 'blue_message', 'green_message', 'button_green', 'button_grey', 'button_yellow', 'button_blue', 'button_red', 'button_orange' );
		$new_names = array( 'alert-block', 'alert-info', 'alert-success', 'btn-success', 'btn', 'btn-info', 'btn-primary', 'btn-danger', 'btn-warning' );
		$value = str_ireplace( $old_names, $new_names, $value );
		//$value = __($value, "js_composer");
		//
		$param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
		$type = isset( $param['type'] ) ? $param['type'] : '';
		$class = isset( $param['class'] ) ? $param['class'] : '';

		if ( isset( $param['holder'] ) == false || $param['holder'] == 'hidden' ) {
			if ( ( $param['type'] ) == 'attach_image' ) {
                $output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" />';
				$element_icon = $this->settings('icon');
				$img = wpb_getImageBySize( array( 'attach_id' => (int)preg_replace( '/[^\d]/', '', $value ), 'thumb_size' => 'thumbnail' ) );
				$this->setSettings('logo', ( $img ? $img['thumbnail'] : '<img width="150" height="150" src="' . vc_asset_url( 'vc/blank.gif' ) . '" class="attachment-thumbnail vc_element-icon"  data-name="' . $param_name . '" alt="" title="" style="display: none;" />' ) . '<span class="no_image_image vc_element-icon' . ( !empty($element_icon) ? ' '.$element_icon : '' ) . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '" /><a href="#" class="column_edit_trigger' . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '">' . __( 'Add image', 'js_composer' ) . '</a>');
				$output .= $this->outputTitleTrue($this->settings['name']);
			}

		} else {
			$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">' . $value . '</' . $param['holder'] . '>';
		}

		if ( ! empty( $param['admin_label'] ) && $param['admin_label'] === true ) {
			$output .= '<span class="vc_admin_label admin_label_' . $param['param_name'] . ( empty( $value ) ? ' hidden-label' : '' ) . '"><label>' . __( $param['heading'], 'js_composer' ) . '</label>: ' . $value . '</span>';
		}

		return $output;
	}
	protected function outputTitle($title) {
		return '';
	}
	protected function outputTitleTrue($title) {
		return  '<h4 class="wpb_element_title">'.__($title, 'js_composer').' '.$this->settings('logo').'</h4>';
	}
    
}

vc_map( array(
    "name" => __( "Image Banner", THEME_LANG),
    "base" => "image_banner",
    "category" => __('by Theme', THEME_LANG ),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
			'type' => 'attach_image',
			'heading' => __( 'Image Banner', THEME_LANG ),
			'param_name' => 'image',
			'description' => __( 'Select image from media library.', 'js_composer' ),
		),
        array(
            "type" => "kt_image_sizes",
            "heading" => __( "Select image sizes", THEME_LANG ),
            "param_name" => "image_size",
            "std" => 'full',
        ),
        array(
            'type' => 'vc_link',
            'heading' => __( 'URL (Link)', 'js_composer' ),
            'param_name' => 'link',
            'description' => __( 'Enter button link.', 'js_composer' )
        ),
        array(
            "type" => "textarea_html",
            "heading" => __("Content", THEME_LANG),
            "param_name" => "content",
            "description" => __("", THEME_LANG),
            "admin_label" => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Content Position', THEME_LANG ),
            'param_name' => 'position',
            'value' => array(
                __( 'Top', THEME_LANG ) => 'position-top',
                __( 'Center', THEME_LANG ) => 'position-center',
                __( 'Bottom', THEME_LANG ) => 'position-bottom',
            ),
            'std' => 'position-center',
            'description' => __( 'Position of content.', THEME_LANG ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Text Align', THEME_LANG ),
            'param_name' => 'align',
            'value' => array(
                __( 'Left', THEME_LANG ) => 'align-left',
                __( 'Center', THEME_LANG ) => 'align-center',
                __( 'Right', THEME_LANG ) => 'align-right',
            ),
            'std' => 'align-center',
            'description' => __( 'Align of text.', THEME_LANG ),
        ),
        
        array(
        	'type' => 'dropdown',
        	'heading' => __( 'CSS Animation', 'js_composer' ),
        	'param_name' => 'css_animation',
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
            "heading" => __( "Extra class name", "js_composer"),
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
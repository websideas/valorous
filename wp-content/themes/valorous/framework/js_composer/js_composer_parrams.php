<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Heading field.
 *
 */
function ktheading_settings_field( $settings, $value ) {
    $dependency = '';
	$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
	$type = isset($settings['type']) ? $settings['type'] : '';
	$class = isset($settings['class']) ? $settings['class'] : '';
    
    return '<input type="hidden" class="wpb_vc_param_value ' . $settings['param_name'] . ' ' . $settings['type'] . ' ' . $class . '" name="' . $param_name . '" value="'.esc_attr($value).'" '.$dependency.'/>';
}
vc_add_shortcode_param( 'kt_heading', 'ktheading_settings_field' );


/**
 * Number field.
 *
 */
function vc_ktnumber_settings_field($settings, $value){
	$dependency = '';
	$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
	$type = isset($settings['type']) ? $settings['type'] : '';
	$min = isset($settings['min']) ? $settings['min'] : '';
	$max = isset($settings['max']) ? $settings['max'] : '';
	$suffix = isset($settings['suffix']) ? $settings['suffix'] : '';
	$class = isset($settings['class']) ? $settings['class'] : '';
	$output = '<input type="number" min="'.esc_attr($min).'" max="'.esc_attr($max).'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.esc_attr($value).'" '.$dependency.' style="max-width:100px; margin-right: 10px;" />'.$suffix;
	return $output;
}
vc_add_shortcode_param('kt_number' , 'vc_ktnumber_settings_field');


/**
 * Radio select field.
 *
 */
function vc_kt_radio_settings_field($settings, $value) {
	$dependency = '';
    $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
	$type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    $class_input = isset($settings['class_input']) ? $settings['class_input'] : '';

    $output = "";
    $uniqid = uniqid();
    $radios = array();
    
    if(!count($settings['value'])) return;
    foreach( $settings['value'] as $k => $v ) {
        $checked = ($value == $k) ? ' checked="checked"' : '';
        $radios[] = "<label><input type='radio' name='{$param_name}_radio_{$uniqid}' class='kt_radio_select_input' value='{$k}' {$checked} /> {$v}</label>";
    }
    $output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.esc_attr($value).'" '.$dependency.' />';
    
    return $output."<div class='".$class_input."'>".implode(' ', $radios)."</div>";
}
vc_add_shortcode_param('kt_radio', 'vc_kt_radio_settings_field', FW_JS.'kt_radio.js');


/**
 * Switch field.
 *
 */
function kt_switch_settings_field($settings, $value) {
	$dependency = '';
    $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
	$type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    $uniqeID    = uniqid();
    if(!$value){
        if(isset($settings['value'])){
            $value = $settings['value'];
        }
    }
    $output = "";
    $checked = ($value == 'true') ? 'checked="checked"': '';
    $output .= '<input type="checkbox" name="' . $param_name . '" class="wpb_vc_param_value cmn-toggle cmn-toggle-round-flat ' . $param_name . ' ' . $type . ' ' . $class . ' " '.$checked.' id="cmn-toggle-'.$uniqeID.'" value="'.esc_attr($value).'" '.$dependency.'>';
    $output .= '<label for="cmn-toggle-'.$uniqeID.'"></label>';
    
    return $output;
}
vc_add_shortcode_param('kt_switch', 'kt_switch_settings_field', FW_JS.'kt_switch.js');



/**
 * Taxonomy checkbox list field.
 *
 */
function vc_kt_taxonomy_settings_field($settings, $value) {
	$dependency = '';

	$value_arr = $value;
	if ( !is_array($value_arr) ) {
		$value_arr = array_map( 'trim', explode(',', $value_arr) );
	}
    $output = '';
	if ( !empty($settings['taxonomy']) ) {

        $placeholder = '';
        $terms_fields = array();
        if($settings['placeholder']){
            $placeholder = 'data-placeholder="'.$settings['placeholder'].'"';
        }
        
        $terms = get_terms( $settings['taxonomy'] , array('hide_empty' => false));
		if ( $terms && !is_wp_error($terms) ) {
			foreach( $terms as $term ) {
                $selected = (in_array( $term->term_id, $value_arr )) ? ' selected="selected"' : '';
                $terms_fields[] = "<option value='{$term->term_id}' {$selected}>{$term->name}</option>";
			}
		}

        $size = (!empty($settings['size'])) ? 'size="'.esc_attr($settings['size']).'"' : '';
        $multiple = (!empty($settings['multiple'])) ? 'multiple="multiple"' : '';

        $output = '<select '.$placeholder.' '.$multiple.' '.$size.' name="'.esc_attr($settings['param_name']).'" class="wpb_vc_param_value kt-select-field wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field" '.$dependency.'>'
                    .implode( $terms_fields )
                .'</select>';

	}
    
    return $output;
}
vc_add_shortcode_param('kt_taxonomy', 'vc_kt_taxonomy_settings_field', FW_JS.'kt_select.js');

/**
 * Posts field.
 *
 */
function vc_kt_posts_settings_field($settings, $value) {
	$dependency = '';
    $output = '';
    
	$value_arr = $value;
	if ( !is_array($value_arr) ) {
		$value_arr = array_map( 'trim', explode(',', $value_arr) );
	}
    $posts_fields = array();
    $placeholder = '';
    if($settings['placeholder']){
        $placeholder = 'data-placeholder="'.$settings['placeholder'].'"';
    }
    
    if ( !empty($settings['args']) ) {
        
        $query = new WP_Query( $settings['args']);
        if ( $query->have_posts() ) {
        	while ( $query->have_posts() ) { $query->the_post();
                $selected = (in_array( get_the_ID(), $value_arr )) ? ' selected="selected"' : '';
                $posts_fields[] = "<option value='".get_the_ID()."' {$selected}>".get_the_title()."</option>";
        	}
        }
        wp_reset_postdata();

        $size = (!empty($settings['size'])) ? 'size="'.$settings['size'].'"' : '';
        $multiple = (!empty($settings['multiple'])) ? 'multiple="multiple"' : '';

        $output = '<select '.$placeholder.' '.$multiple.' '.$size.' name="'.esc_attr($settings['param_name']).'" class="wpb_vc_param_value kt-select-field wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field" '.$dependency.'>'
                    .implode( $posts_fields )
                .'</select>';
    }
    return $output;
}
vc_add_shortcode_param('kt_posts', 'vc_kt_posts_settings_field', FW_JS.'kt_select.js');




/**
 * Authors field.
 *
 */
function vc_kt_authors_settings_field($settings, $value) {
	$dependency = '';
    $output = '';
    
	$value_arr = $value;
	if ( !is_array($value_arr) ) {
		$value_arr = array_map( 'trim', explode(',', $value_arr) );
	}

    $terms_fields = array();
    $placeholder = '';
    if($settings['placeholder']){
        $placeholder = 'data-placeholder="'.$settings['placeholder'].'"';
    }

    $args = array();
    $authors = get_users( $args );
    foreach( $authors as $author ) {
        $selected = (in_array( $author->ID, $value_arr )) ? ' selected="selected"' : '';
        $terms_fields[] = "<option value='{$author->ID}' {$selected}>{$author->display_name}</option>";
    }

    $size = (!empty($settings['size'])) ? 'size="'.$settings['size'].'"' : '';
    $multiple = (!empty($settings['multiple'])) ? 'multiple="multiple"' : '';

    $output = '<select '.$placeholder.' '.$multiple.' '.$size.' name="'.esc_attr($settings['param_name']).'" class="wpb_vc_param_value kt-select-field wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field" '.$dependency.'>'
                .implode( $terms_fields )
            .'</select>';

    return $output;

}
vc_add_shortcode_param('kt_authors', 'vc_kt_authors_settings_field', FW_JS.'kt_select.js');
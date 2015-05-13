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
 * Image select field.
 *
 */
function vc_kt_image_select_settings_field($settings, $value) {
	$dependency = '';
    $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
	$type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    
    $output = "";
    $uniqid = uniqid();
    $radios = array();
    
    if(!count($settings['value'])) return;
    foreach( $settings['value'] as $k => $v ) {
        $checked = ($value == $k) ? ' checked="checked"' : '';
        $radios[] = "<label><input type='radio' name='{$param_name}_radio_{$uniqid}' class='kt_image_select_radio' value='{$k}' {$dependency} {$checked} /> <img src='{$v}' alt=''/></label>";
    }
    $output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.esc_attr($value).'" '.$dependency.' />';
    
    return $output.implode(' ', $radios);
}
vc_add_shortcode_param('kt_image_select', 'vc_kt_image_select_settings_field', FW_JS.'kt_image_select.js');


/**
 * Switch field.
 *
 */
function kt_switch_settings_field($settings, $value) {
	$dependency = '';
    $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
	$type = isset($settings['type']) ? $settings['type'] : '';
    $class = isset($settings['class']) ? $settings['class'] : '';
    
    $output = "";
    
    print_r($settings);
    
    $output .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="cmn-toggle-2">';
    $output .= '<label for="cmn-toggle-2"></label>';
    
    $output .= '';
    
    $output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.esc_attr($value).'" '.$dependency.' />';
    
    return $value.$output;
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
		
        $terms_fields = array();
        if($settings['placeholder']){
            $terms_fields[] = "<option value=''>".$settings['placeholder']."</option>";
        }
        
        $terms = get_terms( $settings['taxonomy'] , array('hide_empty' => false));
		if ( $terms && !is_wp_error($terms) ) {
			foreach( $terms as $term ) {
                $selected = (in_array( $term->term_id, $value_arr )) ? ' selected="selected"' : '';
                $terms_fields[] = "<option value='{$term->term_id}' {$selected}>{$term->name}</option>";
			}
		}

        $size = (!empty($settings['size'])) ? 'size="'.$settings['size'].'"' : '';
        $multiple = (!empty($settings['multiple'])) ? 'multiple="multiple"' : '';
        
        $uniqeID    = uniqid();
        
        $output = '<select id="kt_taxonomy-'.$uniqeID.'" '.$multiple.' '.$size.' name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field" '.$dependency.'>'
                    .implode( $terms_fields )
                .'</select>';
                
        $output .= '<script type="text/javascript">jQuery("#kt_taxonomy-' . $uniqeID . '").chosen();</script>';

	}
    
    return $output;
}
vc_add_shortcode_param('kt_taxonomy', 'vc_kt_taxonomy_settings_field', FW_LIBS.'chosen/chosen.jquery.min.js');

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

    $terms_fields = array();
    if($settings['placeholder']){
        $terms_fields[] = "<option value=''>".$settings['placeholder']."</option>";
    }
    
    if ( !empty($settings['post_type']) ) {
        
        $query = new WP_Query( array('post_type' => $settings['post_type']) );
        if ( $query->have_posts() ) {
        	while ( $query->have_posts() ) { $query->the_post();
                $selected = (in_array( get_the_ID(), $value_arr )) ? ' selected="selected"' : '';
                $terms_fields[] = "<option value='".get_the_ID()."' {$selected}>".get_the_title()."</option>";
        	}
        }
        wp_reset_postdata();

        $size = (!empty($settings['size'])) ? 'size="'.$settings['size'].'"' : '';
        $multiple = (!empty($settings['multiple'])) ? 'multiple="multiple"' : '';
        $uniqeID    = uniqid();
        
        $output .= '<select id="kt_posts-'.$uniqeID.'" '.$multiple.' '.$size.' name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field" '.$dependency.'>'
                    .implode( $terms_fields )
                .'</select>';
        $output .= '<script type="text/javascript">jQuery("#kt_posts-' . $uniqeID . '").chosen();</script>';
    }
    return $output;
}
vc_add_shortcode_param('kt_posts', 'vc_kt_posts_settings_field', FW_LIBS.'chosen/chosen.jquery.min.js');




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
    if($settings['placeholder']){
        $terms_fields[] = "<option value=''>".$settings['placeholder']."</option>";
    }
    
    $authors = get_users( $args );
    foreach( $authors as $author ) {
        $selected = (in_array( $author->ID, $value_arr )) ? ' selected="selected"' : '';
        $terms_fields[] = "<option value='{$author->ID}' {$selected}>{$author->display_name}</option>";
    }

    $size = (!empty($settings['size'])) ? 'size="'.$settings['size'].'"' : '';
    $multiple = (!empty($settings['multiple'])) ? 'multiple="multiple"' : '';
    $uniqeID    = uniqid();
    
    $output .= '<select id="kt_authors-'.$uniqeID.'" multiple="multiple" '.$size.' name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field" '.$dependency.'>'
                .implode( $terms_fields )
            .'</select>';
    
    $output .= '<script type="text/javascript">jQuery("#kt_authors-' . $uniqeID . '").chosen();</script>';
            
    return $output;

}
vc_add_shortcode_param('kt_authors', 'vc_kt_authors_settings_field', FW_LIBS.'chosen/chosen.jquery.min.js');




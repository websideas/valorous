<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Sales_Countdown_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => '',
            'border_heading' => '',
            'per_page' => 12,
            'orderby' => 'date',
            'order' => 'DESC',
            'autoplay' => '', 
            'navigation' => '',
            'slidespeed' => 200,
            'theme' => 'style-navigation-center',
            'desktop' => 2,
            'tablet' => 1,
            'mobile' => 1,
            'css_animation' => '',
            'el_class' => '',
            'columns' => 1,
            'css' => '',   
        ), $atts );
        extract($atts);
        $output = '';
        
        global $woocommerce_loop;
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'sales-countdown-carousel-wrapper ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        if($theme == 'style-navigation-top'){
            $elementClass['carousel'] = 'carousel-wrapper-top';
            $title = ($title) ? $title : "&nbsp;";
        }
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $output .= '<div class="'.esc_attr( $elementClass ).'">';
        
        if($title){
            $heading_class = "block-heading";
            if($border_heading){
                $heading_class .= " block-heading-underline";
            }
            $output .= '<div class="'.esc_attr($heading_class).'">';
                $output .= '<h3>'.$title.'</h3>';
            $output .= '</div>';
        }
        
        // Get products on sale
		$product_ids_on_sale = wc_get_product_ids_on_sale();

		$meta_query = WC()->query->get_meta_query();

		$args = array(
			'posts_per_page'	=> $atts['per_page'],
			'orderby' 			=> $atts['orderby'],
			'order' 			=> $atts['order'],
			'no_found_rows' 	=> 1,
			'post_status' 		=> 'publish',
			'post_type' 		=> 'product',
			'meta_query' 		=> $meta_query,
			'post__in'			=> array_merge( array( 0 ), $product_ids_on_sale )
		);
        
        ob_start();
		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
		$woocommerce_loop['columns'] = $atts['columns'];
        if ( $products->have_posts() ) :
			woocommerce_product_loop_start();
				while ( $products->have_posts() ) : $products->the_post();
					wc_get_template_part( 'content', 'product-sale' );
				endwhile; // end of the loop.
			woocommerce_product_loop_end();
		endif;
		wp_reset_postdata();
        
        $data_carousel = array(
            "autoheight" => "false",
            "autoplay" => $autoplay,
            "navigation" => $navigation,
            "slidespeed" => $slidespeed,
            "pagination" => "false",
            "theme" => $theme,
            "itemscustom" => '[[992,'.$desktop.'], [768, '.$tablet.'], [480, '.$mobile.']]'
        );
                    
        $output .= '<div class="woocommerce-carousel-wrapper" '.render_data_carousel($data_carousel).'>';
		$output .= '<div class="woocommerce columns-' . esc_attr($atts['columns']) . '">' . ob_get_clean() . '</div>';
        $output .= '</div><!-- .woocommerce-carousel-wrapper -->';
        $output .= '</div>';
        
    	return $output;
    }
}

vc_map( array(
    "name" => __( "Sales Countdown Carousel", THEME_LANG),
    "base" => "sales_countdown_carousel",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "", THEME_LANG),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "description" => __( "Title", THEME_LANG ),
            "admin_label" => true,
        ),
        array(
			'type' => 'checkbox',
			'heading' => __( 'Border in heading', THEME_LANG ),
			'param_name' => 'border_heading',
			'value' => array( __( 'Yes, please', 'js_composer' ) => 'true' ),
		),
        array(
			'type' => 'textfield',
			'heading' => __( 'Per page', 'js_composer' ),
			'value' => 12,
			'param_name' => 'per_page',
			'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
		),
        array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'js_composer' ),
			'param_name' => 'orderby',
			'value' => array(
                __( 'Date', 'js_composer' ) => 'date',
    			__( 'ID', 'js_composer' ) => 'ID',
    			__( 'Author', 'js_composer' ) => 'author',
    			__( 'Title', 'js_composer' ) => 'title',
    			__( 'Modified', 'js_composer' ) => 'modified',
    			__( 'Random', 'js_composer' ) => 'rand',
    			__( 'Comment count', 'js_composer' ) => 'comment_count',
    			__( 'Menu order', 'js_composer' ) => 'menu_order',
            ),
			'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'js_composer' ),
			'param_name' => 'order',
			'value' => array(
                __( 'Descending', 'js_composer' ) => 'DESC',
                __( 'Ascending', 'js_composer' ) => 'ASC',
            ),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
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
            "heading" => __( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        // Carousel
        array(
			'type' => 'checkbox',
			'heading' => __( 'AutoPlay', THEME_LANG ),
			'param_name' => 'autoplay',
			'value' => array( __( 'Yes, please', 'js_composer' ) => 'true' ),
            'group' => __( 'Carousel settings', THEME_LANG )
		),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Navigation', THEME_LANG ),
			'param_name' => 'navigation',
			'value' => array( __( "Don't use Navigation", 'js_composer' ) => 'false' ),
            'description' => __( "Don't display 'next' and 'prev' buttons.", THEME_LANG ),
            'group' => __( 'Carousel settings', THEME_LANG )
		),
        array(
    		'type' => 'dropdown',
    		'heading' => __( 'Theme',THEME_LANG ),
    		'param_name' => 'theme',
    		'value' => array(
    			__( 'Navigation Top', THEME_LANG ) => 'style-navigation-top',
    			__( 'Navigation Center', THEME_LANG ) => 'style-navigation-center',
                __( 'Navigation Bottom', THEME_LANG ) => 'style-navigation-bottom',
    		),
            'std' => 'style-navigation-center',
            'description' => __( 'Please your theme for carousel', THEME_LANG ),
            'group' => __( 'Carousel settings', THEME_LANG )
    	),
        array(
			"type" => "kt_number",
			"heading" => __("Slide Speed", THEME_LANG),
			"param_name" => "slidespeed",
			"value" => "200",
            "suffix" => __("milliseconds", THEME_LANG),
			"description" => __('Slide speed in milliseconds', THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
	  	),
        array(
          "type" => "kt_heading",
          "heading" => __("Items to Show?", THEME_LANG),
          "param_name" => "items_show",
          "value" => "6",
          'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Desktop", THEME_LANG),
			"param_name" => "desktop",
			"value" => "2",
			"min" => "1",
			"max" => "25",
			"step" => "1",
            'group' => __( 'Carousel settings', THEME_LANG )
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Tablet", THEME_LANG),
			"param_name" => "tablet",
			"value" => "1",
			"min" => "1",
			"max" => "25",
			"step" => "1",
            'group' => __( 'Carousel settings', THEME_LANG )
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Mobile", THEME_LANG),
			"param_name" => "mobile",
			"value" => "1",
			"min" => "1",
			"max" => "25",
			"step" => "1",
            'group' => __( 'Carousel settings', THEME_LANG )
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


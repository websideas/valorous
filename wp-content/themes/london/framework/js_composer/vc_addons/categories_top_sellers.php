<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class WPBakeryShortCode_Categories_Top_Sellers extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => '',
            'categories' => '',
            'per_page' => 4,
            'columns' => 4,
            'css_animation' => '',
            'css' => '',
            'el_class' => '',
        ), $atts );
        extract( $atts );
        $output = '';
        
        global $woocommerce_loop;
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'categories-top-sellers-wrapper ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        $output .= '<div class="'.esc_attr( $elementClass ).'">';
            $title = ($title) ? $title : "&nbsp;";
            $uniqeID    = uniqid();
            
            $heading_class = "block-heading block-heading-tabs-wapper block-heading-tabs-wapper clearfix";
            
            $output .= '<div class="'.$heading_class.'">';
                $output .= '<h3>'.$title.'</h3>';
                if($categories){
                    $output .= "<ul class='block-heading-tabs'>";
                        $categories_arr = explode(',', $categories);
                        foreach( $categories_arr as $category ){
                            $term = get_term( $category, 'product_cat' );
                            $output .= "<li><a href='#tab-".$term->slug.'-'.$uniqeID."'>".$term->name."</a></li>";
                        }
                    $output .= "</ul>";
                }
            $output .= '</div>';
            
            
            if($categories){
                $categories_arr = explode(',', $categories);
                
                $meta_query = WC()->query->get_meta_query();
        		$args = array(
        			'post_type'           => 'product',
        			'post_status'         => 'publish',
        			'ignore_sticky_posts' => 1,
        			'posts_per_page'      => $atts['per_page'],
        			'meta_key'            => 'total_sales',
        			'orderby'             => 'meta_value_num',
        			'meta_query'          => $meta_query
        		);
                $output .= "<div class='categories-top-sellers-tabs'>";
                foreach($categories_arr as $category){
                    $args['tax_query'] = array( array( 'taxonomy' => 'product_cat', 'field' => 'id', 'terms' => $category ) );
                    $term = get_term( $category, 'product_cat' );
                    $output .= "<div id='tab-".$term->slug.'-'.$uniqeID."' class='categories-top-sellers-tab'>";
                    
                    ob_start();
            		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
            		$woocommerce_loop['columns'] = $atts['columns'];
            
            		if ( $products->have_posts() ) :
            			woocommerce_product_loop_start();
            				while ( $products->have_posts() ) : $products->the_post();
            					wc_get_template_part( 'content', 'product' );
            				endwhile; // end of the loop.
            			woocommerce_product_loop_end();
            		endif;
            		wp_reset_postdata();
                    
            		$output .=  '<div class="woocommerce columns-' . $atts['columns'] . '">' . ob_get_clean() . '</div>';
                    $output .= '</div><!-- .categories-top-sellers-tab -->';
                }
                $output .= "</div><!-- .categories-top-sellers-tabs -->";
            }
        $output .= '</div><!-- .categories-top-sellers-wrapper -->';
        
        return $output;
    }
}

// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Categories top sellers", THEME_LANG),
    "base" => "categories_top_sellers",
    "category" => __('by Theme', THEME_LANG ),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "admin_label" => true,
        ),
        array(
			"type" => "kt_taxonomy",
            'taxonomy' => 'product_cat',
			'heading' => __( 'Categories', 'js_composer' ),
			'param_name' => 'categories',
            'placeholder' => __( 'Select your categories', 'js_composer' ),
            "dependency" => array("element" => "source","value" => array('categories')),
            'multiple' => true,
		),
        array(
			'type' => 'textfield',
			'heading' => __( 'Per page', 'js_composer' ),
			'value' => 12,
			'param_name' => 'per_page',
			'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
		),
        array(
			'type' => 'textfield',
			'heading' => __( 'Columns', 'js_composer' ),
			'value' => 4,
			'param_name' => 'columns',
			'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
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
        array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		),
    ),
));



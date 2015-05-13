<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Designer_Products extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'posts' => '',
            'max_items' => 10,
            'num_products' =>  9,
            'css_animation' => '',
            'orderby' => 'date',
            'meta_key' => '',
            'order' => 'DESC',
            'desktop' => 4,
            'tablet' => 2,
            'mobile' => 1,
            'el_class' => '',
            'css' => '',
        ), $atts ) );

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc-designer-product ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        ob_start();
        
        echo '<div class="vc-designer-product-wrapper">';
        echo '<div class="sidebar '.esc_attr($elementClass).'">';
        the_widget( 'KT_WC_Designer', $atts,  array(
            'before_widget' => '<section  class="widget-container woocommerce widget_designer">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
            'widget_id' => ''
        ) );
        echo '</div>';
        echo '</div>';


        $output = ob_get_clean();
        return $output;


    }
}

vc_map( array(
    "name" => __( "Designer Products", THEME_LANG),
    "base" => "designer_products",
    "category" => __('by Theme', THEME_LANG ),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "admin_label" => true,
        ),

        array(
            "type" => "kt_posts",
            'post_type' => 'collection',
            'heading' => __( 'Collection', 'js_composer' ),
            'param_name' => 'collection_ids',
            'multiple' => true,
           // "dependency" => array("element" => "source","value" => array('posts')),
        ),

        array(
            'type' => 'textfield',
            'heading' => __( 'How many products per designer to show ?', 'js_composer' ),
            'param_name' => 'number',
            'value' => 3, // default value
            'param_holder_class' => 'vc_not-for-custom',
            'description' => __( 'Set max limit for items or enter -1 to display all (limited to 1000).', 'js_composer' )
        ),

        array(
            'type' => 'dropdown',
            'heading' => __( 'Show', 'js_composer' ),
            'param_name' => 'show',
            'admin_label' => true,
            'value' => array(
                __( 'All Products', 'woocommerce' ) => ''        ,
                __( 'Featured Products', 'woocommerce' ) => 'featured',
                 __( 'On-sale Products', 'woocommerce' ) => 'onsale',
            ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => __( 'Order by', 'js_composer' ),
            'param_name' => 'orderby',
            'admin_label' => true,
            'value' => array(
                __( 'Date', 'woocommerce' ) => 'date'        ,
                __( 'Price', 'woocommerce' ) => 'price'        ,
                __( 'Random', 'woocommerce' ) => 'rand'        ,
                __( 'Sales', 'woocommerce' ) => 'sales'        ,
            ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => __( 'Order', 'js_composer' ),
            'param_name' => 'order',
            'admin_label' => true,
            'value' => array(
                __( 'Desc', 'woocommerce' ) => 'desc'        ,
                __( 'ASC', 'woocommerce' ) => 'asc'        ,
            ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => __( 'Hide free', 'js_composer' ),
            'param_name' => 'hide_free',
            'admin_label' => true,
            'value' => array(
                __( 'No', 'woocommerce' ) => '0'        ,
                __( 'Yes', 'woocommerce' ) => '1'        ,
            ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => __( 'Show hidden products', 'js_composer' ),
            'param_name' => 'show_hidden',
            'admin_label' => true,
            'value' => array(
                __( 'No', 'woocommerce' ) => '0'        ,
                __( 'Yes', 'woocommerce' ) => '1'        ,
            ),
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


        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => __( 'Design options', 'js_composer' )
        ),
    ),
));
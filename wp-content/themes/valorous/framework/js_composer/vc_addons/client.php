<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Client extends WPBakeryShortCode {
    var $excerpt_length;
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'client_style' => 'style1',
            'image_size' => 'thumbnail',
            'source' => 'all',
            'categories' => '',
            'posts' => '',
            'authors' => '',
            'orderby' => 'date',
            'meta_key' => '',
            'order' => 'DESC',

            'desktop' => 3,
            'tablet' => 2,
            'mobile' => 1,

            'css' => '',
            'css_animation' => '',
            'el_class' => '',
        ), $atts );

        extract($atts);
        
        $args = array(
                    'post_type' => 'kt_client',
                    'order' => $order,
                    'orderby' => $orderby,
                    'posts_per_page' => -1,
                    'ignore_sticky_posts' => true
                );
        
        if($orderby == 'meta_value' || $orderby == 'meta_value_num'){
            $args['meta_key'] = $meta_key;
        }
        if($source == 'categories'){
            if($categories){
                $categories_arr = array_filter(explode( ',', $categories));
                if(count($categories_arr)){
                    $args['tax_query'] = array(
                                    		array(
                                    			'taxonomy' => 'client-category',
                                    			'field' => 'id',
                                    			'terms' => $categories
                                    		)
                                    	);
                }
            }
        }elseif($source == 'posts'){
            if($posts){
                $posts_arr = array_filter(explode( ',', $posts));
                if(count($posts_arr)){
                    $args['post__in'] = $posts_arr;
                }
            }
        }

        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'kt_client-wrapper ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );


        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $col_desktop = 12/$desktop;
        $col_tab = 12/$tablet;
        $col_mobile = 12/$mobile;
        
        $output  = '';
        $output .= '<div class="'.esc_attr( $elementClass ).'">';
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
                $output .= '<div class="kt_client"><div class="row '.$client_style.'" data-desktop="'.$desktop.'" data-tablet="'.$tablet.'" data-mobile="'.$mobile.'">';
                    while ( $query->have_posts() ) : $query->the_post();
                        $thumbnail = get_thumbnail_attachment(get_post_thumbnail_id(),$image_size);
                        $output .= '<div class="kt_client_col col-xs-'.$col_mobile.' col-sm-'.$col_tab.' col-md-'.$col_desktop.'"><div class="client-logo" style="background-image: url('.$thumbnail['url'].');"></div></div>';
                    endwhile; wp_reset_postdata();
                $output .= '</div></div>';
            endif;
        $output .= '</div>';


    	return $output;
    }
}

vc_map( array(
    "name" => __( "Client", THEME_LANG),
    "base" => "client",
    "category" => __('by Theme', THEME_LANG ),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "kt_image_sizes",
            "heading" => __( "Select image sizes", THEME_LANG ),
            "param_name" => "image_size",
        ),
        //Layout settings
        array(
            'type' => 'dropdown',
            'heading' => __( 'Style', THEME_LANG ),
            'param_name' => 'client_style',
            'value' => array(
                __( 'Style 1', THEME_LANG ) => 'style1',
                __( 'Style 2', THEME_LANG ) => 'style2',
            ),
            'description' => __( 'Select your style.', THEME_LANG ),
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
        // Data settings
        array(
            "type" => "dropdown",
            "heading" => __("Data source", THEME_LANG),
            "param_name" => "source",
            "value" => array(
                __('All', THEME_LANG) => '',
                __('Specific Categories', THEME_LANG) => 'categories',
                __('Specific Client', THEME_LANG) => 'posts',
            ),
            "admin_label" => true,
            'std' => 'all',
            "description" => __("Select content type for your posts.", THEME_LANG),
            'group' => __( 'Data settings', 'js_composer' ),
        ),
        array(
            "type" => "kt_taxonomy",
            'taxonomy' => 'client-category',
            'heading' => __( 'Categories', THEME_LANG ),
            'param_name' => 'categories',
            'placeholder' => __( 'Select your categories', THEME_LANG ),
            "dependency" => array("element" => "source","value" => array('categories')),
            'multiple' => true,
            'group' => __( 'Data settings', 'js_composer' ),
        ),
        array(
            "type" => "kt_posts",
            'args' => array('post_type' => 'kt_client', 'posts_per_page' => -1),
            'heading' => __( 'Specific Client', 'js_composer' ),
            'param_name' => 'posts',
            'placeholder' => __( 'Select your posts', 'js_composer' ),
            "dependency" => array("element" => "source","value" => array('posts')),
            'multiple' => true,
            'group' => __( 'Data settings', 'js_composer' ),
        ),
        array(
    		'type' => 'dropdown',
    		'heading' => __( 'Order by', 'js_composer' ),
    		'param_name' => 'orderby',
    		'value' => array(
    			__( 'Date', 'js_composer' ) => 'date',
    			__( 'Order by post ID', 'js_composer' ) => 'ID',
    			__( 'Author', 'js_composer' ) => 'author',
    			__( 'Title', 'js_composer' ) => 'title',
    			__( 'Last modified date', 'js_composer' ) => 'modified',
    			__( 'Post/page parent ID', 'js_composer' ) => 'parent',
    			__( 'Number of comments', 'js_composer' ) => 'comment_count',
    			__( 'Menu order/Page Order', 'js_composer' ) => 'menu_order',
    			__( 'Meta value', 'js_composer' ) => 'meta_value',
    			__( 'Meta value number', 'js_composer' ) => 'meta_value_num',
    			__( 'Random order', 'js_composer' ) => 'rand',
    		),
    		'description' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'js_composer' ),
    		'group' => __( 'Data settings', 'js_composer' ),
    		'param_holder_class' => 'vc_grid-data-type-not-ids',
            "admin_label" => true,
    	),
    	array(
    		'type' => 'textfield',
    		'heading' => __( 'Meta key', 'js_composer' ),
    		'param_name' => 'meta_key',
    		'description' => __( 'Input meta key for grid ordering.', 'js_composer' ),
    		'group' => __( 'Data settings', 'js_composer' ),
    		'param_holder_class' => 'vc_grid-data-type-not-ids',
    		'dependency' => array(
    			'element' => 'orderby',
    			'value' => array( 'meta_value', 'meta_value_num' ),
    		),
            "admin_label" => true,
    	),
        array(
    		'type' => 'dropdown',
    		'heading' => __( 'Sorting', 'js_composer' ),
    		'param_name' => 'order',
    		'group' => __( 'Data settings', 'js_composer' ),
    		'value' => array(
    			__( 'Descending', 'js_composer' ) => 'DESC',
    			__( 'Ascending', 'js_composer' ) => 'ASC',
    		),
    		'param_holder_class' => 'vc_grid-data-type-not-ids',
    		'description' => __( 'Select sorting order.', 'js_composer' ),
            "admin_label" => true,
    	),
        
        array(
            "type" => "dropdown",
            "class" => "",
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            "heading" => __("On Desktop", THEME_LANG),
            "param_name" => "desktop",
            "value" => array(
                __( '6 Column', 'js_composer' ) => '6',
                __( '4 Column', 'js_composer' ) => '4',
    			__( '3 Column', 'js_composer' ) => '3',
    			__( '2 Column', 'js_composer' ) => '2',
                __( '1 Column', 'js_composer' ) => '1',
    		),
            'std' => '3',
            'group' => __( 'Column settings', THEME_LANG ),
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            "heading" => __("On Tablet", THEME_LANG),
            "param_name" => "tablet",
            "value" => array(
                __( '6 Column', 'js_composer' ) => '6',
                __( '4 Column', 'js_composer' ) => '4',
    			__( '3 Column', 'js_composer' ) => '3',
    			__( '2 Column', 'js_composer' ) => '2',
                __( '1 Column', 'js_composer' ) => '1',
    		),
            'std' => '2',
            'group' => __( 'Column settings', THEME_LANG ),
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            "heading" => __("On Mobile", THEME_LANG),
            "param_name" => "mobile",
            "value" => array(
                __( '6 Column', 'js_composer' ) => '6',
                __( '4 Column', 'js_composer' ) => '4',
    			__( '3 Column', 'js_composer' ) => '3',
    			__( '2 Column', 'js_composer' ) => '2',
                __( '1 Column', 'js_composer' ) => '1',
    		),
            'std' => '1',
            'group' => __( 'Column settings', THEME_LANG ),
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


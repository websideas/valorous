<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Team_Carousel extends WPBakeryShortCode {
    var $excerpt_length;
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => '',
            'border_heading' => '',
            'team_layout' => '',

            'source' => 'all',
            'categories' => '',
            'posts' => '',
            'authors' => '',
            'orderby' => 'date',
            'meta_key' => '',
            'order' => 'DESC',
            'max_items' => 10,
            "excerpt_length" => 50,

            'margin' => 10,
            'loop' => 'false',
            'autoheight' => 'true',
            'autoplay' => 'false',
            'mousedrag' => 'true',
            'autoplayspeed' => 5000,
            'slidespeed' => 200,
            'desktop' => 4,
            'tablet' => 2,
            'mobile' => 1,

            'navigation' => 'true',
            'navigation_always_on' => 'false',
            'navigation_position' => 'center_outside',
            'navigation_style' => '',
            'navigation_border_width' => '1',
            'navigation_border_color' => '',
            'navigation_background' => '',
            'navigation_color' => '',
            'navigation_icon' => 'fa fa-angle-left|fa fa-angle-right',

            'pagination' => 'true',
            'pagination_color' => '',
            'pagination_icon' => 'circle-o',

            'css' => '',
            'css_animation' => '',
            'el_class' => '',
        ), $atts );

        extract($atts);

        $this->excerpt_length = $excerpt_length;
        
        $args = array(
                    'post_type' => 'kt_team',
                    'order' => $order,
                    'orderby' => $orderby,
                    'posts_per_page' => $max_items,
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
                                    			'taxonomy' => 'team-category',
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
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'team-carousel-wrapper ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );


        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $output  = '';
        $output .= '<div class="'.esc_attr( $elementClass ).'">';
            
            if($title){
                $output .= '<div class="block-heading">';
                    $output .= '<h3>'.$title.'</h3>';
                $output .= '</div>';
            }

            
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :

                $carousel_ouput = kt_render_carousel(apply_filters( 'kt_render_args', $atts));
                $team_html = '';

                add_filter( 'excerpt_length', array($this, 'custom_excerpt_length'), 999 );
                
                while ( $query->have_posts() ) : $query->the_post();
                    //Team image
                    $team_image = get_the_post_thumbnail( get_the_ID(), 'recent_posts', array('class'=>"img-responsive"));
                    
                    //Team title
                    $team_title = '<h4 class="entry-title">'.get_the_title().'</h4>';
                    
                    //Team content
                    $team_content = '<div class="team-content">'.get_the_excerpt().'</div>';
                    
                    //Team Regency
                    $regency = rwmb_meta( '_kt_team_regency' );
                    $team_regency = '<span class="team-regency">'.$regency.'</span>';
                    
                    //Team Social
                    $twitter = rwmb_meta( '_kt_team_twitter' );
                    $facebook = rwmb_meta( '_kt_team_facebook' );
                    $google = rwmb_meta( '_kt_team_googleplus' );
                    
                    if( $twitter || $facebook || $google ){
                        $team_social = '<ul class="team-social">';
                            if( $twitter ){ $team_social.= '<li><a href="'.$twitter.'"><i class="fa fa-twitter"></i></a></li>'; }
                            if( $facebook ){ $team_social.= '<li><a href="'.$facebook.'"><i class="fa fa-facebook"></i></a></li>'; }
                            if( $google ){ $team_social.= '<li><a href="'.$google.'"><i class="fa fa-google-plus"></i></a></li>'; }
                        $team_social .='</ul>';
                    }
                    
                    $team_html .= '<div class="team-item layout-'.$team_layout.'">';
                        if( $team_layout == 1 ){
                            $team_html .= sprintf(
                                '<figure>%s<div class="team-hover">%s</div></figure>%s %s %s',
                                $team_image,
                                $team_social,
                                $team_title,
                                $team_regency,
                                $team_content
                            );
                        }elseif( $team_layout == 2 ){
                            $team_html .= sprintf(
                                '<figure>%s<div class="team-hover">%s %s</div></figure>%s %s',
                                $team_image,
                                $team_content,
                                $team_social,
                                $team_title,
                                $team_regency
                            );
                        }
                    $team_html .= '</div><!-- .team-item -->';
                endwhile; wp_reset_postdata();
                
                remove_filter( 'excerpt_length', array($this, 'custom_excerpt_length'), 999 );

                $output .= str_replace('%carousel_html%', $team_html, $carousel_ouput);

                
                
            endif;
        $output .= '</div>';


    	return $output;
    }
    function custom_excerpt_length( $length ) {
    	return $this->excerpt_length;
    }
}

vc_map( array(
    "name" => __( "Team Carousel", THEME_LANG),
    "base" => "team_carousel",
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
			'type' => 'kt_switch',
			'heading' => __( 'Border in heading', THEME_LANG ),
			'param_name' => 'border_heading',
			'value' => 'true',
            "description" => __("Enable border in heading", THEME_LANG)
		),
        //Layout settings
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout Team', THEME_LANG ),
            'param_name' => 'team_layout',
            'value' => array(
                __( 'Layout 1', THEME_LANG ) => '1',
                __( 'Layout 2', THEME_LANG ) => '2',
            ),
            'description' => __( 'Select your layout.', THEME_LANG ),
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
                __('Specific Team', THEME_LANG) => 'posts',
            ),
            "admin_label" => true,
            'std' => 'all',
            "description" => __("Select content type for your posts.", THEME_LANG),
            'group' => __( 'Data settings', 'js_composer' ),
        ),
        array(
            "type" => "kt_taxonomy",
            'taxonomy' => 'team-category',
            'heading' => __( 'Categories', THEME_LANG ),
            'param_name' => 'categories',
            'placeholder' => __( 'Select your categories', THEME_LANG ),
            "dependency" => array("element" => "source","value" => array('categories')),
            'multiple' => true,
            'group' => __( 'Data settings', 'js_composer' ),
        ),
        array(
            "type" => "kt_posts",
            'args' => array('post_type' => 'kt_team', 'posts_per_page' => -1),
            'heading' => __( 'Specific Team', 'js_composer' ),
            'param_name' => 'posts',
            'size' => '5',
            'placeholder' => __( 'Select your posts', 'js_composer' ),
            "dependency" => array("element" => "source","value" => array('posts')),
            'multiple' => true,
            'group' => __( 'Data settings', 'js_composer' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Total items', 'js_composer' ),
            'param_name' => 'max_items',
            'value' => 10, // default value
            'param_holder_class' => 'vc_not-for-custom',
            'description' => __( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'js_composer' ),
            'group' => __( 'Data settings', 'js_composer' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Excerpt length', 'js_composer' ),
            'value' => 50,
            'param_name' => 'excerpt_length',
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
        // Carousel
        array(
            "type" => "kt_number",
            "heading" => __("Margin", THEME_LANG),
            "param_name" => "margin",
            "value" => "10",
            "suffix" => __("px", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG ),
            'description' => __( 'margin-right on item.', THEME_LANG ),
        ),

        array(
            'type' => 'kt_switch',
            'heading' => __( 'Loop', THEME_LANG ),
            'param_name' => 'loop',
            'value' => 'false',
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            "description" => __("Enable loop.", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Auto Height', THEME_LANG ),
            'param_name' => 'autoheight',
            'value' => 'true',
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            "description" => __("Enable auto height.", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Mouse Drag', THEME_LANG ),
            'param_name' => 'mousedrag',
            'value' => 'true',
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            "description" => __("Mouse drag enabled.", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'AutoPlay', THEME_LANG ),
            'param_name' => 'autoplay',
            'value' => 'false',
            "description" => __("Enable auto play.", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
            "type" => "kt_number",
            "heading" => __("AutoPlay Speed", THEME_LANG),
            "param_name" => "autoplayspeed",
            "value" => "5000",
            "suffix" => __("milliseconds", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG ),
            "dependency" => array("element" => "autoplay","value" => array('true')),
        ),
        array(
            "type" => "kt_number",
            "heading" => __("Slide Speed", THEME_LANG),
            "param_name" => "slidespeed",
            "value" => "200",
            "suffix" => __("milliseconds", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
            "type" => "kt_heading",
            "heading" => __("Items to Show?", THEME_LANG),
            "param_name" => "items_show",
            'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
            "type" => "kt_number",
            "class" => "",
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            "heading" => __("On Desktop", THEME_LANG),
            "param_name" => "desktop",
            "value" => "4",
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
            "heading" => __("On Mobile", THEME_LANG),
            "param_name" => "mobile",
            "value" => "1",
            "min" => "1",
            "max" => "25",
            "step" => "1",
            'group' => __( 'Carousel settings', THEME_LANG )
        ),array(
            "type" => "kt_heading",
            "heading" => __("Navigation settings", THEME_LANG),
            "param_name" => "navigation_settings",
            'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Navigation', THEME_LANG ),
            'param_name' => 'navigation',
            'value' => 'true',
            "description" => __("Show navigation in carousel", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Navigation position', THEME_LANG ),
            'param_name' => 'navigation_position',
            'group' => __( 'Carousel settings', THEME_LANG ),
            'value' => array(
                __( 'Center outside', THEME_LANG) => 'center_outside',
                __( 'Center inside', THEME_LANG) => 'center',
                __( 'Top Right', THEME_LANG) => 'top_right',
                __( 'Bottom', THEME_LANG) => 'bottom',
            ),
            "dependency" => array("element" => "navigation","value" => array('true')),
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Always Show Navigation', THEME_LANG ),
            'param_name' => 'navigation_always_on',
            'value' => 'false',
            "description" => __("Always show the navigation.", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG ),
            "dependency" => array("element" => "navigation_position","value" => array('center', 'center_outside', 'top_right')),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Navigation style', 'js_composer' ),
            'param_name' => 'navigation_style',
            'group' => __( 'Carousel settings', THEME_LANG ),
            'value' => array(
                __( 'Normal', THEME_LANG ) => '',
                __( 'Circle Background', THEME_LANG ) => 'circle',
                __( 'Square Background', THEME_LANG ) => 'square',
                __( 'Round Background', THEME_LANG ) => 'round',
                __( 'Circle Border', THEME_LANG ) => 'circle_border',
                __( 'Square Border', THEME_LANG ) => 'square_border',
                __( 'Round Border', THEME_LANG ) => 'round_border',
            ),
            'std' => 'circle_border',
            "dependency" => array("element" => "navigation","value" => array('true')),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Navigation Background', THEME_LANG ),
            'param_name' => 'navigation_background',
            'description' => __( 'Select background for navigation.', THEME_LANG ),
            'group' => __( 'Carousel settings', THEME_LANG ),
            "dependency" => array("element" => "navigation_style","value" => array('circle', 'square', 'round')),
        ),
        array(
            'type' => 'kt_number',
            'heading' => __( 'Border width', THEME_LANG ),
            'param_name' => 'navigation_border_width',
            "value" => "1",
            "min" => "1",
            "max" => "10",
            "suffix" => __("px", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG ),
            "dependency" => array("element" => "navigation_style","value" => array('circle_border', 'square_border', 'round_border')),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Border color', THEME_LANG ),
            'param_name' => 'navigation_border_color',
            'group' => __( 'Carousel settings', THEME_LANG ),
            "dependency" => array("element" => "navigation_style","value" => array('circle_border', 'square_border', 'round_border')),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Navigation color', THEME_LANG ),
            'param_name' => 'navigation_color',
            'description' => __( 'Select color for navigation.', 'js_composer' ),
            'group' => __( 'Carousel settings', THEME_LANG ),
            "dependency" => array("element" => "navigation","value" => array('true')),
        ),
        array(
            'type' => 'kt_radio',
            'heading' => __( 'Navigation Icon', 'js_composer' ),
            'param_name' => 'navigation_icon',
            'class_input' => "radio-wrapper-group",
            'value' => array(
                '<span><i class="fa fa-angle-left"></i><i class="fa fa-angle-right"></i></span>' => 'fa fa-angle-left|fa fa-angle-right',
                '<span><i class="fa fa-chevron-left"></i><i class="fa fa-chevron-right"></i></span>' => 'fa fa-chevron-left|fa fa-chevron-right',
                '<span><i class="fa fa-angle-double-left"></i><i class="fa fa-angle-double-right"></i></span>' => 'fa fa-angle-double-left|fa fa-angle-double-right',
                '<span><i class="fa fa-arrow-left"></i><i class="fa fa-arrow-right"></i></span>' => 'fa fa-arrow-left|fa fa-arrow-right',
                '<span><i class="fa fa-chevron-circle-left"></i><i class="fa fa-chevron-circle-right"></i></span>' =>'fa fa-chevron-circle-left|fa fa-chevron-circle-right',
                '<span><i class="fa fa-arrow-circle-o-left"></i><i class="fa fa-arrow-circle-o-right"></i></span>' => 'fa fa-arrow-circle-o-left|fa fa-arrow-circle-o-right',
            ),
            'description' => __( 'Select your style for navigation.', THEME_LANG ),
            "dependency" => array("element" => "navigation","value" => array('true')),
            'group' => __( 'Carousel settings', THEME_LANG )
        ),

        array(
            "type" => "kt_heading",
            "heading" => __("Pagination settings", THEME_LANG),
            "param_name" => "pagination_settings",
            'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Pagination', THEME_LANG ),
            'param_name' => 'pagination',
            'value' => 'true',
            "description" => __("Show pagination in carousel", THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Pagination color', 'js_composer' ),
            'param_name' => 'pagination_color',
            'description' => __( 'Select color for pagination.', 'js_composer' ),
            'group' => __( 'Carousel settings', THEME_LANG ),
            "dependency" => array("element" => "pagination","value" => array('true')),
        ),
        array(
            'type' => 'kt_radio',
            'heading' => __( 'Pagination Icon', 'js_composer' ),
            'param_name' => 'pagination_icon',
            'class_input' => "radio-wrapper",
            'value' => array(
                '<i class="fa fa-circle-o"></i>' => 'circle-o',
                '<i class="fa fa-circle"></i>' => 'circle',
                '<i class="fa fa-circle-thin"></i>' => 'circle-thin',
                '<i class="fa fa-dot-circle-o"></i>' => 'dot-circle-o',
                '<i class="fa fa-square-o"></i>' => 'square-o',
                '<i class="fa fa-square"></i>' => 'square',
                '<i class="fa fa-stop"></i>' => 'stop',
            ),
            'description' => __( 'Select your style for pagination.', THEME_LANG ),
            "dependency" => array("element" => "pagination","value" => array('true')),
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


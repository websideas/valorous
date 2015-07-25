<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class WPBakeryShortCode_Elastic_Posts extends WPBakeryShortCode {

    protected function content($atts, $content = null)
    {
        $atts = shortcode_atts(array(

            'category' => '',
            'orderby' => 'date',
            'meta_key' => '',
            'order' => 'DESC',
            'columns' => 3,

            'css' => '',
            'css_animation' => '',
            'el_class' => '',

        ), $atts);

        extract($atts);


        $output = $slider_large = $slider_thumbs = '';
        if ($category) {
            $args = array(
                'order' => $order,
                'orderby' => $orderby,
                'posts_per_page' => $columns,
                'ignore_sticky_posts' => true,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'kt_elastic_post',
                        'field'    => 'id',
                        'terms'    => $category,
                    ),
                ),
            );

            if($orderby == 'meta_value' || $orderby == 'meta_value_num'){
                $args['meta_key'] = $meta_key;
            }


            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {

                $atts_carousel = array(
                    'margin' => 0,
                    'desktop' => 1,
                    'loop' => 'true',
                    'tablet' => 1,
                    'mobile' => 1,
                    'pagination' => 'false',
                    'navigation_position' => 'center',
                    'navigation_always_on' => 'true'
                );
                $carousel_ouput = kt_render_carousel(apply_filters( 'kt_render_args', $atts_carousel));
                $blog_carousel_html = '';

                while ( $query->have_posts() ) : $query->the_post();

                    $blog_carousel_html .= '<div class="featured-carousel-item">';
                    ob_start();
                    get_template_part( 'templates/blog/featured/content' );
                    $blog_carousel_html .= ob_get_contents();
                    ob_end_clean();

                    $blog_carousel_html .= '</div><!-- .featured-carousel-item -->';

                endwhile;

                $output .= str_replace('%carousel_html%', $blog_carousel_html, $carousel_ouput);

            }

            $output .= ob_get_clean();

        }

        $elementClass = array(
            'base' => apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'elastic-posts-wrapper ', $this->settings['base'], $atts),
            'extra' => $this->getExtraClass($el_class),
            'css_animation' => $this->getCSSAnimation($css_animation),
            'shortcode_custom' => vc_shortcode_custom_css_class($css, ' ')
        );
        $elementClass = preg_replace(array('/\s+/', '/^\s|\s$/'), array(' ', ''), implode(' ', $elementClass));


        return '<div class="' . esc_attr($elementClass) . '">' . $output . '</div>';
    }
}

// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Elastic slider Posts", THEME_LANG),
    "base" => "elastic_posts",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Display Elastic slider posts", THEME_LANG),
    "params" => array(
        // Data settings
        array(
            "type" => "kt_taxonomy",
            'taxonomy' => 'kt_elastic_post',
            'heading' => __( 'Category', THEME_LANG ),
            'param_name' => 'category',
            'placeholder' => __( 'Select your category', THEME_LANG ),
            'multiple' => false,
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Columns', THEME_LANG ),
            'param_name' => 'columns',
            'value' => array(
                __( '2 columns', 'js_composer' ) => '2',
                __( '3 columns', 'js_composer' ) => '3',
                __( '4 columns', 'js_composer' ) => '4',
            ),
            'std' => '3',
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
            'param_holder_class' => 'vc_grid-data-type-not-ids',
            "admin_label" => true,
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Meta key', 'js_composer' ),
            'param_name' => 'meta_key',
            'description' => __( 'Input meta key for grid ordering.', 'js_composer' ),
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
            'value' => array(
                __( 'Descending', 'js_composer' ) => 'DESC',
                __( 'Ascending', 'js_composer' ) => 'ASC',
            ),
            'param_holder_class' => 'vc_grid-data-type-not-ids',
            'description' => __( 'Select sorting order.', 'js_composer' ),
            "admin_label" => true,
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



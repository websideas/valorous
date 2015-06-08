<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class WPBakeryShortCode_Recentposts extends WPBakeryShortCode {
    var $excerpt_length;

    function custom_excerpt_length( ) {
        return $this->excerpt_length;
    }

    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => '',
            'image_size' => '',
            'show_thumb' => 'true',
            'readmore' => 'true',
            'blog_type' => 'classic',
            'blog_layout' => 1,
            'blog_columns' => 3,
            'blog_columns_tablet' => 2,

            'source' => 'all',
            'categories' => '',
            'posts' => '',
            'authors' => '',
            'orderby' => 'date',
            'meta_key' => '',
            'order' => 'DESC',
            'max_items' => 10,
            "excerpt_length" => 50,

            "show_author" => 'true',
            "show_category" => 'true',
            'show_comment' => 'true',
            "show_date" => 'true',
            "date_format" => 'd F Y',

            'css' => '',
            'css_animation' => '',
            'el_class' => '',

        ), $atts );
        extract($atts);

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'blog-posts-wrapper ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );

        global $wp_query, $paged;


        $output = '';

        $this->excerpt_length = $excerpt_length;

        $args = array(
            'order' => $order,
            'orderby' => $orderby,
            'posts_per_page' => $max_items,
            'ignore_sticky_posts' => true,
            'paged' => $paged
        );

        if($orderby == 'meta_value' || $orderby == 'meta_value_num'){
            $args['meta_key'] = $meta_key;
        }
        if($source == 'categories'){
            if($categories){
                $categories_arr = array_filter(explode( ',', $categories));
                if(count($categories_arr)){
                    $args['category__in'] = $categories;
                }
            }
        }elseif($source == 'posts'){
            if($posts){
                $posts_arr = array_filter(explode( ',', $posts));
                if(count($posts_arr)){
                    $args['post__in'] = $posts_arr;
                }
            }
        }elseif($source == 'authors'){
            if($authors){
                $authors_arr = array_filter(explode( ',', $authors));
                if(count($authors_arr)){
                    $args['author__in'] = $authors_arr;
                }
            }
        }





        ob_start();
        $wp_query = new WP_Query( $args );
        if ( $wp_query->have_posts() ) :
            echo "<div class='blog-posts blog-posts-".$blog_type."'>";
            do_action('before_blog_posts_loop');

            global $blog_atts;
            $blog_atts = array(
                'image_size' => $image_size,
                'readmore' => apply_filters('sanitize_boolean', $readmore),
                "show_author" => apply_filters('sanitize_boolean', $show_author),
                "show_thumb" => apply_filters('sanitize_boolean', $show_thumb),
                "show_category" => apply_filters('sanitize_boolean', $show_category),
                "show_comment" => apply_filters('sanitize_boolean', $show_comment),
                "show_date" => apply_filters('sanitize_boolean', $show_date),
                'blog_layout' => $blog_layout,
                "date_format" => $date_format
            );

            add_filter( 'excerpt_length', array($this, 'custom_excerpt_length'), 999 );

            echo "<div class='blog-posts-content clearfix'>";

            if($blog_type == 'grid' || $blog_type == 'masonry'){
                $elementClass[] = 'blog-posts-columns-'.$blog_columns;
                $elementClass[] = 'blog-posts-layout-'.$blog_layout;
                echo "<div class='row'>";

                $bootstrapColumn = round( 12 / $blog_columns );
                $bootstrapTabletColumn = round( 12 / $blog_columns_tablet );
                $classes = 'col-xs-12 col-sm-'.$bootstrapTabletColumn.' col-md-' . $bootstrapColumn;
            }
            $i = 1;
            while ( $wp_query->have_posts() ) : $wp_query->the_post();
                if($blog_type == 'grid' || $blog_type == 'masonry'){
                    $classes_extra = '';
                    if($blog_type == 'grid'){
                        if (  ( $i - 1 ) % $blog_columns == 0 || 1 == $blog_columns )
                            $classes_extra .= ' col-clearfix-md col-clearfix-lg';

                        if ( ( $i - 1 ) % $blog_columns_tablet == 0 || 1 == $blog_columns )
                            $classes_extra .= ' col-clearfix-sm';
                    }
                    echo "<div class='article-post-item ".$classes." ".$classes_extra."'>";
                }
                get_template_part( 'templates/blog/recentpost/content', get_post_format() );
                if($blog_type == 'grid' || $blog_type == 'masonry'){
                    echo "</div><!-- .article-post-item -->";
                }
                $i++;
            endwhile;

            if($blog_type == 'grid' || $blog_type == 'masonry'){
                echo "</div><!-- .row -->";
            }


            echo "</div>";
            remove_filter( 'excerpt_length', array($this, 'custom_excerpt_length'), 999 );
            wp_reset_postdata();

            echo "</div>";

        endif;

        do_action('after_blog_posts_loop');

        $output .= ob_get_clean();


        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        return '<div class="'.esc_attr( $elementClass ).'">'.$output.'</div>';
    }
}

// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Recent Posts", THEME_LANG),
    "base" => "recentposts",
    "category" => __('by Theme', THEME_LANG ),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "admin_label" => true,
        ),

        array(
            "type" => "kt_heading",
            "heading" => __("Layout setting", THEME_LANG),
            "param_name" => "layout_settings",
        ),
        // Layout setting
        array(
            'type' => 'dropdown',
            'heading' => __( 'Type', 'js_composer' ),
            'param_name' => 'blog_type',
            'value' => array(
                __( 'Classic', 'js_composer' ) => 'classic',
                __( 'Grid', 'js_composer' ) => 'grid',
                __( 'Masonry', 'js_composer' ) => 'masonry',
                //__( 'Timeline', 'js_composer' ) => 'timeline',
            ),
            'description' => '',
        ),
        array(
            "type" => "kt_heading",
            "heading" => __("Columns to Show?", THEME_LANG),
            "edit_field_class" => "kt_sub_heading  vc_column",
            "param_name" => "items_show",
            'dependency' => array(
                'element' => 'blog_type',
                'value' => array( 'grid', 'masonry' )
            ),
        ),


        array(
            'type' => 'dropdown',
            'heading' => __( 'on Desktop', THEME_LANG ),
            'param_name' => 'blog_columns',
            'value' => array(
                __( '1 column', 'js_composer' ) => '1',
                __( '2 columns', 'js_composer' ) => '2',
                __( '3 columns', 'js_composer' ) => '3',
                __( '4 columns', 'js_composer' ) => '4',
                __( '6 columns', 'js_composer' ) => '6',
            ),
            'std' => '3',
            "edit_field_class" => "vc_col-sm-6 vc_column",
            'dependency' => array(
                'element' => 'blog_type',
                'value' => array( 'grid', 'masonry' )
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'on Tablet', THEME_LANG ),
            'param_name' => 'blog_columns_tablet',
            'value' => array(
                __( '1 column', 'js_composer' ) => '1',
                __( '2 columns', 'js_composer' ) => '2',
                __( '3 columns', 'js_composer' ) => '3',
                __( '4 columns', 'js_composer' ) => '4',
                __( '6 columns', 'js_composer' ) => '6',
            ),
            'std' => '2',
            "edit_field_class" => "vc_col-sm-6 vc_column",
            'dependency' => array(
                'element' => 'blog_type',
                'value' => array( 'grid', 'masonry' )
            ),
        ),





        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout', THEME_LANG ),
            'param_name' => 'blog_layout',
            'value' => array(
                __( 'Layout 1', 'js_composer' ) => '1',
                __( 'Layout 2', 'js_composer' ) => '2',
                __( 'Layout 3', 'js_composer' ) => '3',
            ),
            'description' => __( 'Select columns.', THEME_LANG ),
            "dependency" => array("element" => "type","value" => array('grid', 'masonry')),
        ),

        array(
            "type" => "kt_heading",
            "heading" => __("Extra setting", THEME_LANG),
            "param_name" => "extra_settings",
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Show thumbail image', THEME_LANG ),
            'param_name' => 'show_thumb',
            'value' => 'true',
            "description" => __("Show or hide the thumbnail image.", THEME_LANG),
        ),
        array(
            "type" => "kt_image_sizes",
            "heading" => __( "Select image sizes", THEME_LANG ),
            "param_name" => "image_size",
            'dependency' => array(
                'element' => 'show_thumb',
                'value' => array( 'true' )
            ),
        ),
        /*
        array(
            "type" => "textfield",
            "heading" => __( "Image size custom", THEME_LANG ),
            "param_name" => "img_size_custom",
            'description' => __('Default: 300x200 (Width x Height)', THEME_LANG),
            "dependency" => array("element" => "image_size","value" => array('custom')),
        ),
        */
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Show read more button', THEME_LANG ),
            'param_name' => 'readmore',
            'value' => 'true',
            "description" => __("Show or hide the read more.", THEME_LANG),
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
                __('Specific Posts', THEME_LANG) => 'posts',
                __('Specific Authors', THEME_LANG) => 'authors'
            ),
            "admin_label" => true,
            'std' => 'all',
            "description" => __("Select content type for your posts.", THEME_LANG),
            'group' => __( 'Data settings', 'js_composer' ),
        ),
        array(
            "type" => "kt_taxonomy",
            'taxonomy' => 'category',
            'heading' => __( 'Categories', THEME_LANG ),
            'param_name' => 'categories',
            'placeholder' => __( 'Select your categories', THEME_LANG ),
            "dependency" => array("element" => "source","value" => array('categories')),
            'multiple' => true,
            'group' => __( 'Data settings', 'js_composer' ),
        ),
        array(
            "type" => "kt_posts",
            'args' => array('post_type' => 'post', 'posts_per_page' => -1),
            'heading' => __( 'Specific Posts', 'js_composer' ),
            'param_name' => 'posts',
            'size' => '5',
            'placeholder' => __( 'Select your posts', 'js_composer' ),
            "dependency" => array("element" => "source","value" => array('posts')),
            'multiple' => true,
            'group' => __( 'Data settings', 'js_composer' ),
        ),
        array(
            "type" => "kt_authors",
            'post_type' => 'post',
            'heading' => __( 'Specific Authors', 'js_composer' ),
            'param_name' => 'authors',
            'size' => '5',
            'placeholder' => __( 'Select your authors', 'js_composer' ),
            "dependency" => array("element" => "source","value" => array('authors')),
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








        // Meta setting
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Show Author', THEME_LANG ),
            'param_name' => 'show_author',
            'value' => 'true',
            "description" => __("Show or hide the post author.", THEME_LANG),
            'group' => __( 'Meta', 'js_composer' ),
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Show Category', THEME_LANG ),
            'param_name' => 'show_category',
            'value' => 'true',
            "description" => __("Show or hide the post category.", THEME_LANG),
            'group' => __( 'Meta', 'js_composer' ),
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Show Comment', THEME_LANG ),
            'param_name' => 'show_comment',
            'value' => 'true',
            "description" => __("Show or hide the post comment.", THEME_LANG),
            'group' => __( 'Meta', 'js_composer' ),
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Show Date', THEME_LANG ),
            'param_name' => 'show_date',
            'value' => 'true',
            "description" => __("Show or hide the post date.", THEME_LANG),
            'group' => __( 'Meta', 'js_composer' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Date format', 'js_composer' ),
            'param_name' => 'date_format',
            'value' => array(
                __( '05 December 2014', 'js_composer' ) => 'd F Y',
                __( 'December 13th 2014', 'js_composer' ) => 'F jS Y',
                __( '13th December 2014', 'js_composer' ) => 'jS F Y',
                __( '05 Dec 2014', 'js_composer' ) => 'd M Y',
                __( 'Dec 05 2014', 'js_composer' ) => 'M d Y',
                __( 'Time ago', 'js_composer' ) => 'time',
            ),
            'description' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'js_composer' ),
            'group' => __( 'Meta', 'js_composer' ),
            'dependency' => array(
                'element' => 'show_date',
                'value' => array( 'true'),
            ),
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



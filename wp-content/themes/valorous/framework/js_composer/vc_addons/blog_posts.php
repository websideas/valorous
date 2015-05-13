<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class WPBakeryShortCode_List_Blog_Posts extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => '',
            'category' => '',
            'per_page' => 10,
            'orderby' => '',
            'heading' => 'h2',
            'order' => '',
            'pagination' => '',
            'excerpt_length' =>  50,
            'css' => '',
            'el_class' => '',
        ), $atts );
        extract($atts);
        
        $output = '';

        $excerpt_length =  intval( $excerpt_length );

        $exl_function = create_function('$n', 'return '.$excerpt_length.';');
        add_filter( 'excerpt_length', $exl_function , 999 );

        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'list-blog-posts ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );


        $output .= '<div class="'.esc_attr( $elementClass ).'">';
        
            if($title){
                if( $heading == '' ){
                    $heading = 'h2';
                }
                $heading_class = "block-heading";
                $output .= '<'.$heading.' class="'.$heading_class.'">'.$title.'</'.$heading.'>';

            }

            global $wp_query, $post, $paged;

            $category = ($category) ? explode(',', $category ) : false;
        		$args = array(
        			'posts_per_page'	=> $atts['per_page'],
        			'orderby' 			=> $atts['orderby'],
        			'order' 			=> $atts['order'],
        			'post_status' 		=> 'publish',
        			'post_type' 		=> 'post',
                    'posts_per_page'    => $per_page,
                    'paged' => $paged
        		);
                if( !empty( $category ) ){
                    $args['tax_query'] = array( array( 'taxonomy' => 'product_cat', 'field' => 'id', 'terms' => $category, 'operator' => 'IN' ) );
                }
                
                ob_start();

                $wp_query = new WP_Query( $args  );

                $posts = $wp_query->get_posts();

                $n  =  count( $posts );

                ?>
                <div class='blog-posts'>
                    <?php
                        do_action('before_blog_posts_loop');
                        if ( $n ) :
                            foreach ( $posts as $i => $post ) :
                                setup_postdata(  $post );
                                get_template_part( 'templates/loop' );
        
                            endforeach; // end of the loop.
                		endif;
        
                    ?>
                </div><!-- .blog-posts -->
            <?php
            // Previous/next page navigation.

            echo get_the_posts_pagination( array(
                'prev_text'          => __( 'Previous', THEME_LANG ),
                'next_text'          => __( 'Next', THEME_LANG ),
                'before_page_number' => '',
            ) );


            $output .= ob_get_clean();

            do_action('after_blog_posts_loop');
            $wp_query->reset_postdata();
        $output .= "</div>";

       remove_filter('excerpt_length', $exl_function, 999 );
        
        return $output;
    }
}

// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Blog Posts", THEME_LANG),
    "base" => "list_blog_posts",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Display blog posts", THEME_LANG),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "admin_label" => true,
            'description' => __( 'Leave empty to hide.', 'js_composer' )
        ),

        array(
            'type' => 'dropdown',
            'heading' => __( 'Heading tag', 'js_composer' ),
            'param_name' => 'heading',
            'value' => array(
                __( 'Default', 'js_composer' ) => '',
                'h1' => 'h1',
                'h2' => 'h2',
                'h3' => 'h3',
                'h4' => 'h4',
                'h5' => 'h5',
                'h5' => 'h6',

            ),
            'description' => 'Select element tag.'
        ),

        array(
            "type" => "kt_taxonomy",
            'taxonomy' => 'category',
			'heading' => __( 'Category', 'js_composer' ),
			'param_name' => 'category',
            'multiple' => true,
            "placeholder" => 'Please select your category',
            "description" => __("Note: By default, all your catrgory will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'js_composer')
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
			'heading' => __( 'Excerpt length', 'js_composer' ),
			'value' => 50,
			'param_name' => 'excerpt_length',
		),
        array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'js_composer' ),
			'param_name' => 'orderby',
			'value' => array(
                '',
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
                    '',
    			__( 'Descending', 'js_composer' ) => 'DESC',
    			__( 'Ascending', 'js_composer' ) => 'ASC',
            ),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),


        array(
            'type' => 'checkbox',
            'heading' => __( 'Pagination', THEME_LANG ),
            'param_name' => 'pagination',
            'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
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



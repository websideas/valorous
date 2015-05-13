<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * @see wp-content/plugins/js_composer/include/params/vc_grid_item/shortcodes.php
*/
// $this->shortcodes = apply_filters( 'vc_grid_item_shortcodes', $this->shortcodes );

function kt_gird_items(  $shortcodes ){


    $post_data_params = array(
        array(
            'type' => 'checkbox',
            'heading' => __( 'Meta Type', 'js_composer' ),
            'param_name' => 'meta_type',
            'value' => array(
                __( 'Author', 'js_composer' ) => 'author',
                __( 'Date', 'js_composer' ) => 'date',
                __( 'Category', 'js_composer' ) => 'category',
                __( 'Tag', 'js_composer' ) => 'tag',
                __( 'Comment count', 'js_composer' ) => 'comment_count',
            ),
            'description' => __( 'Check to display post meta data.', 'js_composer' ),
            'default' =>'author,date,category,comment_count'
        ),

        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => __( 'Design options', 'js_composer' )
        ),
    );


    $shortcodes['vc_gitem_post_metadata'] =  array(
        'name' => __( 'Post Meta Data', 'js_composer' ),
        'base' => 'vc_gitem_post_metadata',
        'icon' => '',
        'category' => __( 'Post', 'js_composer' ),
        'description' => __( ' Meta data for post', 'js_composer' ),
        'params' => array_merge( $post_data_params, array(
            array(
                'type' => 'textfield',
                'heading' => __( 'Extra class name', 'js_composer' ),
                'param_name' => 'el_class',
                'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            ),
        ) ),
    );

    return $shortcodes;
}

add_filter('vc_grid_item_shortcodes', 'kt_gird_items');




class WPBakeryShortCode_VC_Gitem_Post_Metadata extends WPBakeryShortCode {
    public function __construct( $settings ) {
        parent::__construct( $settings );
    }
}



/**
 * Get post excerpt. Used as wrapper for others post data attributes.
 *
 * @param $data
 *
 * @return mixed|string
 */
function vc_gitem_template_attribute_post_metadata( $value, $data ) {
    /**
     * @var null|Wp_Post $post ;
     * @var string $data ;
     */
    extract( array_merge( array(
        'post' => null,
        'data' => ''
    ), $data ) );

    ob_start();

    // var_dump( $data );
    $meta_type = array_filter(  explode(',', $data) );
    if( empty( $meta_type )){
        return ;
    }

    if( in_array('author', $meta_type ) ){
         printf( '<span class="author vcard">'.__('Posed by:', THEME_LANG ).' <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'THEME_LANG' ), get_the_author() ) ),
            get_the_author()
        );
    }
    if(  in_array( 'date', $meta_type ) ){
    ?>
    <span class="date-time"><i class="fa fa-calendar-o"></i> <?php echo get_the_time( get_option( 'date_format' ) , $post ); ?></span>
    <?php
    }

    if( in_array('category',  $meta_type) ){
    ?>
    <span class="cat"><i class="fa fa-folder-o"></i> <?php the_category(', ' ,'', $post->ID ); ?></span>
    <?php
    }

    if( in_array('comment_count',  $meta_type) ){
    ?>
    <span class="comment-count">
        <i class="fa fa-comments"></i> <?php comments_number( __('Comments: 0', THEME_LANG ),__('Comment: 1', THEME_LANG),__('Comments: %', THEME_LANG) ); ?>
    </span>
    <?php
    }

    return ob_get_clean();
}
add_filter( 'vc_gitem_template_attribute_post_metadata', 'vc_gitem_template_attribute_post_metadata', 10, 2 );

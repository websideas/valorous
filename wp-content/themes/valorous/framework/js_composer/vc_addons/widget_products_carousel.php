<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Widget Products Carousel", THEME_LANG ),
    "base" => "widget_products_carousel",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Widget Products Carousel", THEME_LANG ),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", "js_composer" ),
            "param_name" => "title",
            "admin_label" => true,
            'value' => __( 'Title', 'js_composer' )
        ),
        array(
            "type" => "textfield",
            "heading" => __("Sub title", THEME_LANG),
            "param_name" => "sub_title"
        ),
        array(
            "type" => "kt_taxonomy",
            "taxonomy" => "product_cat",
            "class" => "",
            "heading" => __("Category", THEME_LANG),
            "param_name" => "taxonomy",
            "value" => '',
            'multiple' => true,
            "description" => __("Note: By default, all your catrgory will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed. if nothing selected will show all of categories.", THEME_LANG)
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Show",THEME_LANG),
        	"param_name" => "show",
        	"value" => array(
                __( 'Latest Products', THEME_LANG ) => '',
				__( 'Featured Products', THEME_LANG ) => 'featured',
				__( 'On-sale Products', THEME_LANG ) => 'onsale',
        	),
            'std' => '',
        	"description" => __("",THEME_LANG),
        ),
        array(
            "type" => "textfield",
            "heading" => __("Number Product", THEME_LANG),
            "param_name" => "number",
            "value" => 12,
            "description" => __("Enter number of Product", THEME_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Product per columns", THEME_LANG),
            "param_name" => "product_column",
            "value" => 3,
            "description" => __("Enter number product on columns", THEME_LANG)
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Order by",THEME_LANG),
        	"param_name" => "orderby",
        	"value" => array(
        		__('None', THEME_LANG) => 'none',
                __('ID', THEME_LANG) => 'ID',
                __('Author', THEME_LANG) => 'author',
                __('Name', THEME_LANG) => 'name',
                __('Date', THEME_LANG) => 'date',
                __('Modified', THEME_LANG) => 'modified',
                __('Rand', THEME_LANG) => 'rand'
        	),
            'std' => 'date',
        	"description" => __("Select how to sort retrieved posts.",THEME_LANG),
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Order way",THEME_LANG),
        	"param_name" => "order",
        	"value" => array(
                __('ASC', THEME_LANG) => 'ASC',
                __('DESC', THEME_LANG) => 'DESC'
        	),
            'std' => 'DESC',
        	"description" => __("Designates the ascending or descending order.",THEME_LANG),
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
			"type" => "kt_number",
			"heading" => __("Slide Speed", THEME_LANG),
			"param_name" => "slidespeed",
			"value" => "200",
            "suffix" => __("milliseconds", THEME_LANG),
			"description" => __('Slide speed in milliseconds', THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
	  	),
        array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
    ),
));



class WPBakeryShortCode_Widget_Products_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'sub_title' => '',
            'taxonomy' => '',
            'show' => '',
            'number' => 12,
            'product_column' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'autoplay' => '', 
            'navigation' => '',
            'slidespeed' => 200,
            'css' => '',
            'el_class' => '',
        ), $atts ) );
        
        global $woocommerce, $woocommerce_loop;
        
        $args = array(
			'posts_per_page'	=> $number,
            'post_type'         => 'product',
            'orderby'           => $orderby,
            'order'             => $order
		);
        
        if($taxonomy){
            $args['tax_query'] = array(
                            		array(
                            			'taxonomy' => 'product_cat',
                            			'field' => 'id',
                            			'terms' => explode(",",$taxonomy)
                            		)
                            	);
        }
        
        switch ( $show ) {
			case 'featured' :
				$args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
				break;
			case 'onsale' :
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$args['post__in'] = $product_ids_on_sale;
				break;
		}
        
        $query = new WP_Query( $args );
        ob_start();
        
        if ( $query->have_posts() ) : ?>
        
            <?php
                $data_carousel = array(
                    "autoplay" => $autoplay,
                    "navigation" => $navigation,
                    "slidespeed" => $slidespeed,
                    "theme" => 'style-navigation-bottom',
                    "autoheight" => 'false'
                );
                
                $elementClass = array(
                    'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
                );
                $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
            ?>
            
            <div class="widget-products-carousel-wrapper woocommerce <?php echo esc_attr($el_class); ?>">
                <?php if($title || $sub_title){ ?>
                    <div class="block-heading">
                        <?php if($title){ ?><h3><?php echo esc_html($title); ?></h3><?php } ?>
                        <?php if($sub_title){ ?><div class="sub_title"><?php echo esc_html($sub_title); ?></div><?php } ?>
                    </div>
                <?php } ?>
                
                <div class="kt_product_carousel kt-owl-carousel <?php echo esc_attr( $elementClass ); ?>" <?php echo render_data_carousel($data_carousel); ?>>
                    <?php $i=1; ?>
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <?php if($i == 1){ ?>
                            <ul class="kt_item product_list_widget">
                        <?php } ?>
                            <?php wc_get_template( 'content-widget-product.php', array( 'show_rating' => false ) ); ?>
                        <?php if( $i%$product_column == 0 && $i != $query->post_count ){ ?>
                            </ul><ul class="kt_featured_item product_list_widget">
                        <?php }elseif( $i == $query->post_count){ ?>
                            </ul>
                        <?php } ?>
                    <?php $i++; endwhile; ?>
                </div>
            </div>
        <?php endif; wp_reset_postdata();
        
        $output = ob_get_clean();
        
        return $output;
    }
}
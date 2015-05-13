<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Testimonials", THEME_LANG ),
    "base" => "carousel_testimonials",
    "category" => __('by Theme', THEME_LANG ),
    "description" => __( "Carousel Testimonials", THEME_LANG ),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", "js_composer" ),
            "param_name" => "title",
            "admin_label" => true,
            'value' => __( 'Testimonials', 'js_composer' )
        ),
        array(
            "type" => "textfield",
            "heading" => __("Sub title", THEME_LANG),
            "param_name" => "sub_title"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Number Product", THEME_LANG),
            "param_name" => "number",
            "value" => 4,
            "description" => __("Enter number of Product", THEME_LANG)
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



class WPBakeryShortCode_Carousel_Testimonials extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'sub_title' => '',
            'number' => 4,
            'orderby' => 'date',
            'order' => 'DESC',
            'autoplay' => '', 
            'navigation' => '',
            'slidespeed' => 200,
            'css' => '',
            'el_class' => '',
        ), $atts ) );
        
        $args = array(
            'post_type' => 'testimonial',
            'orderby' => $orderby,
            'order' => $order,
            'posts_per_page' => $number
        );
        $query = new WP_Query( $args );
        
        ob_start();
        
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
        
        if ( $query->have_posts() ){ ?>
            <div class="carousel-testimonials-wrapper">
                <?php if($title || $sub_title){ ?>
                    <div class="block-heading">
                        <?php if($title){ ?><h3><?php echo esc_html($title); ?></h3><?php } ?>
                        <?php if($sub_title){ ?><div class="sub_title"><?php echo esc_html($sub_title); ?></div><?php } ?>
                    </div>
                <?php } ?>
                <div class="carousel-testimonials-content <?php echo esc_attr( $elementClass ); ?>">
                    <div class="kt_testimonial kt-owl-carousel" <?php echo render_data_carousel($data_carousel); ?>>
                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                            <div class="testimonial-item<?php if(!has_post_thumbnail()){ echo ' no-image'; } ?>">
                                <?php if( has_post_thumbnail() ){ ?>
                                    <div class="avatar"><?php the_post_thumbnail('small'); ?></div>
                                <?php } ?>
                                <h3 class="name"><?php the_title(); ?> <span><?php echo rwmb_meta('_kt_testimonial_regency'); ?></span></h3>
                                <?php if( get_the_content() ){ ?>
                                    <div class="desc"><?php the_content(); ?></div>
                                <?php } ?>
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        <?php }
        
        $output = ob_get_clean();
        
        return $output;
    }
}
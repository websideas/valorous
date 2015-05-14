<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Add stylesheet and script for admin
 * 
 * @since       1.0
 * @return      void
 * @access      public
 */


add_action( 'admin_enqueue_scripts', 'kt_admin_enqueue_scripts' );
if ( !function_exists( 'kt_admin_enqueue_scripts' ) ) {
    function kt_admin_enqueue_scripts(){
        
        wp_register_style( 'kt-font-awesome', THEME_FONTS.'font-awesome/css/font-awesome.min.css');
        wp_register_style( 'elegant_font', THEME_FONTS.'elegant_font/style.css');
        wp_register_style( 'framework-core', FW_CSS.'framework-core.css');
        wp_register_style( 'chosen', FW_LIBS.'chosen/chosen.min.css');
        
        
        wp_register_style( 'admin-style', FW_CSS.'theme-admin.css',array( 'elegant_font', 'kt-font-awesome', 'framework-core','chosen'));
        wp_enqueue_style('admin-style');
        
        wp_enqueue_script( 'kt_image', FW_JS.'kt_image.js', array('jquery'), FW_VER, true);
        wp_enqueue_script( 'chosen', FW_LIBS.'chosen/chosen.jquery.min.js', array('jquery'), FW_VER, true);
        
        wp_localize_script( 'kt_image', 'kt_image_lange', array(
            'frameTitle' => __('Select your image', THEME_LANG )
        ));
        
        wp_register_script( 'framework-core', FW_JS.'framework-core.js', array('jquery', 'jquery-ui-tabs'), FW_VER, true);
        wp_enqueue_script('framework-core');
        
    } // End kt_admin_enqueue_scripts.
}


/**
 * Add stylesheet and script for frontend
 * 
 * @since       1.0
 * @return      void
 * @access      public
 */


add_action( 'wp_enqueue_scripts', 'wp_enqueue_scripts_frontend' );
if ( !function_exists( 'wp_enqueue_scripts_frontend' ) ) {
    function wp_enqueue_scripts_frontend(){
        
        

    } // End wp_enqueue_scripts_frontend.
}

/**
 * Custom admin logo
 * 
 * @since       1.0
 * @return      void
 * @access      public
 */
function kt_custom_login_logo() {
    /*
    $options = get_option('theme_options');
    if($options['admin_login']){
	   echo '<style type="text/css">h1 a { background-image:url('.$options['admin_login']['url'].') !important;background-size: auto auto !important;margin-bottom: 10px !important;width: auto!important;}</style>';
    }
    */
}
add_action('login_head', 'kt_custom_login_logo');


/**
 * Custom admin logo
 * 
 * @since       1.0
 * @return      void
 * @access      public
 */
function kt_setting_script() {
    
    $tracking_code = kt_option('advanced_tracking_code');
    echo $tracking_code;
    
    $advanced_css = kt_option('advanced_editor_css');
    $accent = kt_option('styling_accent', '');
    $accent_brighter = kt_colour_brightness($accent, 0.8);
    $accent_brighter_b = kt_colour_brightness($accent, 0.6);
    
    $accent_darker = kt_colour_brightness($accent, -0.8);

    $header_opacity = kt_option('header_layout_opacity', '0.8');
    $header_sticky_opacity = kt_option('header_sticky_opacity', '0.8');
    
    //echo "$accent $accent_brighter $accent_brighter_b";
    
    /**
     * 000000 => $accent
     * 333333 => $accent_brighter
     * 666666 => $accent_brighter_b
     */
     
    ?>
    <style id="kt-theme-custom-css" type="text/css">
        <?php echo $advanced_css; ?>
        <?php if( $accent !='' ){ ?>

        ::-moz-selection{ background:<?php echo $accent; ?>; color: #FFFFFF;}
        ::-webkit-selection{ background:<?php echo $accent; ?>; color: #FFFFFF;}
        ::selection{ background:<?php echo $accent; ?>; color: #FFFFFF;}

        .dropcap-rectangle,
        .button, 
        .btn-default,
        .header-layout1 .site-branding .site-logo.logo-circle,
        .tp-bullets.simplebullets.round .bullet.selected,
        .highlight.highlight1,
        .kt-owl-carousel .owl-buttons div:hover,
        .carousel-heading-top .owl-buttons div:hover,
        .single-product-quickview-images .owl-buttons div:hover,
        .designer-collection-wrapper .designer-collection-link span,
        .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
        .mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, 
        .mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
        .mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar,
        #calendar_wrap tbody td#today,
        .woocommerce .summary .single_add_to_cart_button:hover,
        ul.kt_social_icons.large li a:hover, 
        ul.kt_social_icons.large li a:focus
        #calendar_wrap tbody td#today,
        .header-layout1 .shopping_cart > a:hover,
        .widget_product_tag_cloud a:hover, 
        .widget_tag_cloud a:hover{
            background-color: <?php echo $accent; ?>;
        }
        .woocommerce ul.products.effect-bottom .product-image-container .product-quick-view{
            background-color: <?php echo kt_hex2rgba($accent, '0.6') ?>;
        }
        .woocommerce .compare-button .blockUI.blockOverlay,
        .woocommerce .compare-button .blockUI.blockOverlay:before{
            background-color: <?php echo $accent; ?>!important;
        }
        .button, 
        .btn-default,
        .header-layout1 #woocommerce-nav > ul > li > a:hover,
        .header-layout1 #main-nav > ul > li.current-menu-item > a, 
        .header-layout1 #main-nav > ul > li > a:hover, 
        .header-layout1 #main-nav > ul > li:hover > a,
        .header-content .searchform input[type="text"],
        .header-layout1 .shopping_cart > a,
        #woocommerce-nav-mobile-wrapper,
        #header-content-mobile a,
        .woocommerce a.remove:hover,
        blockquote, 
        .blockquote-reverse, 
        blockquote.pull-right{
            border-color: <?php echo $accent; ?>;
        }
        .tp-bullets .tp-rightarrow.round::after, 
        .tp-bullets .tp-leftarrow.round::after,
        #calendar_wrap thead th{
            color: <?php echo $accent; ?>;
        }
        
        ul.navigation-mobile > li:hover > a, 
        ul.navigation-mobile > li > a:hover,
        ul.navigation-mobile > li.current-menu-item > a, 
        ul.navigation-mobile > li.active-menu-item > a{
            border-left-color: <?php echo $accent; ?>;
        }
        .button:hover,
        .button:focus, 
        .btn-default.active, 
        .btn-default.focus, 
        .btn-default:active, 
        .btn-default:focus, 
        .btn-default:hover, 
        .open > .dropdown-toggle.btn-default,
        ul.kt_social_icons.large li a:hover, 
        ul.kt_social_icons.large li a:focus,
        #backtotop:hover,
        .sidebar .widget-container .widget-title,
        body .wpb_content_element .wpb_tabs_nav li.ui-tabs-active, 
        body .wpb_content_element .wpb_tabs_nav li:hover,
        #calendar_wrap caption,
        #calendar_wrap tbody td,
        .shopping_cart > a span.cart-content-total,
        .header-layout2 .header-content-bottom, 
        .header-layout3 .header-content-bottom,
        .blog-posts .post-item .entry-date-time,
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li.ui-tabs-active a, 
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li a:hover,
        .widget_product_tag_cloud a, 
        .widget_tag_cloud a,
        .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
        .kt_testimonial_wrap .module-title, 
        .kt_product_carousel_wrap .module-title,
        .carousel-testimonials-wrapper .block-heading, 
        .widget-products-carousel-wrapper .block-heading
        {
            background-color: <?php echo $accent_brighter; ?>;
        }
        
        .button:hover,
        .button:focus, 
        .btn-default.active, 
        .btn-default.focus, 
        .btn-default:active, 
        .btn-default:focus, 
        .btn-default:hover, 
        .open > .dropdown-toggle.btn-default,
        ul.kt_social_icons.large li a:hover, 
        ul.kt_social_icons.large li a:focus,
        body .wpb_content_element .wpb_tabs_nav li.ui-tabs-active, 
        body .wpb_content_element .wpb_tabs_nav li:hover,
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li.ui-tabs-active a, 
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li a:hover{
            border-color: <?php echo $accent_brighter; ?>;
        }
        
        .shopping_cart > a span.cart-content-total:before{
            border-right-color: <?php echo $accent_brighter; ?>;
        }

        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li.ui-tabs-active a:after,
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li a:hover:after{
            border-top-color: <?php echo $accent_brighter; ?>;
        }
        
        .woocommerce .widget_price_filter .ui-slider .ui-slider-handle::before{
            color: <?php echo $accent_brighter; ?>;
        }

        .woocommerce span.onsale,
        .woocommerce ul.products .added_to_cart,
        #backtotop{
            background-color: <?php echo $accent_brighter_b; ?>;
        }

        .woocommerce ul.products .button,
        .woocommerce .functional-buttons,
        .woocommerce .summary .single_add_to_cart_button,
        table.compare-list .add-to-cart td a{
            background-color: <?php echo $accent_brighter; ?>;
        }
        .woocommerce ul.products .button:hover,
        .woocommerce .functional-buttons .yith-wcwl-wishlistaddedbrowse a:hover, 
        .woocommerce .functional-buttons .yith-wcwl-wishlistexistsbrowse a:hover, 
        .woocommerce .functional-buttons .yith-wcwl-add-button a.add_to_wishlist:hover, 
        .woocommerce .functional-buttons .product.compare-button a:hover, 
        .woocommerce .functional-buttons .product-quick-view:hover, 
        .woocommerce .functional-buttons .yith-wcwl-wishlistaddedbrowse a:focus, 
        .woocommerce .functional-buttons .yith-wcwl-wishlistexistsbrowse a:focus, 
        .woocommerce .functional-buttons .yith-wcwl-add-button a.add_to_wishlist:focus, 
        .woocommerce .functional-buttons .product.compare-button a:focus, 
        .woocommerce .functional-buttons .product-quick-view:focus,
        table.compare-list .add-to-cart td a:hover,
        .woocommerce ul.products.effect-bottom .product-item-tools-bottom .button:hover, 
        .woocommerce ul.products.effect-bottom .product-item-tools-bottom .yith-wcwl-add-to-wishlist:hover a, 
        .woocommerce ul.products.effect-bottom .product-item-tools-bottom .compare-button:hover a,
        .woocommerce ul.products.effect-bottom .product-item-tools-bottom .yith-wcwl-add-button .ajax-loading{
            background-color: <?php echo $accent; ?>;
        }

        #header.is-sticky{
            background-color: <?php echo kt_hex2rgba($accent, $header_sticky_opacity) ?>;
        }
        .header-layout1.header-container{
            background-color: <?php echo kt_hex2rgba($accent, $header_opacity) ?>;
        }

        <?php } ?>

    </style>
    
    <?php

}
add_action('wp_head', 'kt_setting_script');

/**
 * Add advanced js to footer
 * 
 */
function kt_setting_script_footer() {
    $advanced_js = kt_option('advanced_editor_js');
    if($advanced_js){
        echo sprintf('<script type="text/javascript">%s</script>', $advanced_js);
    }
}
add_action('wp_footer', 'kt_setting_script_footer', 100);

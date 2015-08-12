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
        wp_enqueue_script( 'cookie', FW_JS.'jquery.cookie.js', array('jquery'), FW_VER, true);

        wp_localize_script( 'kt_image', 'kt_image_lange', array(
            'frameTitle' => __('Select your image', THEME_LANG )
        ));

        wp_register_script( 'framework-core', FW_JS.'framework-core.js', array('jquery', 'jquery-ui-tabs'), FW_VER, true);
        wp_enqueue_script('framework-core');
        wp_enqueue_media();
        
    } // End kt_admin_enqueue_scripts.
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
    
    //$tracking_code = kt_option('advanced_tracking_code');
    //echo $tracking_code;
    
    $advanced_css = kt_option('advanced_editor_css');
    $accent = kt_option('styling_accent', '');



    ?>
    <style id="kt-theme-custom-css" type="text/css">

        <?php echo $advanced_css; ?>

        <?php if( $accent !='' ){ ?>

            ::-moz-selection{ background:<?php echo $accent; ?>;}
            ::-webkit-selection{ background:<?php echo $accent; ?>;}
            ::selection{ background:<?php echo $accent; ?>;}

            #header-content-mobile .mobile-cart-total,
            #nav > #main-nav-tool > li > a .mini-cart-total,
            .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
            .featured-vertical-item .entry-main-content .cat-links a,
            .featured-carousel-item .entry-main-content .cat-links a,
            .widget_kt_instagram ul li a:after,
            body .mejs-controls .mejs-time-rail .mejs-time-current,
            body .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current,

            .woocommerce .product .yith-wcwl-add-to-wishlist .ajax-loading,
            .woocommerce ul.shop-products .added_to_cart,
            .woocommerce ul.shop-products .button,
            .woocommerce ul.shop-products .product-quick-view,
            .woocommerce.compare-button,
            .woocommerce .product .yith-wcwl-add-button,
            .woocommerce .product .yith-wcwl-wishlistaddedbrowse,
            .woocommerce .product .yith-wcwl-wishlistexistsbrowse,

            #cancel-comment-reply-link:hover {
                background: <?php echo $accent; ?>;
            }

            blockquote,
            .blockquote-reverse,
            blockquote.pull-right,
            #form-order-review,
            .woocommerce-checkout #payment{
                border-color: <?php echo $accent; ?>;
            }

            .search-heading .search-keyword,
            .search-content-error .search-keyword,
            blockquote.classic footer,
            .post-link-content .post-link-url a,

            .readmore-link:hover,
            .blog-posts .entry-title a:hover,
            .kt_tabs_content ul li .title a:hover,
            .widget_kt_posts ul li .title a:hover,
            #related-article h2.entry-title a:hover,
            .author-info h2.author-title a:hover,
            .author-info .author-social a:hover,
            .comment-meta h5 a:hover,
            .widget_pages ul li a:hover,
            .widget_nav_menu ul li a:hover,
            .widget_meta ul li a:hover,
            .widget_archive ul li a:hover,
            .widget_product_categories ul li a:hover,
            .widget_categories ul li a:hover,
            .yith-woocompare-widget ul.products-list li a.title:hover,
            .woocommerce ul.product_list_widget li a:hover{
                color: <?php echo $accent; ?>;
            }


            #main-content-sideshow .carousel-navigation-center .owl-kttheme .owl-buttons > div i,
            .woocommerce nav.woocommerce-pagination ul li a:focus,
            .woocommerce nav.woocommerce-pagination ul li a:hover,
            .woocommerce nav.woocommerce-pagination ul li span.current,
            .pagination a.page-numbers:hover,
            .pagination .page-numbers.current,
            .widget_product_tag_cloud a:hover,
            .widget_tag_cloud a:hover,
            .entry-share-box a:hover{
                border-color: <?php echo $accent; ?>;
                background: <?php echo $accent; ?>;
            }
            .social-background-empty.social-style-accent a,
            .social-background-outline.social-style-accent a,
            .woocommerce .woocommerce-info{
                border-color: <?php echo $accent; ?>!important;
            }

            .social-background-empty.social-style-accent a,
            .social-background-outline.social-style-accent a{
                color: <?php echo $accent; ?>!important;
            }
            .social-background-fill.social-style-accent a,
            .woocommerce.compare-button .blockUI.blockOverlay{
                background: <?php echo $accent; ?>!important;
            }

            .widget_nav_menu ul li a:hover:after,
            .widget_product_categories ul li a:hover:after,
            .widget_categories ul li a:hover:after,
            .widget_archive ul li a:hover:after,
            .widget_meta ul li a:hover:after,
            .yith-woocompare-widget ul.products-list li a.title:hover:after{
                background: <?php echo $accent; ?>;
                color: <?php echo $accent; ?>;
            }

        <?php } ?>

        <?php



            $header_opacity = kt_option('header_opacity', 1);
            echo '.header-background{opacity:'.$header_opacity.';}';

            $header_sticky_opacity = kt_option('header_sticky_opacity', 0.8);
            echo '.header-sticky-background{opacity:'.$header_sticky_opacity.';}';

            $is_shop = false;
            if(is_archive()){
                if(kt_is_wc()){
                    if(is_shop()){
                        $is_shop = true;
                    }
                }
            }

            if(is_page() || is_singular() || $is_shop){

                global $post;
                $post_id = $post->ID;
                if($is_shop){
                    $post_id = get_option( 'woocommerce_shop_page_id' );
                }

                $pageh_spacing = rwmb_meta('_kt_page_top_spacing', array(), $post_id);
                if($pageh_spacing != ''){
                    echo '#content{padding-top: '.$pageh_spacing.';}';
                }
                $pageh_spacing = rwmb_meta('_kt_page_bottom_spacing', array(), $post_id);
                if($pageh_spacing != ''){
                    echo '#content{padding-bottom:'.$pageh_spacing.';}';
                }

                $pageh_top = rwmb_meta('_kt_page_header_top', array(), $post_id);
                if($pageh_top != ''){
                    echo 'div.page-header{padding-top: '.$pageh_top.';}';
                }

                $pageh_bottom = rwmb_meta('_kt_page_header_bottom', array(), $post_id);
                if($pageh_bottom != ''){
                    echo 'div.page-header{padding-bottom: '.$pageh_bottom.';}';
                }

                $pageh_separator_color = rwmb_meta('_kt_page_header_separator_color', array(), $post_id);
                if($pageh_separator_color != ''){
                    echo '.page-header h1.page-header-title + .page-header-tagline:before{background:'.$pageh_separator_color.';}';
                }

                $pageh_title_color = rwmb_meta('_kt_page_header_title_color', array(), $post_id);
                if($pageh_title_color != ''){
                    echo 'div.page-header h1.page-header-title{color:'.$pageh_title_color.';}';
                }

                $pageh_subtitle_color = rwmb_meta('_kt_page_header_subtitle_color', array(), $post_id);
                if($pageh_subtitle_color != ''){
                    echo 'div.page-header .page-header-subtitle{color:'.$pageh_subtitle_color.';}';
                }

                $pageh_breadcrumbs_color = rwmb_meta('_kt_page_header_breadcrumbs_color', array(), $post_id);
                if($pageh_breadcrumbs_color != ''){
                    echo 'div.page-header .breadcrumbs,div.page-header .breadcrumbs a{color:'.$pageh_breadcrumbs_color.';}';
                }

                $pageh_bg_color = rwmb_meta('_kt_page_header_bg_color', array(), $post_id);
                if($pageh_bg_color != ''){
                    echo 'div.page-header{background:'.$pageh_bg_color.';}';
                }

                $pageh_bg_img = get_link_image_post('_kt_page_header_bg', $post_id, 'full');
                if($pageh_bg_img){
                    echo 'div.page-header{background-image:url('.$pageh_bg_img['url'].');}';
                }

            }

            $navigation_height = kt_option('navigation_height');
            if(!$navigation_height['height'] || $navigation_height['height'] == 'px'){
                $navigation_height['height'] = '100px';
            }
            echo '#nav > ul > li{line-height: '.$navigation_height['height'].'}';

            $navigation_height_fixed = kt_option('navigation_height_fixed');
            if(!$navigation_height_fixed['height'] || $navigation_height_fixed['height'] == 'px'){
                $navigation_height_fixed['height'] = '100px';
            }
            echo '.header-container.is-sticky #nav > ul > li{line-height: '.$navigation_height_fixed['height'].'}';

            if($navigation_bordertop = kt_option('navigation_bordertop')){
                echo '#main-nav-tool .kt-wpml-languages ul, #main-navigation > li .kt-megamenu-wrapper, #main-navigation > li ul.sub-menu-dropdown, .shopping-bag-wrapper{border-color: '.$navigation_bordertop.';}';
            }


            if($navigation_light_color = kt_option('navigation_light_color')){
                echo '.header-light #main-navigation > li > a span:after,.header-light .mobile-nav-bar span.mobile-nav-handle:before,.header-light .mobile-nav-bar span.mobile-nav-handle:after,.header-light .mobile-nav-bar span.mobile-nav-handle span{background:'.$navigation_light_color.';}';
                echo '.header-light .button-toggle .line,.header-light .button-toggle .close:before,.header-light .button-toggle .close:after{background:'.$navigation_light_color.';}';
            }
            if($navigation_light_color_hover = kt_option('navigation_light_color_hover')){
                echo '.header-light #nav > ul > li > a:hover span:after, .header-light #nav > ul > li > a:focus span:after, .header-light #nav > ul > li.current-menu-item > a span:after, .header-light #nav > ul > li.current-menu-parent > a span:after{background: '.$navigation_light_color_hover.';}';
                echo '.header-light .mobile-nav-bar:hover span.mobile-nav-handle:before,.header-light .mobile-nav-bar:hover span.mobile-nav-handle:after,.header-light .mobile-nav-bar:hover span.mobile-nav-handle span{background: '.$navigation_light_color_hover.';}';
            }
            if($navigation_dark_color = kt_option('navigation_dark_color')){
                echo '.header-dark #main-navigation > li > a span:after,.header-dark .mobile-nav-bar span.mobile-nav-handle:before,.header-dark .mobile-nav-bar span.mobile-nav-handle:after,.header-dark .mobile-nav-bar span.mobile-nav-handle span{background:'.$navigation_dark_color.';}';
                echo '.header-dark .button-toggle .line,.header-dark .button-toggle .close:before,.header-dark .button-toggle .close:after{background:'.$navigation_light_color.';}';
            }
            if($navigation_dark_color_hover = kt_option('navigation_dark_color_hover')){
                echo '.header-dark #nav > ul > li > a:hover span:after, .header-dark #nav > ul > li > a:focus span:after, .header-dark #nav > ul > li.current-menu-item > a span:after, .header-dark #nav > ul > li.current-menu-parent > a span:after{background: '.$navigation_dark_color_hover.';}';
            }

            if($navigation_space = kt_option('navigation_space', 20)){
                echo '#nav > ul > li{margin-left: '.$navigation_space.'px;}#main-navigation > li:first-child {margin-left: 0;}';
            }

            $dropdown_background_hover = kt_option('dropdown_background_hover');
            if($dropdown_background_hover['background-color'] != ''){
                echo '#main-nav-tool .kt-wpml-languages ul li, #main-navigation > li ul.sub-menu-dropdown > li{border-color: '.$dropdown_background_hover['background-color'].'}';
            }
            if($mega_vertical = kt_option('mega_vertical', '#282828')){
                echo '#main-navigation > li .kt-megamenu-wrapper.megamenu-layout-table > ul > li{border-color: '.$mega_vertical.';}';
            }
            if($mega_color = kt_option('mega_color', '#282828')){
                echo '.bag-buttons .btn-viewcart{border-color: '.$mega_color.';color:'.$mega_color.';}';
            }
            if($mega_color_hover = kt_option('mega_color_hover')){
                echo '#main-navigation > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > .sub-menu-megamenu > li > a:before{background-color: '.$mega_color_hover.';color:'.$mega_color_hover.';}';
            }



            if($navigation_box_background = kt_option('navigation_box_background')){
                    echo '.bag-buttons .btn-viewcart:hover{background: '.$mega_color.';border-color: '.$mega_color.';color:'.$navigation_box_background['background-color'].';}';
                }
            if($mega_title_color = kt_option('mega_title_color')){
                echo '#main-navigation > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > a, #main-navigation > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > span.megamenu-title, #main-navigation > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li .widget-title{border-color: '.$mega_title_color.';}';
            }
            if($cart_divders = kt_option('cart_divders')){
                echo '.shopping-bag-wrapper .cart-title, .bag-total{border-color: '.$cart_divders.';}';
            }

            if($mobile_sub_color_hover = kt_option('mobile_sub_color_hover')){
                echo 'ul.navigation-mobile > li .sub-menu-dropdown > li > a span:before, ul.navigation-mobile > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > .sub-menu-megamenu > li > a span:before{background: '.$mobile_sub_color_hover.';}';
            }





        ?>


        @media (max-width: 991px) {
            <?php $logo_width = kt_option('logo_mobile_width'); ?>
            .site-branding .site-logo img{
                width: <?php echo $logo_width['width'] ?>!important;
            }
            <?php
            $logo_mobile_margin_spacing = kt_option('logo_mobile_margin_spacing', '');
            $style_logo_mobile = '';
            if($margin_top = $logo_mobile_margin_spacing['margin-top']){
                $style_logo_mobile .= 'margin-top:'.$margin_top.'!important;';
            }
            if($margin_right = $logo_mobile_margin_spacing['margin-right']){
                $style_logo_mobile .= 'margin-right:'.$margin_right.';';
            }
            if($margin_bottom = $logo_mobile_margin_spacing['margin-bottom']){
                $style_logo_mobile .= 'margin-bottom:'.$margin_bottom.'!important;';
            }
            if($margin_left = $logo_mobile_margin_spacing['margin-left']){
                $style_logo_mobile .= 'margin-left:'.$margin_left.';';
            }
            if($style_logo_mobile){
                echo '.site-branding .site-logo img{'.$style_logo_mobile.'}';
            }

            ?>
        }
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

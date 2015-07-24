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
    
    $tracking_code = kt_option('advanced_tracking_code');
    echo $tracking_code;
    
    $advanced_css = kt_option('advanced_editor_css');
    $accent = kt_option('styling_accent', '');
     
    ?>
    <style id="kt-theme-custom-css" type="text/css">

        <?php

            echo $advanced_css;


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



        ?>




        <?php if( $accent !='' ){ ?>

            ::-moz-selection{ background:<?php echo $accent; ?>;}
            ::-webkit-selection{ background:<?php echo $accent; ?>;}
            ::selection{ background:<?php echo $accent; ?>;}


        <?php } ?>



        @media (max-width: 991px) {
            <?php $logo_width = kt_option('logo_mobile_width'); ?>
            .site-branding .site-logo img{
                width: <?php echo $logo_width['width'] ?>!important;
            }
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

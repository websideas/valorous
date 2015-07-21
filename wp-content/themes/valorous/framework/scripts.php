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
    $title_separator = kt_option('title_separator_color', '');
     
    ?>
    <style id="kt-theme-custom-css" type="text/css">
        <?php echo $advanced_css; ?>

        <?php
            if(is_page() || is_singular()){
                $page_top_spacing = rwmb_meta('_kt_page_top_spacing');
                if($page_top_spacing != ''){
                    echo '#content{padding-top: '.$page_top_spacing.'}';
                }
                $page_bottom_spacing = rwmb_meta('_kt_page_bottom_spacing');
                if($page_bottom_spacing != ''){
                    echo '#content{padding-bottom: '.$page_bottom_spacing.'}';
                }
            }
        ?>


        <?php if($title_separator){ ?>
        .page-header h1.page-header-title + .page-header-tagline::before{
            background: <?php echo $title_separator; ?>
        }
        <?php } ?>

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

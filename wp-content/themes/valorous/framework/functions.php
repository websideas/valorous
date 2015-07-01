<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Change the path to the directory that contains demo data folders.
 *
 * @param [string] $demo_directory_path
 *
 * @return [string]
 */

function wbc_change_demo_directory_path( $demo_directory_path ) {
	$demo_directory_path = THEME_DIR.'dummy-data/';
	return $demo_directory_path;

}
add_filter('wbc_importer_dir_path', 'wbc_change_demo_directory_path' );



/**
 * Add page header
 *
 * @since 1.0
 */
add_action( 'theme_before_content', 'get_page_header', 20 );
function get_page_header( ){
    global $post;
    $show_title = true;
    if ( is_front_page() && is_singular('page') ){
        $show_title = rwmb_meta('_kt_page_header', array(), get_option('page_on_front', true));
    } elseif( $post ){
        $post_id = $post->ID;
        $show_title = rwmb_meta('_kt_page_header', array(), $post_id);
    }

    if(kt_is_wc()){
        if(is_shop()){
            $show_title = true;
        }
    }


    if($show_title){
        $title = kt_get_page_title();
        $breadcrumb = kt_get_breadcrumb();
        $page_header_align = kt_get_page_align();
        $tagline = kt_get_page_tagline();

        $tagline = ($tagline != '') ? '<div class="page-header-tagline">'.$tagline.'</div>' : $tagline;
        $title = '<h1 class="page-header-title">'.$title.'</h1>';

        $classes = array('page-header', 'page-header-'.$page_header_align);
        if($page_header_align != 'center'){
            $classes[] = 'page-header-side';
        }

        if($breadcrumb == '' || $page_header_align == 'center'){
            $layout = '%1$s%2$s%3$s';
        }else{
            if($breadcrumb != ''){
                if($page_header_align == 'right'){
                    $layout = '<div class="row"><div class="col-md-8 page-header-right pull-right">%1$s%2$s</div><div class="col-md-4 page-header-left">%3$s</div></div>';
                }else{
                    $layout = '<div class="row"><div class="col-md-8 page-header-left">%1$s%2$s</div><div class="col-md-4 page-header-right">%3$s</div></div>';
                }
            }else{
                $layout = '%1$s%2$s%3$s';
            }
        }

        echo '<div class="'.implode(' ', $classes).'">';
        echo '<div class="container">';
            printf(
                $layout,
                $title,
                $tagline,
                $breadcrumb
            );
        echo "</div>";
        echo "</div>";


    }
}

/**
 * Get page align
 *
 * @return mixed
 *
 */
function kt_get_page_align(){
    global $post;
    $page_header_align = '';
    if ( is_front_page() && is_singular('page') ){
        $page_header_align =  rwmb_meta('_kt_page_header_align');
    }elseif( $post ){
        $post_id = $post->ID;
        $page_header_align =  rwmb_meta('_kt_page_header_align', array(), $post_id);
    }
    if($page_header_align == ''){
        $page_header_align = kt_option('title_align', 'left');
    }

    return $page_header_align;

}

/**
 * Get page title
 *
 * @param string $title
 * @return mixed|void
 */

function kt_get_page_title( $title = '' ){
    global $post;

    if ( is_front_page() && !is_singular('page') ) {
            $title = __( 'Blog', THEME_LANG );
    } elseif ( is_search() ) {
        $title = __( 'Search', THEME_LANG );
    } elseif( is_404() ) {
        $title = __( 'Page not found', THEME_LANG );
    } elseif ( is_archive() ){
        $title = get_the_archive_title();

    } elseif ( is_front_page() && is_singular('page') ){
        $page_on_front = get_option('page_on_front', true);
        $title = get_the_title($page_on_front) ;
    } elseif( $post ){
        $post_id = $post->ID;
        $title = get_the_title($post_id);
    }

    return apply_filters( 'kt_tittle', $title );

}

/**
 * Get page tagline
 *
 * @return mixed|void
 */

function kt_get_page_tagline(){
    global $post;
    $tagline = '';
    if ( is_front_page() && !is_singular('page') ) {
        $tagline =  __('Lastest posts', THEME_LANG);
    }elseif ( is_front_page() && is_singular('page') ){
        $tagline =  rwmb_meta('_kt_page_header_taglitle');
    }elseif ( is_archive() ){
        $tagline =  get_the_archive_description( );
    }elseif( $post ){
        $post_id = $post->ID;
        $tagline = nl2br(rwmb_meta('_kt_page_header_taglitle', array(), $post_id));
    }

    return apply_filters( 'kt_tagline', $tagline );
}


add_filter( 'get_the_archive_title', 'kt_get_the_archive_title');
/**
 * Remove text Category and Archives in get_the_archive_title
 *
 * @param $title
 * @return null|string
 */
function kt_get_the_archive_title($title) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $tax = get_taxonomy( get_queried_object()->taxonomy );
        /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
        $title =  single_term_title( '', false );
    }

    return $title;

}


/**
 * Get breadcrumb
 *
 * @param string $breadcrumb
 * @return mixed|void
 */
function kt_get_breadcrumb($breadcrumb = ''){
    $show = '';
    if( is_page() || is_singular() ){
        $show_option = rwmb_meta( '_kt_show_breadcrumb' );
        if($show_option != ''){
            $show = $show_option;
        }
    }elseif ( is_front_page() && !is_singular('page') ) {
        $show_option = rwmb_meta( '_kt_show_breadcrumb' );
        if($show_option != ''){
            $show = $show_option;
        }
    }
    if($show == '' || $show == '-1'){
        $show = kt_option('title_breadcrumbs');
    }

    if($show){
        if(kt_is_wc()){
            if( is_woocommerce() ){
                ob_start();
                woocommerce_breadcrumb(
                    array(
                        'delimiter' =>'<span class="sep navigation-pipe"></span>',
                        'wrap_before' => '<nav class="woocommerce-breadcrumb breadcrumbs">',

                    ) );
                $breadcrumb = ob_get_clean();
            }else{
                if(function_exists('breadcrumb_trail')) {
                    $breadcrumb = breadcrumb_trail(array( 'echo' => false));
                }
            }
        }else{
            if(function_exists('breadcrumb_trail')) {
                $breadcrumb = breadcrumb_trail(array( 'echo' => false));
            }
        }
    }
    return apply_filters( 'kt_breadcrumb', $breadcrumb );
}


/**
 * Get Layout sidebar of post
 *
 * @return array
 *
 */
function kt_sidebar(){
    global $post;

    $sidebar = kt_option('sidebar', 'full');
    $sidebar_left = kt_option('sidebar_left', 'primary-widget-area');
    $sidebar_right = kt_option('sidebar_right', 'primary-widget-area');

    if( kt_is_wc() ){
        if( is_shop() || is_product_category() || is_product_tag() ){
            $sidebar = kt_option('shop_sidebar', 'full');
            $sidebar_left = kt_option('shop_sidebar_left', 'shop-widget-area');
            $sidebar_right = kt_option('shop_sidebar_right', 'shop-widget-area');
        }elseif( is_product() ){
            $sidebar = kt_option('product_sidebar', 'full');
            $sidebar_left = kt_option('product_sidebar_left', 'shop-widget-area');
            $sidebar_right = kt_option('product_sidebar_right', 'shop-widget-area');
        }elseif(is_cart() || is_checkout()){
            return array('sidebar' => 'full', 'sidebar_area' => null);
        }
    }

    if($sidebar == 'left'){
        $sidebar_area = $sidebar_left;
    }elseif($sidebar == 'right'){
        $sidebar_area = $sidebar_right;
    }else{
        $sidebar_area = null;
    }

    $layout_sidebar = array(
        'sidebar' => $sidebar,
        'sidebar_area' => $sidebar_area
    );

    if(is_page() || is_singular('post') || is_home() || is_singular('portfolio')){
        $page_id = get_the_ID();
        if(is_home()){
            $page_id = get_option( 'page_for_posts' );
        }

        $sidebar_post = rwmb_meta('_kt_sidebar', array(), $page_id);

        if($sidebar_post != 'default' && $sidebar_post){
            $layout_sidebar['sidebar'] = $sidebar_post;
            if($sidebar_post == 'left'){
                $sidebar_left_post = rwmb_meta('_kt_left_sidebar', array(), $page_id);
                if($sidebar_left_post  == 'default'){
                    $sidebar_left_post = $sidebar_left;
                }
                $layout_sidebar['sidebar_area'] = $sidebar_left_post;
            }elseif($sidebar_post == 'right'){
                $sidebar_right_post = rwmb_meta('_kt_right_sidebar', array(), $page_id);
                if($sidebar_right_post  == 'default'){
                    $sidebar_right_post = $sidebar_right;
                }
                $layout_sidebar['sidebar_area'] = $sidebar_right_post;
            }
        }

    }elseif(is_archive()){

    }



    return $layout_sidebar;
}




/**
 * Extend the default WordPress body classes.
 *
 * @since 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function theme_body_classes( $classes ) {
    global $post;
    
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
    
    if( is_page() || is_singular('post')){
        $classes[] = 'layout-'.kt_getlayout($post->ID);
        $classes[] = rwmb_meta('_kt_extra_page_class');
    }else{
        $classes[] = 'layout-'.kt_option('layout');
    }
    
    if( kt_option( 'footer_fixed' ) == 1 ){
        $classes[] = 'footer_fixed';
    } 
    

	return $classes;
}
add_filter( 'body_class', 'theme_body_classes' );

/**
 * Add class layout for main class
 *
 * @since 1.0
 *
 * @param string $classes current class
 * @param string $layout layout current of page 
 *  
 * @return array The filtered body class list.
 */
function kt_main_class_callback($classes, $layout){
    
    if($layout == 'left' || $layout == 'right'){
        $classes .= ' col-md-9 col-xs-12'; 
    }else{
        $classes .= ' col-md-12 col-xs-12';
    }
    
    if($layout == 'left'){
         $classes .= ' pull-right';
    }
    return $classes;
}
add_filter('kt_main_class', 'kt_main_class_callback', 10, 2);


/**
 * Add class layout for sidebar class
 *
 * @since 1.0
 *
 * @param string $classes current class
 * @param string $layout layout current of page 
 *  
 * @return array The filtered body class list.
 */
function kt_sidebar_class_callback($classes, $layout){
    if($layout == 'left' || $layout == 'right'){
        $classes .= ' col-md-3 col-xs-12'; 
    }
    return $classes;
}
add_filter('kt_sidebar_class', 'kt_sidebar_class_callback', 10, 2);



/**
 * Add class remove top or bottom padding
 *
 * @since 1.0
 */
function kt_content_class_callback($classes){
    global $post;
    if(rwmb_meta('_kt_remove_top')){
        $classes .= ' remove_top_padding';
    }
    if(rwmb_meta('_kt_remove_bottom')){
        $classes .= ' remove_bottom_padding';
    }
    return $classes;
} 
add_filter('kt_content_class', 'kt_content_class_callback');

/**
 * Add class sticky to header
 */
function theme_header_content_class_callback($classes){
    if(kt_option('fixed_header', 1)){
        $classes .= ' sticky-header';
    }
    if(kt_option('header_full', 1)){
        $classes .= ' header-fullwidth';
    }

    return $classes;
}

add_filter('theme_header_content_class', 'theme_header_content_class_callback');


/**
 * Add slideshow header
 *
 * @since 1.0
 */
add_action( 'theme_slideshows_position', 'theme_slideshows_position_callback' );
function theme_slideshows_position_callback(){
    global $post;
    if(is_page() || is_singular('post')){
        
        $slideshow = rwmb_meta('_kt_slideshow_source');
        if($slideshow == 'revslider'){
            $revslider = rwmb_meta('_kt_rev_slider');
            if($revslider && class_exists( 'RevSlider' )){
                echo putRevSlider($revslider);
            }
        }elseif($slideshow == 'layerslider'){
            $layerslider = rwmb_meta('_kt_layerslider');
            if($layerslider && is_plugin_active( 'LayerSlider/layerslider.php' )){
                echo do_shortcode('[layerslider id="'.$layerslider.'"]');
            }
        }elseif($slideshow == 'custom_bg'){
            $img = rwmb_meta('_kt_custom_bg');
            $image = wp_get_attachment_url( $img );

            if ( $image ) {
                echo '<div class="page-bg-cover category-slide-container"><div class="container"><div class="cover-img" style="background-image: url(\''.esc_url( $image ).'\');"></div></div></div>';
            }
        }


    }elseif ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        if(is_product_category()){
            
            	global $wp_query;
                $cat = $wp_query->get_queried_object();
                $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
                $image = wp_get_attachment_url( $thumbnail_id );
                if ( $image ) {
                    echo '<div class="page-bg-cover category-slide-container"><div class="container"><div class="cover-img" style="background-image: url(\''.esc_url( $image ).'\');"></div></div></div>';
                } 
        }else{

            // shop page
            if ( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0 ) {
                $shop_page   = wc_get_page_id( 'shop' ) ;

                if ( $shop_page ) {
                    $slideshow = rwmb_meta('_kt_slideshow_source', false, $shop_page);
                    if($slideshow == 'revslider'){
                        $revslider = rwmb_meta('_kt_rev_slider',  false, $shop_page);
                        if($revslider && class_exists( 'RevSlider' )){
                            echo putRevSlider($revslider);
                        }
                    }elseif($slideshow == 'layerslider'){
                        $layerslider = rwmb_meta('_kt_layerslider', false, $shop_page );
                        if($layerslider && is_plugin_active( 'LayerSlider/layerslider.php' )){
                            echo do_shortcode('[layerslider id="'.$layerslider.'"]');
                        }
                    }elseif($slideshow == 'custom_bg'){
                        $img = rwmb_meta('_kt_custom_bg', false, $shop_page );
                        $image = wp_get_attachment_url( $img );

                        if ( $image ) {
                            echo '<div class="page-bg-cover category-slide-container"><div class="container"><div class="cover-img" style="background-image: url(\''.esc_url( $image ).'\');"></div></div></div>';
                        }
                    }

                }
            }

        }

    }
}




/**
 * Add class header
 *
 * @since 1.0
 * @return string
 */
add_filter('theme_header_class', 'theme_header_class_callback', 10, 2);

function theme_header_class_callback($class, $position){
    if($position == 'transparent' ){
        $class .= ' header-absolute';
    }elseif($position == 'gradient'){
        $class .= ' header-gradient';
    }

    return $class;
}



/**
 * Add popup 
 *
 * @since 1.0
 */
add_action( 'theme_after_footer', 'theme_after_footer_add_popup', 20 );
function theme_after_footer_add_popup(){
    $enable_popup = kt_option( 'enable_popup' );
    $disable_popup_mobile = kt_option( 'disable_popup_mobile' );
    $content_popup = kt_option( 'content_popup' );
    $time_show = kt_option( 'time_show', 0 );
    
    if( $enable_popup == 1 ){ 
        if(!isset($_COOKIE['kt_popup'])){ ?>
            <div id="popup-wrap" class="mfp-hide" data-mobile="<?php echo esc_attr( $disable_popup_mobile ); ?>" data-timeshow="<?php echo esc_attr($time_show); ?>">     
                <div class="white-popup-block">
                    <?php echo do_shortcode($content_popup); ?>
                </div>
            </div>
        <?php }
    }
}




function kt_blog_favicon() { 
    $custom_favicon = kt_option( 'custom_favicon' );
    $custom_favicon_iphone = kt_option( 'custom_favicon_iphone' );
    $custom_favicon_iphone_retina = kt_option( 'custom_favicon_iphone_retina' );
    $custom_favicon_ipad = kt_option( 'custom_favicon_ipad' );
    $custom_favicon_ipad_retina = kt_option( 'custom_favicon_ipad_retina' );
    
    ?>
    <!-- Favicons -->
    <?php if($custom_favicon['url']){ ?>
        <link rel="shortcut icon" href="<?php echo esc_url($custom_favicon['url']); ?>" />
    <?php } ?>
	<?php if($custom_favicon_iphone['url']){ ?>
        <link rel="apple-touch-icon" href="<?php echo esc_url($custom_favicon_iphone['url']); ?>" />
    <?php } ?>
    <?php if($custom_favicon_iphone_retina['url']){ ?>
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url($custom_favicon_iphone_retina['url']); ?>" />    
    <?php } ?>
    <?php if($custom_favicon_ipad['url']){ ?>
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url($custom_favicon_ipad['url']); ?>" />    
    <?php } ?>
    <?php if($custom_favicon_ipad_retina['url']){ ?>
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url($custom_favicon_ipad_retina['url']); ?>" />    
    <?php } ?>
<?php }
add_action('wp_head', 'kt_blog_favicon');


/**
 * Add share product 
 *
 * @since 1.0
 */
add_action( 'wp_head', 'wp_head_addthis_script', 50 );
function wp_head_addthis_script(){ 
    $addthis_id = kt_option('addthis_id');
    if($addthis_id){
        ?>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-<?php echo esc_attr( $addthis_id ); ?>" async="async"></script>
        <?php
    }
}

/**
 * Change separator of breadcrumb
 * 
 */
function kt_breadcrumb_trail_args( $args ){
    $args['separator'] = "&nbsp;";
    return $args;
}
add_filter('breadcrumb_trail_args', 'kt_breadcrumb_trail_args');



/**
 * Add logo sticky to main menu
 * 
 */
function kt_nav_wrap() {
    $logo = kt_get_logo();
    $logo_class = ($logo['sticky_retina']) ? 'retina-logo-wrapper' : ''; 
    $wrap  = '<ul id="%1$s" class="%2$s">';
        $wrap .= '<li class="menu-logo '.$logo_class.'">'; 
            ob_start();
        ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img src="<?php echo esc_url($logo['sticky']); ?>" class="default-logo" alt="<?php bloginfo( 'name' ); ?>" />
                    <?php if($logo['sticky_retina']){ ?>
                        <img src="<?php echo esc_url($logo['sticky_retina']); ?>" class="retina-logo" alt="<?php bloginfo( 'name' ); ?>" />
                    <?php } ?>
                </a><?php
            $wrap .= ob_get_contents();
            ob_end_clean();
        $wrap .= '</li>';
        $wrap .= '%3$s';
    $wrap .= '</ul>';

  return $wrap;
}

/*
 * Add social media to author
 */

function kt_contactmethods( $contactmethods ) {

    // Add Twitter, Facebook
    $contactmethods['facebook'] = __('Facebook page/profile url', THEME_LANG);
    $contactmethods['twitter'] = __('Twitter username (without @)', THEME_LANG);
    $contactmethods['pinterest'] = __('Pinterest username', THEME_LANG);
    $contactmethods['googleplus'] = __('Google+ page/profile URL', THEME_LANG);
    $contactmethods['instagram'] = __('Instagram username', THEME_LANG);
    $contactmethods['tumblr'] = __('Tumblr username', THEME_LANG);


    return $contactmethods;
}
add_filter( 'user_contactmethods','kt_contactmethods', 10, 1 );

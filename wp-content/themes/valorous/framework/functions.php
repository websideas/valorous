<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;





/**
 * Add page header
 *
 * @since 1.0
 */
add_action( 'theme_before_content', 'get_page_header', 20 );
function get_page_header( ){
    global $post;
    $show_title = true;

    if ( is_front_page() && is_singular('page')){
        $show_title = rwmb_meta('_kt_page_header', array(), get_option('page_on_front', true));
        if( $show_title == '' ||  $show_title == '-1'){
            $show_title = kt_option('show_page_header', 1);
        }
    }elseif(is_archive()){
        $show_title = kt_option('archive_page_header', 1);
        if(kt_is_wc()){
            if(is_shop() || is_product_taxonomy() || is_product_tag() ){
                $show_title = kt_option('shop_page_header', 1);
            }
        }
    }elseif(is_404()){
        $show_title = kt_option('notfound_page_header', 1);
    }elseif(is_page() || is_singular()){
        $post_id = $post->ID;
        $show_title = rwmb_meta('_kt_page_header', array(), $post_id);
        if( $show_title == '' ||  $show_title == '-1'){
            if(is_page()){
                $show_title = kt_option('show_page_header', 1);
            }elseif(is_singular('portfolio')){
                $show_title = kt_option('portfolio_page_header', 1);
            }else{
                if(kt_is_wc()){
                    if(is_product()){
                        $show_title = kt_option('product_page_header', 1);
                    }
                }else{
                    $show_title = kt_option('single_page_header', 1);
                }
            }
        }
    }

    $show_title = apply_filters( 'kt_show_title', $show_title );

    if($show_title){


        $title = kt_get_page_title();
        $subtitle = kt_get_page_subtitle();
        $breadcrumb = kt_get_breadcrumb();
        $page_header_align = kt_get_page_align();


        $subtitle = ($subtitle != '') ? '<div class="page-header-tagline">'.$subtitle.'</div>' : $subtitle;
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
                $subtitle,
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

    $page_header_align = '';
    if ( is_front_page() && is_singular('page') ){
        $page_header_align =  rwmb_meta('_kt_page_header_align');
    }elseif(is_page() || is_singular()){
        $page_header_align =  rwmb_meta('_kt_page_header_align');
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
    } elseif( is_home() ){
        $page_for_posts = get_option('page_for_posts', true);
        if($page_for_posts){
            $title = get_the_title($page_for_posts) ;
        }
    } elseif( is_404() ) {
        $title = __( 'Page not found', THEME_LANG );
    } elseif ( is_archive() ){
        $title = get_the_archive_title();
    } elseif ( is_front_page() && is_singular('page') ){
        $page_on_front = get_option('page_on_front', true);
        $title = get_the_title($page_on_front) ;
    } elseif( is_page() || is_singular() ){
        $post_id = $post->ID;
        $title = get_the_title($post_id);
    }

    return apply_filters( 'kt_title', $title );

}

/**
 * Get page tagline
 *
 * @return mixed|void
 */

function kt_get_page_subtitle(){
    global $post;
    $tagline = '';
    if ( is_front_page() && !is_singular('page') ) {
        $tagline =  __('Lastest posts', THEME_LANG);
    }elseif( is_home() ){
        $page_for_posts = get_option('page_for_posts', true);
        $tagline = nl2br(rwmb_meta('_kt_page_header_taglitle', array(), $page_for_posts))  ;
    }elseif ( is_front_page() && is_singular('page') ){
        $tagline =  rwmb_meta('_kt_page_header_taglitle');
    }elseif ( is_archive() ){
        $tagline =  get_the_archive_description( );
        if(kt_is_wc()){
            if(is_shop()){
                $shop_page_id = get_option( 'woocommerce_shop_page_id' );
                if($shop_page_id){
                    $tagline = rwmb_meta('_kt_page_header_taglitle', array(), $shop_page_id);
                }
            }
        }
    }elseif(is_search()){
        $tagline = '';
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
    }elseif ( is_archive() ){
        if(kt_is_wc()){
            if(is_shop()){
                $shop_page_id = get_option( 'woocommerce_shop_page_id' );
                if($shop_page_id){
                    $show = rwmb_meta('_kt_show_breadcrumb', array(), $shop_page_id);
                }
            }
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
 * Get settings archive
 *
 * @return array
 */
function kt_get_settings_archive(){
    return array(
        'blog_type' => kt_option('archive_loop_style', 'classic'),
        'blog_columns' => kt_option('archive_columns'),
        'blog_columns_tablet' => kt_option('archive_columns_tablet'),
        'blog_layout' => kt_option('archive_layout', '1'),
        'readmore' => kt_option('archive_readmore', 1),
        'blog_pagination' => kt_option('archive_pagination', 'classic'),
        'thumbnail_type' => kt_option('archive_thumbnail_type', 'image'),
        'sharebox' => kt_option('archive_sharebox', 1),
        'excerpt_length' => kt_option('archive_excerpt_length', 30),
        'show_meta' => kt_option('archive_meta', 1),
        'show_author' => kt_option('archive_meta_author', 1),
        'show_category' => kt_option('archive_meta_categories', 1),
        'show_comment' => kt_option('archive_meta_comments', 1),
        'show_date' => kt_option('archive_meta_date', 1),
        'date_format' => kt_option('archive_date_format', 1),
        'image_size' => kt_option('archive_image_size', 'blog_post'),
        'max_items' => get_option('posts_per_page')
    );
}

/**
 * Get settings search
 *
 * @return array
 */
function kt_get_settings_search(){
    return array(
        'blog_type' => kt_option('search_loop_style', 'classic'),
        'blog_columns' => kt_option('search_columns'),
        'blog_columns_tablet' => kt_option('search_columns_tablet'),
        'blog_layout' => kt_option('search_layout', '1'),
        'readmore' => kt_option('search_readmore', 1),
        'blog_pagination' => kt_option('search_pagination', 'classic'),
        'thumbnail_type' => kt_option('search_thumbnail_type', 'image'),
        'sharebox' => kt_option('search_sharebox', 1),
        'excerpt_length' => kt_option('search_excerpt_length', 30),
        'show_meta' => kt_option('search_meta', 1),
        'show_author' => kt_option('search_meta_author', 1),
        'show_category' => kt_option('search_meta_categories', 1),
        'show_comment' => kt_option('search_meta_comments', 1),
        'show_date' => kt_option('search_meta_date', 1),
        'date_format' => kt_option('search_date_format', 1),
        'image_size' => kt_option('search_image_size', 'blog_post'),
        'max_items' => get_option('posts_per_page')
    );
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



function kt_disable_title_404($show_tittle){
    if(is_404()){
        $show_tittle = false;
    }
    return $show_tittle;
}
add_filter('kt_show_tittle', 'kt_disable_title_404');



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

    if(is_page() || is_singular()){
        if(rwmb_meta('_kt_remove_top')){
            $classes .= ' remove_top_padding';
        }
        if(rwmb_meta('_kt_remove_bottom')){
            $classes .= ' remove_bottom_padding';
        }
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
 * Add favicon to website
 *
 */

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
 * Change separator of breadcrumb
 * 
 */
function kt_breadcrumb_trail_args( $args ){
    $args['separator'] = "&nbsp;";
    return $args;
}
add_filter('breadcrumb_trail_args', 'kt_breadcrumb_trail_args');


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



add_filter( 'kt_placeholder', 'kt_placeholder_callback');
function kt_placeholder_callback( $size = '') {

    $imgage = THEME_IMG . 'placeholder-post.png';

    $placeholder = kt_option('archive_placeholder');

    if(is_array($placeholder) && $placeholder['id'] != '' ){
        $obj = get_thumbnail_attachment($placeholder['id'], $size);
        $imgage = $obj['url'];
    }

    return $imgage;
}
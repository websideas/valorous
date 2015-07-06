<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


function wp_ajax_fronted_loadmore_blog_callback(){
    check_ajax_referer( 'ajax_frontend', 'security' );
    $settings = $_POST['settings'];
    $paged = intval($_POST['paged']);

    $output = array('error' => 1, 'settings' => $settings);
    extract($output['settings']);


    $output['html'] = do_shortcode('[list_blog_posts source="'.$source.'" categories="'.$categories.'" posts="'.$posts.'" authors="'.$authors.'" loadmore="true" page="'.$paged.'" blog_type="'.$blog_type.'" blog_columns="'.$blog_columns.'" blog_layout="'.$blog_layout.'" readmore="'.$readmore.'" blog_pagination="'.$blog_pagination.'" max_items="'.$max_items.'" excerpt_length="'.$excerpt_length.'" orderby="'.$orderby.'" order="'.$order.'" show_author="'.$show_author.'" show_category="'.$show_category.'" show_comment="'.$show_comment.'" show_date="'.$show_date.'" date_format="'.$date_format.'" image_size="'.$image_size.'"]');

    echo json_encode($output);
    die();
}
add_action( 'wp_ajax_fronted_loadmore_blog', 'wp_ajax_fronted_loadmore_blog_callback' );
add_action( 'wp_ajax_nopriv_fronted_loadmore_blog', 'wp_ajax_fronted_loadmore_blog_callback' );

function wp_ajax_fronted_fronted_loadmore_archive_callback(){
    check_ajax_referer( 'ajax_frontend', 'security' );

    $settings = $_POST['settings'];
    $query_vars = (is_array($_POST['queryvars'])) ? $_POST['queryvars'] : json_decode( stripslashes( $_POST['queryvars'] ), true );
    $query_vars['paged'] = intval($_POST['paged']);


    $output = array('error' => 1, 'settings' => $settings);
    extract($output['settings']);

    $wp_query = new WP_Query( $query_vars );

    if($blog_type == 'grid' || $blog_type == 'masonry'){
        $elementClass[] = 'blog-posts-columns-'.$blog_columns;
        $elementClass[] = 'blog-posts-layout-'.$blog_layout;
        $bootstrapColumn = round( 12 / $blog_columns );
        $bootstrapTabletColumn = round( 12 / $blog_columns_tablet );
        $classes = 'col-xs-12 col-sm-'.$bootstrapTabletColumn.' col-md-' . $bootstrapColumn;
    }

    global $blog_atts;
    $blog_atts = array(
        'image_size' => $image_size,
        'readmore' => apply_filters('sanitize_boolean', $readmore),
        'show_meta' =>  apply_filters('sanitize_boolean', $show_meta),
        "show_author" => apply_filters('sanitize_boolean', $show_author),
        "show_category" => apply_filters('sanitize_boolean', $show_category),
        "show_comment" => apply_filters('sanitize_boolean', $show_comment),
        "show_date" => apply_filters('sanitize_boolean', $show_date),
        "date_format" => $date_format,
        'thumbnail_type' => $thumbnail_type,
        'sharebox' => apply_filters('sanitize_boolean', $sharebox),
        "class" => 'loadmore-item'
    );


    $path = ($blog_type == 'classic') ? 'templates/blog/classic/content' : 'templates/blog/layout/layout'.$blog_layout.'/content';
    ob_start();

    $i = ( $query_vars['paged'] - 1 ) * $max_items + 1 ;
    while ( $wp_query->have_posts() ) : $wp_query->the_post();
        if($blog_type == 'grid' || $blog_type == 'masonry'){
            $classes_extra = '';
            if($blog_type == 'grid'){
                if (  ( $i - 1 ) % $blog_columns == 0 || 1 == $blog_columns )
                    $classes_extra .= ' col-clearfix-md col-clearfix-lg ';

                if ( ( $i - 1 ) % $blog_columns_tablet == 0 || 1 == $blog_columns )
                    $classes_extra .= ' col-clearfix-sm';
            }
            echo "<div class='article-post-item ".$classes." ".$classes_extra."'>";
        }

        get_template_part( $path , get_post_format() );

        if($blog_type == 'grid' || $blog_type == 'masonry'){
            echo "</div><!-- .article-post-item -->";
        }
        $i++;


    endwhile;
    $output['html'] = ob_get_clean();

    echo json_encode($output);
    die();

}



add_action( 'wp_ajax_fronted_loadmore_archive', 'wp_ajax_fronted_fronted_loadmore_archive_callback' );
add_action( 'wp_ajax_nopriv_fronted_loadmore_archive', 'wp_ajax_fronted_loadmore_archive_callback' );

if(!function_exists('putRevSlider')){
    function putRevSlider($data,$putIn = ""){
        if(class_exists( 'RevSlider' )){
            $operations = new RevOperations();
            $arrValues = $operations->getGeneralSettingsValues();
            $includesGlobally = UniteFunctionsRev::getVal($arrValues, "includes_globally","on");
            $strPutIn = UniteFunctionsRev::getVal($arrValues, "pages_for_includes");
            $isPutIn = RevSliderOutput::isPutIn($strPutIn,true);

            if($isPutIn == false && $includesGlobally == "off"){
                $output = new RevSliderOutput();
                $option1Name = "Include RevSlider libraries globally (all pages/posts)";
                $option2Name = "Pages to include RevSlider libraries";
                $output->putErrorMessage(__("If you want to use the PHP function \"putRevSlider\" in your code please make sure to check \" ",REVSLIDER_TEXTDOMAIN).$option1Name.__(" \" in the backend's \"General Settings\" (top right panel). <br> <br> Or add the current page to the \"",REVSLIDER_TEXTDOMAIN).$option2Name.__("\" option box."));
                return(false);
            }

            RevSliderOutput::putSlider($data,$putIn);
        }
    }
}



function wp_ajax_fronted_get_wishlist_callback(){
    check_ajax_referer( 'ajax_frontend', 'security' );
    $output = array('count' => 0);
    
    global $wpdb;
    
    if(class_exists('YITH_WCWL_UI')){    
        $count = array();
                	       
    	if( is_user_logged_in() ) {
    	    $count = $wpdb->get_results( $wpdb->prepare( 'SELECT COUNT(*) as `cnt` FROM `' . YITH_WCWL_ITEMS_TABLE . '` WHERE `user_id` = %d', get_current_user_id()  ), ARRAY_A );
    	    $count = $count[0]['cnt'];
    	} elseif( yith_usecookies() ) {
    	    $count[0]['cnt'] = count( yith_getcookie( 'yith_wcwl_products' ) );
    	    $count = $count[0]['cnt'];
    	} else {
    	    $count[0]['cnt'] = count( $_SESSION['yith_wcwl_products'] );
    	    $count = $count[0]['cnt'];
    	}
        
    	if (is_array($count)) {
    		$count = 0;
    	}
        
        $output['count'] = $count;
        
    }
    echo json_encode($output);
    die();
}
add_action( 'wp_ajax_fronted_get_wishlist', 'wp_ajax_fronted_get_wishlist_callback' );
add_action( 'wp_ajax_nopriv_fronted_get_wishlist', 'wp_ajax_fronted_get_wishlist_callback' );


/**
 * Product Quick View callback AJAX request 
 *
 * @since 1.0
 * @return json
 */

function wp_ajax_frontend_product_quick_view_callback() {
    check_ajax_referer( 'ajax_frontend', 'security' );
    global $product, $post;
	$product_id = intval($_POST["product_id"]);
	$post = get_post( $product_id );
	$product = wc_get_product( $product_id );
    wc_get_template( 'content-single-product-quick-view.php');
    die();
    
}
add_action( 'wp_ajax_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );
add_action( 'wp_ajax_nopriv_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );




function wp_ajax_fronted_remove_product_callback(){
    check_ajax_referer( 'ajax_frontend', 'security' );
    $item_key = $_POST['item_key'];
    $output = array();
    foreach ( WC()->cart->cart_contents as $cart_item_key => $cart_item ){
        if($cart_item_key == $item_key ){
            WC()->cart->remove_cart_item( $cart_item_key );
        }
    }
    $output['content_product'] = kt_woocommerce_get_cart(false);
    echo json_encode($output);
    die();
}
add_action( 'wp_ajax_fronted_remove_product', 'wp_ajax_fronted_remove_product_callback' );
add_action( 'wp_ajax_nopriv_fronted_remove_product', 'wp_ajax_fronted_remove_product_callback' );

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
 * Categories products callback AJAX request 
 *
 * @since 1.0
 * @return json
 */
function wp_ajax_fronted_woocategories_products_callback(){
    check_ajax_referer( 'ajax_frontend', 'security' );
    $output = array();
    
    $atts = array(
        "per_page" => $_POST['per_page'],
        "orderby" => $_POST['orderby'],
        "order" => $_POST['order'],
    );
    
    global $woocommerce_loop;
    $woocommerce_loop['columns'] = intval($_POST['columns']);
    
    $cat_id = ($_POST['cat_id']) ? $_POST['cat_id'] : 0;
    
    
    if(defined( 'YITH_WOOCOMPARE' )){
        $YITH_Woocompare_Frontend = new YITH_Woocompare_Frontend();
    }
    
    
    $meta_query = WC()->query->get_meta_query();
    $args = array(
		'posts_per_page'	=> $atts['per_page'],
		'orderby' 			=> $atts['orderby'],
		'order' 			=> $atts['order'],
		'no_found_rows' 	=> 1,
		'post_status' 		=> 'publish',
		'post_type' 		=> 'product',
		'meta_query' 		=> $meta_query,
	);
    
    if($cat_id){
        $args['tax_query'] = array( array( 'taxonomy' => 'product_cat', 'field' => 'id', 'terms' => $cat_id ) );
    }
    
    $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
    if ( $products->have_posts() ) :
        while ( $products->have_posts() ) : $products->the_post();
            ob_start();
            wc_get_template_part( 'content', 'product' );
            $output[] = ob_get_clean();
        endwhile; // end of the loop.
    endif;
    wp_reset_postdata();
    
    echo json_encode($output);
    die();
}
add_action( 'wp_ajax_fronted_woocategories_products', 'wp_ajax_fronted_woocategories_products_callback' );
add_action( 'wp_ajax_nopriv_fronted_woocategories_products', 'wp_ajax_fronted_woocategories_products_callback' );

/**
 * Product Quick View callback AJAX request 
 *
 * @since 1.0
 * @return json
 */

function wp_ajax_frontend_product_quick_view_callback() {
    check_ajax_referer( 'ajax_frontend', 'security' );
    
    global $product, $woocommerce, $post;

	$product_id = $_POST["product_id"];
	
	$post = get_post( $product_id );

	$product = wc_get_product( $product_id );
    
    // Call our template to display the product infos
    wc_get_template( 'content-single-product-quick-view.php');
    
    
    die();
    
}
add_action( 'wp_ajax_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );
add_action( 'wp_ajax_nopriv_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );



add_action( 'wp_ajax_fronted_popup', 'wp_ajax_fronted_popup_callback' );
add_action( 'wp_ajax_nopriv_fronted_popup', 'wp_ajax_fronted_popup_callback' );

function wp_ajax_fronted_popup_callback() {
    check_ajax_referer( 'ajax_frontend', 'security' );
    $output = array();
    $time_show_again = kt_option( 'time_show_again', 60 );
    setcookie('kt_popup', 1, time() + ( $time_show_again*60), '/');
    echo json_encode($output);
    
    die();
}


function wp_ajax_fronted_remove_product_callback(){
    check_ajax_referer( 'ajax_frontend', 'security' );
    $product_id = $_POST['product_id'];
    $item_key = $_POST['item_key'];
    
    global $wpdb, $woocommerce;
    $output = array();
    
    foreach ( WC()->cart->cart_contents as $cart_item_key => $cart_item ){
        if($cart_item_key == $item_key ){
            WC()->cart->remove_cart_item( $cart_item_key );
        }
    }
	
    $output['content_product'] = woocommerce_get_cart(false);
    
    echo json_encode($output);
    die();
}
add_action( 'wp_ajax_fronted_remove_product', 'wp_ajax_fronted_remove_product_callback' );
add_action( 'wp_ajax_nopriv_fronted_remove_product', 'wp_ajax_fronted_remove_product_callback' );
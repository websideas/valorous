<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


function kt_wc_loop_shop_per_page( $number ){
    $num = kt_option('loop_shop_per_page');
    $num =  intval( $num );
    if( $num <=0 ){
        $num = $number;
    }
    return $num;
}

add_filter('loop_shop_per_page', 'kt_wc_loop_shop_per_page' );



/**
 * Sale price Percentage
 */
add_filter( 'woocommerce_sale_price_html', 'woocommerce_custom_sales_price', 10, 2 );
function woocommerce_custom_sales_price( $price, $product ) {
	$percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
	return $price . sprintf( __('<span class="price-save"> %s</span>', THEME_LANG ), $percentage . '%' );
}


/**
 * Define image sizes
 */
function kt_woocommerce_image_dimensions() {
	global $pagenow;
 
	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}

  	$catalog = array('width' => '500','height' => '600', 'crop' => 1 );
    $thumbnail = array('width' => '500', 'height' => '600', 'crop' => 1 );
	$single = array( 'width' => '1000','height' => '1200', 'crop' => 1);
	
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}
add_action( 'after_switch_theme', 'kt_woocommerce_image_dimensions', 1 );


/**
 * Change placeholder for woocommerce
 * 
 */
add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');

function custom_woocommerce_placeholder_img_src( $src ) {
	return THEME_IMG . 'placeholder.png';
}


/**
 * Enable support for woocommerce after setip theme
 * 
 */
add_action( 'after_setup_theme', 'woocommerce_theme_setup' );
if ( ! function_exists( 'woocommerce_theme_setup' ) ):
    function woocommerce_theme_setup() {
        /**
    	 * Disable Woo styles (will use customized compiled copy)
    	 */ 
    	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
        
        /**
    	 * Enable support for woocommerce
    	 */
        add_theme_support( 'woocommerce' );
    }
endif;

/**
 * Woocommerce tool link in header
 * 
 * @since 1.0
 */
function woocommerce_get_tool($id = 'woocommerce-nav'){
    global $wpdb, $yith_wcwl;
    if ( kt_is_wc() ) { ?>
        <nav class="woocommerce-nav-container" id="<?php echo esc_attr($id); ?>">
            <ul class="menu">
                <?php 
                    $style_shop = $style_checkout = "none";
                    if((sizeof( WC()->cart->cart_contents) > 0)){
                        $style_checkout = "inline-block";
                    }else{
                        $style_shop = "inline-block";
                    }
                ?>
                <li class='shop-link' style="display: <?php echo esc_attr($style_shop); ?>;">
                    <?php $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>
                    <a href="<?php echo esc_url( $shop_page_url ); ?>" title="<?php _e('Shop', THEME_LANG); ?>"><?php _e('Shop', THEME_LANG); ?></a>                    
                </li>            
                <li class='my-account-link'>                        
                    <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account', THEME_LANG); ?>"><?php _e('My Account', THEME_LANG); ?></a>
                </li>
                <li class='checkout-link' style="display: <?php echo esc_attr($style_checkout); ?>;">
                    <a href="<?php echo WC()->cart->get_checkout_url(); ?>" title="<?php _e('Checkout', THEME_LANG); ?>"><?php _e('Checkout', THEME_LANG); ?></a>
                </li>                
                <?php 
                    if(class_exists('YITH_WCWL_UI')){
                        $count = array();
            	       
                		if( is_user_logged_in() ) {
                		    $count = $wpdb->get_results( $wpdb->prepare( 'SELECT COUNT(*) as `cnt` FROM `' . YITH_WCWL_ITEMS_TABLE . '` WHERE `user_id` = %d', get_current_user_id()  ), ARRAY_A );
                		    $count = $count[0]['cnt'];
                		} elseif( yith_usecookies() ) {
                		    $count[0]['cnt'] = count( yith_getcookie( 'yith_wcwl_products' ) );
                		    $count = $count[0]['cnt'];
                		} else {
                		    //$count[0]['cnt'] = count( $_SESSION['yith_wcwl_products'] );
                		    //$count = $count[0]['cnt'];
                		}
                        
                		if (is_array($count)) {
                			$count = 0;
                		}
                        echo "<li class='wishlist-link'>";
                            echo '<a href="'.$yith_wcwl->get_wishlist_url('').'">'.__("My Wishlist ", THEME_LANG).'<span>('.$count.')</span></a>';
                        echo "</li>";
                    }
                ?>
                <?php
                    if(defined( 'YITH_WOOCOMPARE' )){
                        echo "<li class='woocompare-link'>";
                        echo '<a href="#" class="yith-woocompare-open">'.__("Compare", THEME_LANG).'</a>';
                        echo "</li>";
                    }
                ?>
                <?php
            	/**
            	 * @hooked 
            	 */
            	do_action( 'woocommerce_get_tool' ); ?>
                
            </ul>
        </nav>
    <?php }
}

/**
 * Woocommerce cart in header
 * 
 * @since 1.0
 */
function woocommerce_get_cart( $wrapper = true ){
    $output = '';
    if ( kt_is_wc() ) {
        $cart_total = WC()->cart->get_cart_total();
		$cart_count = WC()->cart->cart_contents_count;
        if( $wrapper == true ){
            $output .= '<li class="mini-cart">';
        }
        $output .= '<a href="'.WC()->cart->get_cart_url().'">';
            $output .= '<span class="icon-bag"></span>';
            $output .= '<span class="mini-cart-total">'.$cart_count.'</span>';
        $output .= '</a>';
        $output .= '<div class="shopping-bag">';
        $output .= '<div class="shopping-bag-wrapper ">';
        $output .= '<div class="shopping-bag-content">';
            if ( sizeof(WC()->cart->cart_contents)>0 ) {
                $output .= '<h3 class="cart-title">'.__( 'Recently added item(s)',THEME_LANG ).'</h3>';
                $output .= '<div class="bag-products mCustomScrollbar">';
                $output .= '<div class="bag-products-content">';
                foreach (WC()->cart->cart_contents as $cart_item_key => $cart_item) {
                    $bag_product = $cart_item['data']; 
                    
                    if ($bag_product->exists() && $cart_item['quantity']>0) {
                        $output .= '<div class="bag-product clearfix">';
    					$output .= '<figure><a class="bag-product-img" href="'.get_permalink($cart_item['product_id']).'">'.$bag_product->get_image().'</a></figure>';                      
    					$output .= '<div class="bag-product-details">';
        					$output .= '<div class="bag-product-title"><a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $bag_product->get_title(), $bag_product) . '</a></div>';

                        $output .= WC()->cart->get_item_data( $cart_item );

        					$output .= '<div class="bag-product-price">'.wc_price($bag_product->get_price()).'</div>';
                            $output .= '<div class="bag-product-qty">'.__('Qty: ', THEME_LANG).$cart_item['quantity'].'</div>';
                            
    					$output .= '</div>';
    					$output .= apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="#" data-itemkey="'.$cart_item_key.'" data-id="'.$cart_item['product_id'].'" class="remove" title="%s"></a>', __('Remove this item', 'woocommerce') ), $cart_item_key );

    					$output .= '</div>';
                    }
                }
                $output .= '</div>';
                $output .= '</div>';
            }else{
               $output .=  "<p class='cart_block_no_products'>".__('Your cart is empty.', THEME_LANG)."</p>";
            }

            if ( sizeof(WC()->cart->cart_contents)>0 ) {
                $output .= '<div class="bag-total">'.__('Subtotal: ', THEME_LANG).$cart_total.'</div><!-- .bag-total -->';
                $output .= '<div class="bag-buttons clearfix">';
                    $output .= '<a href="'.esc_url( WC()->cart->get_cart_url() ).'" class="btn btn-default pull-left">'.__('View cart', THEME_LANG).'</a>';
                    $output .= '<a href="'.esc_url( WC()->cart->get_checkout_url() ).'" class="btn btn-default pull-left">'.__('Checkout', THEME_LANG).'</a>';
                $output .= '</div><!-- .bag-buttons -->';
            }
        
        $output .= '</div><!-- .shopping-bag-content -->';
        $output .= '</div><!-- .shopping-bag-wrapper -->';
        $output .= '</div><!-- .shopping-bag -->';
        if( $wrapper == true ){
            $output .= '</li>';
        }
    }
    return $output;
}




/**
 * Woocommerce replate cart in header
 * 
 */ 
function woocommerce_header_add_to_cart_fragment( $fragments ) {
    $fragments['.mini-cart'] = woocommerce_get_cart();

	return $fragments;
}
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');






/**
 * Woocommerce replace before main content and after main content
 * 
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'london_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'london_wrapper_end', 10);

function london_wrapper_start() {
  echo '<div class="content-wrapper"><div class="container wc-container">';
}

function london_wrapper_end() {
  echo '</div><!-- .container --></div>';
}

/**
 * Add checkout button to cart page
 * 
 */
add_action('woocommerce_cart_actions', 'woocommerce_button_proceed_to_checkout');

/**
 * remove WC breadcrumb
 * 
 */
// remove WC breadcrumb
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20 );


/**
 * Change columns of shop
 * 
 */

add_filter( 'loop_shop_columns', 'kt_woo_shop_columns' );
function kt_woo_shop_columns( $columns ) {
    $cols =  kt_option('shop_gird_cols');
    $cols = intval(  $cols );
    if( $cols <= 0 ){
        $layout = kt_option('shop_sidebar','full');
        if($layout == 'left' || $layout == 'right'){
            return 3;
        }else{
            return 4;
        }
    }
    return $cols ;
}


/**
 * Change layout of archive product
 * 
 */
add_filter( 'archive_product_layout', 'woocommerce_archive_product_layout' );
function woocommerce_archive_product_layout( $columns ) {
    $layout = kt_option('shop_sidebar', 'full');
    return $layout;
}

add_filter( 'woocommerce_product_loop_start', 'woocommerce_product_loop_start_callback' );
function woocommerce_product_loop_start_callback($classes){
    if(is_product_category() || is_shop() || is_product_tag()){
        $products_layout = kt_option('shop_products_layout', 'grid');
        $classes .= ' '.$products_layout;
    }
    
    $effect = kt_option('shop_products_effect', 'center');
    $classes .= ' effect-'.$effect;
    
    return $classes;
}
add_filter( 'woocommerce_gridlist_toggle', 'woocommerce_gridlist_toggle_callback' );
function woocommerce_gridlist_toggle_callback(){
    return kt_option('shop_products_layout', 'grid');
}


/**
 * Change layout of single product
 * 
 */
add_filter( 'single_product_layout', 'london_single_product_layout' );
function london_single_product_layout( $columns ) {
    $layout = kt_option('product_sidebar', 'full');
    return $layout;
}

/**
 * Change layout of carousel single product
 * 
 */
add_filter( 'woocommerce_single_product_carousel', 'woocommerce_single_product_carousel_callback' );
function woocommerce_single_product_carousel_callback( $columns ) {
    $layout = kt_option('product_sidebar', 'full');
    if($layout == 'left' || $layout == 'right'){
        return '[[992,3], [768, 3], [480, 2]]';
    }else{
        return '[[992,4], [768, 3], [480, 2]]';
    }
    
}

/**
 * Add functional-buttons for archive-product.php
 * 
 */
function woocommerce_shop_loop_item_action_action_add(){
    $count = 1;
    if(class_exists('YITH_WCWL_UI')){
        $count++;
    }
    if(defined( 'YITH_WOOCOMPARE' )){
        $count++;
    }
    
    echo "<div class='functional-buttons functional-button-".$count."'>";
    echo '<a href="#" class="product-quick-view" data-id="'.get_the_ID().'"><span></span><i class="fa fa-spinner fa-pulse"></i></a>';
    if(class_exists('YITH_WCWL_UI')){
        echo do_shortcode('[yith_wcwl_add_to_wishlist]');    
    }
    if(defined( 'YITH_WOOCOMPARE' )){
        echo do_shortcode('[yith_compare_button]');
    }
    echo "</div>";
}

/**
 * Add functional-buttons for effect bottom
 * 
 */
function woocommerce_shop_loop_item_tools_bottom_functional(){
    if(class_exists('YITH_WCWL_UI')){
        echo do_shortcode('[yith_wcwl_add_to_wishlist]');    
    }
    if(defined( 'YITH_WOOCOMPARE' )){
        echo do_shortcode('[yith_compare_button]');
    }
}


function kt_template_single_excerpt(){
    global $post;

    if ( ! $post->post_excerpt ) {
    	return;
    }
    
    ?>
    <div class="product-short-description">
    	<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
    </div>
    <?php
}

/**
 * Change hook of archive-product.php
 * 
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20);

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 12);

add_action( 'woocommerce_before_shop_loop', 'woocommerce_gridlist_toggle', 40);



remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);


add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 5);
add_action( 'woocommerce_after_shop_loop_item', 'kt_template_single_excerpt', 7);
add_action( 'woocommerce_shop_loop_item_image', 'woocommerce_template_loop_product_thumbnail', 5);

add_action( 'woocommerce_shop_loop_item_tools', 'woocommerce_template_loop_price', 10);
add_action( 'woocommerce_shop_loop_item_tools', 'woocommerce_template_loop_add_to_cart', 15);
add_action( 'woocommerce_shop_loop_item_tools', 'woocommerce_shop_loop_item_action_action_add', 20);


remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 20);

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
add_action( 'woocommerce_shop_loop_item_after_image', 'woocommerce_show_product_loop_sale_flash', 10);






$effect = kt_option('shop_products_effect', 'center');
if($effect == 'center'){
    add_action( 'woocommerce_shop_loop_item_after_image', 'woocommerce_shop_loop_item_action_action_add', 10);
    add_action( 'woocommerce_shop_loop_item_after_image', 'woocommerce_template_loop_add_to_cart', 5);    
}else{
    add_action( 'woocommerce_shop_loop_item_after_image', 'kt_woocommerce_shop_loop_item_quickview', 10);
    add_action( 'woocommerce_shop_loop_item_tools_bottom', 'woocommerce_template_loop_rating', 10);
    add_action( 'woocommerce_shop_loop_item_tools_bottom', 'woocommerce_template_loop_add_to_cart', 15);
    add_action( 'woocommerce_shop_loop_item_tools_bottom', 'woocommerce_shop_loop_item_tools_bottom_functional', 20);
    
}


function kt_woocommerce_shop_loop_item_quickview(){
    echo '<a href="#" class="product-quick-view" data-id="'.get_the_ID().'"><span>'.__('Quick view', THEME_LANG).'</span><i class="fa fa-spinner fa-pulse"></i></a>';
}



add_action( 'woocommerce_after_shop_loop_item_sale', 'woocommerce_after_shop_loop_item_sale_sale_price', 10, 2);
function woocommerce_after_shop_loop_item_sale_sale_price($product, $post){
    $sale_price_dates_to 	= ( $date = get_post_meta( $product->id, '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';
    if($sale_price_dates_to){
        echo '<div class="woocommerce-countdown clearfix" data-time="'.$sale_price_dates_to.'"></div>';
    }
}
add_action( 'woocommerce_after_shop_loop_item_sale', 'woocommerce_after_shop_loop_item_sale_rating', 20, 2);
function woocommerce_after_shop_loop_item_sale_rating($product, $post){
    echo "<div class='woocommerce-countdown-rating'>".$product->get_rating_html()."</div>"; 
}
add_action( 'woocommerce_after_shop_loop_item_sale', 'woocommerce_after_shop_loop_item_sale_short_description', 30, 2);
function woocommerce_after_shop_loop_item_sale_short_description($product, $post){
    echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );
}
function woocommerce_gridlist_toggle(){ ?>
    <?php $gridlist = apply_filters('woocommerce_gridlist_toggle', 'grid') ?>
    <ul class="gridlist-toggle hidden-xs">
        <li><span><?php _e('View as:', THEME_LANG) ?></span></li>
		<li>
			<a <?php if($gridlist == 'lists'){ ?>class="active"<?php } ?> href="#" title="<?php _e('List view', THEME_LANG) ?>" data-layout="lists" data-remove="grid"><i class="fa fa-th-list"></i></a>
		</li>
		<li>
			<a <?php if($gridlist == 'grid'){ ?>class="active"<?php } ?> href="#" title="<?php _e('Grid view', THEME_LANG) ?>" data-layout="grid" data-remove="lists"><i class="fa fa-th-large"></i></a>
		</li>
	</ul>
<?php }
/**
 * Change hook of single-product.php
 * 
 */



remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10, 0);
add_action( 'woocommerce_after_single_product_content', 'woocommerce_output_product_data_tabs', 10, 0);

add_filter('woocommerce_product_description_heading', 'london_woocommerce_product_description_heading');
function london_woocommerce_product_description_heading(){
    return "";
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40, 0);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15);

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10, 0);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 17, 0);



if(defined( 'YITH_WOOCOMPARE' )){
    global $yith_woocompare;
    remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
}

add_filter('yith_wcwl_positions', 'yith_wcwl_positions_callback');
function yith_wcwl_positions_callback($positions){
    unset($positions['add-to-cart']);
    return $positions;
}


function woocommerce_shop_loop_item_action_action_product(){
    if(class_exists('YITH_WCWL_UI') || defined( 'YITH_WOOCOMPARE' )){
        echo "<div class='functional-buttons-product clearfix'>";
        echo "<div class='functional-buttons'>";
        if(class_exists('YITH_WCWL_UI')){
            echo do_shortcode('[yith_wcwl_add_to_wishlist]');    
        }
        if(defined( 'YITH_WOOCOMPARE' )){
            echo do_shortcode('[yith_compare_button]');
        }
        echo "</div>";
        echo "</div>";
    }
}
add_action( 'woocommerce_after_add_to_cart_button', 'woocommerce_shop_loop_item_action_action_product', 50);


function custom_stock_totals($availability_html, $availability_text, $variation) {
    $availability         = $variation->get_availability();
	$availability_html = '<p class="stock ' . esc_attr( $availability['class'] ) . '"><span>' . esc_html( $availability_text ) . '</span></p>';
	return 	$availability_html;
}
add_filter('woocommerce_stock_html', 'custom_stock_totals', 20, 3);


/**
 * Add share product 
 *
 * @since 1.0
 */
add_action( 'woocommerce_single_product_summary', 'theme_share_product_add_share', 50 );
function theme_share_product_add_share(){ 
    global $post;
    $addthis_id = kt_option('addthis_id');
    ?>
    <div class="clearfix"></div>
    <div class="product-details-share clearfix">
        <ul class="share clearfix">
            <li><a href="javascript:print();"><i class="fa fa-print"></i> <?php _e('Print', THEME_LANG ); ?></a></li>
            <li><a href="mailto:?subject=<?php echo urlencode(get_the_title($post->ID)); ?>&amp;body=<?php echo urlencode(get_permalink($post->ID)); ?>"><i class="fa fa-envelope-o"></i> <?php _e('Send to a friend', THEME_LANG ); ?></a></li>
        </ul>
        <?php if($addthis_id){ ?>
            <div class="addthis_native_toolbox"></div>
        <?php } ?>
    </div><?php
}



/* cart hooks */
add_action('woocommerce_before_cart_table', 'kt_woocommerce_before_cart_table', 20);
function kt_woocommerce_before_cart_table( $args )
{
	global $woocommerce;

	//$html = '<h3 class="page-title">' . sprintf( __( 'Shopping Cart', THEME_LANG ), $woocommerce->cart->cart_contents_count ) . '</h3><div class="term-description"><p>'.__( 'Great products are not only aesthetically pleasing but also easy to use',THEME_LANG ).'<p></div>';
    $html = '<p>'. sprintf( __( 'Your shopping cart contains: %d products', THEME_LANG ), $woocommerce->cart->cart_contents_count ) . '</p>';
    
	echo $html;
}



if ( ! function_exists( 'woocommerce_content' ) ) {

    /**
     * Output WooCommerce content.
     *
     * This function is only used in the optional 'woocommerce.php' template
     * which people can add to their themes to add basic woocommerce support
     * without hooks or modifying core templates.
     *
     */
    function woocommerce_content() {

        if ( is_singular( 'product' ) ) {

            while ( have_posts() ) : the_post();

                wc_get_template_part( 'content', 'single-product' );

            endwhile;

        } else { ?>

            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

                <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

            <?php endif; ?>
            <?php do_action( 'woocommerce_archive_description' ); ?>

            <?php if ( have_posts() ) : ?>

                <?php do_action('woocommerce_before_shop_loop'); ?>

                <?php woocommerce_product_loop_start(); ?>

                <?php woocommerce_product_subcategories(); ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>

                <?php do_action('woocommerce_after_shop_loop'); ?>

            <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

                <?php wc_get_template( 'loop/no-products-found.php' ); ?>

            <?php endif;

        }
    }
}


if( file_exists( FW_DIR . 'plugins/yith-woocommerce-compare/class.yith-woocompare-frontend.php' ) ){
    require_once ( FW_DIR . 'plugins/yith-woocommerce-compare/class.yith-woocompare-frontend.php' );
}
if( file_exists( FW_DIR . 'plugins/yith-woocommerce-compare/class.yith-woocompare-frontend.php' ) ){
    require_once ( FW_DIR . 'plugins/yith-woocommerce-compare/class.yith-woocompare-frontend.php' );
}


/**
 * Support Plugin: WooCommerce Variation Swatches and Photos
 * Plugin URI: http://woothemes.com/woocommerce/
 */

if( class_exists('WC_Swatch_Picker') ){

    class KT_WC_Swatch_Picker {

        private $size;
        private $attributes;
        private $selected_attributes;
        private $swatch_type_options;

        public function __construct( $product_id, $attributes, $selected_attributes ) {
            $this->swatch_type_options = maybe_unserialize( get_post_meta( $product_id, '_swatch_type_options', true ) );

            if ( !$this->swatch_type_options ) {
                $this->swatch_type_options = array();
            }

            $product_configured_size = get_post_meta( $product_id, '_swatch_size', true );
            if ( !$product_configured_size ) {
                $this->size = 'swatches_image_size';
            } else {
                $this->size = $product_configured_size;
            }

            $this->attributes = $attributes;
            $this->selected_attributes = $selected_attributes;
        }

        public function picker() {
            ?>

            <table class="variations-table" >
                <tbody>
                <?php
                $loop = 0;
                foreach ( $this->attributes as $name => $options ) : $loop++;
                    $st_name = sanitize_title( $name );
                    $hashed_name = md5( $st_name );
                    $lookup_name = '';
                    if ( isset( $this->swatch_type_options[$hashed_name] ) ) {
                        $lookup_name = $hashed_name;
                    } elseif ( isset( $this->swatch_type_options[$st_name] ) ) {
                        $lookup_name = $st_name;
                    }
                    ?>
                    <tr>
                        <td>
                            <div class="label-wrap">
                                <label for="<?php echo $st_name; ?>"><?php echo WC_Swatches_Compatibility::wc_attribute_label( $name ); ?></label>
                            </div>
                            <?php
                            if ( isset( $this->swatch_type_options[$lookup_name] ) ) {
                                $picker_type = $this->swatch_type_options[$lookup_name]['type'];
                                if ( $picker_type == 'default' ) {
                                    $this->render_default( $st_name, $options );
                                } else {
                                    $this->render_picker( $st_name, $options, $name );
                                }
                            } else {
                                $this->render_default( $st_name, $options );
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php
        }

        public function render_picker( $name, $options, $real_name = '' ) {
            $st_name = sanitize_title( $name );
            $hashed_name = md5( $st_name );

            $lookup_name = '';
            if ( isset( $this->swatch_type_options[$hashed_name] ) ) {
                $lookup_name = $hashed_name;
            } elseif ( isset( $this->swatch_type_options[$st_name] ) ) {
                $lookup_name = $st_name;
            }

            $taxonomy_lookup_name = taxonomy_exists( $st_name ) ? $st_name : (taxonomy_exists( $real_name ) ? $real_name : $st_name);
            $selected_value = (isset( $this->selected_attributes[$lookup_name] )) ? $this->selected_attributes[$lookup_name] : '';
            ?>

            <?php $layout = apply_filters( 'wc_swatches_and_photos_label_get_layout', (isset( $this->swatch_type_options[$lookup_name]['layout'] ) ? $this->swatch_type_options[$lookup_name]['layout'] : 'default' ), $name, $options, $this ); ?>

            <?php if ( $layout == 'label_above' ) : ?>
                <?php // $this->render_picker_label_layout( $layout, $name, $options ); ?>
            <?php endif; ?>

            <?php do_action( 'wc_swatches_and_photos_label_before', $layout, $name, $options, $this ); ?>

            <div
                data-attribute-name="<?php echo 'attribute_' . $st_name; ?>"
                data-value="<?php echo !empty($selected_value) ? md5( $selected_value ) : ''; ?>"
                id="<?php echo esc_attr( $st_name ); ?>"
                class="select attribute_<?php echo $st_name; ?>_picker">

                <input type="hidden" name="<?php echo 'attribute_' . $st_name; ?>" id="<?php echo 'attribute_' . $st_name; ?>" value="<?php echo $selected_value; ?>" />

                <?php if ( is_array( $options ) ) : ?>
                    <?php
                    // Get terms if this is a taxonomy - ordered
                    if ( taxonomy_exists( $taxonomy_lookup_name ) ) :
                        $args = array('menu_order' => 'ASC');
                        $terms = get_terms( $taxonomy_lookup_name, $args );

                        foreach ( $terms as $term ) :

                            if ( !in_array( $term->slug, $options ) ) {
                                continue;
                            }


                            if ( $this->swatch_type_options[$lookup_name]['type'] == 'term_options' ) {
                                $size = apply_filters( 'woocommerce_swatches_size_for_product', $this->size, get_the_ID(), $st_name );
                                $swatch_term = new WC_Swatch_Term( 'swatches_id', $term->term_id, $taxonomy_lookup_name, $selected_value == $term->slug, $size );
                            } elseif ( $this->swatch_type_options[$lookup_name]['type'] == 'product_custom' ) {
                                $size = apply_filters( 'woocommerce_swatches_size_for_product', $this->swatch_type_options[$lookup_name]['size'], get_the_ID(), $st_name );
                                $swatch_term = new WC_Product_Swatch_Term( $this->swatch_type_options[$lookup_name], $term->term_id, $taxonomy_lookup_name, $selected_value == $term->slug, $size );
                            }


                            do_action( 'woocommerce_swatches_before_picker_item', $swatch_term );
                            echo $swatch_term->get_output();
                            do_action( 'woocommerce_swatches_after_picker_item', $swatch_term );

                        endforeach;
                    else :
                        foreach ( $options as $option ) :

                            $size = apply_filters( 'woocommerce_swatches_size_for_product', $this->swatch_type_options[$lookup_name]['size'], get_the_ID(), $st_name );
                            $swatch_term = new WC_Product_Swatch_Term( $this->swatch_type_options[$lookup_name], $option, $name, $selected_value == sanitize_title( $option ), $size );

                            do_action( 'woocommerce_swatches_before_picker_item', $swatch_term );
                            echo $swatch_term->get_output();
                            do_action( 'woocommerce_swatches_after_picker_item', $swatch_term );
                        endforeach;
                    endif;
                    ?>
                <?php endif; ?>
            </div>
        <?php
        }

        public function render_default( $name, $options ) {
            $st_name = sanitize_title( $name );
            $hashed_name = md5( $st_name );
            $selected_value = '';

            $lookup_name = '';
            if ( isset( $this->swatch_type_options[$hashed_name] ) ) {
                $lookup_name = $hashed_name;
            } elseif ( isset( $this->swatch_type_options[$st_name] ) ) {
                $lookup_name = $st_name;
            }

            ?>
            <select
                data-attribute-name="<?php echo 'attribute_' . $st_name; ?>"
                id="<?php echo esc_attr( $st_name ); ?>">
                <option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
                <?php if ( is_array( $options ) ) : ?>
                    <?php
                    $selected_value = (isset( $this->selected_attributes[$lookup_name] )) ? $this->selected_attributes[$lookup_name] : '';
                    // Get terms if this is a taxonomy - ordered
                    if ( taxonomy_exists( $st_name ) ) :
                        $args = array('menu_order' => 'ASC');
                        $terms = get_terms( $st_name, $args );

                        foreach ( $terms as $term ) :

                            if ( !in_array( $term->slug, $options ) ) {
                                continue;
                            }

                            echo '<option value="' . esc_attr( md5( $term->slug ) ) . '" ' . selected( $selected_value, $term->slug ) . '>' . $term->name . '</option>';
                        endforeach;
                    else :
                        foreach ( $options as $option ) :
                            echo '<option value="' . md5( sanitize_title( $option ) ) . '" ' . selected( $selected_value, sanitize_title( $option ) ) . '>' . $option . '</option>';
                        endforeach;
                    endif;
                    ?>
                <?php endif; ?>
            </select>
            <input type="hidden" name="<?php echo 'attribute_' . $st_name; ?>" id="<?php echo 'attribute_' . $st_name; ?>" value="<?php echo $selected_value; ?>" />
        <?php
        }

        public function render_picker_label_layout( $layout, $name, $options ) {
            $st_name = sanitize_title( $name );
            ?>

            <div
                id="<?php echo esc_attr( $st_name ); ?>_label"
                class="attribute_<?php echo $st_name; ?>_picker_label">
                &nbsp;
            </div>

        <?php
        }

    }

} // end if


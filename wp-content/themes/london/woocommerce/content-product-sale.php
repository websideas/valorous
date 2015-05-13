<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $post;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

// Bootstrap Column
$bootstrapColumn = round( 12 / $woocommerce_loop['columns'] );
$classes[] = 'col-xs-12 col-sm-'. $bootstrapColumn .' col-md-' . $bootstrapColumn;

?>
<li <?php post_class( $classes ); ?>>
    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
    <div class="product-item-container clearfix">
        <div class="row">
            <div class="col-md-6 col-sm-6 sales-countdown-left">
                <div class="product-image-container">
                    <div class="product-image-content">
                        <?php 
                            $attachment_ids = $product->get_gallery_attachment_ids();
                            $attachment = '';
                            if($attachment_ids){	
                            	foreach ( $attachment_ids as $attachment_id ) {
                            	    $image_link = wp_get_attachment_url( $attachment_id );
                                    if ( $image_link ){
                                        $attachment = wp_get_attachment_image( $attachment_id, 'shop_catalog', false, array('class'=>"second-img product-img"));
                                        break;    
                                    }
                            	}
                            }
                        ?>
                    
                        <a href="<?php the_permalink(); ?>" class="product-thumbnail <?php if($attachment) echo "product-thumbnail-effect"; ?>">
                            <?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog', array('class'=>"first-img product-img")) ?>
                            <?php echo $attachment; ?>
                        </a>
                        <?php
                			/**
                			 * woocommerce_before_shop_loop_item_title hook
                			 *
                			 * @hooked woocommerce_template_loop_add_to_cart - 5
                			 * @hooked woocommerce_show_product_loop_sale_flash - 10
                             * @hooked woocommerce_shop_loop_item_action_action_add - 15
                			 */
                			do_action( 'woocommerce_shop_loop_item_after_image' );
                		?>
                    </div><!-- .product-image-content -->
                </div><!-- .product-image-container -->
            </div><!-- .sales-countdown-left -->
            <div class="col-md-6 col-sm-6 sales-countdown-right">
                <h5>
                	<a href="<?php the_permalink(); ?>">
                
                		<?php
                			/**
                			 * woocommerce_before_shop_loop_item_title hook
                			 */
                			do_action( 'woocommerce_before_shop_loop_item_title' );
                		?>
                
                		<?php the_title(); ?>
                
                		<?php
                			/**
                			 * woocommerce_after_shop_loop_item_title hook
                			 *
                			 */
                			do_action( 'woocommerce_after_shop_loop_item_title' );
                		?>
                
                	</a>
                </h5>
                
            	<?php
            
            		/**
            		 * woocommerce_after_shop_loop_item hook
            		 *
            		 * @hooked woocommerce_template_loop_price - 10
            		 */
            		do_action( 'woocommerce_after_shop_loop_item' ); 
            
            	?>
                
                <?php
            
            		/**
            		 * woocommerce_after_shop_loop_item hook
            		 * @hooked woocommerce_after_shop_loop_item_sale_sale_price - 10
                     * @hooked woocommerce_after_shop_loop_item_sale_rating - 20
            		 * @hooked woocommerce_after_shop_loop_item_sale_short_description - 30
            		 */
            		do_action( 'woocommerce_after_shop_loop_item_sale',  $product, $post); 
            
            	?>
                
                <div class="product-item-tools-bottom">
                    <?php
                		/**
                		 * woocommerce_shop_loop_item_tools_bottom hook
                		 *
                		 * @hooked woocommerce_template_loop_rating - 10
                		 */
                		do_action( 'woocommerce_shop_loop_item_tools_bottom' ); 
                	?>
                </div>
                
             </div><!-- .sales-countdown-right -->
        </div><!-- .row -->
    </div><!-- .product-item-container -->
</li>

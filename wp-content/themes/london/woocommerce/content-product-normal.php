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

global $product, $woocommerce_loop;

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
$classes = array('product');
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

// Bootstrap Column
$bootstrapColumn = round( 12 / $woocommerce_loop['columns'] );
$classes[] = 'col-xs-12 col-sm-'. $bootstrapColumn .' col-md-' . $bootstrapColumn;

$classes[] = 'content-product-normal';

?>
<li <?php post_class($classes); ?>>
    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
    <a href="<?php the_permalink(); ?>" class="product-thumbnail <?php if($attachment) echo "product-thumbnail-effect"; ?>">
        <?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog', array('class'=>"first-img product-img")) ?>
    </a>
    
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

</li>

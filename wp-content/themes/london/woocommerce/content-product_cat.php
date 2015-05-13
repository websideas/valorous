<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Increase loop count
$woocommerce_loop['loop']++;

// Bootstrap Column
$bootstrapColumn = round( 12 / $woocommerce_loop['columns'] );
$classes = 'col-xs-12 col-sm-'. $bootstrapColumn .' col-md-' . $bootstrapColumn;

?>
<li class="product-category product<?php
    if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 )
        echo ' first';
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo ' last';
	?> <?php echo $classes; ?>">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
    <div class="product-image-container">
    	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
    
    		<?php
    			/**
    			 * woocommerce_before_subcategory_title hook
    			 *
    			 * @hooked woocommerce_subcategory_thumbnail - 10
    			 */
    			do_action( 'woocommerce_before_subcategory_title', $category );
    		?>
    
    		<?php
    			/**
    			 * woocommerce_after_subcategory_title hook
    			 */
    			do_action( 'woocommerce_after_subcategory_title', $category );
    		?>
    
    	</a>
    </div>
    
    <h5>
		<?php
			echo $category->name;

			if ( $category->count > 0 )
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
		?>
	</h5>
    
	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</li>

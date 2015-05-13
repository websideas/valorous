<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', 12 ),
	'orderby'             => $orderby,
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', 1 );
$woocommerce_loop['columns_tablet'] = apply_filters( 'woocommerce_cross_sells_columns_tablet', 1 );

if ( $products->have_posts() ) : ?>
	<div class="cross-sells-products carousel-wrapper-top clearfix col-md-12 col-sm-12 col-xs-12">
        <div class="block-heading">
            <h2><?php _e( 'You may be interested in&hellip;', 'woocommerce' ) ?></h2>
        </div>
        <div class="woocommerce-carousel-wrapper" data-theme="style-navigation-top" data-itemscustom="<?php echo apply_filters( 'woocommerce_single_product_cross_sells_carousel', '[[992,4], [768, 2], [480, 1]]'); ?>">
		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>
        </div><!-- .woocommerce-carousel-wrapper -->
	</div><!-- .cross-sells-products -->

<?php endif;

wp_reset_query();

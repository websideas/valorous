<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<ul class="cart_list product_list_widget <?php echo $args['list_class']; ?>">

	<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					?>
					<li class="clearfix">
						<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s"></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key ); ?>
                        <div class="product-thumbnail">
    						<?php if ( ! $_product->is_visible() ) : ?>
    							<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ?>
    						<?php else : ?>
    							<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
    								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ?>
    							</a>
    						<?php endif; ?>
                        </div>
                        <div class="product-information">
                            <a href="product-title"><?php echo $product_name; ?></a>
    						<?php echo WC()->cart->get_item_data( $cart_item ); ?>
    						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                        </div>
					</li>
					<?php
				}
			}
		?>

	<?php else : ?>

		<li class="empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></li>

	<?php endif; ?>

</ul><!-- end product list -->

<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

	<p class="total"><strong><?php _e( 'Subtotal', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
    <?php $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) ); ?>
	<div class="buttons row">
        <div class="col-md-6"><a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button wc-forward"><?php _e( 'View Cart', 'woocommerce' ); ?></a></div>
        <div class="col-md-6"><a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button checkout wc-forward"><?php _e( 'Checkout', 'woocommerce' ); ?></a></div>
	</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>

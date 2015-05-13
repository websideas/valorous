<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();
$attachment_count   = count( $attachment_ids );

if ( $attachment_ids ) {
	?>
    <div class="single-product-main-thumbnails owl-carousel <?php if($attachment_count < 4){ echo " no-padding";} ?>" id="sync2">
    	<?php
    		if ( has_post_thumbnail() ) {
    
    			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
    			$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
    			$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
    			$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_catalog' ), array(
    				'title'	=> $image_title,
    				'alt'	=> $image_title
    				) );

    			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" title="%s">%s</a>', $image_link, $image_caption, $image ), $post->ID );
                
                // Display Attachment Images as well
    			if( $attachment_count > 0 ) :
    
    				// Loop in attachment	
    				foreach ( $attachment_ids as $attachment_id ) {
    					
    					// Get attachment image URL
    					$image_link = wp_get_attachment_url( $attachment_id );
    
    					$image_title = esc_attr( get_the_title( $attachment_id ) );
    					
    					// If isn't a URL we go to next attachment
    					if ( !$image_link )
    						continue;
    
    					$image = wp_get_attachment_image( $attachment_id, 'shop_catalog', array(
    						'data-zoom-image' => $image_link
    						) );
    
    					//var_dump($image);
    					
    					// Display other items
    					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" title="%s">%s</a>', $image_link, $image_title, $image ), $post->ID );
    				}
    
    			endif;
    
    		}
    	?>
    </div><!-- #sync2.single-product-main-thumbnails.owl-carousel -->
	<?php
}
?>
<?php
/**
 * @hooked 
 */
do_action( 'theme_share_product' ); ?>
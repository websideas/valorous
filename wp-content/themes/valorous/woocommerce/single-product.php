<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$layout = apply_filters( 'single_product_layout', 'full' );

echo $layout;

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>  
        <?php if($layout == 'left' || $layout == 'right'){  ?>
            <div class="row <?php echo $layout; ?>">
                <?php $class = ($layout == 'left') ? 'pull-right' : '' ?>
                <div id="main" class="col-md-9 col-xs-12 <?php echo $class; ?>">
        <?php } ?>
        
		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>
        
        <?php if($layout == 'left' || $layout == 'right'){  ?>
                </div><!-- .col-md-9.pull-right -->
        <?php } ?>
        
        <?php
            if($layout !='full'){
        		/**
        		 * woocommerce_sidebar hook
        		 *
        		 * @hooked woocommerce_get_sidebar - 10
        		 */
        		do_action( 'woocommerce_sidebar' );
            }
        	?>
         <?php if($layout == 'left' || $layout == 'right'){  ?>
            </div><!-- .col-md-9.pull-right -->
        <?php } ?>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	

<?php get_footer( 'shop' ); ?>

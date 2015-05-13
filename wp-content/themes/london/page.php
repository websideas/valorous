<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage London
 * @since London 1.0
 */

$sidebar = kt_sidebar();

get_header(); ?>
    <div class="container">
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_before_main' );

        the_post();
        ?>
        <div class="row">    
            <div id="main" class="<?php echo apply_filters('kt_main_class', 'main-class', $sidebar['sidebar']); ?>">
                <?php 
                if( rwmb_meta('_kt_show_title') || rwmb_meta('_kt_show_title') == '' ){
                ?>
                <h1 class="page-title"><?php the_title(); ?></h1>
                <?php
                    if( rwmb_meta('_kt_show_taglitle') ){
                        $tagline =  rwmb_meta('_kt_tagline');
                        if( $tagline !='' ){ ?>
                            <div class="term-description"><p><?php echo esc_html( $tagline ); ?></p></div>
                        <?php }
                    }
                } ?>
                <div class="clear"></div><?php
                // Include the page content template.
                get_template_part( 'content', 'page' );
            	?>
            </div>
            <?php if($sidebar['sidebar'] != 'full'){ ?>
                <div class="<?php echo apply_filters('kt_sidebar_class', 'sidebar', $sidebar['sidebar']); ?>">
                    <?php dynamic_sidebar($sidebar['sidebar_area']); ?>
                </div><!-- .sidebar -->
            <?php } ?>
        </div><!-- .row -->
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_after_main' ); ?>
    </div><!-- .container -->
<?php get_footer(); ?>
<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<div class="container">
    <div id="header-inner">
        <div id="header-wrap" class="display-table">
            <div class="site-branding display-td">
                <?php get_template_part( 'templates/headers/header',  'branding'); ?>
            </div><!-- .site-branding -->
            <div class="display-td header-content-right">
                <div class="header-content-top clearfix">
                    <?php echo woocommerce_get_cart(); ?>
                    <?php woocommerce_get_tool();?>
                </div><!-- .header-content-top -->
                <div class="header-content-bottom clearfix">
                    <?php
                        if ( has_nav_menu( 'primary' ) ) {  
                            wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'container_id' => 'main-nav', 'walker' => new KTMegaWalker(), 'items_wrap' => kt_nav_wrap() ) );
                        }
                    ?>
                    <?php kt_search_form(); ?>
                </div><!-- .header-content-bottom -->
            </div><!-- .header-content -->
        </div><!-- #header-wrap -->
        <div id="mobile-content-all">
            <?php kt_search_form(); ?>
            <?php get_template_part( 'templates/headers/header', 'mobile'); ?>
        </div>
    </div>
</div><!-- .container -->
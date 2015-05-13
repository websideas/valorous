<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>

<div class="container">
    <div class="display-table" id="header-wrap">
        <div class="site-branding display-td">
            <?php get_template_part( 'templates/headers/header',  'branding'); ?>
        </div><!-- .site-branding -->
        <div class="display-td header-content-right">
            <div class="header-content-top clearfix">
                <?php
                    if ( has_nav_menu( 'top' ) ) { 
                        wp_nav_menu( array( 'theme_location' => 'top', 'container' => 'nav', 'container_id' => 'top-nav' ) );
                    } 
                ?>
                <?php woocommerce_get_tool(); ?>
                <div class="clearfix"></div>
                <?php get_template_part( 'templates/headers/header',  'contact'); ?>
                <?php echo woocommerce_get_cart(); ?>
            </div>
        </div>
    </div>
</div>
<div class="header-content-bottom">
    <div class="container">
        <div id="header-inner" class="clearfix">
            <?php
                if ( has_nav_menu( 'primary' ) ) {  
                    wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'container_id' => 'main-nav', 'walker' => new KTMegaWalker(),'items_wrap' => kt_nav_wrap() ) );
                }
            ?>
            <?php kt_search_form(); ?>
            <?php get_template_part( 'templates/headers/header', 'mobile'); ?>
        </div>
    </div>
</div><!-- .header-content-bottom -->
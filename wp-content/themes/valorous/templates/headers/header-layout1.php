<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<!--<div class="container">-->
    <div id="header-inner" class="clearfix">
        <div class="site-branding">
            <?php get_template_part( 'templates/headers/header',  'branding'); ?>
        </div><!-- .site-branding -->
        <nav role="navigation" id="nav">

            <ul id="main-nav-tool">
                <?php if ( kt_is_wc() && kt_option('header_cart', 1) ) { ?>
                <?php echo woocommerce_get_cart(); ?>
                <?php } ?>
                <?php if ( kt_option('header_search', 1) ) { ?>
                <li class="mini-search">
                    <a href="#"><span class="icon-magnifier"></span></a>
                </li>
                <?php } ?>
            </ul>

            <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container' => '',
                        'menu_id'         => 'main-navigation',
                        'menu_class' => 'hidden-mobile',
                        'walker' => new KTMegaWalker(),
                        //'items_wrap' => kt_nav_wrap() )
                    ) );
                }else{
                    printf(
                        '<ul><li><a href="#">%s</a></li></ul>',
                        __("No menu assigned!", THEME_LANG)
                    );
                }
            ?>
        </nav><!-- #main-nav -->
        <div id="mobile-content-all">
            <?php kt_search_form(); ?>
            <?php get_template_part( 'templates/headers/header', 'mobile'); ?>
        </div>
    </div>
<!--</div><!-- .container -->
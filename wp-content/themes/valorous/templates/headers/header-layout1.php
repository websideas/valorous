<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<div id="header-inner" class="clearfix">
    <div class="site-branding">
        <?php get_template_part( 'templates/headers/header',  'branding'); ?>
    </div><!-- .site-branding -->
    <nav role="navigation" id="nav">
        <?php get_template_part( 'templates/headers/header',  'tool'); ?>
        <?php get_template_part( 'templates/headers/header',  'menu'); ?>
        <?php get_template_part( 'templates/headers/header',  'mobile'); ?>
    </nav><!-- #main-nav -->
</div>
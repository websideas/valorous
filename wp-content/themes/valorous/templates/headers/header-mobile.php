<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<div id="header-content-mobile" class="visible-xs-block visible-sm-block">
    <?php if ( kt_is_wc() && kt_option('header_cart', 1) ) { ?>
        <?php echo kt_woocommerce_get_cart_mobile(); ?>
    <?php } ?>
    <!--
    <?php if ( kt_option('header_search', 1) ) { ?>
        <a href="#" class="mobile-search"><span class="icon-magnifier"></span></a>
    <?php } ?>
    -->
    <a href="#" class="mobile-nav-bar">
        <span class="mobile-nav-handle"><span></span></span>
    </a>
</div>
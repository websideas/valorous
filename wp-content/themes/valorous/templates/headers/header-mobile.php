<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<div id="header-content-mobile" class="visible-xs-block visible-sm-block">
    <?php if ( kt_is_wc() && kt_option('header_cart', 1) ) { ?>
        <a href="<?php echo WC()->cart->get_cart_url(); ?>" class="mobile-cart">
            <span class="icon-bag"></span>
            <span class="mini-cart-total">10</span>
        </a>
    <?php } ?>
    <a href="#" class="mobile-nav-bar">
        <span class="mobile-nav-handle"><span></span></span>
    </a>
</div>
<ul id="main-nav-tool">
    <?php if ( kt_is_wc() && kt_option('header_cart', 1) ) { ?>
        <?php echo woocommerce_get_cart(); ?>
    <?php } ?>
    <?php if ( kt_option('header_search', 1) ) { ?>
        <li class="mini-search hidden-xs hidden-sm">
            <a href="#"><span class="icon-magnifier"></span></a>
        </li>
    <?php } ?>
    <li class="mini-mobile-nav visible-xs-inline-block visible-sm-inline-block" >
        <a href="#" class="mobile-nav-bar"><span class="mobile-nav-handle"><span></span></span></a>
    </li>

</ul>
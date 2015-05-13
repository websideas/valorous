<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$copyright = kt_option('footer_copyright');
if($copyright){
    echo sprintf('<div class="footer-copyright">%s</div>', do_shortcode(kt_option('footer_copyright')));
}
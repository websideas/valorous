<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$footer_socials = kt_option('footer_socials');

echo do_shortcode('[kt_social type="'.$footer_socials.'"]');
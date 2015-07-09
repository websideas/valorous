<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$footer_socials = kt_option('footer_socials');

echo do_shortcode('[socials social="'.$footer_socials.'" size="small" style="classic"]');
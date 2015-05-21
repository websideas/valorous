<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



add_action( 'vc_after_init', 'add_cta_button_super_color' );
function add_cta_button_super_color() {


    // VC_icon: Add hexagonal
    $background_style = WPBMap::getParam( 'vc_icon', 'background_style' );
    $background_style['value'][__( 'Diamond Square', THEME_LANG )] = 'diamond_square';
    $background_style['value'][__( 'Hexagonal', THEME_LANG )] = 'hexagonal';
    vc_update_shortcode_param( 'vc_icon', $background_style );


    // VC_icon: Add hexagonal
    $background_color = WPBMap::getParam( 'vc_icon', 'background_color' );
    $background_color['value'][__( 'Custom color', 'js_composer' )] = 'custom';
    vc_update_shortcode_param( 'vc_icon', $background_color );




}
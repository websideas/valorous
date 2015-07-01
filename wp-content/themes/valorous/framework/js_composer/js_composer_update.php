<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



add_action( 'vc_after_init', 'add_option_to_vc_icon' );
function add_option_to_vc_icon() {

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



add_filter('vc_google_fonts_get_fonts_filter', 'kt_add_fonts_vc');
function kt_add_fonts_vc($fonts_list){

    $font = (object) array(
        'font_family' => 'Cabin',
        'font_styles' => 'regular,italic,700,700italic',
        'font_types' => '400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic'
    );
    $fonts_list[] = $font;


    return $fonts_list;
}
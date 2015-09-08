<?php
/*
Plugin Name:  Valorous Custom Post
Plugin URI:   http://kitethemes.com/
Description:  Theme Valorous Custom Post
Version:      1.1
Author:       KiteThemes
Author URI:   http://kitethemes.com/

Copyright (C) 2014-2015, by Cuongdv
All rights reserved.
*/


add_action( 'init', 'register_kt_client_init' );
function register_kt_client_init(){
    $labels = array( 
        'name' => __( 'Client', THEME_LANG),
        'singular_name' => __( 'Client', THEME_LANG),
        'add_new' => __( 'Add New', THEME_LANG),
        'all_items' => __( 'All Clients', THEME_LANG),
        'add_new_item' => __( 'Add New Client', THEME_LANG),
        'edit_item' => __( 'Edit Client', THEME_LANG),
        'new_item' => __( 'New Client', THEME_LANG),
        'view_item' => __( 'View Client', THEME_LANG),
        'search_items' => __( 'Search Client', THEME_LANG),
        'not_found' => __( 'No Client found', THEME_LANG),
        'not_found_in_trash' => __( 'No Client found in Trash', THEME_LANG),
        'parent_item_colon' => __( 'Parent Client', THEME_LANG),
        'menu_name' => __( 'Clients', THEME_LANG)
    );
    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'supports' 	=> array('title', 'thumbnail'),
    );
    register_post_type( 'kt_client', $args );
    
    register_taxonomy('client-category',array('kt_client'), array(
        "label" 						=> __("Client Categories", THEME_LANG),
        "singular_label" 				=> __("Client Category", THEME_LANG),
        'public'                        => false,
        'hierarchical'                  => true,
        'show_ui'                       => true,
        'show_in_nav_menus'             => false,
        'args'                          => array( 'orderby' => 'term_order' ),
        'rewrite'                       => false,
        'query_var'                     => true,
        'show_admin_column'             => true
    ));
}


add_action( 'init', 'register_kt_testimonial_init' );
function register_kt_testimonial_init(){
    $labels = array(
        'name' => __( 'Testimonial', THEME_LANG),
        'singular_name' => __( 'Testimonial', THEME_LANG),
        'add_new' => __( 'Add New', THEME_LANG),
        'all_items' => __( 'Testimonials', THEME_LANG),
        'add_new_item' => __( 'Add New testimonial', THEME_LANG),
        'edit_item' => __( 'Edit testimonial', THEME_LANG),
        'new_item' => __( 'New testimonial', THEME_LANG),
        'view_item' => __( 'View testimonial', THEME_LANG),
        'search_items' => __( 'Search testimonial', THEME_LANG),
        'not_found' => __( 'No testimonial found', THEME_LANG),
        'not_found_in_trash' => __( 'No testimonial found in Trash', THEME_LANG),
        'parent_item_colon' => __( 'Parent testimonial', THEME_LANG),
        'menu_name' => __( 'Testimonials', THEME_LANG)
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'supports' 	=> array('title', 'editor', 'thumbnail'),
    );
    register_post_type( 'kt_testimonial', $args );
    
    register_taxonomy('testimonial-category',array('kt_testimonial'), array(
        "label" 						=> __("Testimonial Categories", THEME_LANG), 
        "singular_label" 				=> __("Testimonial Category", THEME_LANG), 
        'public'                        => false,
        'hierarchical'                  => true,
        'show_ui'                       => true,
        'show_in_nav_menus'             => false,
        'args'                          => array( 'orderby' => 'term_order' ),
        'rewrite'                       => false,
        'query_var'                     => true,
        'show_admin_column'             => true
    ));
}
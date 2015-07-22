<?php
/**
 * http://websideas.com
 *              ___.          .__    .___                    
 *__  _  __ ____\_ |__   _____|__| __| _/____ _____    ______
 *\ \/ \/ // __ \| __ \ /  ___/  |/ __ |/ __ \\__  \  /  ___/
 * \     /\  ___/| \_\ \\___ \|  / /_/ \  ___/ / __ \_\___ \ 
 *  \/\_/  \___  >___  /____  >__\____ |\___  >____  /____  >
 *             \/    \/     \/        \/    \/     \/     \/ 
 */

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

add_action( 'init', 'register_posttype' );
function register_posttype() {
    /* ================================================ TEAM ================================================*/
    $labels = array( 
        'name' => __( 'Team', THEME_LANG),
        'singular_name' => __( 'Team', THEME_LANG),
        'add_new' => __( 'Add New', THEME_LANG),
        'all_items' => __( 'All Team', THEME_LANG),
        'add_new_item' => __( 'Add New Team', THEME_LANG),
        'edit_item' => __( 'Edit Team', THEME_LANG),
        'new_item' => __( 'New Team', THEME_LANG),
        'view_item' => __( 'View Team', THEME_LANG),
        'search_items' => __( 'Search Team', THEME_LANG),
        'not_found' => __( 'No Team found', THEME_LANG),
        'not_found_in_trash' => __( 'No Team found in Trash', THEME_LANG),
        'parent_item_colon' => __( 'Parent Team', THEME_LANG),
        'menu_name' => __( 'Team', THEME_LANG)
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
    register_post_type( 'kt_team', $args );
    
    register_taxonomy('team-category',array('kt_team'), array(
        "label" 						=> __("Team Categories", THEME_LANG), 
        "singular_label" 				=> __("Team Category", THEME_LANG), 
        'public'                        => false,
        'hierarchical'                  => true,
        'show_ui'                       => true,
        'show_in_nav_menus'             => false,
        'args'                          => array( 'orderby' => 'term_order' ),
        'rewrite'                       => false,
        'query_var'                     => true,
        'show_admin_column'             => true
    ));
   /* ============================================== END TEAM ==============================================*/
   /* ============================================== PORTFOLIO =============================================*/
    $labels = array( 
        'name' => __( 'Portfolio', THEME_LANG),
        'singular_name' => __( 'Portfolio', THEME_LANG),
        'add_new' => __( 'Add New', THEME_LANG),
        'all_items' => __( 'All Portfolio', THEME_LANG),
        'add_new_item' => __( 'Add New Portfolio', THEME_LANG),
        'edit_item' => __( 'Edit Portfolio', THEME_LANG),
        'new_item' => __( 'New Portfolio', THEME_LANG),
        'view_item' => __( 'View Portfolio', THEME_LANG),
        'search_items' => __( 'Search Portfolio', THEME_LANG),
        'not_found' => __( 'No Portfolio found', THEME_LANG),
        'not_found_in_trash' => __( 'No Portfolio found in Trash', THEME_LANG),
        'parent_item_colon' => __( 'Parent Portfolio', THEME_LANG),
        'menu_name' => __( 'Portfolio', THEME_LANG)
    );
    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'supports' 	=> array('title', 'editor', 'thumbnail'),
    );
    register_post_type( 'portfolio', $args );
    
    register_taxonomy('portfolio-category',array('portfolio'), array(
        "label" 						=> __("Categories", THEME_LANG), 
        "singular_label" 				=> __("Category", THEME_LANG), 
        'public'                        => false,
        'hierarchical'                  => true,
        'show_ui'                       => true,
        'show_in_nav_menus'             => false,
        'args'                          => array( 'orderby' => 'term_order' ),
        'rewrite'                       => false,
        'query_var'                     => true,
        'show_admin_column'             => true
    ));
   /* =========================================== END PORTFOLIO ===========================================*/
   /* =============================================== CLIENT ==============================================*/
    $labels = array( 
        'name' => __( 'Client', THEME_LANG),
        'singular_name' => __( 'Client', THEME_LANG),
        'add_new' => __( 'Add New', THEME_LANG),
        'all_items' => __( 'All Client', THEME_LANG),
        'add_new_item' => __( 'Add New Client', THEME_LANG),
        'edit_item' => __( 'Edit Client', THEME_LANG),
        'new_item' => __( 'New Client', THEME_LANG),
        'view_item' => __( 'View Client', THEME_LANG),
        'search_items' => __( 'Search Client', THEME_LANG),
        'not_found' => __( 'No Client found', THEME_LANG),
        'not_found_in_trash' => __( 'No Client found in Trash', THEME_LANG),
        'parent_item_colon' => __( 'Parent Client', THEME_LANG),
        'menu_name' => __( 'Client', THEME_LANG)
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
        "label" 						=> __("Categories", THEME_LANG), 
        "singular_label" 				=> __("Category", THEME_LANG), 
        'public'                        => false,
        'hierarchical'                  => true,
        'show_ui'                       => true,
        'show_in_nav_menus'             => false,
        'args'                          => array( 'orderby' => 'term_order' ),
        'rewrite'                       => false,
        'query_var'                     => true,
        'show_admin_column'             => true
    ));
   /* ============================================ END CLIENT ============================================*/
}
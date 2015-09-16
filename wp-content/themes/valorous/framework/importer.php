<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/************************************************************************
* Extended Example:
* Way to set menu, import revolution slider, and set home page.
*************************************************************************/

if ( !function_exists( 'kt_wbc_extended_imported' ) ) {
	function kt_wbc_extended_imported( $demo_active_import , $demo_directory_path ) {

		reset( $demo_active_import );
		$current_key = key( $demo_active_import );

		/************************************************************************
		* Import slider(s) for the current demo being imported
		*************************************************************************/

		if ( class_exists( 'RevSlider' ) ) {

			//If it's demo3 or demo5
			$wbc_sliders_array = array(
                'hero' => 'hero-scene.zip',
                'hero2' => 'hero-scene-2.zip',
                'carousel' => 'home-carousel-slider.zip',
                'carousel2' => 'home-carousel-slider-2.zip',
                'carousel3' => 'home-carousel-slider-3.zip',
                'standand' => 'home-standand-slider.zip',
                'standard2' => 'home-standard-slider-2.zip',
                'standard3' => 'home-standard-slider-3.zip',
                'html5' => 'html5-video.zip',
                'post' => 'post_slider.zip',
                'vimeo' => 'vimeo-background.zip',
                'youtube' => 'youtube-background.zip',


			);

            foreach( $wbc_sliders_array as $k => $wbc_slider_import ){
                $revslider = THEME_DIR.'dummy-data/revslider/'.$wbc_slider_import;
                if ( file_exists( $revslider ) ) {
                    $slider = new RevSlider();
                    $slider->importSliderFromPost( true, true, $revslider );
                }
            }

            /************************************************************************
            * Setting Menus
            *************************************************************************/

            $main_menu = get_term_by( 'name', __('Main menu', THEME_LANG), 'nav_menu' );
            $top_menu = get_term_by( 'name', __('Top menu', THEME_LANG), 'nav_menu' );
            $footer_menu = get_term_by( 'name', __('Footer menu', THEME_LANG), 'nav_menu' );

            set_theme_mod( 'nav_menu_locations', array(
                    'primary' => $main_menu->term_id,
                    'top'  => $top_menu->term_id,
                    'bottom'  => $footer_menu->term_id
                )
            );

            /************************************************************************
            * Set HomePage
            *************************************************************************/

            // array of demos/homepages to check/select from
            $wbc_home_pages = array(
                'demo1' => 'Home',
                'demo2' => 'Home v2',
                'demo3' => 'Home v3',
                'demo4' => 'Home v4',
                'demo5' => 'Home v5'
            );

            if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
                $page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
                if ( isset( $page->ID ) ) {
                    update_option( 'page_on_front', $page->ID );
                    update_option( 'show_on_front', 'page' );
                }
            }

	    }
    }
}
add_action( 'wbc_importer_after_content_import', 'kt_wbc_extended_imported', 10, 2 );
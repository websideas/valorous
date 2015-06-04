<?php
/**
 * All helpers for theme
 *
 */
 
 
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


add_filter( 'rwmb_meta_boxes', 'kite_register_meta_boxes' );
function kite_register_meta_boxes( $meta_boxes )
{
    $prefix = '_kt_';


    /**
     * For Post Audio
     *
     */

    $meta_boxes[] = array(
        'title'  => __('Audio Settings',THEME_LANG),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Audio'),
        ),

        'fields' => array(
            array(
                'name' => __('Audio Type', THEME_LANG),
                'id' => $prefix . 'audio_type',
                'type'     => 'select',
                'options'  => array(
                    '' => __('Upload', THEME_LANG),
                    'Soundcloud' => __('Soundcloud', THEME_LANG),
                ),
            ),
            array(
                'name'             => __( 'Upload MP3 File', THEME_LANG ),
                'id'               => "{$prefix}audio_mp3",
                'type'             => 'file_advanced',
                'max_file_uploads' => 1,
                'mime_type'        => 'audio', // Leave blank for all file types
            ),
            array(
                'name' => __( 'Soundcloud', THEME_LANG ),
                'desc' => __( 'Paste embed iframe or Wordpress shortcode.', THEME_LANG ),
                'id'   => "{$prefix}audio_soundcloud",
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 3,
            ),
        ),
    );

    /**
     * For Video
     *
     */

    $meta_boxes[] = array(
        'title'  => __('Video Settings',THEME_LANG),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Video'),
        ),

        'fields' => array(
            array(
                'name' => __('Video Type', THEME_LANG),
                'id' => $prefix . 'video_type',
                'type'     => 'select',
                'options'  => array(
                    'default' => __('Select Option', THEME_LANG),
                    'upload' => __('Upload', THEME_LANG),
                    'vimeo' => __('Vimeo', THEME_LANG),
                    'youtube' => __('Youtube', THEME_LANG),
                    'dailymotion' => __('Daily Motion', THEME_LANG)
                ),
            ),
            array(
                'name'             => __( 'Upload MP3 File', THEME_LANG ),
                'id'               => "{$prefix}audio_mp3",
                'type'             => 'file_advanced',
                'max_file_uploads' => 1,
                'mime_type'        => 'audio', // Leave blank for all file types
            ),
            array(
                'name' => __( 'Video Id', THEME_LANG ),
                'id' => $prefix . 'video_id',
                'desc' => __( "Please fill this option with the required ID.", THEME_LANG ),
                'type'  => 'text',
            ),

        ),


    );

    /**
     * For Post Audio
     *
     */

    $meta_boxes[] = array(
        'title'  => __('Gallery Settings',THEME_LANG),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Gallery'),
        ),

        'fields' => array(
            array(
                'name' => __('Gallery Type', THEME_LANG),
                'id' => $prefix . 'gallery_type',
                'type'     => 'select',
                'options'  => array(
                    'default' => __('Default', THEME_LANG),
                    'override' => __('Revolution Slider', THEME_LANG),
                    'below' => __('Layer Slider', THEME_LANG)
                ),
            ),

        ),
    );

    /**
     * For Team
     *
     */

    $meta_boxes[] = array(
        'title'  => __('Team Settings',THEME_LANG),
        'pages'  => array( 'kt_team' ),
        'fields' => array(
            array(
                'name' => __( 'Regency', THEME_LANG ),
                'id' => $prefix . 'team_regency',
                'desc' => __( "Regency.", THEME_LANG ),
                'type'  => 'text',
            ),
            array(
                'name' => __( 'Twitter', THEME_LANG ),
                'id' => $prefix . 'team_twitter',
                'desc' => __( "Link Twitter.", THEME_LANG ),
                'type'  => 'text',
            ),
            array(
                'name' => __( 'Facebook', THEME_LANG ),
                'id' => $prefix . 'team_facebook',
                'desc' => __( "Link Facebook.", THEME_LANG ),
                'type'  => 'text',
            ),
            array(
                'name' => __( 'Google+', THEME_LANG ),
                'id' => $prefix . 'team_googleplus',
                'desc' => __( "Link Google+.", THEME_LANG ),
                'type'  => 'text',
            ),
        ),
    );



    /**
     * For Layout option
     * 
     */
    $meta_boxes[] = array(
        'id' => 'page_meta_boxes',
        'title' => 'Page Options',
        'pages' => array( 'page', 'post' ),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(

            // checkbox

            array(
                'name' => __( 'Page title', THEME_LANG ),
                'id' => $prefix . 'show_title',
                'desc' => __( "Show page title.", THEME_LANG ),
                'type'  => 'checkbox',
                'std'  =>'1'
            ),

            array(
                'name' => __( 'Page Tagline', THEME_LANG ),
                'id' => $prefix . 'show_taglitle',
                'desc' => __( "Show page tagtitle.", THEME_LANG ),
                'type'  => 'checkbox',
                'std'  =>'1'
            ),

            array(
                'name' => __( 'Tagline', THEME_LANG ),
                'id' => $prefix . 'tagline',
                'desc' => __( "Enter tagline for page.", THEME_LANG ),
                'type'  => 'text',
            ),

            // data-meta-box.php

            array(
                'name' => __( 'Page breadcrumb', THEME_LANG ),
                'id' => $prefix . 'show_breadcrumb',
                'desc' => __( "Show page breadcrumb.", THEME_LANG ),
                'type'  => 'checkbox',
                'std'  =>'1'
            ),

            array(
                'type' => 'divider',
                'id' => 'fake_divider_id_1',
            ),

            array(
                'name'    => __( 'Header position', THEME_LANG ),
                'type'     => 'select',
                'id'       => $prefix.'header_position',
                'desc'     => __( "Please choose header position", THEME_LANG ),
                'options'  => array(
                    'default' => __('Default', THEME_LANG),
                    'override' => __('Override Slideshow', THEME_LANG),
                    'below' => __('Below Slideshow', THEME_LANG)
                ),
                'std'  => 'default'
            ),

            array(
                'type' => 'divider',
                'id' => 'fake_divider_id',
            ),
            array(
                'name' => __('Select Your Slideshow Type', THEME_LANG),
                'id' => $prefix . 'slideshow_source',
                'desc' => __("You can select the slideshow type using this option.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    '' => __('Select Option', THEME_LANG),
                    'revslider' => __('Revolution Slider', THEME_LANG),
                    'layerslider' => __('Layer Slider', THEME_LANG),
                    'custom_bg' => __('Custom Image', THEME_LANG),
                ),
            ),
            array(
                'name' => __('Select Revolution Slider', THEME_LANG),
                'id' => $prefix . 'rev_slider',
                'default' => true,
                'type' => 'revSlider'
            ),
            array(
                'name' => __('Select Layer Slider', THEME_LANG),
                'id' => $prefix . 'layerslider',
                'default' => true,
                'type' => 'layerslider'
            ),

            array(
                'name' => __('Select Image', THEME_LANG),
                'id' => $prefix . 'custom_bg',
                'default' => true,
                'class' => $prefix . 'custom_bg',
                'type' => 'image_advanced'
            ),



            array(
                'type' => 'divider',
                'id' => 'fake_divider_id',
            ),
            
            array(
                'name' => __('Page layout', THEME_LANG),
                'id' => $prefix . 'layout',
                'desc' => __("Please choose this page's layout.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'default' => __('Default option', THEME_LANG),
                    'full' => __('Full width Layout', THEME_LANG),
                    'boxed' => __('Boxed Layout', THEME_LANG),
                ),
                'std' => 'default'
            ),
            array(
                'type' => 'divider',
                'id' => 'fake_divider_id',
            ),
            array(
                'name' => __('Sidebar configuration', THEME_LANG),
                'id' => $prefix . 'sidebar',
                'desc' => __("Choose the sidebar configuration for the detail page.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'default' => __('Default option', THEME_LANG),
                    'full' => __('No sidebars', THEME_LANG),
                    'left' => __('Left Sidebar', THEME_LANG),
                    'right' => __('Right Layout', THEME_LANG)
                ),
                'std' => 'default'
            ),
            array(
                'name' => __('Left sidebar', THEME_LANG),
                'id' => $prefix . 'left_sidebar',
                'default' => true,
                'type' => 'sidebars'
            ),
            array(
                'name' => __('Right sidebar', THEME_LANG),
                'id' => $prefix . 'right_sidebar',
                'default' => true,
                'type' => 'sidebars'
            ),
            array(
                'type' => 'divider',
                'id' => 'fake_divider_id',
            ),
            array(
				'name' => __('Remove top spacing', THEME_LANG),
				'id' => $prefix . 'remove_top',
				'desc' => __("Remove the spacing at the top of the page", THEME_LANG ),
				'type'  => 'checkbox',
			),
            array(
				'name' => __('Remove bottom spacing', THEME_LANG ),
				'id' => $prefix . 'remove_bottom',
				'desc' => __("Remove the spacing at the bottom of the page", THEME_LANG ),
				'type'  => 'checkbox',
			),
            array(
				'name' => 'Extra page class',
				'id' => $prefix . 'extra_page_class',
				'desc' => "If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.",
				'type'  => 'text',
			),
        )
    );

    



    /**
     * For Testimonial
     * 
     */
    
    $meta_boxes[] = array(
        'id' => 'testimonial_meta_boxes',
        'title' => 'Testimonial Options',
        'pages' => array( 'testimonial' ),
        'context' => 'normal',
        'priority' => 'default',
        'fields' => array(
            
            array(
                'name' => __( 'Regency', THEME_LANG ),
                'id' => $prefix . 'testimonial_regency',
                'desc' => __( "Testimonial Regency.", THEME_LANG ),
                'type'  => 'text',
            ),

        )
    );

    return $meta_boxes;
}



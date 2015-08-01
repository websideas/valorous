<?php
/**
 * All helpers for theme
 *
 */
 
 
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


add_filter( 'rwmb_meta_boxes', 'kt_register_meta_boxes' );
function kt_register_meta_boxes( $meta_boxes )
{
    $prefix = '_kt_';
    $image_sizes = kt_get_image_sizes();
    $menus = wp_get_nav_menus();

    $menus_arr = array('' => __('Default', THEME_LANG));
    foreach ( $menus as $menu ) {
        $menus_arr[$menu->term_id] = esc_html( $menu->name );
    }

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
                    '' => __('Select Option', THEME_LANG),
                    'upload' => __('Upload', THEME_LANG),
                    'soundcloud' => __('Soundcloud', THEME_LANG),
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
                    '' => __('Select Option', THEME_LANG),
                    'external' => __('External url', THEME_LANG),
                ),
            ),
            array(
                'name' => __( 'Video link', THEME_LANG ),
                'id' => $prefix . 'video_link',
                'desc' => sprintf( __( 'Enter link to video (Note: read more about available formats at WordPress <a href="%s" target="_blank">codex page</a>).', THEME_LANG ), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
                'type'  => 'text',
            ),
        ),
    );

    /**
     * For Gallery
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
                    '' => __('Default', THEME_LANG),
                    'rev' => __('Revolution Slider', THEME_LANG),
                    'layer' => __('Layer Slider', THEME_LANG)
                ),
            ),

            array(
                'name' => __('Select Revolution Slider', THEME_LANG),
                'id' => $prefix . 'gallery_rev_slider',
                'default' => true,
                'type' => 'revSlider'
            ),
            array(
                'name' => __('Select Layer Slider', THEME_LANG),
                'id' => $prefix . 'gallery_layerslider',
                'default' => true,
                'type' => 'layerslider'
            ),
            array(
                'name' => __( 'Gallery images', 'your-prefix' ),
                'id'  => "{$prefix}gallery_images",
                'type' => 'image_advanced',
                'desc' => __( "You can drag and drop for change order image", THEME_LANG ),
            ),
        ),
    );



    /**
     * For Link
     *
     */

    $meta_boxes[] = array(
        'title'  => __('Link Settings',THEME_LANG),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Link'),
        ),

        'fields' => array(
            array(
                'name' => __( 'External URL', THEME_LANG ),
                'id' => $prefix . 'external_url',
                'desc' => __( "Input your link in here", THEME_LANG ),
                'type'  => 'text',
            ),

        ),
    );

    /**
     * For Quote
     *
     */

    $meta_boxes[] = array(
        'title'  => __('Quote Settings',THEME_LANG),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Quote'),
        ),
        'fields' => array(
            array(
                'name' => __( 'Quote Content', THEME_LANG ),
                'desc' => __( 'Please type the text for your quote here.', THEME_LANG ),
                'id'   => "{$prefix}quote_content",
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 3,
            ),
            array(
                'name' => __( 'Author', THEME_LANG ),
                'id' => $prefix . 'quote_author',
                'desc' => __( "Please type the text for author quote here.", THEME_LANG ),
                'type'  => 'text',
            ),

        ),
    );

    /**
     * For Layout option for post
     *
     */
    $meta_boxes[] = array(
        'id' => 'post_meta_boxes',
        'title' => 'Post Options',
        'pages' => array('post'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => __('Show Post format', THEME_LANG),
                'id'   => "{$prefix}post_format",
                'type' => 'select',
                'options' => array(
                    -1    => __('Default', THEME_LANG),
                    0		=> __('Hidden', THEME_LANG),
                    1		=> __('Show', THEME_LANG),
                ),
                'std'  => -1
            ),
            array(
                'type' => 'select',
                'name' => __('Post format position', THEME_LANG),
                'desc' => __('Select the format position.', THEME_LANG),
                'id'   => "{$prefix}blog_post_format_position",
                'options' => array(
                    ''    => __('Default', THEME_LANG),
                    'content' => __( 'Content', THEME_LANG ),
                    'fullwidth' => __( 'Fullwidth', THEME_LANG ),
                ),
                'std' => ''
            ),

            array(
                'type' => 'select',
                'name' => __('Post image size', THEME_LANG),
                'desc' => __('Select the format position.', THEME_LANG),
                'id'   => "{$prefix}blog_image_size",
                'options' => array_merge(array('' => __('Default', THEME_LANG)), $image_sizes),
                'std' => ''
            ),

            array(
                'name' => __('Meta info', THEME_LANG),
                'id'   => "{$prefix}meta_info",
                'type' => 'select',
                'options' => array(
                    -1    => __('Default', THEME_LANG),
                    0		=> __('Hidden', THEME_LANG),
                    1		=> __('Show', THEME_LANG),
                ),
                'std'  => -1
            ),
            array(
                'name' => __('Previous & next buttons', THEME_LANG),
                'id'   => "{$prefix}prev_next",
                'type' => 'select',
                'options' => array(
                    -1    => __('Default', THEME_LANG),
                    0		=> __('Hidden', THEME_LANG),
                    1		=> __('Show', THEME_LANG),
                ),
                'std'  => -1
            ),
            array(
                'name' => __('Author info', THEME_LANG),
                'id'   => "{$prefix}author_info",
                'type' => 'select',
                'options' => array(
                    -1    => __('Default', THEME_LANG),
                    0		=> __('Hidden', THEME_LANG),
                    1		=> __('Show', THEME_LANG),
                ),
                'std'  => -1
            ),
            array(
                'name' => __('Social sharing', THEME_LANG),
                'id'   => "{$prefix}social_sharing",
                'type' => 'select',
                'options' => array(
                    -1    => __('Default', THEME_LANG),
                    0		=> __('Hidden', THEME_LANG),
                    1		=> __('Show', THEME_LANG),
                ),
                'std'  => -1
            ),
            array(
                'name' => __('Related articles', THEME_LANG),
                'id'   => "{$prefix}related_acticles",
                'type' => 'select',
                'options' => array(
                    -1    => __('Default', THEME_LANG),
                    0		=> __('Hidden', THEME_LANG),
                    1		=> __('Show', THEME_LANG),
                ),
                'std'  => -1
            ),


        )
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
    /**
     * For Client
     * 
     */
    
    $meta_boxes[] = array(
        'id' => 'client_meta_boxes',
        'title' => 'Client Options',
        'pages' => array( 'kt_client' ),
        'context' => 'normal',
        'priority' => 'default',
        'fields' => array(
            
            array(
                'name' => __( 'Link Client', THEME_LANG ),
                'id' => $prefix . 'link_client',
                'desc' => __( "Link Client.", THEME_LANG ),
                'type'  => 'text',
            ),

        )
    );
    
    
    /**
     * For Portfolio
     * 
     */
    
    $meta_boxes[] = array(
        'id' => 'portfolio_meta_boxes',
        'title' => 'Portfolio Options',
        'pages' => array( 'portfolio' ),
        'context' => 'normal',
        'priority' => 'default',
        'fields' => array(
            array(
                'name' => __('Layout configuration', THEME_LANG),
                'id' => $prefix . 'sidebar',
                'desc' => __("Choose the sidebar configuration for the detail page.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'full' => __('Full Width', THEME_LANG),
                    'left' => __('Left Sidebar', THEME_LANG),
                    'right' => __('Right Sidebar', THEME_LANG)
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
                'name' => __('Video Type', THEME_LANG),
                'id' => $prefix . 'video_type',
                'type'     => 'select',
                'options'  => array(
                    '' => __('Select Option', THEME_LANG),
                    //'upload' => __('Upload', THEME_LANG),
                    'youtube' => __('Youtube', THEME_LANG),
                    'vimeo' => __('Vimeo', THEME_LANG),
                    'dailymotion' => __('Daily Motion', THEME_LANG)
                ),
            ),
            array(
                'name' => __( 'Video Id', THEME_LANG ),
                'id' => $prefix . 'video_id',
                'desc' => __( "Please fill this option with the required ID.", THEME_LANG ),
                'type'  => 'text',
            ),
            
            array(
                'name' => __('Select Image', THEME_LANG),
                'id' => $prefix . 'list_image',
                'type' => 'image_advanced'
            ),
            
            array(
                'name' => __( 'Client', THEME_LANG ),
                'id' => $prefix . 'client',
                'desc' => __( "Please enter your client.", THEME_LANG ),
                'type'  => 'text',
            ),
            array(
                'name' => __( 'Project Date', THEME_LANG ),
                'id' => $prefix . 'project_date',
                'desc' => __( "Please enter your date of project.", THEME_LANG ),
                'type'  => 'date',
            ),
            array(
                'name' => __( 'Link Project', THEME_LANG ),
                'id' => $prefix . 'link_project',
                'desc' => __( "Please enter your link project.", THEME_LANG ),
                'type'  => 'text',
            ),
        )
    );


    /**
     * For Layout option
     *
     */
    $meta_boxes[] = array(
        'id' => 'page_meta_boxes',
        'title' => 'Page Options',
        'pages' => array( 'page', 'post', 'portfolio','product' ),
        'context' => 'normal',
        'priority' => 'high',
        'tabs'      => array(
            'sliders'  => array(
                'label' => __( 'Sliders', THEME_LANG ),
                'icon'  => 'fa fa-picture-o',
            ),
            'page_header' => array(
                'label' => __( 'Page Header', THEME_LANG ),
                'icon'  => 'fa fa-bars',
            ),
            'header'  => array(
                'label' => __( 'Header', THEME_LANG ),
                'icon'  => 'fa fa-desktop',
            ),
            'page_layout' => array(
                'label' => __( 'Page layout', THEME_LANG ),
                'icon'  => 'fa fa-columns',
            ),
            /*
            'extra' => array(
                'label' => __( 'Extra', THEME_LANG ),
                'icon'  => 'fa fa-asterisk',
            ),
            */
        ),
        'fields' => array(
            // Page Header
            array(

                'name' => __( 'Page Header', THEME_LANG ),
                'id' => $prefix . 'page_header',
                'desc' => __( "Show Page Header.", THEME_LANG ),
                'type' => 'select',
                'options' => array(
                    -1    => __('Default', THEME_LANG),
                    0		=> __('Hidden', THEME_LANG),
                    1		=> __('Show', THEME_LANG),
                ),
                'std'  => -1,
                'tab'  => 'page_header',
            ),
            array(
                'name' => __( 'Page Header Custom Text', THEME_LANG ),
                'id' => $prefix . 'page_header_custom',
                'desc' => __( "Enter cstom Text for page header.", THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_header',
            ),

            array(
                'name' => __( 'Page header subtitle', THEME_LANG ),
                'id' => $prefix . 'page_header_subtitle',
                'desc' => __( "Enter subtitle for page.", THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_header',
            ),

            array(
                'id'       => "{$prefix}page_header_align",
                'type'     => 'select',
                'name'    => __( 'Page Header align', THEME_LANG ),
                'desc'     => __( 'Please select Page Header align', THEME_LANG ),
                'options'  => array(
                    ''    => __('Default', THEME_LANG),
                    'left' => __('Left', THEME_LANG ),
                    'center' => __('Center', THEME_LANG),
                    'right' => __('Right', THEME_LANG)
                ),
                'std'  => '',
                'tab'  => 'page_header',
            ),

            array(
                'name' => __('Page breadcrumb', THEME_LANG),
                'id'   => "{$prefix}show_breadcrumb",
                'type' => 'select',
                'options' => array(
                    -1    => __('Default', THEME_LANG),
                    0		=> __('Hidden', THEME_LANG),
                    1		=> __('Show', THEME_LANG),
                ),
                'std'  => -1,
                'desc' => __( "Show page breadcrumb.", THEME_LANG ),
                'tab'  => 'page_header',
            ),

            array(
                'name' => __('Separator bettwen title and subtitle', THEME_LANG),
                'id'   => "{$prefix}page_header_separator",
                'type' => 'select',
                'options' => array(
                    -1    => __('Default', THEME_LANG),
                    0		=> __('Hidden', THEME_LANG),
                    1		=> __('Show', THEME_LANG),
                ),
                'std'  => -1,
                'desc' => __( "Show separator bettwen title and subtitle.", THEME_LANG ),
                'tab'  => 'page_header',
            ),




            array(
                'name' => __('Page header top spacing', THEME_LANG),
                'id' => $prefix . 'page_header_top',
                'desc' => __("(Example: 30px). Emtpy for use default", THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_header',
            ),
            array(
                'name' => __('Page header bottom spacing', THEME_LANG),
                'id' => $prefix . 'page_header_bottom',
                'desc' => __("(Example: 30px). Emtpy for use default", THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_header',
            ),



            array(
                'name' => __( 'Background Image', THEME_LANG ),
                'id'  => "{$prefix}page_header_bg",
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
                'tab'  => 'page_header',
                'desc' => __( "Choose custom background image for page header.", THEME_LANG ),
            ),
            array(
                'name' => __( 'Background color', THEME_LANG ),
                'id'   => "{$prefix}page_header_bg_color",
                'type' => 'color',
                'tab'  => 'page_header',
                'desc' => __( "Choose custom background color for page header.", THEME_LANG ),
            ),
            array(
                'name' => __( 'Separator custom color', THEME_LANG ),
                'id'   => "{$prefix}page_header_separator_color",
                'type' => 'color',
                'tab'  => 'page_header',
                'desc' => __( "Choose custom color for separator.", THEME_LANG ),
            ),
            array(
                'name' => __( 'Typography title custom color', THEME_LANG ),
                'id'   => "{$prefix}page_header_title_color",
                'type' => 'color',
                'tab'  => 'page_header',
                'desc' => __( "Choose custom color for title.", THEME_LANG ),
            ),
            array(
                'name' => __( 'Typography sub title custom color', THEME_LANG ),
                'id'   => "{$prefix}page_header_subtitle_color",
                'type' => 'color',
                'tab'  => 'page_header',
                'desc' => __( "Choose custom color for sub title.", THEME_LANG ),
            ),
            array(
                'name' => __( 'Typography breadcrumbs custom color', THEME_LANG ),
                'id'   => "{$prefix}page_header_breadcrumbs_color",
                'type' => 'color',
                'tab'  => 'page_header',
                'desc' => __( "Choose custom color for breadcrumbs.", THEME_LANG ),
            ),



            // Header
            array(
                'name' => __('Header Color Scheme', THEME_LANG),
                'id'   => "{$prefix}header_scheme",
                'type' => 'select',
                'options' => array(
                    ''    => __('Default', THEME_LANG),
                    'light'		=> __('Light', THEME_LANG),
                    'dark'		=> __('Dark', THEME_LANG),
                ),
                'std'  => '',
                'tab'  => 'header',
            ),

            array(
                'name' => __('Header Color Scheme fixed', THEME_LANG),
                'id'   => "{$prefix}header_scheme_fixed",
                'type' => 'select',
                'options' => array(
                    ''    => __('Default', THEME_LANG),
                    'light'		=> __('Light', THEME_LANG),
                    'dark'		=> __('Dark', THEME_LANG),
                ),
                'std'  => '',
                'tab'  => 'header',
            ),
            array(
                'name'    => __( 'Header position', THEME_LANG ),
                'type'     => 'select',
                'id'       => $prefix.'header_position',
                'desc'     => __( "Please choose header position", THEME_LANG ),
                'options'  => array(
                    'default' => __('Default', THEME_LANG),
                    'transparent' => __('Transparent header', THEME_LANG),
                    'below' => __('Below Slideshow', THEME_LANG),
                ),
                'std'  => 'default',
                'tab'  => 'header',
            ),
            /*
            array(
                'name' => __('Main Navigation Menu', THEME_LANG),
                'id'   => "{$prefix}header_main_menu",
                'type' => 'select',
                'options' => $menus_arr,
                'std'  => '',
                'tab'  => 'header',
            ),
            */

            //sliders
            array(
                'name' => __('Select Your Slideshow Type', THEME_LANG),
                'id' => $prefix . 'slideshow_source',
                'desc' => __("You can select the slideshow type using this option.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    '' => __('Select Option', THEME_LANG),
                    'revslider' => __('Revolution Slider', THEME_LANG),
                    'layerslider' => __('Layer Slider', THEME_LANG),
                    'vertical' => __('Vertical Posts', THEME_LANG),
                    'carousel' => __('Featured Carousel Posts', THEME_LANG),
                ),
                'tab'  => 'sliders',
            ),
            array(
                'name' => __('Select Revolution Slider', THEME_LANG),
                'id' => $prefix . 'rev_slider',
                'default' => true,
                'type' => 'revSlider',
                'tab'  => 'sliders',
                'desc' => __('Select the Revolution Slider.', THEME_LANG),
            ),
            array(
                'name' => __('Select Layer Slider', THEME_LANG),
                'id' => $prefix . 'layerslider',
                'default' => true,
                'type' => 'layerslider',
                'tab'  => 'sliders',
                'desc' => __('Select the Layer Slider.', THEME_LANG),
            ),

            /* ============================================== */
            array(
                'id' => $prefix . 'divider_sliders',
                'type' => 'divider',
                'tab'  => 'sliders',
            ),
            /* ============================================== */
            array(
                'name' => __('Data source', THEME_LANG),
                'id' => $prefix . 'data_source',
                'desc' => __("Select content type for your posts.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    '' => __('All', THEME_LANG),
                    'categories' => __('Specific Categories', THEME_LANG),
                    'authors' => __('Specific Authors', THEME_LANG),
                    'posts' => __('Specific Posts', THEME_LANG),
                ),
                'std' => '',
                'tab'  => 'sliders',
            ),
            array(
                'name'    => __( 'Categories', THEME_LANG ),
                'id'      => "{$prefix}post_categories",
                'type'    => 'taxonomy',
                'tab'  => 'sliders',
                'desc' => __('Select your categories.', THEME_LANG),
                'placeholder' => __('Select Option', THEME_LANG),
                'multiple' => true,
                'options' => array(
                    'taxonomy' => 'category',
                    'type'     => 'select_advanced',
                    'args'     => array()
                ),
            ),
            array(
                'name'    => __( 'Authors', THEME_LANG ),
                'id'      => "{$prefix}post_authors",
                'type'    => 'user',
                'tab'  => 'sliders',
                'desc' => __('Select your authors.', THEME_LANG),
                'placeholder' => __('Select Option', THEME_LANG),
                'multiple' => true
            ),

            array(
                'name'    => __( 'Specific Posts', THEME_LANG ),
                'id'      => "{$prefix}post_posts",
                'type'    => 'post',
                'tab'  => 'sliders',
                'desc' => __('Select your posts.', THEME_LANG),
                'placeholder' => __('Select Option', THEME_LANG),
                'multiple' => true
            ),

            array(
                'name' => __('Order by', THEME_LANG),
                'id' => $prefix . 'post_orderby',
                'desc' => __('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'date' => __( 'Date', 'js_composer' ),
                    'ID' => __( 'Order by post ID', 'js_composer' ),
                    'author'=> __( 'Author', 'js_composer' ),
                    'title' => __( 'Title', 'js_composer' ),
                    'modified' => __( 'Last modified date', 'js_composer' ),
                    'parent' => __( 'Post/page parent ID', 'js_composer' ) ,
                    'comment_count' => __( 'Number of comments', 'js_composer' ),
                    'menu_order' => __( 'Menu order/Page Order', 'js_composer' ),
                    'meta_value' => __( 'Meta value', 'js_composer' ),
                    'meta_value_num' => __( 'Meta value number', 'js_composer' ),
                    'rand' => __( 'Random order', 'js_composer' ) ,
                ),
                'std' => 'date',
                'tab'  => 'sliders',
            ),
            array(
                'name' => __('Meta key', THEME_LANG),
                'id' => $prefix . 'post_meta_key',
                'type' => 'text',
                'tab'  => 'sliders',
                'desc' => __('Select your meta key.', THEME_LANG),
            ),
            array(
                'name' => __('Sorting', THEME_LANG),
                'id' => $prefix . 'post_order',
                'desc' => __('Select sorting order.', THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'DESC' => __( 'Descending', 'js_composer' ),
                    'ASC' => __( 'Ascending', 'js_composer' ),
                ),
                'std' => 'DESC',
                'tab'  => 'sliders',
            ),
            //Page layout
            array(
                'name' => __('Page layout', THEME_LANG),
                'id' => $prefix . 'layout',
                'desc' => __("Please choose this page's layout.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'default' => __('Default', THEME_LANG),
                    'full' => __('Full width Layout', THEME_LANG),
                    'boxed' => __('Boxed Layout', THEME_LANG),
                ),
                'std' => 'default',
                'tab'  => 'page_layout',
            ),
            array(
                'name' => __('Sidebar configuration', THEME_LANG),
                'id' => $prefix . 'sidebar',
                'desc' => __("Choose the sidebar configuration for the detail page.<br/><b>Note: Cart and checkout, My account page always use no sidebars.</b>", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'default' => __('Default', THEME_LANG),
                    'full' => __('No sidebars', THEME_LANG),
                    'left' => __('Left Sidebar', THEME_LANG),
                    'right' => __('Right Layout', THEME_LANG)
                ),
                'std' => 'default',
                'tab'  => 'page_layout',
            ),
            array(
                'name' => __('Left sidebar', THEME_LANG),
                'id' => $prefix . 'left_sidebar',
                'default' => false,
                'type' => 'sidebars',
                'tab'  => 'page_layout',
                'desc' => __("Select your sidebar.", THEME_LANG),
            ),
            array(
                'name' => __('Right sidebar', THEME_LANG),
                'id' => $prefix . 'right_sidebar',
                'default' => false,
                'type' => 'sidebars',
                'tab'  => 'page_layout',
                'desc' => __("Select your sidebar.", THEME_LANG),
            ),
            array(
                'name' => __('Page top spacing', THEME_LANG),
                'id' => $prefix . 'page_top_spacing',
                'desc' => __("Enter your page top spacing (Example: 30px).", THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_layout',
            ),
            array(
                'name' => __('Page bottom spacing', THEME_LANG),
                'id' => $prefix . 'page_bottom_spacing',
                'desc' => __("Enter your page bottom spacing (Example: 30px).", THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_layout',
            ),
            array(
                'name' => 'Extra page class',
                'id' => $prefix . 'extra_page_class',
                'desc' => "If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.",
                'type'  => 'text',
                'tab'  => 'page_layout',
            ),

        )
    );




    return $meta_boxes;
}
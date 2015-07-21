<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


if ( ! class_exists( 'KT_config' ) ) {
    class KT_config{
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if ( ! class_exists( 'ReduxFramework' ) ) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            }
        }
        
        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }
            
            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }
        
        
        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'             => THEME_OPTIONS,
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'         => $theme->get( 'Name' ),
                // Name that appears at the top of your panel
                'display_version'      => $theme->get( 'Version' ),
                // Version that appears at the top of your panel
                'menu_type'            => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'       => false,
                // Show the sections below the admin menu item or not
                'menu_title'           => $theme->get( 'Name' ),
                
                'page_title'           => $theme->get( 'Name' ).__( ' Theme Options - ', THEME_LANG ),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => false,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => false,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => false,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => 61,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => 'dashicons-art',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => 'theme_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE
            );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => '#',
                'title' => __('Like us on Facebook', THEME_LANG),
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => '#',
                'title' => __('Follow us on Twitter', THEME_LANG),
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => '#',
                'title' => __('Find us on LinkedIn', THEME_LANG),
                'icon'  => 'el-icon-linkedin'
            );
            
        }
        
        public function setSections() {
            
            $this->sections[] = array(
                'id' 	=> 'general',
                'title'  => __( 'General', THEME_LANG ),
                'desc'   => __( '', THEME_LANG ),
                'icon_class'	=> 'icon_cogs'
            );


            global $wp_registered_sidebars;
            $sidebars = array();

            foreach ( $wp_registered_sidebars as $sidebar ){
                $sidebars[  $sidebar['id'] ] =   $sidebar['name'];
            }

            $image_sizes = kt_get_image_sizes();


            $this->sections[] = array(
                'id' 	=> 'general_layout',
                'title'  => __( 'General', THEME_LANG ),
                'desc'   => __( '', THEME_LANG ),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'layout',
                        'type'     => 'select',
                        'title'    => __( 'Site boxed mod(?)', THEME_LANG ),
                        'subtitle'     => __( "Please choose page layout", THEME_LANG ),
                        'options'  => array(
                            'full' => __('Full width Layout', THEME_LANG),
                            'boxed' => __('Boxed Layout', THEME_LANG),
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),

                    array(
                        'id'       => 'archive_placeholder',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Placeholder', THEME_LANG ),
                        'subtitle'     => __( "Placeholder for none image", THEME_LANG ),
                    ),



                )
            );

            /**
			 *	Logos
			 **/
			$this->sections[] = array(
				'id'			=> 'logos_favicon',
				'title'			=> __( 'Logos & Favicon', THEME_LANG ),
				'desc'			=> '',
				'subsection' => true,
				'fields'		=> array(
                    array(
                        'id'       => 'logos_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Logos settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'logo',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Logo', THEME_LANG ),
                    ),
                    array(
                        'id'       => 'logo_dark',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Logo Dark', THEME_LANG ),
                    ),
                    array(
                        'id'       => 'logo_footer',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Logo Footer', THEME_LANG ),
                    ),
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'             => 'logo_width',
                        'type'           => 'dimensions',
                        'units'          => array( 'em', 'px'),
                        'units_extended' => 'true',
                        'title'          => __( 'Logo width', THEME_LANG ),
                        'height'         => false,
                        'default'        => array( 'width'  => 120, 'height' => 100 ),
                        'output'   => array( '.site-branding .site-logo img' ),
                    ),
                    array(
                        'id'       => 'logo_margin_spacing',
                        'type'     => 'spacing',
                        'mode'     => 'margin',
                        'output'   => array( '.site-branding .site-logo img' ),
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Logo margin spacing Option', THEME_LANG ),
                        'default'  => array(
                            'margin-top'    => '25px',
                            'margin-right'  => '0px',
                            'margin-bottom' => '25px',
                            'margin-left'   => '0px'
                        )
                    ),

                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),

                    array(
                        'id'             => 'logo_sticky_width',
                        'type'           => 'dimensions',
                        'output'   => array( '.is-sticky .site-branding .site-logo img'),
                        'units'          => array( 'em', 'px'), 
                        'units_extended' => 'true', 
                        'title'          => __( 'Logo sticky width', THEME_LANG ),
                        'height'         => false,
                        'default'        => array( 'width'  => 200, 'height' => 100 )
                    ),
                    array(
                        'id'       => 'logo_sticky_margin_spacing',
                        'type'     => 'spacing',
                        'mode'     => 'margin',
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Logo sticky margin spacing Option', THEME_LANG ),
                        'default'  => array(
                            'margin-top'    => '12px',
                            'margin-right'  => '0px',
                            'margin-bottom' => '12px',
                            'margin-left'   => '0px'
                        ),
                        'output'   => array( '.is-sticky .site-branding .site-logo img'),
                    ),
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'             => 'logo_mobile_width',
                        'type'           => 'dimensions',
                        'units'          => array( 'em', 'px'),
                        'units_extended' => 'true',
                        'title'          => __( 'Logo mobile width', THEME_LANG ),
                        'height'         => false,
                        'default'        => array( 'width'  => 120, 'height' => 100 ),
                    ),
                    array(
                        'id'       => 'logo_mobile_margin_spacing',
                        'type'     => 'spacing',
                        'mode'     => 'margin',
                        'units'          => array( 'em', 'px' ),
                        'units_extended' => 'true',
                        'title'    => __( 'Logo mobile margin spacing Option', THEME_LANG ),
                        'default'  => array(
                            'margin-top'    => '25px',
                            'margin-right'  => '0px',
                            'margin-bottom' => '25px',
                            'margin-left'   => '0px'
                        )
                    ),
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'favicon_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Favicon settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'custom_favicon',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Custom Favicon', THEME_LANG ),
                        'subtitle' => __( 'Using this option, You can upload your own custom favicon (16px x 16px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_iphone',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Apple iPhone Favicon', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPhone (57px x 57px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_iphone_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Apple iPhone Retina Favicon', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPhone Retina Version (114px x 114px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_ipad',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Apple iPad Favicon Upload', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPad (72px x 72px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_ipad_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Apple iPad Retina Icon Upload', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPad Retina Version (144px x 144px)', THEME_LANG),
                    ),
                )
            );
            
            
            /**
			 *	Header
			 **/
			$this->sections[] = array(
				'id'			=> 'Header',
				'title'			=> __( 'Header', THEME_LANG ),
				'desc'			=> '',
				'subsection' => true,
				'fields'		=> array(

                    array(
                        'id'       => 'header',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Header layout', THEME_LANG ),
                        'subtitle' => __( 'Please choose header layout', THEME_LANG ),
                        'options'  => array(
                            'layout1' => array( 'alt' => __( 'Layout 1', THEME_LANG ), 'img' => FW_IMG . 'header/header-v1.png' ),
                            'layout2' => array( 'alt' => __( 'Layout 2', THEME_LANG ), 'img' => FW_IMG . 'header/header-v2.png' ),
                            //'layout3' => array( 'alt' => __( 'Layout 3', THEME_LANG ), 'img' => FW_IMG . 'header/header-v3.png' ),
                        ),
                        'default'  => 'layout1'
                    ),
                    array(
                        'id'       => 'header_scheme',
                        'type'     => 'select',
                        'title'    => __( 'Header Color Scheme', THEME_LANG ),
                        'subtitle'     => __( 'Please select your header color scheme here.', THEME_LANG ),
                        'options'  => array(
                            'dark' => __('Dark', THEME_LANG ),
                            'light' => __('Light', THEME_LANG)
                        ),
                        'default'  => 'light',
                        'clear' => false
                    ),
                    array(
                        'id'		=> 'fixed_header',
                        'type'		=> 'switch',
                        'title'		=> __( 'Fixed Header on Scroll', THEME_LANG ),
                        'subtitle'	=> __( 'Toggle the fixed header when the user scrolls down the site on or off. Please note that for certain header (two and three) styles only the navigation will become fixed.', THEME_LANG),
                        "default"	=> '1',
                        'on'		=> __( 'On', THEME_LANG ),
                        'off'		=> __( 'Off', THEME_LANG ),
                    ),
                    array(
                        'id'       => 'header_scheme_fixed',
                        'type'     => 'select',
                        'title'    => __( 'Header Color Scheme fixed', THEME_LANG ),
                        'subtitle'     => __( 'Please select your header color scheme fixed here.', THEME_LANG ),
                        'options'  => array(
                            'dark' => __('Dark', THEME_LANG ),
                            'light' => __('Light', THEME_LANG),
                        ),
                        'default'  => 'light',
                        'clear' => false,
                        'required' => array('fixed_header','equals','1')
                    ),
                    array(
                        'id' => 'header_full',
                        'type' => 'switch',
                        'title' => __('Full Width Header', THEME_LANG),
                        'desc' => __('Do you want the header to span the full width of the page?', THEME_LANG),
                        "default" => 1,
                        'on' => 'Enabled',
                        'off' => 'Disabled',
                    ),
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    /*
                    array(
                        'id'       => 'header_contact_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Header contact settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'header_phone',
                        'type' => 'text',
                        'title' => __('Phone Number For Contact Info', THEME_LANG), 
                        'default' => __('Call Us: 00-123-456-789', THEME_LANG)
                    ),
                    array(
                        'id' => 'header_email',
                        'type' => 'text',
                        'title' => __('Email Address For Contact Info', THEME_LANG), 
                        'default' => __('demo@domain.com', THEME_LANG)
                    ),
                    */
                    array(
                        'id' => 'header_search',
                        'type' => 'switch',
                        'title' => __('Search Icon', THEME_LANG),
                        'desc' => __('Enable the search Icon in the header.', THEME_LANG),
                        "default" => 1,
                        'on' => 'Enabled',
                        'off' => 'Disabled',
                    ),

                    //Header Search Post Type - All - Product

                    array(
                        'id' => 'header_cart',
                        'type' => 'switch',
                        'title' => __('Cart icon', THEME_LANG),
                        'desc' => __('Enable the cart Icon in the header (Only work if you install WooCommerce).', THEME_LANG),
                        "default" => 1,
                        'on' => 'Enabled',
                        'off' => 'Disabled',
                    ),
                    array(
                        'id' => 'header_language',
                        'type' => 'switch',
                        'title' => __('Language switcher', THEME_LANG),
                        'desc' => __('Enable the language switcher in the header (Only work if you install WPML).', THEME_LANG),
                        "default" => 1,
                        'on' => 'Enabled',
                        'off' => 'Disabled',
                    ),
                )
            );


            /**
			 *	Footer
			 **/
			$this->sections[] = array(
				'id'			=> 'footer',
				'title'			=> __( 'Footer', THEME_LANG ),
				'desc'			=> '',
				'subsection' => true,
				'fields'		=> array(
                    // Footer settings
                    
                    array(
                        'id'       => 'backtotop',
                        'type'     => 'switch',
                        'title'    => __( 'Back to top', THEME_LANG ),
                        'default'  => true,
                    ),

                    array(
                        'id'       => 'footer_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer',
                        'type'     => 'switch',
                        'title'    => __( 'Footer enable', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'footer_fixed',
                        'type'     => 'switch',
                        'title'    => __( 'Footer Fixed', THEME_LANG ),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'footer_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer' ),
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Footer padding', THEME_LANG ),
                        'default'  => array( )
                    ),
                    // Footer Top settings
                    array(
                        'id'       => 'footer_top_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer top settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_top',
                        'type'     => 'switch',
                        'title'    => __( 'Footer top enable', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'footer_top_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-top' ),
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Footer top padding', THEME_LANG ),
                        'default'  => array( )
                    ),
                    // Footer widgets settings
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'footer_widgets_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer widgets settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_widgets',
                        'type'     => 'switch',
                        'title'    => __( 'Footer widgets enable', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'footer_widgets_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-area' ),
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Footer widgets padding', THEME_LANG ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'footer_widgets_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Footer widgets layout', THEME_LANG ),
                        'subtitle' => __( 'Select your footer widgets layout', THEME_LANG ),
                        'options'  => array(
                            '3-3-3-3' => array( 'alt' => __( 'Layout 1', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-1.png' ),
                            '6-3-3' => array( 'alt' => __( 'Layout 2', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-2.png' ),
                            '3-3-6' => array( 'alt' => __( 'Layout 3', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-3.png' ),
                            '6-6' => array( 'alt' => __( 'Layout 4', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-4.png' ),
                            '4-4-4' => array( 'alt' => __( 'Layout 5', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-5.png' ),
                            '8-4' => array( 'alt' => __( 'Layout 6', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-6.png' ),
                            '4-8' => array( 'alt' => __( 'Layout 7', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-7.png' ),
                            '3-6-3' => array( 'alt' => __( 'Layout 8', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-8.png' ),
                            '12' => array( 'alt' => __( 'Layout 9', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-9.png' ),
                        ),
                        'default'  => '4-4-4'
                    ),
                    
                    /* Footer bottom */
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'footer_bottom_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer bottom settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_bottom',
                        'type'     => 'switch',
                        'title'    => __( 'Footer bottom enable', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'footer_bottom_instagram',
                        'type'     => 'switch',
                        'title'    => __( 'Use instagram background if available', THEME_LANG ),
                        'default'  => true,
                    ),


                    array(
                        'id'       => 'footer_bottom_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'units'          => array( 'em', 'px' ),
                        'units_extended' => 'true',
                        'title'    => __( 'Footer bottom padding', THEME_LANG ),
                        'default'  => array( ),
                        'subtitle' => 'Disable if you use instagram background',
                    ),





                    /* Footer copyright */
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'footer_copyright_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer copyright settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_copyright',
                        'type'     => 'switch',
                        'title'    => __( 'Footer copyright enable', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'footer_copyright_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-copyright' ),
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Footer copyright padding', THEME_LANG ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'footer_copyright_layout',
                        'type'     => 'select',
                        'title'    => __( 'Footer copyright layout', THEME_LANG ),
                        'subtitle'     => __( 'Select your preferred footer layout.', THEME_LANG ),
                        'options'  => array(
                            'centered' => __('Centered', THEME_LANG),
                            'sides' => __('Sides', THEME_LANG )
                        ),
                        'default'  => 'centered',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'footer_copyright_left',
                        'type'     => 'select',
                        'title'    => __( 'Footer copyright left', THEME_LANG ),
                        'options'  => array(
                            '' => __('Empty', THEME_LANG ),
                            'navigation' => __('Navigation', THEME_LANG ),
                            'socials' => __('Socials', THEME_LANG ),
                            'copyright' => __('Copyright', THEME_LANG ),
                        ),
                        'default'  => 'socials'
                    ),
                    array(
                        'id'       => 'footer_copyright_right',
                        'type'     => 'select',
                        'title'    => __( 'Footer copyright right', THEME_LANG ),
                        'options'  => array(
                            '' => __('Empty', THEME_LANG ),
                            'navigation' => __('Navigation', THEME_LANG ),
                            'socials' => __('Socials', THEME_LANG ),
                            'copyright' => __('Copyright', THEME_LANG ),
                        ),
                        'default'  => 'copyright'
                    ),
                    array(
                         'id'   => 'footer_socials',
                         'type' => 'kt_socials',
                         'title'    => __( 'Select your socials', THEME_LANG ),
                    ),
                    array(
                        'id'       => 'footer_copyright_text',
                        'type'     => 'editor',
                        'title'    => __( 'Footer Copyright Text', THEME_LANG ),
                        'default'  => 'Copyright &copy; 2015 - <a href="#">Dancing Flower</a> - All Right Reserver '
                    ),





                    
                )
            );



            

            /**
			 *	Styling
			 **/
			$this->sections[] = array(
				'id'			=> 'styling',
				'title'			=> __( 'Styling', THEME_LANG ),
				'desc'			=> '',
				'icon_class'	=> 'icon_camera_alt',
            );
            /**
			 *	Styling General
			 **/
            $this->sections[] = array(
				'id'			=> 'styling_general',
				'title'			=> __( 'General', THEME_LANG ),
				'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'styling_accent',
                        'type'     => 'color',
                        'title'    => __( 'Theme Accent Color', THEME_LANG ),
                        'default'  => '',
                        'transparent' => false,
                    ),
                    array(
                        'id'       => 'styling_link',
                        'type'     => 'link_color',
                        'title'    => __( 'Links Color', THEME_LANG ),
                        'output'      => array( 'a' ),
                        'default'  => array( )
                    ),
                )
            );
            
            
            /**
			 *	Styling Background
			 **/
            $this->sections[] = array(
				'id'			=> 'styling-background',
				'title'			=> __( 'Background', THEME_LANG ),
				'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'styling_body_background',
                        'type'     => 'background',
                        'output'   => array( 'body', 'body.layout-boxed' ),
                        'title'    => __( 'Body Background for full width mod', THEME_LANG ),
                        'subtitle' => __( 'Body background with image, color, etc.', THEME_LANG ),
                        'default'   => '#FFFFFF'
                    ),
                    array(
                        'id'       => 'styling_boxed_background',
                        'type'     => 'background',
                        'output'   => array( 'body.layout-boxed #page' ),
                        'title'    => __( 'Boxed Background for boxed mod', THEME_LANG ),
                        'subtitle' => __( 'Body background with image, color, etc.', THEME_LANG ),
                        'default'   => '#'
                    ),
                )
            );
            
            
            /**
			 *	Styling Header
			 **/
            $this->sections[] = array(
				'id'			=> 'styling_header',
				'title'			=> __( 'Header', THEME_LANG ),
				'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'header_layout1_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Header layout 1 settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'            => 'header-layout-opacity',
                        'type'          => 'slider',
                        'title'         => __( 'Background opacity', THEME_LANG ),
                        'default'       => .8,
                        'min'           => 0,
                        'step'          => .1,
                        'max'           => 1,
                        'resolution'    => 0.1,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'header_sticky_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Header sticky settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'            => 'header_sticky_opacity',
                        'type'          => 'slider',
                        'title'         => __( 'Background opacity', THEME_LANG ),
                        'default'       => .8,
                        'min'           => 0,
                        'step'          => .1,
                        'max'           => 1,
                        'resolution'    => 0.1,
                        'display_value' => 'text'
                    ),


                )
            );
            
            /**
			 *	Styling Footer
			 **/
            $this->sections[] = array(
				'id'			=> 'styling_footer',
				'title'			=> __( 'Footer', THEME_LANG ),
				'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'footer_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_background',
                        'type'     => 'background',
                        'title'    => __( 'Footer Background', THEME_LANG ),
                        'subtitle' => __( 'Footer Background with image, color, etc.', THEME_LANG ),
                        'default'   => array( ),
                        'output'      => array( '#footer' ),
                    ),
                    array(
                        'id'       => 'footer_border',
                        'type'     => 'border',
                        'title'    => __( 'Footer Border', THEME_LANG ),
                        'output'   => array( '#footer' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'bottom'      => false,
                        'default'  => array( )
                    ),
                    
                    // Footer top settings
                    array(
                        'id'       => 'footer_top_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer top settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_top_background',
                        'type'     => 'background',
                        'title'    => __( 'Footer top Background', THEME_LANG ),
                        'subtitle' => __( 'Footer top Background with image, color, etc.', THEME_LANG ),
                        'default'   => array( ),
                        'output'      => array( '#footer-top' ),
                    ),
                    array(
                        'id'       => 'footer_top_border',
                        'type'     => 'border',
                        'title'    => __( 'Footer top Border', THEME_LANG ),
                        'output'   => array( '#footer-top' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'top'      => false,
                        'default'  => array(
                            
                        )
                    ),
                    // Footer widgets settings
                    array(
                        'id'       => 'footer_widgets_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer widgets settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_widgets_border',
                        'type'     => 'border',
                        'title'    => __( 'Footer widgets Border', THEME_LANG ),
                        'output'   => array( '#footer-area' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'top'      => false,
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'footer_widgets_background',
                        'type'     => 'background',
                        'title'    => __( 'Footer widgets Background', THEME_LANG ),
                        'subtitle' => __( 'Footer widgets Background with image, color, etc.', THEME_LANG ),
                        'default'   => array( ),
                        'output'      => array( '#footer-area' ),
                    ),
                    array(
                        'id'       => 'footer_widgets_title_border',
                        'type'     => 'border',
                        'title'    => __( 'Footer widgets title border', THEME_LANG ),
                        'output'   => array( '#footer-area h3.widget-title' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'top'      => false,
                        'default'  => array( )
                    ),
                    
                    //Footer bottom settings
                    array(
                        'id'       => 'footer_bottom_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer bottom settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_bottom_background',
                        'type'     => 'background',
                        'title'    => __( 'Footer Background', THEME_LANG ),
                        'subtitle' => __( 'Footer Background with image, color, etc.', THEME_LANG ),
                        'default'   => array( ),
                        'output'      => array( '#footer-bottom' ),
                    ),

                    //Footer copyright settings
                    array(
                        'id'       => 'footer_copyright_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer copyright settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_copyright_background',
                        'type'     => 'background',
                        'title'    => __( 'Footer Background', THEME_LANG ),
                        'subtitle' => __( 'Footer Background with image, color, etc.', THEME_LANG ),
                        'default'   => array( ),
                        'output'      => array( '#footer-copyright' ),
                    ),
                    array(
                        'id'       => 'footer_copyright_link',
                        'type'     => 'link_color',
                        'title'    => __( 'Links Color', THEME_LANG ),
                        'output'      => array( '#footer-copyright a' ),
                        'default'  => array(  )
                    ),


                )
            );

            
            /**
			 *	Typography
			 **/
			$this->sections[] = array(
				'id'			=> 'typography',
				'title'			=> __( 'Typography', THEME_LANG ),
				'desc'			=> '',
				'icon_class'	=> 'icon_tool',
            );
            
            /**
			 *	Typography General
			 **/
			$this->sections[] = array(
				'id'			=> 'typography_general',
				'title'			=> __( 'General', THEME_LANG ),
				'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'typography_body',
                        'type'     => 'typography',
                        'title'    => __( 'Body Font', THEME_LANG ),
                        'subtitle' => __( 'Specify the body font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'body' ),
                        'default'  => array(
                            'color'       => '#666666',
                            'font-size'   => '14px',
                            'font-family' => 'Dosis',
                            'font-weight' => 'Normal',
                            'line-height' => '22px'
                        ),
                    ),
                    array(
                        'id'       => 'typography_pragraph',
                        'type'     => 'typography',
                        'title'    => __( 'Pragraph', THEME_LANG ),
                        'subtitle' => __( 'Specify the pragraph font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'p' ),
                        'default'  => array(
                            
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Typography Heading settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_heading1',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 1', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 1 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h1', '.h1' ),
                        'default'  => array(
                            'font-size'   => '36px',
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading2',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 2', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 2 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h2', '.h2' ),
                        'default'  => array(
                            'font-size'   => '30px',
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading3',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 3', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 3 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h3', '.h3' ),
                        'default'  => array(
                            'font-size'   => '24px',
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading4',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 4', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 4 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h4', '.h4' ),
                        'default'  => array(
                            'font-size'   => '18px',
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading5',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 5', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 5 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h5', '.h5' ),
                        'default'  => array(
                            'font-size'   => '14px',
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading6',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 6', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 6 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h6', '.h6' ),
                        'default'  => array(
                            'font-size'   => '12px',
                        ),
                    ),
                )
            );
            /**
			 *	Typography header
			 **/
			$this->sections[] = array(
				'id'			=> 'typography_header',
				'title'			=> __( 'Header', THEME_LANG ),
				'desc'			=> '',
                'subsection' => true,
				'fields'		=> array(
                    array(
                        'id'       => 'typography_header_content',
                        'type'     => 'typography',
                        'title'    => __( 'Header', THEME_LANG ),
                        'subtitle' => __( 'Specify the header title font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( '#header' )
                    )
                )
            );
            
            /**
			 *	Typography footer
			 **/
			$this->sections[] = array(
				'id'			=> 'typography_footer',
				'title'			=> __( 'Footer', THEME_LANG ),
				'desc'			=> '',
                'subsection' => true,
				'fields'		=> array(
                    array(
                        'id'       => 'typography_footer_top',
                        'type'     => 'typography',
                        'title'    => __( 'Footer top', THEME_LANG ),
                        'subtitle' => __( 'Specify the footer top font properties.', THEME_LANG ),
                        'google'   => true,

                        'text-align'      => false,
                        'color'           => false,

                        'output'      => array( '#footer-top' ),
                        'default'  => array(
                            'color'       => '',
                            'font-size'   => '',
                            'font-weight' => '',
                            'line-height' => ''
                        ),
                    ),
                    array(
                        'id'       => 'typography_footer_widgets',
                        'type'     => 'typography',
                        'title'    => __( 'Footer widgets', THEME_LANG ),
                        'subtitle' => __( 'Specify the footer widgets font properties.', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'output'      => array( '#footer-area' ),
                        'default'  => array(
                            'color'       => '',
                            'font-size'   => '',
                            'font-weight' => '',
                            'line-height' => ''
                        ),
                    ),
                    array(
                        'id'       => 'typography_footer_widgets_title',
                        'type'     => 'typography',
                        'title'    => __( 'Footer widgets title', THEME_LANG ),
                        'subtitle' => __( 'Specify the footer widgets title font properties.', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'output'      => array( '#footer-area h3.widget-title' ),
                        'default'  => array( ),
                    ),
                    array(
                        'id'       => 'typography_footer_copyright',
                        'type'     => 'typography',
                        'title'    => __( 'Footer copyright', THEME_LANG ),
                        'subtitle' => __( 'Specify the footer font properties.', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'output'      => array( '#footer-copyright' ),
                        'default'  => array(
                            'color'       => '',
                            'font-size'   => '',
                            'font-weight' => '',
                            'line-height' => ''
                        ),
                    ),

                    array(
                        'id'       => 'typography_footer_copyright_link',
                        'type'     => 'link_color',
                        'title'    => __( 'Links Color', THEME_LANG ),
                        'output'      => array( '#footer-copyright a' ),
                        'default'  => array(  )
                    ),

                )
            );
            /**
			 *	Typography sidebar
			 **/
			$this->sections[] = array(
				'id'			=> 'typography_sidebar',
				'title'			=> __( 'Sidebar', THEME_LANG ),
				'desc'			=> '',
                'subsection' => true,
				'fields'		=> array(
                    array(
                        'id'       => 'typography_sidebar_content',
                        'type'     => 'typography',
                        'title'    => __( 'Sidebar text', THEME_LANG ),
                        'subtitle' => __( 'Specify the sidebar title font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( '.sidebar', '.wpb_widgetised_column' ),
                        'default'  => array(
                        
                        ),
                    ),
                    array(
                        'id'       => 'typography_sidebar',
                        'type'     => 'typography',
                        'title'    => __( 'Sidebar title', THEME_LANG ),
                        'subtitle' => __( 'Specify the sidebar title font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( '.sidebar .widget-title', '.wpb_widgetised_column .widget-title' ),
                        'default'  => array(
                            'color'       => '#ffffff',
                            'font-size'   => '18px',
                            'font-weight' => 'Normal',
                            'line-height' => '30px'
                        ),
                    ),
                )
            );
            
            /**
			 *	Typography Navigation
			 **/
			$this->sections[] = array(
				'id'			=> 'typography_navigation',
				'title'			=> __( 'Main Navigation', THEME_LANG ),
				'desc'			=> '',
                'subsection' => true,
				'fields'		=> array(
                    array(
                        'id'       => 'typography-navigation_top',
                        'type'     => 'typography',
                        'title'    => __( 'Top Menu Level', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'output'      => array( '#nav > ul > li > a' )
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id'       => 'typography_navigation_dropdown',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Dropdown menu', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_navigation_second',
                        'type'     => 'typography',
                        'title'    => __( 'Second Menu Level', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'output'      => array(
                            '#main-nav-tool .kt-wpml-languages ul li > span',
                            '#main-nav-tool .kt-wpml-languages ul li > a',
                            '#main-navigation > li ul.sub-menu-dropdown > li > a'
                        )
                    ),
                    array(
                        'id'       => 'typography_navigation_mega',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Mega menu', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_navigation_heading',
                        'type'     => 'typography',
                        'title'    => __( 'Heading title', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'output'      => array( 
                            '#main-navigation > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > a',
                            '#main-navigation > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > span',
                            '#main-navigation > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li .widget-title'
                        ),
                        'default'  => array( ),
                    ),
                    array(
                        'id'       => 'typography_navigation_mega_link',
                        'type'     => 'typography',
                        'title'    => __( 'Mega menu', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'output'      => array(
                            '#main-navigation > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > .sub-menu-megamenu > li > a'
                        ),
                        'default'  => array( ),
                    )
                )
            );

            /**
             *	Sidebar
             **/
            $this->sections[] = array(
                'id'			=> 'sidebar_section',
                'title'			=> __( 'Sidebar Widgets', THEME_LANG ),
                'desc'			=> '',
                'fields'		=> array(

                    array(
                        'id'          => 'custom_sidebars',
                        'type'        => 'slides',
                        'title'       => __('Slides Options', THEME_LANG ),
                        'subtitle'    => __('Unlimited sidebar with drag and drop sortings.', THEME_LANG ),
                        'desc'        => '',
                        'class'       => 'slider-no-image-preview',
                        'content_title' =>'Sidebar',
                        'show' => array(
                            'title' => true,
                            'description' => true,
                            'url' => false,
                        ),
                        'placeholder' => array(
                            'title'           => __('Sidebar title', THEME_LANG ),
                            'description'     => __('Sidebar Description', THEME_LANG ),
                        ),
                    ),
                )
            );

            /**
             *	Page header
             **/
            $this->sections[] = array(
                'id'			=> 'page_header_section',
                'title'			=> __( 'Page header', THEME_LANG ),
                'desc'			=> '',
                'fields'		=> array(

                    array(
                        'id'       => 'title_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Page header settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'title_align',
                        'type'     => 'select',
                        'title'    => __( 'Page header align', THEME_LANG ),
                        'subtitle'     => __( 'Please select page header align', THEME_LANG ),
                        'options'  => array(
                            'left' => __('Left', THEME_LANG ),
                            'center' => __('Center', THEME_LANG),
                            'right' => __('Right', THEME_LANG)
                        ),
                        'default'  => 'left',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'title_breadcrumbs',
                        'type'     => 'switch',
                        'title'    => __( 'Show breadcrumbs', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'title_breadcrumbs_mobile',
                        'type'     => 'switch',
                        'title'    => __( 'Breadcrumbs on Mobile Devices', THEME_LANG ),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'title_separator',
                        'type'     => 'switch',
                        'title'    => __( 'Separator bettwen title and subtitle', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'title_separator_color',
                        'type'     => 'color',
                        'title'    => __( 'Separator Color', THEME_LANG ),
                        'default'  => '',
                        'transparent' => false,
                        'required' => array('title_separator','equals', array( 1 ) ),
                    ),
                    array(
                        'id'       => 'title_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '.page-header' ),
                        'units'          => array( 'em', 'px' ),
                        'units_extended' => 'true',
                        'title'    => __( 'Title padding', THEME_LANG ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'title_background',
                        'type'     => 'background',
                        'title'    => __( 'Background', THEME_LANG ),
                        'subtitle' => __( 'Page header with image, color, etc.', THEME_LANG ),
                        'output'      => array( '.page-header' ),
                        'default'   => array( ),
                    ),
                    array(
                        'id'       => 'title_parallax',
                        'type'     => 'switch',
                        'title'    => __( 'Parallax Background Image', THEME_LANG ),
                        'subtitle' => __( 'Enable parallax background image when scrolling.', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'title_typography',
                        'type'     => 'typography',
                        'title'    => __( 'Typography title', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'line-height'     => false,
                        'output'      => array( '.page-header h1.page-header-title' )
                    ),
                    array(
                        'id'       => 'title_typography_subtitle',
                        'type'     => 'typography',
                        'title'    => __( 'Typography sub title', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'line-height'     => false,
                        'output'      => array( '.page-header .page-header-tagline' )
                    ),

                    array(
                        'id'       => 'title_typography_breadcrumbs',
                        'type'     => 'typography',
                        'title'    => __( 'Typography breadcrumbs', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'line-height'     => false,
                        'output'      => array( '.page-header .breadcrumbs', '.page-header .breadcrumbs a' )
                    ),
                    array(
                        'id'       => 'title_breadcrumbs_color',
                        'type'     => 'color',
                        'title'    => __( 'Breadcrumbs Color', THEME_LANG ),
                        'default'  => '',
                        'transparent' => false,
                    ),




                )
            );


            /**
             * General page
             *
             */
            $this->sections[] = array(
                'icon' => 'el-icon-star',
                'title' => __('Page', THEME_LANG),
                'desc' => __('General Page Options', THEME_LANG),
                'fields' => array(
                    array(
                        'id' => 'show_page_header',
                        'type' => 'switch',
                        'title' => __('Show Page header', THEME_LANG),
                        'desc' => __('Show page header or?.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),

                    array(
                        'id'       => 'sidebar',
                        'type'     => 'select',
                        'title'    => __( 'Sidebar configuration', THEME_LANG ),
                        'subtitle'     => __( "Please choose page layout", THEME_LANG ),
                        'options'  => array(
                            'full' => __('No sidebars', THEME_LANG),
                            'left' => __('Left Sidebar', THEME_LANG),
                            'right' => __('Right Layout', THEME_LANG)
                        ),
                        'default'  => 'right',
                        'clear' => false,
                    ),
                    array(
                        'id'       => 'sidebar_left',
                        'type' => 'select',
                        'title'    => __( 'Sidebar left area', THEME_LANG ),
                        'subtitle'     => __( "Please choose default layout", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'primary-widget-area',
                        'required' => array('sidebar','equals','left')
                        //'clear' => false
                    ),
                    array(
                        'id'       => 'sidebar_right',
                        'type'     => 'select',
                        'title'    => __( 'Sidebar right area', THEME_LANG ),
                        'subtitle'     => __( "Please choose page layout", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'primary-widget-area',
                        'required' => array('sidebar','equals','right')
                        //'clear' => false
                    ),



                    array(
                        'id' => 'show_page_comment',
                        'type' => 'switch',
                        'title' => __('Show comments on page ?', THEME_LANG),
                        'desc' => __('Show or hide the readmore button.', THEME_LANG),
                        "default" => 0,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),

                )
            );

            /**
             * General Blog
             *
             */
            $this->sections[] = array(
                'icon' => 'el-icon-star',
                'title' => __('Blog', THEME_LANG),
                'desc' => __('General Blog Options', THEME_LANG),
                'fields' => array(

                )
            );

            /**
             *	Archive settings
             **/
            $this->sections[] = array(
                'id'			=> 'archive_section',
                'title'			=> __( 'Archive', THEME_LANG ),
                'desc'			=> 'Archive post settings',
                'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'archive_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Archive post general', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'archive_page_header',
                        'type' => 'switch',
                        'title' => __('Show Page header', THEME_LANG),
                        'desc' => __('Show page header or?.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id'       => 'archive_sidebar',
                        'type'     => 'select',
                        'title'    => __( 'Sidebar configuration', THEME_LANG ),
                        'subtitle'     => __( "Please choose archive page ", THEME_LANG ),
                        'options'  => array(
                            'full' => __('No sidebars', THEME_LANG),
                            'left' => __('Left Sidebar', THEME_LANG),
                            'right' => __('Right Layout', THEME_LANG)
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'archive_sidebar_left',
                        'type' => 'select',
                        'title'    => __( 'Sidebar left area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'blog-widget-area',
                        'required' => array('archive_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'archive_sidebar_right',
                        'type'     => 'select',
                        'title'    => __( 'Sidebar right area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'blog-widget-area',
                        'required' => array('archive_sidebar','equals','right'),
                        'clear' => false
                    ),
                    array(
                        'id' => 'archive_loop_style',
                        'type' => 'select',
                        'title' => __('Loop Style', THEME_LANG),
                        'desc' => '',
                        'options' => array(
                            'classic' => __( 'Classic', 'js_composer' ),
                            'grid' => __( 'Grid', 'js_composer' ),
                            'masonry' => __( 'Masonry', 'js_composer' ),
                        ),
                        'default' => 'classic'
                    ),
                    array(
                        'id' => 'archive_sharebox',
                        'type' => 'switch',
                        'title' => __('Share box', THEME_LANG),
                        'desc' => __('Show or hide share box.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required' => array('archive_loop_style','equals', array( 'classic' ) ),
                    ),
                    array(
                        'id' => 'archive_columns',
                        'type' => 'select',
                        'title' => __('Columns on desktop', THEME_LANG),
                        'desc' => '',
                        'options' => array(
                            '1' => __( '1 column', 'js_composer' ) ,
                            '2' => __( '2 columns', 'js_composer' ) ,
                            '3' => __( '3 columns', 'js_composer' ) ,
                            '4' => __( '4 columns', 'js_composer' ) ,
                            '6' => __( '6 columns', 'js_composer' ) ,
                        ),
                        'default' => '3',
                        'required' => array('archive_loop_style','equals', array( 'grid', 'masonry' ) ),
                    ),
                    array(
                        'id' => 'archive_columns_tablet',
                        'type' => 'select',
                        'title' => __('Columns on Tablet', THEME_LANG),
                        'desc' => '',
                        'options' => array(
                            '1' => __( '1 column', 'js_composer' ) ,
                            '2' => __( '2 columns', 'js_composer' ) ,
                            '3' => __( '3 columns', 'js_composer' ) ,
                            '4' => __( '4 columns', 'js_composer' ) ,
                            '6' => __( '6 columns', 'js_composer' ) ,
                        ),
                        'default' => '2',
                        'required' => array('archive_loop_style','equals', array( 'grid', 'masonry' ) ),
                    ),
                    array(
                        'id' => 'archive_layout',
                        'type' => 'select',
                        'title' => __('Post layout', THEME_LANG),
                        'desc' => '',
                        'options' => array(
                            '1' => __( 'Layout 1', THEME_LANG ) ,
                            '2' => __( 'Layout 2', THEME_LANG ) ,
                            '3' => __( 'Layout 3', THEME_LANG ) ,
                        ),
                        'default' => '1',
                        'required' => array('archive_loop_style','equals', array( 'grid', 'masonry' ) ),
                    ),
                    array(
                        'id' => 'archive_readmore',
                        'type' => 'switch',
                        'title' => __('Readmore button ', THEME_LANG),
                        'desc' => __('Show or hide the readmore button.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id' => 'archive_thumbnail_type',
                        'type' => 'select',
                        'title' => __('Thumbnail type', THEME_LANG),
                        'desc' => '',
                        'options' => array(
                            'format' => __( 'Post format', THEME_LANG ) ,
                            'image' => __( 'Featured Image', THEME_LANG ) ,
                        ),
                        'default' => 'image'
                    ),
                    array(
                        'id' => 'archive_pagination',
                        'type' => 'select',
                        'title' => __('Pagination Type', THEME_LANG),
                        'desc' => __('Select the pagination type.', THEME_LANG),
                        'options' => array(
                            'classic' => __( 'Classic pagination', THEME_LANG ),
                            'loadmore' => __( 'Load More button', THEME_LANG )
                        ),
                        'default' => 'classic'
                    ),
                    array(
                        'id' => 'archive_excerpt_length',
                        'type' => 'text',
                        'title' => __('Excerpt Length', THEME_LANG),
                        'desc' => __("Insert the number of words you want to show in the post excerpts.", THEME_LANG),
                        'default' => '30',
                    ),



                    array(
                        'id'   => 'archive_image_size',
                        'type' => 'select',
                        'options' => $image_sizes,
                        'title'    => __( 'Image size', THEME_LANG ),
                        'desc' => __("Select image size.", THEME_LANG),
                        'default' => 'blog_post'
                    ),


                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'archive_meta',
                        'type' => 'switch',
                        'title' => __('Show Meta? ', THEME_LANG),
                        'desc' => __('Show or hide the meta.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),

                    array(
                        'id' => 'archive_meta_author',
                        'type' => 'switch',
                        'title' => __('Post Meta Author', THEME_LANG),
                        'desc' => __('Show meta author in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required' => array('archive_meta','equals', array( 1 ) ),
                    ),
                    array(
                        'id' => 'archive_meta_comments',
                        'type' => 'switch',
                        'title' => __('Post Meta Comments', THEME_LANG),
                        'desc' => __('Show post meta comments in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required' => array('archive_meta','equals', array( 1 ) ),
                    ),
                    array(
                        'id' => 'archive_meta_categories',
                        'type' => 'switch',
                        'title' => __('Post Meta Categories', THEME_LANG),
                        'desc' => __('Show post meta categories in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required' => array('archive_meta','equals', array( 1 ) ),
                    ),

                    array(
                        'id' => 'archive_meta_date',
                        'type' => 'switch',
                        'title' => __('Post Meta Date', THEME_LANG),
                        'desc' => __('Show meta date in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required' => array('archive_meta','equals', array( 1 ) ),
                    ),
                    array(
                        'id' => 'archive_date_format',
                        'type' => 'select',
                        'title' => __('Date format', THEME_LANG),
                        'desc' => __('Select the pagination type.', THEME_LANG),
                        'options' => array(
                            'd F Y' => __( '05 December 2014', 'js_composer' ) ,
                            'F jS Y' => __( 'December 13th 2014', 'js_composer' ) ,
                            'jS F Y' => __( '13th December 2014', 'js_composer' ) ,
                            'd M Y' => __( '05 Dec 2014', 'js_composer' ) ,
                            'M d Y' => __( 'Dec 05 2014', 'js_composer' ) ,
                            'time' => __( 'Time ago', 'js_composer' ) ,
                        ),
                        'default' => 'd F Y',
                        'required' => array('archive_meta','equals', array( 1 ) ),
                    ),

                )
            );


            /**
             *	Single post settings
             **/
            $this->sections[] = array(
                'id'			=> 'post_single_section',
                'title'			=> __( 'Single Post', THEME_LANG ),
                'desc'			=> 'Single post settings',
                'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'blog_single_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Single post general', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'single_page_header',
                        'type' => 'switch',
                        'title' => __('Show Page header', THEME_LANG),
                        'desc' => __('Show page header or?.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id'       => 'blog_sidebar',
                        'type'     => 'select',
                        'title'    => __( 'Single Post: Sidebar configuration', THEME_LANG ),
                        'subtitle'     => __( "Please choose sidebar for single post", THEME_LANG ),
                        'options'  => array(
                            'full' => __('No sidebars', THEME_LANG),
                            'left' => __('Left Sidebar', THEME_LANG),
                            'right' => __('Right Layout', THEME_LANG)
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'blog_sidebar_left',
                        'type' => 'select',
                        'title'    => __( 'Single post: Sidebar left area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'blog-widget-area',
                        'required' => array('blog_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'blog_sidebar_right',
                        'type'     => 'select',
                        'title'    => __( 'Single post: Sidebar right area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'blog-widget-area',
                        'required' => array('blog_sidebar','equals','right'),
                        'clear' => false
                    ),
                    array(
                        'id' => 'blog_post_format',
                        'type' => 'switch',
                        'title' => __('Show Post format ', THEME_LANG),
                        'desc' => __('', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id' => 'blog_post_format_position',
                        'type' => 'select',
                        'title' => __('Post format position', THEME_LANG),
                        'desc' => __('Select the format position.', THEME_LANG),
                        'options' => array(
                            'content' => __( 'Content', THEME_LANG ),
                            'fullwidth' => __( 'Fullwidth', THEME_LANG ),
                        ),
                        'default' => 'content'
                    ),
                    array(
                        'id'   => 'blog_image_size',
                        'type' => 'select',
                        'options' => $image_sizes,
                        'title'    => __( 'Image size', THEME_LANG ),
                        'desc' => __("Select image size.", THEME_LANG),
                        'default' => 'blog_post'
                    ),
                    array(
                        'id' => 'blog_share_box',
                        'type' => 'switch',
                        'title' => __('Share box in posts', THEME_LANG),
                        'desc' => __('Show share box in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id' => 'blog_next_prev',
                        'type' => 'switch',
                        'title' => __('Previous & next buttons', THEME_LANG),
                        'desc' => __('Show Previous & next buttons in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id' => 'blog_author',
                        'type' => 'switch',
                        'title' => __('Author info in posts', THEME_LANG),
                        'desc' => __('Show author info in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id' => 'blog_related',
                        'type' => 'switch',
                        'title' => __('Related posts', THEME_LANG),
                        'desc' => __('Show related posts in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id'       => 'blog_related_type',
                        'type'     => 'select',
                        'title'    => __( 'Single Post: Related Query Type', THEME_LANG ),
                        'subtitle'     => __( "Please choose sidebar for single post", THEME_LANG ),
                        'options'  => array(
                            'categories' => __('Categories', THEME_LANG),
                            'tags' => __('Tags', THEME_LANG),
                            'author' => __('Author', THEME_LANG)
                        ),
                        'default'  => 'categories',
                        'clear' => false,
                    ),

                    array(
                        'id' => 'blog_related_full',
                        'type' => 'text',
                        'title' => __('Related total for full width', THEME_LANG),
                        'subtitle' => '',
                        'desc' => '',
                        'default' => '3',
                    ),
                    array(
                        'id' => 'blog_related_sidebar',
                        'type' => 'text',
                        'title' => __('Related total for sidebar', THEME_LANG),
                        'subtitle' => '',
                        'desc' => '',
                        'default' => '2'
                    ),

                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'blog_meta',
                        'type' => 'switch',
                        'title' => __('Meta information', THEME_LANG),
                        'desc' => __('Show Meta information in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),



                    array(
                        'id' => 'blog_meta_author',
                        'type' => 'switch',
                        'title' => __('Post Meta Author', THEME_LANG),
                        'desc' => __('Show meta author in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required'  => array('blog_meta', "=", 1),
                    ),

                    array(
                        'id' => 'blog_meta_comments',
                        'type' => 'switch',
                        'title' => __('Post Meta Comments', THEME_LANG),
                        'desc' => __('Show post meta comments in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required'  => array('blog_meta', "=", 1),
                    ),
                    array(
                        'id' => 'blog_meta_categories',
                        'type' => 'switch',
                        'title' => __('Post Meta Categories', THEME_LANG),
                        'desc' => __('Show post meta categories in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required'  => array('blog_meta', "=", 1),
                    ),

                    array(
                        'id' => 'blog_meta_date',
                        'type' => 'switch',
                        'title' => __('Post Meta Date', THEME_LANG),
                        'desc' => __('Show meta date in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required'  => array('blog_meta', "=", 1),
                    ),
                    array(
                        'id' => 'blog_date_format',
                        'type' => 'select',
                        'title' => __('Date format', THEME_LANG),
                        'desc' => __('Select the pagination type.', THEME_LANG),
                        'options' => array(
                            'd F Y' => __( '05 December 2014', 'js_composer' ) ,
                            'F jS Y' => __( 'December 13th 2014', 'js_composer' ) ,
                            'jS F Y' => __( '13th December 2014', 'js_composer' ) ,
                            'd M Y' => __( '05 Dec 2014', 'js_composer' ) ,
                            'M d Y' => __( 'Dec 05 2014', 'js_composer' ) ,
                            'time' => __( 'Time ago', 'js_composer' ) ,
                        ),
                        'default' => 'd F Y',
                        'required' => array('blog_meta_date','equals', array( 1 ) ),
                    ),

                )
            );

            /**
             *	Search settings
             **/
            $this->sections[] = array(
                'id'			=> 'search_section',
                'title'			=> __( 'Search', THEME_LANG ),
                'desc'			=> 'Search settings',
                'fields'		=> array(
                    array(
                        'id'       => 'search_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Search post general', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'search_sidebar',
                        'type'     => 'select',
                        'title'    => __( 'Search: Sidebar configuration', THEME_LANG ),
                        'subtitle'     => __( "Please choose archive page ", THEME_LANG ),
                        'options'  => array(
                            'full' => __('No sidebars', THEME_LANG),
                            'left' => __('Left Sidebar', THEME_LANG),
                            'right' => __('Right Layout', THEME_LANG)
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'search_sidebar_left',
                        'type' => 'select',
                        'title'    => __( 'Search: Sidebar left area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'blog-widget-area',
                        'required' => array('archive_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'search_sidebar_right',
                        'type'     => 'select',
                        'title'    => __( 'Search: Sidebar right area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'blog-widget-area',
                        'required' => array('archive_sidebar','equals','right'),
                        'clear' => false
                    ),
                    array(
                        'id' => 'search_loop_style',
                        'type' => 'select',
                        'title' => __('Search Loop Style', THEME_LANG),
                        'desc' => '',
                        'options' => array(
                            'classic' => __( 'Classic', 'js_composer' ),
                            'grid' => __( 'Grid', 'js_composer' ),
                            'masonry' => __( 'Masonry', 'js_composer' ),
                        ),
                        'default' => 'classic'
                    ),
                    array(
                        'id' => 'search_sharebox',
                        'type' => 'switch',
                        'title' => __('Share box', THEME_LANG),
                        'desc' => __('Show or hide share box.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required' => array('search_loop_style','equals', array( 'classic' ) ),
                    ),
                    array(
                        'id' => 'search_columns',
                        'type' => 'select',
                        'title' => __('Columns on desktop', THEME_LANG),
                        'desc' => '',
                        'options' => array(
                            '1' => __( '1 column', 'js_composer' ) ,
                            '2' => __( '2 columns', 'js_composer' ) ,
                            '3' => __( '3 columns', 'js_composer' ) ,
                            '4' => __( '4 columns', 'js_composer' ) ,
                            '6' => __( '6 columns', 'js_composer' ) ,
                        ),
                        'default' => '3',
                        'required' => array('search_loop_style','equals', array( 'grid', 'masonry' ) ),
                    ),
                    array(
                        'id' => 'search_columns_tablet',
                        'type' => 'select',
                        'title' => __('Columns on Tablet', THEME_LANG),
                        'desc' => '',
                        'options' => array(
                            '1' => __( '1 column', 'js_composer' ) ,
                            '2' => __( '2 columns', 'js_composer' ) ,
                            '3' => __( '3 columns', 'js_composer' ) ,
                            '4' => __( '4 columns', 'js_composer' ) ,
                            '6' => __( '6 columns', 'js_composer' ) ,
                        ),
                        'default' => '2',
                        'required' => array('search_loop_style','equals', array( 'grid', 'masonry' ) ),
                    ),
                    array(
                        'id' => 'search_layout',
                        'type' => 'select',
                        'title' => __('Post layout', THEME_LANG),
                        'desc' => '',
                        'options' => array(
                            '1' => __( 'Layout 1', THEME_LANG ) ,
                            '2' => __( 'Layout 2', THEME_LANG ) ,
                            '3' => __( 'Layout 3', THEME_LANG ) ,
                        ),
                        'default' => '1',
                        'required' => array('search_loop_style','equals', array( 'grid', 'masonry' ) ),
                    ),
                    array(
                        'id' => 'search_readmore',
                        'type' => 'switch',
                        'title' => __('Readmore button ', THEME_LANG),
                        'desc' => __('Show or hide the readmore button.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id' => 'search_pagination',
                        'type' => 'select',
                        'title' => __('Pagination Type', THEME_LANG),
                        'desc' => __('Select the pagination type.', THEME_LANG),
                        'options' => array(
                            'classic' => __( 'Classic pagination', THEME_LANG ),
                            'loadmore' => __( 'Load More button', THEME_LANG )
                        ),
                        'default' => 'classic'
                    ),
                    array(
                        'id' => 'search_excerpt_length',
                        'type' => 'text',
                        'title' => __('Excerpt Length', THEME_LANG),
                        'desc' => __("Insert the number of words you want to show in the post excerpts.", THEME_LANG),
                        'default' => '30',
                    ),
                    array(
                        'id'   => 'search_image_size',
                        'type' => 'select',
                        'options' => $image_sizes,
                        'title'    => __( 'Image size', THEME_LANG ),
                        'desc' => __("Select image size.", THEME_LANG),
                        'default' => 'blog_post'
                    ),

                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'search_meta',
                        'type' => 'switch',
                        'title' => __('Show Meta? ', THEME_LANG),
                        'desc' => __('Show or hide the meta.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),

                    array(
                        'id' => 'search_meta_author',
                        'type' => 'switch',
                        'title' => __('Post Meta Author', THEME_LANG),
                        'desc' => __('Show meta author in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required' => array('search_meta','equals', array( 1 ) ),
                    ),
                    array(
                        'id' => 'search_meta_comments',
                        'type' => 'switch',
                        'title' => __('Post Meta Comments', THEME_LANG),
                        'desc' => __('Show post meta comments in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required' => array('search_meta','equals', array( 1 ) ),
                    ),
                    array(
                        'id' => 'search_meta_categories',
                        'type' => 'switch',
                        'title' => __('Post Meta Categories', THEME_LANG),
                        'desc' => __('Show post meta categories in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required' => array('search_meta','equals', array( 1 ) ),
                    ),

                    array(
                        'id' => 'search_meta_date',
                        'type' => 'switch',
                        'title' => __('Post Meta Date', THEME_LANG),
                        'desc' => __('Show meta date in blog posts.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG),
                        'required' => array('search_meta','equals', array( 1 ) ),
                    ),
                    array(
                        'id' => 'search_date_format',
                        'type' => 'select',
                        'title' => __('Date format', THEME_LANG),
                        'desc' => __('Select the pagination type.', THEME_LANG),
                        'options' => array(
                            'd F Y' => __( '05 December 2014', 'js_composer' ) ,
                            'F jS Y' => __( 'December 13th 2014', 'js_composer' ) ,
                            'jS F Y' => __( '13th December 2014', 'js_composer' ) ,
                            'd M Y' => __( '05 Dec 2014', 'js_composer' ) ,
                            'M d Y' => __( 'Dec 05 2014', 'js_composer' ) ,
                            'time' => __( 'Time ago', 'js_composer' ) ,
                        ),
                        'default' => 'd F Y',
                        'required' => array('search_meta','equals', array( 1 ) ),
                    ),
                )
            );

            /**
             *	404 Page
             **/
            $this->sections[] = array(
                'id'			=> '404_section',
                'title'			=> __( '404 Page', THEME_LANG ),
                'desc'			=> '404 Page settings',
                'fields'		=> array(
                    array(
                        'id'       => 'notfound_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( '404 Page general', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'notfound_page_header',
                        'type' => 'switch',
                        'title' => __('Show Page header', THEME_LANG),
                        'desc' => __('Show page header or?.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id' => 'notfound_page_type',
                        'type' => 'select',
                        'title' => __('404 Page', THEME_LANG),
                        'desc' => '',
                        'options' => array(
                            'default' => __( 'Default', THEME_LANG ) ,
                            'page' => __( 'From Page', THEME_LANG ) ,
                            'home' => __( 'Redirect Home', THEME_LANG ) ,
                        ),
                        'default' => 'default',
                    ),

                )
            );

            /**
			 *	Woocommerce
			 **/
			$this->sections[] = array(
				'id'			=> 'woocommerce',
				'title'			=> __( 'Woocommerce', THEME_LANG ),
				'desc'			=> '',
				'icon_class'	=> 'icon_cart_alt',
				'fields'		=> array(
                    array(
                        'id'       => 'shop_products_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Shop Products settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'shop_page_header',
                        'type' => 'switch',
                        'title' => __('Show Page header', THEME_LANG),
                        'desc' => __('Show page header or?.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id'       => 'shop_sidebar',
                        'type'     => 'select',
                        'title'    => __( 'Shop: Sidebar configuration', THEME_LANG ),
                        'subtitle'     => __( "Please choose sidebar for shop post", THEME_LANG ),
                        'options'  => array(
                            'full' => __('No sidebars', THEME_LANG),
                            'left' => __('Left Sidebar', THEME_LANG),
                            'right' => __('Right Layout', THEME_LANG)
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'shop_sidebar_left',
                        'type' => 'select',
                        'title'    => __( 'Shop: Sidebar left area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'shop-widget-area',
                        'required' => array('shop_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'shop_sidebar_right',
                        'type'     => 'select',
                        'title'    => __( 'Shop: Sidebar right area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'shop-widget-area',
                        'required' => array('shop_sidebar','equals','right'),
                        'clear' => false
                    ),

                    array(
                        'id'       => 'shop_products_layout',
                        'type'     => 'select',
                        'title'    => __( 'Shop: Products default Layout', THEME_LANG ),
                        'options'  => array(
                            'grid' => __('Grid', THEME_LANG ),
                            'lists' => __('Lists', THEME_LANG )
                        ),
                        'default'  => 'grid'
                    ),
                    array(
                        'id'       => 'shop_gird_cols',
                        'type'     => 'select',
                        'title'    => __( 'Number column to display width gird mod', THEME_LANG ),
                        'options'  => array(
                            '2' => 2,
                            '3' => 3,
                            '4' => 4,
                        ),
                        'default'  => 3,
                    ),
                    array(
                        'id'       => 'shop_products_effect',
                        'type'     => 'select',
                        'title'    => __( 'Shop product effect', THEME_LANG ),
                        'options'  => array(
                            'center' => __('Center', THEME_LANG ),
                            'bottom' => __('Bottom', THEME_LANG )
                        ),
                        'default'  => 'center'
                    ),
                    array(
                        'id'       => 'loop_shop_per_page',
                        'type'     => 'text',
                        'title'    => __( 'Number of products displayed per page', THEME_LANG ),
                        'default'  => '18'
                    ),




                    // For Single Products
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'shop_single_product',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Shop Product settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'product_page_header',
                        'type' => 'switch',
                        'title' => __('Show Page header', THEME_LANG),
                        'desc' => __('Show page header or?.', THEME_LANG),
                        "default" => 1,
                        'on' => __('Enabled', THEME_LANG),
                        'off' =>__('Disabled', THEME_LANG)
                    ),
                    array(
                        'id'       => 'product_sidebar',
                        'type'     => 'select',
                        'title'    => __( 'Product: Sidebar configuration', THEME_LANG ),
                        'subtitle'     => __( "Please choose single product page ", THEME_LANG ),
                        'options'  => array(
                            'full' => __('No sidebars', THEME_LANG),
                            'left' => __('Left Sidebar', THEME_LANG),
                            'right' => __('Right Layout', THEME_LANG)
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'product_sidebar_left',
                        'type' => 'select',
                        'title'    => __( 'Product: Sidebar left area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'shop-widget-area',
                        'required' => array('product_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'product_sidebar_right',
                        'type'     => 'select',
                        'title'    => __( 'Product: Sidebar right area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'shop-widget-area',
                        'required' => array('product_sidebar','equals','right'),
                        'clear' => false
                    ),

                    //Slider effect: Lightbox - Zoom
                    //Product description position - Tab, Below
                    //Product reviews position - Tab,Below
                    //Social Media Sharing Buttons
                    //Single Product Gallery Type

                )
            );
            $this->sections[] = array(
				'id'			=> 'social',
				'title'			=> __( 'Socials', THEME_LANG ),
				'desc'			=> __('Social and share settings', THEME_LANG),
				'icon_class'	=> 'social_facebook',
				'fields'		=> array(

                    array(
						'id' => 'twitter',
						'type' => 'text',
						'title' => __('Twitter', THEME_LANG),
						'subtitle' => __("Your Twitter username (no @).", THEME_LANG),
						'default' => ''
                    ),
                    array(
						'id' => 'facebook',
						'type' => 'text',
						'title' => __('Facebook', THEME_LANG),
						'subtitle' => __("Your Facebook page/profile url", THEME_LANG),
						'default' => ''
                    ),
                    array(
						'id' => 'pinterest',
						'type' => 'text',
						'title' => __('Pinterest', THEME_LANG),
						'subtitle' => __("Your Pinterest username", THEME_LANG),
						'default' => ''
                    ),
                    array(
						'id' => 'dribbble',
						'type' => 'text',
						'title' => __('Dribbble', THEME_LANG),
						'subtitle' => __("Your Dribbble username", THEME_LANG),
						'desc' => '',
						'default' => ''
				    ),
                    array(
						'id' => 'vimeo',
						'type' => 'text',
						'title' => __('Vimeo', THEME_LANG),
						'subtitle' => __("Your Vimeo username", THEME_LANG),
						'desc' => '',
						'default' => ''
                    ),
                    array(
						'id' => 'tumblr',
						'type' => 'text',
						'title' => __('Tumblr', THEME_LANG),
						'subtitle' => __("Your Tumblr username", THEME_LANG),
						'desc' => '',
						'default' => ''
				    ),
                    array(
						'id' => 'skype',
						'type' => 'text',
						'title' => __('Skype', THEME_LANG),
						'subtitle' => __("Your Skype username", THEME_LANG),
						'desc' => '',
						'default' => ''
					),
                    array(
						'id' => 'linkedin',
						'type' => 'text',
						'title' => __('LinkedIn', THEME_LANG),
						'subtitle' => __("Your LinkedIn page/profile url", THEME_LANG),
						'desc' => '',
						'default' => ''
					),
					array(
						'id' => 'googleplus',
						'type' => 'text',
						'title' => __('Google+', THEME_LANG),
						'subtitle' => __("Your Google+ page/profile URL", THEME_LANG),
						'desc' => '',
						'default' => ''
					),
					array(
						'id' => 'youtube',
						'type' => 'text',
						'title' => __('YouTube', THEME_LANG),
						'subtitle' => __("Your YouTube username", THEME_LANG),
						'desc' => '',
						'default' => ''
					),
					array(
						'id' => 'instagram',
						'type' => 'text',
						'title' => __('Instagram', THEME_LANG),
						'subtitle' => __("Your Instagram username", THEME_LANG),
						'desc' => '',
						'default' => ''
					)
                )
            );
            
            /**
			 *	Import Demo
			 **/
            $this->sections[] = array(
                 'id' => 'wbc_importer_section',
                 'title'  => esc_html__( 'Demo Content', 'framework' ),
                 'desc'   => esc_html__( 'Chose a demo to import', 'framework' ),
                 'icon'   => 'el-icon-website',
                 'fields' => array(
                     array(
                         'id'   => 'wbc_demo_importer',
                         'type' => 'wbc_importer'
                     )
                 )
            );


            /**
			 *	Advanced
			 **/
			$this->sections[] = array(
				'id'			=> 'advanced',
				'title'			=> __( 'Advanced', THEME_LANG ),
				'desc'			=> '',
                'icon_class'	=> 'icon_star_alt',
            );


            /**
             *	Advanced Social Share
             **/
            $this->sections[] = array(
                'id'			=> 'share_section',
                'title'			=> __( 'Social Share', THEME_LANG ),
                'desc'			=> '',
                'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'social_share',
                        'type'     => 'sortable',
                        'mode'     => 'checkbox', // checkbox or text
                        'title'    => __( 'Social Share', THEME_LANG ),
                        'desc'     => __( 'Reorder and Enable/Disable Social Share Buttons.', THEME_LANG ),
                        'options'  => array(
                            'facebook' => __('Facebook', THEME_LANG),
                            'twitter' => __('Twitter', THEME_LANG),
                            'google_plus' => __('Google+', THEME_LANG),
                            'pinterest' => __('Pinterest', THEME_LANG),
                            'linkedin' => __('Linkedin', THEME_LANG),
                            'tumblr' => __('Tumblr', THEME_LANG),
                            'mail' => __('Mail', THEME_LANG),
                        ),
                        'default'  => array(
                            'facebook' => true,
                            'twitter' => true,
                            'google_plus' => true,
                            'pinterest' => true,
                            'linkedin' => true,
                            'tumblr' => true,
                            'mail' => true,
                        )
                    )
                )
            );


            /**
             *	Advanced Mail Chimp API
             **/
            $this->sections[] = array(
                'id'			=> 'socials_api_section',
                'title'			=> __( 'Socials API', THEME_LANG ),
                'desc'			=> '',
                'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'twitter_api_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Twitter API', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'twitter_consumer_key',
                        'type' => 'text',
                        'title' => __('Twitter Consumer Key', THEME_LANG),
                        'subtitle' => __('Your twitter Consumer Key', THEME_LANG),
                        'desc' => sprintf( __( '%sClick Here%s to learn about these keys.', THEME_LANG ), '<a href="#" target="_blank">', '</a>'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'twitter_consumer_secret',
                        'type' => 'text',
                        'title' => __('Twitter Consumer Secret', THEME_LANG),
                        'subtitle' => __("Your twitter Consumer Secret.", THEME_LANG),
                        'default' => ''
                    ),
                    array(
                        'id' => 'twitter_access_key',
                        'type' => 'text',
                        'title' => __('Twitter Access Token', THEME_LANG),
                        'subtitle' => __("Your twitter Access Token.", THEME_LANG),
                        'default' => ''
                    ),
                    array(
                        'id' => 'twitter_access_secret',
                        'type' => 'text',
                        'title' => __('Twitter Access Token Secret', THEME_LANG),
                        'subtitle' => __("Your twitter Access Token Secret.", THEME_LANG),
                        'default' => ''
                    ),
                    array(
                        'id'       => 'facebook_app_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Facebook App', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'facebook_app',
                        'type' => 'text',
                        'title' => __('Facebook App ID', THEME_LANG),
                        'subtitle' => __("Add Facebook App ID.", THEME_LANG),
                        'default' => '417674911655656'
                    ),
                    array(
                        'id'       => 'mailchimp_api_key_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Mail Chimp API', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'mailchimp_api_key',
                        'type' => 'text',
                        'title' => __('Mail Chimp API Key', THEME_LANG),
                        'subtitle' => __('Your Mail Chimp API Key', THEME_LANG),
                        'desc' => sprintf( __( '%sClick Here%s to learn about these keys.', THEME_LANG ), '<a href="#" target="_blank">', '</a>'),
                        'default' => 'acf783f889d685580748b6c543235ef9-us5'
                    ),
                )
            );






            /**
			 *	Advanced Custom CSS
			 **/
			$this->sections[] = array(
				'id'			=> 'advanced_css',
				'title'			=> __( 'Custom CSS', THEME_LANG ),
				'desc'			=> '',
                'subsection' => true,
				'fields'		=> array(
                    array(
                        'id'       => 'advanced_editor_css',
                        'type'     => 'ace_editor',
                        'title'    => __( 'CSS Code', THEME_LANG ),
                        'subtitle' => __( 'Paste your CSS code here.', THEME_LANG ),
                        'mode'     => 'css',
                        'theme'    => 'chrome',
                        'full_width' => true
                    ),
                )
            );
            /**
			 *	Advanced Custom CSS
			 **/
			$this->sections[] = array(
				'id'			=> 'advanced_js',
				'title'			=> __( 'Custom JS', THEME_LANG ),
				'desc'			=> '',
                'subsection' => true,
				'fields'		=> array(
                    array(
                        'id'       => 'advanced_editor_js',
                        'type'     => 'ace_editor',
                        'title'    => __( 'JS Code', THEME_LANG ),
                        'subtitle' => __( 'Paste your JS code here.', THEME_LANG ),
                        'mode'     => 'javascript',
                        'theme'    => 'chrome',
                        'default'  => "jQuery(document).ready(function(){\n\n});",
                        'full_width' => true
                    ),
                )
            );
            /**
			 *	Advanced Tracking Code
			 **/
			$this->sections[] = array(
				'id'			=> 'advanced_tracking',
				'title'			=> __( 'Tracking Code', THEME_LANG ),
				'desc'			=> '',
                'subsection' => true,
				'fields'		=> array(
                    array(
                        'id'       => 'advanced_tracking_code',
                        'type'     => 'textarea',
                        'title'    => __( 'Tracking Code', THEME_LANG ),
                        'desc'     => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the header template of your theme. Please put code inside script tags.', THEME_LANG ),
                    )
                )
            );
            
            $info_arr = array();
            $theme = wp_get_theme();
            
            $info_arr[] = "<li><span>".__('Theme Name:', THEME_LANG)." </span>". $theme->get('Name').'</li>';
            $info_arr[] = "<li><span>".__('Theme Version:', THEME_LANG)." </span>". $theme->get('Version').'</li>';
            $info_arr[] = "<li><span>".__('Theme URI:', THEME_LANG)." </span>". $theme->get('ThemeURI').'</li>';
            $info_arr[] = "<li><span>".__('Author:', THEME_LANG)." </span>". $theme->get('Author').'</li>';
            
            $system_info = sprintf("<div class='troubleshooting'><ul>%s</ul></div>", implode('', $info_arr));
            
            
            /**
			 *	Advanced Troubleshooting
			 **/
			$this->sections[] = array(
				'id'			=> 'advanced_troubleshooting',
				'title'			=> __( 'Troubleshooting', THEME_LANG ),
				'desc'			=> '',
                'subsection' => true,
				'fields'		=> array(
                    array(
                        'id'       => 'opt-raw_info_4',
                        'type'     => 'raw',
                        'content'  => $system_info,
                        'full_width' => true
                    ),
                )
            );
            
            
            
        }
        
    }
    
    global $reduxConfig;
    $reduxConfig = new KT_config();
    
} else {
    echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
}

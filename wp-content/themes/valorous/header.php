<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @since 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo THEME_JS; ?>html5shiv.min.js"></script>
      <script src="<?php echo THEME_JS; ?>respond.min.js"></script>
    <![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class( ); ?>>
    <div id="search-fullwidth" class="mfp-hide">
        <div class="container">
            <p>Start typing and press Enter to search</p>
            <?php get_search_form() ?>
        </div>
    </div><!-- #search-fullwidth -->

    <?php $position = kt_get_header(); ?>
    <?php
	/**
	 * @hooked 
	 */
	do_action( 'theme_body_top' ); ?>
    <div id="page_outter">
        <div id="page">
            <div id="wrapper-content">
                <?php 
                    if($position == 'below'){
                        /**
                    	 * @hooked theme_slideshows_position_callback 10
                    	 */
                    	do_action( 'theme_slideshows_position' );
                    } 
                ?>
                <?php
            	/**
            	 * @hooked 
            	 */
            	do_action( 'theme_before_header' ); ?>
                <?php $header_layout = kt_get_header_layout(); ?>
                <div class="header-<?php echo $header_layout ?> <?php echo apply_filters('theme_header_class', 'header-container', $position) ?> ">

                    <header id="header" class="header-fullwidth sticky-shadow <?php echo apply_filters('theme_header_content_class', 'header-content') ?>" data-color="dark" data-sticky="light">
                        <?php get_template_part( 'templates/headers/header',  $header_layout); ?>
                    </header><!-- #header -->
                    <div id="mobile-nav-holder">
                        <?php
                            if ( has_nav_menu( 'primary' ) ) {  
                                wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'container_id' => 'main-nav-mobile', 'menu_class' => 'menu navigation-mobile', 'walker' => new KTMenuWalker() ) );
                            }
                        ?>
                    </div>
                </div><!-- .header-container -->
                
                <?php 
                    if($position != 'below'){
                        /**
                    	 * @hooked theme_slideshows_position_callback 10
                    	 */
                    	do_action( 'theme_slideshows_position' );
                    } 
                ?>
                
                <?php
            	/**
            	 * @hooked theme_before_content_add_title 10
                 * 
            	 */
            	do_action( 'theme_before_content' , $position); ?>
                
                <div id="content" class="<?php echo apply_filters('kt_content_class', 'site-content') ?>">
                    <?php
            		/**
            		 * @hooked
            		 */
            		do_action( 'theme_content_top' ); ?>
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
    <?php


    /**
     * @hooked
     */
    do_action( 'theme_body_top' ); ?>

    <?php get_template_part( 'searchform',  'full'); ?>
    <?php
        $position = kt_get_header();
        $header_layout = kt_get_header_layout();
        $header_scheme = kt_get_header_scheme();
    ?>

    <div id="page_outter">
        <div id="page">
            <div id="wrapper-content">
                <?php 
                    if($position == 'below'){
                        /**
                    	 * @hooked kt_slideshows_position_callback 10
                    	 */
                    	do_action( 'kt_slideshows_position' );
                    } 
                ?>
                <?php
            	/**
            	 * @hooked 
            	 */
            	do_action( 'theme_before_header' ); ?>
                <?php  ?>
                <div class="header-<?php echo $header_layout ?> header-<?php echo esc_attr($header_scheme['scheme']) ?> <?php echo apply_filters('theme_header_class', 'header-container', $position) ?> ">
                    <?php $header_full = kt_option('header_full', 1); ?>
                    <header id="header" class="<?php echo apply_filters('theme_header_content_class', 'header-content') ?>" data-scheme="<?php echo esc_attr($header_scheme['scheme']) ?>" data-schemesticky="<?php echo esc_attr($header_scheme['sticky']) ?>">
                        <div class="container">
                            <?php get_template_part( 'templates/headers/header',  $header_layout); ?>
                        </div>
                    </header><!-- #header -->
                    <div id="mobile-nav-holder">
                        <?php
                            if ( has_nav_menu( 'primary' ) ) {
                                wp_nav_menu( array(
                                    'theme_location' => 'primary',
                                    'container' => 'nav',
                                    'container_id' => 'main-nav-mobile',
                                    'menu_class' => 'menu navigation-mobile',
                                    'walker' => new KTMenuWalker() )
                                );
                            }
                        ?>
                    </div>
                </div><!-- .header-container -->
                
                <?php
                    if($position != 'below'){
                        /**
                    	 * @hooked kt_slideshows_position_callback 10
                    	 */
                    	do_action( 'kt_slideshows_position' );
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
                    <!--
                    <div class="container">

                        <p style="background: gray; padding: 10px 0;text-align: center">
                            <a href="#" class="btn btn-border-w btn-lg">Button</a>
                            <a href="#" class="btn btn-border-w btn-round btn-lg">Button</a>
                            <a href="#" class="btn btn-border-w btn-circle btn-lg">Button</a>
                            <br/><br/>
                            <a href="#" class="btn btn-border-w">Button</a>
                            <a href="#" class="btn btn-border-w btn-round">Button</a>
                            <a href="#" class="btn btn-border-w btn-circle">Button</a>
                            <br/><br/>
                            <a href="#" class="btn btn-border-w btn-sm">Button</a>
                            <a href="#" class="btn btn-border-w btn-round btn-sm">Button</a>
                            <a href="#" class="btn btn-border-w btn-circle btn-sm">Button</a>
                            <br/><br/>
                            <a href="#" class="btn btn-border-w btn-xs">Button</a>
                            <a href="#" class="btn btn-border-w btn-round btn-xs">Button</a>
                            <a href="#" class="btn btn-border-w btn-circle btn-xs">Button</a>
                        </p>
                        <p style="padding: 10px 0;text-align: center">
                            <a href="#" class="btn btn-border-d">Button</a>
                            <a href="#" class="btn btn-border-d btn-round">Button</a>
                            <a href="#" class="btn btn-border-d btn-circle">Button</a>
                        </p>
                        <p style="padding: 10px 0;text-align: center">
                            <a href="#" class="btn btn-gray">Button</a>
                            <a href="#" class="btn btn-gray btn-round">Button</a>
                            <a href="#" class="btn btn-gray btn-circle">Button</a>
                        </p>

                        <p style="padding: 10px 0;text-align: center">
                            <a href="#" class="btn btn-dark">Button</a>
                            <a href="#" class="btn btn-dark btn-round">Button</a>
                            <a href="#" class="btn btn-dark btn-circle">Button</a>
                        </p>
                        <p style="padding: 10px 0;text-align: center">
                            <a href="#" class="btn btn-darkl">Button</a>
                            <a href="#" class="btn btn-darkl btn-round">Button</a>
                            <a href="#" class="btn btn-darkl btn-circle">Button</a>
                        </p>
                        <p style="padding: 10px 0;text-align: center">
                            <a href="#" class="btn btn-default">Button</a>
                            <a href="#" class="btn btn-default btn-round">Button</a>
                            <a href="#" class="btn btn-default btn-circle">Button</a>
                        </p>

                    </div>
                    -->
<?php
/**
 * The template for displaying error 404
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage London
 * @since London 1.0
 */


get_header(); ?>
    <div class="container">
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_before_main' ); ?>
        <div class="row">
            <div id="main" class="content-404">
                <div class="page-not-found">
                    <div class="img-404">
                        <img alt="Page not found" src="<?php echo get_template_directory_uri() ?>/assets/images/img-404.jpg">
                    </div>
                    <h1><?php _e('This page is not available', THEME_LANG) ?></h1>

                    <p >
                        <?php _e('We\'re sorry, but the Web address you\'ve entered is no longer available.', THEME_LANG ); ?>
                    </p>

                    <h3><?php _e('To find a product, please type its name in the field below.', THEME_LANG ); ?></h3>
                    <?php get_search_form(); ?>
                    <div class="buttons"><a title="<?php _e('Home', THEME_LANG); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-default button button-medium"><span><i class="icon-chevron-left left"></i><?php _e('Home page', THEME_LANG ); ?></span></a></div>
                </div>
            </div>
        </div><!-- .row -->
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_after_main' ); ?>
    </div><!-- .container -->
<?php get_footer(); ?>
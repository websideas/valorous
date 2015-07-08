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
        <div id="main" class="content-404">
            <div class="page-not-found">



                <h1><?php _e('404', THEME_LANG) ?></h1>
                <h3><?php _e('SORRY, PAGE NOT FOUND', THEME_LANG) ?></h3>
                <p ><?php _e('We\'re sorry, but the Web address you\'ve entered is no longer available.', THEME_LANG ); ?></p>
                <?php get_search_form(); ?>
                <div class="buttons">
                    <a title="<?php _e('Home', THEME_LANG); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-default button button-medium">
                        <span>
                            <?php _e('Home page', THEME_LANG ); ?>
                            <i class="icon-home button-icon-right"></i>
                        </span>
                    </a>
                </div>
            </div><!-- .page-not-found -->
        </div><!-- #main -->
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_after_main' ); ?>
    </div><!-- .container -->
<?php get_footer(); ?>
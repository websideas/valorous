<?php
/**
 * The template for displaying archive
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage London
 * @since London 1.0
 */

$sidebar = kt_sidebar();

get_header(); ?>
    <div class="container">
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_before_main' ); ?>
        <div class="row">
            <div id="main" class="<?php echo apply_filters('kt_main_class', 'main-class', $sidebar['sidebar']); ?>">
                <?php
                if( have_posts()){
                    ?>
                    <div class="list-blog-posts">
                        <?php
                        if( is_home() ){
                            ?>
                            <h1 class="page-title"><?php _e('Blog', THEME_LANG ) ?></h1>
                            <div class="term-description"><p><?php _e('Lastest posts', THEME_LANG ) ?></p></div>
                            <?php
                        }else{
                            the_archive_title( '<h1 class="page-title">', '</h1>' );
                            the_archive_description( '<div class="term-description"><p>', '</p></div>' );
                        }

                        ?>
                        <div class="clear"></div>
                        <div class="blog-posts">
                        <?php
                        while( have_posts() ){
                            the_post();
                            // Include the page content template.
                            get_template_part( 'templates/blog/content', get_post_format() );
                        }
                        ?>
                        </div>
                        <?php kt_paging_nav(); ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php if($sidebar['sidebar'] != 'full'){ ?>
                <div class="<?php echo apply_filters('kt_sidebar_class', 'sidebar', $sidebar['sidebar']); ?>">
                    <?php dynamic_sidebar($sidebar['sidebar_area']); ?>
                </div><!-- .sidebar -->
            <?php } ?>
        </div><!-- .row -->
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_after_main' ); ?>
    </div><!-- .container -->
<?php get_footer(); ?>
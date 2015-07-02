<?php
/**
 * The template for displaying single post
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage London
 * @since London 1.0
 */

$sidebar = kt_get_single_sidebar();
get_header();
?>
    <div class="container">
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_before_main' ); ?>
        <?php
            $show_post_format = kt_post_option(null, '_kt_post_format', 'blog_post_format', 1);
            $post_format_position = kt_post_option(null, '_kt_blog_post_format_position', 'blog_post_format_position', 'content');;
        ?>
        <?php
            if( ! post_password_required( ) && $show_post_format && $post_format_position == 'fullwidth' ){
                kt_post_thumbnail('full', 'img-responsive');
            }
        ?>

        <div class="row">
            <div id="main" class="<?php echo apply_filters('kt_main_class', 'main-class', $sidebar['sidebar']); ?>">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php
                        // Include the page content template.
                        get_template_part( 'content', 'single' );
                    ?>
                <?php endwhile; // end of the loop. ?>
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
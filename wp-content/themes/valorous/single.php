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
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <div class="clear"></div>
                    <div class="entry-meta-data">
                        <?php
                        printf( '<span class="author vcard">'.__('Posed by:', THEME_LANG ).' <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
                            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                            esc_attr( sprintf( __( 'View all posts by %s', 'THEME_LANG' ), get_the_author() ) ),
                            get_the_author()
                        );
                        ?>
                        <span class="date-time"><i class="fa fa-calendar-o"></i> <?php the_time( get_option( 'date_format' ) ); ?></span>
                        <span class="cat"><i class="fa fa-folder-o"></i> <?php the_category(', '); ?></span>
                        <span class="comment-count">
                            <i class="fa fa-comments"></i> <?php comments_number(
                                __('Comments: 0', THEME_LANG),
                                __('Comment: 1', THEME_LANG),
                                __('Comments: %', THEME_LANG)
                            ); ?></span>
                    </div>

                    <?php if( has_post_thumbnail() ){ ?>
                        <div class="entry-thumb">
                            <?php the_post_thumbnail('blog-post'); ?>
                        </div>
                    <?php } ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                        <?php
                        wp_link_pages( array(
                            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', THEME_LANG ) . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                            'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', THEME_LANG ) . ' </span>%',
                            'separator'   => '<span class="screen-reader-text">, </span>',
                        ) );
                        ?>
                    </div><!-- .entry-content -->

                    <?php

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

                    ?>
                </article><!-- #post-## -->

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
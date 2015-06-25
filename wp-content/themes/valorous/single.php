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
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php $post_id = get_the_ID(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-single'); ?>>
                        <?php if( ! post_password_required($post->ID) ): ?>
                            <?php
                                if(kt_post_option(null, '_kt_post_format', 'blog_post_format', 1)){
                                    kt_post_thumbnail('full', 'img-responsive');
                                }
                            ?>
                        <?php endif; ?>
                        <h2 class="entry-title"><?php the_title(); ?></h2>
                        <div class="entry-meta-data">
                            <?php
                                kt_entry_meta_author();
                                kt_entry_meta_categories();
                                kt_entry_meta_comments();
                                kt_entry_meta_time();
                            ?>

                        </div>
                        <div class="entry-content clearfix">
                            <?php the_content(); ?>
                            <?php
                                if( ! post_password_required($post->ID) ):
                                    wp_link_pages( array(
                                        'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', THEME_LANG ) . '</span>',
                                        'after'       => '</div>',
                                        'link_before' => '<span>',
                                        'link_after'  => '</span>',
                                        'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', THEME_LANG ) . ' </span>%',
                                        'separator'   => '<span class="screen-reader-text">, </span>',
                                    ) );
                                endif;
                            ?>
                        </div><!-- .entry-content -->

                        <?php

                            $show_sharebox = kt_post_option(null, '_kt_social_sharing', 'blog_share_box', 1);
                            if(get_the_tag_list() || $show_sharebox){
                                echo '<div class="entry-tool clearfix">';
                                kt_entry_meta_tags('<div class="tags-container pull-left">', '</div>');
                                if($show_sharebox){
                                    kt_share_box( null, '', 'pull-right');
                                }
                                echo "</div>";

                            }



                            if(kt_post_option(null, '_kt_author_info', 'blog_author', 1)){
                                kt_author_box();
                            }



                            if(kt_post_option(null, '_kt_prev_next', 'blog_next_prev', 1)){
                                kt_paging_nav();
                            }



                            if(kt_post_option(null, '_kt_related_acticles', 'blog_related', 1)){
                                kt_related_article();
                            }

                            // If comments are open or we have at least one comment, load up the comment template.
                            if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif;

                        ?>
                    </article><!-- #post-## -->
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
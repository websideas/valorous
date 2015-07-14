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

$sidebar = kt_get_archive_sidebar();
$settings = kt_get_settings_archive();


get_header(); ?>
    <div class="container">
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_before_main' ); ?>
        <div class="row">
            <div id="main" class="<?php echo apply_filters('kt_main_class', 'main-class', $sidebar['sidebar']); ?>" role="main">
                <?php do_action('before_blog_posts_loop'); ?>
                <?php if ( have_posts() ) : ?>
                    <?php global $wp_query; ?>
                    <div class='blog-posts blog-posts-<?php echo esc_attr($settings['blog_type']) ?>' data-settings="<?php echo esc_attr( json_encode( $settings ) ); ?>" data-type='<?php echo esc_attr($settings['blog_type']) ?>' data-total='<?php echo esc_attr($wp_query->max_num_pages); ?>' data-current='1'>

                        <?php
                        // Start the Loop.

                        if($settings['blog_type'] == 'grid' || $settings['blog_type'] == 'masonry'){
                            $elementClass[] = 'blog-posts-columns-'.$settings['blog_columns'];
                            $elementClass[] = 'blog-posts-layout-'.$settings['blog_layout'];
                            $bootstrapColumn = round( 12 / $settings['blog_columns'] );
                            $bootstrapTabletColumn = round( 12 / $settings['blog_columns_tablet'] );
                            $classes = 'col-xs-12 col-sm-'.$bootstrapTabletColumn.' col-md-' . $bootstrapColumn;
                        }

                        global $blog_atts;
                        $blog_atts = array(
                            'image_size' => $settings['image_size'],
                            'readmore' => apply_filters('sanitize_boolean', $settings['readmore']),
                            'show_meta' =>  apply_filters('sanitize_boolean', $settings['show_meta']),
                            "show_author" => apply_filters('sanitize_boolean', $settings['show_author']),
                            "show_category" => apply_filters('sanitize_boolean', $settings['show_category']),
                            "show_comment" => apply_filters('sanitize_boolean', $settings['show_comment']),
                            "show_date" => apply_filters('sanitize_boolean', $settings['show_date']),
                            "date_format" => $settings['date_format'],
                            'thumbnail_type' => $settings['thumbnail_type'],
                            'sharebox' => apply_filters('sanitize_boolean', $settings['sharebox']),
                            "class" => ''
                        );
                        $path = ($settings['blog_type'] == 'classic') ? 'templates/blog/classic/content' : 'templates/blog/layout/layout'.$settings['blog_layout'].'/content';

                        if($settings['blog_type'] == 'grid' || $settings['blog_type'] == 'masonry'){
                            echo "<div class='blog-posts-content clearfix'>";
                            echo "<div class='row'>";
                        }

                        $i = 1;
                        while ( have_posts() ) : the_post();

                            if($settings['blog_type'] == 'grid' || $settings['blog_type'] == 'masonry'){
                                $classes_extra = '';
                                if($settings['blog_type'] == 'grid'){
                                    if (  ( $i - 1 ) % $settings['blog_columns'] == 0 || 1 == $settings['blog_columns'] )
                                        $classes_extra .= ' col-clearfix-md col-clearfix-lg ';

                                    if ( ( $i - 1 ) % $settings['blog_columns_tablet'] == 0 || 1 == $settings['blog_columns_tablet'] )
                                        $classes_extra .= ' col-clearfix-sm';
                                }
                                echo "<div class='article-post-item ".$classes." ".$classes_extra." ".$i."'>";
                            }
                            get_template_part( $path, get_post_format() );
                            if($settings['blog_type'] == 'grid' || $settings['blog_type'] == 'masonry'){
                                echo "</div><!-- .article-post-item -->";
                            }

                            $i++;
                            // End the loop.
                        endwhile;

                        if ($settings['blog_type'] == 'grid' || $settings['blog_type'] == 'masonry') {
                            echo "</div><!-- .row -->";
                            echo "</div><!-- .blog-posts-content -->";
                        }


                        // Previous/next page navigation.
                        if ($settings['blog_pagination'] == 'classic') {
                            kt_paging_nav();
                        } elseif ($settings['blog_pagination'] == 'loadmore') {
                            echo '<div class="blog-posts-loadmore"><a href="#" class="blog-loadmore-button"><span class="fa fa-refresh"></span> ' . __('Load more', THEME_LANG) . '</a></div>';
                        }

                    echo "</div><!-- .blog-posts -->";


                // If no content, include the "No posts found" template.
                else :
                    get_template_part( 'content', 'none' );

                endif;
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
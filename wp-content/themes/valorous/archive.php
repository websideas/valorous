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

$blog_type = kt_option('archive_loop_style', 'classic');
$blog_columns = kt_option('archive_columns');
$blog_columns_tablet = kt_option('archive_columns_tablet');
$blog_layout = kt_option('archive_layout', '1');
$readmore = kt_option('archive_readmore', 1);
$blog_pagination = kt_option('archive_pagination', 'classic');
$thumbnail_type = kt_option('archive_thumbnail_type', 'image');
$sharebox = kt_option('archive_sharebox', 1);
$max_items = get_option('posts_per_page');
$excerpt_length = kt_option('archive_excerpt_length', 30);
$show_meta = kt_option('archive_meta', 1);
$show_author = kt_option('archive_meta_author', 1);
$show_category = kt_option('archive_meta_categories', 1);
$show_comment = kt_option('archive_meta_comments', 1);
$show_date = kt_option('archives_meta_date', 1);
$date_format = kt_option('archive_date_format', 1);
$image_size = kt_option('archive_image_size', 'blog_post');


$category = single_term_title("", false);
$catid = get_cat_ID( $category );

get_header(); ?>
    <div class="container">
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_before_main' ); ?>
        <div class="row">
            <div id="main" class="<?php echo apply_filters('kt_main_class', 'main-class', $sidebar['sidebar']); ?>" role="main">
                <?php if ( have_posts() ) : ?>
                    <?php
                        echo do_shortcode( '[list_blog_posts source="categories" categories="'.$catid.'" blog_type="'.$blog_type.'" blog_columns="'.$blog_columns.'" blog_columns_tablet="'.$blog_columns_tablet.'" blog_layout="'.$blog_layout.'" readmore="'.$readmore.'" blog_pagination="'.$blog_pagination.'" max_items="'.$max_items.'" excerpt_length="'.$excerpt_length.'" show_author="'.$show_author.'" show_category="'.$show_category.'" show_comment="'.$show_comment.'" show_date="'.$show_date.'" date_format="'.$date_format.'" image_size="'.$image_size.'" thumbnail_type="'.$thumbnail_type.'" show_meta="'.$show_meta.'" sharebox="'.$sharebox.'"]' );
                    ?>
                <?php endif; ?>
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
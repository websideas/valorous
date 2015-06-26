<?php
global $blog_atts;
$classes = array('post-item post-layout-1', $blog_atts['class']);
?>

<article <?php post_class($classes); ?>>

    <?php
        if($blog_atts['thumbnail_type'] == 'image'){
            kt_post_thumbnail_image($blog_atts['image_size'], 'img-responsive');
        }else{
            kt_post_thumbnail($blog_atts['image_size'], 'img-responsive');
        }
    ?>

    <div class="entry-main-content">

        <div class="post-info">
            <div class="entry-ci">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php if($blog_atts['show_author'] || $blog_atts['show_category'] || $blog_atts['show_comment'] || $blog_atts['show_date']){ ?>
                    <div class="entry-meta-data">
                        <?php
                        if($blog_atts['show_author']){
                            kt_entry_meta_author();
                        }
                        if($blog_atts['show_category']){
                            kt_entry_meta_categories();
                        }
                        if($blog_atts['show_comment']){
                            kt_entry_meta_comments();
                        }
                        if($blog_atts['show_date']){
                            kt_entry_meta_time($blog_atts['date_format']);
                        }
                        ?>
                    </div>
                <?php } ?>
                <div class="entry-excerpt">
                    <?php the_excerpt(); ?>
                </div>
                <?php if($blog_atts['readmore']){ ?>
                    <div class="entry-more">
                        <a href="<?php the_permalink() ?>"><?php _e('Read more', THEME_LANG ); ?></a>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</article>
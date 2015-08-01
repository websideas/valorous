<?php
//var_dump($blog_atts);
?>
<article <?php post_class('post-item-recentpost recentpost-4'); ?>>
    <div class="entry-header">
        <?php
        kt_post_thumbnail_image('recent_posts', 'img-responsive');
        //kt_post_thumbnail('blog-post', 'img-responsive');
        ?>
    </div>
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
            </div>
        </div>
    </div>
</article>
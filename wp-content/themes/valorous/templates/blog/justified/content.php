<?php 
    $thumbanail_size = rwmb_meta( '_kt_thumbnail_packery' );
    if( $thumbanail_size == 'landscape' ){
        $image_size = 'portfolio_wide';
    }elseif( $thumbanail_size == 'portrait' ){
        $image_size = 'portfolio_long';
    }else{
        $image_size = 'portfolio_default';
    }
    $classes = array('post-item post-layout-1', $blog_atts['class']);
?>
<div <?php post_class($classes); ?>>
    <?php the_post_thumbnail( $image_size, array( 'alt' => get_the_title(), 'class' => 'img-responsive' ) ); ?>
    <a class="link-post" href="<?php the_permalink(); ?>"></a>
    <div class="entry-main-content">
        <div class="post-info">
            <div class="entry-ci">
                <h2 class="entry-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <?php if($blog_atts['show_meta']){ ?>
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
                        if($blog_atts['show_view_number']){
                            echo kt_get_post_views( get_the_ID() );
                        }
                        if($blog_atts['show_like_post']){
                            kt_like_post();
                        }
                        ?>
                    </div><!-- .entry-meta-data -->
                <?php } ?>
            </div>
        </div><!-- .post-info -->
    </div><!-- .entry-main-content -->
</div>
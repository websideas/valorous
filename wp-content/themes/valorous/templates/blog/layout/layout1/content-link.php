<?php
    global $blog_atts;
    $classes = array('post-item post-layout-1', $blog_atts['class']);
?>
<article <?php post_class($classes); ?>>
    <div class="entry-main-content">
        <div class="post-info">
            <div class="entry-ci">
                <div class="post-link-title"><?php the_title(); ?></div>
                <div class="post-link-content">
                    <a href="<?php echo rwmb_meta('_kt_external_url'); ?>"><?php echo rwmb_meta('_kt_external_url'); ?></a>
                </div>
            </div>

        </div>
    </div>
</article>
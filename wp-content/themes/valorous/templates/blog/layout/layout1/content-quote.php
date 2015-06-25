<?php
    global $blog_atts;
    $classes = array('post-item post-layout-1', $blog_atts['class']);
?>
<article <?php post_class($classes); ?>>
    <div class="entry-main-content">
        <div class="post-info">
            <div class="entry-ci">
                <div class="post-quote-content">
                    <?php echo rwmb_meta('_kt_quote_content'); ?>
                </div>
                <div class="post-quote-author"><?php echo rwmb_meta('_kt_quote_author'); ?></div>
            </div>
        </div>
    </div>
</article>
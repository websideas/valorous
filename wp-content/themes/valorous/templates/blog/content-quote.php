<div <?php post_class('post-item'); ?>>
    <div class="entry-main-content">
        <div class="entry-date-time">
            <div class="m"> <?php the_time( 'M' ); ?></div>
            <div class="d"> <?php the_time( 'd' ); ?></div>
            <div class="y"> <?php the_time( 'Y' ); ?></div>
        </div>
        <div class="post-info">
            <div class="entry-ci">
                <div class="post_quote_content">
                    <?php echo rwmb_meta('_kt_quote_content'); ?>
                </div>
                <div class="post_quote_author"><?php echo rwmb_meta('_kt_quote_author'); ?></div>
            </div>
        </div>
    </div>
</div>
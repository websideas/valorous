<div <?php post_class('post-item'); ?>>
    <div class="entry-main-content">
        <div class="entry-date-time">
            <div class="m"> <?php the_time( 'M' ); ?></div>
            <div class="d"> <?php the_time( 'd' ); ?></div>
            <div class="y"> <?php the_time( 'Y' ); ?></div>
        </div>
        <div class="post-info">
            <div class="entry-ci">
                <h2 class="entry-title"><?php the_title(); ?></h2>
                <div class="entry-excerpt">
                    <a href="<?php echo rwmb_meta('_kt_external_url'); ?>"><?php echo rwmb_meta('_kt_external_url'); ?></a>
                </div>
            </div>

        </div>
    </div>
</div>
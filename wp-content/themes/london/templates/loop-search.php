<div <?php post_class('post-item search-item'); ?>>
    <div class="post-info">
        <div class="entry-ci">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry-excerpt">
                <?php the_excerpt(); ?>
            </div>
            <div class="entry-more">
                <a href="<?php the_permalink() ?>"><?php _e('Read more', THEME_LANG ); ?></a>
            </div>
        </div>
    </div>
</div>
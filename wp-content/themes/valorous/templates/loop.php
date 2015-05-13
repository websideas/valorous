<div <?php post_class('post-item'); ?>>
    <div class="entry-date-time">
        <div class="m"> <?php the_time( 'M' ); ?></div>
        <div class="d"> <?php the_time( 'd' ); ?></div>
        <div class="y"> <?php the_time( 'Y' ); ?></div>
    </div>
    <div class="post-info">
        <?php if( has_post_thumbnail() ){
            ?>
            <div class="entry-thumb">
                <?php
                the_post_thumbnail('blog-post');
                ?>
            </div>
        <?php
        } ?>
        <div class="entry-ci">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry-meta-data">
                <?php
                printf( '<span class="author vcard">'.__('Posed by:', THEME_LANG ).' <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    esc_attr( sprintf( __( 'View all posts by %s', THEME_LANG ), get_the_author() ) ),
                    get_the_author()
                );
                ?>
                <span class="cat"><?php the_category(', '); ?></span>
                                        <span class="comment-count"><?php comments_number(
                                                __('Comments: 0', THEME_LANG),
                                                __('Comment: 1', THEME_LANG),
                                                __('Comments: %', THEME_LANG)
                                            ); ?></span>
            </div>
            <div class="entry-excerpt">
                <?php the_excerpt(); ?>
            </div>
            <div class="entry-more">
                <a href="<?php the_permalink() ?>"><?php _e('Read more', THEME_LANG ); ?></a>
            </div>
        </div>

    </div>
</div>
<?php

$classes = array('');
?>
<article <?php post_class($classes); ?> style="background-image: url(<?php echo kt_get_post_thumbnail_url('blog_post'); ?>);">
    <div class="entry-main-content">
        <?php kt_entry_meta_categories(' '); ?>
        <?php kt_post_thumbnail_image('small', 'img-responsive'); ?>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="entry-meta-data">
            <?php kt_entry_meta_time();  ?>
        </div>
    </div>
</article>
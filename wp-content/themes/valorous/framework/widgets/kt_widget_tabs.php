<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT tabs widget class
 *
 * @since 1.0
 */
class WP_Widget_KT_Tabs extends WP_Widget {

	public function __construct() {

        $widget_ops = array('classname' => 'widget_kt_posts', 'description' => __( "Display popular posts, recent posts and comments in tabbed format.") );
        parent::__construct('kt_posts', __('KT: Post Tabs', THEME_LANG), $widget_ops);
        $this->alt_option_name = 'widget_kt_post_tabs';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );

	}

	public function widget( $args, $instance ) {
        $cache = array();
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'widget_kt_posts', 'widget' );
        }

        if ( ! is_array( $cache ) ) {
            $cache = array();
        }

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();



        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        
        $select_rand = isset( $instance['select_rand'] ) ? $instance['select_rand'] : true;
        $select_recent = isset( $instance['select_recent'] ) ? $instance['select_recent'] : true;
        $select_comments = isset( $instance['select_comments'] ) ? $instance['select_comments'] : true;
        
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_thumbnail = isset( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : true;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : true;
            
        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        if( $select_rand || $select_recent || $select_comments ){ ?>
            <div class="kt_widget_tabs">
                <ul>
                    <?php if( $select_rand ){ ?><li><a href="#kt_tab_random"><?php _e( 'Random', THEME_LANG ); ?></a></li><?php } ?>
                    <?php if( $select_recent ){ ?><li><a href="#kt_tab_recent"><?php _e( 'Recent', THEME_LANG ); ?></a></li><?php } ?>
                    <?php if( $select_comments ){ ?><li><a href="#kt_tab_comments"><?php _e( 'Comments', THEME_LANG ); ?></a></li><?php } ?>
                </ul>
                <div class="tabs-container">
                <?php if( $select_rand ){ ?>
                    <?php
                        $args_rand =  array(
                            'posts_per_page'      => $number,
                            'no_found_rows'       => true,
                            'post_status'         => 'publish',
                            'ignore_sticky_posts' => true,
                            'order'               => 'DESC',
                            'orderby'             => 'rand'
                        );
                    ?>
                    <div id="kt_tab_random" class="kt_tabs_content">
                        <?php $query_rand = new WP_Query( apply_filters( 'widget_posts_args', $args_rand ) );
                        if ($query_rand->have_posts()){ ?>
                            <ul <?php echo $no_image; ?>>
                                <?php while ( $query_rand->have_posts() ) : $query_rand->the_post(); ?>
                                    <li>
                                        <?php if($show_thumbnail){ kt_post_thumbnail_image( 'recent_posts', 'img-responsive' ); } ?>
                                        <div class="article-attr">
                                            <h3 class="title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                                            <?php kt_entry_meta_categories(); ?>
                                            <div class="entry-meta-data">
                                                <?php
                                                    if( $show_date ){ kt_entry_meta_time(); }
                                                    kt_entry_meta_author();
                                                    kt_entry_meta_comments();
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </ul>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if( $select_recent ){ ?>
                    <?php
                        $args_recent =  array(
                            'posts_per_page'      => $number,
                            'no_found_rows'       => true,
                            'post_status'         => 'publish',
                            'ignore_sticky_posts' => true,
                            'order'               => 'DESC',
                            'orderby'             => 'date'
                        );
                    ?>
                    <div id="kt_tab_recent" class="kt_tabs_content">
                        <?php $query_recent = new WP_Query( apply_filters( 'widget_posts_args', $args_recent ) );
                        if ($query_recent->have_posts()){ ?>
                            <ul <?php echo $no_image; ?>>
                                <?php while ( $query_recent->have_posts() ) : $query_recent->the_post(); ?>
                                    <li>
                                        <?php if($show_thumbnail){ kt_post_thumbnail_image( 'recent_posts', 'img-responsive' ); } ?>
                                        <div class="article-attr">
                                            <h3 class="title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                                            <?php kt_entry_meta_categories(); ?>
                                            <div class="entry-meta-data">
                                                <?php
                                                    if( $show_date ){ kt_entry_meta_time(); }
                                                    kt_entry_meta_author();
                                                    kt_entry_meta_comments();
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </ul>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if( $select_comments ){ ?>
                    <div id="kt_tab_comments" class="kt_tabs_content">
                    <?php
                        $args_comments = array(
                            'orderby' => 'date',
                            'number' => $number,
                            'status' => 'approve'
                        );
                        $comments_query = new WP_Comment_Query;
                        $comments = $comments_query->query( $args_comments );
                        
                        if ( $comments ) { ?>
                            <ul <?php echo $no_image; ?>>
                                <?php foreach ( $comments as $comment ) { ?>
                                    <li>
                                        <?php if($show_thumbnail){ ?>
                                            <a class="entry-thumb" href="<?php echo get_comment_link($comment->comment_ID); ?>">
        										<?php echo get_avatar( $comment->comment_author_email, 'recent_posts' ); ?>     
                                            </a>   
                                        <?php } ?>
                                        <div class="article-attr">
                                            <h3 class="title">
                                                <a href="<?php echo get_comment_link($comment->comment_ID); ?>">   
                									<span class="comment_author"><?php echo get_comment_author( $comment->comment_ID ); ?> </span> - <span class="comment_post"><?php echo get_the_title($comment->comment_post_ID); ?></span>                   
                							    </a>
                                            </h3>
                                            <div class="entry-meta-data">
                                                <?php if( $show_date ){
                                                    $date = date_create( $comment->comment_date );
                                                    echo date_format($date,"d M Y");
                                                } ?>
                                            </div>
                                            <div class="kt-comment-content">
                                                <?php 
                                                    $str = $comment->comment_content;
                                                    if (mb_strlen($str) > 40) {
                                                        echo mb_substr($str, 0, 40).'...';
                                                    } else {
                                                        echo $str;
                                                    } 
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php }else{ ?>
                       	    <?php echo '<li>No comments found.</li>'; ?>
                        <?php } ?>
                    </div>
                <?php } ?>


                </div>
            </div>
        <?php }
        
        echo $args['after_widget'];


        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'widget_kt_posts', $cache, 'widget' );
        } else {
            ob_end_flush();
        }

	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        
        $instance['select_rand'] = isset( $new_instance['select_rand'] ) ? (bool) $new_instance['select_rand'] : false;
        $instance['select_recent'] = isset( $new_instance['select_recent'] ) ? (bool) $new_instance['select_recent'] : false;
        $instance['select_comments'] = isset( $new_instance['select_comments'] ) ? (bool) $new_instance['select_comments'] : false;
        
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_thumbnail'] = isset( $new_instance['show_thumbnail'] ) ? (bool) $new_instance['show_thumbnail'] : false;
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_kt_posts']) )
            delete_option('widget_kt_posts');

        return $instance;
	}

    public function flush_widget_cache() {
        wp_cache_delete('widget_kt_post_tabs', 'widget');
    }

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'Widget Tabs' , THEME_LANG);
        
        $select_rand = isset( $instance['select_rand'] ) ? (bool) $instance['select_rand'] : true;
        $select_recent = isset( $instance['select_recent'] ) ? (bool) $instance['select_recent'] : true;
        $select_comments = isset( $instance['select_comments'] ) ? (bool) $instance['select_comments'] : true;
        
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : true;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
		
	?>
    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
    
    <h4><?php _e('Select Tabs', THEME_LANG); ?></h4>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $select_rand ); ?> id="<?php echo $this->get_field_id( 'select_rand' ); ?>" name="<?php echo $this->get_field_name( 'select_rand' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'select_rand' ); ?>"><?php _e( 'Display Random Posts',THEME_LANG ); ?></label>
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $select_recent ); ?> id="<?php echo $this->get_field_id( 'select_recent' ); ?>" name="<?php echo $this->get_field_name( 'select_recent' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'select_recent' ); ?>"><?php _e( 'Display Recent Posts',THEME_LANG ); ?></label>
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $select_comments ); ?> id="<?php echo $this->get_field_id( 'select_comments' ); ?>" name="<?php echo $this->get_field_name( 'select_comments' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'select_comments' ); ?>"><?php _e( 'Display Comments',THEME_LANG ); ?></label>
    </p>
    
    <h4><?php _e('Options Tabs', THEME_LANG); ?></h4>
    
    <p>
        <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" class="widefat" />
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $show_thumbnail ); ?> id="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'show_thumbnail' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>"><?php _e( 'Show Thumbnail (Avatar Comments)',THEME_LANG ); ?></label>
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show date',THEME_LANG ); ?></label>
    </p>
<?php
	}
}



/**
 * Register KT_Tabs widget
 *
 *
 */

register_widget( 'WP_Widget_KT_Tabs' );
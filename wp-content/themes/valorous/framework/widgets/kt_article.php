<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Recent_Posts widget class
 *
 * @since 2.8.0
 */
class kt_article_widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_kt_article', 'description' => __( "Show posts of categories.") );
        parent::__construct('kt_article', __('KT Article', THEME_LANG), $widget_ops);
        $this->alt_option_name = 'widget_kt_article';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    public function widget($args, $instance) {
        $cache = array();
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'widget_kt_article', 'widget' );
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

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' , THEME_LANG);

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        /**
         * Filter the arguments for the Recent Posts widget.
         *
         * @since 3.4.0
         *
         * @see WP_Query::get_posts()
         *
         * @param array $args An array of arguments used to retrieve the recent posts.
         */
        $r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ) ) );

        if ($r->have_posts()) :
            ?>
            <?php echo $args['before_widget']; ?>
            <?php if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        } ?>
            <ul>
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
                        <?php if ( $show_date ) : ?>
                            <span class="post-date"><?php echo get_the_date(); ?></span>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php echo $args['after_widget']; ?>
            <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
        } else {
            ob_end_flush();
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['show_category'] = isset( $new_instance['show_category'] ) ? (bool) $new_instance['show_category'] : false;
        $instance['show_image'] = isset( $new_instance['show_image'] ) ? (bool) $new_instance['show_image'] : false;
        $instance['show_comment'] = isset( $new_instance['show_comment'] ) ? (bool) $new_instance['show_comment'] : false;
        $instance['show_author'] = isset( $new_instance['show_author'] ) ? (bool) $new_instance['show_author'] : false;

        if ( in_array( $new_instance['orderby'], array( 'name', 'id', 'date', 'author', 'modified', 'rand', 'comment_count' ) ) ) {
            $instance['orderby'] = $new_instance['orderby'];
        } else {
            $instance['orderby'] = 'date';
        }

        if ( in_array( $new_instance['order'], array( 'DESC', 'ASC' ) ) ) {
            $instance['order'] = $new_instance['order'];
        } else {
            $instance['order'] = 'DESC';
        }

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_kt_article']) )
            delete_option('widget_kt_article');

        return $instance;
    }

    public function flush_widget_cache() {
        wp_cache_delete('widget_kt_article', 'widget');
    }

    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        $show_category = isset( $instance['show_category'] ) ? (bool) $instance['show_category'] : false;
        $show_image = isset( $instance['show_image'] ) ? (bool) $instance['show_image'] : false;
        $show_comment = isset( $instance['show_comment'] ) ? (bool) $instance['show_comment'] : false;
        $show_author = isset( $instance['show_author'] ) ? (bool) $instance['show_author'] : false;

        $order = $instance['order'];
        $orderby = $instance['orderby'];


        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" class="widefat" /></p>

        <p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories:',THEME_LANG); ?> </label>
            <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" multiple="multiple">
                <option <?php if (in_array('all',$category_name)){ echo 'selected="selected"';} ?> value="all"><?php _e('All',THEME_LANG); ?></option>
                <?php foreach($cat as $item){ ?>
                    <option <?php if (in_array($item->term_id,$category_name)){ echo 'selected="selected"';} ?> value="<?php echo $item->term_id ?>"><?php echo $item->name; ?></option>
                <?php } ?>
            </select>
        </p>

        <p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order by:', THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                <option <?php selected( $orderby, 'name' ); ?> value="name"><?php _e('Name',THEME_LANG); ?></option>
                <option <?php selected( $orderby, 'id' ); ?> value="id"><?php _e('ID',THEME_LANG); ?></option>
                <option <?php selected( $orderby, 'date' ); ?> value="date"><?php _e('Date',THEME_LANG); ?></option>
                <option <?php selected( $orderby, 'author' ); ?> value="author"><?php _e('Author',THEME_LANG); ?></option>
                <option <?php selected( $orderby, 'modified' ); ?> value="modified"><?php _e('Modified',THEME_LANG); ?></option>
                <option <?php selected( $orderby, 'rand' ); ?> value="rand"><?php _e('Rand',THEME_LANG); ?></option>
                <option <?php selected( $orderby, 'comment_count' ); ?> value="comment_count "><?php _e('Comment count',THEME_LANG); ?></option>
            </select>
        </p>

        <p><label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order:',THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                <option <?php selected( $order, 'DESC' ); ?> value="DESC"><?php _e('Desc',THEME_LANG); ?></option>
                <option <?php selected( $order, 'ASC' ); ?> value="ASC"><?php _e('ASC',THEME_LANG); ?></option>
            </select>
        </p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_category ); ?> id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e( 'Display post category?', THEME_LANG ); ?></label></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_image ); ?> id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Display post image?', THEME_LANG ); ?></label></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_comment ); ?> id="<?php echo $this->get_field_id( 'show_comment' ); ?>" name="<?php echo $this->get_field_name( 'show_comment' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_comment' ); ?>"><?php _e( 'Display post comment?', THEME_LANG ); ?></label></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_author ); ?> id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Display post author?', THEME_LANG ); ?></label></p>


    <?php
    }
}




/**
 * Register article widget
 *
 *
 */

register_widget('kt_article_widget');

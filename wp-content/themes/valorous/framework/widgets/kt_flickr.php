<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT_Instagram widget class
 *
 * @since 1.0
 */
class Widget_KT_Flickr extends WP_Widget {
    
    public function __construct() {
        $widget_ops = array('classname' => 'widget_kt_flickr', 'description' => __( "Lasted images in flickr.", THEME_LANG) );
        parent::__construct('kt_flickr', __('KT: Flickr', THEME_LANG), $widget_ops);
    }

    public function widget($args, $instance) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $user_id = $instance['user_id'];
        $number = $instance['number'];
        $ordering = $instance['ordering'];
        $type = $instance['type'];
        
        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
            
        ?>
            <?php if( $user_id && $number ){ ?>
                <div class="kt_flickr clearfix">
                    <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=<?php echo $ordering; ?>&amp;size=s&amp;source=<?php echo $type; ?>&amp;<?php echo $type; ?>=<?php echo $user_id; ?>"></script>
                </div>
            <?php } ?>
        <?php  
        
        echo $args['after_widget'];
        
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['type'] = $new_instance['type'];
        $instance['user_id'] = $new_instance['user_id'];
        
        $instance['number'] = (int) $new_instance['number'];
        if(!$instance['number']){
            $instance['number'] = 9;
        }
        $instance['ordering'] = $new_instance['ordering'];

        return $instance;
    }


    public function form( $instance ) {

        $defaults = array( 'title' => __( 'Flickr' , THEME_LANG), 'type' => '', 'user_id' => '', 'number' => 9, 'ordering' => '' );
        $instance = wp_parse_args( (array) $instance, $defaults );

        $title = strip_tags($instance['title']);

        ?>

        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type Flickr:', THEME_LANG ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
                <option <?php selected( $instance['type'], 'user' ); ?> value="user"><?php _e('User',THEME_LANG); ?></option>
                <option <?php selected( $instance['type'], 'group' ); ?> value="group"><?php _e('Group',THEME_LANG); ?></option>
            </select>
            <small><?php _e('Select photo stream type.',THEME_LANG); ?></small>
        </p>
        
        <p><label for="<?php echo $this->get_field_id( 'user_id' ); ?>"><?php _e( 'Flickr ID:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'user_id' ); ?>" name="<?php echo $this->get_field_name( 'user_id' ); ?>" type="text" value="<?php echo $instance['user_id']; ?>" />
            <small><?php _e('To find your flickID visit',THEME_LANG); ?> <a target="_blank" href="http://idgettr.com/"><?php _e('idGettr.',THEME_LANG); ?></a></small>
        </p>
        
        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of image to show:', THEME_LANG ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $instance['number']; ?>" class="widefat" />
            <small><?php _e('Select number of photos to display.',THEME_LANG); ?></small>
        </p>

        <p><label for="<?php echo $this->get_field_id( 'ordering' ); ?>"><?php _e( 'Ordering your images:', THEME_LANG ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('ordering'); ?>" name="<?php echo $this->get_field_name('ordering'); ?>">
                <option <?php selected( $instance['ordering'], 'latest' ); ?> value="latest"><?php _e('Latest',THEME_LANG); ?></option>
                <option <?php selected( $instance['ordering'], 'random' ); ?> value="random"><?php _e('Random',THEME_LANG); ?></option>
            </select>
            <small><?php _e('Select photo display order.',THEME_LANG); ?></small>
        </p>
        
    <?php
    }
}

/**
 * Register Widget_KT_Flickr widget
 *
 *
 */

register_widget('Widget_KT_Flickr');

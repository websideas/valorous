<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT AboutMe widget class
 *
 * @since 1.0
 */
class WP_Widget_KT_AboutMe extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_kt_aboutme', 'description' => __( 'About Me widget.', THEME_LANG ) );
        parent::__construct('kt_aboutme', __('KT: About me', THEME_LANG ), $widget_ops);
    }

    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo "<div class='kt-aboutwidget-content'>";
        $attachment = get_thumbnail_attachment($instance['attachment'], $instance['size']);
        if($attachment){
            echo "<p class='kt-aboutwidget-img'>";
            echo "<img src='".$attachment['url']."' alt='".esc_attr($attachment['alt'])."' class='img-responsive' title='".esc_attr($attachment['title'])."'/>";
            echo "</p>";
        }
        if($instance['name']) {
            echo '<h4 class="kt-aboutwidget-title">'.$instance['name'].'</h4>';
        }
        if($instance['description']){
            echo '<div class="kt-aboutwidget-text">'.$instance['description'].'</div>';
        }
        echo "</div>";

        echo $args['after_widget'];

    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['size'] = $new_instance['size'];
        $instance['attachment'] = intval($new_instance['attachment']);
        $instance['name'] = strip_tags($new_instance['name']);

        if ( current_user_can('unfiltered_html') ){
            $instance['description'] =  $new_instance['description'];
        }else{
            $instance['description'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['description']) ) );
        }

        return $instance;
    }

    public function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => __('About me', THEME_LANG), 'target' => '_self', 'attachment' => '', 'size' => 'recent_posts', 'name' => '', 'description' => '') );
        $title = strip_tags($instance['title']);
        $name = strip_tags($instance['name']);

        $attachment = esc_attr( $instance['attachment'] );
        $preview = false;
        $img_preview = "";
        if($instance['attachment']){
            $file = get_thumbnail_attachment($instance['attachment'], 'full');
            $preview = true;
            $img_preview = $file['url'];
        }

        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <div class="wrapper_kt_image_upload">
            <p style="text-align: center;">
                <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attr_e('Select your image', THEME_LANG) ?>" />
                <input class="widefat kt_image_attachment" id="<?php echo $this->get_field_id('attachment'); ?>" name="<?php echo $this->get_field_name('attachment'); ?>" type="hidden" value="<?php echo esc_attr($attachment); ?>" />
            </p>
            <p class="kt_image_preview" style="<?php if($preview){ echo "display: block;";} ?>">
                <img src="<?php echo esc_url($img_preview); ?>" alt="" class="kt_image_preview_img" />
            </p>
        </div>
        <p style="clear: both;">
            <?php
            $sizes = kt_get_image_sizes();
            $sizes['full'] = array();
            ?>
            <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e( 'Image size:', THEME_LANG ); ?></label>
            <select name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" class="widefat">
                <?php foreach($sizes as $key => $size){ ?>
                    <?php
                    $option_text = array();
                    $option_text[] = ucfirst($key);
                    if(isset($size['width'])){
                        $option_text[] = '('.$size['width'].' x '.$size['height'].')';
                    }
                    if(isset($size['crop']) && $size['crop']){
                        $option_text[] = __('Crop', THEME_LANG);
                    }
                    ?>
                    <option value="<?php echo $key; ?>"<?php selected( $instance['size'], $key ); ?>>
                        <?php echo implode(' - ', $option_text) ?>
                    </option>
                <?php } ?>
            </select>
        </p>

        <p><label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e( 'Name:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" type="text" value="<?php echo $name; ?>" /></p>

        <p>
            <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:', THEME_LANG ); ?></label>
            <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo $instance['description'] ?></textarea></p>




        <?php
    }

}


register_widget( 'WP_Widget_KT_AboutMe' );
<?php

class kt_testimonials_carousel extends WP_Widget {
    public $excerpt_length;
    function kt_testimonials_carousel(){
        parent::WP_Widget('kt_testimonials_carousel',
            'Testimonials Carousel',
            array('description' => ''));
    }
    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $sub_title = $instance['sub_title'];
        $number = intval($instance['number']);
        $orderby = $instance['orderby'];
        $order = $instance['order'];
        $autoplay = $instance['autoplay'];
        $navigation = $instance['navigation'];
        $slidespeed = $instance['slidespeed'];
        $el_class = $instance['el_class'];
        
        echo $before_widget;
        if ( !empty( $title ) ) {
            echo $before_title . $title .'<span class="sub-title">'.esc_html($sub_title).'</span>'. $after_title; 
        } 
           
           echo do_shortcode('[carousel_testimonials number="'.$number.'" orderby="'.$orderby.'" order="'.$order.'" autoplay="'.$autoplay.'" navigation="'.$navigation.'" slidespeed="'.$slidespeed.'" el_class="'.$el_class.'"]');
           
        echo $after_widget;
    }
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        
        $instance['sub_title'] = $new_instance['sub_title'];
        $instance['orderby'] =  $new_instance['orderby'];
        $instance['order'] =  $new_instance['order'];
        $instance['autoplay'] = $new_instance['autoplay'];
        $instance['navigation'] = $new_instance['navigation'];
        $instance['slidespeed'] = $new_instance['slidespeed'];
        $instance['el_class'] = $new_instance['el_class'];
        
        $instance['number'] = intval($new_instance['number']);
        if(!$instance['number']) $instance['number'] = 4;
        
        return $instance;
    }
    function form( $instance ) {
            $instance = wp_parse_args( (array) $instance,
                array( 'title' => 'Testimonials', 'number' => '4', 'slidespeed' => '200' ));
            $title = strip_tags($instance['title']);
            $sub_title = strip_tags($instance['sub_title']);
            $number = format_to_edit($instance['number']);
            
            $order = format_to_edit($instance['order']);
            $orderby = format_to_edit($instance['orderby']);
            $autoplay = format_to_edit($instance['autoplay']);
            $navigation = format_to_edit($instance['navigation']);
            $slidespeed = format_to_edit($instance['slidespeed']);
            $el_class = format_to_edit($instance['el_class']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Title:', THEME_LANG ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>" type="text"
                value="<?php echo  esc_attr($title);?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sub_title'); ?>">
                <?php _e('Sub title:', THEME_LANG ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('sub_title'); ?>"
                name="<?php echo $this->get_field_name('sub_title'); ?>"><?php echo  esc_html($sub_title);?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">
                <?php _e('Number of posts to show:', THEME_LANG ); ?> </label>
            <input type="text" class="widefat" value="<?php echo  esc_attr($number);?>"
                id="<?php echo $this->get_field_id('number'); ?>"
                name="<?php echo $this->get_field_name('number'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('orderby'); ?>">
                <?php _e('Order by:', THEME_LANG ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                <option <?php if ( 'name' == $orderby ) echo 'selected="selected"'; ?> value="name"><?php _e('Name','theme-dev-language') ?></option>
                <option <?php if ( 'id' == $orderby ) echo 'selected="selected"'; ?> value="id"><?php _e('ID','theme-dev-language') ?></option>
                <option <?php if ( 'date' == $orderby || $orderby == '') echo 'selected="selected"'; ?> value="date"><?php _e('Date','theme-dev-language') ?></option>
                <option <?php if ( 'author' == $orderby ) echo 'selected="selected"'; ?> value="author"><?php _e('Author','theme-dev-language') ?></option>
                <option <?php if ( 'modified' == $orderby ) echo 'selected="selected"'; ?> value="modified"><?php _e('Modified','theme-dev-language') ?></option>
                <option <?php if ( 'rand' == $orderby ) echo 'selected="selected"'; ?> value="rand"><?php _e('Rand','theme-dev-language') ?></option>
                <option <?php if ( 'comment_count ' == $orderby ) echo 'selected="selected"'; ?> value="comment_count "><?php _e('Comment count','theme-dev-language') ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('order'); ?>">
                <?php _e('Order:', THEME_LANG ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                <option <?php if ( 'DESC' == $order || $order == '' ) echo 'selected="selected"'; ?> value="DESC"><?php _e('Desc',THEME_LANG ) ?></option>
                <option <?php if ( 'ASC' == $order ) echo 'selected="selected"'; ?> value="ASC"><?php _e('Asc', THEME_LANG ) ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('autoplay'); ?>">
                <?php _e('Autoplay:', THEME_LANG ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
                <option <?php if ( 'false' == $autoplay ) echo 'selected="selected"'; ?> value="false"><?php _e('False',THEME_LANG ) ?></option>
                <option <?php if ( 'true' == $autoplay ) echo 'selected="selected"'; ?> value="true"><?php _e('True',THEME_LANG ) ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('navigation'); ?>">
                <?php _e('Show Navigation:', THEME_LANG ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('navigation'); ?>" name="<?php echo $this->get_field_name('navigation'); ?>">
                <option <?php if ( 'true' == $navigation ) echo 'selected="selected"'; ?> value="true"><?php _e('True',THEME_LANG ) ?></option>
                <option <?php if ( 'false' == $navigation ) echo 'selected="selected"'; ?> value="false"><?php _e('False', THEME_LANG ) ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('slidespeed'); ?>">
                <?php _e('Slidespeed:', THEME_LANG ); ?> </label>
            <input type="text" class="widefat" value="<?php echo  esc_attr($slidespeed);?>"
                id="<?php echo $this->get_field_id('slidespeed'); ?>"
                name="<?php echo $this->get_field_name('slidespeed'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('el_class'); ?>">
                <?php _e('Custom class:', THEME_LANG ); ?> </label>
            <input type="text" class="widefat" value="<?php echo  esc_attr($el_class);?>"
                id="<?php echo $this->get_field_id('el_class'); ?>"
                name="<?php echo $this->get_field_name('el_class'); ?>" />
        </p>
<?php
    }
}
     
register_widget('kt_testimonials_carousel');
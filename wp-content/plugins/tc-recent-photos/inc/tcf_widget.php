<?php

/*-----------------------------------------------------------------------------------*/
/*	Create Widget
/*-----------------------------------------------------------------------------------*/

class tc_instagram_widget extends WP_Widget {
 
/*-----------------------------------------------------------------------------------*/
/*	Constructor - Should be same as above
/*-----------------------------------------------------------------------------------*/

    function tc_instagram_widget() {
        parent::WP_Widget(false, $name = __('Instagram Recent Photos Widget', 'tcrinsta'), array( 'description' => __('Show off your recent Instagram photos with lightbox support.', 'tcrinsta') ) );	
    }
 
    /* @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
        extract($args);
		$title		 = apply_filters('widget_title', $instance['title'] );
        $type		 = $instance['type'];
        $username	 = $instance['username'];
        $tag		 = $instance['tag'];
        $size		 = $instance['size'];
        $count		 = $instance['count'];
        $columns	 = $instance['columns'];
        $lightbox	 = $instance['lightbox'];
		$follow		 = $instance['follow'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display set. */
		if( $type == 'user' ){
			echo tcrinsta_getFeed($username, $count, $size, $columns, $lightbox, $follow);
		} else if( $type == 'tag' ){
			echo tcrinsta_getTagMedia($tag, $username, $count, $size, $columns, $lightbox, $follow);
		} else {
			echo 'No valid widget type is set.';
		}

		/* After widget (defined by themes). */
		echo $after_widget;

    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['type'] = strip_tags($new_instance['type']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['tag'] = strip_tags($new_instance['tag']);
		$instance['size'] = strip_tags($new_instance['size']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['columns'] = strip_tags($new_instance['columns']);
		$instance['lightbox'] = strip_tags($new_instance['lightbox']);
		$instance['follow'] = strip_tags($new_instance['follow']);
        return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance){	
	
	// Set up some default widget settings
	$defaults = array(
		'title' => 'Recent Photos',
		'type' => 'user',
		'username' => '25148318',
		'tag' => '',
		'size' => '70',
		'count' => '6',
		'columns' => '2',
		'lightbox' => 'true',
		'follow' => 'false'
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'tcrinsta'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Show Photos From', 'tcrinsta'); ?></label> 
          <select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" class="widefat">
                <option value="user" <?PHP if($instance['type'] == "user"){echo"selected";} ?>><?PHP _e('User ID', 'tcrinsta'); ?></option>
                <option value="tag" <?PHP if($instance['type'] == "tag"){echo"selected";} ?>><?PHP _e('Tag / Hashtag', 'tcrinsta'); ?></option>
          </select>	
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Instagram User ID', 'tcrinsta'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $instance['username']; ?>" />
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('tag'); ?>"><?php _e('Instagram Tag', 'tcrinsta'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" type="text" value="<?php echo $instance['tag']; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Image Count', 'tcrinsta'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $instance['count']; ?>" />
          <br /><small><?PHP _e('12 Images Max'); ?></small>
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Image Size', 'tcrinsta'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $instance['size']; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Columns', 'tcrinsta'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo $this->get_field_name('columns'); ?>" type="text" value="<?php echo $instance['columns']; ?>" />
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('lightbox'); ?>" name="<?php echo $this->get_field_name('lightbox'); ?>" type="checkbox" value="true" <?PHP if($instance['lightbox'] == 'true'){ ?>checked="checked"<?PHP } ?> />
          <label for="<?php echo $this->get_field_id('lightbox'); ?>"><?php _e('Enabled Lightbox'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('follow'); ?>" name="<?php echo $this->get_field_name('follow'); ?>" type="checkbox" value="true" <?PHP if($instance['follow'] == 'true'){ ?>checked="checked"<?PHP } ?> />
          <label for="<?php echo $this->get_field_id('follow'); ?>"><?php _e('Show Follow Button'); ?></label> 
        </p>
        
        
        <?php 
    }
 
 
} // end class example_widget

/*-----------------------------------------------------------------------------------*/
/*	HookEr' In
/*-----------------------------------------------------------------------------------*/

add_action('widgets_init', create_function('', 'return register_widget("tc_instagram_widget");'));

?>
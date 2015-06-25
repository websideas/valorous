<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT image widget class
 *
 * @since 2.8.0
 */
class WP_Widget_KT_Image extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_kt_image', 'description' => __( 'Image for widget.', THEME_LANG ) );
		parent::__construct('kt_image', __('KT image', THEME_LANG ), $widget_ops);
	}

	public function widget( $args, $instance ) {
        $attachment = get_thumbnail_attachment($instance['attachment'], $instance['size']);
		
        if($attachment){
    		echo $args['before_widget'];
            if($instance['link']){
                echo "<a href='".esc_attr($instance['link'])."' target='".esc_attr($instance['target'])."'>";
            }
            echo "<img src='".$attachment['url']."' alt='".esc_attr($attachment['alt'])."' title='".esc_attr($attachment['title'])."'/>";
            if($instance['link']){
                echo "</a>";
            }
    		echo $args['after_widget'];
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['link'] = strip_tags($new_instance['link']);
        $instance['target'] = $new_instance['target'];
        $instance['size'] = $new_instance['size'];
        $instance['attachment'] = intval($new_instance['attachment']);
        
		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'target' => '_self', 'link' => '', 'attachment' => '', 'size' => '', 'animation' => '') );

		$link = esc_attr( $instance['link'] );
        $attachment = esc_attr( $instance['attachment'] );
        $animation = esc_attr( $instance['animation'] );
        $preview = false;
        $img_preview = "";
        if($instance['attachment']){
            $file = get_thumbnail_attachment($instance['attachment'], 'full');
            $preview = true;
            $img_preview = $file['url'];
        }
		
	?>
        <p style="text-align: center;">
            <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attr_e('Select your image', THEME_LANG) ?>" />
            <input class="widefat kt_image_attachment" id="<?php echo $this->get_field_id('attachment'); ?>" name="<?php echo $this->get_field_name('attachment'); ?>" type="hidden" value="<?php echo esc_attr($attachment); ?>" />
        </p>
        <p class="kt_image_preview" style="<?php if($preview){ echo "display: block;";} ?>">
            <img src="<?php echo esc_url($img_preview); ?>" alt="" class="kt_image_preview_img" />
        </p>
        <p style="clear: both;">
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:', THEME_LANG); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
        </p>
        <p>
			<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e( 'Target:', THEME_LANG); ?></label>
			<select name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>" class="widefat">
				<option value="_self"<?php selected( $instance['target'], '_self' ); ?>><?php _e('Stay in Window', THEME_LANG); ?></option>
				<option value="_blank"<?php selected( $instance['target'], '_blank' ); ?>><?php _e('Open New Window', THEME_LANG); ?></option>
			</select>
		</p>
        <p>
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
        <p>
            <label for="<?php echo $this->get_field_id('animation'); ?>"><?php _e( 'CSS Animation:', THEME_LANG ); ?></label>
            <?php
                $string = file_get_contents(FW_URL.'js_composer/animate-config.json');
                $json_a = json_decode($string,true);

                $posts_fields = array();
                $posts_fields[] = "<option value=''>".__('No Animation', THEME_LANG)."</option>";

                foreach($json_a as $key => $value){
                    $selected = ($value == $key) ? ' selected="selected"' : '';

                    $posts_fields[] = "<optgroup label='".ucwords(str_replace('_',' ',$key))."'>";
                    foreach( $value as $k=>$v ){
                        $posts_fields[] .= "<option value='{$k}' {$selected}>".$k."</option>";
                    }
                    $posts_fields[] .= "</optgroup>";
                }
            ?>
            <div class="wrap-kt-animate">';
            <div class="animationSandbox"><h1>Animate</h1></div>';
            <select  name="<?php echo $this->get_field_name('animation'); ?>" id="<?php echo $this->get_field_id('animation'); ?>" class="widefat">'
                <?php echo implode( $posts_fields ); ?>
            </select>
            </div>

        </p>



<?php
	}

}


register_widget( 'WP_Widget_KT_Image' );
<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT Ads widget class
 *
 * @since 2.8.0
 */
class WP_Widget_KT_Ads extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_kt_ads', 'description' => __( 'Ads for widget.', THEME_LANG ) );
		parent::__construct('kt_ads', __('KT: Ads', THEME_LANG ), $widget_ops);
	}

	public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
    
        $attachment1 = get_thumbnail_attachment($instance['attachment1'], 'kt_ads');
        $attachment2 = get_thumbnail_attachment($instance['attachment2'], 'kt_ads');
    
		echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        echo "<div class='kt-ads-content'>";
        if($attachment1){
            if($instance['link1']){
                echo "<a href='".esc_attr($instance['link1'])."' target='".esc_attr($instance['target'])."'>";
            }
            echo "<img src='".$attachment1['url']."' alt='".esc_attr($attachment1['alt'])."' title='".esc_attr($attachment1['title'])."'/>";
            if($instance['link1']){
                echo "</a>";
            }
        }
        if($attachment2){
            if($instance['link2']){
                echo "<a href='".esc_attr($instance['link2'])."' target='".esc_attr($instance['target'])."'>";
            }
            echo "<img src='".$attachment2['url']."' alt='".esc_attr($attachment2['alt'])."' title='".esc_attr($attachment2['title'])."'/>";
            if($instance['link2']){
                echo "</a>";
            }
        }
        echo "</div>";
		echo $args['after_widget'];
	}
	

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        $instance['target'] = $new_instance['target'];
        $instance['attachment1'] = intval($new_instance['attachment1']);
        $instance['link1'] = strip_tags($new_instance['link1']);
        $instance['attachment2'] = intval($new_instance['attachment2']);
        $instance['link2'] = strip_tags($new_instance['link2']);
        
		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('Image', THEME_LANG), 'target' => '_self', 'link1' => '', 'attachment1' => '', 'link2' => '', 'attachment2' => '') );
        $title = strip_tags($instance['title']);
        
        $preview1 = $preview2 = false;
        $img_preview1 = $img_preview2 = "";
        
		$link1 = esc_attr( $instance['link1'] );
        $attachment1 = esc_attr( $instance['attachment1'] );
        if($instance['attachment1']){
            $file1 = get_thumbnail_attachment($instance['attachment1'], 'full');
            $preview1 = true;
            $img_preview1 = $file1['url'];
        }
		
        $link2 = esc_attr( $instance['link2'] );
        $attachment2 = esc_attr( $instance['attachment2'] );
        if($instance['attachment2']){
            $file2 = get_thumbnail_attachment($instance['attachment2'], 'full');
            $preview2 = true;
            $img_preview2 = $file2['url'];
        }
	?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p style="text-align: center;">
            <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attr_e('Select your image 1', THEME_LANG) ?>" />
            <input class="widefat kt_image_attachment" id="<?php echo $this->get_field_id('attachment1'); ?>" name="<?php echo $this->get_field_name('attachment1'); ?>" type="hidden" value="<?php echo esc_attr($attachment1); ?>" />
        </p>
        <p class="kt_image_preview" style="<?php if($preview1){ echo "display: block;";} ?>">
            <img src="<?php echo esc_url($img_preview1); ?>" alt="" class="kt_image_preview_img" />
        </p>
        <p style="clear: both;">
            <label for="<?php echo $this->get_field_id('link1'); ?>"><?php _e('Link Ads 1:', THEME_LANG); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('link1'); ?>" name="<?php echo $this->get_field_name('link1'); ?>" type="text" value="<?php echo esc_attr($link1); ?>" />
        </p>
        
        <p style="text-align: center;">
            <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attr_e('Select your image 2', THEME_LANG) ?>" />
            <input class="widefat kt_image_attachment" id="<?php echo $this->get_field_id('attachment2'); ?>" name="<?php echo $this->get_field_name('attachment2'); ?>" type="hidden" value="<?php echo esc_attr($attachment2); ?>" />
        </p>
        <p class="kt_image_preview" style="<?php if($preview2){ echo "display: block;";} ?>">
            <img src="<?php echo esc_url($img_preview2); ?>" alt="" class="kt_image_preview_img" />
        </p>
        <p style="clear: both;">
            <label for="<?php echo $this->get_field_id('link2'); ?>"><?php _e('Link Ads 2:', THEME_LANG); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('link2'); ?>" name="<?php echo $this->get_field_name('link2'); ?>" type="text" value="<?php echo esc_attr($link2); ?>" />
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e( 'Target:', THEME_LANG); ?></label>
			<select name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>" class="widefat">
				<option value="_self"<?php selected( $instance['target'], '_self' ); ?>><?php _e('Stay in Window', THEME_LANG); ?></option>
				<option value="_blank"<?php selected( $instance['target'], '_blank' ); ?>><?php _e('Open New Window', THEME_LANG); ?></option>
			</select>
		</p>
<?php
	}

}


register_widget( 'WP_Widget_KT_Ads' );
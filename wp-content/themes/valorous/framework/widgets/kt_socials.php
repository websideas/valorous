<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT Ads widget class
 *
 * @since 2.8.0
 */
class WP_Widget_KT_Socials extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_kt_socials', 'description' => __( 'Socials for widget.', THEME_LANG ) );
		parent::__construct('kt_socials', __('KT: Socials', THEME_LANG ), $widget_ops);
	}

	public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        
        $value = isset( $instance['value'] ) ? $instance['value'] : '';
        $style = isset( $instance['style'] ) ? $instance['style'] : 'accent';
        $size = isset( $instance['size'] ) ? $instance['size'] : 'standard';
        $tooltip = isset( $instance['tooltip'] ) ? $instance['tooltip'] : '';
        $space_between_item    = isset( $instance['space_between_item'] ) ? absint( $instance['space_between_item'] ) : 3;
        
		echo $args['before_widget'];
        
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
            $social_icons = '';
            
            $socials_arr = array(
                'facebook' => array('title' => __('Facebook', THEME_LANG), 'icon' => 'fa fa-facebook', 'link' => '%s'),
                'twitter' => array('title' => __('Twitter', THEME_LANG), 'icon' => 'fa fa-twitter', 'link' => 'http://www.twitter.com/%s'),
                'dribbble' => array('title' => __('Dribbble', THEME_LANG), 'icon' => 'fa fa-dribbble', 'link' => 'http://www.dribbble.com/%s'),
                'vimeo' => array('title' => __('Vimeo', THEME_LANG), 'icon' => 'fa fa-vimeo-square', 'link' => 'http://www.vimeo.com/%s'),
                'tumblr' => array('title' => __('Tumblr', THEME_LANG), 'icon' => 'fa fa-tumblr', 'link' => 'http://%s.tumblr.com/'),
                'skype' => array('title' => __('Skype', THEME_LANG), 'icon' => 'fa fa-skype', 'link' => 'skype:%s'),
                'linkedin' => array('title' => __('LinkedIn', THEME_LANG), 'icon' => 'fa fa-linkedin', 'link' => '%s'),
                'googleplus' => array('title' => __('Google Plus', THEME_LANG), 'icon' => 'fa fa-google-plus', 'link' => '%s'),
                'youtube' => array('title' => __('Youtube', THEME_LANG), 'icon' => 'fa fa-youtube', 'link' => 'http://www.youtube.com/user/%s'),
                'pinterest' => array('title' => __('Pinterest', THEME_LANG), 'icon' => 'fa fa-pinterest', 'link' => 'http://www.pinterest.com/%s'),
                'instagram' => array('title' => __('Instagram', THEME_LANG), 'icon' => 'fa fa-instagram', 'link' => 'http://instagram.com/%s'),
            );
            
            foreach($socials_arr as $k => &$v){
                $val = kt_option($k);
                $v['val'] = ($val) ? $val : '';
            }
            
            $margin = ($space_between_item > 0) ? 'style="margin:0 '.$space_between_item.'px;"' : '';

            $tooltiphtml = '';
            if($tooltip) {
                $tooltiphtml .= ' data-toggle="tooltip" data-placement="'.esc_attr($tooltip).'" ';
            }
            
            if($value){
                $social_type = explode(',', $value);
                foreach ($social_type as $id) {
                    $val = $socials_arr[$id];
                    $social_text = '<i class="'.esc_attr($val['icon']).'"></i>';
                    $social_icons .= '<li '.$margin.'><a class="'.esc_attr($id).'" title="'.esc_attr($val['title']).'" '.$tooltiphtml.' href="'.esc_url(str_replace('%s', $val['val'], $val['link'])).'" target="_blank">'.$social_text.'</a></li>'."\n";
                }
            }else{
                foreach($socials_arr as $key => $val){
                    $social_text = '<i class="'.esc_attr($val['icon']).'"></i>';
                    $social_icons .= '<li '.$margin.'><a class="'.esc_attr($key).'"  '.$tooltiphtml.' title="'.esc_attr($val['title']).'" href="'.esc_url(str_replace('%s', $val['val'], $val['link'])).'" target="_blank">'.$social_text.'</a></li>'."\n";
                }
            }
            
            echo "<div class='socials-icon-wrapper social-style-".$style." social-icons-".$size." clearfix'>";
                echo '<ul class="social-nav clearfix">';
                    echo $social_icons;
                echo '</ul>';
            echo "</div>";
		echo $args['after_widget'];
	}
	

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        
        $instance['value'] = $new_instance['value'];
        if ( in_array( $new_instance['style'], array( 'accent', 'dark', 'light', 'color' ) ) ) {
            $instance['style'] = $new_instance['style'];
        } else {
            $instance['style'] = 'accent';
        }
        if ( in_array( $new_instance['background_style'], array( '', 'rounded', 'boxed', 'rounded-less', 'diamond-square', 'rounded-outline', 'boxed-outline', 'rounded-less-outline', 'diamond-square-outline' ) ) ) {
            $instance['background_style'] = $new_instance['background_style'];
        } else {
            $instance['background_style'] = '';
        }
        if ( in_array( $new_instance['size'], array( 'standard', 'small' ) ) ) {
            $instance['size'] = $new_instance['size'];
        } else {
            $instance['size'] = '';
        }
        if ( in_array( $new_instance['tooltip'], array( '', 'top', 'right', 'bottom', 'left' ) ) ) {
            $instance['tooltip'] = $new_instance['tooltip'];
        } else {
            $instance['tooltip'] = '';
        }
        if ( in_array( $new_instance['align'], array( '', 'center', 'right', 'left' ) ) ) {
            $instance['align'] = $new_instance['align'];
        } else {
            $instance['align'] = '';
        }
        $instance['space_between_item'] = (int) $new_instance['space_between_item'];
        
		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('Socials', THEME_LANG), 'target' => '_self', 'value' => '', 'style' => 'accent', 'background_style' => '', 'size' => 'standard', 'tooltip' => '', 'align' => '', 'space_between_item' => 3) );
        $title = strip_tags($instance['title']);
        
        $value = isset( $instance['value'] ) ? $instance['value'] : '';
        $style = isset( $instance['style'] ) ? $instance['style'] : 'accent';
        $background_style = isset( $instance['background_style'] ) ? $instance['background_style'] : '';
        $size = isset( $instance['size'] ) ? $instance['size'] : 'standard';
        $tooltip = isset( $instance['tooltip'] ) ? $instance['tooltip'] : '';
        $align = isset( $instance['align'] ) ? $instance['align'] : '';
        $space_between_item    = isset( $instance['space_between_item'] ) ? absint( $instance['space_between_item'] ) : 3;
	?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        
        <?php
            $socials = array(
                'facebook' => 'fa fa-facebook',
                'twitter' => 'fa fa-twitter',
                'pinterest' => 'fa fa-pinterest-p',
                'dribbble' => 'fa fa-dribbble',
                'vimeo' => 'fa fa-vimeo-square',
                'tumblr' => 'fa fa-tumblr',
                'skype' => 'fa fa-skype',
                'linkedin' => 'fa fa-linkedin',
                'googleplus' => 'fa fa-google-plus',
                'youtube' => 'fa fa-youtube-play',
                'instagram' => 'fa fa-instagram'
            );
            
            $arr_val = ($value) ? explode(',', $value) : array();
        ?>
    
        <div class="kt-socials-options">
            <ul class="kt-socials-lists clearfix">
                <?php foreach($socials as $key => $social){ ?>
                    <?php $class = (in_array($key, $arr_val)) ? 'selected' : ''; ?>
                    <li data-type="<?php echo $key; ?>" class="<?php echo $class; ?>"><i class="<?php echo $social; ?>"></i><span></span></li>
                <?php } ?>
            </ul><!-- .kt-socials-lists -->
            <ul class="kt-socials-profiles clearfix">
            <?php
                if(count($arr_val)){
                    foreach($arr_val as $item){ ?>
                        <li data-type="<?php echo $item; ?>"><i class="<?php echo $socials[$item]; ?>"></i><span></span></li>
                    <?php }
                }
            ?>
            </ul><!-- .kt-socials-profiles -->
            <input id="<?php echo $this->get_field_id( 'value' ); ?>" type="hidden" class="wpb_vc_param_value kt-socials-value" name="<?php echo $this->get_field_name( 'value' ); ?>" value="<?php echo esc_attr($value); ?>" />
        </div><!-- .kt-socials-options -->
        <small><?php _e( 'Empty for select all, Drop and sortable social',THEME_LANG ); ?></small>
        <?php wp_enqueue_script( 'cosials_js', FW_JS.'kt_socials.js', array('jquery'), FW_VER, true); ?>
        
        <p><label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:', THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
                <option <?php selected( $style, 'accent' ); ?> value="accent"><?php _e('Accent',THEME_LANG); ?></option>
                <option <?php selected( $style, 'dark' ); ?> value="dark"><?php _e('Dark',THEME_LANG); ?></option>
                <option <?php selected( $style, 'light' ); ?> value="light"><?php _e('Light',THEME_LANG); ?></option>
                <option <?php selected( $style, 'color' ); ?> value="color"><?php _e('Color',THEME_LANG); ?></option>
            </select>
        </p>
        <p><label for="<?php echo $this->get_field_id('background_style'); ?>"><?php _e('Background Style:', THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('background_style'); ?>" name="<?php echo $this->get_field_name('background_style'); ?>">
                <option <?php selected( $background_style, '' ); ?> value=""><?php _e('None',THEME_LANG); ?></option>
                <option <?php selected( $background_style, 'rounded' ); ?> value="rounded"><?php _e('Circle',THEME_LANG); ?></option>
                <option <?php selected( $background_style, 'boxed' ); ?> value="boxed"><?php _e('Square',THEME_LANG); ?></option>
                <option <?php selected( $background_style, 'rounded-less' ); ?> value="rounded-less"><?php _e('Rounded',THEME_LANG); ?></option>
                <option <?php selected( $background_style, 'diamond-square' ); ?> value="diamond-square"><?php _e('Diamond Square',THEME_LANG); ?></option>
                <option <?php selected( $background_style, 'rounded-outline' ); ?> value="rounded-outline"><?php _e('Outline Circle',THEME_LANG); ?></option>
                <option <?php selected( $background_style, 'boxed-outline' ); ?> value="boxed-outline"><?php _e('Outline Square',THEME_LANG); ?></option>
                <option <?php selected( $background_style, 'rounded-less-outline' ); ?> value="rounded-less-outline"><?php _e('Outline Rounded',THEME_LANG); ?></option>
                <option <?php selected( $background_style, 'diamond-square-outline' ); ?> value="diamond-square-outline"><?php _e('Outline Diamond Square',THEME_LANG); ?></option>
            </select>
            <small><?php _e('Select background shape and style for social.',THEME_LANG); ?></small>
        </p>
        <p><label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size:', THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>">
                <option <?php selected( $size, 'standard' ); ?> value="standard"><?php _e('Standard',THEME_LANG); ?></option>
                <option <?php selected( $size, 'small' ); ?> value="small"><?php _e('Small',THEME_LANG); ?></option>
            </select>
        </p>
        <p><label for="<?php echo $this->get_field_id('tooltip'); ?>"><?php _e('Tooltip:', THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('tooltip'); ?>" name="<?php echo $this->get_field_name('tooltip'); ?>">
                <option <?php selected( $tooltip, '' ); ?> value=""><?php _e('None',THEME_LANG); ?></option>
                <option <?php selected( $tooltip, 'top' ); ?> value="top"><?php _e('Top',THEME_LANG); ?></option>
                <option <?php selected( $tooltip, 'right' ); ?> value="right"><?php _e('Right',THEME_LANG); ?></option>
                <option <?php selected( $tooltip, 'bottom' ); ?> value="bottom"><?php _e('Bottom',THEME_LANG); ?></option>
                <option <?php selected( $tooltip, 'left' ); ?> value="left"><?php _e('Left',THEME_LANG); ?></option>
            </select>
            <small><?php _e('Select the tooltip position',THEME_LANG); ?></small>
        </p>
        <p><label for="<?php echo $this->get_field_id('align'); ?>"><?php _e('Align:', THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('align'); ?>" name="<?php echo $this->get_field_name('align'); ?>">
                <option <?php selected( $align, '' ); ?> value=""><?php _e('None',THEME_LANG); ?></option>
                <option <?php selected( $align, 'center' ); ?> value="center"><?php _e('Center',THEME_LANG); ?></option>
                <option <?php selected( $align, 'left' ); ?> value="left"><?php _e('Left',THEME_LANG); ?></option>
                <option <?php selected( $align, 'right' ); ?> value="right"><?php _e('Right',THEME_LANG); ?></option>
            </select>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'space_between_item' ); ?>"><?php _e( 'Space Between item:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'space_between_item' ); ?>" name="<?php echo $this->get_field_name( 'space_between_item' ); ?>" type="text" value="<?php echo $space_between_item; ?>" /></p>
<?php
	}

}


register_widget( 'WP_Widget_KT_Socials' );
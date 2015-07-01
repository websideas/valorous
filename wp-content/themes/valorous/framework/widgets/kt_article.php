<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class kt_article_widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_kt_article', 'description' => __( 'Show posts of category.') );
		parent::__construct('kt_article', __('KT Article', THEME_LANG ), $widget_ops);
	}

	public function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $number = intval($instance['number']);
        $order = $instance['order'];
        $orderby = $instance['orderby'];
        
        $showcategory = $instance['showcategory'];
        $showimage = $instance['showimage'];
        $showdate = $instance['showdate'];
        $showcomment = $instance['showcomment'];
        $showauthor = $instance['showauthor'];
        $layout = $instance['layout'];
        $category_name = $instance['category_name'];
       
        echo $before_widget;
                
                $args_article = array(
    				'orderby' => $orderby, 
                    'order' => $order,
                    'posts_per_page' => $number
    			);
                    
                if(!in_array('all',$category_name)){
                    $args_article['category__in'] = $category_name;
                }
    			
    			$query = new WP_Query( $args_article );
                
                global $blog_atts;
			?>
            <?php if ( $query->have_posts() ){ ?>
                <ul class="<?php echo $layout; ?>">
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <?php if($showimage && has_post_thumbnail()){ $class = ' has-thumbnail'; }else{ $class = ''; } ?>
                        <li class="acticle-item <?php echo $class; ?>">
                            <?php
                                if($showimage && has_post_thumbnail()){
                                    kt_post_thumbnail_image('small', 'img-responsive');
                                }
                            ?>
                            <div class="article-attr">
                                <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <?php if( $showcategory ){ kt_entry_meta_categories(); } ?>
                                <?php if( $showdate || $showcomment || $showauthor ){ ?>
                                    <div class="entry-meta-data">
                                        <?php 
                                            if( $showdate ){ kt_entry_meta_time($blog_atts['date_format']); }
                                            if( $showauthor ){ kt_entry_meta_author(); }
                                            if( $showcomment ){ kt_entry_meta_comments(); }
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </li>
                    <?php endwhile; wp_reset_postdata(); ?>
                </ul>
            <?php }
        echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        
        $instance['order'] =  $new_instance['order'];
        $instance['orderby'] =  $new_instance['orderby'];
        $instance['showdate'] = (bool)$new_instance['showdate'];
        $instance['showcategory'] = (bool)$new_instance['showcategory'];
        $instance['showimage'] = (bool)$new_instance['showimage'];
        $instance['showcomment'] = (bool)$new_instance['showcomment'];
        $instance['showauthor'] = (bool)$new_instance['showauthor'];
        $instance['layout'] = $new_instance['layout'];
        $instance['category_name'] = $new_instance['category_name'];
        
        $instance['number'] = intval($new_instance['number']);
        if(!$instance['number']) $instance['number'] = 5;
        
		return $instance;
	}
    
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,
            array( 'title' => __('Lastest Article',THEME_LANG),
                   'number' => 5,
                   'category_name' => array(),
                   'orderby' => 'date',
                   'order' => 'DESC', 
                   'showimage'=> 1, 
                   'showcategory' => 1,
                   'showdate'=> 1, 
                   'showauthor' => 1,
                   'showcomment' => 0,
                   'layout' => 'layout-1',
            ));            
        $title = strip_tags($instance['title']);
        $number = intval($instance['number']);
        
        $order = $instance['order'];
        $orderby = $instance['orderby'];
                
        $showdate = $instance['showdate'];
        $showcategory = $instance['showcategory'];
        $showimage = $instance['showimage'];
        $showcomment = $instance['showcomment'];
        $showauthor = $instance['showauthor'];
        $layout = $instance['layout'];
        
        $category_name = $instance['category_name'];
        if(!count($category_name)) $category_name = array('all');
        
        $cat = get_terms( 'category', array('hide_empty' => false));
	?>
		<p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Title:',THEME_LANG); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>" type="text"
                value="<?php echo  esc_attr($title);?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">
                <?php _e('Number of posts to show:',THEME_LANG); ?> </label>
            <input type="text" class="widefat" value="<?php echo  esc_attr($number);?>"
                id="<?php echo $this->get_field_id('number'); ?>"
                name="<?php echo $this->get_field_name('number'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category_name'); ?>">
                <?php _e('Category:',THEME_LANG); ?> </label>
            <select class="widefat" id="<?php echo $this->get_field_id('category_name'); ?>" name="<?php echo $this->get_field_name('category_name'); ?>[]" multiple="multiple">
                <option <?php if (in_array('all',$category_name)){ echo 'selected="selected"';} ?> value="all"><?php _e('All',THEME_LANG); ?></option>
                <?php foreach($cat as $item){ ?>
                    <option <?php if (in_array($item->term_id,$category_name)){ echo 'selected="selected"';} ?> value="<?php echo $item->term_id ?>"><?php echo $item->name; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('orderby'); ?>">
                <?php _e('Order by:', THEME_LANG); ?></label>
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
        <p>
            <label for="<?php echo $this->get_field_id('order'); ?>">
                <?php _e('Order:',THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                <option <?php selected( $order, 'DESC' ); ?> value="DESC"><?php _e('Desc',THEME_LANG); ?></option>
                <option <?php selected( $order, 'ASC' ); ?> value="ASC"><?php _e('Asc',THEME_LANG); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('showimage'); ?>">
                <?php _e('Show Image:',THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('showimage'); ?>" name="<?php echo $this->get_field_name('showimage'); ?>">
                <option <?php selected( $showimage, 1 ); ?> value="1"><?php _e('True',THEME_LANG); ?></option>
                <option <?php selected( $showimage, 0 ); ?> value="0"><?php _e('False',THEME_LANG); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('showcategory'); ?>">
                <?php _e('Show Category:',THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('showcategory'); ?>" name="<?php echo $this->get_field_name('showcategory'); ?>">
                <option <?php selected( $showcategory, 1 ); ?> value="1"><?php _e('True',THEME_LANG); ?></option>
                <option <?php selected( $showcategory, 0 ); ?> value="0"><?php _e('False',THEME_LANG); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('showdate'); ?>">
                <?php _e('Show date:',THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('showdate'); ?>" name="<?php echo $this->get_field_name('showdate'); ?>">
                <option <?php selected( $showdate, 1 ); ?> value="1"><?php _e('True',THEME_LANG); ?></option>
                <option <?php selected( $showdate, 0 ); ?> value="0"><?php _e('False',THEME_LANG); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('showauthor'); ?>">
                <?php _e('Show Author:',THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('showauthor'); ?>" name="<?php echo $this->get_field_name('showauthor'); ?>">
                <option <?php selected( $showauthor, 1 ); ?> value="1"><?php _e('True',THEME_LANG); ?></option>
                <option <?php selected( $showauthor, 0 ); ?> value="0"><?php _e('False',THEME_LANG); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('showcomment'); ?>">
                <?php _e('Show Comment:',THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('showcomment'); ?>" name="<?php echo $this->get_field_name('showcomment'); ?>">
                <option <?php selected( $showcomment, 0 ); ?> value="0"><?php _e('False',THEME_LANG); ?></option>
                <option <?php selected( $showcomment, 1 ); ?> value="1"><?php _e('True',THEME_LANG); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('layout'); ?>">
                <?php _e('Layout:',THEME_LANG); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>">
                <option <?php selected( $layout, 'layout-1' ); ?> value="layout-1"><?php _e('Layout 1',THEME_LANG); ?></option>
                <option <?php selected( $layout, 'layout-2' ); ?> value="layout-2"><?php _e('Layout 2',THEME_LANG); ?></option>
            </select>
        </p>
<?php
	}
}

register_widget( 'kt_article_widget' );
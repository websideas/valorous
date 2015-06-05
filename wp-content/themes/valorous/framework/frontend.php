<?php


// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/*
 * Set up the content width value based on the theme's design.
 *
 * @see kt_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 1170;




add_action( 'after_setup_theme', 'theme_setup' );
if ( ! function_exists( 'theme_setup' ) ):

function theme_setup() {
    /**
     * Editor style.
     */
    add_editor_style();
    
    /**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
    
    /**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array('gallery', 'link', 'image', 'quote', 'video', 'audio') );

    /*
    * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
	 */
	add_theme_support( 'title-tag' );
    
    /**
	 * Allow shortcodes in widgets.
	 *
	 */
	add_filter( 'widget_text', 'do_shortcode' );
    
    
    /**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
    
    
    if (function_exists( 'add_image_size' ) ) {
        add_image_size( 'recent_posts', 570, 380, true);
        add_image_size( 'small', 170, 170, true );
        add_image_size( 'blog-post', 1040, 390, true );
    }
    
    load_theme_textdomain( THEME_LANG, THEME_DIR . '/languages' );
    
    /**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(array(
        'primary' => __('Main menu', THEME_LANG),
        'top'	  => __( 'Top Menu', THEME_LANG ),
        'bottom'	  => __( 'Bottom Menu', THEME_LANG ),
    ));

}
endif;


/**
 * Outputs the header meta title tag
 *
 * @since 1.0
 * @return void
 */
if ( ! function_exists( 'kt_meta_title' ) ) {
	function kt_meta_title() {
	   
	}
}


/**
 * Enqueue scripts and styles.
 *
 * @since London 1.0
 */
function london_scripts() {

    wp_enqueue_style( 'london-style', get_stylesheet_uri(), array('mediaelement') );
    wp_enqueue_style( 'bootstrap-css', THEME_LIBS . 'bootstrap/css/bootstrap.min.css', array());
    wp_enqueue_style( 'font-awesome', THEME_FONTS . 'font-awesome/css/font-awesome.min.css', array());
    wp_enqueue_style( 'font_kites', THEME_FONTS . 'font_kites/stylesheet.css', array());
    wp_enqueue_style( 'font_elegant_font', THEME_FONTS . 'elegant_font/style.css', array());
    wp_enqueue_style( 'animate', THEME_CSS . 'animate.min.css', array());
    wp_enqueue_style( 'mCustomScrollbar', THEME_CSS . 'jquery.mCustomScrollbar.min.css', array());
    wp_enqueue_style( 'magnific-popup', THEME_CSS . 'magnific-popup.css', array());
    wp_enqueue_style( 'owl-carousel', THEME_LIBS . 'owl-carousel/assets/owl.carousel.css', array());
    wp_enqueue_style( 'easyzoom', THEME_CSS . 'easyzoom.css', array());
    wp_enqueue_style( 'woocommerce-products-filter', THEME_CSS . 'woocommerce-products-filter.css', array());
    
	// Load our main stylesheet.
    wp_enqueue_style( 'london-main', THEME_CSS . 'style.css', array( 'london-style' ), '20141010' );
    wp_enqueue_style( 'woocommerce', THEME_CSS . 'woocommerce.css', array('london-main'));
    wp_enqueue_style( 'queries', THEME_CSS . 'queries.css', array('london-main'));
    
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'london-ie', THEME_CSS . 'ie.css', array( 'london-style' ), '20141010' );
	wp_style_add_data( 'london-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    
    wp_enqueue_script( 'jquery-ui-tabs' );
    
    wp_enqueue_script( 'easing-script', THEME_JS . 'jquery.easing.1.3.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'bootstrap-script', THEME_LIBS . 'bootstrap/js/bootstrap.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'mCustomScrollbar-script', THEME_JS . 'jquery.mCustomScrollbar.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'mousewheel-script', THEME_JS . 'jquery.mousewheel.min.js', array( 'jquery' ), null, false );
    wp_enqueue_script( 'waitforimages-script', THEME_JS . 'jquery.waitforimages.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'ktSticky-script', THEME_JS . 'jquery.kt.sticky.js', array( 'jquery' ), null, true );    
    wp_enqueue_script( 'owl-carousel', THEME_LIBS . 'owl-carousel/owl.carousel.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'superfish-script', THEME_JS . 'jquery.superfish.custom.js', array( 'jquery', 'hoverIntent' ), null, true );
    wp_enqueue_script( 'magnific-popup-script', THEME_JS . 'jquery.magnific-popup.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'matchHeightscript', THEME_JS . 'jquery.matchHeight-min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'countdown-script', THEME_JS . 'jquery.countdown.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'variations-plugin-script', THEME_JS . 'woo-variations-plugin.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'easyzoom', THEME_JS . 'easyzoom.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'waypoints', THEME_JS . 'jquery.waypoints.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'countTo', THEME_JS . 'jquery.countTo.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'kt_footer', THEME_JS . 'jquery.kt.footer.js', array( 'jquery' ), null, true );
    
    wp_enqueue_script( 'london-script', THEME_JS . 'functions.js', array( 'jquery', 'wp-mediaelement' ), null, true );
	
    wp_localize_script( 'london-script', 'ajax_frontend', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'ajax_frontend' ),
        'current_date' => date_i18n('Y-m-d H:i:s')
    ));

    
}
add_action( 'wp_enqueue_scripts', 'london_scripts' , 69 );


/**
 * Add scroll to top
 *
 * @since London 1.0
 */
add_action( 'theme_before_footer_top', 'theme_after_footer_top_addscroll' );
function theme_after_footer_top_addscroll(){
    echo "<a href='#top' id='backtotop'></a>";
}


function kt_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'kt_excerpt_more');

function kt_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'kt_excerpt_length', 999 );



if ( ! function_exists( 'kt_comment_nav' ) ) :
    /**
     * Display navigation to next/previous comments when applicable.
     *
     * @since London 1.0
     */
    function kt_comment_nav() {
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
            <nav class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php _e( 'Comment navigation', THEME_LANG ); ?></h2>
                <div class="nav-links">
                    <?php
                    if ( $prev_link = get_previous_comments_link( __( 'Older Comments', THEME_LANG ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', $prev_link );
                    endif;

                    if ( $next_link = get_next_comments_link( __( 'Newer Comments',  THEME_LANG ) ) ) :
                        printf( '<div class="nav-next">%s</div>', $next_link );
                    endif;
                    ?>
                </div><!-- .nav-links -->
            </nav><!-- .comment-navigation -->
        <?php
        endif;
    }
endif;

if ( ! function_exists( 'kt_post_thumbnail_image' ) ) :
    /**
     * Display an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     *
     */
    function kt_post_thumbnail_image($size = 'post-thumbnail', $class_img = '', $post_id = null) {
        if ( post_password_required() || is_attachment()) {
            return;
        }

        if(has_post_thumbnail()){ ?>
            <?php if ( is_singular() ){ ?>
                <div class="entry-thumb">
                    <?php the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) ); ?>
                </div><!-- .entry-thumb -->
            <?php }else{ ?>
                <a class="entry-thumb" href="<?php the_permalink(); ?>" aria-hidden="true">
                    <?php the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) ); ?>
                </a>
            <?php } ?>
        <?php }
    }
endif;


if ( ! function_exists( 'kt_post_thumbnail' ) ) :
    /**
     * Display an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     *
     */
    function kt_post_thumbnail($size = 'post-thumbnail', $class_img = '', $post_id = null) {
        if ( post_password_required() || is_attachment()) {
            return;
        }
        $format = get_post_format();
        ?>

            <?php if(has_post_thumbnail() && ($format == '' || $format == 'image')){ ?>
                <?php if ( is_singular() ){ ?>
                    <div class="entry-thumb">
                        <?php the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) ); ?>
                    </div><!-- .entry-thumb -->
                <?php }else{ ?>
                    <a class="entry-thumb" href="<?php the_permalink(); ?>" aria-hidden="true">
                        <?php the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) ); ?>
                    </a>
                <?php } ?>
            <?php }elseif($format == 'gallery'){
                $type = rwmb_meta('_kt_gallery_type');
                if($type == 'rev' && class_exists( 'RevSlider' )){
                    if ($rev = rwmb_meta('_kt_gallery_rev_slider')) {
                        echo '<div class="entry-thumb">';
                        putRevSlider($rev);
                        echo '</div><!-- .entry-thumb -->';
                    }
                }elseif($type == 'layer' && is_plugin_active( 'LayerSlider/layerslider.php' ) ) {
                    if($layerslider = rwmb_meta('_kt_gallery_layerslider')){
                        echo '<div class="entry-thumb">';
                        echo do_shortcode('[layerslider id="'.rwmb_meta('_kt_gallery_layerslider').'"]');
                        echo '</div><!-- .entry-thumb -->';
                    }
                }elseif($type == ''){
                    echo '<div class="entry-thumb">';
                    $images = get_galleries_post('_kt_gallery_images');
                    $galleries_html = '';
                    foreach($images as $image){
                        $galleries_html .= '<div class="recent-posts-item"><img src="'.$image['url'].'" alt="" /></div>';
                    }
                    $atts = array('desktop' => 1, 'tablet' => 1, 'mobile' => 1, 'navigation_position' => 'center', 'margin' => 0);
                    $carousel_ouput = kt_render_carousel($atts);
                    echo str_replace('%carousel_html%', $galleries_html, $carousel_ouput);

                    echo '</div><!-- .entry-thumb -->';
                }
            }elseif($format == 'video'){
                $type = rwmb_meta('_kt_video_type');
                if($type == 'youtube'){
                    if($video_id = rwmb_meta('_kt_video_id')){
                        echo '<div class="entry-thumb"><div class="embed-responsive embed-responsive-16by9">';
                        echo kt_video_youtube($video_id);
                        echo '</div></div><!-- .entry-thumb -->';
                    }
                }elseif($type == 'vimeo'){
                    if($video_id = rwmb_meta('_kt_video_id')){
                        echo '<div class="entry-thumb"><div class="embed-responsive embed-responsive-16by9">';
                        echo kt_video_vimeo($video_id);
                        echo '</div></div><!-- .entry-thumb -->';
                    }
                }elseif($type == 'dailymotion'){
                    if($video_id = rwmb_meta('_kt_video_id')){
                        echo '<div class="entry-thumb"><div class="embed-responsive embed-responsive-16by9">';
                        echo kt_video_dailymotion($video_id);
                        echo '</div></div><!-- .entry-thumb -->';
                    }
                }
            }elseif($format == 'audio'){
                $type = rwmb_meta('_kt_audio_type');
                if($type == 'upload'){
                    if($audios = rwmb_meta('_kt_audio_mp3', 'type=file')){
                        foreach($audios as $audio) {
                            echo '<div class="entry-thumb">';
                            printf(
                                '<div class="post-media-audio"><audio src="%s" type="audio/mp3" controls="controls"></div>',
                                $audio['url']
                            );
                            echo '</div><!-- .entry-thumb -->';
                        }
                    }
                }elseif($type == 'soundcloud'){
                    if($soundcloud = rwmb_meta('_kt_audio_soundcloud')){
                        echo '<div class="entry-thumb">';
                        echo do_shortcode($soundcloud);
                        echo '</div><!-- .entry-thumb -->';
                    }
                }
            }
    }
endif;






/**
 *
 * Custom call back function for default post type
 *
 * @param $comment
 * @param $args
 * @param $depth
 */
function kt_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>

<li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID() ?>">
    <div  id="comment-<?php comment_ID(); ?>" class="comment-item">

        <div class="comment-avatar">
            <?php echo get_avatar($comment->comment_author_email, $size='90',$default='' ); ?>
        </div>
        <div class="comment-content">
            <div class="comment-meta">
                <a class="comment-author" href="#"><?php printf(__('<b class="author_name">%s </b>'), get_comment_author_link()) ?></a>
                <span class="comment-date"><?php printf( '%1$s' , get_comment_date( 'F j, Y \a\t g:i a' )); ?></span>
            </div>
            <div class="comment-entry entry-content">
                <?php comment_text() ?>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php _e('Your comment is awaiting moderation.', THEME_LANG) ?></em>
                <?php endif; ?>
            </div>
            <div class="comment-actions clear">
                <?php edit_comment_link(__('(Edit)', THEME_LANG),'  ','') ?>
                <?php comment_reply_link( array_merge( $args,
                    array('depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' =>'<i class="fa fa-share"></i> '.__('Reply')
                    ))) ?>
            </div>
        </div>

        <div class="clear"></div>
    </div>
<?php
}


if ( ! function_exists( 'kt_paging_nav' ) ) :
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function kt_paging_nav($post_id = null) {
        global $post;
        if(!$post_id) $post_id = $post->ID;
        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
        $next     = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous ) return;

        ?>
        <nav class="navigation post-navigation clearfix" role="navigation">
            <div class="nav-links">
                <?php
                previous_post_link('<div class="nav-previous"><span class="meta-nav">'.__('Previous:', THEME_LANG).'</span>%link</div>', _x( ' %title', 'Previous post link', THEME_LANG ), TRUE);
                next_post_link('<div class="nav-next"><span class="meta-nav">'.__('Next:', THEME_LANG).'</span>%link</div>', _x( ' %title', 'Next post link', THEME_LANG ), TRUE);
                ?>
            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
    <?php
}
endif;



if ( ! function_exists( 'kt_entry_meta_author' ) ) :
    /**
     * Prints HTML with meta information for author.
     *
     */
    function kt_entry_meta_author() {
        if ( 'post' == get_post_type() ) {
            printf( '<span class="author vcard">%4$s <span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span>',
                _x( 'Author', 'Used before post author name.', THEME_LANG ),
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                get_the_author(),
                __('Posed by:', THEME_LANG )
            );
        }
    }
endif;

if ( ! function_exists( 'kt_entry_meta_categories' ) ) :
    /**
     * Prints HTML with meta information for categories.
     *
     */
    function kt_entry_meta_categories() {
        if ( 'post' == get_post_type() ) {
            $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', THEME_LANG ) );
            if ( $categories_list ) {
                printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                    _x( 'Categories', 'Used before category names.', THEME_LANG ),
                    $categories_list
                );
            }
        }
    }
endif;

if ( ! function_exists( 'kt_entry_meta_tags' ) ) :
    /**
     * Prints HTML with meta information for tags.
     *
     */
    function kt_entry_meta_tags() {
        if ( 'post' == get_post_type() ) {
            $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfifteen' ) );
            if ( $tags_list ) {
                printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                    _x( 'Tags', 'Used before tag names.', 'twentyfifteen' ),
                    $tags_list
                );
            }
        }
    }
endif;



if ( ! function_exists( 'kt_entry_meta_comments' ) ) :
    /**
     * Prints HTML with meta information for comments.
     *
     */
    function kt_entry_meta_comments() {
        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">';
            comments_popup_link( __( 'Leave a comment', THEME_LANG ), __( '1 Comment', THEME_LANG ), __( '% Comments', THEME_LANG ) );
            echo '</span>';
        }
    }
endif;

if ( ! function_exists( 'kt_entry_meta_time' ) ) :
    /**
     * Prints HTML with meta information for time.
     *
     */
    function kt_entry_meta_time($format = 'd F Y') {
        if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
            $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

            if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }

            $time_show = ($format == 'time') ? human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago', THEME_LANG) : get_the_date($format);

            $time_string = sprintf( $time_string,
                esc_attr( get_the_date( 'c' ) ),
                $time_show,
                esc_attr( get_the_modified_date( 'c' ) ),
                get_the_modified_date()
            );

            printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
                _x( 'Posted on', 'Used before publish date.', THEME_LANG ),
                esc_url( get_permalink() ),
                $time_string
            );
        }
    }
endif;



/* ---------------------------------------------------------------------------
 * Entry author [entry_author]
 * --------------------------------------------------------------------------- */
if ( ! function_exists( 'kt_author_box' ) ) :
    /**
     * Prints HTML with information for author box.
     *
     */
    function kt_author_box() {
        ?>
        <div class="entry-author clearfix">
            <?php echo get_avatar( get_the_author_meta('ID'),'avatar' ); ?>
            <div class="entry-author-desc">
                <h4>
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                        <?php echo get_the_author_meta('display_name'); ?>
                    </a>
                </h4>

                <?php $description = get_the_author_meta('description'); ?>
                <?php if($description){ ?><p class="author-description"><?php echo $description; ?></p><?php } ?>

                <?php $url = get_the_author_meta('url'); ?>
                <?php if($url){ ?>
                    <p class="author-url">
                        <span class="author-label"><?php _e( 'Website:', THEME_LANG ) ?> </span>
                        <a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a></p>
                <?php } ?>

                <?php $googleplus = get_the_author_meta('googleplus'); ?>
                <?php $twitter = get_the_author_meta('twitter'); ?>
                <?php $facebook = get_the_author_meta('facebook'); ?>

                <p class="author-social">
                    <span class="author-label"><?php _e( 'Social Links:', THEME_LANG ) ?> </span>
                    <a href="mailto:<?php echo get_the_author_meta('user_email'); ?>"><i class="fa fa-envelope"></i></a>
                    <?php if($facebook){ ?>
                        <a href="<?php echo $facebook; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                    <?php } ?>
                    <?php if($twitter){ ?>
                        <a href="<?php echo $twitter; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                    <?php } ?>
                    <?php if($googleplus){ ?>
                        <a href="<?php echo $googleplus; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                    <?php } ?>
                </p>
            </div>
        </div>
    <?php }
endif;



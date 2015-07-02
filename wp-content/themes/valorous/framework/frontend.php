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
        add_image_size( 'blog_post', 1140, 450, true );
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

    wp_enqueue_style( 'london-style', get_stylesheet_uri(), array('mediaelement', 'wp-mediaelement') );
    wp_enqueue_style( 'bootstrap-css', THEME_LIBS . 'bootstrap/css/bootstrap.min.css', array());
    wp_enqueue_style( 'font-awesome', THEME_FONTS . 'font-awesome/css/font-awesome.min.css', array());
    wp_enqueue_style( 'font_kites', THEME_FONTS . 'font_kites/stylesheet.css', array());
    wp_enqueue_style( 'simple_line_icons', THEME_FONTS . 'simple_line_icons/simple-line-icons.css', array());
    wp_enqueue_style( 'animate', THEME_CSS . 'animate.min.css', array());
    wp_enqueue_style( 'mCustomScrollbar', THEME_CSS . 'jquery.mCustomScrollbar.min.css', array());
    wp_enqueue_style( 'magnific-popup', THEME_CSS . 'magnific-popup.css', array());
    wp_enqueue_style( 'magnific-effect', THEME_CSS . 'magnific-effect.css', array());
    wp_enqueue_style( 'owl-carousel', THEME_LIBS . 'owl-carousel/owl.carousel.css', array());
    wp_enqueue_style( 'owl-theme', THEME_LIBS . 'owl-carousel/owl.theme.css', array());

    wp_enqueue_style( 'easyzoom', THEME_CSS . 'easyzoom.css', array());
    wp_enqueue_style( 'mb.YTPlayer', THEME_LIBS . 'mb.YTPlayer/css/jquery.mb.YTPlayer.min.css', array());


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
    wp_enqueue_script( 'owl-carousel', THEME_LIBS . 'owl-carousel/owl.carousel.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'superfish-script', THEME_JS . 'jquery.superfish.custom.js', array( 'jquery', 'hoverIntent' ), null, true );
    wp_enqueue_script( 'magnific-popup-script', THEME_JS . 'jquery.magnific-popup.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'matchHeightscript', THEME_JS . 'jquery.matchHeight-min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'countdown-script', THEME_JS . 'jquery.countdown.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'variations-plugin-script', THEME_JS . 'woo-variations-plugin.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'easyzoom', THEME_JS . 'easyzoom.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'waypoints', THEME_JS . 'jquery.waypoints.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'countTo', THEME_JS . 'jquery.countTo.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'kt_footer', THEME_JS . 'jquery.kt.footer.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'masonry', THEME_JS . 'masonry.pkgd.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'isotope', THEME_JS . 'isotope.pkgd.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'easy-pie-chart', THEME_JS . 'jquery.easy-pie-chart.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'menu-one-page', THEME_JS . 'jquery.nav.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'mb.YTPlayer', THEME_LIBS . 'mb.YTPlayer/jquery.mb.YTPlayer.min.js', array( 'jquery' ), null, true );




    
    wp_enqueue_script( 'london-script', THEME_JS . 'functions.js', array( 'jquery', 'wp-mediaelement' ), null, true );
    global $wp_query;
    wp_localize_script( 'london-script', 'ajax_frontend', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'ajax_frontend' ),
        'current_date' => date_i18n('Y-m-d H:i:s'),
        'query_vars' => json_encode( $wp_query->query )
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



function kt_excerpt_length( ) {
    return kt_option('archive_excerpt_length', 30);
}
add_filter( 'excerpt_length', 'kt_excerpt_length', 99 );



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
    function kt_post_thumbnail_image($size = 'post-thumbnail', $class_img = '', $link = true) {
        if ( post_password_required() || is_attachment()) {
            return;
        }

        if(has_post_thumbnail()){ ?>
            <?php if ( $link ){ ?>
                <div class="entry-thumb">
                    <a href="<?php the_permalink(); ?>" aria-hidden="true">
                        <?php the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) ); ?>
                    </a>
                </div>
            <?php }else{ ?>
                <div class="entry-thumb">
                    <?php the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) ); ?>
                </div><!-- .entry-thumb -->
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
                    $images = get_galleries_post('_kt_gallery_images', $size);
                    $galleries_html = '';
                    foreach($images as $image){
                        $galleries_html .= '<div class="recent-posts-item"><img src="'.$image['url'].'" alt="" /></div>';
                    }
                    $atts = array( 'navigation_background' => "rgba(255,255,255,0.8)", 'navigation_color'=>"#5c5c5c", 'desktop' => 1, 'tablet' => 1, 'mobile' => 1, 'navigation_style' => "square", 'navigation_icon' => "fa fa-angle-left|fa fa-angle-right", 'navigation_position' => 'center', 'margin' => 0, 'pagination' => 'false');
                    $carousel_ouput = kt_render_carousel($atts);
                    echo str_replace('%carousel_html%', $galleries_html, $carousel_ouput);

                    echo '</div><!-- .entry-thumb -->';
                }
            }elseif($format == 'video'){
                $type = rwmb_meta('_kt_video_type');
                if($type == 'upload'){
                    $mp4 = kt_get_single_file('_kt_video_file_mp4');
                    $webm = kt_get_single_file('_kt_video_file_webm');
                    if($mp4 || $webm){
                        $video_shortcode = "[video ";
                        if($mp4) $video_shortcode .= 'mp4="'.$mp4.'" ';
                        if($webm) $video_shortcode .= 'webm="'.$webm.'" ';
                        $video_shortcode .= "]";
                        echo '<div class="entry-thumb">'.do_shortcode($video_shortcode).'</div><!-- .entry-thumb -->';
                    }

                }elseif($type == 'external'){
                    if($video_link = rwmb_meta('_kt_video_link')){
                        global $wp_embed;
                        $embed = $wp_embed->run_shortcode( '[embed]' . $video_link . '[/embed]' );
                        echo '<div class="entry-thumb"><div class="embed-responsive embed-responsive-16by9">'.do_shortcode($embed).'</div></div><!-- .entry-thumb -->';
                    }
                }
            }elseif($format == 'audio'){
                $type = rwmb_meta('_kt_audio_type');
                if($type == 'upload'){
                    if($audios = rwmb_meta('_kt_audio_mp3', 'type=file')){
                        foreach($audios as $audio) {
                            echo '<div class="entry-thumb">';
                                if(has_post_thumbnail()){
                                    the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) );
                                }
                                echo '<div class="entry-thumb-audio">';
                                echo do_shortcode('[audio src="'.$audio['url'].'"][/audio]');
                                echo '</div><!-- .entry-thumb-audio -->';
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
 * Filter function, converts fixed width to '100%' width
 */
function responsive_wp_video_shortcode( $html, $atts, $video, $post_id, $library ) {
    //$html = str_replace('width: ' . $atts['width'] . 'px', 'width: 100%', $html);

    print_r($video);
    $html = str_replace('width="' . $atts['width'] . '"', 'width="100%"', $html);
    $html = str_replace('height="' . $atts['height'] . '"', 'height="100%"', $html);
    return $html;
}

add_filter( 'wp_video_shortcode', 'responsive_wp_video_shortcode', 10, 5 );



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
                        'reply_text' =>' '.__('Reply')
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
                    previous_post_link('<div class="nav-previous">%link</div>', _x( 'Previous Post', 'Previous post link', THEME_LANG ), TRUE);
                    next_post_link('<div class="nav-next">%link</div>', _x( 'Next Post', 'Next post link', THEME_LANG ), TRUE);
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
    function kt_entry_meta_tags($before = '', $after = '') {
        if ( 'post' == get_post_type() ) {
            $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', THEME_LANG ) );
            if ( $tags_list ) {
                printf( '%3$s<span class="tags-links"><span class="tags-links-text">%1$s</span> %2$s</span>%4$s',
                    _x( 'Tags: ', 'Used before tag names.', THEME_LANG ),
                    $tags_list,
                    $before,
                    $after
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
        if (! post_password_required() && ( comments_open() || get_comments_number() ) ) {
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

            printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                _x( 'Posted on', 'Used before publish date.', THEME_LANG ),
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

        <div class="author-info">
            <div class="author-avatar">
                <?php
                    $author_bio_avatar_size = apply_filters( 'kt_author_bio_avatar_size', 165 );
                    echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
                ?>
            </div><!-- .author-avatar -->
            <div class="author-description">
                <h2 class="author-title"><?php printf( __( 'About %s', THEME_LANG ), get_the_author() ); ?></h2>
                <div class="author-bio">
                    <?php if($description = get_the_author_meta('description')){ ?>
                        <p class="author-description-content"><?php echo $description; ?></p>
                    <?php } ?>
                    <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                        <?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', THEME_LANG ), get_the_author() ); ?>
                    </a>
                </div>
                <?php
                    $googleplus = get_the_author_meta('googleplus');
                    $url = get_the_author_meta('url');
                    $twitter = get_the_author_meta('twitter');
                    $facebook = get_the_author_meta('facebook');
                    $pinterest = get_the_author_meta('pinterest');
                    $instagram = get_the_author_meta('instagram');
                    $tumblr = get_the_author_meta('tumblr');
                ?>

                <p class="author-social">
                    <?php if($facebook){ ?>
                        <a href="<?php echo $facebook; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                    <?php } ?>
                    <?php if($twitter){ ?>
                        <a href="http://www.twitter.com/<?php echo $twitter; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                    <?php } ?>
                    <?php if($pinterest){ ?>
                        <a href="http://www.pinterest.com/<?php echo $pinterest; ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
                    <?php } ?>
                    <?php if($googleplus){ ?>
                        <a href="<?php echo $googleplus; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                    <?php } ?>
                    <?php if($instagram){ ?>
                        <a href="http://instagram.com/<?php echo $instagram; ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                    <?php } ?>
                    <?php if($tumblr){ ?>
                        <a href="http://<?php echo $instagram; ?>.tumblr.com/" target="_blank"><i class="fa fa-tumblr"></i></a>
                    <?php } ?>
                    <?php if($url){ ?>
                        <a href="<?php echo $url; ?>" target="_blank"><i class="fa fa-globe"></i></a>
                    <?php } ?>
                </p>
            </div><!-- .author-description -->
        </div><!-- .author-info -->

    <?php }
endif;




/* ---------------------------------------------------------------------------
 * Share Box [share_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'kt_share_box' ) ){
    function kt_share_box($post_id = null, $style = "", $class = ''){
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $link = urlencode(get_permalink($post_id));
        $title = urlencode(addslashes(get_the_title($post_id)));
        $excerpt = urlencode(get_the_excerpt());
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');

        $html = '';

        ?>
        <div class="entry-share-box <?php echo $class; ?>">
            <?php
            // Facebook
            $html .= '<a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $link.'\', \'sharer\', \'toolbar=0,status=0,width=620,height=280\');popUp.focus();return false;">';
            $html .= '<i class="fa fa-facebook"></i>';
            $html .= '</a>';

            // Twitter
            $html .= '<a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://twitter.com/home?status=' . $link . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;">';
            $html .= '<i class="fa fa-twitter"></i>';
            $html .= '</a>';

            // Google plus
            $html .= '<a class="'.$style.'" href="#" onclick="popUp=window.open(\'https://plus.google.com/share?url=' . $link . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
            $html .= '<i class="fa fa-google-plus"></i>';
            $html .= "</a>";

            // Pinterest
            $html .= '<a class="share_link" href="#" onclick="popUp=window.open(\'http://pinterest.com/pin/create/button/?url=' . $link . '&amp;description=' . $title . '&amp;media=' . urlencode($image[0]) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
            $html .= '<i class="fa fa-pinterest"></i>';
            $html .= "</a>";

            // linkedin
            $html .= '<a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://linkedin.com/shareArticle?mini=true&amp;url=' . $link . '&amp;title=' . $title. '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
            $html .= '<i class="fa fa-linkedin"></i>';
            $html .= "</a>";

            // Tumblr
            $html .= '<a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://www.tumblr.com/share/link?url=' . $link . '&amp;name=' . $title . '&amp;description=' . $excerpt . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
            $html .= '<i class="fa fa-tumblr"></i>';
            $html .= "</a>";

            // Email
            $html .= '<a class="'.$style.'" href="mailto:?subject='.$title.'&amp;body='.$link.'">';
            $html .= '<i class="fa fa-envelope-o"></i>';
            $html .= "</a>";


            echo $html;
            ?>

        </div>
    <?php
    }
}


/* ---------------------------------------------------------------------------
 * Related Article [related_article]
 * --------------------------------------------------------------------------- */
if ( ! function_exists( 'kt_related_article' ) ) :
    function kt_related_article($post_id = null, $type = 'categories'){
        global $post;
        if(!$post_id) $post_id = $post->ID;


        $sidebar = kt_get_single_sidebar($post_id);
        if($sidebar['sidebar'] == 'full'){
            $blog_columns = 3;
            $blog_columns_tablet = 2;
            $posts_per_page = kt_option('blog_related_full', 3);
        }else{
            $blog_columns = 2;
            $blog_columns_tablet = 2;
            $posts_per_page = kt_option('blog_related_sidebar', 2);
        }

        $args = array(
            'posts_per_page' => $posts_per_page,
            'post__not_in' => array($post_id)
        );
        if($type == 'tags'){
            $tags = wp_get_post_tags($post_id);
            if(!$tags) return false;
            $tag_ids = array();
            foreach($tags as $tag)
                $tag_ids[] = $tag->term_id;
            $args['tag__in'] = $tag_ids;
        }elseif($type == 'author'){
            $args['author'] = get_the_author();
        }else{
            $categories = get_the_category($post_id);
            if(!$categories) return false;
            $category_ids = array();
            foreach($categories as $category)
                $category_ids[] = $category->term_id;
            $args['category__in'] = $category_ids;
        }
        $query = new WP_Query( $args );
        ?>
        <?php if($query->have_posts()){ ?>
            <div id="related-article">
                <h3 class="title-article"><?php _e('Related Article', THEME_LANG); ?></h3>
                <div class="row">
                    <?php

                    global $blog_atts;
                    $blog_atts = array(
                        'image_size' => 'recent_posts',
                        'readmore' => false,
                        "show_author" => false,
                        "show_category" => true,
                        "show_comment" => false,
                        "show_date" => true,
                        'show_meta' => true,
                        "date_format" => 'M d Y',
                        'thumbnail_type' => 'image',
                        "class" => ''
                    );

                    $i = 1;
                    $bootstrapColumn = round( 12 / $blog_columns );
                    $bootstrapTabletColumn = round( 12 / $blog_columns_tablet );
                    $classes = 'col-xs-12 col-sm-'.$bootstrapTabletColumn.' col-md-' . $bootstrapColumn;

                    ?>

                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <?php
                            $classes_extra = '';
                            if (  ( $i - 1 ) % $blog_columns == 0 || 1 == $blog_columns )
                                $classes_extra .= ' col-clearfix-md col-clearfix-lg ';

                            if ( ( $i - 1 ) % $blog_columns_tablet == 0 || 1 == $blog_columns )
                                $classes_extra .= ' col-clearfix-sm';
                        ?>
                        <div class="article-post-item <?php echo $classes." ".$classes_extra; ?>">
                            <?php get_template_part( 'templates/blog/layout/layout1/content', get_post_format() ); ?>
                        </div><!-- .article-post-item -->
                    <?php $i++; endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div><!-- #related-article -->
        <?php } ?>
    <?php }
endif;
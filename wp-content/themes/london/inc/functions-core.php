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
	//add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat') );

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

    wp_enqueue_style( 'london-style', get_stylesheet_uri() );
    wp_enqueue_style( 'bootstrap-css', THEME_LIBS . 'bootstrap/css/bootstrap.min.css', array());
    wp_enqueue_style( 'font-awesome', THEME_FONTS . 'font-awesome/css/font-awesome.min.css', array());
    wp_enqueue_style( 'font_kites', THEME_FONTS . 'font_kites/stylesheet.css', array());
    wp_enqueue_style( 'animate', THEME_CSS . 'animate.min.css', array());
    wp_enqueue_style( 'mCustomScrollbar', THEME_CSS . 'jquery.mCustomScrollbar.min.css', array());
    wp_enqueue_style( 'magnific-popup', THEME_CSS . 'magnific-popup.css', array());
    wp_enqueue_style( 'owl-carousel', THEME_LIBS . 'owl-carousel/owl.carousel.css', array());
    wp_enqueue_style( 'owl-carousel-theme', THEME_LIBS . 'owl-carousel/owl.theme.css', array());
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
    wp_enqueue_script( 'customSelect-script', THEME_JS . 'jquery.customSelect.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'ktSticky-script', THEME_JS . 'jquery.kt.sticky.js', array( 'jquery' ), null, true );    
    wp_enqueue_script( 'owl-carousel', THEME_LIBS . 'owl-carousel/owl.carousel.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'superfish-script', THEME_JS . 'jquery.superfish.custom.js', array( 'jquery', 'hoverIntent' ), null, true );
    wp_enqueue_script( 'magnific-popup-script', THEME_JS . 'jquery.magnific-popup.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'matchHeightscript', THEME_JS . 'jquery.matchHeight-min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'countdown-script', THEME_JS . 'jquery.countdown.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'variations-plugin-script', THEME_JS . 'woo-variations-plugin.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'easyzoom', THEME_JS . 'easyzoom.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'waypoints', THEME_JS . 'jquery.waypoints.min.js', array( 'jquery' ), null, true );
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
    return 20;
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
 *
 * @since Twenty Fourteen 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function kt_paging_nav() {
	global $wp_query, $wp_rewrite;
    
    // Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}
    
    echo get_the_posts_pagination( array(
        'prev_text'          => __( 'Previous', THEME_LANG ),
        'next_text'          => __( 'Next', THEME_LANG ),
        'before_page_number' => '',
    ) );
    
}
endif;

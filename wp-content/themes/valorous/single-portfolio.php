<?php
/**
 * The template for displaying single post
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage London
 * @since London 1.0
 */

$sidebar = kt_sidebar();

print_r($sidebar);

get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <?php
        $video_portfolio = $gallery_portfolio = '';
        
        //Video Portfolio
        $type = rwmb_meta('_kt_video_type');
        if($type == 'youtube'){
            if($video_id = rwmb_meta('_kt_video_id')){
                $video = kt_video_youtube($video_id);
            }
        }elseif($type == 'vimeo'){
            if($video_id = rwmb_meta('_kt_video_id')){
                $video = kt_video_vimeo($video_id);
            }
        }elseif($type == 'dailymotion'){
            if($video_id = rwmb_meta('_kt_video_id')){
                $video = kt_video_dailymotion($video_id);
            }
        }
        if( $type != '' ){
            $video_portfolio = '<div class="video-portfolio"><div class="embed-responsive embed-responsive-16by9">';
                $video_portfolio .= $video;
            $video_portfolio .= '</div></div><!-- .video-portfolio -->';
        }
        
        //Gallery Portfolio
        $images = get_galleries_post( '_kt_list_image' );
        if( $images ){
            foreach($images as $image){
                $gallery_portfolio .= '<div class="gallery-portfolio-item"><img class="img-responsive" src="'.$image['url'].'" alt="" /></div>';
            }
        }
        
        //Client Portfolio
        $client = rwmb_meta( '_kt_client' );
        
        //Date Portfolio
        $date = rwmb_meta( '_kt_project_date' );
        
        //Link Portfolio
        $link = rwmb_meta( '_kt_link_project' );
        
        //Category Portfolio
        $terms =  get_the_terms( get_the_ID(), 'portfolio-category' );
        if(!count($terms)) return false;
        
        foreach ( $terms as $term ) {
    		$draught_links[] = $term->slug;
    	}
        $category = implode(' ',$draught_links);
    ?>

    <div class="container">
        <div class="row">
            <div id="main" class="main-class col-md-8<?php if( $sidebar['sidebar'] == 'left' ){ echo ' pull-right'; } ?>">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    
                    <div class="entry-content clearfix">
                        <?php
                            if( $video_portfolio ){
                                echo $video_portfolio;
                            }
                            if( $gallery_portfolio ){
                                echo $gallery_portfolio;
                            }
                            if($sidebar['sidebar'] == 'full'){ ?>
                                <div class="entry-content"><?php the_content(); ?></div>
                            <?php }
                        ?>
                    </div>
                    
                </article><!-- #post-## -->

            </div>
            <?php if($sidebar['sidebar'] != 'full'){ ?>
                <div class="sidebar-portfolio col-md-4">
                    <div class="sidebar-inner">
                        <h3><?php the_title(); ?></h3>
                        <div class="entry-content"><?php the_content();?></div>
                        <?php
                            if( $client ){
                                printf('<div class="meta-post"><span class="title-meta">%s</span><p>%s</p></div>',__( 'Client', THEME_LANG ),$client);
                            }
                            if( $date ){
                                printf('<div class="meta-post"><span class="title-meta">%s</span><p>%s</p></div>',__( 'Date', THEME_LANG ),$date);
                            }
                            if( $date ){
                                printf('<div class="meta-post"><span class="title-meta">%s</span><p>%s</p></div>',__( 'Category', THEME_LANG ),$category);
                            }
                            if( $link ){
                                printf('<a class="btn" href="%s">%s</a>', $link,__( 'View Portfolio', THEME_LANG ));
                            }
                        ?>
                    </div>
                </div><!-- .sidebar -->
            <?php } ?>
        </div><!-- .row -->
        
        <div id="more_portfolio">
                        
            <?php
                $prev_post = get_previous_post();
                if($prev_post) {
                   $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
                   echo "\t" . '<a rel="prev" href="' . get_permalink($prev_post->ID) . '" title="' . $prev_title. '" class="prev">Previous project<span>'. $prev_title . '</span></a>' . "\n";
                                }
                
                $next_post = get_next_post();
                if($next_post) {
                   $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
                   echo "\t" . '<a rel="next" href="' . get_permalink($next_post->ID) . '" title="' . $next_title. '" class="next">Next project<span>'.$next_title.'</span></a>' . "\n";
                                }
            ?>
                
        </div><!-- #more_portfolio -->
        
    </div><!-- .container -->
<?php endwhile; ?>
<?php get_footer(); ?>
<?php
/** @var $this WPBakeryShortCode_VC_Row */
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $full_width = $el_id = $parallax_image = $parallax = '';
extract( shortcode_atts( array(
    'el_class' => '',
    'bg_image' => '',
    'bg_color' => '',
    'bg_image_repeat' => '',
    'font_color' => '',
    'padding' => '',
    'margin_bottom' => '',
    'full_width' => false,
    'parallax' => false,
    'parallax_image' => false,
    'css' => '',
    'equal_height' => '',
    'color_overlay' => '',
    'el_id' => '',

    'background_type' => '',
    'external_link' => '',
    'video_webm' => '',
    'video_mp4' => '',
    'video_image' => '',


    'font_color' => '',
    'top_section' => '',
    'top_divider_color' => '',
    'bottom_section' => '',
    'bottom_divider_color' => '',


), $atts ) );
$parallax_image_id = '';
$parallax_image_src = '';

// wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
// wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass( $el_class );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row ' . ( $this->settings( 'base' ) === 'vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

if($equal_height){
    $css_class .= ' equal_height equal_height_'.$equal_height;
}

$style = $this->buildStyle( $bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom );

$classes = array('row-background-'.$background_type);
if ( $full_width == 'stretch_row_content_no_spaces' ):
    $classes[] = 'vc_row-no-padding';
endif;


if ( $background_type =='content-moving' || $background_type =='content-moving-fade' ):
    $classes[] = 'vc_general vc_parallax vc_parallax-' . $background_type;
    $parallax = $background_type;
endif;

if ( $background_type == 'content-moving-fade' ):
    $classes[] = 'js-vc_parallax-o-fade';
endif;
/*
if ( ! empty( $parallax ) && strpos( $parallax, 'fixed' ) ):
    $classes[] = ' js-vc_parallax-o-fixed';
endif;
*/

if(($top_section && $top_divider_color) || ($bottom_section && $bottom_divider_color)) {
    $classes[] = 'row-divider-content';
}
?>


<div <?php echo isset( $el_id ) && ! empty( $el_id ) ? "id='" . esc_attr( $el_id ) . "'" : ""; ?>
    class="<?php echo esc_attr( $css_class ); ?> <?php echo implode(' ', $classes); ?>"<?php if ( ! empty( $full_width ) ) {
echo ' data-vc-full-width="true" data-vc-full-width-init="false" ';
if ( $full_width == 'stretch_row_content' || $full_width == 'stretch_row_content_no_spaces' ) {
    echo ' data-vc-stretch-content="true"';
}
}

$bgSpeed = 1.5;




if ( $parallax ) {
    wp_enqueue_script( 'vc_jquery_skrollr_js' );
    echo ' data-vc-parallax="' . $bgSpeed . '" ';
}
if ( strpos( $parallax, 'fade' ) ) {
    echo ' data-vc-parallax-o-fade="on"  ';
}
if ( $parallax_image ) {
    $parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
    $parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
    if ( ! empty( $parallax_image_src[0] ) ) {
    $parallax_image_src = $parallax_image_src[0];
    }
    echo ' data-vc-parallax-image="' . $parallax_image_src . '" ';
}
?>
<?php echo $style; ?>>
    <?php echo wpb_js_remove_wpautop( $content ); ?>

    <?php if($color_overlay && $background_type){ ?>
        <div class="parallax-overlay" style="background: <?php echo esc_attr($color_overlay); ?>"></div>
    <?php } ?>

    <?php /*if($background_type == 'external'){ ?>
        <!-- Video BG Init -->
        <div id="row-id-12345"></div>
        <div class="player" data-property="{videoURL:'http://youtu.be/I6jmZ5plZ3o',containment:'#row-id-12345',autoPlay:true, showControls:false, showYTLogo: false, mute:true, startAt:0, opacity:1}"></div>
        <!-- End Video BG Init -->
    <?php } ?>
    <?php if($background_type == 'upload'){ ?>
        <video width="100%" height="100%"  muted="muted" loop="loop" autoplay="true" preload="auto" class="parallax_video">
            <source type="video/mp4" src="http://www.rd-themes.com/Cosmos_boxed/wp-content/uploads/2014/08/Unforgettable_small.mp4" />
        </video>
    <?php } */ ?>
    <?php if($top_section && $top_divider_color){ ?>
        <div class="row-section-divider top-divider" style="background: <?php echo $top_divider_color; ?>"></div>
    <?php } ?>

    <?php if($bottom_section && $bottom_divider_color){ ?>
        <div class="row-section-divider bottom-divider" style="background: <?php echo $bottom_divider_color; ?>"></div>
    <?php } ?>



</div><?php echo $this->endBlockComment( 'row' );
if ( ! empty( $full_width ) ) {
echo '<div class="vc_row-full-width"></div>';
}

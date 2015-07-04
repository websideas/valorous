<?php

$atts = ( shortcode_atts( array(
    'meta_type' => 'author,date,category,comment_count',
    'css' => '',
    'el_class' => '',
), $atts ) );

extract( $atts );
//$meta_type = array_filter(  explode(',', $meta_type) );
if( empty( $meta_type )){
    return ;
}
$elementClass = array(
    'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'entry-meta-data ', $this->settings['base'], $atts ),
    'extra' => $this->getExtraClass( $el_class ),
    'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
);
$elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
?>
<div class="<?php  echo esc_attr( $elementClass ); ?>">
    {{ post_metadata:<?php echo $meta_type; ?> }}
</div>



<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$logo = kt_get_logo();
$logo_class = ($logo['retina']) ? 'retina-logo-wrapper' : ''; 
$logo_circle = kt_option('logo_circle');
if($logo_circle) $logo_class .= ' logo-circle';
?>

<?php $tag = ( is_front_page() && is_home() ) ? 'h1' : 'p'; ?>
<<?php echo $tag ?> class="site-logo <?php echo esc_attr($logo_class); ?>">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <img src="<?php echo esc_url($logo['default']); ?>" class="default-logo" alt="<?php bloginfo( 'name' ); ?>" />
        <?php if($logo['retina']){ ?>
            <img src="<?php echo esc_url($logo['retina']); ?>" class="retina-logo" alt="<?php bloginfo( 'name' ); ?>" />
        <?php } ?>
    </a>
</<?php echo $tag ?>><!-- .site-logo -->
<div id="site-title"><?php bloginfo( 'name' ); ?></div>
<div id="site-description"><?php bloginfo( 'description' ); ?></div>
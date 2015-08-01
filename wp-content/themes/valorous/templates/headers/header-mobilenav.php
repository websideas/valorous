<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$logo = kt_get_logo();

?>
<div id="mobile-nav-holder">
    <div id="mobile-nav-content">

        <div>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <img src="<?php echo esc_url($logo['default']); ?>" class="logo-light" alt="<?php bloginfo( 'name' ); ?>" />
                <img src="<?php echo esc_url($logo['logo_dark']); ?>" class="logo-dark" alt="<?php bloginfo( 'name' ); ?>" />
            </a>

        </div>


        <?php
        if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container' => 'nav',
                    'container_id' => 'main-nav-mobile',
                    'menu_class' => 'menu navigation-mobile',
                    'walker' => new KTMenuWalker() )
            );
        }
        ?>
    </div>
</div>
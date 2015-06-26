<?php
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container' => '',
            'menu_id'         => 'main-navigation',
            'menu_class' => 'hidden-xs hidden-sm',
            'walker' => new KTMegaWalker(),
            //'items_wrap' => kt_nav_wrap() )
        ) );
    }else{
        printf(
            '<ul><li><a href="#">%s</a></li></ul>',
            __("No menu assigned!", THEME_LANG)
        );
    }
?>
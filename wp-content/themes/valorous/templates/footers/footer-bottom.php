<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



$bottom_instagram = false;
$footer_bottom_instagram = kt_option('footer_bottom_instagram', true);

if($footer_bottom_instagram){
    $client_id = get_option( 'kt_instagram_client_id' );
    $access_token = get_option('kt_instagram_access');
    $username = get_option('kt_instagram_username');
    $userid = get_option('kt_instagram_userid');


    if($access_token && $username ){
        $kt_instagram = new KT_Instagram();
        $data = $kt_instagram->getUserMedia( array('count' => 16 ));
        if(!empty($data)){
            $images = $kt_instagram->BgInstagram($data);
            $bottom_instagram = true;
        }
    }
}
?>

<footer id="footer-bottom" class="<?php echo ($bottom_instagram) ? 'bottom-instagram' : 'bottom-background' ?>">
    <?php
    if($bottom_instagram) {
        echo $images;
    }
    $logo_footer = kt_option( 'logo_footer' );
    if(is_array($logo_footer) && $logo_footer['url'] != '' ){
        $img_logo = $logo_footer['url'];
    }else{
        $img_logo = THEME_IMG.'img-logo.png';
    }
    ?>
    <div class='kt-image-content text-center'>
        <div class='kt-image-animation' data-animation='slideInUp'>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <img src='<?php echo $img_logo; ?>' alt="<?php bloginfo( 'name' ); ?>"/>
            </a>
        </div>
    </div>

</footer><!-- #footer-bottom -->
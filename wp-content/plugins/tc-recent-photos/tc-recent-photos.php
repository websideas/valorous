<?php 

/*
Plugin Name: Instagram Recent Photos Widget (shared on wplocker.com)
Plugin Script: tc-recent-photos.php
Plugin URI: http://tyler.tc
Description: Show off your recent Instagram photos with this highly customizable widget for WordPress!
Version: 1.1.2
Author: Tyler Colwell
Author URI: http://tyler.tc

--- THIS PLUGIN AND ALL FILES INCLUDED ARE COPYRIGHT © TYLER COLWELL 2011. 
YOU MAY NOT MODIFY, RESELL, DISTRIBUTE, OR COPY THIS CODE IN ANY WAY. ---

*/

/*-----------------------------------------------------------------------------------*/
/*	Define Anything Needed
/*-----------------------------------------------------------------------------------*/

define('TCRINSTA_VERSION', '1.1.2');
define('TCRINSTA_LOCATION', WP_PLUGIN_URL . '/'.basename(dirname(__FILE__)));
define('TCRINSTA_PATH', plugin_dir_path(__FILE__));
define('TCRINSTA_RELPATH', dirname( plugin_basename( __FILE__ ) ) );
define('TCRINSTA_ABS', ABSPATH);
define('TCRINSTA_INSTAGRAM_URI', TCRINSTA_LOCATION.'/inc/tcf_instagram.php');
require_once('inc/tcf_settings_page.php');
require_once('inc/tcf_widget.php');
require_once('inc/tcf_bootstrap.php');
require_once('inc/tcf_insta.php');

?>
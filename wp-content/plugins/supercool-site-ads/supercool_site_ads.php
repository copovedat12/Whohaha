<?php
/*
Plugin Name: Super Cool Ads
Plugin URI: http://digitalmediamanagement.com/
Description: Create ads to show between pages.
Version: 1.0.1
Author: Tyler Patton, Digital Media Management
Author URI: http://jtpatton.com/
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'SC_ADS_DIR', __FILE__ );

require plugin_dir_path( SC_ADS_DIR ) . 'includes/classes/class-scsa-functions.php';
require plugin_dir_path( SC_ADS_DIR ) . 'includes/classes/class-scsa.php';

$int_ads = new SC_Ads();

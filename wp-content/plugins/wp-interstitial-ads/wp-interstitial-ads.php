<?php
/*
Plugin Name: WP Interstitial Ads
Plugin URI: http://digitalmediamanagement.com/
Description: Create Interstitial ads to show between pages.
Version: 1.0.1
Author: Tyler Patton, Digital Media Management
Author URI: http://jtpatton.com/
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'INT_ADS_DIR', __FILE__ );

require plugin_dir_path( INT_ADS_DIR ) . 'includes/class-int-ads-functions.php';
require plugin_dir_path( INT_ADS_DIR ) . 'includes/class-int-ads.php';

$int_ads = new Int_Ads();

<?php
/**
 * Interstitial Ads Uninstall Functions.
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Make sure we're uninstalling.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// Delete all the options.
delete_option( 'sc_ads_opts' );

<?php
require_once(plugin_dir_path( SC_ADS_DIR ) . 'includes/classes/class-scsa-admin.php');
require_once(plugin_dir_path( SC_ADS_DIR ) . 'includes/classes/class-scsa-options.php');
require_once(plugin_dir_path( SC_ADS_DIR ) . 'includes/classes/class-scsa-frontend.php');

class SC_Ads{
	public function __construct(){
		self::check_is_admin();
		new SC_Ads_Frontend();
	}

	public function check_is_admin(){
		if(is_admin()){
			$options = new SC_Ads_Options();
			$sc_ads_admin = new SC_Ads_Admin($options);
		}
	}
}

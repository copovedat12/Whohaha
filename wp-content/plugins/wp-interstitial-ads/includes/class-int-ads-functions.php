<?php

class Int_Ads_Functions{
	public function is_selected($dur, $type = 'interstitial', $defaults = false){
		if ($type === 'popup') {
			$opts = get_option('interstitial_popup_ads_opts', $defaults);
			$ads_cookie_duration = $opts['cookie_duration'];
		} else {
			$opts = get_option('interstitial_ads_opts', $defaults);
			$ads_cookie_duration = $opts['cookie_duration'];
		}
		if($ads_cookie_duration == $dur){
			echo ' selected';
		}
	}

	public function rand_string($length = 12, $special_chars = true){
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		if ( $special_chars )
				$chars .= '!@#$%^&*()';

		$password = '';
		for ( $i = 0; $i < $length; $i++ ) {
				$password .= substr($chars, wp_rand(0, strlen($chars) - 1), 1);
		}
		return $password;
	}

	public function create_bg_css($ads_background){
		if (isset($ads_background['type'])){
			if ($ads_background['type'] === 'image'){
				if (isset($ads_background['image'])){
					echo "background-image: url(".$ads_background['image'].");";
				}
				if ($ads_background['image_size'] !== 'repeat'){
					echo 'background-size: cover;';
				}
			} else if($ads_background['type'] === 'color' && isset($ads_background['background_color']) && !empty($ads_background['background_color'])) {
				echo "background: ".$ads_background['background_color'].";";
			}
		}
	}
}

<?php
function rand_string($length = 12, $special_chars = true){
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ( $special_chars )
			$chars .= '!@#$%^&*()';

	$password = '';
	for ( $i = 0; $i < $length; $i++ ) {
			$password .= substr($chars, wp_rand(0, strlen($chars) - 1), 1);
	}
	return $password;
}

function create_bg_css($ads_background){
	if (isset($ads_background['type'])){
		if ($ads_background['type'] === 'image'){
			if (isset($ads_background['bg_url'])){
				echo "background-image: url(".$ads_background['bg_url'].");";
			}
			if ($ads_background['img_placement'] !== 'repeat'){
				echo 'background-size: cover;';
			}
		} else if($ads_background['type'] === 'color' && isset($ads_background['bg_color']) && !empty($ads_background['bg_color'])) {
			echo "background: ".$ads_background['bg_color'].";";
		}
	}
}

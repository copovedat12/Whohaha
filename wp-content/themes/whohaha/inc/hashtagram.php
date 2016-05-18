<?php

function get_hashtagram_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_USERPWD, "CZND:Miley123");
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function getHashtagramImages($atts){
	extract(shortcode_atts(array(
		"hashtag" => ""
	), $atts));

	$returned_content = get_hashtagram_data('http://hashtagram.cznd.co/approved.php?q='.$hashtag);

	ob_start();
	?>
	<div class="instagram-showcase">
		<div class="row">
			<?php
				$images = json_decode($returned_content, true);
				foreach ($images as $image):
			?>
			<div class="item col-md-4 col-sm-6">
				<div class="image">
					<div class="user">
						<a href="http://instagram.com/<?php echo $image['usr_name'] ?>"><img src="<?php echo $image['usr_img'] ?>"></a>
					</div>
					<a target="_blank" href="<?php echo $image['instagram_url'] ?>"><img src="<?php echo $image['img_url'] ?>"></a>
				</div>
			</div>
			<?php
				endforeach;
			?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode("hashtagram", "getHashtagramImages");

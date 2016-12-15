<?php

/**
 * Create video container
 */
function getYtPlayer($player_id, $post_id = null, $autoplay = false){
	global $video_embeds;
	if (!isset($video_embeds)) {
		$video_embeds = array();
	}
	$video_embeds[] = array(
		'playerid' =>  $player_id,
		'postid' => $post_id,
		'autoplay' => $autoplay
	);
	?>
	<div id="player_<?php echo $player_id; ?>" data-videoid="<?php echo $player_id; ?>" data-vidurl="https://www.youtube.com/embed/<?php echo $player_id; ?>" class="video-iframe" <?php if ($post_id) echo ' data-postid="'.$post_id.'"'; ?><?php if ($autoplay) echo ' data-autoplay="'.$autoplay.'"'; ?>></div>
	<?php

	if (!empty($video_embeds)) {
		yt_player_render_script($video_embeds);
	}
}

/**
 * Load JS File
 */
function yt_player_render_script($video_embeds){
	$var_array = array(
		'video_embeds' => $video_embeds,
		'ajax_url' => admin_url( 'admin-ajax.php' )
	);
	wp_enqueue_script( 'youtube_player', get_template_directory_uri() . '/resources/js/youtube-player.js', array('jquery'), false, true );
	wp_localize_script( 'youtube_player', 'YOUTUBE_ARRAY', $var_array );
}

/**
 * Create shortcode for videos to be embedded into posts
 * Usage: [get-yt-player id="LwuY1hKP9ug" autoplay="false"]
 */
function getYtPlayer_shortcode($atts){
	extract(shortcode_atts(array(
		"id" => null,
		"autoplay" => false,
	), $atts));

	ob_start();
	?>
	<div class="video-embed">
	<?php
	getYtPlayer($id, null, $autoplay);
	?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'get-yt-player', 'getYtPlayer_shortcode' );

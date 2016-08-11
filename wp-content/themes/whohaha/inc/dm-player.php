<?php

/**
 * Create video container
 */
function getDmPlayer($player_id, $post_id = null, $autoplay = false){
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
	<span class="dm-video-container"<?php if ($post_id) echo ' data-postid="'.$post_id.'"'; ?><?php if ($autoplay) echo ' data-autoplay="'.$autoplay.'"'; ?>>
		<div id="player_<?php echo $player_id; ?>" data-videoid="<?php echo $player_id; ?>" class="video-iframe"></div>
	</span>
	<?php

	if (!empty($video_embeds)) {
		dm_render_script($video_embeds);
	}
}

/**
 * Load JS File
 */
function dm_render_script($video_embeds){
	$var_array = array(
		'video_embeds' => $video_embeds,
		'ajax_url' => admin_url( 'admin-ajax.php' )
	);
	wp_enqueue_script( 'dm_api', 'https://api.dmcdn.net/all.js',false, false, false );
	wp_enqueue_script( 'dm_player', get_template_directory_uri() . '/resources/js/dailymotion-player.js', array('jquery'), false, true );
	wp_localize_script( 'dm_player', 'DM_ARRAY', $var_array );
}
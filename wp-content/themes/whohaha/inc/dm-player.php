<?php

/**
 * Create video container
 */
function getDmPlayer($player_id, $post_id = null, $autoplay = false){
	global $dm_video_embeds;
	if (!isset($dm_video_embeds)) {
		$dm_video_embeds = array();
	}
	$dm_video_embeds[] = array(
		'playerid' =>  $player_id,
		'postid' => $post_id,
		'autoplay' => $autoplay
	);
	?>
	<span class="dm-video-container"<?php if ($post_id) echo ' data-postid="'.$post_id.'"'; ?><?php if ($autoplay) echo ' data-autoplay="'.$autoplay.'"'; ?>>
		<div id="player_<?php echo $player_id; ?>" data-videoid="<?php echo $player_id; ?>" class="video-iframe"></div>
	</span>
	<?php

	if (!empty($dm_video_embeds)) {
		dm_render_script($dm_video_embeds);
	}
}

/**
 * Load JS File
 */
function dm_render_script($dm_video_embeds){
	$var_array = array(
		'video_embeds' => $dm_video_embeds,
		'ajax_url' => admin_url( 'admin-ajax.php' )
	);
	wp_enqueue_script( 'dm_api', 'https://api.dmcdn.net/all.js',false, false, false );
	wp_enqueue_script( 'dm_player', get_template_directory_uri() . '/resources/js/dailymotion-player.js', array('jquery'), false, true );
	wp_localize_script( 'dm_player', 'DM_ARRAY', $var_array );
}

/**
 * Create shortcode for videos to be embedded into posts
 * Usage: [get-dm-player id="x4kds10" autoplay="false"]
 */
function getDmPlayer_shortcode($atts){
	extract(shortcode_atts(array(
		"id" => null,
		"autoplay" => false,
	), $atts));

	ob_start();
	?>
	<div class="video-embed">
	<?php
	getDmPlayer($id, null, $autoplay);
	?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'get-dm-player', 'getDmPlayer_shortcode' );
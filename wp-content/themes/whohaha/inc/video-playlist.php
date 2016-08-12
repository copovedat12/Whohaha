<?php
function getVideoPlaylist($plist_url, $post_id = null){
	?>
	<div class="yt-section">
		<div class="row">
			<div class="outer-container col-md-8">
				<div class="player-container">
					<div id="player"></div>
				</div>
			</div>
			<div class="col-md-4 custom-scrollbar">
				<div class="v-player-list"></div>
			</div>
			<div class="result"></div>
		</div>
	</div>
	<?php
	if(preg_match('/dailymotion/', $plist_url)){
		preg_match('/playlist\/([\w+\-+\_+]+)[\"\?\/]/', $plist_url, $match);
		$plist_id = $match[1];

		render_dmplaylist_script($plist_id);
	} elseif(preg_match('/youtube/', $plist_url)){
		$parts = parse_url($plist_url);
		parse_str($parts['query'], $query);
		$plist_id = $query['list'];

		render_ytplaylist_script($plist_id);
	}
}
/**
 * Load JS File
 */
function render_ytplaylist_script($plist_id){
	$var_array = array(
		'playlistId' => $plist_id
	);
	wp_enqueue_script( 'youtube_playlist', get_template_directory_uri() . '/resources/js/youtube-playlist.js', array('jquery'), false, true );
	wp_localize_script( 'youtube_playlist', 'YOUTUBE_PL_ARRAY', $var_array );
}

function render_dmplaylist_script($plist_id){
	$var_array = array(
		'playlistId' => $plist_id
	);
	wp_enqueue_script( 'dm_api', 'https://api.dmcdn.net/all.js',false, false, false );
	wp_enqueue_script( 'dailymotion_playlist', get_template_directory_uri() . '/resources/js/dailymotion-playlist.js', array('jquery'), false, true );
	wp_localize_script( 'dailymotion_playlist', 'DAILYMOTION_PL_ARRAY', $var_array );
}

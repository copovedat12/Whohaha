<?php

/**
 * Create video container
 */
function get_heroscope_plist(){
	?>
	<div id="player" class="video-iframe"></div>
	<?php
	wp_enqueue_script( 'dm_api', 'https://api.dmcdn.net/all.js', false, false, false );
	wp_enqueue_script( 'youtube_player', get_template_directory_uri() . '/resources/js/heroscopes.js', array('jquery'), false, true );
}

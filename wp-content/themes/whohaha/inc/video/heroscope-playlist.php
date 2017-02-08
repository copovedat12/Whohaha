<?php

/**
 * Create video container
 */
function get_heroscope_plist(){
	?>
	<div id="player" class="video-iframe"></div>
	<?php
	wp_enqueue_script( 'dm_api', 'https://api.dmcdn.net/all.js', false, false, false );
	wp_enqueue_script( 'heroscope_player', get_template_directory_uri() . '/resources/js/heroscopes.js', array('jquery'), '2.0.0', true );
}

function heroscopes_page_urls(){
  add_rewrite_tag('%heroscope%', '([^&]+)');
  add_rewrite_rule(
    'series/heroscopes/([^/]*)/?',
    'index.php?playlists=heroscopes&heroscope=$matches[1]',
    'top'
  );
  flush_rewrite_rules();
}
add_action('init', 'heroscopes_page_urls');

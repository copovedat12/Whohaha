<?php

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Homepage Banner',
		'menu_slug' 	=> 'homepage-banner',
		'capability'	=> 'edit_posts',
		'position'		=> 37.5,
		'icon_url' 		=> 'dashicons-format-gallery',
		'redirect'		=> false
	));

	acf_add_options_page(array(
		'page_title' 	=> 'Featured Series',
		'menu_slug' 	=> 'feature-series',
		'capability'	=> 'edit_posts',
		'position'		=> 38.5,
		'icon_url' 		=> 'dashicons-playlist-video',
		'redirect'		=> false
	));
}
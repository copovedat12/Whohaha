<?php

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Homepage Banner',
		'menu_slug' 	=> 'homepage-banner',
		'capability'	=> 'edit_posts',
		'position'		=> 37.8,
		'icon_url' 		=> 'dashicons-format-gallery',
		'redirect'		=> false
	));
}
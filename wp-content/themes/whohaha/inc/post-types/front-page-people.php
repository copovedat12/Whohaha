<?php

add_action( 'init', 'create_posttypes' );
function create_posttypes() {
	register_post_type( 'front_page_people',
		array(
			'labels' => array(
				'name' => __( 'Front Page People' ),
				'singular_name' => __( 'Front Page Person' )
			),
			'supports' => array( 'title'),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'front_page_people'),
		)
	);
}
<?php 

function create_video_posttype() {
	register_post_type( 'videos',
		array(
			'labels' => array(
				'name' => __( 'Videos' ),
				'singular_name' => __( 'Video' )
			),
			'supports' => array('title','author','thumbnail','excerpt'),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'videos'),
			'menu_icon' => 'dashicons-video-alt3',
			'taxonomies' => 'playlists',
			'exclude_from_search' => true
		)
	);
}
add_action( 'init', 'create_video_posttype' );

function whh_video_metaboxes() {
	$prefix = 'whh_video_';

	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Video Information', 'whohaha' ),
		'object_types'  => array( 'videos' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names'    => true,
		'show_names' => true,
		// 'cmb_styles' => false,
	) );

	$cmb_demo->add_field( array(
		'name'       => esc_html__( 'Video URL', 'whohaha' ),
		'desc'       => esc_html__( 'Youtube or Dailymotion URL', 'whohaha' ),
		'id'         => $prefix . 'url',
		'type'       => 'text_url',
	) );
	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Video Embed Code', 'whohaha' ),
		'id'   => $prefix . 'embed',
		'type' => 'textarea_code',
	) );
	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Video Type', 'whohaha' ),
		'id'   => $prefix . 'type',
		'type' => 'radio',
		'options' => array(
			'youtube' => __('Youtube', 'whohaha'),
			'dailymotion' => __('Dailymotion', 'whohaha')
		)
	) );
}
add_filter( 'cmb2_admin_init', 'whh_video_metaboxes' );

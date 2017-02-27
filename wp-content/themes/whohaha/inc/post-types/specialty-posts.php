<?php 

function create_specialty_posttype() {
	register_post_type( 'special_posts',
		array(
			'labels' => array(
				'name' => __( 'Special Posts' ),
				'singular_name' => __( 'Special Post' )
			),
			'supports' => array('title','author','thumbnail','editor'),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => ''),
			'menu_icon' => 'dashicons-admin-post',
			'taxonomies' => array('post_tag')
		)
	);
}
add_action( 'init', 'create_specialty_posttype' );

function sp_remove_slug( $post_link, $post, $leavename ) {
    if ( 'special_posts' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }
    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    return $post_link;
}
add_filter( 'post_type_link', 'sp_remove_slug', 10, 3 );

function sp_parse_request( $query ) {
    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }
    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'special_posts', 'page' ) );
    }
}
add_action( 'pre_get_posts', 'sp_parse_request' );

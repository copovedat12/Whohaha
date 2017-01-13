<?php 

function video_playlist_init() {
	register_taxonomy(
		'playlists',
		'videos',
		array(
			'label' => __('Playlists'),
			'labels' => array(
				'search_items'      => __( 'Search Playlists'),
				'all_items'         => __( 'All Playlists'),
				'edit_item'         => __( 'Edit Playlist'),
				'update_item'       => __( 'Update Playlist'),
				'add_new_item'      => __( 'Add New Playlist'),
				'new_item_name'     => __( 'New Playlist Name'),
				'menu_name'         => __( 'Playlists'),
			),
			'rewrite' => array( 'slug' => 'series' ),
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_menu' => true,
			'show_in_quick_edit' => true,
			'hierarchical' => true,
			'capabilities' => array(
				'manage_terms' => 'manage_categories',
				'edit_terms' => 'manage_categories',
				'delete_terms' => 'manage_categories',
				'assign_terms' => 'edit_posts'
			)
		)
	);
}
add_action( 'init', 'video_playlist_init', 0 );

add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy');
function tsm_filter_post_type_by_taxonomy() {
	global $typenow;
	$post_type = 'videos'; // change to your post type
	$taxonomy  = 'playlists'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => __("Show All {$info_taxonomy->label}"),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}

<?php

function finish_video_ajax(){
	if(session_id() == '') session_start();
	$do_not_duplicate = $_SESSION['do_not_duplicate'];
	$post_id = ($_POST['id']) ? $_POST['id'] : 0;
	$authors = get_coauthors($post_id);
	$co_authors = array();
	$num_posts = 6;

	$sidebar_posts = array();
	if ($authors[1] !== null) {
		foreach ($authors as $key => $author) {
			if ($key !== 0) {
				$co_authors[] = 'cap-'.$author->data->user_nicename;
			}
		}
		$args = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'author',
					'field' => 'slug',
					'terms' => $co_authors,
					'operator' => 'IN'
				)
			),
			'orderby' => 'rand',
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => $num_posts,
			'post__not_in' => $do_not_duplicate,
			'nopaging' => false
		);
		$query_auth = new WP_Query($args);
		$posts_from_auth = $query_auth->posts;

		if(count($posts_from_auth) > 0){
			foreach ($posts_from_auth as $pfa) {
				$sidebar_posts[] = $pfa;
			}
		}
		$extra_posts = $num_posts - count($posts_from_auth);
	} else {
		$extra_posts = $num_posts;
	}

	if($extra_posts > 0){
		$args = array(
			'orderby' => 'rand',
			'post_type' => 'post',
			'post_status' => 'publish',
			'numberposts' => $extra_posts,
			'post__not_in' => $do_not_duplicate,
		);
		$posts = get_posts($args);

		$query_posts = array_merge($sidebar_posts, $posts);
	} else{
		$query_posts = $sidebar_posts;
	}

	if ($query_posts):
	foreach ($query_posts as $query_post):
		$do_not_duplicate[] = $query_post->ID;
	?>

	<div class="video-post with-post-id unloaded">
		<a href="<?php echo get_the_permalink($query_post->ID); ?>">
			<?php
				$gif = get_field('post_gif', $query_post->ID);
				if( !empty($gif) ){
					echo '<img class="gif" src="'.$gif['url'].'" alt="'.$gif['alt'].'">';
				}else{
					echo get_the_post_thumbnail($query_post->ID, 'home-posts-med');
				}
			?>
			<span><?php echo get_the_title($query_post->ID); ?></span>
		</a>
	</div>

	<?php
	endforeach;
	endif;
	wp_die();
}
add_action( 'wp_ajax_finish_video_ajax', 'finish_video_ajax' );
add_action( 'wp_ajax_nopriv_finish_video_ajax', 'finish_video_ajax' );

function finish_video_ajax_noid(){
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'orderby' => 'rand',
		'posts_per_page' => 6,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => array( 'post-format-video' ),
			)
		)
	);
	$query = new WP_Query($args);
	while( $query->have_posts() ): $query->the_post();
	?>

	<div class="video-post without-post-id unloaded">
		<a href="<?php echo get_the_permalink(); ?>">
			<?php
				$gif = get_field('post_gif');
				if( !empty($gif) ){
					echo '<img class="gif" src="'.$gif['url'].'" alt="'.$gif['alt'].'">';
				}else{
					the_post_thumbnail('home-posts-med');
				}
			?>
			<span><?php the_title(); ?></span>
		</a>
	</div>

	<?php
	endwhile;
	wp_die();
}
add_action( 'wp_ajax_finish_video_ajax_noid', 'finish_video_ajax_noid' );
add_action( 'wp_ajax_nopriv_finish_video_ajax_noid', 'finish_video_ajax_noid' );
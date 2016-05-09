<?php

function getYtPlayer($player_id, $post_id){
	?>

	<div id="player"></div>

	<script>
		var player,
			apiKey = 'AIzaSyC6RkDGWw1wbYXkk0-xqAxtc4eQhV4rVPs',
			playerId = '<?php echo $player_id; ?>';

		var ytEvents = {
			events : {
				startVidByNum : function(i){
					jQuery('#player').animate({ opacity:1 }, 200);
				}
			},
			onPlayerReady : function(event){
				ytEvents.events.startVidByNum();
				// event.target.playVideo();
			},
			onPlayerStateChange : function(event){
				if(event.data === 0){
					jQuery('.video-embed').append('<div class="video-overlay"><img class="loading" alt="loading" src="/wp-content/themes/whohaha/resources/images/default.gif"></div>')
					player.cueVideoById({videoId:playerId});
					jQuery.ajax({
						url : '/wp-admin/admin-ajax.php',
						method : 'POST',
						data : {
							'action' : 'finish_video_ajax',
							'id' : '<?php echo $post_id; ?>'
						}
					}).done(function(output){
						jQuery('.video-overlay').append(output);
						function showVids(){
							jQuery('img.loading').remove();
							jQuery('.video-post').removeClass('unloaded');
						}
						window.setTimeout(showVids, 500);
					});
				}
			},
			definePlayer : function(){
				player = new YT.Player('player', {
					height: '390',
					width: '640',
					videoId: playerId,
					playerVars: {
						controls:1,
						modestbranding:1,
						showinfo:0,
						color: 'white'
					},
					events: {
						'onReady': ytEvents.onPlayerReady,
						'onStateChange': ytEvents.onPlayerStateChange
					}
				});
			},
			init : function(){
				var tag = document.createElement('script');

				tag.src = "https://www.youtube.com/iframe_api";
				var firstScriptTag = document.getElementsByTagName('script')[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			}
		}

		ytEvents.init();

		function onYouTubeIframeAPIReady() {
			ytEvents.definePlayer();
		}

	</script>
	<?php
}

function finish_video_ajax(){
	session_start();
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
	
	<div class="video-post unloaded">
		<a href="<?php echo get_the_permalink($query_post->ID); ?>">
			<?php
				$gif = get_field($query_post->ID, 'post_gif');
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
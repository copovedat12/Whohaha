<?php

function getYtPlayer($player_id, $post_id = null, $autoplay = false){
	global $video_embeds;
	if (!isset($video_embeds)) {
		$video_embeds = array();
	}
	$video_embeds[] = array(
		'playerid' =>  $player_id,
		'postid' => $post_id,
		'autoplay' => $autoplay
	);
	?>
	<div id="player_<?php echo $player_id; ?>" data-videoid="<?php echo $player_id; ?>" <?php if ($post_id) echo ' data-postid="'.$post_id.'"'; ?><?php if ($autoplay) echo ' data-autoplay="'.$autoplay.'"'; ?>></div>
	<?php
}

add_action('wp_footer', 'check_yt_vids', 15);
function check_yt_vids(){
	global $video_embeds;
	render_script($video_embeds);
}

// function render_script($player_id, $post_id = null, $autoplay = false){
function render_script($video_embeds){
	?>
	<script>
		<?php
		foreach ($video_embeds as $index => $video){
			echo PHP_EOL;
			?>
			var player_<?php echo $index; ?>;
			var videoId_<?php echo $index; ?> = "<?php echo $video['playerid']; ?>";
			<?php
		}
		?>

		var ytEvents = {
			events : {
				startVidByNum : function(i){
					jQuery('#player').animate({ opacity:1 }, 200);
				}
			},
			onPlayerReady : function(event){
				ytEvents.events.startVidByNum();
				var autoplay = jQuery(event.target.a).data('autoplay');
				if (autoplay && autoplay === true) {
					event.target.playVideo();
				}
			},
			onPlayerStateChange : function(event){
				if(event.data === 0){
					var selectedVideo = event.target;
					var $this = selectedVideo.a;
					var ajaxAction,
						$parent = $this.offsetParent,
						thisVideoId = jQuery($this).data('videoid'),
						thisPostId = jQuery($this).data('postid');

					jQuery($parent).append('<div class="video-overlay"><img class="loading" alt="loading" src="/wp-content/themes/whohaha/resources/images/default.gif"></div>');
					selectedVideo.cueVideoById({videoId:thisVideoId});

					if(thisPostId){
						ajaxAction = 'finish_video_ajax';
					} else {
						ajaxAction = 'finish_video_ajax_noid';
					}
					jQuery.ajax({
						url : '/wp-admin/admin-ajax.php',
						method : 'POST',
						data : {
							'action' : ajaxAction,
							'id' : thisPostId
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
				<?php
				foreach ($video_embeds as $index => $video) {
				?>
				player_<?php echo $index; ?> = new YT.Player('player_<?php echo $video['playerid']; ?>', {
					height: '390',
					width: '640',
					videoId: videoId_<?php echo $index; ?>,
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
				<?php
				}
				?>
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

	<div class="video-post unloaded">
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

function getYtPlayer_shortcode($atts){
	extract(shortcode_atts(array(
		"id" => "asdf",
		"autoplay" => false,
	), $atts));

	ob_start();
	?>
	<div class="video-embed">
	<?php
	getYtPlayer($id, null, $autoplay);
	?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'get-yt-player', 'getYtPlayer_shortcode' );

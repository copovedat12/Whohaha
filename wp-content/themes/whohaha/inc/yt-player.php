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
					jQuery('.video-embed').append('<div class="video-overlay"></div>')
					player.cueVideoById({videoId:playerId});
					jQuery.ajax({
						url : '/wp-admin/admin-ajax.php',
						method : 'POST',
						data : {
							'action' : 'finish_video_ajax',
							'id' : '<?php echo $post_id; ?>'
						}
					}).done(function(output){
						console.log(output);
						jQuery('.video-overlay').append(output);
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

function finish_video_ajax($player_id){
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
	
	<div class="video-post">
		<a href="<?php echo get_the_permalink(); ?>">
			<?php the_post_thumbnail('home-posts-med'); ?>
			<span><?php the_title(); ?></span>
		</a>
	</div>

	<?php
	endwhile;
	wp_die();
}
add_action( 'wp_ajax_finish_video_ajax', 'finish_video_ajax' );
add_action( 'wp_ajax_nopriv_finish_video_ajax', 'finish_video_ajax' );
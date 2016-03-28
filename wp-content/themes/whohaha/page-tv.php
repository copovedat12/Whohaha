<?php
/**
 * The template for whohaha tv page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container category" role="main">
			<header class="page-header top-header">
				<span>WhoHaha TV</span>
			</header><!-- .page-header -->

			<div class="yt-section">
				<div class="row">
					<div class="outer-container col-md-6">
						<div class="player-container">
							<div id="player"></div>
						</div>
					</div>
					<div class="v-player-list col-md-6"></div>
					<div class="result"></div>
				</div>
			</div>

			<script>
				var player;
				var ytEvents = {
					events : {
						startVidByNum : function(i){
							jQuery('#player').animate({ opacity:0 }, 'slow', function(){
								player.playVideoAt(i);
							})
							.animate({ opacity:1 }, 'slow');
						}
					},
					onPlayerReady : function(event){
						ytEvents.cueVideoPlaylist();
						jQuery('#player').animate({ opacity:1 }, 'slow');
					},
					showPlaylistVids : function(){
						var playlistVids = player.getPlaylist();
						//https://developers.google.com/youtube/v3/docs/playlistItems/list#request
						var playlistInfo;
						jQuery.ajax({
							url: "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=PL0ngUCWCffOuxSeI3U4i7JeAUSA4x7UIG&key=AIzaSyBzZ2YsFh8THdXoObeWTdfg5kyqGfUEhVI"
						})
						.done(function( retVal ) {
							playlistInfo = retVal;
							playlistInfo = playlistInfo.items;

							console.log(retVal);

							for (var i = 0; i < playlistVids.length; i++) {
								if(i === 50){
									break;
								}

								var vidInfo = playlistInfo[i];

								var addImg = '<a href="#" onclick="event.preventDefault(); ytEvents.events.startVidByNum('+i+');">';
								addImg += '<img src="'+vidInfo.snippet.thumbnails.medium.url+'" alt="">';
								addImg += '<h2>'+vidInfo.snippet.title+'</h2>';
								addImg += '</a>';
								jQuery('.v-player-list').append(addImg);
								// console.log(i, vidInfo.snippet.thumbnails);
							}

						});

					},
					onPlayerStateChange : function(event){
						if(event.data === 5){
							ytEvents.showPlaylistVids();
							// event.target.playVideo();
						}
					},
					cueVideoPlaylist : function(){
						player.cuePlaylist({
							listType:'playlist',
							list:'PL0ngUCWCffOuxSeI3U4i7JeAUSA4x7UIG',
							index:0
						});
					},
					definePlayer : function(){
						console.log('define player');
						player = new YT.Player('player', {
							height: '390',
							width: '640',
							videoId: 'N2TQiAnwGXg',
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
			get_template_part( 'template-parts/content', 'archive-footer' );
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

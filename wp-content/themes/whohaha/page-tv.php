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
					<div class="outer-container col-md-8">
						<div class="player-container">
							<div id="player"></div>
						</div>
					</div>
					<div class="col-md-4 custom-scrollbar">
						<div class="v-player-list"></div>
					</div>
					<div class="result"></div>
				</div>
			</div>

			<script>
				var player,
					apiKey = 'AIzaSyC3PT-spYsqJRlVtB_mA0A6KvknYtI7_EM',
					playlistId = 'PL0ngUCWCffOuxSeI3U4i7JeAUSA4x7UIG';

				if(window.location.host === 'localhost'){
					apiKey = 'AIzaSyC3PT-spYsqJRlVtB_mA0A6KvknYtI7_EM';
				}else{
					apiKey = 'AIzaSyBzZ2YsFh8THdXoObeWTdfg5kyqGfUEhVI';
				}

				var ytEvents = {
					events : {
						startVidByNum : function(i){
							jQuery('#player').animate({ opacity:0 }, 'slow', function(){
								player.playVideoAt(i);
							})
							.animate({ opacity:1 }, 'slow');
						}
					},
					numLoaded : 0,
					numShowing : 0,
					playingVid : 0,
					loadUrl : 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId='+playlistId+'&key='+apiKey,
					nextUrl : null,
					onPlayerReady : function(event){
						ytEvents.cueVideoPlaylist();
						jQuery('#player').animate({ opacity:1 }, 'slow');
					},
					addPlaylistVids : function(){
						var playlistVids = player.getPlaylist();
						//https://developers.google.com/youtube/v3/docs/playlistItems/list#request
						var playlistInfo;
						if(ytEvents.nextUrl !== null){
							var ajaxUrl = ytEvents.nextUrl;
						} else{
							var ajaxUrl = ytEvents.loadUrl
						}
						jQuery.ajax({
							url: ajaxUrl
						})
						.done(function( retVal ) {
							playlistInfo = retVal;
							playlistItemsInfo = playlistInfo.items;

							ytEvents.nextUrl = ytEvents.loadUrl + '&pageToken=' + playlistInfo.nextPageToken;
							ytEvents.numLoaded = playlistInfo.items.length;
							ytEvents.numShowing = ytEvents.numShowing + playlistInfo.items.length;

							// console.log(playlistInfo);

							jQuery('button.load-more').remove();

							for (var i = 0; i < ytEvents.numLoaded; i++) {
								var vidInfo = playlistItemsInfo[i];

								if(vidInfo.snippet.position === ytEvents.playingVid){
									var addImg = '<a class="plist-video-'+vidInfo.snippet.position+' active" href="#" onclick="event.preventDefault(); ytEvents.events.startVidByNum('+vidInfo.snippet.position+');">';
								}else{
									var addImg = '<a class="plist-video-'+vidInfo.snippet.position+'" href="#" onclick="event.preventDefault(); ytEvents.events.startVidByNum('+vidInfo.snippet.position+');">';
								}
								addImg += '<img src="'+vidInfo.snippet.thumbnails.medium.url+'" alt="">';
								addImg += '<h2>'+vidInfo.snippet.title+'</h2>';
								addImg += '</a>';
								jQuery('.v-player-list').append(addImg);
							}
							if(playlistInfo.nextPageToken){
								jQuery('.v-player-list').append('<button class="load-more">Load More</button>');
							}

						});

					},
					onPlayerStateChange : function(event){
						if(event.data === 5){
							// ytEvents.addPlaylistVids();
							event.target.playVideo();
						}else if(event.data === 3){
							jQuery('.v-player-list > a').removeClass('active');
							ytEvents.playingVid = player.getPlaylistIndex();
							jQuery('a.plist-video-'+ytEvents.playingVid).addClass('active');

							if(ytEvents.numShowing <= (ytEvents.playingVid + 1)){
								ytEvents.addPlaylistVids();
							}
						}
						// console.log(event, ytEvents.playingVid, ytEvents.numShowing)
					},
					cueVideoPlaylist : function(){
						player.cuePlaylist({
							listType:'playlist',
							list:'PL0ngUCWCffOuxSeI3U4i7JeAUSA4x7UIG',
							index:0
						});
					},
					definePlayer : function(){
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

				jQuery(document).on('click', 'button.load-more', function(){
					ytEvents.addPlaylistVids();
				});
			</script>

		<?php
			get_template_part( 'template-parts/content', 'archive-footer' );
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

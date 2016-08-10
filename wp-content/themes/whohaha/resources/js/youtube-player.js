var video_embeds = YOUTUBE_ARRAY.video_embeds,
	player = [],
	videoId = [];

for (var index = 0; index < video_embeds.length; index++) {
	videoId[index] = video_embeds[index].playerid;
}

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
		for (var index = 0; index < videoId.length; index++) {
			player[index] = new YT.Player('player_' + videoId[index], {
				height: '390',
				width: '640',
				videoId: videoId[index],
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
		}
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
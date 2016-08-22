(function($){
	var dm_video_embeds = (typeof(DM_ARRAY) !== 'undefined') ? DM_ARRAY.video_embeds : null,
		dmPlayer = [];

	for (var index = 0; index < dm_video_embeds.length; index++) {
		var videoObj = dm_video_embeds[index];

		if(videoObj.autoplay === 'true'){
			var autoplay = true;
		} else {
			var autoplay = false;
		}
		/**
		 * Initialize player
		 */
		dmPlayer[index] = DM.player(document.getElementById("player_"+videoObj.playerid), {
			video: videoObj.playerid,
			width: "100%",
			height: "100%",
			params: {
				autoplay: autoplay,
				mute: false
			}
		}).addEventListener('end', function(e){
			var $this = e.target;
			var thisPostId = jQuery($this).parent().data('postid'),
				ajaxAction;

			// Reload video
			this.load(videoObj.playerid, {
				autoplay : false
			});

			// Add overlay with loader
			jQuery($this).after('<div class="video-overlay"><img class="loading" alt="loading" src="/wp-content/themes/whohaha/resources/images/default.gif"></div>');

			// Use ajax to get overlay videos
			if(typeof(thisPostId) !== 'undefined'){
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
		});
	}
})(jQuery);
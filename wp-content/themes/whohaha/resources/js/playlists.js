var whhPlaylists = (function($){
	var player,
		firstVideoUrl = (typeof(DM_PLIST_ARR) !== 'undefined') ? DM_PLIST_ARR.currentVideoId : null;

	var firstVideoId = firstVideoUrl.split('/').pop();
	var currentVideoId = (window.location.hash.length > 0) ? window.location.hash.replace('#','') : firstVideoId;

	player = DM.player(document.getElementById("player"), {
		video: currentVideoId,
		width: "100%",
		height: "100%",
		params: {
			autoplay: true,
			mute: false
		}
	});
	player.addEventListener('apiready', function(){
		$('#player').css('opacity', 1);
		$('a#video-'+currentVideoId).addClass('active');
		var position = $('a#video-'+currentVideoId).position().top + $('.v-player-list').scrollTop();
		$(".v-player-list").animate({scrollTop: position});
		registerPlaylistFunctions();
	});
	player.addEventListener('end', function(){
		if ($('.v-player-list a.active').next().length > 0) {
			$('.v-player-list a.active').next().trigger('click');
		}
	});

	var registerPlaylistFunctions = function() {
		$('.v-player-list a').on('click', function(){
			var $this = $(this);
			// var playerId = $(this).data('videourl').split('/').pop();
			var playerId = $(this).data('videoid');
			player.load(playerId, {
				autoplay : true
			});

			$('.v-player-list a').removeClass('active');
			$this.addClass('active');

			if($('.v-player-list > a').length > 0){
				var position = $this.position().top + $('.v-player-list').scrollTop();
				$(".v-player-list").animate({scrollTop: position});
			}

			window.location.hash = $this.attr('href');

			return false;
		});
	}

	$('.v-player-list').hover(function(){
		if($(window).width() > 992){
			document.body.style.overflow='hidden';
		}
	}, function(){
		document.body.style.overflow='auto';
	});
})(jQuery);
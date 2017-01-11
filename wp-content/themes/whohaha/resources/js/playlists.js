var whhPlaylists = (function($){
	var playerm,
		currentVideoId = (typeof(DM_PLIST_ARR) !== 'undefined') ? DM_PLIST_ARR.currentVideoId : null,
		videoPicked = false;

	currentVideoId = currentVideoId.split('/').pop();

	player = DM.player(document.getElementById("player"), {
		video: currentVideoId,
		width: "100%",
		height: "100%",
		params: {
			autoplay: false,
			mute: false
		}
	});
	player.addEventListener('apiready', function(){
		$('#player').css('opacity', 1);
		// console.log('ready');
		checkVideoIndex();
	});

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

	var pickFirstVideo = function() {
		var $firstItem = $('.v-player-list a').first();
		$firstItem.trigger('click');
	}

	var checkVideoIndex = function(){
		if (window.location.hash.length > 0) {
			var videoId = window.location.hash.replace('#','');
			$('a[data-videoid="'+videoId+'"]').trigger('click');
			if ($('a[data-videoid="'+videoId+'"]').length === 0) pickFirstVideo();
		} else {
			pickFirstVideo();
		}
	}

	$('.v-player-list').hover(function(){
		if($(window).width() > 992){
			document.body.style.overflow='hidden';
		}
	}, function(){
		document.body.style.overflow='auto';
	});
})(jQuery);
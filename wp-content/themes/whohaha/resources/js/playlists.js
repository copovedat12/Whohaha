var heroscope = (function($){
	var playerm,
		currentVideoId = (typeof(DM_PLIST_ARR) !== 'undefined') ? DM_PLIST_ARR.currentVideoId : null;

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
		console.log('ready');
	});

	$('.v-player-list a').on('click', function(){
		var playerId = $(this).data('videourl').split('/').pop();
		player.load(playerId, {
			autoplay : true
		});
	});
})(jQuery);
var heroscope = (function($){
	var player;

	player = DM.player(document.getElementById("player"), {
		video: 'k6XpSTZaUex5Eulo6Ur',
		width: "100%",
		height: "100%",
		params: {
			autoplay: false,
			mute: false,
			'quality': '720',
			'ui-start-screen-info' : false,
			'ui-highlight' : 'E40D8D',
			'ui-theme' : 'dark'
		}
	});
	player.addEventListener('apiready', function(){
		$('#player').css('opacity', 1);
		console.log('ready');
	});

	$('.v-player-list .horoscope-sign').on('click', function(event){
		event.preventDefault();
		var playerId = $(this).data('videoid');

		player.load(playerId, {
			autoplay : true
		});
	});
})(jQuery);
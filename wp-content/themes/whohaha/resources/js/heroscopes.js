var heroscope = (function($){
	var player;

	player = DM.player(document.getElementById("player"), {
		video: 'x4kw90c',
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

	$('.v-player-list .horoscope-sign').on('click', function(event){
		event.preventDefault();
		var playerId = $(this).data('videoid');

		player.load(playerId, {
			autoplay : true
		});
	});
})(jQuery);
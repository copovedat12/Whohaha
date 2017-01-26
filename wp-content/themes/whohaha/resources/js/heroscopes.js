var heroscope = (function($){
	var availSigns = [
		'aries',
		'libra',
		'taurus',
		'scorpio',
		'gemini',
		'sagittarius',
		'cancer',
		'capricorn',
		'leo',
		'aquarius',
		'virgo',
		'pisces',
	];

	// if still using hash, convert to path
	var currHash = (window.location.hash.length > 0) ? window.location.hash.replace('#','') : null;
	if (currHash !== null && availSigns.indexOf(currHash) > 0) window.location.replace('/series/heroscopes/'+currHash+'/');

	var pagepathArr = window.location.pathname.split('/');
	var currPath = (pagepathArr[3].length > 0) ? pagepathArr[3] : null;
	var player,
		videoId,
		currentSign = (currPath !== null && availSigns.indexOf(currPath) > 0) ? currPath : 'aries';

	videoId = $('.v-player-list .horoscope-sign[data-sign="'+currentSign+'"]').data('videoid');

	player = DM.player(document.getElementById("player"), {
		video: videoId,
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
	player.addEventListener('end', function(){
		var $this = $(this);
		this.load(videoId, {
			autoplay : false
		});
		$this.after('<div class="video-overlay"><button class="facebook btn btn-facebook facebook-share" onclick="javascript:socialShare.share(this, \'facebook\', 600, 600);return false;"><i class="fa fa-facebook" aria-hidden="true"></i> Share on Facebook</button></div>');
	});

	$('.v-player-list .horoscope-sign').on('click', function(event){
		event.preventDefault();
		videoId = $(this).data('videoid');

		// window.location.hash = $(this).data('sign');
		history.replaceState( null, null, '/series/heroscopes/' + $(this).data('sign') + '/' );

		player.load(videoId, {
			autoplay : true
		});
	});
})(jQuery);
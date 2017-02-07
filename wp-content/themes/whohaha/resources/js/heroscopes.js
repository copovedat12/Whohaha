var heroscope = (function($){
	var availSigns = {
		'x5at0ul' : 'aquarius',
		'x5at278' : 'pisces',
		'x5at18b' : 'aries',
		'x5at2hx' : 'taurus',
		'x5at1wa' : 'gemini',
		'x5at1ef' : 'cancer',
		'x5at20a' : 'leo',
		'x5at2m0' : 'virgo',
		'x5at23n' : 'libra',
		'x5at2eu' : 'scorpio',
		'x5at2b5' : 'sagittarius',
		'x5at1o0' : 'capricorn',
	},
	// set default currentSign to aries
	currentSign;

	// if still using hash, convert to path and replace current sign
	var currHash = (window.location.hash.length > 0) ? window.location.hash.replace('#','') : null;
	if (currHash !== null && _.has(availSigns, currHash)) {
		currentSign = _.get(availSigns, currHash, 'aries');
		history.replaceState( null, null, '/series/heroscopes/' + currentSign + '/' );
	}

	var pagepathArr = window.location.pathname.split('/');
	var currPath = (pagepathArr[3].length > 0) ? pagepathArr[3] : null;
	var player,
		videoId,
		currentSign = (currPath !== null) ? currPath : 'aries';

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
		$this.after('<div class="video-overlay"><button class="facebook btn btn-facebook facebook-share" onclick="ga(\'send\', \'event\', \'Share\', \'click\', \'Heroscope Facebook share after video\'); javascript:socialShare.share(this, \'facebook\', 600, 600);return false;"><i class="fa fa-facebook" aria-hidden="true"></i> Share on Facebook</button></div>');
	});

	$('.v-player-list .horoscope-sign').on('click', function(event){
		event.preventDefault();
		videoId = $(this).data('videoid');

		$('#player').siblings('.video-overlay').remove();

		// window.location.hash = $(this).data('sign');
		history.replaceState( null, null, '/series/heroscopes/' + $(this).data('sign') + '/' );

		player.load(videoId, {
			autoplay : true
		});
	});
})(jQuery);
var heroscope = (function($){
	var availSigns = {
		'x5861cj' : 'aries',
		'x581wjb' : 'libra',
		'x585gvo' : 'taurus',
		'x585az2' : 'scorpio',
		'x581usd' : 'gemini',
		'x585csg' : 'sagittarius',
		'x585fyz' : 'cancer',
		'x581t0k' : 'capricorn',
		'x581vwz' : 'leo',
		'x585i4y' : 'aquarius',
		'x585ehg' : 'virgo',
		'x581xja' : 'pisces'
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

	videoId = $('.v-player-list .horoscope-sign[data-sign="'+currentSign+'"]').data('videourl');

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
		videoId = $(this).data('videourl');

		$('#player').siblings('.video-overlay').remove();

		// window.location.hash = $(this).data('sign');
		history.replaceState( null, null, '/series/heroscopes/' + $(this).data('sign') + '/' );

		player.load(videoId, {
			autoplay : true
		});
	});
})(jQuery);
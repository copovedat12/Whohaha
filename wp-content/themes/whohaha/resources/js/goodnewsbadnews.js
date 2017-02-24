var gnbnPlaylists = (function($){
	var player = [],
		playerIndex = [],
		playerTypes = ['good', 'bad'],
		playerIds = [],
		videoAutoplay = [false, false],
		firstIds = [];

	if ( typeof(GNBN_PLIST_ARR) !== 'undefined' ) {
		playerIds[0] = GNBN_PLIST_ARR.goodNewsUrls;
		playerIds[1] = GNBN_PLIST_ARR.badNewsUrls;
		firstIds = [playerIds[0][0], playerIds[1][0]];
	}
	if ( window.location.hash.length > 0 ) {
		var hashId = window.location.hash.replace('#','');
		for (id in playerIds) {
			if ( playerIds[id].indexOf(hashId) > -1 ) {
				firstIds[id] = hashId;
				videoAutoplay[id] = true;
			}
		}
	}

	for (var i = 0; i < playerTypes.length; i++) {
		var playerType = playerTypes[i]; // 'good' or 'bad'
		var currentVideo = firstIds[i];
		playerIndex[i] = i;

		player[i] = DM.player(document.getElementById("player_"+playerType), {
			video: currentVideo,
			width: "100%",
			height: "100%",
			params: {
				autoplay: videoAutoplay[i],
				mute: false
			}
		});
		player[i].index = i;
		player[i].currentVideoId = currentVideo;
		player[i].addEventListener('apiready', function(){
			$(this).css('opacity', 1);
		});
		player[i].addEventListener('end', function(e){
			var thisPlayerIds = playerIds[this.index];
			var idIndex = thisPlayerIds.indexOf(this.currentVideoId),
				nextVid;
			if ( playerIds[this.index][idIndex+1] !== 'undefined' && idIndex > -1) {
				nextVid = playerIds[this.index][idIndex+1];
			} else {
				nextVid = playerIds[this.index][0];
			}
			player[this.index].currentVideoId = nextVid;
			this.load(nextVid, {
				autoplay : true
			});
		});
	}

})(jQuery);
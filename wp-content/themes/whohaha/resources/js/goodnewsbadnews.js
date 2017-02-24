var gnbnPlaylists = (function($){
	var player = {},
		playerObjects = {
			good : {
				firstId : null,
				playerIds : [],
				autoplay : false
			},
			bad : {
				firstId : null,
				playerIds : [],
				autoplay : false
			}
		};
	if ( typeof(GNBN_PLIST_ARR) !== 'undefined' ) {
		playerObjects.good.playerIds = GNBN_PLIST_ARR.goodNewsUrls;
		playerObjects.good.firstId = playerObjects.good.playerIds[0];
		playerObjects.bad.playerIds = GNBN_PLIST_ARR.badNewsUrls;
		playerObjects.bad.firstId = playerObjects.bad.playerIds[0];
	}

	if ( window.location.hash.length > 0 ) {
		var hashId = window.location.hash.replace('#','');
		for (id in playerObjects) {
			if ( playerObjects[id].playerIds.indexOf(hashId) > -1 ) {
				playerObjects[id].firstId = hashId;
				playerObjects[id].autoplay = true;
			}
		}
	}

	for (i in playerObjects) {
		var playerType = i; // 'good' or 'bad'
		var currentVideo = playerObjects[i].firstId;

		player[i] = DM.player(document.getElementById("player_"+i), {
			video: currentVideo,
			width: "100%",
			height: "100%",
			params: {
				autoplay: playerObjects[i].autoplay,
				mute: false
			}
		});
		player[i].type = i;
		player[i].currentVideoId = currentVideo;
		player[i].addEventListener('apiready', function(){
			$(this).css('opacity', 1);
		});
		player[i].addEventListener('end', function(e){
			var thisPlayer = playerObjects[this.type],
				thisCurrent = this.currentVideoId;

			var currentIndex = thisPlayer.playerIds.indexOf(thisCurrent);

			if ( typeof( thisPlayer.playerIds[currentIndex+1] ) !== 'undefined' ) {
				nextVid = thisPlayer.playerIds[currentIndex+1];
			} else {
				nextVid = thisPlayer.playerIds[0];
			}
			player[this.type].currentVideoId = nextVid;
			this.load(nextVid, {
				autoplay : true
			});
		});
	}

})(jQuery);
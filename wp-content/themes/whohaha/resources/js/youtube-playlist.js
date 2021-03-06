var playlistId = (typeof(YOUTUBE_PL_ARRAY) !== 'undefined') ? YOUTUBE_PL_ARRAY.playlistId : null;
var player,
	apiKey = 'AIzaSyBzZ2YsFh8THdXoObeWTdfg5kyqGfUEhVI',
	playlistId = playlistId;

if(playlistId !== null){
	var ytEvents = {
		numLoaded : 0,
		numShowing : 0,
		pagesLoaded : 0,
		playingVid : 0,
		loadUrl : 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=30&playlistId='+playlistId+'&key='+apiKey,
		nextUrl : null,
		startVidByNum : function(i){
			jQuery('#player').animate({ opacity:0 }, 'slow', function(){
				player.playVideoAt(i);
			})
			.animate({ opacity:1 }, 'slow');
		},
		onPlayerReady : function(event){
			ytEvents.cueVideoPlaylist();
			jQuery('#player').animate({ opacity:1 }, 'slow');
		},
		addPlaylistVids : function(){
			var playlistVids = player.getPlaylist();
			//https://developers.google.com/youtube/v3/docs/playlistItems/list#request
			var playlistInfo;
			if(ytEvents.nextUrl !== null){
				var ajaxUrl = ytEvents.nextUrl;
			} else{
				var ajaxUrl = ytEvents.loadUrl
			}
			jQuery.ajax({
				url: ajaxUrl
			})
			.done(function( retVal ) {
				ytEvents.pagesLoaded++;

				playlistInfo = retVal;
				playlistItemsInfo = playlistInfo.items;

				ytEvents.nextUrl = ytEvents.loadUrl + '&pageToken=' + playlistInfo.nextPageToken;
				ytEvents.numLoaded = playlistInfo.items.length;
				ytEvents.numShowing = ytEvents.numShowing + playlistInfo.items.length;

				jQuery('button.load-more').remove();

				for (var i = 0; i < ytEvents.numLoaded; i++) {
					var vidInfo = playlistItemsInfo[i];

					if(vidInfo.snippet.position === ytEvents.playingVid){
						var addImg = '<a class="plist-video-'+vidInfo.snippet.position+' active" href="#" onclick="event.preventDefault(); ytEvents.startVidByNum('+vidInfo.snippet.position+');">';
					}else{
						var addImg = '<a class="plist-video-'+vidInfo.snippet.position+'" href="#" onclick="event.preventDefault(); ytEvents.startVidByNum('+vidInfo.snippet.position+');">';
					}
					if(typeof(vidInfo.snippet.thumbnails) !== 'undefined')
						addImg += '<img src="'+vidInfo.snippet.thumbnails.medium.url+'" alt="">';
					addImg += '<h2>'+vidInfo.snippet.title+'</h2>';
					addImg += '</a>';
					jQuery('.v-player-list').append(addImg);
				}
				if(playlistInfo.nextPageToken){
					jQuery('.v-player-list').append('<button class="load-more">Load More</button>');
				}

				if(ytEvents.pagesLoaded === 1) ytEvents.checkPlayFromNum();
			});

		},
		onPlayerStateChange : function(event){
			// unstarted
			if(event.data === -1){
				jQuery('.v-player-list > a').removeClass('active');
				ytEvents.playingVid = player.getPlaylistIndex();
				jQuery('a.plist-video-'+ytEvents.playingVid).addClass('active');

				if(jQuery('.v-player-list > a').length > 0){
					var elem = jQuery('a.plist-video-'+ytEvents.playingVid);
					var position = elem.position().top + jQuery('.v-player-list').scrollTop();
					jQuery(".v-player-list").animate({scrollTop: position});
				}

				if(ytEvents.numShowing <= (ytEvents.playingVid + 1)){
					ytEvents.addPlaylistVids();
				}
			}
		},
		cueVideoPlaylist : function(){
			player.cuePlaylist({
				listType:'playlist',
				list:playlistId,
				index:0
			});
		},
		checkPlayFromNum : function(){
			var urlVars = getUrlVars();
			if(typeof(urlVars['playfrom']) !== 'undefined'){
				var playfrom = (urlVars['playfrom'] - 1);
				ytEvents.startVidByNum(playfrom);
			}
		},
		definePlayer : function(){
			player = new YT.Player('player', {
				height: '390',
				width: '640',
				videoId: null,
				playerVars: {
					controls:1,
					modestbranding:1,
					showinfo:0,
					color: 'white'
				},
				events: {
					'onReady': ytEvents.onPlayerReady,
					'onStateChange': ytEvents.onPlayerStateChange
				}
			});
		},
		init : function(){
			var tag = document.createElement('script');

			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
		}
	}

	ytEvents.init();

	function getUrlVars(){
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}

	function onYouTubeIframeAPIReady() {
		ytEvents.definePlayer();
	}

	jQuery(document).on('click', 'button.load-more', function(){
		ytEvents.addPlaylistVids();
	});

	jQuery('.v-player-list').hover(function(){
		if(jQuery(window).width() > 992){
			document.body.style.overflow='hidden';
		}
	}, function(){
		document.body.style.overflow='auto';
	});
}

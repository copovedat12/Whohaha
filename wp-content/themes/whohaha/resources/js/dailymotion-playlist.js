var dmPlaylist = (function($){

	var playlistId = (typeof(DAILYMOTION_PL_ARRAY) !== 'undefined') ? DAILYMOTION_PL_ARRAY.playlistId : null,
		player,
		ajaxUrl;

	var pListEvents = {
		currentpage : 1,
		currentLoaded : null,
		currentLoadedIndex : 0,
		hasMoreVideos : false,
		startVidById : function(i){
			$('#player').animate({ opacity:0 }, 'slow', function(){
				pListEvents.loadVideo(i);
			})
			.animate({ opacity:1 }, 'slow');
			pListEvents.currentLoaded = i;

			$('.v-player-list > a').removeClass('active');
			$('a.plist-video-'+i).addClass('active');
			if($('.v-player-list > a').length > 0){
				var elem = $('a.plist-video-'+i);
				var position = elem.position().top + $('.v-player-list').scrollTop();
				$(".v-player-list").animate({scrollTop: position});
			}
		},
		startVidByNum : function(i){
			if($('.plist-video-'+i).length > 0){
				var vidId = $('.plist-video-'+i).data('videoid');
				pListEvents.startVidById(vidId);
			}
		},
		loadVideo : function(videoId){
			player.load(videoId,{
				autoplay : true
			});
		},
		renderPlaylistVids : function(videos, callback){
			$('button.load-more').remove();

			for (var index = 0; index < videos.length; index++) {
				var vid = videos[index];

				if(pListEvents.currentLoaded === vid.id){
					var addImg = '<a class="plist-video plist-video-'+(index+1)+' plist-video-'+vid.id+' active" href="#" data-videoid="'+vid.id+'">';
				} else {
					var addImg = '<a class="plist-video plist-video-'+(index+1)+' plist-video-'+vid.id+'" href="#" data-videoid="'+vid.id+'">';
				}
				addImg += '<img src="'+vid.thumbnail_180_url+'" alt="">';
				addImg += '<h2>'+vid.title+'</h2>';
				addImg += '</a>';
				$('.v-player-list').append(addImg);
			}

			if(pListEvents.hasMoreVideos === true){
				$('.v-player-list').append('<button class="load-more">Load More</button>');
			}

			if(callback) callback();
		},
		addPlaylistVids : function(){
			ajaxUrl = 'https://api.dailymotion.com/playlist/'+playlistId+'/videos?fields=id,thumbnail_180_url,thumbnail_url,title,&sort=recent&page='+(pListEvents.currentpage + 1)+'&limit=10';
			$.ajax({
				url: ajaxUrl
			})
			.done(function(output){
				pListEvents.currentpage++;
				var videos = output.list;
				pListEvents.hasMoreVideos = output.has_more;
				pListEvents.renderPlaylistVids(videos);
			});
		},
		checkPlayFromNum : function(){
			var urlVars = getUrlVars();
			if(typeof(urlVars['playfrom']) !== 'undefined'){
				// console.log(urlVars['playfrom']);
				pListEvents.startVidByNum(urlVars['playfrom']);
			}
		},
		init : function(){
			ajaxUrl = 'https://api.dailymotion.com/playlist/'+playlistId+'/videos?fields=id,thumbnail_180_url,thumbnail_url,title,&sort=recent&page='+pListEvents.currentpage+'&limit=30';
			$.ajax({
				url: ajaxUrl
			})
			.done(function(output){
				var videos = output.list;
				pListEvents.hasMoreVideos = output.has_more;
				pListEvents.currentLoaded = videos[pListEvents.currentLoadedIndex].id;

				player = DM.player(document.getElementById("player"), {
					video: videos[pListEvents.currentLoadedIndex].id,
					width: "100%",
					height: "100%",
					params: {
						autoplay: false,
						mute: false
					}
				});

				/**
				 * Add event listeners to player
				 */
				player.addEventListener('load', function(){
					$('#player').animate({ opacity:1 }, 'slow');
					pListEvents.renderPlaylistVids(videos, pListEvents.checkPlayFromNum);
				});
				player.addEventListener('end', function(){
					var $nextVideo = $('.plist-video-'+pListEvents.currentLoaded).next('a.plist-video');
					if($($nextVideo).length > 0){
						$($nextVideo).trigger('click');
					}
				});
				player.addEventListener('play', function(){
					if($('.plist-video-'+pListEvents.currentLoaded).next('a').length < 1 && pListEvents.hasMoreVideos === true){
						pListEvents.addPlaylistVids();
					}
				});

			});
		}
	}

	pListEvents.init();

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

	$(document).on('click', 'button.load-more', function(){
		pListEvents.addPlaylistVids();
	});

	$(document).on('click', 'a.plist-video', function(e){
		var $this = e.currentTarget;
		var vidId = $($this).data('videoid');
		pListEvents.startVidById(vidId);
		return false;
	});

	$('.v-player-list').hover(function(){
		if($(window).width() > 992){
			document.body.style.overflow='hidden';
		}
	}, function(){
		document.body.style.overflow='auto';
	});

	return {startVidById : pListEvents.startVidById};
})(jQuery);
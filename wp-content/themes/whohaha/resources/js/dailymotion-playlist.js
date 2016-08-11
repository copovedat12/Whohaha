var playlistId = (typeof(DAILYMOTION_PL_ARRAY) !== 'undefined') ? DAILYMOTION_PL_ARRAY.playlistId : null,
	player,
	ajaxUrl;

var pListEvents = {
	currentpage : 1,
	currentLoaded : null,
	currentLoadedIndex : 0,
	events : {
		startVidByNum : function(i){
			jQuery('#player').animate({ opacity:0 }, 'slow', function(){
				pListEvents.loadVideo(i);
			})
			.animate({ opacity:1 }, 'slow');
			pListEvents.currentLoaded = i;

			jQuery('.v-player-list > a').removeClass('active');
			jQuery('a.plist-video-'+i).addClass('active');
			if(jQuery('.v-player-list > a').length > 0){
				var elem = jQuery('a.plist-video-'+i);
				var position = elem.position().top + jQuery('.v-player-list').scrollTop();
				jQuery(".v-player-list").animate({scrollTop: position});
			}
		}
	},
	loadVideo : function(videoId){
		player.load(videoId,{
			autoplay : true
		});
	},
	loadPlaylistVids : function(videos, more){
		jQuery('button.load-more').remove();

		for (var index = 0; index < videos.length; index++) {
			var vid = videos[index];

			if(pListEvents.currentLoaded === vid.id){
				var addImg = '<a class="plist-video plist-video-'+vid.id+' active" href="#" onclick="event.preventDefault(); pListEvents.events.startVidByNum(\''+vid.id+'\');">';
			} else {
				var addImg = '<a class="plist-video plist-video-'+vid.id+'" href="#" onclick="event.preventDefault(); pListEvents.events.startVidByNum(\''+vid.id+'\');">';
			}
			addImg += '<img src="'+vid.thumbnail_180_url+'" alt="">';
			addImg += '<h2>'+vid.title+'</h2>';
			addImg += '</a>';
			jQuery('.v-player-list').append(addImg);
		}

		if(more === true){
			jQuery('.v-player-list').append('<button class="load-more">Load More</button>');
		}
	},
	addPlaylistVids : function(){
		ajaxUrl = 'https://api.dailymotion.com/playlist/'+playlistId+'/videos?fields=id,thumbnail_180_url,thumbnail_url,title,&sort=recent&page='+(pListEvents.currentpage + 1)+'&limit=10';
		jQuery.ajax({
			url: ajaxUrl
		})
		.done(function(output){
			pListEvents.currentpage++;
			var videos = output.list;
			var more = output.has_more;
			pListEvents.loadPlaylistVids(videos, more);
		});
	},
	init : function(){
		ajaxUrl = 'https://api.dailymotion.com/playlist/'+playlistId+'/videos?fields=id,thumbnail_180_url,thumbnail_url,title,&sort=recent&page='+pListEvents.currentpage+'&limit=10';
		jQuery.ajax({
			url: ajaxUrl
		})
		.done(function(output){
			var videos = output.list;
			var more = output.has_more;

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
				jQuery('#player').animate({ opacity:1 }, 'slow');
			});
			player.addEventListener('end', function(){
				var $nextVideo = jQuery('.plist-video-'+pListEvents.currentLoaded).next('a.plist-video');
				if(jQuery($nextVideo).length > 0){
					jQuery($nextVideo).trigger('click');
				}
			});
			player.addEventListener('play', function(){
				if(jQuery('.plist-video-'+pListEvents.currentLoaded).next('a').length < 1 && more === true){
					pListEvents.addPlaylistVids();
				}
			});

			pListEvents.loadPlaylistVids(videos, more);
		});
	}
}

pListEvents.init();

jQuery(document).on('click', 'button.load-more', function(){
	pListEvents.addPlaylistVids();
});

jQuery('.v-player-list').hover(function(){
	if(jQuery(window).width() > 992){
		document.body.style.overflow='hidden';
	}
}, function(){
	document.body.style.overflow='auto';
});

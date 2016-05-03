/*
 *	Dev scripts for theme
 */

( function( $ ) {

	// Handles both slide navigations
	$(function(){
		var navButton = $('button.navbar-toggle'),
		socialNavButton = $('.social-toggle a'),
		showLeft = $('#slide-navigation'),
		showRight = $('#slide-nav-social'),
		body = $('body'),
		links = showLeft.find('a');

		navButton.click(function(){
			$(this).toggleClass('active');
			body.toggleClass('push-toright');
			showLeft.toggleClass('slide-nav-open');
		});
		socialNavButton.click(function(){
			$(this).toggleClass('active');
			body.toggleClass('push-toleft');
			showRight.toggleClass('slide-nav-open');
		});

		$('a.restore-body').click(function(){
			$(this).toggleClass('active');
			body.removeClass('push-toleft');
			body.removeClass('push-toright');
			showRight.removeClass('slide-nav-open');
			showLeft.removeClass('slide-nav-open');
		});
	});

	var trendingOptions = {
			dots: false,
			infinite: true,
			arrows: true,
			speed: 300,
			autoplay: false,
			autoplaySpeed: 3000,
			slidesToShow: 4,
			slidesToScroll: 4,
			responsive: [
				{
					breakpoint: 991,
					settings: {
					  slidesToShow: 3,
					  slidesToScroll: 3
					}
				},
				{
					breakpoint: 700,
					settings: {
					  slidesToShow: 2,
					  slidesToScroll: 2
					}
				},
				{
					breakpoint: 500,
					settings: {
					  slidesToShow: 1,
					  slidesToScroll: 1
					}
				}
			]
		}

	// Slick Carousels http://kenwheeler.github.io/slick/
	$(function(){
		$('#home-authors-carousel').slick({
			dots: false,
			infinite: false,
			speed: 300,
			slidesToShow: 6,
			slidesToScroll: 6,
			responsive: [
			  {
				breakpoint: 1024,
				settings: {
				  slidesToShow: 4,
				  slidesToScroll: 4
				}
			  },
			  {
				breakpoint: 600,
				settings: {
				  slidesToShow: 3,
				  slidesToScroll: 3
				}
			  },
			  {
				breakpoint: 480,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 2
				}
			  }
			]
		});

		$('.homepage-banner .banner').slick({
			dots : true,
			arrows : false,
			autoplay: true,
			autoplaySpeed: 5000
		});

		$('.in-post-carousel').slick({
			dots: false,
			arrows : true,
			infinite: false,
			speed: 300,
			slidesToShow: 4,
			slidesToScroll: 4,
			responsive: [
			  {
				breakpoint: 1024,
				settings: {
				  slidesToShow: 4,
				  slidesToScroll: 4
				}
			  },
			  {
				breakpoint: 600,
				settings: {
				  slidesToShow: 3,
				  slidesToScroll: 3
				}
			  },
			  {
				breakpoint: 480,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 2
				}
			  }
			]
		});

		$('.video-carousel').slick({
			arrows : true,
			infinite : true,
			autoplay: false,
			speed : 300,
			slidesToShow : 1,
			variableWidth: true,
			centerMode: true,
		});

		$('#page-trending-slides').slick(trendingOptions);
	});

	$(function(){
	   $('.video-carousel iframe').each(function(){
			var oldSrc = $(this).attr('src');
			if( oldSrc.indexOf('youtube') > 0 || oldSrc.indexOf('vimeo') > 0 ){
				if( oldSrc.indexOf('?') > 0 ){
					$(this).attr('src', oldSrc+'&enablejsapi=1');
				}else{
					$(this).attr('src', oldSrc+'?enablejsapi=1');
				}
			}
		});

		$('.video-carousel').on('beforeChange', function(event, slick, currentSlide, nextSlide){
			var elem = document.getElementsByClassName('slick-current')[0];
			var elemIframe = elem.getElementsByTagName("iframe")[0];
			var elemSrc = elemIframe.getAttribute('src');

			if( elemSrc.indexOf('youtube') > 0 ){
				elemIframe.contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
			} else if( elemSrc.indexOf('vine') > 0 ) {
				elemIframe.contentWindow.postMessage('mute', '*');
			} else if( elemSrc.indexOf('vimeo') > 0 ) {
				elemIframe.contentWindow.postMessage('{"method":"pause"}', elemSrc);
			} else{
				// just reload page
				elemIframe.src = elemSrc;
			}
		});
	});

	$(function(){
		// global keycode constant
		var KEYCODE_ESC = 27,
			AVAIL_CODES = {
				numbers : [48, 57],
				uppercase : [65,90],
				// lowercase : [97, 122]
			},
			CODES = {
				BACKSPACE:8,
				COMMA:188,
				DELETE:46,
				DOWN:40,
				END:35,
				ENTER:13,
				ESCAPE:27,
				HOME:36,
				LEFT:37,
				NUMPAD_ADD:107,
				NUMPAD_DECIMAL:110,
				NUMPAD_DIVIDE:111,
				NUMPAD_ENTER:108,
				NUMPAD_MULTIPLY:106,
				NUMPAD_SUBTRACT:109,
				PAGE_DOWN:34,
				PAGE_UP:33,
				PERIOD:190,
				RIGHT:39,
				SPACE:32,
				TAB:9,
				UP:38,
				CTRL:17
			},
			ctrlDown = false;
		// intialize
		$(document).ready( function() {
			// cache variables
			var $search = $('#site-search');
			var $searchtext = $('#site-search .search-field');
			var $searchBtn = $('.icon.search a');
			//turn off autocomplete
			$searchtext.attr('autocomplete', 'off');
			// on any keydown, start parsing keyboard input

			//on search button click
			$searchBtn.click(function(){
				$searchtext.show().focus();
				$search.fadeIn(200);
			});

			$(document).keydown(function(e) {
				if (e.keyCode == CODES.CTRL || e.metaKey || e.ctrlKey){
					ctrlDown = true;
					console.log('ctrl pressed');
				} else{
					ctrlDown = false;
				}

			  if($search.is(':visible')) {
				switch (e.which) {
				  case KEYCODE_ESC:
					$search.fadeOut(200);
					$searchtext.blur().hide();
				  break;
				  default:
					$searchtext.focus();
				  break;
				}
			  } else {
				for (var key in AVAIL_CODES){
					if(e.which >= AVAIL_CODES[key][0] && e.which <= AVAIL_CODES[key][1] && ctrlDown === false && !($('input, textarea').is(':focus'))){
						$searchtext.show().focus();
						$searchtext.val(String.fromCharCode(e.which).toLowerCase());
						$search.fadeIn(200);
					}
				}
			  }
			});
			$('#close-search').click(function(){
				$search.fadeOut(200);
				$searchtext.blur().hide();
			});

		});
	});

	$(function(){
		$('.generate-tags ul.menu, .generate-tags ul.category-nav').append('<li><a id="tag-generate" href="?rand"><span class="reloadtags glyphicon glyphicon-refresh" aria-hidden="true"></span></a></li>');

		$(document).on("click", "a#tag-generate", function(event){
			event.preventDefault();

			ga('send', 'event', 'Tag Generator', 'click', 'Generate random tags in navbar');

			$clicked = $(this);
			$list = $clicked.closest('ul');
			$container = $('.generate-tags');
			$('.reloadtags').addClass('loading');

			$.ajax({
				url : '/wp-admin/admin-ajax.php',
				method : 'POST',
				data : {
					'action' : 'generate_rand_tags_ajax',
					'tag_num' : 3,
					'max_len' : 13
				}
			})
			.done(function(output){
				$container.html('');
				$container.prepend(output);
				$container.find('a').removeAttr('style');
			});
		});
	});

	$(function(){
		$(document).ajaxComplete(function(){
			if($('#home-break-slides').hasClass('slick-slider') !== true){
				$('#home-break-slides').slick(trendingOptions);
			}
		});
	});

	$(function(){
		if($('.sticky-sidebar').length > 0){
			var top = $('.sticky-sidebar').offset().top;
			//https://github.com/leafo/sticky-kit/issues
			$(window).on('load resize', function(){
				if($('.sticky-sidebar').length > 0){
					if($(window).width() < 991){
						$(".sticky-sidebar .sidebar").trigger('sticky_kit:detach');
					}else{
						var top = $('.sticky-sidebar').offset().top;
						$(".sticky-sidebar .sidebar").stick_in_parent({
							parent : $('.sticky-container'),
							offset_top : top
						});
					}
				}
			});
		}
	});

} )( jQuery );

(function($){
	var $list = $('.v-player-list'),
		$window = $(window);

	$window.on('load resize', function(){
		if($window.outerWidth() >= 992){
			var newHeight = $('#player').height();
			$list.css({'height' : newHeight+'px'});
		}else{
			$list.css({'height' : '348px'});
		}
	});
})(jQuery);

(function($){
	var ias = $.ias({
		container:  '#homeposts',
		item:       '.loop-post',
		pagination: 'nav.posts-navigation',
		next:       '.posts-navigation .nav-previous a',
		negativeMargin: 100,
		delay: 1
	});
	ias.extension(new IASSpinnerExtension({
		src : '/wp-content/uploads/2015/10/default.gif'
	}));
	ias.on('rendered', function(items){
		FB.XFBML.parse();
	});

	ias.on('noneLeft', function() {
	    $('.load-more-trigger').remove();
	});

	var i = 0;
	$.ias().on('render', function(items) {
		i++;
		console.log(i);
		if(i == 2){
			ias.extension(new IASTriggerExtension({
				text: 'VIEW MORE HAHAS',
				html: '<div class="load-more-trigger text-center"><a class="btn btn-primary">{text}</a></div>'
			}));
		}
	});

})(jQuery);

(function($){
	var $body = $('body');

	$body.on('click', '.video-overlay a', function(e){
		// e.preventDefault();
		var title = $(e.currentTarget).find('span');
		ga('send', 'event', 'Video Overlay', 'click', ''+title.text()+'');
		// console.log("ga('send', 'event', 'Video Overlay', 'click', '"+title.text()+"');");
	});
})(jQuery);

(function($){
	var $links = $('img'),
		title = $('title').html();

	$links.each(function(key, value){
		if($(value).attr('alt') == null){
			$(value).prop('alt', title);
		}
	});

})(jQuery);

// Global function for social icons on post pages
function socialShare(url, width, height) {
	var winLeft = (window.innerWidth / 2) - (width / 2);
	var winTop = (window.innerHeight / 2) - (height / 2);
	window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height='+height+',width='+width+',top='+winTop+',left='+winLeft);
}

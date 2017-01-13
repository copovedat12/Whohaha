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

		$('.in-post-carousel-with-author').slick({
			dots: false,
			arrows : false,
			infinite: false,
			speed: 300,
			slidesToShow: 3,
			slidesToScroll: 3,
			responsive: [
			  {
				breakpoint: 1024,
				settings: {
				  slidesToShow: 3,
				  slidesToScroll: 3
				}
			  },
			  {
				breakpoint: 600,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 2
				}
			  },
			  {
				breakpoint: 480,
				settings: {
				  slidesToShow: 1,
				  slidesToScroll: 1
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
			draggable: false,
			asNavFor: '.caption-slider'
		});
		$('.caption-slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			draggable: false,
			adaptiveHeight: true
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
				if (e.keyCode === CODES.CTRL || e.metaKey || e.ctrlKey){
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
		$('li.page_item.shop a').click(function(){
			ga('send', 'event', 'Nav Shop Link', 'click', 'Click on shop link in nav bar');
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
		$window = $(window),
		newHeight;

	var recalcHeight = function(){
		if($window.outerWidth() >= 992){
			newHeight = $('.player-container').outerHeight();
			$list.css({'height' : newHeight+'px'});
		}else{
			$list.css({'height' : '348px'});
		}
	}
	recalcHeight();

	$window.on('load resize', function(){
		recalcHeight();
	});
})(jQuery);

(function($){
	var containerName;
	if($('#homeposts').length > 0){
		containerName = '#homeposts';
	} else if ($('#archiveposts').length > 0){
		containerName = '#archiveposts';
	} else {
		containerName = null;
	}
	var ias = $.ias({
		container:  containerName,
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
		refreshSlots();
	});

	ias.on('noneLeft', function() {
			$('.load-more-trigger').remove();
	});

	var i = 0;
	$.ias().on('render', function(items) {
		i++;
		console.log(i);
		if(i === 2){
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

/*
 * Add google event when youtube subscribe iframe is clicked in interstitial ad
 */
(function($){
	$(window).load(function(){
		if ($('#___ytsubscribe_0').length > 0) {
			var iframeYt = document.getElementById('___ytsubscribe_0').firstElementChild;
			focus();
			var listener = addEventListener('blur', function() {
				if(document.activeElement === iframeYt) {
					ga('send', 'event', 'Interstitial Ad', 'click', 'Subscribe to WhoHaha on Youtube');
				}
				removeEventListener('blur', listener);
			});
		}
	});
})(jQuery);

/*
 * Add controls to number input
 */
(function($){
	var woo = $(document);
	var input = $(woo).find('.quantity input');

	// $(woo).find('.quantity');
		// .prepend('<span class="input-num input-number-decrement">-</span>')
		// .append('<span class="input-num input-number-increment">+</span>');

	var val = input.val();
	var inputMin = input.attr('min');
	var incrBtn = $('.input-number-increment');
	var decrBtn = $('.input-number-decrement');

	$(document).on('click', '.input-num', function(e){
		// redefine input in case button replaced with ajax
		input = $(e.currentTarget).siblings('.quantity').find('input');
		val = input.val();

		if($(e.target).hasClass('input-number-decrement')){
			decrease();
		}
		else if($(e.target).hasClass('input-number-increment')){
			increase();
		}
		val = input.val();
		$('input[name="update_cart"]').attr('disabled', false);
	});

	function increase(){
		console.log(input);
		$(input).attr('value', parseInt(val)+1);
	}
	function decrease(){
		if(val > inputMin){
			$(input).attr('value', parseInt(val)-1);
		}
	}
})(jQuery);

(function($){
	var main_img_link = $('a.woocommerce-main-image');
	var main_img = $(main_img_link).find('img');

	$('.images .thumbnails > a').on('click', function(e){
		e.preventDefault();
		var selected = $(this);
		var selectedImg = $(selected).find('img');

		var newLink = $(selected).attr('href');
		var newSrc = $(selectedImg).attr('src');
		var newSrcset = $(selectedImg).attr('srcset');

		$(main_img_link).attr('href', newLink);
		$(main_img).attr('src', newSrc).attr('srcset', newSrcset);
	});
})(jQuery);

(function($){
	lightbox.option({
	  'resizeDuration': 300,
			'disableScrolling' : true
	});
})(jQuery);

(function($){
	if ( $('.match-height').length > 0 )
		$('.match-height').matchHeight();

	$('#page.gopitchyourself .bg-pink span').fitText(.58);
	$('#page.gopitchyourself .bg-purple span').fitText(1.05);
	$('#page.gopitchyourself .bg-blue span').fitText(.87);
})(jQuery);

(function($){
	function floatLabel(inputType){
		$(inputType).each(function(){
			var $this = $(this).find('input');
			// on focus add cladd active to label
			$this.focus(function(){
				$this.parent().siblings('label').addClass("active");
			});
			//on blur check field and remove class if needed
			$this.blur(function(){
				if($this.val() === '' || $this.val() === 'blank'){
					$this.parent().siblings('label').removeClass();
				}
			});
		});
	}
	// just add a class of "floatLabel to the input field!"
	floatLabel(".floatlabel");

	jQuery('.entry-form-container select.form-control').select2();
})(jQuery);

(function($){
	$('.whh-playlists article.has-tooltip').popover({
		html: true,
		// trigger: 'click',
		trigger : 'manual',
		container : '.whh-playlists',
		placement : 'auto right',
		title : $(this).siblings('.plist-popover-title').text(),
		content : function() {
			return $(this).siblings('.plist-popover-content').html();
		}
	})
	.on("mouseenter", function () {
		if (window.innerWidth > 700) {
			var _this = this;
			$(this).popover("show").addClass('active');
			$(".popover").on("mouseleave", function () {
				setTimeout(function(){
					if (!$(_this).is(':hover')) {
						$(_this).popover("hide").removeClass('active');
					}
				}, 100);
			});
		}
	}).on("mouseleave", function () {
		var _this = this;
		setTimeout(function () {
			if (!$(".popover:hover").length) {
				$(_this).popover("hide").removeClass('active');
			}
		}, 100);
	});

	$('.playlist-carousel').slick({
		dots: false,
		infinite: false,
		arrows: true,
		speed: 300,
		autoplay: false,
		autoplaySpeed: 3000,
		slidesToShow: 3,
		slidesToScroll: 3,
		// lazyLoad: 'ondemand',
		draggable: false,
		responsive: [
			{
				breakpoint: 991,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 2
				}
			},
			{
				breakpoint: 700,
				settings: {
				  slidesToShow: 1,
				  slidesToScroll: 1
				}
			}
		]
	});
	$('.single-playlist-carousel').slick({
		dots: false,
		infinite: false,
		arrows: true,
		speed: 300,
		autoplay: false,
		autoplaySpeed: 3000,
		slidesToShow: 4,
		slidesToScroll: 4,
		// lazyLoad: 'ondemand',
		draggable: false,
		swipe: false,
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
	});
})(jQuery);

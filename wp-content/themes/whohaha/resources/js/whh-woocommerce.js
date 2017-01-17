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
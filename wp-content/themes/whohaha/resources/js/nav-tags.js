(function($){
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
				'action' : 'generate_rand_tags_ajax'
			}
		})
		.done(function(output){
			$container.html(output);
			// $container.find('a').removeAttr('style');
		})
		.fail(function(jqXHR, textStatus){
			console.log('error', textStatus);
		})
		.always(function(output){
			$('.reloadtags').removeClass('loading');
		});
	});
})(jQuery);
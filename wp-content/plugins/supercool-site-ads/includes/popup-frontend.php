<?php
$options = get_option('sc_ads_opts_popup');
?>
<div class="int-modal-wrapper fade-in">
	<div class="modal-overlay"></div>
	<div class="int-modal">
		<a class="modal-close">×</a>
		<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['sc_popup_ads_content'])) ); ?>
	</div>
</div>
<script>
	(function($){
		function setCookie() {
			<?php if ($options['sc_popup_ads_dev_mode']): ?>
			console.log('Cookie would be set for <?php echo ($options['sc_popup_cookie_time'] / 60); ?> minutes.');
			<?php else: ?>
			Cookies.set('_wp_int_ad_popup', '<?php echo $_SERVER['REQUEST_URI']; ?>', { path: '/', expires: <?php echo $options['sc_popup_cookie_time']; ?> });
			<?php endif; ?>
		}

		$(document).ready(function(){
			$('a.modal-close, .modal-overlay').click(function(){
				$('.modal-overlay').remove();
				$('.int-modal-wrapper').remove();
				setCookie();
			});

			$('.int-modal a, .int-modal input[type="submit"]').click(function(){
				setCookie();
			});
		});
	})(jQuery);
</script>

<?php
$options = get_option('sc_ads_opts_int');
?>
<div class="ad-container">
	<div class="wp-int-navbar">
		<div class="intads-bootstrap-container">
			<div class="close-btn">
				<div class="countdown pull-right">
					Continue In <span><?php echo $options['sc_int_ads_timer']; ?></span>
					<?php if($options['sc_int_ads_allow_skip']): ?> &nbsp; | &nbsp; <a href="#" class="int-close">or skip this ad</a><?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="intads-bootstrap-container">
		<div class="int-ad-content-container">
			<div class="int-ad-content">
				<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['sc_int_ads_content'])) ); ?>
			</div>
			<?php if (isset($options['sc_int_ads_bl_content']) || $options['sc_int_ads_br_content'])): ?>
				<div class="int-ad-content-bottom">
					<div class="int-ad-content-bottom-half left-half">
						<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['sc_int_ads_bl_content'])) ); ?>
					</div>
					<div class="int-ad-content-bottom-half right-half">
						<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['sc_int_ads_br_content'])) ); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<script>
	(function($){
		$('body').css('overflow', 'hidden');

		var ad = $('.ad-container');
		var closeBtn = ad.find('a.int-close'),
			ctTimer = ad.find('.countdown span');

		var start = <?php echo $options['sc_int_ads_timer']; ?>;

		function setCookie() {
			<?php if ($options['sc_int_ads_dev_mode']): ?>
			console.log('Cookie would be set for <?php echo $options['sc_int_cookie_time']; ?> seconds.');
			<?php else: ?>
			Cookies.set('_wp_int_ad', '<?php echo $_SERVER['REQUEST_URI']; ?>', { path: '/', expires: <?php echo $options['sc_int_cookie_time']; ?> });
			<?php endif; ?>
		}

		function countDown(){
			if(start === 0){
				$('.close-btn').html('<a href="#" class="int-close">Continue</a>');
				setCookie();
				clearInterval(statTimer);
			} else{
				$(ctTimer).text(start);
				start--;
			}
		}
		var statTimer = setInterval(countDown, 1000);

		function closeAd(){
			ad.remove();
			$('body').css('overflow', 'initial');
			setCookie();
		}

		$('body').on('click', 'a.int-close', function(e){
			e.preventDefault();
			closeAd();
		});

		$('body').on('click', '.int-ad-content-container a, .int-ad-content-container input[type="submit"]', function(){
			setCookie();
		});
	})(jQuery);
</script>

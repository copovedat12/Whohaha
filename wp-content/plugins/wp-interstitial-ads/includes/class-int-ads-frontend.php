<?php

class Int_Ads_Frontend{
	public function full_screen_ad(){
		$options = get_option('interstitial_ads_opts', Int_Ads::get_defaults());
		?>
		<div class="ad-container">
			<div class="wp-int-navbar">
				<div class="container close-btn">
					<div class="countdown pull-right">
						Continue In <span><?php echo $options['timer']; ?></span>
						<?php if($options['skip_link']): ?> &nbsp; | &nbsp; <a href="#" class="close">or skip this ad</a><?php endif; ?>
					</div>
				</div>
			</div>
			<div class="container">
			<?php if ($options['content_layout'] === 'layout1'): ?>
				<div class="int-ad-content-container">
					<div class="int-ad-content">
						<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['content'])) ); ?>
					</div>
				</div>
			<?php elseif ($options['content_layout'] === 'layout2'): ?>
				<div class="int-ad-content-container">
					<div class="int-ad-content">
						<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['content_top'])) ); ?>
					</div>
					<div class="int-ad-content-bottom">
						<div class="int-ad-content-bottom-half left-half">
							<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['content_bottom_left'])) ); ?>
						</div>
						<div class="int-ad-content-bottom-half right-half">
							<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['content_bottom_right'])) ); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			</div>
		</div>
		<script>
			if (typeof(jQuery) == 'undefined'){
				document.write('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"><\/script>');
			}
			(function($){
				$('body').css('overflow', 'hidden');

				var ad = $('.ad-container');
				var closeBtn = ad.find('a.close'),
					ctTimer = ad.find('.countdown span');

				var start = <?php echo $options['timer']; ?>;

				function countDown(){
					if(start === 0){
						$('.close-btn').html('<a href="#" class="close">Continue To Site</a>');
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
					Cookies.set('_wp_int_ad', '<?php echo $_SERVER['REQUEST_URI']; ?>', { path: '/', expires: <?php echo $options['cookie_duration']; ?> });
				}

				$('body').on('click', 'a.close', function(e){
					e.preventDefault();
					closeAd();
				});
			})(jQuery);
		</script>
		<?php
	}

	public function modal_ad(){
		$options = get_option('interstitial_popup_ads_opts', Int_Ads::get_defaults());
		?>
		<div class="int-modal-wrapper fade-in">
			<div class="modal-overlay"></div>
			<div class="int-modal">
				<a class="modal-close">×</a>
				<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['popup_content'])) ); ?>
			</div>
		</div>
		<script>
			(function($){
				$(document).ready(function(){
					$('a.modal-close, .modal-overlay').click(function(){
						$('.modal-overlay').remove();
						$('.int-modal-wrapper').remove();
						Cookies.set('_wp_int_ad_popup', '<?php echo $_SERVER['REQUEST_URI']; ?>', { path: '/', expires: <?php echo $options['popup_cookie_duration']; ?> });
					});
				});
			})(jQuery);
		</script>
		<?php
	}
}

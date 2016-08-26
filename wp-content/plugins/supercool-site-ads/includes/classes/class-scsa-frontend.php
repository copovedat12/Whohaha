<?php

class SC_Ads_Frontend{
	public function __construct(){
		// add_action( 'wp_enqueue_scripts', array($this, 'load_scripts') );
		add_action( 'wp', array($this, 'init_sc_ads') );
	}

	public function write_ad_css(){
		$int_option = get_option('sc_ads_opts_int');
		$popup_option = get_option('sc_ads_opts_popup');
		?>

		<style media="screen">
		.ad-container{
			background: #FFFFFF;
			<?php create_bg_css($int_option['sc_int_ads_bg']); echo PHP_EOL; ?>
		}
		.sc-int-ad-content-container{
			max-width: <?php echo (isset($int_option['sc_int_ads_max_width'])) ? $int_option['sc_int_ads_max_width'] : 'none'; ?>;
			color: <?php echo (isset($int_option['sc_int_ads_font_color'])) ? $int_option['sc_int_ads_font_color'] : '#000000'; ?>;
		}

		.sc-ad-modal{
			max-width: <?php echo (isset($popup_option['sc_popup_ads_max_width'])) ? $popup_option['sc_popup_ads_max_width'] : 'none'; ?>;
			color: <?php echo (isset($popup_option['sc_popup_ads_font_color'])) ? $popup_option['sc_popup_ads_font_color'] : '#000000'; ?>;
			margin-top: <?php echo (isset($popup_option['sc_popup_ads_distance_from_top'])) ? $popup_option['sc_popup_ads_distance_from_top'] : '100px'; ?>;
		}
		</style>
		<?php
	}

	public function load_scripts(){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'cookies-js', plugins_url( '/assets/cookies.js', SC_ADS_DIR ), array(), '', true );
		wp_enqueue_style( 'sc-ads', plugins_url( '/assets/sc-ads-styles.css', SC_ADS_DIR ) );
	}

	public function check_for_cookies(){
		$set_cookies = array();
		if(isset($_COOKIE['_sc_ads_int'])) $set_cookies[] = 'interstital';
		if(isset($_COOKIE['_sc_ads_popup'])) $set_cookies[] = 'popup';
		return $set_cookies;
	}

	public function check_is_enabled(){
		$int_option = get_option('sc_ads_opts_int');
		$popup_option = get_option('sc_ads_opts_popup');
		$is_enabled = array();
		if($int_option['sc_int_ads_enable']) $is_enabled[] = 'interstital';
		if($popup_option['sc_popup_ads_enable']) $is_enabled[] = 'popup';
		return $is_enabled;
	}

	public function check_dev_mode(){
		$int_option = get_option('sc_ads_opts_int');
		$popup_option = get_option('sc_ads_opts_popup');
		$in_dev_mode = array();
		if($int_option['sc_int_ads_dev_mode']) $in_dev_mode[] = 'interstital';
		if($popup_option['sc_popup_ads_dev_mode']) $in_dev_mode[] = 'popup';
		return $in_dev_mode;
	}

	public function check_page_active($pages){
		if(
			(is_home() && isset($pages['home'])) ||
			(is_single() && isset($pages['posts'])) ||
			(is_page() && isset($pages['pages'])) ||
			(is_tag() && isset($pages['tags'])) ||
			(is_category() && isset($pages['categories'])) ||
			(is_author() && isset($pages['authors']))
		){
			return true;
		}
	}

	public function check_is_ad_active(){
		$int_option = get_option('sc_ads_opts_int');
		$popup_option = get_option('sc_ads_opts_popup');

		$cookies = self::check_for_cookies();
		$is_enabled = self::check_is_enabled();
		$dev_mode = self::check_dev_mode();
		$is_admin = current_user_can('manage_options');

		$is_active = array();
		if( in_array('interstital', $is_enabled) && ( ( !in_array('interstital', $cookies) && !in_array('interstital', $dev_mode) ) || ( in_array('interstital', $dev_mode) && $is_admin ) ) ){
			$pages = $int_option['sc_int_ads_pages'];
			if(self::check_page_active($pages)){
				$is_active[] = 'interstital';
			}
		}
		if ( in_array('popup', $is_enabled) && ( ( !in_array('popup', $cookies) && !in_array('popup', $dev_mode) ) || ( in_array('popup', $dev_mode) && $is_admin ) ) ){
			$pages = $popup_option['sc_popup_ads_pages'];
			if(self::check_page_active($pages)){
				$is_active[] = 'popup';
			}
		}

		return $is_active;
	}

	public function init_sc_ads(){
		$check_active = self::check_is_ad_active();

		if(!empty($check_active)){
			add_action( 'wp_enqueue_scripts', array($this, 'load_scripts') );
			add_action( 'wp_head', array($this, 'write_ad_css'), 8 );
			if (in_array('interstital', $check_active)) {
				add_action( 'wp_footer', array($this, 'render_int_ad'), 15 );
			} elseif (in_array('popup', $check_active)) {
				add_action( 'wp_footer', array($this, 'render_popup_ad'), 15 );
			}
		}
	}

	public function render_int_ad(){
		// include plugin_dir_path( SC_ADS_DIR ) . 'includes/interstitial-frontend.php';
		$options = get_option('sc_ads_opts_int');
		?>
		<div class="ad-container">
			<div class="sc-int-navbar">
				<div class="sc-ads-bootstrap-container">
					<div class="close-btn">
						<div class="countdown pull-right">
							Continue In <span><?php echo $options['sc_int_ads_timer']; ?></span>
							<?php if($options['sc_int_ads_allow_skip']): ?> &nbsp; | &nbsp; <a href="#" class="int-close">or skip this ad</a><?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="sc-ads-bootstrap-container">
				<div class="sc-int-ad-content-container">
					<div class="sc-int-ad-content">
						<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['sc_int_ads_content'])) ); ?>
					</div>
					<?php if (isset($options['sc_int_ads_bl_content']) || isset($options['sc_int_ads_br_content'])): ?>
						<div class="sc-int-ad-content-bottom">
							<div class="sc-int-ad-content-bottom-half left-half">
								<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['sc_int_ads_bl_content'])) ); ?>
							</div>
							<div class="sc-int-ad-content-bottom-half right-half">
								<?php echo do_shortcode( htmlspecialchars_decode(stripslashes($options['sc_int_ads_br_content'])) ); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<script>
			(function($){
				$(document).ready(function(){
					if(typeof(Cookies.get('_sc_ads_int')) !== 'undefined'){
						ad.remove();
						$('body').css('overflow', 'initial');
						// window.location.reload();
					}
				});

				$('body').css('overflow', 'hidden');
				var ad = $('.ad-container');
				var closeBtn = ad.find('a.int-close'),
					ctTimer = ad.find('.countdown span');

				var start = <?php echo $options['sc_int_ads_timer']; ?>;

				function setCookie() {
					<?php if ($options['sc_int_ads_dev_mode']): ?>
					console.log('Cookie would be set for <?php echo $options['sc_int_cookie_time']; ?> seconds.');
					<?php else: ?>
					Cookies.set('_sc_ads_int', '<?php echo $_SERVER['REQUEST_URI']; ?>', { path: '/', expires: <?php echo $options['sc_int_cookie_time']; ?> });
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

				$('body').on('click', '.sc-int-ad-content-container a, .sc-int-ad-content-container input[type="submit"]', function(){
					setCookie();
				});
			})(jQuery);
		</script>
		<?php
	}

	public function render_popup_ad(){
		// include plugin_dir_path( SC_ADS_DIR ) . 'includes/popup-frontend.php';
		$options = get_option('sc_ads_opts_popup');
		?>
		<div class="sc-ad-modal-wrapper fade-in">
			<div class="modal-overlay"></div>
			<div class="sc-ad-modal">
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
					Cookies.set('_sc_ads_popup', '<?php echo $_SERVER['REQUEST_URI']; ?>', { path: '/', expires: <?php echo $options['sc_popup_cookie_time']; ?> });
					<?php endif; ?>
				}
				function reload(){
					window.location.reload();
				}

				$(document).ready(function(){
					if(typeof(Cookies.get('_sc_ads_popup')) !== 'undefined'){
						$('.modal-overlay').remove();
						$('.sc-ad-modal-wrapper').remove();
					}

					$('a.modal-close, .modal-overlay').click(function(){
						$('.modal-overlay').remove();
						$('.sc-ad-modal-wrapper').remove();
						setCookie(reload);
					});

					$('.sc-ad-modal a, .sc-ad-modal input[type="submit"]').click(function(){
						setCookie();
					});
				});
			})(jQuery);
		</script>
		<?php
	}
}

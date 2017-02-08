<?php
/**
 * The template for whohaha tv page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

<?php if ( ! post_password_required( $post ) ) : ?>

<?php
	$pageTitle = get_the_title();
	$pageUrl = urlencode(get_permalink());
	$pageThumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
?>
	
	<div class="heroscope-content-area">
		<div id="particles-js"></div>
		<div class="heroscope-container">
			<div class="container">
				<header class="page-header text-center">
					<img src="<?php echo get_template_directory_uri(); ?>/resources/images/heroscope/heroscopes-logo-lowercase.png" alt="Heroscopes">
					<img class="poweredby" src="<?php echo get_template_directory_uri(); ?>/resources/images/heroscope/powered-by.png" alt="Powered By DailyMotion">
				</header><!-- .page-header -->

				<div class="yt-section">
					<div class="row">
						<div class="outer-container col-md-8">
							<div class="video-embed">
								<?php get_heroscope_plist(); ?>
							</div>
						</div>
						<div class="col-md-4 custom-scrollbar">
							<div class="v-player-list">
								<a href="/series/heroscopes/aquarius/" class="horoscope-sign aquarius" data-videoid="x5at0ul" data-sign="aquarius"></a>
								<a href="/series/heroscopes/pisces/" class="horoscope-sign pisces" data-videoid="x5at278" data-sign="pisces"></a>
								<a href="/series/heroscopes/aries/" class="horoscope-sign aries" data-videoid="x5at18b" data-sign="aries"></a>
								<a href="/series/heroscopes/taurus/" class="horoscope-sign taurus" data-videoid="x5at2hx" data-sign="taurus"></a>
								<a href="/series/heroscopes/gemini/" class="horoscope-sign gemini" data-videoid="x5at1wa" data-sign="gemini"></a>
								<a href="/series/heroscopes/cancer/" class="horoscope-sign cancer" data-videoid="x5at1ef" data-sign="cancer"></a>
								<a href="/series/heroscopes/leo/" class="horoscope-sign leo" data-videoid="x5at20a" data-sign="leo"></a>
								<a href="/series/heroscopes/virgo/" class="horoscope-sign virgo" data-videoid="x5at2m0" data-sign="virgo"></a>
								<a href="/series/heroscopes/libra/" class="horoscope-sign libra" data-videoid="x5at23n" data-sign="libra"></a>
								<a href="/series/heroscopes/scorpio/" class="horoscope-sign scorpio" data-videoid="x5at2eu" data-sign="scorpio"></a>
								<a href="/series/heroscopes/sagittarius/" class="horoscope-sign sagittarius" data-videoid="x5at2b5" data-sign="sagittarius"></a>
								<a href="/series/heroscopes/capricorn/" class="horoscope-sign capricorn" data-videoid="x5at1o0" data-sign="capricorn"></a>
							</div>
						</div>
						<div class="result"></div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-8 post-content">
						<div class="socials">
							<h4>Share:</h4>
							<span class="social-icon">
								<a class="facebook" target="_blank" onclick="ga('send', 'event', 'Share', 'click', 'Heroscope Facebook share under video'); javascript:socialShare.share(this, 'facebook', 600, 600);return false;" href="https://www.facebook.com/sharer/sharer.php?s=100&u=<?php echo $pageUrl ?>/"><i class="fa fa-facebook" aria-hidden="true"></i></a>
							</span>
							<span class="social-icon">
								<a class="twitter" target="_blank" data-pagetitle="<?php echo $pageTitle ?>" onclick="ga('send', 'event', 'Share', 'click', 'Heroscope Twitter share under video'); javascript:socialShare.share(this, 'twitter', 550, 450);return false;" href="http://twitter.com/intent/tweet?status=<?php echo $pageTitle ?>+<?php echo $pageUrl; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
							</span>
							<span class="social-icon">
								<a class="pinterest" target="_blank" data-pagetitle="<?php echo $pageTitle ?>" data-thumbnail="<?php echo $pageThumb[0] ?>" onclick="ga('send', 'event', 'Share', 'click', 'Heroscope Pinterest share under video'); javascript:socialShare.share(this, 'pinterest', 750, 600);return false;" href="http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $pageThumb[0] ?>&url=<?php echo $pageUrl ?>&is_video=false&description=<?php echo $pageTitle ?>"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
							</span>
						</div>
						<?php 
						$post = get_queried_object();
						print_r($post->description);
						?>
					</div>
					<div class="col-md-4 planets">
						<img src="<?php echo get_template_directory_uri(); ?>/resources/images/heroscope/planets.png" alt="Planets Zodiac">
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="//cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
	<script>
		particlesJS('particles-js', {
			"particles": {
				"number": {
				    "value": 30
				},
				"shape": {
					"type" : "image",
					"image" : {
						"src": "/wp-content/themes/whohaha/resources/images/heroscope/star.png",
						"width" : 1,
						"height" : 1
					}
				},
				"opacity": {
					"value": 1,
					// "random": true,
					"anim": {
						"enable": true,
						"speed": 1,
						"opacity_min":0.1,
						"sync": false
					}
				},
				"size": {
					"value" : 30,
					"random" : true
				},
				"line_linked": {
					"enable" : false
				},
				"move": {
					"enable": true,
					"speed": 0.5,
				}
			},
			"interactivity": {
				"events" : {
					"onclick" : {
						"enable" : false
					},
					"onhover" : {
						"enable" : false
					}
				}
			}
		});
	</script>

	<div id="primary" class="content-area container">
		<main id="main" class="site-main category" role="main">

		<?php
			get_template_part( 'template-parts/content', 'archive-footer' );
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php else: ?>
	
	<div id="primary" class="password-protected content-area">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<?php echo get_the_password_form(); ?>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

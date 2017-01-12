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
					<img src="<?php echo get_template_directory_uri(); ?>/resources/images/heroscope/heroscopes-logo.png" alt="Heroscopes">
					<img class="poweredby" src="<?php echo get_template_directory_uri(); ?>/resources/images/heroscope/powered-by.png" alt="Powered By DailyMotion">
				</header><!-- .page-header -->

				<?php //getVideoPlaylist('https://www.youtube.com/playlist?list=PLdt4fwPI6A7SqDGWYcVSUbgoir84t24Wf'); ?>
				<div class="yt-section">
					<div class="row">
						<div class="outer-container col-md-8">
							<div class="player-container">
								<!-- <div id="player"></div> -->
								<!-- <iframe id="player" style="opacity: 1;" width="853" height="480" src="//www.dailymotion.com/embed/video/x4kw90c" frameborder="0" allowfullscreen></iframe> -->
								<?php get_heroscope_plist(); ?>
							</div>
						</div>
						<div class="col-md-4 custom-scrollbar">
							<div class="v-player-list">
								<a href="//www.dailymotion.com/embed/video/x4kw90c" class="horoscope-sign aries" data-videoid="x4kw90c"></a>
								<a href="//www.dailymotion.com/embed/video/x4kduga" class="horoscope-sign libra" data-videoid="x4kduga"></a>
								<a href="//www.dailymotion.com/embed/video/x4kdugc" class="horoscope-sign taurus" data-videoid="x4kdugc"></a>
								<a href="//www.dailymotion.com/embed/video/x4kdu6z" class="horoscope-sign scorpio" data-videoid="x4kdu6z"></a>
								<a href="//www.dailymotion.com/embed/video/x4kdu70" class="horoscope-sign gemini" data-videoid="x4kdu70"></a>
								<a href="//www.dailymotion.com/embed/video/x4kdugb" class="horoscope-sign sagittarius" data-videoid="x4kdugb"></a>
								<a href="//www.dailymotion.com/embed/video/x4kdu72" class="horoscope-sign cancer" data-videoid="x4kdu72"></a>
								<a href="//www.dailymotion.com/embed/video/x4kdu71" class="horoscope-sign capricorn" data-videoid="x4kdu71"></a>
								<a href="//www.dailymotion.com/embed/video/x4kdtye" class="horoscope-sign leo" data-videoid="x4kdtye"></a>
								<a href="//www.dailymotion.com/embed/video/x4kdtya" class="horoscope-sign aquarius" data-videoid="x4kdtya"></a>
								<a href="//www.dailymotion.com/embed/video/x4kdty8" class="horoscope-sign virgo" data-videoid="x4kdty8"></a>
								<a href="//www.dailymotion.com/embed/video/x4kdtyc" class="horoscope-sign pisces" data-videoid="x4kdtyc"></a>
							</div>
						</div>
						<div class="result"></div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-8 post-content">
						<div class="socials">
							<span class="social-icon">
								<a class="facebook" onclick="javascript:socialShare(this.href, 600, 600);return false;" href="https://www.facebook.com/sharer/sharer.php?s=100&u=<?php echo $pageUrl ?>/"><i class="fa fa-facebook" aria-hidden="true"></i></a>
							</span>
							<span class="social-icon">
								<a class="twitter" target="_blank" onclick="javascript:socialShare(this.href, 550, 450);return false;" href="http://twitter.com/intent/tweet?status=<?php echo $pageTitle ?>+<?php echo $pageUrl ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
							</span>
							<span class="social-icon">
								<a class="pinterest" target="_blank" onclick="javascript:socialShare(this.href, 750, 600);return false;" href="http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $pageThumb[0] ?>&url=<?php echo $pageUrl ?>&is_video=false&description=<?php echo $pageTitle ?>"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
							</span>
						</div>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php echo get_the_content(); ?>
						<?php endwhile; ?>
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

	<div id="primary" class="content-area">
		<main id="main" class="site-main container category" role="main">

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

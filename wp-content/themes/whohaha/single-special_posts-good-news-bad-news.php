<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

	<main class="site-main" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

	<div class="goodnewsbadnews-content-area">
		<div class="container">
			
			<header class="text-center">
				<h1><?php the_title(); ?></h1>
				<img src="<?php echo get_template_directory_uri(); ?>/resources/images/goodnews-badnews/question.png" alt="">
			</header><!-- .page-header -->

			<div class="pre-header row text-center">
				<div class="col-xs-6">
					<img src="<?php echo get_template_directory_uri(); ?>/resources/images/goodnews-badnews/good-news.png" alt="Good News" title="Good News">
				</div>
				<div class="col-xs-6">
					<img src="<?php echo get_template_directory_uri(); ?>/resources/images/goodnews-badnews/bad-news.png" alt="Bad News" title="Bad News">
				</div>
			</div>

			<div class="side-by-side">
				<div class="row">
					<div class="col-xs-6">
						<div class="player-container">
							<div id="player_good" class="player good"></div>
						</div>
						<?php
						$goodArr = array();
						$args = array(
							'post_type' => 'videos',
							'tax_query' => array(
								array(
									'taxonomy' => 'playlists',
									'field' => 'slug',
									'terms' => 'good-news'
								)
							),
							'posts_per_page' => -1
						);
						$query = get_posts($args);
						foreach ($query as $video) {
							$goodArr[] = array_pop( explode('/', get_post_meta($video->ID, 'whh_video_url', true)) );
						}
						?>
					</div>

					<div class="col-xs-6">
						<div class="player-container">
							<div id="player_bad" class="player bad"></div>
						</div>
						<?php
						$badArr = array();
						$args = array(
							'post_type' => 'videos',
							'tax_query' => array(
								array(
									'taxonomy' => 'playlists',
									'field' => 'slug',
									'terms' => 'bad-news'
								)
							),
							'posts_per_page' => -1
						);
						$query = get_posts($args);
						foreach ($query as $video) {
							$badArr[] = array_pop( explode('/', get_post_meta($video->ID, 'whh_video_url', true)) );
						}
						?>
					</div>
					<?php 
					wp_enqueue_script( 'dm_api', 'https://api.dmcdn.net/all.js', false, false, false );
					wp_enqueue_script( 'goodnewsbadnews', get_template_directory_uri() . '/resources/js/goodnewsbadnews.js', array('jquery'), false, true );
					$var_array = array(
						'goodNewsUrls' => $goodArr,
						'badNewsUrls' => $badArr
					);
					wp_localize_script( 'goodnewsbadnews', 'GNBN_PLIST_ARR', $var_array );
					?>
				</div>
			</div>

			<div class="socials">
				<!-- <h4>Share:</h4> -->
				<span class="social-icon">
					<a class="facebook" target="_blank" onclick="ga('send', 'event', 'Share', 'click', 'Good News Bad News Facebook share under video'); javascript:socialShare.share(this, 'facebook', 600, 600);return false;" href="https://www.facebook.com/sharer/sharer.php?s=100&amp;u=/"><i class="fa fa-facebook" aria-hidden="true"></i></a>
				</span>
				<span class="social-icon">
					<a class="twitter" target="_blank" data-pagetitle="" onclick="ga('send', 'event', 'Share', 'click', 'Good News Bad News Twitter share under video'); javascript:socialShare.share(this, 'twitter', 550, 450);return false;" href="http://twitter.com/intent/tweet?status=+"><i class="fa fa-twitter" aria-hidden="true"></i></a>
				</span>
				<span class="social-icon">
					<a class="pinterest" target="_blank" data-pagetitle="" data-thumbnail="" onclick="ga('send', 'event', 'Share', 'click', 'Good News Bad News Pinterest share under video'); javascript:socialShare.share(this, 'pinterest', 750, 600);return false;" href="http://pinterest.com/pin/create/bookmarklet/?media=&amp;url=&amp;is_video=false&amp;description="><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
				</span>
			</div>

			<div class="description">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<p class="text-center"><?php echo get_the_content(); ?></p>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div id="primary" class="content-area container">

		<section class="whh-playlists">
			<header class="top-header home-author-header">
				<span>WhoHaha &amp; Chill</span>
			</header>
			<?php
			whh_render_all_series( array(get_queried_object()->term_id) );
			whh_render_single_series(
				array(
					'limit' => 1,
					'shuffle' => true,
					'exclude' => array(get_queried_object()->term_id)
				)
			);
			?>
		</section>

		<div class="row">
			<div class="col-md-12">
				<?php get_template_part('template-parts/funny-ladies'); ?>
			</div>
		</div>

	</div><!-- #primary -->

	<?php endwhile; // End of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>

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

	<div class="goodnewsbadnews-content-area">
		<div class="container">
			<?php
			$playlist = get_queried_object();
			$args = array(
				'post_type' => 'videos',
				'tax_query' => array(
					array(
						'taxonomy' => 'playlists',
						'field' => 'slug',
						'terms' => $playlist->slug
					)
				),
				'posts_per_page' => -1
			);
			$query = new WP_Query($args);
			?>
			
			<?php if ( $query->have_posts() ) : ?>

				<div class="pre-header row text-center">
					<div class=" col-lg-4 col-lg-offset-2 col-xs-6">
						<img src="<?php echo get_template_directory_uri(); ?>/resources/images/goodnews-badnews/good-news.png" alt="Good News" title="Good News">
					</div>
					<div class=" col-lg-4 col-xs-6">
						<img src="<?php echo get_template_directory_uri(); ?>/resources/images/goodnews-badnews/bad-news.png" alt="Bad News" title="Bad News">
					</div>
				</div>

				<header class="text-center">
					<h1><?php echo $playlist->name; ?></h1>
					<img src="<?php echo get_template_directory_uri(); ?>/resources/images/goodnews-badnews/question.png" alt="">
				</header><!-- .page-header -->

				<div class="yt-section">
					<div class="row">
						<div class="outer-container col-md-8">
							<div class="player-container">
								<?php
								$last_post = $query->posts[0];
								$last_post_video_url = get_post_meta($last_post->ID, 'whh_video_url', true);
								?>
								<div id="player" class="video-iframe"></div>

								<?php
								wp_enqueue_script( 'dm_api', 'https://api.dmcdn.net/all.js', false, false, false );

								$var_array = array(
									'currentVideoId' => $last_post_video_url
								);
								wp_enqueue_script( 'dm_playlists', get_template_directory_uri() . '/resources/js/playlists.js', array('jquery'), false, true );
								wp_localize_script( 'dm_playlists', 'DM_PLIST_ARR', $var_array );
								?>
							</div>
						</div>
						<div class="col-md-4 custom-scrollbar">
							<div class="v-player-list">
								<?php
								while ( $query->have_posts() ) : $query->the_post();
								$video_url = get_post_meta(get_the_ID(), 'whh_video_url', true);
								?>
									<a href="#<?php echo array_pop(explode('/', $video_url)); ?>" data-videoid="<?php echo array_pop(explode('/', $video_url)); ?>" id="video-<?php echo array_pop(explode('/', $video_url)); ?>"><img src="<?php the_post_thumbnail_url('full') ?>" alt="<?php the_title(); ?>"><h2><?php the_title(); ?></h2></a>
								<?php endwhile; wp_reset_postdata(); ?>
							</div>
						</div>
						<div class="result"></div>
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
							<p class="text-center"><?php echo $playlist->description; ?></p>
						</div>
					</div>
				</div>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

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
	</main><!-- #main -->

<?php get_footer(); ?>

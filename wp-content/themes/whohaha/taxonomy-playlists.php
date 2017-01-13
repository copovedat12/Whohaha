<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container category" role="main">

		<?php
		$post = get_queried_object();
		$args = array(
			'post_type' => 'videos',
			'tax_query' => array(
				array(
					'taxonomy' => 'playlists',
					'field' => 'slug',
					'terms' => $post->slug
				)
			),
			'posts_per_page' => -1
		);
		$query = new WP_Query($args);
		?>

		<?php if ( $query->have_posts() ) : ?>

			<header class="page-header top-header">
				<span><?php echo $post->name; ?></span>
			</header><!-- .page-header -->

			<div class="whohaha-tv-intro">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<h3 class="text-center"><?php echo $post->description; ?></h3>
					</div>
				</div>
			</div>

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

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

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

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>

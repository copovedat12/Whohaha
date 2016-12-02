<?php
/**
 * Template Name: Playlist Page
 *
 * @package WordPress
 * @subpackage WhoHaha
 * @since whohaha
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container category" role="main">
			<header class="page-header top-header">
				<span><?php echo get_the_title(); ?></span>
			</header><!-- .page-header -->

			<div class="whohaha-tv-intro">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<h3 class="text-center">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php echo get_the_content(); ?>
						<?php endwhile; ?>
						</h3>
					</div>
				</div>
			</div>
			<?php if( get_field('video_playlist') ) getVideoPlaylist( get_field('video_playlist') ); ?>

		<?php
			get_template_part( 'template-parts/content', 'archive-footer' );
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

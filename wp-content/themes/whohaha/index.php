<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

	<section class="homepage-banner">
	<?php get_template_part('template-parts/home', 'banner'); ?>
	</section>

	<div id="primary" class="content-area homepage container-fluid">
		<main id="main" class="site-main" role="main">

			<?php get_template_part('template-parts/funny-ladies'); ?>

			<section class="whh-playlists">
				<header class="top-header home-author-header">
					<span>WHOHAHA ORIGINAL SERIES</span>
				</header>
				<?php
				whh_render_all_series();
				whh_render_single_series(['featured' => true]);
				?>
			</section>

			<?php get_template_part('template-parts/loop-breaks/break-part', '0'); ?>

			<section class="homepage-posts posts-grid">
				<header class="top-header home-author-header">
					<span>WHOHAHA TV</span>
				</header>

				<?php if(have_posts()): ?>
					<div id="homeposts">
						<?php get_template_part( 'template-parts/infinite-loop', 'home' ); ?>
					</div>
				<?php endif; ?>

				<?php the_posts_navigation(); ?>

			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

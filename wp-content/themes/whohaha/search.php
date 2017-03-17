<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package whohaha
 */
get_header(); ?>

	<section id="primary" class="content-area container">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header top-header">
				<span>Results for <?php echo $searchQuery; ?></span>
			</header>

			<section class="posts-grid" id="archiveposts">
				<div class="row loop-post">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if (is_search() && ($post->post_type=='page')) continue; ?>

					<?php
					get_template_part( 'template-parts/content-displayposts', 'medium' );
					?>

				<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</section>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		<?php
			get_template_part( 'template-parts/content', 'archive-footer' );
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

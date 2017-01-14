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
		<main id="main" class="site-main category" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header top-header">
				<span>Results for <?php echo get_search_query(); ?></span>
			</header>

			<div id="archiveposts">
				<div class="row loop-post">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if (is_search() && ($post->post_type=='page')) continue; ?>

					<?php
					/**
					* Run the loop for the search to output the results.
					* If you want to overload this in a child theme then include a file
					* called content-search.php and that will be used instead.
					*/
					//get_template_part( 'template-parts/content', 'search' );
					get_template_part( 'template-parts/content-displayposts', 'medium' );
					?>

				<?php endwhile; ?>
				</div>
			</div>

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

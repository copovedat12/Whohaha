<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

	<div id="primary" class="content-area container">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="row">
					<div class="col-md-9">
						<article id="post-<?php the_ID(); ?>" class="recommend" <?php post_class(); ?>>
							<header class="entry-header">
								<?php
								if(get_the_ID() === 1219) {
									echo '<img src="'.get_template_directory_uri().'/resources/images/whofuntheworld.jpg" alt="Who Fun The World?">';
								} else {
									the_title( '<h1 class="entry-title">', '</h1>' );
								}
								?>
							</header><!-- .entry-header -->

							<div class="entry-content">
								<div class="row">
									<div class="col-md-12">
										<div style="position: relative; padding-bottom: 56.25%; height: 0; margin-bottom: 20px;"><iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="https://www.youtube.com/embed/LwuY1hKP9ug?rel=0&amp;controls=1&amp;showinfo=0&amp;autoplay=1" width="300" height="150" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-9 pull-right">
										<?php the_content(); ?>
									</div>
									<div class="col-md-3 social-icons">
										<?php echo get_template_part('inc/social-icons'); ?>
									</div>
								</div>
							</div><!-- .entry-content -->

							<footer class="entry-footer">
							</footer><!-- .entry-footer -->
						</article><!-- #post-## -->
					</div>
					<div class="col-md-3">
						<?php get_template_part( 'template-parts/sidebar', 'page' ); ?>
					</div>
				</div>

			<?php endwhile; // End of the loop. ?>

			<?php
				get_template_part( 'template-parts/trending-hahas' );
				get_template_part( 'template-parts/content', 'archive-footer' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php // get_sidebar(); ?>
<?php get_footer(); ?>

<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package whohaha
 */

get_header(); ?>

	<div id="primary" class="content-area container">
		<main id="main" class="site-main category" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'whohaha' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

			<?php
				get_template_part( 'template-parts/content', 'archive-footer' );
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>

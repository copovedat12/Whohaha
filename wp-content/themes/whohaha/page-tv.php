<?php
/**
 * The template for whohaha tv page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container category" role="main">
			<header class="page-header top-header">
				<span>WhoHaha TV</span>
			</header><!-- .page-header -->

			<div class="whohaha-tv-intro">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<h3 class="text-center">
							Is clicking on multiple links sometimes just too much for you? Don’t worry, we’ve got you covered. Sit back, relax, and watch every hilarious Whohaha video in one place.
						</h3>
					</div>
				</div>
			</div>

			<div class="yt-section">
				<div class="row">
					<div class="outer-container col-md-8">
						<div class="player-container">
							<div id="player"></div>
						</div>
					</div>
					<div class="col-md-4 custom-scrollbar">
						<div class="v-player-list"></div>
					</div>
					<div class="result"></div>
				</div>
			</div>

		<?php
			get_template_part( 'template-parts/content', 'archive-footer' );
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

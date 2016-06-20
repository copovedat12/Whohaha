<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package whohaha
 */
session_start();
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container" role="main">

		<?php while ( have_posts() ) : the_post();

			global $do_not_duplicate;
			$do_not_duplicate = array();
			$do_not_duplicate[] = get_the_ID();


			if(get_field('video_playlist') || (have_rows('add_more_videos') && !($_GET['display'] === 'list'))){
				get_template_part( 'template-parts/content', 'single-full-width' );
			} else if(get_post_format() === 'video'){
				get_template_part( 'template-parts/content', 'single-video' );
			} else{
				get_template_part( 'template-parts/content', 'single' );
			}

			endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

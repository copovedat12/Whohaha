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

	<div id="primary" class="content-area container">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				if ( ! post_password_required( $post ) ) :

					global $do_not_duplicate;
					$do_not_duplicate = array();
					$do_not_duplicate[] = get_the_ID();

					if(get_field('video_playlist') || (have_rows('add_more_videos') && !($_GET['display'] === 'list'))){
						get_template_part( 'template-parts/content', 'single-full-width' );
					} else if(get_post_format() === 'video'){
						get_template_part( 'template-parts/content', 'single-video' );
					} else if(get_post_type() === 'quizzes'){
						get_template_part( 'template-parts/content', 'quiz' );
					} else{
						get_template_part( 'template-parts/content', 'single' );
					}

				else:

				?>
					<div class="row">
						<div class="col-md-12">
							<header class="entry-header">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
									<?php $author_image = get_field('profile_image', 'user_'.get_the_author_id()); ?>
									<img src="<?php echo $author_image['sizes']['thumbnail']; ?>" width="<?php echo $author_image['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $author_image['sizes'][ 'thumbnail-height' ]; ?>">
								</a>
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header><!-- .entry-header -->
						</div>
					</div>
					<div class="row">
						<div class="password-protected">
							<div class="col-md-12 text-center">
								<?php echo get_the_password_form(); ?>
							</div>
						</div>
					</div>
				<?php

				endif; // If password protected

			endwhile; // End of the loop.
			?>

			<?php get_template_part( 'template-parts/content', 'single-footer' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

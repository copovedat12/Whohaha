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
		<main id="main" class="site-main container author" role="main">

		<section class="author-header">
			<?php $author_image = get_field('profile_image', 'user_'.get_the_author_id());
			if($author_image): ?>
			<div class="author-image">
				<img src="<?php echo $author_image['sizes']['medium']; ?>" width="<?php echo $author_image['sizes'][ 'medium-width' ]; ?>" height="<?php echo $author_image['sizes'][ 'medium-height' ]; ?>">
			</div>
			<?php endif; ?>
			<div class="author-bio">
				<h1><?php echo get_the_author(); ?></h1>
				<?php if(get_the_author_meta( 'description', get_the_author_id() )): ?>
				<p><?php the_author_meta( 'description', get_the_author_id() ); ?></p>
				<?php endif; ?>
				<p class="social-links">
					<?php 
					if(get_usermeta(get_the_author_id(),'user_url')): ?>
					<a class="socicon" href="<?php the_author_meta( 'user_url'); ?>" target="_blank"><i class="fi-web"></i></a>
					<?php endif;
					if(get_field('user_fb', 'user_'.get_the_author_id())): ?>
					<a class="socicon" href="<?php the_field('user_fb', 'user_'.get_the_author_id()); ?>" target="_blank">b</a>
					<?php endif;
						  if(get_field('user_tw', 'user_'.get_the_author_id())): ?>
					<a class="socicon" href="<?php the_field('user_tw', 'user_'.get_the_author_id()); ?>" target="_blank">a</a>
					<?php endif;
						  if(get_field('user_ig', 'user_'.get_the_author_id())): ?>
					<a class="socicon" href="<?php the_field('user_ig', 'user_'.get_the_author_id()); ?>" target="_blank">x</a>
					<?php endif;
						  if(get_field('user_yt', 'user_'.get_the_author_id())): ?>
					<a class="socicon" href="<?php the_field('user_yt', 'user_'.get_the_author_id()); ?>" target="_blank">r</a>
					<?php endif;
						  if(get_field('user_pin', 'user_'.get_the_author_id())): ?>
					<a class="socicon" href="<?php the_field('user_pin', 'user_'.get_the_author_id()); ?>" target="_blank">d</a>
					<?php endif; ?>
				</p>
			</div>
		</section>

		<?php if ( have_posts() ) : ?>

			<header class="page-header top-header">
				<!-- <h1 class="page-title"><?php //single_cat_title( '', true ); ?></h1> -->
				<span>Videos Featuring <?php echo get_the_author(); ?></span>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php //while ( have_posts() ) : the_post(); ?>

				<?php

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'archive' );
					// get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php// endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		<?php
			get_template_part( 'template-parts/content', 'archive-footer' );
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

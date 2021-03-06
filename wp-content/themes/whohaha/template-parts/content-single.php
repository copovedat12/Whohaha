<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */
?>

<div class="row sticky-container">
	<div class="col-md-9">
		<article id="<?php echo get_post_format(); ?>-format post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php $author_image = get_field('profile_image', 'user_'.get_the_author_id()); ?>
					<img src="<?php echo $author_image['sizes']['thumbnail']; ?>" width="<?php echo $author_image['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $author_image['sizes'][ 'thumbnail-height' ]; ?>">
				</a>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->

			<?php if(!get_field('hide_image')): ?>
			<div class="post-featured-image">
				<?php the_post_thumbnail('full') ?>
			</div>
			<?php endif; ?>

			<?php
				if (get_field('socials_to_bottom') && get_field('socials_to_bottom') == true ){
					$socials_bottom = true;
				} else{
					$socials_bottom = false;
				}
			?>
			<div class="row">
				<div class="<?php echo ($socials_bottom === true ? "col-md-12" : "col-md-9 pull-right"); ?>">
					<div class="entry-content">
						<?php if ( get_field('post_sub_header') ): ?>
						<h2 class="entry-subtitle">
							<?php the_field('post_sub_header'); ?>
						</h2>
						<?php endif; ?>

						<?php the_content(); ?>
						<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'whohaha' ),
								'after'  => '</div>',
							) );
						?>
					</div><!-- .entry-content -->

					<?php get_template_part('template-parts/content', 'entry-footer'); ?>
				</div>
				<div class="social-icons <?php if($socials_bottom === true): ?>col-md-12 bottom<?php else: ?>col-lg-3 col-md-3<?php endif; ?>">
					<?php get_template_part('inc/social-icons'); ?>
				</div>
			</div>
		</article>
	</div>

	<?php if (get_field('remove_sidebar') == null || get_field('remove_sidebar') == false ): ?>
		<div class="col-md-3 sticky-sidebar">
			<?php get_template_part( 'template-parts/sidebar', 'main' ); ?>
		</div>
	<?php endif; ?>
</div>

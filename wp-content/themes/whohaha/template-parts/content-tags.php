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
	<div class="col-md-9 tag-posts">

		<header class="page-header top-header">
			<span><?php single_cat_title( '', true ); ?></span>
		</header><!-- .page-header -->

		<?php
		global $do_not_duplicate;
		$do_not_duplicate = array();

		$args = array(
			'tag_id' => get_query_var('tag_id')
		);

		$post_loop = new WP_Query($args);
		while ( $post_loop->have_posts() ) : $post_loop->the_post(); 
		// $loop_index++;
		$do_not_duplicate[] = $post->ID;
		?>
		<article id="<?php echo get_post_format(); ?>-format post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php $author_image = get_field('profile_image', 'user_'.get_the_author_id()); ?>
					<img src="<?php echo $author_image['sizes']['thumbnail']; ?>" width="<?php echo $author_image['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $author_image['sizes'][ 'thumbnail-height' ]; ?>">
				</a>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->

			<?php if ( get_field('video_embed_code') ):
				if(have_rows('add_more_videos')):
				?>

				<div class="video-expanded-gallery">
					<div>
						<div class="video-embed<?php if(get_field('video_type') === 'instagram'): ?>-insta<?php endif; ?> <?php the_field('video_type'); ?>">
							<?php echo get_field('video_embed_code'); ?>
						</div>
					</div>
					<?php while (have_rows('add_more_videos')): the_row(); ?>
						<div>
							<div class="video-embed<?php if(get_field('video_type') === 'instagram'): ?>-insta<?php endif; ?> <?php the_sub_field('extra_video_type') ?>">
								<?php the_sub_field('extra_video_code') ?>
							</div>
						</div>
					<?php endwhile; ?>
				</div>

				<?php else: ?>

				<div class="video-embed">
					<?php echo get_field('video_embed_code'); ?>
				</div>
				<?php endif;?>
			<?php else: ?>
				<div class="post-featured-image">
					<?php the_post_thumbnail('full') ?>
				</div>
			<?php endif; ?>

			<div class="row">
				<div class="col-lg-9 col-md-9 pull-right">
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
				<div class="col-lg-3 col-md-3 social-icons">
					<?php get_template_part('inc/social-icons'); ?>
				</div>
			</div>
		</article>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>

	<div class="col-md-3 sticky-sidebar">
		<?php get_template_part( 'template-parts/sidebar', 'tags' ); ?>
	</div>
</div>

<div class="post-footer">
<?php
	get_template_part( 'template-parts/content', 'archive-footer' );
?>
</div>


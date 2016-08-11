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

			<?php
			if ( get_field('dailymotion_video_embed_code') ):
			?>

				<div class="video-embed">
					<?php
					$iframe_string = get_field('dailymotion_video_embed_code');
					if(preg_match('/dailymotion/', $iframe_string)){
						preg_match('/embed\/video\/([\w+\-+\_+]+)[\"\?]/', $iframe_string, $match);
						$video_id = $match[1];
						getDmPlayer($video_id, get_the_ID(), false);
					} else{
						echo get_field('video_embed_code');
					}
					?>
				</div>

			<?php
			elseif ( get_field('video_embed_code') ):
				// If video gallery
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
					<?php
					$iframe_string = get_field('video_embed_code');
					if(preg_match('/youtube/', $iframe_string)){
						/*
						 * Below are my past failed attempts at regex
						 */
						// /embed\/(\w+((\-+\w+)?)+)((\?(rel|list)=(\w+((\-+\w+)?)+))+)?"/
						// /embed\/(\w+((\-+\w+)?)+)(\?rel=\d+?)?"/
						// /embed\/(\w+((\-+\w+)?)+)(\"|\?)/
						// /embed\/(\w+((\-+\w+)?)+)\"|\?/
						// /embed\/(\w+([\-+\w+]?)+[\-\w+]?)\"|\?/
						preg_match('/embed\/([\w+\-+]+)[\"\?]/', $iframe_string, $match);
						$video_id = $match[1];
						getYtPlayer($video_id, get_the_ID(), false);
					} else{
						echo get_field('video_embed_code');
					}
					?>
				</div>
				<?php endif;?>
			<?php else: ?>
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
	</div><!-- .col-md-9 -->

	<?php if (get_field('remove_sidebar') == null || get_field('remove_sidebar') == false ): ?>
	<div class="col-md-3 sticky-sidebar">
		<?php get_template_part( 'template-parts/sidebar', 'main' ); ?>
	</div><!-- .col-md-3 -->
	<?php endif; ?>

</div> <!-- .row.sticky-container -->

<?php get_template_part( 'template-parts/content', 'single-footer' ); ?>

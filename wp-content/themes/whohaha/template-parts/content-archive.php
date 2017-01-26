<?php
global $do_not_duplicate;
$do_not_duplicate = array();
if(have_posts() && !is_paged() ):
?>
	<div class="row">
		<?php
		$args = array(
			'posts_per_page' => 2
		);
		if(is_category()) $args['cat'] = get_query_var('cat');
		if(is_author()){
			$args['author_name'] = get_the_author_meta( 'user_nicename', $author->ID );

			/**
			 * If author is Alex Lynn Ward, show heroscopes as post
			 */
			if (get_the_author_meta( 'user_nicename', $author->ID ) === 'alex-lynn-ward') {
				$args['posts_per_page'] = 1;
				$heroscopes = get_terms(array('taxonomy' => 'playlists', 'slug' => 'heroscopes'));
				$heroscopes = $heroscopes[0];
				$playlist_feat_img = get_field('featured_image', $heroscopes);
				?>
				<div class="col-sm-6">
					<article class="post top-two format-video">
						<div class="entry-image">
							<a href="<?php echo get_term_link($heroscopes); ?>">
								<img src="<?php echo $playlist_feat_img['sizes']['home-posts-lg']; ?>" alt="<?php echo $playlist_feat_img['alt']; ?>" width="<?php echo $playlist_feat_img['sizes']['home-posts-lg-width']; ?>" height="<?php echo $playlist_feat_img['sizes']['home-posts-lg-height']; ?>">
								<?php get_template_part('template-parts/play-button'); ?>
							</a>

							<div class="entry-content">
								<h2 class="entry-title"><a href="<?php echo get_term_link($heroscopes); ?>" rel="bookmark"><?php echo $heroscopes->name; ?></a></h2>
							</div><!-- .entry-content -->
						</div>
					</article><!-- #post-## -->
				</div>
				<?php
			}
		}
		if(is_tag()) $args['tag_id'] = get_query_var('tag_id');

		$post_loop = new WP_Query($args);
		while ( $post_loop->have_posts() ) : $post_loop->the_post(); 
		// $loop_index++;
		$do_not_duplicate[] = $post->ID;
		?>
		<?php get_template_part( 'template-parts/content-displayposts', 'large' ); ?>
		<?php endwhile; wp_reset_postdata(); ?>

	</div><!-- .row -->
<?php endif; ?>

<?php if(have_posts()): ?>
	<div id="homeposts">
		<?php get_template_part( 'template-parts/infinite', 'loop-archive' ); ?>
	</div>
<?php endif; ?>

<?php the_posts_navigation(); ?>
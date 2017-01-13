<?php

function whh_render_all_series($exclude = null){
	$tax_args  = array('taxonomy' => 'playlists', 'hide_empty' => true);
	if ($exclude !== null) $tax_args['exclude'] = $exclude;
	$taxTerms = get_terms( $tax_args );
	?>
	<h3 class="section-header">All Series</h3>
	<div class="row playlist-carousel">
		<?php
		foreach ($taxTerms as $playlist):
			$taxargs = array(
				'post_type' => 'videos',
				'tax_query' => array(
					array(
						'taxonomy' => 'playlists',
						'field' => 'slug',
						'terms' => $playlist->slug
					)
				),
				'posts_per_page' => 1
			);
			$taxonomy = new WP_Query($taxargs);
			while ( $taxonomy->have_posts() ):
				$taxonomy->the_post();
				$video_url = get_post_meta(get_the_ID(), 'whh_video_url', true);
				$video_id = array_pop(explode('/', $video_url));
				?>
				<div class="item col-md-4 col-sm-6">
					<article class="has-tooltip" title="<?php echo $playlist->name; ?>">
						<div>
							<?php
							$playlist_feat_img = get_field('featured_image', $playlist);
							if($playlist_feat_img):
							?>
								<img src="<?php echo $playlist_feat_img['url']; ?>" alt="<?php echo $playlist_feat_img['alt']; ?>" width="<?php echo $playlist_feat_img['width']; ?>" height="<?php echo $playlist_feat_img['height']; ?>">
							<?php else: ?>
								<?php the_post_thumbnail( 'full' ); ?>
							<?php endif; ?>
							<!-- <img data-lazy="<?php //the_post_thumbnail_url( 'full' ); ?>"> -->
						</div>
						<a href="<?php echo get_term_link($playlist); ?>" class="hover-border"></a>
					</article>
					<span class="plist-popover-title">
						<?php echo $playlist->name; ?>
					</span>
					<span class="plist-popover-content">
						<div class="episodes"><?php echo $playlist->count; ?> Episodes</div>
						<div class="desciption">
							<?php echo $playlist->description; ?>
						</div>
						<hr>

						<a href="<?php echo get_term_link($playlist); ?>#<?php echo $video_id; ?>" class="featured-video">
							<?php the_post_thumbnail( 'full' ); ?>
							<span class="title"><?php echo get_the_title(); ?></span>
						</a>
						
						<a href="<?php echo get_term_link($playlist); ?>" class="btn btn-primary btn-block">View More</a>
					</span>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
		endforeach;
		?>
	</div>
	<?php
}

function filter_tax_terms($val){
	return $val->count > 4;
}
function whh_render_single_series($args = array()){
	$limit = (!empty($args['limit'])) ? $args['limit'] : 3;

	$tax_args = array('taxonomy' => 'playlists', 'hide_empty' => true);

	if (!empty($args['exclude'])) $tax_args['exclude'] = $args['exclude'];

	$taxTerms = get_terms( $tax_args );

	$filtered_playlists = array_filter($taxTerms, 'filter_tax_terms');

	if (!empty($args['shuffle']) && $args['shuffle'] === true)
		shuffle($filtered_playlists);

	$playlists = array_slice($filtered_playlists, 0, $limit);

	foreach ($playlists as $playlist):
		?>
		<h3 class="section-header"><?php echo $playlist->name; ?></h3>
		<div class="row single-playlist-carousel">
		<?php
		$query_args = array(
			'post_type' => 'videos',
			'tax_query' => array(
				array(
					'taxonomy' => 'playlists',
					'field' => 'slug',
					'terms' => $playlist->slug
				)
			),
			'posts_per_page' => 12
		);
		$taxonomy = new WP_Query($query_args);
		while ( $taxonomy->have_posts() ):
			$taxonomy->the_post();
			$video_url = get_post_meta(get_the_ID(), 'whh_video_url', true);
			$video_id = array_pop(explode('/', $video_url));
			?>
			<div class="item col-md-3 col-sm-4">
				<article title="<?php echo get_the_title(); ?>">
					<div class="playlist-video">
						<?php the_post_thumbnail( 'full' ); ?>
						<!-- <img data-lazy="<?php //the_post_thumbnail_url( 'full' ); ?>"> -->
						<span class="title"><?php echo get_the_title(); ?></span>
						<?php get_template_part('template-parts/play-button'); ?>
					</div>
					<a href="<?php echo get_term_link($playlist); ?>#<?php echo $video_id; ?>" class="hover-border"></a>
				</article>
				<?php /* ?>
				<!-- <span class="playlist-popover-title">
					<?php echo get_the_title(); ?>
				</span>
				<span class="playlist-popover-content">
					<div class="desciption">
						<?php echo get_the_excerpt(); ?>
					</div>
					
					<a href="<?php echo get_term_link($playlist); ?>#<?php echo $video_id; ?>" class="btn btn-primary btn-block">Watch Now</a>
				</span> -->
				<?php */ ?>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
		</div>
	<?php
	endforeach;
}
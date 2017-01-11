<section class="whh-playlists">
	<header class="top-header home-author-header">
		<span>WHOHAHA ORIGINAL SERIES</span>
	</header>
	
	<h3 class="section-header">All Series</h3>

	<div class="row playlist-carousel">
		<?php
		$taxTerms = get_terms(array('taxonomy' => 'playlists', 'hide_empty' => true));
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
					<article title="<?php echo $playlist->name; ?>">
						<div>
							<?php the_post_thumbnail( 'full' ); ?>
							<!-- <img data-lazy="<?php //the_post_thumbnail_url( 'full' ); ?>"> -->
						</div>
						<a href="/playlist/<?php echo $playlist->slug; ?>" class="hover-border"></a>
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

						<a href="/playlist/<?php echo $playlist->slug; ?>#<?php echo $video_id; ?>" class="featured-video">
							<?php the_post_thumbnail( 'full' ); ?>
							<span class="title"><?php echo get_the_title(); ?></span>
						</a>
						
						<a href="/playlist/<?php echo $playlist->slug; ?>" class="btn btn-primary btn-block">View More</a>
					</span>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
		endforeach;
		?>
	</div>

	
	<?php
	$plist_slugs = array('cannabis-moms-club', 'ask-a-badass', 'really-important-questions');
	foreach ($plist_slugs as $plist_slug):
		$plist = get_term_by('slug', $plist_slug, 'playlists');
		?>
		<h3 class="section-header"><?php echo $plist->name; ?></h3>
		<div class="row single-playlist-carousel">
		<?php
		$args = array(
			'post_type' => 'videos',
			'tax_query' => array(
				array(
					'taxonomy' => 'playlists',
					'field' => 'slug',
					'terms' => $plist->slug
				)
			),
			'posts_per_page' => 12
		);
		$taxonomy = new WP_Query($args);
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
					</adiv>
					<a href="/playlist/<?php echo $plist->slug; ?>#<?php echo $video_id; ?>" class="hover-border"></a>
				</article> 
				<span class="plist-popover-title">
					<?php echo get_the_title(); ?>
				</span>
				<span class="plist-popover-content">
					<div class="desciption">
						<?php echo get_the_excerpt(); ?>
					</div>
					
					<a href="/playlist/<?php echo $plist->slug; ?>#<?php echo $video_id; ?>" class="btn btn-primary btn-block">Watch Now</a>
				</span>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
		</div>
	<?php
	endforeach;
	?>

</section>
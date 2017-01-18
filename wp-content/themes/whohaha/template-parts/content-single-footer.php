<footer class="post-footer">
	<?php if (!has_tag('aha')): ?>

		<?php
		if(get_the_id() !== 3215 && get_the_id() !== 3208):

		global $do_not_duplicate;

		$available_tags = array();
		$post_tags = wp_get_post_tags( get_the_ID() );
		$post_tags = json_decode(json_encode($post_tags), true);

		for ($i=0; $i < count($post_tags); $i++) { 
			$available_tags[] = $post_tags[$i]['slug'];
		}
		$available_tags = implode (",", $available_tags);

		$args = array(
			'orderby'        => 'rand',
			'posts_per_page' => '2',
			'post__not_in' => $do_not_duplicate,
			'tag' => $available_tags
		);
		$post_loop = new WP_Query($args);
		if($post_loop->have_posts() && $post_loop->found_posts > 1 && $available_tags):
		?>
		<div class="row">
			<div class="col-md-12">
				<header class="top-header">
					<span>More Like This</span>
				</header>
				<div class="row">
					<?php
					while ( $post_loop->have_posts() ) : $post_loop->the_post(); 
					// $loop_index++;
					$do_not_duplicate[] = $post_loop->post->ID;
					?>
					<?php get_template_part( 'template-parts/content-displayposts', 'large' ); ?>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
		<?php endif; endif; ?>

		<section class="whh-playlists">
			<header class="top-header home-author-header">
				<span>WhoHaha &amp; Chill</span>
			</header>
			<?php
			whh_render_all_series();
			whh_render_single_series([ 'limit' => 1, 'shuffle' => true ]);
			?>
		</section>

	<?php endif; // !has_tag('aha') ?>

	<div class="row">
		<div class="col-md-12">
			<?php get_template_part('template-parts/funny-ladies'); ?>
		</div>
	</div>
</footer>
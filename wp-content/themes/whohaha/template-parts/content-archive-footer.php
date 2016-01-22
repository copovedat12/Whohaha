<div class="row">
	<div class="col-md-12">
		<header class="top-header">
			<span>More HAHAs</span>
		</header>
		<div class="row">
			<?php
			// $pageid = get_the_ID();
			global $do_not_duplicate;
			$args = array(
				'orderby'        => 'rand',
				'posts_per_page' => '3',
				'post__not_in' => $do_not_duplicate
			);
			$post_loop = new WP_Query($args);
			while ( $post_loop->have_posts() ) : $post_loop->the_post(); 
			// $loop_index++;
			$do_not_duplicate[] = $post->ID;
			?>
			<?php get_template_part( 'template-parts/postpage', 'more-to-love' ); ?>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</div>
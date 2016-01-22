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
			// $args['post_status'] = 'publish';
			// $args['post_type'] = 'post';
			$args['author_name'] = get_the_author_meta( 'user_nicename', $author->ID );
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
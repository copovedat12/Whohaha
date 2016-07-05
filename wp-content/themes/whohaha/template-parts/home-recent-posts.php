<?php
global $do_not_duplicate;
$do_not_duplicate = array();
if(have_posts() && is_front_page() && !is_paged() ):
?>
	<div class="row">
		<?php
		$posts_per_page = get_option( 'sticky_posts' ) ? 1 : 2;
		$homepage_loop = new WP_Query('posts_per_page='.$posts_per_page);
		while ( $homepage_loop->have_posts() ) : $homepage_loop->the_post();
		// $loop_index++;
		$do_not_duplicate[] = $post->ID;
		?>
		<?php get_template_part( 'template-parts/content-displayposts', 'large' ); ?>
		<?php endwhile; wp_reset_postdata(); ?>

	</div><!-- .row -->
<?php endif; ?>

<?php if(have_posts()): ?>
	<div id="homeposts">
		<?php get_template_part( 'template-parts/infinite', 'loop' ); ?>
	</div>
<?php endif; ?>

<?php the_posts_navigation(); ?>

<?php
	$args = array( 'post_type' => 'carousel_posts', 'posts_per_page' => 1 );
	$query = new WP_Query( $args );
	if ( $query->have_posts() ):
	while ( $query->have_posts() ): $query->the_post();
?>

	<div class="banner">
		<?php
			while( have_rows('carousel_posts') ): the_row();
			$image = get_sub_field('post_image');
			$url = get_sub_field('post_url');
		?>
		<div><a href="<?php echo $url; ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"></a></div>
		<?php endwhile; ?>
	</div>

<?php 
	endwhile; 
	wp_reset_postdata(); 
	endif;
?>
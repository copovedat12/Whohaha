<?php
	$args = array( 'post_type' => 'carousel_posts', 'posts_per_page' => 1 );
	$query = new WP_Query( $args );
	if ( $query->have_posts() ):
	while ( $query->have_posts() ): $query->the_post();
?>

	<div class="banner">
		<?php
			$banners = get_field('carousel_posts');
			shuffle($banners);
			foreach ($banners as $banner):
			$image = $banner['post_image'];
			$url = $banner['post_url'];
		?>
			<div><a href="<?php echo $url; ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"></a></div>
		<?php endforeach; ?>
	</div>

<?php 
	endwhile; 
	wp_reset_postdata(); 
	endif;
?>
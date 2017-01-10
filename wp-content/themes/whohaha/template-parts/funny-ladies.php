<?php
	$args = array( 'post_type' => 'front_page_people', 'posts_per_page' => 1 );
	$query = new WP_Query( $args );
	if ( $query->have_posts() ):
	while ( $query->have_posts() ): $query->the_post();
?>
<section class="homepage-authors">
	<header class="side-header home-author-header">
		<span>Funny Ladies</span>
	</header>
	<div class="row" id="home-authors-carousel">
		<?php
			$all_ladies = get_field('front_page_people');
			$banks = $all_ladies[0];
			shuffle($all_ladies);
			$ladies = array();
			$ladies[] = $banks;
			foreach ($all_ladies as $lady){
				if($lady['person']['user_nicename'] !== 'elizabethbanks'){
					$ladies[] = $lady;
				}
			}
			foreach ($ladies as $lady):
				$person = $lady['person'];
		?>
			<div class="author carousel-author">
				<a href="<?php echo get_author_posts_url( $person['ID'] ); ?>">
				<?php $profile_image = get_field('profile_image', 'user_'.$person['ID']); ?>
				<img src="<?php echo $profile_image['sizes']['thumbnail']; ?>" width="<?php echo $profile_image['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $profile_image['sizes'][ 'thumbnail-height' ]; ?>">
				</a>
				<a class="author-name" href="<?php echo get_author_posts_url( $person['ID'] ); ?>"><?php echo $person['display_name']; ?> </a>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php 
	endwhile; 
	wp_reset_postdata(); 
	endif;
?>
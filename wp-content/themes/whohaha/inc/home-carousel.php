<?php
	$banner_query = new WP_Query( array( 'tag' => 'featured' ) );
	if ( $banner_query->have_posts() ):
?>
<section class="homepage-banner">

	<?php if($banner_query->found_posts > 1): ?>
	<div id="home-banner-carousel" class="carousel slide" data-interval="false">
		<div class="carousel-inner" role="listbox">
	<?php endif; ?>

		<?php while ( $banner_query->have_posts() ): $banner_query->the_post(); $post_count++; ?>
		<div class="item<?php if($post_count === 1){echo " active";} ?>">
			<div class="slide">
				<?php
				$image = get_field('featured_image_link');
					if ( $image ) :
				?>
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="1140" height="500">
				<?php
					endif;
				?>
				<div class="carousel-slide-footer">
					<div class="slide-header">
						<h2 class="entry-title">
							<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
						</h2>
					</div>
					<div class="slide-description">
						<!-- <p>The ‘Happiest Place on Earth’ is a lie. In case you’ve never experienced your phone being smashed by a giant unsympathetic talking dog...</p> -->
						<p><?php echo excerpt(22); ?></p>
						<div class="slide-icon">
							<a href="<?php echo esc_url( get_permalink() ); ?>"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile; ?>

	<?php if($banner_query->found_posts > 1): ?>
		</div>
		<a class="left carousel-control" href="#home-banner-carousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#home-banner-carousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<?php endif; ?>

</section>
<?php endif; ?>
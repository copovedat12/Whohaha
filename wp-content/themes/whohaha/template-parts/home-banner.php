<?php if( have_rows('carousel_posts', 'options') ): ?>
	<div class="banner">
		<?php
			$banners = get_field('carousel_posts', 'options');
			if (get_field('randomize_banners', 'options')) shuffle($banners);
			foreach ($banners as $banner):
			$image = $banner['post_image'];
			$url = $banner['post_url'];
		?>
			<div><a href="<?php echo $url; ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"></a></div>
		<?php endforeach; ?>
	</div>
<?php endif;

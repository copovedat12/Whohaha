<article id="post-<?php echo $cat_post->ID; ?>" class="post">
	<div class="entry-image">
		<a href="<?php echo esc_url( get_permalink($cat_post->ID) ); ?>">
		<?php
			echo get_the_post_thumbnail($cat_post->ID, 'medium');
		?>
		</a>
	</div>
	<div class="entry-content">
		<h2 class="entry-title">
			<a href="<?php echo esc_url( get_permalink($cat_post->ID) ); ?>" rel="bookmark">
				<?php echo get_the_title($cat_post->ID); ?>
			</a>
		</h2>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
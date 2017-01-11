<aside class="sidebar">
	<header class="top-header">
		<span>More To Love</span>
	</header>
	<div class="posts">
		<?php
		$popular_posts = get_popular_posts_id(3, 'month');
		// print_r($popular_posts);
		if($popular_posts) echo '<div class="row">';
		foreach ($popular_posts as $post_id):
		?>
		    <article id="post-<?php echo $post_id; ?>" class="post col-md-12 col-sm-4">
		    	<div class="background">
			    	<div class="entry-image">
			    		<a href="<?php echo esc_url( get_permalink($post_id) ); ?>">
				    		<?php
				    			$gif = get_field('post_gif', $post_id);
				    			if( !empty($gif) ){
				    				echo '<img src="'.$gif['url'].'" alt="'.$gif['alt'].'">';
				    			}else if ( get_the_post_thumbnail($post_id, 'home-posts-lg') ) {
				    				echo get_the_post_thumbnail($post_id, 'home-posts-lg');
				    			}
				    			if(get_post_format($post_id) === 'video') get_template_part('template-parts/play-button');
				    		?>
			    		</a>
			    	</div>
			    	<div class="entry-content">
			    		<h3 class="entry-title">
			    			<a href="<?php echo esc_url( get_permalink($post_id) ); ?>" rel="bookmark">
			    				<?php echo get_the_title($post_id); ?>
			    			</a>
			    		</h3>
			    	</div><!-- .entry-content -->
		    	</div>
		    </article><!-- #post-## -->
		<?php
		endforeach;
		if($popular_posts) echo '</div>';
		?>
	</div>
</aside>
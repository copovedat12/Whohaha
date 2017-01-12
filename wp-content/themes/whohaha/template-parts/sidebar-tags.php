<aside class="sidebar">
<!-- <aside class="sidebar" data-spy="affix" data-offset-top="60" data-offset-bottom="200"> -->
	<header class="top-header">
		<span>More Like This</span>
	</header>
	<div class="posts">
		<?php
		global $do_not_duplicate;

		$args = array(
			'orderby' => 'rand',
			'post_type' => 'post',
			'numberposts' => 3,
			'post__not_in' => $do_not_duplicate
		);

		$tag_posts = get_posts($args);
		if ($tag_posts) {
		echo "<div class=\"row\">";
		foreach ($tag_posts as $tag_post) {
			$do_not_duplicate[] = $tag_post->ID;
		?>
		    <article id="post-<?php echo $tag_post->ID; ?>" class="post col-md-12 col-sm-4">
		    	<div class="background">
			    	<div class="entry-image">
			    		<a href="<?php echo esc_url( get_permalink($tag_post->ID) ); ?>">
			    		<?php
			    			$gif = get_field('post_gif', $tag_post->ID);
			    			if( !empty($gif) ){
			    				echo '<img src="'.$gif['url'].'" alt="'.$gif['alt'].'">';
			    			}else if ( get_the_post_thumbnail($tag_post->ID, 'home-posts-lg') ) {
			    				echo get_the_post_thumbnail($tag_post->ID, 'home-posts-lg');
			    			}
			    			get_template_part('template-parts/play-button');
			    		?>
			    		</a>
			    	</div>
			    	<div class="entry-content">
			    		<h3 class="entry-title">
			    			<a href="<?php echo esc_url( get_permalink($tag_post->ID) ); ?>" rel="bookmark">
			    				<?php echo get_the_title($tag_post->ID); ?>
			    			</a>
			    		</h3>
			    	</div><!-- .entry-content -->
		    	</div>
		    </article><!-- #post-## -->
		<?php
		}
		echo "</div>";
		}
		?>
	</div>
</aside>
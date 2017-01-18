<aside class="sidebar">
	<header class="top-header">
		<span>More To Love</span>
	</header>
	<div class="posts">
		<?php
		$sidebar_posts_num = 2;
		global $do_not_duplicate;

		$args = array(
			'orderby' => 'rand',
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => $sidebar_posts_num,
			'post__not_in' => $do_not_duplicate,
			'tag' => 'aha'
		);
		$query_posts = get_posts($args);

		if ($query_posts) {
		echo "<div class=\"row\">";
		foreach ($query_posts as $query_post):
			$do_not_duplicate[] = $query_post->ID;
		?>
		    <article id="post-<?php echo $query_post->ID; ?>" class="post col-md-12 col-sm-6">
		    	<div class="background">
			    	<div class="entry-image">
			    		<a href="<?php echo esc_url( get_permalink($query_post->ID) ); ?>">
			    		<?php
			    			$gif = get_field('post_gif', $query_post->ID);
			    			if( !empty($gif) ){
			    				echo '<img src="'.$gif['url'].'" alt="'.$gif['alt'].'">';
			    			}else if ( get_the_post_thumbnail($query_post->ID, 'home-posts-lg') ) {
			    				echo get_the_post_thumbnail($query_post->ID, 'home-posts-lg');
			    			}
			    			get_template_part('template-parts/play-button');
			    		?>
			    		</a>
			    	</div>
			    	<div class="entry-content">
			    		<h3 class="entry-title">
			    			<a href="<?php echo esc_url( get_permalink($query_post->ID) ); ?>" rel="bookmark">
			    				<?php echo get_the_title($query_post->ID); ?>
			    			</a>
			    		</h3>
			    	</div><!-- .entry-content -->
		    	</div>
		    </article><!-- #post-## -->
		<?php
		endforeach;
		echo "</div>";
		}
		?>
	</div>
</aside>

<?php 
$_SESSION['do_not_duplicate'] = $do_not_duplicate;

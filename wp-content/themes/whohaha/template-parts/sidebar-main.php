<aside class="sidebar">
	<header class="top-header">
		<span>More To Love</span>
	</header>
	<div class="posts">
		<?php
		global $do_not_duplicate;

		$authors = get_coauthors();
		$co_authors = array();

		$sidebar_posts = array();
		if ($authors[1] !== null) {
			$has_co_authors = true;
			foreach ($authors as $key => $author) {
				if ($key !== 0) {
					$co_authors[] = 'cap-'.$author->data->user_nicename;
				}
			}
			$args = array(
				'tax_query' => array(
					array(
						'taxonomy' => 'author',
						'field' => 'slug',
						'terms' => $co_authors,
						'operator' => 'IN'
					)
				),
				'orderby' => 'rand',
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 2,
				'post__not_in' => $do_not_duplicate,
				'nopaging' => false
			);
			$query_auth = new WP_Query($args);
			$posts_from_auth = $query_auth->posts;

			if(count($posts_from_auth) > 0){
				foreach ($posts_from_auth as $pfa) {
					$sidebar_posts[] = $pfa;
				}
			}
			$extra_posts = 2 - count($posts_from_auth);
		} else {
			$has_co_authors = false;
			$extra_posts = 2;
		}

		if($extra_posts > 0){
			$args = array(
				'orderby' => 'rand',
				'post_type' => 'post',
				'post_status' => 'publish',
				'numberposts' => $extra_posts,
				'post__not_in' => $do_not_duplicate,
			);
			$posts = get_posts($args);

			$query_posts = array_merge($sidebar_posts, $posts);
		} else{
			$query_posts = $sidebar_posts;
		}

		if ($query_posts) {
		echo "<div class=\"row\">";
		foreach ($query_posts as $query_post):
			$do_not_duplicate[] = $query_post->ID;
		?>
		    <article id="post-<?php echo $query_post->ID; ?>" class="post col-md-12 col-sm-4">
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

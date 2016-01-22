<aside class="sidebar">
	<header class="top-header">
		<span>More Like This</span>
	</header>
	<div class="posts">
		<?php
		global $do_not_duplicate;

		$available_tags = array();
		$post_tags = wp_get_post_tags( get_the_ID() );
		$post_tags = json_decode(json_encode($post_tags), true);

		for ($i=0; $i < count($post_tags); $i++) { 
			$available_tags[] = $post_tags[$i]['name'];
		}
		$available_tags = implode (",", $available_tags);

		$args = array(
			'orderby' => 'date',
			'order' => 'DESC',
			'post_type' => 'post',
			'numberposts' => 3,
			'post__not_in' => $do_not_duplicate,
			'tag' => $available_tags
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
			    		?>
			    		<div class="play-btn">
			    			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
			    				<polygon class="triangle" id="XMLID_18_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
			    				<circle class="circle" id="XMLID_17_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"></circle>
			    			</svg>
			    		</div>
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
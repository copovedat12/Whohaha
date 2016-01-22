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
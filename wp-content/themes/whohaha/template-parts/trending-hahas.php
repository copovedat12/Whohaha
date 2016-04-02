<div class="row trending-hahas">
	<div class="col-md-12">
		<header class="side-header">
			<span>TRENDING HAHAs</span>
		</header>
		<?php
		//try http://www.wpbeginner.com/wp-tutorials/how-to-track-popular-posts-by-views-in-wordpress-without-a-plugin/
		$popular_posts = get_popular_posts_id(8, 'day');
		// print_r($popular_posts);
		if($popular_posts) echo '<div class=""><div id="page-trending-slides">';
		foreach ($popular_posts as $post_id):
		?>
			<div class="post-container">
			    <article id="post-<?php echo $post_id; ?>" class="post break-slide">
			    	<div class="background">
				    	<div class="entry-image">
				    		<a href="<?php echo esc_url( get_permalink($post_id) ); ?>">
				    		<?php
				    			// echo get_the_post_thumbnail($post_id, 'home-posts-med');
				    			$gif = get_field('post_gif', $post_id);
				    			if( !empty($gif) ){
				    				echo '<img class="gif" src="'.$gif['url'].'" alt="'.$gif['alt'].'">';
				    			}else if ( get_the_post_thumbnail($post_id, 'home-posts-med') ) {
				    				echo get_the_post_thumbnail($post_id, 'home-posts-med');
				    			}
				    		?>

				    		<?php if(get_post_format($post_id) === 'video'): ?>
				    		<div class="play-btn">
				    			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
				    				<polygon class="triangle" id="XMLID_18_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
				    				<circle class="circle" id="XMLID_17_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"></circle>
				    			</svg>
				    		</div>
				    		<?php endif; ?>
				    		</a>
				    	</div>

				    	<div class="entry-content">
				    		<h3 class="entry-title">
				    			<a href="<?php echo esc_url( get_permalink($post_id) ); ?>" rel="bookmark">
				    				<?php echo get_the_title($post_id); ?>
				    			</a>
				    		</h3>
				    	</div>
			    	</div>
			    </article><!-- #post-## -->
		   	</div>
		<?php
		endforeach;
		if($popular_posts) echo '</div></div>';
		?>
	</div>
</div>
<footer class="post-footer">
	<?php
		global $do_not_duplicate;

		$available_tags = array();
		$post_tags = wp_get_post_tags( get_the_ID() );
		$post_tags = json_decode(json_encode($post_tags), true);

		for ($i=0; $i < count($post_tags); $i++) { 
			$available_tags[] = $post_tags[$i]['slug'];
		}
		$available_tags = implode (",", $available_tags);

		$args = array(
			'orderby'        => 'rand',
			'posts_per_page' => '2',
			'post__not_in' => $do_not_duplicate,
			'tag' => $available_tags
		);
		$post_loop = new WP_Query($args);
		if($post_loop->have_posts() && $post_loop->found_posts > 1 && $available_tags):
	?>
	<div class="row">
		<div class="col-md-12">
			<header class="top-header">
				<span>More Like This</span>
			</header>
			<div class="row">
				<?php
				while ( $post_loop->have_posts() ) : $post_loop->the_post(); 
				// $loop_index++;
				$do_not_duplicate[] = $post_loop->post->ID;
				?>
				<?php get_template_part( 'template-parts/content-displayposts', 'large' ); ?>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-md-12">
			<header class="top-header">
				<span>WhoHaha &amp; Chill</span>
			</header>
			<div class="col-md-4 col-sm-6">
				<article class="post bottom-rest">
					<div class="entry-image">
						<a href="/ask-a-badass/">
							<img src="<?php echo get_template_directory_uri(); ?>/resources/images/post-footer/askabadass.jpg" alt="Ask A Badass">
							<div class="play-btn">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
									<polygon class="triangle" id="XMLID_18_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
									<circle class="circle" id="XMLID_17_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"></circle>
								</svg>
							</div>
						</a>
						<div class="entry-content">
							<h2 class="entry-title"><a href="/ask-a-badass/" rel="bookmark">Ask A Badass</a></h2>
						</div><!-- .entry-content -->
					</div>
				</article><!-- #post-## -->
			</div>
			<div class="col-md-4 col-sm-6">
				<article class="post bottom-rest">
					<div class="entry-image">
						<a href="/really-important-questions-really-important-answers/">
							<img src="<?php echo get_template_directory_uri(); ?>/resources/images/post-footer/reallyimportantquestions.jpg" alt="Really Important Questions">
							<div class="play-btn">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
									<polygon class="triangle" id="XMLID_18_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
									<circle class="circle" id="XMLID_17_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"></circle>
								</svg>
							</div>
						</a>
						<div class="entry-content">
							<h2 class="entry-title"><a href="/really-important-questions-really-important-answers/" rel="bookmark">Really Important Questions</a></h2>
						</div><!-- .entry-content -->
					</div>
				</article><!-- #post-## -->
			</div>
			<div class="col-md-4 col-sm-6">
				<article class="post bottom-rest">
					<div class="entry-image">
						<a href="/tv/">
							<img src="<?php echo get_template_directory_uri(); ?>/resources/images/post-footer/whohahaTV.jpg" alt="WhoHaha TV">
							<div class="play-btn">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
									<polygon class="triangle" id="XMLID_18_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
									<circle class="circle" id="XMLID_17_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"></circle>
								</svg>
							</div>
						</a>
						<div class="entry-content">
							<h2 class="entry-title"><a href="/tv/" rel="bookmark">WhoHaha TV</a></h2>
						</div><!-- .entry-content -->
					</div>
				</article><!-- #post-## -->
			</div>
		</div>
	</div>
</footer>
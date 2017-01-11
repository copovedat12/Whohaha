<!-- <header class="side-header home-author-header">
	<span>TRENDING HAHAs</span>
</header> -->
<h3 class="section-header">Trending Hahas</h3>
<?php
//try http://www.wpbeginner.com/wp-tutorials/how-to-track-popular-posts-by-views-in-wordpress-without-a-plugin/
$popular_posts = get_popular_posts_id(8, 'week');
// print_r($popular_posts);
if($popular_posts) echo '<div class="row"><div id="home-break-slides">';
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

		    		<?php if(get_post_format() === 'video') get_template_part('template-parts/play-button'); ?>
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

<hr>

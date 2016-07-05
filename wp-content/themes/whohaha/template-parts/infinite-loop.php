<?php
/**
 * Template part for displaying posts on the home page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

?>

<div class="loop-post row">
<?php
	global $do_not_duplicate;

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$display_count = 6;
	$offset = ( $paged - 1 ) * $display_count;
	// offest +2 posts so first 2 posts on home page aren't used in the loop
	$offset = $offset + 2;
	if(get_option( 'sticky_posts' )) $offset = $offset - 1;
	$homepage_loop = new WP_Query(array('paged' => $paged, 'offset' => $offset, 'post__not_in' => get_option( 'sticky_posts' ) ));
?>

<?php include(get_template_directory() . '/template-parts/infinite-loop-break.php'); ?>

<?php
	$loop_index = 0;
	while ( $homepage_loop->have_posts() ) : $homepage_loop->the_post();
	$loop_index++;
	$do_not_duplicate[] = $post->ID;

	if($loop_index === 1 || ($loop_index - 1)%6 === 0){
		echo '<div class="starting-at-'.$loop_index.'page'.$paged.'">';
	}

	// get_template_part( 'template-parts/content', get_post_format() );
	get_template_part( 'template-parts/content-displayposts', 'medium' );

	if( ($loop_index)%6 === 0 ){
		echo '</div><!-- .row -->';
	}
	endwhile; wp_reset_postdata();
?>

</div>

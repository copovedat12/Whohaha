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
	$args = array(
		'paged' => $paged,
		'offset' => $offset
	);
	// add argument depending on what archive page
	if(is_category()) $args['cat'] = get_query_var('cat');
	if(is_author()){
		// $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
		// $args['author'] = $author->ID;
		// $posts = get_field('co_authors');
		// print_r($posts);
		$args['author_name'] = get_the_author_meta( 'user_nicename', $author->ID );
	}
	if(is_tag()) $args['tag_id'] = get_query_var('tag_id');

	$post_loop = new WP_Query($args);

	$loop_index = 0;
	while ( $post_loop->have_posts() ) : $post_loop->the_post(); 
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
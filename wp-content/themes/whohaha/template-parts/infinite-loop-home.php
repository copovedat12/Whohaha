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
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$display_count = 6;
		$homepage_loop = new WP_Query(array('paged' => $paged, 'post__not_in' => get_option( 'sticky_posts' ) ));
	?>

	<?php
	/**
	 * Homepage loop breaks
	 */
	if ( $paged !== 1 && (($paged + 1) !== $homepage_loop->max_num_pages) && ($homepage_loop->max_num_pages !== 0) && $paged < 6 ):
	?>
	<div class="<?php if( $paged !== 2) echo 'break '; ?>col-md-12">
		<?php get_template_part('template-parts/loop-breaks/break-part', $paged-1); ?>
	</div>
	<?php
	endif;
	?>

	<?php
		$loop_index = 0;
		while ( $homepage_loop->have_posts() ) : $homepage_loop->the_post();
		$loop_index++;

		if($loop_index === 1 || ($loop_index - 1)%6 === 0){
			echo '<div class="starting-at-'.$loop_index.' page'.$paged.'">';
		}

		// get_template_part( 'template-parts/content', get_post_format() );
		get_template_part( 'template-parts/content-displayposts', 'medium' );

		if( ($loop_index)%6 === 0 ){
			echo '</div><!-- .row -->';
		}
		endwhile; wp_reset_postdata();
	?>
</div>

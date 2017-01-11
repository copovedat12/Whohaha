<?php
/**
 * Template part for displaying posts on the post page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

?>

<div class="col-md-4 col-sm-6">
	<article id="post-<?php the_ID(); ?>" class="post bottom-rest">
		<div class="entry-image">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php
				$gif = get_field('post_gif');
				if( !empty($gif) ){
					echo '<img class="gif" src="'.$gif['url'].'" alt="'.$gif['alt'].'">';
				}else if ( has_post_thumbnail() ) {
					the_post_thumbnail('home-posts-med');
				}
				get_template_part('template-parts/play-button');
				?>
			</a>
			<div class="entry-content">
				<div class="entry-tags">
					<?php
						$categories = get_the_category();
						$separator = ' ';
						$output = '';
						if ( ! empty( $categories ) ) {
						    foreach( $categories as $category ) {
						        $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
						    }
						    echo trim( $output, $separator );
						}
					?>
				</div>
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			</div><!-- .entry-content -->
		</div>
	</article><!-- #post-## -->
</div>
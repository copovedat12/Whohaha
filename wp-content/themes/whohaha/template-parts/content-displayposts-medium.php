<?php
/**
 * Template part for displaying posts on the home page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

?>

<div class="col-md-4 col-sm-6">
	<article id="post-<?php the_ID(); ?>" class="post bottom-rest format-<?php echo get_post_format(); ?>">
		<div class="entry-image">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
			$gif = get_field('post_gif');
			if( !empty($gif) ){
				echo '<img class="gif" src="'.$gif['url'].'" alt="'.$gif['alt'].'">';
			}else if ( has_post_thumbnail() ) {
				the_post_thumbnail('home-posts-med');
			}
			?>

			<?php if(get_post_format() === 'video'): ?>
			<div class="play-btn">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
					<polygon class="triangle" id="XMLID_18_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
					<circle class="circle" id="XMLID_17_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"></circle>
				</svg>
			</div>
			<?php endif; ?>

			<?php if(in_array(get_the_ID(), get_popular_posts_id(8, 'week'))): ?>
				<span class="glyphicon glyphicon-flash popular-post" aria-hidden="true"></span>
			<?php endif; ?>
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

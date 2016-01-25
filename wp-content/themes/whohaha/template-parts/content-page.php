<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

?>

<div class="row">
	<div class="col-md-9">
		<article id="post-<?php the_ID(); ?>" class="recommend" <?php post_class(); ?>>
			<header class="entry-header">
				<?php
				if(get_the_ID() === 1219) {
					echo '<img src="'.get_template_directory_uri().'/resources/images/WHH_SendLadies_Banner.jpg" alt="Who Fun The World?" width="" height="">';
				} else {
					the_title( '<h1 class="entry-title">', '</h1>' );
				}
				?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_content(); ?>
				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'whohaha' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
			</footer><!-- .entry-footer -->
		</article><!-- #post-## -->
	</div>
	<div class="col-md-3">
		<?php get_template_part( 'template-parts/sidebar', 'page' ); ?>
	</div>
</div>
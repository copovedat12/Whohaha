<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<header class="entry-header">
					<?php
					the_title( '<h1 class="entry-title">', '</h1>' );
					?>

					<?php if ( is_cart() && !empty(WC()->cart->cart_contents) ): ?>
					<div class="cart-checkout">
					    <?php wc_get_template( 'cart/proceed-to-checkout-button.php' ); ?>
					</div>
				<?php endif; ?>
				</header><!-- .entry-header -->
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<article id="post-<?php the_ID(); ?>" class="recommend" <?php post_class(); ?>>

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
				</div>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php // get_sidebar(); ?>
<?php get_footer(); ?>

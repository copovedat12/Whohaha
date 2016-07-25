<?php
/**
 * The template for displaying Woocommerce pages.
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

			<?php
				if( is_singular( 'product' ) ){
					woocommerce_content();
				} else{
					woocommerce_get_template( 'archive-product.php' );
				}
			?>

			<?php if (is_shop()): ?>
				<section class="shop-about">
					<header class="top-header">
						<span>About The Shop</span>
					</header>
					<div class="row">
						<div class="col-md-5">
							<img src="https://cdn.shopify.com/s/files/1/1136/0732/files/IMG_2136_5acb3fd8-c209-4a7f-8258-4858c7714b0f_grande.JPG?14900229916359214490" alt="Elizabeth Banks Rocking a Badass Tee" />
						</div>
						<div class="col-md-7">
							<h1>Some Badass Title</h1>

							<p>Cofounded by actress, director, and producer Elizabeth Banks, Whohaha is a new digital platform whose goal is to spotlight funny ladies around the world. From the girl next door that makes hilarious videos and posts them to her YouTube channel, to global celebrities that perform at concert halls for thousands of people, Whohaha is a place for all female creators to come together and distribute their content for everyone to see. The goal? Make people laugh until they pee.</p>

							<p>Do you consider yourself a funny lady? Do you like to support funny ladies? If so, <strong>we think you’re a badass</strong>. Whohaha and Elizabeth Banks have teamed up with CZND to present you with Badass Clothing. Currently, there are two products offered: the Women’s Badass Tee, and the Unisex Badass Tee. Be sure to check back regularly. Additional badass clothing and products will soon be made available.</p>
						</div>
					</div>
				</section>
			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php // get_sidebar(); ?>
<?php get_footer(); ?>

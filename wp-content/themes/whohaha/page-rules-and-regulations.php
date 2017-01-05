<?php
/**
 * Template Name: Enter Sweeps
 *
 * @package WordPress
 * @subpackage WhoHaha
 * @since whohaha
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

<?php if ( ! post_password_required( $post ) ) : ?>

<div id="primary" class="content-area">

	<main id="main" class="container site-main" role="main">

			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div>
						<?php the_content(); ?>
					</div>
				</div>
			</div>

	</main><!-- #main -->
</div><!-- #primary -->

<?php else: ?>
	
	<div id="primary" class="password-protected content-area">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<?php echo get_the_password_form(); ?>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>

<?php

get_footer();

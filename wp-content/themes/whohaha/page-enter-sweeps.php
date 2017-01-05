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

get_header('gopitchyourself'); ?>

<?php if ( ! post_password_required( $post ) ) : ?>

<div class="enter-header">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<img class="gopitchyourself" src="/wp-content/themes/whohaha/resources/images/pitchperfect/go-pitch-yourself-black.png" width="1504" height="414" alt="Go Pitch Yourself">
				
				<div class="entry-list-rules">
					<h2 class="text-center"><span>More Important Details</span></h2>
					<ul>
						<li>Participants must be at least 13 years old.</li>
						<li>Your video(s) should not be longer than 90 seconds (1 1/2 minutes) in length.</li>
						<li>You may submit up to 5 new and unique videos.</li>
						<li>Each video must be posted natively to one or more of the following social media channels: YouTube, Facebook, Twitter, Instagram, or Tumblr.</li>
						<li>Each video MUST include the campaign hashtags #GoPitchYourself and #PitchPerfect3.</li>
						<li>All participants must fill out the official submission form and include direct links to their entry(ies).</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
		<div class="container">

			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="entry-form-container">
						<?php echo do_shortcode('[contact-form-7 id="10733" title="GoPitchYourself"]'); ?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="bottom-cta text-center">
						<small>By clicking the SUBMIT button, you signify that you accept and agree to be bound by WhoHaha's Terms of Use (<a target="_blank" href="http://whohaha.com/terms-of-use">whohaha.com/terms-of-use</a>) and Privacy Policy (<a target="_blank" href="http://whohaha.com/privacy-policy/">whohaha.com/privacy-policy</a>), NBC Universal's Privacy Policy (<a target="_blank" href="http://nbcuniversal.com/privacy">nbcuniversal.com/privacy</a>), and the Challenge Official Rules and Regulations (<a target="_blank" href="http://whohaha.com/gopitchyourself/rules-and-regulations/">whohaha.com/gopitchyourself/rules-and-regulations</a>)</small>
					</div>
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

get_footer('gopitchyourself');

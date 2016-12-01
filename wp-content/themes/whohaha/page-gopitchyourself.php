<?php
/**
 * The template for displaying Pitch Perfect sweeps pages.
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

get_header('sweeps'); ?>

<div id="primary" class="content-area">
	
	<div class="pp-header">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="pp-head-banner">
						<img src="/wp-content/themes/whohaha/resources/images/pitchperfect/pitch-perfect-squad.png" width="1270" height="576" alt="Pitch Perfect Girls">
						<img class="gopitchyourself" src="/wp-content/themes/whohaha/resources/images/pitchperfect/go-pitch-yourself.png" width="1504" height="414" alt="Go Pitch Yourself">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="blackbox">
						<span class="text">WE'RE SEARCHING FOR THE NEXT BEST CONTENT CREATORS TO RECEIVE A
						ONCE-IN-A-LIFETIME TRIP TO LA TO PARTICIPATE IN AN EXCITING DIGITAL
						CONTENT LAB AND PRODUCE A PITCH PERFECT VIDEO WITH ELIZABETH BANKS!</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<main id="main" class="site-main" role="main">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<h3 class="text-center"><span>LET OUR FAVORITE FUNNY LADY ELIZABETH BANKS TELL YOU MORE</span></h3>

					<div class="video-embed">
						<iframe width="853" height="480" src="https://www.youtube.com/embed/OgPm-yaLoyo" frameborder="0" allowfullscreen></iframe>
					</div>

					<div class="row callout-boxes">
						<div class="col-md-4">
							<div class="box bg-pink match-height">
								<span>
									Are you funny?
								</span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box bg-purple match-height">
								<span>
									Are you making <br>
									the most hilarious <br>
									content for your <br>
									social channels?
								</span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box bg-blue match-height">
								<span>
									Or, <br>
									do you have <br>
									what it takes <br>
									to do so?
								</span>
							</div>
						</div>
					</div>

					<p class="callout-text text-center">
						If you answered yes to any (or all) of these questions, <br>
						<span class="large">this is the perfect opportunity for you!</span>
					</p>

					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<h4>Here's how it works</h4>
							<ul>
								<li>Create a video showing us why you deserve to be selected for a once-in-a-lifetime experience. What makes you unique and perfectly imperfect?</li>
								<li>Universal and WhoHaha will pick 5 winners to participate in a week-long social content lab in Los Angeles. There, you will attend creator workshops and be paired with a WhoHaha mentor, who will guide you in learning how to create amazing content, grow your social channels, and become a digital media badass.</li>
								<li>During the lab, the winners will also produce a video with the incomparable Elizabeth Banks that will tie into the Pitch Perfect 3 marketing campaign.</li>
								<li>Your video may also be included on the Pitch Perfect 3 Home Entertainment Blu-ray &amp; DVD Release!</li>
								<li>Winners will be notified March, 2017.</li>
							</ul>
						</div>
					</div>

					<div class="row still-stumped-header">
						<div class="col-md-8 col-md-offset-2">
							<h4>Still stumped? That's OK...</h4>
							<p class="text-center">Check out the example videos from some of our favorite WhoHaha creators below.</p>
						</div>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<div class="video-embed">
										<iframe width="853" height="480" src="https://www.youtube.com/embed/cmSbXsFE3l8" frameborder="0" allowfullscreen></iframe>
									</div>
								</div>
								<div class="col-md-6">
									<div class="video-embed">
										<iframe width="853" height="480" src="https://www.youtube.com/embed/oqCYlxcq84c" frameborder="0" allowfullscreen></iframe>
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="bottom-cta text-center">
						<a href="/gopitchyourself/enter/" class="btn btn-primary btn-large">
							Enter Here!
						</a>
						<br>
						<a class="rules" href="#rules">Official Rules and Regulations</a>
					</div>
				</div>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php

get_footer('sweeps');

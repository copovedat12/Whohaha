<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package whohaha
 */

?>

		</div><!-- #content -->

		<div id="site-search">
			<button id="close-search">
		        <span class="sr-only">Close Search</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </button>
			<?php get_search_form(); ?>
		</div>

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info container">
				<div class="footer-content-area">
					<nav class="footer-links">
						<!-- <ul>
							<?php // wp_list_pages( array( 'title_li' => false ) ); ?>
						</ul> -->
						<ul>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('About'))); ?>">About</a></li>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Contact'))); ?>">Contact</a></li>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Recommend'))); ?>">Recommend</a></li>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Terms Of Use'))); ?>">Terms Of Use</a></li>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Privacy Policy'))); ?>">Privacy Policy</a></li>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Subscribe'))); ?>">Subscribe</a></li>
						</ul>
					</nav>
					<div class="copyright">
						<div class="row">
							<div class="col-md-9">
								WhoHaha.com is for informational purposes only, and does not provide medical advice. For more information, please visit our Terms of Use.&copy; Copyright 2015. WhoHaha - All Rights Reserved. Digital Media Management
							</div>
							<div class="col-md-3 text-right logos">
								<a class="dm2-logo" href="http://digitalmediamanagement.com/"></a>
								<!-- <a class="win-logo" href="http://womensinfluencernetwork.com/"></a> -->
							</div>
						</div>
					</div>
				</div>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
		<a class="restore-body"></a>
	</div><!-- .inner-wrap -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script>
	function scrollLoop(){
		console.log('ajax loaded');
	}
	/*jQuery(document).ready(function($){
		$('aside.sidebar').hcSticky({
			top: 50
		});
	});*/
</script>

</body>
</html>

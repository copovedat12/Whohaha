<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package whohaha
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<meta name="google-site-verification" content="YLaxceYycBEBXkM_yGMEhKD0IioeOHSM_EI-nnH81pE" />
<meta name="google-site-verification" content="civVdocHhY9An9L-iLyjzsphwp45HNfxxth8V_QsOH8" />
<meta name="google-site-verification" content="o3-7wzsKZSUaDQmKen8Ytcpu3stbVRTkM3yLeGsMIh4" />
<meta name="dailymotion-domain-verification" content="dm0i69zu6gv3wixpq" />

<meta property="fb:pages" content="707649489340379" />

<script src="https://use.typekit.net/lhe1ynn.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-13198218-54', 'auto');
  ga('send', 'pageview');
</script>

<link href='https://fonts.googleapis.com/css?family=Oswald:300,700|Lato:900,400,300' rel='stylesheet' type='text/css'>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="page" class="sweepspage site">
	<div class="inner-wrap">

		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'whohaha' ); ?></a>

		<header id="sweeps" class="site-header" role="banner">
			<nav class="navbar">
				<div class="sweeps-name navbar-left">
					<?php echo get_the_title(); ?>
				</div>

				<div class="site-branding">
					<span class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="/wp-content/themes/whohaha/resources/images/whohaha_logo_small.png" alt="WhoHaha">
					</a>
					</span>
					<span>PRESENTS</span>
				</div><!-- .site-branding -->

				<ul class="nav-social nav navbar-nav navbar-right">
					<li class="icon"><a class="socicon" href="https://www.facebook.com/whohaha/" target="_blank">b</a></li>
					<li class="icon"><a class="socicon" href="http://instagram.com/whohaha/" target="_blank">x</a></li>
					<li class="icon"><a class="socicon" href="https://twitter.com/whohahadotcom/" target="_blank">a</a></li>
					<li class="icon"><a class="socicon" href="https://www.youtube.com/whohaha/?sub_confirmation=1" target="_blank">r</a></li>
					<li class="icon"><a data-toggle="modal" data-target=".snapchat-modal"><i class="fi-social-snapchat"></i></a></li>
				</ul>
			</nav>
		</header><!-- #masthead -->

		<!-- snapchat modal -->
		<div class="modal fade snapchat-modal" tabindex="-1" role="dialog" aria-labelledby="snapchatModal">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<img src="<?php echo get_template_directory_uri(); ?>/resources/images/snap_chat.png" alt="snapchat">
						<p>
							Point your Snapchat camera at this image to follow Whohaha!
						</p>
					</div>
				</div>
			</div>
		</div>

		<div id="content" class="site-content <?php echo $post->post_name; ?>">

		<?php do_action('whh_before_content'); ?>
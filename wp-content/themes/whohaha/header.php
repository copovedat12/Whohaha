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

<meta property="fb:pages" content="707649489340379" />

<script type='text/javascript'>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
  (function() {
    var gads = document.createElement('script');
    gads.async = true;
    gads.type = 'text/javascript';
    var useSSL = 'https:' == document.location.protocol;
    gads.src = (useSSL ? 'https:' : 'http:') +
      '//www.googletagservices.com/tag/js/gpt.js';
    var node = document.getElementsByTagName('script')[0];
    node.parentNode.insertBefore(gads, node);
  })();
</script>

<script type='text/javascript'>
    var gptAdSlots = [];
    googletag.cmd.push(function() {
        var mapping1 = googletag.sizeMapping().
            addSize([0, 0], [300, 250]).
            addSize([500, 400], [450, 375]).
            addSize([768, 225], [720, 225]).
            addSize([992, 300], [952, 298]).
            addSize([1300, 400], [1260, 394]).
            build();
        gptAdSlots[0] = googletag.defineSlot('/4738791/WHH_Spot_1', [1260, 394], 'div-gpt-ad-1468262599942-0').
            defineSizeMapping(mapping1).
            setCollapseEmptyDiv(true).
            addService(googletag.pubads());
        // googletag.pubads().enableSingleRequest();
        googletag.enableServices();
    });

    googletag.cmd.push(function() {
        var mapping2 = googletag.sizeMapping().
            addSize([0, 0], [300, 250]).
            addSize([500, 400], [450, 375]).
            addSize([768, 225], [720, 225]).
            addSize([992, 300], [952, 298]).
            addSize([1300, 400], [1260, 394]).
            build();
        gptAdSlots[1] = googletag.defineSlot('/4738791/WHH_Spot_2', [1260, 394], 'div-gpt-ad-1468262843164-0').
            defineSizeMapping(mapping2).
            setCollapseEmptyDiv(true).
            addService(googletag.pubads());
        // googletag.pubads().enableSingleRequest();
        googletag.enableServices();
    });

    var refreshSlots = function() {
        googletag.cmd.push(function() {
            googletag.pubads().refresh([gptAdSlots[0], gptAdSlots[1]]);
        });
    };
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-13198218-54', 'auto');
  ga('send', 'pageview');
</script>

<link href='https://fonts.googleapis.com/css?family=Oswald:300|Lato:900,400,400italic,300|Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>

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

<div id="page" class="hfeed site">
	<div class="inner-wrap">

		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'whohaha' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<div class="row">
				<div class="toggle-container">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				    </button>
				</div>
				<div class="site-branding">
					<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
				</div><!-- .site-branding -->

				<nav id="slide-navigation" class="slide-navigation vertical-nav" role="navigation">
					<div class="menu">
						<button class="navbar-toggle side visible-xs-block" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					    </button>

						<div class="generate-tags hidden-md hidden-lg">
						<?php
							if(get_nav_menu_count() === false):

								generate_rand_tags();

							else:

								$args = array(
									'menu' => 'Tag Menu',
									'container' => false,
									'items_wrap' => '<ul id="%1$s" class="category-nav">%3$s</ul>',
								);
								wp_nav_menu( $args );

							endif;
						?>
						</div>

						<ul class="pages-nav">
							<li class="page_item"><a href="/about/">About</a></li>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Contact'))); ?>">Contact</a></li>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Recommend'))); ?>">Recommend</a></li>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Terms Of Use'))); ?>">Terms of Use</a></li>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Privacy Policy'))); ?>">Privacy Policy</a></li>
							<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Subscribe'))); ?>">Subscribe</a></li>
						</ul>
					</div>
				</nav><!-- #slide-navigation -->

				<nav id="site-navigation" class="main-navigation horizontal-nav hidden-xs" role="navigation">
					<div class="menu generate-tags">
						<?php

							if(get_nav_menu_count() === false):

								generate_rand_tags();

							else:

								$args = array(
									'menu' => 'Tag Menu',
									'container' => false
								);
								wp_nav_menu( $args );

							endif;
						?>
					</div>
				</nav><!-- #site-navigation -->

				<div class="nav-social">
					<ul class="hidden-xs">
						<li class="search icon"><a href="#" onclick="event.preventDefault();"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></li>
						<li class="icon"><a class="socicon" href="https://www.facebook.com/whohaha/" target="_blank">b</a></li>
						<li class="icon"><a class="socicon" href="http://instagram.com/whohaha/" target="_blank">x</a></li>
						<li class="icon"><a class="socicon" href="https://twitter.com/whohahadotcom/" target="_blank">a</a></li>
						<li class="icon"><a class="socicon" href="https://www.youtube.com/whohaha/?sub_confirmation=1" target="_blank">r</a></li>
						<!-- <li class="icon"><a class="socicon" data-toggle="modal" data-target=".snapchat-modal">`</a></li> -->
						<li class="icon"><a data-toggle="modal" data-target=".snapchat-modal"><i class="fi-social-snapchat"></i></a></li>
					</ul>
					<div class="social-toggle">
						<a class="glyphicon glyphicon-option-vertical"></a>
					</div>
				</div>

				<div id="slide-nav-social" class="slide-nav-social">
					<ul>
						<li class="icon"><a class="socicon" href="https://www.facebook.com/whohaha/" target="_blank">b</a></li>
						<li class="icon"><a class="socicon" href="http://instagram.com/whohaha/" target="_blank">x</a></li>
						<li class="icon"><a class="socicon" href="https://twitter.com/whohahadotcom/" target="_blank">a</a></li>
						<li class="icon"><a class="socicon" href="https://www.youtube.com/whohaha/?sub_confirmation=1" target="_blank">r</a></li>
						<li class="icon"><a class="" data-toggle="modal" data-target=".snapchat-modal"><i class="fi-social-snapchat"></i></a></li>
						<!-- <li class="icon"><a class="socicon" data-toggle="modal" data-target=".snapchat-modal">`</a></li> -->
					</ul>
				</div>
			</div>
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

		<div id="content" class="site-content">

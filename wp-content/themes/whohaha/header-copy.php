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

<!-- for facebook -->
	<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
<?php if ( is_home() ): ?>
	<meta property="og:title" content="WhoHaHa.com with Elizabeth Banks"/>
	<meta property="og:description" content="<?php bloginfo( 'description' ); ?>"/>
	<meta property="og:url" content="http://whohaha.com"/>
	<meta property="og:type" content="website"/>
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/resources/images/whohaha-fb.jpg" /> <!-- still need -->
<?php elseif ( is_author() ): ?>
	<?php 
		$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
		$curauth_id = $curauth->ID;
	?>
	<meta property="og:title" content="<?php echo get_the_author_meta('display_name', $curauth_id); ?>"/>
	<meta property="og:description" content="<?php echo author_meta_info( $curauth_id )['short_desc']; ?>"/>
	<meta property="og:url" content="<?php echo get_author_posts_url( $curauth_id ); ?>"/>
	<meta property="og:type" content="website"/>
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/resources/images/whohaha-fb.jpg" />
<?php else: ?>
	<meta property="og:title" content="<?php the_title(); ?>"/>
	<meta property="og:description" content="<?php echo get_excerpt_by_id($post_id); ?>"/>
	<meta property="og:url" content="<?php the_permalink(); ?>"/>
	<meta property="og:type" content="<?php if (is_single() || is_page()) { echo "article"; } else { echo "website";} ?>"/>
	<?php
		$thumb_id = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
	?>
	<meta property="og:image" content="<?php echo $thumb_url[0]; ?>" />
	<?php global $post; $author_id=$post->post_author;$fb_url = get_field('user_fb', 'user_' . $author_id); ?>
	<meta property="article:publisher" content="<?php echo $fb_url;?>" /> <!-- still need -->
	<meta property="article:author" content="<?php echo $fb_url;?>" /> <!-- still need -->
<?php endif; ?>

<meta name="description" content="<?php bloginfo( 'description' ); ?>" />
<meta name="google-site-verification" content="YLaxceYycBEBXkM_yGMEhKD0IioeOHSM_EI-nnH81pE" />
<meta name="google-site-verification" content="civVdocHhY9An9L-iLyjzsphwp45HNfxxth8V_QsOH8" />

<link href='https://fonts.googleapis.com/css?family=Oswald:300|Lato:400,400italic,300|Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
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
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<!-- <p class="site-description"><?php //bloginfo( 'description' ); ?></p> -->
			</div><!-- .site-branding -->

			<nav id="slide-navigation" class="slide-navigation vertical-nav" role="navigation">
				<div class="menu">
					<button class="navbar-toggle side visible-xs-block" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				    </button>
					<ul class="category-nav hidden-md hidden-lg">
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/culture/">Culture</a></li>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/advice/">Advice</a></li>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/relationships/">Relationships</a></li>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/how-to/">How-To</a></li>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/food/">Food</a></li>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/lol/">LOL</a></li>
						<!-- <li class="page_item"><a href="/whohaha/category/contribute/">Contribute</a></li> -->
					</ul>
					<ul class="pages-nav">
						<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('About'))); ?>">About</a></li>
						<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Contact'))); ?>">Contact</a></li>
						<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Recommend'))); ?>">Recommend</a></li>
						<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Terms Of Use'))); ?>">Terms of Use</a></li>
						<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Privacy Policy'))); ?>">Privacy Policy</a></li>
						<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('Subscribe'))); ?>">Subscribe</a></li>
					</ul>
				</div>
			</nav><!-- #slide-navigation -->

			<nav id="site-navigation" class="main-navigation horizontal-nav hidden-xs" role="navigation">
				<div class="menu">
					<ul>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/culture/">Culture</a></li>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/advice/">Advice</a></li>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/relationships/">Relationships</a></li>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/how-to/">How-To</a></li>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/food/">Food</a></li>
						<li class="page_item"><a href="<?php echo site_url(); ?>/category/lol/">LOL</a></li>
						<!-- <li class="page_item"><a href="/whohaha/category/contribute/">Contribute</a></li> -->
					</ul>
				</div>
			</nav><!-- #site-navigation -->

			<div class="nav-social">
				<ul class="hidden-xs">
					<li class="search icon"><a href="#" onclick="event.preventDefault();"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></li>
					<li class="icon"><a class="socicon" href="https://www.facebook.com/whohaha/" target="_blank">b</a></li>
					<li class="icon"><a class="socicon" href="http://instagram.com/whohaha/" target="_blank">x</a></li>
					<li class="icon"><a class="socicon" href="https://twitter.com/whohahadotcom/" target="_blank">a</a></li>
					<li class="icon"><a class="socicon" href="https://www.youtube.com/whohaha" target="_blank">r</a></li>
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
					<li class="icon"><a class="socicon" href="https://www.youtube.com/whohaha" target="_blank">r</a></li>
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

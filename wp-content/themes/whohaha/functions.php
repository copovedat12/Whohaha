<?php
require_once(__DIR__ . '/vendor/autoload.php');

/**
 * whohaha functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package whohaha
 */

if ( ! function_exists( 'whohaha_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function whohaha_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on whohaha, use a find and replace
	 * to change 'whohaha' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'whohaha', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('home-banner-lg', 2000, 625, true);
	// add_image_size('home-posts-med', 400, 315, true);
	add_image_size('home-posts-med', 400, 320, true);
	add_image_size('home-posts-lg', 630, 400, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'whohaha' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'whohaha_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // whohaha_setup
add_action( 'after_setup_theme', 'whohaha_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function whohaha_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'whohaha_content_width', 640 );
}
add_action( 'after_setup_theme', 'whohaha_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function whohaha_scripts() {

	wp_enqueue_script( 'lodash', '//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.2/lodash.min.js', null, '4.17.12', true );

	wp_enqueue_script( 'bootstrap-js', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), '3.3.7', true );

	wp_enqueue_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'), '4.0.3', true);

	wp_enqueue_script( 'slick-js', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array('jquery'), '1.6.0', true );

	wp_enqueue_script( 'match-height', '//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js', array('jquery'), '0.7.0', true);

	wp_enqueue_script( 'fittext', '//cdnjs.cloudflare.com/ajax/libs/FitText.js/1.2.0/jquery.fittext.min.js', array('jquery'), '1.2.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.2', true );

	/*
	 * enqueue styles here
	 */

	// Remove this after 01.13.17
	// it's being loaded into the dev-styles
	// wp_enqueue_style( 'bootstrap', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css');
	wp_enqueue_style( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' );

	wp_enqueue_style( 'slick-styles', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css');

	wp_enqueue_style( 'fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css' );

	wp_enqueue_style( 'socicon', '//file.myfontastic.com/n6vo44Re5QaWo8oCKShBs7/icons.css' );

	wp_enqueue_style( 'lightbox-style', get_template_directory_uri() . '/resources/css/vendor/lightbox.min.css');

	wp_enqueue_style( 'styles', get_template_directory_uri() . '/css/style.css', array(), '1.0.0');

	wp_enqueue_style( 'whohaha-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'whohaha_scripts' );

function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

add_role( 'in_post', __('Person in Post'),
	array(
	'read' => true, // true allows this capability
	'edit_posts' => true, // Allows user to edit their own posts
	'edit_pages' => false, // Allows user to edit pages
	'edit_others_posts' => false, // Allows user to edit others posts not just their own
	'create_posts' => true, // Allows user to create new posts
	'manage_categories' => true, // Allows user to manage post categories
	'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
	'edit_themes' => false, // false denies this capability. User can’t edit your theme
	'install_plugins' => false, // User cant add new plugins
	'update_plugin' => false, // User can’t update any plugins
	'update_core' => false // user cant perform core updates
	)
);

// Meta description for posts in the header
function get_excerpt_by_id($post_id){
	$the_post = get_post($post_id); //Gets post ID
	$the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
	$excerpt_length = 35; //Sets excerpt length by word count
	$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
	$words = explode(' ', $the_excerpt, $excerpt_length + 1);
	if(count($words) > $excerpt_length) :
		array_pop($words);
		array_push($words, '…');
		$the_excerpt = implode(' ', $words);
	endif;
	return $the_excerpt;
}

// Meta description for authors in the header
function author_excerpt($id){
	$word_limit = 50; // Limit the number of words
	$authorDescriptionShort = wp_trim_words(strip_tags(get_the_author_meta('description', $id)), $word_limit);
	return $authorDescriptionShort;
}
function get_author_avatar_url($id){
	$get_avatar = get_wp_user_avatar($id);
    preg_match('/src\s*=\s*"(.+?)"/', $get_avatar, $matches);
    return $matches[1];
}
function author_meta_info($auth_id){
	$img_url = get_author_avatar_url($auth_id);
	$short_desc = author_excerpt($auth_id);
	return array(
		'img_url' => $img_url,
		'short_desc' => $short_desc
	);
}

function get_ID_by_page_name($page_name) {
   global $wpdb;
   $page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '".$page_name."' AND post_type = 'page'");
   return $page_name_id;
}

/**
 * Remove Contact Form 7 styles
 */
add_filter( 'wpcf7_load_css', '__return_false' );

/*
 * Create wp admin theme
 */
function my_admin_theme_style() {
  wp_enqueue_style( 'Global Stylesheet', get_stylesheet_directory_uri() . '/admin-style.css' );
    // wp_enqueue_style('my-admin-theme', plugins_url('wp-admin.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');

/**
 * Add Custom Meta Box functionality
 */
if( file_exists( get_template_directory() . '/cmb2/init.php' ) )
	require get_template_directory() . '/cmb2/init.php';

/**
 * Mailchimp redirect functions
 */
require get_template_directory() . '/inc/mailchimp-redirect.php';

/**
 * Implement the Hashtagram shortcode
 */
require get_template_directory() . '/inc/random-tags.php';

/**
 * Implement extra contact fields for socials
 */
require get_template_directory() . '/inc/contact-fields.php';

/**
 * Implement the video functions
 * Includes Youtube player, playlist, shortcode
 * Includes Dailymotion Player
 * Include video ajax (overlay and post rendering)
 */
require get_template_directory() . '/inc/video/yt-player.php';
require get_template_directory() . '/inc/video/dm-player.php';
require get_template_directory() . '/inc/video/video-playlist.php';
require get_template_directory() . '/inc/video/video-ajax.php';
// Heroscope page
require get_template_directory() . '/inc/video/heroscope-playlist.php';

/**
 * Implement the Custom Post Types
 */
require get_template_directory() . '/inc/post-types/front-page-people.php';
require get_template_directory() . '/inc/post-types/quiz.php';

require get_template_directory() . '/inc/options-pages.php';

/**
 * Load custom Video Post Type
 * Load custom Video Playlist taxonomy
 */
require get_template_directory() . '/inc/post-types/videos.php';
require get_template_directory() . '/inc/taxonomies/playlists.php';

/**
 * Implement the Wordpress Popular Posts functions
 */
require get_template_directory() . '/inc/wpp-custom.php';

/**
 * Customize yoast meta tag imnplementation
 */
require get_template_directory() . '/inc/yoast.php';

/**
 * Customize Instant Articles
 */
require get_template_directory() . '/inc/instant-articles.php';

/*
 * Load Woocommerce custom functions
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Make images for WHH FB Quizzes
 */
require get_template_directory() . '/inc/quiz-image.php';

/**
 * Render WhoHaha Playlist carousels
 */
require get_template_directory() . '/inc/whh-playlists.php';

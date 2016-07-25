<?php
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
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function whohaha_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'whohaha' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'whohaha_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function whohaha_scripts() {

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css');

	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/assets/javascripts/bootstrap.min.js', array('jquery'), '', true );

	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/js/slick.js', array('jquery'), '1.2.43', true );

	wp_enqueue_script( 'jquery-ias', get_template_directory_uri() . '/js/jquery-ias.min.js', array('jquery'), '', true );

	wp_enqueue_script( 'sticky-kit', get_template_directory_uri() . '/js/sticky-kit.js', array('jquery'), '', true );

	wp_enqueue_script( 'dev-scripts', get_template_directory_uri() . '/resources/js/script.js', array('bootstrap-js'), '20151001', true );

	wp_enqueue_style( 'slick-styles', get_template_directory_uri() . '/css/slick.css');

	wp_enqueue_style( 'foundation-font', get_template_directory_uri() . '/fonts/foundation-icons/foundation-icons.css');

	wp_enqueue_style( 'dev-styles', get_template_directory_uri() . '/css/style.css');

	wp_enqueue_style( 'whohaha-style', get_stylesheet_uri() );

	wp_enqueue_script( 'whohaha-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'whohaha-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
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

function get_nav_menu_count(){
	$menu_to_count = wp_nav_menu(array(
		'echo' => false,
		'menu' => 'Tag Menu'
		));
	$menu_items = substr_count($menu_to_count,'class="menu-item ');
	if($menu_items < 4){
		return false;
	}else{
		return true;
	}
}

/**
 * Mailchimp redirect functions
 */
require get_template_directory() . '/inc/mailchimp-redirect.php';

/**
 * Implement the Hashtagram shortcode
 */
require get_template_directory() . '/inc/random-tags.php';

/**
 * Implement the Hashtagram shortcode
 */
require get_template_directory() . '/inc/hashtagram.php';

/**
 * Implement the Youtube Playlist shortcode
 */
require get_template_directory() . '/inc/yt-playlist.php';
require get_template_directory() . '/inc/yt-player.php';

/**
 * Implement the Custom Post Types
 */
require get_template_directory() . '/inc/post-types.php';

/**
 * Implement the Wordpress Popular Posts functions
 */
require get_template_directory() . '/inc/wpp-custom.php';

// require get_template_directory() . '/inc/jetpack-infinite-scroll.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

require get_template_directory() . '/inc/yoast.php';

require get_template_directory() . '/inc/instant-articles.php';

/*
 * Load Woocommerce custom functions
 */
require get_template_directory() . '/inc/woocommerce.php';

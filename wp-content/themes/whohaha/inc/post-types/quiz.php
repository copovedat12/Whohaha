<?php 

function create_quiz_posttype() {
	register_post_type( 'quizzes',
		array(
			'labels' => array(
				'name' => __( 'Quizzes' ),
				'singular_name' => __( 'Quiz' )
			),
			'supports' => array('title','author','thumbnail','editor'),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'quiz'),
			'menu_icon' => 'dashicons-facebook',
			'taxonomies' => array('post_tag'),
			'exclude_from_search' => true
		)
	);
}
add_action( 'init', 'create_quiz_posttype' );

function quiz_sub_page_urls(){
  add_rewrite_tag('%quiz_sub_page%', '([^&]+)');
  add_rewrite_rule(
    'quiz/([^/]*)/([^/]*)',
    'single.php?quiz=$matches[1]&fbid=$matches[2]',
    'top'
  );
  flush_rewrite_rules();
}
add_action('init', 'quiz_sub_page_urls');

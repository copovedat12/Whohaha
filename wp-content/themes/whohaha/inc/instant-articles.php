<?php

use Facebook\InstantArticles\Elements\Interactive;

function incl_video($ia_post) {
	$instant_article = $ia_post->instant_article;
	$post_id = $ia_post->get_the_id();
	$iframe_string = get_post_meta( $post_id, 'video_embed_code', true );
	if($iframe_string){
		preg_match('/src="([^"]+)"/', $iframe_string, $match);
		$video_url = $match[1];
		$instant_article->addChild( Interactive::create()->withSource($video_url)->withWidth(640)->withHeight(390) );
	}
}

add_action( 'instant_articles_before_article_content', 'incl_video' );

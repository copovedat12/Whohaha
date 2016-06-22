<?php

use Facebook\InstantArticles\Elements\SocialEmbed;

// add_action( 'instant_articles_after_transform_post', function ($ia_post) {
//     $instant_article = $ia_post->instant_article;
//     $post_id = $ia_post->get_the_id();
//     $iframe_string = get_post_meta( $post_id, 'video_embed_code', true );
//     preg_match('/src="([^"]+)"/', $iframe_string, $match);
//     $video_url = $match[1];
//     $instant_article->addChild( SocialEmbed::create()->withSource($video_url) );
// } );

function incl_video($ia_post) {
	$instant_article = $ia_post->instant_article;
	$post_id = $ia_post->get_the_id();
	$iframe_string = get_post_meta( $post_id, 'video_embed_code', true );
	if($iframe_string){
		preg_match('/src="([^"]+)"/', $iframe_string, $match);
		$video_url = $match[1];
		$instant_article->addChild( SocialEmbed::create()->withSource($video_url) );
	}
}

// add_filter( 'instant_articles_parsed_document', 'incl_video', 1 );

add_action( 'instant_articles_before_article_content', 'incl_video' );

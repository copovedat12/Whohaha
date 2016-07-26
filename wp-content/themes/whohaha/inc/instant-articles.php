<?php

add_filter('instant_articles_content', 'add_youtube_video', 10);
function add_youtube_video($content) {
  $iframe_string = get_field('video_embed_code');
  $content = $iframe_string . $content;
  return $content;
};

<?php

function filter_wpseo_title($title){
    $check_title = check_guide_page('title');
    if ($check_title) {
        $title = $check_title;
    }
    return $title;
}
function filter_wpseo_description($description){
    $check_desc = check_guide_page('description');
    if ($check_desc) {
        $description = $check_desc;
    }
    return $description;
}
function filter_wpseo_image($image){
    $check_img = check_guide_page('image');
    if ($check_img) {
        $image = $check_img;
    }
    return $image;
}

function filter_wpseo_url($url){
    $check_img = check_guide_page('url');
    if ($check_img) {
        $url = $check_img;
    }
    return $url;
}

function check_guide_page($type){
    if (is_tag()) {
        $tag = get_queried_object();
        $uc_name = ucwords($tag->name);

        if ($type === 'title') {
            $uc_name = ucwords($tag->name);
            return $uc_name . ' Archive | WhoHaha';
        }
        if ($type === 'description') {
            $uc_name = ucwords($tag->name);
            return $uc_name . ' Archives for WhoHaha.com';
        }
        if ($type === 'image') {
            $thumb_id = get_post_thumbnail_id();
            $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);

            return $thumb_url[0];
        }
    }
    elseif (get_post_type() === 'quizzes') {
        global $wp_query;
        if ($type === 'image'){
            if ( 
                isset($wp_query->query_vars['page']) && 
                $wp_query->query_vars['page'] > 0 &&
                getimagesize(get_site_url() . '/wp-content/uploads/user-images/'.$wp_query->query_vars['quizzes'].'_'.$wp_query->query_vars['page'].'_share.png') !== false
            ) {
                return '/wp-content/uploads/user-images/'.$wp_query->query_vars['quizzes'].'_'.$wp_query->query_vars['page'].'_share.png';
            }
        }
        if ($type === 'url'){
            return get_site_url().'/quiz/'.$wp_query->query_vars['quizzes'].'/'.$wp_query->query_vars['page'].'/';
        }
    }
    // $wp_query->query_vars
}
function meta_change(){
    add_filter('wpseo_title', 'filter_wpseo_title', 10, 1);
    add_filter('wpseo_opengraph_title', 'filter_wpseo_title', 10, 1);
    add_filter('wpseo_opengraph_image', 'filter_wpseo_image', 10, 1);
    add_filter('wpseo_metadesc', 'filter_wpseo_description', 10, 1);
    add_filter('wpseo_canonical', 'filter_wpseo_url', 10, 1);
}
add_action( 'wp', 'meta_change' );

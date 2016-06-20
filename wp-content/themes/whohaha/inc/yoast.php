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
}
function meta_change(){
    add_filter('wpseo_title', 'filter_wpseo_title', 10, 1);
    add_filter('wpseo_opengraph_title', 'filter_wpseo_title', 10, 1);
    add_filter('wpseo_opengraph_image', 'filter_wpseo_image', 10, 1);
    add_filter('wpseo_metadesc', 'filter_wpseo_description', 10, 1);
}
add_action( 'wp', 'meta_change' );

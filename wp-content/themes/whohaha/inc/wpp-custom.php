<?php

function get_popular_posts_id($post_count, $time_limit = null, $offset = 0) {
    switch ($time_limit) {
        case 'day':
            $time = date("Y-m-d", strtotime("-1 day"));
            break;
        case 'week':
            $time = date("Y-m-d", strtotime("-1 week"));
            break;
        case 'month':
            $time = date("Y-m-d", strtotime("-1 month"));
            break;
        case 'year':
            $time = date("Y-m-d", strtotime("-1 year"));
            break;

        default:
            $time = date("Y-m-d", strtotime("-1 year"));
            break;
    }


    global $wpdb;
    $wpp_table = $wpdb->prefix.'popularpostssummary';
    $sql = "SELECT DISTINCT postid FROM $wpp_table as wpp
            LEFT JOIN $wpdb->posts as p
            ON wpp.postid = p.ID
            WHERE p.post_type IN ('post')
            AND wpp.view_date > '$time'
            ORDER BY wpp.pageviews DESC
            LIMIT $post_count
            OFFSET $offset";

    $query = $wpdb->get_results($sql);
    $query = json_decode(json_encode($query), true);

    $posts = array();
    for ($i=0; $i < count($query); $i++) {
        $posts[] = $query[$i][postid];
    }
    // $posts[time] = $time;
    return (array) $posts;
}

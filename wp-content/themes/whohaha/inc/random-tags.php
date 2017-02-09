<?php

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

function generate_rand_tags(){
    $tag_num = 2;
    $max_len = 13;

    global $wpdb;
    $terms = $wpdb->terms;
    $term_tax = $wpdb->term_taxonomy;

    $sql = "SELECT name,slug FROM $terms as t
            JOIN $term_tax as tt
            ON t.term_id = tt.term_id
            WHERE tt.taxonomy = 'post_tag'
            AND tt.count > 0
            AND length(t.name) <= $max_len";

    $query = $wpdb->get_results($sql);

    $tags = array();

    while (count($tags) <= ($tag_num - 1)) {
        $key = array_rand($query, 1);
        if( $max_len && !in_array($query[$key], $tags) ){
            $tags[] = $query[$key];
        }
    }

    ?>
    <ul class="wp-tag-cloud">
        <li><a id="tag-generate" href="#"><span class="reloadtags glyphicon glyphicon-refresh" aria-hidden="true"></span></a></li>
        <?php
        foreach ($tags as $tag) {
            echo "<li class='tag'><a href='".get_site_url()."/tag/".$tag->slug."'>".$tag->name."</a></li>";
        }
        ?>
        <li class="page_item"><a href="/tv/">WhoHaha TV</a></li>
        <li class="page_item shop"><a target="_blank" href="https://shop.whohaha.com">Shop</a></li>
    </ul>
    <?php
}

function generate_rand_tags_ajax(){
    generate_rand_tags();
    wp_die();
}
add_action( 'wp_ajax_generate_rand_tags_ajax', 'generate_rand_tags_ajax' );
add_action( 'wp_ajax_nopriv_generate_rand_tags_ajax', 'generate_rand_tags_ajax' );
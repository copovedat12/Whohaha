<?php

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
        <li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('TV'))); ?>">WhoHaha TV</a></li>
        <li class="page_item shop"><a href="https://cznd.co/collections/whohaha">Shop</a></li>
    </ul>
    <?php
}

function generate_rand_tags_ajax(){
    $tag_num = ($_POST['tag_num']) ? $_POST['tag_num'] : 2;
    $max_len = ($_POST['max_len']) ? $_POST['max_len'] : 13;

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
        <li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('TV'))); ?>">WhoHaha TV</a></li>
        <li class="page_item shop"><a href="https://cznd.co/collections/whohaha">Shop</a></li>
    </ul>
    <?php
    wp_die();
}
add_action( 'wp_ajax_generate_rand_tags_ajax', 'generate_rand_tags_ajax' );
add_action( 'wp_ajax_nopriv_generate_rand_tags_ajax', 'generate_rand_tags_ajax' );
<?php

function customSearchQuery($searchTerm) {
  global $wpdb;

  $query = "SELECT DISTINCT p.ID 
    FROM $wpdb->posts AS p
    LEFT JOIN $wpdb->term_relationships AS pr ON (p.ID = pr.object_id)
    LEFT JOIN $wpdb->term_taxonomy as tt ON (pr.term_taxonomy_id = tt.term_taxonomy_id)
    LEFT JOIN $wpdb->terms AS t ON (tt.term_id = t.term_id)
    WHERE p.post_status = 'publish'
    AND p.post_type = 'post'
    AND tt.taxonomy = 'post_tag'
    AND (p.post_title LIKE '%${searchTerm}%' OR t.name LIKE '%${searchTerm}%')
    GROUP BY p.ID
    ORDER BY p.post_date DESC";
  $result = $wpdb->get_results( $query );

  $idArr = array();
  foreach ($result as $post) {
    $idArr[] = $post->ID;
  }

  return $idArr;
}

function search_filter($query) {
  if ( $query->is_main_query() ) {
    if ($query->is_search) {
      global $searchQuery;
      $searchQuery = get_search_query();

      $postsArr = customSearchQuery($query->query_vars['s']);
      $query->query_vars['post__in'] = $postsArr;
      $query->query_vars['s'] = null;
    }
  }
}

add_action('pre_get_posts','search_filter');

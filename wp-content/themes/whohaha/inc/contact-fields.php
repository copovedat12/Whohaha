<?php

/**
 * Create new user contact methods
 * ex: $instagram = get_user_meta( $user_id, 'instagram', true);
 */
function new_contactmethods( $contactmethods ) {
   $contactmethods['instagram'] = 'Instagram username (without @)';
   $contactmethods['youtube'] = 'Youtube URL';
   $contactmethods['pinterest'] = 'Pinterest URL';
   unset($contactmethods['googleplus']); // Remove G+
   return $contactmethods;
}
add_filter('user_contactmethods','new_contactmethods',10,1);

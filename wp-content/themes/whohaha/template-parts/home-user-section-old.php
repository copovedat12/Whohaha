<?php
	$user_query = new WP_User_Query( array( 'role' => 'in_post' ) );
	if ( ! empty( $user_query->results ) ):
?>
<section class="homepage-authors">
	<header class="side-header home-author-header">
		<span>Funny Ladies</span>
	</header>
	<div id="home-authors-carousel">
		<?php
			// get the last element of the user array
			foreach ( $user_query->results as $user ):
		?>
			<div class="author">
				<!--<img class="headshot" src="<?php //echo get_wp_user_avatar_src( $user->ID ); ?>" alt="">-->
				<a href="<?php echo get_author_posts_url( $user->ID ); ?>">
				<?php // echo get_wp_user_avatar($user->ID, 142); ?>
				<?php $profile_image = get_field('profile_image', 'user_'.$user->ID); ?>
				<img src="<?php echo $profile_image['sizes']['thumbnail']; ?>" width="<?php echo $profile_image['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $profile_image['sizes'][ 'thumbnail-height' ]; ?>">
				</a>
				<a class="author-name" href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php echo $user->display_name; ?> </a>
			</div>

		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>
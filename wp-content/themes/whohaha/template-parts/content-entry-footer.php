<?php
$authors = get_coauthors();
if($authors[1] !== null || have_rows('things_in_post')):
?>

<footer class="entry-footer">
	<div class="people-in-video">
		<header class="top-header">
			<?php if ( has_post_format( 'video' )): ?>
			<span>In This Video</span>
			<?php else: ?>
			<span>In This Post</span>
			<?php endif; ?>
		</header>

		<div class="row">
			<div class="in-post-carousel">
			<?php
			/*
			 * Check For Co-Authors
			 */
			if($authors[1] !== null):
				foreach ($authors as $key => $author) : if($key >= 1):
				$user_id = $author->data->ID;
				?>
				<div class="post-person">
					<a href="<?php echo get_author_posts_url( $user_id ); ?>">
					<?php $profile_image = get_field('profile_image', 'user_'.$user_id); ?>
					<img src="<?php echo $profile_image['sizes']['thumbnail']; ?>" width="<?php echo $profile_image['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $profile_image['sizes'][ 'thumbnail-height' ]; ?>">
					</a>
					<a href="<?php echo get_author_posts_url( $user_id ); ?>" class="author-name"><?php echo $author->data->display_name; ?></a>
				</div>
				<?php
				endif; endforeach;
			endif;

			/*
			 * Check For Post Items
			 */
			if( have_rows('things_in_post') ):
			    while ( have_rows('things_in_post') ) : the_row();
			    $thingImg = get_sub_field('thing_image');
			    $thingName = get_sub_field('thing_name');
			    $thingLink = get_sub_field('thing_link');
				?>
				<div class="post-item">
					<a target="_blank" href="<?php echo $thingLink; ?>">
					<img src="<?php echo $thingImg['sizes']['thumbnail']; ?>" width="<?php echo $thingImg['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $thingImg['sizes'][ 'thumbnail-height' ]; ?>">
					</a>
					<a href="<?php echo $thingLink; ?>" class="author-name"><?php echo $thingName; ?></a>
				</div>
				<?php
			    endwhile;
			endif;
			?>
			</div>
		</div>
	</div>
</footer><!-- .entry-footer -->

<?php
endif;
?>
<footer class="entry-footer">
	<div class="people-in-video">
		<header class="top-header">
			<?php if ( has_post_format( 'video' )): ?>
			<span>In This Video</span>
			<?php else: ?>
			<span>In This Post</span>
			<?php endif; ?>
		</header>
		<?php

		$authors = get_coauthors();

		if($authors[1] !== null):
			echo '<div class="row">';
			foreach ($authors as $key => $author) :
				// echo $key.'<br>';
				// print_r($author->data);
				// echo "<br>";
				$user_id = $author->data->ID;
				if($key >= 1):
			?>
			<div class="col-xs-3 post-person">
				<a href="<?php echo get_author_posts_url( $user_id ); ?>">
				<?php $profile_image = get_field('profile_image', 'user_'.$user_id); ?>
				<img src="<?php echo $profile_image['sizes']['thumbnail']; ?>" width="<?php echo $profile_image['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $profile_image['sizes'][ 'thumbnail-height' ]; ?>">
				</a>
				<span class="author-name"><?php echo $author->data->display_name; ?></span>
			</div>
			<?php
				endif;
			endforeach;
			echo '</div><!-- /.row -->';
		else :
		    if ( has_post_format( 'video' )){
		    	echo '<div class="no-people-found">No people found in this video</div>';
		    } else{
		    	echo '<div class="no-people-found">No people found in this post</div>';
		    }
		endif;

		if( have_rows('things_in_post') ):
		 	// loop through the rows of data
		 	echo '<div class="row">';
		    while ( have_rows('things_in_post') ) : the_row();
		    // $post_image = get_sub_field('person_image');
		    $thingImg = get_sub_field('thing_image');

		?>
			<div class="col-xs-3 post-person">
				<a href="<?php ?>">
				<img src="<?php echo $thingImg['sizes']['thumbnail']; ?>" width="<?php echo $thingImg['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $thingImg['sizes'][ 'thumbnail-height' ]; ?>">
				</a>
				<span class="author-name"><?php ?></span>
			</div>
		<?php
		    endwhile;
			echo '</div><!-- /.row -->';
		endif;
		?>
	</div>
</footer><!-- .entry-footer -->
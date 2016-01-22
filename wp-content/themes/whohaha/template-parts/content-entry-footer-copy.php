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

		// check if the repeater field has rows of data
		if( have_rows('people_in_post') ):
		 	// loop through the rows of data
		 	echo '<div class="row">';
		    while ( have_rows('people_in_post') ) : the_row();
		    // $post_image = get_sub_field('person_image');
		    $user_id = get_sub_field('person');
		    if ($user_id):
		    $user_id = $user_id['ID'];

		    $person = get_user_by( 'id', $user_id );
		?>
			<div class="col-xs-3 post-person">
				<a href="<?php echo get_author_posts_url( $user_id ); ?>">
				<?php $profile_image = get_field('profile_image', 'user_'.$user_id); ?>
				<img src="<?php echo $profile_image['sizes']['thumbnail']; ?>" width="<?php echo $profile_image['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $profile_image['sizes'][ 'thumbnail-height' ]; ?>">
				</a>
				<span class="author-name"><?php echo $person->display_name; ?></span>
			</div>
		<?php
			endif;
		    endwhile;
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
	<?php /* <div class="author-of-post">
		<header class="top-header">
			<span>Author</span>
		</header>
		<div class="row">
			<div class="col-sm-12 post-author-container">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php $author_image = get_field('profile_image', 'user_'.get_the_author_id()); ?>
					<img src="<?php echo $author_image['sizes']['thumbnail']; ?>" width="<?php echo $author_image['sizes'][ 'thumbnail-width' ]; ?>" height="<?php echo $author_image['sizes'][ 'thumbnail-height' ]; ?>">
				</a>
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author-name"><?php echo get_the_author(); ?></a>
			</div>
		</div>
	</div> */ ?>
</footer><!-- .entry-footer -->
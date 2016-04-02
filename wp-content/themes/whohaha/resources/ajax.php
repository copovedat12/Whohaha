<?php
	require_once( dirname( __DIR__ ).'../../../../wp-load.php' );

	$tags = generate_rand_tags(3, 13);
	?>
	<ul class="wp-tag-cloud">
		<li><a id="tag-generate" href="?rand"><span class="reloadtags glyphicon glyphicon-refresh" aria-hidden="true"></span></a></li>
		<?php
		foreach ($tags as $tag) {
			echo "<li class='tag'><a href='".get_site_url()."/tag/".$tag->slug."'>".$tag->name."</a></li>";
		}
		?>
		<li class="page_item"><a href="<?php echo esc_url(get_permalink(get_ID_by_page_name('TV'))); ?>">WhoHaha TV</a></li>
	</ul>

<?php
	require_once( dirname( __DIR__ ).'../../../../wp-load.php' );

	$tags = generate_rand_tags(4, 13);
	?>
	<ul class="wp-tag-cloud">
		<?php
		foreach ($tags as $tag) {
			echo "<li class='tag'><a href='".get_site_url()."/tag/".$tag->slug."'>".$tag->name."</a></li>";
		}
		?>
		<li><a id="tag-generate" href="?rand"><span class="reloadtags glyphicon glyphicon-refresh" aria-hidden="true"></span></a></li>
	</ul>

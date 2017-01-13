<section class="whh-playlists">
	<header class="top-header home-author-header">
		<span>WhoHaha &amp; Chill</span>
	</header>
	<?php
	whh_render_all_series();
	whh_render_single_series([ 'limit' => 1, 'shuffle' => true ]);
	?>
</section>

<div class="row">
	<div class="col-md-12">
		<?php get_template_part('template-parts/funny-ladies'); ?>
	</div>
</div>
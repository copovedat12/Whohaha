<?php if( $paged !== 1 && (($paged + 1) !== $homepage_loop->max_num_pages) && ($homepage_loop->max_num_pages !== 0) && $paged < 6 ): ?>

	<?php if( $paged === 2): ?>
		<div class="break first col-md-12">
			<?php get_template_part('template-parts/loop-breaks/break', 'part-1'); ?>
		</div>
	<?php else: ?>
		<div class="break col-md-12">
			<?php get_template_part('template-parts/loop-breaks/break', 'part-'.($paged-1)); ?>
		</div>
	<?php endif; ?>

<?php endif; ?>
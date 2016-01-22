<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package whohaha
 */

get_header(); ?>

	<?php $hashtag = get_field('hashtag'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container category" role="main">
			<header class="page-header top-header">
				<span>#<?php echo $hashtag; ?></span>
			</header><!-- .page-header -->

			<?php
			$returned_content = get_hashtagram_data('http://hashtagram.cznd.co/approved.php?q='.$hashtag);
			?>
			<div class="instagram-showcase">
				<div class="row">
					<?php
						$images = json_decode($returned_content, true);
						foreach ($images as $image):
					?>
					<div class="item col-md-3 col-sm-6">
						<div class="image">
							<div class="user">
								<a href="http://instagram.com/<?php echo $image['usr_name'] ?>"><img src="<?php echo $image['usr_img'] ?>"></a>
							</div>
							<a target="_blank" href="<?php echo $image['instagram_url'] ?>"><img src="<?php echo $image['img_url'] ?>"></a>
						</div>
					</div>
					<?php
						endforeach;
					?>
				</div>
			</div>

		<?php
			get_template_part( 'template-parts/content', 'archive-footer' );
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>

<?php
	$pageTitle = get_the_title();
	$pageUrl = urlencode(get_permalink());
	$pageThumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
?>

<a class="social-link facebook" onclick="javascript:socialShare.share(this, 'facebook', 600, 600);return false;" href="https://www.facebook.com/sharer/sharer.php?s=100&u=<?php echo $pageUrl ?>/">
	<span class="socicon socicon-facebook"></span>
	<span class="text">share</span>
</a>
<a class="social-link twitter" onclick="javascript:socialShare.share(this, 'twitter', 550, 450);return false;" data-pagetitle="<?php echo $pageTitle ?>" href="http://twitter.com/intent/tweet?status=<?php echo $pageTitle ?>+<?php echo $pageUrl ?>">
	<span class="socicon socicon-twitter"></span>
	<span class="text">tweet</span>
</a>
<a class="social-link pinterest" onclick="javascript:socialShare.share(this, 'pinterest', 750, 600);return false;" data-pagetitle="<?php echo $pageTitle ?>" data-thumbnail="<?php echo $pageThumb[0] ?>" href="http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $pageThumb[0] ?>&url=<?php echo $pageUrl ?>&is_video=false&description=<?php echo $pageTitle ?>">
	<span class="socicon socicon-pinterest"></span>
	<span class="text">pinterest</span>
</a>

<?php
	$pageTitle = get_the_title();
	$pageUrl = urlencode(get_permalink());
	$pageThumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
?>
<!-- http://petragregorova.com/articles/social-share-buttons-with-custom-icons/ -->

<a class="social-link facebook" onclick="javascript:socialShare(this.href, 600, 600);return false;" href="https://www.facebook.com/sharer/sharer.php?s=100&u=<?php echo $pageUrl ?>/">
	<span class="socicon">b</span>
	<span class="text">share</span>
</a><!-- https://www.facebook.com/sharer/sharer.php?s=100&p[url]=http%3A%2F%2Fthehautemess.com%2F11-things-to-do-this-fall%2F%3Ffb_ref%3D3e2ab7ee3ce749ae983f0a5271c2622c-Facebook&s=100 -->
<a class="social-link twitter" onclick="javascript:socialShare(this.href, 550, 450);return false;" href="http://twitter.com/intent/tweet?status=<?php echo $pageTitle ?>+<?php echo $pageUrl ?>">
	<span class="socicon">a</span>
	<span class="text">tweet</span>
</a>
<a class="social-link pinterest" onclick="javascript:socialShare(this.href, 750, 600);return false;" href="http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $pageThumb[0] ?>&url=<?php echo $pageUrl ?>&is_video=false&description=<?php echo $pageTitle ?>">
	<span class="socicon">d</span>
	<span class="text">pinterest</span>
</a>

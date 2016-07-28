<?php
// First Things First...
add_theme_support( 'woocommerce' );

// And put everything in here to make sure nothing breaks
if( class_exists( 'WooCommerce' ) ):

// Disable woocommerce styles
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/*
 * Remove Woocommerce html wrapper
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/*
 * Edit actions for archive pages
 */
add_filter( 'woocommerce_show_page_title', false );
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15);

/*
 * Edit actions for product pages
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

/*
 * Edit cart actions
 */
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10);

/*
 * Replace add to cart button on archive pages
 */
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action( 'woocommerce_after_shop_loop_item', 'replace_add_to_cart', 10 );
function replace_add_to_cart() {
	global $product;
	$link = $product->get_permalink();
	if($product->is_in_stock()){
		echo do_shortcode('<a href="'.$link.'" class="btn btn-primary add_to_cart_button">GET IT</a>');
	} else {
		echo do_shortcode('<a href="'.$link.'" class="btn btn-primary disabled add_to_cart_button">Out of Stock</a>');
	}
}

add_action('whh_before_end_navigation', 'shop_navigation', 20);
function shop_navigation(){
	if(is_woocommerce()||is_cart()||is_checkout()||is_account_page()){
		?>
		<div id="shop-nav">
			<div class="left-sec">
				<ul>
					<li><a href="#">FAQ's</a></li>
					<li><a href="/my-account">My Account</a></li>
				</ul>
			</div>
			<div class="right-sec">
				<div class="cart">
					<?php if(is_cart()): ?>
						<a href="/shop">
							<span class="glyphicon glyphicon-shopping-cart"></span>
							<small>Back to Shop</small>
						</a>
					<?php else: ?>
						<a class="cart-contents" href="<?php echo (!empty(WC()->cart->cart_contents)) ? '/cart' : '/shop'; ?>">
							<span class="glyphicon glyphicon-shopping-cart"></span>
							<?php if(!empty(WC()->cart->cart_contents)): ?>
							<?php echo WC()->cart->get_cart_contents_count(); ?>
							<?php endif; ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}

add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo (!empty(WC()->cart->cart_contents)) ? '/cart' : '/shop'; ?>">
		<span class="glyphicon glyphicon-shopping-cart"></span>
		<?php if(!empty(WC()->cart->cart_contents)): ?>
		<?php echo WC()->cart->get_cart_contents_count(); ?>
		<?php endif; ?>
	</a>
	<?php
	$fragments['a.cart-contents'] = ob_get_clean();
	return $fragments;
}

/*
 * Add shop banner
 */
add_action('whh_before_content', 'add_shop_banner', 20);
function add_shop_banner(){
	if (is_shop()) {
		?>
		<section class="shop-banner">
			<a href="/shop">
				<img src="<?php echo get_template_directory_uri() ?>/resources/images/shop/badass-banner.jpg" alt="Shop Banner">
			</a>
		</section>
		<?php
	}
}

endif;

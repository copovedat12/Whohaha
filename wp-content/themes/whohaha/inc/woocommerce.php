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

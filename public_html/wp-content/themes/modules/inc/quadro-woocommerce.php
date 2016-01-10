<?php
/** 
 * WooCommerce Support Helper Functions
 */


// Modifies WooCommerce Shop Single image size
function quadro_wc_single_image( $size ){
	$size['width'] = '700';
	$size['height'] = '9999';
	$size['crop'] = false;
	return $size;
}
add_filter( 'woocommerce_get_image_size_shop_single', 'quadro_wc_single_image' );

// Modifies WooCommerce Shop Catalog image size
function quadro_wc_shop_image( $size ){
	$size['width'] = '700';
	$size['height'] = '700';
	$size['crop'] = true;
	return $size;
}
add_filter( 'woocommerce_get_image_size_shop_catalog', 'quadro_wc_shop_image' );

// Modifies WooCommerce Shop Thumbnail image size
function quadro_wc_thumb_image( $size ){
	$size['width'] = '120';
	$size['height'] = '120';
	$size['crop'] = true;
	return $size;
}
add_filter( 'woocommerce_get_image_size_shop_thumbnail', 'quadro_wc_thumb_image' );


// Modifies the basic wrapper to fit the theme
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'quadro_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'quadro_woocommerce_wrapper_end', 10);
function quadro_woocommerce_wrapper_start() {
	echo '<main id="main" class="site-main" role="main">';
		quadro_woocommerce_page_header();
		echo '<div class="page-wrapper clear">';
			echo '<div id="primary" class="content-area">';
				echo '<div class="page-content">';
}
function quadro_woocommerce_wrapper_end() {
				echo '</div><!-- .page-content -->';
			echo '</div><!-- #primary -->';
			quadro_woocommerce_sidebar();
		echo '</div><!-- .page-wrapper -->';
	echo '</main>';
}


// Removes breadcrumbs
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Removes Default Sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);


// Adds Sidebar selected in the "Shop" page according to Sidebar WooCommerce
// Options in the theme
// add_action('woocommerce_sidebar', 'quadro_woocommerce_sidebar', 10);
function quadro_woocommerce_sidebar() {
	global $quadro_options;
	// Return early if we don't want the sidebar here
	if ( $quadro_options['woo_sidebar'] == 'none' ) return;
	// Retrieve Sidebar Option
	$page_id = get_option('woocommerce_shop_page_id');
	$page_sidebar = esc_attr( get_post_meta( $page_id, 'quadro_page_sidebar', true ) );
	$page_sidebar = $page_sidebar != '' ? $page_sidebar : 'main-sidebar';
	?>

	<div id="secondary" class="widget-area woo-sidebar" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( $page_sidebar ) ) : ?>
			<aside class="help">
				<p><?php esc_html_e('Would like to activate some Widgets?', 'quadro'); ?>
				<br /><?php esc_html_e('Go to Appearance > Widgets. Just like that!', 'quadro'); ?></p>
			</aside>
		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
	<?php
}


// Remove page title. We'll add it by our own
add_filter('woocommerce_show_page_title', 'quadro_woocommerce_page_title');
function quadro_woocommerce_page_title() {
	if ( is_shop() )
		return false;
}


// Add user input text before login/register form
add_action( 'woocommerce_before_customer_login_form', 'quadro_woo_login_msg' );
function quadro_woo_login_msg() {
	if ( get_option( 'woocommerce_enable_myaccount_registration' ) == 'yes' ) {
		global $quadro_options;
		if ( $quadro_options['woo_login_text'] != '' )
			echo '<div class="login-text">' . esc_attr( $quadro_options['woo_login_text'] ) . '</div>';
	}
}


// Add user input text before login/register form
add_action( 'woocommerce_before_my_account', 'quadro_woo_account_msg' );
function quadro_woo_account_msg() {
	global $quadro_options;
	if ( $quadro_options['woo_account_text'] != '' )
		echo '<div class="account-text">' . esc_attr( $quadro_options['woo_account_text'] ) . '</div>';
}


// Adjust number of items per page
add_filter( 'loop_shop_per_page', 'quadro_woo_loop_nmbr', 20 );
function quadro_woo_loop_nmbr() {
	global $cols, $quadro_options;
	if ( $quadro_options['woo_loop_number'] != '' ) {
		return esc_attr( $quadro_options['woo_loop_number'] );
	}
}


/*
 * Return a new number of maximum columns for shop archives
 */
add_filter( 'loop_shop_columns', 'quadro_shop_columns', 1, 10 );
function quadro_shop_columns( $number_columns ) {
	global $quadro_options;
	return esc_attr( $quadro_options['woo_loop_columns'] );
}


/**
 * Change number of related products on product page
 * to user setting and products per row to 4.
 */ 
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary', 'quadro_output_related_products', 20 );
function quadro_output_related_products() {
	global $quadro_options;
	$related_nmbr = $quadro_options['woo_related_number'] != '' ? esc_attr( $quadro_options['woo_related_number'] ) : 4;
	$args = array( 
		'posts_per_page' => $related_nmbr,
		'columns' => 4
	);
	woocommerce_related_products($args);
}

 
/**
 * Set the number of cross sells displayed at Check Out page to a maximum of 4
 */
add_filter( 'woocommerce_cross_sells_total', 'quadro_woo_cross_items', 10, 1 );
function quadro_woo_cross_items( $limit ) {
	return 4;
}


/**
 * Removes Cross Sells from Cart Collaterals
 * (it'll be added on the cart.php template)
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );


/**
 * Changes the number of columns for thumbnails on single product pages
 */
add_filter( 'woocommerce_product_thumbnails_columns', 'quadro_woo_thumb_columns');
function quadro_woo_thumb_columns( $number ){
	return 5;
}


/**
 * Applies Header Styles to Shop & Products Pages
 */
// add_action('woocommerce_before_main_content', 'quadro_woocommerce_page_header', 30);
function quadro_woocommerce_page_header() {
	$page_id = get_option('woocommerce_shop_page_id');

	// Get Page metadata
	$hide_header 		= esc_attr( get_post_meta( $page_id, 'quadro_page_header_hide', true ) );
	if ( $hide_header != 'true' ) {
		$header_pos 	= esc_attr( get_post_meta( $page_id, 'quadro_page_header_pos', true ) );
		$header_size 	= esc_attr( get_post_meta( $page_id, 'quadro_page_header_size', true ) );
		$use_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_show_tagline', true ) );
		$page_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_tagline', true ) );
		$back_color     = esc_attr( get_post_meta( $page_id, 'quadro_page_header_back_color', true ) );
		$header_use_pic	= get_post_meta( $page_id, 'quadro_page_header_back_usepic', true );
	}
	?>

	<?php if ( $hide_header != 'true' ) { ?>
	<header class="page-header <?php echo $header_pos; ?>-header <?php echo $header_size; ?>-header">
		<div class="page-inner-header">
			<h1 class="page-title">
				<?php if ( !is_product_category() ) woocommerce_page_title(); ?>
				<?php // Add Category to Header Title
				if ( is_product_category() ) {
					$shop_id = get_option('woocommerce_shop_page_id');
					echo get_the_title( $shop_id );
				} ?>
			</h1>
			<?php if ( $use_tagline == 'true' ) { ?>
				<?php if ( !is_product_category() ) { ?>
					<h2 class="page-tagline"><?php echo $page_tagline; ?></h2>
				<?php } else { ?>
					<h2 class="page-tagline"><?php woocommerce_page_title(); ?></h2>
				<?php } ?>
			<?php } ?>
			<?php quadro_breadcrumbs(); ?>
		</div>
	</header><!-- .page-header -->
	<?php } ?>
	
	<?php
}


// add_action('woocommerce_after_main_content', 'quadro_woocommerce_page_footer', 1);
// function quadro_woocommerce_page_footer() {
// 	echo '</div><!-- .page-content -->';
// 	echo '</div><!-- .page-wrapper -->';
// }


/**
 * Refreshes the top Cart wrapper every time a product is added to the Cart.
 */
function quadro_woocomerce_header_cart_refresh( $fragments ) {
	global $woocommerce, $quadro_options;

	if ( $quadro_options['header_cart'] == 'show' ) {

	ob_start();

	?><li>
		<div class="header-cart">
			<?php if( !$woocommerce->cart->cart_contents_count ) { ?>
				<a class="header-cart-link" href="<?php echo esc_url( get_permalink( get_option('woocommerce_cart_page_id') ) ); ?>">
					<i class="fa fa-shopping-cart"></i>
				</a>
				<div class="cart-contents">
					<div class="cart-inner clear">
						<p class="cart-empty-msg"><?php esc_html_e('You have no items in your cart.', 'quadro') ?></p>
					</div>
				</div>
			<?php } else { ?>
				<a class="header-cart-link header-cart-link-active" href="<?php echo esc_url( get_permalink( get_option('woocommerce_cart_page_id') ) ); ?>"><i class="fa fa-shopping-cart"></i><span class="header-cart-qy"><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>
				<div class="cart-contents">
					<div class="cart-inner clear">
						<ul class="clear">
							<?php foreach( $woocommerce->cart->cart_contents as $cart_item ): ?>
								<li class="cart-content">
									<a href="<?php echo esc_url( get_permalink( $cart_item['product_id'] ) ); ?>">
									<?php echo get_the_post_thumbnail( $cart_item['product_id'], 'thumbnail' ); ?>
									<div class="product-details">
										<span class="product-title"><?php echo $cart_item['data']->post->post_title; ?></span>
										<span class="product-quantity"><?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']); ?></span>
									</div>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
						<div class="cart-total">
							<p><?php echo esc_html__('Cart Subtotal ', 'quadro') . '<span>' . $woocommerce->cart->get_cart_total() . '</span>'; ?></p>
						</div>
						<div class="cart-actions">
							<div class="cart-link"><a href="<?php echo esc_url( get_permalink( get_option('woocommerce_cart_page_id') ) ); ?>" title="<?php esc_html_e('View Cart', 'quadro'); ?>" class="cart-link-a"><?php esc_html_e('View Cart', 'quadro'); ?></a></div>
							<div class="checkout-link"><a href="<?php echo esc_url( get_permalink( get_option('woocommerce_checkout_page_id') ) ); ?>" title="<?php esc_html_e('Checkout', 'quadro'); ?>" class="qbtn"><?php esc_html_e('Checkout', 'quadro'); ?></a></div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</li><?php

	// Bring it all back to the element
	$fragments['#masthead .header-cart'] = ob_get_clean();

	// Output it
	return $fragments;

	} // End if Show Cart in header conditional

}
add_filter('add_to_cart_fragments', 'quadro_woocomerce_header_cart_refresh');


/**
 * Prints My Cart Icon on the header
 */
function quadro_header_cart() {
	
	global $woocommerce, $quadro_options;
	
	if ( $quadro_options['header_cart'] == 'show' ) {
	
	?><li>
		<div class="header-cart">
			<?php if( !$woocommerce->cart->cart_contents_count ) { ?>
				<a class="header-cart-link" href="<?php echo esc_url( get_permalink( get_option('woocommerce_cart_page_id') ) ); ?>">
					<i class="fa fa-shopping-cart"></i>
				</a>
				<div class="cart-contents">
					<div class="cart-inner clear">
						<p class="cart-empty-msg"><?php esc_html_e('You have no items in your cart.', 'quadro') ?></p>
					</div>
				</div>
			<?php } else { ?>
				<a class="header-cart-link header-cart-link-active" href="<?php echo esc_url( get_permalink( get_option('woocommerce_cart_page_id') ) ); ?>"><i class="fa fa-shopping-cart"></i><span class="header-cart-qy"><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>
				<div class="cart-contents">
					<div class="cart-inner clear">
						<ul class="clear">
							<?php foreach($woocommerce->cart->cart_contents as $cart_item): ?>
								<li class="cart-content">
									<a href="<?php echo esc_url( get_permalink( $cart_item['product_id'] ) ); ?>">
										<?php echo get_the_post_thumbnail( $cart_item['product_id'], 'thumbnail' ); ?>
										<div class="product-details">
											<span class="product-title"><?php echo $cart_item['data']->post->post_title; ?></span>
											<span class="product-quantity"><?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']); ?></span>
										</div>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
						<div class="cart-total">
							<p><?php echo esc_html__('Cart Subtotal ', 'quadro') . '<span>' . $woocommerce->cart->get_cart_total() . '</span>'; ?></p>
						</div>
						<div class="cart-actions">
							<div class="cart-link"><a href="<?php echo esc_url( get_permalink( get_option('woocommerce_cart_page_id') ) ); ?>" title="<?php esc_html_e('View Cart', 'quadro'); ?>" class="cart-link-a"><?php esc_html_e('View Cart', 'quadro'); ?></a></div>
							<div class="checkout-link"><a href="<?php echo esc_url( get_permalink( get_option('woocommerce_checkout_page_id') ) ); ?>" title="<?php esc_html_e('Checkout', 'quadro'); ?>" class="qbtn"><?php esc_html_e('Checkout', 'quadro'); ?></a></div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</li><?php 

	} // End if Show Cart in header conditional
}

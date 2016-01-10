<?php
/**
 * The Header for our theme.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php // Retrieve Theme Options
global $quadro_options;
$quadro_options = quadro_get_options(); ?>

<?php if ( $quadro_options['favicon_img'] ) { ?>
<link rel="shortcut icon" href="<?php echo esc_url( $quadro_options['favicon_img'] ); ?>">
<?php } ?>

<?php // Get ID (with conditional for WooCommerce shop)
$page_id = class_exists( 'Woocommerce' ) && is_shop() ? get_option('woocommerce_shop_page_id') : get_the_id();

// Bring Header & Layout Options
$site_layout 	= esc_attr( $quadro_options['site_layout'] );
$header_layout 	= esc_attr( $quadro_options['header_layout'] );
$header_height 	= esc_attr( $quadro_options['header_height'] );
$perpage_header = esc_attr( get_post_meta( $page_id, 'quadro_site_header_style', true ) );
$header_style 	= ($perpage_header != '' && $perpage_header != 'same') ? $perpage_header : esc_attr( $quadro_options['header_transp'] );
$sticky_header 	= ($header_layout != 'header-layout7' && $header_layout != 'header-layout17') ? esc_attr( $quadro_options['sticky_menu'] ) : 'not-sticky';
$perpage_color 	= esc_attr( get_post_meta( $page_id, 'quadro_site_header_color', true ) );
$transp_color 	= ($perpage_color != '' && $perpage_color != 'same' && $header_layout != 'header-layout7' ) ? $perpage_color : esc_attr( $quadro_options['transp_header_color'] );
$show_search 	= esc_attr( $quadro_options['search_header_display'] );
$show_sidebar	= esc_attr( $quadro_options['single_sidebar'] );

if ( is_search() || is_archive() || is_home() ) {
	$sidebar_pos = esc_attr( $quadro_options['blog_sidebar_pos'] );
}
elseif ( is_single() ) {
	$sidebar_pos = is_single() ? esc_attr( $quadro_options['single_sidebar_pos'] ) : 'none';
}
else {
	$sidebar_pos = 'none';
}

$hide_header_class = '';
?>

<?php wp_head(); ?>
</head>

<body <?php body_class('site-' . $site_layout . ' ' . $header_style . '-header ' . $header_layout . ' ' . $header_height . '-header ' . $transp_color . '-header ' . $sticky_header . '-header ' . $show_sidebar . '-' . $sidebar_pos . ' woo-sidebar-' . $quadro_options['woo_sidebar'] . ' woo-cols' . $quadro_options['woo_loop_columns']); ?>>

<?php if ( is_page() ) {
	// Apply function for inline styles
	quadro_page_styles( $page_id ); 
	// Check for Hidden Header class
	$hide_header 		= esc_attr( get_post_meta( $page_id, 'quadro_page_header_hide', true ) );
	$hide_header_class 	= $hide_header == 'true' ? ' header-hide' : '';
} ?>

<?php if ( class_exists( 'Woocommerce' ) && ( is_woocommerce() ) ) {
	// Apply function for inline styles of WooCommerce special pages
	// using the selected Shop page options
	quadro_page_styles( get_option('woocommerce_shop_page_id') ); 
} ?>

<div id="page" class="hfeed site">

	<header id="masthead" class="site-header <?php echo $show_search; ?>-search" role="banner">

		<div class="header-1st-row">
			<div class="inner-header">
				<?php qi_header_1st_row_left(); ?>
				<?php qi_header_1st_row_center(); ?>
				<?php qi_header_1st_row_right(); ?>
			</div>
		</div>

		<div class="header-2nd-row">
			<div class="inner-header">
				<?php qi_header_2nd_row_left(); ?>
				<?php qi_header_2nd_row_center(); ?>
				<?php qi_header_2nd_row_right(); ?>
			</div>
		</div>

		<?php // Print Topper Widget Area if enabled
		quadro_widget_area( 'widgetized_header_display', 'widgt_header_layout', 'topper-header', 'header-sidebar', false ); ?>
	
	</header><!-- #masthead -->

	<div id="content" class="site-content <?php echo $hide_header_class; ?>">

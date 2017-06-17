<?php
/**
 * The Header for our theme.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-53F54FR');</script>
<!-- End Google Tag Manager -->
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_bloginfo('template_directory');?>/images/icons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_bloginfo('template_directory');?>/images/icons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_bloginfo('template_directory');?>/images/icons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_bloginfo('template_directory');?>/images/icons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_bloginfo('template_directory');?>/images/icons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_bloginfo('template_directory');?>/images/icons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_bloginfo('template_directory');?>/images/icons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_bloginfo('template_directory');?>/images/icons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_bloginfo('template_directory');?>/images/icons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_bloginfo('template_directory');?>/images/icons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_bloginfo('template_directory');?>/images/icons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_bloginfo('template_directory');?>/images/icons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_bloginfo('template_directory');?>/images/icons/favicon-16x16.png">
<link rel="manifest" href="<?php echo get_bloginfo('template_directory');?>/images/icons/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo get_bloginfo('template_directory');?>/images/icons/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

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

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-53F54FR"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	
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

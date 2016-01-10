<?php 
/**
 * This file defines available hooks and filters to be used across the theme, 
 * and creates functions for firing them.
 * 
 * You can attach a function to a hook by calling:
 * 
 * add_action( 'hook_name', 'your_function_name', optional_priority_number );
 * 
 */


/**
 * Post Hooks
 */

// Before Post Title (with argument for ad placement)
function qi_before_post_title() {
	do_action( 'qi_before_post_title', 'pretitle' );
}

// After Post Title (with argument for ad placement)
function qi_after_post_title() {
	do_action( 'qi_after_post_title', 'posttitle' );
}

// Before Post Content (with argument for ad placement)
function qi_before_post() {
	do_action( 'qi_before_post', 'precontent' );
}

// After Post Content (with argument for ad placement)
function qi_after_post() {
	do_action( 'qi_after_post', 'postcontent' );
}


/**
 * Header Hooks
 */

// Header 1st Row - Left Position
function qi_header_1st_row_left() {
	echo '<div class="header-left">';
	do_action( 'qi_header_1st_row_left' );
	echo '</div>';
}

// Header 1st Row - Center Position
function qi_header_1st_row_center() {
	echo '<div class="header-center">';
	do_action( 'qi_header_1st_row_center' );
	echo '</div>';
}

// Header 1st Row - Right Position
function qi_header_1st_row_right() {
	echo '<div class="header-right">';
	do_action( 'qi_header_1st_row_right' );
	echo '</div>';
}

// Header 2nd Row - Left Position
function qi_header_2nd_row_left() {
	echo '<div class="header-left">';
	do_action( 'qi_header_2nd_row_left' );
	echo '</div>';
}

// Header 2nd Row - Center Position
function qi_header_2nd_row_center() {
	echo '<div class="header-center">';
	do_action( 'qi_header_2nd_row_center' );
	echo '</div>';
}

// Header 2nd Row - Right Position
function qi_header_2nd_row_right() {
	echo '<div class="header-right">';
	do_action( 'qi_header_2nd_row_right' );
	echo '</div>';
}

// Print Header Extras (WooCommerce Cart, Login Link, etc.)
// Priorities for inside actions should be
// defined between 2 & 9998 including those two.
function qi_header_extras() {
	do_action( 'qi_header_extras' );
}


/**
 * Portfolio Hooks
 */

// Before Portfolio Item Header
function qi_before_portf_item_header() {
	do_action( 'qi_before_portf_item_header' );
}

// After Portfolio Item Header
function qi_after_portf_item_header() {
	do_action( 'qi_after_portf_item_header' );
}


/**
 * Available filters
 */

// 'qi_filter_available_modules' 
// (/inc/custom-field-definition.php)

// 'qi_filter_cfields_definition' -> Filters common custom fields, including modules style
// (/inc/custom-field-definition.php)

// 'qi_filter_cfields_mods_definition' -> Filters only module specific custom fields
// (/inc/custom-field-definition.php)

// 'qi_portf_title'
// (module-portfolio.php)

// 'qi_filter_portf_item_content'
// (/inc/theme-functions.php)

// 'qi_filter_portf_item_media'
// (/inc/theme-functions.php)

// 'qi_filter_portf_item_fields'
// (/inc/theme-functions.php)

// 'get_the_archive_title'
// (/inc/qi-framework/template-tags.php)
 
// 'option' + theme_options_group
// Native WP filter for theme options. Look for Theme Options 
// Group variable name in functions.php ($quadro_options_group).
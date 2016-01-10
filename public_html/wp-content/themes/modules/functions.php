<?php
/**
 * quadro functions and definitions
 *
 * @package quadro
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 740; /* pixels */
}

// Define Template Directory URI & Template Directory
$template_directory_uri = get_template_directory_uri();
$template_directory = get_template_directory();

if ( ! function_exists( 'quadro_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function quadro_setup() {

	global $template_directory;

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on quadro, use a find and replace
	 * to change 'quadro' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'quadro', $template_directory . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for title-tag
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'quadro-sq-thumb', 700, 700, true );
	add_image_size( 'quadro-med-thumb', 700, 507, true );
	add_image_size( 'quadro-med-full-thumb', 700, 9999, false );
	add_image_size( 'quadro-full-thumb', 1400, 9999, false );


	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'quadro' ),
		'user' => esc_html__( 'User/Login Menu', 'quadro' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'status', 'gallery', 'image', 'audio', 'video', 'quote', 'link' ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );

	/**
	 * Enable WooCommerce Support
	 */
	add_theme_support( 'woocommerce' );

}
endif; // quadro_setup
add_action( 'after_setup_theme', 'quadro_setup' );


/**
 * Including Animation Definitions
 */
require( $template_directory . '/inc/animation-definitions.php' );


/**
 * Including required files (ADMIN ONLY)
 */
if ( is_admin() ) {

	// Including Custom Fields definition
	require( $template_directory . '/inc/custom-fields-definition.php' );
	
	// Include Demo Content Available Packs
	require( get_template_directory() . '/inc/dcontent_available.php' );

}


/**
 * Including Theme Options definition
 */
require( $template_directory . '/inc/options-definition.php' );


/**
 * Declare variables for QI Framework
 */

// Theme Options Group
$quadro_options_group = 'quadro_modules_options';

if ( is_admin() ) { 
	// Available Patterns Quantity (change this variable if new patterns are incorporated)
	$patterns_qty = 34;
	// Dashboard Helpers (on/off)
	$dashboard_helpers = true;
	// Theme's Slug (internal use only)
	$theme_slug = 'modules';
	// Theme's Docs URL
	$docs_url = '//quadroideas.com/docs/Modules_Documentation.html';
	// Theme Support URL
	$support_url = 'http://quadroideas.com/support/theme/modules-wp-theme';
}


/**
 * Including QuadroIdeas Framework
 */
require( $template_directory . '/inc/qi-framework/qi-framework.php' );


/**
 * Register widgetized areas.
 */
function quadro_widgets_init() {
	
	// Retrieve Theme Options
	$quadro_options = quadro_get_options();

	register_sidebar( array(
		'name' 			=> esc_html__( 'Sidebar', 'quadro' ),
		'id' 			=> 'main-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	// Create Header Widgetized Area
	if ( $quadro_options['widgetized_header_display'] == 'show' ) {
		if ( $quadro_options['widgt_header_layout'] == 'widg-layout1' ) { $i = 4; }
		else if ( $quadro_options['widgt_header_layout'] == 'widg-layout2' || $quadro_options['widgt_header_layout'] == 'widg-layout3' || $quadro_options['widgt_header_layout'] == 'widg-layout4' ) { $i = 3; }
		else if ( $quadro_options['widgt_header_layout'] === 'widg-layout5' ) { $i = 2; }
		else if ( $quadro_options['widgt_header_layout'] == 'widg-layout6' ) { $i = 1; }

		for ($j = 1; $j <= $i ; $j++) {
			
			register_sidebar(array(
				'name' => 'Header Column ' . $j,
				'id' => 'header-sidebar' . $j,
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
				'after_widget' 		=> '</aside>',
				'before_title'  	=> '<h1 class="widget-title">',
				'after_title'   	=> '</h1>',
			));
			
		} // end for
	}

	// Create Footer Widgets Area
	if ( $quadro_options['widgetized_footer_layout'] == 'widg-layout1' ) { $i = 4; }
	else if ( $quadro_options['widgetized_footer_layout'] == 'widg-layout2' || $quadro_options['widgetized_footer_layout'] == 'widg-layout3' || $quadro_options['widgetized_footer_layout'] == 'widg-layout4' ) { $i = 3; }
	else if ( $quadro_options['widgetized_footer_layout'] === 'widg-layout5' ) { $i = 2; }
	else if ( $quadro_options['widgetized_footer_layout'] == 'widg-layout6' ) { $i = 1; }

	for ($j = 1; $j <= $i ; $j++) {
		
		register_sidebar(array(
			'name' => 'Footer Column ' . $j,
			'id' => 'footer-sidebar' . $j,
			'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
			'after_widget' 		=> '</aside>',
			'before_title'  	=> '<h1 class="widget-title">',
			'after_title'   	=> '</h1>',
		));
		
	} // end for

	// Create User Added Sidebars
	if ( is_array($quadro_options['quadro_sidebars']) ) {
		foreach( $quadro_options['quadro_sidebars'] as $user_sidebar ) {
			
			// Skip iteration if there's no name for this sidebar
			if ( $user_sidebar['name'] == '' ) continue;

			register_sidebar(array(
				'name' => esc_attr($user_sidebar['name']),
				'id' => esc_attr($user_sidebar['slug']),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  	=> '</aside>',
				'before_title'  	=> '<h1 class="widget-title">',
				'after_title'   	=> '</h1>',
			));
			
		} // end for
	}

}
add_action( 'widgets_init', 'quadro_widgets_init' );


/**
 * Enqueue scripts and styles
 */
function quadro_scripts() {

	global $quadro_options, $template_directory_uri;
	
	wp_enqueue_style( 'quadro-style', get_stylesheet_uri() );

	wp_enqueue_script( 'quadro-skip-link-focus-fix', $template_directory_uri . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'jquery-masonry', array( 'jquery' ) );

	wp_enqueue_script('quadroscripts', $template_directory_uri . '/js/scripts.js', 'jquery', '', true);

	wp_enqueue_script('animOnScroll', $template_directory_uri . '/js/animOnScroll.js', 'jquery', '', true);

	/**
	 * Define Ajax Url for non logged requests
	 */
	wp_localize_script( 'quadroscripts', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	// Include Woocommerce Styles if plugin activated
	if ( class_exists( 'Woocommerce' ) ) {
		// Check for 2.3 version (major update) in order to provide backwards compatibility
		global $woocommerce;
		if ( ! is_object( $woocommerce ) || version_compare( $woocommerce->version, '2.3', '>=' ) ) {
			wp_register_style( 'woocommerce-styles', $template_directory_uri . '/inc/woocommerce-styles.css', array(), '' );	
		} else {
			wp_register_style( 'woocommerce-styles', $template_directory_uri . '/inc/woocommerce-styles-pre23.css', array(), '' );	
		}
		wp_enqueue_style( 'woocommerce-styles' );
	}

	// Site Origin Page Builder **Theme Specific** Styles
	if( function_exists( 'siteorigin_panels_activate' ) ) {
		wp_enqueue_style( 'quadro-page-builder-specific', $template_directory_uri . '/inc/page-builder-specific-styles.css' );
	}

	// Call Retina.js if Retina option enabled
	if ( $quadro_options['retina_enable'] == true ) {
		wp_enqueue_script('retina', $template_directory_uri . '/js/retina.js', 'jquery', '', true);
	}

	// Call animate.css
	wp_enqueue_style( 'animate-styles', $template_directory_uri . '/inc/animate.min.css', array(), '' );

	// Call Responsive Panel Navigation CSS
  	wp_enqueue_style( 'plugin-styles', $template_directory_uri . '/inc/jquery.mmenu.css', array(), '' );

}
add_action( 'wp_enqueue_scripts', 'quadro_scripts' );


/**
 * Include Polyfills for IE8
 */
function quadro_ie8_polyfills() {
	global $template_directory_uri;
	wp_enqueue_script('html5shiv', $template_directory_uri . '/js/html5shiv.js', 'jquery', '', false);
	wp_enqueue_script('selectivizr', $template_directory_uri . '/js/selectivizr-min.js', 'jquery', '', false);
}
if ( !preg_match('/(?i)msie [5-8]/',$_SERVER['HTTP_USER_AGENT']) ) {
    add_action( 'wp_enqueue_scripts', 'quadro_ie8_polyfills' );
}


/**
 * Enqueue admin extra styles (theme based only)
 */
function quadro_admin_styles() {
	global $template_directory_uri;
	wp_enqueue_style('adminstyles', $template_directory_uri . '/inc/back-styles.css', '');
}
add_action( 'admin_enqueue_scripts', 'quadro_admin_styles' );


/**
 * Including Quadro Custom Post Types
 */
require( $template_directory . '/inc/custom-post-types.php' );


/**
 * Including Theme Specific Functions
 */
require( $template_directory . '/inc/theme-functions.php' );


/**
 * Including Quadro Widgets
 */
require( $template_directory . '/inc/quadro-widgets.php' );


/**
 * Including Page Builder Layouts
 */
require( $template_directory . '/inc/page-builder-layouts.php' );


/** 
 * Including WooCommerce Support Helper Functions
 */
// Check for WooCommerce first
if ( class_exists( 'Woocommerce' ) ) {
	require( $template_directory . '/inc/quadro-woocommerce.php' );
}


/**
 * Adds the WordPress Ajax Library to frontend.
 */
function quadro_add_ajax_library() { 
	$html = '<script type="text/javascript">';
		$html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"';
	$html .= '</script>';
 
	echo $html;
}
add_action( 'wp_head', 'quadro_add_ajax_library' );


// Adds gallery shortcode defaults for size
function quadro_gallery_atts( $out, $pairs, $atts ) {

	$atts = shortcode_atts( array(
			'size' => 'quadro-med-thumb',
		), $atts );

	$out['size'] = $atts['size'];
	return $out;

}
add_filter( 'shortcode_atts_gallery', 'quadro_gallery_atts', 10, 3 );


/**
 * Adds browser class to body
 */
add_filter('body_class','quadro_browser_body_class');
function quadro_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_IE) $classes[] = 'ie';
	elseif($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}


/**
 * Register the required plugins for this theme.
 *
 * Thanks to https://github.com/thomasgriffin/TGM-Plugin-Activation for
 * this awesome class!
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
add_action( 'tgmpa_register', 'quadro_register_required_plugins' );
function quadro_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Nayma Portfolio
		array(
			'name'     				=> 'Quadro Ideas - Portfolio Type',
			'slug'     				=> 'quadro-portfolio',
			'source'   				=> get_stylesheet_directory() . '/inc/plugins/quadro-portfolio.zip',
			'required' 				=> true,
			'version' 				=> '1.0.0',
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'description'			=> esc_html__('This plugin enables the Portfolio custom post type that we use to create Portoflio Items.', 'quadro'),
		),

		// SiteOrigin Page Builder
		array(
			'name'					=> 'Page Builder by SiteOrigin',
			'slug'					=> 'siteorigin-panels',
			'required'				=> false,
			'version'				=> '1.5.3',
			'description'			=> esc_html__('Build page layouts using the widgets you know and love using this simple drag and drop page builder.', 'quadro'),
		),

		// SiteOrigin Widgets Bundle
		array(
			'name'					=> 'SiteOrigin Widgets Bundle',
			'slug'					=> 'so-widgets-bundle',
			'required'				=> false,
			'version'				=> '1.4.2',
			'description'			=> esc_html__('A collection of widgets to be used together with Page Builder plugin.', 'quadro'),
		),

		// Responsive Lightbox
		array(
			'name'					=> 'Responsive Lightbox',
			'slug'					=> 'responsive-lightbox',
			'required'				=> false,
			'version'				=> '1.5.7',
			'description'			=> esc_html__('Responsive Lightbox allows users to view larger versions of images and galleries in a lightbox (overlay) effect optimized for mobile devices.', 'quadro'),
		),

		// CF Mega Menus
		array(
			'name'					=> 'CF Mega Menus',
			'slug'					=> 'wp-mega-menus-master',
			'source'				=> 'https://github.com/crowdfavorite/wp-mega-menus/archive/1.0.1.zip',
			'required'				=> false,
			'version'				=> '1.0.1',
			'description'			=> esc_html__('Mega Menus plugin lets you create visual enhanced submenus with "post style" content.', 'quadro'),
		),

		// Crelly Slider
		array(
			'name'					=> 'Crelly Slider',
			'slug'					=> 'crelly-slider',
			'required'				=> false,
			'version'				=> '0.7.0', // we're not requiring any specific version yet
			'description'			=> esc_html__('Crelly Slider is a Free / Open Source WordPress slider with a powerful Drag & Drop Builder. You can add Texts and Images using animations and transitions. It&#39;s perfect to display your creative content in posts and pages. With it&#39;s tons of features, Crelly Slider is the best free solution for your online WebSite.', 'quadro'),
		),

	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'quadro';

	/**
	 * Array of configuration settings.
	 */
	$config = array(
		'domain'       		=> 'quadro',         			// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'getting-started', 			// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '', 							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> esc_html__( 'Required Plugins Area (Install/Update)', 'quadro' ),
			'menu_title'                       			=> esc_html__( 'Install Required Plugins', 'quadro' ),
			'installing'                       			=> esc_html__( 'Installing Plugin: %s', 'quadro' ),
			'oops'                             			=> esc_html__( 'Something went wrong with the plugin API.', 'quadro' ),
			'notice_can_install_required'     			=> _n_noop( wp_get_theme() . ' requires the following plugin: %1$s.', wp_get_theme() . ' requires the following plugins: %1$s.', 'quadro' ),
			'notice_can_install_recommended'			=> _n_noop( wp_get_theme() . ' recommends the following plugin: %1$s.', wp_get_theme() . ' recommends the following plugins: %1$s.', 'quadro' ),
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'quadro' ),
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'quadro' ),
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'quadro' ),
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'quadro' ),
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.<br /> Please, update them one by one if you are on Multisite to prevent any errors.', 'quadro' ),
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'quadro' ),
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'quadro' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'quadro' ),
			'return'                           			=> esc_html__( 'Return to Required Plugins Installer', 'quadro' ),
			'plugin_activated'                 			=> esc_html__( 'Plugin activated successfully.', 'quadro' ),
			'complete' 									=> esc_html__( 'All plugins installed and activated successfully. %s', 'quadro' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}
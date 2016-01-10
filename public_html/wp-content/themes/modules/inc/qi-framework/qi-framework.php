<?php

/**
 * This file handles the loading of the QuadroIdeas Framework
 * that powers the theme.
 * 
 * The following variables need to be set up from the theme itself:
 * 
 * $patterns_qty 		- Sets the available background patterns quantity
 * $theme_slug			- Sets theme slug, for internal use only
 * $docs_url 			- Sets the URL for this theme's docs
 * $support_url			- Sets theme support URL for internal links
 * $dcontent_file		- Sets demo content file name if it'll be use for demo content import
 * $dcontent_settings	- Sets demo settings file name if it'll be use for demo content import
 * $dcontent_widgets	- Sets demo widgets file name if it'll be use for demo content import
 * $dcontent_plugins	- Sets joined plugins array to be used for demo content import
 * $dcontent_reading	- Sets Reading Settings option to be used for demo content import
 * $dcontent_front		- Sets Reading Settings Front Page option to be used for demo content import
 * $dcontent_posts		- Sets Reading Settings Posts Page option to be used for demo content import
 */

// Define Template Directory URI & Template Directory
$template_directory_uri = get_template_directory_uri();
$template_directory = get_template_directory();

/*-----------------------------------------------------------------------------------*/
/*	Including Framework Files
/*-----------------------------------------------------------------------------------*/

/**
 * Custom Hooks
 */
require( $template_directory . '/inc/qi-framework/hooks.php' );

/**
 * Get Quadro Options file
 */
require( $template_directory . '/inc/qi-framework/options.php' );

/**
 * Custom functions that act independently of the theme templates.
 */
require( $template_directory . '/inc/qi-framework/extras.php' );

/**
 * Custom template tags for the theme.
 */
require( $template_directory . '/inc/qi-framework/template-tags.php' );

/**
 * Functions for Transient Fragment Caching
 */
require( $template_directory . '/inc/qi-framework/transient-cache.php' );


/*-----------------------------------------------------------------------------------*/
/*	Including Framework Backend Files
/*-----------------------------------------------------------------------------------*/

// Load for ADMIN ONLY
if ( is_admin() ) {

	/**
	 * Including Quadro Theme Welcoming Message (ADMIN ONLY)
	 */
	// require( $template_directory . '/inc/qi-framework/welcome-msg.php' );

	/**
	 * Including Quadro Custom Fields functions (ADMIN ONLY)
	 */
	require( $template_directory . '/inc/qi-framework/custom-fields-functions.php' );

	/**
	 * Including Quadro Modules management functions (ADMIN ONLY)
	 */
	require( $template_directory . '/inc/qi-framework/modules-admin.php' );

	/**
	 * Including Quadro Dashboard Helper (ADMIN ONLY)
	 */
	global $dashboard_helpers;
	if ( $dashboard_helpers == true )
		require( $template_directory . '/inc/qi-framework/dashboard-helper.php' );
	
	/**
	 * Including Theme Update Checker (ADMIN ONLY)
	 */
	require( $template_directory . '/inc/qi-framework/update.php' );

	/**
	 * Load TGM Plugin Activation Class
	 */
	function tgm_setup() {
		require( get_template_directory() . '/inc/qi-framework/class-tgm-plugin-activation.php');
	}
	add_action( 'after_setup_theme', 'tgm_setup' );

	/**
	 * Load Getting Started Helper
	 */
	require( $template_directory . '/inc/qi-framework/gs-helper.php' );

}


/**
 * Include Icon Fonts definition (ADMIN ONLY)
 */
function qi_load_font_defs() {
	global $quadro_options;
	// we add backwards compatibility in case the option isn't defined
	if ( !isset($quadro_options['icon_font']) || $quadro_options['icon_font'] == 'font-awesome' ) {
		require( get_template_directory() . '/inc/qi-framework/font-awesome-list.php' );
	} else {
		require( get_template_directory() . '/inc/qi-framework/e-icons-list.php' );
	}
}
add_action( 'admin_init', 'qi_load_font_defs' );


/*-----------------------------------------------------------------------------------*/
/*	Enqueuing Frontend and Backend Scripts
/*-----------------------------------------------------------------------------------*/

/**
 * Enqueue scripts and styles
 */
function qi_scripts() {

	global $template_directory_uri, $quadro_options;
	
	// Call Icon fonts
	if ( !isset($quadro_options['icon_font']) || $quadro_options['icon_font'] == 'font-awesome' ) {
		wp_enqueue_style( 'quadro-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '' );
	} else {
		wp_enqueue_style( 'quadro-e-icons', $template_directory_uri . '/inc/qi-framework/fonts/eicons/e-icons.css' );
	}

}
add_action( 'wp_enqueue_scripts', 'qi_scripts' );


/**
 * Enqueue admin scripts and styles
 */
function qi_admin_scripts() {

	global $template_directory_uri, $quadro_options;

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-sortable' );

	wp_register_script( 'adminscripts', $template_directory_uri . '/inc/qi-framework/js/admin-scripts.js', 'jquery', '', true );
	wp_localize_script( 'adminscripts', 'adminscripts_localized',
		array(
			'mediaTitle'	=> esc_html__( 'Upload or choose a Media File', 'quadro' ),
			'mediaButton'	=> esc_html__( 'Choose File', 'quadro' ),
			'backToTop'		=> esc_html__( 'Back to Top', 'quadro' ),
			'importFail'	=> esc_html__( 'There was an error with the import. Please try to import it directly from the xml file located in your theme folder.', 'quadro' ),
			'portfTransientsRefreshed'	=> esc_html__( 'Portfolio transients successfully refreshed.', 'quadro' ),
			'addThisModule'	=> esc_html__( 'Add this Module to a Page', 'quadro' ),
			'dupThisModule'	=> esc_html__( 'Duplicate this Module', 'quadro' ),
			'publishFirst'	=> esc_html__( 'Please publish this module first.', 'quadro' ),
			'importConfirm'	=> esc_html__( 'Click OK to import demo content to your WordPress install. Several WordPress options and all your theme options will be replaced!', 'quadro' ),
			'importPlugins'	=> esc_html__( '** Also, it is recommended to install the plugins being used on the pack before importing the content. Click cancel now to check that first.', 'quadro' ),
			'importSuccess'	=> esc_html__( 'Demo content successfully imported. Page needs to be refreshed.', 'quadro' ),
			'visualEditorNotice'	=> esc_html__( 'Save or Update this page to reload Visual Editor on this item.', 'quadro' ),
			// Variables for Posts Picker (edit & view)
			'generalEditLink'	=> get_edit_post_link( '', '' ),
			'generalPostLink'	=> get_site_url() . '/?p=',
			'includes_url'		=> includes_url(),
		)
	);
	wp_enqueue_script( 'adminscripts' );

	wp_enqueue_style( 'qi-framework-styles', $template_directory_uri . '/inc/qi-framework/framework-styles.css', '' );

	wp_enqueue_style( 'thickbox' );
	wp_enqueue_script( 'thickbox' );

	// Enqueue New Media Manager
	wp_enqueue_media();

	// Call Icon fonts
	wp_enqueue_style( 'quadro-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '' );

	// Call Elegant Icons if selected
	if ( isset($quadro_options['icon_font']) && $quadro_options['icon_font'] == 'e-icons' )
		wp_enqueue_style( 'quadro-e-icons', $template_directory_uri . '/inc/qi-framework/fonts/eicons/e-icons.css' );

}
add_action( 'admin_enqueue_scripts', 'qi_admin_scripts' );


/*-----------------------------------------------------------------------------------*/
/*	Enabling ColorPicker Script through Farbtastic
/*-----------------------------------------------------------------------------------*/

function quadro_page_cpicker_scripts() {
	wp_enqueue_script( 'farbtastic' );
}

function quadro_page_cpicker_styles() {
	wp_enqueue_style('farbtastic');
}

add_action( 'admin_print_scripts', 'quadro_page_cpicker_scripts' );
add_action( 'admin_print_styles', 'quadro_page_cpicker_styles' );


/*-----------------------------------------------------------------------------------*/
/*	Retina uploading & resizing functions
/*  http://wp.tutsplus.com/tutorials/theme-development/ensuring-your-theme-has-retina-support
/*-----------------------------------------------------------------------------------*/

if ( $quadro_options['retina_enable'] == true ) {

	add_filter( 'wp_generate_attachment_metadata', 'quadro_retina_support_attachment_meta', 10, 2 );
	/**
	 * Retina images
	 * 
	 * This function is attached to the 'wp_generate_attachment_metadata' filter hook.
	 */
	function quadro_retina_support_attachment_meta( $metadata, $attachment_id ) {
		foreach ( $metadata as $key => $value ) {
			if ( is_array( $value ) ) {
				foreach ( $value as $image => $attr ) {
					if ( is_array( $attr ) )
						quadro_retina_support_create_images( get_attached_file( $attachment_id ), $attr['width'], $attr['height'], true );
				}
			}
		}
	 
		return $metadata;
	}

	/**
	 * Create retina-ready images
	 *
	 * Referenced via quadro_retina_support_attachment_meta().
	 */
	function quadro_retina_support_create_images( $file, $width, $height, $crop = false ) {
		if ( $width || $height ) {
			$resized_file = wp_get_image_editor( $file );
			if ( ! is_wp_error( $resized_file ) ) {
				$filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x' );
	 
				$resized_file->resize( $width * 2, $height * 2, $crop );
				$resized_file->save( $filename );
	 
				$info = $resized_file->get_size();
	 
				return array(
					'file' => wp_basename( $filename ),
					'width' => $info['width'],
					'height' => $info['height'],
				);
			}
		}
		return false;
	}

	add_filter( 'delete_attachment', 'quadro_delete_retina_support_images' );
	/**
	 * Delete retina-ready images
	 *
	 * This function is attached to the 'delete_attachment' filter hook.
	 */
	function quadro_delete_retina_support_images( $attachment_id ) {
		$meta = wp_get_attachment_metadata( $attachment_id );
		if ( $meta ) {
			$upload_dir = wp_upload_dir();
			$path = pathinfo( $meta['file'] );
			foreach ( $meta as $key => $value ) {
				if ( 'sizes' === $key ) {
					foreach ( $value as $sizes => $size ) {
						$original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
						$retina_filename = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
						if ( file_exists( $retina_filename ) )
							unlink( $retina_filename );
					}
				}
			}
		}
	}

} // End if Retina Option Enabled


/*-----------------------------------------------------------------------------------*/
/*	Adding supported plugins features
/*-----------------------------------------------------------------------------------*/

function quadro_plugins_support() {

	global $template_directory_uri;
	
	// Site Origin Page Builder Styles
	if( function_exists( 'siteorigin_panels_activate' ) ) {
		wp_enqueue_style( 'quadro-page-builder', $template_directory_uri . '/inc/qi-framework/plugins/page-builder-styles.css' );
	}

	// Crelly Slider Styles
	if( class_exists( 'CrellySliderCommon' ) ) {
		wp_enqueue_style( 'quadro-crelly-slider', $template_directory_uri . '/inc/qi-framework/plugins/crelly-slider-styles.css' );
	}

}
add_action( 'wp_enqueue_scripts', 'quadro_plugins_support' );


/*-----------------------------------------------------------------------------------*/
/*	Miscelaneous
/*-----------------------------------------------------------------------------------*/


// to add defer to loading of scripts - use defer to keep loading order
if ( ! function_exists( 'qi_script_tag_defer' ) ) :
function qi_script_tag_defer( $tag, $handle ) {
	if ( is_admin() ) {
		return $tag;
	}
	if ( strpos($tag, 'jquery.js') || strpos($tag, 'webfont.js') || strpos($tag, 'googleapis.com/maps') ) {
	// if ( strpos($tag, 'jquery.js') ) {
		return $tag;
	}
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.') !==false ) {
		return $tag;
	}
	else {
		return str_replace(' src',' defer src', $tag);
	}
}
endif; // if !function_exists
add_filter( 'script_loader_tag', 'qi_script_tag_defer', 10, 2 );
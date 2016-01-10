<?php

/**
 * Quadro Theme Option Parameters
 * 
 * Array that holds parameters for all options for
 * the theme. The 'type' key is used to generate
 * the proper form field markup and to sanitize
 * the user-input data properly. The 'tab' key
 * determines the Settings Page on which the
 * option appears, and the 'section' tab determines
 * the section of the Settings Page tab in which
 * the option appears.
 * 
 * @return	array	$options	array of arrays of option parameters
 */
if ( ! function_exists( 'quadro_get_option_parameters' ) ) :
function quadro_get_option_parameters() {

	$options = array(
		/**
		 * General Tab Options
		 */
		// Branding Section
		'logo_type' => array(
			'name' => 'logo_type',
			'title' => esc_html__( 'Logo Type', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'image' => array(
					'name' => 'logo',
					'title' => esc_html__( 'Logo Image', 'quadro' )
				),
				'title' => array(
					'name' => 'title',
					'title' => esc_html__( 'Title', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'branding',
			'tab' => 'general',
			'default' => 'title'
		),
		'logo_img' => array(
			'name' => 'logo_img',
			'title' => esc_html__( 'Logo Image File', 'quadro' ),
			'type' => 'upload',
			'description' => esc_html__('Note: Logo img should be 60px height minimum. Keep in mind that that is the maximum height the logo will have and the theme will resize it proportionally to fit into that.', 'quadro'),
			'section' => 'branding',
			'tab' => 'general',
			'default' => ''
		),
		'logo_img_retina' => array(
			'name' => 'logo_img_retina',
			'title' => esc_html__( 'Logo Image File for Retina', 'quadro' ),
			'type' => 'upload',
			'description' => esc_html__('Twice as bigger, for retina screens', 'quadro'),
			'section' => 'branding',
			'tab' => 'general',
			'default' => ''
		),
		'about_text' => array(
			'name' => 'about_text',
			'title' => esc_html__( 'About Text', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => esc_html__( 'This will appear next to your logo/name on the site\'s header.', 'quadro' ),
			'section' => 'branding',
			'tab' => 'general',
			'default' => 'This is a short description about this site.',
		),
		'favicon_img' => array(
			'name' => 'favicon_img',
			'title' => esc_html__( 'Favicon Image File', 'quadro' ),
			'type' => 'upload',
			'description' => '',
			'section' => 'branding',
			'tab' => 'general',
			'default' => ''
		),
		'custom_login_img' => array(
			'name' => 'custom_login_img',
			'title' => esc_html__( 'Custom Login Image File', 'quadro' ),
			'type' => 'upload',
			'description' => '',
			'section' => 'branding',
			'tab' => 'general',
			'default' => ''
		),
		'custom_login_img_retina' => array(
			'name' => 'custom_login_img_retina',
			'title' => esc_html__( 'Custom Login Image File for Retina', 'quadro' ),
			'type' => 'upload',
			'description' => esc_html__('Twice as bigger, for retina screens', 'quadro'),
			'section' => 'branding',
			'tab' => 'general',
			'default' => ''
		),
		// Miscelaneous Section
		'404_title' => array(
			'name' => '404_title',
			'title' => esc_html__( '404 Page Title', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => '',
			'section' => 'misc',
			'tab' => 'general',
			'default' => 'Oops! That page can&rsquo;t be found.'
		),
		'404_text' => array(
			'name' => '404_text',
			'title' => esc_html__( '404 Page Text', 'quadro' ),
			'type' => 'textarea',
			'sanitize' => 'html',
			'description' => '',
			'section' => 'misc',
			'tab' => 'general',
			'default' => '<p>It looks like nothing was found at this location. Maybe try a search?</p>'
		),
		'retina_enable' => array(
			'name' => 'retina_enable',
			'title' => esc_html__( 'Retina Support Enable', 'quadro' ),
			'type' => 'checkbox',
			'description' => esc_html__('Only disable Retina Support if you want to avoid extra time dedication when uploading images to the site. Keep in mind that any image you may upload when Retina Support is disabled wont get cropped accordingly.', 'quadro'),
			'section' => 'misc',
			'tab' => 'general',
			'default' => true
		),
		'breadcrumbs_show' => array(
			'name' => 'breadcrumbs_show',
			'title' => esc_html__( 'Breadcrumbs', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'misc',
			'tab' => 'general',
			'default' => 'show'
		),
		'breadcrumbs_prefix' => array(
			'name' => 'breadcrumbs_prefix',
			'title' => esc_html__( 'Breadcrumbs Prefix', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Optional text for breadcrumbs. Ex: "You are here:"', 'quadro'),
			'section' => 'misc',
			'tab' => 'general',
			'default' => ''
		),
		'backto_enable' => array(
			'name' => 'backto_enable',
			'title' => esc_html__( 'Back-to-top Enable', 'quadro' ),
			'type' => 'checkbox',
			'description' => '',
			'section' => 'misc',
			'tab' => 'general',
			'default' => true
		),
		'transients_enable' => array(
			'name' => 'transients_enable',
			'title' => esc_html__( 'Transients Cache Enable', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'disabled' => array(
					'name' => 'disabled',
					'title' => esc_html__( 'Disabled', 'quadro' )
				),
				'enabled' => array(
					'name' => 'enabled',
					'title' => esc_html__( 'Enabled', 'quadro' )
				),
			),
			'description' => esc_html__('We recommend enabling this option for maximum performance improvements. Disable this option if you need to show sensitive information on modules served specifically for each particular user. Note: Some Page Builder elements which output dynamic CSS won\'t work with transients enabled.', 'quadro'),
			'section' => 'misc',
			'tab' => 'general',
			'default' => 'disabled'
		),
		// User/Login Menu Section
		'header_login' => array(
			'name' => 'header_login',
			'title' => esc_html__( 'Login Link in Header (show/hide)', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'login',
			'tab' => 'general',
			'default' => 'hide'
		),
		'header_login_text' => array(
			'name' => 'header_login_text',
			'title' => esc_html__( 'Login Link Text', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Optional text for login icon. Ex: "Login"', 'quadro'),
			'section' => 'login',
			'tab' => 'general',
			'default' => 'Login'
		),
		'header_login_url' => array(
			'name' => 'header_login_url',
			'title' => esc_html__( 'Login Page URL', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Enter here your preferred login page URL', 'quadro'),
			'section' => 'login',
			'tab' => 'general',
			'default' => ''
		),
		'header_logged_url' => array(
			'name' => 'header_logged_url',
			'title' => esc_html__( 'Once logged in link points to:', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Optional. Can be used for a My Account page.', 'quadro'),
			'section' => 'login',
			'tab' => 'general',
			'default' => ''
		),
		'header_logout' => array(
			'name' => 'header_logout',
			'title' => esc_html__( 'Logout Link in User Menu (show/hide)', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
			),
			'description' => esc_html__('To display a Logout link inside the User/Login Menu, make sure you have created a new menu (at Appearance >> Menus) and defined it for the User/Login Menu option in Appearance >> Menus >> Manage Locations.', 'quadro'),
			'section' => 'login',
			'tab' => 'general',
			'default' => 'show'
		),
		'header_logout_text' => array(
			'name' => 'header_logout_text',
			'title' => esc_html__( 'Logout Link Text', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Text for logout link in menu. Ex: "Logout"', 'quadro'),
			'section' => 'login',
			'tab' => 'general',
			'default' => 'Logout'
		),
		// Options & Content Section
		'demo_content_import' => array(
			'name' => 'demo_content_import',
			'title' => esc_html__( 'Demo Content Import', 'quadro' ),
			'type' => 'dummy_importx',
			'description' => wp_kses_post( __('<br />Click "Import Dummy Content" to import most pages, posts, menus and theme settings to your WordPress install. <strong>Please be aware that this process will override your current content & options in lots of ways. It is advisable that you do this only on installs with no previous content.</strong><br />* If you receive a success message but don\'t see any content imported **and** you had the WordPress Importer plugin activated, give this a second run, the Importer will have used the first one to deactivate the plugin to enable this action.', 'quadro') ),
			'section' => 'options',
			'tab' => 'general',
			'customizer' => 'exclude',
			'default' => ''
		),
		'backup_options' => array(
			'name' => 'backup_options',
			'title' => esc_html__( 'Backup Options', 'quadro' ),
			'type' => 'backup_options',
			'description' => '',
			'section' => 'options',
			'tab' => 'general',
			'customizer' => 'exclude',
			'default' => ''
		),
		'transfer_options' => array(
			'name' => 'transfer_options',
			'title' => esc_html__( 'Export Options', 'quadro' ),
			'type' => 'transfer_options',
			'description' => esc_html__( 'You can transfer your theme settings between different installs by copying the text inside this text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".', 'quadro' ),
			'section' => 'options',
			'tab' => 'general',
			'customizer' => 'exclude',
			'default' => ''
		),
		// Theme Updates Section
		'updates_enable' => array(
			'name' => 'updates_enable',
			'title' => esc_html__( 'Enable Updates', 'quadro' ),
			'type' => 'checkbox',
			'description' => esc_html__('Keep this checked if you want to be able to update your theme from the WordPress themes screen and get notified about new versions as they come out.', 'quadro'),
			'section' => 'updates',
			'tab' => 'general',
			'customizer' => 'exclude',
			'default' => true
		),
		'quadro_username' => array(
			'name' => 'quadro_username',
			'title' => esc_html__( 'QuadroIdeas.com Username', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => wp_kses_post( __( 'Don\'t have a QuadroIdeas.com user? Get yours <a href="http://quadroideas.com" target="_blank">here</a>. <strong>Note: If you already have a username, you may need to login and register your theme before being able to update.</strong>', 'quadro' ) ),
			'section' => 'updates',
			'tab' => 'general',
			'customizer' => 'exclude',
			'default' => ''
		),
		'quadro_userpass' => array(
			'name' => 'quadro_userpass',
			'title' => esc_html__( 'QuadroIdeas.com Password', 'quadro' ),
			'type' => 'pass',
			'sanitize' => 'nohtml',
			'description' => '',
			'section' => 'updates',
			'tab' => 'general',
			'customizer' => 'exclude',
			'default' => ''
		),
		'quadro_userlicense' => array(
			'name' => 'quadro_userlicense',
			'title' => esc_html__( 'License ID', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => '',
			'section' => 'updates',
			'tab' => 'general',
			'customizer' => 'exclude',
			'default' => ''
		),
		'user_verify' => array(
			'name' => 'user_verify',
			'title' => esc_html__( 'Verify User', 'quadro' ),
			'type' => 'usercheck',
			'sanitize' => 'nohtml',
			'description' => wp_kses_post( __( 'This step is not required. You can use it to verify you have entered your credentials correctly. <br /><strong>Once you enter your details, click "Save Settings" before checking.</strong>', 'quadro' ) ),
			'section' => 'updates',
			'tab' => 'general',
			'customizer' => 'exclude',
			'default' => ''
		),
		/**
		 * Layout Tab Options
		 */
		// Blog Section
		'blog_layout' => array(
			'name' => 'blog_layout',
			'title' => esc_html__( 'Blog Style', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'classic' => array(
					'name' => 'classic',
					'title' => esc_html__( 'Classic', 'quadro' )
				),
				'teasers' => array(
					'name' => 'teasers',
					'title' => esc_html__( 'Teasers', 'quadro' )
				),
				'headlines' => array(
					'name' => 'headlines',
					'title' => esc_html__( 'Headlines', 'quadro' )
				),
				'masonry' => array(
					'name' => 'masonry',
					'title' => esc_html__( 'Masonry', 'quadro' )
				),
			),
			'description' => esc_html__('This setting applies to all multiple-posts layouts (blog, archives, search results, etc.)', 'quadro'),
			'section' => 'blog',
			'tab' => 'layout',
			'default' => 'masonry'
		),
		'blog_columns' => array(
			'name' => 'blog_columns',
			'title' => esc_html__( 'Blog Columns', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'two' => array(
					'name' => 'two',
					'title' => esc_html__( 'Two', 'quadro' )
				),
				'three' => array(
					'name' => 'three',
					'title' => esc_html__( 'Three', 'quadro' )
				),
			),
			'description' => esc_html__('This setting applies to all multiple-posts masonry layouts (blog, archives, search results, etc.)', 'quadro'),
			'section' => 'blog',
			'tab' => 'layout',
			'default' => 'three'
		),
		'masonry_margins' => array(
			'name' => 'masonry_margins',
			'title' => esc_html__( 'Masonry Margins', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'false' => array(
					'name' => 'false',
					'title' => esc_html__( 'Without Margins', 'quadro' )
				),
				'true' => array(
					'name' => 'true',
					'title' => esc_html__( 'With Margins', 'quadro' )
				),
			),
			'description' => esc_html__('This setting applies to all multiple-posts masonry layouts (blog, archives, search results, etc.)', 'quadro'),
			'section' => 'blog',
			'tab' => 'layout',
			'default' => 'true'
		),
		'blog_animation' => array(
			'name' => 'blog_animation',
			'title' => esc_html__( 'Posts Loading Animation', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'none' => array(
					'name' => 'none',
					'title' => esc_html__( 'None', 'quadro' )
				),
				'1' => array(
					'name' => '1',
					'title' => esc_html__( 'Type 1', 'quadro' )
				),
				'2' => array(
					'name' => '2',
					'title' => esc_html__( 'Type 2', 'quadro' )
				),
				'3' => array(
					'name' => '3',
					'title' => esc_html__( 'Type 3', 'quadro' )
				),
				'4' => array(
					'name' => '4',
					'title' => esc_html__( 'Type 4', 'quadro' )
				),
				'5' => array(
					'name' => '5',
					'title' => esc_html__( 'Type 5', 'quadro' )
				),
				'6' => array(
					'name' => '6',
					'title' => esc_html__( 'Type 6', 'quadro' )
				),
				'7' => array(
					'name' => '7',
					'title' => esc_html__( 'Type 7', 'quadro' )
				),
				'8' => array(
					'name' => '8',
					'title' => esc_html__( 'Type 8', 'quadro' )
				),
			),
			'description' => esc_html__('This setting applies to all multiple-posts masonry layouts (blog, archives, search results, etc.). Available in Masonry Blog Style.', 'quadro'),
			'section' => 'blog',
			'tab' => 'layout',
			'default' => '3'
		),
		'archive_background' => array(
			'name' => 'archive_background',
			'title' => esc_html__( 'Background Color', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'section' => 'blog',
			'tab' => 'layout',
			'default' => '#f1f1f1'
		),
		'blog_sidebar' => array(
			'name' => 'blog_sidebar',
			'title' => esc_html__( 'Show Sidebar for Blog & Archives', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'sidebar' => array(
					'name' => 'sidebar',
					'title' => esc_html__( 'With Sidebar', 'quadro' )
				),
				'fullwidth' => array(
					'name' => 'fullwidth',
					'title' => esc_html__( 'Full Width', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'blog',
			'tab' => 'layout',
			'default' => 'fullwidth'
		),
		// Blog Sidebar Position
		'blog_sidebar_pos' => array(
			'name' => 'blog_sidebar_pos',
			'title' => esc_html__( 'Sidebar Position', 'quadro' ),
			'type' => 'radio',
			'valid_options' => array(
				'left' => array(
					'name' => 'left',
					'title' => esc_html__( 'Left', 'quadro' ),
					'description' => ''
				),
				'right' => array(
					'name' => 'right',
					'title' => esc_html__( 'Right', 'quadro' ),
					'description' => ''
				),
			),
			'description' => '',
			'section' => 'blog',
			'tab' => 'layout',
			'default' => 'right'			
		),
		// Single Blog Posts Section
		'single_sidebar' => array(
			'name' => 'single_sidebar',
			'title' => esc_html__( 'Style', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'sidebar' => array(
					'name' => 'sidebar',
					'title' => esc_html__( 'With Sidebar', 'quadro' )
				),
				'fullwidth' => array(
					'name' => 'fullwidth',
					'title' => esc_html__( 'Full Width', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'single',
			'tab' => 'layout',
			'default' => 'fullwidth'
		),
		// Single Post Sidebar Position
		'single_sidebar_pos' => array(
			'name' => 'single_sidebar_pos',
			'title' => esc_html__( 'Sidebar Position', 'quadro' ),
			'type' => 'radio',
			'valid_options' => array(
				'left' => array(
					'name' => 'left',
					'title' => esc_html__( 'Left', 'quadro' ),
					'description' => ''
				),
				'right' => array(
					'name' => 'right',
					'title' => esc_html__( 'Right', 'quadro' ),
					'description' => ''
				),
			),
			'description' => '',
			'section' => 'single',
			'tab' => 'layout',
			'default' => 'right'			
		),
		// Author Box on Single Posts
		'single_author_box' => array(
			'name' => 'single_author_box',
			'title' => esc_html__( 'Author Box at End of Article', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'single',
			'tab' => 'layout',
			'default' => 'show'
		),
		// Site Layout Section
		'site_layout' => array(
			'name' => 'site_layout',
			'title' => esc_html__( 'Stretched / Boxed Site Version', 'quadro' ),
			'type' => 'layout-picker',
			'path' => '/images/admin/site-layout/',
			'valid_options' => array(
				'stretched' => array(
					'name' => 'stretched',
					'title' => '',
					'img' => 'site-layout1.png',
					'description' => '',
				),
				'boxed' => array(
					'name' => 'boxed',
					'title' => '',
					'img' => 'site-layout2.png',
					'description' => '',
				),
			),
			'description' => '',
			'section' => 'site',
			'tab' => 'layout',
			'default' => 'stretched'
		),
		// Header Section
		'header_layout' => array(
			'name' => 'header_layout',
			'title' => esc_html__( 'Header Layout', 'quadro' ),
			'type' => 'layout-picker',
			'path' => '/images/admin/header-layouts/',
			'valid_options' => array(
				'layout1' => array(
					'name' => 'header-layout1',
					'title' => 'Layout 1',
					'img' => 'header-layout1.png',
					'description' => esc_html__('One row. Logo + Navigation Menu + Social Links + Extras.', 'quadro'),
				),
				'layout2' => array(
					'name' => 'header-layout2',
					'title' => 'Layout 2',
					'img' => 'header-layout2.png',
					'description' => esc_html__('Two rows. Logo + Navigation Menu + Social Links + Extras.', 'quadro'),
				),
				'layout3' => array(
					'name' => 'header-layout3',
					'title' => 'Layout 3',
					'img' => 'header-layout3.png',
					'description' => esc_html__('Two rows. Logo + About Text + Navigation Menu + Social Links + Extras.', 'quadro'),
				),
				'layout4' => array(
					'name' => 'header-layout4',
					'title' => 'Layout 4',
					'img' => 'header-layout4.png',
					'description' => esc_html__('Two rows. Logo + Navigation Menu + Social Links + Extras.', 'quadro'),
				),
				'layout5' => array(
					'name' => 'header-layout5',
					'title' => 'Layout 5',
					'img' => 'header-layout5.png',
					'description' => esc_html__('One row. Logo + Navigation Menu + Social Links + Extras.', 'quadro'),
				),
				'layout6' => array(
					'name' => 'header-layout6',
					'title' => 'Layout 6',
					'img' => 'header-layout6.png',
					'description' => esc_html__('One row. Logo + Navigation Menu + Social Links + Extras.', 'quadro'),
				),
				'layout7' => array(
					'name' => 'header-layout7',
					'title' => 'Layout 7',
					'img' => 'header-layout7.png',
					'description' => esc_html__('Side Header. Logo + Menu + Social + Extras. (Only with Streched Site & Background Header).', 'quadro'),
				),
				'layout8' => array(
					'name' => 'header-layout8',
					'title' => 'Layout 8',
					'img' => 'header-layout8.png',
					'description' => esc_html__('One row. Logo + Closed Menu + Social Links + Extras.', 'quadro'),
				),
				'layout9' => array(
					'name' => 'header-layout9',
					'title' => 'Layout 9',
					'img' => 'header-layout9.png',
					'description' => esc_html__('One row. Logo + Closed Menu + Social Links + Extras.', 'quadro'),
				),
				'layout10' => array(
					'name' => 'header-layout10',
					'title' => 'Layout 10',
					'img' => 'header-layout10.png',
					'description' => esc_html__('One row. Logo + Navigation Menu + Social Links + Extras.', 'quadro'),
				),
				'layout11' => array(
					'name' => 'header-layout11',
					'title' => 'Layout 11',
					'img' => 'header-layout11.png',
					'description' => esc_html__('One row. Logo + Navigation Menu + About Text.', 'quadro'),
				),
				'layout12' => array(
					'name' => 'header-layout12',
					'title' => 'Layout 12',
					'img' => 'header-layout12.png',
					'description' => esc_html__('One row. Logo + Closed Menu + Social Links + Extras.', 'quadro'),
				),
				'layout13' => array(
					'name' => 'header-layout13',
					'title' => 'Layout 13',
					'img' => 'header-layout13.png',
					'description' => esc_html__('Two rows. Logo + About Text + Navigation Menu + Social Links + Extras.', 'quadro'),
				),
				'layout14' => array(
					'name' => 'header-layout14',
					'title' => 'Layout 14',
					'img' => 'header-layout14.png',
					'description' => esc_html__('Two rows. Logo + Ad Banner + Navigation Menu + Social Links + Extras.', 'quadro'),
				),
				'layout15' => array(
					'name' => 'header-layout15',
					'title' => 'Layout 15',
					'img' => 'header-layout15.png',
					'description' => esc_html__('Two rows. Logo + Ad Banner + Navigation Menu + Social Links + Extras.', 'quadro'),
				),
				'layout16' => array(
					'name' => 'header-layout16',
					'title' => 'Layout 16',
					'img' => 'header-layout16.png',
					'description' => esc_html__('Logo + Closed Menu + Social Links + Extras. (Only with Stretched site layout and Transparent header).', 'quadro'),
				),
				// 'layout17' => array(
				// 	'name' => 'header-layout17',
				// 	'title' => 'Layout 7',
				// 	'img' => 'header-layout17.png',
				// 	'description' => esc_html__('Side Header. Logo + Closed Menu. (Only with Streched Site & Background Header).', 'quadro'),
				// ),
			),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => 'header-layout5'
		),
		'header_height' => array(
			'name' => 'header_height',
			'title' => esc_html__( 'Header Height', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'short' => array(
					'name' => 'short',
					'title' => esc_html__( 'Short', 'quadro' )
				),
				'tall' => array(
					'name' => 'tall',
					'title' => esc_html__( 'Tall', 'quadro' )
				),
			),
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'header_layout',
					'val' => 'header-layout7',
					'type' => ':checked',
					'operator' => '!='
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout17',
					'type' => ':checked',
					'operator' => '!='
				),
			),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => 'tall'
		),
		'header_transp' => array(
			'name' => 'header_transp',
			'title' => esc_html__( 'Header Style', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'background' => array(
					'name' => 'background',
					'title' => esc_html__( 'With Background', 'quadro' )
				),
				'transparent' => array(
					'name' => 'transparent',
					'title' => esc_html__( 'Transparent', 'quadro' )
				),
			),
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'header_layout',
					'val' => 'header-layout7',
					'type' => ':checked',
					'operator' => '!='
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout17',
					'type' => ':checked',
					'operator' => '!='
				),
			),
			'description' => esc_html__( 'You can override this setting on each page.', 'quadro' ),
			'section' => 'header',
			'tab' => 'layout',
			'default' => 'background'
		),
		'1st_row_back' => array(
			'name' => '1st_row_back',
			'title' => esc_html__( 'Header 1st Row Background', 'quadro' ),
			'type' => 'color',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'header_transp',
					'val' => 'background',
					'type' => ''
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout7',
					'type' => ':checked',
					'operator' => '!='
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout17',
					'type' => ':checked',
					'operator' => '!='
				),
			),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => '#ffffff'
		),
		'1st_row_color' => array(
			'name' => '1st_row_color',
			'title' => esc_html__( 'Header 1st Row Color', 'quadro' ),
			'type' => 'color',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'header_transp',
					'val' => 'background',
					'type' => ''
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout7',
					'type' => ':checked',
					'operator' => '!='
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout17',
					'type' => ':checked',
					'operator' => '!='
				),
			),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => '#353535'
		),
		'2nd_row_back' => array(
			'name' => '2nd_row_back',
			'title' => esc_html__( 'Header 2nd Row Background', 'quadro' ),
			'type' => 'color',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'header_transp',
					'val' => 'background',
					'type' => ''
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout7',
					'type' => ':checked',
					'operator' => '!='
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout17',
					'type' => ':checked',
					'operator' => '!='
				),
			),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => '#353535'
		),
		'2nd_row_color' => array(
			'name' => '2nd_row_color',
			'title' => esc_html__( 'Header 2nd Row Color', 'quadro' ),
			'type' => 'color',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'header_transp',
					'val' => 'background',
					'type' => ''
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout7',
					'type' => ':checked',
					'operator' => '!='
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout17',
					'type' => ':checked',
					'operator' => '!='
				),
			),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => '#ffffff'
		),
		'transp_header_color' => array(
			'name' => 'transp_header_color',
			'title' => esc_html__( 'Transparent Header Color', 'quadro' ),
			'type' => 'radio',
			'valid_options' => array(
				'dark' => array(
					'name' => 'dark',
					'title' => esc_html__( 'Dark', 'quadro' ),
					'description' => ''
				),
				'light' => array(
					'name' => 'light',
					'title' => esc_html__( 'Light', 'quadro' ),
					'description' => ''
				),
				'custom' => array(
					'name' => 'custom',
					'title' => esc_html__( 'Custom', 'quadro' ),
					'description' => ''
				),
			),
			'description' => '',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'header_transp',
					'val' => 'transparent',
					'type' => ''
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout7',
					'type' => ':checked',
					'operator' => '!='
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout17',
					'type' => ':checked',
					'operator' => '!='
				),
			),
			'section' => 'header',
			'tab' => 'layout',
			'default' => 'light'			
		),
		'transp_header_custom' => array(
			'name' => 'transp_header_custom',
			'title' => esc_html__( 'Transparent Header Custom Color', 'quadro' ),
			'type' => 'color',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'header_transp',
					'val' => 'transparent',
					'type' => ''
				),
				array(
					'id' => 'transp_header_color',
					'val' => 'custom',
					'type' => ':checked'
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout7',
					'type' => ':checked',
					'operator' => '!='
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout17',
					'type' => ':checked',
					'operator' => '!='
				),
			),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => '#fff'
		),
		'side_header_back' => array(
			'name' => 'side_header_back',
			'title' => esc_html__( 'Side Header Background', 'quadro' ),
			'type' => 'color',
			'hide' => true,
			'conditions' => array(
                array(
                    'combined' => 'true',
                    'combOperator' => 'or',
                    'combination' => array(
                        array(
                            'id' => 'header_layout',
                            'val' => 'header-layout7',
                            'type' => ':checked',
                            'operator' => '=='
                        ),
                        array(
                            'id' => 'header_layout',
                            'val' => 'header-layout17',
                            'type' => ':checked',
                            'operator' => '=='
                        ),
                    ),
                ),
            ),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => '#fff'
		),
		'side_header_color' => array(
			'name' => 'side_header_color',
			'title' => esc_html__( 'Side Header Color', 'quadro' ),
			'type' => 'color',
			'hide' => true,
			'conditions' => array(
                array(
                    'combined' => 'true',
                    'combOperator' => 'or',
                    'combination' => array(
                        array(
                            'id' => 'header_layout',
                            'val' => 'header-layout7',
                            'type' => ':checked',
                            'operator' => '=='
                        ),
                        array(
                            'id' => 'header_layout',
                            'val' => 'header-layout17',
                            'type' => ':checked',
                            'operator' => '=='
                        ),
                    ),
                ),
            ),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => '#1b1b1b'
		),
		'sticky_menu' => array(
			'name' => 'sticky_menu',
			'title' => esc_html__( 'Sticky Menu (Pit Bar)', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'sticky' => array(
					'name' => 'sticky',
					'title' => esc_html__( 'Sticky', 'quadro' )
				),
				'not-sticky' => array(
					'name' => 'not-sticky',
					'title' => esc_html__( 'Not Sticky', 'quadro' )
				),
			),
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'header_layout',
					'val' => 'header-layout7',
					'type' => ':checked',
					'operator' => '!='
				),
				array(
					'id' => 'header_layout',
					'val' => 'header-layout17',
					'type' => ':checked',
					'operator' => '!='
				),
			),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => 'sticky'
		),
		'social_header_display' => array(
			'name' => 'social_header_display',
			'title' => esc_html__( 'Social Icons (show/hide)', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => 'show'
		),
		'search_header_display' => array(
			'name' => 'search_header_display',
			'title' => esc_html__( 'Search Field in Menu (show/hide)', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'header',
			'tab' => 'layout',
			'default' => 'show'
		),
		'widgetized_header_display' => array(
			'name' => 'widgetized_header_display',
			'title' => esc_html__( 'Widgetized Area in Header (show/hide)', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
			),
			'description' => esc_html__('This enables a slideable top space above the header that serves as an extra widget area.', 'quadro'),
			'section' => 'header',
			'tab' => 'layout',
			'default' => 'hide'
		),
		'widgt_header_layout' => array(
			'name' => 'widgt_header_layout',
			'title' => esc_html__( 'Widgetized Header Layout', 'quadro' ),
			'type' => 'layout-picker',
			'path' => '/images/admin/widget-layouts/',
			'valid_options' => array(
				'widg-layout1' => array(
					'name' => 'widg-layout1',
					'title' => '',
					'img' => 'widg-layout1.png',
					'description' => '',
				),
				'widg-layout2' => array(
					'name' => 'widg-layout2',
					'title' => '',
					'img' => 'widg-layout2.png',
					'description' => '',
				),
				'widg-layout3' => array(
					'name' => 'widg-layout3',
					'title' => '',
					'img' => 'widg-layout3.png',
					'description' => '',
				),
				'widg-layout4' => array(
					'name' => 'widg-layout4',
					'title' => '',
					'img' => 'widg-layout4.png',
					'description' => '',
				),
				'widg-layout5' => array(
					'name' => 'widg-layout5',
					'title' => '',
					'img' => 'widg-layout5.png',
					'description' => '',
				),
				'widg-layout6' => array(
					'name' => 'widg-layout6',
					'title' => '',
					'img' => 'widg-layout6.png',
					'description' => '',
				),
			),
			'description' => '',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'widgetized_header_display',
					'val' => 'show',
					'type' => ''
				),
			),
			'section' => 'header',
			'tab' => 'layout',
			'default' => 'widg-layout1'
		),
		'widgt_header_background' => array(
			'name' => 'widgt_header_background',
			'title' => esc_html__( 'Widgetized Header Background', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'widgetized_header_display',
					'val' => 'show',
					'type' => ''
				),
			),
			'section' => 'header',
			'tab' => 'layout',
			'default' => '#f1f1f1'
		),
		'widgt_header_color' => array(
			'name' => 'widgt_header_color',
			'title' => esc_html__( 'Widgetized Header Color', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'widgetized_header_display',
					'val' => 'show',
					'type' => ''
				),
			),
			'section' => 'header',
			'tab' => 'layout',
			'default' => '#1b1b1b'
		),
		// Footer Section
		'widgetized_footer_display' => array(
			'name' => 'widgetized_footer_display',
			'title' => esc_html__( 'Widgetized Footer (show/hide)', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'footer',
			'tab' => 'layout',
			'default' => 'hide'
		),
		'footer_background' => array(
			'name' => 'footer_background',
			'title' => esc_html__( 'Background Color', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'section' => 'footer',
			'tab' => 'layout',
			'default' => '#1f1f1f'
		),
		'footer_text_color' => array(
			'name' => 'footer_text_color',
			'title' => esc_html__( 'Text Color', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'section' => 'footer',
			'tab' => 'layout',
			'default' => '#ffffff'
		),
		'footer_links_color' => array(
			'name' => 'footer_links_color',
			'title' => esc_html__( 'Links Color', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'section' => 'footer',
			'tab' => 'layout',
			'default' => '#e6e6e6'
		),
		'copyright_text' => array(
			'name' => 'copyright_text',
			'title' => esc_html__( 'Copyright Text', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => '',
			'section' => 'footer',
			'tab' => 'layout',
			'default' => 'Proudly powered by <a href="http://wordpress.org/" title="A Semantic Personal Publishing Platform">WordPress</a><span class="sep"> | </span>Modules Theme by <a href="http://quadroideas.com/">QuadroIdeas</a>'
		),
		'widgetized_footer_layout' => array(
			'name' => 'widgetized_footer_layout',
			'title' => esc_html__( 'Widgetized Footer Layout', 'quadro' ),
			'type' => 'layout-picker',
			'path' => '/images/admin/widget-layouts/',
			'valid_options' => array(
				'widg-layout1' => array(
					'name' => 'widg-layout1',
					'title' => '',
					'img' => 'widg-layout1.png',
					'description' => '',
				),
				'widg-layout2' => array(
					'name' => 'widg-layout2',
					'title' => '',
					'img' => 'widg-layout2.png',
					'description' => '',
				),
				'widg-layout3' => array(
					'name' => 'widg-layout3',
					'title' => '',
					'img' => 'widg-layout3.png',
					'description' => '',
				),
				'widg-layout4' => array(
					'name' => 'widg-layout4',
					'title' => '',
					'img' => 'widg-layout4.png',
					'description' => '',
				),
				'widg-layout5' => array(
					'name' => 'widg-layout5',
					'title' => '',
					'img' => 'widg-layout5.png',
					'description' => '',
				),
				'widg-layout6' => array(
					'name' => 'widg-layout6',
					'title' => '',
					'img' => 'widg-layout6.png',
					'description' => '',
				),
			),
			'description' => '',
			'section' => 'footer',
			'tab' => 'layout',
			'default' => 'widg-layout2'
		),
		'social_footer_display' => array(
			'name' => 'social_footer_display',
			'title' => esc_html__( 'Social Icons (show/hide)', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'footer',
			'tab' => 'layout',
			'default' => 'show'
		),
		// Sidebars Section
		'quadro_sidebars' => array(
			'name' => 'quadro_sidebars',
			'title' => esc_html__( 'Manage Sidebars', 'quadro' ),
			'type' => 'repeatable',
			'repeat_fields' => array(
				'name' => array(
					'name' => 'name',
					'title' => esc_html__( 'Sidebar Name', 'quadro' ),
					'type' => 'text',
					'description' => esc_html__( 'The name will be shown at widgets page.', 'quadro' )
				),
				'slug' => array(
					'name' => 'slug',
					'title' => esc_html__( 'Sidebar Slug', 'quadro' ),
					'type' => 'text',
					'description' => esc_html__( 'Internal use. Only lowercases, digits, "-" and "_" allowed.', 'quadro' )
				),
			),
			'repeat-item' => esc_html__( 'Add new Sidebar', 'quadro' ),
			'description' => '',
			'section' => 'sidebars',
			'tab' => 'layout',
			'default' => ''
		),
		/**
		 * Design Tab Options
		 */
		// Color Options
		'main_color' => array(
			'name' => 'main_color',
			'title' => esc_html__( 'Theme\'s Main Color', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'section' => 'colors',
			'tab' => 'design',
			'default' => '#c4a364'
		),
		// Background Options
		'background_color' => array(
			'name' => 'background_color',
			'title' => esc_html__( 'Color', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'section' => 'background',
			'tab' => 'design',
			'default' => '#eaeaea'
		),
		'background_pattern' => array(
			'name' => 'background_pattern',
			'title' => esc_html__( 'Pattern', 'quadro' ),
			'type' => 'layout-picker',
			'path' => '/images/admin/pattern-thumbs/',
			'valid_options' => quadro_get_patterns(),
			'description' => '',
			'section' => 'background',
			'tab' => 'design',
			'default' => 'none'
		),
		'background_img' => array(
			'name' => 'background_img',
			'title' => esc_html__( 'Custom Image', 'quadro' ),
			'type' => 'upload',
			'description' => esc_html__( 'Note: Uploading a custom background image will override any other background setting.', 'quadro' ),
			'section' => 'background',
			'tab' => 'design',
			'default' => ''
		),
		// Custom CSS Options
		'custom_css' => array(
			'name' => 'custom_css',
			'title' => '',
			'type' => 'textarea',
			'sanitize' => 'html',
			'description' => '',
			'section' => 'css',
			'tab' => 'design',
			'default' => '',
			'no_reset' => true
		),

		/**
		 * Typography Tab Options
		 */
		// Font Options
		'font_selection' => array(
			'name' => 'font_selection',
			'title' => esc_html__( 'Font Selection', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'google' => array(
					'name' => 'google',
					'title' => esc_html__( 'Google & Web Safe Fonts', 'quadro' )
				),
				'typekit_fonts' => array(
					'name' => 'typekit_fonts',
					'title' => esc_html__( 'Typekit - License Kit / Custom Kit', 'quadro' )
				),
				'custom' => array(
					'name' => 'custom',
					'title' => esc_html__( 'Custom Font Upload', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'fonts',
			'tab' => 'typography',
			'default' => 'google'
		),
		'headings_font' => array(
			'name' => 'headings_font',
			'title' => 'Headings',
			'type' => 'font',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'font_selection',
					'val' => 'google',
					'type' => '',
				),
			),
			'description' => wp_kses_post( __( 'Google Fonts (those which come after the separator mark) can be previewed <a href="https://www.google.com/fonts" title="Google Fonts">here</a>. Please check available weights for each font family before declaring them.', 'quadro' ) ),
			'section' => 'fonts',
			'tab' => 'typography',
			'default' => 'Poppins|font-family: "Poppins";',
		),
		'headings_weight' => array(
			'name' => 'headings_weight',
			'title' => 'Headings Weight',
			'type' => 'text-hideable',
			'sanitize' => 'nohtml',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'font_selection',
					'val' => 'google',
					'type' => '',
				),
			),
			'description' => esc_html__( '(Optional) Ex. :300,400,700', 'quadro' ),
			'section' => 'fonts',
			'tab' => 'typography',
			'default' => ':300,400'
		),
		'body_font' => array(
			'name' => 'body_font',
			'title' => 'Body',
			'type' => 'font',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'font_selection',
					'val' => 'google',
					'type' => '',
				),
			),
			'description' => wp_kses_post( __( 'Google Fonts (those which come after the separator mark) can be previewed <a href="https://www.google.com/fonts" title="Google Fonts">here</a>. Please check available weights for each font family before declaring them.', 'quadro' ) ),
			'section' => 'fonts',
			'tab' => 'typography',
			'default' => 'Lato|font-family: "Lato";'
		),
		'body_weight' => array(
			'name' => 'body_weight',
			'title' => 'Body Weight',
			'type' => 'text-hideable',
			'sanitize' => 'nohtml',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'font_selection',
					'val' => 'google',
					'type' => '',
				),
			),
			'description' => esc_html__( '(Optional) Ex. :300,400,700', 'quadro' ),
			'section' => 'fonts',
			'tab' => 'typography',
			'default' => ':300,400,700'
		),
		'font_subset' => array(
			'name' => 'font_subset',
			'title' => esc_html__( 'Font Subset', 'quadro' ),
			'type' => 'text-hideable',
			'sanitize' => 'nohtml',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'font_selection',
					'val' => 'google',
					'type' => '',
				),
			),
			'description' => esc_html__('(Optional) Add :cyrillic / :greek / :cyrillic-ext / :greek-ext / :latin to enable font subsets. Only on supported Google Fonts. Multiple subsets should be separated by commas, using just one colon at the beginning.', 'quadro'),
			'section' => 'fonts',
			'tab' => 'typography',
			'default' => ''
		),
		// Typekit Options
		'typekit_kit' => array(
			'name' => 'typekit_kit',
			'title' => esc_html__( 'Activate Typekit Kit', 'quadro' ),
			'type' => 'typekit_activate',
			'description' => wp_kses_post( __( 'You need an active Modules license for Typekit to work, so make sure you have registered your theme at <a href="http://quadroideas.com/account" target="_blank">quadroideas.com</a> and filled your details at the General Tab before going on.<br />Clicking this button will auto-populate the fields below with your personal Kit ID and data.<br />', 'quadro' ) ),
			'section' => 'fonts',
			'tab' => 'typography',
			'customizer' => 'exclude',
			'default' => ''
		),
		'typekit_kit_id' => array(
			'name' => 'typekit_kit_id',
			'title' => esc_html__( 'Typekit Kit ID', 'quadro' ),
			'type' => 'text-hideable',
			'sanitize' => 'nohtml',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'font_selection',
					'val' => 'typekit_fonts',
					'type' => '',
				),
			),
			'description' => esc_html__( 'Enter Typekit Kit\'s ID', 'quadro' ),
			'section' => 'fonts',
			'tab' => 'typography',
			'default' => ''
		),
		'typekit_kit_headings_family' => array(
			'name' => 'typekit_kit_headings_family',
			'title' => esc_html__( 'Typekit - Headings Font Family', 'quadro' ),
			'type' => 'text-hideable-kses',
			'sanitize' => 'nohtml',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'font_selection',
					'val' => 'typekit_fonts',
					'type' => '',
				),
			),
			'description' => esc_html__( 'Enter font-family CSS name', 'quadro' ),
			'section' => 'fonts',
			'tab' => 'typography',
			'default' => ''
		),
		'typekit_kit_body_family' => array(
			'name' => 'typekit_kit_body_family',
			'title' => esc_html__( 'Typekit - Body Font Family', 'quadro' ),
			'type' => 'text-hideable-kses',
			'sanitize' => 'nohtml',
			'hide' => true,
			'conditions' => array(
				array(
					'id' => 'font_selection',
					'val' => 'typekit_fonts',
					'type' => '',
				),
			),
			'description' => esc_html__( 'Enter font-family CSS name', 'quadro' ),
			'section' => 'fonts',
			'tab' => 'typography',
			'default' => ''
		),
		// Font Color Options
		'links_color' => array(
			'name' => 'links_color',
			'title' => esc_html__( 'Links', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'section' => 'colors',
			'tab' => 'typography',
			'default' => '#b73f5b'
		),
		'hover_color' => array(
			'name' => 'hover_color',
			'title' => esc_html__( 'Links Hover', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'section' => 'colors',
			'tab' => 'typography',
			'default' => '#80404f'
		),
		// Font Size Options
		'body_size' => array(
			'name' => 'body_size',
			'title' => 'Body',
			'type' => 'number',
			'min' => 8,
			'max' => 30,
			'description' => esc_html__('8 to 30 allowed.', 'quadro'),
			'section' => 'sizes',
			'tab' => 'typography',
			'default' => '18'
		),
		'site_title_size' => array(
			'name' => 'site_title_size',
			'title' => 'Site Title',
			'type' => 'number',
			'min' => 12,
			'max' => 60,
			'description' => esc_html__('12 to 60 allowed.', 'quadro'),
			'section' => 'sizes',
			'tab' => 'typography',
			'default' => '22'
		),
		// Custom Font Options
		'custom_font_name' => array(
			'name' => 'custom_font_name',
			'title' => esc_html__( 'Font Name', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Just for CSS use. No spaces, please. ;)', 'quadro'),
			'section' => 'custom',
			'tab' => 'typography',
			'default' => ''
		),
		'custom_font_use_logo' => array(
			'name' => 'custom_font_use_logo',
			'title' => esc_html__( 'Use Custom Font for Logo', 'quadro' ),
			'type' => 'checkbox',
			'description' => '',
			'section' => 'custom',
			'tab' => 'typography',
			'default' => false
		),
		'custom_font_use_headings' => array(
			'name' => 'custom_font_use_headings',
			'title' => esc_html__( 'Use Custom Font for Headings', 'quadro' ),
			'type' => 'checkbox',
			'description' => '',
			'section' => 'custom',
			'tab' => 'typography',
			'default' => false
		),
		'custom_font_eot' => array(
			'name' => 'custom_font_eot',
			'title' => esc_html__( 'Font Upload .eot', 'quadro' ),
			'type' => 'upload',
			'description' => '',
			'section' => 'custom',
			'tab' => 'typography',
			'default' => ''
		),
		'custom_font_woff' => array(
			'name' => 'custom_font_woff',
			'title' => esc_html__( 'Font Upload .woff', 'quadro' ),
			'type' => 'upload',
			'description' => '',
			'section' => 'custom',
			'tab' => 'typography',
			'default' => ''
		),
		'custom_font_ttf' => array(
			'name' => 'custom_font_ttf',
			'title' => esc_html__( 'Font Upload .ttf/.otf', 'quadro' ),
			'type' => 'upload',
			'description' => '',
			'section' => 'custom',
			'tab' => 'typography',
			'default' => ''
		),
		'custom_font_svg' => array(
			'name' => 'custom_font_svg',
			'title' => esc_html__( 'Font Upload .svg', 'quadro' ),
			'type' => 'upload',
			'description' => '',
			'section' => 'custom',
			'tab' => 'typography',
			'default' => ''
		),

		/**
		 * Social Tab Options
		 */		
		// Profiles Section
		'dribbble_profile' => array(
			'name' => 'dribbble_profile',
			'title' => esc_html__( 'Dribbble Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Dribbble Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'facebook_profile' => array(
			'name' => 'facebook_profile',
			'title' => esc_html__( 'Facebook Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Facebook Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'flickr_profile' => array(
			'name' => 'flickr_profile',
			'title' => esc_html__( 'Flickr Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Flickr Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'github_profile' => array(
			'name' => 'github_profile',
			'title' => esc_html__( 'GitHub Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'GitHub Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'google-plus_profile' => array(
			'name' => 'google-plus_profile',
			'title' => esc_html__( 'Google+ Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Google+ Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'instagram_profile' => array(
			'name' => 'instagram_profile',
			'title' => esc_html__( 'Instagram Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Instagram Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'linkedin_profile' => array(
			'name' => 'linkedin_profile',
			'title' => esc_html__( 'Linked-In Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Linked-In Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'pinterest_profile' => array(
			'name' => 'pinterest_profile',
			'title' => esc_html__( 'Pinterest Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Pinterest Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'skype_profile' => array(
			'name' => 'skype_profile',
			'title' => esc_html__( 'Skype Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Skype Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'tumblr_profile' => array(
			'name' => 'tumblr_profile',
			'title' => esc_html__( 'Tumblr Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Tumblr Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'twitter_profile' => array(
			'name' => 'twitter_profile',
			'title' => esc_html__( 'Twitter Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Twitter Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'vimeo-square_profile' => array(
			'name' => 'vimeo-square_profile',
			'title' => esc_html__( 'Vimeo Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'Vimeo Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		'youtube_profile' => array(
			'name' => 'youtube_profile',
			'title' => esc_html__( 'YouTube Profile', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__( 'YouTube Username', 'quadro' ),
			'section' => 'profiles',
			'tab' => 'social',
			'default' => ''
		),
		// Header Icons Section
		'header_icons_color_type' => array(
			'name' => 'header_icons_color_type',
			'title' => esc_html__( 'Color', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'brand' => array(
					'name' => 'brand',
					'title' => esc_html__( 'Brand', 'quadro' )
				),
				'custom' => array(
					'name' => 'custom',
					'title' => esc_html__( 'Custom', 'quadro' )
				),
			),
			'description' => esc_html__('Chose whether to use the original colors for each network or a custom one for all of them.', 'quadro'),
			'section' => 'header-icons',
			'tab' => 'social',
			'default' => 'custom'
		),
		'header_icons_color' => array(
			'name' => 'header_icons_color',
			'title' => esc_html__( 'Color Picker', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'section' => 'header-icons',
			'tab' => 'social',
			'default' => '#b4b4b4'
		),
		// Footer Icons Section
		'footer_icons_color_type' => array(
			'name' => 'footer_icons_color_type',
			'title' => esc_html__( 'Color', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'brand' => array(
					'name' => 'brand',
					'title' => esc_html__( 'Brand', 'quadro' )
				),
				'custom' => array(
					'name' => 'custom',
					'title' => esc_html__( 'Custom', 'quadro' )
				),
			),
			'description' => esc_html__('Chose whether to use the original colors for each network or a custom one for all of them.', 'quadro'),
			'section' => 'footer-icons',
			'tab' => 'social',
			'default' => 'brand'
		),
		'footer_icons_color' => array(
			'name' => 'footer_icons_color',
			'title' => esc_html__( 'Color Picker', 'quadro' ),
			'type' => 'color',
			'description' => '',
			'section' => 'footer-icons',
			'tab' => 'social',
			'default' => '#eeeeee'
		),
		// General Social Settings
		'social_target' => array(
			'name' => 'social_target',
			'title' => esc_html__( 'Link Target', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'brand' => array(
					'name' => '_self',
					'title' => esc_html__( 'Same tab ("_self")', 'quadro' )
				),
				'custom' => array(
					'name' => '_blank',
					'title' => esc_html__( 'New tab ("_blank")', 'quadro' )
				),
			),
			'description' => esc_html__('Chose whether to open the profile links in the same tab or in a new one.', 'quadro'),
			'section' => 'general-social',
			'tab' => 'social',
			'default' => '_self'
		),
		// User Contact Methods
		'available_contact_methods' => array(
			'name' => 'available_contact_methods',
			'title' => esc_html__( 'Available Contact Methods', 'quadro' ),
			'type' => 'repeatable',
			'repeat_fields' => array(
				'title' => array(
					'name' => 'title',
					'title' => esc_html__( 'Name', 'quadro' ),
					'type' => 'text',
					'description' => ''
				),
				'slug' => array(
					'name' => 'slug',
					'title' => esc_html__( 'Slug', 'quadro' ),
					'type' => 'text',
					'description' => ''
				),
			),
			'repeat-item' => esc_html__('Add new Method', 'quadro'),
			'item-name' => esc_html__('Contact Method', 'quadro'),
			'description' => '',
			'section' => 'user-contact',
			'tab' => 'social',
			'default' => ''
		),
		// Header Advertising Settings
		'ads_header_show' => array(
			'name' => 'ads_header_show',
			'title' => esc_html__( 'Ad Show/Hide', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'ads_header',
			'tab' => 'advertising',
			'default' => 'hide'
		),
		'ads_header_upload' => array(
			'name' => 'ads_header_upload',
			'title' => esc_html__( 'Image Ad Upload', 'quadro' ),
			'type' => 'upload',
			'description' => esc_html__('Upload an image for your ad', 'quadro'),
			'section' => 'ads_header',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_header_url' => array(
			'name' => 'ads_header_url',
			'title' => esc_html__( 'Image Ad Link', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Insert URL destination for your ad', 'quadro'),
			'section' => 'ads_header',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_header_target' => array(
			'name' => 'ads_header_target',
			'title' => esc_html__( 'Image Ad Link Target', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'self' => array(
					'name' => 'self',
					'title' => esc_html__( 'Self', 'quadro' )
				),
				'blank' => array(
					'name' => 'blank',
					'title' => esc_html__( 'Blank', 'quadro' )
				),
			),
			'description' => esc_html__('Select "Self" to open on the same browser\'s tab, or "Blank" to open a new one.', 'quadro'),
			'section' => 'ads_header',
			'tab' => 'advertising',
			'default' => 'self'
		),
		'ads_header_shortcode' => array(
			'name' => 'ads_header_shortcode',
			'title' => esc_html__( 'Ad Shortcode', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => esc_html__('Paste here shortcode from your Ads Plugin (overrides image upload)', 'quadro'),
			'section' => 'ads_header',
			'tab' => 'advertising',
			'default' => ''
		),
		// Pre Title Advertising Settings
		'ads_pretitle_show' => array(
			'name' => 'ads_pretitle_show',
			'title' => esc_html__( 'Ad Show/Hide', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'ads_posts_pretitle',
			'tab' => 'advertising',
			'default' => 'hide'
		),
		'ads_pretitle_upload' => array(
			'name' => 'ads_pretitle_upload',
			'title' => esc_html__( 'Image Ad Upload', 'quadro' ),
			'type' => 'upload',
			'description' => esc_html__('Upload an image for your ad', 'quadro'),
			'section' => 'ads_posts_pretitle',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_pretitle_url' => array(
			'name' => 'ads_pretitle_url',
			'title' => esc_html__( 'Image Ad Link', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Insert URL destination for your ad', 'quadro'),
			'section' => 'ads_posts_pretitle',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_pretitle_target' => array(
			'name' => 'ads_pretitle_target',
			'title' => esc_html__( 'Image Ad Link Target', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'self' => array(
					'name' => 'self',
					'title' => esc_html__( 'Self', 'quadro' )
				),
				'blank' => array(
					'name' => 'blank',
					'title' => esc_html__( 'Blank', 'quadro' )
				),
			),
			'description' => esc_html__('Select "Self" to open on the same browser\'s tab, or "Blank" to open a new one.', 'quadro'),
			'section' => 'ads_posts_pretitle',
			'tab' => 'advertising',
			'default' => 'self'
		),
		'ads_pretitle_shortcode' => array(
			'name' => 'ads_pretitle_shortcode',
			'title' => esc_html__( 'Ad Shortcode', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => esc_html__('Paste here shortcode from your Ads Plugin (overrides image upload)', 'quadro'),
			'section' => 'ads_posts_pretitle',
			'tab' => 'advertising',
			'default' => ''
		),
		// Post Title Advertising Settings
		'ads_posttitle_show' => array(
			'name' => 'ads_posttitle_show',
			'title' => esc_html__( 'Ad Show/Hide', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'ads_posts_posttitle',
			'tab' => 'advertising',
			'default' => 'hide'
		),
		'ads_posttitle_upload' => array(
			'name' => 'ads_posttitle_upload',
			'title' => esc_html__( 'Image Ad Upload', 'quadro' ),
			'type' => 'upload',
			'description' => esc_html__('Upload an image for your ad', 'quadro'),
			'section' => 'ads_posts_posttitle',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_posttitle_url' => array(
			'name' => 'ads_posttitle_url',
			'title' => esc_html__( 'Image Ad Link', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Insert URL destination for your ad', 'quadro'),
			'section' => 'ads_posts_posttitle',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_posttitle_target' => array(
			'name' => 'ads_posttitle_target',
			'title' => esc_html__( 'Image Ad Link Target', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'self' => array(
					'name' => 'self',
					'title' => esc_html__( 'Self', 'quadro' )
				),
				'blank' => array(
					'name' => 'blank',
					'title' => esc_html__( 'Blank', 'quadro' )
				),
			),
			'description' => esc_html__('Select "Self" to open on the same browser\'s tab, or "Blank" to open a new one.', 'quadro'),
			'section' => 'ads_posts_posttitle',
			'tab' => 'advertising',
			'default' => 'self'
		),
		'ads_posttitle_shortcode' => array(
			'name' => 'ads_posttitle_shortcode',
			'title' => esc_html__( 'Ad Shortcode', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => esc_html__('Paste here shortcode from your Ads Plugin (overrides image upload)', 'quadro'),
			'section' => 'ads_posts_posttitle',
			'tab' => 'advertising',
			'default' => ''
		),
		// Pre Content Advertising Settings
		'ads_precontent_show' => array(
			'name' => 'ads_precontent_show',
			'title' => esc_html__( 'Ad Show/Hide', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'ads_posts_precontent',
			'tab' => 'advertising',
			'default' => 'hide'
		),
		'ads_precontent_upload' => array(
			'name' => 'ads_precontent_upload',
			'title' => esc_html__( 'Image Ad Upload', 'quadro' ),
			'type' => 'upload',
			'description' => esc_html__('Upload an image for your ad', 'quadro'),
			'section' => 'ads_posts_precontent',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_precontent_url' => array(
			'name' => 'ads_precontent_url',
			'title' => esc_html__( 'Image Ad Link', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Insert URL destination for your ad', 'quadro'),
			'section' => 'ads_posts_precontent',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_precontent_target' => array(
			'name' => 'ads_precontent_target',
			'title' => esc_html__( 'Image Ad Link Target', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'self' => array(
					'name' => 'self',
					'title' => esc_html__( 'Self', 'quadro' )
				),
				'blank' => array(
					'name' => 'blank',
					'title' => esc_html__( 'Blank', 'quadro' )
				),
			),
			'description' => esc_html__('Select "Self" to open on the same browser\'s tab, or "Blank" to open a new one.', 'quadro'),
			'section' => 'ads_posts_precontent',
			'tab' => 'advertising',
			'default' => 'self'
		),
		'ads_precontent_shortcode' => array(
			'name' => 'ads_precontent_shortcode',
			'title' => esc_html__( 'Ad Shortcode', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => esc_html__('Paste here shortcode from your Ads Plugin (overrides image upload)', 'quadro'),
			'section' => 'ads_posts_precontent',
			'tab' => 'advertising',
			'default' => ''
		),
		// After Content Advertising Settings
		'ads_postcontent_show' => array(
			'name' => 'ads_postcontent_show',
			'title' => esc_html__( 'Ad Show/Hide', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'ads_posts_postcontent',
			'tab' => 'advertising',
			'default' => 'hide'
		),
		'ads_postcontent_upload' => array(
			'name' => 'ads_postcontent_upload',
			'title' => esc_html__( 'Image Ad Upload', 'quadro' ),
			'type' => 'upload',
			'description' => esc_html__('Upload an image for your ad', 'quadro'),
			'section' => 'ads_posts_postcontent',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_postcontent_url' => array(
			'name' => 'ads_postcontent_url',
			'title' => esc_html__( 'Image Ad Link', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Insert URL destination for your ad', 'quadro'),
			'section' => 'ads_posts_postcontent',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_postcontent_target' => array(
			'name' => 'ads_postcontent_target',
			'title' => esc_html__( 'Image Ad Link Target', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'self' => array(
					'name' => 'self',
					'title' => esc_html__( 'Self', 'quadro' )
				),
				'blank' => array(
					'name' => 'blank',
					'title' => esc_html__( 'Blank', 'quadro' )
				),
			),
			'description' => esc_html__('Select "Self" to open on the same browser\'s tab, or "Blank" to open a new one.', 'quadro'),
			'section' => 'ads_posts_postcontent',
			'tab' => 'advertising',
			'default' => 'self'
		),
		'ads_postcontent_shortcode' => array(
			'name' => 'ads_postcontent_shortcode',
			'title' => esc_html__( 'Ad Shortcode', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => esc_html__('Paste here shortcode from your Ads Plugin (overrides image upload)', 'quadro'),
			'section' => 'ads_posts_postcontent',
			'tab' => 'advertising',
			'default' => ''
		),
		// Inside Single Post Advertising Settings
		'ads_midcontent_show' => array(
			'name' => 'ads_midcontent_show',
			'title' => esc_html__( 'Ad Show/Hide', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'ads_posts_midcontent',
			'tab' => 'advertising',
			'default' => 'hide'
		),
		'ads_midcontent_paragraphs' => array(
			'name' => 'ads_midcontent_paragraphs',
			'title' => esc_html__( 'Insert ad after number of paragraphs', 'quadro' ),
			'type' => 'number',
			'min' => 1,
			'max' => 5000,
			'sanitize' => 'nohtml',
			'description' => '',
			'section' => 'ads_posts_midcontent',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_midcontent_upload' => array(
			'name' => 'ads_midcontent_upload',
			'title' => esc_html__( 'Image Ad Upload', 'quadro' ),
			'type' => 'upload',
			'description' => esc_html__('Upload an image for your ad', 'quadro'),
			'section' => 'ads_posts_midcontent',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_midcontent_url' => array(
			'name' => 'ads_midcontent_url',
			'title' => esc_html__( 'Image Ad Link', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Insert URL destination for your ad', 'quadro'),
			'section' => 'ads_posts_midcontent',
			'tab' => 'advertising',
			'default' => ''
		),
		'ads_midcontent_target' => array(
			'name' => 'ads_midcontent_target',
			'title' => esc_html__( 'Image Ad Link Target', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'self' => array(
					'name' => 'self',
					'title' => esc_html__( 'Self', 'quadro' )
				),
				'blank' => array(
					'name' => 'blank',
					'title' => esc_html__( 'Blank', 'quadro' )
				),
			),
			'description' => esc_html__('Select "Self" to open on the same browser\'s tab, or "Blank" to open a new one.', 'quadro'),
			'section' => 'ads_posts_midcontent',
			'tab' => 'advertising',
			'default' => 'self'
		),
		'ads_midcontent_shortcode' => array(
			'name' => 'ads_midcontent_shortcode',
			'title' => esc_html__( 'Ad Shortcode', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'html',
			'description' => esc_html__('Paste here shortcode from your Ads Plugin (overrides image upload)', 'quadro'),
			'section' => 'ads_posts_midcontent',
			'tab' => 'advertising',
			'default' => ''
		),
		/**
		 * Portfolio Options
		 */
		'portfolio_slug' => array(
			'name' => 'portfolio_slug',
			'title' => esc_html__( 'Portfolio Items Slug Prefix', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => wp_kses_post( __('This appears in the URL before the portfolio item slug. <strong>IMPORTANT: You must reflush permalinks after you modify this option.</strong>', 'quadro') ),
			'section' => 'portfolio',
			'tab' => 'portfolio',
			'default' => 'portfolio-item'
		),
		'portfolio_viewall_url' => array(
			'name' => 'portfolio_viewall_url',
			'title' => esc_html__( 'View All Items URL', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Leave empty if not in use.', 'quadro'),
			'section' => 'portfolio',
			'tab' => 'portfolio',
			'default' => ''
		),
		'portfolio_viewall' => array(
			'name' => 'portfolio_viewall',
			'title' => esc_html__( 'View All Items Text', 'quadro' ),
			'type' => 'text',
			'sanitize' => 'nohtml',
			'description' => esc_html__('Note: won\'t show up when loaded via AJAX.', 'quadro'),
			'section' => 'portfolio',
			'tab' => 'portfolio',
			'default' => 'View all'
		),
		'portfolio_keep_nav_in' => array(
			'name' => 'portfolio_keep_nav_in',
			'title' => esc_html__( 'Keep Navigation in Same Category', 'quadro' ),
			'type' => 'checkbox',
			'description' => esc_html__('Will work only for non-AJAX navigated items.', 'quadro'),
			'section' => 'portfolio',
			'tab' => 'portfolio',
			'default' => false
		),
		'portfolio_fields' => array(
			'name' => 'portfolio_fields',
			'title' => esc_html__( 'Data Fields', 'quadro' ),
			'type' => 'repeatable',
			'repeat_fields' => array(
				'title' => array(
					'name' => 'title',
					'title' => esc_html__( 'Field Title', 'quadro' ),
					'type' => 'text',
					'description' => ''
				),
				'slug' => array(
					'name' => 'slug',
					'title' => esc_html__( 'Field Slug', 'quadro' ),
					'type' => 'text',
					'description' => esc_html__( 'Internal use. Only lowercases, digits, "-" and "_" allowed.', 'quadro' )
				),
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Display Field Title', 'quadro' ),
					'type' => 'checkbox',
					'description' => esc_html__( 'If enabled the Field Title will be shown next to its data on the frontend.', 'quadro' )
				),

			),
			'repeat-item' => esc_html__('Add new Field', 'quadro'),
			'item-name' => esc_html__('Portfolio Data Field', 'quadro'),
			'description' => esc_html__('You can use as many fields as you want to display structured data on your portfolio items. Select which fields to show in each portfolio module on its Options metabox.', 'quadro'),
			'section' => 'portfolio',
			'tab' => 'portfolio',
			'default' => ''
		),
		'portf_transients_del' => array(
			'name' => 'portf_transients_del',
			'title' => esc_html__( 'Refresh Portfolio Transients', 'quadro' ),
			'type' => 'portf-transients-del',
			'description' => esc_html__( 'Use this button to reset "cached" portfolio items data. It won\'t delete anything, just reset the transients.', 'quadro' ),
			'section' => 'portfolio',
			'tab' => 'portfolio',
			'customizer' => 'exclude',
			'default' => ''
		),
		/**
		 * Woocommerce Options
		 */
		'header_cart' => array(
			'name' => 'header_cart',
			'title' => esc_html__( 'Show Cart Icon on Header', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'show' => array(
					'name' => 'show',
					'title' => esc_html__( 'Show', 'quadro' )
				),
				'hide' => array(
					'name' => 'hide',
					'title' => esc_html__( 'Hide', 'quadro' )
				),
			),
			'description' => '',
			'section' => 'woocommerce',
			'tab' => 'woocommerce',
			'default' => 'show'
		),
		'woo_sidebar' => array(
			'name' => 'woo_sidebar',
			'title' => esc_html__( 'Sidebar on Shop page', 'quadro' ),
			'type' => 'select',
			'valid_options' => array(
				'left' => array(
					'name' => 'left',
					'title' => esc_html__( 'Left positioned', 'quadro' )
				),
				'right' => array(
					'name' => 'right',
					'title' => esc_html__( 'Right positioned', 'quadro' )
				),
				'none' => array(
					'name' => 'none',
					'title' => esc_html__( 'None (full width)', 'quadro' )
				),
			),
			'description' => wp_kses_post( __( 'This option will use selected sidebar in <strong>Shop Page</strong>.', 'quadro' ) ),
			'section' => 'woocommerce',
			'tab' => 'woocommerce',
			'default' => 'left'
		),
		'woo_loop_number' => array(
			'name' => 'woo_loop_number',
			'title' => esc_html__( 'Number of items per page in Shop page', 'quadro' ),
			'type' => 'number',
			'min' => 1,
			'max' => 300,
			'description' => '',
			'section' => 'woocommerce',
			'tab' => 'woocommerce',
			'default' => '12'
		),
		'woo_loop_columns' => array(
			'name' => 'woo_loop_columns',
			'title' => esc_html__( 'Number of columns per row in Shop page', 'quadro' ),
			'type' => 'number',
			'min' => 2,
			'max' => 6,
			'description' => '',
			'section' => 'woocommerce',
			'tab' => 'woocommerce',
			'default' => '3'
		),
		'woo_related_number' => array(
			'name' => 'woo_related_number',
			'title' => esc_html__( 'Number of related products shown', 'quadro' ),
			'type' => 'number',
			'min' => 1,
			'max' => 60,
			'description' => '',
			'section' => 'woocommerce',
			'tab' => 'woocommerce',
			'default' => '4'
		),
		'woo_account_text' => array(
			'name' => 'woo_account_text',
			'title' => esc_html__( 'My Account Intro', 'quadro' ),
			'type' => 'textarea',
			'sanitize' => 'html',
			'description' => esc_html__('Add text before default "My account" content (gets added after Woocommerce user intro).', 'quadro'),
			'section' => 'woocommerce',
			'tab' => 'woocommerce',
			'default' => ''
		),
		'woo_login_text' => array(
			'name' => 'woo_login_text',
			'title' => esc_html__( 'Login/Register Intro', 'quadro' ),
			'type' => 'textarea',
			'sanitize' => 'html',
			'description' => esc_html__('Add text before login/register form.', 'quadro'),
			'section' => 'woocommerce',
			'tab' => 'woocommerce',
			'default' => ''
		),
		
	);
	return apply_filters( 'quadro_get_option_parameters', $options );
}
endif; // quadro_get_option_parameters


/**
 * Quadro Theme Admin Settings Page Tabs
 * 
 * Array that holds all of the tabs for the
 * Quadro Theme Settings Page. Each tab
 * key holds an array that defines the 
 * sections for each tab, including the
 * description text.
 * 
 * @return	array	$tabs	array of arrays of tab parameters
 */
if ( ! function_exists( 'quadro_get_settings_page_tabs' ) ) :
function quadro_get_settings_page_tabs() {
	$tabs = array( 
		'general' => array(
			'name' => 'general',
			'title' => esc_html__( 'General', 'quadro' ),
			'sections' => array(
				'branding' => array(
					'name' => 'branding',
					'title' => esc_html__( 'Branding', 'quadro' ),
					'description' => ''
				),
				'misc' => array(
					'name' => 'misc',
					'title' => esc_html__( 'Miscelaneous', 'quadro' ),
					'description' => esc_html__('', 'quadro')
				),
				'login' => array(
					'name' => 'login',
					'title' => esc_html__( 'User/Login Menu', 'quadro' ),
					'description' => esc_html__( 'This section enables a login link for your users at the top of the header site. If you want to include a sub-menu inside it, create a new menu by navigating to Appearance >> Menus, and then define it for the User/Login Menu location at Appearance >> Menus >> Manage Locations. You can leave that menu empty (without any items) if you only want to display a Logout link inside it.', 'quadro' )
				),
				'options' => array(
					'name' => 'options',
					'title' => esc_html__( 'Options & Content', 'quadro' ),
					'description' => ''
				),
				'updates' => array(
					'name' => 'updates',
					'title' => esc_html__( 'Theme Updates & License', 'quadro' ),
					'description' => ''
				),
			)
		),
		'layout' => array(
			'name' => 'layout',
			'title' => esc_html__( 'Layout', 'quadro' ),
			'sections' => array(
				'site' => array(
					'name' => 'site',
					'title' => esc_html__( 'General Layout', 'quadro' ),
					'description' => ''
				),
				'header' => array(
					'name' => 'header',
					'title' => esc_html__( 'Header Options', 'quadro' ),
					'description' => esc_html__( 'Manage Header options for Modules Theme.', 'quadro' )
				),
				'blog' => array(
					'name' => 'blog',
					'title' => esc_html__( 'Blog & Archives Options', 'quadro' ),
					'description' => wp_kses_post( __( 'Manage Blog and Archives options for Modules Theme.<br /><small>(Options selected in Blog modules over your site will override these)</small>', 'quadro' ) )
				),
				'single' => array(
					'name' => 'single',
					'title' => esc_html__( 'Single Blog Posts', 'quadro' ),
					'description' => ''
				),
				'footer' => array(
					'name' => 'footer',
					'title' => esc_html__( 'Footer Options', 'quadro' ),
					'description' => esc_html__( 'Manage Footer options for Modules Theme.', 'quadro' )
				),
				'sidebars' => array(
					'name' => 'sidebars',
					'title' => esc_html__( 'Sidebars', 'quadro' ),
					'description' => esc_html__( 'Add or remove Widget Areas', 'quadro' )
				),
			)
		),
		'design' => array(
			'name' => 'design',
			'title' => esc_html__( 'Design', 'quadro' ),
			'sections' => array(
				'colors' => array(
					'name' => 'colors',
					'title' => esc_html__( 'Colors', 'quadro' ),
					'description' => ''
				),
				'background' => array(
					'name' => 'background',
					'title' => esc_html__( 'Background', 'quadro' ),
					'description' => ''
				),
				'css' => array(
					'name' => 'css',
					'title' => esc_html__( 'Custom CSS', 'quadro' ),
					'description' => esc_html__( 'These CSS rules override all theme\'s CSS rules and are not deleted when you restore default settings.', 'quadro' )
				),
			)
		),
		'typography' => array(
			'name' => 'typography',
			'title' => esc_html__( 'Typography', 'quadro' ),
			'sections' => array(
				'fonts' => array(
					'name' => 'fonts',
					'title' => esc_html__( 'Font Options', 'quadro' ),
					'description' => ''
				),
				'colors' => array(
					'name' => 'colors',
					'title' => esc_html__( 'Colors', 'quadro' ),
					'description' => ''
				),
				'sizes' => array(
					'name' => 'sizes',
					'title' => esc_html__( 'Font Sizes', 'quadro' ),
					'description' => ''
				),
				'custom' => array(
					'name' => 'custom',
					'title' => esc_html__( 'Custom Font Upload', 'quadro' ),
					'description' => wp_kses_post( __( 'Font packages can be downloaded from sites like <a href="http://www.fontsquirrel.com/" target="_blank">Font Squirrel</a> and others. While you don\'t explicitly need to have all four font formats, uploading as many of them as you can will improve compatibility with more web browsers.', 'quadro' ) )
				),
			)
		),
		'social' => array(
			'name' => 'social',
			'title' => esc_html__( 'Social', 'quadro' ),
			'sections' => array(
				'profiles' => array(
					'name' => 'profiles',
					'title' => esc_html__( 'Social Networks Profiles', 'quadro' ),
					'description' => ''
				),
				'header-icons' => array(
					'name' => 'header-icons',
					'title' => esc_html__( 'Header Social Icons Settings', 'quadro' ),
					'description' => ''
				),
				'footer-icons' => array(
					'name' => 'footer-icons',
					'title' => esc_html__( 'Footer Social Icons Settings', 'quadro' ),
					'description' => ''
				),
				'general-social' => array(
					'name' => 'general-social',
					'title' => esc_html__( 'General Social Settings', 'quadro' ),
					'description' => ''
				),
				'user-contact' => array(
					'name' => 'user-contact',
					'title' => esc_html__( 'User Contact Methods', 'quadro' ),
					'description' => '<p>' . esc_html__('Use this section to define available contact methods for all your users, to be edited on the Your Profile page (and used on author archives, author modules, author box, and team modules).', 'quadro') . '</p><p>' . esc_html__( 'For the \'slug\' field, enter the name of the social network you want to use. It should be all lowercase letters, and match the proper ', 'quadro' ) . '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">' . esc_html__('icon name on Font Awesome.', 'quadro' ) . '</a></p><p>' . esc_html__('Twitter example: Name|Twitter  -  Slug|twitter', 'quadro') . '<br />' . esc_html__('Email example: Name|Email  -  Slug|envelope', 'quadro') . '</p>'
				),
			)
		),
		'advertising' => array(
			'name' => 'advertising',
			'title' => esc_html__( 'Advertising', 'quadro' ),
			'sections' => array(
				'ads_header' => array(
					'name' => 'ads_header',
					'title' => esc_html__( 'On Header Ad', 'quadro' ),
					'description' => esc_html__( 'Manage advertising shortcodes or banners for the site\'s header.', 'quadro' ),
				),
				'ads_posts_pretitle' => array(
					'name' => 'ads_posts_pretitle',
					'title' => esc_html__( 'On Posts Ads - Before Title', 'quadro' ),
					'description' => esc_html__( 'Manage advertising shortcodes or banners across site\'s posts.', 'quadro' ),
				),
				'ads_posts_posttitle' => array(
					'name' => 'ads_posts_posttitle',
					'title' => esc_html__( 'On Posts Ads - After Title', 'quadro' ),
					'description' => esc_html__( 'Manage advertising shortcodes or banners across site\'s posts.', 'quadro' ),
				),
				'ads_posts_precontent' => array(
					'name' => 'ads_posts_precontent',
					'title' => esc_html__( 'On Posts Ads - Before Content', 'quadro' ),
					'description' => esc_html__( 'Manage advertising shortcodes or banners across site\'s posts.', 'quadro' ),
				),
				'ads_posts_postcontent' => array(
					'name' => 'ads_posts_postcontent',
					'title' => esc_html__( 'On Posts Ads - After Content', 'quadro' ),
					'description' => esc_html__( 'Manage advertising shortcodes or banners across site\'s posts.', 'quadro' ),
				),
				'ads_posts_midcontent' => array(
					'name' => 'ads_posts_midcontent',
					'title' => esc_html__( 'On Posts Ads - Inside Content', 'quadro' ),
					'description' => esc_html__( 'Manage advertising shortcodes or banners across site\'s posts.', 'quadro' ),
				),
			)
		),
		'portfolio' => array(
			'name' => 'portfolio',
			'title' => esc_html__( 'Portfolio', 'quadro' ),
			'sections' => array(
				'portfolio' => array(
					'name' => 'portfolio',
					'title' => esc_html__( 'Portfolio Options', 'quadro' ),
					'description' => esc_html__('Once you modify an option here you will probably need to refresh the Portfolio Transients by using the button down below this page. If you don\'t see your changes being applied, start with that.', 'quadro')
				),
			)
		),
		'woocommerce' => array(
			'name' => 'woocommerce',
			'title' => esc_html__( 'WooCommerce', 'quadro' ),
			'sections' => array(
				'woocommerce' => array(
					'name' => 'woocommerce',
					'title' => esc_html__( 'WooCommerce Options', 'quadro' ),
					'description' => esc_html__('Settings for WooCommerce Plugin used with Modules theme.', 'quadro')
				),
			)
		),
	);
	return apply_filters( 'quadro_get_settings_page_tabs', $tabs );
}
endif; // quadro_get_settings_page_tabs


?>
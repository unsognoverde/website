<?php

$prefix = 'quadro_';

/*-----------------------------------------------------------------------------------*/
/*	Meta Boxes & Options for Posts
/*-----------------------------------------------------------------------------------*/

// Define available modules
$available_modules = array( 
	'Authors'						=> 'authors',
	'Blog' 							=> 'blog',
	'Canvas' 						=> 'canvas',
	'Carousel' 						=> 'carousel',
	'Crelly slider' 				=> 'crelly',
	'Featured Post' 				=> 'featured',
	'Flash News' 					=> 'flashnews',
	'Image'							=> 'image',
	'Insights'						=> 'insights',
	'Slidable Insights'				=> 'sl_insights',
	'Logos Roll'					=> 'logos',
	'Magazine' 						=> 'magazine',
	'Portfolio'						=> 'portfolio',
	'Quote Posts Slider'			=> 'quoteposts',
	'Services'						=> 'services',
	'Slider' 						=> 'slider',
	'Posts Slider' 					=> 'pslider',
	'Slogan' 						=> 'slogan',
	'Team'							=> 'team',
	'Testimonials'					=> 'testimonials',
	'Tiled Display' 				=> 'display',
	'Video Posts Slider'			=> 'videoposts',
	'Modules Tabs'					=> 'tabs',
	'Modules Wrapper (W/Sidebar)'	=> 'wrapper',
);

// Apply Filter Available Modules
$available_modules = apply_filters( 'qi_filter_available_modules', $available_modules );

// Create Modules definition array
foreach ($available_modules as $type => $slug) {
	$modules_array[] = array( 'type' => $type, 'slug' => $slug );
}

$quadro_cfields_def = array(

	// Adding Posts basic meta box
	'post_metabox' => array(
		'id' => 'post-metabox',
		'title' => esc_html__('Post Header Options', 'quadro'),
		'page' => 'post',
		'context' => 'side',
		'priority' => 'default',
		'fields' => array(
			array(
				'name' => esc_html__('Header Size', 'quadro'),
				'id' => $prefix . 'post_header_size',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Regular', 'quadro' ), 'value' => 'regular'),
					array('name' => esc_html__('Big', 'quadro' ), 'value' => 'big'),
					array('name' => esc_html__('Giant', 'quadro' ), 'value' => 'giant'),
					),
				'std' => 'regular'
			),
			array(
				'name' => esc_html__('Use as Background', 'quadro'),
				'id' => $prefix . 'post_header_back',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Featured Image', 'quadro' ), 'value' => 'featured'),
					array('name' => esc_html__('Solid Color', 'quadro' ), 'value' => 'color'),
					),
				'std' => 'featured'
			),
			array(
				'name' => esc_html__('Back color', 'quadro'),
				'id' => $prefix . 'post_header_back_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Text color', 'quadro'),
				'id' => $prefix . 'post_header_text_color',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Automatic', 'quadro' ), 'value' => 'auto'),
					array('name' => esc_html__('Dark', 'quadro' ), 'value' => 'dark'),
					array('name' => esc_html__('Light', 'quadro' ), 'value' => 'light'),
					),
				'std' => 'auto'
			),
			array(
				'name' => esc_html__('Dark Background Overlay', 'quadro'),
				'id' => $prefix . 'post_header_overlay',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Enabled', 'quadro' ), 'value' => 'on'),
					array('name' => esc_html__('Disabled', 'quadro' ), 'value' => 'off'),
					),
				'std' => 'on'
			),
		)
	),

	// Adding Modular Template meta box
	'modular_template_metabox' => array(
		'id' => 'modular-qi-template-metabox',
		'title' => esc_html__('Modular Template Options', 'quadro'),
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Choose Modules to Show', 'quadro'),
				'id' => $prefix . 'mod_temp_modules',
				'type' => 'posts_picker',
				'post_type' => 'quadro_mods',
				'available_mods' => $available_modules,
				'show_type' => false
			),
			array(
				'name' => esc_html__('Modules Navigation', 'quadro'),
				'id' => $prefix . 'mod_temp_navigation',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Disabled', 'quadro' ), 'value' => 'off'),
					array('name' => esc_html__('Enabled', 'quadro' ), 'value' => 'on'),
					),
				'std' => 'off'
			),
		)
	),

	// Adding Pages basic meta box
	'page_metabox' => array(
		'id' => 'page-metabox',
		'title' => esc_html__('Page Options', 'quadro'),
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Site Header Style', 'quadro'),
				'id' => $prefix . 'site_header_style',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Same as site', 'quadro' ), 'value' => 'same'),
					array('name' => esc_html__('With background', 'quadro' ), 'value' => 'background'),
					array('name' => esc_html__('Transparent', 'quadro' ), 'value' => 'transparent'),
					),
				'desc' => esc_html__('Overrides Theme Options Header Style Setting. Note: won\'t apply for Header Layout 7.', 'quadro'),
				'std' => 'same'
			),
			array(
				'name' => esc_html__('Color for Transparent Site Header', 'quadro'),
				'id' => $prefix . 'site_header_color',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Same as site', 'quadro' ), 'value' => 'same'),
					array('name' => esc_html__('Light', 'quadro' ), 'value' => 'light'),
					array('name' => esc_html__('Dark', 'quadro' ), 'value' => 'dark'),
					),
				'std' => 'same'
			),
			array(
				'name' => esc_html__('Select Sidebar', 'quadro'),
				'id' => $prefix . 'page_sidebar',
				'type' => 'sidebar_picker',
			),
			array(
				'name' => esc_html__('Hide Page Header (homepage use, for example)', 'quadro'),
				'id' => $prefix . 'page_header_hide',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('Page Header Position', 'quadro'),
				'id' => $prefix . 'page_header_pos',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Center', 'quadro' ), 'value' => 'center'),
					array('name' => esc_html__('Left', 'quadro' ), 'value' => 'left'),
					),
				'std' => 'center'
			),
			array(
				'name' => esc_html__('Page Header Size', 'quadro'),
				'id' => $prefix . 'page_header_size',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Regular', 'quadro' ), 'value' => 'regular'),
					array('name' => esc_html__('Big', 'quadro' ), 'value' => 'big'),
					),
				'std' => 'regular'
			),
			array(
				'name' => esc_html__('Breadcrumbs on this page', 'quadro'),
				'id' => $prefix . 'page_breadcrumbs',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide')
					),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Title color', 'quadro'),
				'id' => $prefix . 'page_title_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Header Back color', 'quadro'),
				'id' => $prefix . 'page_header_back_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Use Picture as Header Back (uses Feat. Image)', 'quadro'),
				'id' => $prefix . 'page_header_back_usepic',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('Display Tagline', 'quadro'),
				'id' => $prefix . 'page_show_tagline',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('Tagline text', 'quadro'),
				'id' => $prefix . 'page_tagline',
				'type' => 'textarea',
				'sanitize' => 'html',
				'desc' => ''
			),
			array(
				'name' => esc_html__('Use Picture as Page Back', 'quadro'),
				'id' => $prefix . 'page_back_usepic',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('Background for this Page', 'quadro'),
				'id' => $prefix . 'page_back_pic',
				'type' => 'upload'
			)
		)
	),

	// Adding modules Types meta box
	'mod_type_metabox' => array(
		'id' => 'mod-type-metabox',
		'title' => esc_html__('Module Type', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Select Module Type', 'quadro'),
				'id' => $prefix . 'mod_type',
				'type' => 'double_select',
				'options' => $modules_array
			),
		)
	),

	// Adding modules Fields Container meta box
	'mod_container_metabox' => array(
		'id' => 'mod-container-metabox',
		'title' => esc_html__('Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array()
	),

	// Adding modules basic meta box
	'mod_metabox' => array(
		'id' => 'mod-metabox',
		'title' => esc_html__('Module Style', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Module Header', 'quadro'),
				'id' => $prefix . 'mod_header_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Header Layout', 'quadro'),
				'id' => $prefix . 'mod_header_layout',
				'type' => 'layout-picker',
				'path' => '/images/admin/module-header/',
				'options' => array(
					'none' => array(
						'name' => 'none',
						'title' => esc_html__( 'No Header', 'quadro' ),
						'img' => 'mod-header-none.png',
						'description' => '',
					),
					'fullwidth' => array(
						'name' => 'fullwidth',
						'title' => esc_html__( 'Fullwidth', 'quadro' ),
						'img' => 'mod-header-full.png',
						'description' => '',
					),
					'integrated' => array(
						'name' => 'integrated',
						'title' => esc_html__( 'Integrated', 'quadro' ),
						'img' => 'mod-header-integrated.png',
						'description' => '',
					),
					'left' => array(
						'name' => 'left',
						'title' => esc_html__( 'Left Header', 'quadro' ),
						'img' => 'mod-header-left.png',
						'description' => '',
					),
					'right' => array(
						'name' => 'right',
						'title' => esc_html__( 'Right Header', 'quadro' ),
						'img' => 'mod-header-right.png',
						'description' => '',
					),
					'left-50' => array(
						'name' => 'left-50',
						'title' => esc_html__( 'Left Header - 50%', 'quadro' ),
						'img' => 'mod-header-left-50.png',
						'description' => '',
					),
					'right-50' => array(
						'name' => 'right-50',
						'title' => esc_html__( 'Right Header - 50%', 'quadro' ),
						'img' => 'mod-header-right-50.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Module Introduction', 'quadro'),
				'id' => $prefix . 'mod_intro',
				'type' => 'textarea',
			),
			array(
				'name' => esc_html__('Button Text', 'quadro'),
				'id' => $prefix . 'mod_header_btn',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('(Optional) Leave empty for no button.', 'quadro')
			),
			array(
				'name' => esc_html__('Button Link', 'quadro'),
				'id' => $prefix . 'mod_header_btn_url',
				'type' => 'text',
				'std' => '',
			),
			array(
				'name' => esc_html__('Title color', 'quadro'),
				'id' => $prefix . 'mod_title_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Header background color', 'quadro'),
				'id' => $prefix . 'mod_title_back',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => '',
				'id' => $prefix . 'mod_title_back_usepic',
				'type' => 'checkbox',
				'desc' => esc_html__('Use Picture as Header Background', 'quadro'),
			),
			array(
				'name' => esc_html__('Header Image Background', 'quadro'),
				'id' => $prefix . 'mod_title_back_pic',
				'type' => 'upload'
			),
			array(
				'name' => esc_html__('Module Background', 'quadro'),
				'id' => $prefix . 'mod_back_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Background color', 'quadro'),
				'id' => $prefix . 'mod_back_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Background pattern', 'quadro'),
				'id' => $prefix . 'mod_back_pattern',
				'type' => 'pattern_picker'
			),
			array(
				'name' => '',
				'id' => $prefix . 'mod_back_usepic',
				'type' => 'checkbox',
				'desc' => esc_html__('Use Picture as Background', 'quadro'),
			),
			array(
				'name' => esc_html__('Image Background', 'quadro'),
				'id' => $prefix . 'mod_back_pic',
				'type' => 'upload'
			),
			array(
				'name' => esc_html__('Dark Background Overlay', 'quadro'),
				'id' => $prefix . 'mod_overlay',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Disabled', 'quadro' ), 'value' => 'off'),
					array('name' => esc_html__('Enabled', 'quadro' ), 'value' => 'on'),
					),
				'std' => 'off'
			),
			array(
				'name' => '',
				'id' => $prefix . 'mod_parallax',
				'type' => 'checkbox',
				'desc' => esc_html__('Fixed Background', 'quadro'),
			),
		)
	),

	// Adding quadro_portfolio meta boxes for Portfolio type
	'quadro_portfolio_meta_box' => array(
		'id' => 'quadro-portfolio-metabox',
		'title' => esc_html__('Portfolio Item Options', 'quadro'),
		'page' => 'quadro_portfolio',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
			array(
				'name' => esc_html__('Item Style', 'quadro'),
				'id' => $prefix . 'portfolio_item_style',
				'type' => 'layout-picker',
				'path' => '/images/admin/single-port-layouts/',
				'options' => array(
					'portf-layout1' => array(
						'name' => 'portf-layout1',
						'title' => esc_html__( 'Content on Right w/Expanded Media', 'quadro' ),
						'img' => 'portf-layout1.png',
						'description' => '',
					),
					'portf-layout2' => array(
						'name' => 'portf-layout2',
						'title' => esc_html__( 'Content on Right w/Media Slider', 'quadro' ),
						'img' => 'portf-layout2.png',
						'description' => '',
					),
					'portf-layout3' => array(
						'name' => 'portf-layout3',
						'title' => esc_html__( 'Content on Top w/Expanded Media', 'quadro' ),
						'img' => 'portf-layout3.png',
						'description' => '',
					),
					'portf-layout4' => array(
						'name' => 'portf-layout4',
						'title' => esc_html__( 'Content on Top w/Media Slider', 'quadro' ),
						'img' => 'portf-layout4.png',
						'description' => '',
					),
					'portf-layout5' => array(
						'name' => 'portf-layout5',
						'title' => esc_html__( 'Masonry Grid (three columns)', 'quadro' ),
						'img' => 'portf-layout5.png',
						'description' => '',
					),
					'portf-layout5b' => array(
						'name' => 'portf-layout5b',
						'title' => esc_html__( 'Masonry Grid (two columns)', 'quadro' ),
						'img' => 'portf-layout5b.png',
						'description' => '',
					),
					'portf-layout6' => array(
						'name' => 'portf-layout6',
						'title' => esc_html__( 'Large Media Slider w/Slidable Content', 'quadro' ),
						'img' => 'portf-layout6.png',
						'description' => '',
					),
					'as-created' => array(
						'name' => 'as-created',
						'title' => esc_html__( 'As Created & Formatted', 'quadro' ),
						'img' => 'as-created.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'portf-layout1'
			),
			array(
				'name' => esc_html__('Video Position', 'quadro'),
				'id' => $prefix . 'portfolio_video_position',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('After Gallery/Image', 'quadro' ), 'value' => 'gallery,video'),
					array('name' => esc_html__('Before Gallery/Image', 'quadro' ), 'value' => 'video,gallery'),
					),
				'std' => 'gallery,video'
			),
			array(
				'name' => esc_html__('Keep video out of slider', 'quadro'),
				'id' => $prefix . 'portfolio_video_out',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('External Link', 'quadro'),
				'id' => $prefix . 'portfolio_link',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Link Title', 'quadro'),
				'id' => $prefix . 'portfolio_link_title',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Wrap images with links', 'quadro'),
				'id' => $prefix . 'portfolio_img_link',
				'type' => 'checkbox',
				'desc' => esc_html__('Links images in galleries to their own files (useful for use with lightbox plugins).', 'quadro')
			),
			array(
				'name' => esc_html__('View All Items URL', 'quadro'),
				'id' => $prefix . 'portfolio_viewall_url',
				'type' => 'text',
				'desc' => esc_html__('Note: will override Theme Options setting.', 'quadro')
			),
			array(
				'name' => esc_html__('View All Items Text', 'quadro'),
				'id' => $prefix . 'portfolio_viewall',
				'type' => 'text',
				'desc' => esc_html__('Note: will override Theme Options setting.', 'quadro')
			),
			array(
				'name' => esc_html__('Data Fields', 'quadro'),
				'id' => $prefix . 'portfolio_fields',
				'type' => 'portfolio-fields-input',
				'desc' => esc_html__('Add new data fields in', 'quadro') . ' <a href="' . esc_url( admin_url( 'themes.php?page=quadro-settings&tab=portfolio' ) ) . '">' . esc_html__('Theme Options >> Portfolio Tab', 'quadro') . '</a>.<br />' . esc_html__('Fields with completed info will be shown on this Item\'s view.', 'quadro')
			),
		)
	),

);

$quadro_cfields_mods_def = array(

	// Adding modules TABS Type meta box
	'mod_tabs_type_metabox' => array(
		'id' => 'mod-tabs-qi-type-metabox',
		'title' => esc_html__('Modules Tabs Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => wp_kses_post( __('Choose Modules to Show <small>Each selected module will create a tab for itself.</small>', 'quadro') ),
				'id' => $prefix . 'mod_tabs_modules',
				'type' => 'posts_picker',
				'post_type' => 'quadro_mods',
				'available_mods' => $available_modules,
				'show_type' => false,
				'wrapper' => true
			),
			array(
                'name' => wp_kses_post( __('Tabs Titles <br /><small>These need to be added manually and in proper order.<small>', 'quadro') ),
                'id' => $prefix . 'mod_tabs_titles',
                'type' => 'repeatable',
                'item-name' => esc_html__('Tab', 'quadro'),
                'repeat-fields' => array(
                	'title' => array( 'name' => 'title', 'title' => 'Title', 'type' => 'text' ),
                ),
                'repeat-item' => esc_html__('Add another Title', 'quadro'),
                'dependant'
            ),
		)
	),

	// Adding modules IMAGE Type meta box
	'mod_image_type_metabox' => array(
		'id' => 'mod-image-qi-type-metabox',
		'title' => esc_html__('Image Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Note:', 'quadro'),
				'id' => $prefix . 'mod_image_desc',
				'type' => 'subtitle',
				'desc' => esc_html__('Upload an image for this module through the Media Manager or via the "Set Featured Image" metabox, and set it as featured image.', 'quadro'),
			),
		)
	),

	// Adding modules WRAPPER Type meta box
	'mod_wrapper_type_metabox' => array(
		'id' => 'mod-wrapper-qi-type-metabox',
		'title' => esc_html__('Wrapper Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Sidebar Position', 'quadro'),
				'id' => $prefix . 'mod_wrapper_sidebar',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Right', 'quadro' ), 'value' => 'right'),
					array('name' => esc_html__('Left', 'quadro' ), 'value' => 'left'),
				),
				'std' => 'right'
			),
			array(
				'name' => esc_html__('Select Sidebar', 'quadro'),
				'id' => $prefix . 'mod_wrapper_sidebar_pick',
				'type' => 'sidebar_picker',
			),
			array(
				'name' => esc_html__('Choose Modules to Show', 'quadro'),
				'id' => $prefix . 'mod_wrapper_modules',
				'type' => 'posts_picker',
				'post_type' => 'quadro_mods',
				'available_mods' => $available_modules,
				'show_type' => false,
				'wrapper' => true
			),
		)
	),

	// Adding modules CAROUSEL Type meta box
	'mod_carousel_type_metabox' => array(
		'id' => 'mod-carousel-qi-type-metabox',
		'title' => esc_html__('Carousel Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Margins (make full width)', 'quadro'),
				'id' => $prefix . 'mod_carousel_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('With Margins', 'quadro' ), 'value' => 'with-margins'),
					array('name' => esc_html__('Without Margins', 'quadro' ), 'value' => 'no-margins'),
				),
				'std' => 'with-margins'
			),
			array(
				'name' => esc_html__('How many posts to show?', 'quadro'),
				'id' => $prefix . 'mod_carousel_pper',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('Enter -1 to show all posts.', 'quadro')
			),
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_carousel_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'quadro' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'quadro' ), 'value' => 'tax'),
					array('name' => esc_html__('By Post Format', 'quadro' ), 'value' => 'format'),
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'quadro'),
				'id' => $prefix . 'mod_carousel_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'quadro'),
				'id' => $prefix . 'mod_carousel_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'quadro'),
				'id' => $prefix . 'mod_pick_carousel',
				'type' => 'posts_picker',
				'post_type' => array( 'post', 'product', 'quadro_portfolio' ),
				'show_type' => true
			),
			array(
				'name' => esc_html__('Posts Offset', 'quadro'),
				'id' => $prefix . 'mod_carousel_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'quadro')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'quadro'),
				'id' => $prefix . 'mod_carousel_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'quadro')
			),
		)
	),

	// Adding modules LOGOS ROLL Type meta box
	'mod_logos_type_metabox' => array(
		'id' => 'mod-logos-qi-type-metabox',
		'title' => esc_html__('Logos Roll Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Layout', 'quadro'),
				'id' => $prefix . 'mod_logos_layout',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Carousel', 'quadro' ), 'value' => 'carousel'),
					array('name' => esc_html__('Still', 'quadro' ), 'value' => 'still'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Columns', 'quadro'),
				'id' => $prefix . 'mod_logos_columns',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('3', 'quadro' ), 'value' => 'three'),
					array('name' => esc_html__('4', 'quadro' ), 'value' => 'four'),
					array('name' => esc_html__('5', 'quadro' ), 'value' => 'five'),
					array('name' => esc_html__('6', 'quadro' ), 'value' => 'six'),
				),
				'std' => 'three'
			),
			array(
                'name' => esc_html__('', 'quadro'),
                'id' => $prefix . 'mod_logos_content',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many logos as you want, one at a time.', 'quadro'),
                'item-name' => esc_html__('Logo', 'quadro'),
                'repeat-fields' => array(
                	'img' => array( 'name' => 'img', 'title' => 'Image File', 'type' => 'upload' ),
                	'link_url' => array( 'name' => 'link_url', 'title' => 'Link (URL)', 'type' => 'text' ),
                ),
                'repeat-item' => esc_html__('Add another Logo', 'quadro')
            ),
		)
	),

	// Adding modules CRELLY SLIDER Type meta box
	'mod_crelly_type_metabox' => array(
		'id' => 'mod-crelly-qi-type-metabox',
		'title' => esc_html__('Crelly Slider Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Slider Shortcode', 'quadro'),
				'id' => $prefix . 'mod_crelly_shortcode',
				'type' => 'text',
				'desc' => esc_html__('Paste in this field the shortcode for the slider as you would normally paste on any page.', 'quadro')
			),
		)
	),

	// Adding modules DISPLAY Type meta box
	'mod_display_type_metabox' => array(
		'id' => 'mod-display-qi-type-metabox',
		'title' => esc_html__('Display Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Display Style', 'quadro'),
				'id' => $prefix . 'mod_display_layout',
				'type' => 'layout-picker',
				'path' => '/images/admin/display-styles/',
				'options' => array(
					'layout1' => array(
						'name' => 'layout1',
						'title' => esc_html__( 'Layout 1', 'quadro' ),
						'img' => 'display-style1.png',
						'description' => '',
					),
					'layout2' => array(
						'name' => 'layout2',
						'title' => esc_html__( 'Layout 2', 'quadro' ),
						'img' => 'display-style2.png',
						'description' => '',
					),
					'layout3' => array(
						'name' => 'layout3',
						'title' => esc_html__( 'Layout 3', 'quadro' ),
						'img' => 'display-style3.png',
						'description' => '',
					),
					'layout4' => array(
						'name' => 'layout4',
						'title' => esc_html__( 'Layout 4', 'quadro' ),
						'img' => 'display-style4.png',
						'description' => '',
					),
					'layout5' => array(
						'name' => 'layout5',
						'title' => esc_html__( 'Layout 5', 'quadro' ),
						'img' => 'display-style5.png',
						'description' => '',
					),
				),
				'desc' => wp_kses_post( __( 'To use layouts 1 or 3 <strong>large thumbnail</strong> size must be set on WordPress defaults of 1024 by 1024 pixels.', 'quadro' ) ),
				'std' => 'layout1'
			),
			array(
				'name' => esc_html__('Margins (make full width)', 'quadro'),
				'id' => $prefix . 'mod_display_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('With Margins', 'quadro' ), 'value' => 'with-margins'),
					array('name' => esc_html__('Without Margins', 'quadro' ), 'value' => 'no-margins'),
				),
				'std' => 'with-margins'
			),
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_display_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'quadro' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'quadro' ), 'value' => 'tax'),
					array('name' => esc_html__('By Post Format', 'quadro' ), 'value' => 'format'),
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'quadro'),
				'id' => $prefix . 'mod_display_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'quadro'),
				'id' => $prefix . 'mod_display_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'quadro'),
				'id' => $prefix . 'mod_pick_display',
				'type' => 'posts_picker',
				'post_type' => array( 'post', 'product' ),
				'show_type' => true
			),
			array(
				'name' => esc_html__('Posts Offset', 'quadro'),
				'id' => $prefix . 'mod_display_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'quadro')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'quadro'),
				'id' => $prefix . 'mod_display_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'quadro')
			),
		)
	),

	// Adding modules FLASH NEWS Type meta box
	'mod_flashnews_type_metabox' => array(
		'id' => 'mod-flashnews-qi-type-metabox',
		'title' => esc_html__('Flash News Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('How many posts to show?', 'quadro'),
				'id' => $prefix . 'mod_flashnews_pper',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('Enter -1 to show all posts.', 'quadro')
			),
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_flashnews_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'quadro' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'quadro' ), 'value' => 'tax'),
					array('name' => esc_html__('By Post Format', 'quadro' ), 'value' => 'format'),
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'quadro'),
				'id' => $prefix . 'mod_flashnews_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'quadro'),
				'id' => $prefix . 'mod_flashnews_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'quadro'),
				'id' => $prefix . 'mod_pick_flashnews',
				'type' => 'posts_picker',
				'post_type' => array( 'post' ),
				'show_type' => true
			),
			array(
				'name' => esc_html__('Posts Offset', 'quadro'),
				'id' => $prefix . 'mod_flashnews_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'quadro')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'quadro'),
				'id' => $prefix . 'mod_flashnews_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'quadro')
			),
		)
	),

	// Adding modules INSIGHTS Type meta box
	'mod_insights_type_metabox' => array(
		'id' => 'mod-insights-qi-type-metabox',
		'title' => esc_html__('Insights Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Text Color', 'quadro'),
				'id' => $prefix . 'mod_insights_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Animation', 'quadro'),
				'id' => $prefix . 'mod_insights_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Animation Delay Between Elements (in ms.)', 'quadro'),
				'id' => $prefix . 'mod_insights_anim_delay',
				'type' => 'number',
			),
			array(
                'name' => esc_html__('Insights', 'quadro'),
                'id' => $prefix . 'mod_insights',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many Insights as you want, one at a time.', 'quadro'),
                'repeat-fields' => array(
                	'title' => array( 'name' => 'title', 'title' => 'Title', 'type' => 'text' ),
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'textarea' ),
                	'img' => array( 'name' => 'img', 'title' => 'Image', 'type' => 'upload' ),
                	'button_text' => array( 'name' => 'button_text', 'title' => 'Button Text', 'type' => 'text' ),
                	'button_url' => array( 'name' => 'button_url', 'title' => 'Button Link', 'type' => 'text' ),
                	'layout' => array( 
                		'name' => 'layout', 
                		'title' => 'Layout', 
                		'type' => 'layout-picker',
                		'path' => '/images/admin/insight-layouts/',
                		'std' => 'layout1',
                		'options' => array(
							'layout1' => array(
								'name' => 'layout1',
								'title' => esc_html__( 'Layout 1', 'quadro' ),
								'img' => 'insight-layout1.png',
								'description' => '',
							),
							'layout2' => array(
								'name' => 'layout2',
								'title' => esc_html__( 'Layout 2', 'quadro' ),
								'img' => 'insight-layout2.png',
								'description' => '',
							),
							'layout3' => array(
								'name' => 'layout3',
								'title' => esc_html__( 'Layout 3', 'quadro' ),
								'img' => 'insight-layout3.png',
								'description' => '',
							),
							'layout4' => array(
								'name' => 'layout4',
								'title' => esc_html__( 'Layout 4', 'quadro' ),
								'img' => 'insight-layout4.png',
								'description' => '',
							),
						),
                	),
                ),
                'item-name' => esc_html__('Insight', 'quadro'),
                'repeat-item' => esc_html__('Add another Insight', 'quadro'),
            ),
		)
	),

	// Adding modules MAGAZINE Type meta box
	'mod_magazine_type_metabox' => array(
		'id' => 'mod-magazine-qi-type-metabox',
		'title' => esc_html__('Magazine Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Magazine Style', 'quadro'),
				'id' => $prefix . 'mod_magazine_layout',
				'type' => 'layout-picker',
				'path' => '/images/admin/magazine-styles/',
				'options' => array(
					'layout1' => array(
						'name' => 'layout1',
						'title' => esc_html__( 'Layout 1', 'quadro' ),
						'img' => 'magazine-style1.png',
						'description' => '',
					),
					'layout2' => array(
						'name' => 'layout2',
						'title' => esc_html__( 'Layout 2', 'quadro' ),
						'img' => 'magazine-style2.png',
						'description' => '',
					),
					'layout3' => array(
						'name' => 'layout3',
						'title' => esc_html__( 'Layout 3', 'quadro' ),
						'img' => 'magazine-style3.png',
						'description' => '',
					),
					'layout4' => array(
						'name' => 'layout4',
						'title' => esc_html__( 'Layout 4', 'quadro' ),
						'img' => 'magazine-style4.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'layout1'
			),
			array(
				'name' => esc_html__('Columns', 'quadro'),
				'id' => $prefix . 'mod_magazine_columns',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Two', 'quadro' ), 'value' => 'two'),
					array('name' => esc_html__('Three', 'quadro' ), 'value' => 'three'),
				),
				'desc' => esc_html__('Applies only for layouts 2 and 4.', 'quadro'),
				'std' => 'two'
			),
			array(
				'name' => esc_html__('How many posts to show?', 'quadro'),
				'id' => $prefix . 'mod_magazine_perpage',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('Applies only for layout 4. Enter -1 to show all posts.', 'quadro')
			),
			array(
				'name' => esc_html__('Excerpt', 'quadro'),
				'id' => $prefix . 'mod_magazine_excerpt',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide'),
				),
				'desc' => esc_html__('Applies only for layout 4.', 'quadro'),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Exclude Posts Without Thumbnail?', 'quadro'),
				'id' => $prefix . 'mod_magazine_nothumb',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_magazine_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Latest Posts', 'quadro' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'quadro' ), 'value' => 'tax'),
					array('name' => esc_html__('By Post Format', 'quadro' ), 'value' => 'format'),
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'quadro'),
				'id' => $prefix . 'mod_magazine_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'quadro'),
				'id' => $prefix . 'mod_magazine_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'quadro'),
				'id' => $prefix . 'mod_pick_magazine',
				'type' => 'posts_picker',
				'post_type' => array( 'post' ),
				'show_type' => true
			),
			array(
				'name' => esc_html__('Posts Offset', 'quadro'),
				'id' => $prefix . 'mod_magazine_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'quadro')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'quadro'),
				'id' => $prefix . 'mod_magazine_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma. Using this setting disables \'-1\' setting for posts quantity.', 'quadro')
			),
		)
	),

	// Adding modules SLOGAN Type meta box
	'mod_slogan_type_metabox' => array(
		'id' => 'mod-slogan-qi-type-metabox',
		'title' => esc_html__('Slogan Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Slogan Text', 'quadro'),
				'id' => $prefix . 'mod_slogan_text',
				'type' => 'prev-editor'
			),
			array(
				'name' => esc_html__('Slogan Size', 'quadro'),
				'id' => $prefix . 'mod_slogan_size',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Giant', 'quadro' ), 'value' => 'giant'),
					array('name' => esc_html__('Regular', 'quadro' ), 'value' => 'regular'),
					),
				'std' => 'giant'
			),
			array(
				'name' => esc_html__('Content Align', 'quadro'),
				'id' => $prefix . 'mod_slogan_align',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Center', 'quadro' ), 'value' => 'center'),
					array('name' => esc_html__('Left', 'quadro' ), 'value' => 'left'),
					array('name' => esc_html__('Right', 'quadro' ), 'value' => 'right'),
					),
				'std' => 'center'
			),
			array(
				'name' => esc_html__('Use Gallery Slider as Background', 'quadro'),
				'id' => $prefix . 'mod_slogan_gallery',
				'type' => 'gallery'
			),
			array(
				'name' => esc_html__('Video Background', 'quadro'),
				'id' => $prefix . 'mod_slogan_video_back_subtitle',
				'type' => 'subtitle',
				'desc' => esc_html__('(It\'s advisable to upload more than one video format to prevent some browsers from not finding proper codecs.)', 'quadro'),
			),
			array(
				'name' => esc_html__('Video Background (MP4)', 'quadro'),
				'id' => $prefix . 'mod_slogan_video_mp4',
				'type' => 'upload'
			),
			array(
				'name' => esc_html__('Video Background (WEBM)', 'quadro'),
				'id' => $prefix . 'mod_slogan_video_webm',
				'type' => 'upload'
			),
			array(
				'name' => esc_html__('Video Background (OGV/THEORA)', 'quadro'),
				'id' => $prefix . 'mod_slogan_video_ogv',
				'type' => 'upload'
			),
			array(
				'name' => esc_html__('1st Button Properties', 'quadro'),
				'id' => $prefix . 'mod_slogan_1st_button_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Text', 'quadro'),
				'id' => $prefix . 'mod_slogan_action_text',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Link', 'quadro'),
				'id' => $prefix . 'mod_slogan_action_link',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Color', 'quadro'),
				'id' => $prefix . 'mod_slogan_action_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Background', 'quadro'),
				'id' => $prefix . 'mod_slogan_action_back',
				'type' => 'color',
				'desc' => esc_html__('Optional. Will be set by main color if not set.', 'quadro'),
				'std' => '#'
			),
			array(
				'name' => esc_html__('2nd Button Properties', 'quadro'),
				'id' => $prefix . 'mod_slogan_1st_button_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Text', 'quadro'),
				'id' => $prefix . 'mod_slogan_action2_text',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Link', 'quadro'),
				'id' => $prefix . 'mod_slogan_action2_link',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Color', 'quadro'),
				'id' => $prefix . 'mod_slogan_action2_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Background', 'quadro'),
				'id' => $prefix . 'mod_slogan_action2_back',
				'type' => 'color',
				'desc' => esc_html__('Optional. Will be set by main color if not set.', 'quadro'),
				'std' => '#'
			),
			array(
				'name' => esc_html__('Animation', 'quadro'),
				'id' => $prefix . 'mod_slogan_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Animation Delay Between Elements (in ms.)', 'quadro'),
				'id' => $prefix . 'mod_slogan_anim_delay',
				'type' => 'number',
			),
		)
	),

	// Adding modules FEATURED Type meta box
	'mod_featured_type_metabox' => array(
		'id' => 'mod-featured-qi-type-metabox',
		'title' => esc_html__('Featured Post Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_featured_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
					array('name' => esc_html__('Last post (from all posts)', 'quadro' ), 'value' => 'all'),
					array('name' => esc_html__('Last post By Categories', 'quadro' ), 'value' => 'tax'),
					array('name' => esc_html__('Last post By Post Format', 'quadro' ), 'value' => 'format'),
				),
				'std' => 'custom'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'quadro'),
				'id' => $prefix . 'mod_featured_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'quadro'),
				'id' => $prefix . 'mod_featured_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Post to Show', 'quadro'),
				'id' => $prefix . 'mod_pick_featured',
				'type' => 'one_post_picker',
				'post_type' => array( 'post', 'quadro_portfolio' )
			),
			array(
				'name' => esc_html__('Posts Offset', 'quadro'),
				'id' => $prefix . 'mod_featured_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'quadro')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'quadro'),
				'id' => $prefix . 'mod_featured_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'quadro')
			),
			array(
				'name' => esc_html__('Select Featured Post Style', 'quadro'),
				'id' => $prefix . 'mod_featured_style',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Content on right side', 'quadro' ), 'value' => 'type1'),
					array('name' => esc_html__('Content on left side', 'quadro' ), 'value' => 'type2')
					),
				'desc' => wp_kses_post( __( 'Note: To display featured posts <strong>large thumbnail</strong> size must be set on WordPress defaults of 1024 by 1024 pixels.', 'quadro' ) ),
				'std' => 'type1'
			),
			array(
				'name' => esc_html__('Post Date', 'quadro'),
				'id' => $prefix . 'mod_featured_date',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Post Categories', 'quadro'),
				'id' => $prefix . 'mod_featured_cats',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
		)
	),

	// Adding modules PORTFOLIO Type meta box
	'mod_portfolio_type_metabox' => array(
		'id' => 'mod-portfolio-qi-type-metabox',
		'title' => esc_html__('Portfolio Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Portfolio Style', 'quadro'),
				'id' => $prefix . 'mod_portfolio_style',
				'type' => 'layout-picker',
				'path' => '/images/admin/portfolio-styles/',
				'options' => array(
					'masonry' => array(
						'name' => 'masonry',
						'title' => esc_html__( 'Masonry Portfolio', 'quadro' ),
						'img' => 'portfolio-masonry.png',
						'description' => '',
					),
					'grid' => array(
						'name' => 'grid',
						'title' => esc_html__( 'Perfect Grid Portfolio', 'quadro' ),
						'img' => 'portfolio-grid.png',
						'description' => '',
					),
					'grid2' => array(
						'name' => 'grid2',
						'title' => esc_html__( 'Mosaic Portfolio', 'quadro' ),
						'img' => 'portfolio-mosaic.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'masonry'
			),
			array(
				'name' => esc_html__('Layout', 'quadro'),
				'id' => $prefix . 'mod_portfolio_layout',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Full Width, no margins', 'quadro' ), 'value' => 'full'),
					array('name' => esc_html__('Regular Width, with margins', 'quadro' ), 'value' => 'margin'),
					),
				'std' => 'ajax'
			),
			array(
				'name' => esc_html__('Select Columns', 'quadro'),
				'id' => $prefix . 'mod_portfolio_columns',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Two Columns', 'quadro' ), 'value' => 'two'),
					array('name' => esc_html__('Three Columns', 'quadro' ), 'value' => 'three'),
					array('name' => esc_html__('Four Columns', 'quadro' ), 'value' => 'four'),
					),
				'std' => 'three'
			),
			array(
				'name' => esc_html__('Loading Method', 'quadro'),
				'id' => $prefix . 'mod_portfolio_loading',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Ajax', 'quadro' ), 'value' => 'ajax'),
					array('name' => esc_html__('No Ajax', 'quadro' ), 'value' => 'noajax'),
					),
				'std' => 'ajax'
			),
			array(
				'name' => esc_html__('Reveal Info by Default', 'quadro'),
				'id' => $prefix . 'mod_portfolio_show_data',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Reveal on Hover', 'quadro' ), 'value' => 'hover'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide'),
					),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Categories Filter', 'quadro'),
				'id' => $prefix . 'mod_portfolio_filter',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide')
					),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Filter by', 'quadro'),
				'id' => $prefix . 'mod_portfolio_filter_terms',
				'type' => 'tax_picker_permanent',
				'tax_slug' => 'portfolio_tax'
			),
			array(
				'name' => esc_html__('Items per page', 'quadro'),
				'id' => $prefix . 'mod_portfolio_perpage',
				'type' => 'text',
				'desc' => esc_html__('Enter -1 to show all items in one page.', 'quadro')
			),
			array(
				'name' => esc_html__('Navigation', 'quadro'),
				'id' => $prefix . 'mod_portfolio_show_nav',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Portfolio Items', 'quadro'),
				'id' => $prefix . 'mod_portfolio_method_subtitle',
				'type' => 'subtitle',
			),
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_portfolio_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Items', 'quadro' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'quadro' ), 'value' => 'tax'),
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'quadro'),
				'id' => $prefix . 'mod_portfolio_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'portfolio_tax'
			),
			array(
				'name' => esc_html__('Choose Items to Show', 'quadro'),
				'id' => $prefix . 'mod_portfolio_picker',
				'type' => 'posts_picker',
				'post_type' => array( 'quadro_portfolio' ),
				'show_type' => false
			),
			array(
				'name' => esc_html__('Order Items by', 'quadro'),
				'id' => $prefix . 'mod_portfolio_orderby',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Date', 'quadro' ), 'value' => 'post_date'),
					array('name' => esc_html__('Title', 'quadro' ), 'value' => 'title')
				),
				'desc' => esc_html__( 'Note: this setting won\'t work for "Custom Selection" method.', 'quadro' ),
				'std' => 'date'
			),
			array(
				'name' => esc_html__('Order', 'quadro'),
				'id' => $prefix . 'mod_portfolio_order',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Descendant (newer first, if by date)', 'quadro' ), 'value' => 'DESC'),
					array('name' => esc_html__('Ascendant (older first, if by date)', 'quadro' ), 'value' => 'ASC')
				),
				'desc' => esc_html__( 'Note: this setting won\'t work for "Custom Selection" method.', 'quadro' ),
				'std' => 'DESC'
			),
		)
	),

	// Adding modules SERVICES Type meta box
	'mod_services_type_metabox' => array(
		'id' => 'mod-services-qi-type-metabox',
		'title' => esc_html__('Services Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Services Layout', 'quadro'),
				'id' => $prefix . 'mod_services_layout',
				'type' => 'layout-picker',
				'path' => '/images/admin/service-layouts/',
				'options' => array(
					'type1' => array(
						'name' => 'type1',
						'title' => esc_html__( 'Layout 1', 'quadro' ),
						'img' => 'service-layout1.png',
						'description' => '',
					),
					'type2' => array(
						'name' => 'type2',
						'title' => esc_html__( 'Layout 2', 'quadro' ),
						'img' => 'service-layout2.png',
						'description' => '',
					),
					'type3' => array(
						'name' => 'type3',
						'title' => esc_html__( 'Layout 3', 'quadro' ),
						'img' => 'service-layout3.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'type1'
			),
			array(
				'name' => esc_html__('Columns', 'quadro'),
				'id' => $prefix . 'mod_services_columns',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('One', 'quadro' ), 'value' => 'one'),
					array('name' => esc_html__('Two', 'quadro' ), 'value' => 'two'),
					array('name' => esc_html__('Three', 'quadro' ), 'value' => 'three'),
					array('name' => esc_html__('Four', 'quadro' ), 'value' => 'four')
					),
				'std' => 'three'
			),
			array(
				'name' => esc_html__('Show for Services', 'quadro'),
				'id' => $prefix . 'mod_services_show',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Icon', 'quadro' ), 'value' => 'icon'),
					array('name' => esc_html__('Image', 'quadro' ), 'value' => 'image'),
					array('name' => esc_html__('None', 'quadro' ), 'value' => 'none'),
					),
				'std' => 'icon'
			),
			array(
				'name' => esc_html__('Text Color', 'quadro'),
				'id' => $prefix . 'mod_services_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Icons Color', 'quadro'),
				'id' => $prefix . 'mod_services_icolor',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Animation', 'quadro'),
				'id' => $prefix . 'mod_services_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Animation Delay Between Elements (in ms.)', 'quadro'),
				'id' => $prefix . 'mod_services_anim_delay',
				'type' => 'number',
			),
			array(
                'name' => esc_html__('', 'quadro'),
                'id' => $prefix . 'mod_services_services',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many services as you want, one at a time. Drag to reorder.', 'quadro'),
                'item-name' => esc_html__('Service', 'quadro'),
                'repeat-fields' => array(
                	'title' => array( 'name' => 'title', 'title' => 'Title', 'type' => 'text' ),
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'textarea' ),
                	'link_url' => array( 'name' => 'link_url', 'title' => 'Link (URL)', 'type' => 'text' ),
                	'link_text' => array( 'name' => 'link_text', 'title' => 'Link Text', 'type' => 'text' ),
                	'icon' => array( 'name' => 'icon', 'title' => 'Icon', 'type' => 'icon_extended' ),
                	'img' => array( 'name' => 'img', 'title' => 'Image File', 'type' => 'upload' ),
                ),
                'repeat-item' => esc_html__('Add another Service', 'quadro')
            ),
		)
	),

	// Adding modules SLIDABLE INSIGHTS Type meta box
	'mod_sl_insights_type_metabox' => array(
		'id' => 'mod-sl-insights-qi-type-metabox',
		'title' => esc_html__('Slidable Insights Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Slidable Insights Size', 'quadro'),
				'id' => $prefix . 'mod_sl_insights_size',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Giant', 'quadro' ), 'value' => 'giant'),
					array('name' => esc_html__('Regular', 'quadro' ), 'value' => 'regular'),
					),
				'std' => 'giant'
			),
			array(
				'name' => esc_html__('Navigation Style', 'quadro'),
				'id' => $prefix . 'mod_sl_insights_nav',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Numbered', 'quadro' ), 'value' => 'numbered'),
					array('name' => esc_html__('Arrows', 'quadro' ), 'value' => 'arrows'),
					),
				'std' => 'numbered'
			),
			array(
				'name' => esc_html__('Text Color', 'quadro'),
				'id' => $prefix . 'mod_sl_insights_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Animation', 'quadro'),
				'id' => $prefix . 'mod_sl_insights_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Animation Delay Between Elements (in ms.)', 'quadro'),
				'id' => $prefix . 'mod_sl_insights_anim_delay',
				'type' => 'number',
			),
			array(
                'name' => esc_html__('Slidable Insights', 'quadro'),
                'id' => $prefix . 'mod_sl_insights',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many Showcase as you want, one at a time.', 'quadro'),
                'repeat-fields' => array(
                	'title' => array( 'name' => 'title', 'title' => 'Title', 'type' => 'text' ),
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'textarea' ),
                	'img' => array( 'name' => 'img', 'title' => 'Image', 'type' => 'upload' ),
                	'button_text' => array( 'name' => 'button_text', 'title' => 'Button Text', 'type' => 'text' ),
                	'button_url' => array( 'name' => 'button_url', 'title' => 'Button Link', 'type' => 'text' ),
                	'layout' => array( 
                		'name' => 'layout', 
                		'title' => 'Layout', 
                		'type' => 'layout-picker',
                		'path' => '/images/admin/insight-layouts/',
                		'std' => 'layout1',
                		'options' => array(
							'layout1' => array(
								'name' => 'layout1',
								'title' => esc_html__( 'Layout 1', 'quadro' ),
								'img' => 'insight-layout1.png',
								'description' => '',
							),
							'layout2' => array(
								'name' => 'layout2',
								'title' => esc_html__( 'Layout 2', 'quadro' ),
								'img' => 'insight-layout2.png',
								'description' => '',
							),
							'layout3' => array(
								'name' => 'layout3',
								'title' => esc_html__( 'Layout 3', 'quadro' ),
								'img' => 'insight-layout3.png',
								'description' => '',
							),
							'layout4' => array(
								'name' => 'layout4',
								'title' => esc_html__( 'Layout 4', 'quadro' ),
								'img' => 'insight-layout4.png',
								'description' => '',
							),
						),
                	),
                ),
                'item-name' => esc_html__('Insight', 'quadro'),
                'repeat-item' => esc_html__('Add another Insight', 'quadro'),
            ),
		)
	),

	// Adding modules TEAM Type meta box
	'mod_team_type_metabox' => array(
		'id' => 'mod-team-qi-type-metabox',
		'title' => esc_html__('Team Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Select Style', 'quadro'),
				'id' => $prefix . 'mod_team_style',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Two Columns', 'quadro' ), 'value' => 'type1'),
					array('name' => esc_html__('Three Columns', 'quadro' ), 'value' => 'type2'),
					array('name' => esc_html__('Four Columns', 'quadro' ), 'value' => 'type3'),
					),
				'std' => 'type1'
			),
			array(
                'name' => esc_html__('Team Members', 'quadro'),
                'id' => $prefix . 'mod_team_content',
                'type' => 'repeatable',
                'desc' => wp_kses_post( __('Add as many team members as you want, one at a time.<br />Define which social networks you\'d like to enable in the USER CONTACT METHODS section at <a href="' . esc_url( admin_url( 'themes.php?page=quadro-settings&tab=social' ) ) . '">Theme Options >> Social Tab</a>.', 'quadro') ),
                'item-name' => esc_html__('Team Member', 'quadro'),
                'repeat-fields' => array(
                	'name' => array( 'name' => 'name', 'title' => 'Name', 'type' => 'text' ),
                	'role' => array( 'name' => 'role', 'title' => 'Role', 'type' => 'text' ),
                	'link' => array( 'name' => 'link', 'title' => 'Link', 'type' => 'text' ),
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'textarea' ),
                	'img' => array( 'name' => 'img', 'title' => 'Photo', 'type' => 'upload' ),
                	'social' => array( 'name' => 'social', 'title' => 'Social Networks', 'type' => 'social-flex' ),
                ),
                'repeat-item' => esc_html__('Add another Team member', 'quadro')
            ),
		)
	),

	// Adding modules TESTIMONIALS Type meta box
	'mod_testimonials_type_metabox' => array(
		'id' => 'mod-testimonials-qi-type-metabox',
		'title' => esc_html__('Testimonials Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Select Style', 'quadro'),
				'id' => $prefix . 'mod_testimonial_style',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Slider', 'quadro' ), 'value' => 'type1'),
					array('name' => esc_html__('Two Columns', 'quadro' ), 'value' => 'type2'),
					array('name' => esc_html__('Three Columns', 'quadro' ), 'value' => 'type3'),
				),
				'std' => 'type1'
			),
			array(
				'name' => esc_html__('Background Style', 'quadro'),
				'id' => $prefix . 'mod_testimonial_back_style',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Solid Color', 'quadro' ), 'value' => 'solid'),
					array('name' => esc_html__('Transparent', 'quadro' ), 'value' => 'transp'),
				),
				'std' => 'solid'
			),
			array(
				'name' => esc_html__('Background Color (optional)', 'quadro'),
				'id' => $prefix . 'mod_testimonial_back',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Text Color (optional)', 'quadro'),
				'id' => $prefix . 'mod_testimonial_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
                'name' => esc_html__('', 'quadro'),
                'id' => $prefix . 'mod_testimonial_content',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many testimonials as you want, one at a time.', 'quadro'),
                'item-name' => esc_html__('Testimonial', 'quadro'),
                'repeat-fields' => array(
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'textarea' ),
                	'author' => array( 'name' => 'author', 'title' => 'Author', 'type' => 'text' ),
                	'subtitle' => array( 'name' => 'subtitle', 'title' => 'Subtitle', 'type' => 'text' ),
                	'link' => array( 'name' => 'link', 'title' => 'Link', 'type' => 'text' ),
                	'img' => array( 'name' => 'img', 'title' => 'Photo', 'type' => 'upload' ),
                ),
                'repeat-item' => esc_html__('Add another Testimonial', 'quadro')
            ),
		)
	),

	// Adding modules VIDEO POSTS Type meta box
	'mod_videoposts_type_metabox' => array(
		'id' => 'mod-videoposts-qi-type-metabox',
		'title' => esc_html__('Video Posts Slider Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('How many posts to show?', 'quadro'),
				'id' => $prefix . 'mod_videoposts_pper',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('Enter -1 to show all posts.', 'quadro')
			),
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_videoposts_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'quadro' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'quadro' ), 'value' => 'tax'),
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'quadro'),
				'id' => $prefix . 'mod_videoposts_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'quadro'),
				'id' => $prefix . 'mod_pick_videoposts',
				'type' => 'posts_picker',
				'post_type' => array( 'post' ),
				'post_format' => array( 'video' ),
				'show_type' => false
			),
			array(
				'name' => esc_html__('Posts Offset', 'quadro'),
				'id' => $prefix . 'mod_videoposts_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'quadro')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'quadro'),
				'id' => $prefix . 'mod_videoposts_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'quadro')
			),
		)
	),

	// Adding modules SLIDER Type meta box
	'mod_slider_type_metabox' => array(
		'id' => 'mod-slider-qi-type-metabox',
		'title' => esc_html__('Slider Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
                'name' => esc_html__('', 'quadro'),
                'id' => $prefix . 'mod_slider_slides',
                'type' => 'repeatable',
                'desc' => wp_kses_post( __('Add as many slides as you want, one at a time. Drag to reorder.<br /><strong>Note: editors turn into regular textareas when sorting them or adding new ones. Update or publish to re-enable.', 'quadro') ),
                'item-name' => esc_html__('Slide', 'quadro'),
                'repeat-fields' => array(
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'editor' ),
                	'align' => array( 'name' => 'align', 'title' => 'Content Align', 'type' => 'select',
                	'options' => array(
						array('name' => esc_html__('Center', 'quadro' ), 'value' => 'center'),
						array('name' => esc_html__('Left', 'quadro' ), 'value' => 'left'),
						array('name' => esc_html__('Right', 'quadro' ), 'value' => 'right'),
					) ),
                	'link_url' => array( 'name' => 'link_url', 'title' => 'Button URL', 'type' => 'text' ),
                	'link_text' => array( 'name' => 'link_text', 'title' => 'Button Text', 'type' => 'text' ),
                	'img' => array( 'name' => 'img', 'title' => 'Image File', 'type' => 'upload' ),
                ),
                'repeat-item' => esc_html__('Add another Slide', 'quadro')
            ),
			array(
				'name' => esc_html__('Margins', 'quadro'),
				'id' => $prefix . 'mod_slider_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Disable', 'quadro' ), 'value' => 'disable'),
					array('name' => esc_html__('Enable', 'quadro' ), 'value' => 'enable'),
				),
				'std' => 'disable'
			),
			array(
				'name' => esc_html__('Transition Timer (in millisecs.)', 'quadro'),
				'id' => $prefix . 'mod_slider_time',
				'type' => 'number'
			),
			array(
				'name' => esc_html__('Slider Height', 'quadro'),
				'id' => $prefix . 'mod_slider_height',
				'type' => 'text',
				'desc' => wp_kses_post( __(' Enter a number and its unit in pixels (e.g. <strong>500px</strong>) or <strong>100vh</strong> to make it full-height (optional).', 'quadro') )
			),
		)
	),

	// Adding modules POSTS SLIDER Type meta box
	'mod_pslider_type_metabox' => array(
		'id' => 'mod-pslider-qi-type-metabox',
		'title' => esc_html__('Posts Slider Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Select Caption Style', 'quadro'),
				'id' => $prefix . 'mod_pslider_caption_style',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Big Caption', 'quadro' ), 'value' => 'type1'),
					array('name' => esc_html__('Striped Caption', 'quadro' ), 'value' => 'type2'),
					),
				'std' => 'type1'
			),
			array(
				'name' => esc_html__('Select Caption Position', 'quadro'),
				'id' => $prefix . 'mod_pslider_caption_pos',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Left', 'quadro' ), 'value' => 'left'),
					array('name' => esc_html__('Right', 'quadro' ), 'value' => 'right'),
					array('name' => esc_html__('Left & Right (alternated)', 'quadro' ), 'value' => 'alternated'),
					),
				'desc' => esc_html__('(The Caption Position option is only available for Striped Caption style)', 'quadro'),
				'std' => 'left'
			),
			array(
				'name' => esc_html__('Transition Timer (in millisecs.)', 'quadro'),
				'id' => $prefix . 'mod_pslider_time',
				'type' => 'text',
				'desc' => wp_kses_post( __('Enter <strong>stop</strong> to disable autorun.', 'quadro') )
			),
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_pslider_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
					array('name' => esc_html__('Latest posts (from all posts)', 'quadro' ), 'value' => 'all'),
					array('name' => esc_html__('Latest posts By Categories', 'quadro' ), 'value' => 'tax'),
					array('name' => esc_html__('Latest posts By Post Format', 'quadro' ), 'value' => 'format'),
				),
				'std' => 'custom'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'quadro'),
				'id' => $prefix . 'mod_pslider_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'quadro'),
				'id' => $prefix . 'mod_pslider_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'quadro'),
				'id' => $prefix . 'mod_pick_pslider',
				'type' => 'posts_picker',
				'post_type' => array( 'post', 'quadro_portfolio' ),
				'show_type' => false
			),
			array(
				'name' => esc_html__('How many posts to show?', 'quadro'),
				'id' => $prefix . 'mod_pslider_pper',
				'type' => 'text',
				'std' => '',
			),
			array(
				'name' => esc_html__('Posts Offset', 'quadro'),
				'id' => $prefix . 'mod_pslider_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'quadro')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'quadro'),
				'id' => $prefix . 'mod_pslider_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'quadro')
			),
			array(
				'name' => esc_html__('Post Date', 'quadro'),
				'id' => $prefix . 'mod_pslider_date',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Post Categories', 'quadro'),
				'id' => $prefix . 'mod_pslider_cats',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Margins (make full width)', 'quadro'),
				'id' => $prefix . 'mod_pslider_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('With Margins', 'quadro' ), 'value' => 'with-margins'),
					array('name' => esc_html__('Without Margins', 'quadro' ), 'value' => 'no-margins'),
				),
				'std' => 'with-margins'
			),
		)
	),

	// Adding modules AUTHORS Type meta box
	'mod_authors_type_metabox' => array(
		'id' => 'mod-authors-qi-type-metabox',
		'title' => esc_html__('Authors Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_authors_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
					array('name' => esc_html__('All Authors', 'quadro' ), 'value' => 'all'),
				),
				'std' => 'custom'
			),
			array(
				'name' => esc_html__('Choose Authors to Show', 'quadro'),
				'id' => $prefix . 'mod_pick_authors',
				'type' => 'authors_picker',
			),
			array(
				'name' => esc_html__('Users Bio', 'quadro'),
				'id' => $prefix . 'mod_authors_bio',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Users Web & Social Profiles', 'quadro'),
				'id' => $prefix . 'mod_authors_extras',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
		)
	),

	// Adding modules QUOTE POSTS Type meta box
	'mod_quoteposts_type_metabox' => array(
		'id' => 'mod-quoteposts-qi-type-metabox',
		'title' => esc_html__('Quote Posts Slider Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('How many posts to show?', 'quadro'),
				'id' => $prefix . 'mod_quoteposts_pper',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('Enter -1 to show all posts.', 'quadro')
			),
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_quoteposts_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'quadro' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'quadro' ), 'value' => 'tax'),
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'quadro'),
				'id' => $prefix . 'mod_quoteposts_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'quadro'),
				'id' => $prefix . 'mod_pick_quoteposts',
				'type' => 'posts_picker',
				'post_type' => array( 'post' ),
				'post_format' => array( 'quote' ),
				'show_type' => false
			),
			array(
				'name' => esc_html__('Text Color (optional)', 'quadro'),
				'id' => $prefix . 'mod_quoteposts_color',
				'type' => 'color',
				'std' => '#'
			),
		)
	),

	// Adding modules BLOG Type meta box
	'mod_blog_type_metabox' => array(
		'id' => 'mod-blog-qi-type-metabox',
		'title' => esc_html__('Blog Module Options', 'quadro'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Blog Style', 'quadro'),
				'id' => $prefix . 'mod_blog_layout',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Classic Style', 'quadro' ), 'value' => 'classic'),
					array('name' => esc_html__('Teasers Style', 'quadro' ), 'value' => 'teasers'),
					array('name' => esc_html__('Headlines Style', 'quadro' ), 'value' => 'headlines'),
					array('name' => esc_html__('Masonry Style', 'quadro' ), 'value' => 'masonry'),
					),
				'std' => 'classic'
			),
			array(
				'name' => esc_html__('Columns', 'quadro'),
				'id' => $prefix . 'mod_blog_columns',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Three', 'quadro' ), 'value' => 'three'),
					array('name' => esc_html__('Two', 'quadro' ), 'value' => 'two')
					),
				'std' => 'three',
				'desc' => esc_html__( '(Available in Masonry Blog Style)', 'quadro' ),
			),
			array(
				'name' => esc_html__('Margins', 'quadro'),
				'id' => $prefix . 'mod_blog_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Without Margins', 'quadro' ), 'value' => 'false'),
					array('name' => esc_html__('With Margins', 'quadro' ), 'value' => 'true')
					),
				'std' => 'false',
				'desc' => esc_html__( '(Available in Masonry Blog Style)', 'quadro' )
			),
			array(
				'name' => esc_html__('Posts Loading Animation', 'quadro'),
				'id' => $prefix . 'mod_blog_anim',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('None', 'quadro' ), 'value' => 'none'),
					array('name' => esc_html__('Type 1', 'quadro' ), 'value' => '1'),
					array('name' => esc_html__('Type 2', 'quadro' ), 'value' => '2'),
					array('name' => esc_html__('Type 3', 'quadro' ), 'value' => '3'),
					array('name' => esc_html__('Type 4', 'quadro' ), 'value' => '4'),
					array('name' => esc_html__('Type 5', 'quadro' ), 'value' => '5'),
					array('name' => esc_html__('Type 6', 'quadro' ), 'value' => '6'),
					array('name' => esc_html__('Type 7', 'quadro' ), 'value' => '7'),
					array('name' => esc_html__('Type 8', 'quadro' ), 'value' => '8'),
					),
				'std' => '3',
				'desc' => esc_html__( '(Available in Masonry Blog Style)', 'quadro' ),
			),
			array(
				'name' => esc_html__('Posts per page', 'quadro'),
				'id' => $prefix . 'mod_blog_perpage',
				'type' => 'text',
				'desc' => esc_html__('Enter -1 to show all posts in one page or leave empty to use WordPress general setting in Settings >> Reading.', 'quadro')
			),
			array(
				'name' => esc_html__('Navigation', 'quadro'),
				'id' => $prefix . 'mod_blog_show_nav',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'quadro' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'quadro' ), 'value' => 'hide'),
				),
				'desc' => esc_html__('Keep in mind that navigation will always navigate all posts regardless of your custom selection at this screen.', 'quadro'),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('What to show?', 'quadro'),
				'id' => $prefix . 'mod_blog_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'quadro' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'quadro' ), 'value' => 'tax'),
					array('name' => esc_html__('By Post Format', 'quadro' ), 'value' => 'format'),
					array('name' => esc_html__('Custom Selection', 'quadro' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'quadro'),
				'id' => $prefix . 'mod_blog_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'quadro'),
				'id' => $prefix . 'mod_blog_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'quadro'),
				'id' => $prefix . 'mod_pick_blog',
				'type' => 'posts_picker',
				'post_type' => array( 'post' ),
				'show_type' => true
			),
			array(
				'name' => esc_html__('Posts Offset', 'quadro'),
				'id' => $prefix . 'mod_blog_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'quadro')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'quadro'),
				'id' => $prefix . 'mod_blog_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma. Using this setting disables \'-1\' setting for posts quantity.', 'quadro')
			),
		)
	),


);

/**
 * [$quadro_cfields_def filter]
 */
$quadro_cfields_def = apply_filters( 'qi_filter_cfields_definition', $quadro_cfields_def );

/**
 * [$quadro_cfields_mods_def filter]
 */
$quadro_cfields_mods_def = apply_filters( 'qi_filter_cfields_mods_definition', $quadro_cfields_mods_def );


?>
<?php
/**
 * This file sets up pre built layouts for SiteOrigins Page Builder Plugin
 */

function quadro_page_builder_layouts($layouts) {
	
	$theme_folder = get_stylesheet_directory_uri();

	// Mega Menu 1
	$layouts['mega-menu-1'] = array (
	  'name' => __('Mega Menu 1', 'quadro'),
	  'description' => '<img src="' . $theme_folder . '/images/admin/prebuilt-layouts/mega-menu-1.jpg">' . esc_html__('Five columns with custom menus.', 'quadro'),
	  'widgets' => 
	  array (
	    0 => 
	    array (
	      'title' => 'Home Versions',
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 0,
	        'id' => 0,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    1 => 
	    array (
	      'title' => 'Home Versions',
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 1,
	        'id' => 1,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    2 => 
	    array (
	      'title' => 'Pages',
	      'nav_menu' => 44,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 2,
	        'id' => 2,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    3 => 
	    array (
	      'title' => 'Home Versions',
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 3,
	        'id' => 3,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    4 => 
	    array (
	      'title' => 'Home Versions',
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 4,
	        'id' => 4,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	  ),
	  'grids' => 
	  array (
	    0 => 
	    array (
	      'cells' => 5,
	      'style' => 
	      array (
	        'gutter' => '20px',
	        'background_display' => 'tile',
	      ),
	    ),
	  ),
	  'grid_cells' => 
	  array (
	    0 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.2,
	    ),
	    1 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.2,
	    ),
	    2 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.2,
	    ),
	    3 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.2,
	    ),
	    4 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.2,
	    ),
	  ),
	);

	// Mega Menu 2
	$layouts['mega-menu-2'] = array (
	  'name' => __('Mega Menu 2', 'quadro'),
	  'description' => '<img src="' . $theme_folder . '/images/admin/prebuilt-layouts/mega-menu-2.jpg">' . esc_html__('Four columns with custom menus.', 'quadro'),
	  'widgets' =>
		array (
	    0 => 
	    array (
	      'title' => 'Home Versions',
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 0,
	        'id' => 0,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    1 => 
	    array (
	      'title' => 'Home Versions',
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 1,
	        'id' => 1,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    2 => 
	    array (
	      'title' => 'Pages',
	      'nav_menu' => 44,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 2,
	        'id' => 2,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    3 => 
	    array (
	      'title' => 'Home Versions',
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 3,
	        'id' => 3,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	  ),
	  'grids' => 
	  array (
	    0 => 
	    array (
	      'cells' => 4,
	      'style' => 
	      array (
	        'gutter' => '20px',
	        'background_image_attachment' => false,
	        'background_display' => 'tile',
	      ),
	    ),
	  ),
	  'grid_cells' => 
	  array (
	    0 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.25,
	    ),
	    1 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.25,
	    ),
	    2 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.25,
	    ),
	    3 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.25,
	    ),
	  ),
	);

	// Mega Menu 3
	$layouts['mega-menu-3'] = array (
	  'name' => __('Mega Menu 3', 'quadro'),
	  'description' => '<img src="' . $theme_folder . '/images/admin/prebuilt-layouts/mega-menu-3.jpg">' . esc_html__('Four columns: 1 image and 3 custom menus.', 'quadro'),
	  'widgets' =>
		array (
	    0 => 
	    array (
	      'image' => 1444,
	      'image_fallback' => '',
	      'size' => 'full',
	      'title' => '',
	      'alt' => '',
	      'url' => '',
	      'bound' => true,
	      'new_window' => false,
	      'full_width' => false,
	      'panels_info' => 
	      array (
	        'class' => 'SiteOrigin_Widget_Image_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 0,
	        'id' => 0,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    1 => 
	    array (
	      'title' => 'Home Versions',
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 1,
	        'id' => 1,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    2 => 
	    array (
	      'title' => 'Pages',
	      'nav_menu' => 44,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 2,
	        'id' => 2,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    3 => 
	    array (
	      'title' => 'Pages',
	      'nav_menu' => 44,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 3,
	        'id' => 3,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	  ),
	  'grids' => 
	  array (
	    0 => 
	    array (
	      'cells' => 4,
	      'style' => 
	      array (
	        'gutter' => '20px',
	        'background_display' => 'tile',
	      ),
	    ),
	  ),
	  'grid_cells' => 
	  array (
	    0 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.4,
	    ),
	    1 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.2,
	    ),
	    2 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.2,
	    ),
	    3 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.2,
	    ),
	  ),
	);

	// Mega Menu 4
	$layouts['mega-menu-4'] = array (
	  'name' => __('Mega Menu 4', 'quadro'),
	  'description' => '<img src="' . $theme_folder . '/images/admin/prebuilt-layouts/mega-menu-4.jpg">' . esc_html__('Three columns: 3 images with custom menus.', 'quadro'),
	  'widgets' =>
	  	array (
	    0 => 
	    array (
	      'image' => 1444,
	      'image_fallback' => '',
	      'size' => 'full',
	      'title' => '',
	      'alt' => '',
	      'url' => '',
	      'bound' => true,
	      'new_window' => false,
	      'full_width' => false,
	      'panels_info' => 
	      array (
	        'class' => 'SiteOrigin_Widget_Image_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 0,
	        'id' => 0,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    1 => 
	    array (
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 0,
	        'id' => 1,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    2 => 
	    array (
	      'image' => 1444,
	      'image_fallback' => '',
	      'size' => 'full',
	      'title' => '',
	      'alt' => '',
	      'url' => '',
	      'bound' => true,
	      'panels_info' => 
	      array (
	        'class' => 'SiteOrigin_Widget_Image_Widget',
	        'grid' => 0,
	        'cell' => 1,
	        'id' => 2,
	        'style' => 
	        array (
	          'background_image_attachment' => false,
	          'background_display' => 'tile',
	        ),
	      ),
	      'new_window' => false,
	      'full_width' => false,
	    ),
	    3 => 
	    array (
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'grid' => 0,
	        'cell' => 1,
	        'id' => 3,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    4 => 
	    array (
	      'image' => 1444,
	      'image_fallback' => '',
	      'size' => 'full',
	      'title' => '',
	      'alt' => '',
	      'url' => '',
	      'bound' => true,
	      'panels_info' => 
	      array (
	        'class' => 'SiteOrigin_Widget_Image_Widget',
	        'grid' => 0,
	        'cell' => 2,
	        'id' => 4,
	        'style' => 
	        array (
	          'background_image_attachment' => false,
	          'background_display' => 'tile',
	        ),
	      ),
	      'new_window' => false,
	      'full_width' => false,
	    ),
	    5 => 
	    array (
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'grid' => 0,
	        'cell' => 2,
	        'id' => 5,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	  ),
	  'grids' => 
	  array (
	    0 => 
	    array (
	      'cells' => 3,
	      'style' => 
	      array (
	        'gutter' => '20px',
	        'background_display' => 'tile',
	      ),
	    ),
	  ),
	  'grid_cells' => 
	  array (
	    0 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.333333333333,
	    ),
	    1 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.333333333333,
	    ),
	    2 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.333333333333,
	    ),
	  ),
	);

	// Mega Menu 5
	$layouts['mega-menu-5'] = array (
	  'name' => __('Mega Menu 5', 'quadro'),
	  'description' => '<img src="' . $theme_folder . '/images/admin/prebuilt-layouts/mega-menu-5.jpg">' . esc_html__('Three columns: custom menu + contact data + map.', 'quadro'),
	  'widgets' =>
	  	array (
	    0 => 
	    array (
	      'title' => 'Home Versions',
	      'nav_menu' => 43,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Nav_Menu_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 0,
	        'id' => 0,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    1 => 
	    array (
	      'title' => 'Contact us',
	      'text' => 'MON to FRI 9am - 18hs
	767 5th Ave, New York, NY 10153
	Phone: (212) 336-1440
	contact@modulesdemoqi.com',
	      'filter' => true,
	      'panels_info' => 
	      array (
	        'class' => 'WP_Widget_Text',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 1,
	        'id' => 1,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    2 => 
	    array (
	      'networks' => 
	      array (
	        0 => 
	        array (
	          'name' => 'facebook',
	          'url' => 'https://www.facebook.com/',
	          'icon_color' => '#ffffff',
	          'button_color' => '#3a5795',
	        ),
	        1 => 
	        array (
	          'name' => 'vimeo-square',
	          'url' => 'https://vimeo.com/',
	          'icon_color' => '#ffffff',
	          'button_color' => '#5bc8ff',
	        ),
	        2 => 
	        array (
	          'name' => 'twitter',
	          'url' => 'https://twitter.com/',
	          'icon_color' => '#ffffff',
	          'button_color' => '#78bdf1',
	        ),
	        3 => 
	        array (
	          'name' => 'google-plus',
	          'url' => 'https://plus.google.com/',
	          'icon_color' => '#ffffff',
	          'button_color' => '#dd4b39',
	        ),
	      ),
	      'design' => 
	      array (
	        'new_window' => true,
	        'theme' => 'flat',
	        'hover' => true,
	        'icon_size' => '1',
	        'rounding' => '0',
	        'padding' => '1',
	        'align' => 'left',
	        'margin' => '0.2',
	      ),
	      'panels_info' => 
	      array (
	        'class' => 'SiteOrigin_Widget_SocialMediaButtons_Widget',
	        'raw' => false,
	        'grid' => 0,
	        'cell' => 1,
	        'id' => 2,
	        'style' => 
	        array (
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	    3 => 
	    array (
	      'map_center' => 'Central Park, NYC, NY, USA',
	      'settings' => 
	      array (
	        'map_type' => 'interactive',
	        'width' => '640',
	        'height' => '260',
	        'zoom' => 12,
	        'scroll_zoom' => true,
	        'draggable' => true,
	        'disable_default_ui' => false,
	        'keep_centered' => false,
	      ),
	      'markers' => 
	      array (
	        'marker_at_center' => true,
	        'marker_icon' => 0,
	        'info_display' => 'click',
	        'markers_draggable' => false,
	        'marker_positions' => 
	        array (
	        ),
	      ),
	      'styles' => 
	      array (
	        'style_method' => 'normal',
	        'styled_map_name' => '',
	        'raw_json_map_styles' => '',
	        'custom_map_styles' => 
	        array (
	        ),
	      ),
	      'directions' => 
	      array (
	        'origin' => '',
	        'destination' => '',
	        'travel_mode' => 'driving',
	        'avoid_highways' => false,
	        'avoid_tolls' => false,
	        'waypoints' => 
	        array (
	        ),
	        'optimize_waypoints' => false,
	      ),
	      'api_key_section' => 
	      array (
	        'api_key' => '',
	      ),
	      'panels_info' => 
	      array (
	        'class' => 'SiteOrigin_Widget_GoogleMap_Widget',
	        'grid' => 0,
	        'cell' => 2,
	        'id' => 3,
	        'style' => 
	        array (
	          'background_image_attachment' => false,
	          'background_display' => 'tile',
	        ),
	      ),
	    ),
	  ),
	  'grids' => 
	  array (
	    0 => 
	    array (
	      'cells' => 3,
	      'style' => 
	      array (
	        'gutter' => '20px',
	        'background_display' => 'tile',
	      ),
	    ),
	  ),
	  'grid_cells' => 
	  array (
	    0 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.2,
	    ),
	    1 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.25,
	    ),
	    2 => 
	    array (
	      'grid' => 0,
	      'weight' => 0.55,
	    ),
	  ),
	);
	
	return $layouts;

}
add_filter('siteorigin_panels_prebuilt_layouts','quadro_page_builder_layouts');
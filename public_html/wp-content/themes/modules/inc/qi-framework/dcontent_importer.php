<?php 

function quadro_dcontent_import() {
	
	global $wpdb, $quadro_options_group, $dcontent_file, $dcontent_settings, 
	$dcontent_widgets, $dcontent_reading, $dcontent_front, $dcontent_posts, $dcontent_plugins;

	// Before we start, check if user has permissions
	if ( current_user_can('manage_options') ) {

		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
		// Ensure WordPress Importer Class
		if ( ! class_exists( 'WP_Importer' ) ) require ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		// Deactivate WP Importer Plugin (to eliminate false "falses")
		deactivate_plugins( '/wordpress-importer/wordpress-importer.php', true );
		// Ensure WordPress Importer Plugin
		if ( ! class_exists( 'WP_Import' ) ) require get_template_directory() . '/inc/qi-framework/wordpress-importer.php';
		// With both of them loaded
		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {

			$dcontent = new WP_Import();

			// Basic dummy content import
			$theme_xml = get_template_directory() . '/inc/dcontent/' . $dcontent_file;
			$dcontent->fetch_attachments = true;
			ob_start();
			$dcontent->import($theme_xml);
			ob_end_clean();

			// Set Menu locations for imported menus
			$locations = get_theme_mod( 'nav_menu_locations' );
			$menus = wp_get_nav_menus();
			if( $menus ) {
				foreach( $menus as $menu ) {
					if ( $menu->name == 'Main Menu' ) { // This name should be taken from the demo
						$locations['primary'] = $menu->term_id;
						$locations['secondary'] = $menu->term_id;
					} elseif ( $menu->name == 'Short' ) { // This name should be taken from the demo
						// $locations['secondary'] = $menu->term_id;
					}
				}
			}
			set_theme_mod( 'nav_menu_locations', $locations );

			// Import Theme Options
			$theme_options_file = get_template_directory_uri() . '/inc/dcontent/' . $dcontent_settings;
			$theme_options_file = wp_remote_get( $theme_options_file );
			$data = unserialize( urldecode( $theme_options_file['body']) );
			// Set value to let the validation callback know
			// it is alright to go through all the options.
			$data['restore_next'] = true;
			update_option( $quadro_options_group, $data );

			// Retrieve sidebars from import
			quadro_widgets_init();

			// Add data to widgets
			$widgets_json = get_template_directory_uri() . '/inc/dcontent/' . $dcontent_widgets;
			$widgets_json = wp_remote_get( $widgets_json );
			$widget_data = $widgets_json['body'];
			$import_widgets = quadro_import_widget_data( $widget_data );

			
			// Example of Plugin Demo Content Import
			// if ( in_array('revolution', $dcontent_plugins) && class_exists('UniteFunctionsRev') ) {
				// Import plugin's content
			// }


			// if ( in_array('crelly', $dcontent_plugins) ) {
			// 	// Perform Crelly Slider import
			// 	crelly_slider_import();
			// }
			
			// Set reading options
			$homepage = get_page_by_title( $dcontent_front );
			$posts_page = get_page_by_title( $dcontent_posts );
			if ( $homepage->ID && $posts_page->ID ) {
				update_option( 'show_on_front', $dcontent_reading );
				update_option( 'page_on_front', $homepage->ID );
				update_option( 'page_for_posts', $posts_page->ID );
			}

			// That's it! Go back to options-helper.php and then return to ajax call.
			die();

		}
	}
}

// Parsing Widgets Function
// http://wordpress.org/plugins/widget-settings-importexport/
function quadro_import_widget_data( $widget_data ) {
	$json_data = $widget_data;
	$json_data = json_decode( $json_data, true );

	$sidebar_data = $json_data[0];
	$widget_data = $json_data[1];

	foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
		$widgets[ $widget_data_title ] = '';
		foreach( $widget_data_value as $widget_data_key => $widget_data_array ) {
			if( is_int( $widget_data_key ) ) {
				$widgets[$widget_data_title][$widget_data_key] = 'on';
			}
		}
	}
	unset($widgets[""]);

	foreach ( $sidebar_data as $title => $sidebar ) {
		$count = count( $sidebar );
		for ( $i = 0; $i < $count; $i++ ) {
			$widget = array( );
			$widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
			$widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
			if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
				unset( $sidebar_data[$title][$i] );
			}
		}
		$sidebar_data[$title] = array_values( $sidebar_data[$title] );
	}

	foreach ( $widgets as $widget_title => $widget_value ) {
		foreach ( $widget_value as $widget_key => $widget_value ) {
			$widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
		}
	}

	$sidebar_data = array( array_filter( $sidebar_data ), $widgets );

	quadro_parse_import_data( $sidebar_data );
}

function quadro_parse_import_data( $import_array ) {
	global $wp_registered_sidebars;
	$sidebars_data = $import_array[0];
	$widget_data = $import_array[1];
	$current_sidebars = get_option( 'sidebars_widgets' );
	$new_widgets = array( );

	foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

		foreach ( $import_widgets as $import_widget ) :
			//if the sidebar exists
			if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
				$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
				$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
				$current_widget_data = get_option( 'widget_' . $title );
				$new_widget_name = quadro_get_new_widget_name( $title, $index );
				$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

				if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
					while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
						$new_index++;
					}
				}
				$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
				if ( array_key_exists( $title, $new_widgets ) ) {
					$new_widgets[$title][$new_index] = $widget_data[$title][$index];
					$multiwidget = $new_widgets[$title]['_multiwidget'];
					unset( $new_widgets[$title]['_multiwidget'] );
					$new_widgets[$title]['_multiwidget'] = $multiwidget;
				} else {
					$current_widget_data[$new_index] = $widget_data[$title][$index];
					$current_multiwidget = $current_widget_data['_multiwidget'];
					$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
					$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
					unset( $current_widget_data['_multiwidget'] );
					$current_widget_data['_multiwidget'] = $multiwidget;
					$new_widgets[$title] = $current_widget_data;
				}

			endif;
		endforeach;
	endforeach;

	if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
		update_option( 'sidebars_widgets', $current_sidebars );

		foreach ( $new_widgets as $title => $content )
			update_option( 'widget_' . $title, $content );

		return true;
	}

	return false;
}

function quadro_get_new_widget_name( $widget_name, $widget_index ) {
	$current_sidebars = get_option( 'sidebars_widgets' );
	$all_widget_array = array( );
	foreach ( $current_sidebars as $sidebar => $widgets ) {
		if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
			foreach ( $widgets as $widget ) {
				$all_widget_array[] = $widget;
			}
		}
	}
	while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
		$widget_index++;
	}
	$new_widget_name = $widget_name . '-' . $widget_index;
	return $new_widget_name;
}


/**
 * Import Demo Content for Crelly Slider (from mySql file)
 */
function crelly_slider_import() {

	require_once(ABSPATH . '/wp-load.php');
	global $wpdb; 

	$table_pref = $wpdb->prefix;

	$sql_insert = '';
	
	$wpdb->query( $wpdb->prepare( $sql_insert ) );

}


?>
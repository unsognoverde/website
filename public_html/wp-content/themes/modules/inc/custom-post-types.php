<?php 

/*-----------------------------------------------------------------------------------*/
/*  Module Post Type & Helpers
/*-----------------------------------------------------------------------------------*/

function quadro_mods_register() {

   /**
	* Register 'quadro_mods' custom post type
	*/
	register_post_type( 'quadro_mods', array(
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'mods' ),
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'exclude_from_search' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'taxonomies' => array(),
		'capability_type' => 'post',
		'capabilities' => array(),
        'menu_icon'=> 'dashicons-screenoptions',
		'labels' => array(
			'name' => esc_html__( 'Modules', 'quadro' ),
			'singular_name' => esc_html__( 'Module', 'quadro' ),
			'add_new' => esc_html__( 'Add New', 'quadro' ),
			'add_new_item' => esc_html__( 'Add New Module', 'quadro' ),
			'edit_item' => esc_html__( 'Edit Module', 'quadro' ),
			'new_item' => esc_html__( 'New Module', 'quadro' ),
			'all_items' => esc_html__( 'All Modules', 'quadro' ),
			'view_item' => esc_html__( 'View Module', 'quadro' ),
			'search_items' => esc_html__( 'Search Modules', 'quadro' ),
			'not_found' =>  esc_html__( 'No Module found', 'quadro' ),
			'not_found_in_trash' => esc_html__( 'No Module found in Trash', 'quadro' ),
			'parent_item_colon' => '',
			'menu_name' => 'Modules'
		)
	) );
}
add_action( 'init', 'quadro_mods_register' );


/**
 * Adds Type Column to modules
 */
add_filter('manage_quadro_mods_posts_columns', 'quadro_mod_addcolumn', 10);  
add_action('manage_quadro_mods_posts_custom_column', 'quadro_mod_column_content', 10, 2); 

// Add new column 
function quadro_mod_addcolumn($columns) {  
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => esc_html__( 'Module', 'quadro' ),
        'module_type' => esc_html__( 'Module Type', 'quadro' ),
        'date' => esc_html__( 'Date', 'quadro' )
    );
    return $columns;
}  
  
// Show the module type 
function quadro_mod_column_content($column_name, $post_ID) {  
	if ($column_name == 'module_type') {
		global $available_modules;

		$mod_type = get_post_meta( $post_ID, 'quadro_mod_type', true );
		$this_type = array_search( $mod_type, $available_modules );

		echo $this_type;

	}
}

// Add Modules filtering controls
add_action( 'restrict_manage_posts', 'quadro_module_filtering' );
function quadro_module_filtering() {
	
	global $current_screen, $available_modules;
	if ( $current_screen->post_type == 'quadro_mods' ) {
		echo '<select name="module_filter">';
		echo '<option value="" ' . selected( isset($_GET['module_filter']) && ($_GET['module_filter'] == '') ) . '>' . esc_html__('All Module Types', 'quadro') . '</option>';
		foreach ( $available_modules as $module_name => $module_slug) {
			echo '<option value="' . $module_slug . '" ' . selected( isset($_GET['module_filter']) && ($_GET['module_filter'] == $module_slug) ) . '>' . $module_name . '</option>';
		}
	echo '</select>';
	}
}

// Add Modules filtering functioning
add_filter( 'parse_query','quadro_module_filter' );
function quadro_module_filter( $query ) {
	if( is_admin() && isset( $query->query['post_type'] ) && $query->query['post_type'] == 'quadro_mods' ) {
		$mod_query = &$query->query_vars;
		$mod_query['meta_query'] = array();

		if( !empty( $_GET['module_filter'] ) ) {
			$mod_query['meta_query'][] = array(
				'field' => 'quadro_mod_type',
				'value' => $_GET['module_filter'],
				'compare' => '=',
				'type' => 'CHAR'
			);
		}
	}
}

// Enable Modules Preview when coming from internal request
if ( !is_user_logged_in() || !isset($_GET['qi']) || $_GET['qi'] != 'internal-preview' ) {
	function quadro_makemods_visible($do_parse) {
		$GLOBALS['wp_post_types']['quadro_mods']->publicly_queryable = false;
		// Return filter, we don't want to affect the filter results.
		return $do_parse;
	}
	add_filter( 'do_parse_request', 'quadro_makemods_visible' );
}


/*
 * Add the Module preview link to action list for post_row_actions
 */
function qi_preview_module_link( $actions, $post ) {
	if ( get_post_type() === 'quadro_mods' && current_user_can('edit_posts') ) {
		$actions['preview_mod'] = '<a href="' . get_permalink($post->ID) . '?qi=internal-preview" title="' . esc_html__('Preview this Module', 'quadro') . '" rel="permalink">' . esc_html__('Preview', 'quadro') . '</a>';
	}
	return $actions;
}
add_filter( 'post_row_actions', 'qi_preview_module_link', 10, 2 );

?>
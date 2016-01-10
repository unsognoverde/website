<?php
/**
 *
 * This file handles the Options for the theme.
 * 
 */

/**
 * Globalize the variable that holds the Theme Options
 */
global $quadro_options;

/**
 * Implement the WordPress Settings API for Theme Settings.
 * Loads required files.
 */
function quadro_register_options(){
	require( get_template_directory() . '/inc/qi-framework/options-helper.php' );
	// Load fonts list
	require( get_template_directory() . '/inc/qi-framework/google-fonts-list.php' );
}
// Settings API options initilization and validation
add_action( 'admin_init', 'quadro_register_options' );


/**
 * Load CSS Options Applying
 */
function quadro_apply_css(){
	require( get_template_directory() . '/inc/css-functions.php' );
}
add_action( 'init', 'quadro_apply_css' );


/**
 * Setup the Theme Admin Settings Page
 * Add "Quadro Options" link to the "Appearance" menu
 */
function quadro_add_theme_page() {
	// Add Theme options page
	add_theme_page(
		// $page_title
		// Name displayed in HTML title tag
		esc_html__( 'Theme Options', 'quadro' ), 
		// $menu_title
		// Name displayed in the Admin Menu
		esc_html__( 'Theme Options', 'quadro' ), 
		// $capability
		// User capability required to access page
		'edit_theme_options',
		// $menu_slug
		// String to append to URL after "themes.php"
		'quadro-settings', 
		// $callback
		// Function to define settings page markup
		'quadro_admin_options_page'
	);
}
// Load the Admin Options page
add_action( 'admin_menu', 'quadro_add_theme_page' );


/**
 * Define Quadro Admin Page Tab Markup
 * 
 * @link	http://www.onedesigns.com/tutorials/separate-multiple-theme-options-pages-using-tabs	Daniel Tara
 */
function quadro_get_page_tab_markup() {

	$page = 'quadro-settings';

	$current = quadro_get_current_tab();

	$tabs = quadro_get_settings_page_tabs();
	
	$links = array();
	
	foreach( $tabs as $tab ) {
		$tabname = $tab['name'];
		$tabtitle = $tab['title'];
		if ( $tabname == $current ) {
			$links[] = "<a class='nav-tab nav-tab-active' href='?page=$page&tab=$tabname'>$tabtitle</a>";
		} else {
			$links[] = "<a class='nav-tab' href='?page=$page&tab=$tabname'>$tabtitle</a>";
		}
	}
	
	echo '<div id="icon-themes" class="icon32"><br /></div>';
	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $links as $link )
		echo $link;
	echo '</h2>';
	
}


/**
 * Get current settings page tab
 */
function quadro_get_current_tab() {

	$page = 'quadro-settings';
	if ( isset( $_GET['page'] ) && 'quadro-reference' == $_GET['page'] ) {
		$page = 'quadro-reference';
	}
	if ( isset( $_GET['tab'] ) ) {
		$current = $_GET['tab'];
	} else {
		$quadro_options = quadro_get_options();
		$current = 'general';
	}	
	return apply_filters( 'quadro_get_current_tab', $current );
}


/**
 * Quadro Theme Settings Page Markup
 * 
 * @uses	quadro_get_current_tab()	defined in \functions\custom.php
 * @uses	quadro_get_page_tab_markup()	defined in \functions\custom.php
 */
function quadro_admin_options_page() { 
	global $quadro_options_group;
	// Determine the current page tab
	$currenttab = quadro_get_current_tab();
	// Define the page section accordingly
	$settings_section = 'quadro_' . $currenttab . '_tab';
	?>

	<div class="wrap">
		<?php quadro_get_page_tab_markup(); ?>
		<?php if ( isset( $_GET['settings-updated'] ) ) {
				echo '<div class="updated"><p>';
				echo esc_html__( 'Theme settings updated successfully.', 'quadro' );
				echo '</p></div>';
		} ?>
		<form id="quadro_options_form" action="options.php" method="post">
		<?php 
			// Implement settings field security, nonces, etc.
			settings_fields($quadro_options_group);
			// Output each settings section, and each
			// Settings field in each section
			do_settings_sections( $settings_section );
		?>
			<input type="hidden" id="quadro_nonce" name="quadro_nonce" value="<?php echo wp_create_nonce('quadro_ajax_nonce'); ?>" />
			<?php submit_button( esc_html__( 'Save Settings', 'quadro' ), 'primary', $quadro_options_group . '[submit-' . $currenttab . ']', false ); ?>
			<?php submit_button( esc_html__( 'Reset This Tab', 'quadro' ), 'secondary', $quadro_options_group . '[reset-' . $currenttab . ']', false ); ?>
		</form>
		<div class="options-sidebar">
			<?php do_action( 'qi_options_sidebar' ); ?>
		</div>
	</div>
<?php 
}

/**
 * Quadro Theme Option Defaults
 * 
 * Returns an associative array that holds 
 * all of the default values for all Theme 
 * options.
 * 
 * @uses	quadro_get_option_parameters()	defined in \functions\options.php
 * 
 * @return	array	$defaults	associative array of option defaults
 */
function quadro_get_option_defaults() {
	// Get the array that holds all
	// Theme option parameters
	$option_parameters = quadro_get_option_parameters();
	// Initialize the array to hold
	// the default values for all
	// Theme options
	$option_defaults = array();
	// Loop through the option
	// parameters array
	foreach ( $option_parameters as $option_parameter ) {
		$name = $option_parameter['name'];
		// Add an associative array key
		// to the defaults array for each
		// option in the parameters array
		$option_defaults[$name] = $option_parameter['default'];
	}
	// Return the defaults array
	return apply_filters( 'quadro_option_defaults', $option_defaults );
}

/**
 * Define default options tab
 */
function quadro_define_default_options_tab( $options ) {
	$options['default_options_tab'] = 'general';
	return $options;
}
add_filter( 'quadro_option_defaults', 'quadro_define_default_options_tab' );


/**
 * Get Quadro Theme Options
 * 
 * Array that holds all of the defined values
 * for Quadro Theme options. If the user 
 * has not specified a value for a given Theme 
 * option, then the option's default value is
 * used instead.
 *
 * @uses	quadro_get_option_defaults()	defined in \functions\options.php
 * 
 * @uses	get_option()
 * @uses	wp_parse_args()
 * 
 * @return	array	$quadro_options	current values for all Theme options
 */
// $quadro_options_std = null;
function quadro_get_options() {
	global $quadro_options_group;
	// global $quadro_options_std;

	// if ( !$quadro_options_std ) {
		// Get the option defaults
		$option_defaults = quadro_get_option_defaults();
		// Globalize the variable that holds the Theme options
		global $quadro_options;
		// Parse the stored options with the defaults
		$quadro_options = wp_parse_args( get_option( $quadro_options_group, array() ), $option_defaults );
		// Assign retrieved parsed options to stored values
		// $quadro_options_std = $quadro_options;	
	// }

	// Return the parsed array from stored values
	// return $quadro_options_std;
	return $quadro_options;

}

/**
 * Separate settings by tab
 * 
 * Returns an array of tabs, each of
 * which is an indexed array of settings
 * included with the specified tab.
 *
 * @uses	quadro_get_option_parameters()	defined in \functions\options.php
 * @uses	quadro_get_settings_page_tabs()	defined in \functions\options.php
 * 
 * @return	array	$settingsbytab	array of arrays of settings by tab
 */
function quadro_get_settings_by_tab() {
	// Get the list of settings page tabs
	$tabs = quadro_get_settings_page_tabs();
	// Initialize an array to hold
	// an indexed array of tabnames
	$settingsbytab = array();
	// Loop through the array of tabs
	foreach ( $tabs as $tab ) {
		$tabname = $tab['name'];
		// Add an indexed array key
		// to the settings-by-tab 
		// array for each tab name
		$settingsbytab[] = $tabname;
	}
	// Get the array of option parameters
	$option_parameters = quadro_get_option_parameters();
	// Loop through the option parameters
	// array
	foreach ( $option_parameters as $option_parameter ) {
		$optiontab = $option_parameter['tab'];
		$optionname = $option_parameter['name'];
		// Add an indexed array key to the 
		// settings-by-tab array for each
		// setting associated with each tab
		$settingsbytab[$optiontab][] = $optionname;
		$settingsbytab['all'][] = $optionname;
	}
	// Return the settings-by-tab
	// array
	return $settingsbytab;
}


/**
 * Get Valid Background Patterns
 * Number declared in while loop should be modified
 * according to number of available background patterns.
 */
function quadro_get_patterns(){
	
	global $patterns_qty;

	$patterns = array();

	$i = 1;

	$patterns['none'] = array(
		'name' => 'none',
		'title' => esc_html__('None', 'quadro'),
		'img' => '',
		'description' => '',
	);

	while ( $i < $patterns_qty ) {
		$patterns[] = array(
			'name' => $i,
			'title' => '',
			'img' => $i . 'thumb.jpg',
			'description' => '',
		);
		$i++;
	}

	return $patterns;

}


?>
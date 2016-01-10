<?php
/*******
  Original Plugin & API by Kaspars Dambis (kaspars@konstruktors.com)
  Modified by Jeremy Clark http://clark-technet.com
  Modified by QuadroIdeas http://quadroideas.com
*******/

// TEMP: Enable update check on every request. Normally we don't need this! This is for testing only!
// set_site_transient('update_themes', null);

// NOTE: All variables and functions will need to be prefixed properly to allow multiple plugins to be updated

$api_url = 'http://quadroideas.com/quadroupdates';

global $quadro_options;
$quadro_options = quadro_get_options();

/***********************Parent Theme**************/
$theme_data = wp_get_theme(get_option('template'));
$theme_version = $theme_data->Version;
$theme_base = get_option('template');
/**************************************************/


//Uncomment below to find the theme slug that will need to be setup on the api server
// var_dump($theme_base);


function qi_theme_update_check($checked_data) {
	global $wp_version, $theme_version, $theme_base, $api_url, $quadro_options;

	$request = array(
		'slug' => $theme_base,
		'version' => $theme_version,
		'username' => $quadro_options['quadro_username'],
		'userpass' => $quadro_options['quadro_userpass'],
	);
	// Start checking for an update
	$send_for_check = array(
		'body' => array(
			'action' => 'theme_update', 
			'request' => serialize( $request ),
			'api-key' => md5( esc_url(home_url('/')) )
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . esc_url(home_url('/'))
	);
	$raw_response = wp_remote_post($api_url, $send_for_check);
	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);

	// Feed the update data into WP updater
	if (!empty($response)) 
		$checked_data->response[$theme_base] = $response;

	return $checked_data;
}


// Take over the Theme info screen on WP multisite
function qi_theme_api_call($def, $action, $args) {
	global $wp_version, $theme_base, $api_url, $theme_version;

	// Add check for 'slug' existence inside $args
	// to avoid WordPress.org server error message
	// in some screens
	if ( !property_exists($args, 'slug') ) return false;

	if ( $args->slug != $theme_base )
		return false;

	// Get the current version
	$args->version = $theme_version;

	$request_string = array(
		'body' => array(
			'action' => $action,
			'request' => json_encode($args),
			'api-key' => md5( esc_url( home_url('/') ) )
		),
		'user-agent' => 'WordPress/'. $wp_version .'; '. esc_url( home_url('/') )
	);
	$request = wp_remote_post($api_url, $request_string);

	if ( is_wp_error($request) ) {
		$res = new WP_Error( 'themes_api_failed', wp_kses_post( __( 'An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>', 'quadro' ) ), $request->get_error_message() );
	} else {
		$res = unserialize($request['body']);
		if ($res === false)
			$res = new WP_Error('themes_api_failed', esc_html__('An unknown error occurred', 'quadro'), $request['body']);
	}

	return $res;
}


// Add these functions only if updates enabled in Theme Options
if ( isset($quadro_options['updates_enable']) && $quadro_options['updates_enable'] == true ) {
	add_filter('pre_set_site_transient_update_themes', 'qi_theme_update_check');
	add_filter('themes_api', 'qi_theme_api_call', 10, 3);
	if ( is_admin() ) $current = get_transient('update_themes');
}

?>
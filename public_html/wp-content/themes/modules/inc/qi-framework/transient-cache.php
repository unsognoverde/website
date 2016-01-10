<?php
/**
 * Handles the functions for creating, deleting and renewing
 * transients for fragment caching of different areas of the theme.
 */


/**
 * Clear Fragment Chache Related Transients and their Timeouts
 */
function qi_clear_fragment_transients() {
	global $wpdb, $quadro_options;
	if ( isset( $quadro_options['transients_enable'] ) && $quadro_options['transients_enable'] == 'enabled' ) {
		$wpdb->query( "DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_qi_fragm_%'" );
		$wpdb->query( "DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_timeout_qi_fragm_%'" );
		// $wpdb->query( "DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_qi_fragm_%'" );
		// $wpdb->query( "DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_timeout_qi_fragm_%'" );
	}
}


/**
 * Add transients clearing function to key instances to assure
 * proper "cache" refreshing when saving posts, modules or terms.
 */
add_action( 'save_post', 'qi_clear_fragment_transients' );
add_action( 'transition_post_status', 'qi_clear_fragment_transients' );
add_action( 'edit_term', 'qi_clear_fragment_transients' );


/**
 * Define if user is logged in for later use in
 * transients function.
 */
$logged = is_user_logged_in() ? '_logged' : '';


/**
 * Enables the use of transients for a pseudo fragment cache
 * on called sections of the theme.
 * Credits:
 * https://gist.github.com/westonruter/5475349
 * https://gist.github.com/markjaquith/2653957
 * http://css-tricks.com/wordpress-fragment-caching-revisited/
 */
if ( ! function_exists( 'qi_fragment_cache' ) ) :
function qi_fragment_cache( $key, $time, $function ) {

	global $quadro_options, $logged;

	// Check for Use Transients option and deliver straight content if set to false.
	// Also, check for presence of pagination in module. If true, skip to no-transient
	if ( isset( $quadro_options['transients_enable'] ) && $quadro_options['transients_enable'] == 'enabled' && !is_paged() ) {

		$fragment = get_transient( 'qi_fragm_' . $key . $logged );
		if ( false === $fragment ) {
			ob_start();
			call_user_func( $function );
			$fragment = ob_get_clean();
			set_transient( 'qi_fragm_' . $key . $logged, $fragment, $time );
		}
		echo $fragment;
	
	} else {

		ob_start();
		call_user_func( $function );
		$fragment = ob_get_clean();
		echo $fragment;

	}

}
endif; // if !function_exists
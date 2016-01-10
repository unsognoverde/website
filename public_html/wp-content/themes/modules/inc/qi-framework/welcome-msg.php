<?php 

/**
 * Adding Welcome Panel after Activating Theme
 */
function quadro_welcome_message() {

	global $docs_url, $support_url, $theme_slug;

	$theme = wp_get_theme();

	// Get first time variable
	$not_first_time = get_option( $theme_slug . '_ftime', false );
	$back_st = $not_first_time == true ? 'back ' : '';
	$msg = '<div id="qi-welcome-panel" class="qi-welcome-panel">
				<span class="dismiss-msg-span"><a href="#" class="welc-msg-dismiss"><i class="fa fa-times"></i></a></span>
				<div class="qi-welcome-header">
					<a href="http://quadroideas.com" title="Quadro Ideas"><img src="' . get_template_directory_uri() . '/images/admin/qi-logo-black.png' . '" /></a>
					<h3>Welcome ' . $back_st . 'to ' . $theme . '!</h3>
					<h4 class="about-description">' . esc_html__('We are glad you decided to use ', 'quadro') . $theme . esc_html__(' on this site', 'quadro') . '</h4> 
				</div>
				<div class="qi-welcome-content clear">
					<h3>' . esc_html( 'Here are a couple of useful tips to get you started:', 'quadro') . '</h3>
					<ul class="welcome-tips">
						<li>
							<i class="fa fa-file-text"></i>
							<p>' . wp_kses_post( __('The documentation file for this theme has lots of helpful sections, including a nice <strong>Getting Started</strong> with step by step descriptions on how to start working with it.', 'quadro') ) . ' <a href="' . $docs_url . '" target="_blank">' . esc_html__('You can find it here.', 'quadro') . '</a></p>
						</li>
						<li>
							<i class="fa fa-refresh"></i>
							<p>' . wp_kses_post( __('We update the theme from time to time to keep making it even better. <a href="http://twitter.com/quadroIdeas">Follow us on Twitter</a> to get notified about updates as soon as they see the web-light.', 'quadro') ) . '</p>
						</li>
						<li>
							<i class="fa fa-life-ring"></i>
							<p>' . esc_html__('Should you need help with the theme and you can\'t find the answer on the documentation file, we\'ll be ready to cover you on our', 'quadro') . ' <a href="' . $support_url . '" target="_blank">' . esc_html__('Support Forum.', 'quadro') . '</a></p>
						</li>
						<li>
							<i class="fa fa-pencil-square-o"></i>
							<p>' . wp_kses_post( __('Also, we tend to publish cool posts on maximizing the use of our themes, with clever implementations and extra customization tips. <a href="http://quadroideas.com/blog" target="_blank">Read them here</a>.', 'quadro') ) . '</p>
						</li>
					</ul>
				</div>
				<div class="qi-welcome-footer clear">
					<p class="message-gone">' . wp_kses_post( __('(This welcome message will be gone after you refresh the page or navigate to another screen. <a href="#" class="welc-msg-dismiss">Dismiss now &raquo;</a>)', 'quadro') ) . '</p>
					<ul class="qi-socials">
						<li><a href="http://quadroideas.com" title="Quadro Ideas">www.quadroideas.com</a></li>
						<li><a href="https://twitter.com/quadroIdeas" title="Follow us on Twitter"><i class="fa fa-twitter-square"></i></a></li>
						<li><a href="https://www.facebook.com/quadroideas" title="Join our Facebook Page"><i class="fa fa-facebook-square"></i></a></li>
					</ul>
				</div>
			</div>';
	
	add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );

	// Update first time option
	update_option( $theme_slug . '_ftime', true );

}
// add_action('after_switch_theme', 'quadro_welcome_message', 10 ,  2);

// Un-comment next line to "always test" the message
// add_action('admin_init', 'quadro_welcome_message', 10 ,  2);

?>
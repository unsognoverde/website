<?php

/**
 * Redirects to Getting Started page on theme activation
 */
function qi_get_started_redirect() {
	global $pagenow;
	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
		wp_redirect( admin_url( "themes.php?page=getting-started" ) );
	}
}
add_action( 'after_switch_theme', 'qi_get_started_redirect' );
// add_action( 'admin_init', 'qi_get_started_redirect' );


/**
 * Registers Getting Started Menu
 */
function qi_register_gs_menu() {
	add_submenu_page( 'themes.php', 'Getting Started', 'Getting Started', 'manage_options', 'getting-started', 'qi_geting_started' );
}
add_action('admin_menu', 'qi_register_gs_menu');


/**
 * Getting Started Page Callback
 */
function qi_geting_started() {
	
	global $docs_url, $support_url, $theme_slug;
	$theme = wp_get_theme();
	?>

	<div class="wrap">

		<div id="qi-welcome-panel" class="qi-welcome-panel">
				
			<div class="qi-welcome-header">
				<a href="http://quadroideas.com" title="Quadro Ideas"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/qi-logo-black.png" /></a>
				<h2><?php printf( esc_html__( 'Welcome to %1$s! Please read through this page to get started setting up your theme.', 'quadro' ), $theme ); ?></h2>
			</div>

			<div class="qi-welcome-content clear">

				<ul id="gs-tabs-list" class="gs-tabs-list">
					<li id="start" class="current"><a href="#"><i class="fa fa-check"></i> <?php esc_html_e( 'Getting Started', 'quadro' ); ?></a></li>
					<li id="plugins"><a href="#"><i class="fa fa-plug"></i> <?php esc_html_e( 'Plugins', 'quadro' ); ?></a></li>
					<li id="support"><a href="#"><i class="fa fa-question-circle"></i> <?php esc_html_e( 'FAQ & Support', 'quadro' ); ?></a></li>
				</ul>

				<div id="started-tabs" class="gs-tabs">
					<div id="start-tab" class="gs-tab visible">
						<?php // Include Theme Specific Getting Started Content
						require( get_template_directory() . '/inc/getting-started/getting-started.php' );
						?>
					</div>
					<div id="plugins-tab" class="gs-tab">
						<?php 
						global $tgmpa;
						$tgmpa->install_plugins_page();
						?>
					</div>
					<div id="support-tab" class="gs-tab">
						<?php // Include Theme Specific FAQ Content
						require( get_template_directory() . '/inc/getting-started/theme-faqs.php' );
						?>
						<p>Looking for some other question? <a href="http://quadroideas.com/faq/" target="_blank">Take a look at more FAQs here.</a></p>
					</div>
				</div>

			</div>

			<div class="qi-welcome-footer clear">
				<ul class="qi-socials">
					<li><a href="http://quadroideas.com" title="Quadro Ideas">www.quadroideas.com</a></li>
					<li><a href="https://twitter.com/quadroIdeas" title="Follow us on Twitter"><i class="fa fa-twitter-square"></i></a></li>
					<li><a href="https://www.facebook.com/quadroideas" title="Join our Facebook Page"><i class="fa fa-facebook-square"></i></a></li>
				</ul>
			</div>

			<div class="getting-started-sidebar">
				<?php //do_action( 'qi_options_sidebar' ); ?>
			</div>
			
		</div>

	</div>

	<?php
}
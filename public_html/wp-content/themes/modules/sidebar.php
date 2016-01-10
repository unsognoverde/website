<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * Will run only for Header type 2 (Fullwidth) layout
 * 
 */
?>
	
<?php 
// Retrieve Theme Options
global $quadro_options;

// Retrieve Sidebar Option
$page_sidebar = '';
if ( is_page() ) $page_sidebar = esc_attr( get_post_meta( get_the_ID(), 'quadro_page_sidebar', true ) );
$page_sidebar = $page_sidebar != '' ? $page_sidebar : 'main-sidebar';
if ( is_page() || $quadro_options['blog_sidebar'] == 'sidebar' || ( is_single() && $quadro_options['single_sidebar'] == 'sidebar' ) ) { ?>

	<div id="secondary" class="widget-area" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( $page_sidebar ) ) : ?>
			<aside class="help">
				<p><?php esc_html_e('Would like to activate some Widgets?', 'quadro'); ?>
				<br /><?php esc_html_e('Go to Appearance > Widgets. Just like that!', 'quadro'); ?></p>
			</aside>
		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->

<?php } ?>

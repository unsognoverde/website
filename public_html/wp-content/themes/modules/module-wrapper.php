<?php
/**
 * The template used for displaying Modules Wrapper content
 *
 */
?>

<?php 
// Retrieve Theme Options
global $quadro_options;

$mod_id = get_the_ID();

// Get Sidebar Position
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$sidebar_pos 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_wrapper_sidebar', true ) );
$sidebar_pick 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_wrapper_sidebar_pick', true ) );
$sidebar_pick 	= $sidebar_pick != '' ? $sidebar_pick : 'main-sidebar';

// Query for the Modules Wrapper Modules
$args = array(
	'post_type' =>  'quadro_mods',
	'posts_per_page' => -1,
	'no_found_rows' => true,
	'update_post_term_cache' => false,
);
// Bring picked posts if there are some
$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_wrapper_modules', $args );
$mod_query = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-wrapper sidebar-<?php echo $sidebar_pos; ?> clear <?php quadro_mod_parallax($mod_id); ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<div class="inner-mod-wrapper">

		<?php if( $mod_query->have_posts() ) : ?>

			<div class="modules-wrapper">

					<?php while( $mod_query->have_posts() ) : $mod_query->the_post(); ?>

						<?php // Retrieve Module type
						$mod_type = esc_attr( get_post_meta( get_the_ID(), 'quadro_mod_type', true ) ); ?>
						<?php // and call the template for it
						get_template_part( 'module', $mod_type ); ?>

					<?php endwhile; ?>

			</div>

		<?php endif; // ends 'mod_query' loop ?>
		
		<?php wp_reset_postdata(); ?>

		<div id="secondary" class="widget-area" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( $sidebar_pick ) ) : ?>
				<aside class="help">
					<p><?php esc_html_e('Would like to activate some Widgets?', 'quadro'); ?>
					<br /><?php esc_html_e('Go to Appearance > Widgets. Just like that!', 'quadro'); ?></p>
				</aside>
			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary -->

	</div>

</section>
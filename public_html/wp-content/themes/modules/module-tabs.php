<?php
/**
 * The template used for displaying Modules Tabs content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Sidebar Position
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$titles			= get_post_meta( $mod_id, 'quadro_mod_tabs_titles', true );

// Query for the Modules Tabs Modules
$args = array(
	'post_type' =>  'quadro_mods',
	'posts_per_page' => -1,
	'no_found_rows' => true,
	'update_post_term_cache' => false,
);
// Bring picked posts if there are some
$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_tabs_modules', $args );
$mod_query = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-tabs clear <?php quadro_mod_parallax($mod_id); ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<div class="inner-mod-wrapper">

		<?php if( $mod_query->have_posts() ) : ?>

			<div class="modules-tabs">

				<ul id="mods-tabs-list" class="mods-tabs-list">
					<?php $i = 0; ?>
					<?php while( $mod_query->have_posts() ) : $mod_query->the_post(); ?>
						<?php $tab_title = isset($titles[$i]) && $titles[$i]['title'] !== '' ? wp_kses_post($titles[$i]['title']) : get_the_title(); ?>
						<li id="tab<?php echo $i; ?>" class="<?php echo $i === 0 ? 'current' : ''; ?>"><a href="#"><?php echo $tab_title; ?></a></li>
						<?php $i++; ?>
					<?php endwhile; ?>
				</ul>

				<div id="mods-tabs" class="mods-tabs">
					<?php $i = 0; ?>
					<?php while( $mod_query->have_posts() ) : $mod_query->the_post(); ?>
						<div id="tab<?php echo $i; ?>-tab" class="mod-tab <?php echo $i === 0 ? 'visible' : ''; ?>">
							<?php // Retrieve Module type
							$mod_type = esc_attr( get_post_meta( get_the_ID(), 'quadro_mod_type', true ) ); ?>
							<?php // and call the template for it
							get_template_part( 'module', $mod_type ); ?>
						</div>
						<?php $i++; ?>
					<?php endwhile; ?>
				</div>

			</div>

		<?php endif; // ends 'mod_query' loop ?>
		
		<?php wp_reset_postdata(); ?>

	</div>

</section>
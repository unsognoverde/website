<?php
/**
 * The template used for displaying Crelly Slider Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Module Data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );

// Get Crelly Slider Shortcode
$slider_shortcode = get_post_meta( $mod_id, 'quadro_mod_crelly_shortcode', true );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-crelly-slider no-margins <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>
	
	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<?php echo do_shortcode( $slider_shortcode ); ?>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->

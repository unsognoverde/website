<?php
/**
 * The template used for displaying Canvas Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );

?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-canvas <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">
	
	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>
	
	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<div class="canvas-content">

				<?php the_content(); ?>

			</div><!-- .canvas-content -->

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .home-module -->

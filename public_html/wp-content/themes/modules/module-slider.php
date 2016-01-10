<?php
/**
 * The template used for displaying Slider Modules content
 *
 */
?>

<?php
$mod_id = get_the_ID();

$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$time 			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slider_time', true ) );
$margins 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slider_margins', true ) );
$height 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slider_height', true ) );
$slides 		= get_post_meta( $mod_id, 'quadro_mod_slider_slides', true );

// Define px or 100vh
if ( stripos( $height, 'vh' ) ) {
	$vh_used = 'vh-used';
	$height = '100vh';
}
else { 
	$vh_used = 'novh-used';
}

?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-slider clear margins-<?php echo $margins; ?> <?php echo $vh_used; ?> <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">
	
	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<?php if ( !empty($slides) ) { ?>

				<input type="hidden" id="slider-time" value="<?php echo $time; ?>">

				<ul class="quadro-slides slides" style="height: <?php echo $height; ?>;">
					
					<?php foreach ($slides as $slide) { ?>

						<?php
						// Get options for this slide
						$content 		= wp_kses_post( $slide['content'] );
						$action_link 	= esc_url( $slide['link_url'] );
						$action_text 	= esc_attr( $slide['link_text'] );
						$align 			= esc_attr( $slide['align'] );
						?>

						<li class="quadro-slide align-<?php echo $align; ?>" style="background-image: url('<?php echo qi_image_by_url( esc_url( $slide['img'] ), 'full' ); ?>');">
							<div class="dark-overlay"></div>

							<div class="inner-slide">
								<div class="slide-content">
									<?php if ( $action_link != '' ) { ?>
										<a href="<?php echo $action_link; ?>" class="slide-content-link" title="<?php echo $action_text; ?>">
									<?php } ?>
									
									<?php $content = apply_filters( 'the_content', $content );
									echo $content; ?>

									<?php if ( $action_text != '' ) { ?>
										<span class="qbtn slide-content-rmore"><?php echo $action_text; ?></span>
									<?php } ?>
									<?php if ( $action_link != '' ) { ?>
										</a>
									<?php } ?>
							</div>
							</div>
						</li>

					<?php } // end foreach ?>

				</ul>

			<?php } // if not empty ?>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>

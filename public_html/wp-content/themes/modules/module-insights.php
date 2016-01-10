<?php
/**
 * The template used for displaying Insights Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Module data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$insights		= get_post_meta( $mod_id, 'quadro_mod_insights', true );
$color 			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_insights_color', true ) );
$anim 			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_insights_anim', true ) );
$anim_delay 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_insights_anim_delay', true ) );
// Ensure minimal default value for animation delay
$anim_delay		= $anim_delay !== '' ? $anim_delay : 0;

// Bring available animations variable
global $qi_animations;
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-insights <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<ul class="insights">
				<?php if ( is_array($insights) ) {
					foreach ($insights as $insight) { ?>
						<li class="insight <?php echo esc_attr( $insight['layout'] ); ?>-insight clear">

							<?php // Define image sizes
							if ( ($insight['layout'] == 'layout1' || $insight['layout'] == 'layout2' ) && $insight['img'] != '' ) {
								$img_size = 'large';
							} else if ( ($insight['layout'] == 'layout3' || $insight['layout'] == 'layout4' ) && $insight['img'] != '' ) {
								$img_size = 'full';
							} ?>

							<?php // Check for possible empty image in this insight
							if ( ($insight['layout'] == 'layout1' || $insight['layout'] == 'layout3' ) && $insight['img'] != '' ) { ?>
							<img src="<?php echo qi_image_by_url( esc_url( $insight['img'] ), $img_size ); ?>" class="<?php echo $qi_animations[$anim]['first']; ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>">
							<?php } ?>
							
							<?php // Check for possible empty content in this insight
							if (  $insight['title'] != '' || $insight['content'] != '' ) { ?>
								<div class="insight-text <?php echo $qi_animations[$anim]['second']; ?>" data-wow-delay="<?php echo $anim_delay; ?>ms" style="color: <?php echo $color; ?>;">
									<?php if ( $insight['title'] != '' ) { ?>
									<h4><?php echo esc_attr( $insight['title'] ); ?></h4>
									<?php } ?>
									<?php if ( $insight['content'] != '' ) { ?>
									<p><?php echo wp_kses_post( $insight['content'] ); ?></p>
									<?php } ?>
									<?php if ( $insight['button_text'] != '' ) { ?>
									<a href="<?php echo esc_url($insight['button_url']); ?>" title="<?php echo esc_attr($insight['button_text']); ?>" class="qbtn insight-link"><?php echo esc_attr($insight['button_text']); ?></a>
									<?php } ?>
								</div>
							<?php } ?>

							<?php // Check for possible empty imgage in this insight
							if ( ($insight['layout'] == 'layout2' || $insight['layout'] == 'layout4' ) && $insight['img'] != '' ) { ?>
							<img src="<?php echo qi_image_by_url( esc_url( $insight['img'] ), $img_size . 'quadro-full-thumb' ); ?>" class="<?php echo $qi_animations[$anim]['first']; ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>">
							<?php } ?>

						</li>
					<?php } 
				} ?>
			</ul>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->

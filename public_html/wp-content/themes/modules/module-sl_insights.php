<?php
/**
 * The template used for displaying Slidable Insights Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Module data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$sl_insights	= get_post_meta( $mod_id, 'quadro_mod_sl_insights', true );
$size			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_sl_insights_size', true ) );
$nav			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_sl_insights_nav', true ) );
$color 			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_sl_insights_color', true ) );
$anim 			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_sl_insights_anim', true ) );
$anim_delay 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_sl_insights_anim_delay', true ) );
// Ensure minimal default value for animation delay
$anim_delay		= $anim_delay !== '' ? $anim_delay : 0;

// Bring available animations variable
global $qi_animations;
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-sl-insights <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> size-<?php echo $size; ?> nav-<?php echo $nav; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<ul class="sl-insights slides clear">
				<?php if ( is_array($sl_insights) ) {
					foreach ($sl_insights as $sl_insight) { ?>
						<li class="sl-insight <?php echo esc_attr( $sl_insight['layout'] ); ?>-sl-insight">

							<?php // Define image sizes
							if ( ($sl_insight['layout'] == 'layout1' || $sl_insight['layout'] == 'layout2' ) && $sl_insight['img'] != '' ) {
								$img_size = 'large';
							} else if ( ($sl_insight['layout'] == 'layout3' || $sl_insight['layout'] == 'layout4' ) && $sl_insight['img'] != '' ) {
								$img_size = 'full';
							} ?>

							<?php // Check for possible empty image in this showcas
							if ( ($sl_insight['layout'] == 'layout1' || $sl_insight['layout'] == 'layout3' ) && $sl_insight['img'] != '' ) { ?>
							<img src="<?php echo qi_image_by_url( esc_url( $sl_insight['img'] ), $img_size ); ?>" class="<?php echo $qi_animations[$anim]['first']; ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>">
							<?php } ?>
							
							<?php // Check for possible empty content in this showcas
							if (  $sl_insight['title'] != '' || $sl_insight['content'] != '' ) { ?>
								<div class="sl-insight-text <?php echo $qi_animations[$anim]['second']; ?>" data-wow-delay="<?php echo $anim_delay; ?>ms" style="color: <?php echo $color; ?>;">
									<?php if ( $sl_insight['title'] != '' ) { ?>
									<h4><?php echo esc_attr( $sl_insight['title'] ); ?></h4>
									<?php } ?>
									<?php if ( $sl_insight['content'] != '' ) { ?>
									<p><?php echo wp_kses_post( $sl_insight['content'] ); ?></p>
									<?php } ?>
									<?php if ( $sl_insight['button_text'] != '' ) { ?>
									<a href="<?php echo esc_url($sl_insight['button_url']); ?>" title="<?php echo esc_attr($sl_insight['button_text']); ?>" class="qbtn sl-insight-link"><?php echo esc_attr($sl_insight['button_text']); ?></a>
									<?php } ?>
								</div>
							<?php } ?>

							<?php // Check for possible empty imgage in this showcas
							if ( ($sl_insight['layout'] == 'layout2' || $sl_insight['layout'] == 'layout4' ) && $sl_insight['img'] != '' ) { ?>
							<img src="<?php echo qi_image_by_url( esc_url( $sl_insight['img'] ), $img_size . 'quadro-full-thumb' ); ?>" class="<?php echo $qi_animations[$anim]['first']; ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>">
							<?php } ?>

						</li>
					<?php } 
				} ?>
			</ul>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->

<?php
/**
 * The template used for displaying Services Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Service Module Layout Style and Posts list
$header_layout 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$services_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_services_layout', true ) );
$services_columns 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_services_columns', true ) );
$services_show 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_services_show', true ) );
$services_color 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_services_color', true ) );
$services_icolor 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_services_icolor', true ) );
$services 			= get_post_meta( $mod_id, 'quadro_mod_services_services', true );
$anim 				= esc_attr( get_post_meta( $mod_id, 'quadro_mod_services_anim', true ) );
$anim_delay 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_services_anim_delay', true ) );
// Ensure minimal default value for animation delay
$anim_delay			= $anim_delay !== '' ? $anim_delay : 0;
$delay 				= 0;

// Retrieve Theme Options
global $quadro_options, $qi_animations;

?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-services services-<?php echo $services_layout; ?> <?php echo $services_columns; ?>-columns <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">
	
	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>
	
	<div class="mod-content">

		<div class="inner-mod">

			<ul class="quadro-services clear">

				<style>
					#post-<?php echo $mod_id; ?> a { color: <?php echo $services_color ?> ; }
				</style>
				
				<?php foreach ( $services as $service ) { ?>
					
					<?php
					// Get options for this Service
					$service_title 		= esc_attr( $service['title'] );
					$service_content 	= strip_tags( $service['content'], '<div><img><p><span><a><br><strong><em><i><bold><small>' );
					$service_link 		= esc_url( $service['link_url'] );
					$link_text 			= esc_attr( $service['link_text'] );
					$service_img 		= esc_url( $service['img'] );
					$service_icon 		= esc_attr( $service['icon'] );
					?>

					<li class="quadro-service <?php echo $services_show; ?>-service <?php echo $qi_animations[$anim]['first']; ?>" data-wow-delay="<?php echo $delay; ?>ms" style="color: <?php echo $services_color; ?>;">
						
						<?php if ( $services_show != 'none' && $services_layout != 'type3' ) { ?>
						<span class="service-icon">
							
							<?php if ( $service_link != '' ) echo '<a href="' . $service_link . '" title="' . $service_title . '">'; ?>
								
								<?php // Bring Icon or Image
								if ( $services_show == 'icon' ) {
									echo '<i class="' . $service_icon . '" style="color: ' . $services_icolor . ';"></i>';
								} elseif ( $services_show == 'image' && $service_img != '' ) {
									echo '<img src="' . qi_image_by_url( $service_img, 'quadro-med-thumb' ) . '" title="' . $service_title . '" />';
								} ?>
							
							<?php if ( $service_link != '' ) echo '</a>'; ?>
						
						</span>
						<?php } ?>

						<?php if ( $services_layout == 'type3' && $service_img != '' ) {
							echo '<img src="' . qi_image_by_url( $service_img, 'quadro-med-thumb' ) . '" title="' . $service_title . '" />';
						} ?>

						<div class="service-content-wrapper">

								<h2 class="service-title">
									<?php if ( $service_link != '' ) echo '<a href="' . $service_link . '" title="' . $service_title . '">';
									echo $service_title;
									if ( $service_link != '' ) echo '</a>'; ?>
								</h2>

							<?php if ( $service_content != '' ) 
								echo '<div class="service-content">' . $service_content . '</div>'; ?>

							<?php if ( $service_link != '' && $link_text != '' ) {
								echo '<a href="' . $service_link . '" class="qbtn service-link" title="' . $link_text . '">';
								echo $link_text;
								echo '</a>';
							} ?>

						</div>
					
					</li>

					<?php // Increase animation delay
					$delay = $delay + $anim_delay; ?>

				<?php } // ends services loop ?>

			</ul>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>
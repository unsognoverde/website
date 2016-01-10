<?php
/**
 * The template used for displaying Slogan Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Slogan Module data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$slogan_text 	= wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_slogan_text', true ) );
$use_slider 	= wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_slogan_gallery', true ) );
$video_poster 	= esc_url( get_post_meta( $mod_id, 'quadro_mod_back_pic', true ) );
$video_mp4 		= esc_url( get_post_meta( $mod_id, 'quadro_mod_slogan_video_mp4', true ) );
$video_webm 	= esc_url( get_post_meta( $mod_id, 'quadro_mod_slogan_video_webm', true ) );
$video_ogv 		= esc_url( get_post_meta( $mod_id, 'quadro_mod_slogan_video_ogv', true ) );
$action_text 	= wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_slogan_action_text', true ) );
if ( $action_text != '' ) {
	$action_link 	= esc_url( get_post_meta( $mod_id, 'quadro_mod_slogan_action_link', true ) );
	$action_color 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slogan_action_color', true ) );
	$action_back 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slogan_action_back', true ) );
}
$action2_text 	= wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_slogan_action2_text', true ) );
if ( $action2_text != '' ) {
	$action2_link 	= esc_url( get_post_meta( $mod_id, 'quadro_mod_slogan_action2_link', true ) );
	$action2_color 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slogan_action2_color', true ) );
	$action2_back 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slogan_action2_back', true ) );
}
$size			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slogan_size', true ) );
$align			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slogan_align', true ) );
$anim 			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slogan_anim', true ) );
$anim_delay 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_slogan_anim_delay', true ) );
// Ensure minimal default value for animation delay
$anim_delay		= $anim_delay !== '' ? $anim_delay : 0;

// Set background to none if slider is being used
$style = $use_slider != '' ? 'style="background-image: none !important;"' : '';

// Bring avaiable animations
global $qi_animations;

?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-slogan <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> size-<?php echo $size; ?> align-<?php echo $align; ?> overlay-<?php echo $overlay; ?>" <?php echo $style; ?>>

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<?php // Prepare Video Background if Present
	if ( $video_mp4 != '' || $video_webm != '' || $video_ogv != '' ) {
		$video_html = '<div class="video-wrap">
			<img class="mobile-video-poster" src="' . $video_poster . '" style="display:none;"">
			<video class="slogan-video-back" preload="auto" loop autoplay muted>';
				if ( '' != $video_webm ) { $video_html .= '<source type="video/webm" src="' . $video_webm . '">'; }
				if ( '' != $video_mp4 ) { $video_html .= '<source type="video/mp4" src="' . $video_mp4 . '">'; }
				if ( '' != $video_ogv ) { $video_html .= '<source type="video/ogg" src="' .  $video_ogv . '">'; }
			$video_html .='</video>
		</div>';
		// Output Video Element
		echo $video_html;
	} ?>

	<div class="dark-overlay"></div>
	
	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">
	
		<?php quadro_maybe_print_gallery_field_as_bg( 'quadro_mod_slogan_gallery', $mod_id, 'full', 'slogan-slider' ); ?>

		<div class="inner-mod">

			<div class="slogan-wrapper">
				
				<div class="slogan-content-wrapper <?php echo $qi_animations[$anim]['first']; ?>">
					<?php $slogan_text = apply_filters( 'the_content', $slogan_text );
					echo $slogan_text; ?>
				</div>

				<?php if ( $action_text != '' ) { ?>
					<a href="<?php echo $action_link; ?>" style="color: <?php echo $action_color; ?>; background: <?php echo $action_back; ?>;" class="slogan-call-to-action qbtn <?php echo $qi_animations[$anim]['second']; ?>" data-wow-delay="<?php echo $anim_delay; ?>ms"><?php echo $action_text; ?></a>
				<?php } ?>

				<?php if ( $action2_text != '' ) { ?>
					<a href="<?php echo $action2_link; ?>" style="color: <?php echo $action2_color; ?>; background: <?php echo $action2_back; ?>;" class="slogan-call-to-action qbtn <?php echo $qi_animations[$anim]['second']; ?>" data-wow-delay="<?php echo $anim_delay; ?>ms"><?php echo $action2_text; ?></a>
				<?php } ?>
			
			</div><!-- .slogan-wrapper -->

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->

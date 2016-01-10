<?php
/**
 * The template used for displaying Team Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Team Module data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$team 			= get_post_meta( $mod_id, 'quadro_mod_team_content', true );
$team_style 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_team_style', true ) );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-team <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>
	
	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<?php if ( !empty($team) ) { ?>
				
				<div class="team-<?php echo $team_style; ?>">

					<ul class="team clear">

						<?php foreach ($team as $member) { ?>
						
							<li class="team-member">
								<div class="team-member-wrapper clear">

									<?php $img_url = isset($member['img']) ? esc_url( $member['img'] ) : '';
									if ( $img_url != '' ) {
										echo '<div class="member-photo-wrapper">';
										echo '<img src="' . qi_image_by_url( $img_url, 'quadro-sq-thumb' ) . '" title="' . esc_attr( $member['name'] ) . '"></div>';
									} ?>

									<div class="member-content">
										<h3 class="member-name">
											<?php $url = isset($member['link']) ? esc_url( $member['link'] ) : ''; ?>
											<?php if ( $url != '' ) echo '<a href="' . $url . '">'; ?>
											<?php $name = isset($member['name']) ? esc_attr( $member['name'] ) : '';
											if ( $name != '' ) echo $name; ?>
											<?php if ( $url != '' ) echo '</a>'; ?>
										</h3>
										<span class="member-role">
											<?php $role = isset($member['role']) ? esc_attr( $member['role'] ) : '';
											if ( $role != '' ) echo $role; ?>
										</span>
										<?php $content = isset($member['content']) ? esc_attr( $member['content'] ) : '';
										// Filter through the_content filter
										$content = apply_filters( 'the_content', $content );
										$content = str_replace( ']]>', ']]&gt;', $content );
										if ( $content != '' ) echo $content; ?>
										<?php $social = isset($member['social']) ? $member['social'] : '';
										// Print Social Networks Links if there are some
										if ( !empty($social) ) {
											echo '<div class="member-socials">';
											foreach ($social as $network => $value) {
												if ( isset($value) && $value != '' ) {
													if ( $network == 'envelope' ) $value = 'mailto:' . $value;
													echo '<a href="' . esc_url($value) . '"><i class="fa fa-' . esc_attr($network) . '"></i></a>';
												}
											}
											echo '</div>';
										} ?>
									</div>
								</div>
							</li>

						<?php } ?>

					</ul>

				</div>

			<?php } ?>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->

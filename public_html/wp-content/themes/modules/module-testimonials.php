<?php
/**
 * The template used for displaying Testimonials Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Testimonials Module data
$header_layout 			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay				= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$testimonials 			= get_post_meta( $mod_id, 'quadro_mod_testimonial_content', true );
$testimonial_style 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_testimonial_style', true ) );
$testimonial_back_style = esc_attr( get_post_meta( $mod_id, 'quadro_mod_testimonial_back_style', true ) );
$testimonial_back 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_testimonial_back', true ) );
$testimonial_color 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_testimonial_color', true ) );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-testimonials <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?> testimonial-back-<?php echo $testimonial_back_style;?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>
	
	<div class="mod-content">

		<div class="inner-mod">

			<?php if ( !empty($testimonials) ) { ?>
				
				<div class="testimonials-wrapper">

					<div class="testimonials-<?php echo $testimonial_style; ?>">

						<ul class="testimonials slides clear">

							<?php foreach ($testimonials as $testimonial) { ?>
							
								<li class="testimonial-item">

										<div class="testimonial-item-content" style="background: <?php echo $testimonial_back; ?>; color: <?php echo $testimonial_color; ?>;">

											<?php $content = isset($testimonial['content']) ? esc_attr( $testimonial['content'] ) : '';
											if ( $content != '' ) echo '<p>' . $content . '</p>'; ?>

											<div class="testimonial-item-author">
												<?php 
												// Check for link and bring it
												$url = isset($testimonial['link']) ? esc_url( $testimonial['link'] ) : '';
												if ( $url != '' ) echo '<a href="' . $url . '" style="color: ' . $testimonial_color . ';">';
												// Check for photo and bring it
												$img_url = isset($testimonial['img']) ? esc_url( $testimonial['img'] ) : '';
												if ( $img_url != '' ) {
													echo '<img src="' . qi_image_by_url( $img_url, 'thumbnail' ) . '" title="' . esc_attr( $testimonial['author'] ) . '" class="testimonial-photo">';
												}
												echo '<span class="testimonial-author-name">';
													// Check for author and bring it
													$author = isset($testimonial['author']) ? esc_attr( $testimonial['author'] ) : '';
													if ( $author != '' ) echo $author;
													// Check for author subtitle and bring it
													$title = isset($testimonial['subtitle']) ? esc_attr( $testimonial['subtitle'] ) : '';
													if ( $title != '' ) echo '<span class="testimonial-author-subtitle">' . $title . '</span>';
												echo '</span>';
												// Check for link and close it
												if ( $url != '' ) echo '</a>';
												?>
											</div>

										</div>

								</li>

							<?php } ?>

						</ul>

					</div>

				</div><!-- .testimonials-wrapper -->

			<?php } ?>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->

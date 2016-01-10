<?php
/**
 * The template used for displaying Logos Roll Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Logos Module data
$logos 				= get_post_meta( $mod_id, 'quadro_mod_logos_content', true );
$header_layout 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$logos_layout 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_logos_layout', true ) );
$logos_columns 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_logos_columns', true ) );
$logos_cols 		= array( 'three' => 3, 'four' => 4, 'five' => 5, 'six' => 6 );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-logos logos-<?php echo $logos_layout; ?> <?php echo $logos_columns; ?>-columns <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>" data-columns="<?php echo $logos_cols[$logos_columns]; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>
	
	<div class="mod-content">

		<div class="inner-mod">

			<?php if ( !empty($logos) ) { ?>
				
				<div class="logos-wrapper">

					<ul class="logos slides clear">

						<?php foreach ($logos as $logo) { ?>

							<li class="logo-profile">
								<div class="logo-content clear">
									<?php if ( isset($logo['link_url']) && $logo['link_url'] != '' ) {
										echo '<a href="' . esc_url($logo['link_url']) . '" target="_blank" class="logo-link">';
									}
									$img_url = isset($logo['img']) ? esc_url( $logo['img'] ) : '';
									if ( $img_url != '' ) { 
										echo '<img src="' . qi_image_by_url( $img_url, 'medium' ) . '" alt="">';
									}
									if ( isset($logo['link_url']) && $logo['link_url'] != '' ) {
										echo '</a>';
									} ?>
								</div>
							</li>

						<?php } ?>

					</ul>

				</div>

			<?php } ?>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section><!-- .module -->

<?php
/**
 * The template used for displaying Video Posts Modules content
 *
 */
?>

<?php
$mod_id = get_the_ID();

// Get Video Posts Module Data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$picker_method 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_videoposts_method', true ) );
$items_perpage 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_videoposts_pper', true ) );
$offset 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_videoposts_offset', true ) );
$exclude 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_videoposts_exclude', true ) );
$items_perpage 	= $items_perpage != '' ? $items_perpage : 200;

// Now, let's get all the slides
$args = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => 'post-format-video'
		)
	),
	'posts_per_page' => $items_perpage,
	'offset' => $offset,
	'no_found_rows' => true,
	'post__not_in' => explode( ',', $exclude )
 );

// Modify Query depending on the selected Show Method
if ( $picker_method == 'tax' ) {
	// Bring Selected Categories
	$sel_terms = esc_attr( get_post_meta( $mod_id, 'quadro_mod_videoposts_terms', true ) );
	if ( $sel_terms != '' ) {
		// Add tax query to query arguments
		$args['cat'] = $sel_terms;
	}
}
elseif ( $picker_method == 'custom' ) {
	// Bring picked posts if there are some
	$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_pick_videoposts', $args );
}

$videoposts = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-videoposts clear <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">
	
	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>
	
	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<div class="videos-wrapper">

				<div class="videos-slider">

					<ul class="quadro-videos slides">
						
						<?php if( $videoposts->have_posts() ) : while( $videoposts->have_posts() ) : $videoposts->the_post(); ?>
							
							<li class="quadro-video">
								<div class="quadro-video-container">
									<?php 
									$video_post = quadro_print_media(get_the_content(), array('video', 'object', 'iframe', 'embed'), 1, '<div class="media-wrapper">', '</div>');
									echo $video_post['media'];
									?>
								</div>
								<div class="video-post">
									<h3 class="entry-title">
										<a href="<?php the_permalink(); ?>" title="<?php get_the_title(); ?>">
											<?php the_title(); ?>
										</a>
									</h3>
									<p><?php quadro_excerpt(get_the_excerpt(), 25, '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>'); ?></p>
								</div>
							</li>

						<?php endwhile; endif; // ends video posts loop ?>
						<?php wp_reset_postdata(); ?>

					</ul>

				</div>

				<div id="videos-nav" class="videos-nav">
					<ul class="slides">
						<?php if( $videoposts->have_posts() ) : while( $videoposts->have_posts() ) : $videoposts->the_post(); ?>
							<li class="videos-nav-item format-video">
								<?php if ( has_post_thumbnail() && ! post_password_required() ) { ?>
									<?php the_post_thumbnail('thumbnail'); ?>
								<?php } else {
									// there's no thumbnail, try to bring a video screenshot
									echo '<img src="' . quadro_video_screenshot_url( get_the_content() ) . '">';
								} ?>
							</li>
						<?php endwhile; endif; // ends 'videoposts' loop ?>
						<?php wp_reset_postdata(); ?>
					</ul>
				</div>

			</div>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>

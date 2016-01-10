<?php
/**
 * The template used for displaying Display Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Display Module Data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$layout		 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_display_layout', true ) );
$mod_margins 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_display_margins', true ) );
$picker_method 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_display_method', true ) );
$offset 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_display_offset', true ) );
$exclude 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_display_exclude', true ) );

// Determine amount of posts to bring based on layout
if ( $layout == 'layout1' || $layout == 'layout4' ) $items_perpage = 4;
elseif ( $layout == 'layout2' ) $items_perpage = 5;
elseif ( $layout == 'layout3' ) $items_perpage = 3;
elseif ( $layout == 'layout5' ) $items_perpage = 6;
// Set counter
$i = 1;


// Now, let's get all the display posts
$args = array(
	'post_type' => array( 'post', 'product' ),
	'posts_per_page' => $items_perpage,
	'offset' => $offset,
	'no_found_rows' => true,
	'post__not_in' => explode( ',', $exclude )
);

// Modify Query depending on the selected Show Method
if ( $picker_method == 'tax' ) {
	// Bring Selected Categories
	$sel_terms = esc_attr( get_post_meta( $mod_id, 'quadro_mod_display_terms', true ) );
	if ( $sel_terms != '' ) {
		// Add tax query to query arguments
		$args['cat'] = $sel_terms;
	}
}
elseif ( $picker_method == 'format' ) {
	// Bring selected post formats
	$args = quadro_add_selected_formats( $mod_id, 'quadro_mod_display_formats', $args );
}
elseif ( $picker_method == 'custom' ) {
	// Bring picked posts if there are some
	$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_pick_display', $args );
}

$display_posts = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-display <?php quadro_mod_parallax($mod_id); ?> <?php echo $mod_margins; ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">
	
	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<div class="display-wrapper display-<?php echo $layout; ?>">

				<ul class="clear">

					<?php if( $display_posts->have_posts() ) : while( $display_posts->have_posts() ) : $display_posts->the_post(); ?>

						<?php $post_id = get_the_ID(); ?>

						<li id="display-post-<?php the_ID(); ?>" <?php post_class('display-item display-item' . $i); ?>>
						
							<?php // Defining Thumb Sizes
							if ( ($layout == 'layout1' || $layout == 'layout3') && $i == 1 ) $thumb_size = 'large';
							else $thumb_size = 'quadro-med-thumb';
							?>

							<?php // Get post format
							$post_format = get_post_format($post_id);
							// Bring Feat. Image or Screenshot if video post
							if ( $post_format != 'video' || has_post_thumbnail() ) {
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumb_size );
								$image = $image[0];
							} else {
								$image = quadro_video_screenshot_url( get_the_content() );
							}
							$back_img = 'style="background-image: url(\'' . $image . '\');"';
							?>

							<article>

								<a href="<?php the_permalink(); ?>" rel="bookmark">
									<div class="display-back-img lazy" data-original="<?php echo $image[0]; ?>" <?php echo $back_img; ?>></div>
								</a>

								<div class="display-content">

									<?php quadro_posted_on(); ?>

									<?php if ( $post_format != 'aside' && $post_format != 'status' && $post_format != 'quote' ) { ?>
									<h1 class="entry-title">
										<a href="<?php the_permalink(); ?>" rel="bookmark">
											<?php the_title(); ?>
										</a>
									</h1>
									<div class="entry-summary">
										<?php echo quadro_excerpt(get_the_excerpt(), 25, '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>'); ?>
									</div><!-- .entry-summary -->
									<?php } 
									elseif ( $post_format == 'quote' ) {
										if ( get_the_title() != '' ) { ?>
											<h1 class="entry-title">
												<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
											</h1>
										<?php } else {
											echo '<div class="entry-summary">';
											echo '<a href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">';
											echo quadro_excerpt(get_the_excerpt(), 15, '');
											echo '</a>';
											echo '</div>';
										}
									} elseif ( $post_format == 'aside' || $post_format == 'status' ) {
										echo '<div class="entry-summary">';
										echo '<a href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">';
										echo quadro_excerpt(get_the_excerpt(), 15, '');
										echo '</a>';
										echo '</div>';
									} ?>

								</div>

							</article>
						
						</li>

						<?php $i++; ?>

					<?php endwhile; endif; // ends Display loop ?>
					<?php wp_reset_postdata(); ?>

				</ul>

			</div>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>
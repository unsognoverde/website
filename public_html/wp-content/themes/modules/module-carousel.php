<?php
/**
 * The template used for displaying Carousel Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Carousel Module Data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$mod_margins 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_carousel_margins', true ) );
$picker_method 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_carousel_method', true ) );
$items_perpage 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_carousel_pper', true ) );
$offset 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_carousel_offset', true ) );
$exclude 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_carousel_exclude', true ) );
$items_perpage 	= $items_perpage != '' ? $items_perpage : 200;


// Now, let's get all the carousel posts
$args = array(
	'post_type' => array( 'post', 'product' ),
	'posts_per_page' => $items_perpage,
	'offset' => $offset,
	'no_found_rows' => true,
	'post__not_in' => explode( ',', $exclude ),
);

// Modify Query depending on the selected Show Method
if ( $picker_method == 'tax' ) {
	// Bring Selected Categories
	$sel_terms = esc_attr( get_post_meta( $mod_id, 'quadro_mod_carousel_terms', true ) );
	if ( $sel_terms != '' ) {
		// Add tax query to query arguments
		$args['cat'] = $sel_terms;
	}
}
elseif ( $picker_method == 'format' ) {
	// Bring selected post formats
	$args = quadro_add_selected_formats( $mod_id, 'quadro_mod_carousel_formats', $args );
}
elseif ( $picker_method == 'custom' ) {
	// Bring picked posts if there are some
	$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_pick_carousel', $args );
}

$home_carousel = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-carousel <?php quadro_mod_parallax($mod_id); ?> <?php echo $mod_margins; ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">
	
	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>
	
	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<div class="carousel-wrapper">

				<ul class="carousel slides clear">

					<?php if( $home_carousel->have_posts() ) : while( $home_carousel->have_posts() ) : $home_carousel->the_post(); ?>

						<?php $post_id = get_the_ID(); ?>

						<li id="carousel-post-<?php the_ID(); ?>" class="carousel-item">

							<?php // Get post format
							$post_format = get_post_format($post_id);
							// Bring Feat. Image or Screenshot if video post
							if ( $post_format != 'video' || has_post_thumbnail() ) {
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'quadro-med-thumb' );
								$image = $image[0];
							} else {
								$image = quadro_video_screenshot_url( get_the_content() );
							}
							$back_img = 'style="background-image: url(\'' . $image . '\');"';
							?>

							<article <?php post_class(); ?>>

								<div class="carousel-back-img lazy" data-original="<?php echo $image[0]; ?>" <?php echo $back_img; ?>></div>
								
								<div class="carousel-content">

									<?php quadro_posted_on(); ?>

									<?php if ( $post_format != 'aside' && $post_format != 'status' && $post_format != 'quote' ) { ?>
									<h1 class="entry-title">
										<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
									</h1>
									<?php } 
									elseif ( $post_format == 'quote' ) {
										if ( get_the_title() != '' ) { ?>
											<h1 class="entry-title">
												<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
											</h1>
										<?php } else {
											echo '<div class="entry-summary">';
											echo quadro_excerpt(get_the_excerpt(), 15, '');
											echo '</div>';	
										}
									} elseif ( $post_format == 'aside' || $post_format == 'status' ) {
										echo '<div class="entry-summary">';
										echo quadro_excerpt(get_the_excerpt(), 15, '');
										echo '</div>';
									} ?>

									<?php $categories_list = get_the_category_list( ', ' );
									if ( $categories_list && quadro_categorized_blog() ) : ?>
										<span class="cat-links">
											<?php echo $categories_list; ?>
										</span>
									<?php endif; // End if categories ?>
									
								</div>

							</article>
						
						</li>

					<?php endwhile; endif; // ends Carousel loop ?>
					<?php wp_reset_postdata(); ?>

				</ul>

			</div>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>
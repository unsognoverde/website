<?php
/**
 * The template used for displaying Magazine Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Module Data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$columns	 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_magazine_columns', true ) );
$chosen_perpage	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_magazine_perpage', true ) );
$excerpt	 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_magazine_excerpt', true ) );
$nothumb	 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_magazine_nothumb', true ) );
$layout		 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_magazine_layout', true ) );
$picker_method 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_magazine_method', true ) );
$offset 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_magazine_offset', true ) );
$exclude 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_magazine_exclude', true ) );
// Determine amount of posts to bring based on layout
if ( $layout == 'layout1' ) $items_perpage = 4;
elseif ( $layout == 'layout2' && $columns == 'two' ) $items_perpage = 6;
elseif ( $layout == 'layout2' && $columns == 'three' ) $items_perpage = 9;
elseif ( $layout == 'layout3' ) $items_perpage = $chosen_perpage;
elseif ( $layout == 'layout4' ) $items_perpage = $chosen_perpage;
// Set counter
$i = 1;


// Now, let's get all the magazine posts
$args = array(
	'post_type' => array( 'post' ),
	'offset' => $offset,
	'no_found_rows' => true,
);

// Add exclude parameter only if present
if ( $exclude != '' ) {
	$args['post__not_in'] = explode( ',', $exclude );
}

// Modify Query depending on the selected Show Method
if ( $picker_method == 'tax' ) {
	// Bring Selected Categories
	$sel_terms = esc_attr( get_post_meta( $mod_id, 'quadro_mod_magazine_terms', true ) );
	if ( $sel_terms != '' ) {
		// Add tax query to query arguments
		$args['cat'] = $sel_terms;
	}
}
elseif ( $picker_method == 'format' ) {
	// Bring selected post formats
	$args = quadro_add_selected_formats( $mod_id, 'quadro_mod_magazine_formats', $args );
}
elseif ( $picker_method == 'custom' ) {
	// Bring picked posts if there are some
	$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_pick_magazine', $args );
}

$magazine_posts = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-magazine magazine-<?php echo $layout; ?> mag-columns-<?php echo $columns; ?> <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">
	
	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>
	
	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

				<ul class="clear">

					<?php if( $magazine_posts->have_posts() ) : while( $magazine_posts->have_posts() ) : $magazine_posts->the_post(); ?>

						<?php $post_id = get_the_ID(); ?>
						
						<li id="magazine-post-<?php the_ID(); ?>" <?php post_class('magazine-item magazine-item' . $i); ?>>

							<?php // Get post data
							$post_format = get_post_format($post_id);

							// Exclude no Thumbnail Posts if Asked for
							if ( !has_post_thumbnail() && ($nothumb == 'true' && $post_format != 'video') ) continue;
							?>

							<article class="clear">

								<div class="entry-thumbnail">
									<?php if ( $post_format != 'video' || has_post_thumbnail() ) { ?>
										<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'quadro-med-thumb' );
										$back_img = 'style="background-image: url(\'' . $image[0] . '\');"'; ?>
										<a href="<?php the_permalink(); ?>" rel="bookmark" class="lazy" data-original="<?php echo $image[0]; ?>" <?php echo $back_img; ?> ></a>
									<?php } else {
										$image = quadro_video_screenshot_url( get_the_content() );
										$back_img = 'style="background-image: url(\'' . $image . '\');"'; ?>
										<a href="<?php the_permalink(); ?>" rel="bookmark" class="lazy" data-original="<?php echo $image[0]; ?>" <?php echo $back_img; ?> ></a>
									<?php } ?>

									<?php $categories_list = get_the_category_list( ', ' );
									if ( $categories_list && quadro_categorized_blog() ) : ?>
										<span class="cat-links">
											<?php echo $categories_list; ?>
										</span>
									<?php endif; // End if categories ?>
								</div>

								<div class="magazine-content">

									<?php if ( $post_format != 'aside' && $post_format != 'status' && $post_format != 'quote' ) { ?>

										<h1 class="entry-title">
											<a href="<?php the_permalink(); ?>" rel="bookmark">
												<?php the_title(); ?>
											</a>
										</h1>

										<?php quadro_posted_on(); ?>
									
									<?php } ?>

									<?php // Set content differentially for First and subsequent posts depending on the selected layout
									if ( ($layout == 'layout1' && $i == 1) || $layout == 'layout3' || ($layout == 'layout2' && ($i == 1 || $i == 2)) || ($layout == 'layout2' && $columns == 'three' && $i == 3) || ($layout == 'layout4' && $excerpt == 'show') || ($post_format == 'aside' || $post_format == 'status' || $post_format == 'quote') ) { ?>
										<div class="entry-summary">
											<?php echo quadro_excerpt(get_the_excerpt(), 25, ''); ?>
										</div><!-- .entry-summary -->
									<?php } ?>

								</div>

							</article>
						
						</li>

						<?php // Break if reached number of posts
						if ( $i == $items_perpage ) break; ?>

						<?php $i++; ?>

					<?php endwhile; endif; // ends magazine loop ?>
					<?php wp_reset_postdata(); ?>

				</ul>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>
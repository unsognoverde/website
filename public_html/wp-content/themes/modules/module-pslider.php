<?php
/**
 * The template used for displaying Posts Slider Modules content
 *
 */
?>

<?php
$mod_id = get_the_ID();

// Get Posts Slider Module Data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$mod_margins 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_margins', true ) );
$caption_style 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_caption_style', true ) );
$caption_pos 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_caption_pos', true ) );
$slider_time 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_time', true ) );
$slider_icon 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_icon', true ) );
$slider_date 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_date', true ) );
$slider_cats 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_cats', true ) );
$picker_method 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_method', true ) );
$items_perpage 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_pper', true ) );
$offset 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_offset', true ) );
$exclude 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_exclude', true ) );
$items_perpage 	= $items_perpage != '' ? $items_perpage : 3;
$slider_time 	= $slider_time != '' ? $slider_time : 4000;
$i = 1;

// Now, let's get all the slider posts
$args = array(
	'post_type' => array( 'post' ),
	'posts_per_page' => $items_perpage,
	'offset' => $offset,
	'no_found_rows' => true,
	'post__not_in' => explode( ',', $exclude )
);

// Modify Query depending on the selected Show Method
if ( $picker_method == 'tax' ) {
	// Bring Selected Categories
	$sel_terms = esc_attr( get_post_meta( $mod_id, 'quadro_mod_pslider_terms', true ) );
	if ( $sel_terms != '' ) {
		// Add tax query to query arguments
		$args['cat'] = $sel_terms;
	}
}
elseif ( $picker_method == 'format' ) {
	// Bring selected post formats
	$args = quadro_add_selected_formats( $mod_id, 'quadro_mod_pslider_formats', $args );
}
elseif ( $picker_method == 'custom' ) {
	// Bring picked posts if there are some
	$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_pick_pslider', $args );
}

$quadro_slides = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod caption-<?php echo $caption_style; ?> caption-<?php echo $caption_pos; ?> type-pslider clear <?php quadro_mod_parallax($mod_id); ?> <?php echo $mod_margins; ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>
	
	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<div id="quadro-slider" class="quadro-slider-el">

				<input type="hidden" class="slider-time" value="<?php echo $slider_time; ?>">

				<ul class="quadro-pslides slides">
					
					<?php if( $quadro_slides->have_posts() ) : while( $quadro_slides->have_posts() ) : $quadro_slides->the_post(); ?>

						<?php // Skip this post if has no thumbnail
						if ( ! has_post_thumbnail() ) continue; ?>

						<?php 
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'quadro-full-thumb' );
						$back_img = 'style="background-image: url(\'' . $thumb[0] . '\');"'; 
						?>

						<li <?php post_class('quadro-pslide lazy'); ?> data-original="<?php echo $thumb[0]; ?>" <?php echo $back_img; ?>>

							<?php if ( $caption_style == 'type1' ) { ?>
								<div class="dark-overlay"></div>
							<?php } ?>

							<div class="slide-caption">

								<?php if ( $slider_date == 'show' ) quadro_posted_on(); ?>

								<?php if ( $slider_cats == 'show' ) { ?>
									<?php $categories_list = get_the_category_list( ', ' );
									if ( $categories_list && quadro_categorized_blog() ) : ?>
										<span class="cat-links">
											<?php echo $categories_list; ?>
										</span>
									<?php endif; // End if categories ?>
								<?php } ?>
									
								<h3 class="entry-title">
									<a href="<?php the_permalink(); ?>" class="slider-caption-link" title="<?php echo get_the_title(); ?>"><?php the_title(); ?></a>
								</h3>								
								
								<?php if ( $caption_style == 'type1' ) { ?>
									<div class="entry-summary">
										<?php quadro_excerpt(get_the_excerpt(), 20, '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>'); ?>
									</div>
								<?php } ?>

							</div>

						</li>

						<?php // Increase counter
						$i++; ?>

					<?php endwhile; endif; // ends 'quadro_slides' loop ?>
					<?php wp_reset_postdata(); ?>

				</ul>

			</div>

			<div id="slider-nav" class="slider-nav">
				<ul class="slides">
					<?php if( $quadro_slides->have_posts() ) : while( $quadro_slides->have_posts() ) : $quadro_slides->the_post(); ?>
					<?php // Skip this post if has no thumbnail
					if ( ! has_post_thumbnail() ) continue; ?>
					<li class="slider-nav-item">
						<?php the_post_thumbnail( 'thumbnail', array('alt' => '' . get_the_title() . '', 'title' => '') ); ?>
					</li>
					<?php endwhile; endif; // ends 'quadro_slides' loop ?>
					<?php wp_reset_postdata(); ?>
				</ul>
			</div>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>

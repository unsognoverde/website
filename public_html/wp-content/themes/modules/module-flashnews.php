<?php
/**
 * The template used for displaying Flash News Modules content
 *
 */
?>

<?php 
$mod_id = get_the_ID();

// Get Module Data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$picker_method 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_flashnews_method', true ) );
$items_perpage 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_flashnews_pper', true ) );
$offset 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_flashnews_offset', true ) );
$exclude 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_flashnews_exclude', true ) );
$items_perpage 	= $items_perpage != '' ? $items_perpage : 100;


// Now, let's get all the flashnews posts
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
	$sel_terms = esc_attr( get_post_meta( $mod_id, 'quadro_mod_flashnews_terms', true ) );
	if ( $sel_terms != '' ) {
		// Add tax query to query arguments
		$args['cat'] = $sel_terms;
	}
}
elseif ( $picker_method == 'format' ) {
	// Bring selected post formats
	$args = quadro_add_selected_formats( $mod_id, 'quadro_mod_flashnews_formats', $args );
}
elseif ( $picker_method == 'custom' ) {
	// Bring picked posts if there are some
	$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_pick_flashnews', $args );
}

$home_flashnews = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-flashnews <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">
	
	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>
	
	<div class="mod-content">

		<div class="inner-mod">	
			
			<ul class="flashnews slides clear">

				<?php if( $home_flashnews->have_posts() ) : while( $home_flashnews->have_posts() ) : $home_flashnews->the_post(); ?>

					<?php $post_format = get_post_format( get_the_ID() ); ?>

					<li id="flashnews-post-<?php the_ID(); ?>" class="flashnews-item">

						<p class="flashnews-content">
							<?php $categories_list = get_the_category_list( ', ' );
							if ( $categories_list && quadro_categorized_blog() ) : ?>
								<span class="cat-links">
									<?php echo $categories_list; ?>
								</span>
							<?php endif; // End if categories ?>

							<a href="<?php the_permalink(); ?>" rel="bookmark" class="entry-title">
								<?php if ( $post_format != 'aside' && $post_format != 'status' && $post_format != 'quote' ) {
									the_title();
								} 
								elseif ( $post_format == 'quote' ) {
									if ( get_the_title() != '' ) {
										the_title();
									} else {
										echo quadro_excerpt(get_the_excerpt(), 15, '');
									}
								} elseif ( $post_format == 'aside' || $post_format == 'status' ) {
									echo quadro_excerpt(get_the_excerpt(), 15, '');
								} ?>
							</a>
						</p>

					</li>

				<?php endwhile; endif; // ends flashnews loop ?>
				<?php wp_reset_postdata(); ?>

			</ul>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>
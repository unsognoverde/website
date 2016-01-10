<?php
/**
 * The template used for displaying Quote Posts Modules content
 *
 */
?>

<?php
$mod_id = get_the_ID();

// Get Quote Posts Module Data
$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$picker_method 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_quoteposts_method', true ) );
$text_color 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_quoteposts_color', true ) );
$items_perpage 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_quoteposts_pper', true ) );
$items_perpage 	= $items_perpage != '' ? $items_perpage : -1;

// Now, let's get all the slides
$args = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => 'post-format-quote'
		)
	),
	'no_found_rows' => true,
	'posts_per_page' => $items_perpage
 );

// Modify Query depending on the selected Show Method
if ( $picker_method == 'tax' ) {
	// Bring Selected Categories
	$sel_terms = esc_attr( get_post_meta( $mod_id, 'quadro_mod_quoteposts_terms', true ) );
	if ( $sel_terms != '' ) {
		// Add tax query to query arguments
		$args['cat'] = $sel_terms;
	}
}
elseif ( $picker_method == 'custom' ) {
	// Bring picked posts if there are some
	$args = quadro_add_selected_posts( $mod_id, 'quadro_mod_pick_quoteposts', $args );
}

$quoteposts = new WP_Query( $args );
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-quoteposts clear <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>
	
	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">

		<div class="inner-mod">

			<ul class="quadro-quotes slides">
				
				<?php if( $quoteposts->have_posts() ) : while( $quoteposts->have_posts() ) : $quoteposts->the_post(); ?>
					
					<li>
						<div class="quote-post" style="color: <?php echo $text_color; ?>">
							
							<?php // We bring over the Posted On function to apply color to links
							$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
							if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
								$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';

							$time_string = sprintf( $time_string,
								esc_attr( get_the_date( 'c' ) ),
								esc_html( get_the_date() ),
								esc_attr( get_the_modified_date( 'c' ) ),
								esc_html( get_the_modified_date() )
							);

							printf( '<span class="posted-on">' . esc_html__( '%1$s', 'quadro' ) . '</span>',
								sprintf( '<a href="%1$s" title="%2$s" style="color: ' . $text_color . '" rel="bookmark">%3$s</a>',
									esc_url( get_permalink() ),
									esc_attr( get_the_time() ),
									$time_string
								)
							);
							?>

							<div class="quote-quote">
								<?php echo quadro_just_quote(get_the_content(), '', ''); ?>
							</div>
						</div>
					</li>

				<?php endwhile; endif; // ends quote posts loop ?>
				<?php wp_reset_postdata(); ?>

			</ul>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>

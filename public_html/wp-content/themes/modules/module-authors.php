<?php
/**
 * The template used for displaying Authors Modules content
 *
 */
?>

<?php
$mod_id = get_the_ID();

// Get Authors Module Data
$header_layout 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
$overlay			= esc_attr( get_post_meta( $mod_id, 'quadro_mod_overlay', true ) );
$authors_bio 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_authors_bio', true ) );
$authors_extras		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_authors_extras', true ) );
$picker_method 		= esc_attr( get_post_meta( $mod_id, 'quadro_mod_authors_method', true ) );

// Let's prepare the arguments
$args = array(
	'fields' => array( 'display_name', 'user_email', 'ID' ),
	'who' => 'authors'
);

// Modify query depending on the selected Show Method
if ( $picker_method == 'custom' ) {
	// Bring picked authors if there are some
	$picked_authors = esc_attr( get_post_meta( $mod_id, 'quadro_mod_pick_authors', true ) );
	// Make array for multiple later use
	global $author_array;
	$author_array = explode( ', ', rtrim($picked_authors, ', ') );
	$args['include'] = $author_array;
}

$authors = get_users( $args );

// Order retrieved Authors if hand picked
if ( $picker_method == 'custom' ) {
	function cmp($a, $b) {
	   global $author_array;

	   $pos1 = array_search( $a->ID, $author_array );
	   $pos2 = array_search( $b->ID, $author_array );

	   if ( $pos1 == $pos2 )
	       return 0;
	   else
	      return ( $pos1 < $pos2 ? -1 : 1 );
	}

	usort( $authors, 'cmp' );
}
?>

<section id="post-<?php the_ID(); ?>" class="quadro-mod type-authors clear <?php quadro_mod_parallax($mod_id); ?> modheader-<?php echo $header_layout; ?> overlay-<?php echo $overlay; ?>">

	<?php // Apply function for inline styles
	quadro_mod_styles( $mod_id ); ?>

	<div class="dark-overlay"></div>

	<?php quadro_mod_title( $mod_id ); ?>

	<div class="mod-content">
	
		<div class="inner-mod">

			<ul class="authors-list">
				<?php if ( is_array($authors) ) : foreach ( $authors as $author ) : ?>

					<li>

						<?php // Bring cover img for author
						$cover_img = qi_image_by_url( esc_url( get_the_author_meta( 'cover_img', $author->ID ) ), 'quadro-med-thumb' );
						$style = $cover_img != '' ? 'style="background-image: url(' . $cover_img . ');"' : '';
						?>

						<div class="author-cover" <?php echo $style; ?>></div>
						
						<?php $author_link = get_author_posts_url( $author->ID ); ?>

						<div class="author-name">
							<?php if ( get_avatar( $author->user_email ) ) {
								echo '<a href="' . esc_url( $author_link ) . '" title="' . esc_html__('Posts by ', 'quadro') . $author->display_name . '">';
								echo get_avatar( $author->user_email, $size='120', '', $author->display_name ) . '</a>'; 
							} ?>
							<h3>
								<a href="<?php echo esc_url( $author_link ); ?>" title="<?php echo esc_html__('Posts by ', 'quadro') . $author->display_name; ?>">
									<?php echo $author->display_name; ?>
								</a>
							</h3>
						</div>
						
						<?php if ( $authors_bio == 'show' ) {
							echo '<div class="author-bio">' . get_the_author_meta( 'description', $author->ID ) . '</div>';
						} ?>
					
						<?php if ( $authors_extras == 'show' ) { ?>
							<div class="author-extras">
								<?php
								$user_url = esc_url( get_the_author_meta( 'user_url', $author->ID ) );
								if ( $user_url != '' )
									echo '<a class="author-web" href="' . $user_url . '" title="' . $user_url . '"><i class="fa fa-link"></i></a>';
								// Now get methods defined at Theme Options >> Social Tab
				 				global $quadro_options;
				 				if ( is_array( $quadro_options['available_contact_methods'] ) ) {
				 					foreach ( $quadro_options['available_contact_methods'] as $method ) {
										$contact = esc_url( get_the_author_meta( $method['slug'], $author->ID ) );
										if ( $contact != '' )
											echo '<a class="author-' . $method['slug'] . '" href="' . $contact . '" title="' . esc_html__('Follow', 'quadro') . ' ' . $author->display_name . ' ' . esc_html__('on', 'quadro') . ' ' . $method['title'] . '"><i class="fa fa-' . $method['slug'] . '"></i></a>';
				 					}
				 				} ?>
							</div>
						<?php } ?>

					</li>

				<?php endforeach; endif; // ends 'authors' loop ?>
			</ul>

		</div><!-- .inner-mod -->

	</div><!-- .mod-content -->

</section>

<?php
/**
 * @package quadro
 */
?>

<?php
$post_id = get_the_id();
// Get header type
$header_back 		= esc_attr( get_post_meta( $post_id, 'quadro_post_header_back', true ) );
$header_text_color	= esc_attr( get_post_meta( $post_id, 'quadro_post_header_text_color', true ) );
$header_overlay		= esc_attr( get_post_meta( $post_id, 'quadro_post_header_overlay', true ) );
$header_text_color 	= $header_text_color == '' ? 'auto' : $header_text_color;
$has_thumb			= has_post_thumbnail( $post_id ) ? 'has-feat-img' : 'hasnt-feat-img';

// Bring Feat. Image or Solid Color as background
if ( $header_back == 'color' ) {
	$header_back_color 	= esc_attr( get_post_meta( $post_id, 'quadro_post_header_back_color', true ) );
	$style = 'style="background-color: ' . $header_back_color . ';"';
}
else {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'quadro-full-thumb' );
	$style = 'style="background-image: url(\'' . $image[0] . '\');"';
}
?>

<?php // Enabling the "more tag"
global $more;
$more = 0;
?>

<article id="post-<?php the_ID(); ?>" data-original="<?php echo $image[0]; ?>" <?php post_class('lazy blog-item post-title-' . $header_text_color . ' overlay-' . $header_overlay . ' ' . $has_thumb . ' header-' . $header_back); ?> <?php echo $style; ?>>

	<div class="dark-overlay"></div>

	<div class="entry-inner">

		<header class="entry-header">

			<?php quadro_posted_on(); ?>

			<?php /* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( ', ' );
			if ( $category_list != '' ) {
				if ( quadro_categorized_blog() ) {
					$cats_text = '<p class="cat-links">' . esc_html__( 'In %1$s', 'quadro' ) . '</p>';
				} // end check for categories on this blog 
				printf( $cats_text, $category_list );
			} ?>
			
			<?php qi_before_post_title(); ?>

			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>

			<?php qi_after_post_title(); ?>

			<?php quadro_posted_by_gravatar( $post->post_author, 60 ); ?>

		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php echo quadro_excerpt(get_the_excerpt(), 30, '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>'); ?>
		</div><!-- .entry-summary -->

		<footer class="entry-footer">
			
			<?php edit_post_link( '<i class="fa fa-pencil"></i>', '<span class="edit-link">', '</span>' ); ?>

		</footer><!-- .entry-footer -->

	</div><!-- .entry-inner -->

</article><!-- #post-## -->
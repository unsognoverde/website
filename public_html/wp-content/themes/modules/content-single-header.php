<?php
/**
 * Template for displaying single post header.
 *
 */
?>

<?php
$post_id = get_the_id();
// Get header type
$header_size 		= esc_attr( get_post_meta( $post_id, 'quadro_post_header_size', true ) );
$header_back 		= esc_attr( get_post_meta( $post_id, 'quadro_post_header_back', true ) );
$header_text_color	= esc_attr( get_post_meta( $post_id, 'quadro_post_header_text_color', true ) );
$header_overlay		= esc_attr( get_post_meta( $post_id, 'quadro_post_header_overlay', true ) );
$header_text_color 	= $header_text_color == '' ? 'auto' : $header_text_color;
$header_size 		= $header_size == '' ? 'regular' : $header_size;
$has_thumb			= has_post_thumbnail( $post_id ) ? 'has-feat-img' : 'hasnt-feat-img';

// Bring Feat. Image or Solid Color as background
if ( is_attachment() ) {
	$image[0] = '';
	$style = '';
}
else if ( $header_back == 'color' ) {
	$header_back_color 	= esc_attr( get_post_meta( $post_id, 'quadro_post_header_back_color', true ) );
	$style = 'style="background-color: ' . $header_back_color . ';"';
}
else {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
	$style = 'style="background-image: url(\'' . $image[0] . '\');"';
}
?>

<header class="entry-header clear post-<?php echo $header_size; ?>-header post-title-<?php echo $header_text_color; ?> overlay-<?php echo $header_overlay; ?> header-<?php echo $header_back; ?> <?php echo $has_thumb; ?>" <?php echo $style; ?> data-original="<?php echo $image[0]; ?>">

	<div class="dark-overlay"></div>

	<div class="entry-inner">

		<div class="entry-meta">
			<?php quadro_posted_on(); ?>

			<?php /* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( ', ' );
			if ( $category_list != '' ) {
				if ( quadro_categorized_blog() ) {
					$cats_text = '<p class="cat-links">' . esc_html__( 'In %1$s', 'quadro' ) . '</p>';
				} // end check for categories on this blog 
				printf( $cats_text, $category_list );
			} ?>

			<?php if ( ! post_password_required() && ( comments_open() && '0' != get_comments_number() ) ) : ?>
	        	<span class="comments-link"><?php comments_popup_link( esc_html__( 'Comment', 'quadro' ), esc_html__( '1', 'quadro' ), esc_html__( '%', 'quadro' ) ); ?></span>
	        <?php endif; ?>
		</div>
		
		<?php qi_before_post_title(); ?>

		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php qi_after_post_title(); ?>

		<?php quadro_posted_by_gravatar( $post->post_author, 60 ); ?>

	</div>

</header><!-- .entry-header -->
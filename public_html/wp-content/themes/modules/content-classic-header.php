<?php
/**
 * Template for displaying single post header.
 *
 */
?>

<?php
$post_id = get_the_id();

// Get header data
$header_back 	= esc_attr( get_post_meta( $post_id, 'quadro_post_header_back', true ) );
$style			= '';

// Bring Feat. Image if selected as background
if ( has_post_thumbnail() && $header_back != 'color' ) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'quadro-full-thumb' );
	$style = 'style="background-image: url(\'' . $image[0] . '\');"';
}
?>

<header class="entry-header clear">

	<?php if ( has_post_thumbnail() && $header_back != 'color' ) { ?>
	<div class="entry-thumbnail" <?php echo $style; ?>></div>
	<?php } ?>

	<div class="entry-inner">

		<?php quadro_posted_on(); ?>

		<?php /* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( esc_html__( ', ', 'quadro' ) );
		if ( $category_list != '' ) {
			if ( quadro_categorized_blog() ) {
				$cats_text = '<p class="cat-links">' . __( 'In %1$s', 'quadro' ) . '</p>';
			} // end check for categories on this blog 
			printf( $cats_text, $category_list );
		} ?>
		
		<?php qi_before_post_title(); ?>

		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>

		<?php qi_after_post_title(); ?>

		<?php quadro_posted_by_gravatar( $post->post_author, 60 ); ?>

	</div>

</header><!-- .entry-header -->